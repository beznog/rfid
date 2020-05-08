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

// Show all systems
Route::get('list/systems', 'ItemController@listSystems');

// Show all items
Route::get('list', 'ItemController@list');

// Add new item (system, component or element)
Route::get('add', 'ItemController@index');
Route::post('add',
    [
        'before' => 'csrf',
        'uses' => 'ItemController@store'
    ]
);

// Autofill form to edit item
Route::get('edit/{itemId}', 'ItemController@autocompleteEditForm');

// Edit item
Route::post('edit/{itemId}', 'ItemController@edit');

// Delete item
Route::get('delete/{itemId}', 'ItemController@delete');

// Delete image from item
Route::get('delete/image/{itemId}', 'ItemController@deleteImage');

// Scan items
Route::get('scan/{itemId}', 'ItemController@scan');
