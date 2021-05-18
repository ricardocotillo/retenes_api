<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMcodvenToDetpeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detpe', function (Blueprint $table) {
            $table->string('MCODVEN', 6)->nullable();
            $table->foreignId('cabpe_id')->on('cabpe')->onDelete('cascade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detpe', function (Blueprint $table) {
            
        });
    }
}
