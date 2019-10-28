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

Route::get('/home', 'HomeController@index')->name('home');



Route::resource('issues', 'IssueController')->names('issue')->middleware('auth.required');
Route::put('takeInWork/{id}', 'IssueController@takeInWork')->name('issue.takeInWork')->where(['id' => '[0-9]+'])->middleware('auth.required');

