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
//Route::post('/login','Auth\LoginController@login_redirect');
Route::get('/seller/register', 'SellerController@seller_form')->name('seller.register');
Route::post('/seller/create', 'SellerController@create_seller')->name('seller.create');

Route::get('/products', 'ProductController@index')->withoutMiddleware(['auth'])->name('Products');
Route::get('/create_product', 'ProductController@create');
Route::post('/product_store', 'ProductController@store');

Route::get('/admin', 'AdminController@index')->name('admin.index');
Route::get('/seller', 'SellerController@index')->name('seller.index');
Route::get('/customer', 'CustomerController@index')->name('customer.index');

Route::get('/admin_registration', 'AdminController@auth_register_view');
Route::post('/admin_registration', 'AdminController@auth_register');
Route::post('/admin_registration/edit', 'AdminController@edit');
Route::get('/admin/approval', 'AdminController@approval_view');
Route::post('/admin/approval', 'AdminController@approval');

Route::get('/product_edit/{id}', 'ProductController@edit');
Route::post('/product_update/{id}', 'ProductController@update');
Route::get('/product_destroy/{id}', 'ProductController@destroy');

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
