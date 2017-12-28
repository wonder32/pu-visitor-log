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
    private $version = PVLVERSION;
    
    private $settings;
    private $error_page;
    private $admin_page;

	public function __construct()
	{
		$this->filter = new Filter();       // hook to actions and filters

		$this->settings = get_option('pu-visitor-log');

		if (is_admin()) {
			$this->startActivation();           // (de)activation hooks
			$this->initAdmin();
			$this->check_for_updates();
		}

		$this->filter->run();
	}

	public function initAdmin() {
		$this->filter->add_action( 'plugins_loaded', $this, 'load_textdomain' );
		$this->filter->add_action( 'admin_menu', $this, 'loadAdminPage' );
		$this->filter->add_action( 'admin_menu', $this, 'loadErrorPage' );
	}


	public function startActivation() {
		register_activation_hook(PVLFILE, array('Pvl\Includes\DeActivate', 'activate'));
		register_deactivation_hook(PVLFILE, array('Pvl\Includes\DeActivate', 'deactivate'));
	}

	public function loadErrorPage() {
		if (false != $this->settings) {
			$this->error_page = new ErrorPage($this->settings);
		}
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

    public function loadAdminPage() {

        $this->admin_page = new AdminPage();

    }
}
