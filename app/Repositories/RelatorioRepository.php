<?php

namespace App\Repositories;

use App\Interfaces\RelatorioRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\Relatorio;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\MapeamentoRepository;

class RelatorioRepository implements RelatorioRepositoryInterface
{
  public function findAll($pagination = null, $columns = ['*'], $order = "DESC", $per_page = 10)
  {
    $empresaId = Controller::getSession('empresa_id');

    if($pagination == 'false'){
      $relatorios = Relatorio::OrderBy('created_at', $order)->where("empresa_id", $empresaId)->get($columns);
    }else{
      $relatorios = Relatorio::OrderBy('created_at', $order)->where("empresa_id", $empresaId)->paginate($perPage = $per_page, $columns, $pageName = 'page');
    }

    if(!$relatorios){
      return 0;
    }

    foreach($relatorios as $key => $relatorio){
      $mapeamentoRepository = new MapeamentoRepository;
      if(!empty($relatorio->areas)){
        $areas = unserialize($relatorio->areas);
        $relatorios[$key]["areas"] = implode(', ', $areas);
      }
  
      if(!empty($relatorio->atividades)){
        $atividades = unserialize($relatorio->atividades);
        $relatorios[$key]["atividades"] = implode(', ', $atividades);
      }
  
      if(!empty($relatorio->setores)){
        $setores = unserialize($relatorio->setores);
        $relatorios[$key]["setores"] = implode(', ', $setores);
      }
  
      if(!empty($relatorio->estrutura)){
        $estrutura = unserialize($relatorio->estrutura);
        $relatorios[$key]["estrutura"] = $estrutura;
      }
    }

    return $relatorios;
  }

  public function findById($id)
  {
    $empresaId = Controller::getSession('empresa_id');
    $relatorio = Relatorio::where("id", $id)->where("empresa_id", $empresaId)->first();

    if(!empty($relatorio->areas)){
      $areas = unserialize($relatorio->areas);
      $relatorio["areas"] = $areas;
      $relatorio["areas_imploded"] = implode(', ', $areas);
    }

    if(!empty($relatorio->atividades)){
      $atividades = unserialize($relatorio->atividades);
      $relatorio["atividades"] = $atividades;
      $relatorio["atividades_imploded"] = implode(', ', $atividades);
    }

    if(!empty($relatorio->setores)){
      $setores = unserialize($relatorio->setores);
      $relatorio["setores"] = $setores;
      $relatorio["setores_imploded"] = implode(', ', $setores);
    }

    if(!empty($relatorio->estrutura)){
      $estrutura = unserialize($relatorio->estrutura);
      $relatorio["estrutura"] = $estrutura;
    }

    return $relatorio;
  }

  public function create($request)
  {
    $empresaId = Controller::getSession('empresa_id');

    $query = new Relatorio;
    $query->empresa_id = $empresaId;

    if(!empty($request->estrutura)){
      $query->estrutura = serialize($request->estrutura);
    }
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

    $atividades = $request->atividades;
    if(in_array("Todos", $atividades) && count($atividades) == 1){
      $newAtividades = '';
    }else{
      $newAtividades = serialize($atividades);
    }

    $query->descricao = $request->descricao;
    $query->assinante = $request->assinante;
    $query->cabecalho = $request->cabecalho;
    $query->tipo_relatorio = $request->tipo_relatorio;
    $query->setores = $newSetores;
    $query->areas = $newAreas;
    $query->atividades = $newAtividades;
    $query->save();

    return $query->id;
  }

  public function configure($request)
  {
    $query = Relatorio::find($request->relatorio_id);
    $query->descricao = $request->descricao;
    $query->assinante = $request->assinante;
    $query->cabecalho = $request->cabecalho;
    $query->tipo_relatorio = $request->tipo_relatorio;

    $setores = $request->setores;
    $areas = $request->areas;
    $atividades = $request->atividades;

    if($setores == null && $query->setores != null){
      // não faz nada
    }elseif($setores == null && $query->setores == null){
      $query->setores = '';
    }elseif($setores != null && in_array("Todos", $setores) && count($setores) == 1){
      $query->setores = '';
    }else{
      $query->setores = serialize($setores);
    }

    if($areas == null && $query->areas != null){
      // não faz nada
    }elseif($areas == null && $query->areas == null){
      $query->areas = '';
    }elseif($areas != null && in_array("Todos", $areas) && count($areas) == 1){
      $query->areas = '';
    }else{
      $query->areas = serialize($areas);
    }

    if($atividades == null && $query->atividades != null){
      // não faz nada
    }elseif($atividades == null && $query->atividades == null){
      $query->atividades = '';
    }elseif($atividades != null && in_array("Todos", $atividades) && count($atividades) == 1){
      $query->atividades = '';
    }else{
      $query->atividades = serialize($atividades);
    }

    if($setores == null && $query->setores != null){
      // não faz nada
    }elseif($setores == null && $query->setores == null){
      $query->setores = '';
    }elseif($setores != null && in_array("Todos", $setores) && count($setores) == 1){
      $query->setores = '';
    }else{
      $query->setores = serialize($setores);
    }
    
    if(!empty($request->estrutura)){
      $query->estrutura = serialize($request->estrutura);
    }

    $query->save();

    return $query->id;
  }

  public function delete($id)
  {
    Relatorio::find($id)->delete();
    return true;
  }
}