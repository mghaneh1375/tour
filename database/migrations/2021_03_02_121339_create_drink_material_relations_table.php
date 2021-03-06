<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrinkMaterialRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drink_material_relations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('drinkId');
            $table->unsignedBigInteger('foodMaterialId');
            $table->string('volume');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drink_material_relations');
    }
}
