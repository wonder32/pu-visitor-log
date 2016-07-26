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
        // Display whatever it is you want to show.
        echo 'Geef hier de mogelijkheden aan die u graag voor de leden van uw ondernemersverening beschikbaar wilt hebben.';
        echo '<form id="pu_visitor_settings" action="options.php" method="post">';
        settings_fields('pu_visitor_settings');
        do_settings_sections('pu-visitor-log');
        submit_button('Opslaan', 'primary', 'ng_ondernemersvereniging_submit');
        echo '</form>';
        echo '</div>';
    }

}

