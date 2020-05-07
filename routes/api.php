<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

/**
 * We can group these routes with middleware for validating access token.
 * We can use tymondesigns/jwt-auth package or the built-in Laravel Passport.
 * For demo purposes, its excluded. But yes, it's required in real world applications
*/
Route:: middleware('custom-auth')->group(function() {
    Route::prefix('properties')->group(function() {
        // Add a new property
        Route::post('/', '\App\Http\Controllers\Api\PropertyController@store')
            ->name('post.properties.store');

        // Get a summary of all property analytics by suburb, state, country
        Route::get('/summary', '\App\Http\Controllers\Api\PropertyController@summary')
            ->name('get.properties.summary');

        Route::prefix('{property:guid}/analytics')->group(function() {
            // Get all analytics for an inputted property
            Route::get('/', '\App\Http\Controllers\Api\AnalyticController@index')
                ->name('get.properties.analytics.index');;

            // Add/Update an analytic to a property
            Route::put('/', '\App\Http\Controllers\Api\AnalyticController@save')
                ->name('put.properties.analytics.save');
        });
    });
});

