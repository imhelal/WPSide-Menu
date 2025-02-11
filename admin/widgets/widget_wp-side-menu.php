<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Repeater;

class WPSM_Menu_Widget extends Widget_Base {

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

	public function get_script_depends() {
		return [ 'wpsm-script' ];
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
				'label' => esc_html__( 'Menu Content', 'wpside-menu' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			)
		);
		// Add logo control
		$this->add_control(
			'wpsm_logo',
			array(
				'label' => esc_html__( 'Logo', 'wpside-menu' ),
				'type' => Controls_Manager::MEDIA,
				'media_type' => 'image',

			)
		);

		// Add menu control
		$this->add_control(
			'wpsm_menu',
			array(
				'label' => esc_html__( 'Menu', 'wpside-menu' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->get_nav_menus(),
				'default' => ''
			)
		);

		// Add toggle icon control
//	    $this->add_control(
//			'wpsm_toggle_icon',
//			array(
//			'label' => esc_html__( 'Toggle Icon', 'wpside-menu' ),
//		    'type' => Controls_Manager::ICONS,
//		    'default' => array(
//				'value' => WPSM_ASSETS_DIR . 'icons/close-icon.svg',
//			    'library' => 'svg',
//		    )
//	    ));
		$this->add_control(
			'wpsm_toggle_icon',
			array(
				'label' => esc_html__( 'Toggle Icon', 'wpside-menu' ),
				'type' => Controls_Manager::ICONS,
				'default' => array(
					'value' => 'fas fa-bars', // Use the Font Awesome 5 "bars" icon
					'library' => 'fa-solid', // Correct library for solid icons
				)
			)
		);

		// Add social icon reapeter
		// Create a repeater
		$repeater = new Repeater();

		// Add a control for choosing the social icon
		$repeater->add_control(
			'icon',
			[ 
				'label' => __( 'Social Links', 'wpside-menu' ),
				'type' => Controls_Manager::ICONS,
				'default' => [ 
					'value' => 'fab fa-facebook',
					'library' => 'fa-brands',
				],
			]
		);

		// Add a control for the URL
		$repeater->add_control(
			'link',
			[ 
				'label' => __( 'Link', 'wpside-menu' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'wpside-menu' ),
				'default' => [ 
					'url' => '',
				],
			]
		);

		// Add a control for custom label (optional)
		$repeater->add_control(
			'label',
			[ 
				'label' => __( 'Label', 'wpside-menu' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Facebook', 'wpside-menu' ),
			]
		);

		// Add the repeater to the controls
		$this->add_control(
			'wpsm_social_icons',
			[ 
				'label' => __( 'Social Icons', 'wpside-menu' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),

				'title_field' => '{{{ label }}}', // Displays the label in the repeater list.
			]
		);

		$this->end_controls_section();
		/* =========== Style ============ */
		// Toggle Style Section
		$this->start_controls_section(
			'wpsm_menu_toggle_section',
			array(
				'label' => esc_html__( 'Menu Toggle', 'wpside-menu' ),
				'tab' => Controls_Manager::TAB_STYLE,
			)
		);

		// Main toggler color
		$this->add_control(
			'wpsm_main_toggle_color',
			array(
				'label' => esc_html__( 'Toggle Background', 'wpside-menu' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6BC4A6',
				'selectors' => array(
					'{{WRAPPER}} button.wpsm-widget-toggle.wpsm-toggle-btn' => 'background-color: {{VALUE}};',
				)
			)
		);
		$this->add_control(
			'wpsm_main_icon_color',
			array(
				'label' => esc_html__( 'Toggle Icon Color', 'wpside-menu' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => array(
					'{{WRAPPER}} button.wpsm-widget-toggle.wpsm-toggle-btn svg' => 'fill: {{VALUE}};',
				)
			)
		);
		// Icon size
		$this->add_control(
			'wpsm_toggle_icon_size',
			array(
				'label' => esc_html__( 'Icon Size', 'wpside-menu' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 150,
						'step' => 1,
					),
					'em' => array(
						'min' => 0,
						'max' => 20,
						'step' => 1,
					)
				),
				'default' => array(
					'unit' => 'px',
					'size' => 25,
				),
				'selectors' => array(
					'{{WRAPPER}} button.wpsm-widget-toggle.wpsm-toggle-btn svg' => 'width: {{SIZE}}{{UNIT}};',
				)
			)
		);
		// Main toggler padding
		$this->add_control(
			'wpsm_main_toggler_padding',
			array(
				'label' => esc_html__( 'Toggle Button Padding', 'wpside-menu' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default' => array(
					'top' => '10',
					'right' => '10',
					'bottom' => '10',
					'left' => '10',
					'unit' => 'px',
					'isLinked' => true,
				),
				'selectors' => array(
					'{{WRAPPER}} button.wpsm-widget-toggle.wpsm-toggle-btn'
					=> 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				)
			)
		);

		// Close icon color
		$this->add_control(
			'wpsm_close_icon_bg',
			array(
				'label' => esc_html__( 'Close Button Background', 'wpside-menu' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6bc4a6',
				'selectors' => array(
					'{{WRAPPER}} .wpsm-content-wrapper .wpsm-toggle-btn' => 'background-color: {{VALUE}}'
				)
			)
		);

		$this->end_controls_section();


		// Menu Style Section
		$this->start_controls_section(
			'wpsm_menu_style',
			array(
				'label' => esc_html__( 'Menu Content', 'wpside-menu' ),
				'tab' => Controls_Manager::TAB_STYLE,
			) );

		$this->add_control(
			'wpsm_content_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'wpside-menu' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .wpsm-content-wrapper' => 'background-color: {{VALUE}}',
				)
			)
		);
		$this->add_control(
			'wpsm_content_arrow_color',
			array(
				'label' => esc_html__( 'Arrow Color', 'wpside-menu' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .wps-nav-link span svg' => 'fill: {{VALUE}}',
				)
			)
		);

		// Menu text style
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name' => 'wpsm_menu_typography',
				'label' => esc_html__( 'Menu Typography', 'wpside-menu' ),
				'selector' => '{{WRAPPER}} .wpsm-nav ul li a',
			)
		);


