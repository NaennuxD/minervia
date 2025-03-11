<?php

namespace App\Http\Controllers;

use App\Interfaces\MapeamentoRepositoryInterface;
use App\Interfaces\PoliticaRepositoryInterface;
use App\Interfaces\EmpresaRepositoryInterface;
use App\Interfaces\RopaRepositoryInterface;
use Illuminate\Http\Request;

class MapeamentoController extends Controller
{
  private MapeamentoRepositoryInterface $mapeamentoRepository;
  private PoliticaRepositoryInterface $politicaRepository;
  private EmpresaRepositoryInterface $empresaRepository;
  private RopaRepositoryInterface $ropaRepository;

  public function __construct(
    MapeamentoRepositoryInterface $mapeamentoRepository,
    PoliticaRepositoryInterface $politicaRepository,
    EmpresaRepositoryInterface $empresaRepository,
    RopaRepositoryInterface $ropaRepository,
  )
  {
    $this->mapeamentoRepository = $mapeamentoRepository;
    $this->politicaRepository = $politicaRepository;
    $this->empresaRepository = $empresaRepository;
    $this->ropaRepository = $ropaRepository;
  }

  public function findAll()
  {
    $this->validateSession();
    $mapeamentos = $this->mapeamentoRepository->findAll(with_parents: false);
    $is_historic = false;

    return view('content.mapeamentos.listar', compact('mapeamentos', 'is_historic'));
  }

  public function create()
  {
    $this->validateSession();
    return view('content.mapeamentos.adicionar');
  }

  public function handleCreate(Request $request)
  {
    $this->validateSession();
    $mapeamento_id = $this->mapeamentoRepository->create($request);
    return redirect('/mapeamento/'.$mapeamento_id.'/mapa/adicionar?status=success');
  }

  public function createMap()
  {
    $this->validateSession();
    $mapeamentoId = request('mapeamento_id');

    $empresa = $this->empresaRepository->findByMapeamentoId($mapeamentoId);
    $mapeamento = $this->mapeamentoRepository->findById($mapeamentoId);
    $steps = $this->mapeamentoRepository->steps();
    $dados_pessoais_tratados = $this->mapeamentoRepository->retrievePartialData(param: "dados_pessoais_tratados", current_map: $mapeamentoId);
    $gestao_de_politicas = $this->politicaRepository->retrieveData();

    $stepKeys = $this->mapeamentoRepository->retrieveOnlyKeys($steps);
    $liberados = [3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 15, 17, 18, 19, 20, 21];

    foreach($stepKeys as $key => $stepKey){
      $count = $key + 1;
      
      if(in_array($count, $liberados)){
        $newStepKeys[] = $stepKeys[$key];
      }
    }

    $stepKeys = $newStepKeys;
    $answers = $this->mapeamentoRepository->retrieveAnswers(perguntas: $stepKeys, clear_empty: true, current_map: $mapeamentoId);

    return view('content.mapeamentos.editar')->with([
      "mapeamento" => $mapeamento,
      "steps" => $steps,
      "empresa_id" => $empresa->id,
      "empresa_nome" => $empresa->company_name,
      "dados_pessoais_tratados" => $dados_pessoais_tratados,
      "answers" => $answers,
      "gestao_de_politicas" => $gestao_de_politicas
    ]);
  }

  public function handleCreateMap(Request $request)
  {
    $this->validateSession();
    $id = $this->mapeamentoRepository->createMap($request);

    return redirect('/mapeamento/'.$id.'/mapas/listar?status=success');
  }

  public function updateMap()
  {
    $this->validateSession();
    $mapeamentoId = request('mapeamento_id');

    $empresa = $this->empresaRepository->findByMapeamentoId($mapeamentoId);
    $mapeamento = $this->mapeamentoRepository->findById($mapeamentoId);
    $steps = $this->mapeamentoRepository->steps();
    $mapeamento["dados"] = unserialize($mapeamento->dados);
    $dados_pessoais_tratados = $this->mapeamentoRepository->retrievePartialData(param: "dados_pessoais_tratados", current_map: $mapeamentoId);
    $gestao_de_politicas = $this->politicaRepository->retrieveData();

    $stepKeys = $this->mapeamentoRepository->retrieveOnlyKeys($steps);
    $liberados = [3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 15, 17, 18, 19, 20, 21];

    foreach($stepKeys as $key => $stepKey){
      $count = $key + 1;
      
      if(in_array($count, $liberados)){
        $newStepKeys[] = $stepKeys[$key];
      }
    }

    $stepKeys = $newStepKeys;
    $answers = $this->mapeamentoRepository->retrieveAnswers(perguntas: $stepKeys, clear_empty: true, current_map: $mapeamentoId);
    $parents = $this->mapeamentoRepository->findParentsById($mapeamentoId);

    return view('content.mapeamentos.editar')->with([
      "mapeamento" => $mapeamento,
      "steps" => $steps,
      "empresa_id" => $empresa->id,
      "empresa_nome" => $empresa->company_name,
      "dados_pessoais_tratados" => $dados_pessoais_tratados,
      "answers" => $answers,
      "parents" => $parents,
      "gestao_de_politicas" => $gestao_de_politicas
    ]);
  }

  public function handleUpdateMap(Request $request)
  {
    $this->validateSession();

    if($request->status_antigo == 'Aprovado' && $request->status == 'Aprovado'){
      $id = $this->mapeamentoRepository->createParentMap($request);
    }else{
      $id = $this->mapeamentoRepository->updateMap($request);
    }

    return redirect('/mapeamento/'.$id.'/mapa/editar?status=success');
  }

  public function showMaps()
  {
    $mapeamento_id = request('mapeamento_id');
    $mapeamentos = $this->mapeamentoRepository->findParentsById($mapeamento_id);
    $is_historic = true;

    if(!count($mapeamentos)){
      return redirect('/mapeamentos?status=empty');
    }

    if(count($mapeamentos) == 1){
      return redirect('/mapeamento/'.$mapeamento_id.'/mapa/editar');
    }

    return view('content.mapeamentos.listar', compact('mapeamentos', 'is_historic'));
  }

  public function delete(Request $request)
  {
    $this->validateSession();
    $id = $this->mapeamentoRepository->delete($request);

    if($request->is_parent == 'true'){
      return redirect('/mapeamento/'.$id.'/mapas/listar?status=success');
    }

    return redirect('/mapeamentos?status=success');
  }
}