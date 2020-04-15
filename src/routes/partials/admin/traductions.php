<?php

    /**
    * Routes pour les traductions
    */
    Route::group(["prefix"=>"traductions", 'middleware' => 'can:manage,Potassium\App\Entities\Traduction'], function(){
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

    Route::resource('traductions','TraductionsController')->middleware('can:manage,Potassium\App\Entities\Traduction');
