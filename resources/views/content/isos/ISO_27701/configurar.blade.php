@php
$exitScale = true;
$isNavbar = true;
$isMenu = (new \Jenssegers\Agent\Agent())->isMobile() ? true : false;
@endphp

@extends('layouts/contentNavbarLayout', ["container" => "container-fluid"])
@section('title', 'Configurar Gestão de Privacidade')
@section('content')

@include('_partials.styles.custom-container')
<div class="row py-3 mb-5">
  <div class="col-12 p-xl-0 col-xl-12 align-items-center d-flex">
    <a href="/maturidades/" class="mt-1 me-4">
      <img src="{{asset('assets/img/back.png')}}" style="width: 30px" alt="Voltar">
    </a>

    <h1 class="fw-light m-0 text-dark">
      Configurar Gestão de Privacidade
    </h1>
  </div>
</div>
@include('_partials.errors')

<style>
  #navbar-collapse{
    display: none!important;
  }

  .custom-select{
    position: relative;
    display: inline-block;
  }

  .custom-select select {
    opacity: 0;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 90%;
    cursor: pointer;
  }

  .selected-value {
    padding: 5px;
    border-radius: 4px;
    cursor: pointer;
    display: inline-block;
  }

  .table-secondary {
    --bs-table-bg: transparent;
    --bs-table-striped-bg: #fff;
    --bs-table-striped-color: #000;
    --bs-table-active-bg: #d7dbe1;
    --bs-table-active-color: #435971;
    --bs-table-hover-bg: #f0f0f0;
    --bs-table-hover-color: #435971;
    color: #000;
  }

  .table-responsive{
    overflow: inherit
  }

  h5.categoria{
    position: sticky;
    top: 45px;
  }
</style>

@php
$status = [
  "Não se aplica",
  "Inexistente",
  "Não implementado",
  "Parcialmente implementado",
  "Implementado",
];
@endphp

<form action="" id="formIso" method="POST" autocomplete="off">
  @csrf

  <input type="hidden" name="empresa_id" value="{{$isos->empresa_id}}" />
  <input type="hidden" name="iso_id" value="{{$isos->id}}" />
  <input type="hidden" name="iso" value="{{$isos->iso}}" />

  <div class="table-responsive table-escala mb-5 mt-4">
    <table class="table table-bordered table-sm table-hover table-striped" style="table-layout: fixed;">
      <thead class="table-dark">
        <tr class="text-nowrap">
          <th style="width: 40px">#</th>
          <th class="text-white">Controles</th>
          <th class="text-white" style="width: 200px">Status atual</th>
          <th class="text-white" style="width: 200px">Nível de atenção</th>
          <th class="text-white" style="width: 250px">Análise</th>
        </tr>
      </thead>
      <tbody class="drop">
        @foreach ($isos["dados"] as $key => $iso)
          <tr data-key="{{$key}}">
            <td class="py-0 delete">
              <button type="button" onclick="removeClone({{$key}})" class="border-0 p-0 bg-transparent">
                <img src="{{asset('assets/img/delete.png')}}" alt="Deletar" class="rounded-circle" style="width: 18px" />
              </button>
            </td>
            <td class="p-0">
              <textarea name="steps[{{$key}}][controle]" class="form-control" cols="30" rows="3">{!! isset($iso["controle"]) ? $iso["controle"] : '' !!}</textarea>
            </td>
            <td>
              <div class="custom-select">
                <span class="selected-value">{!!isset($iso['status']) ? $iso['status'] : 'Selecione uma opção'!!}</span>
                <select name="steps[{{$key}}][status]" class="dynamic-select form-select">
                  <option value="">Selecione uma opção</option>
                  @foreach($status as $s)
                    <option {{isset($iso['status']) && $iso['status'] == $s ? 'selected' : ''}} value="{!!$s!!}">{!!$s!!}</option>
                  @endforeach
                </select>
              </div>
            </td>
            <td>
              <input type="hidden" name="steps[{{$key}}][nivel]" value="{!!isset($iso['nivel']) ? $iso['nivel'] : ''!!}" />
              <span data-name="steps[{{$key}}][nivel]" class="selected-value-nivel">{!!isset($iso['nivel']) ? $iso['nivel'] : 'Selecione um status'!!}</span>
            </td>
            <td class="p-0">
              <textarea name="steps[{{$key}}][obs]" class="form-control" cols="30" rows="3">{{isset($iso['obs']) ? $iso['obs'] : ''}}</textarea>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="col-12 my-4">
      <a class="btn btn-sm btn-outline-secondary me-3 mt-2 btn-clone">+ Adicionar</a>
    </div> 
  </div>

  <div class="mx-auto w-100 ">
    <div id="col_btn_submit" class="d-flex justify-content-center">
      <a href="/maturidades" class="btn btn-outline-secondary me-3">Cancelar</a>
      <input class="btn btn-submit btn-primary" type="submit" value="Salvar Alterações" />
    </div>
  </div>

