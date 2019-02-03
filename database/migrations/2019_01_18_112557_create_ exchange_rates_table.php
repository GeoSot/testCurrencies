<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateExchangeRatesTable extends Migration
{
    protected $table = 'exchange_rates';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            //--Foreign Keys
            $table->unsignedInteger('base_currency_code');
            $table->unsignedInteger('exchange_currency_code');

            $table->float('ratio')->nullable();
            $table->timestamps();

            //--Foreign Keys Rules
            $table->foreign('base_currency_code')->references('code')->on('currencies')->onDelete('cascade');
            $table->foreign('exchange_currency_code')->references('code')->on('currencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
