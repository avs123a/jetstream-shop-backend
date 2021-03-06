<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController as ApiCartController;
use App\Http\Controllers\API\CategoryController as ApiCategoryController;
use App\Http\Controllers\API\ProductController as ApiProductController;
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

Route::post('register', [AuthController::class, 'register']);

Route::post('authorize', [AuthController::class, 'authorizeUser']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['prefix' => 'catalog'], function () {
        Route::get('categories', [ApiCategoryController::class, 'index']);

        Route::get('categories/{slug}', [ApiProductController::class, 'listByCategory']);

        Route::get('products', [ApiProductController::class, 'index']);

        Route::get('products/{slug}', [ApiProductController::class, 'show']);
    });

    Route::post('checkout', [ApiCartController::class, 'createOrder']);
});

//CartController
