@extends('layouts/contentNavbarLayout', ["container" => "container-xxl m-w-950"])
@section('title', 'Adicionar ROPA')
@section('content')

<style>
.container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
  max-width: 1400px;
}
</style>

<div class="row py-3 mb-5">
  <div class="col-12 p-xl-0 col-xl-5 align-items-center d-flex">

    <a href="{{ url()->previous() }}" class="mt-1 me-4">
      <img src="{{asset('assets/img/back.png')}}" style="width: 30px" alt="Voltar">
    </a>

    <h1 class="fw-light m-0 text-dark">
      Adicionar ROPA
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
        <div class="col-xl-6 col-md-4 col-12 mb-4">
          <div class="form-group">
            <label for="descricao" class="form-label">Descrição<span class="text-danger">*</span></label>
            <input type="text" name="descricao" required id="descricao" value="{{@old('descricao')}}" class="form-control @error('descricao') is-invalid @enderror" />
          </div>
        </div>
        <div class="col-xl-12 col-12 mb-4">
          <div class="form-group">
            <label for="perguntas" class="form-label">Perguntas<span class="text-danger">*</span></label>
            <ul style="list-style: none;padding: 0;">
              @foreach ($stepKeys as $step)
              @php($key = $loop->iteration)
              <li class="mt-2 mb-2">
                <div class="form-check">
                  <input class="form-check-input" name="perguntas[{{$key}}][slug]" type="checkbox" value="{{$step["slug"]}}" id="{{$step["slug"]}}">
                  <label class="form-check-label" for="{{$step["slug"]}}">
                    {{$step["name"]}}
                  </label>
                </div>
              </li>
                @if(isset($step["subitems"]))
                  <ul>
                    @foreach ($step["subitems"] as $subitem)
                    @php($subKey = $loop->iteration)
                    <li @if($loop->last) class="mb-2" @endif>
                      <div class="form-check">
                        <input class="form-check-input" name="perguntas[{{$key}}][subitems][{{$subKey}}][slug]" type="checkbox" value="{{$subitem["slug"]}}" id="{{$subitem["slug"]}}">
                        <label class="form-check-label" for="{{$subitem["slug"]}}">
                          {{$subitem["name"]}}
                        </label>
                      </div>
                    </li>
                    @endforeach
                  </ul>
                @endif
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-auto d-flex justify-content-start">
      <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-4">Cancelar</a>
      <input type="submit" class="btn btn-primary" value="Adicionar" />
    </div>
  </div>

</form>
@endsection