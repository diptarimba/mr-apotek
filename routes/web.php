<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CorporateController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Corporate\AdminController as CorporateAdminController;
use App\Http\Controllers\Corporate\HomeController as CorporateHomeController;
use App\Http\Controllers\Corporate\ProfileController as CorporateProfileController;
use App\Http\Controllers\Corporate\Steganography\DecryptController;
use App\Http\Controllers\Corporate\Steganography\EncryptController;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\ProfileController;
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
Route::get('/', function () {
    return redirect()->route('login.index');
})->middleware('guest');
// Route::get('/register', function () {
//     return view('page.auth.register');
// })->name('register.index');
Route::get('/reset-password', [LoginRegisterController::class, 'reset_index'])->name('reset_password.index');
Route::post('/reset-password', [LoginRegisterController::class, 'reset_send'])->name('reset_password.send');

Route::get('/change-password/{token}', [LoginRegisterController::class, 'change_password'])->name('change_password.index');
Route::post('/change-password/{token}', [LoginRegisterController::class, 'reset_store'])->name('change_password.store');
Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
Route::get('/login', [LoginRegisterController::class, 'login'])->name('login.index');
Route::post('/authenticate', [LoginRegisterController::class, 'authenticate'])->name('login.post');

Route::middleware(['no_auth'])->group(function () {
    Route::get('me', [ProfileController::class, 'index'])->name('profile.me');
    Route::post('{user}/me', [ProfileController::class, 'store'])->name('profile.store');

    Route::prefix('admin')->as('admin.')->middleware(['role:admin', 'auth'])->group(function () {
        Route::get('dashboard', [AdminHomeController::class, 'index'])->name('dashboard');
        Route::resource('admin', AdminController::class)->parameter('admin', 'user');
        Route::resource('corporate', CorporateController::class);
    });


    Route::prefix('corporate')->as('corporate.')->middleware(['role:user_corporate', 'auth'])->group(function () {
        Route::get('dashboard', [CorporateHomeController::class, 'index'])->name('dashboard');
        Route::get('company', [CorporateProfileController::class, 'index'])->name('company.index');
        Route::post('company', [CorporateProfileController::class, 'update'])->name('company.post');
        Route::resource('admin', CorporateAdminController::class)->parameter('admin', 'user');
        Route::resource('steganography/encrypt', EncryptController::class);
        Route::get('steganography/{decrypt}/decrypt', [DecryptController::class, 'edit'])->name('decrypt.index');
        Route::post('steganography/{decrypt}/decrypt', [DecryptController::class, 'decrypt_store'])->name('decrypt.store');
    });

    Route::get('logout', [LoginRegisterController::class, 'logout'])->name('logout');
});
