@extends('layouts/contentNavbarLayout', ["container" => "container-xxl m-w-950"])
@section('title', 'Adicionar Relatório')
@section('content')

<style>
  .container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
    max-width: 1400px;
  }

  .form-clone,
  #form-container > div{
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 20px
  }
</style>

<div class="row py-3 mb-5">
  <div class="col-12 p-xl-0 col-xl-5 align-items-center d-flex">

    <a href="/relatorios" class="mt-1 me-4">
      <img src="{{asset('assets/img/back.png')}}" style="width: 30px" alt="Voltar">
    </a>

    <h1 class="fw-light m-0 text-dark">
      Adicionar Relatório
    </h1>
  </div>
</div>

@include('_partials.errors')

<form action="" autocomplete="off" method="POST">
  @csrf
  <h5>Preencha os campos abaixo:</h5>
  <div class="card mb-4 col-12">
    <div class="card-body">
      <div class="row">
        <div class="col-xl-12 col-md-4 col-12 mb-4">
          <div class="form-group">
            <label for="descricao" class="form-label">Descrição <small>(Será usado como título no PDF)</small><span class="text-danger">*</span></label>
            <input type="text" name="descricao" required id="descricao" value="{{@old('descricao')}}" class="form-control @error('descricao') is-invalid @enderror" />
          </div>
        </div>
        <div class="col-xl-2 col-md-4 col-12 mb-4">
          <div class="form-group">
            <label for="cabecalho" class="form-label">Incluir cabeçalho<span class="text-danger">*</span></label>
            <select name="cabecalho" required id="cabecalho" class="form-select">
              <option value="Sim">Sim</option>
              <option value="Não">Não</option>
            </select>
          </div>
        </div>
        <div class="col-xl-4 col-md-4 col-12 mb-4">
          <div class="form-group">
            <label for="tipo_relatorio" class="form-label">Tipo de Relatório<span class="text-danger">*</span></label>
            <select name="tipo_relatorio" required id="tipo_relatorio" class="form-select">
              <option value="RoPA">Relatório de Atividades de Tratamento</option>
              <option value="Lia">Teste de Legítimo Interesse</option>
              <option value="RIPD">Relatório de Impacto à Privacidade</option>
              <option value="Geral">Relatórios Gerais</option>
            </select>
          </div>
        </div>
        <div class="col-xl-6 col-md-4 col-12 mb-4">
          <div class="form-group">
            <label for="assinante" class="form-label">Nome dado ao Assinante</label>
            <input type="text" name="assinante" id="assinante" class="form-control @error('assinante') is-invalid @enderror" />
          </div>
        </div>
        <div class="col-xl-4 col-md-4 col-12 mb-0">
          <div class="form-group">
            <label for="atividade_tratamento" class="form-label">Atividade de Tratamento<span class="text-danger">*</span></label>
            <select name="atividades[]" required id="atividades" class="form-select" multiple>
              {{-- <option value="Todos">Todos</option> --}}
              @foreach($atividades as $atividade)
                <option value="{{$atividade}}">{{$atividade}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-xl-4 col-md-4 col-12 mb-0">
          <div class="form-group">
            <label for="setores" class="form-label">Setores<span class="text-danger">*</span></label>
            <select name="setores[]" required id="setores" class="form-select" multiple>
              {{-- <option value="Todos">Todos</option> --}}
              @foreach($setores as $setor)
                <option value="{{$setor}}">{{$setor}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-xl-4 col-md-4 col-12 mb-0">
          <div class="form-group">
            <label for="areas" class="form-label">Áreas<span class="text-danger">*</span></label>
            <select name="areas[]" required id="areas" class="form-select" multiple>
              {{-- <option value="Todos">Todos</option> --}}
              @foreach($areas as $area)
                <option value="{{$area}}">{{$area}}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-auto d-flex justify-content-start">
      <a href="/relatorios" class="btn btn-outline-secondary me-4">Cancelar</a>
      <input type="submit" class="btn btn-primary" value="Adicionar" />
    </div>
  </div>

</form>
@endsection