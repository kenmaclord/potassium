<?php

    Route::get('login', 'Front\FrontLoginController@showLoginForm')->name('front.login');
    Route::post('login', 'Front\FrontLoginController@login')->name('front.login.post');
    Route::post('logout', 'Front\FrontLoginController@logout')->name('front.logout');;

    Route::get('register', 'Front\FrontRegisterController@showRegistrationForm')->name('front.register');
    Route::post('register', 'Front\FrontRegisterController@register')->name('front.register.post');;

    Route::get('password/reset', 'Front\FrontForgotPasswordController@showLinkRequestForm')->name('front.password.request');
    Route::post('password/email', 'Front\FrontForgotPasswordController@sendResetLinkEmail')->name('front.password.email');
    Route::get('password/reset/{token}', 'Front\FrontResetPasswordController@showResetForm')->name('front.password.reset');
    Route::post('password/reset', 'Front\FrontResetPasswordController@reset')->name('front.password.update');

    Route::get('email/verify', 'Front\FrontVerificationController@show')->name('front.verification.notice');
    Route::get('email/verify/{id}/{hash}', 'Front\FrontVerificationController@verify')->name('front.verification.verify');
    Route::post('email/resend', 'Front\FrontVerificationController@resend')->name('front.verification.resend');
