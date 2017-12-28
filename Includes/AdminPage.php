<?php

namespace Pvl\Includes;

class AdminPage
{
	private $Settings;

    public function __construct()
    {
        $this->create_page();
        $this->registerOptions();
    }

    // register menu
    public function create_page()
    {
        add_submenu_page(
            'options-general.php',
	        __( 'Puddinq Visitor Log Settings.', 'pu-visitor-log' ),
	        __( 'Pu visitor log'),
	        __( 'manage_options'),
	        __( 'pu-visitor-log'),
            array($this, 'pu_options') //function
        );


    }

    // page output
    public function pu_options()
    {
        echo '<div class="wrap">';
        echo '<h2>Pu Visitor Log</h2>';
        // Display whatever it is you want to show.
        echo '<form id="pu_visitor_settings" action="options.php" method="post">';
        settings_fields('pu-visitor-log');
        do_settings_sections('pu-visitor-log');
        submit_button('Opslaan', 'primary', 'ng_ondernemersvereniging_submit');
        echo '</form>';
        echo '</div>';
    }

    public function registerOptions() {

    	$this->Settings = new Settings();

	    // Section: Basic Settings.
	    $this->Settings->add_section(
		    array(
			    'id'    => 'pu-visitor-log',
			    'title' => __( 'Settings.', 'pu-visitor-log' ),
			    'desc' => __( 'Here you can set which log parts should be activated.', 'pu-visitor-log' ),
		    )
	    );

	    $this->Settings->add_field(
		    'pu-visitor-log',
		    array(
			    'id'      => 'activated',
			    'type'    => 'multicheck',
			    'name'    => __( 'Select parts', 'pu-visitor-log' ),
			    'desc'    => __( 'You need to save the settings before they take effect.', 'pu-visitor-log' ),
			    'options' => array(
				    'wp_log' => __( 'Activate default wordpress logging.', 'pu-visitor-log' ),
				    'pu_log'  =>  __( 'Add Puddinq log screen to menu.', 'pu-visitor-log' )
			    )
		    )
	    );

    }

}

