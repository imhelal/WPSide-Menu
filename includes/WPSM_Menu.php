<?php

class WPSM_Menu {

	public $template;

	private static $instance  = null;

	private function __construct() {
		if($this->is_compatible()) {
			$this->template = WPSM_Template::getInstance();
			add_action('init', array($this, 'init'));
		}
	}

	public static function getInstance() {

		if(self::$instance == null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Check plugin compatibility
	 */
	public function is_compatible() {
		// Check if the elementor plugin installed & activated
		if(!did_action('elementor/loaded')) {
			add_action('admin_notices', array($this, 'elementor_missing_notice'));
			return false;
		}

		return true;
	}

	/**
	 * Elementor missing notice
	 */
	public function elementor_missing_notice() {
		$format = '<div class="notice notice-error is-dismissible"><p>%s</p></div>';
		printf($format, esc_html__('Install Elementor, Please!', 'wpside-menu'));
	}

	/**
	 * Plugin initialization
	 */
	public function init() {

		// Assets loader
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

		// Elementor widgets
		add_action('elementor/elements/categories_registered', array($this, 'register_widget_categories'));
		add_action('elementor/widgets/widgets_registered', array($this, 'elementor_widgets_init'));

	}

	/**
	 * Load plugin assets
	 */
	public function enqueue_scripts() {
		wp_enqueue_style('wpsm-style', WPSM_ASSETS_DIR . 'css/wpside-menu.css');
		wp_enqueue_script('wpsm-script', WPSM_ASSETS_DIR . 'js/wpside-menu.js', array(), null, true);

	}

	/**
	 * Elementor Widget Category
	 */
	public function register_widget_categories($elements_manager) {
		$elements_manager->add_category(
			'wpside_menu_widgets',
			array(
				'title' => esc_html__('MayaStudio', 'wpside-menu'),
				'icon' => 'fa fa-home',
				''
			)
		);
	}

	/**
	 * Elementor widgets registerer
	 */
	public function elementor_widgets_init($widgets_manager) {
		require_once WPSM_PLUGIN_DIR . 'includes/widgets_loader.php';
		$widgets_manager->register(new WPSM_Menu_Widget());
	}

}