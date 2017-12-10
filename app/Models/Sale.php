<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
	protected $fillable = ['total', 'parked', 'paid', 'payment_method', 'paid_amount', 'number'];

	public function sale()
	{
		return $this->belongsTo(Sale::class);
	}

	public function cash()
	{
		return $this->belongsTo(Cash::class);
	}

	public function products()
	{
		return $this->belongsToMany(Product::class, 'sale_products', 'sale_id', 'product_id')->withPivot('unit_price')->withPivot('amount')->withPivot('discount');
	}

	public function paymentMethodReadable()
	{
		switch ($this->payment_method) {
			case 1:
				$method = 'Efectivo';
				break;
			case 2:
				$method = 'Tarjeta';
				break;
			default:
				$method = '';
				break;
		}

		return $method;
	}

	public function createdAtReadable($format = 'd/m/Y')
	{
		$date = \DateTime::createFromFormat('Y-m-d H:i:s', $this->created_at);
		if ($date) {
			return $date->format($format);
		} else {
			return null;
		}
	}

	public function updatedAtReadable($format = 'd/m/Y')
	{
		$date = \DateTime::createFromFormat('Y-m-d H:i:s', $this->updated_at);
		if ($date) {
			return $date->format($format);
		} else {
			return null;
		}
	}

	public function number()
	{
		return 'SC-' . $this->number;
	}

	public function change($formatted = false)
	{
		$change = $this->paid_amount - $this->total;
		if ($formatted) {
			$change = number_format($change, 2, ',', '.');
		}
		return $change;
	}
}
