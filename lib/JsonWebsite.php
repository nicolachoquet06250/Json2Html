<?php

class JsonWebsite {

	public function __construct($repo) {
		$dir = opendir($repo);

		while (($file = readdir($dir)) !== false) {
			if($file !== '.' && $file !== '..') {
				$file_name = explode('.', $file)[0];
				$converted = new JsonToHtml($file_name);
				$converted->write();
			}
		}
	}

}