@extends('layouts/contentNavbarLayout', ["container" => "container-xxl col-12 m-w-1220"])
@section('title', '('.count($empresas).') Empresas')
@section('content')

@include('_partials.styles.custom-container')
@include('_partials.titles.list', ["title" => "Empresas", "count" => count($empresas), "url" => "/empresa/adicionar"])
@include('_partials.errors')

@if(!empty(request('status')) && request('status') == 'select')
  <div class="alert alert-danger" role="alert">
    <p class="m-0 fw-bold mb-1">Acesse uma empresa para continuar navegando.</p>
    <p class="m-0">Clique em "Acessar" na aba "Gerenciar".</p>
  </div>
@endif

@if(!count($empresas))
<div class="alert alert-dark" role="alert">
  <ul class="list-unstyled m-0">
    <li>Nenhuma empresa encontrada. <a href="/empresa/adicionar">Clique aqui para adicionar</a>.</li>
  </ul>
</div>
@else
  <div class="table-responsive text-nowrap table-escala">
    <table class="table table-bordered table-sm table-hover table-striped">
      <thead class="table-dark">
        <tr>
          <th class="text-white">Empresa</th>
          <th class="text-white">Cidade</th>
          <th class="text-white">Agente de tratamento</th>
          <th class="text-white">Encarregado</th>
          {{-- <th class="text-white">Tipo de Agente de Tratamento</th> --}}
          <th class="text-white">Gerenciar</th>
          <th class="text-white">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($empresas as $empresa)
          <tr>
            <td>
              <div class="d-flex align-items-center">
                {{$empresa->company_name}}
                @if($empresa->status == 'active')
                  <div class="badge bg-success text-white">Ativo</div>
                @else
                  <div class="badge bg-danger text-white">Inativo</div>
                @endif
              </div>
            </td>
            <td>
              {{$empresa->city}}/{{$empresa->state}}
            </td>
            <td>
              {{$empresa->agente_tratamento}}
            </td>
            <td>
              {{$empresa->encarregado}}
            </td>
            {{-- <td>
              {{$empresa->tipo_agente}}
            </td> --}}
            <td>
              <a class="btn btn-primary btn-sm" href="/configurar/empresa/{{$empresa->id}}{{ (request('redirectTo')) ? "?redirectTo=".request('redirectTo') : "" }}">Acessar &#10142;</a>
            </td>
            <td class="d-flex">
              <a href="/empresa/{{$empresa->id}}/editar">
                <img src="{{ asset('assets/img/edit.png') }}" alt="Editar" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Editar" style="width: 21px" data-bs-original-title="" title="">
              </a>
              
              @if(Auth::user()->funcao != 'operador')
                <form action="/empresa/{{$empresa->id}}/deletar" method="POST">
                  @csrf
                  <input type="hidden" name="lote_id" value="{{$empresa->id}}">
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

@endsection