<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashMove extends Model
{
    protected $fillable = ['income', 'withdrawal', 'concept'];

    public function cash()
    {
        return $this->belongsTo(Cash::class);
    }
}
