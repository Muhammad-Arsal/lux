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

// use Illuminate\Routing\Route;

Route::group(['namespace' => '\Modules\Customers\Http\Controllers', 'as' => 'backend.', 'middleware' => ['web', 'auth'], 'prefix' => 'admin'], function () {

    Route::get('customers', ['as' => "customer.view", 'uses' => 'CustomersController@index']);
    Route::get('customers/create', ['as' => "customer.add", 'uses' => 'CustomersController@createPage']);
    Route::post('customers/add', ['as' => 'customer.store', 'uses' => 'CustomersController@store']);
    Route::get('customers/{id}/edit', ['as' => 'customer.edit', 'uses' => 'CustomersController@edit']);
    Route::post('customers/{id}/update', ['as' => 'customer.update', 'uses' => 'CustomersController@update']);
    Route::post('customers/{id}/delete', ['as' => 'customer.delete', 'uses' => 'CustomersController@destroy']);
});
