<?php

namespace App\Http\Controllers\Tpv;

use App\Models\Cash;
use App\Models\CashMove;
use App\Models\Product;
use App\Models\Sale;
use Auth;
use DB;
use Illuminate\Http\Request as FormRequest;
use Request;
use Session;

class IndexController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$openCash = Cash::where('open', 1)->first();
		if (!$openCash) {
			return redirect()->route('tpv.abrir-caja');
		} else {
			$products = Product::ordered()->get();
			$sale = Session::get('sale');
			Session::forget('sale');
			return view('tpv.index', compact('products', 'sale'));
		}
	}

	public function sales()
	{
		if (Request::get('term')) {
			$sales = Sale::where('paid', 1)->get();
			for ($i = 0, $n = sizeof($sales); $i < $n; $i++) {
				if ($sales[$i]->number() != Request::get('term')) {
					$sales->forget($i);
				}
			}
			$sales = $sales->values();
		} else {
			$sales = Sale::where('paid', 1)->orderBy('id', 'DESC')->take(8)->get();
		}
		$returns = 0;
		$total = 0;
		foreach ($sales as $sale) {
			if ($sale->sale) {
				$returns += $sale->total;
			}
			$total += $sale->total;
		}
		return view('tpv.sales', compact('sales', 'returns', 'total'));
	}

	public function parked()
	{
		$sales = Sale::where('parked', 1)->orderBy('id', 'DESC')->take(8)->get();
		$returns = 0;
		$total = 0;
		foreach ($sales as $sale) {
			if ($sale->sale) {
				$returns += $sale->total;
			}
			$total += $sale->total;
		}
		return view('tpv.sales', compact('sales', 'returns', 'total'));
	}

	public function sale($id)
	{
		$sale = Sale::find($id);
		return view('tpv.sale', compact('sale'));
	}

	public function printSale($id)
	{
		$sale = Sale::find($id);
		return view('tpv.print', compact('sale'));
	}

	public function processMove(FormRequest $request)
	{
		$cashMove = new CashMove;
		$cashMove->cash_id = $request->cash;
		$cashMove->income = $request->income;
		$cashMove->withdrawal = $request->withdrawal;
		$cashMove->concept = $request->concept;
		$cashMove->save();
		return redirect()->back();
	}

	public function parkSale(FormRequest $request)
	{
		$visit = Visit::find(Session::get('visit'));

		$sale = new Sale;
		$sale->total = $request->total;
		$sale->parked = 1;
		$sale->save();

		for ($i = 0, $n = sizeof($request->products); $i < $n; $i++) {
			DB::table('sale_products')->insert(
				['product_id' => $request->products[$i][0], 'sale_id' => $sale->id, 'unit_price' => $request->products[$i][1], 'amount' => $request->products[$i][2], 'discount' => $request->products[$i][3]]
			);
		}
	}

	public function unparkSale($id)
	{
		$sale = Sale::find($id);
		$sale->parked = null;
		$sale->save();

		Session::put('sale', $sale);
	}

	public function saveSale(FormRequest $request)
	{
		if ($request->sale) {
			Sale::destroy($request->sale);
		}

		$number = DB::table('sales')->max('number') + 1;

		$sale = new Sale;
		$sale->cash_id = $this->openCash->id;
		$sale->total = $request->total;
		$sale->payment_method = $request->payment_method;
		$sale->paid_amount = $request->paid_amount;
		$sale->number = $number;
		$sale->paid = 1;
		$sale->save();

		for ($i = 0, $n = sizeof($request->products); $i < $n; $i++) {
			DB::table('sale_products')->insert(
				['product_id' => $request->products[$i][0], 'sale_id' => $sale->id, 'unit_price' => $request->products[$i][1], 'amount' => $request->products[$i][2], 'discount' => $request->products[$i][3]]
			);
		}

		echo $sale->id;
	}

	public function returnSale(FormRequest $request)
	{
		$parentSale = Sale::find($request->sale);
		$sale = new Sale;
		$sale->cash_id = $this->openCash->id;
		$sale->sale_id = $parentSale->id;
		$sale->total = $request->total * -1;
		$sale->payment_method = $parentSale->payment_method;
		$sale->paid = 1;
		$sale->save();

		for ($i = 0, $n = sizeof($request->products); $i < $n; $i++) {
			DB::table('sale_products')->insert(
				['product_id' => $request->products[$i][0], 'sale_id' => $sale->id, 'unit_price' => $request->products[$i][1], 'amount' => $request->products[$i][2] * -1, 'discount' => $request->products[$i][3]]
			);
		}
	}

	public function cancelSale($id = null)
	{
		if ($id) {
			Sale::destroy($id);
		}
	}

	public function searchProduct(FormRequest $request)
	{
		$product = Product::where('ean', $request->code)->first();

		if ($product) {
			echo $product->id;
		}
	}
}
