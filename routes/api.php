<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PosAccountController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::get('/login', [UserController::class,'login']);
// //Route::post('/loginCheck', [UserController::class,'loginCheck'])->name('loginCheck');
// Route::get('/registration-form',[RegistrationController::class, 'showRegisterFrom']);
// Route::get('/countries',[CountryController::class,'getCountry'])->name('country');
// Route::get('/terms',[UserController::class,'getTerms']);
// Route::post('/member/register',[UserController::class,'store'])->name('store.register');


// //Route::middleware('login')->group(function(){
//     Route::post('/register',[RegistrationController::class,'register']);
//     Route::get('/verify',[RegistrationController::class,'verifyEmail']);
//     Route::post('/logincheck',[UserController::class,'loginCheck'])->name('logincheck');
//     Route::get('/dashboard',[DashboardController::class,'index']);
//     Route::get('user-crate',[UserController::class,'userCreate'])->name('create.user');
//     Route::get('all-users',[UserController::class,'userIndex'])->name('user.index');
//     Route::get('get/sidebar',[ModuleController::class,'sidebar'])->name('get.sidebar');
//     Route::get('/navigation',[ModuleController::class,'viewNavigation'])->name('view.navigation');
//     Route::get('/show-navigation',[ModuleController::class,'allNavigation'])->name('all.navigation');

//});

Route::group(['middleware'=>'api'],function($router){
    Route::post('/register',[RegistrationController::class,'register']);
    Route::get('/verify',[RegistrationController::class,'verifyEmail']);
    Route::post('/loginCheck',[RegistrationController::class,'login'])->name('logincheck');
});

Route::post('/pos/request',[PosAccountController::class,'store']);

