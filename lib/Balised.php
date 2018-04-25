<?php

class Balised {
	protected function balise($name, $value = '', $attrs = null, $autoclosed = false) {
		if($autoclosed) {
			$value = $value !== '' ? "value='{$value}'" : '';
		}

		$balise = "<{$name} ";
		if($attrs) {
			$balise .= $attrs;
		}
		$balise .= $autoclosed ? "{$value} />" : ">{$value}</{$name}>";

		return $balise;
	}
}