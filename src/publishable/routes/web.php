<?php

Route::group([
    "prefix"=>"admin",
    "middleware"=>["web", "auth:web"],
    'namespace' => 'Admin'], function(){

    Route::get('/', 'DashboardController@index')->name('admin.dashboard');

    require __DIR__.'/partials/admin/users.php';

    // @PageRoutes
});


Route::group([
    "prefix" => Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale(),
    'namespace' => 'Front',
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect' ]], function(){

    Route::get('/', 'FrontController@index')->name('home');
});
