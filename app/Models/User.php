<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ErpResetPassword;
use App\Notifications\TpvResetPassword;
use Request;

class User extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'role',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
		$url_array = explode('.', parse_url(Request::url(), PHP_URL_HOST));
        $subdomain = $url_array[0];

		if ($subdomain == 'tpv') {
			$this->notify(new TpvResetPassword($token));
		} else {
			$this->notify(new ErpResetPassword($token));
		}
    }
}
