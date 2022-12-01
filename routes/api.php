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

Route::post('/login', 'App\Http\Controllers\AuthController@login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'middleware' => ['auth:sanctum', 'role:1']
], function() {

    Route::group([
        'prefix' => 'articles'
    ], function() {
        Route::get(
            '/',
            'App\Http\Controllers\ArticleController@index'
        )->name('articles.list');
        Route::get(
            '/{id}',
            'App\Http\Controllers\ArticleController@show'
        )->name('articles.detail');
        Route::post(
            '/',
            'App\Http\Controllers\ArticleController@store'
        )->name('articles.store');
        Route::put(
            '/{id}',
            'App\Http\Controllers\ArticleController@put'
        )->name('articles.update');
        Route::delete(
            '/{id}',
            'App\Http\Controllers\ArticleController@delete'
        )->name('articles.updateActiveStatus');
    });

});
