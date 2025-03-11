<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateScale extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'aula' => 'required|string',
            'data' => 'required|array',
            'modulo' => 'required|integer',
            'professor_id' => 'required|integer',
          ];
    }
    
    public function messages(){
        return [
            'modulo.required' => 'Escolha um módulo',
            'aula.required' => 'Nome da aula é obrigatório',
            'data.required' => 'Informe a data da aula',
            'professor_id.required' => 'Informe um professor para essaa aula'
        ];
    }
}
