<?php
namespace App\Http\Controllers;
use Redirect, View, Request;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use \App\Http\Requests\UpdateRoleRequest;
use \App\Http\Requests\CreateUserRequest;
use \App\Http\Requests\UpdateUserRequest;
use \App\Http\Requests\UpdatePermissionRequest;
use \App\Role, \App\User, \App\Permission;

/**
 * Admin Controller - Base class for admin screens
 * File : /5.0/app/Http/Controllers/AdminController.php
 *
 * PHP version 5.5
 *
 * @package  Easy Payments
 * @author   Jason Turpin <jasonaturpin@gmail.com>
 */

/**
 * Handles Admin Level Screens
 *
 * @package  Easy Payments
 * @author   Jason Turpin <jasonaturpin@gmail.com>
 */
class AdminController extends PortalController {
    /**
     * Constructor Method
     */
    public function __construct() {
        // Run parent constructor
        parent::__construct();

        // Authenticates the user
        $this->middleware('auth');
    }

    /**
     * Admin Home
     *
     * @return View
     */
    public function do_home() {
        View::share('_pageName', 'Admin Home');
        View::share('_title', 'Admin Home');
        return $this->_renderTemplate('Admin.Home');
    }

    /**
     * List User Roles
     *
     * @return View
     */
    public function do_listRoles() {
        // Share View Variables
        View::share('Roles', Role::all());
        View::share('_pageName', 'List Roles');
        View::share('_title', 'List Roles');
        View::share('_pageAction', '/Admin/listRoles');

        // Include bootstrap's DataTable
        $this->_includeDataTable();

        // Add custom JS
        $this->scripts[] = '/js/Admin.ListRoles.js';

        // Render the template
        return $this->_renderTemplate('Admin.ListRoles');
    }

    /**
     * Edit an existing role
     *
     * @param int $role_id Role ID
     *
     * @return View
     */
    public function do_editRole($role_id) {
        // Fetch the role ID
        try {
            /** @var \App\Role $role */
            $this->role = Role::findOrFail($role_id);

        // IF an invalid user ID was passed, throw a 404
        } catch (ModelNotFoundException $ex) {
            $this->_addDashboardMessage('The role you were looking for does not exist.', 'error');
            return redirect()->route('admin.listroles')->with('dashboardMessages', $this->dashboardMessages);
        }

        // Share View Variables
        View::share('role', $this->role);
        View::share('_pageName', 'Edit '.$this->role->label);
        View::share('_title', 'Edit '.$this->role->label);
        View::share('_pageAction', '/Admin/updateRole/'.$this->role->role_id);

        // Render the template
        return $this->_renderTemplate('Admin.Role');
    }

    /**
     * Add a new role
     *
     * @return View
     */
    public function do_addRole() {
        /** Role $role */
        $role = new Role();

        // Populate data from old request
        $role->fill(Request::old());

        // Share View Variables
        View::share('role', $role);
        View::share('_pageName', 'Add Role');
        View::share('_title', 'Add Role');
        View::share('_pageAction', '/Admin/createRole');

        // Render the template
        return $this->_renderTemplate('Admin.Role');
    }

    /**
     * Creates a new role after passing validation
     *
     * @param int             $role_id
     * @param EditRoleRequest $request Handles role validation
     *
     * @return Redirect
     */
    public function do_updateRole($role_id, UpdateRoleRequest $request) {
        // Attempt to find the role
        try {
            /** @var \App\Role $role */
            $role = Role::findOrFail($role_id);

        // IF an invalid ID was passed, throw a 404
        } catch (ModelNotFoundException $ex) {
            $this->_addDashboardMessage('The role you were looking for does not exist.', 'error');
            return redirect()->route('admin.listroles')->with('dashboardMessages', $this->dashboardMessages);
        }

        // Populate with new values
        $role->fill($request->all());
        $role->save();

        // Add success message
        $this->_addDashboardMessage('Successfully updated '.$role->label.' role.', 'success');

        // Redirect the user to the edit page
        return redirect()->route('admin.editrole', ['role_id' => $role->role_id])
            ->with('dashboardMessages', $this->dashboardMessages);
    }

    /**
     * Creates a new role after passing UpdateRoleRequest validation
     *
     * @param EditRoleRequest $request Handles role validation
     *
     * @return Redirect
     */
    public function do_createRole(UpdateRoleRequest $request) {
        /** \App\Role $role */
        $role = Role::create($request->all());

        // Add success message
        $this->_addDashboardMessage('Successfully created '.$role->label.' role.', 'success');

        // Redirect the user to the edit page
        return redirect()->route('admin.editrole', ['role_id' => $role->role_id])
            ->with('dashboardMessages', $this->dashboardMessages);
    }

