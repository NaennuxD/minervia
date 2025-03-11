@extends('layouts/contentNavbarLayout', ["container" => "container-xxl col-12 m-w-1220"])
@section('title', '('.count($mapeamentos).') Mapeamentos')
@section('content')

@php
$company_name = "";
$company_url = "";

if(isset($empresa)){
  $company_name = "Empresa: ".$empresa->company_name;
  $company_url = "?empresa_id=".$empresa->id;
}

$mapeamentosEncoded = json_encode($mapeamentos);
@endphp

<script>
  {!!"var mapeamentos = ". $mapeamentosEncoded!!}
</script>

@include('_partials.styles.custom-container')

@if($is_historic)
  <div class="row py-3 mb-5">
    <div class="col-12 p-xl-0 col-xl-12 align-items-center d-flex">
      <a href="/mapeamentos" class="mt-1 me-4">
        <img src="{{asset('assets/img/back.png')}}" style="width: 30px" alt="Voltar">
      </a>
  
      <h1 class="fw-light m-0 text-dark">
        Histórico de Mapeamentos
      </h1>
    </div>
  </div>
@else
  <div class="row py-3 mb-5">
    <div class="col-auto">
      <h1 class="fw-light m-0 text-dark">
        Mapeamentos (<span class="number-of-maps">{{count($mapeamentos)}}</span>)
      </h1>
    </div>
    @if(Auth::user()->funcao != 'operador')
      <div class="col">
        <a href="/mapeamento/adicionar" class="btn btn-primary"> <i class="bx bx-plus"></i> Adicionar novo</a>
      </div>
    @endif
  </div>
@endif

@include('_partials.errors')

<div class="row mb-5">
  <div class="col-xl-12 col-12">
    <div class="card">
      <h5 class="card-header">Filtro de dados</h5>
      <div class="card-body row">
        <div class="form-group col-12 mb-3 mb-xl-0">
          {{-- <label for="filter" class="form-label">Nome:</label> --}}
          <input type="text" id="filter" name="filter" class="form-control" placeholder="Pesquise pelo setor, atividade, área, nome do entrevistado e status. Ex: aprovado, 2023">
        </div>
      </div>
    </div>
  </div>
</div>

<div class="badge badge-warning ms-0 mb-3">{!!$company_name!!}</div>

@if(!count($mapeamentos))
<div class="alert alert-dark" role="alert">
  <ul class="list-unstyled m-0">
    <li>Nenhuma mapeamento encontrada. <a href="/mapeamento/adicionar{{$company_url}}">Clique aqui para adicionar</a>.</li>
  </ul>
</div>
@else
  <div class="table-responsive text-nowrap table-escala">
    <table class="table table-bordered table-sm table-hover table-striped">
      <thead class="table-dark">
        <tr>
          <th class="text-white">Setor</th>
          <th class="text-white">Área</th>
          <th class="text-white">Atividade de Tratamento</th>
          <th class="text-white">Entrevistado</th>
          <th class="text-white">Status</th>
          <th class="text-white">Data criação</th>
          <th class="text-white">Ações</th>
        </tr>
      </thead>
      <tbody id="mapeamentos">
        @foreach ($mapeamentos as $mapeamento)
          <tr>
            <td>
              {{$mapeamento->setor}}
              {!!$is_historic && $loop->last ? '<span class="badge bg-primary text-white">Último</span>' : ''!!}
            </td>
            <td>
              {{$mapeamento->nome_area}}
            </td>
            <td>
              {{$mapeamento->atividade_tratamento}}
            </td>
            <td>
              {{$mapeamento->nome_entrevistado}}
            </td>
            <td>
              <span class="badge badge-{{$mapeamento->status_cor}} fs-6 fw-semibold">{{$mapeamento->status}}</span>
            </td>
            <td>
              {{$mapeamento->data_criacao}}
            </td>
            <td class="d-flex">
              @if(!isset($mapeamento->dados))
                <a href="/mapeamento/{{$mapeamento->id}}/mapa/adicionar">
                  <img src="{{ asset('assets/img/create.png') }}" alt="Criar" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Criar" style="width: 21px" data-bs-original-title="" title="">
                </a>
              @else
                <a href="/mapeamento/{{$mapeamento->id}}/mapa/editar">
                  <img src="{{ asset('assets/img/edit.png') }}" alt="Editar mapeamento" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Editar mapeamento" style="width: 21px" data-bs-original-title="" title="">
                </a>
              @endif
              
              @if(Auth::user()->funcao != 'operador')
                <form action="/mapeamento/{{$mapeamento->id}}/deletar?is_parent={{$mapeamento->parent_id != null ? 'true' : 'false'}}" method="POST">
                  @csrf
                  <input type="hidden" name="mapeamento_id" value="{{$mapeamento->id}}">
                  <input type="hidden" name="mapa_id" value="{{$mapeamento->mapa_id}}">
                  <button type="submit" onclick="if(!confirm('Deseja realmente fazer isso?')){ return false }" class="border-0 p-0 ms-2 bg-transparent" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Excluir" data-bs-original-title="" title="">
                    <img src="{{ asset('assets/img/delete.png') }}" alt="Excluir" class="rounded-circle" style="width: 20px">
                  </button>
                </form>
              @endif
            </td>
          </tr>
        @endforeach
        
      </tbody>
    </table>
  </div>
