<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('user/login',[ LoginController::class, 'loginUser'])->name('loginUser');
Route::get('user/login',[ LoginController::class, 'login'])->name('login');
Route::get('user/dashboard',[ HomeController::class, 'userDashboard'])->name('userDashboard');



Auth::routes();

Route::post('register/users',[ RegisterController::class, 'register'])->name('register');
Route::get('register/users',[ RegisterController::class, 'viewRegister'])->name('viewRegister');




Route::group(['middleware' => ['auth']], function() {
    Route::group(['middleware' => ['role:Admin']], function ()
     {

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::get('/', [HomeController::class, 'index'])->name('home');

      });

      /**
   * Logout Route
   */
   Route::get('/logout', [LogoutController::class,'perform'])->name('logout.perform');
 
});
