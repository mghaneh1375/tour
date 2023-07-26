<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalShopsUserActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_shops_user_actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('localShopId');
            $table->unsignedBigInteger('userId');
            $table->tinyInteger('iAmHere')->default(0);
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
        Schema::dropIfExists('local_shops_user_actions');
    }
}
