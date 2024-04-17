<?php

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

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


Auth::routes();


// Inicio / Home
Route::get('/', 'HomeController@index')->name('index');
Route::get('login', 'HomeController@login')->name('login');




// Clientes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', 'HomeController@index')->name('index');

    Route::resource('usuarios', 'UserController')->middleware('permiso');
    Route::resource('cliente', 'ClienteController')->middleware('permiso');
    Route::resource('aval', 'AvalController')->middleware('permiso');
    Route::resource('solicitud', 'SolicitudController')->middleware('permiso');
    Route::resource('analisis_credito', 'AnalisisController')->middleware('permiso');
    Route::resource('desembolso', 'DesembolsoController')->middleware('permiso');
    Route::resource('pagos_masivos', 'PagosMasivosController')->middleware('permiso');
    Route::resource('transacciones', 'TransaccionesController')->middleware('permiso');


    Route::get('admin/usuarios', 'UserController@index')->name('listUsuarios');

    Route::get('clientes/addclientes', 'ClienteController@create')->name('addcliente');
    Route::get('clientes/datosReferencia/{id}', 'ClienteController@verReferencia')->name('verReferencia');
    Route::post('clientes/addreferencias/{id}', 'ClienteController@guardarReferencias')->name('addreferencias');


    Route::get('solicitud/detalleClienteSolicitud/{id}', 'SolicitudController@obtenerDetallesCliente');
    Route::get('solicitud/productos/{id}', 'SolicitudController@verProductos')->name('verProductos');

    Route::post('analisis_credito/detalleTablaAmortizacion/', 'AnalisisController@tablaAmortizacion')->name('tablaAmortizacion');
    Route::post('analisis_credito/autorizacion', 'AnalisisController@autorizacion')->name('autorizacion');

    Route::post('transaccion/import/excel', 'PagosMasivosController@importFromExcel')->name('importExcel');
    Route::get('transaccion/pagosMasivos/','TransaccionesController@procesarDatos')->name('procesarDatos');

    Route::get('solicitud/pdfBlanco/{id}','SolicitudController@pdfContrato')->name('pdfBlanco');
    Route::get('solicitud/pdf/solicitudCredito/{id}','SolicitudController@pdfSolicitud')->name('solicitudCredito');
    Route::post('analisis_credito/reporteColocacion/','AnalisisController@colocacionClientes')->name('colocacionClientes');

    Route::get('cp/buscarCodigoPostal/', 'CpController@checkCp')->name('checkCp');

});

