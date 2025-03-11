@php
$exitScale = true;
$isNavbar = true;
$isMenu = (new \Jenssegers\Agent\Agent())->isMobile() ? true : false;
@endphp

@extends('layouts/contentNavbarLayout', ["container" => "container-fluid"])
@section('title', 'Configurar Sistema de Gestão de Segurança da Informação')
@section('content')

@include('_partials.styles.custom-container')
<div class="row py-3 mb-5">
  <div class="col-12 p-xl-0 col-xl-12 align-items-center d-flex">
    <a href="/maturidades/" class="mt-1 me-4">
      <img src="{{asset('assets/img/back.png')}}" style="width: 30px" alt="Voltar">
    </a>

    <h1 class="fw-light m-0 text-dark">
      Sistema de Gestão de Segurança da Informação
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
    top: -30px;
    width: 100%;
    height: 100%;
    cursor: pointer;
  }

  .selected-value {
    padding: 45px 5px;
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
$situacoes = [
  "0 - Incompleto <br>(A organização não possui um processo definido)",
  "1 - Inicial <br>(A organização possui um processo definido, mas ele é inconsistente e não é seguido)",
  "2 - Gerenciado <br>(A organização possui um processo definido e ele é seguido de forma consistente)",
  "3 - Definido <br>(A organização possui um processo definido e ele é seguido de forma consistente. Além disso, o processo é documentado e padronizado)",
  "4 - Gerenciado  Quantitativamente<br>(A organização mede e controla quantitativamente o desempenho do processo)",
  "5 - Otimizado <br>(A organização melhora continuamente o processo com base nos resultados medidos)",
];
@endphp

<form action="" id="formIso" method="POST" autocomplete="off">
  @csrf

  <input type="hidden" name="empresa_id" value="{{$iso->empresa_id}}" />
  <input type="hidden" name="iso_id" value="{{$iso->id}}" />
  <input type="hidden" name="iso" value="{{$iso->iso}}" />

  <h3>Definições</h3>
  <div class="table-responsive table-escala mb-5 mt-4">
    <table class="table table-bordered table-sm table-hover table-striped">
      {{-- <thead class="table-dark">
        <tr>
          <th style="width: 140px" class="text-white">Requisitos</th>
          <th></th>
        </tr>
      </thead> --}}
      <tbody>

        @foreach ($steps as $sKey => $step)
          <tr>
            <td class="p-0">
              <table class="table table-bordered table-secondary table-sm table-hover table-striped mb-0" style="table-layout: fixed;">
                <thead class="table-dark" >
                  <tr class="text-nowrap">
                    <th>#</th>
                    <th class="text-white">Controles</th>
                    <th class="text-white" style="width: 300px">Situação Atual</th>
                    <th class="text-white" style="width: 300px">Desejável</th>
                    <th class="text-white" style="width: 250px">Observações</th>
                  </tr>
                </thead>
                <tbody class="drop drop-id-{{$sKey}}">
                  @foreach($step["subcategorias"] as $cKey => $subcategoria)
                    <tr data-key="{{$cKey}}">
                      <td class="py-0 delete">
                        <button type="button" onclick="removeClone({{$cKey}})" class="border-0 p-0 bg-transparent">
                          <img src="{{asset('assets/img/delete.png')}}" alt="Deletar" class="rounded-circle" style="width: 18px" />
                        </button>
                      </td>
                      <td>
                        {!! $subcategoria["controle"] !!}
                      </td>
                      <td>
                        <div class="custom-select">
                          <span class="selected-value">{!!$iso['dados'] && $iso['dados'][$sKey]['subcategorias'][$cKey]['situacao'] ? $iso->dados[$sKey]['subcategorias'][$cKey]['situacao'] : 'Selecione uma opção'!!}</span>
                          <select name="steps[{{$sKey}}][subcategorias][{{$cKey}}][situacao]" class="dynamic-select form-select">
                            <option value="">Selecione uma opção</option>
                            @foreach($situacoes as $situacao)
                              <option {{$iso['dados'] && $iso['dados'][$sKey]['subcategorias'][$cKey]['situacao'] && $iso->dados[$sKey]['subcategorias'][$cKey]['situacao'] == $situacao ? 'selected' : ''}} value="{!!$situacao!!}">{!!$situacao!!}</option>
                            @endforeach
                          </select>
                        </div>
                      </td>
                      <td>
                        <div class="custom-select">
                          <span class="selected-value">{!!$iso['dados'] && $iso['dados'][$sKey]['subcategorias'][$cKey]['desejavel'] ? $iso->dados[$sKey]['subcategorias'][$cKey]['desejavel'] : 'Selecione uma opção'!!}</span>
                          <select name="steps[{{$sKey}}][subcategorias][{{$cKey}}][desejavel]" class="dynamic-select form-select">
                            <option value="">Selecione uma opção</option>
                            @foreach($situacoes as $situacao)
                              <option {{$iso['dados'] && $iso['dados'][$sKey]['subcategorias'][$cKey]['desejavel'] && $iso->dados[$sKey]['subcategorias'][$cKey]['desejavel'] == $situacao ? 'selected' : ''}} value="{!!$situacao!!}">{!!$situacao!!}</option>
                            @endforeach
                          </select>
                        </div>
                      </td>
                      <td class="p-0">
                        <textarea name="steps[{{$sKey}}][subcategorias][{{$cKey}}][obs]" class="form-control" cols="30" rows="4">{{$iso['dados'] && $iso['dados'][$sKey]['subcategorias'][$cKey]['desejavel'] ? $iso->dados[$sKey]['subcategorias'][$cKey]['obs'] : ''}}</textarea>
                      </td>
                    </tr>
                    @dump($loop)
                  @endforeach
                  

                  {{-- @dump(count($iso['dados'][$sKey]['subcategorias']))
                  @dump($loop->count) --}}
                </tbody>
              </table>  
              
              <div class="col-12 my-4">
                <a class="btn btn-sm btn-outline-secondary me-3 mt-2 btn-clone" data-key="{{$sKey}}">+ Adicionar</a>
              </div>    
            </td>
          </tr>

          @dump($loop)
        @endforeach

      </tbody>
    </table>
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

    $('.custom-select .dynamic-select').on('change', function() {
      let selectedOption = $(this).find('option:selected').text();
      $(this).siblings('.selected-value').text(selectedOption);
      $(this).blur();
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
      let key = $(this).data('key')
      let original = $(`.drop.drop-id-${key} tr`).last()
      let clone = $(original).clone()
      let drop = $(`.drop.drop-id-${key}`)
      let currentKey = clone.data('key')
      let newKey = currentKey + 1
      let button = clone.find('button')

      $(button).attr('onclick', 'removeClone('+newKey+')')

      let selects = clone.find('select')
      let inputs = clone.find('input')
      let textareas = clone.find('textarea')

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
