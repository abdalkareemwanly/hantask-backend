<?php

use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ChildController;
use App\Http\Controllers\API\CountryController;
use App\Http\Controllers\API\LanguageController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\SubCategoryController;
use App\Http\Controllers\API\TranslationsController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace' => 'API' , 'prefix' => 'admin'],function(){
    Route::post('login',[AdminController::class,'login'])->name('admin.login');
    Route::get('AdminNumber',[AdminController::class, 'AdminNumber'])->name('admin.AdminNumber');
});
// Start Role Controller
Route::group(['namespace' => 'API' , 'prefix' => 'admin' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/roles',[RoleController::class,'index'])->name('admin.role.index');
    Route::post('/role/store',[RoleController::class,'store'])->name('admin.role.store');
});
// End Role Controller

// Start User Controller

Route::group(['namespace' => 'API' , 'prefix' => 'admin' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/users',[UserController::class,'index'])->name('admin.user.index');
    Route::post('/user/store',[UserController::class,'store'])->name('admin.user.store');
    Route::get('/user/show/{id}',[UserController::class,'show'])->name('admin.user.show');
    Route::post('/user/update/{id}',[UserController::class,'update'])->name('admin.user.update');
    Route::get('/user/delete/{id}',[UserController::class,'delete'])->name('admin.user.delete');
    Route::get('/user/FinalDeletion/{id}',[UserController::class,'FinalDeletion'])->name('admin.user.FinalDeletion');
});

// End User Controller

// Start Category Controller

Route::group(['namespace' => 'API' , 'prefix' => 'admin' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/categories',[CategoryController::class,'index'])->name('admin.category.index');
    Route::post('/category/store',[CategoryController::class,'store'])->name('admin.category.store');
    Route::post('/category/update/{id}',[CategoryController::class,'update'])->name('admin.category.update');
    Route::get('/category/status/{id}',[CategoryController::class,'status'])->name('admin.category.status');
    Route::get('/category/delete/{id}',[CategoryController::class,'delete'])->name('admin.category.delete');
});

// End Category Controller

// Start SubCategory Controller

Route::group(['namespace' => 'API' , 'prefix' => 'admin' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/subCategories',[SubCategoryController::class,'index'])->name('admin.subCategory.index');
    Route::post('/subCategory/store',[SubCategoryController::class,'store'])->name('admin.subCategory.store');
    Route::post('/subCategory/update/{id}',[SubCategoryController::class,'update'])->name('admin.subCategory.update');
    Route::get('/subCategory/status/{id}',[SubCategoryController::class,'status'])->name('admin.subCategory.status');
    Route::get('/subCategory/delete/{id}',[SubCategoryController::class,'delete'])->name('admin.subCategory.delete');


});

// End SubCategory Controller

// Start child Controller

Route::group(['namespace' => 'API' , 'prefix' => 'admin' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/childs',[ChildController::class,'index'])->name('admin.child.index');
    Route::post('/child/store',[ChildController::class,'store'])->name('admin.child.store');
    Route::post('/child/update/{id}',[ChildController::class,'update'])->name('admin.child.update');
    Route::get('/child/status/{id}',[ChildController::class,'status'])->name('admin.child.status');
    Route::get('/child/delete/{id}',[ChildController::class,'delete'])->name('admin.child.delete');
});

// End child Controller

// Start Brand Controller

Route::group(['namespace' => 'API' , 'prefix' => 'admin' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/brands',[BrandController::class,'index'])->name('admin.brand.index');
    Route::post('/brand/store',[BrandController::class,'store'])->name('admin.brand.store');
    Route::post('/brand/update/{id}',[BrandController::class,'update'])->name('admin.brand.update');
    Route::get('/brand/delete/{id}',[BrandController::class,'delete'])->name('admin.brand.delete');

});

// End Brand Controller

// Start Language Controller

Route::group(['namespace' => 'API' , 'prefix' => 'admin' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/languages',[LanguageController::class,'index'])->name('admin.language.index');
    Route::post('/language/store',[LanguageController::class,'store'])->name('admin.language.store');
    Route::post('/language/update/{id}',[LanguageController::class,'update'])->name('admin.language.update');
    Route::post('/language/show/{id}',[LanguageController::class, 'show'])->name('admin.language.show');
    Route::get('/language/update_default/{id}',[LanguageController::class,'update_default'])->name('admin.language.update_default');
    Route::get('/language/delete/{id}',[LanguageController::class,'delete'])->name('admin.language.delete');
});

Route::group(['namespace' => 'API' , 'prefix' => 'admin' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/translation',[TranslationsController::class,'index'])->name('admin.translation.index');
    Route::post('/translation/show/{slug}',[TranslationsController::class, 'show'])->name('admin.translation.show');
    Route::post('/translation/update/{slug}',[TranslationsController::class, 'update'])->name('admin.translation.update');
    Route::post('/translation/store',[TranslationsController::class,'store'])->name('admin.translation.store');
});

// End Language Controller

// Start Country Controller

Route::group(['namespace' => 'API' , 'prefix' => 'admin' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/countries',[CountryController::class,'index'])->name('admin.country.index');
    Route::post('/country/store',[CountryController::class,'store'])->name('admin.country.store');
    Route::post('/country/update/{id}',[CountryController::class,'update'])->name('admin.country.update');
    Route::get('/country/delete/{id}',[CountryController::class,'delete'])->name('admin.country.delete');
    Route::get('/country/excel',[CountryController::class,'excel'])->name('admin.country.excel');
    Route::post('/country/import',[CountryController::class,'import'])->name('admin.country.import');

});

// End Country Controller