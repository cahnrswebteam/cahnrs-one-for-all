<?php
if ( 'sdc' == get_theme_mod( 'cahnrs_flex_subtheme' ) ) :
	wp_redirect( 'http://sdc.wsu.edu?status=404' );
	exit;
else:
?>
<?php get_header(); ?>

<main class="spine-single-template">

	<?php get_template_part('parts/headers'); ?>

	<section class="row">

		<div class="column one">

			<article id="post-0" class="post error404 no-results not-found">

				<header class="article-header">
					<h1 class="article-title">Page Not Found</h1>
				</header>

				<div class="entry-content">
					<p>This site has recently been reconstructed. We apologize for the inconvenience and appreciate your patience during this transition. The content you are looking for is most likely in a new location - please try using the navigation on the left or the search form below to find it.</p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->

			</article>

		</div><!--/column-->

	</section>

</main>

<?php get_footer(); ?>
<?php endif; ?>