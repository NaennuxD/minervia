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
        Schema::create('relatorios', function (Blueprint $table) {
            $table->id();
            $table->string("descricao");
            $table->string("assinante")->nullable()->default("Encarregado de Dados ou equivalente");
            $table->string("cabecalho");
            $table->integer("empresa_id");
            $table->string("tipo_relatorio");
            $table->string("setores")->nullable();
            $table->string("areas")->nullable();
            $table->string("atividade_tratamento")->nullable();
            $table->text("estrutura")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relatorios');
    }
};
