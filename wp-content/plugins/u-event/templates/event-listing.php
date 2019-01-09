<?php 
/*
 *  Event List
 */
get_header();
?>
	<?php
	global $page_title;
	$page_title = __('Events', 'cactusthemes'); //overwrite page title
	get_template_part( 'header', 'heading' ); ?>
    <div id="body">
    	<div class="container">
        	<div class="content-pad-3x">
            <?php
			//global $u_event;
			$event_style =  cop_get('u_event_settings','uevent-style');
			//echo $style;
			if($event_style !='grid'){
			?>
                     <div class="row">
                        <div id="content" class="col-md-9">
						<?php
						if (have_posts() ) : 
						while ( have_posts() ) : the_post(); ?>
								 <?php get_template_part('u-event/classic-list'); ?>
					    <?php endwhile;
						endif; ?>
                     	<?php if(function_exists('wp_pagenavi')){
							wp_pagenavi();
						}else{
							cactusthemes_content_nav('paging');
						}?>
                        </div><!--/content-->
                        <?php get_sidebar(); ?>
                     </div><!--/row-->
             <?php }
			 if($event_style=='grid'){
			  get_template_part('u-event/grid-list');
			 }?>
            </div><!--/content-pad-->
        </div><!--/container-->
    </div><!--/body-->
<?php get_footer(); ?>