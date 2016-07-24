<?php
/*
Plugin Name: Pu Visitor Log
Plugin URI:  https://www.puddinq.com/plugins/pu-visitor-log/
Description: Admin dashboard plugin for puddinq sites
Version:     0.0.3
Author:      Stefan Schotvanger
Author URI:  https://www.puddinq.nl/wip/stefan-schotvanger/
License:     WTFPL
License URI: http://www.wtfpl.net/
Domain Path: /languages
Text Domain: pu-visitor-log
*/

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/************************************
 *      CONSTANTS
 ************************************/

define ('PULADIR', plugin_dir_path(__FILE__));
define ('PULAFILE', __FILE__);
define ('PULANAME', 'pu-dashboard');
define ('PULAVERSION', '0.0.3');

/********************** **************
 *      LOAD FILES
 ************************************/

    // plugin activation, uninstall and deactivation
    require_once(PULADIR . 'includes/pu-visitor-log-un-install.php');
    // plugin kickoff
    require_once(PULADIR . 'includes/pu-visitor-log-plugin-start.php');
    // admin screen
    require_once(PULADIR . 'includes/pu-visitor-log-admin-page.php');



// start the show
if( class_exists( 'pu_visitor_log_plugin_start' ) ) {
    $pu_visitor_log_plugin_start = new pu_visitor_log_plugin_start;
}
