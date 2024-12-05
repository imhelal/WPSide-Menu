<?php

class WPSM_Menu_Widget extends \Elementor\Widget_Base {


	public function get_name() {
		return 'wpsmenu';
	}
	public function get_title() {
		return esc_html__( 'WP Side Menu', 'wpside-menu' );
	}


}