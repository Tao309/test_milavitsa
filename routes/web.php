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



Route::resource('issues', 'IssueController')->names('issue');

//Route::get('issues', 'IssueController@list')->name('issue.list');
//Route::get('addIssue', 'IssueController@add')->name('issue.add');
//
//Route::post('addIssue', 'IssueController@add')->name('issue.add');
