<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\InvoiceProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\POSController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\ProfileController;
use App\Models\Invoice;
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
        Route::get('pos', [POSController::class, 'index'])->name('pos');
        Route::post('pos', [POSController::class, 'store'])->name('pos.store');
        Route::get('order', [OrderController::class, 'index'])->name('order.index');
        Route::get('order/{order}/detail', [OrderController::class, 'detail'])->name('order.detail');
        Route::resource('admin', AdminController::class)->parameter('admin', 'user');
        Route::resource('unit', UnitController::class);
        Route::resource('product', ProductController::class);
        Route::resource('supplier', SupplierController::class);
        Route::patch('invoice/{invoice}/approve', [InvoiceController::class, 'approve'])->name('invoice.approve');
        Route::patch('invoice/{invoice}/paid', [InvoiceController::class, 'paid'])->name('invoice.paid');
        Route::resource('invoice/{invoice}/product', InvoiceProductController::class)->names('invoice-product');
        Route::resource('invoice', InvoiceController::class);
    });

    Route::get('logout', [LoginRegisterController::class, 'logout'])->name('logout');
});
