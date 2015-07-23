<?php
namespace App\Http\Controllers;
use Auth, View, Request;

/**
 * Portal Controller - Base class for all admin screens
 * File : /5.0/app/Http/Controllers/PortalController.php
 *
 * PHP version 5.3
 *
 * @package  Easy Payments
 * @author   Jason Turpin <jasonaturpin@gmail.com>
 */

/**
 * Handles Portal Level Screens
 *
 * @package  Easy Payments
 * @author   Jason Turpin <jasonaturpin@gmail.com>
 */
class PortalController extends BaseController {
    /**
     * Constructor Method
     */
    public function __construct() {
        // Run parent constructor
        parent::__construct();

        // Authenticates the user
        $this->middleware('guest', ['only' => 'do_signIn']);

        // Add stylesheets to load
        $this->stylesheets[] = $this->adminThemeLoc.'/css/bootstrap.min.css';
        $this->stylesheets[] = $this->adminThemeLoc.'/css/bootstrap-reset.css';
        $this->stylesheets[] = $this->adminThemeLoc.'/assets/font-awesome/css/font-awesome.css';
        $this->stylesheets[] = $this->adminThemeLoc.'/assets/gritter/css/jquery.gritter.css';
        $this->stylesheets[] = $this->adminThemeLoc.'/css/slidebars.css';
        $this->stylesheets[] = $this->adminThemeLoc.'/css/style.css';
        $this->stylesheets[] = $this->adminThemeLoc.'/css/style-responsive.css';

        // Add JS to load
        $this->scripts[]     = $this->adminThemeLoc.'/js/jquery.dcjqaccordion.2.7.js';
        $this->scripts[]     = $this->adminThemeLoc.'/js/jquery.scrollTo.min.js';
        $this->scripts[]     = $this->adminThemeLoc.'/js/jquery.nicescroll.js';
        $this->scripts[]     = $this->adminThemeLoc.'/js/respond.min.js';
        $this->scripts[]     = $this->adminThemeLoc.'/js/jquery.pulsate.min.js';
        $this->scripts[]     = $this->adminThemeLoc.'/js/slidebars.min.js';
        $this->scripts[]     = $this->adminThemeLoc.'/js/common-scripts.js';
        $this->scripts[]     = $this->adminThemeLoc.'/js/pulstate.js';
    }

    /**
     * Admin Home Screen
     *
     * @return View
     */
    public function do_home() {
        // Share View Variables
        View::share('_title', 'Portal Home');

        return $this->_renderTemplate('Portal.Home');
    }

    /**
     * User to sign a user in
     *
     * @return Response
     */
    public function do_signIn() {
        // Initialize email
        $email = '';

        /**
         * Uses these values instead of the raw strings.  Helps prevent some automated bots from trying to sign in.
         * username => HJ)as9M*#
         * password => lN9S*&n#
         */
        // IF the user submitted the login form
        if (Request::isMethod('post') && Request::has('HJ)as9M*#')) {
            // Set the user's credentials
            $credentials = array(
                'email'    => Request::get('HJ)as9M*#'),
                'password' => Request::get('lN9S*&n#'),
            );

            // IF the user successfully signed in
            if (Auth::attempt($credentials)) {
                return redirect()->route('portal.home')->with('dashboardMessages', $this->dashboardMessages);
            }

            // The sign in credentials were incorrect, alert the user
            $this->_addDashboardMessage('Invalid username / password combination.', 'error');
        }

        // Set view data
        View::share('email', $email);
        View::share('_title', 'Sign In');
        View::share('_pageAction', '/signIn');

        // Render the template
        return $this->_renderTemplate('Portal.SignIn');
    }

    /**
     * Signs the current user out of their account
     *
     * @return Response
     */
    public function do_signOut() {
        // Signs the user out
        Auth::logout();

        // Provide feedback
        $this->_addDashboardMessage('You have successfully signed out.', 'success');

        // Redirect the user to the sign in page
        return redirect()->route('portal.signin')->with('dashboardMessages', $this->dashboardMessages);
    }
}
