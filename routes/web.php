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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/', 'AdminController@index')->middleware('admin.check');
Route::resource('posts', 'PostsController')->middleware('admin.check');

// links q tme q ser ajax
Route::post('/comments/create', 'PostsController@storeComment')->name('sendComment');
Route::post('likePost', 'LikeController@store');
Route::post('likeComment', 'LikeController@storeLikeComment');


Route::resource('users', 'UsersController')->middleware('admin.check');
Route::resource('categories', 'CategoriesController')->middleware('admin.check');
Route::get('categories/{category}', 'CategoriesController@singleCategory');
Route::get('post/{slug}', 'PostsController@singlePost');
Route::post('search', 'PostsController@search');
Route::get('user/{user}', 'UsersController@singleUser');

// login c google
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');