@extends('layouts/contentNavbarLayout', ["container" => "container-xxl m-w-950"])
@section('title', 'Adicionar Gráfico')
@section('content')

<style>
.container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
  max-width: 1400px;
}
</style>

<div class="row py-3 mb-5">
  <div class="col-12 p-xl-0 col-xl-5 align-items-center d-flex">

    <a href="{{ url()->previous() }}" class="mt-1 me-4">
      <img src="{{asset('assets/img/back.png')}}" style="width: 30px" alt="Voltar">
    </a>

    <h1 class="fw-light m-0 text-dark">
      Adicionar Gráfico
    </h1>
  </div>
</div>

@include('_partials.errors')

<form action="" autocomplete="off" method="POST">
  @csrf
  <h5>Preencha os campos abaixo:</h5>
  <div class="card mb-4 col-12">
    <div class="card-body">
      <div class="row">
        <div class="col-xl-3 col-md-4 col-12 mb-4 mb-xl-0">
          <div class="form-group">
            <label for="nome" class="form-label">Nome<span class="text-danger">*</span></label>
            <input type="text" name="nome" id="nome" value="{{@old('nome')}}" required class="form-control @error('nome') is-invalid @enderror" />
          </div>
        </div>
        <div class="col-xl-3 col-12 mb-4">
          <div class="form-group">
            <label for="tipo" class="form-label">Tipo<span class="text-danger">*</span></label>
            <select name="tipo" class="form-select" id="tipo">
              <option {{@old('tipo') == 'bar_h' ? 'selected=""' : ''}} value="bar_h">Barra Horizontal</option>
              <option {{@old('tipo') == 'bar' ? 'selected=""' : ''}} value="bar">Barra Vertical</option>
              <option {{@old('tipo') == 'pie' ? 'selected=""' : ''}} value="pie">Pizza</option>
              <option {{@old('tipo') == 'line' ? 'selected=""' : ''}} value="line">Linha</option>
              <option {{@old('tipo') == 'polarArea' ? 'selected=""' : ''}} value="polarArea">Área Polar</option>
              <option {{@old('tipo') == 'bubble' ? 'selected=""' : ''}} value="bubble">bubble</option>
              <option {{@old('tipo') == 'doughnut' ? 'selected=""' : ''}} value="doughnut">doughnut</option>
            </select>
          </div>
        </div>
        <div class="col-xl-6 col-12 mb-4">
          <div class="form-group">
            <label for="parametros" class="form-label">Parâmetro<span class="text-danger">*</span></label>
            <select name="parametros" id="parametros" class="form-select">
              @foreach ($stepKeys as $step)
                  <option value="{{$step["slug"]}}">{{$step["name"]}}</option>
                @if(isset($step["subitems"]))
                  <optgroup label="Subitems de {{$step["name"]}}">
                  @foreach ($step["subitems"] as $subitem)
                    <option value="{{$subitem["slug"]}}">{{$subitem["name"]}}</option>
                  @endforeach
                  </optgroup>
                @endif
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-xl-6 col-12 mb-4">
          <div class="form-group">
            <label for="setores" class="form-label">Setores<span class="text-danger">*</span></label>
            <select name="setores[]" required id="setores" class="form-select" multiple>
              @foreach($setores as $setor)
                <option value="{{$setor}}">{{$setor}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-xl-6 col-12 mb-4">
          <div class="form-group">
            <label for="areas" class="form-label">Áreas<span class="text-danger">*</span></label>
            <select name="areas[]" required id="areas" class="form-select" multiple>
              @foreach($areas as $area)
                <option value="{{$area}}">{{$area}}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-auto d-flex justify-content-start">
      <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-4">Cancelar</a>
      <input type="submit" class="btn btn-primary" value="Adicionar" />
    </div>
  </div>

</form>
@endsection