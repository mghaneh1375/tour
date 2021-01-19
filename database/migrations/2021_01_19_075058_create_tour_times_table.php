<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourTimes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('tourId');
            $table->string('code');
            $table->string('sDate', 20);
            $table->string('eDate', 20);
            $table->boolean('isPublished')->default(true);
            $table->integer('registered')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tourTimes');
    }
}
