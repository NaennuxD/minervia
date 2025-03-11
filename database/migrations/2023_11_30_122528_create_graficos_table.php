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
        Schema::create('graficos', function (Blueprint $table) {
            $table->id();
            $table->string("nome");
            $table->string("tipo");
            $table->string("parametros");
            $table->string("setores");
            $table->integer("empresa_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graficos');
    }
};
