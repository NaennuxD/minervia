<?php

namespace App\Repositories;

use App\Interfaces\ISORepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\ISO;
use Carbon\Carbon;

class ISORepository implements ISORepositoryInterface
{
  public function findAll()
  {
    $empresaId = Controller::getSession('empresa_id');
    $queries = ISO::where("empresa_id", $empresaId)->get();

    foreach($queries as $key => $query){
      $queries[$key]["data_criacao"] = Carbon::parse($query->created_at)->format('d/m/Y - H:i:s');

      switch ($query->iso) {
        case 'ISO_27701':
          $queries[$key]["iso_nome"] = "Gestão da Privacidade";
          break;
        
        case 'ISO_27002':
          $queries[$key]["iso_nome"] = "Proteção de Dados";
          break;
        
        case 'ISO_27001':
          $queries[$key]["iso_nome"] = "Sistema de Gestão de Segurança da Informação";
          break;
          
        default:
          $queries[$key]["iso_nome"] = "Desconhecido";
          break;
      }
    }

    return $queries;
  }

  public function create($request)
  {
    $empresaId = Controller::getSession('empresa_id');

    if($request->iso == 'ISO_27001'){
      $steps = $this->stepsISO_27001();
    }elseif($request->iso == 'ISO_27002'){
      $steps = $this->stepsISO_27002();
    }else{
      $steps = $this->stepsISO_27701();
    }

    $query = new ISO;
    $query->descricao = "";
    $query->empresa_id = $empresaId;
    $query->iso = $request->iso;
    $query->dados = serialize($steps);
    $query->save();

    return $query->id;
  }

  public function configure($request)
  {
    $empresaId = Controller::getSession('empresa_id');

    $query = ISO::find($request->iso_id);
    $query->empresa_id = $empresaId;
    $query->iso = $request->iso;
    $query->dados = serialize($request->steps);
    $query->save();

    return $query->id;
  }

  public function findById($id)
  {
    $query = ISO::find($id);
    $query['dados'] = unserialize($query->dados);
    $query["data_criacao"] = Carbon::parse($query->created_at)->format('d/m/Y - H:i:s');

    switch ($query->iso) {
      case 'ISO_27701':
        $query["iso_nome"] = "Gestão da Privacidade";
        break;
      
      case 'ISO_27002':
        $query["iso_nome"] = "Proteção de Dados";
        break;
      
      case 'ISO_27001':
        $query["iso_nome"] = "Sistema de Gestão de Segurança da Informação";
        break;
        
      default:
        $query["iso_nome"] = "Desconhecido";
        break;
    }

    return $query;
  }

  public function delete($request)
  {
    ISO::where("id", $request->iso_id)->delete();

    return true;
  }

  public function retrieveData($tipo)
  {
    $empresaId = Controller::getSession('empresa_id');
    $query = ISO::where("iso", $tipo)->where("empresa_id", $empresaId)->first();

    if(!empty($query->dados)){
      return unserialize($query->dados);
    }

    return 0;
  }

