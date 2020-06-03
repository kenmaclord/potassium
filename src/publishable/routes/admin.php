<?php

    Route::group([
        "prefix"=>"admin",
        "middleware"=>["web", "auth:web"],
        'namespace' => 'Admin'], function(){

        Route::get('/', 'DashboardController@index')->name('admin.dashboard');

        require __DIR__.'/partials/admin/users.php';

        // @PageRoutes
    });
