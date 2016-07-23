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

class pu_visitor_log_plugin_start
{
    public $version = PULAVERSION;

    public function __construct()
    {
        add_action('init', array($this, 'init'));

        register_activation_hook(PULAFILE, [$this, 'activate']);

        // load and execute update checker
        $this->check_for_updates();
    }

    public function init()
    {
        // hook add options in activation hook
        add_action( 'pu-dash-activation', ['pu_visitor_log_un_install', 'pu_visitor_log_install']);
        // localize language files
        add_action( 'plugins_loaded', [$this, 'pu_visitor_log_textdomain']);
        // load admin settings page
        add_action( 'admin_menu', [$this, 'load_admin_page'] );
    }

    public function activate()
    {
        do_action('pu-dash-activation');
    }
    /************************************
     *  if plugin page check for updates
     ************************************/


    public function check_for_updates()
    {
        // only load file if it has not been loaded
        if (is_admin()) {
            if( !class_exists( 'PucFactory' ) ) {
                require PULADIR . 'vendor/plugin-update-checker/plugin-update-checker.php';
            }
            $pu_visitor_log_UpdateChecker = PucFactory::buildUpdateChecker(
                'http://plugins.puddinq.com/updates/?action=get_metadata&slug=pu-dashboard',
                PULAFILE
            );
        }

    }

    /***********************************
     *  load language files
     ***********************************/



    public function new_plugin_textdomain() {

        load_plugin_textdomain( 'wp-pu-dashboard-lang', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );

    }


    /***********************************
     *  load Admin page
     ***********************************/

    public function load_admin_page() {

        $admin_page = new pu_visitor_log_admin_page();

    }
}
