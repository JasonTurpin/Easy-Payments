<?php
namespace App\Http\Controllers;
use View;

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
}
