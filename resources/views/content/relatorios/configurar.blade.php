@extends('layouts/contentNavbarLayout', ["container" => "container-xxl m-w-950"])
@section('title', 'Adicionar Relatório')
@section('content')

<style>
  .container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
    max-width: 1400px;
  }

  hr{
    background-color: transparent
  }

  .form-clone,
  #form-container > div{
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px;
    display: flex;
    width: 100%;
    flex-wrap: wrap;
    flex-direction: row;
    padding-bottom: 0;
}

a.btn.btn-outline-danger{
  margin: 0 0 15px 5px;
}

.form-group.mb-3{
  margin-bottom: 0.4rem!important
}

#form-container .form-group,
.form-clone .form-group{
  padding: 5px;
  width: 50%!important;
}

</style>

<script>
{!!"var questions = ". json_encode($stepKeys)!!}
{!!"var graficos = ". json_encode($graficos)!!}
</script>

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

  <div class="d-flex justify-content-between align-items-center">
    <h5>Preencha os campos abaixo:</h5>
    <a href="/relatorio/{{$relatorio->id}}/visualizar" target="_blank">Visualizar <i class="bx bx-link-external"></i></a>
  </div>

  <div class="card mb-4 col-12">
    <div class="card-body">
      <div class="row">
        <div class="col-xl-12 col-md-4 col-12 mb-4">
          <div class="form-group">
            <label for="descricao" class="form-label">Descrição <small>(Será usado como título no PDF)</small><span class="text-danger">*</span></label>
            <input type="text" name="descricao" required id="descricao" value="{{$relatorio->descricao}}" class="form-control @error('descricao') is-invalid @enderror" />
          </div>
        </div>
        <div class="col-xl-2 col-md-4 col-12 mb-4">
          <div class="form-group">
            <label for="cabecalho" class="form-label">Incluir cabeçalho<span class="text-danger">*</span></label>
            <select name="cabecalho" required id="cabecalho" class="form-select">
              <option {{$relatorio->cabecalho == 'Sim' ? 'selected="selected"' : ''}} value="Sim">Sim</option>
              <option {{$relatorio->cabecalho == 'Não' ? 'selected="selected"' : ''}} value="Não">Não</option>
            </select>
          </div>
        </div>
        <div class="col-xl-4 col-md-4 col-12 mb-4">
          <div class="form-group">
            <label for="tipo_relatorio" class="form-label">Tipo de Relatório<span class="text-danger">*</span></label>
            <select name="tipo_relatorio" required id="tipo_relatorio" class="form-select">
              <option {{$relatorio->tipo_relatorio == 'RoPA' ? 'selected="selected"' : ''}} value="RoPA">Relatório de Atividades de Tratamento</option>
              <option {{$relatorio->tipo_relatorio == 'Lia' ? 'selected="selected"' : ''}} value="Lia">Teste de Legítimo Interesse</option>
              <option {{$relatorio->tipo_relatorio == 'RIPD' ? 'selected="selected"' : ''}} value="RIPD">Relatório de Impacto à Privacidade</option>
              <option {{$relatorio->tipo_relatorio == 'Geral' ? 'selected="selected"' : ''}} value="Geral">Relatórios Gerais</option>
            </select>
          </div>
        </div>
        <div class="col-xl-6 col-md-4 col-12 mb-4">
          <div class="form-group">
            <label for="assinante" class="form-label">Nome dado ao Assinante</label>
            <input type="text" name="assinante" id="assinante" value="{{$relatorio->assinante}}" class="form-control @error('assinante') is-invalid @enderror" />
          </div>
        </div>
        <div class="col-xl-4 col-md-4 col-12 mb-4">
          <div class="form-group">
            <label for="atividade_tratamento" class="form-label">Atividade de Tratamento<span class="text-danger">*</span></label>
            <select name="atividades[]" id="atividades" class="form-select" multiple>
              {{-- <option value="Todos">Todos</option> --}}
              @foreach($atividades as $atividade)
                <option value="{{$atividade}}">{{$atividade}}</option>
              @endforeach
            </select>
            <b>Atuais:</b> {{$relatorio->atividades_imploded ?? 'Todos'}}
          </div>
        </div>
        <div class="col-xl-4 col-md-4 col-12 mb-0">
          <div class="form-group">
            <label for="setores" class="form-label">Setores<span class="text-danger">*</span></label>
            <select name="setores[]" id="setores" class="form-select" multiple>
              {{-- <option value="Todos">Todos</option> --}}
              @foreach($setores as $setor)
                <option value="{{$setor}}">{{$setor}}</option>
              @endforeach
            </select>
            <b>Atuais:</b> {{$relatorio->setores_imploded ?? 'Todos'}}
          </div>
        </div>
        <div class="col-xl-4 col-md-4 col-12 mb-0">
          <div class="form-group">
            <label for="areas" class="form-label">Áreas<span class="text-danger">*</span></label>
            <select name="areas[]" id="areas" class="form-select" multiple>
              {{-- <option value="Todos">Todos</option> --}}
              @foreach($areas as $area)
                <option value="{{$area}}">{{$area}}</option>
              @endforeach
            </select>
            <b>Atuais:</b> {{$relatorio->areas_imploded ?? 'Todos'}}
          </div>
        </div>
      </div>
    </div>
  </div>

  <h5>Estrutura do Relatório:</h5>
  <div class="card mb-4 col-12">
    <div class="card-body">
      <div class="row">
        <div class="col">
          <div class="form-clone">
            <div class="form-group mb-3">
              <label class="form-label">Título:<span class="text-danger">*</span></label>
              <input required class="form-control" name="estrutura[0][titulo]" value="{{$relatorio->estrutura ? $relatorio->estrutura[0]['titulo'] : ''}}" type="text">
            </div>

            <div class="form-group mb-3">
              <label class="form-label">Descrição:</label>
              <textarea rows="1" class="form-control" name="estrutura[0][descricao]">{{$relatorio->estrutura ? $relatorio->estrutura[0]['descricao'] : ''}}</textarea>
            </div>

            <div class="form-group mb-3">
              <label class="form-label">Tipo de Informação:</label>
              <select class="type form-select" name="estrutura[0][tipo]" data-type-id="0">
                <option value="">Escolha</option>
                <option {{$relatorio->estrutura && $relatorio->estrutura[0]['tipo'] == 'text' ? 'selected="selected"' : ''}} value="text">Texto</option>
                <option {{$relatorio->estrutura && $relatorio->estrutura[0]['tipo'] == 'graphic' ? 'selected="selected"' : ''}} value="graphic">Gráfico</option>
                <option {{$relatorio->estrutura && $relatorio->estrutura[0]['tipo'] == 'map answer' ? 'selected="selected"' : ''}} value="map answer">Resposta de Mapeamento</option>
                <option {{$relatorio->estrutura && $relatorio->estrutura[0]['tipo'] == 'setores' ? 'selected="selected"' : ''}} value="setores">Setores</option>
                <option {{$relatorio->estrutura && $relatorio->estrutura[0]['tipo'] == 'areas' ? 'selected="selected"' : ''}} value="areas">Áreas</option>
                <option {{$relatorio->estrutura && $relatorio->estrutura[0]['tipo'] == 'atividades' ? 'selected="selected"' : ''}} value="atividades">Atividades de Tratamento</option>
                <option {{$relatorio->estrutura && $relatorio->estrutura[0]['tipo'] == 'policy management' ? 'selected="selected"' : ''}} value="policy management">Gestão de Políticas</option>
                <option {{$relatorio->estrutura && $relatorio->estrutura[0]['tipo'] == 'maturidade' ? 'selected="selected"' : ''}} value="maturidade">Maturidade</option>
              </select>
            </div>

            <div class="form-group type-drop mb-3" data-type-drop-id="0">
              @if($relatorio->estrutura)
                @if($relatorio->estrutura[0]["tipo"] == "text")
                  <label class="form-label">Descrição:</label>
                  <textarea rows="1" name="estrutura[0][texto]" class="form-control">{{$relatorio->estrutura[0]['titulo']}}</textarea>
                @endif

                @if($relatorio->estrutura[0]["tipo"] == "maturidade")
                  <label class="form-label">Escolha o relatório:</label>
                  <select name="estrutura[0][maturidade]" class="form-select">
                    <option value="">Escolha</option>
                    <option {{isset($relatorio->estrutura[0]['maturidade']) && $relatorio->estrutura[0]['maturidade'] == "ISO_27001" ? 'selected="selected"' : ''}} value="ISO_27001">Sistema de Gestão de Segurança da Informação</option>
                    <option {{isset($relatorio->estrutura[0]['maturidade']) && $relatorio->estrutura[0]['maturidade'] == "ISO_27002" ? 'selected="selected"' : ''}} value="ISO_27002">Proteção de Dados</option>
                    <option {{isset($relatorio->estrutura[0]['maturidade']) && $relatorio->estrutura[0]['maturidade'] == "ISO_27701" ? 'selected="selected"' : ''}} value="ISO_27701">Gestão de Privacidade</option>
                  </select>
                @endif

                @if($relatorio->estrutura[0]["tipo"] == "graphic")
                  <label class="form-label">Escolha o gráfico:</label>
                  <select name="estrutura[0][grafico]" class="form-select">
                    @foreach($graficos as $grafico)
                      <option value="{{$grafico->id}}" {{isset($relatorio->estrutura[0]['grafico']) && $relatorio->estrutura[0]['grafico'] == $grafico->id ? 'selected="selected"' : ''}}>{{$grafico->nome}}</option>
                    @endforeach
                  </select>
                @endif

                @if($relatorio->estrutura[0]["tipo"] == "map answer")
                  <label class="form-label">Escolha o parâmetro:<span class="text-danger">*</span></label>
                  <select name="estrutura[0][map]" required class="form-select select-map">
                    @foreach ($stepKeys as $question)
                        <option {{$relatorio->estrutura && $relatorio->estrutura[0]['map'] == $question["slug"] ? 'selected="selected"' : ''}} value="{{$question["slug"]}}">{{$question["name"]}}</option>
                      @if(isset($question["subitems"]))
                        <optgroup label="Subitems de {{$question["name"]}}">
                        @foreach ($question["subitems"] as $subitem)
                          <option {{$relatorio->estrutura && $relatorio->estrutura[0]['map'] == $subitem["slug"] ? 'selected="selected"' : ''}}  value="{{$subitem["slug"]}}">{{$subitem["name"]}}</option>
                        @endforeach
                        </optgroup>
                      @endif
                    @endforeach
                  </select>
                @endif

                @if($relatorio->estrutura[0]["tipo"] == "setores")
                  <label class="form-label">Setores:</label>
                  <div class="form-control d-flex align-items-center">{{$relatorio->setores_imploded}}</div>
                @endif

                @if($relatorio->estrutura[0]["tipo"] == "areas")
                  <label class="form-label">Áreas:</label>
                  <div class="form-control d-flex align-items-center">{{$relatorio->areas_imploded}}</div>
                @endif

                @if($relatorio->estrutura[0]["tipo"] == "atividades")
                  <label class="form-label">Atividades de Tratamento:</label>
                  <div class="form-control d-flex align-items-center">{{$relatorio->atividades_imploded}}</div>
                @endif
              @endif
            </div>
          </div>

          <div id="form-container" class="mt-2">

            @if($relatorio->estrutura)
              @foreach($relatorio->estrutura as $key => $estrutura)
                @php
                if($loop->first){
                  continue;
                }
                @endphp
                <hr class="my-2 clone-number-{{$key}}">
                <div class="clone-number-{{$key}}">
                  <div class="form-group mb-3">
                    <label class="form-label">Título:<span class="text-danger">*</span></label>
                    <input required="" class="form-control" name="estrutura[{{$key}}][titulo]" value="{{$estrutura["titulo"]}}" type="text">
                  </div>
      
                  <div class="form-group mb-3">
                    <label class="form-label">Descrição:</label>
                    <textarea rows="1" class="form-control" name="estrutura[{{$key}}][descricao]">{{$estrutura["descricao"]}}</textarea>
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label">Tipo de Informação:</label>
                    <select class="type form-select" name="estrutura[{{$key}}][tipo]" data-type-id="{{$key}}">
                      <option value="">Escolha</option>
                      <option {{$estrutura['tipo'] == 'text' ? 'selected="selected"' : ''}} value="text">Texto</option>
                      <option {{$estrutura['tipo'] == 'graphic' ? 'selected="selected"' : ''}} value="graphic">Gráfico</option>
                      <option {{$estrutura['tipo'] == 'map answer' ? 'selected="selected"' : ''}} value="map answer">Resposta de Mapeamento</option>
                      <option {{$estrutura['tipo'] == 'setores' ? 'selected="selected"' : ''}} value="setores">Setores</option>
                      <option {{$estrutura['tipo'] == 'areas' ? 'selected="selected"' : ''}} value="areas">Áreas</option>
                      <option {{$estrutura['tipo'] == 'atividades' ? 'selected="selected"' : ''}} value="atividades">Atividades de Tratamento</option>
                      <option {{$estrutura['tipo'] == 'policy management' ? 'selected="selected"' : ''}} value="policy management">Gestão de Políticas</option>
                      <option {{$estrutura['tipo'] == 'maturidade' ? 'selected="selected"' : ''}} value="maturidade">Maturidade</option>
                    </select>
                  </div>
      
                  <div class="form-group type-drop mb-3" data-type-drop-id="{{$key}}">
                    @if($estrutura["tipo"] == "text")
                      <label class="form-label">Descrição:</label>
                      <textarea rows="1" name="estrutura[{{$key}}][texto]" class="form-control">{{$estrutura['titulo']}}</textarea>
                    @endif

                    @if($estrutura["tipo"] == "maturidade")
                    <label class="form-label">Escolha o relatório:</label>
                    <select name="estrutura[{{$key}}][maturidade]" class="form-select">
                      <option value="">Escolha</option>
                      <option {{isset($estrutura['maturidade']) && $estrutura['maturidade'] == "ISO_27001" ? 'selected="selected"' : ''}} value="ISO_27001">Sistema de Gestão de Segurança da Informação</option>
                      <option {{isset($estrutura['maturidade']) && $estrutura['maturidade'] == "ISO_27002" ? 'selected="selected"' : ''}} value="ISO_27002">Proteção de Dados</option>
                      <option {{isset($estrutura['maturidade']) && $estrutura['maturidade'] == "ISO_27701" ? 'selected="selected"' : ''}} value="ISO_27701">Gestão de Privacidade</option>
                    </select>
                  @endif

                    @if($estrutura["tipo"] == "setores")
                      <label class="form-label">Setores:</label>
                      <div class="form-control d-flex align-items-center">{{$relatorio->setores_imploded}}</div>
                    @endif

                    @if($estrutura["tipo"] == "areas")
                      <label class="form-label">Áreas:</label>
                      <div class="form-control d-flex align-items-center">{{$relatorio->areas_imploded}}</div>
                    @endif

                    @if($estrutura["tipo"] == "atividades")
                      <label class="form-label">Atividades de Tratamento:</label>
                      <div class="form-control d-flex align-items-center">{{$relatorio->atividades_imploded}}</div>
                    @endif
    
                    @if($estrutura["tipo"] == "graphic")
                      <label class="form-label">Escolha o gráfico:</label>
                      <select name="estrutura[{{$key}}][grafico]" class="form-select">
                        @foreach($graficos as $grafico)
                          <option value="{{$grafico->id}}" {{$estrutura['grafico'] == $grafico->id ? 'selected="selected"' : ''}}>{{$grafico->nome}}</option>
                        @endforeach
                      </select>
                    @endif

                    @if($estrutura["tipo"] == "map answer")
                      <label class="form-label">Escolha o parâmetro:<span class="text-danger">*</span></label>
                      <select name="estrutura[{{$key}}][map]" required class="form-select select-map">
                        @foreach ($stepKeys as $question)
                          <option {{$estrutura['map'] == $question["slug"] ? 'selected="selected"' : ''}} value="{{$question["slug"]}}">{{$question["name"]}}</option>
                          @if(isset($question["subitems"]))
                            <optgroup label="Subitems de {{$question["name"]}}">
                            @foreach ($question["subitems"] as $subitem)
                              <option {{$estrutura['map'] == $subitem["slug"] ? 'selected="selected"' : ''}}  value="{{$subitem["slug"]}}">{{$subitem["name"]}}</option>
                            @endforeach
                            </optgroup>
                          @endif
                        @endforeach
                      </select>
                    @endif
                  </div>

                  <a class="btn btn-sm btn-outline-danger" href="javascript:deleteClone('.clone-number-{{$key}}')">Excluir</a>
                </div>
              @endforeach
            @endif

          </div>

          <div id="form-container" class="form-drop"></div>

          <a href="javascript:void(0)" class="mt-4 btn btn-outline-success btn-sm" id="add-field-btn">Adicionar Campo</a>
        </div>
      
        <script>
          $(document).ready(function() {
            $('#add-field-btn').on('click', function() {
              addDynamicField();
            });

            const typeSelect = $('select.type')

            $(document).on('change', 'select.select-map', function() {
              let selectedType = $(this)
              let selectedTypeVal = $(this).val()
              let parent = $(selectedType).parent()

              if(selectedTypeVal == 'dados_pessoais_tratados'){
                let currentName = $(this).attr('name')
                let newName = currentName.replace("[map]", "[filtro]")
                let newSelect = $("<select>").attr('name', newName).addClass('form-select')

                let oldSelect = $(parent).find("select[name='"+newName+"']")
                if(oldSelect.length > 0){
                  $(oldSelect).remove()
                }

                $(newSelect).append('<option value="">Selecione</option>')
                $(newSelect).append('<option value="categoria_do_dado">Categoria do dado</option>')
                $(newSelect).append('<option value="titular_do_dado">Titular do dado</option>')
                $(newSelect).append('<option value="dado_de_crianca_ou_adolescente">Dado de criança ou adolescente</option>')
                $(newSelect).append('<option value="volume_de_titulares">Volume de titulares</option>')

                let div = $('<div>')
                $(parent).append(div)
                $(div).append('<label class="form-label">Filtrar por: <small>(opcional)</small></label>')
                $(div).append(newSelect)
                $(div).addClass('form-group map-filtro mt-3')
              }else{
                $(parent).find('div.map-filtro').remove()
              }


              // console.log(selectedType)
              // console.log(parent)
            })

            $(document).on('change', 'select.type', function() {
              let selectedType = $(this)
              let typeId = selectedType.attr('data-type-id')
              let typeDrop = $('div[data-type-drop-id="'+typeId+'"]')

              if (typeDrop) {
                typeDrop.html('');
              }

              let newLabel, newInput
    
              if (selectedType.val() === 'text') {

                newLabel = '<label class="form-label">Descrição:</label>';
                newInput = $('<textarea>').attr('name', 'estrutura['+typeId+'][texto]').addClass('form-control').attr('rows', 1)

              } else if(selectedType.val() === 'setores') {

                newLabel = '<label class="form-label">Setores:</label>';
                newInput = '<div class="form-control d-flex align-items-center">{{$relatorio->setores_imploded}}</div>'

              } else if(selectedType.val() === 'areas') {

                newLabel = '<label class="form-label">Áreas:</label>';
                newInput = '<div class="form-control d-flex align-items-center">{{$relatorio->areas_imploded}}</div>'

              } else if(selectedType.val() === 'atividades') {

                newLabel = '<label class="form-label">Atividades de Tratamento:</label>';
                newInput = '<div class="form-control d-flex align-items-center">{{$relatorio->atividades_imploded}}</div>'

              } else if (selectedType.val() === 'maturidade') {

                newLabel = '<label class="form-label">Escolha o relatório:</label>';
                newInput = $('<select name="estrutura['+typeId+'][maturidade]">').addClass('form-select');

                $('<option>').val('ISO_27001').text('Sistema de Gestão de Segurança da Informação').appendTo(newInput);
                $('<option>').val('ISO_27002').text('Proteção de Dados').appendTo(newInput);
                $('<option>').val('ISO_27701').text('Gestão de Privacidade').appendTo(newInput);

              } else if (selectedType.val() === 'graphic') {

                newLabel = '<label class="form-label">Escolha o gráfico:</label>';
                newInput = $('<select name="estrutura['+typeId+'][grafico]">').addClass('form-select');

                graficos.map((value, index) => {
                  $('<option>').val(value.id).text(value.nome).appendTo(newInput);
                })

              } else if(selectedType.val() === 'map answer') {

                newLabel = '<label class="form-label">Escolha a pergunta:</label>';
                newInput = $('<select name="estrutura['+typeId+'][map]">').addClass('form-select select-map');
    
                questions.map((value, index) => {
                  $('<option>').val(value.slug).text(value.name).appendTo(newInput);

                  if(value.subitems){
                    let html = `<optgroup label="Subitems de ${value.name}">`
                    
                    value.subitems.map((sValue, sIndex) => {
                      html += `<option value="${sValue.slug}">${sValue.name}</option>`
                    })
                    
                    html += `</optiongroup>`                    

                    $(html).appendTo(newInput)
                  }
                })

              }
    
              typeDrop.append(newLabel);
              typeDrop.append(newInput);
            });

            function addDynamicField() {
              const formOriginal = $('.form-clone')
              const formDrop = $('.form-drop');
              const newForm = formOriginal.clone()
              const count =  Math.floor(Math.random() * (1000 - 1))
              const hr = '<hr class="my-2 clone-number-' + count + '">'
              const selects = newForm.find('select')
              const inputs = newForm.find('input')
              const textareas = newForm.find('textarea')

              $(selects).each(function (index, value){
                let name = $(value).attr('name')
                let newName = name.replace('[0]', '['+count+']')

                $(value).attr('name', newName).val("")
              })

              $(inputs).each(function (index, value){
                let name = $(value).attr('name')
                let newName = name.replace('[0]', '['+count+']')

                $(value).attr('name', newName).val("")
              })

              $(textareas).each(function (index, value){
                let name = $(value).attr('name')
                let newName = name.replace('[0]', '['+count+']')

                $(value).attr('name', newName).val("")
              })

              $(newForm).removeClass('form-clone').addClass('clone-number-' + count)

              let typeDrop = $(newForm).find('.type-drop')
              $(typeDrop).attr('data-type-drop-id', count).html("")

              let typeSelect = $(newForm).find('.type')
              $(typeSelect).attr('data-type-id', count)

              $(newForm).append(`<a class="btn btn-sm btn-outline-danger" href="javascript:deleteClone('.clone-number-${count}')">Excluir</a>`)
                           
              $(formDrop).append(hr)
              $(formDrop).append(newForm)
            }
          });

          function deleteClone(clone){
            $(clone).remove()
          }
        </script>

      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-auto d-flex justify-content-start">
      <a href="/relatorios" class="btn btn-outline-secondary me-4">Cancelar</a>
      <input type="submit" class="btn btn-primary" value="Salvar Relatório" />
    </div>
  </div>

</form>
@endsection