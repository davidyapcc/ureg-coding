<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    protected $fillable = [
        'code',
        'name',
    ];

    /**
     * Get the rates where this currency is the base currency.
     */
    public function baseRates(): HasMany
    {
        return $this->hasMany(Rate::class, 'base_currency_id');
    }

    /**
     * Get the rates where this currency is the target currency.
     */
    public function targetRates(): HasMany
    {
        return $this->hasMany(Rate::class, 'target_currency_id');
    }
}
