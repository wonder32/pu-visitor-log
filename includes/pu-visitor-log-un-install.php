<?php

/*******************************
 *      Installation
 *******************************/

/**
 * Class pu_visitor_logboard_base
 *
 *  __construct     ..
 *
 * methods:
 * - pu_visitor_log_install()      add options
 * - pu_visitor_log_uninstall()    remove options
 */

class pu_visitor_log_un_install
{


    public static function pu_visitor_log_install()
    {
        self::add_options();
    }

    public static function add_options()
{
    //add_action( 'admin_menu', array( __CLASS__, 'admin_settings_menu' ) );

    add_option('pu_visitor_log_settings', array('enable' => 'false', 'dash' => 'false'));
//        add_option('pu_visitor_log_widget_content', 'Edit this text or use html, the media uploader, and shortcodes to create your own widget.');
        add_option('pu_visitor_log_widget_title', 'Custom Widget');
//        add_option('pu_visitor_log_avail_dashboard_widgets');
        // die('install');
}

    /********************************
     *      Un installation
     ********************************/

    public static function pu_visitor_log_uninstall()
    {
        self::remove_options();
    }

    public static function remove_options()
    {

//        delete_option('pu_visitor_log_user_roles');
        delete_option('pu_visitor_log_settings');
//        delete_option('pu_visitor_log_widget_content');
        delete_option('pu_visitor_log_widget_title');
//        delete_option('pu_visitor_log_avail_dashboard_widgets');
        // die('uninstall');
    }
    /********************************
     *      Admin settingspage
     ********************************/

    static function admin_settings_menu()
    {

    }
}
