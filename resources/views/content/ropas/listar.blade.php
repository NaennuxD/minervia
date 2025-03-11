@extends('layouts/contentNavbarLayout', ["container" => "container-xxl col-12 m-w-1220"])
@section('title', '('.$ropas->total().') ROPA')
@section('content')

<style>
.container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
  max-width: 1400px;
}
</style>

<div class="row py-3 mb-5">
  <div class="col-auto">
    <h1 class="fw-light m-0 text-dark">
      ROPA ({{$ropas->total()}})
    </h1>
  </div>
  <div class="col">
    <a href="/ropa/adicionar" class="btn btn-primary"> <i class="bx bx-plus"></i> Adicionar novo</a>
  </div>
</div>

@include('_partials.errors')

@if(!count($ropas))
  <div class="alert alert-dark" role="alert">
    <ul class="list-unstyled m-0">
      <li>Você não inseriu ROPA ainda.</li>
    </ul>
  </div>
@else
  <div class="table-responsive text-nowrap">
    <table class="table table-bordered table-sm table-hover table-striped">
      <thead class="table-dark">
        <tr>
          <th class="text-white">Ações</th>
          <th class="text-white">ROPA</th>
          <th class="text-white">Descrição</th>
          {{-- <th class="text-white">Perguntas</th> --}}
        </tr>
      </thead>
      <tbody>
        @foreach ($ropas as $ropa)
          <tr>
            <td class="d-flex">
              <a href="ropa/{{$ropa->id}}/editar">
                <img src="{{asset('assets/img/edit.png')}}" alt="Editar" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Editar" style="width: 21px" />
              </a>

              <form action="ropa/{{$ropa->id}}/deletar" method="POST">
                @csrf
                <input type="hidden" name="ropa_id" value="{{$ropa->id}}">
                <button type="submit" onclick="if(!confirm('Deseja realmente fazer isso?')){ return false }" class="border-0 p-0 ms-2 bg-transparent" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Excluir">
                  <img src="{{asset('assets/img/delete.png')}}" alt="Deletar" class="rounded-circle" style="width: 20px" />
                </button>
              </form>
            </td>
            <td>
              <a href="ropa/{{$ropa->id}}/visualizar">Visualizar <i class="bx bx-link-external"></i></a>
            </td>
            <td>{{$ropa->descricao}}</td>
            {{-- <td>{{$ropa->perguntas}}</td> --}}
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  @if($ropas->hasPages())
    <div class="mt-2 pagination">
      {{$ropas->links()}}
    </div>
  @endif
@endif

@endsection