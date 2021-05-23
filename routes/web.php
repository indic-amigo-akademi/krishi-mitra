<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
})->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/seller/register', 'SellerController@seller_form')->name('seller.register');
Route::post('/seller/create', 'SellerController@create_seller')->name('seller.create');

Route::get('/products', 'ProductController@index')->withoutMiddleware(['auth'])->name('product.browse');
Route::get('/product/create', 'ProductController@create')->name('product.create');
Route::post('/product_store', 'ProductController@store');

Route::get('/admin', 'AdminController@index')->name('admin.index');
Route::get('/seller', 'SellerController@index')->name('seller.index');
Route::get('/customer', 'CustomerController@index')->name('customer.index');

// Admin Routes
Route::get('/admin/register', 'AdminController@register_view')->name('admin.register.view');
Route::post('/admin/register', 'AdminController@register')->name('admin.register');
Route::get('/admin/approval', 'AdminController@approval_view')->name('admin.approval.view');
Route::post('/admin/approval', 'AdminController@approval')->name('admin.approval');

Route::get('/product_edit/{id}', 'ProductController@edit');
Route::post('/product_update/{id}', 'ProductController@update');
Route::get('/product_destroy/{id}', 'ProductController@destroy');

// Default routes
Route::get('/about', 'AppController@about')->name('about');
Route::post('/contact', 'AppController@create_contact')->name('contact.create');
Route::get('/contact', 'AppController@contact')->name('contact');

// Cart Routes
Route::post('/cart/store', 'CartController@store');
Route::get('/cart', 'CartController@index')->name('cart');
Route::post('/cart/delete', 'CartController@destroy')->name('cart.destroy');
Route::post('/cart/incr', 'CartController@incr')->name('cart.increment');
Route::post('/cart/decr', 'CartController@decr')->name('cart.decrement');

Route::get('/checkout', 'OrderController@index')->name('checkout');
Route::get('/checkout/form', 'OrderController@create')->name('CheckoutForm');
Route::get('/checkout/processed/cod', 'OrderController@storecod')->name('OrderProcessed.cod');
Route::get('/checkout/processed/card', 'OrderController@storecard')->name('OrderProcessed.card');
Route::get('/orders', 'OrderController@showall')->name('ShowOrders');
Route::get('/orders/{id}', 'OrderController@showone')->name('ShowSingle');

//product page
Route::get('/product', function () {
    return view('product');
})->name('product');

//seller detail product page
Route::get('/sproducts_detail/{id}', 'ProductController@show');
