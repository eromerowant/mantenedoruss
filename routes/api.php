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
});














Route::fallback(function () {
    return response()->json([
        'status'  => 'error',
        'message' => 'Ruta no encontrada.'
    ], 404);
});