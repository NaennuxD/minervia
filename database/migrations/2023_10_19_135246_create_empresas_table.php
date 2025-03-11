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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('inactive');
            $table->string('cnpj')->nullable();
            $table->string('company_name');
            $table->string('contact');
            $table->string('address')->nullable();
            $table->string('cep')->nullable();
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('city')->nullable();
            $table->string('logo')->nullable();
            $table->string('state')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('country')->nullable();
            // $table->string('tipo_agente')->nullable();
            $table->string('encarregado')->nullable();
            $table->string('agente_tratamento')->nullable();
            $table->string('telefone_empresa')->nullable();
            $table->string('telefone_encarregado')->nullable();
            $table->string('email_empresa')->nullable();
            $table->string('email_encarregado')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
