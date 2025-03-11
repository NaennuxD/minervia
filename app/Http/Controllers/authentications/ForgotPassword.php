<?php

namespace App\Http\Controllers\authentications;

use Infinitypaul\LaravelPasswordHistoryValidation\Rules\NotFromPasswordHistory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class ForgotPassword extends Controller {
  public function request(){
    return view('content.authentications.auth-forgot-password');
  }

  public function email(Request $request){
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
      ? back()->with(['status' => __($status)])
      : back()->withErrors(['email' => __($status)]);
  }

  public function reset(Request $request){
    return view('content.authentications.auth-reset-password', ['token' => $request->token, 'email' => $request->email]);
  }

  public function update(Request $request) {
    $request->validate([
      'token' => 'required',
      'email' => 'required|email',
      'password' => ['required', new NotFromPasswordHistory($request->user())],
    ]);

    $status = Password::reset(
      $request->only('email', 'password', 'password_confirmation', 'token'),
      function ($user, $password) {
        $user->forceFill([
          'password' => Hash::make($password)
        ])->setRememberToken(Str::random(60));
        
        $user->save();
        
        event(new PasswordReset($user));
      }
    );

    return $status === Password::PASSWORD_RESET
      ? redirect()->route('login')->with('status', __($status))
      : back()->withErrors(['email' => [__($status)]]);
  }
}