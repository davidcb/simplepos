<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderFormRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return \Auth::check();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'order_number' => 'required',
			'order_date' => 'required',
			'provider' => 'required',
		];
	}

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'order_number.required' => 'El número del pedido es obligatorio',
			'order_date.required' => 'La fecha del pedido es obligatoria',
			'provider.required' => 'El proveedor es obligatorio',
		];
	}
}
