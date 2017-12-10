<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Product extends Model implements Sortable
{
	use SortableTrait;

	public $sortable = [
		'order_column_name' => 'orderby',
		'sort_when_creating' => true,
	];

	protected $fillable = [
		'name', 'name_en', 'codtpv', 'codairport', 'price', 'origin_price', 'customs_price', 'hotel_price', 'tax', 'active',
	];

	public function provider() {
		return $this->belongsTo(Provider::class);
	}

	public function sales() {
		return $this->belongsToMany(Sale::class, 'sale_products', 'product_id', 'sale_id');
	}
}
