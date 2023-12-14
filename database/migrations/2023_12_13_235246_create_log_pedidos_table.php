<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Detpe;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('mnserie', 10);
            $table->string('mnroped', 30);
            $table->string('mitem', 5)->nullable();
            $table->foreignIdFor(User::class);
            $table->string('description', 500);
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
        Schema::dropIfExists('log_pedidos');
    }
};
