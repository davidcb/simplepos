<?php

namespace App\Observers;

use App\Models\Order;
use DB;

class OrderObserver
{
	/**
	 * Listen to the Order deleting event.
	 *
	 * @param  Order  $order
	 * @return void
	 */
	public function deleting(Order $order)
	{
		DB::table('order_products')->where('order_id', $order->id)->delete();
	}
}