</form>

<script>
  var colSubmit = $('#col_btn_submit');
  
  $("#formIso").submit(function(e){
    $(colSubmit).html('<div class="spinner-border mt-1 text-light" role="status"></div>')
  })
</script>

<script>
  $(document).ready(function() {
    $('.custom-select .selected-value').on('click', function() {    
      let select = $(this).siblings('.dynamic-select');
      select.focus();
    });

    $(document).on('change', '.custom-select .dynamic-select', function() {
      let selectedOption = $(this).find('option:selected').text();
      $(this).siblings('.selected-value').text(selectedOption);
      $(this).blur();

      let nivel
      let selectedName = $(this).attr('name')

      selectedName = selectedName.replace('status', 'nivel')

      switch (selectedOption) {
        case 'Não se aplica':
          nivel = 'Muito baixo'
          break;
        case 'Inexistente':
          nivel = 'Muito alto'
          break;
        case 'Não implementado':
          nivel = 'Alto'
          break;
        case 'Parcialmente implementado':
          nivel = 'Médio'
          break;
        case 'Implementado':
          nivel = 'Baixo'
          break;
      
        default:
          nivel = '';
          break;
      }

      $('input[name="'+selectedName+'"]').val(nivel)
      $('span[data-name="'+selectedName+'"]').html(nivel)
      console.log(selectedName)
    });
  });
</script>

<script>
  function removeClone(key){
    let first = $('.drop tr').first()

    console.log("first", first.data('key'))
    console.log("key", key)

    if(first.data('key') != key){
      $('table tr[data-key="'+key+'"]').remove()
    }
  }

  $(document).ready(function() {
    $('.btn-clone').click(function(){
      let original = $(`.drop tr`).last()
      let clone = $(original).clone()
      let drop = $(`.drop`)
      let currentKey = clone.data('key')
      let newKey = currentKey + 1
      let button = clone.find('button')

      $(button).attr('onclick', 'removeClone('+newKey+')')

      let selects = clone.find('select')
      let inputs = clone.find('input')
      let textareas = clone.find('textarea')
      let spans = clone.find('span.selected-value-nivel')

      spans.map((index, value) => {
        let currentName = $(value).attr('data-name')
        newName = currentName.replace('['+currentKey+']', '['+newKey+']')
        $(value).attr('data-name', newName)
      })

      textareas.map((index, value) => {
        let currentName = $(value).attr('name')
        newName = currentName.replace('['+currentKey+']', '['+newKey+']')
        $(value).attr('name', newName).val("")
      })

      selects.map((index, value) => {
        let currentName = $(value).attr('name')
        newName = currentName.replace('['+currentKey+']', '['+newKey+']')
        $(value).attr('name', newName).val("")
      })

      inputs.map((index, value) => {
        let currentName = $(value).attr('name')
        newName = currentName.replace('['+currentKey+']', '['+newKey+']')
        $(value).attr('name', newName).val("")
      })
      
      $(original).removeAttr('class')
      $(clone).attr('data-key', newKey)

      drop.append(clone)
    })

    $('.custom-select .selected-value').on('click', function() {    
      let select = $(this).siblings('.dynamic-select');
    
      select.focus();
    });

    $(document).on('change', '.custom-select .dynamic-select', function() {
      let selectedOption = $(this).find('option:selected').text();
      $(this).siblings('.selected-value').text(selectedOption);
      $(this).blur();
    });
  });
</script>

@endsection
