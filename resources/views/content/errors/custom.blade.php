@extends('layouts/blankLayout')
@section('title', 'Acesso Negado')
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
            <div class="app-brand-logo demo"><img style="max-width: 120px;" src="{{asset('assets/img/logo-dark.png')}}"></div>
          </div>

          <!-- /Logo -->
          <h5 class="mb-4 fw-normal text-danger text-center">Acesso não autorizado!</h5>
          <p class="mb-4 text-center">Motivo: {{$message}}</p>

        </div>
      </div>
    </div>
  </div>
</div>

@endsection