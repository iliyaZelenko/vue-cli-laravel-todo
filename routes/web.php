<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProv'id'er within a group which
| contains the "web" m'id'dleware group. Now create something great!
|
*/

Route::get('/{any}', 'SpaController@index')->where('any', '.*');
