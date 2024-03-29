<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Cabpe;

class CreateValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('values', function (Blueprint $table) {
            $table->id();
            $table->string('mnserie', 4);
            $table->string('mnroped', 7);
            $table->string('label', 50);
            $table->string('value', 500);
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
        Schema::dropIfExists('values');
    }
}
