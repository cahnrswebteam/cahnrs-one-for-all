<?php global $cahnrs_flex; ?>
<header id="global-header" class="main-header colors-<?php echo esc_attr( spine_get_option( 'secondary_colors' ) ); ?>">
	<div id="site-heading">
		<span id="network-title"><a href="http://cahnrs.wsu.edu">CAHNRS</a><?php if ( is_front_page() ) : ?><span><a href="http://cahnrs.wsu.edu">College of Agricultural, Human, and Natural Resource Sciences</a></span><?php endif; ?></span>
		<span id="site-title"><?php echo get_bloginfo( 'name' ); ?></span>
	</div>
  <?php if ( true == spine_get_option( 'crop' ) && is_front_page() ) : ?>
	<nav>
		<?php
			$nav_args = array(
				'theme_location' => 'site',
				'container'      => false,
				'menu_class'     => 'nav-wrapper is_dropdown',
				'depth'          => 1
			);
			wp_nav_menu( $nav_args );
		?>
	</nav>
	<?php endif; ?>
  <?php if ( is_front_page() ) : ?>
	<h1 id="page-title"><?php the_title(); ?></h1>
  <?php endif; ?>
</header>