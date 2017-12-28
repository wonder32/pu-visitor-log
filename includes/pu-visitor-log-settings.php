<?php

add_action( 'admin_init', 'register_pu_dash_setings' );

function register_pu_dash_setings()
{
    $blog_name = get_bloginfo('name');

    //register our settings
    register_setting(
        'pu_visitor_settings',
        'pu_visitor_settings'
    );

    add_settings_section(
        'pu_visitor_settings',
        $blog_name . 'visitor settings.',
        'pu_visitor_intro',
        'pu-visitor-log'
    );

    add_settings_field(
        'activated',
        __('Activate', 'pu-visitor-log'),
        'pu_visitor_activate',
        'pu-visitor-log',
        'pu_visitor_settings'
    );
    add_settings_field(
        'errors',
	    __('Erord', 'pu-visitor-log'),
        'pu_visitor_errors',
        'pu-visitor-log',
        'pu_visitor_settings'
    );


}

function pu_visitor_intro() {
    echo '<p></p>';
}

function pu_visitor_activate()
{
    $options = get_option('pu_visitor_settings');
    $disable = (isset($options['activated'])) ? 'checked' : '';
    ?>
    <input type="checkbox" id="activated" name="pu_visitor_settings[activated]" <?php echo $disable; ?>>
    <p>Select box to activate.</p>
    <?php
}

function pu_visitor_errors()
{
    $options = get_option('pu_visitor_settings');
    $disable = (isset($options['errors'])) ? 'checked' : '';
    ?>
    <input type="checkbox" id="errors" name="pu_visitor_settings[errors]" <?php echo $disable; ?>>
    <p>Select box to show errors.</p>
    <?php
}

