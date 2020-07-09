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

Route::redirect('/', '/login');

Auth::routes();

Route::get('/welcome', 'HomeController@welcome')->name('welcome');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/favourites', 'HomeController@setFavourite')->name('favourite');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
Route::get('/exchangerate', 'HomeController@getExchangerate')->name('exchangerate');
Route::get('/profile', 'HomeController@profile')->name('profile');
Route::post('/profile/update', 'HomeController@updateProfile')->name('update_profile');
Route::get('/view-proof', 'HomeController@showProof')->name('proof');
