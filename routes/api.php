<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\APIUserController;
use App\Http\Controllers\Api\V1\APICategoriesController;
use App\Http\Controllers\Api\V1\APIArticlesController;

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

Route::prefix('v1')->group(function(){
    Route::post('register', [APIUserController::class, 'register'])->name('api.register');
    Route::post('login', [APIUserController::class, 'login'])->name('api.login');
    Route::group(['middleware' => 'auth:api'], function(){
        Route::prefix('categories')->group(function(){
            Route::get('show', [APICategoriesController::class, 'show'])->name('api.categories.show');
            Route::post('create', [APICategoriesController::class, 'create'])->name('api.categories.create');
            Route::put('update', [APICategoriesController::class, 'update'])->name('api.categories.update');
            Route::delete('delete', [APICategoriesController::class, 'delete'])->name('api.categories.delete');
        });
        Route::prefix('articles')->group(function(){
            Route::get('show', [APIArticlesController::class, 'show'])->name('api.articles.show');
            Route::post('create', [APIArticlesController::class, 'create'])->name('api.articles.create');
            Route::put('update', [APIArticlesController::class, 'update'])->name('api.articles.update');
            Route::delete('delete', [APIArticlesController::class, 'delete'])->name('api.articles.delete');
        });
        Route::get('profile', [APIUserController::class, 'profile'])->name('api.profile');
        Route::get('logout', [APIUserController::class, 'logout'])->name('api.logout');
    });
});
