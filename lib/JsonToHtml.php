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

		$content = '';

		foreach ($file as $balise => $value) {
			if(($method = Html::is_balise($balise))) {
				$content .= Html::$method($value);
			}
		}

		return $content;
	}

	public function write() {
		$this->parse($this->get_file());
		file_put_contents('www/'.$this->name.'.html', $this->parse($this->get_file()));
	}
}