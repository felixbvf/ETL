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

Route::get('export_parametros','PersonaController@ExportParametro');
Route::get('export_agenda','PersonaController@ExportPersona');
Route::get('export_prestamos','PrestamoController@ExportPrestamo');
Route::get('export_planpagos','PrestamoController@ExportPlanpagos');
Route::get('export_garantias','PrestamoController@ExportGarantias');