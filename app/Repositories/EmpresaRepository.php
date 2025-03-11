<?php

namespace App\Repositories;

use App\Interfaces\EmpresaRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\Empresa;
use App\Models\Mapeamento;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class EmpresaRepository implements EmpresaRepositoryInterface
{
  public function findAll()
  {
    $empresas = Empresa::all();

    foreach($empresas as $key => $empresa){
      $mapeamentos = Mapeamento::where('empresa_id', $empresa->id)->count();
      $empresas[$key]["mapeamentos"] = $mapeamentos;
    }

    return $empresas;
  }

  public function findById($id)
  {
    $empresa = Empresa::find($id);
    $mapeamentos = Mapeamento::where('empresa_id', $empresa->id)->count();
    $empresa["mapeamentos"] = $mapeamentos;

    return $empresa;
  }
  
  public function findByMapeamentoId($id)
  {
    $mapeamento = Mapeamento::find($id);
    $empresa = Empresa::find($mapeamento->empresa_id);

    return $empresa;
  }

  public function create($request)
  {
    $query = new Empresa;

    $logo = $request->file('logo');
    $hasPhoto = 0;

    if($logo){
      $uploaded_logo = (new Controller)->storageImage('enterprise_image', $logo, 'empresas');
      $query->logo = $uploaded_logo;
    }else{
      $query->logo = "logo-dark.jpg";
    }

    $query->cnpj = $request->cnpj;
    $query->company_name = $request->company_name;
    $query->contact = $request->contact;
    $query->cep = $request->cep;
    $query->address = $request->address;
    $query->number = $request->number;
    $query->complement = $request->complement;
    $query->neighborhood = $request->neighborhood;
    $query->state = $request->state;
    $query->city = $request->city;
    $query->status = 'active';
    $query->encarregado = $request->encarregado;
    $query->agente_tratamento = $request->agente_tratamento;
    $query->telefone_empresa = $request->telefone_empresa;
    $query->telefone_encarregado = $request->telefone_encarregado;
    $query->email_empresa = $request->email_empresa;
    $query->email_encarregado = $request->email_encarregado;
    $query->save();

    return $query->id;
  }

  public function update($request)
  {
    $query = Empresa::find($request->empresa_id);

    $logo = $request->file('logo');
    $hasPhoto = 0;

    if($logo){
      $uploaded_logo = Controller::storageImage('enterprise_image', $logo, 'empresas');
      $query->logo = $uploaded_logo;
    }

    $query->cnpj = $request->cnpj;
    $query->company_name = $request->company_name;
    $query->contact = $request->contact;
    $query->cep = $request->cep;
    $query->address = $request->address;
    $query->number = $request->number;
    $query->complement = $request->complement;
    $query->neighborhood = $request->neighborhood;
    $query->state = $request->state;
    $query->city = $request->city;
    $query->status = $request->status;
    $query->country = $request->country;
    $query->encarregado = $request->encarregado;
    // $query->tipo_agente = $request->tipo_agente;
    $query->agente_tratamento = $request->agente_tratamento;
    $query->telefone_empresa = $request->telefone_empresa;
    $query->telefone_encarregado = $request->telefone_encarregado;
    $query->email_empresa = $request->email_empresa;
    $query->email_encarregado = $request->email_encarregado;
    $query->save();

    return true;
  }

  public function delete($id)
  {
    $empresa = Empresa::find($id);
    if($empresa){
      $empresa->delete();
    }

    $mapeamentos = Mapeamento::where("empresa_id", $id)->get();
    if($mapeamentos){
      $mapeamentos->each->delete();
    }

    return true;
  }
}