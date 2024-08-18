<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\FeatureController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Vendor\Backend\ProductController as VendorProductController;
use App\Http\Controllers\Vendor\VendorController;
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

Route::get('/', [IndexController::class, 'index']);


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'UserDashboard'])->name('dashboard');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::post('/user/update/password', [UserController::class, 'UserUpdatePassword'])->name('user.update.password');

});

Route::get('/profile', [App\Http\Controllers\HomeController::class, 'index'])->name('profile');
Route::get('/category', [App\Http\Controllers\HomeController::class, 'category'])->name('category');
Route::get('/products', [App\Http\Controllers\HomeController::class, 'products'])->name('products');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
    Route::get('/vendor/login', [VendorController::class, 'VendorLogin'])->name('vendor.login');
});


Route::middleware(['auth', 'user_type:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminDestroy'])->name('admin.logout');

    Route::get('/all/category', [CategoryController::class, 'allCategory'])->name('all.category');
    Route::get('/add/category', [CategoryController::class, 'addCategory'])->name('add.category');
    Route::post('/store/category', [CategoryController::class, 'storeCategory'])->name('store.category');

    Route::get('/all/feature', [FeatureController::class, 'allFeature'])->name('all.feature');
    Route::get('/add/feature', [FeatureController::class, 'addFeature'])->name('add.feature');
    Route::post('/store/feature', [FeatureController::class, 'storeFeature'])->name('store.feature');
    
    Route::get('/all/product', [ProductController::class, 'allProduct'])->name('all.product');
    Route::get('/add/product', [ProductController::class, 'addProduct'])->name('add.product');
    Route::post('/store/product', [ProductController::class, 'storeProduct'])->name('store.product');
});

Route::middleware(['auth', 'user_type:vendor'])->prefix('vendor')->group(function(){
    Route::get('/dashboard', [VendorController::class, 'VendorDashboard'])->name('vendor.dashboard');
    Route::get('/logout', [VendorController::class, 'VendorDestroy'])->name('vendor.logout');

    Route::get('/all/product', [VendorProductController::class, 'allProduct'])->name('vendor.all.product');
    Route::get('/add/product', [VendorProductController::class, 'addProduct'])->name('vendor.add.product');
    Route::post('/store/product', [VendorProductController::class, 'storeProduct'])->name('vendor.store.product');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
