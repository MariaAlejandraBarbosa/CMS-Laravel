<?php

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

Route::get('/', 'App\Http\Controllers\ContentController@getHome')->name('home');

//Cart
Route::get('/cart', 'App\Http\Controllers\CartController@getCart')->name('cart');
Route::post('/cart/product/{id}/add', 'App\Http\Controllers\CartController@postCartAdd')->name('cart_add');
Route::post('/cart/item/{id}/update', 'App\Http\Controllers\CartController@postCartItemQuantityUpdate')->name('cart_item_uptade');
Route::get('/cart/item/{id}/delete', 'App\Http\Controllers\CartController@getCartItemDelete')->name('cart_item_delete');   

//Store
Route::get('/store', 'App\Http\Controllers\StoreController@getStore')->name('store');
Route::get('/store/category/{id}/{slug}', 'App\Http\Controllers\StoreController@getCategory')->name('store_category');
Route::post('/search', 'App\Http\Controllers\StoreController@postSearch')->name('search');

// Router Auth
Route::get('/login', 'App\Http\Controllers\ConnectController@getLogin')->name('login');
Route::post('/login', 'App\Http\Controllers\ConnectController@postLogin')->name('login');
Route::get('/recover', 'App\Http\Controllers\ConnectController@getRecover')->name('recover');
Route::post('/recover', 'App\Http\Controllers\ConnectController@postRecover')->name('recover');

Route::get('/reset', 'App\Http\Controllers\ConnectController@getReset')->name('reset');
Route::post('/reset', 'App\Http\Controllers\ConnectController@postReset')->name('reset');


Route::get('/register', 'App\Http\Controllers\ConnectController@getRegister')->name('register');
Route::post('/register', 'App\Http\Controllers\ConnectController@postRegister')->name('register');
Route::get('/logout', 'App\Http\Controllers\ConnectController@getLogout')->name('logout');

//Module Products
Route::get('/product/{id}/{slug}', 'App\Http\Controllers\ProductController@getProduct')->name('product_single');

//Module User Actions
Route::get('/account/edit', 'App\Http\Controllers\UserController@getAccountEdit')->name('account_edit');
Route::post('account/edit/avatar', 'App\Http\Controllers\UserController@postAccountAvatar')->name('account_avatar_edit');
Route::post('account/edit/password', 'App\Http\Controllers\UserController@postAccountPassword')->name('account_password_edit');
Route::post('account/edit/info', 'App\Http\Controllers\UserController@postAccountInfo')->name('account_info_edit');
Route::get('/account/address', 'App\Http\Controllers\UserController@getAccountAddress')->name('account_address');
Route::post('/account/address/add', 'App\Http\Controllers\UserController@postAccountAddressAdd')->name('account_address');
Route::get('/account/address/{address}/setdefault', 'App\Http\Controllers\UserController@getAccountAddressSetDefault')->name('account_address');
Route::get('/account/address/{address}/delete', 'App\Http\Controllers\UserController@getAccountAddressDelete')->name('account_address');


//Ajax Api Routers
Route::get('/md/api/load/products/{section}/', 'App\Http\Controllers\ApiJsController@getProductsSection');
Route::post('/md/api/load/user/favorites', 'App\Http\Controllers\ApiJsController@postUserFavorites');
Route::post('/md/api/favorites/add/{object}/{module}', 'App\Http\Controllers\ApiJsController@postFavoriteAdd');
Route::post('/md/api/load/product/stock/{stc}/variants', 'App\Http\Controllers\ApiJsController@postProductStockVariants');
Route::post('/md/api/load/cities/{state}', 'App\Http\Controllers\ApiJsController@postCoverageCitiesFromState');