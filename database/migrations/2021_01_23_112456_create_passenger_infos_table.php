<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassengerInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passengerInfos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('userId')->nullable();
            $table->string('firstNameFa')->nullable();
            $table->string('lastNameFa')->nullable();
            $table->string('firstNameEn')->nullable();
            $table->string('lastNameEn')->nullable();
            $table->string('birthDay', 20)->nullable();
            $table->tinyInteger('sex')->nullable();
            $table->string('meliCode', 50)->nullable();
            $table->tinyInteger('iForeign')->default(0);
            $table->string('passportNum')->nullable();
            $table->string('passportExp', 20)->nullable();
            $table->unsignedInteger('countryId')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passengerInfos');
    }
}
