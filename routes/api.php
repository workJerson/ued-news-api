<?php

use App\Http\Controllers\ArticleCategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(
    ['prefix' => 'public'],
    function () {
        Route::get('articles', PublicController::class)->name('articles');
        Route::get('categories', 'App\Http\Controllers\PublicController@showAllCategories');
        Route::get('articles/{slug}', 'App\Http\Controllers\PublicController@showArticleBySlug');
        Route::get('articles/category/{slug}', 'App\Http\Controllers\PublicController@showArticlesByCategory');
        Route::get('articles/tags/{slug}', 'App\Http\Controllers\PublicController@showArticlesByTag');
        Route::get('global-search/articles', 'App\Http\Controllers\PublicController@articleGlobalSearch');
    }
);

Route::group(
    ['prefix' => 'auth', 'namespace' => 'App\Http\Controllers'],
    function () {
        Route::post('login', 'AuthController@login');
    }
);

Route::group(
    ['middleware' => 'auth:api'],
    function () {
        Route::resource('articles', ArticleController::class, ['except' => ['edit', 'create']]);
        Route::resource('article-categories', ArticleCategoryController::class, ['except' => ['edit', 'create']]);
        Route::resource('tags', TagsController::class, ['except' => ['edit', 'create']]);
        Route::resource('users', UserController::class, ['except' => ['edit', 'create']]);
    }
);
