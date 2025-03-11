@extends('layouts/contentNavbarLayout', ["container" => "container-xxl col-12 m-w-1120"])
@section('title', 'Adicionar Mapeamento')
@section('content')

@include('_partials.styles.custom-container')
@include('_partials.titles.add-edit', ["title" => "Adicionar Mapeamento"])
@include('_partials.errors')

<script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">

<style>
  .bs-stepper-header{
    overflow-x: hidden;
    -ms-overflow-style: none;
    overflow: -moz-scrollbars-none;
    scrollbar-width: none;
    border: 1px solid rgba(0,0,0,.1);
    border-radius: 4px;
    scrollbar-width: thin;
    cursor: grab;
  }

  .step{
    transition: ease all .3s;
  }

  .step.active,
  .step:hover{
    background-color: rgba(0,0,0,.04);
  }

  .bs-stepper-header:active{
    cursor: grabbing;
  }

  .bs-stepper-header::-webkit-scrollbar {
    width: 0 !important
  }

  .bs-stepper-content,
  .bs-stepper-header{
    border: 1px solid rgba(0,0,0,.1);
    border-radius: 4px;
  }

  .bs-stepper-content {
    padding: 20px;
  }

  .step-clone hr,
  .step-clone-drop hr{
    margin: 40px 0
  }

  .suggestions {
    border: 1px solid #ced4da;
    box-shadow: 0 0 10px #ced4da;
    margin-top: 10px;
    border-radius: 2px;
  }

  .suggestions div {
    padding: 10px;
    cursor: pointer;
    border-bottom: 1px solid #ddd;
    transition: ease all .3s
  }

  .suggestions div:hover{
    background-color: #f5f5f5
  }
</style>

