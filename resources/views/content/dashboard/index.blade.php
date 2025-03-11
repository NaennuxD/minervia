@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

@section('content')

<div class="row py-3 mb-4 align-items-center">
  <div class="col-12">
    <h1 class="fw-light text-dark">
      Bem vindo, {{$nome}}.
    </h1>
  </div>
  <div class="col-12">
    <p class="badge fs-6 fw-semibold badge-primary m-0">{{ucfirst($funcao)}}</p>
  </div>
</div>

@endsection