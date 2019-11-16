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

// Route::get('/', function(){
//     return redirect()->route('login');
// });

// routes for login, logout, register, reset password and forget password
Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// routes for admin:
Route::get('/admin', 'AdminsController@index')->name('admin.index');
Route::post('/import/user', 'AdminsController@import')->name('import.user');
Route::post('/admin/user', 'AdminsController@store')->name('store.user');
Route::patch('/admin/user/user', 'AdminsController@update')->name('update.user');
Route::delete('/admin/user/user', 'AdminsController@destroy')->name('delete.user');
Route::delete('/admin/users/users', 'AdminsController@destroys')->name('deletes.user');
// routes for organizer:
Route::get('/organizer', 'OrganizersController@index')->name('organizer.index');

// routes for user:
Route::get('/home', 'UsersController@index')->name('user.index');