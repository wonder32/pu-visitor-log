<?php
/**
 * Class pu_visitor_logboard_base
 *
 *  __construct     initialize plugin (load init)
 * init()           all basic hooks
 * functions:
 * - check_for_updates()
 * - pu_visitor_logboard_textdomain()
 */

namespace Pvl\Includes;

class Log
{

    private $wp_config;

	public function __construct($options) {

		if ( isset( $options['activated'] ) && isset( $options['activated']['pu_log'] ) ) {

			$this->wp_config = $this->get_wp_config();

		}
	}

	public function result() {
		if (!$this->wp_config) {
			echo 'wp-config.php not found';
			return;
		}

		$interest = [1 => 'WP_DEBUG', 2 => 'WP_DEBUG_log', 3 => 'WP_DEBUG_display'];

		$constant[1] = "define( 'WP_DEBUG', true );". "\r\n";
		$constant[2] = "define( 'WP_DEBUG_LOG', true );". "\r\n";
		$constant[3] = "define( 'WP_DEBUG_DISPLAY', false );". "\r\n";

		foreach ( $this->wp_config as &$line ) {
			if ( ! preg_match( '/^define\(\s*\'([A-Z_]+)\',(.*)\)/', $line, $match ) ) {
				continue;
			}

			if ( $id = array_search($match[1], $interest) ) {
				$line = $constant[$id];
				if ($id === 2 ) {
					$is_pu_log_exist = true;
				}
			}
		}
		unset( $line );

		if ( !$is_pu_log_exist ) {
			array_shift( $this->wp_config );
			array_unshift( $this->wp_config, "<?php\r\n", $constant[1], $constant[2], $constant[3] );
		}

		// Insert the constant in wp-config.php file
		$config_file_path     = ABSPATH . 'wp-config.php';
		$handle = @fopen( $config_file_path, 'w' );
		foreach( $this->wp_config as $line ) {
			@fwrite( $handle, $line );
		}

		@fclose( $handle );

		// Update the writing permissions of wp-config.php file
		$chmod = defined( 'FS_CHMOD_FILE' ) ? FS_CHMOD_FILE : 0644;
		@chmod( $config_file_path, $chmod );

	}

	public function get_wp_config() {
		$config_file_path     = ABSPATH . 'wp-config.php';
		$config_file_alt = dirname( ABSPATH ) . '/wp-config.php';

		if ( !file_exists( $config_file_path ) && !is_writable( $config_file_path ) ) {
			return;
		}
		return $config_file = file( $config_file_path );
	}
}
