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
    'role:'.implode(',', get_roles(['group_admin', 'group_admin', 'super_admin']))
])->group(function() {
    Route::post('register/group/user', 'RegistrationController@registerGroupUser')
        ->name('register.group.end.user');

    Route::post('register/client/user', 'RegistrationController@registerClientUser')
        ->name('register.client.end.user');
});

Route::post('login', 'AuthController@login');

Route::middleware('auth:api')->group(function() {
    Route::get('user/{user}', 'UsersController@show');
    Route::post('logout', 'AuthController@logout');


    Route::middleware(
        'role:'.implode(
            "|",
            only(config('user_roles'), 'group_admin', 'client_admin')
        )
    )->group(function() {
        Route::post('relogin-as', 'AuthController@reloginAs');
    });

    Route::middleware('role:'.config('user_roles.super_admin'))->group(function() {
        Route::post('register', 'RegistrationController@register')
            ->name('register.super.admin');

        Route::post('register/group/admin', 'RegistrationController@registerGroupAdmin')
            ->name('register.group.admin');

        Route::post('register/client/admin', 'RegistrationController@registerClientAdmin')
            ->name('register.client.admin');

        Route::post('login-as', 'AdminsController@loginAs');

        Route::prefix('groups')->group(function() {
            Route::delete('/{group}', 'GroupsController@destroy');
            Route::get('/', 'GroupsController@index');
            Route::post('/', 'GroupsController@create');
        });

        Route::prefix('client')->group(function() {
            Route::put('{client}/assign-group/{group}', 'AdminsController@assignGroup');

            Route::get('/', 'ClientsController@index');
            Route::post('/', 'ClientsController@create');
        });
    });

    Route::middleware('role:'.config('user_roles.group_admin'))->group(function() {
        // Todo: For specific role
    });

    Route::middleware(
        'role:'.implode(
            "|",
            only(config('user_roles'), 'group_admin', 'super_admin')
        )
    )->group(function() {
        Route::get('clients', 'ClientsController@show');
    });

    Route::middleware(
        'role:'.implode(
            "|",
            only(config('user_roles'), 'group_admin', 'super_admin', 'client_admin')
        )
    )->group(function() {
        Route::get('users', 'AccountsController@index');
    });
});