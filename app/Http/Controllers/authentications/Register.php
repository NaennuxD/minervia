<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterUserRequest;

class Register extends Controller
{
  public function index()
  {

    if(Auth::id()){
      return redirect()->intended('/');
    }
    
    return view('content.authentications.auth-register');
  }

  public function save(RegisterUserRequest $request){

    $nome = $request->old('nome');
    // $sobrenome = $request->old('sobrenome');
    $email = $request->old('email');
    // $modulo = $request->old('modulo');
    $password = $request->old('password');
    $password_confirm = $request->old('password_confirm');
    // $whatsapp = $request->old('whatsapp');

    if($request->password != $request->password_confirm){

      $args = [
        'erro' => true,
        'content' => 'Senhas não conferem'
      ];

      return view('content.authentications.auth-register')->with($args);
    }

    $user = new User;
    $user->name = $request->nome;
    $user->email = $request->email;
    $user->funcao = 'customer';
    $user->password = Hash::make($request->password);
    $user->save();
    
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
      $request->session()->regenerate();
      return redirect('/');
    }

    return back()->withErrors([
      'email' => 'Usuário não encontrado ou senha incorreta.',
    ])->onlyInput('email');

  }
}
