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
Route::get('', 'ItemController@index');

// Show all items
Route::get('list', 'ItemController@list');

// Add new item (system, component or element)
Route::post('add_item',
    [
        'before' => 'csrf',
        'uses' => 'ItemController@store'
    ]
);

// Edit item
Route::post('edit/{itemId}', 'ItemController@edit');

// Delete item
Route::get('delete/{itemId}', 'ItemController@delete');

// Scan items
Route::get('scan/{itemId}', 'ItemController@scan');
