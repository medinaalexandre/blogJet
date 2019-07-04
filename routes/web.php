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

// Users routes
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('user/{user}', 'UsersController@singleUser');
Route::get('post/{slug}', 'PostsController@singlePost');
Route::post('search', 'PostsController@search');
Route::get('user/{user}/likes', 'UsersController@myLikes')->name('mylikes');

// Admin routes
Route::get('/admin/', 'AdminController@index')->middleware('admin.check');
Route::resource('posts', 'PostsController')->middleware('admin.check');
Route::resource('users', 'UsersController')->middleware('admin.check');
Route::resource('categories', 'CategoriesController')->middleware('admin.check');
Route::post('/comments/create', 'PostsController@storeComment')->name('sendComment');

//Categories menu
Route::get('categories/{category}', 'CategoriesController@singleCategory');

// Like routes
Route::post('likePost', 'LikeController@store');
Route::post('likeComment', 'LikeController@storeLikeComment');

// google login
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');