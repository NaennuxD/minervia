<!DOCTYPE html>
<html>
<head>
<title>Minervia - {{$relatorio->descricao}}</title>
<style>
  @page {
    size: auto;
    header: page-header;
    footer: page-footer;
    margin-header: 20px;
    margin-footer: 0;
    margin-top: 120px;
    margin-bottom: 100px;
  }

  body {
    font-family: "Open Sans", Sans-serif;
    font-size: 12pt;
    line-height: 1.3em;
  }

  .page-break-before { page-break-before: always; }

  #header{
    width: 100%;
    padding-bottom: 20px;
    margin-bottom: 120px;
    border-bottom: 2px solid #00696e;
  }

  h1{
    font-size: 2em; 
  }

  h2{
    font-size: 1.3em; 
  }

  h3{
    font-size: 1.1em; 
  }

  .title,
  h1,
  h2{
    font-weight: bold;
    line-height: 1.3em;
  }

  .subtitle{
    font-weight: 600;
    line-height: 1.3em;
  }

  h3,
  h4,
  h5{
    font-weight: 600;
    line-height: 1.3em;
  }

  body,
  li,
  ul,
  p{
    font-size: 14px
  }

  hr{
    margin: 15px 0;
  }

  ul{
    padding: 10px 20px;
    background-color: #f4f4f4
  }

  li{
    margin: 0 10px;
  }

  @page :first {
    footer: firstpage;
    margin-top: 0pt;
  }

  #footer{
    border-top: 2px solid #00696e;
    padding: 15px 0;
    margin-top: 10px;
  }

  #content{
    margin-top: 200pt
  } 

  #space-120px{
    height: 120px;
  }

  #space-100px{
    height: 100px;
  }

  #space-90px{
    height: 90px;
  }

  #space-80px{
    height: 80px;
  }

  #space-70px{
    height: 70px;
  }

  #space-60px{
    height: 60px;
  }

  #space-50px{
    height: 50px;
  }

  #space-40px{
    height: 40px;
  }

  #space-30px{
    height: 30px;
  }

  #space-20px{
    height: 20px;
  }

  #space-10px{
    height: 10px;
  }

  #space-200px{
    height: 200px;
  }

  #space-300px{
    height: 300px;
  }

  #space-400px{
    height: 400px;
  }

  li p{
    margin: 0!important
  }

  .table{
    width:100%;
  }

  .table,
  .table tr,
  .table td{
    font-size: 13px!important;
    border: 1px solid #ddd
  }

  .table td{
    padding: 5px;
  }

  .w-50{
    width: 50%;
  }

  .fw-bold{
    font-weight: bold
  }
</style>
</head>

