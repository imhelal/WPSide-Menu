<?php

if(!function_exists('get_wpsm_widget_template')){
	function get_wpsm_widget_template($filename, $template_args = array()) {
		$file = WPSM_TEMPLATE_DIR . $filename . '.php';
		if(!file_exists($file)) {
			return false;
		}
		ob_start();
		include($file);
		return ob_get_clean();
	}
}