<?php

require 'lib/autoload.php';

$json = '{
  "nohtml": {
    "head": "documentation de la lib"
  },
  "html": {
    "Doctype": {
      "_": "html"
    },
    "html": {
      "head": {
        "_": {
          "metas": [
            {
              "name": "Description",
              "content": "Documentation de la librarie Json2Html"
            },
            {
              "charset": "utf-8"
            }
          ],
          "title": {
            "_": "Documentation de la librarie"
          }
        }
      },
      "body": [
        {
          "name": "p",
          "content": {
            "_": "Les balises supprotées sont :"
          }
        },
        {
          "name": "div",
          "content": {
            "_": []
          }
        }
      ]
    }
  }
}';

$json = json_decode($json);

try {
	$ref = new ReflectionClass(get_class(new Html()));
	$methods = $ref->getMethods();

	$balises = [];

	foreach ($methods as $key => $method) {

		if($method->class === 'Html' && $method->getName() !== '__call' && $method->getName() !== 'is_balise' ) {
			$name = $method->name;
			$balise = 'span';
			$content = new stdClass();
			$content->_ = " - <{$name}></{$name}>";

			$obj = new stdClass();
			$obj->name = $balise;

			$obj->content = $content;

			if($name === '_html') {
				$name = 'html';
				$content->_ = " - <{$name}></{$name}>";
			}
			elseif ($name === 'scripts') {
				$name = 'script';
				$content->_ = " - <{$name}></{$name}>";
			}
			elseif ($name === 'links') {
				$name = 'link';
				$content->_ = " - <{$name}></{$name}>";
			}
			elseif ($name === 'br' && $name === 'img') {
				$content->_ = " - <{$name}/>";
			}
			elseif ($name === 'comment') {
				$content->_ = " - <!-- ... -->";
			}
			$obj->content = $content;

			$balises[] = $obj;
			$br = new stdClass();
			$br->name = 'br';
			$br->nbr = 1;
			$balises[] = $br;
		}
	}


	$json->html->html->body[1]->content->_ = $balises;

	$json = json_encode($json);

	file_put_contents('json_site/doc.json', $json);

	new JsonWebsite('json_site', 'www/doc.html');

} catch (ReflectionException $e) {
	new var_dump($e->getMessage());
}


// aller voir les pages :
//
//  - http://www.41mag.fr/demo/41mag-memo-html5.pdf
//  - http://41mag.fr/liste-des-balises-html5
// pour voir la liste des balises HTML 5 et les gérer dans le framework