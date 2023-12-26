<?php


use App\Http\Controllers\Site\CategoriesController;
use App\Http\Controllers\Site\ChatController;
use App\Http\Controllers\Site\CheckoutController;
use App\Http\Controllers\Site\ServiceController;
use App\Http\Controllers\Site\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Start Site Controllers
Route::group(['namespace' => 'Site' , 'prefix' => 'site'],function(){
    Route::post('/register',[UserController::class,'register'])->name('site.register');
    Route::post('/login',[UserController::class,'login'])->name('site.login');
});
// Start CheckoutController
Route::group(['namespace' => 'Site' , 'prefix' => 'site' , 'middleware' => 'auth:sanctum'],function(){
    Route::post('/checkout',[CheckoutController::class, 'checkout'])->name('site.user.checkout');
});
// End CheckoutController

// Start ChatController
Route::group(['namespace' => 'Site' , 'prefix' => 'site' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/getContact',[ChatController::class,'getContact'])->name('site.chat.getContact');
    Route::get('/getMessage/{id}',[ChatController::class,'getMessage'])->name('site.chat.getMessage');
    Route::post('/storeMessage',[ChatController::class,'storeMessage'])->name('site.chat.storeMessage');
});
// End ChatController

// Start CategoriesController
Route::group(['namespace' => 'Site' , 'prefix' => 'site' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/categories',[CategoriesController::class,'index'])->name('site.categories');
});
// End CategoriesController

// Start ServiceController
Route::group(['namespace' => 'Site' , 'prefix' => 'site' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/services',[ServiceController::class,'index'])->name('site.services');
});
// End ServiceController

// End Site Controllers
