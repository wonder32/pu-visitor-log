<?php

namespace Pvl\Includes;

class ErrorPage {
	private $options;
	private $filter;

	public function __construct($options) {
		$this->options = $options;
		if (isset($this->options['activated']) && isset($this->options['activated']['pu_log'])) {
			$this->create_page();
		}

		$this->filter = new Filter;
		$this->filter->add_action( 'admin_enqueue_scripts', $this, 'load_error_scripts' );
		$this->filter->run();

	}

	// register menu
	public function create_page() {
		if ($this->options['activated']['pu_log'] === 'pu_log') {
			add_menu_page(
				__( 'Puddinq visitor log', 'pu-visitor-log' ),
				__( 'Pu visitor log', 'pu-visitor-log' ),
				'manage_options',
				'pu_visitor_log',
				array( $this, 'pu_log_page' ) //function
			);
		}


	}

	// page output
	public function pu_log_page() {
		echo '<div class="wrap">';
		echo '<h2>Pu Visitor Log</h2>';

		$this->logScreen();
		// Display whatever it is you want to show.

		echo '</div>';
	}

	public function load_error_scripts($hook) {

		if ($hook !== 'toplevel_page_pu_visitor_log') {
			return;
		}

		$value = array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
		    'nonce' => wp_create_nonce('0)AT5r}A4H^X')
		);

		wp_enqueue_style( 'pu-log-admin', plugins_url('css/style.css', PVLFILE) );
		wp_enqueue_script( 'pu-log-admin', plugins_url('js/script.js', PVLFILE) );
		wp_localize_script('pu-log-admin', 'pu_ajax', $value);
	}



	public function logScreen() {

		$file = WP_CONTENT_DIR . '/debug.log';
		$bytes=filesize($file);
		//how many lines?
		$linecount=600;
		//what's a typical line length?
		$length=80;

		//we double the offset factor on each iteration
		//if our first guess at the file offset doesn't
		//yield $linecount lines
		$offset_factor=1;

		$fp = fopen($file, "r") or die("Can't open $file");


		$complete=false;
		while (!$complete)
		{
			//seek to a position close to end of file
			$offset = $linecount * $length * $offset_factor;
			fseek($fp, -$offset, SEEK_END);


			//we might seek mid-line, so read partial line
			//if our offset means we're reading the whole file,
			//we don't skip...
			if ($offset<$bytes)
				fgets($fp);

			//read all following lines, store last x
			$lines=array();
			while(!feof($fp))
			{
				$line = fgets($fp);
				array_push($lines, $line);
				if (count($lines)>$linecount)
				{
					array_shift($lines);
					$complete=true;
				}
			}

			//if we read the whole file, we're done, even if we
			//don't have enough lines
			if ($offset>=$bytes)
				$complete=true;
			else
				$offset_factor*=2; //otherwise let's seek even further back

		}
		fclose($fp);

		$base = log($bytes) / log(1024);
		$suffix = array("", "kb", "MB", "Gb", "Tb")[floor($base)];
		$omvang = number_format(pow(1024, $base - floor($base)), 2) . $suffix;

		echo "<div class='pu-log-size'>Your log is {$omvang}<span> clear now</span></div>";
		echo '<div class="pulog-screen">';
		echo '<div id="bytes-pulog-screen" style="display:none">' . $bytes . '</div>';
		echo '<ul class="pulog-screen">';

		$number = 0;
		foreach ($lines as $id => $line) {

			if (preg_match('[Notice|Warning|Fatal]', $line, $matches)) {
				++$number;
				$class = "hot hot-{$matches[0]}";
				$id = "id='hot-{$number}'";
				$pos = strpos($line, ' in ') + 4;
				$line = substr($line, 0, $pos) . '<br>' . substr($line, $pos);

			} else {
				$class = "not not-{$number}";
				$line = substr($line, 26);
			}

			echo "<li class='{$class}'{$id}>{$line}</li>";
		}
		echo '<li><span class="blinking-cursor">.</span><span class="blinking-cursor2">.</span></li>';
		echo '</ul>';
		echo '</div>';



	}
}