<?php

namespace App\Http\Controllers;

use Infinitypaul\LaravelPasswordHistoryValidation\Rules\NotFromPasswordHistory;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(
      UserRepositoryInterface $userRepository
    )
    {
      $this->userRepository = $userRepository;
    }

    public function show()
    {
      $usuarios = $this->userRepository->findAll(pagination: 1, order: "ASC", per_page: 10);

      return view('content.usuarios.listar')->with([
        "usuarios" => $usuarios
      ]);
    }

    public function update()
    {
      $userId = request('usuario_id');
      $usuarios = $this->userRepository->findById($userId);

      return view('content.usuarios.editar')->with([
        "usuario" => $usuarios
      ]);
    }

    public function handleUpdate(Request $request)
    {
      $request->validate([
        "name" => "required|string",
        'email' => 'required|string|unique:users,email,'.$request->id,
        "funcao" => "required|string"
      ]);

      $userId = request('usuario_id');
      $this->userRepository->update($request);

      return redirect('/usuario/'.$userId.'/edit?status=success');
    }

    public function create()
    {
      return view('content.usuarios.adicionar');
    }

    public function handleCreate(Request $request)
    {
      $request->validate([
        "name" => "required|string",
        'email' => 'required|string|unique:users,email',
        "password" => "required|string",
        "funcao" => "required|string"
      ]);

      $this->userRepository->create($request);

      return redirect('/usuarios?status=success');
    }

    public function delete()
    {
      $userId = request('usuario_id');
      $this->userRepository->delete($userId);

      return redirect('/usuarios?status=success');
    }

    public function firstAccess()
    {
      if(!Auth::user()->primeiro_acesso){
        return to_route('dashboard');
      }
      return view('content.authentications.auth-first-access');
    }

    public function handleFirstAccess(Request $request)
    {
      $request->validate([
        'password' => ['required', new NotFromPasswordHistory($request->user())],
        'password_confirmation' => 'required|string',
        // 'g-recaptcha-response' => 'required|captcha'
      ]);


      if($request->password != $request->password_confirmation){
        $args = [
          'erro' => true,
          'content' => 'Senhas não conferem'
        ];
        return view('content.authentications.auth-first-access')->with($args);
      }

      $request["id"] = Auth::id();
      $this->userRepository->updatePassword($request);
      
      return redirect('/');
    }
}
