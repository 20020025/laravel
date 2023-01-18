<?php

use Illuminate\Support\Facades\Route;

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

Route::resource('buku', BukuController::class);

Route::get('/register', 'RegisterController@index')->name('register.index');
Route::post('/register', 'RegisterController@store')->name('register.store');

Route::get('/login', 'LoginController@index')->name('login');
Route::post('/login', 'LoginController@check_login')->name('login.check_login');

Route::get('/profile', 'ProfileController@index')->name('profile.index');
Route::patch('/profile/{id}', 'ProfileController@update')->name('profile.update');

Route::get('/buku', 'BukuController@index')->name('buku.index');
Route::get('/logout', 'BukuController@logout')->name('buku.logout');
