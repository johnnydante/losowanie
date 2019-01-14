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

Route::get('/home', 'HomeController@index');
Route::get('/', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function() {
    Route::middleware(['auth.admin'])->group(function() {
        Route::group(['prefix'=>'admin'],function() {
            Route::get('addUser', 'AdminController@addUser')->name('addUser');
            Route::get('deleteUser/{id}', 'AdminController@deleteUser')->name('deleteUser');
            Route::get('saveEditUser/{id}', 'AdminController@saveEditUser')->name('saveEditUser');
            Route::get('shuffle', 'AdminController@shuffle')->name('shuffle');
            Route::get('delete', 'AdminController@delete')->name('delete');
            Route::get('sendMailPairs', 'AdminController@sendMailPairs')->name('sendMailPairs');
        });
    });
    Route::get('users', 'UserController@users')->name('users');
    Route::get('getPair', 'UserController@getPair')->name('getPair');
    Route::post('suggest', 'UserController@postSuggestion')->name('postSuggestion');
    Route::get('{suggest}/change', 'UserController@changeSuggestion')->name('changeOneSuggest');
    Route::get('changePassword', 'UserController@changePasswordShow')->name('passwordChange');
    Route::post('changePassword', 'UserController@changePasswordPost')->name('changePassword.post');
});

