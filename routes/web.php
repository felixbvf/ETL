<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('export_parametros','PersonaController@ExportParametro'); 
Route::get('export_agenda','PersonaController@ExportPersona');
Route::get('export_prestamos','PrestamoController@ExportPrestamo');
//Route::get('export_planpagos','PrestamoController@ExportPlanpagos');
Route::get('export_garantias','PrestamoController@ExportGarantias');
Route::get('export_aportes','AporteController@ExportAporte');