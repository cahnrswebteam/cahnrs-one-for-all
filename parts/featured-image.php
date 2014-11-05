<?php if( has_post_thumbnail() ):?>
<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );?>
<div id="post-featured-image">
	<div id="post-image-wrapper" style="background-image: url(<?php echo $image[0];?>);">
		<?php /*the_post_thumbnail( 'site-banner' );*/ ?>
    </div> 
</div>
<?php endif;?> 
