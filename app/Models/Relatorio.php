<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relatorio extends Model
{
    use HasFactory;

    protected $fillable = [
        "descricao",
        "assinante",
        "cabecalho",
        "empresa_id",
        "tipo_relatorio",
        "setores",
        "areas",
        "atividade_tratamento",
        "estrutura",
    ];
}
