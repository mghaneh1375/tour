<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddErrTextInUserSubAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('formDB')->table('user_sub_assets', function (Blueprint $table) {
            $table->longText('err_text')->nullable();
            $table->enum('status', ['PENDING', 'CONFIRM', 'REJECT'])->default('PENDING');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('formDB')->table('user_sub_assets', function (Blueprint $table) {
            $table->dropColumn(['err_text']);
            $table->dropColumn(['status']);
        });
    }
}
