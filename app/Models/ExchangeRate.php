<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
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
        'date', 'base_currency_id', 'dest_currency_id', 'exchange_rate'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'exchange_rate' => 'float'
    ];

    /**
     * Get base currency
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function baseCurrency()
    {
        return $this->belongsTo(Currency::class, 'base_currency_id');
    }

    /**
     * Get dest currency
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function destCurrency()
    {
        return $this->belongsTo(Currency::class, 'dest_currency_id');
    }

    /**
     * Scope a query to only include exchange rates of a given base currency id.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $currencyId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBaseCurrency($query, $currencyId)
    {
        return $query->where('base_currency_id', $currencyId);
    }

    /**
     * Scope a query to only include exchange rates of a given dest currency id.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $currencyId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDestCurrency($query, $currencyId)
    {
        return $query->where('dest_currency_id', $currencyId);
    }

    /**
     * Scope a query to sort descending by date (newest first).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNewest($query)
    {
        return $query->orderByDesc('date');
    }

    /**
     * Scope a query to include only exchange rates of given base currency id, dest currency id
     * and also sort descending by date (newest first).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $baseCurrencyId
     * @param int $destCurrencyId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNewestRate($query, $baseCurrencyId, $destCurrencyId)
    {
        return $query->baseCurrency($baseCurrencyId)->destCurrency($destCurrencyId)->newest();
    }
}
