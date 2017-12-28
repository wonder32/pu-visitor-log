<?php



class pu_visitor_log_hook
{

    private $settings;

    private $log = array();

    public function __construct()
    {
        $this->get_settings();

        $this->check_file();

        $this->add_actions();
    }

    public function get_settings()
    {
        $this->settings = get_option('pu_visitor_settings');
    }

    public function add_actions()
    {
        add_action('exit', [$this, 'print_file']);
    }

    public function add_log($ip = null, $browser = null, $message = null)
    {
        $this->log[] = ['ip' => $ip, 'browser' => $browser, 'message' => $message];
    }

    public function check_file()
    {
        $wp_upload_dir = wp_upload_dir();
        $upload_dir = WP_CONTENT_DIR . '/';
        $filename = 'pu.log';

        if(!file_exists($upload_dir.$filename)) {
            $header = '' . php_EOL;
            $file = file_put_contents($upload_dir.$filename, 'Puddinq Visitor Log');
        }

    }

    public function print_file()
    {

    }
}

$settings = get_option('pu_visitor_settings');



if ('on' == $settings['activated']) {
    $log = new pu_visitor_log_hook;
}