<?php

namespace App\Http\Controllers;

use Alert;
use Auth;
use App\Models;
use App\Models\Image;
use App\Models\Provider;
use App\Models\Product;
use App\Http\Requests\ProductFormRequest;
use App\Services\Pagination;
use DB;
use Request;
use Session;

class ProductController extends Controller {

	private $menuActive = null;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->menuActive = 'products';
	}

	public function index()
	{
		if (Request::get('orderby') && Request::get('sort')) {
			$products = Product::orderBy(Request::get('orderby'), Request::get('sort'))->get();
		} else {
			$products = Product::ordered()->get();
		}

		$products = textFilter($products, 'name', Request::get('filter_name'));
		$products = yesNoFilter($products, 'active', Request::get('filter_active'));
		$products = betweenFilter($products, 'price', Request::get('filter_min_price'), Request::get('filter_max_price'));
		$products = betweenFilter($products, 'origin_price', Request::get('filter_min_origin_price'), Request::get('filter_max_origin_price'));
		$products = betweenFilter($products, 'customs_price', Request::get('filter_min_customs_price'), Request::get('filter_max_customs_price'));
		$products = betweenFilter($products, 'hotel_price', Request::get('filter_min_hotel_price'), Request::get('filter_max_hotel_price'));

		$pagination = new Pagination($products, $perPage = 20, Request::except('page'));
		$products = $pagination->results();

		return view('product.index', ['products' => $products, 'menuActive' => $this->menuActive, 'pagination' => $pagination]);
	}

	public function add()
	{
		$providers = Provider::get();
		return view('product.add', ['providers' => $providers, 'menuActive' => $this->menuActive]);
	}

	public function edit($id)
	{
		$providers = Provider::get();
		$product = Product::find($id);

		return view('product.edit', ['providers' => $providers, 'product' => $product, 'menuActive' => $this->menuActive]);
	}

	/**
	 * Saves a product.
	 *
	 * @return Response
	 */
	public function save(ProductFormRequest $request)
	{
		$product = new Product;

		$product->name = $request->name;
		$product->name_en = $request->name_en;
		$product->codtpv = $request->codtpv;
		$product->codairport = $request->codairport;
		$product->price = $request->price;
		$product->origin_price = $request->origin_price;
		$product->customs_price = $request->customs_price;
		$product->hotel_price = $request->hotel_price;
		$product->tax = $request->tax;
		$product->color = $request->color;

		if ($request->provider) {
			$product->provider_id = $request->provider;
		} else {
			$product->provider_id = null;
		}

		$product->save();

		if (sizeof($request->images)) {
			$n = 0;
			foreach ($request->images as $i) {
				$image = new Image;
				$image->url = $i;
				$image->orderby = ++$n;
				$product->images()->save($image);
			}
		}

		Alert::success('Producto guardado correctamente');

		return redirect('/productos');
	}

	/**
	 * Updates a product.
	 *
	 * @return Response
	 */
	public function update(ProductFormRequest $request)
	{
		$product = Product::find($request->id);
		$product->name = $request->name;
		$product->name_en = $request->name_en;
		$product->codtpv = $request->codtpv;
		$product->codairport = $request->codairport;
		$product->price = $request->price;
		$product->origin_price = $request->origin_price;
		$product->customs_price = $request->customs_price;
		$product->hotel_price = $request->hotel_price;
		$product->tax = $request->tax;
		$product->color = $request->color;

		if ($request->provider) {
			$product->provider_id = $request->provider;
		} else {
			$product->provider_id = null;
		}

		$product->save();

		if (sizeof($request->images)) {
			foreach ($request->images as $i) {
				$image = new Image;
				$image->url = $i;
				$maxOrderBy = sizeof($product->images);
				$image->orderby = $maxOrderBy + 1;
				$product->images()->save($image);
			}
		}

		Alert::success('Producto guardado correctamente');

		return redirect('/productos');
	}

	/**
	 * Deletes a product.
	 *
	 * @return Response
	 */
	public function delete($id)
	{
		$sales = Models\Sale::where('product_id', $id)->count();
		$orders = Models\Order::where('product_id', $id)->count();
		if (!sizeof($orders) && !sizeof($sales)) {
			Product::destroy($id);
			Alert::success('Producto eliminado correctamente');
		} else {
			Alert::error('No se pudo eliminar el producto por estar asociado a algún pedido o venta');
		}
		return back();
	}

	/**
	 * Deletes multiple products.
	 *
	 * @return Response
	 */
 	public function deleteMultiple()
  	{
  		$notDeleted = [];
  		foreach (Request::input('selected') as $id) {
			$sales = Models\Sale::where('product_id', $id)->count();
			$orders = Models\Order::where('product_id', $id)->count();
  			if ($orders < 1 && $sales < 1) {
  				Product::destroy($id);
  			} else {
  				$notDeleted[] = $id;
  			}
  		}
  		if (sizeof($notDeleted)) {
  			echo json_encode($notDeleted);
  		} else {
  			echo json_encode('ok');
  		}
  	}

	/**
	 * Activates multiple products.
	 *
	 * @return Response
	 */
	public function activateMultiple()
	{
		$products = Product::where(Request::input('selected'))->get();
		foreach ($products as $product) {
			$product->active = 1;
			$product->save();
		}
		Alert::success('Productos activados correctamente');
		return redirect()->back();
	}

	/**
	 * Deactivates multiple products.
	 *
	 * @return Response
	 */
	public function deactivateMultiple()
	{
		$products = Product::where(Request::input('selected'))->get();
		foreach ($products as $product) {
			$product->active = null;
			$product->save();
		}
		Alert::success('Productos desactivados correctamente');
		return redirect()->back();
	}

	public function search() {
		if (Request::get('currentProduct')) {
			$currentProduct = Product::find(Request::get('currentProduct'));
			$products = Product::where('id', '<>', Request::get('currentProduct'))->get();
		} else {
			$products = Product::get();
		}

		$products = $products->filter(function($product) {
			if (
				preg_match('/(.*)' . Request::get('term') . '(.*)/i', $product->name) ||
				preg_match('/(.*)' . Request::get('term') . '(.*)/i', $product->reference)
			) {
				return true;
			} else {
				return false;
			}
		});

		$result = [];
		foreach ($products as $product) {
			$results[] = array('id' => $product->id, 'name' => $product->name, 'price' => $product->price);
		}
		$response = Request::get('callback') . '(' . json_encode($results) . ')';
		echo $response;
	}

	public function deleteRelated()
	{
		if (Request::get('sale_id') && Request::get('product_id')) {
			DB::table('sale_products')->where('product_id', Request::get('product_id'))->where('sale_id', Request::get('sale_id'))->delete();
		} elseif (Request::get('order_id') && Request::get('product_id')) {
			DB::table('order_products')->where('product_id', Request::get('product_id'))->where('order_id', Request::get('order_id'))->delete();
		}
		return back();
	}

	public function moveUp($id)
	{
		$product = Product::find($id);
		$product->moveOrderUp();
		Alert::success('Producto subido correctamente');
		return back();
	}

	public function moveDown($id)
	{
		$product = Product::find($id);
		$product->moveOrderDown();
		Alert::success('Producto bajado correctamente');
		return back();
	}

}
