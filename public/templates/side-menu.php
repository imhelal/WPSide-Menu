<?php
$settings = $template_args;
$logo_url = $settings['wpsm_logo']['url'] ?? null;
$social_icons = $settings['wpsm_social_icons'];
$nav = $settings['wpsm_menu'] ?? null;
$toggle_icon = $settings['wpsm_toggle_icon'] ?? null;

?>

<style>
	button.wpsm-widget-toggle.wpsm-toggle-btn {
		background-color: #6BC4A6;
		border: none;
		color: #fff;
		padding: 13px;
		line-height: 0;
	}

	button.wpsm-widget-toggle.wpsm-toggle-btn svg {
		fill: #fff;
		width: 25px;
	}

	.wpsm-wrapper {
		position: fixed;
		width: 100%;
		min-height: 100vh;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0;
		background: rgb(47 47 47 / 15%);
		z-index: 999999999999999;
		display: flex;
		justify-content: end;
		transition: 0.4s;
		visibility: hidden;
		opacity: 0;
	}

	.wpsm-open.wpsm-wrapper {
		visibility: visible;
		opacity: 1;
	}

	.wpsm-content-wrapper {
		width: 300px;
		background-color: #ADDDE8;
		height: 100%;
		position: relative;
		padding-top: 35px;
		transition: 0.4s;
		transform: translateX(500px);
	}

	.wpsm-open .wpsm-content-wrapper {
		transform: translateX(0px);
	}

	.wpsm-content-wrapper .wpsm-toggle-btn {
		position: absolute;
		top: 2px;
		right: 101%;
		width: 48px;
		height: 48px;
		border-radius: 50%;
		padding: 0px;
		border: none;
		background-color: #6bc4a6;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	button.wpsm-toggle-btn img {
		width: 18px;
		filter: invert(1);
	}

	.wpsm-content {
		display: flex;
		flex-direction: column;
		justify-content: start;
		align-items: center;
		gap: 20px;
	}

	.wpsm-logo {
		text-align: center;
	}

	.wpsm-logo img {
		width: 205px;
		margin: 0 auto;
	}

	.wpsm-social-icons {
		width: 100%;
	}

	.wpsm-social-icons ul {
		display: flex;
		justify-content: center;
		gap: 8px;
		width: 100%;
		padding: 0px 20px;
		flex-wrap: wrap;
		margin: 0;
	}

	.wpsm-social-icons ul li a {
		background-color: #6BC4A6;
		border-radius: 50%;
		display: flex;
		justify-content: center;
		align-items: center;
		padding: 15px;
	}

	.wpsm-social-icons li a svg {
		width: 18px;
		height: 18px;
		fill: #fff;
	}

	.wpsm-nav {
		width: 100%;
		margin-top: 5px;
	}

	.wpsm-nav ul {
		margin: 0;
		padding: 0;
	}

	.wpsm-content ul li {
		list-style: none;
	}

	.wpsm-nav ul li a {
		display: flex;
		padding: 10px 20px;
		background-color: transparent;
		font-size: 20px;
		color: #000000;
		font-weight: 400;
		transition: .4s;
		width: 100%;
		height: 100%;
		justify-content: space-between;
		align-items: center;
	}

	.wpsm-nav ul li a:hover,
	.wpsm-nav ul li.current_page_item>a {
		background-color: #6bc4a6;
		color: #fff;
	}

	.wpsm-nav .menu-item-has-children {
		position: relative;
	}

	.wpsm-nav .menu-item-has-children .submenu-arrow svg {}

	.wps-nav-link span svg {
		width: 24px;
		fill: #fff;
		margin-left: 14px;
		transition: 0.5s;
	}

	.wpsm-nav .wpsm-submenu-active.menu-item-has-children .wps-nav-link .submenu-arrow svg {
		transform: rotate(-90deg);
		fill: #fff !important;
	}

	.wpsm-nav ul li a:hover .submenu-arrow svg,
	.wpsm-nav ul li.current_page_item>.wps-nav-link .submenu-arrow svg {
		fill: #fff !important;
	}

	.wpsm-nav ul.sub-menu {
		height: 0px;
		overflow: hidden;
		transition: 0.4s;

	}

	.wpsm-nav ul.sub-menu li a {
		padding-left: 40px;
	}

	.wpsm-submenu-active ul.sub-menu {
		height: auto;
	}



	/* RTL */
	.rtl .wpsm-wrapper {
		justify-content: start;
	}


	.rtl .wpsm-nav .wpsm-submenu-active.menu-item-has-children .wps-nav-link .submenu-arrow svg {
		transform: rotate(90deg);
	}
</style>
<button
	class="wpsm-widget-toggle wpsm-toggle-btn"><?php \Elementor\Icons_Manager::render_icon( $toggle_icon, array( 'aria-hidden' => true ) ) ?></button>
<div class="wpsm-wrapper">
	<div class="wpsm-content-wrapper">
		<button class="wpsm-toggle-btn">
			<img src="<?php echo WPSM_ASSETS_DIR . 'icons/close-icon.svg' ?>" alt="">
		</button>
		<div class="wpsm-content">
			<!-- logo -->
			<?php if ( $logo_url ) : ?>
				<div class="wpsm-logo">
					<a href="<?php echo home_url(); ?>">
						<img src="<?php echo esc_url( $logo_url ) ?>" alt="">
					</a>
				</div>
			<?php endif; ?>

			<!-- social -->
			<?php if ( ! empty( $social_icons ) ) : ?>
				<div class="wpsm-social-icons">
					<ul>
						<?php foreach ( $social_icons as $icon ) :
							$link = ! empty( $icon['link']['url'] ) ? esc_url( $icon['link']['url'] ) : '#';
							?>
							<li>
								<a href="<?php echo $link ?>"
									target="<?php echo ( $icon['link']['is_external'] ? '_blank' : '_self' ) ?>">
									<?php \Elementor\Icons_Manager::render_icon( $icon['icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
			<!-- nav -->
			<?php if ( $nav ) :
				wp_nav_menu(
					array(
						'menu' => $nav,
						'container' => 'nav',
						'container_class' => 'wpsm-nav',
						'menu_class' => 'wpsm-nav-items',
						'walker' => new Custom_Walker_Nav_Menu()
					)
				);
			endif; ?>
		</div>
	</div>
</div>