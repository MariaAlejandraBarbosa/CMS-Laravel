<?php 

use Illuminate\Support\Facades\Route;


Route::prefix('/admin')->group(function(){
    Route::get('/', 'App\Http\Controllers\Admin\DashboardController@getDashboard')->name('dashboard');

    //Module Setting
    Route::get('/settings', 'App\Http\Controllers\Admin\SettingsController@getHome')->name('settings');
    Route::post('/settings', 'App\Http\Controllers\Admin\SettingsController@postHome')->name('settings');

    //Module users
    Route::get('/users/{status}', 'App\Http\Controllers\Admin\UserController@getUsers')->name('user_list');
    Route::get('/user/{id}/edit', 'App\Http\Controllers\Admin\UserController@getUserEdit')->name('user_edit');
    Route::post('/user/{id}/edit', 'App\Http\Controllers\Admin\UserController@postUserEdit')->name('user_edit');
    Route::get('/user/{id}/banned', 'App\Http\Controllers\Admin\UserController@getUserBanned')->name('user_banned');
    Route::get('/user/{id}/permissions', 'App\Http\Controllers\Admin\UserController@getUserPermissions')->name('user_permissions');
    Route::post('/user/{id}/permissions', 'App\Http\Controllers\Admin\UserController@postUserPermissions')->name('user_permissions');
 
    //Modulo Productos
    Route::get('/products/add', 'App\Http\Controllers\Admin\ProductController@getProductAdd')->name('product_add');
    Route::get('/products/{status}', 'App\Http\Controllers\Admin\ProductController@getHome')->name('products');
    Route::get('/product/{id}/edit', 'App\Http\Controllers\Admin\ProductController@getProductEdit')->name('product_edit');
    Route::get('/product/{id}/delete', 'App\Http\Controllers\Admin\ProductController@getProductDelete')->name('product_delete'); 
    Route::get('/product/{id}/restore', 'App\Http\Controllers\Admin\ProductController@getProductRestore')->name('product_delete'); 
    Route::get('/product/{id}/stock', 'App\Http\Controllers\Admin\ProductController@getProductStock')->name('product_stock');
    Route::post('/product/add', 'App\Http\Controllers\Admin\ProductController@postProductAdd')->name('product_add');
    Route::post('/product/search', 'App\Http\Controllers\Admin\ProductController@postProductSearch')->name('product_search');
    Route::post('/product/{id}/edit', 'App\Http\Controllers\Admin\ProductController@postProductEdit')->name('product_edit');
    Route::post('/product/{id}/gallery/add', 'App\Http\Controllers\Admin\ProductController@postProductGalleryAdd')->name('product_gallery_app');
    Route::post('/product/{id}/stock', 'App\Http\Controllers\Admin\ProductController@postProductStock')->name('product_stock');
    Route::get('/product/{id}/gallery/{gid}/delete', 'App\Http\Controllers\Admin\ProductController@getProductGalleryDelete')->name('product_gallery_delete');
    
    //Module Inventory
    Route::get('/product/stock/{id}/edit/', 'App\Http\Controllers\Admin\ProductController@getProductStockEdit')->name('product_stock');
    Route::post('/product/stock/{id}/edit/', 'App\Http\Controllers\Admin\ProductController@postProductStockEdit')->name('product_stock');
    Route::post('/product/stock/{id}/variant/', 'App\Http\Controllers\Admin\ProductController@postProductStockVariantAdd')->name('product_stock');
    Route::get('/product/stock/{id}/delete/', 'App\Http\Controllers\Admin\ProductController@getProductStockDeleted')->name('product_stock');
    Route::get('/product/variant/{id}/delete/', 'App\Http\Controllers\Admin\ProductController@getProductVariantDeleted')->name('product_stock');
    
    //Categories

    Route::get('/categories/{modules}', 'App\Http\Controllers\Admin\CategoriesController@getHome')->name('categories');
    Route::post('/category/add/{modules}', 'App\Http\Controllers\Admin\CategoriesController@postCategoryAdd')->name('category_add');
    Route::get('/category/{id}/edit','App\Http\Controllers\Admin\CategoriesController@getCategoryEdit')->name('category_edit');
    Route::post('/category/{id}/edit','App\Http\Controllers\Admin\CategoriesController@postCategoryEdit')->name('category_edit');
    Route::get('/category/{id}/subs','App\Http\Controllers\Admin\CategoriesController@getSubCategories')->name('category_edit');
    Route::get('/category/{id}/delete','App\Http\Controllers\Admin\CategoriesController@getCategoryDelete')->name('category_delete');

    //Sliders
    Route::get('/sliders', 'App\Http\Controllers\Admin\SliderController@getHome')->name('sliders_list');
    Route::post('/slider/add', 'App\Http\Controllers\Admin\SliderController@postSliderAdd')->name('slider_add');
    Route::get('/slider/{id}/edit', 'App\Http\Controllers\Admin\SliderController@getEditSlider')->name('slider_edit');
    Route::post('/slider/{id}/edit', 'App\Http\Controllers\Admin\SliderController@postEditSlider')->name('slider_edit');
    Route::get('/slider/{id}/delete', 'App\Http\Controllers\Admin\SliderController@getDeleteSlider')->name('slider_delete');

    //Coverage
    Route::get('/coverage', 'App\Http\Controllers\Admin\CoverageController@getList')->name('coverage_list');
    Route::post('/coverage/state/add', 'App\Http\Controllers\Admin\CoverageController@postCoverageStateAdd')->name('coverage_add');
    Route::get('/coverage/{id}/edit', 'App\Http\Controllers\Admin\CoverageController@getCoverageEdit')->name('coverage_edit');
    Route::post('/coverage/state/{id}/edit', 'App\Http\Controllers\Admin\CoverageController@postCoverageStateEdit')->name('coverage_edit');
    Route::get('/coverage/{id}/delete', 'App\Http\Controllers\Admin\CoverageController@getCoverageDelete')->name('coverage_delete');
});