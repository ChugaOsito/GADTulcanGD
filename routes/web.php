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
    return redirect('/Recibidos');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Inicio Middleware
Route::group(['middleware'=> 'auth'], function(){
    //MiPerfil
    Route::get('/MiPerfil/{id}', [App\Http\Controllers\UserController::class,'editprofile']);
Route::post('/MiPerfil/{id}', [App\Http\Controllers\UserController::class,'updateprofile']);
    //FinmI Perfil

//Rutas de Firma Electronica
Route::get('/ValidarDocFirmado/{id}', [App\Http\Controllers\FirmaElectronicaController::class,'ValidarDoc'])->name('ValidarDocFirmado');
Route::get('/FirmarDoc/{id}', [App\Http\Controllers\FirmaElectronicaController::class,'FormularioFirma'])->name('FormFirmarDoc');
Route::post('/FirmarDoc/{id}', [App\Http\Controllers\FirmaElectronicaController::class,'FirmarDoc'])->name('FirmarDoc');
//Fin Rutas Firma Electronica
Route::get('/EnviarDoc', [App\Http\Controllers\EnviarDocController::class,'getEnviar'])->name('FormularioEnviar');
Route::post('/EnviarDoc', [App\Http\Controllers\EnviarDocController::class,'postEnviar'])->name('FormularioEnviar');
Route::get('/Documentos/{id}', [App\Http\Controllers\EnviarDocController::class,'MostrarDocumentos']);
Route::get('/Documento/{id}', [App\Http\Controllers\EnviarDocController::class,'VisualizarDocumento']);
Route::get('/Enviados', [App\Http\Controllers\EnviarDocController::class,'BandejaSalida']);
Route::get('/Recibidos', [App\Http\Controllers\EnviarDocController::class,'BandejaEntrada']);
Route::get('/Editor', [App\Http\Controllers\EnviarDocController::class,'EditorTexto']);
Route::post('/Editor', [App\Http\Controllers\EnviarDocController::class,'DocHtml']);
//Inicio Responder
Route::get('/ResponderDoc/{id}', [App\Http\Controllers\EnviarDocController::class,'getResponder'])->name('FormularioEnviar');
Route::post('/ResponderDoc/{id}', [App\Http\Controllers\EnviarDocController::class,'postResponder'])->name('FormularioEnviar');
Route::get('/EditorResponder/{id}', [App\Http\Controllers\EnviarDocController::class,'EditorTextoResponder']);
Route::post('/EditorResponder/{id}', [App\Http\Controllers\EnviarDocController::class,'DocHtmlResponder']);
Route::get('/Documentos/{id}', [App\Http\Controllers\EnviarDocController::class,'MostrarDocumentos']);
//Fin Responder
Route::get('/Seguimiento/{id}', [App\Http\Controllers\EnviarDocController::class,'Seguimiento']);
Route::get('/12345', function () {
     $pdf = App::make('dompdf.wrapper');
    $pdf->loadHTML('aQUI VA EL HTML');
    return $pdf->stream();
});
//Anexos
Route::get('/Anexos/{id}', [App\Http\Controllers\EnviarDocController::class,'FormularioAnexos'])->name('FormularioAnexos');
Route::post('/Anexos/{id}', [App\Http\Controllers\EnviarDocController::class,'Anexos'])->name('Anexos');
Route::get('/Anexo/{id}/eliminar', [App\Http\Controllers\EnviarDocController::class,'BorrarAnexo'])->name('BorrarAnexo');
Route::get('/VerAnexo/{id}', [App\Http\Controllers\EnviarDocController::class,'VisualizarAnexo']);
//Carpetas
Route::get('/VincularCarpeta/{id}', [App\Http\Controllers\EnviarDocController::class,'FormularioCarpeta']);
Route::post('/VincularCarpeta/{id}', [App\Http\Controllers\EnviarDocController::class,'VincularCarpeta'])->name('VincularCarpeta');;


});
Route::group(['middleware'=> 'admin', 'namespace'=>'Admin'], function(){

   


//Inicio Rutas Gestion de usuarios
Route::get('/usuarios', [App\Http\Controllers\UserController::class,'index']);
Route::post('/usuarios', [App\Http\Controllers\UserController::class,'store']);
Route::get('/usuario/{id}', [App\Http\Controllers\UserController::class,'edit']);
Route::post('/usuario/{id}', [App\Http\Controllers\UserController::class,'update']);
Route::get('/usuario/{id}/eliminar', [App\Http\Controllers\UserController::class,'delete']);
Route::get('/usuario/{id}/restaurar', [App\Http\Controllers\UserController::class,'restore']);

//Fin rutas gestion de usuarios
 

  

    
    
    });

