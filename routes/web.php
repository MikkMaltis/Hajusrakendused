<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteMusicController;
use App\Http\Controllers\API\FavoriteMusicController as APIFavoriteMusicController;

// Weather routes
Route::resource('weather', WeatherController::class);
Route::post('weather/fetch', [WeatherController::class, 'fetchWeather'])->name('weather.fetchWeather');

// Map routes
Route::get('/maps', [App\Http\Controllers\MarkerController::class, 'index'])->name('maps.index');
Route::post('/maps', [App\Http\Controllers\MarkerController::class, 'store'])->name('maps.store');
Route::put('/maps/{marker}', [App\Http\Controllers\MarkerController::class, 'update'])->name('maps.update');
Route::delete('/maps/{marker}', [App\Http\Controllers\MarkerController::class, 'destroy'])->name('maps.destroy');

// Music routes
Route::resource('music', FavoriteMusicController::class);

// Music API tester route
Route::get('/music/api/tester', function () {
    return view('music.api_tester');
})->name('music.api_tester');

// External Music API route with caching
Route::get('/music/external-api', [FavoriteMusicController::class, 'proxyExternalApi'])->name('music.external');

// Add a home route that redirects to the music index
Route::get('/', function () {
    return redirect()->route('music.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('/blog', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/blog/{post}/edit', [BlogController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/{post}', [BlogController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{post}', [BlogController::class, 'destroy'])->name('blog.destroy');
});

// Comment routes
Route::post('/posts/{post}/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');

// Admin routes (protected by controller-level auth checks)
Route::get('/comments', [App\Http\Controllers\CommentController::class, 'index'])->name('comments.index');
Route::patch('/comments/{comment}/approve', [App\Http\Controllers\CommentController::class, 'approve'])->name('comments.approve');
Route::delete('/comments/{comment}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Product routes
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::post('/add-to-cart', [App\Http\Controllers\ProductController::class, 'addToCart'])->name('add.to.cart');
Route::get('/cart', [App\Http\Controllers\ProductController::class, 'cart'])->name('cart');
Route::post('/update-cart', [App\Http\Controllers\ProductController::class, 'updateCart'])->name('update.cart');
Route::post('/remove-from-cart', [App\Http\Controllers\ProductController::class, 'removeFromCart'])->name('remove.from.cart');

// Payment routes
Route::get('/checkout', [App\Http\Controllers\PaymentController::class, 'checkout'])->name('checkout');
Route::post('/payment/process', [App\Http\Controllers\PaymentController::class, 'processPayment'])->name('payment.process');
Route::get('/payment/success', [App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [App\Http\Controllers\PaymentController::class, 'cancel'])->name('payment.cancel');

require __DIR__.'/auth.php';
