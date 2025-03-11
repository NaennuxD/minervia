@extends('layouts/blankLayout')

@section('title', 'Acesse sua conta')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <div class="app-brand-logo demo">@include('_partials.macros',["color"=>"dark"])</div>
          </div>
          <!-- /Logo -->
          <h5 class="mb-4 fw-normal text-dark text-center">Acesse sua conta</h5>

          @if (session('status'))
            @switch(session('status'))
              @case('passwords.reset')
                <div class="alert alert-success">
                  Sua senha foi alterada com sucesso!
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
              <p class="m-0 fw-bold mb-1">Ops. Algo deu errado!</p>
              <ul class="list-unstyled m-0">
                  @foreach($errors->all() as $error)
                  <li> {{ $error }} </li>
                  @endforeach
              </ul>
            </div>
          @endif

          <form id="formAuthentication" class="mb-3" action="{{route('auth')}}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">E-mail</label>
              <input type="text" required class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" name="email" placeholder="E-mail" autofocus>
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Senha</label>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" required id="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>

            <div class="mb-3 col text-center" id="col_btn_submit">
              <input class="btn btn-submit btn-primary mx-auto" type="submit" value="Entrar" />
            </div>
          </form>
          {{-- <hr class="my-4">
          <p class="text-center">
            <span>Não tem uma conta?</span>
            <a href="{{route('register')}}">
              <span>Criar conta</span>
            </a>
          </p> --}}
        </div>
      </div>
    </div>
    <!-- /Register -->
  </div>
</div>

<script>
  var colSubmit = $('#col_btn_submit');
  
  $("#formAuthentication").submit(function(e){
    $(colSubmit).html('<div class="spinner-border mt-1 text-light" role="status"></div>')
  })
</script>

@endsection
