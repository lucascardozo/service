<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public 
Route::get('/', 'App\Http\Controllers\LoginController@index')->name('login');
Route::get('/login/{error?}', 'App\Http\Controllers\LoginController@index')->name('login');
Route::post('/login', 'App\Http\Controllers\LoginController@logar')->name('login');

// Private Routes
Route::middleware('autenticacao','dados.user','log.acesso')->prefix('/admin')->group(function(){

    // importants
    Route::get('/', 'App\Http\Controllers\HomeController@index')->name("admin.home");
    Route::get('/home', 'App\Http\Controllers\HomeController@index')->name("admin.home");
    Route::get('/logs', 'App\Http\Controllers\LogsController@index')->name("admin.logs");
    Route::post('/logs', 'App\Http\Controllers\LogsController@index')->name("admin.logs");
    Route::get('/sair', 'App\Http\Controllers\LoginController@sair')->name("admin.sair");

    // Backups
    Route::get('/backups', 'App\Http\Controllers\BackupController@index')->name("admin.backups");
    Route::get('/backups/gerar/', 'App\Http\Controllers\BackupController@gerar')->name("admin.backups.gerar");
    Route::get('/backups/download/{file}', 'App\Http\Controllers\BackupController@download')->name("admin.backups.download");
    Route::get('/backups/deletar/{id}', 'App\Http\Controllers\BackupController@deletar')->name("admin.backups.deletar");

    // Group routes
    Route::get('/grupos', 'App\Http\Controllers\GruposController@index')->name("admin.grupos");
    Route::post('/grupos/listar', 'App\Http\Controllers\GruposController@show')->name("admin.grupos.listar");
    Route::post('/grupos/cadastrar', 'App\Http\Controllers\GruposController@create')->name("admin.grupos.cadastrar");
    Route::post('/grupos/editar', 'App\Http\Controllers\GruposController@update')->name("admin.grupos.editar");
    Route::post('/grupos/obter', 'App\Http\Controllers\GruposController@obter')->name("admin.grupos.obter");
    Route::post('/grupos/deletar', 'App\Http\Controllers\GruposController@delete')->name("admin.grupos.deletar");

    // Group routes
    Route::get('/categorias', 'App\Http\Controllers\CategoriasController@index')->name("admin.categorias");
    Route::post('/categorias/listar', 'App\Http\Controllers\CategoriasController@show')->name("admin.categorias.listar");
    Route::post('/categorias/cadastrar', 'App\Http\Controllers\CategoriasController@create')->name("admin.categorias.cadastrar");
    Route::post('/categorias/editar', 'App\Http\Controllers\CategoriasController@update')->name("admin.categorias.editar");
    Route::post('/categorias/obter', 'App\Http\Controllers\CategoriasController@obter')->name("admin.categorias.obter");
    Route::post('/categorias/deletar', 'App\Http\Controllers\CategoriasController@delete')->name("admin.categorias.deletar");

    // User routes
    Route::get('/usuarios', 'App\Http\Controllers\UsuariosController@index')->name("admin.usuarios");
    Route::post('/usuarios/listar', 'App\Http\Controllers\UsuariosController@show')->name("admin.usuarios.listar");
    Route::post('/usuarios/cadastrar', 'App\Http\Controllers\UsuariosController@create')->name("admin.usuarios.cadastrar");
    Route::post('/usuarios/editar', 'App\Http\Controllers\UsuariosController@update')->name("admin.usuarios.editar");
    Route::post('/usuarios/obter', 'App\Http\Controllers\UsuariosController@obter')->name("admin.usuarios.obter");
    Route::post('/usuarios/editarSenha', 'App\Http\Controllers\UsuariosController@updateSenha')->name("admin.usuarios.editarSenha");
    Route::post('/usuarios/obterSenha', 'App\Http\Controllers\UsuariosController@obterSenha')->name("admin.usuarios.obterSenha");
    Route::post('/usuarios/deletar', 'App\Http\Controllers\UsuariosController@delete')->name("admin.usuarios.deletar");

    // Perfil
    Route::get('/perfil', 'App\Http\Controllers\UsuariosController@perfil')->name("admin.perfil");
    Route::post('/perfil/editar', 'App\Http\Controllers\UsuariosController@updatePerfil')->name("admin.perfil.editar");
    Route::post('/perfil/editarSenha', 'App\Http\Controllers\UsuariosController@updateSenha')->name("admin.perfil.editarSenha");
    Route::get('/fotoPerfil', 'App\Http\Controllers\UsuariosController@fotoPerfil')->name("admin.fotoPerfil");
    Route::post('/perfil/fotoCrop', 'App\Http\Controllers\UsuariosController@fotoCrop')->name("admin.perfil.fotoCrop");
    Route::get('/foto/{id}', 'App\Http\Controllers\UsuariosController@foto')->name("admin.foto");

    // Atendimentos routes
    Route::get('/atendimentos', 'App\Http\Controllers\AtendimentosController@index')->name("admin.atendimentos");
    Route::post('/atendimentos/listar', 'App\Http\Controllers\AtendimentosController@show')->name("admin.atendimentos.listar");
    Route::post('/atendimentos/cadastrar', 'App\Http\Controllers\AtendimentosController@create')->name("admin.atendimentos.cadastrar");
    Route::post('/atendimentos/editar', 'App\Http\Controllers\AtendimentosController@update')->name("admin.atendimentos.editar");
    Route::post('/atendimentos/obter', 'App\Http\Controllers\AtendimentosController@obter')->name("admin.atendimentos.obter");
    Route::post('/atendimentos/deletar', 'App\Http\Controllers\AtendimentosController@delete')->name("admin.atendimentos.deletar");

    // Report
    Route::post('/relatorio','App\Http\Controllers\ReportsController@relatorioUsuarios')->name("admin.report.user");
    Route::post('/relatorio-atendimentos','App\Http\Controllers\ReportsController@relatorioAtendimentos')->name("admin.report.atendimentos");

    // Charts
    Route::get('/listAtendimentos','App\Http\Controllers\ChartsController@listAtendimentos')->name("admin.charts.atendimentos");
    Route::get('/listAtendimentosMes','App\Http\Controllers\ChartsController@listAtendimentosMes')->name("admin.charts.atendimentos.mes");
    Route::get('/listAtendimentosCategorias','App\Http\Controllers\ChartsController@listAtendimentosCategorias')->name("admin.charts.atendimentos.categorias");
    
});

// Fallback function
Route::fallback(function(){
    return view('404');
});
