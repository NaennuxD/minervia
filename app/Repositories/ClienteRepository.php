<?php

namespace App\Repositories;

use App\Interfaces\ClienteRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\Clientes;
use App\Models\User;
use App\Models\Projetos;
use Illuminate\Support\Facades\Auth;

class ClienteRepository implements ClienteRepositoryInterface
{
  public function findAll()
  {
    $clientes = Clientes::all();

    foreach($clientes as $key => $cliente){
      $user = User::where('funcao', 'cliente')->where('id', $cliente->user_id)->first();
      $projects = Projetos::where('cliente_id', $cliente->id)->get();

      $clientes[$key]["name"] = $user->name;
      $clientes[$key]["funcao"] = $user->funcao;
      $clientes[$key]["cpf"] = $user->cpf;
      $clientes[$key]["telefone"] = $user->telefone;
      $clientes[$key]["endereco"] = $user->endereco;
      $clientes[$key]["email"] = $user->email;
      $clientes[$key]["projetos"] = $projects;
    }

    return $clientes;
  }

  public function findById($id)
  {
    $cliente = Clientes::find($id);
    $user = User::where('funcao', 'cliente')->where('id', $cliente->user_id)->first();

    $cliente["name"] = $user->name;
    $cliente["funcao"] = $user->funcao;
    $cliente["cpf"] = $user->cpf;
    $cliente["telefone"] = $user->telefone;
    $cliente["endereco"] = $user->endereco;
    $cliente["email"] = $user->email;

    return $cliente;
  }

  public function getClienteByUserId($id)
  {
    $query = Clientes::where('user_id', $id)->first();

    return $query;
  }

  public function create($request)
  {
    $query = new Clientes;
    $query->user_id = $request->user_id;
    $query->indicador = $request->indicador;
    $query->save();

    return $query->id;
  }

  public function update($request)
  {
    $query = Clientes::where('user_id', $request->user_id)->first();
    $query->indicador = $request->indicador;
    $query->save();

    return true;
  }

  public function delete($id)
  {
    $query = Clientes::find($id);
    $userId = $query->user_id;
    $query->delete();

    return $userId;
  }
}