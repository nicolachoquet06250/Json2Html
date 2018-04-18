<?php

class JsonFile {
	private $path_file;

	public function __construct($path) {
		$this->path_file = 'json_site/'.$path.'.json';
	}

	public function get() {
		return file_get_contents($this->path_file);
	}

	public function update() {

	}
}