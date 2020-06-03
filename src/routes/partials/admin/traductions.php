<?php

    /**
    * Routes pour les traductions
    */
    Route::middleware(['can:manage, Potassium\App\Entities\Traduction'])
        ->group(function(){

            Route::prefix("traductions")->group(function(){
                Route::get('/', 'TraductionsController@index');
                Route::post('/', 'TraductionsController@store');
                Route::put('/content/{traduction}', 'TraductionsController@update');
            });

            Route::prefix("langues")->group(function(){
                Route::get('/','LanguesController@index');
                Route::put('/visibility/{langue}','LanguesController@toggleVisibility');
                Route::put('/availability/{langue}','LanguesController@toggleAvailability');
                Route::get('/available','LanguesController@available');
                Route::get('localized_langues','LanguesController@getLocalizedLangues');
            });

            Route::prefix("zones")->group(function(){
                Route::get('/','ZonesController@index');
                Route::put('/unpublish/{traduction}/{langue}', 'ZonesController@unPublish');;
                Route::post('/','ZonesController@store');
                Route::put('reorder/{table}','ZonesController@reorder');
                Route::put('{zone}','ZonesController@update');
                Route::put('publish/{zone}/{langue}','ZonesController@publish');
                Route::delete('{zone}','ZonesController@destroy');
            });
        });
