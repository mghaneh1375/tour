<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourSchedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tourId');
            $table->tinyInteger('day');
            $table->unsignedBigInteger('hotelId')->default(0);
            $table->tinyInteger('isBoomgardi')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });

//        Schema::table('tourSchedules', function (Blueprint $table){
//            $table->foreign('tourId')->on('tour')->references('id')->onDelete('cascade');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tourSchedules');
    }
}
