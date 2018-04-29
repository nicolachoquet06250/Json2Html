<?php

class Balised {
	protected function balise($name, $value = '', $attrs = null, $autoclosed = false) {
		if($autoclosed) {
			$value = $value !== '' ? "value='{$value}'" : '';
		}

		$balise = "<{$name}";
		if($attrs) {
			$balise .= " {$attrs}";
		}
		$value = htmlspecialchars($value);
		$balise .= $autoclosed ? "{$value} />" : ">{$value}</{$name}>";

		return $balise;
	}

	protected function attrs($attrs, callable $callback = null) {
	    $default_callback = function ($attr) {
            $attrs_str = '';

            if(isset($attr->attr) && count($attr->attr) > 0) {
                foreach ($attr->attr as $attr => $valeur) {
                    $attrs_str .= $attr."='";
                    if(gettype($valeur) === 'array' || gettype($valeur) === 'object') {
                        $valeur = (gettype($valeur) === 'object') ? get_object_vars($valeur) : $valeur;
                        foreach ($valeur as $cle => $val) {
                            if (gettype($cle) === 'string') {
                                $attrs_str .= $cle.':'.$val.'; ';
                            } else {
                                $attrs_str .= $val.' ';
                            }
                        }
                    }
                    else {
                        $attrs_str .= $valeur;
                    }
                    $attrs_str .= "' ";
                }
            }
            return $attrs_str;
        };

	    return ($callback)
            ? $callback($attrs) : $default_callback($attrs);
	}

}