<?php
global $cahnrs_flex;
$opts = get_theme_mod( 'cahnrs_flex_subtheme' );
?>
<header id="global-header" class="main-header colors-<?php echo esc_attr( spine_get_option( 'secondary_colors' ) ); ?>">
	<div id="site-heading"<?php if ( has_nav_menu( 'cahnrs_horizontal' ) ) echo ' class="additional-menu"'; ?>>
		<div class="organization cahnrs">
    	<a href="http://cahnrs.wsu.edu">CAHNRS</a>
			<div>
				<a href="http://cahnrs.wsu.edu">College of Agricultural, Human, and Natural Resource Sciences</a>
				<ul>
					<li><a href="http://cahnrs.wsu.edu/academics/">Students</a></li>
					<li><a href="http://cahnrs.wsu.edu/research/">Research</a></li>
					<li><a href="http://cahnrs.wsu.edu/extension/">Extension</a></li>
					<li><a href="http://cahnrs.wsu.edu/alumni/">Alumni and Friends</a></li>
					<li><a href="http://cahnrs.wsu.edu/fs/">Faculty and Staff</a></li>
				</ul>
			</div>
		</div><?php if ( 'extension' == $opts ) : ?><div class="organization">
    	<a href="http://ext.wsu.edu">Extension</a>
			<div>
				<a href="http://ext.wsu.edu">Extension</a>
				<ul>
					<li><a href="http://extension.wsu.edu/">Placeholder</a></li>
					<li><a href="http://extension.wsu.edu/">Placeholder</a></li>
					<li><a href="http://extension.wsu.edu/">Placeholder</a></li>
					<li><a href="http://extension.wsu.edu/">Placeholder</a></li>
					<li><a href="http://extension.wsu.edu/">Placeholder</a></li>
				</ul>
      </div>
		</div><?php endif; ?><a id="site-title" href="<?php echo home_url( '/' ); ?>"><?php echo get_bloginfo( 'name' ); ?></a>
	</div>
  <?php if ( has_nav_menu( 'cahnrs_horizontal' ) ) : ?>
	<nav id="cahnrs-additional-navigation" class="<?php echo esc_attr( spine_get_option( 'spine_color' ) ); ?>">
	<?php
		$horizontal_nav_args = array(
			'theme_location' => 'cahnrs_horizontal',
			'container'      => false,
			'menu_class'     => 'nav-wrapper is_dropdown',
			'depth'          => 3,
		);
		wp_nav_menu( $horizontal_nav_args );
	?>
	</nav>
	<?php endif; ?>
	<?php if ( true == spine_get_option( 'crop' ) && is_front_page() ) : ?>
	<nav id="cahnrs-primary-navigation">
		<?php
			$site_nav_args = array(
				'theme_location' => 'site',
				'container'      => false,
				'menu_class'     => 'nav-wrapper is_dropdown',
				'depth'          => 1,
			);
			wp_nav_menu( $site_nav_args );
		?>
	</nav>
	<?php endif; ?>
	<?php if ( is_front_page() ) : ?>
	<h1 id="page-title"><?php the_title(); ?></h1>
	<?php endif; ?>
</header>