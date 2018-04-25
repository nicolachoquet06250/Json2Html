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

$dir = opendir('json_site');

while (($file = readdir($dir)) !== false) {
	if($file !== '.' && $file !== '..') {
		$file_name = explode('.', $file)[0];
		$converted = new JsonToHtml($file_name);
		$converted->write();
	}
}


// aller voir les pages :
//  - http://www.41mag.fr/demo/41mag-memo-html5.pdf
//  - http://41mag.fr/liste-des-balises-html5
// pour voir la liste des balises HTML 5 et les gérer dans le framework