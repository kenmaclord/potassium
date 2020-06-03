<?php

use Potassium\App\Entities\Pays;
use Potassium\App\Entities\Langue;
use Potassium\App\Entities\Continent;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::group(['middleware' =>'auth:api'], function(){
Route::prefix('api')
    ->group(function(){
        Route::get('/langues/{type}', function ($type) {
            return Langue::$type()->orderBy('order')->get();
        });

        Route::get('/pays', function () {
            if (json_decode(request('group_by_continent'))) {
                return Continent::with('pays')->orderBy('name')->get();
            }

            return Pays::orderBy('name')->get();
        });

        Route::get('/front/traductions', 'App\Http\Controllers\Front\FrontTraductionsController@index');
    });
