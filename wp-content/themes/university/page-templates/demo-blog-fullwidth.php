<?php 
/*
 * Template Name: Demo Blog Full Width
 */
$layout = 'full';
get_header();
?>
	<?php get_template_part( 'header', 'heading' ); ?>
    <div id="body">
    	<div class="container">
        	<div class="content-pad-3x">
                <div class="row">
                    <div id="content" class="<?php echo $layout!='full'?'col-md-9':'col-md-12' ?><?php echo ($layout == 'left') ? " revert-layout":"";?>">
                	<?php
					$paged = get_query_var('paged')?get_query_var('paged'):1;
					$args=array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'paged' => $paged
					);
					$listing_query = null;
					$listing_query = new WP_Query($args);?>
                        <div class="blog-listing">
                        	<?php
							// The Loop
							if($listing_query->have_posts()):
								while($listing_query->have_posts()): $listing_query->the_post();
									get_template_part('loop','item');
								endwhile;
							endif;
							?>
                        </div>
                        <?php
						//$pagination = ot_get_option('pagination_style');
						//if($pagination=='page_navi'){
							wp_pagenavi(array( 'query' => $listing_query ));
						//}else{
							//cactusthemes_content_nav('paging');
						//}
						?>
                    </div><!--/content-->
                    <?php if($layout != 'full'){get_sidebar();} ?>
                </div><!--/row-->
            </div><!--/content-pad-->
        </div><!--/container-->
    </div><!--/body-->
<?php get_footer(); ?>