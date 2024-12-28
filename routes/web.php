<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;

use App\Http\Controllers\Auth\AdminRegisterController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AddProductController;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/forgotpassword', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/search', [ShopController::class, 'search'])->name('shop.search');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

Route::get('/adminlogin', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/adminlogin', [AdminLoginController::class, 'login']);
Route::get('/adminlogout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::get('/adminregister', [AdminRegisterController::class, 'showRegistrationForm'])->name('admin.register');
Route::post('/adminregister', [AdminRegisterController::class, 'register']);

Route::get('/admindashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware('auth:admin');

// User Route for "About Product" page (accessible by all)
Route::get('/aboutproduct', [AddProductController::class, 'create'])->name('aboutproduct');

// Admin Routes (Protected with 'auth:admin' middleware)
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/aboutproduct/admin', [AddProductController::class, 'create'])->name('about.product'); // Admin route
    Route::post('/storeproduct', [AddProductController::class, 'store'])->name('product.store');
    Route::delete('/deleteproduct/{product}', [AddProductController::class, 'destroy'])->name('product.destroy');

    // Routes for editing products
    Route::get('/editproduct/{product}', [AddProductController::class, 'edit'])->name('product.edit'); // Show edit form
    Route::put('/updateproduct/{product}', [AddProductController::class, 'update'])->name('product.update'); // Update product
});

// Product-related actions (Admin access)
Route::get('/editproduct/{id}', [ProductController::class, 'edit'])->name('edit.product');
Route::put('/updateproduct/{id}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

// Admin routes for managing categories
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admindashboard', [CategoryController::class, 'index'])->name('admindashboard');
    Route::post('/admindashboard', [CategoryController::class, 'store'])->name('store.category');
    Route::post('/updatecategory', [CategoryController::class, 'update'])->name('update.category');
    Route::delete('/deletecategory/{id}', [CategoryController::class, 'destroy'])->name('delete.category');
});

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/process', [CheckoutController::class, 'checkout'])->name('checkout.process');
Route::get('/checkedout', [CheckoutController::class, 'checkedOut'])->name('checkedout.index');
Route::delete('/order/remove/{id}', [CheckoutController::class, 'removeOrder'])->name('order.remove');

// Static pages
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/services', [ServicesController::class, 'index'])->name('services');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/send-email', [ContactController::class, 'sendEmail'])->name('send.email');

Route::get('/total-users', [UserController::class, 'totalUsers'])->name('total-users');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

Route::get('/orders', [UserController::class, 'allOrders'])->name('orders');  // Accessing orders
Route::get('/user/{user}/orders', [UserController::class, 'userOrders'])->name('user.orders');  // Specific user orders


