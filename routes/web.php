<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Shop\CatalogController as ShopCatalogController;
use App\Http\Controllers\Shop\OrderController as ShopOrderController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
//    TODO replace to homepage !!!
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('home', function () {
    return Inertia::render('Frontend/Home', []);
});

Route::group(['prefix' => 'shop'], function () {
   Route::get('/', [ShopCatalogController::class, 'index']);

   Route::get('/{slug}', [ShopCatalogController::class, 'details']);

});

Route::group(['prefix' => 'cart'], function () {
    Route::get('/', [ShopOrderController::class, 'index']);

    Route::get('/checkout', [ShopOrderController::class, 'checkout']);
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

/** Admin routes */
Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'verified']], function () {

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', [AdminCategoryController::class, 'index'])->name('admin.categories.list');

        Route::post('/', [AdminCategoryController::class, 'store'])->name('admin.categories.create');

        Route::put('/{id}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');

        Route::delete('/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.delete');
    });

    Route::group(['prefix' => 'products'], function () {
        Route::get('/', [AdminProductController::class, 'index'])->name('admin.products.list');

        Route::post('/', [AdminProductController::class, 'store'])->name('admin.products.create');

        Route::put('/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');

        Route::delete('/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.delete');
    });


});


Route::get('test', function () {
    dd(config('app.url'));
});
