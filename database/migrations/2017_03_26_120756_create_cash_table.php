<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash', function (Blueprint $table) {
            $table->increments('id');
            $table->float('opening_amount')->unsigned();
            $table->float('closing_amount')->unsigned()->nullable();
            $table->tinyInteger('opening_according')->unsigned()->nullable();
            $table->tinyInteger('closing_according')->unsigned()->nullable();
            $table->tinyInteger('open')->unsigned()->nullable();
            $table->string('opening_notes')->nullable();
            $table->string('closing_notes')->nullable();
            $table->float('fund')->unsigned()->nullable();
            $table->float('envelope')->unsigned()->nullable();
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
        Schema::dropIfExists('cash');
    }
}
