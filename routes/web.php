<?php

use App\Http\Controllers\Front\Auth\TwoFactorAuthController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\front\CheckOutController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\ProfileController;
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


//
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});
Route::group(['prefix' => LaravelLocalization::setLocale()], function() {
    Route::get('/', [HomeController::class, 'index'])->name('home');
/////////////////////////////////////////////////////////////////////////////////////////
    Route::middleware(['throttle:50,1'])->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('front.products.index');
        Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('front.products.show');
    });
/////////////////////////////////////////////////////////////////////////////////////////
    Route::resource('cart', CartController::class);
////////////////////////////////////////////////////////////////////////////////////////
    Route::get('/checkout', [CheckOutController::class, 'create'])->name('checkout.index');
    Route::post('/checkout/store', [CheckOutController::class, 'store'])->name('checkout.store');
////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('/auth/2fa', [TwoFactorAuthController::class, 'index']);
});
require __DIR__.'/dashboard.php';
//require __DIR__.'/auth.php';

