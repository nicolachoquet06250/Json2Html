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
		$file = (gettype($file) !== 'object' && gettype($file) !== 'array')
			? json_decode($file) : $file;

		foreach ($file as $balise => $value) {
			switch (gettype($value)) {
				case 'object':
					$this->parse($value);
					break;
				case 'array':
					$this->parse($value);
					break;
				case 'string':
					var_dump("<{$balise}>{$value}</{$balise}>");
					break;
				default:
					break;
			}
		}
	}

	public function write() {
		$this->parse($this->get_file());
		file_put_contents('www/'.$this->name.'.html', $this->get_file());
	}
}