<?php
/**
 * Class pu_visitor_logboard_base
 *
 *  __construct     initialize plugin (load init)
 * init()           all basic hooks
 * functions:
 * - check_for_updates()
 * - pu_visitor_logboard_textdomain()
 */

namespace Pvl\Includes;

class Backend
{
    public $version = PVLVERSION;

	public function __construct()
	{

		if (is_admin()) {
			$this->startActivation();           // (de)activation hooks
			$this->filter = new Filter();       // hook to actions and filters
			$this->filter->add_action( 'init', $this, 'init' );
			$this->filter->add_action( 'plugins_loaded', $this, 'load_textdomain' );
			$this->check_for_updates();
			$this->filter->run();

		}
	}


	public function startActivation() {
		register_activation_hook(PVLFILE, array('Pvl\Includes\DeActivate', 'activate'));
		register_deactivation_hook(PVLFILE, array('Pvl\Includes\DeActivate', 'deactivate'));
	}


    public function init()
    {

        // localize language files
        add_action( 'plugins_loaded', [$this, 'load_textdomain']);
        // load admin settings page
        add_action( 'admin_menu', [$this, 'load_admin_page'] );

    }

	public function load_textdomain() {

		load_plugin_textdomain('pu-visitor-log', false, PVLNAME . '/languages/');
	}

    /************************************
     *  if plugin page check for updates
     ************************************/


    public function check_for_updates()
    {
        // only load file if it has not been loaded
        if (is_admin()) {
            if( !class_exists( '\PucFactory' ) ) {
                require PVLADIR . 'vendor/plugin-update-checker/plugin-update-checker.php';
            }
            $pu_visitor_log_UpdateChecker = \PucFactory::buildUpdateChecker(
                'http://plugins.puddinq.com/updates/?action=get_metadata&slug=pu-visitor-log',
                PVLFILE
            );
        }

    }

    /***********************************
     *  load language files
     ***********************************/



    public function new_plugin_textdomain() {

        load_plugin_textdomain( 'pu-visitor-log', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );

    }


    /***********************************
     *  load Admin page
     ***********************************/

    public function load_admin_page() {

        $admin_page = new AdminPage();

    }
}
