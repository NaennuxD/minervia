<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ROPA extends Model
{
    use HasFactory;

    protected $fillable = [
        "descricao",
        "empresa_id",
        "perguntas"
    ];
}
