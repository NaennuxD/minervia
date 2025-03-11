@extends('layouts/contentNavbarLayout', ["container" => "container-xxl col-xl-10 col-12 m-w-950"])
@section('title', 'Adicionar Cliente')
@section('content')

@include('_partials.styles.custom-container')
@include('_partials.titles.add-edit', ["title" => "Adicionar Cliente"])
@include('_partials.errors')

<form action="" autocomplete="off" method="POST">
  @csrf
  <input type="hidden" name="return_url" value="{{request('returnUrl')}}">

  <h5>Preencha todos os campos abaixo:</h5>
  <div class="card mb-4 col-12">
    <h5 class="card-header">Informações pessoais:</h5>
    <div class="card-body">
      <div class="row">
        <div class="col-xl-4 col-md-4 col-12 mb-4 mb-xl-0">
          <div class="form-group">
            <label for="name" class="form-label">Nome completo<span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" value="{{@old('name')}}" required class="form-control @error('name') is-invalid @enderror" />
          </div>
        </div>
        <div class="col-xl-3 col-12 mb-4 mb-xl-0">
          <div class="form-group">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" name="cpf" id="cpf" value="{{@old('cpf')}}" class="form-control @error('cpf') is-invalid @enderror" />
          </div>
        </div>
        <div class="col-xl-3 col-12 mb-4 mb-xl-0">
          <div class="form-group">
            <label for="telefone" class="form-label">Telefone<span class="text-danger">*</span></label>
            <input type="text" name="telefone" id="telefone" value="{{@old('telefone')}}" required class="form-control @error('telefone') is-invalid @enderror" />
          </div>
        </div>
      </div>
    </div>
    <hr>
    <h5 class="card-header">Dados de acesso:</h5>
    <div class="card-body">
      <div class="row">
        <div class="col-xl-3 col-12 mb-4 mb-xl-0">
          <div class="form-group">
            <label for="email" class="form-label">E-mail de acesso<span class="text-danger">*</span></label>
            <input type="text" name="email" id="email" value="{{@old('email')}}" required class="form-control @error('email') is-invalid @enderror" />
          </div>
        </div>
        <div class="col-xl-5 col-12 mb-4 mb-xl-0">
          <div class="form-group">
            <label for="password" class="form-label">Senha de acesso<span class="text-danger">*</span></label>
            <div class="d-flex align-items-center">
              <input type="text" name="password" id="password" value="{{@old('password')}}" required class="form-control @error('password') is-invalid @enderror me-3"> <button type="button" onclick="generatePassword()" style="width:180px" class="btn btn-outline-primary">Gerar senha</button>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-12 mb-4 mb-xl-0">
          <div class="form-group">
            <label for="funcao" class="form-label">Função<span class="text-danger">*</span></label>
            <select name="funcao" class="form-select" readonly="true" id="funcao">
              <option value="cliente">Cliente</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <h5 class="card-header">Informações diversas:</h5>
    <div class="card-body">
      <div class="row">
        <div class="col-12 mb-4 mb-xl-0">
          <div class="form-group">
            <label for="indicador" class="form-label">Indicador</label>
            <textarea rows="2" name="indicador" id="indicador" class="form-control @error('indicador') is-invalid @enderror">{{@old('indicador')}}</textarea>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-auto d-flex justify-content-start">
      <a href="javascript:history.back(-1)" class="btn btn-outline-secondary me-4">Cancelar</a>
      <input type="submit" class="btn btn-primary" value="Adicionar" />
    </div>
  </div>

</form>

@include('_partials.scripts.generate-password')
@include('_partials.scripts.masks')

<script>
$(document).ready(function(){
  generatePassword()
})
</script>

@endsection