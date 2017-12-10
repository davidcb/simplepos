<?php

namespace App\Http\Controllers;

use Alert;
use Auth;
use Illuminate\Support\Collection;
use PDF;
use Request;
use Session;

class ReportController extends Controller {

	private $menuActive = null;

	public function __construct()
	{
		$this->menuActive = 'reports';
	}

	public function index()
	{
		return view('report.index', ['menuActive' => $this->menuActive]);
	}

	public function salesmanCommision()
	{
		return view('report.select', ['menuActive' => $this->menuActive]);
	}

	public function salesmanCommisionExport()
	{
		$month = Request::input('month');
		$year = Request::input('year');
		$island = Request::input('island');
		$estates = Estate::where('island', $island)->get();
		$salesmans = islandSalesmans($island);
		$islandText = $this->islandText($island);

		//return view('report.print_salesman', ['salesmans' => $salesmans, 'estates' => $estates, 'islandText' => $islandText, 'month' => $month, 'year' => $year]);

		$pdf = PDF::loadView('report.print_salesman', ['salesmans' => $salesmans, 'estates' => $estates, 'islandText' => $islandText, 'month' => $month, 'year' => $year]);
		return $pdf->download('personal_' . str_slug($islandText) . '.pdf');

		//return view('report.salesman', ['estates' => $estates, 'salesmans' => $salesmans, 'month' => $month, 'year' => $year, 'menuActive' => $this->menuActive]);
	}

	public function guideCommision()
	{
		return view('report.select', ['menuActive' => $this->menuActive]);
	}

	public function guideCommisionExport()
	{
		$month = Request::input('month');
		$year = Request::input('year');
		$island = Request::input('island');
		$guides = islandGuides($island, $month, $year);
		$islandText = $this->islandText($island);

		//return view('report.print_guides', ['guides' => $guides, 'islandText' => $islandText, 'month' => $month, 'year' => $year, 'menuActive' => $this->menuActive]);

		$pdf = PDF::loadView('report.print_guides', ['guides' => $guides, 'islandText' => $islandText, 'month' => $month, 'year' => $year]);
		return $pdf->download('guias.pdf');

		//return view('report.guides', ['guides' => $guides, 'month' => $month, 'year' => $year, 'menuActive' => $this->menuActive]);
	}

	public function agencyCommision()
	{
		return view('report.select', ['partial' => true, 'menuActive' => $this->menuActive]);
	}

	public function agencyCommisionExport()
	{
		$month = Request::input('month');
		$year = Request::input('year');
		$island = Request::input('island');
		$estates = Estate::where('island', $island)->get();
		$partial = Request::input('partial');
		$islandText = $this->islandText($island);

		//return view('report.print_agencies', ['estates' => $estates, 'islandText' => $islandText, 'partial' => $partial, 'month' => $month, 'year' => $year, 'menuActive' => $this->menuActive]);

		$pdf = PDF::loadView('report.print_agencies', ['estates' => $estates, 'islandText' => $islandText, 'partial' => $partial, 'month' => $month, 'year' => $year]);
		return $pdf->download('agencias.pdf');

		//return view('report.agencies', ['estates' => $estates, 'partial' => $partial, 'month' => $month, 'year' => $year, 'menuActive' => $this->menuActive]);
	}

	public function agencyGuidesCommision()
	{
		$estates = Estate::get();
		$agencies = Agency::orderBy('name', 'ASC')->get();
		return view('report.select', ['menuActive' => $this->menuActive, 'agencies' => $agencies, 'estates' => $estates]);
	}

	public function agencyGuidesCommisionExport()
	{
		$month = Request::input('month');
		$year = Request::input('year');
		$estate = Estate::find(Request::input('estate'));
		$agency = Agency::find(Request::input('agency'));

		//return view('report.print_agency', ['agency' => $agency, 'estate' => $estate, 'month' => $month, 'year' => $year]);

		$pdf = PDF::loadView('report.print_agency', ['agency' => $agency, 'estate' => $estate, 'month' => $month, 'year' => $year]);
		return $pdf->download(str_slug($agency->name) . '.pdf');

		return view('report.agency', ['agency' => $agency, 'estate' => $estate, 'month' => $month, 'year' => $year, 'menuActive' => $this->menuActive]);
	}

	public function islandText($island) {
		switch ($island) {
			case 1:
				$islandText = 'Gran Canaria';
				break;
			case 2:
				$islandText = 'Fuerteventura';
				break;
			case 3:
				$islandText = 'La Gomera';
				break;
			default:
				$islandText = '';
				break;
		}
		return $islandText;
	}

}
