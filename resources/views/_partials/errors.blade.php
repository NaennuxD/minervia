@if($errors->any())
  <div class="alert alert-danger" role="alert">
    <p class="m-0 fw-bold mb-1">Ops. Algo deu errado!</p>
    <ul class="list-unstyled m-0">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif