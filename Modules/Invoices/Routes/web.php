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

use Modules\Invoices\Http\Controllers\InvoicesController;

Route::group(['namespace' => '\Modules\Invoices\Http\Controllers', 'as' => 'backend.', 'middleware' => ['web', 'auth'], 'prefix' => 'admin'], function () {

    Route::get('invoices', ['as' => "invoices.view", 'uses' => 'InvoicesController@index']);
    Route::get('invoices/create', ['as' => "invoices.add", 'uses' => 'InvoicesController@create']);
    Route::get('invoices/{id}/fetch', ['as' => "invoices.fetch", 'uses' => 'InvoicesController@fetch']);
    Route::get('invoices/{current}/search', ['as' => "invoices.search", 'uses' => 'InvoicesController@search']);
});
