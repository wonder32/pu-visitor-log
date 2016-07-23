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


    static function pu_visitor_log_install()
    {
//        add_option('pu_visitor_log_user_roles', array('administrator' => 'true'));
//        add_option('pu_visitor_log_show_widgets', array('dashboard_right_now' => 'true'));
//        add_option('pu_visitor_log_widget_content', 'Edit this text or use html, the media uploader, and shortcodes to create your own widget.');
//        add_option('pu_visitor_log_widget_title', 'Custom Widget');
//        add_option('pu_visitor_log_avail_dashboard_widgets');
    }


    /********************************
     *      Un installation
     ********************************/

    public function pu_visitor_log_uninstall()
    {
//        delete_option('pu_visitor_log_user_roles');
//        delete_option('pu_visitor_log_show_widgets');
//        delete_option('pu_visitor_log_widget_content');
//        delete_option('pu_visitor_log_widget_title');
//        delete_option('pu_visitor_log_avail_dashboard_widgets');
    }
}
