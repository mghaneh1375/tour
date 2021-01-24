<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsCategoryRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsCategoryRelations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('newsId');
            $table->unsignedBigInteger('categoryId');
        });

        Schema::table('newsCategoryRelations', function(Blueprint $table){
            $table->foreign('newsId')->on('news')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('categoryId')->on('newsCategories')->references('id')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newsCategoryRelations');
    }
}
