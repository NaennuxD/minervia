@extends('layouts/contentNavbarLayout', ["container" => "container-xxl m-w-950"])
@section('title', 'Gráfico: '.$grafico->nome)
@section('content')

<style>
.container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
  max-width: 1400px;
}
</style>

<div class="row py-3 mb-5">
  <div class="col-12 p-xl-0 align-items-center d-flex">

    <a href="{{ url()->previous() }}" class="mt-1 me-4">
      <img src="{{asset('assets/img/back.png')}}" style="width: 30px" alt="Voltar">
    </a>

    <h1 class="fw-light m-0 text-dark">
      Gráfico: {{$grafico->nome}}
    </h1>
  </div>
</div>

<h5>Visualizar:</h5>
<div class="card">
  <div class="card-body">
    <canvas id="chart_id_{{$grafico->id}}"></canvas>
  </div>
</div>

@include('content.graficos.render_chart');
@endsection