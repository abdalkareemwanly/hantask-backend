<?php

use App\Http\Controllers\Seller\ChatController;
use App\Http\Controllers\Seller\NotificationController;
use App\Http\Controllers\Seller\PayoutHistoryController;
use App\Http\Controllers\Seller\PostController;
use App\Http\Controllers\Seller\ProfileController;
use App\Http\Controllers\Seller\ProfileVerifyController;
use App\Http\Controllers\Seller\ReportController;
use App\Http\Controllers\Seller\ReviewController;
use App\Http\Controllers\Seller\ServiceController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'seller' , 'namespace' => 'Seller' , 'middleware' => 'auth:sanctum'], function() {
    Route::get('/profile',[ProfileController::class,'index'])->name('seller.profile');
    Route::post('/profile/update',[ProfileController::class,'update'])->name('seller.profile.update');
    Route::post('/profile/changePassword',[ProfileController::class,'changePassword'])->name('seller.profile.changePassword');
});

// Start ChatController
Route::group(['namespace' => 'Seller' , 'prefix' => 'seller' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/getContact',[ChatController::class,'getContact'])->name('seller.chat.getContact');
    Route::get('/getMessage/{id}',[ChatController::class,'getMessage'])->name('seller.chat.getMessage');
    Route::post('/storeMessage',[ChatController::class,'storeMessage'])->name('seller.chat.storeMessage');
});
// End ChatController

// Start Service Controller

Route::group(['namespace' => 'Seller' , 'prefix' => 'seller' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/services',[ServiceController::class,'index'])->name('seller.service.index');
    Route::post('/service/store',[ServiceController::class,'store'])->name('seller.service.store');
    Route::post('/service/update/{id}',[ServiceController::class,'update'])->name('seller.service.update');
    Route::get('/service/deleteMethod/{id}',[ServiceController::class,'delete'])->name('seller.service.delete');
});

// End Service Controller


// Start Post Controller

Route::group(['namespace' => 'Seller' , 'prefix' => 'seller' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/posts',[PostController::class,'index'])->name('seller.posts.index');
    Route::get('/post/comments/{id}',[PostController::class,'comments'])->name('seller.post.comments');
    Route::post('/post/comment/store/{id}',[PostController::class,'storeComment'])->name('seller.post.comment.store');
    Route::post('/post/comment/update/{id}',[PostController::class,'updateComment'])->name('seller.post.comment.update');
    Route::get('/post/comment/delete/{id}',[PostController::class,'deleteComment'])->name('seller.post.comment.delete');
    Route::get('post/report',[PostController::class,'report'])->name('seller.post.report');

});

// End Post Controller


// Start ProfileVerify Controller

Route::group(['namespace' => 'Seller' , 'prefix' => 'seller' , 'middleware' => 'auth:sanctum'],function(){
    Route::post('/profileVerify/store',[ProfileVerifyController::class,'store'])->name('seller.profileVerify.store');
});

// End ProfileVerify Controller


// Start PayoutHistory Controller

Route::group(['namespace' => 'Seller' , 'prefix' => 'seller' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/PayoutHistory',[PayoutHistoryController::class,'index'])->name('seller.PayoutHistory.index');
});

// End PayoutHistory Controller

// Start Review Controller

Route::group(['namespace' => 'Seller' , 'prefix' => 'seller' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/reviews',[ReviewController::class,'index'])->name('seller.reviews.index');
});

// End Review Controller

// Start Notification Controller

Route::group(['namespace' => 'Seller' , 'prefix' => 'seller' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/notifications',[NotificationController::class,'index'])->name('seller.notifications.index');
    Route::get('/notification/pusher',[NotificationController::class,'pusher'])->name('seller.notifications.pusher');
});

// End Notification Controller

// Start Report Controller

Route::group(['namespace' => 'Seller' , 'prefix' => 'seller' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/reports',[ReportController::class,'index'])->name('seller.report.index');
    Route::post('/report/store',[ReportController::class,'store'])->name('seller.report.store');
    Route::post('/report/update/{id}',[ReportController::class,'update'])->name('seller.report.update');
    Route::get('/report/delete/{id}',[ReportController::class,'delete'])->name('seller.report.delete');
});

// End Report Controller
