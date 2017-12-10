<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashMovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_moves', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cash_id')->unsigned();
            $table->float('income')->unsigned()->nullable();
            $table->float('withdrawal')->unsigned()->nullable();
            $table->string('concept', 1000)->nullable();
            $table->timestamps();
            $table->foreign('cash_id')->references('id')->on('cash');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_moves');
    }
}
