<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class Dashboard extends Controller
{
  public function logout(Request $request){
    Auth::logout();
  
    session()->invalidate();
    session()->regenerateToken();
  
    return redirect('/login');
  }

  public function index(){
    $nome = Auth::user()->name;
    $funcao = Auth::user()->funcao;

    return view('content.dashboard.index')->with([
      "nome" => $nome,
      "funcao" => $funcao
    ]);
  }
}