    /**
     * List Permission Levels
     *
     * @return View
     */
    public function do_listPermissions() {
        // Share View Variables
        View::share('Permissions', Permission::all());
        View::share('_pageName', 'List Permission Levels');
        View::share('_title', 'List Permission Levels');
        View::share('_pageAction', '/Admin/listPermissions');

        // Include bootstrap's DataTable
        $this->_includeDataTable();

        // Add custom JS
        $this->scripts[] = '/js/Admin.ListPermissions.js';

        // Render the template
        return $this->_renderTemplate('Admin.ListPermissions');
    }

    /**
     * Add a new permission
     *
     * @return View
     */
    public function do_addPermission() {
        /** Permission $permission */
        $permission = new Permission();

        // Populate data from old request
        $permission->fill(Request::old());

        // Share View Variables
        View::share('permission', $permission);
        View::share('permissionRoles', (array) Request::old('roles'));
        View::share('Roles', Role::active()->get());
        View::share('_pageName', 'Add A New Permission Level');
        View::share('_title', 'Add A New Permission Level');
        View::share('_pageAction', '/Admin/createPermission');

        // Render the template
        return $this->_renderTemplate('Admin.Permission');
    }

    /**
     * Edit a permission level
     *
     * @param int $permission_id The permission level being edited
     *
     * @return View
     */
    public function do_editPermission($permission_id) {
        // Attempt to find the permission
        try {
            /** Permission $permission */
            $permission = Permission::findOrFail($permission_id);

        // IF an invalid user ID was passed, throw a 404
        } catch (ModelNotFoundException $ex) {
            $this->_addDashboardMessage('The permission level you were looking for does not exist.', 'error');
            return redirect()->route('admin.listpermissions')->with('dashboardMessages', $this->dashboardMessages);
        }

        // Fetchs old form data
        $oldData = Request::old();

        // IF old form data exists
        if (is_array($oldData) && !empty($oldData)) {
            // Set user roles (is case as array for case of null)
            $permissionRoles = (array) Request::old('roles');

            // Fill model with old form data
            $permission->fill($oldData);

        // Old form data does not exist.  Fetch user roles
        } else {
            $permissionRoles = $permission->roles->modelKeys();
        }

        // Share View Variables
        View::share('permission', $permission);
        View::share('permissionRoles', $permissionRoles);
        View::share('Roles', Role::active()->get());
        View::share('_pageName', 'Edit '.$permission->label);
        View::share('_title', 'Edit '.$permission->label);
        View::share('_pageAction', '/Admin/updatePermission/'.$permission->permission_id);

        // Render the template
        return $this->_renderTemplate('Admin.Permission');
    }

    /**
     * Creates a new user role permission group after UpdatePermissionRequest validation
     *
     * @param UpdatePermissionRequest $request Handles user validation
     *
     * @return Redirect
     */
    public function do_createPermission(UpdatePermissionRequest $request) {
        /** Permission $permission */
        $permission = new Permission();

        // Set values
        $permission->fill($request->all());

        // Save permission
        $permission->save();

        // IF permission was assigned roles, sync the joiner table
        $permissionRoleData = $request->get('roles');
        if (!empty($permissionRoleData)) {
            $permission->syncRoles($permissionRoleData);
        }

        // Add success message
        $this->_addDashboardMessage('Successfully created a new permission level.', 'success');

        // Redirect the user to the edit page
        return redirect()->route('admin.editpermission', ['permission_id' => $permission->permission_id])
            ->with('dashboardMessages', $this->dashboardMessages);
    }

    /**
     * Updates a user after passing UpdateUserRequest validation
     *
     * @param int                     $permission_id Permission ID
     * @param UpdatePermissionRequest $request       Handles permission validation
     *
     * @return Redirect
     */
    public function do_updatePermission($permission_id, UpdatePermissionRequest $request) {
        // Attempt to find the permission
        try {
            /** Permission $permission */
            $permission = Permission::findOrFail($permission_id);

        // IF an invalid permission ID was passed, throw a 404
        } catch (ModelNotFoundException $ex) {
            $this->_addDashboardMessage('The permission level you were looking for does not exist.', 'error');
            return redirect()->route('admin.listpermissions')->with('dashboardMessages', $this->dashboardMessages);
        }

        // Set values
        $permission->fill($request->all());

        // Save permission
        $permission->save();

        // Sync the permission role data
        $permissionRoleData = (array) $request->get('roles');
        $permission->syncRoles($permissionRoleData);

        // Add success message
        $this->_addDashboardMessage('Successfully updated the "'.$permission->label.'" permission level.', 'success');

        // Redirect the user to the edit page
        return redirect()->route('admin.editpermission', ['permission_id' => $permission->permission_id])
            ->with('dashboardMessages', $this->dashboardMessages);
    }
    
