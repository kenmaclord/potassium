<?php

    /**
    * Routes pour les utilisateurs
    */
    Route::prefix('utilisateurs')
    ->middleware(['can:manage,App\Entities\User'])
    ->group(function(){
        Route::get('/', 'UsersController@index');
        Route::get('/avatars', 'UsersController@avatars');
        Route::post('/', 'UsersController@store');
        Route::put('reorder/{table}', 'UsersController@reorder');
        Route::get('/{user}', 'UsersController@show');
        Route::put('toggleLock/{user}', 'UsersController@toggleLock');
        Route::put('{user}', 'UsersController@update');
        Route::delete('/{user}', 'UsersController@destroy');
    });
