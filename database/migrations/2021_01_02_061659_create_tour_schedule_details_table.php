<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourScheduleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourScheduleDetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tourScheduleId');
            $table->unsignedBigInteger('detailKindId');
            $table->string('text', 255)->nullable();
            $table->string('sTime', 10)->nullable();
            $table->string('eTime', 10)->nullable();
            $table->tinyInteger('hasPlace')->default(0);
            $table->text('description')->nullable();
        });

        Schema::table('tourScheduleDetails', function(Blueprint $table){
           $table->foreign('tourScheduleId')->on('tourSchedules')->references('id')->onDelete('cascade');
           $table->foreign('detailKindId')->on('tourScheduleDetailKinds')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tourScheduleDetails');
    }
}
