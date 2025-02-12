<?php
/**
 * Plugin Name: WP Side Menu
 * Description: The plugin to create an awesome mobile menu.
 * Version: 1.3.1
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: MayaStudio
 * Author URI: https://mayastudio.co.il
 * Text Domain: wpside-menu
 * Update URI: https://relaxwp.com/plugins/wpside-menu/
 */

// Exit if direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define( 'WPS_PLUGIN_VERSION', 1.2 );
// Plugin directory path
define( 'WPSM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
// Assets directory path
define( 'WPSM_ASSETS_DIR', plugin_dir_url( __FILE__ ) . 'public/assets/' );
// Template path
define( 'WPSM_TEMPLATE_DIR', WPSM_PLUGIN_DIR . 'public/templates/' );


// Helper functions
require_once WPSM_PLUGIN_DIR . 'includes/functions.php';

if ( ! class_exists( 'wpsm_plugin_loader' ) ) {
	function wpsm_plugin_loader() {
		require_once WPSM_PLUGIN_DIR . 'includes/classes.php';
		WPSM_Menu::getInstance();
	}

	add_action( 'plugins_loaded', 'wpsm_plugin_loader' );
}


