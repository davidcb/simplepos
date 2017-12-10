<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
	protected $fillable = [
		'name', 'business_name', 'cif', 'address', 'zipcode', 'city', 'province', 'telephone', 'telephone2', 'fax', 'email', 'iban', 'contact',
	];
}
