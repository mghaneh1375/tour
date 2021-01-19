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
            $table->integer('passengerCount');
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
