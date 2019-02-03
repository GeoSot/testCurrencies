<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateCurrenciesTable extends Migration
{
    protected $table = 'currencies';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->unsignedInteger('code')->unique()->index();
            $table->string('code_text', 10)->unique()->index();
            $table->string('name')->unique()->index();
            $table->string('symbol');          
            $table->float('subunit');
            $table->string('decimal_mark', 25);
            $table->string('thousands_separator', 25);
            $table->boolean('active')->default(true);
            $table->timestamps();
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