  public function stepsISO_27001()
  {  
    $steps = [
      ["controle" => "A empresa identifica as questões internas e externas que têm relevância para o SGSI?"],
      ["controle" => "A empresa identifica as partes envolvidas?"],
      ["controle" => "A empresa definiu o escopo do SGSI estabelecendo os limites e a extensão de sua aplicação?"],
      ["controle" => "A empresa possui um Sistema de Gestão de Segurança da Informação?4.1 Entendendo a organização e seu contexto"],
      ["controle" => "Existem evidências da autação da Alta Administração demonstrando sua liderança, compromisso e dedicação em relação ao SGSI?"],
      ["controle" => "A empresa, com o apoio da Alta Administração, elaborou uma Política de Segurança da Informação?"],
      ["controle" => "A Alta Administração atribui e comunica as responsabilidades e autoridades dos papéis pertinentes à segurança da informação?"],
      ["controle" => "Ao elaborar o planejamento do SGSI, a empresa considera seu próprio contexto e os requisitos de todas as partes envolvidas, Identifica os riscos e oportunidades e elabora um plano de ações para lidar com esses riscos e oportunidades?"],
      ["controle" => "A empresa gerencia avaliações de riscos de segurança da informação?"],
      ["controle" => "A empresa possui um processo de tratamento de riscos da segurança da informação?"],
      ["controle" => "A empresa define os objetivos de segurança da informação para as funções e níveis pertinentes?"],
      ["controle" => "A empresa planeja e gerencia as mudanças no SGSI?"],
      ["controle" => "A empresa identifica e disponibiliza os recursos necessários para o SGSI?"],
      ["controle" => "A empresa determina e assegura as habilidades necessárias das pessoas que realizam atividades que impactam o desempenho da segurança da informação?"],
      ["controle" => "As pessoas que realizam trabalho sob o controle da empresa são conscientizadas sobre a política de segurança da informação, sua contribuição e as implicações da não conformidade com os requisitos do SGSI?"],
      ["controle" => "A empresa determina a necessidade de comunicações internas e externas relevantes para o SGSI?"],
      ["controle" => "O SGSI é documentado, incluindo as informações necessárias para sua eficácia?"],
      ["controle" => "Ao criar e atualizar a informação documentada, a empresa assegura identificação, descrição, formato, análise crítica e aprovação?"],
      ["controle" => "É assegurado ao SGSI disponibilidade, proteção, distribuição, acesso, recuperação, uso, armazenamento, preservação, controle de mudanças, retenção e disposição?"],
      ["controle" => "A empresa realiza o planejamento, implementação e controle de processos para atender aos requisitos e executar ações para o que foi planejado?"],
      ["controle" => "A empresa conduz avaliações de riscos de segurança da informação em intervalos planejados ou quando mudanças significativas são propostas ou ocorrem?"],
      ["controle" => "A empresa possui um plano de tratamento de riscos da segurança da informação?"],
      ["controle" => "A empresa monitora a segurança da informação determinando o que, como, quando, quem monitora, mede, analisa e avalia?"],
      ["controle" => "A empresa realiza auditorias internas em intervalos planejados para fornecer informações sobre a conformidade e eficácia do SGSI?"],
      ["controle" => "A empresa mantém programa(s) de auditoria interna, incluindo diversos elementos como frequência, métodos, responsabilidades, requisitos de planejamento e relato?"],
      ["controle" => "A Alta Administração analisa o SGSI em intervalos planejados? Os resultados da análise incluem decisões relativas às oportunidades para melhoria necessidades de mudanças do SGSI?"],
      ["controle" => "A empresa melhora continuamente a conformidade, a adequação e a eficácia do SGSI?"],
      ["controle" => "A empresa implementa as ações necessárias para reagir a uma não conformidade?"],
    ];
    
    return $steps;
  }

