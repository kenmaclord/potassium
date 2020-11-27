<?php

    Route::prefix(LaravelLocalization::setLocale())
    ->namespace('Front')
    ->middleware([ 'localeSessionRedirect', 'localizationRedirect' ])
    ->group(function(){
        Route::get('/', 'FrontController@index')->name('home');
    });
