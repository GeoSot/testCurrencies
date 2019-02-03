<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateAvailableExchangesTable extends Migration
{
    protected $table = 'available_exchanges';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            //--Foreign keys
            $table->unsignedInteger('currency_from_code');
            $table->unsignedInteger('currency_to_code');
            //--Foreign Rules
            $table->foreign('currency_from_code')->references('code')->on('currencies')->onDelete('cascade');
            $table->foreign('currency_to_code')->references('code')->on('currencies')->onDelete('cascade');
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
