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
Route::get('/admin/', 'AdminController@index')->middleware('admin.check');
Route::resource('posts', 'PostsController')->middleware('admin.check');
Route::post('/comments/create', 'PostsController@storeComment');
Route::resource('users', 'UsersController')->middleware('admin.check');
Route::resource('categories', 'CategoriesController')->middleware('admin.check');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/contact',function(){
   return view('contact');
});
Route::get('post/{slug}', 'PostsController@singlePost');
Route::post('search', 'PostsController@search');
Route::get('user/{user}', 'UsersController@singleUser');
Route::post('likePost', 'LikeController@store');