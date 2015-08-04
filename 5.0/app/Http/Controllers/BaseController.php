<?php
namespace App\Http\Controllers;
use Auth, Session, View, Route;
use \App\User;

/**
 * Base Controller
 * File : /5.0/app/Http/Controllers/BaseController.php
 *
 * PHP version 5.3
 *
 * @package  Easy Payments
 * @author   Jason Turpin <jasonaturpin@gmail.com>
 */

/**
 * Base level controller
 *
 * @package  Easy Payments
 * @author   Jason Turpin <jasonaturpin@gmail.com>
 */
class BaseController extends Controller {
    /**
     * @var array - array of stylesheets to be loaded on the page
     */
    protected $stylesheets       = array();

    /**
     * @var array - array of JS files to be loaded
     */
    protected $scripts           = array();

    /**
     * @var array - Array of user messages
     */
    protected $dashboardMessages = array();

    /**
     * @var \App\User - Current user object
     */
    protected $user              = null;

    /**
     * @var bool - if a login is required for the page
     */
    protected $loginRequired     = true;

    /**
     * @var string - Admin theme assets path
     */
    protected $adminThemeLoc     = '';
    
    /**
     * Constructor Method
     */
    public function __construct() {
        // Admin theme location
        $this->adminThemeLoc = config('app.adminThemeLoc');

        // Fetch Current User
        $this->user = Auth::user();

        // IF the user is not logged in, build a new one
        if (empty($this->user)) {
            $this->user = new User;
        }

        // Initialize controller/action data
        $action = $controller = '';

        // Route name
        $controllerAction = strtolower(Route::currentRouteName());

        // Explode the action
        $pieces = explode('.', $controllerAction);

        // Set controller
        if (isset($pieces[0])) {
            $controller = $pieces[0];
        }

        // Set action
        if (isset($pieces[1])) {
            $action = $pieces[1];
        }

        // IF dashboard messages exist, display them
        if (Session::has('dashboardMessages')) {

            // Loop over each dashboard message
            foreach (Session::get('dashboardMessages') as $msg) {
                // IF message type was passed
                if (isset($msg['type'])) {
                    $this->_addDashboardMessage($msg['msg'], $msg['type']);
                } else {
                    $this->_addDashboardMessage($msg['msg']);
                }
            }
        }

        // Add CSS
        $this->stylesheets[] = '/css/style.css';

        // Add JS
        $this->scripts[]     = $this->adminThemeLoc.'/js/jquery.js';
        $this->scripts[]     = $this->adminThemeLoc.'/js/bootstrap.min.js';
        $this->scripts[]     = '/js/app.js';

        // Set view data
        View::share('stylesheets', $this->stylesheets);
        View::share('scripts', $this->scripts);
        View::share('_keywords', config('app.keywords'));
        View::share('_description', config('app.description'));
        View::share('_siteURL', config('app.siteURL'));
        View::share('_title', config('app.titleTag'));
        View::share('_siteName', config('app.siteName'));
        View::share('_user', $this->user);
        View::share('_action', $action);
        View::share('_controller', $controller);
        View::share('_controllerAction', $controllerAction);
    }

    /**
     * Renders a template
     *
     * @param string $template Template name
     *
     * @return Response
     */
    protected function _renderTemplate($template) {
        // Process dashboard logic
        $this->_processDashboardLogic();
        
        // Share View Variables
        View::share('scripts', $this->scripts);
        View::share('stylesheets', $this->stylesheets);
        View::share('_user', $this->user);

        return View::make($template);
    }
    
