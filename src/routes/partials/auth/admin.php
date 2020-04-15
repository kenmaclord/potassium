<?php

    Route::group(['prefix'=>'admin'], function(){
        Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
        Route::post('login', 'Admin\LoginController@login')->name('admin.login.post');
        Route::post('logout', 'Admin\LoginController@logout')->name('admin.logout');

        Route::get('password/reset', 'Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
        Route::post('password/email', 'Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
        Route::get('password/reset/{token}', 'Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');
        Route::post('password/reset', 'Admin\ResetPasswordController@reset')->name('admin.password.update');
    });
