<?php get_header(); ?>

<main class="spine-page-default">

<?php get_template_part('parts/headers'); ?> 

<?php get_template_part('parts/featured-image'); ?>

<section class="row">
	
		<?php while ( have_posts() ) : the_post(); ?>
	
			<?php get_template_part('articles/article'); ?>
		
		<?php endwhile; ?>

</section>

</main>

<?php get_footer(); ?>