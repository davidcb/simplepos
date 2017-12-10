<?php

namespace App\Observers;

use App\Models\Product;
use DB;

class ProductObserver
{
	/**
	 * Listen to the Product deleting event.
	 *
	 * @param  Product  $product
	 * @return void
	 */
	public function deleting(Product $product)
	{
		DB::table('warehouse_products')->where('product_id', $product->id)->delete();
	}
}
