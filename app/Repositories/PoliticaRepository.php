<?php

namespace App\Repositories;

use App\Interfaces\PoliticaRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Politicas;
use Carbon\Carbon;

class PoliticaRepository implements PoliticaRepositoryInterface
{
  public function findAll()
  {
    $empresaId = Controller::getSession('empresa_id');
    $queries = Politicas::where("empresa_id", $empresaId)->get();

    foreach($queries as $key => $query){
      $queries[$key]["data_criacao"] = Carbon::parse($query->created_at)->format('d/m/Y - H:i:s');
    }

    return $queries;
  }

  public function create($request)
  {
    $empresaId = Controller::getSession('empresa_id');

    $query = new Politicas;
    $query->descricao = $request->descricao;
    $query->empresa_id = $empresaId;
    $query->save();

    return $query->id;
  }

  public function configure($request)
  {
    $empresaId = Controller::getSession('empresa_id');

    $query = Politicas::find($request->politica_id);
    $query->empresa_id = $empresaId;
    $query->dados = serialize($request->steps);
    $query->save();

    return $query->id;
  }

  public function findById($id)
  {
    $query = Politicas::find($id);
    $query['dados'] = unserialize($query->dados);
    $query["data_criacao"] = Carbon::parse($query->created_at)->format('d/m/Y - H:i:s');

    return $query;
  }

  public function delete($request)
  {
    Politicas::where("id", $request->politica_id)->delete();
    return true;
  }

  public function retrieveData()
  {
    $empresaId = Controller::getSession('empresa_id');
    $query = Politicas::where("empresa_id", $empresaId)->first();

    if(!empty($query->dados)){
      return unserialize($query->dados);
    }

    return 0;
  }

}