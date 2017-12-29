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
use Pvl\Includes\Log;


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


// start the show
if( is_admin() ) {

	// Settingspage, Errorpage
    $backend = new Backend;
}
