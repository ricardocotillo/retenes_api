<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMcodtrspToCabpe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cabpe', function (Blueprint $table) {
            Schema::table('cabpe', function (Blueprint $table) {
                $table->string('MCODTRSP', 11)->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cabpe', function (Blueprint $table) {
            //
        });
    }
}
