@extends('layouts/contentNavbarLayout', ["container" => "container-xxl col-xl-10 col-12"])
@section('title', '('.$politicas->count().') Gestão de Políticas e Procedimentos')
@section('content')

<style>
.container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
  max-width: 1400px;
}
</style>

<div class="row py-3 mb-5">
  <div class="col-auto">
    <h1 class="fw-light m-0 text-dark">
      Gestão de Políticas e Procedimentos ({{$politicas->count()}})
    </h1>
  </div>
  <div class="col">
    <a href="/politica/adicionar" class="btn btn-primary"> <i class="bx bx-plus"></i> Adicionar novo</a>
  </div>
</div>

@include('_partials.errors')

@if(!count($politicas))
  <div class="alert alert-dark" role="alert">
    <ul class="list-unstyled m-0">
      <li>Você não inseriu Gestão de Políticas e Procedimentos ainda.</li>
    </ul>
  </div>
@else
  <div class="table-responsive text-nowrap table-escala">
    <table class="table table-bordered table-sm table-hover table-striped">
      <thead class="table-dark">
        <tr>
          <th class="text-white">Descrição</th>
          <th class="text-white">Data criação</th>
          <th class="text-white">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($politicas as $politica)
          <tr>
            <td>{{$politica->descricao}}</td>
            <td>{{$politica->data_criacao}}</td>
            <td class="d-flex">
              <a href="/politica/{{$politica->id}}/configurar">
                <img src="{{asset('assets/img/edit.png')}}" alt="Editar" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Editar" style="width: 21px" />
              </a>

              <form action="/politica/{{$politica->id}}/deletar" method="POST">
                @csrf
                <input type="hidden" name="politicas_id" value="{{$politica->id}}">
                <button type="submit" onclick="if(!confirm('Deseja realmente fazer isso?')){ return false }" class="border-0 p-0 ms-2 bg-transparent" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Excluir">
                  <img src="{{asset('assets/img/delete.png')}}" alt="Deletar" class="rounded-circle" style="width: 20px" />
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