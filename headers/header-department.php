<?php global $cahnrs_flex; ?>
<header id="global-header" class="main-header colors-<?php echo esc_attr( spine_get_option( 'secondary_colors' ) ); ?>">
	<div id="site-heading">
		<span id="network-title"><a href="http://cahnrs.wsu.edu">CAHNRS</a></span>
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
  <?php if ( is_singular( 'page' ) || is_archive() ) : ?>
  <h1 id="page-title">
	<?php
		if ( is_singular( 'page' ) ) {
			the_title();
		} elseif ( is_archive() ) {
			if ( is_day() ) {
				the_time('F j, Y');
			} elseif ( is_month() ) {
				the_time('F Y');
			} elseif ( is_year() ) {
				the_time('Y');
			} elseif ( is_tax() || is_category() || is_tag() ) {
				single_cat_title();
			}
			echo ' Archive';
		}
	?>
  </h1>
  <?php endif; ?>
</header>