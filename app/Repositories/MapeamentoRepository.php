<?php

namespace App\Repositories;

use App\Interfaces\MapeamentoRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\Mapeamento;
use App\Models\Mapa;
use App\Models\Empresa;
use App\Models\Parametro;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MapeamentoRepository implements MapeamentoRepositoryInterface
{
  public function steps()
  {
    // $categoria_do_dado = Parametro::where('data', 'categoria_do_dado')->first()->value;
    // $categoria_do_dado = explode(', ', $categoria_do_dado);

    $steps = [
      [
        "name" => "Finalidade",
        "status" => "active",
        "slug" => "finalidade",
        "type" => "text",
        "duplicate" => false
      ],
      [
        "name" => "Descrição do fluxo",
        "status" => "active",
        "slug" => "descricao_do_fluxo",
        "type" => "text",
        "duplicate" => false
      ],
      [
        "name" => "Dados pessoais tratados",
        "status" => "active",
        "slug" => "dados_pessoais_tratados",
        "type" => "text",
        "duplicate" => true,
        "subitems" => [
          [
            "name" => "Categoria do dado",
            "status" => "active",
            "slug" => "categoria_do_dado",
            "type" => "text",
          ],
          [
            "name" => "Titular do dado",
            "status" => "active",
            "slug" => "titular_do_dado",
            "type" => "text",
          ],
          [
            "name" => "Dado de criança ou adolescente",
            "status" => "active",
            "slug" => "dado_de_crianca_ou_adolescente",
            "type" => "radio",
            "values" => [
              "SIM",
              "NÃO"
            ],
          ],
          [
            "name" => "Volume de titulares",
            "status" => "active",
            "slug" => "volume_de_titulares",
            "type" => "text",
          ]
        ]
      ],
      [
        "name" => "Abrangência da coleta",
        "status" => "active",
        "slug" => "abrangencia_da_coleta",
        "duplicate" => true,
        "type" => "text",
      ],
      [
        "name" => "Origem dos dados",
        "status" => "active",
        "slug" => "origem_dos_dados",
        "duplicate" => true,
        "type" => "text",
      ],
      [
        "name" => "Fonte dos dados",
        "status" => "active",
        "slug" => "fonte_dos_dados",
        "duplicate" => true,
        "type" => "text",
      ],
      [
        "name" => "Aplicativos/sistemas utilizados",
        "status" => "active",
        "slug" => "aplicativos_sistemas_utilizados",
        "duplicate" => true,
        "type" => "text",
        "subitems" => [
          [
            "name" => "Fornecedor",
            "status" => "active",
            "slug" => "fornecedor",
            "type" => "text",
          ],
          [
            "name" => "Local de armazenamento digital",
            "status" => "active",
            "slug" => "local_de_armazenamento_digital",
            "type" => "text",
          ],
        ]
      ],
      [
        "name" => "Documento físico",
        "status" => "active",
        "slug" => "documento_fisico",
        "duplicate" => true,
        "type" => "text",
        "subitems" => [
          [
            "name" => "Local de armazenamento físico",
            "status" => "active",
            "slug" => "local_de_armazenamento_fisico",
            "type" => "text",
          ],
        ]
      ],
      [
        "name" => "Organizações com as quais existem compartilhamento externo de dados",
        "status" => "active",
        "slug" => "organizacoes_com_as_quais_existem_compartilhamento_externo_de_dados",
        "duplicate" => true,
        "type" => "text",
        "subitems" => [
          [
            "name" => "Ferramentas ou procedimentos usados para o compartilhamento externo",
            "status" => "active",
            "slug" => "ferramentas_ou_procedimentos_usados_para_o_compartilhamento_externo",
            "type" => "text",
            "duplicate" => true,
          ],
        ]
      ],
      [
        "name" => "Compartilhamento interno de dados",
        "status" => "active",
        "slug" => "compartilhamento_interno_de_dados",
        "duplicate" => true,
        "type" => "text",
        "subitems" => [
          [
            "name" => "Ferramentas ou procedimentos usados para compartilhamento interno de dados",
            "status" => "active",
            "slug" => "ferramentas_ou_procedimentos_usados_para_compartilhamento_interno",
            "type" => "text",
            "duplicate" => true,
          ],
        ]
      ],
      [
        "name" => "Organizações com as quais existem transferência internacional",
        "status" => "active",
        "slug" => "organizacoes_com_as_quais_existem_transferencia_internacional",
        "duplicate" => true,
        "type" => "text",
        "subitems" => [
          [
            "name" => "Controles para transferência internacional",
            "status" => "active",
            "slug" => "controles_para_transferencia_internacional",
            "type" => "text",
            "duplicate" => true,
          ],
        ]
      ],
      [
        "name" => "Processo de decisão automatizada",
        "status" => "active",
        "slug" => "processo_de_decisao_automatizada",
        "duplicate" => true,
        "type" => "text",
      ],
      [
        "name" => "Período de retenção",
        "status" => "active",
        "slug" => "periodo_de_retencao",
        "duplicate" => true,
        "type" => "text",
        "subitems" => [
          [
            "name" => "Forma de descarte",
            "status" => "active",
            "slug" => "forma_de_descarte",
            "type" => "text",
          ],
        ]
      ],
      [
        "name" => "Responsável pelo processo",
        "status" => "active",
        "slug" => "responsavel_pelo_processo",
        "duplicate" => true,
        "type" => "text",
      ],
      [
        "name" => "Medidas de segurança (técnicas ou administrativas)",
        "status" => "active",
        "slug" => "medidas_de_seguranca",
        "duplicate" => true,
        "type" => "text",
      ],
      [
        "name" => "Papel da empresa",
        "status" => "active",
        "slug" => "papel_da_empresa",
        "duplicate" => false,
        "type" => "text",
      ],
      [
        "name" => "Base legal",
        "status" => "active",
        "slug" => "base_legal",
        "duplicate" => true,
        "type" => "text",
        "subitems" => [
          [
            "name" => "Comprovação da base legal",
            "status" => "active",
            "slug" => "comprovacao_da_base_legal",
            "type" => "text",
          ],
        ]
      ],
      [
        "name" => "Terceiros",
        "status" => "active",
        "slug" => "terceiros",
        "duplicate" => true,
        "type" => "select",
        "values" => [
          "OPERADOR",
          "SUBOPERADOR",
          "GOVERNO",
          "CONTROLADOR CONJUNTO",
          "CONTROLADOR SINGULAR"
        ],
        "subitems" => [
          [
            "name" => "Organização",
            "status" => "active",
            "slug" => "organizacao",
            "type" => "text",
          ],
        ]
      ],
      [
        "name" => "Princípios",
        "status" => "active",
        "slug" => "principios",
        "duplicate" => false,
        "subitems" => [
          [
            "name" => "Tratamento atende ao princípio da finalidade",
            "status" => "active",
            "slug" => "tratamento_atende_ao_principio_da_finalidade",
            "duplicate" => false,
            "type" => "text",
          ],
          [
            "name" => "Tratamento atende ao princípio da adequação",
            "status" => "active",
            "slug" => "tratamento_atende_ao_principio_da_adequacao",
            "duplicate" => false,
            "type" => "text",
          ],
          [
            "name" => "Tratamento atende ao princípio da necessidade",
            "status" => "active",
            "slug" => "tratamento_atende_ao_principio_da_necessidade",
            "duplicate" => false,
            "type" => "text",
          ],
          [
            "name" => "Tratamento atende ao princípio da qualidade",
            "status" => "active",
            "slug" => "tratamento_atende_ao_principio_da_qualidade",
            "duplicate" => false,
            "type" => "text",
          ],
          [
            "name" => "Tratamento atende ao princípio da não discriminação",
            "status" => "active",
            "slug" => "tratamento_atende_ao_principio_da_nao_discriminacao",
            "duplicate" => false,
            "type" => "text",
          ],
        ]
      ],
      [
        "name" => "GAPS",
        "status" => "active",
        "slug" => "gaps",
        "type" => "text",
        "duplicate" => true,
        "subitems" => [
          [
            "name" => "Nível da probabilidade de incidente",
            "status" => "active",
            "slug" => "nivel_da_probabilidade_de_incidente",
            "type" => "select",
            "values" => [
              "1 MUITO IMPROVÁVEL",
              "2 IMPROVÁVEL",
              "3 POSSÍVEL",
              "4 PROVÁVEL",
              "5 MUITO PROVÁVEL",
            ]
          ],
          [
            "name" => "Nível do impacto",
            "status" => "active",
            "slug" => "nivel_do_impacto",
            "type" => "select",
            "values" => [
              "1 MUITO BAIXO",
              "2 BAIXO",
              "3 MÉDIO",
              "4 ALTO",
              "5 CRÍTICO",
            ]
          ],
          [
            "name" => "Nível do risco",
            "status" => "active",
            "slug" => "nivel_do_risco",
            "type" => "text",
          ],
          [
            "name" => "Descrição da probabilidade",
            "status" => "active",
            "slug" => "descricao_da_probabilidade",
            "type" => "text",
          ],
          [
            "name" => "Descrição do impacto",
            "status" => "active",
            "slug" => "descricao_do_impacto",
            "type" => "text",
          ],
          [
            "name" => "Descrição do risco",
            "status" => "active",
            "slug" => "descricao_do_risco",
            "type" => "text",
          ],
          [
            "name" => "Controles aplicados para mitigação dos riscos",
            "status" => "active",
            "slug" => "controles_aplicados_para_mitigacao_dos_riscos",
            "type" => "text",
          ],
          [
            "name" => "Sugestão de correções necessárias",
            "status" => "active",
            "slug" => "sugestao_de_correcoes_necessarias",
            "type" => "text",
          ],
        ]
      ],
      [
        "name" => "Orientação para RIPD",
        "status" => "active",
        "slug" => "orientacao_para_ripd",
        "duplicate" => true,
        "type" => "text",
      ],
      [
        "name" => "Orientação para avaliação de legítimo interesse",
        "status" => "active",
        "slug" => "orientacao_para_avaliacao_de_legitimo_interesse",
        "duplicate" => true,
        "type" => "text",
      ]
    ];
    
    return $steps;
  }

  public function findAll($with_parents = false)
  {
    $empresaId = Controller::getSession('empresa_id');

    if($with_parents){
      $mapeamentos = Mapeamento::where('empresa_id', $empresaId)->get();
    }else{
      $mapeamentos = Mapeamento::where('empresa_id', $empresaId)->where("parent_id", null)->get();
    }

    foreach($mapeamentos as $key => $mapeamento){
      $mapeamentos[$key]["data_criacao"] = Carbon::parse($mapeamento->created_at)->format('d/m/Y - H:i:s');

      if($mapeamento->status == 'Em andamento'){
        $mapeamentos[$key]["status_cor"] = "primary";
      }elseif($mapeamento->status == 'Em aprovação'){
        $mapeamentos[$key]["status_cor"] = "warning";
      }elseif($mapeamento->status == 'Aprovado'){
        $mapeamentos[$key]["status_cor"] = "success";
      }elseif($mapeamento->status == 'Reprovado'){
        $mapeamentos[$key]["status_cor"] = "danger";
      }
    }
    
    return $mapeamentos;
  }

  public function findById($id)
  {
    $empresaId = Controller::getSession('empresa_id');
    $mapeamento = Mapeamento::where("id", $id)->where('empresa_id', $empresaId)->first();

    if($mapeamento->status == 'Em andamento'){
      $mapeamento["status_cor"] = "primary";
    }elseif($mapeamento->status == 'Em aprovação'){
      $mapeamento["status_cor"] = "warning";
    }elseif($mapeamento->status == 'Aprovado'){
      $mapeamento["status_cor"] = "success";
    }elseif($mapeamento->status == 'Reprovado'){
      $mapeamento["status_cor"] = "danger";
    }

    return $mapeamento;
  }

  public function retrieveCompanyName($query)
  {
    $empresaId = Controller::getSession('empresa_id');
    foreach($query as $key => $mapeamento){
      $empresa = Empresa::find($empresaId);
      $query[$key]->company_name = $empresa->company_name;
    }

    return $query;
  }

  public function findByEmpresaId($sectors = null, $areas = null, $all = 'false')
  {
    $ids = [];
    $empresaId = Controller::getSession('empresa_id');

    $mapeamentos = Mapeamento::query();
    $mapeamentos->where('empresa_id', $empresaId);

    if($areas != null){
      $mapeamentos->whereIn("nome_area", $areas);
    }

    if($sectors != null){
      $mapeamentos->whereIn("setor", $sectors);
    }
    
    if($all == 'false'){
      $query = DB::select('
        SELECT 
        max(id) as id
        FROM `mapeamentos` 
        WHERE parent_id is not null 
        AND empresa_id = :empresa_id
        GROUP BY parent_id
        ORDER by parent_id
      ', ['empresa_id' => $empresaId]);

      foreach($query as $q){
        array_push($ids, $q->id);
      }

      $mapeamentos->whereIn("id", $ids);
    }

    $mapeamentos->orderBy("id", "DESC");
    return $this->retrieveCompanyName($mapeamentos->get());
  }

  public function create($request)
  {
    $empresaId = Controller::getSession('empresa_id');
    $query = new Mapeamento;
    $query->empresa_id = $empresaId;
    $query->setor = $request->setor;
    $query->parent_id = null;
    $query->status = 'Em andamento';
    $query->save();

    return $query->id;
  }

  public function delete($request)
  {
    $parent_id = null;

    if($request->is_parent == 'true'){
      $query = Mapeamento::where("id", $request->mapeamento_id)->first();
      $parent_id = $query->parent_id;
      $query->delete();
      return $parent_id;
    }else{
      $query = Mapeamento::where("id", $request->mapeamento_id)->orWhere("parent_id", $request->mapeamento_id)->delete();
      return true;
    }
  }

  public function createMap($request)
  {
    $query = Mapeamento::find($request->mapeamento_id);
    $query->nome_area = $request->nome_area;
    $query->nome_entrevistado = $request->nome_entrevistado;
    $query->nome_aprovador = $request->nome_aprovador;
    $query->atividade_tratamento = $request->atividade_tratamento;
    $query->status = $request->status;
    $query->dados = serialize($request->map);
    $query->save();

    return $query->id;
  }

  public function updateMap($request)
  {
    $query = Mapeamento::find($request->mapeamento_id);
    $query->nome_area = $request->nome_area;
    $query->setor = $request->setor;
    $query->nome_entrevistado = $request->nome_entrevistado;
    $query->nome_aprovador = $request->nome_aprovador;
    $query->atividade_tratamento = $request->atividade_tratamento;
    $query->status = $request->status;
    $query->dados = serialize($request->map);
    $query->save();

    return $query->id;
  }

  public function createParentMap($request)
  {
    $current = Mapeamento::find($request->mapeamento_id);
    $empresaId = Controller::getSession('empresa_id');

    $query = new Mapeamento;
    $query->empresa_id = $empresaId;
    $query->setor = $request->setor;
    $query->nome_area = $request->nome_area;
    $query->nome_entrevistado = $request->nome_entrevistado;
    $query->nome_aprovador = $request->nome_aprovador;
    $query->atividade_tratamento = $request->atividade_tratamento;
    $query->dados = serialize($request->map);
    $query->parent_id = $request->parent_id ?? $request->mapeamento_id;
    $query->save();
    
    return $query->parent_id;
  }

  public function findParentsById($id)
  {
    $queries = Mapeamento::where("id", $id)->orWhere("parent_id", $id)->get();
    foreach($queries as $key => $query){
      $queries[$key]["data_criacao"] = Carbon::parse($query->created_at)->format('d/m/Y - H:i:s');

      if($query->status == 'Em andamento'){
        $queries[$key]["status_cor"] = "primary";
      }elseif($query->status == 'Em aprovação'){
        $queries[$key]["status_cor"] = "warning";
      }elseif($query->status == 'Aprovado'){
        $queries[$key]["status_cor"] = "success";
      }elseif($query->status == 'Reprovado'){
        $queries[$key]["status_cor"] = "danger";
      }
    }

    if($queries->count() == 1){
      foreach($queries as $key => $query){
        if($query->id == $id && $query->parent_id != null){
          $newQuery = Mapeamento::find($query->parent_id);
          $newQuery["data_criacao"] = Carbon::parse($newQuery->created_at)->format('d/m/Y - H:i:s');

          if($newQuery->status == 'Em andamento'){
            $newQuery["status_cor"] = "primary";
          }elseif($newQuery->status == 'Em aprovação'){
            $newQuery["status_cor"] = "warning";
          }elseif($newQuery->status == 'Aprovado'){
            $newQuery["status_cor"] = "success";
          }elseif($newQuery->status == 'Reprovado'){
            $newQuery["status_cor"] = "danger";
          }

          $queries[] = $newQuery;
        }
      }
    }

    return $queries;
  }

  public function implodePerguntas($perguntas)
  {
    if(empty($perguntas)){
      return '';
    }

    if(!is_array($perguntas)){
      $perguntas = unserialize($perguntas);
    }

    $imploded = '';
    foreach($perguntas as $pergunta){
      if(isset($pergunta['slug'])){
        $imploded .= $pergunta['slug'].', ';
      }

      if(isset($pergunta["subitems"])){
        foreach($pergunta["subitems"] as $subitem){
          $imploded .= $subitem['slug'].', ';
        }
      }
    }

    $imploded = rtrim($imploded, ', ');
    
    return $imploded;
  }

  public function retrievePartialData(
    string $param,
    array $sectors = null,
    array $areas = null,
    string $current_map = null,
    bool $only_answers = false,
    bool $without_subitems = false
  )
  {
    $mapeamentos = $this->findByEmpresaId(sectors: $sectors, all: 'true', areas: $areas);
    $arr = [];
    $skip = false;

    foreach($mapeamentos as $key => $mapeamento){
      if($current_map == $mapeamento->id || !$mapeamento->dados){
        continue;
      }

      $newDados = [];
      $dados = unserialize($mapeamento->dados);

      foreach($dados as $key => $dado){
        foreach($dado as $dKey => $d){
          if(!isset($d["subitems"][$param]) && !isset($dados[$param])){
            $skip = true;
          }

          if(!isset($dados[$param]) && isset($d["subitems"][$param])){
            $newDados[$param][] = [
              "valor" => $d["subitems"][$param],
            ];

            $dados = '';
          }

          if(isset($d["subitems"])){
            foreach($d["subitems"] as $sKey => $subitem){
              if(Str::is($param.'*', $sKey)){
                if($sKey == $param){
                  continue;
                }

                $newDados[$param][] = [
                  "valor" => $subitem,
                ];
    
                $dados = '';
              }
            }
          }
        }
      }

      if(count($newDados) > 0){
        $dados = $newDados;
        $skip = false;
      }

      if($skip){
        continue;
      }

      // dump($dados[$param]);
      // Loop para varrer array e remover dado com a key "valor" caso esteja vazia e remover a key "subitems"
      foreach($dados[$param] as $key => $dado){
        // dump($dado["valor"]);
        // Se a key "valor" estiver nulla, remove do array
        if(!isset($dado["valor"])){
          unset($dados[$param][$key]);
        }

        // Se a variável $param não for "dados_pessoais_tratados", remove a key "subitems" por não precisar processa-la
        if($param != "dados_pessoais_tratados" || $without_subitems){
          unset($dados[$param][$key]["subitems"]);
        }
      }

      if($dados[$param]){
        if($only_answers){
          foreach($dados[$param] as $dado){
            if(!in_array($dado["valor"], $arr)){
              $arr[] = $dado["valor"];
            }
          }

        }else{
          $arr[] = [
            "mapeamento_id" => $mapeamento->id,
            "parametro" => $param,
            "area" => $mapeamento->nome_area,
            "setor" => $mapeamento->setor,
            "atividade_tratamento" => $mapeamento->atividade_tratamento,
            "dados" => $dados[$param]
          ];

        }
      }
    }

    return $arr;
  }

  public function retrieveAllSetores()
  {
    $empresaId = Controller::getSession('empresa_id');
    $setores = $this->findByEmpresaId(all: "true");
    $arr = [];

    foreach($setores as $setor){
      array_push($arr, $setor->setor);
    }

    $arr = array_unique($arr);

    return $arr;
  }

  public function retrieveAllAreas()
  {
    $empresaId = Controller::getSession('empresa_id');
    $areas = $this->findByEmpresaId(all: "true");
    $arr = [];

    foreach($areas as $area){
      array_push($arr, $area->nome_area);
    }

    $arr = array_unique($arr);

    return $arr;
  }

  public function retrieveAllAtividades()
  {
    $empresaId = Controller::getSession('empresa_id');
    $atividades = $this->findByEmpresaId(all: "true");
    $arr = [];

    foreach($atividades as $atividade){
      array_push($arr, $atividade->atividade_tratamento);
    }

    $arr = array_unique($arr);

    return $arr;
  }

  public function retrieveOnlyKeys($data, $return = [])
  {
    foreach($data as $key => $d){
      $return[$key] = [
        "name" => $d["name"],
        "slug" => $d["slug"],
      ];

      if(isset($d["subitems"])){
        $subitems = $d["subitems"];

        foreach($subitems as $subitem){
          $return[$key]["subitems"][] = [
            "name" => $subitem["name"],
            "slug" => $subitem["slug"],
          ];
        }
      }
    }

    return $return;
  }

  public function retrieveAnswers($perguntas, $clear_empty = false, $current_map = null)
  {
    $perguntas = explode(", ", $this->implodePerguntas($perguntas));
    $respostas = [];

    foreach($perguntas as $pergunta){
      $resposta = $this->retrievePartialData(param: $pergunta, only_answers: true, without_subitems: true, current_map: $current_map);

      if($clear_empty && !$resposta){
        continue;
      }

      $respostas[$pergunta] = $resposta;
    }

    return $respostas;
  }
}