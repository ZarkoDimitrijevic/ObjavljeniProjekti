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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');//->name('home') to znaci jednostavniji url moze da radi

Route::get('/user/{id}', 'ProfileController@viewProfile');//ovde kazemo da funkciji viewProfile treba proslediti {id}

Route::post('/home', 'HomeController@publish');//moguce je da bude isto ime jer pazi da li smo dosli get ili post metodom

Route::get('/event/{id}', 'EventController@viewEvent');//ovde kazemo da funkciji viewEvent treba proslediti {id}