@endif

<script>
  let numberOfMaps = $(".number-of-maps")
  let table = $('#mapeamentos')
  let filter = document.getElementById("filter")
  
  $(filter).keyup(function(e){
    let value = e.target.value
    let dataFiltered = []

    if(value.length === 0){
      dataFiltered = mapeamentos
    }

    let valuesArray = value.split(', ');

    dataFiltered = mapeamentos.filter((data) => {
      return valuesArray.every((val) => {
        return data.atividade_tratamento.toLowerCase().includes(val.toLowerCase()) || data.data_criacao.toLowerCase().includes(val.toLowerCase()) || data.dados.toLowerCase().includes(val.toLowerCase()) || data.atividade_tratamento != null && data.atividade_tratamento.toLowerCase().includes(val.toLowerCase()) || data.nome_area != null && data.nome_area.toLowerCase().includes(val.toLowerCase()) || data.nome_entrevistado != null && data.nome_entrevistado.toLowerCase().includes(val.toLowerCase()) || data.setor != null && data.setor.toLowerCase().includes(val.toLowerCase()) || data.status != null && data.status.toLowerCase().includes(val.toLowerCase())
      });
    });

    if(dataFiltered.length > 0){
      $(numberOfMaps).html(dataFiltered.length)

      $(table).html("")
    
      dataFiltered.forEach(data => {
        $(table).append(`
          <tr>
            <td>
              ${data.setor}
            </td>
            <td>
              ${data.nome_area}
            </td>
            <td>
              ${data.atividade_tratamento}
            </td>
            <td>
              ${data.nome_entrevistado}
            </td>
            <td>
              <span class="badge badge-${data.status_cor} fs-6 fw-semibold">${data.status}</span>
            </td>
            <td>
              ${data.data_criacao}
            </td>
            <td class="d-flex">
              @if(!isset($mapeamento->dados))
                <a href="/mapeamento/${data.id}/mapa/adicionar">
                  <img src="{{ asset('assets/img/create.png') }}" alt="Criar" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Criar" style="width: 21px" data-bs-original-title="" title="">
                </a>
              @else
                <a href="/mapeamento/${data.id}/mapa/editar">
                  <img src="{{ asset('assets/img/edit.png') }}" alt="Editar mapeamento" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Editar mapeamento" style="width: 21px" data-bs-original-title="" title="">
                </a>
              @endif
              <form action="/mapeamento/${data.id}/deletar?is_parent=${data.parent_id!= null ? 'true' : 'false'}}" method="POST">
                @csrf
                <input type="hidden" name="mapeamento_id" value="${data.id}">
                <input type="hidden" name="mapa_id" value="${data.mapa_id}">
                <button type="submit" onclick="if(!confirm('Deseja realmente fazer isso?')){ return false }" class="border-0 p-0 ms-2 bg-transparent" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Excluir" data-bs-original-title="" title="">
                  <img src="{{ asset('assets/img/delete.png') }}" alt="Excluir" class="rounded-circle" style="width: 20px">
                </button>
              </form>
            </td>
          </tr>

        `);   
      });
    }else{
      $(table).html("<p class='m-2'>Nenhum resultado encontrado</p>").addClass('is-empty')
    }
  })
</script>

@endsection