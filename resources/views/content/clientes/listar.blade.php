@extends('layouts/contentNavbarLayout', ["container" => "container-xxl col-xl-8 col-12"])
@section('title', '('.count($clientes).') Clientes')
@section('content')

@include('_partials.styles.custom-container')
@include('_partials.titles.list', ["title" => "Clientes", "count" => count($clientes), "url" => "/cliente/adicionar"])
@include('_partials.errors')

@if(!count($clientes))
  <div class="alert alert-dark" role="alert">
    <ul class="list-unstyled m-0">
      <li>Você não inseriu clientes ainda.</li>
    </ul>
  </div>
@else
  <div class="table-responsive text-nowrap table-escala">
    <table class="table table-bordered table-sm table-hover table-striped">
      <thead class="table-dark">
        <tr>
          <th class="text-white">Nome</th>
          <th class="text-white">Telefone</th>
          <th class="text-white">Indicador</th>
          <th class="text-white">Projetos</th>
          <th class="text-white">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($clientes as $cliente)
          <tr>
            <td>{{$cliente->name}}</td>
            <td>{{$cliente->telefone}}</td>
            <td><span class="badge badge-primary">{{$cliente->indicador}}</span></td>
            <td>
              @if(count($cliente->projetos))
                <a href="/projetos/cliente/{{$cliente->id}}">Listar ({{count($cliente->projetos)}}) <i class="bx bx-link-external"></i></a>
              @else
                -
              @endif
            </td>
            <td class="d-flex">
              <a href="cliente/{{$cliente->id}}/edit">
                <img src="{{asset('assets/img/edit.png')}}" alt="Editar" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Editar cliente" style="width: 21px" />
              </a>

              <form action="cliente/{{$cliente->id}}/delete" method="POST">
                @csrf
                <button type="submit" onclick="if(!confirm('Deseja realmente fazer isso?')){ return false }" class="border-0 p-0 ms-2 bg-transparent" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Excluir">
                  <img src="{{asset('assets/img/delete.png')}}" alt="Excluir" class="rounded-circle" style="width: 20px" />
                </button>
              </form>
            </td>
          </tr>

        @endforeach
        
      </tbody>
    </table>
  </div>
@endif

@endsection