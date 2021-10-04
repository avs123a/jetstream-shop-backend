<?php

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

//Route::post('register', []);

//Route::post('login', []);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'catalog'], function () {
    Route::get('categories', [ApiCategoryController::class, 'index']);

    Route::get('categories/{slug}', [ApiProductController::class, 'listByCategory']);

    Route::get('products', [ApiProductController::class, 'index']);

    Route::get('products/{slug}', [ApiProductController::class, 'show']);
});
