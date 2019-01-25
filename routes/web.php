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

Route::middleware(['changePassword'])->group(function() {
    Route::get('/home', 'HomeController@index');
    Route::get('/', 'HomeController@index')->name('home');
});

Route::middleware(['auth'])->group(function() {
    Route::middleware(['changePassword'])->group(function() {
        Route::middleware(['auth.admin'])->group(function () {
            Route::group(['prefix' => 'admin'], function () {
                Route::get('addUser', 'AdminController@addUser')->name('addUser');
                Route::get('deleteUser/{id}', 'AdminController@deleteUser')->name('deleteUser');
                Route::get('saveEditUser/{id}', 'AdminController@saveEditUser')->name('saveEditUser');
                Route::get('sendMail/{id}', 'AdminController@sendMailPairs')->name('sendMail');
                Route::get('shuffle', 'AdminController@shuffle')->name('shuffle');
                Route::get('resetShuffle', 'AdminController@resetShuffle')->name('resetShuffle');
                Route::get('sendMailPairs', 'AdminController@sendMailPairs')->name('sendMailPairs');

                Route::middleware(['auth.superadmin'])->group(function () {
                    Route::get('doAdmin/{id}', 'AdminController@doAdmin')->name('doAdmin');
                    Route::get('deleteAdmin/{id}', 'AdminController@deleteAdmin')->name('deleteAdmin');
                    Route::get('supershuffle', 'AdminController@superShuffle')->name('superShuffle');
                });
            });
        });
        Route::get('users', 'UserController@users')->name('users');
        Route::get('getPair', 'UserController@getPair')->name('getPair');
        Route::post('suggest', 'UserController@postSuggestion')->name('postSuggestion');
        Route::get('{suggest}/change', 'UserController@changeSuggestion')->name('changeOneSuggest');
    });
    Route::get('changePassword', 'UserController@changePasswordShow')->name('passwordChange');
    Route::post('changePassword', 'UserController@changePasswordPost')->name('changePassword.post');
});

