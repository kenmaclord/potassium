<?php

use Entities\Pays;
use Entities\Langue;
use App\Entities\Continent;
use Illuminate\Http\Request;

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
Route::group([], function(){
    Route::get('/langues/{type}', function ($type) {
        return Langue::$type()->orderBy('order')->get();
    });

    Route::get('/pays', function () {
        if (json_decode(request('group_by_continent'))) {
            return Continent::with('pays')->orderBy('name')->get();
        }

        return Pays::orderBy('name')->get();
    });
});
