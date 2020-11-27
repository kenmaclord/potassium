<?php

Route::middleware(["web"])
    ->namespace('Potassium\App\Http\Controllers\Auth')
    ->group(function(){

    require __DIR__.'/partials/auth/admin.php';
    require __DIR__.'/partials/auth/front.php';
});


Route::prefix("admin")
    ->middleware(["web", "auth:web"])
    ->namespace('Potassium\App\Http\Controllers\Admin')
    ->group(function(){
        require __DIR__.'/partials/admin/traductions.php';
        require __DIR__.'/partials/admin/droits.php';
        require __DIR__.'/partials/admin/users.php';
    });
