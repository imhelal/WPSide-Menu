<?php
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
	// Start level - Used for creating submenus
	function start_lvl( &$output, $depth = 0, $args = null ) {
		$classes = array( 'sub-menu' );

		// Optionally add classes based on depth
		if ( $depth === 1 ) {
			$classes[] = 'level-1'; // First-level submenu
		} elseif ( $depth === 2 ) {
			$classes[] = 'level-2'; // Second-level submenu
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		// Open the submenu <ul>
		$id = 'menu-item-' . $args->menu_id;
		$output .= "\n<ul$class_names>\n";
	}

	// Start the menu item - where we add the custom arrows
	function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		// Add a custom class to items that have submenus
		if ( in_array( 'menu-item-has-children', $classes ) ) {
			$classes[] = 'has-children';
		}

		// Add the custom arrow icon for submenus
		if ( in_array( 'has-children', $classes ) ) {
			$arrow = '<span class="submenu-arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg></span>';
		} else {
			$arrow = '';
		}

		// Build the <a> tag for the menu item
		$classes[] = 'menu-item-' . $item->ID;
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = 'menu-item-' . $item->ID;
		$output .= '<li id="' . $id . '"' . $class_names . '>';
		$output .= '<a class="wps-nav-link" href="' . esc_url( $item->url ) . '">' . esc_html( $item->title ) . $arrow . '</a>';
	}
}
