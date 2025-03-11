<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'cnpj',
        'company_name',
        'contact',
        'address',
        'cep',
        'number',
        'complement',
        'city',
        'state',
        'logo',
        'neighborhood',
        'country',
        // 'tipo_agente',
        'encarregado',
        'agente_tratamento',
        'telefone_empresa',
        'telefone_encarregado',
        'email_empresa',
        'email_encarregado',
    ];
}
