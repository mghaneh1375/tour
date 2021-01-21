<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourUserReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourUserReservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('tourTimeId');
            $table->string('code');
            $table->integer('inCapacityCount')->default(0);
            $table->integer('noneCapacityCount')->default(0);
            $table->text('features');
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
        Schema::dropIfExists('tourUserReservations');
    }
}
