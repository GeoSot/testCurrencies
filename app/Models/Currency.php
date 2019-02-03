<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'code', 'code_text', 'symbol', 'subunit', 'decimal_mark', 'thousands_separator', 'active'];
    protected $primaryKey = 'code';
    protected $casts = [
        'active' => 'boolean',
    ];
    protected $appends = [
        'available_exchanges'
    ];


    /*
     *
     * - - -  R E L A T I O N S H I P S  - - -
     *
     */

    /**
     * Get the AvailableExchange of this Currency
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function availableExchanges()
    {
        return $this->hasMany(AvailableExchange::class, 'currency_from_code');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function exchangeRatios()
    {
        return $this->hasMany(ExchangeRate::class, 'base_currency_code');
    }


    /*
   *
   * - - -  M E T H O D S  - - -
   *
   */
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return Builder
     */
    public function scopeActive(Builder $builder)
    {
        return $builder->where('active', true);
    }


    /**
     * AReturn The Data For The Select Boxes
     *
     * @param  array $extraFiels
     *
     * @return array
     */
    public function forSelectBox($extraFiels = [])
    {
        return $this->only(array_merge(['code', 'name', 'code_text'], $extraFiels));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function getAvailableExchangesAttribute()
    {
        return $this->availableExchanges()->get()->map(function (AvailableExchange $item) {
            return $item->currencyTo->forSelectBox();
        });
    }


    /**
     * @param Currency $exchangeToCoin
     * @param float    $amount
     *
     * @return float
     */
    public function getExchangeTo(Currency $exchangeToCoin, float $amount = 1)
    {
        $ratioObj = $this->exchangeRatios()->where('exchange_currency_code', $exchangeToCoin->getKey())->first();
        return $ratioObj->ratio * $amount;
    }

    /**
     * formats a value According to currency properties
     * @param float $amount
     *
     * @return string
     */
    public function getHumanFormatted(float $amount)
    {
        return number_format($amount, 2, $this->decimal_mark, $this->thousands_separator);
    }


}
