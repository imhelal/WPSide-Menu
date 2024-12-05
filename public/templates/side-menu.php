<?php
	$settings = $template_args;
	$logo_url = $settings['wpsm_logo']['url'] ?? null;
    $nav = $settings['wpsm_menu'] ?? null;
?>

<div class="wpsm-wrapper">
	<div class="wpsm-content-wrapper">
		<button class="wpsm-close-btn">Close</button>
		<div class="wpsm-content">
			<!-- logo -->
			<?php if ($logo_url): ?>
			<div class="wpsm-logo">
				<img src="<?php echo esc_url($logo_url) ?>" alt="">
			</div>
			<?php endif; ?>

			<!-- social -->
			<div class="wpsm-social-icons">
				<ul>
					<li><a href="#">test</a></li>
				</ul>
			</div>
			<!-- nav -->
            <?php if ($nav):
                    wp_nav_menu(
                            array(
                                    'menu' => $nav,
                                'container' => 'nav',
                                'container_class' => 'wpsm-nav',
                                'menu_class' => 'wpsm-nav-items',
                            )
                    );
                endif; ?>
		</div>
	</div>
</div>