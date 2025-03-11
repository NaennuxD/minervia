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
            @switch(session('status'))
              @case('passwords.throttled')
                <div class="alert alert-danger">
                  Você solicitou a redefinição de senha recentemente, verifique seu e-mail.
                </div>
                @break

                @case('passwords.sent')
                <div class="alert alert-success">
                  Enviamos um email com um link de redefinição de senha. Caso não o encontre, verifique seu Lixo Eletrônico ou Caixa de Spam.
                </div>
                @break

              @default
                <div class="alert alert-success">
                  {{ session('status') }}
                </div>        
            @endswitch
          @endif

          @if($errors->any())
            <div class="alert alert-danger" role="alert">
              <ul class="list-unstyled m-0">
                @foreach($errors->all() as $error)
                  <li> {{ $error === 'passwords.throttled' ? 'Você solicitou a redefinição de senha recentemente, verifique seu e-mail.' : $error}} </li>
                @endforeach
              </ul>
            </div>
          @endif

          <!-- /Logo -->
          <h5 class="mb-4 fw-normal text-dark text-center">Esqueceu sua senha?</h5>
          <p class="mb-4 text-center">Informe seu e-mail e nós enviaremos instruções para resetar sua senha</p>

          <form id="formAuthentication" class="mb-3" action="{{route('password-email')}}" method="POST">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} mb-3">
              <label for="email" class="form-label">E-mail</label>
              <input type="email" value="{{ old('email') }}" class="form-control" id="email" name="email" placeholder="Informe seu e-mail" autofocus>
            </div>

            <input type="submit" value="Enviar link de recuperação" class="btn btn-primary mt-4 d-grid w-100" />
          </form>

          <div class="text-center">
            <a href="{{route('login')}}" class="btn-link">
              Voltar ao login
            </a>
          </div>
        </div>
      </div>
      <!-- /Forgot Password -->
    </div>
  </div>
</div>
@endsection
