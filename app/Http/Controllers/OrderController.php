<?php

namespace App\Http\Controllers;

use Alert;
use Auth;
use App\Models\Order;
use App\Models\Provider;
use App\Http\Requests\OrderFormRequest;
use App\Services\Pagination;
use DB;
use Request;
use Session;

class OrderController extends Controller {

	private $menuActive = null;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->menuActive = 'orders';
	}

	public function index()
	{
		if (Request::get('orderby') && Request::get('sort')) {
			$orders = Order::orderBy(Request::get('orderby'), Request::get('sort'))->get();
		} else {
			$orders = Order::get();
		}

		$orders = textFilter($orders, 'order_number', Request::get('filter_order_number'));
		$orders = betweenFilter($orders, 'order_date', Request::get('filter_min_order_date'), Request::get('filter_max_order_date'));
		$orders = valueFilter($orders, 'provider_id', Request::get('filter_provider'));

		$pagination = new Pagination($orders, $perPage = 20, Request::except('page'));
		$orders = $pagination->results();

		$providers = Provider::orderBy('name', 'ASC')->get();

		return view('order.index', ['providers' => $providers, 'orders' => $orders, 'menuActive' => $this->menuActive, 'pagination' => $pagination]);
	}

	public function add()
	{
		$providers = Provider::orderBy('name', 'ASC')->get();
		return view('order.add', ['providers' => $providers, 'menuActive' => $this->menuActive]);
	}

	public function edit($id)
	{
		$order = Order::find($id);
		$providers = Provider::orderBy('name', 'ASC')->get();

		return view('order.edit', ['providers' => $providers, 'order' => $order, 'menuActive' => $this->menuActive]);
	}

	/**
	 * Saves a order.
	 *
	 * @return Response
	 */
	public function save(OrderFormRequest $request)
	{
		$order = new Order;

		$order->order_number = $request->order_number;
		$date = str_replace('/', '-', $request->order_date);
		$order->order_date = date('Y-m-d', strtotime($date));
		$order->provider_id = $request->provider;
		$order->mark = $request->mark;

		$order->save();

		for ($i = 0, $n = sizeof($request->products); $i < $n; $i++) {
			DB::table('order_products')->insert(
				['product_id' => $request->products[$i], 'order_id' => $order->id, 'amount' => $request->quantities[$i]]
			);
		}

		Alert::success('Pedido guardado correctamente');

		return redirect('/pedidos');
	}

	/**
	 * Updates a order.
	 *
	 * @return Response
	 */
	public function update(OrderFormRequest $request)
	{
		$order = Order::find($request->id);

		$order->order_number = $request->order_number;
		$date = str_replace('/', '-', $request->order_date);
		$order->order_date = date('Y-m-d', strtotime($date));
		$order->provider_id = $request->provider;
		$order->mark = $request->mark;

		$order->save();

		DB::table('order_products')->where('order_id', $order->id)->delete();
		for ($i = 0, $n = sizeof($request->products); $i < $n; $i++) {
			DB::table('order_products')->insert(
				['product_id' => $request->products[$i], 'order_id' => $order->id, 'amount' => $request->quantities[$i]]
			);
		}

		Alert::success('Pedido guardado correctamente');

		return redirect('/pedidos');
	}

	/**
	 * Deletes a order.
	 *
	 * @return Response
	 */
	public function delete($id)
	{
		Order::destroy($id);
		Alert::success('Pedido eliminado correctamente');
		return redirect()->back();
	}

	/**
	 * Deletes multiple orders.
	 *
	 * @return Response
	 */
	public function deleteMultiple()
	{
		Order::destroy(Request::input('selected'));
		Alert::success('Pedidos eliminados correctamente');
		return redirect()->back();
	}

	public function print($id)
	{
		$order = Order::find($id);

		return view('order.print', ['order' => $order, 'menuActive' => $this->menuActive]);
	}

}
