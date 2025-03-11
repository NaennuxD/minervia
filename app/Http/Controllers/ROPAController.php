<?php

namespace App\Http\Controllers;

use App\Interfaces\MapeamentoRepositoryInterface;
use App\Interfaces\GraficoRepositoryInterface;
use App\Interfaces\RopaRepositoryInterface;
use Illuminate\Http\Request;

class ROPAController extends Controller
{
  private MapeamentoRepositoryInterface $mapeamentoRepository;
  private GraficoRepositoryInterface $graficoRepository;
  private RopaRepositoryInterface $ropaRepository;

  public function __construct(
    MapeamentoRepositoryInterface $mapeamentoRepository,
    GraficoRepositoryInterface $graficoRepository,
    RopaRepositoryInterface $ropaRepository,
  )
  {
    $this->mapeamentoRepository = $mapeamentoRepository;
    $this->graficoRepository = $graficoRepository;
    $this->ropaRepository = $ropaRepository;
  }

  public function findAll()
  {
    $this->validateSession();
    $ropas = $this->ropaRepository->findAll(pagination: 1, order: "ASC", per_page: 10);

    return view('content.ropas.listar')->with([
      "ropas" => $ropas
    ]);
  }

  public function create()
  {
    $this->validateSession();
    $steps = $this->mapeamentoRepository->steps();
    $stepKeys = $this->mapeamentoRepository->retrieveOnlyKeys($steps);

    return view('content.ropas.adicionar', compact('stepKeys'));
  }

  public function handleCreate(Request $request)
  {
    $this->validateSession();
    $ropa_id = $this->ropaRepository->create($request);

    return redirect('/ropa/'.$ropa_id.'/editar?status=success');
  }

  public function delete()
  {
    $this->validateSession();
    $ropaId = request('ropa_id');
    $this->ropaRepository->delete($ropaId);

    return redirect('/ropas?status=success');
  }

  public function update()
  {
    $this->validateSession();
    $ropaId = request('ropa_id');
    $ropa = $this->ropaRepository->findById($ropaId);
    $steps = $this->mapeamentoRepository->steps();
    $stepKeys = $this->mapeamentoRepository->retrieveOnlyKeys($steps);

    if(!$ropa){
      return redirect('/ropas?status=empty');
    }

    return view('content.ropas.editar', compact('ropa', 'stepKeys'));
  }

  public function handleUpdate(Request $request)
  {
    $this->validateSession();
    $this->ropaRepository->update($request);

    return redirect('/ropa/'.$request->ropa_id.'/editar?status=success');
  }

  public function show()
  {
    $this->validateSession();
    $ropaId = request('ropa_id');
    $ropa = $this->ropaRepository->findById($ropaId);
    $answers = $this->mapeamentoRepository->retrieveAnswers($ropa->perguntas);
    $steps = $this->mapeamentoRepository->steps();
    $stepKeys = $this->mapeamentoRepository->retrieveOnlyKeys($steps);

    $customStepKeys = [];
    foreach($stepKeys as $step){
      $customStepKeys[$step["slug"]] = $step["name"];

      if(isset($step['subitems'])){
        foreach($step['subitems'] as $subitem){
          $customStepKeys[$subitem["slug"]] = $subitem["name"];
        }
      }
    }

    return view('content.ropas.visualizar', compact("ropa", "answers", "customStepKeys"));
  }
}
