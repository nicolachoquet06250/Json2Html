<?php

class Html extends Balised {

	public function __call($name, $arguments) {
		if($this->is_balise($name)) {
			return $this->$name($arguments[0]);
		}
		else {
			return '';
		}
	}

	public function is_balise($balise) {
		if($balise === 'html') return '_html';
		return (in_array($balise, get_class_methods(get_class($this)))) ? $balise : false;
	}

	private function comment($string_or_array) {
	    new var_dump($string_or_array);
		$comment = "\n".'<!-- '."\n";
		if(gettype($string_or_array) === 'array') {
			foreach ($string_or_array as $string) {
				$comment .= $string."\n";
			}
		}
		else {
			$comment .= $string_or_array;
		}
		$comment .= ' -->'."\n";

		return $comment;
	}

	private function Doctype($type) {
		return '<!'.__FUNCTION__." {$type->_}>";
	}

	private function _html($array) {
		$html = "\n<html>\n";
		foreach ($array as $balise => $value) {
			if(($method = $this->is_balise($balise))) {
				$html.= $this->$method($value);
			}
		}
		$html .= "\n</html>";

		return $html;
	}

	private function head($array) {
		$head = "\n<head>\n";
		$array = isset($array->_) ? get_object_vars($array->_) : $array;
		foreach ($array as $balise => $value) {
			if(($method = $this->is_balise($balise))) {
				$head.= $this->$method($value);
			}
		}
		$head .= "\n</head>";

		return $head;
	}

	private function metas($metas) {
		$metas_str = '';

		foreach ($metas as $meta) {
			$metas_str .= (isset($meta->charset))
				? "\n<meta charset='{$meta->charset}' />"
				: "\n<meta name='{$meta->name}' content='{$meta->content}' />";
		}
		$metas_str .= "\n";

		return $metas_str;
	}

	private function links($links) {
		$links_str = '';

		foreach ($links as $link) {
			$links_str .= (isset($link->type))
				? "<link type='{$link->type}' rel='{$link->rel}' 
	href='{$link->href}' />\n"
				: "";
		}

		return $links_str;
	}

	private function title($title) {
		return '<'.__FUNCTION__.">{$title->_}</".__FUNCTION__.'>'."\n";
	}

	private function style($object) {
		$style_str = "<style>\n";
		foreach ($object as $selecteur => $style) {
			$style_str .= "\t".$selecteur." {\n";
			foreach ($style as $prop => $valeur) {
				$style_str .= "\t\t".$prop.': '.$valeur.';'."\n";
			}
			$style_str .= "\t}\n";
		}
		$style_str .= "</style>";
		return $style_str;
	}

	private function body($array) {
		$body = "\n<body>\n";
		foreach ($array as $balise) {
            new var_dump($balise->name);
			if(($method = $this->is_balise($balise->name))) {
			    $body.= ($method === 'br')
                    ? $this->$method($balise->nbr)
                        : $this->$method($balise->content);
			}
		}
		$body .= "\n</body>";

		return $body;
	}

	private function p($value) {
		$p = '<'.__FUNCTION__.' ';
		if(isset($value->attr) && count($value->attr) > 0) {
			foreach ($value->attr as $attr => $valeur) {
				$p .= $attr."='";
				foreach ($valeur as $cle => $val) {
					if(gettype($cle) === 'string') {
						$p .= $cle.':'.$val.'; ';
					}
					else {
						$p .= $val.' ';
					}
				}
				$p .= "' ";
			}
		}
		$p .= ">{$value->_}</".__FUNCTION__.'>';

		return $p;
	}

	private function a($value) {
		$a = '<'.__FUNCTION__.' ';
		if(isset($value->attr) && count($value->attr) > 0) {
			foreach ($value->attr as $attr => $valeur) {
				$a .= $attr."='";
				if(gettype($valeur) === 'array') {
					foreach ($valeur as $cle => $val) {
						if (gettype($cle) === 'string') {
							$a .= $cle.':'.$val.'; ';
						} else {
							$a .= $val.' ';
						}
					}
				}
				else {
					$a .= $valeur;
				}
				$a .= "' ";
			}
		}
		$a .= ">{$value->_}</".__FUNCTION__.'>';

		return $a;
	}

	private function b($value) {
		return '<'.__FUNCTION__.">{$value}</".__FUNCTION__.'>';
	}

	private function br($nbr) {
		$brs = '';
		for($i=0, $max=(int)$nbr; $i<$max; $i++) {
			$brs .= "\n<br />";
		}
		$brs .= "\n";
		return $brs;
	}

	private function img($value) {
		$attrs = '';
		if(isset($value->attr) && count($value->attr) > 0) {
			foreach ($value->attr as $attr => $valeur) {
				$attrs .= $attr."='";
				if(gettype($valeur) === 'array' || gettype($valeur) === 'object') {
					$valeur = (gettype($valeur) === 'object') ? get_object_vars($valeur) : $valeur;
					foreach ($valeur as $cle => $val) {
						if (gettype($cle) === 'string') {
							$attrs .= $cle.':'.$val.'; ';
						} else {
							$attrs .= $val.' ';
						}
					}
				}
				else {
					$attrs .= $valeur;
				}
				$attrs .= "' ";
			}
		}
		return $this->balise(__FUNCTION__, '', $attrs,true);
	}

}