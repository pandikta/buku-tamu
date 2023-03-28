<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Route::resource('guest', [GuestController::class]);
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login-proses');

Route::get('guest', [GuestController::class, 'index'])->name('guest');
Route::post('/guests', [GuestController::class, 'store'])->name('guest.store');

Route::middleware('auth')->group(function () {
    Route::get('registrasi', [RegistrationController::class, 'index'])->name('regis');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('search-staff', [RegistrationController::class, 'search_staff'])->name('search-staff');
    Route::get('search-guest', [RegistrationController::class, 'search_guest'])->name('search-guest');
    Route::post('registrasi', [RegistrationController::class, 'store'])->name('regis.store');
});
