<?php 
global $cahnrs_flex, $sdc_custom, $post;
$sdc_custom->post_controller->set_post( $post );
?>
<header id="global-header" class="main-header<?php if( !$sdc_custom->post_model->hide_banner ) echo ' has-banner';?>">
	<div id="site-heading">
    	<a id="site-title" href="<?php echo home_url( '/' );?>">
			<?php echo $sdc_custom->post_model->site_name;?>
        </a>
        <a id="site-description" href="<?php echo get_permalink();?>">
        	<?php echo get_the_title( $post->ID );?>
        </a>
    </div>
    <?php if( is_front_page() ):?> 
    <nav>
    	<?php 
		$nav_args = array(
            'theme_location' => 'site',
            'container'      => false,
            'menu_class'     => 'nav-wrapper is_dropdown',
            'depth'          => 2
            );
		wp_nav_menu( $nav_args );?>
    </nav>
    <?php endif;?>
</header>
<?php if( is_front_page() ):?>
<?php $slides = $cahnrs_flex->get_query( 'category_name=homepage-feature&post_type=any&posts_per_page=4' );?>
<div class="cycle-slideshow cahnrs-full-slider" 
	data-cycle-fx="fade"
    data-cycle-speed="500"
    data-cycle-slides="> div" 
    data-cycle-loader=true
    data-cycle-pager=".cycle-pager"
    data-cycle-timeout=6000 
    data-cycle-pager-template="<a style=background-image:url('{{children.0.src}}') href='#'></a>" />
	<?php foreach( $slides as $slide ):?>
    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $slide->ID ), 'full' );?>
    <div style="background-image: url('<?php echo $image[0];?>');" >
    	<img src="<?php echo $image[0];?>"/ >
        <ul class="slide-caption">
        	<li>
            	<h3 ><?php echo $slide->post_title;?></h3>
            	<span class="slide-description"><?php echo $slide->post_excerpt;?></span>
            </li>
        </ul>
        <a href="<?php echo get_permalink( $slide->ID );?>"></a>
    </div>
    <?php endforeach;?>
</div>
<div class="cycle-pager"></div>
<?php elseif( !$sdc_custom->post_model->hide_banner ):?>
<div id="post-featured-image">
	<div id="post-image-wrapper" style="background-image: url(<?php echo $sdc_custom->post_model->banner_src;?>);">
    </div> 
</div>
<?php endif;?>
<?php if(!is_front_page() ):?>
	<nav id="pagebuilder-tertiary-nav" role="navigation">
        <ul>
	<?php $cahnrs_flex->theme_controller->set_tertiary( $post->ID );?>
    <?php if( $cahnrs_flex->theme_model->tertiary_nav ):?>
    	<?php foreach( $cahnrs_flex->theme_model->tertiary_nav as $nav_item ):
		?><li class="<?php if( $post->ID == $nav_item->object_id ) echo ' selected';?>">
            <a class="" href="<?php echo $nav_item->url;?>">
				<?php echo $nav_item->title;?>
            </a>
        </li><?php endforeach;?>
    <?php else:?>
    	<li class="selected">
            <a class="" href="#">
				<?php echo get_the_title( $post->ID );?>
            </a>
        </li>
    <?php endif;?>  
    </ul>
    </nav>
<?php endif;?>