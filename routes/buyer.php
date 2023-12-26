<?php

use App\Http\Controllers\Buyer\JobController;
use App\Http\Controllers\Buyer\ProfileController;
use Illuminate\Support\Facades\Route;

// Start ProfileController

Route::group(['prefix' => 'buyer' , 'namespace' => 'Buyer' , 'middleware' => 'auth:sanctum'], function() {
    Route::get('/profile',[ProfileController::class,'index'])->name('buyer.profile');
    Route::post('/profile/update',[ProfileController::class,'update'])->name('buyer.profile.update');
    Route::post('/profile/changePassword',[ProfileController::class,'changePassword'])->name('buyer.profile.changePassword');
});

// End ProfileController

// Start JobController

Route::group(['prefix' => 'buyer' , 'namespace' => 'Buyer' , 'middleware' => 'auth:sanctum'], function() {
    Route::get('/jobs',[JobController::class,'index'])->name('buyer.jobs');
    Route::post('/job/store',[JobController::class,'store'])->name('buyer.job.store');
    Route::get('/job/changeStatusMethod/{id}',[JobController::class,'status'])->name('buyer.job.changeStatusMethod');
    Route::get('/job/show/{id}',[JobController::class,'show'])->name('buyer.job.show');
    Route::post('/job/update/{id}',[JobController::class,'update'])->name('buyer.job.update');
    Route::get('/job/deleteMethod/{id}',[JobController::class,'delete'])->name('buyer.job.deleteMethod');

});

// End JobController
