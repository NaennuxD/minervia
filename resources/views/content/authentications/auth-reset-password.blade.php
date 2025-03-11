@extends('layouts/blankLayout')

@section('title', 'Recuperar senha')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-4">

      <!-- Forgot Password -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <div class="app-brand-logo demo">@include('_partials.macros',["color"=>"dark"])</div>
          </div>

          @if (session('status'))
            <div class="alert alert-success">
              {{ session('status') }}
            </div>
          @endif

          @if($errors->any())
          <div class="alert alert-danger" role="alert">
            <p class="m-0 fw-bold mb-1">Ops. Algo deu errado!</p>
            <ul class="list-unstyled m-0">
                @foreach($errors->all() as $error)
                <li> {{ $error }} </li>
                @endforeach
            </ul>
          </div>
        @endif

          <!-- /Logo -->
          <h5 class="mb-4 fw-normal text-dark text-center">Alterar senha de acesso</h5>
          <p class="mb-4 text-center">Preencha os campos abaixo para finalizar a alteração de sua senha</p>

          <form id="formAuthentication" class="mb-3" action="{{route('password-update')}}" method="POST">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} mb-3">
              <label for="email" class="form-label">E-mail</label>

              <div class="col">
                  <input id="email" type="email" class="form-control" readonly name="email" value="{{ $email }}" required>
              </div>
            </div>


            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} mb-3">
              <label for="password" class="form-label">Digite uma Senha</label>

              <div class="col">
                  <input id="password" type="password" class="form-control" name="password" required autofocus>

                  @if ($errors->has('password'))
                      <span class="help-block">
                          <strong>{{ $errors->first('password') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

          <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} mb-3">
              <label for="password-confirm" class="form-label">Confirme a Senha</label>
              <div class="col">
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                  @if ($errors->has('password_confirmation'))
                      <span class="help-block">
                          <strong>{{ $errors->first('password_confirmation') }}</strong>
                      </span>
                  @endif
              </div>
          </div>

            <input type="submit" value="Alterar senha" class="btn btn-primary d-grid w-100" />
          </form>

        </div>
      </div>
      <!-- /Forgot Password -->
    </div>
  </div>
</div>
@endsection
