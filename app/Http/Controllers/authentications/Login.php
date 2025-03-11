<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthUserRequest;

class Login extends Controller
{
  public function index()
  {
    if(Auth::id()){
      $user = User::where('id', Auth::id())->first(['funcao']);

      if($user->funcao == 'aprovador'){
        return redirect()->intended('/');
      }
    }

    return view('content.authentications.auth-login');
  }

  public function auth(AuthUserRequest $request)
  {
    $email = $request->old('email');
    $password = $request->old('password');

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
      $request->session()->regenerate();

      return redirect()->intended('/');
    }

    return back()->withErrors([
      'email' => 'Usuário não encontrado ou senha incorreta.',
    ])->onlyInput('email');

  }
}
