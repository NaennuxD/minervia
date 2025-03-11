@extends('layouts/contentNavbarLayout', ["container" => "container-xxl col-12 m-w-1120"])
@section('title', 'Atualizar Empresa')
@section('content')

@include('_partials.styles.custom-container')
@include('_partials.titles.add-edit', ["title" => "Atualizar Empresa"])
@include('_partials.errors')

<style>
  .form-control::file-selector-button {
    padding: 15px;
  }
  
  .current-logo {
    width: auto;
    border: 0;
    padding: 0;
    max-height: 35px;
    margin-right: 10px;
  }
</style>

<form action="" method="POST" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="empresa_id" value="{{$empresa->id}}" required>
  <h5>Dados externos:</h5>
  <div class="card mb-4 col-12">
    <div class="card-body">
      <div class="row">
        <div class="col-xl-3 col-12 mb-4">
          <div class="form-group">
            <label for="cnpj" class="form-label">CNPJ<span class="text-danger">*</span></label>
            <input type="text" name="cnpj" id="cnpj" value="{{$empresa->cnpj}}" class="form-control" required>
          </div>
        </div>
        <div class="col-xl-5 col-12 mb-4">
          <div class="form-group">
            <label for="company_name" class="form-label">Razão Social<span class="text-danger">*</span></label>
            <input type="text" name="company_name" id="company_name" value="{{$empresa->company_name}}" class="form-control" required>
          </div>
        </div>
        <div class="col-xl-2 col-6 mb-4">
          <div class="form-group">
            <label for="contact" class="form-label">Contato<span class="text-danger">*</span></label>
            <input type="text" name="contact" id="contact" value="{{$empresa->contact}}" class="form-control" required>
          </div>
        </div>
        <div class="col-xl-2 col-6 mb-4">
          <div class="form-group">
            <label for="cep" class="form-label">CEP<span class="text-danger">*</span></label>
            <input type="text" name="cep" id="cep" value="{{$empresa->cep}}" class="form-control">
          </div>
        </div>
        <div class="col-xl-4 col-12 mb-4">
          <div class="form-group">
            <label for="address" class="form-label">Endereço<span class="text-danger">*</span></label>
            <input type="text" name="address" id="address" value="{{$empresa->address}}" class="form-control">
          </div>
        </div>
        <div class="col-xl-1 col-3 mb-4">
          <div class="form-group">
            <label for="number" class="form-label">Número<span class="text-danger">*</span></label>
            <input type="text" name="number" id="number" value="{{$empresa->number}}" class="form-control">
          </div>
        </div>
        <div class="col-xl-4 col-9 mb-4">
          <div class="form-group">
            <label for="complement" class="form-label">Complemento<span class="text-danger">*</span></label>
            <input type="text" name="complement" id="complement" value="{{$empresa->complement}}" class="form-control">
          </div>
        </div>
        <div class="col-xl-3 col-6 mb-4">
          <div class="form-group">
            <label for="neighborhood" class="form-label">Bairro<span class="text-danger">*</span></label>
            <input type="text" name="neighborhood" id="neighborhood" value="{{$empresa->neighborhood}}" class="form-control">
          </div>
        </div>
        <div class="col-xl-3 col-6 mb-4">
          <div class="form-group">
            <label for="city" class="form-label">Cidade<span class="text-danger">*</span></label>
            <input type="text" name="city" id="city" value="{{$empresa->city}}" class="form-control">
          </div>
        </div>
        <div class="col-xl-1 col-4 mb-4">
          <div class="form-group">
            <label for="state" class="form-label">Estado<span class="text-danger">*</span></label>
            <input type="text" name="state" id="state" value="{{$empresa->state}}" class="form-control">
          </div>
        </div>
        <div class="col-xl-2 col-8 mb-4">
          <div class="form-group">
            <label for="country" class="form-label">País<span class="text-danger">*</span></label>
            <input type="text" name="country" id="country" value="Brasil" value="{{$empresa->Brasil}}" class="form-control">
          </div>
        </div>
        <div class="col-xl-2 col-8 mb-4">
          <div class="form-group">
            <label for="status" class="form-label">Status<span class="text-danger">*</span></label>
            <select name="status" id="status" class="form-select">
              <option value="inactive" {{$empresa->status == 'inactive' ? 'selected' : ''}}>Inativo</option>
              <option value="active" {{$empresa->status == 'active' ? 'selected' : ''}}>Ativo</option>
            </select>
          </div>
        </div>
        
      </div>
    </div>
  </div>

  <h5>Dados internos:</h5>
  <div class="card mb-4 col-12">
    <div class="card-body">
      <div class="row">
        <div class="col-xl-4 col-12 mb-4">
          <div class="form-group">
            <label for="agente_tratamento" class="form-label">Agente de tratamento</label>
            <input type="text" value="{{$empresa->agente_tratamento}}" name="agente_tratamento" id="agente_tratamento" class="form-control">
          </div>
        </div>
        {{-- <div class="col-xl-4 col-12 mb-4">
          <div class="form-group">
            <label for="tipo_agente" class="form-label">Tipo de Agente de Tratamento</label>
            <input type="text" value="{{$empresa->tipo_agente}}" name="tipo_agente" id="tipo_agente" class="form-control">
          </div>
        </div> --}}
        <div class="col-xl-4 col-12 mb-4">
          <div class="form-group">
            <label for="encarregado" class="form-label">Encarregado</label>
            <input type="text" value="{{$empresa->encarregado}}" name="encarregado" id="encarregado" class="form-control">
          </div>
        </div>
      </div>
    </div>
  </div>

  <h5>Logo:</h5>
  <div class="card mb-4 col-12">
    <div class="card-body">
      <div class="row">
        <div class="col-xl-6 col-12 mb-4 mb-xl-0">
          <div class="form-group">
            <label for="logo" class="form-label cursor-pointer">Logo atual
              <input type="file" name="logo" class="d-none form-control" id="logo" />
              <div class="d-flex align-items-center" style="margin-top: 12px;">
                <img src="{{URL::asset('storage/uploads/' . $empresa->logo)}}" alt="{{$empresa->company_name}}" class="current-logo" />
                <i class='bx bx-edit-alt'></i>
              </div>
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <h5>Contato da Empresa:</h5>
  <div class="card mb-4 col-12">
    <div class="card-body">
      <div class="row">
        <div class="col-xl-4 col-12 mb-4">
          <div class="form-group">
            <label for="telefone_empresa" class="form-label">Telefone</label>
            <input type="text" value="{{$empresa->telefone_empresa}}" name="telefone_empresa" id="telefone_empresa" class="form-control">
          </div>
        </div>
        <div class="col-xl-4 col-12 mb-4">
          <div class="form-group">
            <label for="email_empresa" class="form-label">E-mail</label>
            <input type="email" value="{{$empresa->email_empresa}}" name="email_empresa" id="email_empresa" class="form-control">
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <h5>Contato do Encarregado:</h5>
  <div class="card mb-4 col-12">
    <div class="card-body">
      <div class="row">
        <div class="col-xl-4 col-12 mb-4">
          <div class="form-group">
            <label for="telefone_encarregado" class="form-label">Telefone</label>
            <input type="text" value="{{$empresa->telefone_encarregado}}" name="telefone_encarregado" id="telefone_encarregado" class="form-control">
          </div>
        </div>
        <div class="col-xl-4 col-12 mb-4">
          <div class="form-group">
            <label for="email_encarregado" class="form-label">E-mail</label>
            <input type="email" value="{{$empresa->email_encarregado}}" name="email_encarregado" id="email_encarregado" class="form-control">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-auto d-flex justify-content-center">
      <a href="javascript:history.back(-1)" class="btn btn-outline-secondary me-3">Cancelar</a>
    </div>
    <div class="col-auto ps-0 d-flex align-items-center">
      <div id="submit" class="form-group m-0">
        <input class="btn btn-primary" type="submit" {{Auth::user()->funcao == 'operador' ? 'disabled' : ''}} value="Atualizar">
      </div>
      <div id="loading" class="spinner-border d-none" role="status"></div>
    </div>
  </div>
</form>

@include('content.empresas.scripts')

@endsection