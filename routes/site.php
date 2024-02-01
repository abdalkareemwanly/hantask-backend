<?php

use App\Http\Controllers\Site\AddressController;
use App\Http\Controllers\Site\CategoriesController;
use App\Http\Controllers\Site\ChatController;
use App\Http\Controllers\Site\CheckoutController;
use App\Http\Controllers\Site\CouponController;
use App\Http\Controllers\Site\Global\CategoryController;
use App\Http\Controllers\Site\Global\ChildCategoryController;
use App\Http\Controllers\Site\Global\SubCategoryController;
use App\Http\Controllers\Site\PostController;
use App\Http\Controllers\Site\ServiceController;
use App\Http\Controllers\Site\UserController;
use Illuminate\Support\Facades\Route;

// Start Site Controllers
Route::group(['namespace' => 'Site' , 'prefix' => 'site'],function(){
    Route::post('/register',[UserController::class,'register'])->name('site.register');
    Route::post('/login',[UserController::class,'login'])->name('site.login');
});
// Start CheckoutController
Route::group(['namespace' => 'Site' , 'prefix' => 'site'],function(){
    Route::post('/checkout',[CheckoutController::class, 'checkout'])->middleware('auth:sanctum')->name('site.user.checkout');
});
// End CheckoutController

// Start CheckoutController
Route::group(['namespace' => 'Site' , 'prefix' => 'site'],function(){
    Route::post('/coupons/pay',[CouponController::class, 'payCoupon'])->name('site.user.coupons');
});
// End CheckoutController

// Start ChatController
Route::group(['namespace' => 'Site' , 'prefix' => 'site'],function(){
    Route::get('/getContact',[ChatController::class,'getContact'])->name('site.chat.getContact');
    Route::get('/getMessage/{id}',[ChatController::class,'getMessage'])->name('site.chat.getMessage');
    Route::post('/storeMessage',[ChatController::class,'storeMessage'])->name('site.chat.storeMessage');
});
// End ChatController

// Start Categories Controller
Route::group(['namespace' => 'Site' , 'prefix' => 'site'],function(){
    Route::get('/categories',[CategoriesController::class,'index'])->name('site.categories');
});
// End Categories Controller


// Start Categories Controller
Route::group(['namespace' => 'Site' , 'prefix' => 'site/global'],function(){
    Route::get('/category',[CategoryController::class,'index'])->name('site.category');
});
// End Categories Controller

// Start SubCategory Controller

Route::group(['namespace' => 'Site' , 'prefix' => 'site/global'],function(){
    Route::get('/subCategories',[SubCategoryController::class,'index'])->name('site.subCategories');
});
// End ChildCategory Controller

Route::group(['namespace' => 'Site' , 'prefix' => 'site/global'],function(){
    Route::get('/childCategories',[ChildCategoryController::class,'index'])->name('site.childCategories');
});

// End ChildCategory Controller

// Start Address Controller
Route::group(['namespace' => 'Site' , 'prefix' => 'site'],function(){
    Route::get('/countrys',[AddressController::class,'countrys'])->name('site.countrys');
    Route::get('/citis',[AddressController::class,'citis'])->name('site.citis');
    Route::get('/areas',[AddressController::class,'areas'])->name('site.areas');
});
// End Address Controller

// Start ServiceController

Route::group(['namespace' => 'Site' , 'prefix' => 'site'],function(){
    Route::get('/services',[ServiceController::class,'index'])->name('site.services');
});
// End ServiceController

// Start Post Controller

Route::group(['namespace' => 'Site' , 'prefix' => 'site'],function(){
    Route::get('/posts',[PostController::class,'index'])->name('site.posts');
    Route::get('/post/{id}',[PostController::class,'show'])->name('site.post.show');
    Route::post('/post/comment/{id}',[PostController::class,'comment'])->middleware('auth:sanctum')->name('site.post.comment');
});
// End Post Controller

// End Site Controllers
