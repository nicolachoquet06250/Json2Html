<?php

class Html {
	const HTML 			= "_html";
	const TITLE			= "title";
	const COMMENT 		= "comment";
	const DOCTYPE 		= "Doctype";
	const A 			= "a";
	const ABBR 			= "abbr";
	const ADDRESS 		= "address";
	const AREA 			= "area";
	const ARTICLE 		= "article";
	const ASIDE 		= "aside";
	const AUDIO 		= "audio";
	const B 			= "b";
	const BASE 			= "base";
	const BDO 			= "bdo";
	const BLOCKQUOTE 	= "blockquote";
	const BODY 			= "body";
	const BR 			= "br";
	const HEAD 			= "head";
	const BUTTON		= "button";
	const CANVAS		= "canvas";
	const CAPTION		= "caption";
	const CITE			= "cite";
	const CODE			= "code";
	const COL			= "col";
	const COLGROUP		= "colgroup";
	const COMMAND		= "command";
	const DATALIST		= "datalist";
	const DD			= "dd";
	const DEL			= "del";
	const DETAILS		= "details";
	const METAS			= "metas";
	const LINKS			= "links";
	const STYLE			= "style";
	const P				= "p";

	static function is_balise($balise) {
		if($balise === 'html') return '_html';
		try {
			$oClass = new ReflectionClass(__CLASS__);
			return (in_array($balise, $oClass->getConstants())) ? $balise : false;
		} catch (ReflectionException $e) {
			return false;
		}
	}

	static function comment($string_or_array) {
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

	static function Doctype($type) {
		return '<!'.__FUNCTION__." {$type}>";
	}

	static function body($array) {
		$body = "\n<body>\n";
		foreach ($array as $balise => $value) {
			if(($method = Html::is_balise($balise))) {
				$body.= Html::$method($value);
			}
		}
		$body .= "\n</body>";

		return $body;
	}

	static function metas($metas) {
		$metas_str = '';

		foreach ($metas as $meta) {
			$metas_str .= (isset($meta->charset))
				? "\n<meta charset='{$meta->charset}' />"
					: "\n<meta name='{$meta->name}' content='{$meta->content}' />";
		}
		$metas_str .= "\n";

		return $metas_str;
	}

	static function links($links) {
		$links_str = '';

		foreach ($links as $link) {
			$links_str .= (isset($link->type))
				? "<link type='{$link->type}' rel='{$link->rel}' 
	href='{$link->href}' />\n"
				: "";
		}

		return $links_str;
	}

	static function _html($array) {
		$html = "\n<html>\n";
		foreach ($array as $balise => $value) {
			if(($method = Html::is_balise($balise))) {
				$html.= Html::$method($value);
			}
		}
		$html .= "\n</html>";

		return $html;
	}

	static function head($array) {
		$head = "\n<head>\n";
		foreach ($array as $balise => $value) {
			if(($method = Html::is_balise($balise))) {
				$head.= Html::$method($value);
			}
		}
		$head .= "\n</head>";

		return $head;
	}

	static function title($title) {
		return '<'.__FUNCTION__.">{$title}</".__FUNCTION__.'>';
	}

	static function style($object) {
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

	static function p($value) {
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
		$p .= ">{$value->html}</".__FUNCTION__.'>';

		return $p;
	}

	static function a($value) {
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
		$a .= ">{$value->html}</".__FUNCTION__.'>';

		return $a;
	}

	static function br($nbr) {
		return $nbr*'<br />';
	}

}