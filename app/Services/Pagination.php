<?php

namespace App\Services;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class Pagination
{

	protected $paginator;
	protected $currentPage;
	protected $perPage;
	protected $collection;

	/**
	 * Create paginator
	 *
	 * @param  Illuminate\Support\Collection  $collection
	 * @param  int     $total
	 * @param  int     $perPage
	 * @return string
	 */
	public function __construct($collection, $perPage, $appends = null) {

		$this->currentPage = Paginator::resolveCurrentPage();
		$total = sizeof($collection);

		$this->collection = $collection;
		$this->perPage = $perPage;

		$this->paginator = new LengthAwarePaginator(
			$collection, 
			$total, 
			$this->perPage, 
			$this->currentPage, 
			['path' => Paginator::resolveCurrentPath()]
		);

		if ($appends) {
			foreach ($appends as $key => $value) {
				$this->paginator->appends($key, $value);
			}
		}

		return $this;
		
	}

	public function render() {
		return str_replace('/?', '?', $this->paginator->render());
	}

	public function results() {
		$offset = ($this->currentPage - 1) * $this->perPage;
		return $this->collection->slice($offset, $this->perPage);
	}

	public function lastPage() {
		$total = sizeof($this->collection);
		$pages = ceil($total / $total);
		return $pages;
	}

}