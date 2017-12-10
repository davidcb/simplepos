<?php

namespace App\Observers;

use App\Models\Sale;
use DB;

class SaleObserver
{
	/**
	 * Listen to the Sale deleting event.
	 *
	 * @param  Sale  $sale)
	 * @return void
	 */
	public function deleting(Sale $sale)
	{
		DB::table('sale_products')->where('sale_id', $sale->id)->delete();
	}
}
