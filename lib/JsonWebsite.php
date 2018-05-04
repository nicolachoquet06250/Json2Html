<?php

class JsonWebsite {

	/**
	 * JsonWebsite constructor.
	 *
	 * @param        $repo
	 * @param string $redirect
	 */
	public function __construct($repo, $redirect = '') {
		try {
			$dir = opendir($repo);

			while (($file = readdir($dir)) !== false) {
				if ($file !== '.' && $file !== '..') {
					$file_name = explode('.', $file)[0];
					$converted = new JsonToHtml($file_name);
					$converted->write();
				}
			}

			$rall = is_cli() ? "\n" : "\n<br />\n";
			echo "Génération du répository html `{$repo}` réussi !{$rall}";
			if (!is_cli() && $redirect) {
				echo '<script>window.location.href = "'.$redirect.'"</script>';
			}
		} catch (Exception $e) {
			exit($e->getMessage());
		}
	}

}