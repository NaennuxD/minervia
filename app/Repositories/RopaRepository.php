<?php

namespace App\Repositories;

use App\Interfaces\RopaRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\ROPA;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\MapeamentoRepository;

class RopaRepository implements RopaRepositoryInterface
{

  public function findAll($pagination = null, $columns = ['*'], $order = "DESC", $per_page = 10)
  {
    $empresaId = Controller::getSession('empresa_id');

    if($pagination == 'false'){
      $ropas = ROPA::OrderBy('created_at', $order)->where("empresa_id", $empresaId)->get($columns);
    }else{
      $ropas = ROPA::OrderBy('created_at', $order)->where("empresa_id", $empresaId)->paginate($perPage = $per_page, $columns, $pageName = 'page');
    }

    if(!$ropas){
      return 0;
    }

    foreach($ropas as $key => $ropa){
      $mapeamentoRepository = new MapeamentoRepository;
      $ropas[$key]["perguntas"] = $mapeamentoRepository->implodePerguntas($ropa->perguntas);
    }

    return $ropas;
  }

  public function findById($id)
  {
    $empresaId = Controller::getSession('empresa_id');
    $ropa = ROPA::where("id", $id)->where("empresa_id", $empresaId)->first();

    if(!empty($ropa->perguntas)){
      $ropa["perguntas"] = unserialize($ropa->perguntas);
    }

    return $ropa;
  }

  public function create($request)
  {
    $empresaId = Controller::getSession('empresa_id');

    $query = new ROPA;
    $query->empresa_id = $empresaId;

    if(!empty($request->perguntas)){
      $query->perguntas = serialize($request->perguntas);
    }

    $query->descricao = $request->descricao;
    $query->save();

    return $query->id;
  }

  public function update($request)
  {
    $query = ROPA::find($request->ropa_id);
    $query->descricao = $request->descricao;

    if(!empty($request->perguntas)){
      $query->perguntas = serialize($request->perguntas);
    }

    $query->save();

    return true;
  }

  public function delete($id)
  {
    ROPA::find($id)->delete();
    return true;
  }
}