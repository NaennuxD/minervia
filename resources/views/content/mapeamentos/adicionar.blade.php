@extends('layouts/contentNavbarLayout', ["container" => "container col-5"])
@section('title', 'Adicionar Mapeamento')
@section('content')

@include('_partials.styles.custom-container')
@include('_partials.titles.add-edit', ["title" => "Adicionar Mapeamento"])
@include('_partials.errors')

<style>
.form-control::file-selector-button { padding: 15px; }
</style>

<form action="" id="formMapeamento" method="POST" enctype="multipart/form-data">
  @csrf

  <h5>Preencha os campos abaixo:</h5>
  <div class="card mb-4 col-12">
    <div class="card-body">
      <div class="row">
        <div class="col-12 mb-4">
          <div class="form-group">
            <label for="setor" class="form-label">Setor<span class="text-danger">*</span></label>
            <input type="text" name="setor" id="setor" class="form-control" required>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-auto d-flex justify-content-center">
      <a href="javascript:history.back(-1)" class="btn btn-outline-secondary me-3">Cancelar</a>
    </div>
    <div class="col-auto ps-0 text-center" id="col_btn_submit">
      <input class="btn btn-submit btn-primary mx-auto" type="submit" value="Adicionar" />
    </div>
  </div>
</form>

<script>
  var colSubmit = $('#col_btn_submit');
  
  $("#formMapeamento").submit(function(e){
    $(colSubmit).html('<div class="spinner-border mt-1 text-light" role="status"></div>')
  })
</script>

@endsection