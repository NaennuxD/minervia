@php
// $containerNav = $containerNav ?? 'container-fluid';
$containerNav = 'container-fluid';
$navbarDetached = ($navbarDetached ?? '');
@endphp

<!-- Navbar -->
@if(isset($navbarDetached) && $navbarDetached == 'navbar-detached')
<nav class="{{$containerNav}} navbar align-items-center mt-2" id="layout-navbar">
  @endif
  @if(isset($navbarDetached) && $navbarDetached == '')
  <nav class=" navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="{{$containerNav}}">
      @endif

      <!--  Brand demo (display only for navbar-full and hide on below xl) -->
      @if(isset($navbarFull))
      <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
        <a href="{{url('/')}}">
          <div class="app-brand-logo demo">@include('_partials.macros',["color"=>"white"])</div>
          {{-- <div class="app-brand-text mt-2 text-center text-dark">{{config('variables.templateName')}}</div> --}}
        </a>
      </div>
      @endif

      <!-- ! Not required for layout-without-menu -->
      @if(!isset($navbarHideToggle))
      <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
        <a class="nav-item nav-link px-0 me-xl-4 d-flex align-items-center" href="javascript:void(0)">
          <i class="bx bx-menu bx-sm mr-2"></i> <b>Menu</b>
        </a>
      </div>
      @endif

      @if($exitScale)
      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <a class="btn btn-primary btn-sm" href="javascript:history.back(-1)">Voltar</a>
      </div>
      @endif

      @if(!isset($navbarDetached))
    </div>
    @endif
  </nav>
  <!-- / Navbar -->
