<?php

use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\AreaController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ChildController;
use App\Http\Controllers\API\CityController;
use App\Http\Controllers\API\CountryController;
use App\Http\Controllers\API\LanguageController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\SellerController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\SubCategoryController;
use App\Http\Controllers\API\TranslationsController;
use App\Http\Controllers\API\TaxeController;
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

Route::group(['namespace' => 'API' , 'prefix' => 'admin' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/all',[AdminController::class,'all'])->name('admin.all');
    Route::post('/store',[AdminController::class,'store'])->name('admin.store');
});

// Start Profile Controller

Route::group(['namespace' => 'API' , 'prefix' => 'admin' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/profile',[ProfileController::class,'index'])->name('admin.profile.index');
    Route::post('/profile/update',[ProfileController::class,'update'])->name('admin.profile.update');
    Route::post('/profile/password_change',[ProfileController::class,'password_change'])->name('admin.profile.password_change');
    Route::get('/profile/logout',[ProfileController::class,'logout'])->name('admin.profile.logout');
});

// End Profile Controller

// Start Role Controller

Route::group(['namespace' => 'API' , 'prefix' => 'admin' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/roles',[RoleController::class,'index'])->name('admin.role.index');
    Route::post('/role/store',[RoleController::class,'store'])->name('admin.role.store');
    Route::get('/role/show/{id}',[RoleController::class,'show'])->name('admin.role.show');
    Route::post('/role/permission/{id}',[RoleController::class,'permission'])->name('admin.role.permission');
    Route::post('/role/update/{id}',[RoleController::class,'update'])->name('admin.role.update');
    Route::get('/role/delete/{id}',[RoleController::class,'delete'])->name('admin.role.delete');
});

// End Role Controller

// Start User Controller

Route::group(['namespace' => 'API' , 'prefix' => 'admin' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/users',[UserController::class,'index'])->name('admin.user.index');
    Route::post('/user/store',[UserController::class,'store'])->name('admin.user.store');
    Route::get('/user/show/{id}',[UserController::class,'show'])->name('admin.user.show');
    Route::get('/user/changeStatusMethod/{id}',[UserController::class,'status'])->name('admin.user.status');
    Route::post('/user/update/{id}',[UserController::class,'update'])->name('admin.user.update');
    Route::get('/user/archiveMethod/{id}',[UserController::class,'archived'])->name('admin.user.archived');
    Route::get('/user/viewArchived/',[UserController::class,'user_archived'])->name('admin.user.user_archived');
    Route::get('/user/unarchiveMethod/{id}',[UserController::class,'unArchived'])->name('admin.user.unArchived');
    Route::get('/user/deleteMethod/{id}',[UserController::class,'delete'])->name('admin.user.delete');


});

// End User Controller

// Start Category Controller

Route::group(['namespace' => 'API' , 'prefix' => 'admin' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/categories',[CategoryController::class,'index'])->name('admin.category.index');
    Route::post('/category/store',[CategoryController::class,'store'])->name('admin.category.store');
    Route::post('/category/update/{id}',[CategoryController::class,'update'])->name('admin.category.update');
    Route::get('/category/changeStatusMethod/{id}',[CategoryController::class,'status'])->name('admin.category.status');
    Route::get('/category/deleteMethod/{id}',[CategoryController::class,'delete'])->name('admin.category.delete');
});

// End Category Controller

// Start SubCategory Controller

Route::group(['namespace' => 'API' , 'prefix' => 'admin' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/subCategories',[SubCategoryController::class,'index'])->name('admin.subCategory.index');
    Route::post('/subCategory/store',[SubCategoryController::class,'store'])->name('admin.subCategory.store');
    Route::post('/subCategory/update/{id}',[SubCategoryController::class,'update'])->name('admin.subCategory.update');
    Route::get('/subCategory/changeStatusMethod/{id}',[SubCategoryController::class,'status'])->name('admin.subCategory.status');
    Route::get('/subCategory/deleteMethod/{id}',[SubCategoryController::class,'delete'])->name('admin.subCategory.delete');


});

