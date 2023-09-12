<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

 	Schema::connection('formDB')->table('user_forms_data', function (Blueprint $table) {
            $table->string('user_id')->change();
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
            $table->unsignedInteger('user_id')->change();
        });
    }
};
