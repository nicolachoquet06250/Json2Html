<?php

class var_dump {
	public function __construct($mixed) {
		if(php_sapi_name() === 'cli') {
			var_dump($mixed);
		}
		else {
			echo '<pre style="margin-left: 30px;">';
			var_dump($mixed);
			echo '</pre>';
		}
	}
}