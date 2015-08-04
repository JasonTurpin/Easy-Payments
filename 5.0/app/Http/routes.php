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
Route::any('/Admin/addPermission', ['as' => 'admin.addpermission', 'uses' => 'AdminController@do_addPermission']);
Route::any('/Admin/createPermission', ['as' => 'admin.createpermission', 'uses' => 'AdminController@do_createPermission']);
Route::any('/Admin/updatePermission/{permission_id}', ['as' => 'admin.updatepermission', 'uses' => 'AdminController@do_updatePermission'])->where('permission_id', '\d+');
Route::any('/Admin/editPermission/{permission_id}', ['as' => 'admin.editpermission', 'uses' => 'AdminController@do_editPermission'])->where('permission_id', '\d+');
Route::any('/Admin/listPermissions', ['as' => 'admin.listpermissions', 'uses' => 'AdminController@do_listPermissions']);
Route::any('/Admin/listRoles', ['as' => 'admin.listroles', 'uses' => 'AdminController@do_listRoles']);
Route::any('/Admin/addRole', ['as' => 'admin.addrole', 'uses' => 'AdminController@do_addRole']);
Route::any('/Admin/createRole', ['as' => 'admin.createrole', 'uses' => 'AdminController@do_createRole']);
Route::any('/Admin/editRole/{role_id}', ['as' => 'admin.editrole', 'uses' => 'AdminController@do_editRole'])->where('role_id', '\d+');
Route::any('/Admin/updateRole/{role_id}', ['as' => 'admin.updaterole', 'uses' => 'AdminController@do_updateRole'])->where('role_id', '\d+');
Route::any('/Admin/listUsers', ['as' => 'admin.listusers', 'uses' => 'AdminController@do_listUsers']);
Route::any('/Admin/addUser', ['as' => 'admin.adduser', 'uses' => 'AdminController@do_addUser']);
Route::any('/Admin/createUser', ['as' => 'admin.createuser', 'uses' => 'AdminController@do_createUser']);
Route::any('/Admin/editUser/{user_id}', ['as' => 'admin.edituser', 'uses' => 'AdminController@do_editUser'])->where('user_id', '\d+');
Route::any('/Admin/updateUser/{user_id}', ['as' => 'admin.updateuser', 'uses' => 'AdminController@do_updateUser'])->where('user_id', '\d+');
