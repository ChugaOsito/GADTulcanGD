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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Inicio Middleware
Route::group(['middleware'=> 'auth'], function(){

//Rutas de Firma Electronica
Route::get('/FormValidarDocFirmado', [App\Http\Controllers\FirmaElectronicaController::class,'FormularioValidar'])->name('FormValidarDocFirmado');
Route::post('/ValidarDocFirmado', [App\Http\Controllers\FirmaElectronicaController::class,'ValidarDoc'])->name('ValidarDocFirmado');
Route::get('/FormFirmarDoc', [App\Http\Controllers\FirmaElectronicaController::class,'FormularioFirma'])->name('FormFirmarDoc');
Route::post('/FirmarDoc', [App\Http\Controllers\FirmaElectronicaController::class,'FirmarDoc'])->name('FirmarDoc');
//Fin Rutas Firma Electronica
Route::get('/EnviarDoc', [App\Http\Controllers\EnviarDocController::class,'getEnviar'])->name('FormularioEnviar');
Route::post('/EnviarDoc', [App\Http\Controllers\EnviarDocController::class,'postEnviar'])->name('FormularioEnviar');
Route::get('/Documentos', [App\Http\Controllers\EnviarDocController::class,'MostrarDocumentos']);
Route::get('/Documento/{id}', [App\Http\Controllers\EnviarDocController::class,'VisualizarDocumento']);
Route::get('/Enviados', [App\Http\Controllers\EnviarDocController::class,'BandejaSalida']);

});

//Inicio Middleware Usuario Administrador
Route::group(['middleware'=> 'admin', 'namespace'=>'Admin'], function(){

    Route::get('/admin', function () {
        return 'Bienvenido a la pantalla de Administracion';
    });
//Inicio Rutas Gestion de usuarios
Route::get('/usuarios', [App\Http\Controllers\UserController::class,'index']);
Route::post('/usuarios', [App\Http\Controllers\UserController::class,'store']);
Route::get('/usuario/{id}', [App\Http\Controllers\UserController::class,'edit']);
Route::post('/usuario/{id}', [App\Http\Controllers\UserController::class,'update']);

//Fin rutas gestion de usuarios
    
    
    
    });
//Fin Middleware Administrador
//Fin Middleware
