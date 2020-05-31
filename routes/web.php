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

Auth::routes();

//resources
Route::resource('user', 'UserController');
Route::resource('poll','PollController');
Route::resource('category','CategoryController');
Route::resource('log','LogsController');
Route::resource('vote','VoteController');

//get
Route::get('/voting/{id}', 'VoteController@vote')->name('vote.voting');
Route::get('/createUsers', 'UserController@viewCreateUsers')->name('user.viewCreateUsers');
Route::get('/', 'HomeController@index')->name('home');
Route::patch('/togglePoll', 'PollController@togglePoll')->name('TogglePoll');

//post
Route::post('/createUsers', 'UserController@createUsers')->name('createUsers');


