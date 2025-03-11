@extends('layouts/contentNavbarLayout', ["container" => "container-xxl m-w-950"])
@section('title', 'Editar Gráfico')
@section('content')

<style>
.container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
  max-width: 1400px;
}
</style>

<div class="row py-3 mb-5">
  <div class="col-12 p-xl-0 align-items-center d-flex">

    <a href="/graficos" class="mt-1 me-4">
      <img src="{{asset('assets/img/back.png')}}" style="width: 30px" alt="Voltar">
    </a>

    <h1 class="fw-light m-0 text-dark">
      Editar Gráfico
    </h1>
  </div>
</div>

@include('_partials.errors')

<form action="" autocomplete="off" class="mb-5" method="POST">
  @csrf
  <h5>Preencha os campos abaixo:</h5>
  
  <input type="hidden" name="grafico_id" value="{{$grafico->id}}">

  <div class="card mb-4 col-12">
    <div class="card-body">
      <div class="row">
        <div class="col-xl-3 col-md-4 col-12 mb-4 mb-xl-0">
          <div class="form-group">
            <label for="name" class="form-label">Nome<span class="text-danger">*</span></label>
            <input type="text" name="nome" id="nome" value="{{$grafico->nome}}" required class="form-control @error('nome') is-invalid @enderror" />
          </div>
        </div>
        <div class="col-xl-3 col-12 mb-4">
          <div class="form-group">
            <label for="tipo" class="form-label">Tipo<span class="text-danger">*</span></label>
            <select name="tipo" class="form-select" id="tipo">
              <option {{$grafico->tipo == 'bar' && $grafico->axis == "y" ? 'selected=""' : ''}} value="bar_h">Barra Horizontal</option>
              <option {{$grafico->tipo == 'bar' && $grafico->axis == "x" ? 'selected=""' : ''}} value="bar">Barra Vertical</option>
              <option {{$grafico->tipo == 'pie' ? 'selected=""' : ''}} value="pie">Pizza</option>
              <option {{$grafico->tipo == 'line' ? 'selected=""' : ''}} value="line">Linha</option>
              <option {{$grafico->tipo == 'polarArea' ? 'selected=""' : ''}} value="polarArea">Área Polar</option>
              <option {{$grafico->tipo == 'bubble' ? 'selected=""' : ''}} value="bubble">bubble</option>
              <option {{$grafico->tipo == 'doughnut' ? 'selected=""' : ''}} value="doughnut">doughnut</option>
            </select>
          </div>
        </div>
        <div class="col-xl-6 col-12 mb-4">
          <div class="form-group">
            <label for="parametros" class="form-label">Parâmetro<span class="text-danger">*</span></label>
            <select name="parametros" id="parametros" class="form-select">
              @foreach ($stepKeys as $step)
                  <option {{$grafico->parametros == $step["slug"] ? 'selected=""' : ''}} value="{{$step["slug"]}}">{{$step["name"]}}</option>
                @if(isset($step["subitems"]))
                  <optgroup label="Subitems de {{$step["name"]}}">
                  @foreach ($step["subitems"] as $subitem)
                    <option {{$grafico->parametros == $subitem["slug"] ? 'selected=""' : ''}}  value="{{$subitem["slug"]}}">{{$subitem["name"]}}</option>
                  @endforeach
                  </optgroup>
                @endif
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-xl-6 col-12 mb-4">
          <div class="form-group">
            <label for="setores" class="form-label">Setores<span class="text-danger">*</span> <small>(Selecione apenas quando quiser alterar)</small></label>
            <select name="setores[]" id="setores" class="form-select" multiple>
              @foreach($setores as $setor)
                <option {{$setores && $grafico->setores && in_array($setor, $grafico->setores) ? 'selected' : ''}} value="{{$setor}}">{{$setor}}</option>
              @endforeach
            </select>
            {{-- <b>Atuais:</b> {{$grafico->setores_imploded ?? 'Todos'}} --}}
          </div>
        </div>
        <div class="col-xl-6 col-12 mb-4">
          <div class="form-group">
            <label for="areas" class="form-label">Áreas<span class="text-danger">*</span> <small>(Selecione apenas quando quiser alterar)</small></label>
            <select name="areas[]" id="areas" class="form-select" multiple>
              @foreach($areas as $area)
                <option {{$areas && $grafico->areas && in_array($area, $grafico->areas) ? 'selected' : ''}} value="{{$area}}">{{$area}}</option>
              @endforeach
            </select>
            {{-- <b>Atuais:</b> {{$grafico->areas_imploded ?? 'Todos'}} --}}
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-auto d-flex justify-content-start">
      <a href="/graficos" class="btn btn-outline-secondary me-4">Cancelar</a>
      <input type="submit" class="btn btn-primary" value="Atualizar" />
    </div>
  </div>

</form>

<h5>Visualizar:</h5>
<div class="card">
  <div class="card-body">
    <canvas id="chart_id_{{$grafico->id}}"></canvas>
  </div>
</div>

@include('content.graficos.render_chart')
@endsection