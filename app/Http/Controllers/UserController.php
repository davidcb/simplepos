<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Models\Estate;
use App\Models\User;
use App\Services\Pagination;
use Hash;
use Request;
use Session;
use Alert;

class UserController extends Controller {

	private $menuActive = null;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->menuActive = 'users';
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Request::get('orderby') && Request::get('sort')) {
			$users = User::orderBy(Request::get('orderby'), Request::get('sort'))->get();
		} else {
			$users = User::get();
		}

		$users = textFilter($users, 'name', Request::get('filter_name'));
		$users = textFilter($users, 'email', Request::get('filter_email'));
		$users = valueFilter($users, 'role', Request::get('filter_role'));

		$pagination = new Pagination($users, $perPage = 20, ['term' => Request::get('term'), 'orderby' => Request::get('orderby')]);
		$users = $pagination->results();

		return view('user.index', ['users' => $users, 'menuActive' => $this->menuActive, 'pagination' => $pagination]);
	}

	/**
	 * Show the user add form.
	 *
	 * @return Response
	 */
	public function add()
	{
		return view('user.add', ['menuActive' => $this->menuActive]);
	}

	/**
	 * Show the user edit form.
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);

		return view('user.edit', ['user' => $user, 'menuActive' => $this->menuActive]);
	}

	/**
	 * Saves a user.
	 *
	 * @return Response
	 */
	public function save(UserFormRequest $request)
	{
		$user = new User;

		$user->name = $request->name;
		$user->email = $request->email;
		$user->password = Hash::make($request->password);
		$user->role = $request->role;
		$user->save();

		Alert::success('Usuario guardado correctamente');
		return redirect('/usuarios');
	}

	/**
	 * Updates a user.
	 *
	 * @return Response
	 */
	public function update(UserFormRequest $request)
	{
		$user = User::find(Request::input('id'));

		$user->name = $request->name;
		$user->email = $request->email;
		if (Request::input('password')) {
			$user->password = Hash::make($request->password);
		}
		$user->role = $request->role;
		$user->save();

		Alert::success('Usuario guardado correctamente');
		return redirect('/usuarios');
	}

	/**
	 * Deletes a user.
	 *
	 * @return Response
	 */
	public function delete($id)
	{
		User::destroy($id);
		Alert::success('Usuario eliminado correctamente');
		return redirect()->back();
	}

	/**
	 * Deletes multiple users.
	 *
	 * @return Response
	 */
	public function deleteMultiple()
	{
		User::destroy(Request::input('selected'));
		Alert::success('Usuarios eliminados correctamente');
		return redirect()->back();
	}

}
