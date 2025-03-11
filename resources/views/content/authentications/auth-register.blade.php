@extends('layouts/blankLayout')

@section('title', 'Faça sua matrícula')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">

      <!-- Register Card -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{url('/')}}" class="">
              <div class="app-brand-logo demo">@include('_partials.macros',["color"=>"dark"])</div>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-3 text-center">Faça sua matrícula</h4>
          <p class="mb-4">Preencha os campos abaixo para efetuar com sua inscrição</p>

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

          @if(isset($erro))
            <p class="text-danger">{{$content}}</p>
          @endif

          <form id="formAuthentication" class="mb-3" action="{{route('new_register')}}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" required class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome') }}" placeholder="Joana" autofocus>
            </div>
            {{-- <div class="mb-3">
              <label for="sobrenome" class="form-label">Sobrenome</label>
              <input type="text" required class="form-control @error('sobrenome') is-invalid @enderror" id="sobrenome" name="sobrenome" value="{{ old('sobrenome') }}" placeholder="Ferreira" autofocus>
            </div>
            <div class="mb-3">
              <label for="modulo" class="form-label">Módulo</label>
              <select name="modulo" required id="modulo" class="form-control @error('modulo') is-invalid @enderror">
                <option value="1">Ministros</option>
                <option value="2">Mestres</option>
                <option value="3">Águias</option>
                <option value="4">Ministérios</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="whatsapp" class="form-label">Whatsapp</label>
              <input type="text" required class="form-control @error('whatsapp') is-invalid @enderror" id="whatsapp" value="{{ old('whatsapp') }}" name="whatsapp" placeholder="(62) 99123-4567">
            </div> --}}
            <div class="mb-3">
              <label for="email" class="form-label">E-mail</label>
              <input type="text" required class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" name="email" placeholder="joanaferreira@hotmail.com">
            </div>
            <div class="mb-3 form-password-toggle">
              <label class="form-label" for="password">Senha</label>
              <div class="input-group input-group-merge">
                <input type="password" id="password" required class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="mb-3 form-password-toggle">
              <label class="form-label" for="password_confirm">Repita a Senha</label>
              <div class="input-group input-group-merge">
                <input type="password" required id="password_confirm" value="{{ old('password_confirm') }}" class="form-control @error('password_confirm') is-invalid @enderror" name="password_confirm" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password_confirm" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>

            <button class="btn btn-primary d-grid w-100">
              Fazer matrícula
            </button>
          </form>

          <hr class="my-4">

          <p class="text-center">
            <span>Já tem uma matrícula?</span>
            <a href="{{route('login')}}">
              <span>Faça seu login</span>
            </a>
          </p>
        </div>
      </div>
    </div>
    <!-- Register Card -->
  </div>
</div>
</div>
@endsection
