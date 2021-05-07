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
Route::get('/seller_register', 'SellerController@seller_form');
Route::post('/seller_create', 'SellerController@create_seller');
Route::get('/products', 'ProductController@index')->withoutMiddleware(['auth']);
Route::get('/create_product', 'ProductController@create');
Route::post('/product_store', 'ProductController@store');
Route::get('/admin_registration','AdminController@auth_register_view');
Route::post('/admin_registration','AdminController@auth_register');
Route::get('/admin','AdminController@index');
Route::get('/seller','SellerController@index');
Route::get('/customer','CustomerController@index');

// Default routes
Route::get('/contact', 'AppController@contact')->name('contact');
Route::get('/about', 'AppController@about')->name('about');
