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

// Route::get('/', function () {
// 		return view('home');
// 	});

// Route::get('/create-post', 'BlogPostController@create');
// Route::get('post/{id}', 'BlogPostController@show');
// Route::get('posts', 'BlogPostController@index');
// Route::post('/posts', 'BlogPostController@store');


Route::get('/', 'HomeController@home')->name('home');
Route::get('/contact', 'HomeController@contact')->name('contact');
Route::get('/secret', 'HomeController@secret')
    ->name('secret')
    ->middleware('can:contact.secret');
Route::resource('posts', 'BlogPostController');

Auth::routes();
