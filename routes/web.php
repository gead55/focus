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
Route::get('/', function () {
    return view('welcome');
});

Route::get('hello', 'Hello@index');
// Route::get('/hello',function(){
//     return 'Hello World!';
// });


Route::get('/home', 'HomeController@index')->name('home');

Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/callback', 'SocialAuthController@callback');

Route::get('/redirect/google', 'SocialAuthController@redirectToGoogle');
Route::get('/callback/google', 'SocialAuthController@callbackToGoogle');

Route::get('/redirect/github', 'SocialAuthController@redirectToProvider');
Route::get('/callback/github', 'SocialAuthController@handleProviderCallback');