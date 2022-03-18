<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
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

Route::prefix('v1')->group(function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::middleware('auth:api')->group(function(){
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        // Article
        Route::post('/article', [ArticleController::class, 'store']);
        Route::get('/article', [ArticleController::class, 'index']);
        Route::get('/article/{id}', [ArticleController::class, 'show']);
        Route::put('/article/{id}', [ArticleController::class, 'update']);
        Route::delete('/article/{id}', [ArticleController::class, 'destroy']);

        // Category
        Route::get('/category', [CategoryController::class, 'index']);
        Route::post('/category', [CategoryController::class, 'store']);
        Route::get('/category/{id}', [CategoryController::class, 'show']);
        Route::put('/category/{id}', [CategoryController::class, 'update']);
        Route::delete('/category/{id}', [CategoryController::class, 'destroy']);
    });
});
