<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddErrTextInUserFormsDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('formDB')->table('user_forms_data', function (Blueprint $table) {
            $table->longText('err_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('formDB')->table('user_forms_data', function (Blueprint $table) {
            $table->dropColumn(['err_text']);
        });
    }
}
