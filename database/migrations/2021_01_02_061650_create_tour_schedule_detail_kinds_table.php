<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourScheduleDetailKindsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourScheduleDetailKinds', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('color', 15);
            $table->string('icon')->nullable();
            $table->tinyInteger('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tourScheduleDetailKinds');
    }
}
