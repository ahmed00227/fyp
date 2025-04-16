<?php

use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\ChatBotController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login',[UserController::class,'login'])->name('login');
Route::post('/signup',[UserController::class,'signup'])->name('signup');
Route::get('/products',[UserController::class,'productsList'])->name('products');

Route::middleware('auth:sanctum')->group(function () {
   Route::post('/cart/add',[CartController::class,'addToCart'])->name('cart.add');
   Route::post('/cart/remove',[CartController::class,'removeFromCart'])->name('cart.remove');
   Route::get('/cart/empty',[CartController::class,'emptyCart'])->name('cart.empty');
   Route::post('/cart/update',[CartController::class,'updateCart'])->name('cart.update');
   Route::get('/checkout',[CartController::class,'checkout'])->name('cart.checkout');
   Route::get('/chat/{specialization}',[\App\Http\Controllers\api\ChatController::class,'chat'])->name('chat');
   Route::post('/message/send',[\App\Http\Controllers\api\ChatController::class,'messageSend'])->name('message');
   Route::get('/orders',[UserController::class,'orders'])->name('orders');
   Route::post('/logout',[UserController::class,'logout'])->name('logout');
   Route::post('/recommendations',[ChatBotController::class,'recommendations'])->name('recommendations');
   Route::get('/descriptions',[ChatBotController::class,'descriptions'])->name('descriptions');
});
