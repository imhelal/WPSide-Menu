<?php

class WPSM_Menu {

	public $template;

	private static $instance = null;

	private function __construct() {
		if ( $this->is_compatible() ) {
			$this->template = WPSM_Template::getInstance();
			add_action( 'init', array( $this, 'init' ) );
		}
	}

	public static function getInstance() {

		if ( self::$instance == null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Check plugin compatibility
	 */
	public function is_compatible() {
		// Check if the elementor plugin installed & activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'elementor_missing_notice' ) );
			return false;
		}

		return true;
	}

	/**
	 * Elementor missing notice
	 */
	public function elementor_missing_notice() {
		$format = '<div class="notice notice-error is-dismissible"><p>%s</p></div>';
		printf( $format, esc_html__( 'Install Elementor, Please!', 'wpside-menu' ) );
	}

	/**
	 * Plugin initialization
	 */
	public function init() {

		// update checker
		if ( is_admin() && function_exists( 'get_plugin_data' ) ) {
			add_filter( 'site_transient_update_plugins', array( $this, 'update_checker' ) );
		}

		// Assets loader
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Elementor widgets
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_widget_categories' ) );
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'elementor_widgets_init' ) );

	}

	// Check for update
	public function update_checker( $transient ) {
		if ( empty( $transient->checked ) ) {
			return $transient;
		}

		$plugin_slug = 'wpside-menu/wpside-menu.php';
		$remote_url = 'https://relaxwp.com/plugins/wpside-menu/metadata.json';

		// Fetch plugin metadata.
		$response = wp_remote_get( $remote_url );

		// Debug: Log the response
		//error_log('Update checker response: ' . print_r($response, true));

		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			return $transient;
		}

		$data = json_decode( wp_remote_retrieve_body( $response ), true );

		// Debug: Log the metadata
		//error_log('Update metadata: ' . print_r($data, true));

		// Check if the new version is greater than the current version.
		if ( version_compare( $data['version'], get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin_slug )['Version'], '>' ) ) {
			$transient->response[ $plugin_slug ] = (object) [ 
				'slug' => $plugin_slug,
				'new_version' => $data['version'],
				'package' => $data['download_url']
			];
		}

		return $transient;
	}


	/**
	 * Load plugin assets
	 */
	public function enqueue_scripts() {
		//		wp_enqueue_style('wpsm-style', WPSM_ASSETS_DIR . 'css/wpside-menu.css');
		wp_register_script( 'wpsm-script', WPSM_ASSETS_DIR . 'js/wpside-menu.js?v=' . WPS_PLUGIN_VERSION, array(), null, true );

	}

	/**
	 * Elementor Widget Category
	 */
	public function register_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'wpside_menu_widgets',
			array(
				'title' => esc_html__( 'MayaStudio', 'wpside-menu' ),
				'icon' => 'fa fa-home',
				''
			)
		);
	}

	/**
	 * Elementor widgets registerer
	 */
	public function elementor_widgets_init( $widgets_manager ) {
		require_once WPSM_PLUGIN_DIR . 'includes/widgets_loader.php';
		$widgets_manager->register( new WPSM_Menu_Widget() );
	}

}