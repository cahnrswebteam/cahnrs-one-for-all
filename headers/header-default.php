<?php global $cahnrs_flex; ?>
<header id="global-header" class="main-header">
	<div id="site-heading">
		<a href="<?php echo home_url( '/' ); ?>">
			<span id="site-title"><?php echo get_bloginfo( 'name' ); ?></span>
			<span id="site-description"><?php echo get_bloginfo( 'description' ); ?></span>
		</a>
	</div>
	<?php if ( has_nav_menu( 'cahnrs_horizontal' ) ) : ?>
	<nav>
	<?php
		$nav_args = array(
			'theme_location' => 'cahnrs_horizontal',
			'container'      => false,
			'menu_class'     => 'nav-wrapper is_dropdown',
			'depth'          => 2
		);
		wp_nav_menu( $nav_args );
	?>
	</nav>
	<?php endif; ?>
</header>