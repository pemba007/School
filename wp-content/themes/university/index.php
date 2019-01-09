<?php 
$layout = ot_get_option('archive_sidebar','right');

get_header();
?>
	<?php get_template_part( 'header', 'heading' ); ?>
    <div id="body">
    	<div class="container">
        	<div class="content-pad-3x">
                <div class="row">
                    <div id="content" class="<?php echo $layout!='full'?'col-md-9':'col-md-12' ?><?php echo ($layout == 'left') ? " revert-layout":"";?>">
                        <div class="blog-listing">
                        <?php 
						if(is_tax('u_event_cat')){
							ct_filter_order_lis();
							if(function_exists('cop_get')){
								$slug_pt =  cop_get('u_event_settings','uevent-slug');
								$filter =  cop_get('u_event_settings','uevent-filter');
							}  
							if($slug_pt==''){
								$slug_pt = 'event';
							}
							if($filter==1){
								ct_filter_bar($taxono='u_event_cat',$slug_pt);
								?>
                                <style type="text/css">
								.uni-orderbar{ margin-bottom:40px}
                                @media (max-width: 768px){
									.project-listing{ float:none}
								}
                                </style>
                                <?php
							}
						}
						?>
                        	<?php
							// The Loop
							while ( have_posts() ) : the_post();
								get_template_part('loop','item');
							endwhile;
							?>
                        </div>
                        <?php if(function_exists('wp_pagenavi')){
							wp_pagenavi();
						}else{
							cactusthemes_content_nav('paging');
						}?>
                    </div><!--/content-->
                    <?php if($layout != 'full'){get_sidebar();} ?>
                </div><!--/row-->
            </div><!--/content-pad-->
        </div><!--/container-->
    </div><!--/body-->
<?php get_footer(); ?>