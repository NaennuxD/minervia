<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\ClienteRepositoryInterface;
use App\Repositories\ClienteRepository;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Interfaces\EmpresaRepositoryInterface;
use App\Repositories\EmpresaRepository;
use App\Interfaces\MapeamentoRepositoryInterface;
use App\Repositories\MapeamentoRepository;
use App\Interfaces\GraficoRepositoryInterface;
use App\Repositories\GraficoRepository;
use App\Interfaces\RopaRepositoryInterface;
use App\Repositories\RopaRepository;
use App\Interfaces\ParametroRepositoryInterface;
use App\Repositories\ParametroRepository;
use App\Interfaces\RelatorioRepositoryInterface;
use App\Repositories\RelatorioRepository;
use App\Interfaces\ISORepositoryInterface;
use App\Repositories\ISORepository;
use App\Interfaces\PoliticaRepositoryInterface;
use App\Repositories\PoliticaRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() 
    {
        $this->app->bind(PoliticaRepositoryInterface::class, PoliticaRepository::class);
        $this->app->bind(ISORepositoryInterface::class, ISORepository::class);
        $this->app->bind(RelatorioRepositoryInterface::class, RelatorioRepository::class);
        $this->app->bind(ParametroRepositoryInterface::class, ParametroRepository::class);
        $this->app->bind(RopaRepositoryInterface::class, RopaRepository::class);
        $this->app->bind(GraficoRepositoryInterface::class, GraficoRepository::class);
        $this->app->bind(MapeamentoRepositoryInterface::class, MapeamentoRepository::class);
        $this->app->bind(EmpresaRepositoryInterface::class, EmpresaRepository::class);
        $this->app->bind(ClienteRepositoryInterface::class, ClienteRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}