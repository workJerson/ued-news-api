<?php

use App\Http\Controllers\ArticleCategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PublicController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(
    ['prefix' => 'public'],
    function () {
        Route::get('articles', PublicController::class)->name('articles');
        Route::get('articles/{slug}', 'App\Http\Controllers\PublicController@showArticleBySlug');
        Route::get('articles/tags/{slug}', 'App\Http\Controllers\PublicController@showArticlesByTag');
    }
);

Route::group(
    [],
    function () {
        Route::resource('articles', ArticleController::class, ['except' => ['edit', 'create']]);
        Route::resource('article-categories', ArticleCategoryController::class, ['except' => ['edit', 'create']]);
    }
);
