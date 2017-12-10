<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{

	private $menuActive = null;

	public function __construct()
	{
		$this->menuActive = 'home';
	}

	public function index()
	{
		return view('home', ['menuActive' => $this->menuActive]);
	}
}
