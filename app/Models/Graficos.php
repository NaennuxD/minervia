<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Graficos extends Model
{
    use HasFactory;

    protected $fillable = [
        "nome",
        "tipo",
        "parametros",
        "empresa_id",
        "setores"
    ];
}
