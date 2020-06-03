<?php

    /**
    * Routes pour les utilisateurs
    */
    Route::group(['prefix'=>'utilisateurs', 'middleware' => 'can:manage,App\Entities\User'], function(){

    });
