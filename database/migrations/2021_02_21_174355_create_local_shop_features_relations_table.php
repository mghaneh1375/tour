<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalShopFeaturesRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_shop_features_relations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('featureId');
            $table->unsignedBigInteger('localShopId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('local_shop_features_relations');
    }
}
