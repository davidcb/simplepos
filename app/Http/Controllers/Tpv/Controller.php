<?php

namespace App\Http\Controllers\Tpv;

use App\Models\Cash;
use App\Models\Sale;
use Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use View;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected $openCash;

	public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();

		    $openCash = Cash::where('open', 1)->first();
		    $parkedSales = Sale::where('parked', 1)->count();
		    View::share('openCash', $openCash);
		    View::share('parkedSales', $parkedSales);
			$this->openCash = $openCash;

            return $next($request);
        });

    }
}
