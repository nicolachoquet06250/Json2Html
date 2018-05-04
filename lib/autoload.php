<?php

ini_set('display_errors', 'on');

/**
 * @return bool
 */
function is_cli() {
	return !isset($_SERVER) || empty($_SERVER) || isset($_SERVER['argv']);
}

/**
 * @param $class
 * @throws Exception
 */

function __autoload($class) {
	if(is_file("lib/{$class}.php")) {
		require_once "lib/{$class}.php";
	}
	else {
	    throw new Exception("class {$class} not found !");
    }
}