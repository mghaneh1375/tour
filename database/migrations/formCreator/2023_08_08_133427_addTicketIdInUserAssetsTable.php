<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTicketIdInUserAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('formDB')->table('user_assets', function (Blueprint $table) {
            $table->longText('err_text')->nullable();
            $table->unsignedInteger('ticket_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('formDB')->table('user_assets', function (Blueprint $table) {
            $table->dropColumn(['err_text']);
            $table->dropColumn(['ticket_id']);
        });
    }
}
