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

Route::group(['namespace' => '\Modules\Product\Http\Controllers\Backend', 'as' => 'backend.', 'middleware' => ['web', 'auth'], 'prefix' => 'admin'], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Posts Routes
     *
     * ---------------------------------------------------------------------
     */
    //Product
    Route::get('product/index', ['as' => "product.index", 'uses' => 'ProductController@index']);
    Route::get('product/create', ['as' => "product.create", 'uses' => 'ProductController@create']);
    Route::post('products/store', ['as' => 'product.store', 'uses' => 'ProductController@store']);
    Route::get('products/{id}/edit', ['as' => 'product.edit', 'uses' => 'ProductController@editProduct']);
    Route::post('products/{id}/update', ['as' => 'product.update', 'uses' => 'ProductController@updateProduct']);
    Route::get('products/{id}/add-variant', ['as' => 'product.addVariant', 'uses' => 'ProductController@addVariant']);
    Route::post('products/{id}/store-variant', ['as' => 'product.storeVariant', 'uses' => 'ProductController@storeVariant']);
    Route::get('products/{product_id}/edit-variant/{id}/edit', ['as' => 'product.editVariant', 'uses' => 'ProductController@editVariant']);
    Route::post('products/{product_id}/update-variant/{id}/update', ['as' => 'product.updateVariant', 'uses' => 'ProductController@updateVariant']);
    Route::get('products/preview', ['as' => 'product.preview', 'uses' => 'ProductController@productPreview']);
    //Product Category
    Route::get("product/category/index", ['as' => "product.category.index", 'uses' => "CategoryController@index"]);
    Route::get('product/category/create', ['as' => "product.category.create", 'uses' => "CategoryController@create"]);
    Route::post('product/category/store', ['as' => "product.category.store", 'uses' => "CategoryController@store"]);
    Route::get('products/category/{id}/edit', ['as' => "product.category.edit", 'uses' => "CategoryController@edit"]);
    Route::post('products/category/{id}/update', ['as' => "product.category.update", 'uses' => 'CategoryController@update']);
    Route::post('products/category{id}/delete', ['as' => "product.category.delete", 'uses' => "CategoryController@destroy"]);

    /*
     *
     *  Categories Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'categories';
    $controller_name = 'CategoriesController';
    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    Route::resource("$module_name", "$controller_name");
});
