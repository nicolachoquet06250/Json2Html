<?php

class JsonFile {
	private $path_file, $content;

	public function __construct($path) {
		$this->path_file = 'json_site/'.$path.'.json';
		$this->content   = file_exists($this->path_file)
			? file_get_contents($this->path_file) : '';
	}

	public function get() {
		return $this->content;
	}

	public function update($new_value) {
		$this->content = $new_value;
	}

	public function save() {
		$f = fopen($this->path_file, 'w+');
		fwrite($f, $this->content);
		fclose($f);
	}
}