<form action="" id="formMapeamento" method="POST" autocomplete="off">
  @csrf

  <input type="hidden" name="empresa_id" value="{{$empresa_id}}" />
  <input type="hidden" name="mapeamento_id" value="{{request('mapeamento_id')}}" />
  <input type="hidden" name="parent_id" value="{{$mapeamento->parent_id}}" />
  <input type="hidden" name="status" value="{{$mapeamento->status}}" />

  <h4>Informações Básicas</h4>

  <div class="card border shadow-none mt-4">
    <div class="card-body">
      <h5 class="mb-4">Preencha os campos abaixo:</h5>
      <div class="row">
        <div class="col-xl-4 col-12 mb-xl-3 mb-3">
          <div class="form-group">
            <label for="setor" class="form-label">Setor:</label>
            <input type="text" onkeypress="return handleEnter(this, event)" class="form-control" required value="{{$mapeamento->setor}}" id="setor" name="setor" />
          </div>
        </div>
        <div class="col-xl-4 col-12 mb-xl-3 mb-3">
          <div class="form-group">
            <label for="empresa_nome" class="form-label">Empresa:</label>
            <input type="text" onkeypress="return handleEnter(this, event)" class="form-control" readonly value="{{$empresa_nome}}" id="empresa_nome" name="empresa_nome" />
          </div>
        </div>
        <div class="col-xl-4 col-12 mb-xl-0 mb-3">
          <div class="form-group">
            <label for="atividade_tratamento" class="form-label">Atividade de tratamento:</label>
            <input type="text" onkeypress="return handleEnter(this, event)" class="form-control" required value="{{$mapeamento->atividade_tratamento}}" id="atividade_tratamento" name="atividade_tratamento" />
          </div>
        </div>
        <div class="col-xl-3 col-12 mb-xl-0 mb-3">
          <div class="form-group">
            <label for="nome_area" class="form-label">Nome da área:</label>
            <input type="text" onkeypress="return handleEnter(this, event)" class="form-control" required value="{{$mapeamento->nome_area}}" id="nome_area" name="nome_area" />
          </div>
        </div>
        <div class="col-xl-3 col-12 mb-xl-0 mb-3">
          <div class="form-group">
            <label for="nome_entrevistado" class="form-label">Nome do entrevistado:</label>
            <input type="text" onkeypress="return handleEnter(this, event)" class="form-control" required value="{{$mapeamento->nome_entrevistado}}" id="nome_entrevistado" name="nome_entrevistado" />
          </div>
        </div>
        <div class="col-xl-3 col-12 mb-xl-0 mb-3">
          <div class="form-group">
            <label for="nome_entrevistado" class="form-label">Status do Mapeamento:</label>
            <input type="hidden" name="status_antigo" value="{{$mapeamento->status}}">

            @if(Auth::user()->funcao == 'operador')
              @if($mapeamento->status == 'Em andamento')
                <select name="status" id="status" class="form-select">
                  <option {{$mapeamento->status == 'Em andamento' ? 'selected' : ''}} value="Em andamento">Em andamento</option>
                  <option {{$mapeamento->status == 'Em aprovação' ? 'selected' : ''}} value="Em aprovação">Em aprovação</option>
                </select>
              @else
                <div class="d-flex align-items-center" style="height: 39.5px">
                  <span class="badge badge-{{$mapeamento->status_cor}} fs-6 fw-semibold">{{$mapeamento->status}}</span>
                  <input type="hidden" name="status" value="{{$mapeamento->status}}">
                </div>
              @endif
            @else
              <select name="status" id="status" class="form-select">
                <option {{$mapeamento->status == 'Em andamento' ? 'selected' : ''}} value="Em andamento">Em andamento</option>
                <option {{$mapeamento->status == 'Em aprovação' ? 'selected' : ''}} value="Em aprovação">Em aprovação</option>
                <option {{$mapeamento->status == 'Aprovado' ? 'selected' : ''}} value="Aprovado">Aprovado</option>
                {{-- <option {{$mapeamento->status == 'Reprovado' ? 'selected' : ''}} value="Reprovado">Reprovado</option> --}}
              </select>
            @endif
          </div>
        </div>
        <div class="col-xl-3 col-12 mb-xl-0 mb-3">
          <div class="form-group">
            <label for="nome_aprovador" class="form-label">Nome do aprovador:</label>
            <input type="text" onkeypress="return handleEnter(this, event)" class="form-control" value="{{$mapeamento->nome_aprovador}}" id="nome_aprovador" name="nome_aprovador" />
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="bs-stepper my-4" id="stepper">
    <h4>Etapas</h4>
    <div class="bs-stepper-header bg-white" id="bs-stepper-header" role="tablist">
      @foreach ($steps as $key => $step)
        @php
          $step_slug = $step["slug"];
        @endphp
        @php if($step["status"] != "active"){continue;} @endphp
        <div class="step" data-target="#{{$step_slug}}" onclick="jumpTo({{$key}})">
          <button type="button" class="step-trigger" role="tab" aria-controls="{{$step_slug}}" id="{{$step_slug}}-trigger">
            <span class="bs-stepper-circle">{{$key + 1}}</span>
            <span class="bs-stepper-label">{{$step["name"]}}</span>
          </button>
        </div>

        @if($key != count($steps) - 1)
          <div class="line"></div>
        @endif
      @endforeach
    </div>

    <div class="d-flex mt-3 justify-content-between align-items-center">
      <div class="step-point fw-semibold">
        Etapa: <span id="current-step"></span> de {{count($steps)}}
      </div>
    </div>

    <div class="bs-stepper-content mt-3 bg-white">
      @foreach ($steps as $key => $step)
        @php
          $step_slug = $step["slug"];

          if(!isset($step_slug)){
            continue;
          }
        @endphp

        <div id="{{$step_slug}}" class="content" role="tabpanel" aria-labelledby="{{$step_slug}}-trigger">
          <div class="step-clone {{$step_slug}}-step-clone">
            <h5 class="mb-4">Preencha os campos abaixo:</h5>

            <!-- ITEMS INICIO -->
            <div class="row">
              <div class="col-xl-8 col-12">
                <div class="form-group">
                  @if(isset($step["type"]))
                    <label for="{{$step_slug}}" class="form-label">{{$step["name"]}}:</label>
                    @if($step["type"] === "text")
                      <input type="text" onkeypress="return handleEnter(this, event)" id="{{$step_slug}}" data-suggests="{{$step_slug}}_suggestions" class="form-control {{$step_slug}}" value="{{isset($mapeamento["dados"]) && isset($mapeamento["dados"][$step_slug]) ? $mapeamento["dados"][$step_slug][0]["valor"] : ''}}" name="map[{{$step_slug}}][0][valor]" />
                      <div id="{{$step_slug}}_suggestions" class="suggestions hide"></div>
                    @else
                      <select class="form-select" name="map[{{$step_slug}}][0][valor]">
                        <option value="">Selecione</option>
                        @foreach($step["values"] as $value)
                          <option value="{{$value}}" {{isset($mapeamento["dados"]) && $mapeamento["dados"][$step_slug][0]["valor"] == $value ? 'selected' : ''}}>{{$value}}</option>
                        @endforeach
                      </select>
                    @endif
                  @endif

                </div>
              </div>
            </div>
            <!-- ITEMS FIM -->

            <!-- SUBITEMS INICIO -->
            @if(isset($step["subitems"]))
              <div class="card border shadow-none mt-4">
                <div class="card-body" style="padding-bottom: 12px;">
                  <div class="row">
                    @foreach($step["subitems"] as $subitem)
                      @php
                      if($subitem["status"] != "active"){
                        continue;
                      }
                      
                      $subitem_slug = $subitem["slug"];
                      @endphp

                      <!-- STEP CLONE SUBITEM INICIO -->
                      <div class="step-clone {{$subitem_slug}}-step-clone">
                        <div class="col-xl-auto subitems col-12 mb-3">
                          <div class="form-group">
                            <label class="form-label">{{$subitem["name"]}}:</label>

                            @if($subitem["type"] === "text")
                              <input type="text" onkeypress="return handleEnter(this, event)" data-id="0" data-suggests="{{$subitem_slug}}_suggestions" name="map[{{$step_slug}}][0][subitems][{{$subitem_slug}}]" value="{{isset($mapeamento["dados"]) && isset($mapeamento["dados"][$step_slug]) ? $mapeamento["dados"][$step_slug][0]["subitems"][$subitem_slug] : ''}}" class="form-control {{$subitem_slug}}" id="{{$subitem_slug}}" />
                              <div id="{{$subitem_slug}}_suggestions" class="suggestions subitem hide"></div>

                            @elseif($subitem["type"] === "select")
                              <select class="form-select" data-id="0" id="{{$subitem_slug}}" name="map[{{$step_slug}}][0][subitems][{{$subitem_slug}}]">
                                <option value="">Selecione</option>
                                @foreach($subitem["values"] as $value)
                                  <option value="{{$value}}" {{isset($mapeamento["dados"]) && $mapeamento["dados"][$step_slug][0]["subitems"][$subitem_slug] == $value ? 'selected' : ''}}>{{$value}}</option>
                                @endforeach
                              </select>
                            @elseif($subitem["type"] === "radio")
                              @foreach($subitem["values"] as $keyValue => $value)
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" value="{{$value}}" {{isset($mapeamento["dados"]) && $mapeamento["dados"][$step_slug][0]["subitems"][$subitem_slug] == $value ? 'checked' : ''}} name="map[{{$step_slug}}][0][subitems][{{$subitem_slug}}]" id="value_for_{{$subitem_slug}}_{{$keyValue}}" {{$loop->iteration == 1 ? 'checked="checked"' : ''}}>
                                  <label class="form-check-label" for="value_for_{{$subitem_slug}}_{{$keyValue}}">
                                    {{$value}}
                                  </label>
                                </div>
                              @endforeach
                            @endif

                          </div>
                        </div>
                      </div>
                      <!-- STEP CLONE SUBITEM FIM -->

                      @php
                      $totalSubItems = count($step["subitems"])
                      @endphp

                      @if(isset($subitem["duplicate"]) && $subitem["duplicate"])
                        <!-- STEP CLONE DROP SUBITEM INICIO -->
                        <div class="step-clone-drop {{$subitem_slug}}-step-clone-drop">
                          <?php
                          if(isset($mapeamento["dados"]) && isset($mapeamento["dados"][$step_slug]) && isset($mapeamento["dados"][$step_slug])){
                            $m = $mapeamento["dados"][$step_slug][0];

                            if(isset($m["subitems"])){
                            ?>
                              @foreach ($m["subitems"] as $keySubItemClonado => $subItemClonado)
                                @php
                                if($loop->iteration <= $totalSubItems){
                                  continue;
                                }
                                @endphp
                                
                                <div class="step-clone clone-{{$keySubItemClonado}}">
                                  <div class="col-xl-auto subitems col-12 mb-3">
                                    <div class="form-group">
          
                                      <label class="form-label">
                                        {{$subitem["name"]}}:
                                        <img src="{{asset('assets/img/delete.png')}}" alt="Excluir" class="rounded-circle ms-2 cursor-pointer" onclick="removeSubitemClone('{{$keySubItemClonado}}')" style="width: 20px">
                                      </label>
                                      @if($subitem["type"] === "text")
                                        <input type="text" onkeypress="return handleEnter(this, event)" data-id="0" name="map[{{$step_slug}}][0][subitems][{{$keySubItemClonado}}]" value="{{$mapeamento["dados"][$step_slug][0]["subitems"][$keySubItemClonado]}}" class="form-control" id="{{$keySubItemClonado}}" />
                                      @elseif($subitem["type"] === "select")
                                        <select class="form-select" data-id="0" id="{{$keySubItemClonado}}" name="map[{{$step_slug}}][0][subitems][{{$keySubItemClonado}}]">
                                          <option value="">Selecione</option>
                                          @foreach($subitem["values"] as $value)
                                            <option value="{{$value}}" {{$mapeamento["dados"][$step_slug][0]["subitems"][$keySubItemClonado] == $value ? 'selected' : ''}}>{{$value}}</option>
                                          @endforeach
                                        </select>
                                      @elseif($subitem["type"] === "radio")
                                        @foreach($subitem["values"] as $keyValue => $value)
                                          <div class="form-check">
                                            <input class="form-check-input" type="radio" value="{{$value}}" {{$mapeamento["dados"][$step_slug][0]["subitems"][$keySubItemClonado] == $value ? 'checked' : ''}} name="map[{{$step_slug}}][0][subitems][{{$keySubItemClonado}}]" id="value_for_{{$keySubItemClonado}}_{{$keyValue}}">
                                            <label class="form-check-label" for="value_for_{{$keySubItemClonado}}_{{$keyValue}}">
                                              {{$value}}
                                            </label>
                                          </div>
                                        @endforeach
                                      @endif
          
                                    </div>
                                  </div>
                                </div>
                              @endforeach
                            <?php
                            }
                          }
                          ?>
                        
                        </div>
                        <!-- STEP CLONE DROP SUBITEM FIM -->
                        
                        <!-- BUTTON STEP CLONE SUBITEM INICIO -->
                        <div class="col-12 mb-4">
                          <a class="btn btn-sm btn-outline-secondary me-3 mt-2 btnCloneSubItem" onclick="cloneSubitem('{{$subitem_slug}}' ,'{{$subitem_slug}}-step-clone', '{{$subitem_slug}}-step-clone-drop')">+ Adicionar {{$subitem["name"]}}</a>
                        </div>
                        <!-- BUTTON STEP CLONE SUBITEM FIM -->
                      @endif
                    @endforeach
                  </div>
                </div>
              </div>
            @endif
            <!-- SUBITEMS FIM -->
          </div>
         
          <!-- STEP CLONE DROP FROM DB INICIO -->
          <div class="step-clone-drop {{$step_slug}}-step-clone-drop">
            @if(isset($mapeamento["dados"]) && isset($mapeamento["dados"][$step_slug]))
              @foreach($mapeamento["dados"][$step_slug] as $key => $m)
                @php
                // Pula o primeiro item original
                if($key == 0){
                  continue;
                }
                @endphp

                <hr class="hr-{{$step_slug}}-number-{{$key}}">

                <!-- STEP CLONE NUMERED FROM DB INICIO -->
                <div class="step-clone clone-{{$step_slug}}-number-{{$key}}">
                  <h5 class="mb-4 d-flex">
                    Preencha os campos abaixo:
                    <img src="{{asset('assets/img/delete.png')}}" alt="Excluir" class="rounded-circle ms-2 cursor-pointer" onclick="removeClone('{{$step_slug}}',{{$key}})" style="width: 20px">
                  </h5>

                  <div class="row">
                    <div class="col-xl-auto col-12">
                      <div class="form-group">
                        <label class="form-label">{{$step["name"]}}:</label>

                        @if($step["type"] === "text")
                          <input type="text" onkeypress="return handleEnter(this, event)" class="form-control" data-id="{{$key}}" id="{{$step_slug}}" value="{{$m["valor"]}}" name="map[{{$step_slug}}][{{$key}}][valor]" />
                        @else
                          <select class="form-select" data-id="{{$key}}" id="{{$step_slug}}" name="map[{{$step_slug}}][{{$key}}][valor]">
                            <option value="">Selecione</option>
                            @foreach($step["values"] as $value)
                              <option value="{{$value}}" {{$m["valor"] == $value ? 'selected' : ''}}>{{$value}}</option>
                            @endforeach
                          </select>
                        @endif
                      </div>
                    </div>
                  </div>

                  @if(isset($step["subitems"]))
                    <div class="card border shadow-none mt-4">
                      <div class="card-body" style="padding-bottom: 12px;">
                        <div class="row">
                          @foreach ($step["subitems"] as $subitem)
                            @php
                            if($subitem["status"] != "active"){
                              continue;
                            }
                            
                            $subitem_slug = $subitem["slug"];
                            @endphp
                            
                            <!-- STEP CLONE SUBITEM FROM DB INICIO -->
                            <div class="step-clone {{$subitem_slug}}-step-clone_{{$key}}">
                              <div class="col-xl-auto subitems col-12 mb-3">
                                <div class="form-group">
                                  <label class="form-label">{{$subitem["name"]}}:</label>
                                  
                                  @if($subitem["type"] === "text")
                                    <input type="text" onkeypress="return handleEnter(this, event)" data-id="{{$key}}" name="map[{{$step_slug}}][{{$key}}][subitems][{{$subitem_slug}}]" value="{{$m["subitems"][$subitem_slug]}}" class="form-control" id="{{$subitem_slug}}" />
                                  @elseif($subitem["type"] === "select")
                                    <select class="form-select" data-id="{{$key}}" id="{{$subitem_slug}}" name="map[{{$step_slug}}][{{$key}}][subitems][{{$subitem_slug}}]">
                                      <option value="">Selecione</option>
                                      @foreach($subitem["values"] as $value)
                                        <option value="{{$value}}" {{$m["subitems"][$subitem_slug] == $value ? 'selected' : ''}}>{{$value}}</option>
                                      @endforeach
                                    </select>
                                  @elseif($subitem["type"] === "radio")
                                    @foreach($subitem["values"] as $keyValue => $value)
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" value="{{$value}}" {{$m["subitems"][$subitem_slug] == $value ? 'checked' : ''}} name="map[{{$step_slug}}][{{$key}}][subitems][{{$subitem_slug}}]" id="value_for_{{$subitem_slug}}_{{$keyValue}}_{{$key}}">
                                        <label class="form-check-label" for="value_for_{{$subitem_slug}}_{{$keyValue}}_{{$key}}">
                                          {{$value}}
                                        </label>
                                      </div>
                                    @endforeach
                                  @endif
        
                                </div>
                              </div>
                            </div>

                            @php
                            $totalSubItems = count($step["subitems"])
                            @endphp


                            @if(isset($subitem["duplicate"]) && $subitem["duplicate"])
                              <!-- STEP CLONE DROP SUBITEM FROM DB INICIO -->
                              <div class="step-clone-drop {{$subitem_slug}}-step-clone-drop_{{$key}}">

                                <?php
                                if(isset($mapeamento["dados"]) && isset($mapeamento["dados"][$step_slug]) && isset($mapeamento["dados"][$step_slug])){
                                  if(isset($m["subitems"])){
                                  ?>
                                    @foreach ($m["subitems"] as $keySubItemClonado => $subItemClonado)
                                      @php
                                      if($loop->iteration <= $totalSubItems){
                                        continue;
                                      }
                                      @endphp
                                      
                                      <div class="step-clone clone-{{$keySubItemClonado}}">
                                        <div class="col-xl-auto subitems col-12 mb-3">
                                          <div class="form-group">
                
                                            <label class="form-label">
                                              {{$subitem["name"]}}:
                                              <img src="{{asset('assets/img/delete.png')}}" alt="Excluir" class="rounded-circle ms-2 cursor-pointer" onclick="removeSubitemClone('{{$keySubItemClonado}}')" style="width: 20px">
                                            </label>
                                            @if($subitem["type"] === "text")
                                              <input type="text" onkeypress="return handleEnter(this, event)" name="map[{{$step_slug}}][{{$key}}][subitems][{{$keySubItemClonado}}]" value="{{$mapeamento["dados"][$step_slug][$key]["subitems"][$keySubItemClonado]}}" class="form-control" id="{{$keySubItemClonado}}" />
                                            @elseif($subitem["type"] === "select")
                                              <select class="form-select" name="map[{{$step_slug}}][{{$key}}][subitems][{{$keySubItemClonado}}]">
                                                <option value="">Selecione</option>
                                                @foreach($subitem["values"] as $value)
                                                  <option value="{{$value}}" {{$mapeamento["dados"][$step_slug][$key]["subitems"][$keySubItemClonado] == $value ? 'selected' : ''}}>{{$value}}</option>
                                                @endforeach
                                              </select>
                                            @elseif($subitem["type"] === "radio")
                                              @foreach($subitem["values"] as $keyValue => $value)
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" value="{{$value}}" {{$mapeamento["dados"][$step_slug][$key]["subitems"][$keySubItemClonado] == $value ? 'checked' : ''}} name="map[{{$step_slug}}][{{$key}}][subitems][{{$keySubItemClonado}}]" id="value_for_{{$keySubItemClonado}}_{{$keyValue}}">
                                                  <label class="form-check-label" for="value_for_{{$keySubItemClonado}}_{{$keyValue}}">
                                                    {{$value}}
                                                  </label>
                                                </div>
                                              @endforeach
                                            @endif
                
                                          </div>
                                        </div>
                                      </div>
                                    @endforeach
                                  <?php
                                  }
                                }
                                ?>
                              
                              </div>
                              <!-- STEP CLONE DROP SUBITEM FROM DB FIM -->
                              
                              <!-- BUTTON STEP CLONE SUBITEM FROM DB INICIO -->
                              <div class="col-12 mb-4">
                                <a class="btn btn-sm btn-outline-secondary me-3 mt-2 btnCloneSubItem" onclick="cloneSubitem('{{$subitem_slug}}' ,'{{$subitem_slug}}-step-clone', '{{$subitem_slug}}-step-clone-drop_{{$key}}', {{$key}})">+ Adicionar {{$subitem["name"]}}</a>
                              </div>
                              <!-- BUTTON STEP CLONE SUBITEM FROM DB FIM -->
                            @endif



                          @endforeach
                          
                        </div>
                      </div>
                    </div>
                  @endif

                </div>
                <!-- STEP CLONE NUMERED FROM DB FIM -->

              @endforeach
            @endif
          </div>
          <!-- STEP CLONE DROP FROM DB FIM -->

          <div class="step-options d-flex">
            @if($step["duplicate"])
              <a class="btn btn-sm btn-outline-secondary me-3 mt-4" onclick="clone('{{$step_slug}}' ,'{{$step_slug}}-step-clone', '{{$step_slug}}-step-clone-drop')">+ Adicionar</a>
            @endif

            @if($step_slug === 'dados_pessoais_tratados')
              <a class="btn btn-sm btn-outline-success mt-4" href="javascript:void()" data-width="modal-xl" data-bs-toggle="modal" data-bs-target="#modalImportMaps">+ Importar</a>
            @endif

            @if($step_slug === 'medidas_de_seguranca')
              <a class="btn btn-sm btn-outline-success mt-4" href="javascript:void()" data-width="modal-xl" data-bs-toggle="modal" data-bs-target="#modalImportPoliticas">+ Importar</a>
            @endif
          </div>
        </div>
      @endforeach
    </div>
  </div>
  
  <div class="navigator d-flex align-items-center justify-content-center mx-auto" id="col_btn_submit">
    <a class="btn btn-outline-secondary me-3" onclick="previous()">Anterior</a>
    <a class="btn btn-primary me-3" onclick="next()">Avançar</a>
    <input class="btn btn-submit btn-primary" type="submit" {!! Auth::user()->funcao == 'operador' && $mapeamento->status != 'Em andamento' ? 'disabled' : '' !!} value="Salvar Mapeamento" />
  </div>

