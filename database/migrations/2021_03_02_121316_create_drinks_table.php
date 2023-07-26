<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drinks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('cityId')->default(0);
            $table->text('description');
            $table->text('recipes');
            $table->unsignedBigInteger('categoryId');
            $table->string('file');
            $table->string('picNumber')->nullable();
            $table->string('alt')->nullable();
            $table->string('keyword', 300);
            $table->string('seoTitle', 300);
            $table->string('slug', 300);
            $table->string('meta', 300);
            $table->integer('seen')->default(0);
            $table->integer('reviewCount')->default(0);
            $table->float('fullRate')->default(0);
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
        Schema::dropIfExists('drinks');
    }
}
