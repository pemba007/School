<?php
/**
 * The sidebar containing the main widget area.
 */
?>
<div id="sidebar" class="col-md-3 normal-sidebar">
<div class="row">
<?php 
if(is_front_page() && is_active_sidebar('frontpage_sidebar')){
	dynamic_sidebar( 'frontpage_sidebar' );
}elseif(is_category()||is_home()&&!is_front_page()){
	$cat_id = get_query_var('cat');
	$style = get_option("cat_layout_$cat_id")?get_option("cat_layout_$cat_id"):ot_get_option('blog_style','video');
	if($style=='video'&&is_active_sidebar('video_listing_sidebar')){
		dynamic_sidebar( 'video_listing_sidebar' );
	}elseif($style=='blog'&&is_active_sidebar('blog_sidebar')){
		dynamic_sidebar( 'blog_sidebar' );
	}elseif(is_active_sidebar('main_sidebar')){
		dynamic_sidebar( 'main_sidebar' );
	}
}elseif(is_active_sidebar('u_event_sidebar')&&is_singular('u_event') || is_active_sidebar('u_event_sidebar')&&is_post_type_archive( 'u_event' )){
	dynamic_sidebar( 'u_event_sidebar' );	
}elseif(is_active_sidebar('u_course_sidebar')&&is_singular('u_course') || is_active_sidebar('u_course_sidebar')&&is_post_type_archive( 'u_course' )){
	dynamic_sidebar( 'u_course_sidebar' );	
}elseif(is_active_sidebar('woocommerce_sidebar') && function_exists('is_woocommerce') && is_woocommerce()){
	dynamic_sidebar( 'woocommerce_sidebar' );
}elseif(is_active_sidebar('main_sidebar')){
	dynamic_sidebar( 'main_sidebar' );
}
?>
</div>
</div><!--#sidebar-->
