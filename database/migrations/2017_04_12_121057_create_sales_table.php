<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sale_id')->unsigned()->nullable();
            $table->integer('cash_id')->unsigned();
            $table->float('total')->nullable();
            $table->float('paid_amount')->nullable();
            $table->tinyInteger('parked')->unsigned()->nullable();
            $table->tinyInteger('paid')->unsigned()->nullable();
            $table->tinyInteger('payment_method')->unsigned()->nullable();
            $table->integer('number')->unsigned();
            $table->timestamps();
            $table->foreign('sale_id')->references('id')->on('sales');
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
        Schema::dropIfExists('sales');
    }
}
