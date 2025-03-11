@extends('layouts/contentNavbarLayout', ["container" => "container-xxl m-w-950"])
@section('title', 'ROPA: '.$ropa->descricao)
@section('content')

<style>
.container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
  max-width: 1400px;
}
</style>

<div class="row py-3 mb-5">
  <div class="col-12 p-xl-0 align-items-center d-flex">

    <a href="/ropas" class="mt-1 me-4">
      <img src="{{asset('assets/img/back.png')}}" style="width: 30px" alt="Voltar">
    </a>

    <h1 class="fw-light m-0 text-dark">
      ROPA: {{$ropa->descricao}}
    </h1>
  </div>
</div>

<div class="d-flex justify-content-between align-items-center">
  <h5>Visualizar:</h5>
  <a href="/ropa/{{$ropa->id}}/editar">Editar <i class="bx bx-link-external"></i></a>
</div>

<table class="table table-bordered table-sm table-hover table-striped">
  <thead class="table-dark">
    <tr>
      <th><b class="text-white">Perguntas</b></th>
      <th><b class="text-white">Respostas</b></th>
    </tr>
  </thead>

  <tbody>
    @foreach ($answers as $key => $answer)
      <tr>
        <td>{{$customStepKeys[$key]}}</td>
        <td>
          {!!$answer ? implode("<br>", $answer) : '-'!!}
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

@endsection