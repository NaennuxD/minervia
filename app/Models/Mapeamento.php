<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapeamento extends Model
{
    use HasFactory;

    protected $fillable = [
        "empresa_id",
        "setor",
        "dados",
        "nome_area",
        "nome_entrevistado",
        "status",
        "nome_aprovador",
        "atividade_tratamento"
    ];
}