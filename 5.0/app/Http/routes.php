<?php
/**
 * Application routing
 * File : /5.0/app/Http/routes.php
 *
 * PHP version 5.5
 *
 * @package  Easy Payments
 * @author   Jason Turpin <jasonaturpin@gmail.com>
 */

// Sign in / sign out
Route::any('/signIn', ['as' => 'portal.signin', 'uses' => 'PortalController@do_signIn']);
Route::any('/signOut', ['as' => 'portal.signout', 'uses' => 'PortalController@do_signOut']);

// Portal level screens
Route::get('/Portal', ['as' => 'portal.home', 'uses' => 'PortalController@do_home']);

// Admin level screens
Route::any('/Admin', ['as' => 'admin.home', 'uses' => 'AdminController@do_home']);
Route::any('/Admin/listRoles', ['as' => 'admin.listroles', 'uses' => 'AdminController@do_listRoles']);
Route::any('/Admin/addRole', ['as' => 'admin.addrole', 'uses' => 'AdminController@do_addRole']);
Route::any('/Admin/createRole', ['as' => 'admin.createrole', 'uses' => 'AdminController@do_createRole']);
Route::any('/Admin/editRole/{role_id}', ['as' => 'admin.editrole', 'uses' => 'AdminController@do_editRole'])->where('role_id', '\d+');
Route::any('/Admin/updateRole/{role_id}', ['as' => 'admin.updaterole', 'uses' => 'AdminController@do_updateRole'])->where('role_id', '\d+');
