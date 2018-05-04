<?php

class JsonToHtml {

	private $file, $name, $nohtml, $content;

	public function __construct($name) {
		$this->name   = $name;
		$this->file   = new JsonFile($name);
		$this->nohtml = (isset(json_decode($this->file->get())->nohtml))
			? json_decode($this->file->get())->nohtml : new stdClass();
		$content      = json_decode($this->file->get());
		if (isset($content->html)) :
			$this->content = json_encode($content->html);
		else:
			$this->content = json_encode($content);
		endif;
	}

	private function get_file() {
		return $this->content;
	}

	private function parse($file) {
		$file = (gettype($file) !== 'object' && gettype($file) !== 'array')
			? json_decode($file) : $file;

		$content = '';
		foreach ($file as $balise => $value) {
			if (($method = (new Html())->is_balise($balise))) {
				$content .= (new Html())->$method($value);
			}
		}

		return $content;
	}

	/**
	 * @throws Exception
	 */
	public function write() {
		if (!(isset($this->nohtml->htmlpage) && !$this->nohtml->htmlpage)) {
			file_put_contents('www/'.$this->name.'.html', $this->parse($this->get_file()));
			if (!is_file('www/'.$this->name.'.html')) {
				throw new Exception('Une erreur s\'est produite lors de la création du fichier !');
			}
		}
	}
}