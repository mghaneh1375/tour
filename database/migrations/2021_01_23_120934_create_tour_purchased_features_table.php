<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourPurchasedFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourPurchasedFeatures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('featureId');
            $table->unsignedBigInteger('tourPurchasedId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tourPurchasedFeatures');
    }
}
