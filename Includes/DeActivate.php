<?php

/*******************************
 *      Installation
 *******************************/


namespace Pvl\Includes;

class DeActivate
{

	/********************************
	 *      Un installation
	 ********************************/
	public static function activate()
	{

//		wp_die('test this');
	    add_option('pu_visitor_settings', array('activate' => null, 'errors' => 'on'));

	}


    /********************************
     *      Un installation
     ********************************/
    public static function deactivate()
    {

//	    wp_die('test this');
	    delete_option( 'pu_visitor_settings' );

    }
}
