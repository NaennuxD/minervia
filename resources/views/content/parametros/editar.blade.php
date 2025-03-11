@extends('layouts/contentNavbarLayout', ["container" => "container-xxl m-w-950"])
@section('title', 'Editar Parâmetro')
@section('content')

<style>
.container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
  max-width: 1400px;
}
</style>

<div class="row py-3 mb-5">
  <div class="col-12 p-xl-0 align-items-center d-flex">

    <a href="/parametros" class="mt-1 me-4">
      <img src="{{asset('assets/img/back.png')}}" style="width: 30px" alt="Voltar">
    </a>

    <h1 class="fw-light m-0 text-dark">
      Editar Parâmetro
    </h1>
  </div>
</div>

@include('_partials.errors')

<form action="" autocomplete="off" class="mb-5" method="POST">
  @csrf
  <h5>Preencha os campos abaixo:</h5>
  
  <input type="hidden" name="parametro_id" value="{{$parametro->id}}">

  <div class="card mb-4 col-12">
    <div class="card-body">
      <div class="row">
        <div class="col-xl-12 col-md-4 col-12 mb-4">
          <div class="form-group">
            <label for="data" class="form-label">Data<span class="text-danger">*</span></label>
            <input type="text" name="data" id="data" value="{{$parametro->data}}" required class="form-control @error('data') is-invalid @enderror" />
          </div>
        </div>
        <div class="col-xl-12 col-md-4 col-12 mb-4 mb-xl-0">
          <div class="form-group">
            <label for="value" class="form-label">Value<span class="text-danger">*</span></label>
            <textarea name="value" id="value" cols="30" rows="10" required class="form-control @error('value') is-invalid @enderror">{{$parametro->value}}</textarea>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-auto d-flex justify-content-start">
      <a href="/parametros" class="btn btn-outline-secondary me-4">Cancelar</a>
      <input type="submit" class="btn btn-primary" value="Atualizar" />
    </div>
  </div>
</form>

@endsection