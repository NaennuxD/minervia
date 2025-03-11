<?php

namespace App\Http\Controllers;

use App\Interfaces\MapeamentoRepositoryInterface;
use App\Interfaces\GraficoRepositoryInterface;
use Illuminate\Http\Request;

class GraficosController extends Controller
{
  private MapeamentoRepositoryInterface $mapeamentoRepository;
  private GraficoRepositoryInterface $graficoRepository;

  public function __construct(
    MapeamentoRepositoryInterface $mapeamentoRepository,
    GraficoRepositoryInterface $graficoRepository,
  )
  {
    $this->mapeamentoRepository = $mapeamentoRepository;
    $this->graficoRepository = $graficoRepository;
  }

  public function findAll()
  {
    $this->validateSession();
    $graficos = $this->graficoRepository->findAll(pagination: 1, order: "ASC", per_page: 10);

    return view('content.graficos.listar')->with([
      "graficos" => $graficos
    ]);
  }

  public function create()
  {
    $this->validateSession();
    $setores = $this->mapeamentoRepository->retrieveAllSetores();
    $areas = $this->mapeamentoRepository->retrieveAllAreas();
    $steps = $this->mapeamentoRepository->steps();
    $stepKeys = $this->mapeamentoRepository->retrieveOnlyKeys($steps);

    return view('content.graficos.adicionar', compact("stepKeys", "setores", "areas"));
  }

  public function handleCreate(Request $request)
  {
    $this->validateSession();
    $grafico_id = $this->graficoRepository->create($request);

    if(!empty($request->return_url)){
      return redirect($request->return_url.'?status=success&grafico_id='.$grafico_id);
    }

    return redirect('/grafico/'.$grafico_id.'/editar?status=success');
  }

  public function delete()
  {
    $this->validateSession();
    $graficoId = request('grafico_id');
    $this->graficoRepository->delete($graficoId);

    return redirect('/graficos?status=success');
  }

  public function update()
  {
    $this->validateSession();
    $graficoId = request('grafico_id');
    $grafico = $this->graficoRepository->findById($graficoId);

    if(!$grafico){
      return redirect('/graficos?status=empty');
    }

    if(empty($grafico->setores)){
      $sectors = [];
    }else{
      $sectors = $grafico->setores;
    }

    if(empty($grafico->areas)){
      $areas = [];
    }else{
      $areas = $grafico->areas;
    }

    $mapsData = $this->mapeamentoRepository->retrievePartialData(param: $grafico->parametros, sectors: $sectors, areas: $areas);
    $dataFormated = $this->graficoRepository->formatDataFromMap($mapsData);
    $labels = implode(',', $dataFormated[0]);
    $data = implode(',', $dataFormated[1]);

    $setores = $this->mapeamentoRepository->retrieveAllSetores();
    $areas = $this->mapeamentoRepository->retrieveAllAreas();
    $steps = $this->mapeamentoRepository->steps();
    $stepKeys = $this->mapeamentoRepository->retrieveOnlyKeys($steps);
    
    return view('content.graficos.editar', compact("grafico", "labels", "data", "stepKeys", "setores", "areas"));
  }

  public function handleUpdate(Request $request)
  {
    $this->validateSession();
    $this->graficoRepository->update($request);

    return redirect('/grafico/'.$request->grafico_id.'/editar?status=success');
  }

  /**
   * Descontinuado
   */
  public function show()
  {
    $this->validateSession();
    $graficoId = request('grafico_id');
    $grafico = $this->graficoRepository->findById($graficoId);
    
    $parametros = $grafico->parametros;

    $mapsData = $this->mapeamentoRepository->retrievePartialData(param: $parametros);
    $dataFormated = $this->graficoRepository->formatDataFromMap($mapsData);

    $labels = implode(',', $dataFormated[0]);
    $data = implode(',', $dataFormated[1]);

    return view('content.graficos.grafico', compact("grafico", "labels", "data"));
  }
}