</form>

@if(isset($parents))
  <h5 class="mt-4">Versões mais recentes</h5>
  <div class="table-responsive text-nowrap table-escala">
    <table class="table table-bordered table-sm table-hover table-striped">
      <thead class="table-dark">
        <tr>
          <th class="text-white">Setor</th>
          <th class="text-white">Área</th>
          <th class="text-white">Ativida de Tratamento</th>
          <th class="text-white">Entrevistado</th>
          <th class="text-white">Status</th>
          <th class="text-white">Data criação</th>
          <th class="text-white">Ações</th>
        </tr>
      </thead>
      <tbody id="mapeamentos">
        @foreach ($parents as $parent)
          <tr>
            <td>
              {{$parent->setor}}
              {!!$parent->parent_id == null ? '<span class="badge bg-primary text-white">Original</span>' : ''!!}
            </td>
            <td>
              {{$parent->nome_area}}
            </td>
            <td>
              {{$parent->atividade_tratamento}}
            </td>
            <td>
              {{$parent->nome_entrevistado}}
            </td>
            <td>
              <span class="badge badge-{{$parent->status_cor}} fs-6 fw-semibold">{{$parent->status}}</span>
            </td>
            <td>
              {{$parent->data_criacao}}
            </td>
            <td class="d-flex">
              @if(!isset($parent->dados))
                <a href="/mapeamento/{{$parent->id}}/mapa/adicionar">
                  <img src="{{ asset('assets/img/create.png') }}" alt="Criar" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Criar" style="width: 21px" data-bs-original-title="" title="">
                </a>
              @else
                <a href="/mapeamento/{{$parent->id}}/mapa/editar">
                  <img src="{{ asset('assets/img/edit.png') }}" alt="Editar mapeamento" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Editar mapeamento" style="width: 21px" data-bs-original-title="" title="">
                </a>
              @endif
              @if(Auth::user()->funcao != 'operador')
                @if($parent->id != $mapeamento->id)
                  <form action="/mapeamento/{{$parent->id}}/deletar?is_parent={{$parent->parent_id != null ? 'true' : 'false'}}" method="POST">
                    @csrf
                    <input type="hidden" name="mapeamento_id" value="{{$parent->id}}">
                    <input type="hidden" name="mapa_id" value="{{$parent->mapa_id}}">
                    <button type="submit" onclick="if(!confirm('Deseja realmente fazer isso?')){ return false }" class="border-0 p-0 ms-2 bg-transparent" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Excluir" data-bs-original-title="" title="">
                      <img src="{{ asset('assets/img/delete.png') }}" alt="Excluir" class="rounded-circle" style="width: 20px">
                    </button>
                  </form>
                @endif
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endif

