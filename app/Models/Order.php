<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
		'order_number', 'order_date', 'mark',
	];

	public function products() {
		return $this->belongsToMany(Product::class, 'order_products', 'order_id', 'product_id')->withPivot('amount');
	}

	public function provider() {
		return $this->belongsTo(Provider::class);
	}

	public function orderDateReadable() {
		$date = \DateTime::createFromFormat('Y-m-d', $this->order_date);
		if ($date) {
			return $date->format('d/m/Y');
		} else {
			return null;
		}
	}
}
