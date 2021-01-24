<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourPurchasedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourPurchased', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('userId');
            $table->unsignedBigInteger('mainInfoId');
            $table->string('payOffCode')->nullable();
            $table->string('koochitaTrackingCode');
            $table->string('phone', 20);
            $table->string('email');
            $table->unsignedBigInteger('tourTimeId');
            $table->string('fullyPrice');
            $table->string('payable');
            $table->unsignedBigInteger('dailyDiscountId')->nullable();
            $table->unsignedBigInteger('groupDiscountId')->nullable();
            $table->unsignedBigInteger('codeDiscountId')->nullable();
            $table->string('koochitaScoreDiscountId')->nullable();

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
        Schema::dropIfExists('tourPurchased');
    }
}
