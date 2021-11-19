<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





// PÚBLICAS:
Route::group(['prefix' => 'v1'], function () {
    Route::post('user/recover_password', 'UserController@recover_password')->name('recover_password');
    
});


// CON AUTENTICACIÓN:
Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'v1'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me')->name('me');

    // REGION
    Route::get('regiones/index', 'RegionController@index');
    Route::post('regiones/store', 'RegionController@store');
    Route::post('regiones/update', 'RegionController@update');
    Route::get('regiones/show', 'RegionController@show');
    Route::delete('regiones/delete', 'RegionController@delete');
});














Route::fallback(function () {
    return response()->json([
        'status'  => 'error',
        'message' => 'Ruta no encontrada.'
    ], 404);
});