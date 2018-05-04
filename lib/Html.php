<?php

class Html extends Balised {

	public function __call($name, $arguments) {
		if ($this->is_balise($name)) {
			return $this->$name($arguments[0]);
		} else {
			return '';
		}
	}

	public function is_balise($balise) {
		if ($balise === 'html') {
			return '_html';
		}
		return (in_array($balise, get_class_methods(get_class($this)))) ? $balise : false;
	}

	/**
	 * @param $string_or_array
	 * @return string
	 */
	private function comment($string_or_array) {
		$comment = "\n".'<!-- '."\n";
		if (gettype($string_or_array) === 'array') {
			foreach ($string_or_array as $string) {
				$comment .= $string."\n";
			}
		} else {
			$comment .= $string_or_array;
		}
		$comment .= ' -->'."\n";

		return $comment;
	}

	/**
	 * @param $type
	 * @return string
	 */
	private function Doctype($type) {
		return '<!'.__FUNCTION__." {$type->_}>";
	}

	/**
	 * @param $array
	 * @return string
	 */
	private function _html($array) {
		$html = "\n<html>\n";
		foreach ($array as $balise => $value) {
			if (($method = $this->is_balise($balise))) {
				$html .= $this->$method($value);
			}
		}
		$html .= "\n</html>";

		return $html;
	}

	/**
	 * @param $array
	 * @return string
	 */
	private function head($array) {
		$head  = "\n<head>\n";
		$array = isset($array->_) ? get_object_vars($array->_) : $array;
		foreach ($array as $balise => $value) {
			if (($method = $this->is_balise($balise))) {
				$head .= $this->$method($value);
			}
		}
		$head .= "\n</head>";

		return $head;
	}

	/**
	 * @param $metas
	 * @return string
	 */
	private function metas($metas) {
		$metas_str = '';

		foreach ($metas as $meta) {
			$attrs = $this->attrs($meta, function ($attrs) {
				$str = '';
				foreach ($attrs as $attr => $valeur) {
					$str .= "{$attr}=\"{$valeur}\" ";
				}
				return $str;
			});

			$metas_str .= "\n{$this->balise('meta', '', $attrs, true)}";
		}
		$metas_str .= "\n";

		return $metas_str;
	}

	/**
	 * @param $links
	 * @return string
	 */
	private function links($links) {
		$links_str = '';

		foreach ($links as $link) {
			$attrs = $this->attrs($link, function ($attrs) {
				$str = '';
				foreach ($attrs as $attr => $valeur) {
					$str .= "{$attr}=\"{$valeur}\" ";
				}
				return $str;
			});

			$links_str .= "{$this->balise('link', '', $attrs, true)}\n";
		}

		return $links_str;
	}

	/**
	 * @param $links
	 * @return string
	 */
	private function scripts($links) {
		$scripts_str = '';

		foreach ($links as $link) {
			$attrs = $this->attrs($link, function ($attrs) {
				$str = '';
				foreach ($attrs as $attr => $valeur) {
					$str .= "{$attr}=\"{$valeur}\" ";
				}
				return $str;
			});

			$scripts_str .= "{$this->balise('script', '', $attrs)}\n";
		}

		return $scripts_str;
	}

	/**
	 * @param $title
	 * @return string
	 */
	private function title($title) {
		return $this->balise(__FUNCTION__, $title->_)."\n";
	}

	/**
	 * @param $object
	 * @return string
	 */
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

	/**
	 * @param $array
	 * @return string
	 */
	private function body($array) {
		$body = "\n<body>\n";
		foreach ($array as $balise) {
			if (($method = $this->is_balise($balise->name))) {
				$body .= ($method === 'br')
					? $this->$method($balise->nbr)
					: $this->$method($balise->content);
			}
		}
		$body .= "\n</body>";

		return $body;
	}

	/**
	 * @param $content
	 * @return string
	 */
	private function div($content) {
		$parse_array = function ($array, Html $self) {
			$str = '';
			foreach ($array as $balise) {
				if (($method = $self->is_balise($balise->name))) {
					$str .= ($method === 'br')
						? $self->$method($balise->nbr)
						: $self->$method($balise->content);
				}
			}
			return $str;
		};
		$div         = "\n<".__FUNCTION__.">\n";
		$div         .= "\t".(gettype($content->_) === 'array'
				? $parse_array($content->_, $this) : "<span>{$content->_}</span>")."\n";
		$div         .= '</'.__FUNCTION__.">\n";
		return $div;
	}

	/**
	 * @param $value
	 * @return string
	 */
	private function p($value) {
		$attrs = $this->attrs($value);

		return $this->balise(__FUNCTION__, $value->_, $attrs);
	}

	/**
	 * @param $value
	 * @return string
	 */
	private function a($value) {
		$attrs = $this->attrs($value);

		return $this->balise(__FUNCTION__, $value->_, $attrs);
	}

	/**
	 * @param $value
	 * @return string
	 */
	private function b($value) {
		$attrs = $this->attrs($value);

		return $this->balise(__FUNCTION__, $value->_, $attrs);
	}

	/**
	 * @param $nbr
	 * @return string
	 */
	private function br($nbr) {
		$brs = '';
		for ($i = 0, $max = (int)$nbr; $i < $max; $i++) {
			$brs .= "\n{$this->balise(__FUNCTION__, '', '',true)}";
		}
		$brs .= "\n";
		return $brs;
	}

	/**
	 * @param $value
	 * @return string
	 */
	private function img($value) {
		$attrs = $this->attrs($value);

		return $this->balise(__FUNCTION__, $value->_, $attrs, true);
	}

	/**
	 * @param $value
	 * @return string
	 */
	private function span($value) {
		$attrs = $this->attrs($value);

		return $this->balise(__FUNCTION__, $value->_, $attrs);
	}

}