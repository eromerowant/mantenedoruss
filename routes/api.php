<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





// PÚBLICAS:
Route::group(['prefix' => 'v1'], function () {
    Route::post('user/recover_password', 'UserController@recover_password')->name('recover_password');
    
});


// CON AUTENTICACIÓN:
Route::group([
    'middleware' => 'api',
    'prefix' => 'v1'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me')->name('me');
});














Route::fallback(function () {
    return response()->json([
        'status'  => 'error',
        'message' => 'Ruta no encontrada.'
    ], 404);
});