<script>
  var colSubmit = $('#col_btn_submit');
  
  $("#formMapeamento").submit(function(e){
    $(colSubmit).html('<div class="spinner-border mt-1 text-light" role="status"></div>')
  })
</script>

<div class="modal modal-center fade" id="modalImportMaps" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modalImportMapsTitle">Importar de outro Mapeamento</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <hr>
      <div class="modal-body py-3">

        <h5>Selecione os campos abaixo:</h5>
        <div class="table-responsive text-nowrap table-escala">
          <table class="table table-bordered table-sm table-hover table-striped">
            <thead class="table-dark">
              <tr>
                <th class="text-white"><input type="checkbox" onchange="toggleCheckboxes('check_dados_pessoais_tratados')"></th>
                <th class="text-white">Setor</th>
                <th class="text-white">Dado Pessoal Tratado</th>
                <th class="text-white">Categoria do Dado</th>
                <th class="text-white">Dado de Crianca ou adolescente</th>
                <th class="text-white">Ações</th>
              </tr>
            </thead>
            <tbody>
              @if(isset($dados_pessoais_tratados))
                @foreach($dados_pessoais_tratados as $map)
                  @foreach($map["dados"] as $dados)
                    <tr>
                      <td><input type="checkbox" name="data[]" class="check_dados_pessoais_tratados" data-valor="{{$dados["valor"]}}" data-categoria="{{$dados["subitems"]["categoria_do_dado"]}}" data-titular="{{$dados["subitems"]["titular_do_dado"]}}" data-volume="{{$dados["subitems"]["volume_de_titulares"]}}" data-crianca="{{$dados["subitems"]["dado_de_crianca_ou_adolescente"]}}"></td>
                      <td>{{$map["setor"]}}</td>
                      <td>{{$dados["valor"]}}</td>
                      <td>{{$dados["subitems"]["categoria_do_dado"]}}</td>
                      <td>{{$dados["subitems"]["dado_de_crianca_ou_adolescente"]}}</td>
                      <td><a target="_blank" href="/mapeamento/{{$map['mapeamento_id']}}/mapa/editar">Visualizar <i class="bx bx-link-external"></i></a></td>
                    </tr>
                  @endforeach
                @endforeach
              @endif
            </tbody>
          </table>
        </div>

      </div>
      <div class="modal-footer justify-content-center mt-0">
        <button type="button" class="btn btn-outline-secondary me-3" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success btn-import-selected" disabled>Importar selecionados</button>
      </div>
    </form>
  </div>
