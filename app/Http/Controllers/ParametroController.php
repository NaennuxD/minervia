<?php

namespace App\Http\Controllers;

use App\Interfaces\ParametroRepositoryInterface;
use App\Interfaces\MapeamentoRepositoryInterface;
use App\Interfaces\EmpresaRepositoryInterface;
use Illuminate\Http\Request;

class ParametroController extends Controller
{
  private ParametroRepositoryInterface $parametroRepository;
  private MapeamentoRepositoryInterface $mapeamentoRepository;
  private EmpresaRepositoryInterface $empresaRepository;

  public function __construct(
    ParametroRepositoryInterface $parametroRepository,
    MapeamentoRepositoryInterface $mapeamentoRepository,
    EmpresaRepositoryInterface $empresaRepository
  )
  {
    $this->parametroRepository = $parametroRepository;
    $this->empresaRepository = $empresaRepository;
    $this->mapeamentoRepository = $mapeamentoRepository;
  }

  public function findAll()
  {
    $parametros = $this->parametroRepository->findAll();

    return view('content.parametros.listar', compact('parametros'));
  }

  public function create()
  {
    return view('content.parametros.adicionar');
  }

  public function handleCreate(Request $request)
  {
    $parametro_id = $this->parametroRepository->create($request);
    return redirect('/parametros?status=success');
  }

  public function update()
  {
    $parametroId = request('parametro_id');
    $parametros = $this->parametroRepository->findById($parametroId);

    return view('content.parametros.editar')->with([
      "parametro" => $parametros
    ]);
  }

  public function handleUpdate(Request $request)
  {
    $this->parametroRepository->update($request);

    return redirect('/parametros?status=success');
  }

  public function delete(Request $request)
  {
    $parametroId = $request->parametro_id;
    $this->parametroRepository->delete($parametroId);

    return redirect('/parametros?status=success');
  }
}
