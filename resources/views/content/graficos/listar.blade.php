@extends('layouts/contentNavbarLayout', ["container" => "container-xxl col-xl-10 col-12"])
@section('title', '('.$graficos->total().') Gráficos')
@section('content')

<style>
.container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
  max-width: 1400px;
}
</style>

<div class="row py-3 mb-5">
  <div class="col-auto">
    <h1 class="fw-light m-0 text-dark">
      Gráficos ({{$graficos->total()}})
    </h1>
  </div>
  <div class="col">
    <a href="/grafico/adicionar" class="btn btn-primary"> <i class="bx bx-plus"></i> Adicionar novo</a>
  </div>
</div>

@include('_partials.errors')

@if(!count($graficos))
  <div class="alert alert-dark" role="alert">
    <ul class="list-unstyled m-0">
      <li>Você não inseriu graficos ainda.</li>
    </ul>
  </div>
@else
  <div class="table-responsive text-nowrap table-escala">
    <table class="table table-bordered table-sm table-hover table-striped">
      <thead class="table-dark">
        <tr>
          <th class="text-white">Nome</th>
          <th class="text-white">Tipo</th>
          <th class="text-white">Parâmetro</th>
          <th class="text-white">Setores</th>
          <th class="text-white">Áreas</th>
          <th class="text-white">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($graficos as $grafico)
          <tr>
            <td>{{$grafico->nome}}</td>
            <td>{{$grafico->tipo}}</td>
            <td>{{$grafico->parametros}}</td>
            <td>{{$grafico->setores ? $grafico->setores : 'Todos'}}</td>
            <td>{{$grafico->areas ? $grafico->areas : 'Todos'}}</td>
            <td class="d-flex">
              <a href="grafico/{{$grafico->id}}/editar">
                <img src="{{asset('assets/img/edit.png')}}" alt="Editar" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Editar" style="width: 21px" />
              </a>

              <form action="grafico/{{$grafico->id}}/deletar" method="POST">
                @csrf
                <input type="hidden" name="grafico_id" value="{{$grafico->id}}">
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

  @if($graficos->hasPages())
    <div class="mt-2 pagination">
      {{$graficos->links()}}
    </div>
  @endif
@endif

@endsection