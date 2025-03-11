@extends('layouts/contentNavbarLayout', ["container" => "container-xxl m-w-950"])
@section('title', '('.count($parametros).') Parâmetros')
@section('content')

<style>
.container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
  max-width: 1400px;
}
</style>

<div class="row py-3 mb-4">
  <div class="col-auto">
    <h1 class="fw-light m-0 text-dark">
      Parâmetros ({{count($parametros)}})
    </h1>
  </div>
  <div class="col">
    <a href="/parametro/adicionar" class="btn btn-primary"> <i class="bx bx-plus"></i> Adicionar novo</a>
  </div>
</div>

@include('_partials.errors')

@if(!count($parametros))
  <div class="alert alert-dark" role="alert">
    <ul class="list-unstyled m-0">
      <li>Você não inseriu parametros ainda.</li>
    </ul>
  </div>
@else
  <div class="table-responsive text-nowrap table-escala">
    <table class="table table-bordered table-sm table-hover table-striped">
      <thead class="table-dark">
        <tr>
          <th class="text-white">Data</th>
          <th class="text-white">Value</th>
          <th class="text-white">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($parametros as $parametro)
          <tr>
            <td>{{$parametro->data}}</td>
            <td>{{$parametro->value}}</td>
            <td class="d-flex">
              <a href="parametro/{{$parametro->id}}/editar">
                <img src="{{asset('assets/img/edit.png')}}" alt="Editar" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Editar" style="width: 21px" />
              </a>

              <form action="parametro/{{$parametro->id}}/deletar" method="POST">
                @csrf
                <input type="hidden" name="parametro_id" value="{{$parametro->id}}">
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