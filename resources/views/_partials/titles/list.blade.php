<div class="row py-3 mb-5">
  <div class="col-auto">
    <h1 class="fw-light m-0 text-dark">
      {{$title}} ({{$count}})
    </h1>
  </div>

  @if(Auth::user()->funcao != 'operador')
    <div class="col">
      <a href="{{$url}}" class="btn btn-primary"> <i class="bx bx-plus"></i> Adicionar novo</a>
    </div>
  @endif
</div>