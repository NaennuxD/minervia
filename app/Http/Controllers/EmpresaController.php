<?php

namespace App\Http\Controllers;

use App\Interfaces\EmpresaRepositoryInterface;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
  private EmpresaRepositoryInterface $empresaRepository;

  public function __construct(
    EmpresaRepositoryInterface $empresaRepository,
  )
  {
    $this->empresaRepository = $empresaRepository;
  }

  public function findAll()
  {
    $empresas = $this->empresaRepository->findAll();

    return view('content.empresas.listar')->with([
      "empresas" => $empresas
    ]);
  }
  
  public function create()
  {
    return view('content.empresas.adicionar');
  }

  public function handleCreate(Request $request)
  {
    $empresaId = $this->empresaRepository->create($request);

    if(!empty($request->return_url)){
      return redirect($request->return_url.'?status=success&empresa_id='.$empresaId);
    }

    return redirect('/empresas?status=success');
  }

  public function delete()
  {
    $empresaId = request('empresa_id');
    $this->empresaRepository->delete($empresaId);

    return redirect('/empresas?status=success');
  }

  public function update()
  {
    $empresaId = request('empresa_id');
    $empresa = $this->empresaRepository->findById($empresaId);

    return view('content.empresas.editar')->with([
      "empresa" => $empresa
    ]);
  }

  public function handleUpdate(Request $request)
  {
    $this->empresaRepository->update($request);

    return redirect('/empresas?status=success');
  }
}

