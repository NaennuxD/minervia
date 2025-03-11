<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\PoliticaRepositoryInterface;

class PoliticasController extends Controller
{
  private PoliticaRepositoryInterface $politicaRepository;

  public function __construct(
    PoliticaRepositoryInterface $politicaRepository,
  )
  {
    $this->politicaRepository = $politicaRepository;
  }

  public function steps()
  {
    $steps = [
      "Política de Segurança da Informação",
      "Política de Acesso",
      "Política de Senhas",
      "Política de Backup e Recuperação de Desastres",
      "Política de Gerenciamento de Incidentes de Segurança da Informação",
      "Política de Segurança Física",
      "Política de Continuidade de Negócios",
      "Política de Gestão de Riscos",
      "Política de Classificação da Informação",
      "Política de Tratamento de Incidentes",
      "Política de Monitoramento e Auditoria",
      "Política de Proteção de Dados Pessoais",
      "Política de Controle de Dispositivos Móveis",
      "Política de Comunicação e Treinamento em Segurança da Informação",
      "Política de Uso Aceitável dos Recursos de Informação",
      "Política de Gerenciamento de Fornecedores e Terceiros",
      "Política de Contratação e Demissão de Funcionários",
      "Política de Conscientização em Segurança da Informação",
      "Política de Segurança da Informação para Funcionários em Home Office",
      "Política de Gerenciamento de Acesso de Terceiros",
      "Política de Privacidade e Proteção de Dados Pessoais dos Funcionários",
      "Política de Controle de Acesso Físico às Instalações",
      "Política de Revisão e Monitoramento de Funcionários",
      "Política de Treinamento em Segurança da Informação para Novos Funcionários",
      "Política de Remoção de Acesso de Funcionários Desligados",
      "Política de Acordo de Confidencialidade e Propriedade Intelectual",
      "Política de Auditoria Externa",
      "Política de Continuidade de Serviços Terceirizados",
      "Política de Monitoramento de Terceiros",
      "Política de Gerenciamento de Mudanças",
      "Política de Proteção de Propriedade Intelectual",
      "Política de Gerenciamento de Ativos de TI",
      "Política de Uso de Dispositivos Móveis Pessoais para Fins Profissionais",
      "Política de Acesso Remoto e VPN",
      "Política de Controle de Acesso a Sistemas Críticos",
      "Política de Resposta a Incidentes Cibernéticos em Parceria com Órgãos Reguladores",
      "Política de Testes de Invasão e Vulnerabilidade",
      "Política de Uso de Redes Sociais e Comunicação Eletrônica no Trabalho",
      "Política de Gerenciamento de Mídias Sociais",
      "Política de Proteção de Informações de Propriedade do Cliente.      ",
    ];

    return $steps;
  }

  public function findAll()
  {
    $this->validateSession();
    $politicas = $this->politicaRepository->findAll();

    if($politicas->count()){
      return redirect('/politica/'.$politicas[0]["id"].'/configurar');
    }

    return view('content.politicas.listar', compact('politicas'));
  }

  public function create()
  {
    $this->validateSession();
    return view('content.politicas.adicionar');
  }

  public function handleCreate(Request $request)
  {
    $this->validateSession();

    $politica_id = $this->politicaRepository->create($request);
    return redirect('/politica/'.$politica_id.'/configurar');
  }

  public function configure(Request $request)
  {
    $this->validateSession();
    $politicaId = $request->politica_id;
    $empresaId = Controller::getSession('empresa_id');

    $politica = $this->politicaRepository->findById($politicaId);

    if(!$politica){
      return redirect('/politicas');
    }

    $steps = $this->steps();
    return view('content.politicas.'.$politica->politica.'.configurar', compact('politica', 'steps'));
  }

  public function handleConfigure(Request $request)
  {
    $this->validateSession();
    $this->politicaRepository->configure($request);

    return redirect('/politica/'.$request->politica_id.'/configurar?status=success');
  }

  public function delete(Request $request)
  {
    $this->validateSession();
    $id = $this->politicaRepository->delete($request);
  
    return redirect('/politicas?status=success');
  }

}
