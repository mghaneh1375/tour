<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisementSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisementSizes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('pcSize', 20)->nullable();
            $table->string('mobileSize', 20)->nullable();
            $table->tinyInteger('isSame')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisementSizes');
    }
}