    /**
     * Creates a new user after passing CreateUserRequest validation
     *
     * @param CreateUserRequest $request Handles user validation
     *
     * @return Redirect
     */
    public function do_createUser(CreateUserRequest $request) {
        /** User $user */
        $user = new User();

        // Set values
        $user->fill($request->all());
        $user->email = $request->get('email');

        // Set the password hash
        $user->setPassword($request->get('password'));

        // Save user
        $user->save();

        // IF user was assigned roles, sync the joiner table
        $userRoleData = $request->get('roles');
        if (!empty($userRoleData)) {
            $user->syncRoles($userRoleData);
        }

        // Add success message
        $this->_addDashboardMessage('Successfully created a new user account.', 'success');

        // Redirect the user to the edit page
        return redirect()->route('admin.edituser', ['user_id' => $user->user_id])
            ->with('dashboardMessages', $this->dashboardMessages);
    }

    /**
     * Add a new user account
     *
     * @return View
     */
    public function do_addUser() {
        /** User $user */
        $user = new User();

        // Populate data from old request
        $user->fill(Request::old());

        // Share View Variables
        View::share('user', $user);
        View::share('userRoles', (array) Request::old('roles'));
        View::share('Roles', Role::active()->get());
        View::share('_pageName', 'Add User');
        View::share('_title', 'Add User');
        View::share('_pageAction', '/Admin/createUser');

        // Render the template
        return $this->_renderTemplate('Admin.User');
    }

    /**
     * Edit an existing user account
     *
     * @param int $user_id The user being edited ID
     *
     * @return View
     */
    public function do_editUser($user_id) {
        // Attempt to find the user
        try {
            $user = User::findOrFail($user_id);

        // IF an invalid user ID was passed, throw a 404
        } catch (ModelNotFoundException $ex) {
            $this->_addDashboardMessage('The user you were looking for does not exist.', 'error');
            return redirect()->route('admin.listusers')->with('dashboardMessages', $this->dashboardMessages);
        }

        // Fetchs old form data
        $oldData = Request::old();

        // IF old form data exists
        if (is_array($oldData) && !empty($oldData)) {
            // Set user roles (is case as array for case of null)
            $userRoles = (array) Request::old('roles');

            // Fill model with old form data
            $user->fill($oldData);
        
        // Old form data does not exist.  Fetch user roles
        } else {
            $userRoles = $user->roles->modelKeys();
        }

        // Share View Variables
        View::share('user', $user);
        View::share('userRoles', $userRoles);
        View::share('Roles', Role::active()->get());
        View::share('_pageName', 'Edit '.$user->firstName.' '.$user->lastName);
        View::share('_title', 'Edit '.$user->firstName.' '.$user->lastName);
        View::share('_pageAction', '/Admin/updateUser/'.$user->user_id);

        // Render the template
        return $this->_renderTemplate('Admin.User');
    }

    /**
     * Updates a user after passing UpdateUserRequest validation
     *
     * @param int               $user_id User's ID
     * @param UpdateUserRequest $request Handles user validation
     *
     * @return Redirect
     */
    public function do_updateUser($user_id, UpdateUserRequest $request) {
        // Attempt to find the user
        try {
            /** User $user */
            $user = User::findOrFail($user_id);

        // IF an invalid user ID was passed, throw a 404
        } catch (ModelNotFoundException $ex) {
            $this->_addDashboardMessage('The user you were looking for does not exist.', 'error');
            return redirect()->route('admin.listusers')->with('dashboardMessages', $this->dashboardMessages);
        }

        // Set values
        $user->fill($request->all());

        // IF the password was updated, reset the hash
        $password = $request->get('password');
        if (!empty($password)) {
            $user->setPassword($password);
        }

        // Save user
        $user->save();

        // Sync the user role data
        $userRoleData = (array) $request->get('roles');
        $user->roles()->sync($userRoleData);

        // Add success message
        $this->_addDashboardMessage('Successfully updated '.$user->firstName.' '.$user->lastName.'.', 'success');

        // Redirect the user to the edit page
        return redirect()->route('admin.edituser', ['user_id' => $user->user_id])
            ->with('dashboardMessages', $this->dashboardMessages);
    }

    /**
     * List User Accounts
     *
     * @return View
     */
    public function do_listUsers() {
        // Share View Variables
        View::share('Users', User::all());
        View::share('_pageName', 'List Users');
        View::share('_title', 'List Users');
        View::share('_pageAction', '/Admin/listUsers');

        // Include bootstrap's DataTable
        $this->_includeDataTable();

        // Add custom JS
        $this->scripts[] = '/js/Admin.ListUsers.js';

        // Render the template
        return $this->_renderTemplate('Admin.ListUsers');
    }
}
