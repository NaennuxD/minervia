<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadFilesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'comprovante' => 'required'
        ];
    }
    
    public function messages(){
        return [
            'comprovante.required' => 'O documento enviado é invalido. Por favor, tente novamente.',
        ];
    }
}