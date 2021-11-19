<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





// PÚBLICAS:
Route::group(['prefix' => 'v1'], function () {
    Route::post('login', 'AuthController@login');
});


// CON AUTENTICACIÓN:
Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'v1'
], function () {
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

    Route::post('user/recover_password', 'UserController@recover_password');

    // REGION
    Route::get('regiones/index', 'RegionController@index');
    Route::post('regiones/store', 'RegionController@store');
    Route::post('regiones/update', 'RegionController@update');
    Route::get('regiones/show', 'RegionController@show');
    Route::delete('regiones/delete', 'RegionController@delete');

    // COMUNAS
    Route::get('comunas/index', 'ComunaController@index');
    Route::post('comunas/store', 'ComunaController@store');
    Route::post('comunas/update', 'ComunaController@update');
    Route::get('comunas/show', 'ComunaController@show');
    Route::delete('comunas/delete', 'ComunaController@delete');

    // SEDES
    Route::get('sedes/index', 'SedeController@index');
    Route::post('sedes/store', 'SedeController@store');
    Route::post('sedes/update', 'SedeController@update');
    Route::get('sedes/show', 'SedeController@show');
    Route::delete('sedes/delete', 'SedeController@delete');

    // ENSAYOS
    Route::get('ensayos/index', 'EnsayoController@index');
    Route::post('ensayos/store', 'EnsayoController@store');
    Route::post('ensayos/update', 'EnsayoController@update');
    Route::get('ensayos/show', 'EnsayoController@show');
    Route::delete('ensayos/delete', 'EnsayoController@delete');

    // ORIGENES
    Route::get('origenes/index', 'OrigenController@index');
    Route::post('origenes/store', 'OrigenController@store');
    Route::post('origenes/update', 'OrigenController@update');
    Route::get('origenes/show', 'OrigenController@show');
    Route::delete('origenes/delete', 'OrigenController@delete');

    // SUBORIGENES
    Route::get('suborigenes/index', 'SuborigenController@index');
    Route::post('suborigenes/store', 'SuborigenController@store');
    Route::post('suborigenes/update', 'SuborigenController@update');
    Route::get('suborigenes/show', 'SuborigenController@show');
    Route::delete('suborigenes/delete', 'SuborigenController@delete');
});














Route::fallback(function () {
    return response()->json([
        'status'  => 'error',
        'message' => 'Ruta no encontrada.'
    ], 404);
});