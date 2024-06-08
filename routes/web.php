<?php


use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\PropertyOptionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Person\OrderController as PersonOrderController;
use App\Http\Controllers\ResetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes([
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);

// Маршруты для смены локали
Route::get('locale/{locale}', [MainController::class, 'changeLocale'])->name('locale');
Route::get('currency/{currencyCode}', [MainController::class, 'changeCurrency'])->name('currency');

// Маршрут для сброса данных (если требуется)
Route::get('reset', [ResetController::class, 'reset'])->name('reset');

// Маршрут для выхода из системы
Route::get('/logout', [LoginController::class, 'logout'])->name('get-logout');

Route::middleware(['set_locale'])->group(function () {
    // Группа маршрутов для администратора
    Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('home');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');

        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('properties', PropertyController::class);
        Route::resource('properties/{property}/property-options', PropertyOptionController::class);
    });

    // Группа маршрутов для личного кабинета пользователя
    Route::middleware(['auth'])->prefix('person')->group(function () {
        Route::get('/orders', [PersonOrderController::class, 'index'])->name('person.orders.index');
        Route::get('/orders/{order}', [PersonOrderController::class, 'show'])->name('person.orders.show');
    });

    // Основные маршруты
    Route::get('/', [MainController::class, 'index'])->name('index');
    Route::get('/categories', [MainController::class, 'categories'])->name('categories');
    Route::post('/subscription/{product}', [MainController::class, 'subscribe'])->name('subscription');

    // Группа маршрутов для корзины
    Route::prefix('basket')->group(function () {
        Route::post('/add/{product}', [BasketController::class, 'basketAdd'])->name('basket-add');
        Route::middleware(['basket_not_empty'])->group(function () {
            Route::get('/', [BasketController::class, 'basket'])->name('basket');
            Route::get('/place', [BasketController::class, 'basketPlace'])->name('basket-place');
            Route::post('/remove/{product}', [BasketController::class, 'basketRemove'])->name('basket-remove');
            Route::post('/place', [BasketController::class, 'basketConfirm'])->name('basket-confirm');
        });
    });

    // Маршруты для категорий и продуктов
    Route::get('/{category}', [MainController::class, 'category'])->name('category');
    Route::get('/{category}/{product}', [MainController::class, 'product'])->name('product');
});




//Auth::routes();
//
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
