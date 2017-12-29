<?php

namespace Pvl\Includes;

class ErrorPage {
	private $options;

	public function __construct($options) {
		$this->options = $options;
		if (isset($this->options['activated']) && isset($this->options['activated']['pu_log'])) {
			$this->create_page();
		}

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

	public function logScreen() {

		$file = WP_CONTENT_DIR . '/debug.log';
		$bytes=filesize($file);
		//how many lines?
		$linecount=20;

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

		$style = <<<HTML
		<style>
			div.pulog-screen {
				border: 3px solid #fff;
				border-radius: 3px;
				padding: 5px;
				color:gray;
				background-color: #0f0f0f;
				overflow: scroll;
				height:100%;
			}
			
			ul.pulog-screen li {
		      overflow: hidden; 
			  text-overflow: ellipsis;
			  white-space: nowrap;
			}
			
			ul.pulog-screen li.hot {
				color: red;
				font-weight: 600;
			}
		
		</style>
HTML;

		echo $style;
		echo '<div class="pulog-screen">';
		echo '<ul class="pulog-screen">';
		foreach ($lines as $id => $line) {

			$class = preg_match('[Notice|Warning|Fatal ]', $line) ? ' class="hot"' : '';

			echo "<li{$class}>{$line}</li>";
		}
		echo '</div>';
		echo '</ul>';


	}
}