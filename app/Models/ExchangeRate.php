<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['base_currency_code', 'exchange_currency_code', 'ratio'];

    protected $casts = [
        'ratio' => 'float',
    ];

     /*
      *
      * - - -  R E L A T I O N S H I P S  - - -
      *
      */
    /**
     * Get the quoteCoin of of this Rate
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exchangeCurrency()
    {
        return $this->belongsTo(Currency::class, 'code', 'exchange_currency_code');
    }


    /**
     *  Get the Currency of this Rate
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function baseCurrency()
    {
        return $this->belongsTo(ExchangeRate::class, 'code', 'base_currency_code');
    }
}
