<?php
global $page_title;
if(is_singular('u_event')){
	$layout_event = get_post_meta(get_the_ID(),'event-layout-header', true );
	if($layout_event=='def' || $layout_event==''){
		if(function_exists('cop_get')){
			$layout_event =  cop_get('u_event_settings','u-event-layout-header');
		} 
	}
}
if(!is_page_template('page-templates/front-page.php')){
	if(is_singular('u_event')&& $layout_event=='feature-image'){
		if ( function_exists('has_post_thumbnail') && has_post_thumbnail(get_the_ID()) ) {
 		$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full'); }
	?>
    <div class="page-heading event-header-image" style="height:400px; background-image:url(<?php echo $thumbnail[0]; ?>); ">
    <div class="over-thumb"></div>
        <div class="container">
                	<div class="center-ct">
                    	<h1><?php echo $page_title ?></h1>
                        <p class="divider-ct"></p>
                        <?php if(has_excerpt( get_the_ID())){ ?>
                        	<p class="description">
                        	<?php echo get_the_excerpt(); ?>
                        	</p>
                        <?php }?>
                    </div>
        </div><!--/container-->
    </div><!--/page-heading-->	
	<?php
	}else {?>
    <div class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    <h1><?php echo $page_title ?></h1>
                </div>
                <?php if(is_active_sidebar('pathway_sidebar')){
                        echo '<div class="pathway pathway-sidebar col-md-4 col-sm-4 hidden-xs text-right">';
                            dynamic_sidebar('pathway_sidebar');
                        echo '</div>';
                    }else{?>
                <div class="pathway col-md-4 col-sm-4 hidden-xs text-right">
                    <?php if(function_exists('un_breadcrumbs')){ un_breadcrumbs(); } ?>
                </div>
                <?php } ?>
            </div><!--/row-->
        </div><!--/container-->
    </div><!--/page-heading-->
<?php }
 }//if not front page ?>

<div class="top-sidebar">
    <div class="container">
        <div class="row">
            <?php
                if ( is_active_sidebar( 'top_sidebar' ) ) :
                    dynamic_sidebar( 'top_sidebar' );
                endif;
             ?>
        </div><!--/row-->
    </div><!--/container-->
</div><!--/Top sidebar-->