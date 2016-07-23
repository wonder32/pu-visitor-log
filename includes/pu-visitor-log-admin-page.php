<?php

class pu_visitor_log_admin_page
{

    public function __construct()
    {
        $this->create_page();
    }

    // register menu
    public function create_page()
    {
        add_submenu_page(
            'options-general.php',
            'Visitor information',
            'Visitor log',
            'manage_options',
            'pu-visitor-log',
            array($this, 'pu_options') //function
        );
    }

    // page output
    public function pu_options()
    {
        echo '<div class="wrap">';
        echo '<h2>Your Plugin Name</h2>';
        echo 'test ';
        echo '</div>';
    }

}