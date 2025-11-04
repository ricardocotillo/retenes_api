<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lista_precios', function (Blueprint $table) {
            $table->id();
            $table->string('mcodcadi', 3);
            $table->string('mindcred', 2);
            $table->string('mcondpago', 2)->nullable();
            $table->decimal('impneto_min', 14, 4);
            $table->decimal('impneto_max', 14, 4);
            $table->string('mcodcli', 16)->nullable();
            $table->string('mcodzon', 5)->nullable();
            $table->string('mnom_camlis', 20);
            $table->string('des_lista', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_precios');
    }
};
