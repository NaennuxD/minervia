@extends('layouts/contentNavbarLayout', ["container" => "container-xxl m-w-950"])
@section('title', 'Editar usuário')
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
      Editar usuário
    </h1>
  </div>
</div>

@include('_partials.errors')

<form action="" autocomplete="off" method="POST">
  @csrf
  <h5>Preencha os campos abaixo:</h5>
  
  <input type="hidden" name="id" value="{{$usuario->id}}">

  <div class="card mb-4 col-12">
    <div class="card-body">
      <div class="row">
        <div class="col-xl-4 col-md-4 col-12 mb-4 mb-xl-0">
          <div class="form-group">
            <label for="name" class="form-label">Nome<span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" value="{{$usuario->name}}" required class="form-control @error('name') is-invalid @enderror" />
          </div>
        </div>
        <div class="col-xl-4 col-12 mb-4">
          <div class="form-group">
            <label for="funcao" class="form-label">Função<span class="text-danger">*</span></label>
            <select name="funcao" class="form-select" id="funcao">
              <option {{$usuario->funcao == 'administrador' ? 'selected=""' : ''}} value="administrador">Administrador</option>
              <option {{$usuario->funcao == 'aprovador' ? 'selected=""' : ''}} value="aprovador">Aprovador</option>
              <option {{$usuario->funcao == 'operador' ? 'selected=""' : ''}} value="operador">Operador</option>
            </select>
          </div>
        </div>
        <div class="col-xl-4 col-12 mb-4">
          <div class="form-group">
            <label for="status" class="form-label">Status<span class="text-danger">*</span></label>
            <select name="status" class="form-select" id="status">
              <option {{$usuario->status == 'Ativo' ? 'selected' : ''}} value="active">Ativo</option>
              <option {{$usuario->status == 'Inativo' ? 'selected' : ''}} value="inactive">Inativo</option>
            </select>
          </div>
        </div>
        <div class="col-xl-5 col-12 mb-4 mb-xl-0">
          <div class="form-group">
            <label for="email" class="form-label">E-mail de acesso<span class="text-danger">*</span></label>
            <input type="text" name="email" id="email" value="{{$usuario->email}}" required class="form-control @error('email') is-invalid @enderror" />
          </div>
        </div>
        <div class="col-xl-7 col-12 mb-4 mb-xl-0">
          <div class="form-group">
            <label for="password" class="form-label">Senha de acesso <small>(Deixe em branco caso não queira alterar)</small></label>
            <div class="d-flex align-items-center">
              <input type="text" name="password" id="password" class="form-control @error('password') is-invalid @enderror me-3"> <button type="button" onclick="generatePassword()" style="width:220px" class="btn btn-outline-primary">Gerar senha</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-auto d-flex justify-content-start">
      <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-4">Cancelar</a>
      <input type="submit" class="btn btn-primary" value="Atualizar" />
    </div>
  </div>

</form>

<script>
  function generatePassword() {
    var chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJLMNOPQRSTUVWXYZ@#$%&";
    var passwordLength = 16;
    var password = "";

    for (var i = 0; i < passwordLength; i++) {
      var randomNumber = Math.floor(Math.random() * chars.length);
      password += chars.substring(randomNumber, randomNumber + 1);
    }
    document.getElementById('password').value = password
  }
</script>

@endsection