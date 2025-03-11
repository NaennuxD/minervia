@php
$exitScale = true;
$isNavbar = true;
$isMenu = (new \Jenssegers\Agent\Agent())->isMobile() ? true : false;
@endphp

@extends('layouts/contentNavbarLayout', ["container" => "container-fluid"])
@section('title', 'Configurar Gestão de Política e Procedimentos')
@section('content')

<style>
#navbar-collapse{
  display: none!important;
}
</style>

@include('_partials.styles.custom-container')
<div class="row py-3 mb-5">
  <div class="col-12 p-xl-0 col-xl-12 align-items-center d-flex">
    <a href="/" class="mt-1 me-4">
      <img src="{{asset('assets/img/back.png')}}" style="width: 30px" alt="Voltar">
    </a>

    <h1 class="fw-light m-0 text-dark">
      Gestão de Política e Procedimentos
    </h1>
  </div>
</div>
@include('_partials.errors')

@php
$tipo = [
  "Política",
  "Procedimento",
  "Norma regulamentadora",
];

$status = [
  "Inexistente",
  "Iniciado",
  "Parcialmente implementado",
  "Implementado",
];

$fase = [
  "Não documentado",
  "Em aprovação",
  "Aprovado e implementado",
];
@endphp

<form action="" id="formPolitica" method="POST" autocomplete="off">
  @csrf

  <input type="hidden" name="empresa_id" value="{{$politica->empresa_id}}" />
  <input type="hidden" name="politica_id" value="{{$politica->id}}" />

  <div class="table-responsive table-escala mb-5 mt-4">
    <table class="table table-bordered table-sm table-hover table-striped">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th class="text-white" style="min-width: 200px">Políticas temas</th>
          <th class="text-white" style="min-width: 150px">Tipo</th>
          <th class="text-white" style="min-width: 150px">Status</th>
          <th class="text-white" style="min-width: 150px">Fase</th>
          <th class="text-white" style="min-width: 100px">Área</th>
          <th class="text-white">Próxima Revisão</th>
          <th class="text-white" style="min-width: 120px">Criado por</th>
          <th class="text-white" style="min-width: 120px">Aprovado por</th>
        </tr>
      </thead>
      <tbody class="drop">
        @if($politica->dados)
          @foreach($politica->dados as $key => $step)
            <tr data-key="{{$key}}">
              <td class="py-0 delete">
                <button type="button" onclick="removeClone({{$key}})" class="border-0 p-0 bg-transparent">
                  <img src="{{asset('assets/img/delete.png')}}" alt="Deletar" class="rounded-circle" style="width: 18px" />
                </button>
              </td>
              <td class="p-0">
                <input type="text" name="steps[{{$key}}][tema]" class="border-0 form-control" value="{{$politica["dados"] && $politica["dados"][$key]["tema"] ? $politica["dados"][$key]["tema"] : ''}}">
              </td>
              <td class="p-0">
                <select name="steps[{{$key}}][tipo]" class="form-select border-0">
                  <option value="">Escolha</option>
                  @foreach($tipo as $s)
                    <option {{$politica["dados"] && $politica["dados"][$key]["tipo"] && $politica["dados"][$key]["tipo"] == $s ? 'selected' : ''}} value="{{$s}}">{{$s}}</option>
                  @endforeach
                </select>
              </td>
              <td class="p-0">
                <select name="steps[{{$key}}][status]" class="form-select border-0">
                  <option value="">Escolha</option>
                  @foreach($status as $s)
                    <option {{$politica["dados"] && $politica["dados"][$key]["status"] && $politica["dados"][$key]["status"] == $s ? 'selected' : ''}} value="{{$s}}">{{$s}}</option>
                  @endforeach
                </select>
              </td>
              <td class="p-0">
                <select name="steps[{{$key}}][fase]" class="form-select border-0">
                  <option value="">Escolha</option>
                  @foreach($fase as $s)
                    <option {{$politica["dados"] && $politica["dados"][$key]["fase"] && $politica["dados"][$key]["fase"] == $s ? 'selected' : ''}} value="{{$s}}">{{$s}}</option>
                  @endforeach
                </select>
              </td>
              <td class="p-0">
                <input type="text" name="steps[{{$key}}][area]" class="border-0 form-control" value="{{$politica["dados"] && $politica["dados"][$key]["area"] ? $politica["dados"][$key]["area"] : ''}}">
              </td>
              {{-- <td class="p-0">
                <input type="date" name="steps[{{$key}}][revisao]" class="border-0 form-control" value="{{$politica["dados"] && $politica["dados"][$key]["revisao"] ? $politica["dados"][$key]["revisao"] : ''}}">
              </td> --}}
              <td class="p-0">
                <input type="date" name="steps[{{$key}}][proxima_revisao]" class="border-0 form-control" value="{{$politica["dados"] && $politica["dados"][$key]["proxima_revisao"] ? $politica["dados"][$key]["proxima_revisao"] : ''}}">
              </td>
              <td class="p-0">
                <input type="text" name="steps[{{$key}}][criado]" class="border-0 form-control" value="{{$politica["dados"] && $politica["dados"][$key]["criado"] ? $politica["dados"][$key]["criado"] : ''}}">
              </td>
              <td class="p-0">
                <input type="text" name="steps[{{$key}}][aprovado]" class="border-0 form-control" value="{{$politica["dados"] && $politica["dados"][$key]["aprovado"] ? $politica["dados"][$key]["aprovado"] : ''}}">
              </td>
            </tr>
          @endforeach
        @else
          <tr data-key="0">
            <td class="py-0 delete">
              <button type="button" onclick="removeClone(0)" class="border-0 p-0 bg-transparent">
                <img src="{{asset('assets/img/delete.png')}}" alt="Deletar" class="rounded-circle" style="width: 18px" />
              </button>
            </td>
            <td class="p-0">
              <input type="text" name="steps[0][tema]" class="border-0 form-control">
            </td>
            <td class="p-0">
              <select name="steps[0][tipo]" class="form-select border-0">
                <option value="">Escolha</option>
                @foreach($tipo as $s)
                  <option value="{{$s}}">{{$s}}</option>
                @endforeach
              </select>
            </td>
            <td class="p-0">
              <select name="steps[0][status]" class="form-select border-0">
                <option value="">Escolha</option>
                @foreach($status as $s)
                  <option value="{{$s}}">{{$s}}</option>
                @endforeach
              </select>
            </td>
            <td class="p-0">
              <select name="steps[0][fase]" class="form-select border-0">
                <option value="">Escolha</option>
                @foreach($fase as $s)
                  <option value="{{$s}}">{{$s}}</option>
                @endforeach
              </select>
            </td>
            <td class="p-0">
              <input type="text" name="steps[0][area]" class="border-0 form-control">
            </td>
            {{-- <td class="p-0">
              <input type="date" name="steps[0][revisao]" class="border-0 form-control">
            </td> --}}
            <td class="p-0">
              <input type="date" name="steps[0][proxima_revisao]" class="border-0 form-control">
            </td>
            <td class="p-0">
              <input type="text" name="steps[0][criado]" class="border-0 form-control">
            </td>
            <td class="p-0">
              <input type="text" name="steps[0][aprovado]" class="border-0 form-control">
            </td>
          </tr>
        @endif
      </tbody>
    </table>
    <div class="col-12 my-4">
      <a class="btn btn-sm btn-outline-secondary me-3 mt-2 btn-clone">+ Adicionar</a>
    </div>
  </div>
  <div class="mx-auto w-100 ">
    <div id="col_btn_submit" class="d-flex justify-content-center">
      <a href="/" class="btn btn-outline-secondary me-3">Cancelar</a>
      <input class="btn btn-submit btn-primary" type="submit" value="Salvar Alterações" />
    </div>
  </div>

</form>

<script>
  var colSubmit = $('#col_btn_submit');
  
  $("#formPolitica").submit(function(e){
    $(colSubmit).html('<div class="spinner-border mt-1 text-light" role="status"></div>')
  })
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
      let origianl = $('.drop tr').last()
      let clone = $(origianl).clone()
      let drop = $('.drop')
      let currentKey = clone.data('key')
      let selects = clone.find('select')
      let inputs = clone.find('input')
      let newKey = currentKey + 1
      let button = clone.find('button')

      selects.map((index, value) => {
        let currentName = $(value).attr('name')
        newName = currentName.replace('['+currentKey+']', '['+newKey+']')
        $(value).attr('name', newName).val("")
      })

      $(button).attr('onclick', 'removeClone('+newKey+')')

      inputs.map((index, value) => {
        let currentName = $(value).attr('name')
        newName = currentName.replace('['+currentKey+']', '['+newKey+']')
        $(value).attr('name', newName).val("")
      })

      $(origianl).removeAttr('class')
      $(clone).attr('data-key', newKey)

      drop.append(clone)
    })

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

@endsection
