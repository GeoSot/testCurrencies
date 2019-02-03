<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableExchange extends Model
{
    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['currency_from_code', 'currency_to_code'];

    /*
     *
     * - - -  R E L A T I O N S H I P S  - - -
     *
     */

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currencyFrom()
    {
        return $this->belongsTo(Currency::class, 'code', 'currency_from_code');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currencyTo()
    {
        return $this->belongsTo(Currency::class, 'currency_to_code', 'code');
    }



    /*
    *
    * - - -  M E T H O D S  - - -
    *
    */



}
