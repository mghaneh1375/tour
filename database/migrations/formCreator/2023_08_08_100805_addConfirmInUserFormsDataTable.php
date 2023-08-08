<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConfirmInUserFormsDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('formDB')->table('user_forms_data', function (Blueprint $table) {
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
        Schema::connection('formDB')->table('user_forms_data', function (Blueprint $table) {
            $table->dropColumn(['status']);
        });
    }
}