  public function stepsISO_27002()
  {  
    $steps = [
      ["controle" => "Política de Segurança da Informação e políticas temas são definidas, aprovadas pela direção, publicadas e comunicadas para as partes envolvidas."],
      ["controle" => "Os papéis e responsabilidades pela segurança da informação são definidos e alocados de acordo com as necessidades da empresa."],
      ["controle" => "As funções conflitantes e áreas de responsabilidade conflitantes são segregadas."],
      ["controle" => "As partes envolvidas aplicam a segurança da informação de acordo com a política da segurança da informação, com as políticas específicas por tema e com os procedimentos da empresa."],
      ["controle" => "A empresa mantém contato com as autoridades relevantes."],
      ["controle" => "A empresa mantém contato com grupos de interesse especial ou outros fóruns especializados em segurança e associações profissionais."],
      ["controle" => "As informações relacionadas a ameaças à segurança da informação são coletadas e analisadas para produzir inteligência sobre ameaças."],
      ["controle" => "A segurança da informação está integrada ao gerenciamento de projetos."],
      ["controle" => "Um inventário de informações e outros ativos associados, incluindo proprietários, é desenvolvido e mantido."],
      ["controle" => "Regras para o uso aceitável e procedimentos para o manuseio de informações e outros ativos associados são identificadas, documentadas e implementadas."],
      ["controle" => "Todas as partes envolvidas, conforme apropriado, devolvem todos os ativos da empresa em sua posse mediante mudança ou rescisão de seu emprego, contrato ou acordo."],
      ["controle" => "As informações são classificadas com base na confidencialidade, integridade, disponibilidade e requisitos relevantes das partes interessadas."],
      ["controle" => "Procedimentos para rotulagem de informações são implementados de acordo com o esquema de classificação de informações."],
      ["controle" => "Regras para transferência de informações são implementadas para todos os tipos de transferência dentro da empresa e entre a empresa e outras partes."],
      ["controle" => "Regras para controlar o acesso físico e lógico às informações e a outros ativos associados são estabelecidas."],
      ["controle" => "O ciclo de vida completo das identidades é controlado."],
      ["controle" => "A alocação e a gestão de informações de autenticação são monitoradas."],
      ["controle" => "Os direitos de acesso a informações e outros ativos são geridos de acordo com a política específica do tópico da empresa e as regras para controle de acesso."],
      ["controle" => "Processos e procedimentos são definidos e implementados para gerenciar os riscos da segurança da informação."],
      ["controle" => "Requisitos relevantes de segurança da informação são estabelecidos com cada fornecedor com base no tipo de relacionamento."],
      ["controle" => "Processos e procedimentos são estabelecidos e implementados para gerenciar os riscos da segurança da informação associados à cadeia de fornecimento de produtos e serviços de TIC."],
      ["controle" => "A empresa deve gerenciar as mudanças nas práticas de segurança da informação do fornecedor e na prestação de serviços."],
      ["controle" => "Os processos para serviços em nuvem devem ser estabelecidos de acordo com os requisitos de segurança da informação da empresa desde a compra até o término do contrato."],
      ["controle" => "A empresa deve manter um plano de gestão incidentes de segurança de informação."],
      ["controle" => "A empresa avalia os eventos de segurança da informação."],
      ["controle" => "Os incidentes de segurança da informação são respondidos de acordo com os procedimentos documentados."],
      ["controle" => "O conhecimento adquirido em incidentes de segurança da informação é usado para fortalecer e melhorar os controles de segurança da informação."],
      ["controle" => "A empresa coleta evidências relacionadas a eventos de segurança da informação."],
      ["controle" => "A empresa estabelece procedimentos para manter a segurança da informação durante a disrupção."],
      ["controle" => "A empresa possui um plano de continuidade de negócios."],
      ["controle" => "Os requisitos legais, estatutários, regulatórios e contratuais relevantes para a segurança da informação são gerenciados."],
      ["controle" => "A empresa protege os direitos de propriedade intelectual."],
      ["controle" => "Os registros devem ser protegidos contra perda, destruição, falsificação, acesso não autorizado e liberação não autorizada."],
      ["controle" => "A empresa assegura os requisitos referentes à privacidade e proteção de dados pessoais de acordo com as leis e regulamentos aplicáveis e os requisitos contratuais."],
      ["controle" => "A empresa gerencia a segurança da informação, incluindo pessoas, processos e tecnologias, em intervalos planejados ou quando ocorrem mudanças significativas."],
      ["controle" => "O compliance com a política de segurança da informação da empresa, políticas específicas por tema, regras e normas são analisadas criticamente a intervalos regulares."],
      ["controle" => "Os procedimentos operacionais para instalações de processamento de informações são documentados e disponibilizados às partes envolvidas."],
      ["controle" => "Verificações de antecedentes são realizadas em candidatos antes de ingressarem na empresa, de acordo com as leis, regulamentos e ética aplicáveis, sendo proporcionais aos requisitos do negócio, à classificação das informações e aos riscos percebidos."],
      ["controle" => "As responsabilidades do pessoal e da empresa para a segurança da informação constam nos contratos trabalhistas."],
      ["controle" => "As partes internas e externas pertinentes recebem conscientização, educação, treinamento e atualizações regulares sobre segurança da informação, políticas e procedimentos específicos relacionados às suas funções."],
      ["controle" => "A empresa possui um processo disciplinar formalizado e comunicado para tomar ações contra o pessoal e outras partes interessadas relevantes que cometeram uma violação da política de segurança da informação."],
      ["controle" => "A empresa protege seus interesses que permanecem válidos após a rescisão ou a mudança de emprego do pessoal relevante e outras partes interessadas."],
      ["controle" => "A empresa implementa acordos de confidencialidade ou não divulgação com as partes internas e externas."],
      ["controle" => "Medidas de segurança são implementadas quando as pessoas estiverem trabalhando remotamente."],
      ["controle" => "A empresa possui um procedimento para o pessoal relatar eventos de segurança da informação."],
      ["controle" => "Perímetros de segurança devem são definidos e usados para proteger áreas que contenham informações e outros ativos associados."],
      ["controle" => "As áreas seguras são protegidas pelos controles de entrada e pontos de acesso apropriados."],
      ["controle" => "Segurança física é implementada em escritórios, salas e instalações."],
      ["controle" => "As instalações são monitoradas continuamente."],
      ["controle" => "São projetadas proteções contra ameaças físicas e ambientais, intencionais ou não intencionais à infraestrutura."],
      ["controle" => "São projetadas medidas de segurança para trabalhar em áreas seguras."],
      ["controle" => "São definidas regras de mesa limpa e tela limpa."],
      ["controle" => "Os equipamentos são posicionados com segurança e proteção."],
      ["controle" => "São definidas regras de proteção para os ativos fora do local."],
      ["controle" => "As mídias de armazenamento são gerenciadas em todo seu ciclo de vida, manuseio e descarte."],
      ["controle" => "As instalações de processamento de informações são protegidas contra falhas de energia e outras perdas causadas por falhas nos serviços de infraestrutura."],
      ["controle" => "Os cabos que transportam energia ou dados, ou que sustentam serviços de informação, são protegidos contra interceptação, interferência ou danos."],
      ["controle" => "Os equipamentos são gerenciados corretamente para assegurar a disponibilidade, integridade e confidencialidade da informação."],
      ["controle" => "Os equipamentos que contêm mídias de armazenamento são gerenciados para garantir que quaisquer dados confidenciais e softwares licenciados tenham sido removidos ou substituídos com segurança antes da descarte ou reutilização."],
      ["controle" => "Existem regras para proteger as informações armazenadas, processadas ou acessíveis por meio de dispositivos de endpoint do usuário."],
      ["controle" => "A atribuição e o uso de direitos de acessos privilegiados são restritos e gerenciados."],
      ["controle" => "O acesso às informações e outros ativos associados é restrito de acordo com a política de controle de acesso."],
      ["controle" => "Os acessos de leitura e escrita ao código-fonte, ferramentas de desenvolvimento e bibliotecas de software são gerenciados."],
      ["controle" => "A empresa assegura que qualquer parte envolvida seja autenticada com segurança com base no controle de acesso."],
      ["controle" => "A empresa monitora e assegura a capacidade necessária para tratamento das informações."],
      ["controle" => "A empresa implementa regras de proteção contra malware."],
      ["controle" => "A empresa gerencia todas suas vulnerabilidades técnicas."],
      ["controle" => "A empresa gerencia e assegura que as regras de configurações, incluindo configurações de segurança, de hardware, software, serviços e redes, são documentadas, implementadas, monitoradas e analisadas criticamente."],
      ["controle" => "As informações armazenadas em sistemas de informação, dispositivos ou em qualquer outro meio de armazenamento são excluídas quando não forem mais necessárias."],
      ["controle" => "O mascaramento de dados é usado de acordo com sua política específica levando em consideração as legislações aplicáveis."],
      ["controle" => "As medidas de prevenção de vazamento de dados são aplicadas a sistemas, redes e quaisquer outros dispositivos que processem, armazenem ou transmitam informações."],
      ["controle" => "Cópias de backup de informações, software e sistemas são mantidas e testadas regularmente de acordo com a política de backup."],
      ["controle" => "Recursos de processamento de informações são implementados com redundância suficiente para manter disponibilidade."],
      ["controle" => "Logs que registrem atividades, exceções, falhas e outros eventos relevantes são produzidos e analisados."],
      ["controle" => "As redes, sistemas e aplicações são monitorados e ações apropriadas são tomadas quando detectados comportamentos anômalos para avaliar possíveis incidentes de segurança da informação."],
      ["controle" => "Os relógios dos sistemas de processamento de informações utilizados pela empresa são sincronizados."],
      ["controle" => "O uso de programas utilitários que possam ser capazes de se sobrepor a controles de sistema e de aplicações é restrito e rigorosamente gerenciado."],
      ["controle" => "Regras são implementadas para gerenciar com segurança a instalação de software e aplicações em sistemas operacionais."],
      ["controle" => "Redes e dispositivos de rede são constantemente monitorados e controlados para proteger as informações em sistemas e aplicações."],
      ["controle" => "A empresa assegura a proteção nos serviços de rede."],
      ["controle" => "Grupos de serviços de informação, usuários e sistemas de informação são segregados nas redes da empresa."],
      ["controle" => "O acesso a websites externos é gerenciado."],
      ["controle" => "A empresa implementa regras para o uso de criptografia e gerenciamento de chaves criptográficas."],
      ["controle" => "A empresa implementa regras para o desenvolvimento seguro de software e sistemas."],
      ["controle" => "Requisitos de segurança da informação são identificados, especificados e aprovados ao desenvolver ou adquirir aplicações."],
      ["controle" => "Princípios para engenharia de sistemas seguros são definidos e aplicados a qualquer atividade de desenvolvimento de sistemas."],
      ["controle" => "Princípios de codificação segura são aplicados ao desenvolvimento de software."],
      ["controle" => "Regras e processos de teste de segurança são definidos e implementados no ciclo de vida do desenvolvimento."],
      ["controle" => "A empresa gerencia as atividades relacionadas à terceirização de desenvolvimento de sistemas."],
      ["controle" => "Ambientes de desenvolvimento, teste e produção são separados e protegidos."],
      ["controle" => "A empresa implementa regras e procedimentos para de gestão de mudanças."],
      ["controle" => "Informações de teste são gerenciadas."],
      ["controle" => "Testes de auditoria e outras atividades de garantia envolvendo a avaliação de sistemas operacionais são planejados e acordados entre o testador e a gestão apropriada."],
    ];
    
    return $steps;
  }
  
