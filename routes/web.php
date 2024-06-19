<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

/* Landing page */
Route::get('/', function () {
    return view('welcome');
});

/* disable feature register, reset, verify */
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);


/* Routing for dashboard */
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

/* Routing Grup for menu Employee */
Route::name('employee.')->middleware('auth')->group(function () {
    Route::get('/my-profile/{id}', [EmployeeController::class, 'MyProfile'])->name('MyProfile');
    Route::post('/my-profile-has/update', [EmployeeController::class, 'updateFromProfile'])->name('updateFromProfile');

    /* Route just for admin only */
    Route::middleware('admin')->group(function () {
        Route::get('/employee', [EmployeeController::class, 'index'])->name('index');
        Route::post('/employee/change-password', [EmployeeController::class, 'change_password'])->name('change_password');
        Route::post('/employee/destroy', [EmployeeController::class, 'destroy'])->name('destroy');

        Route::get('/employee/show', [EmployeeController::class, 'show'])->name('show');
        Route::post('/employee/store', [EmployeeController::class, 'store'])->name('store');
        Route::post('/employee/update', [EmployeeController::class, 'update'])->name('update');
    });
});
