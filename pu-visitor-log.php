<?php
/*
Plugin Name: Pu Visitor Log
Plugin URI:  https://www.puddinq.com/plugins/pu-visitor-log/
Description: Admin dashboard plugin for puddinq sites
Version:     0.0.5
Author:      Stefan Schotvanger
Author URI:  https://www.puddinq.nl/wip/stefan-schotvanger/
License:     WTFPL
License URI: http://www.wtfpl.net/
Domain Path: /languages
Text Domain: pu-visitor-log
*/


use Pvl\Includes\Backend;


// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

require_once 'vendor/autoload.php';

/************************************
 *      CONSTANTS
 ************************************/

define ('PVLADIR', plugin_dir_path(__FILE__));
define ('PVLFILE', __FILE__);
define ('PVLNAME', 'pu-visitor-log');
define ('PVLVERSION', '0.0.5');

/********************** **************
 *      LOAD FILES
 ************************************/

    // settings
    require_once(PVLADIR . 'includes/pu-visitor-log-settings.php');

    // log functions
//    require_once(PULADIR . 'log/pu-visitor-log.php');

// start the show
if( is_admin() ) {
    $backend = new Backend;
}
