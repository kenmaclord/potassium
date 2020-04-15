<?php

    /**
    * Routes pour les utilisateurs
    */
    Route::group(['prefix'=>'utilisateurs', 'middleware' => 'can:manage,App\Entities\User'], function(){
        Route::get('/', 'UsersController@index');
        Route::get('/avatars', 'UsersController@avatars');
        Route::get('/droits', 'DroitsController@index');
        Route::post('/', 'UsersController@store');
        Route::put('/droits/{user}', 'DroitsController@update');
        Route::put('reorder/{table}', 'UsersController@reorder');
        Route::get('/{user}', 'UsersController@show');
        Route::put('toggleLock/{user}', 'UsersController@toggleLock');
        Route::put('{user}', 'UsersController@update');
        Route::delete('/{user}', 'UsersController@destroy');
    });
