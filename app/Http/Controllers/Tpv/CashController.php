<?php

namespace App\Http\Controllers\Tpv;

use App\Models\Cash;
use Auth;
use Illuminate\Http\Request as FormRequest;
use Request;
use Session;

class CashController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

    public function openCash()
    {
        $openCash = Cash::where('open', 1)->first();
        if ($openCash) {
            return redirect()->route('tpv.home');
        } else {
            $lastCash = Cash::orderBy('id', 'DESC')->first();
            return view('tpv.cash.open', compact('lastCash'));
        }
    }

    public function processOpenCash(FormRequest $request)
    {
        $openCash = Cash::where('open', 1)->first();
        if ($openCash) {
            return redirect(route('tpv.home'));
        } else {
            $cash = new Cash;
            $cash->opening_amount = $request->opening_amount;
            $cash->opening_according = $request->according;
            $cash->open = 1;
            $cash->opening_notes = $request->notes;
            $cash->save();

            return redirect()->route('tpv.home');
        }
    }

    public function closeCash()
    {
        $cash = Cash::where('open', 1)->first();
        if (!$cash) {
            return redirect()->route('tpv.home');
        } else {
            return view('tpv.cash.close', compact('cash'));
        }
    }

    public function processCloseCash(FormRequest $request)
    {
        $openCash = Cash::where('open', 1)->first();
        if (!$openCash) {
            return redirect(route('tpv.home'));
        } else {
            $openCash->closing_amount = $request->closing_amount;
            $openCash->fund = $request->fund;
            $openCash->envelope = $request->envelope;
            $openCash->open = 0;
            $openCash->closing_notes = $request->notes;
            $openCash->save();

            echo $openCash->id;

            //return redirect()->route('tpv.home');
        }
    }

    public function printClose($id) {
        $cash = Cash::find($id);
        return view('tpv.cash.print', compact('cash'));
    }

}
