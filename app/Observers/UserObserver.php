<?php

namespace App\Observers;

use App\Models\Salesman;
use App\Models\User;

class UserObserver
{
	/**
	 * Listen to the User deleting event.
	 *
	 * @param  User  $user
	 * @return void
	 */
	public function deleting(User $user)
	{
		$salesman = Salesman::where('user_id', $user->id);
		$salesman->user_id = null;
		$salesman->save();
	}
}
