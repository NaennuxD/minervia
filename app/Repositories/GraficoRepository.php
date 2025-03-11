<?php

namespace App\Repositories;

use App\Interfaces\GraficoRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\Graficos;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class GraficoRepository implements GraficoRepositoryInterface
{
  public function findAll($pagination = null, $columns = ['*'], $order = "DESC", $per_page = 10)
  {
    $empresaId = Controller::getSession('empresa_id');

    if($pagination == 'false'){
      $graficos = Graficos::OrderBy('created_at', $order)->where("empresa_id", $empresaId)->get($columns);
    }else{
      $graficos = Graficos::OrderBy('created_at', $order)->where("empresa_id", $empresaId)->paginate($perPage = $per_page, $columns, $pageName = 'page');
    }

    if(!$graficos){
      return 0;
    }

    foreach($graficos as $key => $grafico){
      $setores = unserialize($grafico->setores);

      if(empty($setores)){
        continue;
      }
      
      $graficos[$key]["setores"] = implode(', ', $setores);
    }

    foreach($graficos as $key => $grafico){
      $areas = unserialize($grafico->areas);

      if(empty($areas)){
        continue;
      }
      
      $graficos[$key]["areas"] = implode(', ', $areas);
    }

    return $graficos;
  }

  public function findById($id)
  {
    $empresaId = Controller::getSession('empresa_id');
    $grafico = Graficos::where("id", $id)->where("empresa_id", $empresaId)->first();

    $grafico["axis"] = "x";

    if($grafico->tipo == 'bar_h'){
      $grafico["tipo"] = "bar";
      $grafico["axis"] = "y";
    }

    $setores = unserialize($grafico->setores);
    $areas = unserialize($grafico->areas);

    if(!empty($setores)){
      $grafico["setores_imploded"] = implode(', ', $setores);
    }

    $grafico["setores"] = $setores;

    if(!empty($areas)){
      $grafico["areas_imploded"] = implode(', ', $areas);
    }

    $grafico["areas"] = $areas;

    return $grafico;
  }

  public function findBySectors($setores)
  {
    $result = [];

    $empresaId = Controller::getSession('empresa_id');
    $graficos = Graficos::where("empresa_id", $empresaId)->get();

    if(empty($setores)){
      return $graficos;
    }

    foreach($graficos as $key => $grafico){
      if(empty($grafico->setores)){
        continue;
      }

      $graficoSetores = unserialize($grafico->setores);

      if(array_intersect($graficoSetores, $setores)){
        $result[] = $grafico;
      }
    }

    return $result;
  }

  public function findByAreas($areas)
  {
    $result = [];

    $empresaId = Controller::getSession('empresa_id');
    $graficos = Graficos::where("empresa_id", $empresaId)->get();

    if(empty($areas)){
      return $graficos;
    }

    foreach($graficos as $key => $grafico){
      if(empty($grafico->areas)){
        continue;
      }

      $graficoAreas = unserialize($grafico->areas);

      if(array_intersect($graficoAreas, $areas)){
        $result[] = $grafico;
      }
    }

    return $result;
  }

  public function create($request)
  {
    $empresaId = Controller::getSession('empresa_id');

    $setores = $request->setores;
    if(in_array("Todos", $setores) && count($setores) == 1){
      $newSetores = '';
    }else{
      $newSetores = serialize($setores);
    }

    $areas = $request->areas;
    if(in_array("Todos", $areas) && count($areas) == 1){
      $newAreas = '';
    }else{
      $newAreas = serialize($areas);
    }

    $query = new Graficos;
    $query->nome = $request->nome;
    $query->tipo = $request->tipo;
    $query->empresa_id = $empresaId;
    $query->parametros = $request->parametros;
    $query->setores = $newSetores;
    $query->areas = $newAreas;
    $query->save();

    return $query->id;
  }

  public function update($request)
  {
    $query = Graficos::find($request->grafico_id);
    
    $setores = $request->setores;

    if($setores == null && $query->setores != null){
      // não faz nada
    }elseif($setores == null && $query->setores == null){
      $query->setores = '';
    }elseif($setores != null && in_array("Todos", $setores) && count($setores) == 1){
      $query->setores = '';
    }else{
      $query->setores = serialize($setores);
    }
    
    $areas = $request->areas;

    if($areas == null && $query->areas != null){
      // não faz nada
    }elseif($areas == null && $query->areas == null){
      $query->areas = '';
    }elseif($areas != null && in_array("Todos", $areas) && count($areas) == 1){
      $query->areas = '';
    }else{
      $query->areas = serialize($areas);
    }

    $query->nome = $request->nome;
    $query->tipo = $request->tipo;
    $query->parametros = $request->parametros;
    $query->save();

    return true;
  }

  public function delete($id)
  {
    Graficos::find($id)->delete();
    return true;
  }

  private function retrieveLabelAndData(array $array, string $strtoupper = 'true')
  {
    $labels = [];
    $data = [];

    foreach($array as $key => $r){
      $labels[] = "'".($strtoupper == 'true' ? strtoupper($key) : ucfirst($key))."'";
      $data[] = "'".$r."'";
    }

    return [ 
      $labels,
      $data
    ];
  }

  public function formatDataFromMap(array $array, string $strtoupper = 'true')
  {
    $newArray = [];
    foreach($array as $r){
      foreach($r["dados"] as $dado){
        $newArray[] = $dado;
      }
    }

    $arrayCounted = array_count_values(array_column($newArray, 'valor'));

    return $this->retrieveLabelAndData(array: $arrayCounted, strtoupper: $strtoupper);
  }
}