<body>
  <htmlpageheader name="page-header">
    <div id="header">
      <table style="width:100%">
        <tr>
          <td>
            {{-- @dd($logo) --}}
            <img src="data:image/jpg;base64,{{$logo}}" alt="PGIDB" width="120" />
          </td>
          <td style="text-align:right">
            <h1>Minervia</h1>
          </td>
        </tr>
      </table>
    </div>
  </htmlpageheader>

  <htmlpagefooter name="firstpage">
    <div id="footer">
      <table style="width:100%;">
        <tr>
          <td>
            <span style="font-size:10px;">Document created at {{date('d/m/Y H:i:s')}}.</span>
          </td>
          <td style="text-align: right">
            <span style="font-size:10px;">Copyright © Minervia 2023. All rights reserved. Powered by PGIDB.</span>
          </td>
        </tr>
      </table>
    </div>
  </htmlpagefooter>
  <htmlpagefooter name="page-footer">
    <div style="text-align: center; font-size: 12px; color:#333;">Página: {PAGENO}/{nbpg}</div>
    <div id="footer">
      <table style="width:100%;">
        <tr>
          <td>
            <span style="font-size:10px;">Document created at {{date('d/m/Y H:i:s')}}.</span>
          </td>
          <td style="text-align: right">
            <span style="font-size:10px;">Copyright © Minervia 2023. All rights reserved. Powered by PGIDB.</span>
          </td>
        </tr>
      </table>
    </div>
  </htmlpagefooter>

  @if($relatorio->tipo_relatorio == 'RoPA' || $relatorio->tipo_relatorio == 'Geral' )
    <div id="space-400px"></div>
    <div style="text-align:center;">
      <h1 style="margin-bottom: 10pt;">{{$relatorio->descricao}}</h1>
      {{-- <h5>{{$relatorio->tipo_relatorio}}</h5> --}}
    </div>

    <div class="page-break-before"></div>
  @else
    <div id="space-120px"></div>
    <div style="text-align:center;">
      @if($relatorio->tipo_relatorio == 'RIPD')
        <h1 style="margin-bottom: 10pt;">{{$relatorio->descricao}}</h1>
        {{-- <h5>PROJETO DE CONTROLE DE RELATÓRIO DE IMPACTO</h5> --}}
        {{-- <h5>{{$relatorio->tipo_relatorio}}</h5> --}}
      @else
        <h1 style="margin-bottom: 10pt;">{{$relatorio->descricao}}</h1>
        {{-- <h5>{{$relatorio->tipo_relatorio}}</h5> --}}
      @endif
    </div>

    <div id="space-40px"></div>
  @endif

  @if($relatorio->cabecalho == 'Sim')
    <table class="table">
      <tr>
        <td class="w-50 fw-bold">
          Agente de tratamento
        </td>
        <td class="w-50">
          {{$empresa->agente_tratamento}}
        </td>
      </tr>
      {{-- <tr>
        <td class="fw-bold">
          Tipo de Agente de Tratamento
        </td>
        <td>
          {{$empresa->tipo_agente}}
        </td>
      </tr> --}}
      <tr>
        <td class="fw-bold w-50">
          E-mail
        </td>
        <td class="w-50">
          {{$empresa->email_empresa}}
        </td>
      </tr>
      <tr>
        <td class="fw-bold w-50">
          Telefone
        </td>
        <td class="w-50">
          {{$empresa->telefone_empresa}}
        </td>
      </tr>
    </table>
    <div id="space-10px"></div>
    <table class="table">
      <tr>
        <td class="fw-bold w-50">
          Encarregado
        </td>
        <td class="w-50">
          {{$empresa->encarregado}}
        </td>
      </tr>
      <tr>
        <td class="fw-bold w-50">
          E-mail
        </td>
        <td class="w-50">
          {{$empresa->email_encarregado}}
        </td>
      </tr>
      <tr>
        <td class="fw-bold w-50">
          Telefone
        </td>
        <td class="w-50">
          {{$empresa->telefone_encarregado}}
        </td>
      </tr>
    </table>
    <div id="space-30px"></div>
  @endif

  @if($relatorio->estrutura)
    @foreach($relatorio->estrutura as $key => $estrutura)
      <div id="space-10px"></div>
      <h3 class="title">{{$estrutura["titulo"]}}</h3>
      <p class="subtitle" style="margin-bottom: 10px">{{$estrutura["descricao"]}}</p>

      @if($estrutura["tipo"] == 'text')
        <p>{{$estrutura["texto"]}}</p>
      @endif

      @if($estrutura['tipo'] == 'policy management')
        @foreach($respostas[$key] as $resposta)
          <ul>
            <li><p><span style="font-weight: bold">Política:</span> {{$resposta["tema"]}}</p></li>
            <li><p><span style="font-weight: bold">Tipo:</span> {{$resposta["tipo"]}}</p></li>
            <li><p><span style="font-weight: bold">Status:</span> {{$resposta["status"]}}</p></li>
            <li><p><span style="font-weight: bold">Fase:</span> {{$resposta["fase"]}}</p></li>
            <li><p><span style="font-weight: bold">Área:</span> {{$resposta["area"]}}</p></li>
            <li><p><span style="font-weight: bold">Próxima Revisão:</span> {{$resposta["proxima_revisao"]}}</p></li>
            <li><p><span style="font-weight: bold">Criado por:</span> {{$resposta["criado"]}}</p></li>
            <li><p><span style="font-weight: bold">Aprovado por:</span> {{$resposta["aprovado"]}}</p></li>
          </ul>
        @endforeach
      @endif

      @if($estrutura['tipo'] == 'maturidade')
        @if($estrutura['maturidade'] == 'ISO_27001')
          <table class="table">
            <thead>
              <tr>
                <th class="fw-bold text-white" style="background-color: black">Controle</th>
                <th class="fw-bold text-white" style="background-color: black">Situação Atual</th>
                <th class="fw-bold text-white" style="background-color: black">Desejavel</th>
                <th class="fw-bold text-white" style="background-color: black">Análise</th>
              </tr>
            </thead>
            <tbody>
              @foreach($respostas[$key] as $resposta)
                <tr>
                  <td style="width: 50%">{{ $resposta["controle"] ? $resposta["controle"] : '-' }}</td>
                  <td>{!! $resposta["situacao"] ? $resposta["situacao"] : '-' !!}</td>
                  <td>{!! $resposta["desejavel"] ? $resposta["desejavel"] : '-' !!}</td>
                  <td>{{ $resposta["obs"] ? $resposta["obs"] : '-' }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <table class="table">
            <thead>
              <tr>
                <th class="fw-bold text-white" style="background-color: black">Controle</th>
                <th class="fw-bold text-white" style="background-color: black">Status Atual</th>
                <th class="fw-bold text-white" style="background-color: black">Nível de Atenção</th>
                <th class="fw-bold text-white" style="background-color: black">Análise</th>
              </tr>
            </thead>
            <tbody>
              @foreach($respostas[$key] as $resposta)
                <tr>
                  <td style="width: 50%">{{ $resposta["controle"] ? $resposta["controle"] : '-' }}</td>
                  <td>{!! $resposta["status"] ? $resposta["status"] : '-' !!}</td>
                  <td>{!! $resposta["nivel"] ? $resposta["nivel"] : '-' !!}</td>
                  <td>{{ $resposta["obs"] ? $resposta["obs"] : '-' }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      @endif

      @if($estrutura['tipo'] == 'map answer')
        @if(isset($estrutura['filtro']))
            <div style="margin-top: 20px;">
              @foreach($respostas[$key] as $rKey => $resposta)
                <p style="font-size:12px; font-weight: bold">{{$rKey}}</p>
                <ul>
                  @foreach($resposta as $r)
                    <li>{{$r}}</li>
                  @endforeach
                </ul>
              @endforeach
            </div>
        @else
          <ul>
            @foreach($respostas[$key] as $resposta)
              <li><p>{{$resposta}}</p></li>
            @endforeach
          </ul>
        @endif
      @endif

      @if($estrutura['tipo'] == 'setores')
        <ul>
          @foreach($relatorio->setores as $setor)
            <li><p>{{$setor}}</p></li>
          @endforeach
        </ul>
      @endif

      @if($estrutura['tipo'] == 'areas')
        <ul>
          @foreach($relatorio->areas as $area)
            <li><p>{{$area}}</p></li>
          @endforeach
        </ul>
      @endif

      @if($estrutura['tipo'] == 'atividades')
        <ul>
          @foreach($relatorio->atividades as $atividade)
            <li><p>{{$atividade}}</p></li>
          @endforeach
        </ul>
      @endif

      @if($estrutura['tipo'] == 'graphic')
        @php
        $chartConfig = "
        {
          type: '".$respostas[$key]["tipo"]."',
          data: {
            labels: [".$respostas[$key]["labels"]."],
            datasets: [{
              label: '".$respostas[$key]["nome"]."',
              data: [".$respostas[$key]["data"]."],
            }]
          },
          options: {
            indexAxis: '".$respostas[$key]["axis"]."',
            scales: {
              y: {
                beginAtZero: true
              }
            },
          }
        }
        ";
        $chartUrl = 'https://quickchart.io/chart?w=600&h=300&c=' . urlencode($chartConfig);
        @endphp
      
        <img src="{{$chartUrl}}" alt="">      
      @endif

      @if(!$loop->last)
        <hr>
      @endif
    @endforeach
  @endif

  <div id="space-100px"></div>
  <div id="space-20px"></div>
  <div style="width: 100%; text-align:center; font-size: 13px">
    ______________________________________________________________
    <div id="space-10px"></div>
    {{$relatorio->assinante}}
  </div>

  <div id="space-20px"></div>

  <div style="text-align: center; font-size: 13px">Data: {{date('d/m/Y')}}</div>

</body>
</html>
