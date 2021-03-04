<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrinkGoodForRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drink_good_for_relations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('drinkId');
            $table->unsignedBigInteger('foodGoodForId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drink_good_for_relations');
    }
}
