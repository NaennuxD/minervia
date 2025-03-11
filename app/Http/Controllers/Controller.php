<?php

namespace App\Http\Controllers;

use App\Interfaces\EmpresaRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Request as Req;
use Session;
use Image;
use URL;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    private EmpresaRepositoryInterface $empresaRepository;

    public function __construct(
      EmpresaRepositoryInterface $empresaRepository,
    )
    {
      $this->empresaRepository = $empresaRepository;
    }

    public function abortTo($to = '/') {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(redirect($to));
    }

    public function setSession(string $session, string $param)
    {
        return request()->session()->put($session, $param);
    }

    public static function getSession(string $session)
    {
        return request()->session()->get($session);
    }

    public function validateSession()
    {
        $session = $this->getSession(session: 'empresa_nome');

        if(empty($session)){
            $redirectTo = Req::url();
            $this->abortTo('/empresas?status=select&redirectTo='.$redirectTo);
        }
    }

    public static function hasSession()
    {
        return request()->session()->has('empresa_nome');
    }

    public function configureSession()
    {
        $empresaId = request('empresa_id');
        $empresa = $this->empresaRepository->findById($empresaId);

        if(!$empresa){
            return redirect('/mapeamentos?status=error');
        }

        $this->setSession(session: 'empresa_id', param: $empresa->id);
        $this->setSession(session: 'empresa_nome', param: $empresa->company_name);

        if(!empty(request('redirectTo'))){
            return redirect(request('redirectTo'));
        }

        return redirect('/mapeamentos');
    }

    public static function storageImage($prefixName, $uploadedFile, $storagePath, $type = 'image'){
        $extension = 'jpg';
        $filename = $prefixName . '_' . time() . '.'. $extension;

        if($type == 'image'){
            $image = Image::make($uploadedFile->getRealPath());
        }else if($type == 'base64'){
            $image = Image::make($uploadedFile);
        }
        
        $image->resize(1024, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $height = $image->getHeight();
        $width = $image->getWidth();

        $image->resizeCanvas($width, $height, 'center', false, '#ffffff');
        $image->save(storage_path('app/public/uploads/'.$storagePath.'/'.$filename));

        return $storagePath.'/'.$filename;
    }

}