</div>

<div class="modal modal-center fade" id="modalImportPoliticas" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modalImportPoliticasTitle">Importar Política e Procedimentos</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <hr>
      <div class="modal-body py-3">

        <h5>Selecione os campos abaixo:</h5>
        <div class="table-responsive text-nowrap table-escala">
          <table class="table table-bordered table-sm table-hover table-striped">
            <thead class="table-dark">
              <tr>
                <th class="text-white"><input type="checkbox" onchange="toggleCheckboxes('check_medidas_de_seguranca')"></th>
                <th class="text-white">Políticas temas</th>
                <th class="text-white">Tipo</th>
                <th class="text-white">Status</th>
                <th class="text-white">Fase</th>
                <th class="text-white">Área</th>
              </tr>
            </thead>
            <tbody>
              @if(!empty($gestao_de_politicas))
                @foreach($gestao_de_politicas as $dados)
                  <tr>
                    <td><input type="checkbox" class="check_medidas_de_seguranca" name="data[]" data-tema="{{$dados["tema"]}}"></td>
                    <td>{{$dados["tema"]}}</td>
                    <td>{{$dados["tipo"]}}</td>
                    <td>{{$dados["status"]}}</td>
                    <td>{{$dados["fase"]}}</td>
                    <td>{{$dados["area"]}}</td>
                  </tr>
                @endforeach
              @endif
            </tbody>
          </table>
        </div>

      </div>
      <div class="modal-footer justify-content-center mt-0">
        <button type="button" class="btn btn-outline-secondary me-3" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success btn-import-selected-pol" disabled>Importar selecionados</button>
      </div>
    </form>
  </div>
