<?php
namespace App\Http\Controllers;
use Redirect, View;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use \App\Http\Requests\UpdateRoleRequest;
use \App\Role;

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
}
