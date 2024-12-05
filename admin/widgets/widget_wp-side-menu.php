<?php

class WPSM_Menu_Widget extends \Elementor\Widget_Base {

    public $wpsm_menu;

	public function get_name() {
		return 'wpsmenu';
	}
	public function get_title() {
		return esc_html__( 'WP Side Menu', 'wpside-menu' );
	}

	public function get_categories() {
		return [ 'wpside_menu_widgets' ];
	}
	private function get_nav_menus() {
		$nav_menus = wp_get_nav_menus();
		$menu_options = [];
		foreach ( $nav_menus as $nav_menu ) {
			$menu_options[ $nav_menu->slug ] = $nav_menu->name;
		}
		return $menu_options;
	}

    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
                'wpsm_menu_content',
            array(
                    'label' => esc_html__( 'Content', 'wpside-menu' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );
        // Add logo control
        $this->add_control(
                'wpsm_logo',
                array(
                   'label' => esc_html__( 'Logo', 'wpside-menu' ),
                   'type' => \Elementor\Controls_Manager::MEDIA,
                   'media_type' => 'image',

            )
        );

		// Add menu control
	    $this->add_control(
			'wpsm_menu',
		    array(
				'label' => esc_html__( 'Menu', 'wpside-menu' ),
			    'type' => \Elementor\Controls_Manager::SELECT,
			    'options' => $this->get_nav_menus(),
			    'default' => ''
		    )
	    );
    }

	public function render() {
		$settings = $this->get_settings_for_display();

        $template_args = $settings;
		$template_name = 'side-menu';
        echo get_wpsm_widget_template($template_name, $template_args);

	}


}