</div>

@include('content.mapeamentos.editar_scripts')

<script>
  {!!"var answers = ". json_encode($answers)!!}

  $(document).ready(function () {
    @foreach($answers as $key => $answer)
      $(document).on({
        input: function () {
          suggestWords($(this), answers['{{$key}}']);
        },
        focus: function () {
          suggestWords($(this), answers['{{$key}}']);
        }
      }, 'input.{{$key}}');
    @endforeach

    $(document).on('keydown', function (event) {
      if (event.which === 27) {
        $('.suggestions').empty();
        toggleSuggests('close', '.suggestions')
      }
    });
  });
</script>

<script>
function toggleSuggests(action, input) {
  if(action == 'close'){
    $(input).removeClass('show').addClass('hide')
  }else{
    $(input).removeClass('hide').addClass('show')
  }
}

function suggestWords(input, wordArray) {
  const inputValue = input.val().toLowerCase();
  const inputSuggests = $(input).attr('data-suggests')
  const suggestionsId = $('#' + inputSuggests);
  const suggestionsContainer = $(suggestionsId);

  toggleSuggests('open', suggestionsId)
  suggestionsContainer.empty();

  const matchingWords = wordArray.filter(word => word.toLowerCase().includes(inputValue));

  matchingWords.forEach(word => {
    const suggestionElement = $('<div>').text(word);
    suggestionElement.on('click', () => {
      input.val(word);
      suggestionsContainer.empty();
      toggleSuggests('close', suggestionsId)
    });
    suggestionsContainer.append(suggestionElement);
  });
}

