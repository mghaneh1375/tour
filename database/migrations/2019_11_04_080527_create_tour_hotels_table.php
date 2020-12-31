<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourHotels', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tourId');
            $table->unsignedInteger('hotelId');
            $table->string('roomKind');
            $table->integer('cost');
            $table->string('sameGroup', 2);

            $table->foreign('tourId')->references('id')->on('tour')->onUpdate('cascade')->onDelete('Cascade');
            $table->foreign('hotelId')->references('id')->on('hotels')->onUpdate('cascade')->onDelete('Cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tourHotels');
    }
}
