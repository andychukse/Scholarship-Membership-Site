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

Route::get('/error', function () {
    return view('error');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/admin', 'HomeController@index')->name('home');
Route::resource('post', 'PostController');
Route::get('/lists', 'PostController@posts')->name('list-all');
Route::get('/lists/{type}', 'PostController@list')->name('list-type');
Route::get('/list/{slug}', 'PostController@view')->name('view-scholar');
Route::get('/search', 'PostController@search')->name('search');

Route::get('/subscribe/{name}', 'SubscriptionController@subscribe')->name('subscribe');
Route::get('/subscriptions', 'SubscriptionController@index')->name('subscriptions');
Route::get('/my-subscription', 'SubscriptionController@mySubscriptions')->name('my-subscription');
Route::get('/subscription/{subscription}/edit', 'SubscriptionController@edit')->name('subedit');
Route::post('/subscription/{subscription}/', 'SubscriptionController@update')->name('subupdate');

Route::post('/pay', 'SubscriptionController@redirectToGateway')->name('pay');
Route::post('/bank', 'SubscriptionController@bank')->name('bank');
Route::get('/payment/callback', 'SubscriptionController@handleGatewayCallback');
Route::get('/payment/bank/{id}', 'SubscriptionController@bankpay')->name('bankpay');
Route::get('/renew/callback', 'PaymentController@handleGatewayCallback');


Route::get('/users', 'HomeController@users')->name('users');
Route::get('/user/{id}/edit', 'HomeController@edit')->name('user.edit');
Route::post('/user/role/{user}', 'HomeController@updateRole')->name('user.role');
Route::get('/profile', 'HomeController@profile')->name('profile');
Route::post('/profile/{user}', 'HomeController@update')->name('profile.update');

