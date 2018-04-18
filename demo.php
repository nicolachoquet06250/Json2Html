<?php

/**
 * @param $class
 * @throws Exception
 */
function __autoload($class) {
	if(is_file("lib/{$class}.php")) {
		require_once "lib/{$class}.php";
	}
	else throw new Exception("class {$class} not found !");
}

$index = new JsonToHtml('index');
$index->write();