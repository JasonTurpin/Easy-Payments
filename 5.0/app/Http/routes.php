<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Sign in / sign out
Route::any('/signIn', ['as' => 'portal.signin', 'uses' => 'PortalController@do_signIn']);
Route::any('/signOut', ['as' => 'portal.signout', 'uses' => 'PortalController@do_signOut']);

// Portal level screens
Route::get('/Portal', ['as' => 'portal.home', 'uses' => 'PortalController@do_home']);

// Admin level screens
Route::any('/Admin', ['as' => 'admin.home', 'uses' => 'AdminController@do_home']);
