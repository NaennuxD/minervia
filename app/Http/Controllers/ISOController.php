<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\ISORepositoryInterface;

class ISOController extends Controller
{
  private ISORepositoryInterface $isoRepository;

  public function __construct(
    ISORepositoryInterface $isoRepository,
  )
  {
    $this->isoRepository = $isoRepository;
  }

  public function findAll()
  {
    $this->validateSession();
    $isos = $this->isoRepository->findAll();

    return view('content.isos.listar', compact('isos'));
  }

  public function create()
  {
    $this->validateSession();
    return view('content.isos.adicionar');
  }

  public function handleCreate(Request $request)
  {
    $this->validateSession();

    $iso_id = $this->isoRepository->create($request);
    return redirect('/maturidade/'.$iso_id.'/configurar');
  }

  public function configure(Request $request)
  {
    $this->validateSession();
    $isoId = $request->iso_id;
    $empresaId = Controller::getSession('empresa_id');

    $isos = $this->isoRepository->findById($isoId);

    if(!$isos){
      return redirect('/privacidades');
    }

    if($isos->iso == 'ISO_27001'){
      $steps = $this->isoRepository->stepsISO_27001();
    }elseif($isos->iso == 'ISO_27002'){
      $steps = $this->isoRepository->stepsISO_27002();
    }else{
      $steps = $this->isoRepository->stepsISO_27701();
    }

    // return $isos;

    return view('content.isos.'.$isos->iso.'.configurar', compact('isos', 'steps'));
  }

  public function handleConfigure(Request $request)
  {
    $this->validateSession();
    $this->isoRepository->configure($request);

    return redirect('/maturidade/'.$request->iso_id.'/configurar?status=success');
  }

  public function delete(Request $request)
  {
    $this->validateSession();
    $id = $this->isoRepository->delete($request);
  
    return redirect('/maturidades?status=success');
  }
}
