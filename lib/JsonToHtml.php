<?php

class JsonToHtml {

	private $file, $name;

	public function __construct($name) {
		$this->name = $name;
		$this->file = new JsonFile($name);
	}

	private function get_file() {
		return $this->file->get();
	}

	private function parse($file) {
		$file = (gettype($file) !== 'string')
			? json_decode($this->get_file()) : $file;

		foreach ($file as $balise => $value) {
			if(gettype($value) === 'object') {
				$this->parse($value);
			}
			else {
				var_dump(gettype($value));
			}
		}
	}

	public function write() {
		$this->parse($this->file);
		file_put_contents('www/'.$this->name.'.html', $this->get_file());
	}
}