  public function stepsISO_27701()
  {
    $steps = [
      ["controle" => "A empresa definiu seu papel para identificar se atua como controlador e/ou operador de DP."],
      ["controle" => "A empresa definiu todas as leis de proteção de dados e normas regulamentadoras aplicáveis ao negócio e analisou todos os requisitos contratuais estabelecidos com outras organizações."],
      ["controle" => "A empresa identificou todas as partes com as quais estabelece condições comerciais para o tratamento de dados pessoais e categorizou."],
      ["controle" => "A empresa definiu o alcance do SGSI."],
      ["controle" => "A empresa estabeleceu e monitora continuamente o SGPI."],
      ["controle" => "A Alta Direção participa ativamente da implementação do programa de privacidade."],
      ["controle" => "A Alta Direção participa ativamente do estabelecimento de regras para segurança da informação."],
      ["controle" => "A Alta Direção direciona as demandas aos responsáveis de forma que todos tenham papéis relevantes no processo de implementação e gestão do SGSI."],
      ["controle" => "A empresa observou todos os contextos organizacionais (cultura, parceiros, legislações etc.) aos quais está inserida e todos os riscos associados."],
      ["controle" => "A organizações implementou processos para avaliação de riscos em todos os projetos."],
      ["controle" => "O processo de avaliação de riscos aplicado à proteção de dados se estende à privacidade."],
      ["controle" => "A empresa realiza avaliação de riscos em todas as atividades necessárias para proteger a privacidade."],
      ["controle" => "A empresa estabelece métricas e audita os resultados alcançados."],
      ["controle" => "A empresa estebeleceu processos de avaliação de riscos e os tratamentos são definidos de acordo com a avaliação realizada."],
      ["controle" => "A empresa identifica e disponibiliza recursos necessários (financeiro, pessoal ou organizacional) para assegurar a implantação, gestão e melhoria contínua do SGSI."],
      ["controle" => "A empresa estabelece as responsabilidades de acordo com a competência de cada colaborador para implementação do SGSI."],
      ["controle" => "A empresa implementa uma cultura de forma que todos contribuam para um SGSI mais eficiente de acordo com as características específicas de cada negócio."],
      ["controle" => "A empresa definiu as informaçãoes relevantes que, quando, como e para quem deve ser informadas."],
      ["controle" => "A empresa documentou o SGSI com todas as descrições necessárias para o documento."],
      ["controle" => "A empresa disponibiliza versões atualizadas e completas para todas as partes relevantes ao cumprimento do SGSI."],
      ["controle" => "A empresa estabelece métricas tangíveis e audita os resultados alcançados."],
      ["controle" => "A empresa estabeleu procedimentos de aditoria para o SGSI."],
      ["controle" => "A empresa estabeleceu períodos mínimos de revisão do SGSI bem como procedimentos de atualização de versão."],
      ["controle" => "A empresa estabeleceu procedimentos para tomar ações para controlar e corrigir uma não conformidade, tratar as consequências, analisar criticamente a eficácia de quaisquer ações corretivas tomadas e alterar o SGSI, se necessário."],
      ["controle" => "Os papéis e responsabilidades pela segurança da informação foram defnidos e alocados de acordo com as necessidades da empresa, incluindo quando referente ao tratamento de dados pessoais."],
      ["controle" => "A empresa indicou um DPO e uma equipe de privacidade (Comitê Gestor)."],
      ["controle" => "A empresa identificou todas as finalidade de todas as suas atividades de tratamento de dados pessoais."],
      ["controle" => "A empresa  definiu todas as bases legais para realização do tratamento de DP de acordo com as finalidades de cada atividade."],
      ["controle" => "A empresa identificou a necessidade do uso do Consentimento como base legal e implementou todos os procedimentos necessários para a gestão."],
      ["controle" => "A empresa assegura que todo tratamento realizado com base no consetimento está cumprindo os requisitos estabelecidos para a gestão desta base legal."],
      ["controle" => "A empresa estabeleceu procedimentos internos para identificar, de acordo com a característa da atividade, a realização de avaliações de impacto à privacidade."],
      ["controle" => "A empresa identificou todos os operadores que utiliza e definiu os critérios de proteção de dados e privacidade de acordo com o nível exigido para a atividade e estabeleceu regras em contrato."],
      ["controle" => "A empresa identificou todos os controladores conjuntos que utiliza e definiu os critérios de proteção de dados e privacidade de acordo com o nível exigido para a atividade e estabeleceu regras em contrato."],
      ["controle" => "A empresa mantém um inventário atualizado de todas as atividades de tratamento de dados pessoais que realiza."],
      ["controle" => "A empresa deve assegurar que os titulares de DP sejam providos com informações apropriadas sobre o tratamento de seus DP e para atender quaisquer outras obrigações aplicáveis aos titulares de DP, relativas aos tratamentos de seus DP."],
      ["controle" => "Aviso de Privacidade - a empresa determinou os requisitos legais, regulamentares e/ou de negócio para quando a informação for fornecida para o titular de DP (por exemplo, antes do tratamento, dentro de um certo tempo, a partir da solicitação) e para o tipo de informação a ser fornecida."],
      ["controle" => "Aviso de Privacidade - a empresa fornece aos titulares de DP, de forma clara e facilmente acessível, informações que identifquem o controlador de DP e descrevam o tratamento de seus DP."],
      ["controle" => "A empresa fornece mecanismos para os titulares de DP para modifcar ou cancelar os seus consentimentos."],
      ["controle" => "A empresa concede aos titulares de DP o direito de negar o consentimento ao tratamento de seus DP."],
      ["controle" => "A empresa implementou políticas, procedimentos e/ou mecanismos para permitir aos titulares de DP obter acesso para corrigir e excluir os seus DP, quando solicitado e sem atraso indevido."],
      ["controle" => "A empresa estabelece procedimentos para comunicar aos terceiros com os quais compartilha DP qualquer alteração referente ao tratamento."],
      ["controle" => "A empresa é capaz de fornecer uma cópia do DP que é tratado em um formato estruturado e usado normalmente, acessível pelo titular de DP."],
      ["controle" => "A empresa definiu e documentou políticas e procedimentos para tratamento e respostas a solicitações legítimas dos titulares de DP."],
      ["controle" => "A empresa oferece mecanismos permitindo aos titulares de DP desaprovar decisões tomadas de forma automatizada, e/ou solicitar a intervenção humana."],
      ["controle" => "A empresa limita a coleta de DP para o que é adequado, relevante e necessário em relação aos propósitos identifcados."],
      ["controle" => "A empresa limita o tratamento de DP gerenciadno por meio de políticas de privacidade e de segurança da informação, juntamente com procedimentos documentados para as suas adoções e compliance."],
      ["controle" => "A  empresa implementa políticas, procedimentos e/ou mecanismos para minimizar a imprecisão dos DP que ela trata."],
      ["controle" => "A empresa definiu critérios para tratamentos de DP após atingir a finalidade do tratamento inicial, utilizando processos de anonimização."],
      ["controle" => "A empresa implementou mecanismos para excluir/anonimizar o DP quando nenhum tratamento adicional for realizado."],
      ["controle" => "A empresa implementou procedimentos para realizar verifcações periódicas de modo que arquivos temporários não usados sejam excluídos dentro de um período de tempo identifcado."],
      ["controle" => "A empresa estabeceu procedimentos para cumprir os prazos de retenção dos DP."],
      ["controle" => "A empresa estabeleceu procedimentos técnicos (físicos e lógicos) para realizar o descarte dos DP."],
      ["controle" => "A empresa assegura que somente pessoas autorizadas têm acesso aos sistemas de transmissão, seguindo os processos apropriados (incluindo a retenção de logs de auditoria), para assegurar que o DP seja transmitido sem comprometimento para os destinatários corretos."],
      ["controle" => "A empresa documenta o compliance com os requisitos de todas jurisições como a base para a transferência."],
      ["controle" => "A empresa identifica todos os países e as organizações internacionais para os quais os DP possam, possivelmente, ser transferidos em uma operação normal, inclusive em condições de subcontratação."],
      ["controle" => "A empresa registra a transferência de DP para ou de terceiros que tenham sido modifcados, bem como apoia essas partes nas solcitações relativas às obrigações para os titulares de DP."],
      ["controle" => "A empresa registra todas as transferências de DP para terceiros."],
      ["controle" => "O contrato entre a empresa e o cliente satisfaz as condições necessárias para garantir assistência com as obrigações do cliente, considerando a natureza do tratamento."],
      ["controle" => "O contrato entre a empresa e o cliente inclui, mas não é limitado a, o objetivo e o tempo de duração do serviço."],
      ["controle" => "A empresa não trata dados dos clientes para fins de marketing."],
      ["controle" => "A empresa possui procedimentos para verifcar se uma instrução viola a legislação e/ou regulamentação."],
      ["controle" => "A empresa possui trilha de auditoria (interna e externa) que demonstra compliance para o tratamento conrtatado em todo o ciclo de vida."],
      ["controle" => "A empresa mantém um inventário atualizado de todas as atividades de tratamento de dados pessoais que realiza."],
      ["controle" => "A empresa possui capacidade de atender a solicitações dos titulares de acordo com as obrigações estabelecidas em contrato com o cliente."],
      ["controle" => "A empresa conduz verifcações periódicas, de modo que, arquivos temporários não usados são removidos dentro do período de tempo identifcado."],
      ["controle" => "A empresa obedece à instrução e atende ao prazo de retenção dos DP estabelecido em contrato."],
      ["controle" => "A empresa assegura que somente pessoas autorizadas têm acesso a sistemas de transmissão e sigam os processos apropriados para assegurar que DP sejam transmitidos sem comprometimento para os destinatários corretos."],
      ["controle" => "A  empresa assegura em contrato informar ao cliente de forma antecipada, de acordo com um prazo acordado, de tal modo que o cliente tenha a capacidade de contestar estas mudanças ou rescindir o contrato."],
      ["controle" => "A empresa disponibiliza a relação de todos os países com os quais compartilha DP para a execução de um contrato."],
      ["controle" => "A empresa registra e mantém trilha de auditoria para todos os terceiros com quem compartilha DP, inclusive quando submetido a investigações legais ou a auditorias externas."],
      ["controle" => "A empresa possui procedimentos para notificar ao cliente sobre quaisquer solicitações dentro de um prazo acordado."],
      ["controle" => "A empresa rejeita quaisquer solicitações para a divulgação de DP que não sejam legalmente obrigatórias e consulta o cliente em questão."],
      ["controle" => "O contrato com o cliente prevê a utilização de subcontratados."],
      ["controle" => "A empresa divulga a lista de seus subcontratados para o cumprimento do contrato e avisa ao cliente qualquer alteração de forma antecipada."],
      ["controle" => "A empresa adota a prática de utilização de contrato pontual específico em caso de solicitar uma alteração de subcontratado."],
    ];

    return $steps;
  }

}