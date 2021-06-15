<?php

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

Route::get('/home', 'CustomerController@home')->name('home');

// Profile routes
Route::get('/profile/account', 'CustomerController@profile')->name('profile');

Route::get('/seller/register', 'SellerController@seller_form')->name(
    'seller.register'
);
Route::post('/seller/create', 'SellerController@create_seller')->name(
    'seller.create'
);

Route::get('/explore', 'AppController@explore')->name('product.browse');
Route::get('/profile', 'CustomerController@index')->name('customer.index');

// Admin Routes
Route::get('/admin', 'AdminController@index')->name('admin.index');
Route::get('/admin/register', 'AdminController@register_view')->name(
    'admin.register.view'
);
Route::post('/admin/register', 'AdminController@register')->name(
    'admin.register'
);
Route::get('/admin/approval', 'AdminController@approval_view')->name(
    'admin.approval.view'
);
Route::post('/admin/approval', 'AdminController@approval')->name(
    'admin.approval'
);
Route::get('/admin/product/browse', 'AdminController@browse')->name(
    'admin.product.browse'
);
Route::get('/admin/browse', 'AdminController@admin_browse_view')->name(
    'admin.browse.view'
);
Route::post('/admin/browse', 'AdminController@admin_browse')->name(
    'admin.browse'
);

// Seller Routes
Route::get('/seller', 'SellerController@index')->name('seller.index');
Route::get('/seller/products', 'SellerController@product_display')->name(
    'seller.product.browse'
);
Route::get('/seller/product/create', 'ProductController@create')->name(
    'seller.product.create'
);
Route::get('/seller/product/edit/{id}', 'ProductController@edit')->name(
    'seller.product.edit'
);
Route::get('/seller/product/{slug}', 'SellerController@product_show')->name(
    'seller.product.view'
);

// Product routes
Route::post('/product/store', 'ProductController@store')->name('product.store');
Route::post('/product/update/{id}', 'ProductController@update')->name(
    'product.update'
);
Route::post('/product/destroy/{id}', 'ProductController@destroy')->name(
    'product.destroy'
);
Route::get('/product/inactivate/{id}', 'ProductController@inactivate')->name(
    'product.inactivate'
);
Route::get('/product/activate/{id}', 'ProductController@activate')->name(
    'product.activate'
);
Route::get('/product/search', 'ProductController@search')->name('search.item');

// Default routes
Route::get('/about', 'AppController@about')->name('about');
Route::get('/contact', 'AppController@contact')->name('contact');
Route::post('/contact', 'AppController@create_contact')->name('contact.create');

// Cart Routes
Route::get('/cart', 'CartController@index')->name('cart');
Route::post('/cart/store', 'CartController@store')->name('cart.store');
Route::post('/cart/incr', 'CartController@incr')->name('cart.increment');
Route::post('/cart/decr', 'CartController@decr')->name('cart.decrement');
Route::post('/cart/delete', 'CartController@destroy')->name('cart.destroy');

// Checkout Routes
Route::get('/checkout', 'OrderController@checkout')->name('checkout');
Route::get('/checkout/form', 'OrderController@create')->name('checkout.add');
Route::get('/checkout/processed/cod', 'OrderController@storecod')->name(
    'OrderProcessed.cod'
);
Route::get('/checkout/processed/card', 'OrderController@storecard')->name(
    'OrderProcessed.card'
);
// Route::get('/checkout', 'OrderController@index')->name('checkout');
Route::get('/checkout1/{id}', 'OrderController@index1')->name(
    'checkout_buynow'
);
Route::post('/checkout/form', 'OrderController@create')->name('CheckoutForm');
Route::get('/checkout/processed', 'OrderController@store')->name(
    'OrderProcessed'
);
Route::get('/checkout/processed/buynow/{id}', 'OrderController@buy_now');

Route::get('/orders', 'OrderController@showall')->name('orders');
Route::get('/orders/{id}', 'OrderController@showone')->name('orders.show');

// Address Routes
Route::get('/address', 'AddressController@address_view')->name('address');
Route::post('/address', 'AddressController@address_edit_delete')->name(
    'address.edit.delete'
);
Route::get('/address/add', 'AddressController@add_address_view')->name(
    'address.add.view'
);
Route::post('/address/add', 'AddressController@add_address')->name(
    'address.add'
);
Route::get('/address/edit', 'AddressController@edit_address_view')->name(
    'address.edit.view'
);
Route::post('/address/edit', 'AddressController@edit_address')->name(
    'address.edit'
);

//product page
Route::get('/product', function () {
    return view('product');
})->name('product');
