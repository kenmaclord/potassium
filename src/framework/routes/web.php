<?php

/**
* Routes pour l'authentification
*/
Auth::routes();

/**
* Routes pour l'admin
*/
Route::group(["prefix"=>"admin","middleware"=>"auth", 'namespace' => 'Admin'], function(){

    Route::get('/', 'DashboardController@index')->name('admin');

    /**
    * Routes pour les traductions
    */
    Route::group(["prefix"=>"traductions", 'middleware' => 'can:manage,Entities\Traduction'], function(){
        Route::get('content','TraductionsController@index');
        Route::put('content/{traduction}','TraductionsContentController@update');
        Route::put('content/setPublishedState/{traduction_content}','TraductionsContentController@setPublishedState');

        Route::get('langue','TraductionsController@getLangue');

        Route::get('langues','LanguesController@index');
        Route::put('langues/visibility/{langue}','LanguesController@toggleVisibility');
        Route::put('langues/availability/{langue}','LanguesController@toggleAvailability');
        Route::get('langues/available','LanguesController@available');

        Route::get('zones','ZonesController@index');
        Route::get('zones/is_published/{zone}/{langue}', 'ZonesController@isPublished');;
        Route::post('zones','ZonesController@store');
        Route::put('zones/reorder/{table}','ZonesController@reorder');
        Route::put('zones/{zone}','ZonesController@update');
        Route::put('zones/publish/{zone}/{langue}','ZonesController@publish');
        Route::delete('zones/{zone}','ZonesController@destroy');
    });

    Route::resource('traductions','TraductionsController')->middleware('can:manage,Entities\Traduction');


    /**
    * Routes pour les utilisateurs
    */
    Route::group(['prefix'=>'utilisateurs', 'middleware' => 'can:manage,Entities\User'], function(){
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

    // @PageRoutes

});

/**
* Routes pour le front
*/
Route::group(
[
    "prefix" => Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale(),
    'namespace' => 'Front',
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect' ]
], function(){
    Route::get('/', 'FrontController@index');
});
