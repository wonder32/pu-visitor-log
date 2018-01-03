<?php
/**
 * Created by PhpStorm.
 * User: sscho
 * Date: 31/12/2017
 * Time: 11:09
 */

namespace Pvl\Includes;


class Ajax {

	public function __construct() {
		$this->filter = new Filter;
		$this->filter->add_action( 'wp_ajax_pu_ajax', $this, 'pu_ajax' );
		$this->filter->run();
	}

	public function pu_ajax() {

		// check nonce
		check_ajax_referer('0)AT5r}A4H^X', 'nonce');

		switch ($_POST['task']) {
			case 'refresh':
				$this->refresh();
				break;
			case 'delete':
				$this->delete();
				break;
		}

	}

	public function refresh() {

		$return = array('update' => 'false');

		$file = WP_CONTENT_DIR . '/debug.log';

		$return['bytes'] = filesize($file);

		if ($return['bytes'] === (int) $_POST['bytes']) {
			wp_send_json($return);
		}
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
			if ($offset<$return['bytes'])
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
			if ($offset>=$return['bytes'])
				$complete=true;
			else
				$offset_factor*=2; //otherwise let's seek even further back

		}
		fclose($fp);

		$output = '';

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

			$output .= "<li class='{$class}'{$id}>{$line}</li>";
		}

		$return['output'] = $output;
		$return['old_bytes'] = intval($_POST['bytes']);
		$return['update'] = 'true';

		wp_send_json($return);
	}

	public function delete() {
		$return = array('update' => 'false');

		$file = WP_CONTENT_DIR . '/debug.log';

		$output = '';
		$handle = @fopen( $file, 'w' );

		@fwrite( $handle, '' );

		@fclose( $handle );

		$chmod = defined( 'FS_CHMOD_FILE' ) ? FS_CHMOD_FILE : 0644;
		@chmod( $file, $chmod );

		$return['bytes'] = filesize($file);



		$return['output'] = $output;
		$return['old_bytes'] = intval($_POST['bytes']);
		$return['update'] = 'true';

		wp_send_json($return);
	}
}