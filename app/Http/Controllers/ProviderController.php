<?php

namespace App\Http\Controllers;

use Alert;
use Auth;
use App\Models;
use App\Models\Provider;
use App\Http\Requests\ProviderFormRequest;
use App\Services\Pagination;
use DB;
use Request;
use Session;

class ProviderController extends Controller {

	private $menuActive = null;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->menuActive = 'providers';
	}

	public function index()
	{
		if (Request::get('orderby') && Request::get('sort')) {
			$providers = Provider::orderBy(Request::get('orderby'), Request::get('sort'))->get();
		} else {
			$providers = Provider::get();
		}

		$providers = textFilter($providers, 'name', Request::get('filter_name'));
		$providers = textFilter($providers, 'business_name', Request::get('filter_business_name'));
		$providers = textFilter($providers, 'cif', Request::get('filter_cif'));

		$pagination = new Pagination($providers, $perPage = 20, Request::except('page'));
		$providers = $pagination->results();

		return view('provider.index', ['providers' => $providers, 'menuActive' => $this->menuActive, 'pagination' => $pagination]);
	}

	public function add()
	{
		return view('provider.add', ['menuActive' => $this->menuActive]);
	}

	public function edit($id)
	{
		$provider = Provider::find($id);

		return view('provider.edit', ['provider' => $provider, 'menuActive' => $this->menuActive]);
	}

	/**
	 * Saves a provider.
	 *
	 * @return Response
	 */
	public function save(ProviderFormRequest $request)
	{
		$provider = new Provider;

		$provider->name = $request->name;
		$provider->business_name = $request->business_name;
		$provider->cif = $request->cif;
		$provider->address = $request->address;
		$provider->zipcode = $request->zipcode;
		$provider->city = $request->city;
		$provider->province = $request->province;
		$provider->telephone = $request->telephone;
		$provider->telephone2 = $request->telephone2;
		$provider->fax = $request->fax;
		$provider->email = $request->email;
		$provider->iban = $request->iban;
		$provider->contact = $request->contact;

		$provider->save();

		Alert::success('Proveedor guardado correctamente');

		return redirect('/proveedores');
	}

	/**
	 * Updates a provider.
	 *
	 * @return Response
	 */
	public function update(ProviderFormRequest $request)
	{
		$provider = Provider::find($request->id);
		$provider->name = $request->name;
		$provider->business_name = $request->business_name;
		$provider->cif = $request->cif;
		$provider->address = $request->address;
		$provider->zipcode = $request->zipcode;
		$provider->city = $request->city;
		$provider->province = $request->province;
		$provider->telephone = $request->telephone;
		$provider->telephone2 = $request->telephone2;
		$provider->fax = $request->fax;
		$provider->email = $request->email;
		$provider->iban = $request->iban;
		$provider->contact = $request->contact;

		$provider->save();

		Alert::success('Proveedor guardado correctamente');

		return redirect('/proveedores');
	}

	/**
	 * Deletes a provider.
	 *
	 * @return Response
	 */
	public function delete($id)
	{
		$orders = Models\Order::where('provider_id', $id)->count();
		$payments = Models\Payment::where('provider_id', $id)->count();
		$products = Models\Product::where('provider_id', $id)->count();
		$purchases = Models\Purchase::where('provider_id', $id)->count();
		if (!sizeof($orders) && !sizeof($payments) && !sizeof($products) && !sizeof($purchases)) {
			Provider::destroy($id);
			Alert::success('Proveedor eliminado correctamente');
		} else {
			Alert::error('No se pudo eliminar el proveedor por estar asociado a pedidos, pagos, productos o compras');
		}
		return back();
	}

	/**
	 * Deletes multiple providers.
	 *
	 * @return Response
	 */
 	public function deleteMultiple()
  	{
  		$notDeleted = [];
  		foreach (Request::input('selected') as $id) {
			$orders = Models\Order::where('provider_id', $id)->count();
			$payments = Models\Payment::where('provider_id', $id)->count();
			$products = Models\Product::where('provider_id', $id)->count();
			$purchases = Models\Purchase::where('provider_id', $id)->count();
  			if ($orders < 1 && $payments < 1 && $products < 1 && $purchases < 1) {
  				Provider::destroy($id);
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

}
