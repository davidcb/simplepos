<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
	protected $table = 'cash';

	protected $fillable = ['opening_amount', 'closing_amount', 'opening_according', 'closing_according', 'open', 'opening_notes', 'closing_notes', 'fund', 'envelope'];

	public function currentAmount()
	{
		$currentAmount = $this->opening_amount;

		$currentAmount += $this->cashAmount();

		foreach ($this->cashMoves as $move) {
			$currentAmount += $move->income;
			$currentAmount -= $move->withdrawal;
		}

		return $currentAmount;
	}

	public function cashAmount()
	{
		$currentAmount = 0;

		foreach ($this->sales as $sale) {
			if ($sale->payment_method == 1) {
				$currentAmount += $sale->total;
			}
		}

		return $currentAmount;
	}

	public function cardAmount()
	{
		$currentAmount = 0;

		foreach ($this->sales as $sale) {
			if ($sale->payment_method == 2) {
				$currentAmount += $sale->total;
			}
		}

		return $currentAmount;
	}

	public function totalAmount()
	{
		return $this->cashAmount() + $this->cardAmount();
	}

    public function cashMoves()
    {
        return $this->hasMany(CashMove::class);
    }

	public function sales()
	{
		return $this->hasMany(Sale::class);
	}

	public function updatedAtReadable($format = 'd/m/Y')
	{
		$date = \DateTime::createFromFormat('Y-m-d H:i:s', $this->updated_at);
		if ($date) {
			return $date->format($format);
		} else {
			return null;
		}
	}
}
