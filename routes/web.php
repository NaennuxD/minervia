<?php
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:administrador|aprovador|operador'])->group(function () {
    Route::get('/', 'App\Http\Controllers\dashboard\Dashboard@index')->name('dashboard');
    Route::get('/logout', 'App\Http\Controllers\dashboard\Dashboard@logout')->name('logout');

    Route::get('/configurar/empresa/{empresa_id}', 'App\Http\Controllers\Controller@configureSession')->where('empresa_id', '[0-9]+');

    Route::get('/empresas', 'App\Http\Controllers\EmpresaController@findAll')->name('empresas');
    Route::get('/empresa/{empresa_id}/editar', 'App\Http\Controllers\EmpresaController@update')->where('empresa_id', '[0-9]+')->name('empresas');

    Route::get('/mapeamentos', 'App\Http\Controllers\MapeamentoController@findAll')->name('mapeamentos');
    Route::get('/mapeamento/{mapeamento_id}/mapa/editar', 'App\Http\Controllers\MapeamentoController@updateMap')->where('mapeamento_id', '[0-9]+')->where('mapa_id', '[0-9]+')->name('mapeamentos');
    Route::get('/mapeamento/{mapeamento_id}/mapas/listar', 'App\Http\Controllers\MapeamentoController@showMaps')->where('mapeamento_id', '[0-9]+')->where('mapa_id', '[0-9]+')->name('mapeamentos');
    Route::get('/mapeamento/{mapeamento_id}/mapa/editar', 'App\Http\Controllers\MapeamentoController@updateMap')->where('mapeamento_id', '[0-9]+')->where('mapa_id', '[0-9]+')->name('mapeamentos');
    Route::post('/mapeamento/{mapeamento_id}/mapa/editar', 'App\Http\Controllers\MapeamentoController@handleUpdateMap')->where('mapeamento_id', '[0-9]+')->where('mapa_id', '[0-9]+')->name('mapeamentos');
});

Route::middleware('auth')->group(function () {
    Route::get('/primeiro-acesso', 'App\Http\Controllers\UserController@firstAccess')->name('primeiro-acesso');
    Route::post('/primeiro-acesso', 'App\Http\Controllers\UserController@handleFirstAccess');
});

