@extends('layouts/contentNavbarLayout', ["container" => "container-xxl col-12 m-w-1220"])
@section('title', '('.$relatorios->total().') Relatórios')
@section('content')

@include('_partials.styles.custom-container')
@include('_partials.titles.list', ["title" => "Relatório", "count" => count($relatorios), "url" => "/relatorio/adicionar"])
@include('_partials.errors')

@if(!count($relatorios))
  <div class="alert alert-dark" role="alert">
    <ul class="list-unstyled m-0">
      <li>Você não inseriu relatorios ainda.</li>
    </ul>
  </div>
@else
  <div class="table-responsive text-nowrap table-escala">
    <table class="table table-bordered table-sm table-hover table-striped">
      <thead class="table-dark">
        <tr>
          <th class="text-white">Descrição</th>
          <th class="text-white">Setores</th>
          <th class="text-white">Áreas</th>
          <th class="text-white">Atividades</th>
          <th class="text-white">Tipo</th>
          <th class="text-white text-center">Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($relatorios as $relatorio)
          <tr>
            <td>{{$relatorio->descricao}}</td>
            <td>{{$relatorio->setores ? $relatorio->setores : 'Todos'}}</td>
            <td>{{$relatorio->areas ? $relatorio->areas : 'Todos'}}</td>
            <td>{{$relatorio->atividades ? $relatorio->atividades : 'Todos'}}</td>
            <td>{{$relatorio->tipo_relatorio}}</td>
            <td class="d-flex">
              <a target="_blank" href="relatorio/{{$relatorio->id}}/visualizar">Visualizar <i class="bx bx-link-external"></i></a>

              <a href="relatorio/{{$relatorio->id}}/configurar" class="ms-3 me-1">
                <img src="{{asset('assets/img/edit.png')}}" alt="Editar" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Editar" style="width: 21px" />
              </a>

              <form action="relatorio/{{$relatorio->id}}/deletar" method="POST">
                @csrf
                <input type="hidden" name="relatorio_id" value="{{$relatorio->id}}">
                <button type="submit" onclick="if(!confirm('Deseja realmente fazer isso?')){ return false }" class="border-0 p-0 ms-2 bg-transparent" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Excluir">
                  <img src="{{asset('assets/img/delete.png')}}" alt="Deletar" class="rounded-circle" style="width: 20px" />
                </button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  @if($relatorios->hasPages())
    <div class="mt-2 pagination">
      {{$relatorios->links()}}
    </div>
  @endif
@endif

@endsection