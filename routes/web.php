<?php

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

Route::get('test', function () {
    return view('test');
});
Route::get('get-statistics', 'StatisticsController@index')->name('getStatistics');
Route::get('sales-by-mounth', 'StatisticsController@getSalesByMounth')->name('getSalesByMounth');
Route::get('get-year-order', 'StatisticsController@getOrderYear')->name('get-year-order');
Route::get('get-order-by-brand', 'StatisticsController@getSalesByBrand')->name('getOrderByBrand');

Route::get('/', function () {
    return view('layouts.master');
});
//Route::get('test', function () {
//    return view('test');
//});
Route::get('/admin', function () {
    return view('layouts.master');
})->name('admin');

Route::apiResources([
    'brands'            => 'BrandController',
    'suppliers'         => 'SupplierController',
    'category'          => 'CategoryController',
    'attribute-group'   => 'AttributeGroupController',
    'attributes'        => 'AttributeController',
    'status'            => 'StatusController',
    'payment-method'    => 'PaymentMethodController',
    'payment-status'    => 'PaymentStatusController',
    'sale'              => 'SaleController',
    'attribute-value'   => 'AttributeValueController',
    'order'             => 'OrderController',
    'menu'              => 'MenuController',
    'user'              => 'UserController',
]);
Route::resource('product' , 'ProductController');
Route::get('product-import', 'ProductController@importView')->name('product.import');
Route::post('product-import', 'ProductController@import');
Route::get('product-export', 'ProductController@export')->name('export');
//Route::resource('product/{id}/gallery' , 'ProductImageController');
Route::get('attribute/api/getAll/{id}','AttributeController@getAttribute');
Route::get('brand/api/getAll','BrandController@getBrand')->name('brand/api/getAll');
Route::get('supplier/api/getAll','SupplierController@getSupplier')->name('supplier/api/getAll');
Route::get('category/api/getAll','CategoryController@getCategory')->name('category/api/getAll');
Route::get('status/api/getAll','StatusController@getStatus')->name('status/api/getAll');
Route::get('payment-status/api/getAll','paymentStatusController@getPaymentStatus')->name('payment-status/api/getAll');
Route::get('payment-method/api/getAll','paymentMethodController@getPaymentMethod')->name('payment-method/api/getAll');
Route::get('attribute-group/api/getAll','AttributeGroupController@getAttributeGroup')->name('attribute-group/api/getAll');
Route::post('attribute/api/post','AttributeGroupController@postAttribute')->name('attribute/api/post');
Route::resource('product/{id}/gallery' , 'ProductImageController')->except([
    'edit', 'create'
]);
Route::resource('product/{id}/attribute-value' , 'AttributeValueController')->except([
    'edit', 'create'
]);
Route::prefix('menu')->group(function (){
    Route::get('/','MenuController@index')->name('menu.index');
    Route::post('/','MenuController@store');
    Route::delete('/{id}','MenuController@destroy');
    Route::put('/','MenuController@update');
});
Route::resource('banner' , 'BannerController')->except([
    'edit', 'create'
]);
Route::post('ckeditor/image_upload', 'CKEditorController@upload')->name('upload');

Route::get('order/show/{id}','OrderController@showOrderDetail')->name('order.showOrderDetail');

Route::get('group/api/getAll','GroupController@getGroup')->name('group/api/getAll');
