<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourPrices', function (Blueprint $table) {
            $table->id();
            $table->integer('ageFrom');
            $table->integer('ageTo');
            $table->integer('cost')->nullable();
            $table->boolean('inCapacity')->default(true);
            $table->boolean('isFree')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tourPrices');
    }
}
