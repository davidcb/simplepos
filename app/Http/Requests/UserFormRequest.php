<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
		if (preg_match('/[0-9]+/', $this->request->get('id'))) {
			return [
				'email' => 'required|email',
				'name' => 'required',
			];
		} else {
			return [
				'email' => 'required|email',
				'name' => 'required',
				'password' => 'required|confirmed',
			];
		}
	}

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'email.required' => 'La dirección de email es obligatoria',
			'email.email' => 'La dirección de email no es válida',
			'name.required' => 'El nombre es obligatorio',
			'password.required' => 'La contraseña es obligatoria',
			'password.confirmed' => 'La contraseña debe coincidir con su confirmación',
		];
	}
}
