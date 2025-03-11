<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string',
            'telefone' => 'required|string',
            'cpf' => 'required|string'
        ];
    }
    
    public function messages(){
        return [
            'name.required' => 'Nome é obrigatório',
            'email.required' => 'E-mail é obrigatório',
            'email.unique' => 'E-mail já cadastrado em nosso sistema',
            'telefone.required' => 'Telefone é obrigatório',
            'cpf.required' => 'CPF é obrigatório',
            'password.required' => 'Senha é obrigatória'
        ];
    }
}
