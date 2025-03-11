<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|string',
            'password' => 'required|string'
          ];
    }
    
    public function messages(){
        return [
            'email.required' => 'E-mail é obrigatório',
            'password.required' => 'Senha é obrigatória'
        ];
    }
}