function calcularNivelDeRisco(nivelDeRisco, key) {
  let result

  if (nivelDeRisco > 19) {
    result = "CRÍTICO";
  } else if (nivelDeRisco > 11) {
    result = "ALTO";
  } else if (nivelDeRisco > 5) {
    result = "MÉDIO";
  } else if (nivelDeRisco > 2) {
    result = "BAIXO";
  } else {
    result = "MUITO BAIXO";
  }

  // console.log(result)
  $('input[name="map[gaps]['+key+'][subitems][nivel_do_risco]"]').val(result)
}

$('document').ready(function(){
  var allowedIds = ['nivel_da_probabilidade_de_incidente', 'nivel_do_impacto'];

  $(document).on('change', 'select', function() {
    let currentId = $(this).attr('id')

    if(allowedIds.includes(currentId)){
      let key = $(this).data('id')
      let val1 = $('select[name="map[gaps]['+key+'][subitems][nivel_da_probabilidade_de_incidente]"]').val()
      let val2 = $('select[name="map[gaps]['+key+'][subitems][nivel_do_impacto]"]').val()

      console.log("val1", val1)
      console.log("val2", val2)
      console.log("key", key)

      if(val1 && val2){
        val1 = val1.match(/[0-9]+/)[0];
        val2 = val2.match(/[0-9]+/)[0];
        calcularNivelDeRisco(val1 * val2, key)
      }
    }
  });
})
</script>

@endsection