<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
	/**
	 * The URIs that should be excluded from CSRF verification.
	 *
	 * @var array
	 */
	protected $except = [
		'tpv.*'
	];

	/**
	 * Determine if the request has a URI that should pass through CSRF verification.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return bool
	 */
	protected function shouldPassThrough($request)
	{
		foreach ($this->except as $except) {
			if (Str::is($except, $request->url())) {
				// break out of CSRF check
				return true;
			}
		}

		return false;
	}
}
