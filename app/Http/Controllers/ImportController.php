<?php

namespace App\Http\Controllers;

use Alert;
use Auth;
use App\Models;
use DB;
use Request;
use Session;
use Storage;

class ImportController extends Controller {

	private $menuActive = null;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->menuActive = 'import';
	}

    /**
	 * Show the list of available imports.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('import.index', ['menuActive' => $this->menuActive]);
	}

    /**
	 * Show the import form to the user.
	 *
	 * @return Response
	 */
	public function import($module)
	{
		return view('import.form', ['menuActive' => $this->menuActive]);
	}

	/**
	 * Imports from an excel file.
	 *
	 * @return Response
	 */
	public function processImport($module)
	{

		if (Auth::user()->role == 1) {
			return redirect()->back();
		}

		if (Request::hasFile('file') && Request::file('file')->isValid()) {
			$uploadedFile = Request::file('file');

			$extension = $uploadedFile->getClientOriginalExtension();

			$filename = str_random(20) . '.' . $extension;

			Storage::put(
				'csv/' . $filename,
				file_get_contents($uploadedFile->getRealPath())
			);
		} else {
			Alert::error('Error al subir el archivo');
			return redirect()->back();
		}

		$fp = fopen(storage_path('app/csv/') . $filename, 'r');
		$i = 0;

        switch ($module) {
            case 'pedidos':
                while (($line = fgetcsv($fp, 1000, ';')) !== false) {
					if ($i++ == 0) {
						continue;
					}
                    $order = new Models\Order;
                    $order->id = $line[0];
                    $order->order_number = $line[1];
                    $date = str_replace('/', '-', $line[2]);
            		$order->order_date = date('Y-m-d', strtotime($date));
                    // todo: el proveedor hay que buscarlo en la BD. Importar primero los proveedores.
                    $order->provider_id = $line[3];
                    $order->mark = $line[4];
                    $order->save();
                }
                break;
            case 'productos':
                while (($line = fgetcsv($fp, 1000, ';')) !== false) {
					if ($i++ == 0) {
						continue;
					}
                    $product = new Models\Product;
                    $product->id = $line[0];
                    $product->ean = $line[1];
                    $product->name = $line[3];
                    $product->price = $line[5];
                    $product->active = 1;
                    // todo: el proveedor hay que buscarlo en la BD. Importar primero los proveedores.
                    //$product->provider_id = $line[9];
                    $product->save();
                }
                break;
            case 'proveedores':
                while (($line = fgetcsv($fp, 1000, ';')) !== false) {
					if ($i++ == 0) {
						continue;
					}
                    $provider = new Models\Provider;
                    $provider->id = $line[0];
                    $provider->name = $line[2];
                    $provider->business_name = $line[3];
                    $provider->cif = $line[4];
                    $provider->address = $line[5];
                    $provider->zipcode = $line[6];
                    $provider->city = $line[7];
                    $provider->province = $line[8];
                    $provider->telephone = $line[9];
                    $provider->telephone2 = $line[10];
                    $provider->fax = $line[11];
                    $provider->email = $line[12];
                    $provider->iban = $line[13];
                    $provider->contact = $line[14];
                    $provider->save();
                }
                break;
        }

		Alert::success('Importación realizada correctamente');

		return redirect('/importar');
	}
}
