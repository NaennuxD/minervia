@extends('layouts/commonMaster' )

@php
if((new \Jenssegers\Agent\Agent())->isMobile()){
  $isNavbar = true;
}else{
  $isNavbar = ($isNavbar ?? false);
}

$contentNavbar = true;
$containerNav = ($containerNav ?? 'container-xxl');
$isMenu = ($isMenu ?? true);
$isFlex = ($isFlex ?? false);
$exitScale = ($exitScale ?? false);
$isFooter = ($isFooter ?? true);
$customizerHidden = ($customizerHidden ?? '');


$navbarDetached = 'navbar-detached';

$container = ($container ?? 'container-xxl');

@endphp

@section('layoutContent')
<div class="layout-wrapper layout-content-navbar {{ $isMenu ? '' : 'layout-without-menu' }}">
  <div class="layout-container">

    @if ($isMenu)
      @include('layouts/sections/menu/verticalMenu')
    @endif


    <div class="layout-page">

      @php
      use \App\Http\Controllers\Controller;
      $hasSession = Controller::hasSession();
      @endphp
      @if($hasSession)
      <a href="/empresas?redirectTo={{\Request::url()}}" style="z-index: 999999">
        <div class="container-fluid bg-gray px-4 py-2 text-white">
          <p class="m-0 text-center">Empresa: {{Controller::getSession('empresa_nome')}}</p>
        </div>
      </a>
      @endif
      
      @if ($isNavbar)
        @include('layouts/sections/navbar/navbar')
      @endif


      <div class="content-wrapper">
        @if ($isFlex)
        <div class="{{$container}} d-flex align-items-stretch flex-grow-1 p-0">
          @else
          <div class="{{$container}} flex-grow-1 container-p-y">
            @endif

            @if (!empty($_GET['status']) && $_GET['status'] == 'success')
              <div class="alert alert-success alert-dismissible" role="alert">
                Ação efetuada com sucesso!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
              </div>
            @endif    

            @if (!empty($_GET['status']) && $_GET['status'] == 'empty')
              <div class="alert alert-primary text-dark alert-dismissible" role="alert">
                Nenhum resultado encontrado para a sua solicitação.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
              </div>
            @endif

            @if (!empty($_GET['status']) && $_GET['status'] == 'wrong')
              <div class="alert alert-danger alert-dismissible" role="alert">
                Dados inválidos
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
              </div>
            @endif

            @yield('content')

          </div>

          @if ($isFooter)
          @include('layouts/sections/footer/footer')
          @endif
          <div class="content-backdrop fade"></div>
        </div>
      </div>
    </div>

    @if ($isMenu)
    <div class="layout-overlay layout-menu-toggle"></div>
    @endif
    <div class="drag-target"></div>
  </div>
  @endsection
