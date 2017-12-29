<?php

namespace Pvl\Includes;

class AdminPage
{
	private $settings;
	private $options;

	private $log;

    public function __construct($options)
    {
	    $this->options = $options;
        $this->create_page();
        $this->registerOptions();
    }

    // register menu
    public function create_page()
    {
        add_submenu_page(
            'options-general.php',
	        __( 'Puddinq Visitor Log Settings.', 'pu-visitor-log' ),
	        __( 'Pu visitor log', 'pu-visitor-log' ),
	        'manage_options',
	        __( 'pu-visitor-log', 'pu-visitor-log' ),
            array($this, 'pageOutput') //function
        );


    }

    // page output
    public function pageOutput()
    {
        echo '<div class="wrap">';
        echo '<h2>Pu Visitor Log</h2>';
	    $this->settings->show_navigation();
	    $this->settings->script();
	    $this->settings->show_forms();

	    $this->log = new Log($this->options);
	    $this->log->result();

        echo '</div>';
    }

    public function registerOptions() {

    	$this->settings = new Settings();

	    // Section: Basic Settings.
	    $this->settings->add_section(
		    array(
			    'id'    => 'pu-visitor-log',
			    'title' => __( 'Settings.', 'pu-visitor-log' ),
			    'desc' => __( 'Here you can set which log parts should be activated.', 'pu-visitor-log' ),
		    )
	    );

	    $this->settings->add_field(
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

