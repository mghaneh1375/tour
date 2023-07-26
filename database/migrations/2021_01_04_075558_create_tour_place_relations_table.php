<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourPlaceRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourPlaceRelations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tourId');
            $table->unsignedBigInteger('tourScheduleDetailId');
            $table->unsignedBigInteger('placeId');
            $table->unsignedBigInteger('kindPlaceId');
        });

        Schema::table('tourPlaceRelations', function (Blueprint $table){
           $table->foreign('tourScheduleDetailId')->on('tourScheduleDetails')->references('id')->onDelete('cascade');
//           $table->foreign('tourId')->on('tour1')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tourPlaceRelations');
    }
}
