<?php

namespace App\Repositories;

use App\Interfaces\ParametroRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\Parametro;
use App\Models\Mapeamento;
use App\Models\Mapa;
use Illuminate\Support\Facades\Auth;

class ParametroRepository implements ParametroRepositoryInterface
{
  public function findAll()
  {
    $parametros = Parametro::all();
    foreach($parametros as $key => $parametro){
    }
    return $parametros;
  }

  public function findById($id)
  {
    $parametro = Parametro::find($id);
    return $parametro;
  }

  public function create($request)
  {
    $query = new Parametro;
    $query->data = $request->data;
    $query->value = $request->value;
    $query->save();
    return $query->id;
  }

  public function update($request)
  {
    $query = Parametro::find($request->parametro_id);
    $query->data = $request->data;
    $query->value = $request->value;
    $query->save();
    return true;
  }

  public function delete($id)
  {
    Parametro::find($id)->delete();
    return true;
  }
}