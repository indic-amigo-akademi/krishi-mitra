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

Route::get('/home', 'AppController@home')->name('home'); // test done

// Profile routes
Route::get('/profile/account', 'CustomerController@profile')->name('profile'); // test done
Route::get('/profile', 'CustomerController@index')->name('customer.index'); // test done
Route::get('/explore', 'AppController@explore')->name('explore'); // review

// Admin Routes
Route::prefix('admin')->name('admin.')
    ->controller('AdminController')->middleware('role_auth:admin,sysadmin')->group(function () {
        Route::get('/', 'index')->name('index'); // test done
        Route::get('approval', 'approval_view')->name('approval.view'); // test done
        Route::get('product/browse', 'product_browse')->name('product.browse'); // test done
        Route::get('browse', 'admin_browse_view')->name('browse.view'); // test done

        Route::post('register', 'register')->name('register');
        Route::post('approval', 'approval')->name('approval');
        Route::post('browse', 'admin_browse')->name('browse');
    });

Route::get('admin/register', 'AdminController@register_view')->name('admin.register.view'); // test done


// Seller Routes
Route::prefix('seller')->name('seller.')
    ->controller('ProductController')->middleware('role_auth:seller')->group(function () {
        Route::get('product/create', 'create')->name('product.create');
        Route::get('product/edit/{id}', 'edit')->name('product.edit');
    });

Route::prefix('seller')->name('seller.')
    ->controller('SellerController')->middleware('role_auth:seller')->group(function () {
        Route::get('/', 'index')->name('index'); // test done
        Route::get('orders', 'product_orders')->name('order.browse'); // test done
        Route::get('order/{id}', 'show_order')->name('order.view'); // test done
        Route::get('products', 'product_browse')->name('product.browse'); // test done
        Route::get('product/{slug}', 'product_show')->name('product.view'); // test done

        Route::post('register', 'create_seller')->name('register');
    });

Route::get('seller/register', 'SellerController@seller_form')->name('seller.register.view'); // test done


// Product routes
Route::prefix('product')->name('product.')
    ->controller('ProductController')->middleware('role_auth:seller,admin,sysadmin')->group(function () {
        Route::get('deactivate/{id}', 'deactivate')->name('deactivate'); // review
        Route::get('activate/{id}', 'activate')->name('activate'); // review

        Route::post('add', 'store')->name('store');
        Route::post('edit/{id}', 'update')->name('update');
        Route::post('delete/{id}', 'destroy')->name('destroy');
    });

// Route::get('/product/search', 'AppController@search')->name('search.item');

// Default routes
Route::get('/about', 'AppController@about')->name('about'); // test done
Route::get('/contact', 'AppController@contact')->name('contact'); // test done
Route::post('/contact', 'AppController@create_contact')->name('contact.create');

// Cart Routes
Route::prefix('cart')->name('cart.')
    ->controller('CartController')->group(function () {
        Route::post('store', 'store')->name('store');
        Route::post('incr', 'incr')->name('increment');
        Route::post('decr', 'decr')->name('decrement');
        Route::post('delete', 'destroy')->name('delete');
    });
Route::get('/cart', 'CartController@index')->name('cart'); // test done

// Checkout Routes
Route::get('/checkout', 'OrderController@checkout')->name('checkout'); // test done
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

Route::get('/orders', 'OrderController@showall')->name('orders'); // test done
Route::get('/orders/{id}', 'OrderController@showone')->name('orders.show'); // test done
Route::post('/orders/{id}', 'OrderController@cancel_delete')->name(
    'orders.show.cancel.delete'
);

// Address Routes

Route::prefix('address')->name('address.')
    ->controller('AddressController')->group(function () {
        Route::get('add', 'add')->name(
            'add.view'
        ); // test done
        
        Route::post('add', 'create')->name(
            'add'
        ); // test done
        Route::post('', 'update_delete')->name(
            'edit.delete'
        );
        Route::post('edit', 'edit')->name(
            'edit'
        ); // test done
    });
Route::get('/address', 'AddressController@view')->name('address'); // test done
// Route::get('/address/edit', 'AddressController@edit_address_view')->name(
//     'address.edit.view'
// );


//product page
Route::get('/product/{slug}', 'ProductController@show_one')->name(
    'product.view'
); // test done
