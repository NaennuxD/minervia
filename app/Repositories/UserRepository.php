<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class UserRepository implements UserRepositoryInterface 
{
  public function findAll($pagination = null, $columns = ['*'], $order = "DESC", $per_page = 10)
  {
    if($pagination == 'false'){
      $queries = User::where("funcao", "!=", "customer")->OrderBy('created_at', $order)->get($columns);
    }else{
      $queries = User::where("funcao", "!=", "customer")->OrderBy('created_at', $order)->paginate($perPage = $per_page, $columns, $pageName = 'page');
    }

    if(!$queries){
      return 0;
    }

    foreach($queries as $key => $query){
      $queries[$key]["data_criacao"] = Carbon::parse($query->created_at)->format('d/m/Y - H:i:s');

      switch ($query->status) {
        case 'active':
          $query["status"] = "Ativo";
        break;
        
        case 'inactive':
          $query["status"] = "Inativo";
        break;
        
        default:
          $query["status"] = "Default";
        break;
      }
    }

    return $queries;
  }

  public function findAllByFuncao($funcao)
  {
    $query = User::where('funcao', $funcao)->get();

    foreach($query as $key => $q){
      $query[$key]["data_criacao"] = Carbon::parse($q->created_at)->format('d/m/Y - H:i:s');
      
      switch ($query->status) {
        case 'active':
          $query["status"] = "Ativo";
        break;
        
        case 'inactive':
          $query["status"] = "Inativo";
        break;
        
        default:
          $query["status"] = "Default";
        break;
      }
    }

    return $query;
  }

  public function findById($id)
  {
    $query = User::find($id);
      
    switch ($query->status) {
      case 'active':
        $query["status"] = "Ativo";
      break;
      
      case 'inactive':
        $query["status"] = "Inativo";
      break;
      
      default:
        $query["status"] = "Default";
      break;
    }

    return $query;
  }

  public function create($request)
  {
    $query = new User;
    $query->name = $request->name;
    $query->funcao = $request->funcao;
    $query->email = $request->email;
    $query->status = 'active';
    $query->primeiro_acesso = 1;
    $query->password = Hash::make($request->password);
    $query->save();

    return $query->id;
  }

  public function update($request)
  {
    $query = User::find($request->id);
    $query->name = $request->name;
    $query->email = $request->email;
    $query->status = $request->status;
    $query->funcao = $request->funcao;

    if(!empty($request->password)){
      $query->primeiro_acesso = 1;
      $query->password = Hash::make($request->password);
    }

    $query->save();

    return true;
  }

  public function delete($id)
  {
    $query = User::find($id)->delete();

    return true;
  }

  public function updatePassword($request)
  {
    $query = User::find($request->id);
    $query->password = Hash::make($request->password);
    $query->primeiro_acesso = 0;
    $query->save();
  }
}