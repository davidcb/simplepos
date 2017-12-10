<?php

namespace App\Http\Controllers;

use Alert;
use Auth;
use App\Models\Estate;
use App\Models\Sale;
use App\Models\Salesman;
use App\Http\Requests\SaleFormRequest;
use App\Services\Pagination;
use DB;
use PDF;
use Request;
use Session;

class SaleController extends Controller {

	private $menuActive = null;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->menuActive = 'sales';
	}

	public function index()
	{
		if (Request::get('orderby') && Request::get('sort')) {
			$sales = Sale::where('paid', 1)->orderBy(Request::get('orderby'), Request::get('sort'))->get();
		} else {
			$sales = Sale::where('paid', 1)->orderBy('id', 'DESC')->get();
		}

		$sales = betweenFilter($sales, 'total', Request::get('filter_min_total'), Request::get('filter_max_total'));
		$sales = valueFilter($sales, 'payment_method', Request::get('filter_payment_method'));
		$sales = betweenFilter($sales, 'updated_at', Request::get('filter_min_updated_at'), Request::get('filter_max_updated_at'));

		$pagination = new Pagination($sales, $perPage = 20, Request::except('page'));
		$sales = $pagination->results();

		return view('sale.index', ['sales' => $sales, 'menuActive' => $this->menuActive, 'pagination' => $pagination]);
	}

	public function export($id)
	{
		$sale = Sale::find($id);
		return PDF::loadView('tpv.print', ['sale' => $sale])->download('ticket_' . $sale->number() . '.pdf');
	}

	/*public function add()
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

	public function delete($id)
	{
		Order::destroy($id);
		Alert::success('Pedido eliminado correctamente');
		return redirect()->back();
	}

	public function deleteMultiple()
	{
		Order::destroy(Request::input('selected'));
		Alert::success('Pedidos eliminados correctamente');
		return redirect()->back();
	}*/

}
