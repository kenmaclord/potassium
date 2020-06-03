<?php

/**
* Routes pour les droits
*/
Route::prefix('utilisateurs/droits')
    ->middleware(['can:manage,App\Entities\User'])
    ->group(function(){
        Route::get('/', 'DroitsController@index');
        Route::put('/{user}', 'DroitsController@update');
    });