    /**
     * Separates the dashboard messages array by category
     * 
     * @return void
     */
    protected function _processDashboardLogic() {
        // Process the dashboard messages
        $errorMsgs   = array();
        $successMsgs = array();
        $neutralMsgs = array();
        $errorFields = array();
        
        // Loop over dashboard messages
        foreach ($this->dashboardMessages as $msg) {
            // IF a required value is missing, skip
            if (!isset($msg['type']) || !isset($msg['msg'])) {
                continue;
            }

            // Process message type
            switch ($msg['type']) {
                case 'error':
                    $errorMsgs[] = $msg['msg'];
                    break;
                case 'success':
                    $successMsgs[] = $msg['msg'];
                    break;
                default:
                    $neutralMsgs[] = $msg['msg'];
                    break;
            }
        }

        /** \Illuminate\Support\ViewErrorBag $Bags */
        $Bags = Session::get('errors');

        // IF Validation Errors exist
        if (is_a($Bags, '\Illuminate\Support\ViewErrorBag') && $Bags->count() > 0) {
            // Fetch the default error bag
            foreach ($Bags->getBags() as $bag) {
                // Add keys to error fields
                $errorFields = array_merge($errorFields, $bag->keys());

                // Add the validation errors to the error messages array
                $errorMsgs = array_merge($errorMsgs, $bag->all());
            }

            // Remove duplicate values from the error fields array (if there are any)
            $errorFields = array_unique($errorFields);
        }
        
        // Share data with view
        View::share('errorFields', $errorFields);
        View::share('_errorMsgs', $errorMsgs);
        View::share('_successMsgs', $successMsgs);
        View::share('_neutralMsgs', $neutralMsgs);
    }

    /**
     * Include the CSS and JS necessary for a datatable
     *
     * @return void
     */
    protected function _includeDataTable() {
        // Add JS and CSS needed for data table
        $this->scripts[]     = $this->adminThemeLoc.'/assets/advanced-datatable/media/js/jquery.dataTables.js';
        $this->scripts[]     = $this->adminThemeLoc.'/assets/data-tables/DT_bootstrap.js';
        $this->stylesheets[] = $this->adminThemeLoc.'/assets/data-tables/DT_bootstrap.css';
    }

    /**
     * Adds message to dashboard queue
     *
     * @param string $msg  Message to be displayed
     * @param string $type Message type (success, error, or neutral)
     *
     * @return void
     */
    protected function _addDashboardMessage($msg, $type = 'neutral') {
        $this->dashboardMessages[] = array(
            'msg'  => $msg,
            'type' => $type
        );
    }

    /**
     * Add JS/CSS for file upload
     *
     * @return void
     */
    protected function _includeFileUpload() {
        $this->stylesheets[] = $this->adminThemeLoc.'/assets/bootstrap-fileupload/bootstrap-fileupload.css';
        $this->scripts[]     = $this->adminThemeLoc.'/assets/bootstrap-fileupload/bootstrap-fileupload.js';
    }

    /**
     * Use searchable multi-select box JS/CSS
     *
     * @return void
     */
    protected function _includeSearchableMultiSelect() {
        $this->stylesheets[] = $this->adminThemeLoc.'/assets/bootstrap-fileupload/bootstrap-fileupload.css';
        $this->scripts[]     = $this->adminThemeLoc.'/jquery-multi-select/js/jquery.multi-select.js';
        $this->scripts[]     = $this->adminThemeLoc.'/jquery-multi-select/js/jquery.quicksearch.js';
    }

    /**
     * Use jQuery UI code
     *
     * @return void
     */
    protected function _includeJQueryUI() {
        $this->scripts[]     = $this->adminThemeLoc.'/assets/jquery-ui/jquery-ui-1.10.1.custom.min.js';
        $this->stylesheets[] = '//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css';
    }

    /**
     * Use JS Stepy Code
     *
     * @return void
     */
    protected function _includeStepy() {
        // Add stepy JS code
        $this->scripts[] = $this->adminThemeLoc.'/js/jquery.stepy.js';
    }

    /**
     * Use Colorpicker Code
     *
     * @return void
     */
    protected function _includeColorPicker() {
        $this->scripts[]     = '/packages/colorMaster/tinycolor-0.9.15.min.js';
        $this->scripts[]     = '/packages/colorMaster/pick-a-color-1.2.3.min.js';
        $this->stylesheets[] = '/packages/colorMaster/pick-a-color-1.2.3.min.css';
    }

    /**
     * Add calendar data
     *
     * @return void
     */
    protected function _includeCalendar() {
        $this->stylesheets[] = $this->adminThemeLoc.'/assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css';
        $this->stylesheets[] = $this->adminThemeLoc.'/assets/bootstrap-timepicker/compiled/timepicker.css';
        $this->scripts[]     = $this->adminThemeLoc.'/js/jquery-ui-1.9.2.custom.min.js';
        $this->scripts[]     = $this->adminThemeLoc.'/assets/fullcalendar/fullcalendar/fullcalendar.min.js';
        $this->scripts[]     = $this->adminThemeLoc.'/assets/bootstrap-timepicker/js/bootstrap-timepicker.js';
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout() {
        if ( ! is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }
}
