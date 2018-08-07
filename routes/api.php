<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware([
    'auth:api',
    'role:'.implode(',', get_roles(['super_admin', 'group_admin', 'client_admin']))
])->group(function() {
    Route::post('register', 'RegistrationController@register');
    Route::post('groups/register/user', 'RegistrationController@registerGroupUser');
});

Route::post('login', 'AuthController@login');

Route::middleware('auth:api')->group(function() {
    Route::post('logout', 'AuthController@logout');

    Route::middleware('role:'.config('user_roles.super_admin'))->group(function() {
        Route::prefix('groups')->group(function() {
            Route::get('/', 'GroupsController@index');
            Route::post('/', 'GroupsController@create');
        });

        Route::prefix('clients')->group(function() {
            Route::get('/', 'ClientsController@index');
            Route::post('/', 'ClientsController@create');
            Route::put('{client}/assign-group/{group}', 'AdminsController@assignGroup');
        });
    });
});