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


// Main page
Route::get('', 'ItemsController@index');

// Show all items
Route::get('list', 'ItemsController@list');

// Add new item (system, component or element)
Route::post('add_item',
    [
        'before' => 'csrf',
        'uses' => 'ItemsController@store'
    ]
);

// Edit item
Route::post('edit/{itemId}', 'ItemsController@edit');

// Delete item
Route::get('delete/{itemId}', 'ItemsController@delete');

// Scan items
Route::get('scan/{itemId}', 'ItemsController@scan');
