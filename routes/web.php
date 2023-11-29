<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\AdminLoginController;

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

Route::get('/', function () {
    return view('welcome');
});

// Define a route group with the 'admin' prefix
Route::group(['prefix' => 'admin'],function(){

    // Group of routes for guests (non-authenticated users)
    Route::group(['middleware' => 'admin.guest'],function() {

        // Display the admin login form
        Route::get('/login',[AdminLoginController::class, 'index'])->name('admin.login');

        // Handle authentication attempt for admin login 
        Route::post('/authenticate',[AdminLoginController::class, 'authenticate'])->name('admin.authenticate');

    });

    // Group of routes for authenticated admin users
    Route::group(['middleware' => 'admin.auth'],function() {

        // Display the admin dashboard
        Route::get('/dashboard',[HomeController::class, 'index'])->name('admin.dashboard');

    });
});
