<?php


use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes([
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);

Route::get('/logout', [LoginController::class, 'logout'])->name('get-logout');


Route::middleware(['auth', 'is_admin'])->namespace('App\Http\Controllers\Admin')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('home');
});


Route::get('/', [MainController::class, 'index'])->name('index');

Route::get('/basket', [BasketController::class, 'basket'])->name('basket');
Route::get('/basket/place', [BasketController::class, 'basketPlace'])->name('basket-place');
Route::post('/basket/add/{id}', [BasketController::class, 'basketAdd'])->name('basket-add');
Route::post('/basket/remove/{id}', [BasketController::class, 'basketRemove'])->name('basket-remove');
Route::post('/basket/place', [BasketController::class, 'basketConfirm'])->name('basket-confirm');


Route::get('/categories', [MainController::class, 'categories'])->name('categories');
Route::get('/{category}', [MainController::class, 'category'])->name('category');

Route::get('/{category}/{product?}', [MainController::class, 'product'])->name('product');





//Auth::routes();
//
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
