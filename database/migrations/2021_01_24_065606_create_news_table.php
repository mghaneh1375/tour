<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('userId');
            $table->string('title');
            $table->string('slug');
            $table->string('pic');
            $table->string('summery', 300);
            $table->longText('text');
            $table->string('release', 20);
            $table->string('date', 10);
            $table->string('time', 10);
            $table->text('meta');
            $table->string('keyword');
            $table->string('seoTitle');
            $table->integer('seen')->unsigned();
            $table->tinyInteger('confirm')->default(0);
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
        Schema::dropIfExists('news');
    }
}
