<?php

Route::group(['prefix'=>'utilisateurs/droits', 'middleware' => 'can:manage,App\Entities\User'], function(){

    Route::get('/droits', 'DroitsController@index');
    Route::put('/droits/{user}', 'DroitsController@update');
});
