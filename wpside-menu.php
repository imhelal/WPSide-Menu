<?php
/**
 * Plugin Name: WP Side Menu
 * Description: The plugin to create an awesome mobile menu.
 * Version: 1.0
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: MayaStudio
 * Author URI: https://mayastudio.co.il
 * Text Domain: wpside-menu
 *
 */

// Exit if direct access
if( !defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin directory path
define('WPSM_PLUING_DIR', plugin_dir_path( __FILE__ ));

if( !class_exists('wpsm_plugin_loader') ) {
	function wpsm_plugin_loader() {
		require_once WPSM_PLUING_DIR . 'includes/WPSM_Menu.php';
		WPSM_Menu::getInstance();
	}

	add_action('plugins_loaded', 'wpsm_plugin_loader');
}


