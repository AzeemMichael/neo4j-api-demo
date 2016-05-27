<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'api/v1', 'middleware' => ['api']], function() {

    Route::post('register', [
        'as'   => 'api.v1.register',
        'uses' => 'Auth\TokenAuthController@register'
    ]);

    Route::post('authenticate', [
        'as'   => 'api.v1.authenticate',
        'uses' => 'Auth\TokenAuthController@authenticate'
    ]);

    Route::get('authenticate/user', [
        'as'   => 'api.v1.authenticate.user',
        'uses' => 'Auth\TokenAuthController@getAuthenticatedUser'
    ]);

    Route::get('me', [
        'as'   => 'api.v1.me.show',
        'uses' => 'Api\MeController@show'
    ]);

    Route::resource('appointments', 'Api\AppointmentsController', [
        'except' => ['create', 'edit'],
        'parameters' => ['appointments' => 'appointment']
    ]);

});