// End SubCategory Controller

// Start child Controller

Route::group(['namespace' => 'API' , 'prefix' => 'admin' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/childs',[ChildController::class,'index'])->name('admin.child.index');
    Route::post('/child/store',[ChildController::class,'store'])->name('admin.child.store');
    Route::post('/child/update/{id}',[ChildController::class,'update'])->name('admin.child.update');
    Route::get('/child/changeStatusMethod/{id}',[ChildController::class,'status'])->name('admin.child.status');
    Route::get('/child/deleteMethod/{id}',[ChildController::class,'delete'])->name('admin.child.delete');
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

// Start City Controller

Route::group(['namespace' => 'API' , 'prefix' => 'admin' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/citys',[CityController::class,'index'])->name('admin.city.index');
    Route::post('/city/store',[CityController::class,'store'])->name('admin.city.store');
    Route::post('/city/update/{id}',[CityController::class,'update'])->name('admin.city.update');
    Route::get('/city/delete/{id}',[CityController::class,'delete'])->name('admin.city.delete');
    Route::get('/city/excel',[CityController::class,'excel'])->name('admin.city.excel');
    Route::post('/city/import',[CityController::class,'import'])->name('admin.city.import');
});

// End City Controller

// Start Area Controller

Route::group(['namespace' => 'API' , 'prefix' => 'admin' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/areas',[AreaController::class,'index'])->name('admin.area.index');
    Route::post('/area/store',[AreaController::class,'store'])->name('admin.area.store');
    Route::post('/area/update/{id}',[AreaController::class,'update'])->name('admin.area.update');
    Route::get('/area/delete/{id}',[AreaController::class,'delete'])->name('admin.area.delete');
    Route::get('/area/excel',[AreaController::class,'excel'])->name('admin.area.excel');
    Route::post('/area/import',[AreaController::class,'import'])->name('admin.area.import');
});

// Start Area Controller



// Start Taxe Controller

Route::group(['namespace' => 'API' , 'prefix' => 'admin' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/taxes',[TaxeController::class,'index'])->name('admin.taxe.index');
    Route::post('/taxe/store',[TaxeController::class,'store'])->name('admin.taxe.store');
    Route::post('/taxe/update/{id}',[TaxeController::class,'update'])->name('admin.taxe.update');
    Route::get('/taxe/delete/{id}',[TaxeController::class,'delete'])->name('admin.taxe.delete');
    Route::get('/taxe/excel',[TaxeController::class,'excel'])->name('admin.taxe.excel');
    Route::post('/taxe/import',[TaxeController::class,'import'])->name('admin.taxe.import');
});

// Start Taxe Controller

// Start Seller Controller

Route::group(['namespace' => 'API' , 'prefix' => 'admin' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/sellers',[SellerController::class,'index'])->name('admin.seller.index');
    Route::post('/seller/store',[SellerController::class,'store'])->name('admin.seller.store');
    Route::post('/seller/update/{id}',[SellerController::class,'update'])->name('admin.seller.update');
    Route::get('/seller/changeStatusMethod/{id}',[SellerController::class,'status'])->name('admin.seller.status');
    Route::get('/seller/deleteMethod/{id}',[SellerController::class,'delete'])->name('admin.seller.delete');

});

// End Seller Controller

// Start Service Controller

Route::group(['namespace' => 'API' , 'prefix' => 'admin' , 'middleware' => 'auth:sanctum'],function(){
    Route::get('/services',[ServiceController::class,'index'])->name('admin.service.index');
    Route::post('/service/store',[ServiceController::class,'store'])->name('admin.service.store');
    Route::post('/service/update/{id}',[ServiceController::class,'update'])->name('admin.service.update');
    Route::get('/service/changeStatusMethod/{id}',[ServiceController::class,'status'])->name('admin.service.status');
    Route::get('/service/deleteMethod/{id}',[ServiceController::class,'delete'])->name('admin.service.delete');
});

// End Service Controller
