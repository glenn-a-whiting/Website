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

Route::get('/', function () {
    return view('welcome');
});

Route::get("/home","PageController@index");
Route::get("/home/{lang}","PageController@page");
Route::get("/home/{lang}/{page}","PageController@specific");
Route::get("/home/{lang}/{page}/{directory}","PageController@subdirectory");