Route::middleware(['auth', 'role:administrador|aprovador'])->group(function(){
    Route::get('/graficos', 'App\Http\Controllers\GraficosController@findAll')->name('graficos');
    Route::get('/grafico/adicionar', 'App\Http\Controllers\GraficosController@create')->name('graficos');
    Route::post('/grafico/adicionar', 'App\Http\Controllers\GraficosController@handleCreate')->name('graficos');
    Route::get('/grafico/{grafico_id}/editar', 'App\Http\Controllers\GraficosController@update')->where('grafico_id', '[0-9]+')->name('graficos');
    Route::post('/grafico/{grafico_id}/editar', 'App\Http\Controllers\GraficosController@handleUpdate')->where('grafico_id', '[0-9]+')->name('graficos');
    Route::post('/grafico/{grafico_id}/deletar', 'App\Http\Controllers\GraficosController@delete')->where('grafico_id', '[0-9]+')->name('graficos');

    Route::get('/ropas', 'App\Http\Controllers\ROPAController@findAll')->name('ropas');
    Route::get('/ropa/adicionar', 'App\Http\Controllers\ROPAController@create')->name('ropas');
    Route::post('/ropa/adicionar', 'App\Http\Controllers\ROPAController@handleCreate')->name('ropas');
    Route::get('/ropa/{ropa_id}/editar', 'App\Http\Controllers\ROPAController@update')->where('ropa_id', '[0-9]+')->name('ropas');
    Route::post('/ropa/{ropa_id}/editar', 'App\Http\Controllers\ROPAController@handleUpdate')->where('ropa_id', '[0-9]+')->name('ropas');
    Route::post('/ropa/{ropa_id}/deletar', 'App\Http\Controllers\ROPAController@delete')->where('ropa_id', '[0-9]+')->name('ropas');
    Route::get('/ropa/{ropa_id}/visualizar', 'App\Http\Controllers\ROPAController@show')->where('ropa_id', '[0-9]+')->name('ropas');

    Route::get('/relatorios', 'App\Http\Controllers\RelatorioController@findAll')->name('relatorios');
    Route::get('/relatorio/adicionar', 'App\Http\Controllers\RelatorioController@create')->name('relatorios');
    Route::post('/relatorio/adicionar', 'App\Http\Controllers\RelatorioController@handleCreate')->name('relatorios');
    Route::get('/relatorio/{relatorio_id}/configurar', 'App\Http\Controllers\RelatorioController@configure')->where('relatorio_id', '[0-9]+')->name('relatorios');
    Route::post('/relatorio/{relatorio_id}/configurar', 'App\Http\Controllers\RelatorioController@handleConfigure')->where('relatorio_id', '[0-9]+')->name('relatorios');
    Route::post('/relatorio/{relatorio_id}/deletar', 'App\Http\Controllers\RelatorioController@delete')->where('relatorio_id', '[0-9]+')->name('relatorios');
    Route::get('/relatorio/{relatorio_id}/visualizar', 'App\Http\Controllers\RelatorioController@show')->where('relatorio_id', '[0-9]+')->name('relatorios');

    Route::get('/empresa/adicionar', 'App\Http\Controllers\EmpresaController@create')->name('empresas');
    Route::post('/empresa/adicionar', 'App\Http\Controllers\EmpresaController@handleCreate')->name('empresas');
    Route::post('/empresa/{empresa_id}/editar', 'App\Http\Controllers\EmpresaController@handleUpdate')->where('empresa_id', '[0-9]+')->name('empresas');
    Route::post('/empresa/{empresa_id}/deletar', 'App\Http\Controllers\EmpresaController@delete')->name('empresas');

    Route::get('/mapeamento/adicionar', 'App\Http\Controllers\MapeamentoController@create')->name('mapeamentos');
    Route::post('/mapeamento/adicionar', 'App\Http\Controllers\MapeamentoController@handleCreate')->name('mapeamentos');
    Route::post('/mapeamento/{mapeamento_id}/deletar', 'App\Http\Controllers\MapeamentoController@delete')->name('mapeamentos');
    Route::get('/mapeamento/{mapeamento_id}/mapa/adicionar', 'App\Http\Controllers\MapeamentoController@createMap')->where('mapeamento_id', '[0-9]+')->name('mapeamentos');
    Route::post('/mapeamento/{mapeamento_id}/mapa/adicionar', 'App\Http\Controllers\MapeamentoController@handleCreateMap')->where('mapeamento_id', '[0-9]+')->name('mapeamentos');

    Route::get('/maturidade/adicionar', 'App\Http\Controllers\ISOController@create')->name('isos');
    Route::post('/maturidade/adicionar', 'App\Http\Controllers\ISOController@handleCreate')->name('isos');
    Route::post('/maturidade/{iso_id}/deletar', 'App\Http\Controllers\ISOController@delete')->name('isos');
    Route::get('/maturidade/{iso_id}/configurar', 'App\Http\Controllers\ISOController@configure')->where('iso_id', '[0-9]+')->name('isos');
    Route::post('/maturidade/{iso_id}/configurar', 'App\Http\Controllers\ISOController@handleConfigure')->where('iso_id', '[0-9]+')->name('isos');
    Route::get('/maturidades', 'App\Http\Controllers\ISOController@findAll')->name('isos');

    Route::get('/politica/adicionar', 'App\Http\Controllers\PoliticasController@create')->name('politicas');
    Route::post('/politica/adicionar', 'App\Http\Controllers\PoliticasController@handleCreate')->name('politicas');
    Route::post('/politica/{politica_id}/deletar', 'App\Http\Controllers\PoliticasController@delete')->name('politicas');
    Route::get('/politica/{politica_id}/configurar', 'App\Http\Controllers\PoliticasController@configure')->where('politica_id', '[0-9]+')->name('politicas');
    Route::post('/politica/{politica_id}/configurar', 'App\Http\Controllers\PoliticasController@handleConfigure')->where('politica_id', '[0-9]+')->name('politicas');
    Route::get('/politicas', 'App\Http\Controllers\PoliticasController@findAll')->name('politicas');

    Route::get('/usuarios', 'App\Http\Controllers\UserController@show')->name('usuarios');
    Route::get('/usuario/{usuario_id}/edit', 'App\Http\Controllers\UserController@update')->name('usuarios');
    Route::post('/usuario/{usuario_id}/edit', 'App\Http\Controllers\UserController@handleUpdate')->name('usuarios');
    Route::get('/usuario/adicionar', 'App\Http\Controllers\UserController@create')->name('usuarios');
    Route::post('/usuario/adicionar', 'App\Http\Controllers\UserController@handleCreate')->name('usuarios');
    Route::post('/usuario/{usuario_id}/delete', 'App\Http\Controllers\UserController@delete')->name('usuarios');

    Route::get('/parametros', 'App\Http\Controllers\ParametroController@findAll')->name('parametros');
    Route::get('/parametro/{parametro_id}/editar', 'App\Http\Controllers\ParametroController@update')->name('parametros');
    Route::post('/parametro/{parametro_id}/editar', 'App\Http\Controllers\ParametroController@handleUpdate')->name('parametros');
    Route::get('/parametro/adicionar', 'App\Http\Controllers\ParametroController@create')->name('parametros');
    Route::post('/parametro/adicionar', 'App\Http\Controllers\ParametroController@handleCreate')->name('parametros');
    Route::post('/parametro/{parametro_id}/deletar', 'App\Http\Controllers\ParametroController@delete')->name('parametros');
});

Route::middleware(['auth', 'role:aprovador|operador'])->group(function () {

});

Route::middleware('guest')->group(function(){
    Route::get('/login', 'App\Http\Controllers\authentications\Login@index')->name('login');
    Route::post('/login', 'App\Http\Controllers\authentications\Login@auth')->name('auth');

    // Route::get('/register', 'App\Http\Controllers\authentications\Register@index')->name('register');
    // Route::post('/register', 'App\Http\Controllers\authentications\Register@save')->name('new_register');
    
    // Route::get('/forgot-password', 'App\Http\Controllers\authentications\ForgotPassword@request')->name('forgot-password');
    // Route::post('/forgot-password', 'App\Http\Controllers\authentications\ForgotPassword@email')->name('password-email');
    
    // Route::post('/reset-password', 'App\Http\Controllers\authentications\ForgotPassword@update')->name('password-update');
    // Route::get('/reset-password/{token}', 'App\Http\Controllers\authentications\ForgotPassword@reset')->name('password.reset');
});