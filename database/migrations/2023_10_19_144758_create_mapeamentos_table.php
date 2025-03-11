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
        Schema::create('mapeamentos', function (Blueprint $table) {
            $table->id();
            $table->integer("empresa_id")->nullable();
            $table->string("setor")->nullable();
            $table->string("nome_area")->nullable();
            $table->string("nome_entrevistado")->nullable();
            $table->string("atividade_tratamento")->nullable();
            $table->string("status")->nullable();
            $table->string("nome_aprovador")->nullable();
            $table->text("dados")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapeamentos');
    }
};
