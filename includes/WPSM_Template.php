<?php

class WPSM_Template {
	private static $instance = null;

	private function __construct() {

	}
	public static function getInstance() {
		if (self::$instance == null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function get_template($filename, $template_args = array()) {
		$file = WPSM_TEMPLATE_DIR . $filename . '.php';
		if(!file_exists($file)) {
			return false;
		}
		ob_start();
		include($file);
		return ob_get_clean();
	}
}