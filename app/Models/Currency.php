<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /**
     * Without created_at and updated_at columns
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code'
    ];

    /**
     * Get all exchange rates
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function exchangeRates()
    {
        return $this->hasMany(ExchangeRate::class, 'base_currency_id')
            ->orWhere('dest_currency_id', $this->id);
    }

    /**
     * Get exchange rates where currency is set as base
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function baseExchangeRates()
    {
        return $this->hasMany(ExchangeRate::class, 'base_currency_id');
    }

    /**
     * Get exchange rates where currency is set as dest
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function destExchangeRates()
    {
        return $this->hasMany(ExchangeRate::class, 'dest_currency_id');
    }

    /**
     * Scope a query to only include currency of a given code.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $code
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCode($query, $code)
    {
        return $query->where('code', $code);
    }
}