		// Text Color
		$this->add_control(
			'wpsm_menu_item_text_color',
			array(
				'label' => esc_html__( 'Text Color', 'wpside-menu' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => array(
					'{{WRAPPER}} .wpsm-nav ul li a' => 'color:{{VALUE}}',
				)
			)
		);
		// Text hover color
		$this->add_control(
			'wpsm_menu_item_text_hover_color',
			array(
				'label' => esc_html__( 'Text Hover Color', 'wpside-menu' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => array(
					'{{WRAPPER}} .wpsm-nav ul li a:hover' => 'color:{{VALUE}}',
					'{{WRAPPER}} .wpsm-nav ul li.current_page_item > a' => 'color: {{VALUE}}'
				)
			)
		);

		// Menu Item hover bg
		$this->add_control(
			'wpsm_menu_item_hover_bg',
			array(
				'label' => esc_html__( 'Item Hover Background', 'wpside-menu' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => array(
					'{{WRAPPER}} .wpsm-nav ul li a:hover' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .wpsm-nav ul li.current_page_item > a' => 'background-color: {{VALUE}}'
				)
			)
		);


		// Logo style
		$this->add_control(
			'wpsm_logo_size',
			array(
				'label' => esc_html__( 'Logo Size', 'wpside-menu' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 500,
						'step' => 1,
					),
					'em' => array(
						'min' => 0,
						'max' => 20,
						'step' => 1,
					)
				),
				'default' => array(
					'unit' => 'px',
					'size' => 205,
				),
				'selectors' => array(
					'{{WRAPPER}} .wpsm-logo img ' => 'width: {{SIZE}}{{UNIT}};',
				)
			)
		);



		// Icon color
		$this->add_control(
			'wpsm_content_icon_color',
			array(
				'label' => esc_html__( 'Social Icon Color', 'wpside-menu' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .wpsm-social-icons ul li a svg' => 'fill: {{VALUE}}',
				)
			)
		);

		// Icon bg
		$this->add_control(
			'wpsm_content_icon_bg_color',
			array(
				'label' => esc_html__( 'Social Icon BG', 'wpside-menu' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .wpsm-social-icons ul li a' => 'background-color: {{VALUE}}',
				)
			)
		);

		$this->end_controls_section();

	}


	public function render() {
		$settings = $this->get_settings_for_display();

		$template_args = $settings;
		$template_name = 'side-menu';
		echo get_wpsm_widget_template( $template_name, $template_args );

	}


}