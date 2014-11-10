<?php 
global $cahnrs_flex, $post;
if( $cahnrs_flex->check_post_thumbnail() && ( 'page' == $post->post_type  || 'post' == $post->post_type )  ):?> 

<?php $image = wp_get_attachment_url( get_post_thumbnail_id() );?>
<div id="post-featured-image">
	<div id="post-image-wrapper" style="background-image: url(<?php echo $image;?>);">
    </div> 
</div>
<?php endif;?> 
