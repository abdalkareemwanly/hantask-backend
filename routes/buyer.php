<?php

use App\Http\Controllers\Buyer\AcceptedCommentController;
use App\Http\Controllers\Buyer\ChatController;
use App\Http\Controllers\Buyer\CommentController;
use App\Http\Controllers\Buyer\JobController;
use App\Http\Controllers\Buyer\NotificationController;
use App\Http\Controllers\Buyer\PaymentStatusController;
use App\Http\Controllers\Buyer\PostApproveController;
use App\Http\Controllers\Buyer\PostController;
use App\Http\Controllers\Buyer\PostImageController;
use App\Http\Controllers\Buyer\ProfileController;
use App\Http\Controllers\Buyer\ReportController;
use App\Http\Controllers\Buyer\ReviewController;
use Illuminate\Support\Facades\Route;

// Start ProfileController

Route::group(['prefix' => 'buyer' , 'namespace' => 'Buyer' , 'middleware' => 'auth:sanctum'], function() {
    Route::get('/profile',[ProfileController::class,'index'])->name('buyer.profile');
    Route::post('/profile/update',[ProfileController::class,'update'])->name('buyer.profile.update');
    Route::post('/profile/changePassword',[ProfileController::class,'changePassword'])->name('buyer.profile.changePassword');
});

// End ProfileController


// Start Post Controller

Route::group(['namespace' => 'Buyer' , 'prefix' => 'buyer' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/posts',[PostController::class,'index'])->name('buyer.post');
    Route::post('/post/store',[PostController::class,'store'])->name('buyer.post.store');
    Route::get('/post/{id}',[PostController::class,'show'])->name('buyer.post.show');
    Route::get('/post/changeStatusMethod/{id}',[PostController::class,'status'])->name('buyer.post.changeStatusMethod');
    Route::post('/post/update/{id}',[PostController::class,'update'])->name('buyer.post.update');
    Route::get('/post/delete/{id}',[PostController::class,'delete'])->name('buyer.post.delete');
});

// End Post Controller


// Start ImagePost Controller

Route::group(['namespace' => 'Buyer' , 'prefix' => 'buyer' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/post/images/{id}',[PostImageController::class,'index'])->name('buyer.post.images');
    Route::post('/post/image/store/{id}',[PostImageController::class,'store'])->name('buyer.post.image.store');
    Route::post('/post/image/update/{id}',[PostImageController::class,'update'])->name('buyer.post.image.update');
    Route::get('/post/image/delete/{id}',[PostImageController::class,'delete'])->name('buyer.post.image.delete');
});
// End ImagePost Controller


// Start PaymentStatus Controller

Route::group(['namespace' => 'Buyer' , 'prefix' => 'buyer' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/PaymentStatus',[PaymentStatusController::class,'index'])->name('buyer.PaymentStatus.index');
    Route::post('/PaymentStatus/store',[PaymentStatusController::class,'store'])->name('buyer.PaymentStatus.store');
});

// End PaymentStatus Controller


// Start Report Controller

Route::group(['namespace' => 'Buyer' , 'prefix' => 'buyer' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/reports',[ReportController::class,'index'])->name('buyer.report.index');
    Route::post('/report/store',[ReportController::class,'store'])->name('buyer.report.store');
    Route::post('/report/update/{id}',[ReportController::class,'update'])->name('buyer.report.update');
    Route::get('/report/delete/{id}',[ReportController::class,'delete'])->name('buyer.report.delete');
});

// End Report Controller

// Start Review Controller

Route::group(['namespace' => 'Buyer' , 'prefix' => 'buyer' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/reviews',[ReviewController::class,'index'])->name('buyer.reviews.index');
    Route::post('/review/store',[ReviewController::class,'store'])->name('buyer.reviews.store');
    Route::post('/review/update/{id}',[ReviewController::class,'update'])->name('buyer.reviews.update');
    Route::get('/review/delete/{id}',[ReviewController::class,'delete'])->name('buyer.reviews.delete');

});

// End Review Controller

// Start Comment Controller

Route::group(['namespace' => 'Buyer' , 'prefix' => 'buyer' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/comments',[CommentController::class,'index'])->name('buyer.comments.index');
    Route::get('/comment/changeStatusMethod/{id}',[CommentController::class,'status'])->name('buyer.comment.status');

});

// End Comment Controller

// Start AcceptedComment Controller

Route::group(['namespace' => 'Buyer' , 'prefix' => 'buyer' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/acceptedComments',[AcceptedCommentController::class,'index'])->name('buyer.acceptedComments.index');
    Route::get('/acceptedComment/changeWorkStatusMethod/{id}',[AcceptedCommentController::class,'workStatus'])->name('buyer.acceptedComment.workStatus');

});

// End AcceptedComment Controller

// Start Notification Controller

Route::group(['namespace' => 'Buyer' , 'prefix' => 'buyer' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/notifications',[NotificationController::class,'index'])->name('buyer.notifications.index');

});

// End Notification Controller



// Start ChatController
Route::group(['namespace' => 'Buyer' , 'prefix' => 'buyer' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/getContact',[ChatController::class,'getContact'])->name('buyer.chat.getContact');
    Route::get('/getMessage/{id}',[ChatController::class,'getMessage'])->name('buyer.chat.getMessage');
    Route::post('/storeMessage',[ChatController::class,'storeMessage'])->name('buyer.chat.storeMessage');
});
// End ChatController
