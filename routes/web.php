<?php

use Illuminate\Support\Facades\Auth;
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
})->name('welcome');

Auth::routes();

Route::get('/home', 'AppController@home')->name('home');

// Profile routes
Route::get('/profile/account', 'CustomerController@profile')->name('profile');

Route::get('/explore', 'AppController@explore')->name('explore');
Route::get('/profile', 'CustomerController@index')->name('customer.index');

// Admin Routes
Route::prefix('admin')->name('admin.')
    ->controller('AdminController')->middleware('role_auth:admin,sysadmin')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('approval', 'approval_view')->name('approval.view');
        Route::get('product/browse', 'product_browse')->name('product.browse');
        Route::get('browse', 'admin_browse_view')->name('browse.view');

        Route::post('register', 'register')->name('register');
        Route::post('approval', 'approval')->name('approval');
        Route::post('browse', 'admin_browse')->name('browse');
    });

Route::get('admin/register', 'AdminController@register_view')->name('admin.register.view');


// Seller Routes
Route::prefix('seller')->name('seller.')
    ->controller('ProductController')->middleware('role_auth:seller')->group(function () {
        Route::get('product/create', 'create')->name('product.create');
        Route::get('product/edit/{id}', 'edit')->name('product.edit');
    });

Route::prefix('seller')->name('seller.')
    ->controller('SellerController')->middleware('role_auth:seller')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('orders', 'product_orders')->name('order.browse');
        Route::get('order/{id}', 'show_order')->name('order.view');
        Route::get('products', 'product_browse')->name('product.browse');
        Route::get('product/{slug}', 'product_show')->name('product.view');

        Route::post('register', 'create_seller')->name('register');
    });

Route::get('seller/register', 'SellerController@seller_form')->name('seller.register.view');


// Product routes
Route::prefix('product')->name('product.')
    ->controller('ProductController')->middleware('role_auth:seller,admin,sysadmin')->group(function () {
        Route::get('deactivate/{id}', 'deactivate')->name('deactivate');
        Route::get('activate/{id}', 'activate')->name('activate');

        Route::post('add', 'store')->name('store');
        Route::post('edit/{id}', 'update')->name('update');
        Route::post('delete/{id}', 'destroy')->name('destroy');
    });

// Route::get('/product/search', 'AppController@search')->name('search.item');

// Default routes
Route::get('/about', 'AppController@about')->name('about');
Route::get('/contact', 'AppController@contact')->name('contact');
Route::post('/contact', 'AppController@create_contact')->name('contact.create');

// Cart Routes
Route::prefix('cart')->name('cart.')
    ->controller('CartController')->group(function () {
        Route::post('store', 'store')->name('store');
        Route::post('incr', 'incr')->name('increment');
        Route::post('decr', 'decr')->name('decrement');
        Route::post('delete', 'destroy')->name('delete');
    });
Route::get('/cart', 'CartController@index')->name('cart');

// Checkout Routes
Route::get('/checkout', 'OrderController@checkout')->name('checkout');
//Route::get('/checkout/form', 'OrderController@create')->name('checkout.add');
/*Route::get('/checkout/processed/cod', 'OrderController@storecod')->name(
    'OrderProcessed.cod'
);
Route::get('/checkout/processed/card', 'OrderController@storecard')->name(
    'OrderProcessed.card'
);*/
// Route::get('/checkout', 'OrderController@index')->name('checkout');
Route::post('/checkout/form', 'OrderController@create')->name('CheckoutForm');
Route::post('/checkout/processed', 'OrderController@store')->name(
    'OrderProcessed'
);
//Route::get('/checkout/processed/buynow/{id}', 'OrderController@buy_now');

Route::get('/orders', 'OrderController@showall')->name('orders');
Route::get('/orders/{id}', 'OrderController@showone')->name('orders.show');
Route::post('/orders/{id}', 'OrderController@cancel_delete')->name(
    'orders.show.cancel.delete'
);

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
// Route::get('/address/edit', 'AddressController@edit_address_view')->name(
//     'address.edit.view'
// );
Route::post('/address/edit', 'AddressController@edit_address')->name(
    'address.edit'
);

//product page
Route::get('/product/{slug}', 'ProductController@show_one')->name(
    'product.view'
);
