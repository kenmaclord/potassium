<?php

Route::group([
    'namespace' => 'Potassium\App\Http\Controllers\Auth',
    'middleware' => 'web'], function(){

    require __DIR__.'/partials/auth/admin.php';
    require __DIR__.'/partials/auth/front.php';
});


Route::group([
    "prefix"=>"admin",
    "middleware"=>["web", "auth:web"],
    'namespace' => 'Potassium\App\Http\Controllers\Admin'], function(){

    require __DIR__.'/partials/admin/traductions.php';
});