//Inicio Middleware Usuario Super Administrador
Route::group(['middleware'=> 'superadmin', 'namespace'=>'Admin'], function(){
    Route::get('/', function () {
        return redirect('/Dashboard');
    });
  
Route::get('/Dashboard', [App\Http\Controllers\DashboardController::class,'index'])->name('Dashboard');

//Departamento
Route::get('/departamentos', [App\Http\Controllers\DepartamentController::class,'index']);
Route::post('/departamentos', [App\Http\Controllers\DepartamentController::class,'store']);
Route::get('/departamento/{id}', [App\Http\Controllers\DepartamentController::class,'edit']);
Route::post('/departamento/{id}', [App\Http\Controllers\DepartamentController::class,'update']);
Route::get('/departamento/{id}/eliminar', [App\Http\Controllers\DepartamentController::class,'delete']);
Route::get('/departamento/{id}/restaurar', [App\Http\Controllers\DepartamentController::class,'restore']);
//Fin departamento  
//Tratamientos y Tiutulos
Route::get('/tratamientos', [App\Http\Controllers\TreatmentController::class,'index']);
Route::post('/tratamientos', [App\Http\Controllers\TreatmentController::class,'store']);
Route::get('/tratamiento/{id}', [App\Http\Controllers\TreatmentController::class,'edit']);
Route::post('/tratamiento/{id}', [App\Http\Controllers\TreatmentController::class,'update']);
Route::get('/tratamiento/{id}/eliminar', [App\Http\Controllers\TreatmentController::class,'delete']);
Route::get('/tratamiento/{id}/restaurar', [App\Http\Controllers\TreatmentController::class,'restore']);
//Fin Tratamientos y titulos

//Cargos
Route::get('/cargos', [App\Http\Controllers\PositionController::class,'index']);
Route::post('/cargos', [App\Http\Controllers\PositionController::class,'store']);
Route::get('/cargo/{id}', [App\Http\Controllers\PositionController::class,'edit']);
Route::post('/cargo/{id}', [App\Http\Controllers\PositionController::class,'update']);
Route::get('/cargo/{id}/eliminar', [App\Http\Controllers\PositionController::class,'delete']);
Route::get('/cargo/{id}/restaurar', [App\Http\Controllers\PositionController::class,'restore']);
//Fin Cargos
//Tamño Archivos

Route::get('/size/{id}', [App\Http\Controllers\ConfigurationController::class,'edit']);
Route::post('/size/{id}', [App\Http\Controllers\ConfigurationController::class,'update']);
//Fin Tamño Archivos
//Inicio Tipo de documentos
Route::get('/tipos', [App\Http\Controllers\TypeController::class,'index']);
Route::post('/tipos', [App\Http\Controllers\TypeController::class,'store']);
Route::get('/tipo/{id}', [App\Http\Controllers\TypeController::class,'edit']);
Route::post('/tipo/{id}', [App\Http\Controllers\TypeController::class,'update']);
Route::get('/tipo/{id}/eliminar', [App\Http\Controllers\TypeController::class,'delete']);
Route::get('/tipo/{id}/restaurar', [App\Http\Controllers\TypeController::class,'restore']); 
//Fin tipo de documentos
    
    
    });
//Fin Middleware Super Administrador
//Inicio Middleware Jefe de Departamento
Route::group(['middleware'=> 'departamentboss', 'namespace'=>'Admin'], function(){
    Route::get('/', function () {
        return redirect('/Dashboard');
    });
  
//Carpetas
Route::get('/carpetas', [App\Http\Controllers\FolderController::class,'index']);
Route::post('/carpetas', [App\Http\Controllers\FolderController::class,'store']);
Route::get('/carpeta/{id}', [App\Http\Controllers\FolderController::class,'edit']);
Route::post('/carpeta/{id}', [App\Http\Controllers\FolderController::class,'update']);
Route::get('/carpeta/{id}/eliminar', [App\Http\Controllers\FolderController::class,'delete']);
Route::get('/carpeta/{id}/restaurar', [App\Http\Controllers\FolderController::class,'restore']);
//Fin carpetas 

//Inicio Decarga copias de usuarios
Route::get('/DescargarCopia', [App\Http\Controllers\ZipController::class,'index']);
Route::post('/DescargarCopia', [App\Http\Controllers\ZipController::class,'download']);


//Fin Decarga copias de usuarios
    }); 
//Fin middleware jefe de departamento 
//Fin Middleware
