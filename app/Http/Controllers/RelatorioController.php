<?php

namespace App\Http\Controllers;

use App\Interfaces\RelatorioRepositoryInterface;
use App\Interfaces\MapeamentoRepositoryInterface;
use App\Interfaces\GraficoRepositoryInterface;
use App\Interfaces\EmpresaRepositoryInterface;
use App\Interfaces\PoliticaRepositoryInterface;
use App\Interfaces\ISORepositoryInterface;
use Illuminate\Http\Request;
use File;
use PDF;

class RelatorioController extends Controller
{
  private RelatorioRepositoryInterface $relatorioRepository;
  private MapeamentoRepositoryInterface $mapeamentoRepository;
  private GraficoRepositoryInterface $graficoRepository;
  private EmpresaRepositoryInterface $empresaRepository;
  private ISORepositoryInterface $isoRepository;
  private PoliticaRepositoryInterface $politicaRepository;

  public function __construct(
    RelatorioRepositoryInterface $relatorioRepository,
    PoliticaRepositoryInterface $politicaRepository,
    MapeamentoRepositoryInterface $mapeamentoRepository,
    GraficoRepositoryInterface $graficoRepository,
    EmpresaRepositoryInterface $empresaRepository,
    ISORepositoryInterface $isoRepository,
  )
  {
    $this->relatorioRepository = $relatorioRepository;
    $this->mapeamentoRepository = $mapeamentoRepository;
    $this->graficoRepository = $graficoRepository;
    $this->politicaRepository = $politicaRepository;
    $this->isoRepository = $isoRepository;
    $this->empresaRepository = $empresaRepository;
  }

  public function findAll()
  {
    $this->validateSession();
    $relatorios = $this->relatorioRepository->findAll(pagination: 1, order: "ASC", per_page: 10);

    return view('content.relatorios.listar')->with([
      "relatorios" => $relatorios
    ]);
  }

  public function create()
  {
    $this->validateSession();
    $setores = $this->mapeamentoRepository->retrieveAllSetores();
    $atividades = $this->mapeamentoRepository->retrieveAllAtividades();
    $areas = $this->mapeamentoRepository->retrieveAllAreas();

    return view('content.relatorios.adicionar', compact('setores', 'areas', 'atividades'));
  }

  public function handleCreate(Request $request)
  {
    $this->validateSession();
    $id = $relatorio = $this->relatorioRepository->create($request);
    
    return redirect('/relatorio/'.$id.'/configurar?status=success');
  }

  public function configure()
  {
    $this->validateSession();
    $id = request('relatorio_id');
    $relatorio = $this->relatorioRepository->findById($id);

    if(!$relatorio){
      return redirect('/relatorios?status=empty');
    }

    $graficosSetores = $this->graficoRepository->findBySectors($relatorio->setores);
    $graficosAreas = $this->graficoRepository->findBySectors($relatorio->setores);
    $graficos = array_unique(array_merge($graficosAreas, $graficosSetores));

    $steps = $this->mapeamentoRepository->steps();
    $stepKeys = $this->mapeamentoRepository->retrieveOnlyKeys($steps);
    $setores = $this->mapeamentoRepository->retrieveAllSetores();
    $atividades = $this->mapeamentoRepository->retrieveAllAtividades();
    $areas = $this->mapeamentoRepository->retrieveAllAreas();

    return view('content.relatorios.configurar', compact('stepKeys', 'setores', 'areas', 'atividades', 'relatorio', 'graficos'));
  }

  public function handleConfigure(Request $request)
  {
    $this->validateSession();
    $id = $relatorio = $this->relatorioRepository->configure($request);
    
    return redirect('/relatorio/'.$id.'/configurar?status=success');
  }

  public function filterData(array $data, string $filter){
    $arr = [];
    foreach($data as $d){
      foreach($d["dados"] as $dado){
        foreach($dado["subitems"] as $key => $subitem){
          if($key == $filter){
            if (!isset($arr[$subitem])) {
              $arr[$subitem] = array();
            }

            if(!in_array($dado["valor"], $arr[$subitem])){
              $arr[$subitem][] = $dado["valor"];
            }
          }
        }
      }
    }
    return $arr;
  }

  public function show()
  {
    $this->validateSession();
    $id = request('relatorio_id');
    $relatorio = $this->relatorioRepository->findById($id);
    $empresa = $this->empresaRepository->findById($relatorio->empresa_id);

    $respostas = [];
    
    if($relatorio['estrutura']){
      foreach($relatorio['estrutura'] as $key => $estrutura){
        if($estrutura['tipo'] == 'map answer'){

          if(!empty($estrutura["filtro"])){
            $answer = $this->mapeamentoRepository->retrievePartialData(param: $estrutura['map'], only_answers: false);
            $data = $this->filterData(data: $answer, filter: $estrutura["filtro"]);
          }else{
            $data = $this->mapeamentoRepository->retrievePartialData(param: $estrutura['map'], only_answers: true);
          }

          $respostas[$key] = $data;
        }

        if($estrutura['tipo'] == 'policy management'){
          $data = $this->politicaRepository->retrieveData();
          $respostas[$key] = $data;
        }

        if($estrutura['tipo'] == 'maturidade'){
          $data = $this->isoRepository->retrieveData(tipo: $estrutura["maturidade"]);
          $respostas[$key] = $data;
        }

        if($estrutura['tipo'] == 'graphic'){
          $grafico = $this->graficoRepository->findById($estrutura["grafico"]);

          if($grafico){
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
            $dataFormated = $this->graficoRepository->formatDataFromMap(array: $mapsData, strtoupper: 'false');
            $labels = implode(',', $dataFormated[0]);
            $data = implode(',', $dataFormated[1]);

            $respostas[$key]["labels"] = $labels;
            $respostas[$key]["data"] = $data;
            $respostas[$key]["nome"] = $grafico->nome;
            $respostas[$key]["tipo"] = $grafico->tipo;
            $respostas[$key]["axis"] = $grafico->axis;
          }
        }
      }
    }

    $logo = File::get(storage_path('app/public/uploads/' . $empresa->logo));
    $logo = base64_encode($logo);

    // return $logo;

    $data = [
      "logo" => $logo,
      "relatorio" => $relatorio,
      "respostas" => $respostas,
      "empresa" => $empresa
    ];

    $config = ['instanceConfigurator' => function($mpdf) {
      // $mpdf->showWatermarkImage = true;
      // $mpdf->watermarkImgBehind = true;
      // $mpdf->setWatermarkImage(src: public_path('assets/img/relatorio/bg.png'), alpha: 0.2, size: 5, pos: [0, -20]);
    }]; 

    $nomeRelatorio = 'relatorio_'.date('dmY_His').'.pdf';

    $pdf = PDF::loadView('content.relatorios.pdf', $data, [], $config);
    return $pdf->stream($nomeRelatorio);
  }

  public function delete()
  {
    $this->validateSession();
    $id = request('relatorio_id');
    $this->relatorioRepository->delete($id);

    return redirect('/relatorios?status=success');
  }
}
