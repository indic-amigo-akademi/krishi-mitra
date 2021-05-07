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
Route::get('/customer', 'CustomerController@index')->name('customer.index');

Route::get('/seller', 'SellerController@index')->name('seller.index');
Route::get('/seller/register', 'SellerController@seller_form')->name(
    'seller.register'
);
Route::post('/seller/create', 'SellerController@create_seller')->name(
    'seller.create'
);

Route::get('/admin', 'AdminController@index')->name('admin.index');
Route::get('/admin_registration', 'AdminController@auth_register_view');
Route::post('/admin_registration', 'AdminController@auth_register');
Route::post('/admin_registration/edit', 'AdminController@edit');

Route::get('/products', 'ProductController@index')->withoutMiddleware(['auth']);
Route::get('/create_product', 'ProductController@create');
Route::post('/product_store', 'ProductController@store');
Route::get('/product_edit/{id}', 'ProductController@edit');
Route::post('/product_update/{id}', 'ProductController@update');
Route::get('/product_destroy/{id}', 'ProductController@destroy');

// Default routes
Route::get('/contact', 'AppController@contact')->name('contact');
Route::get('/about', 'AppController@about')->name('about');
