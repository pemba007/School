<?php 
global $global_page_layout;
$single_page_layout = get_post_meta(get_the_ID(),'sidebar_layout',true);
$content_padding = get_post_meta(get_the_ID(),'content_padding',true);
$layout = $single_page_layout ? $single_page_layout : ($global_page_layout ? $global_page_layout : ot_get_option('page_layout','right'));
$global_page_layout = $layout;
get_header();
$page_content = get_post_meta(get_the_ID(),'page_content',true);
?>
	<?php get_template_part( 'header', 'heading' ); ?>    
    <div id="body" <?php if($page_content=='blog'){?> class="frontpage-blogcontent" <?php }?>>
    	<?php if($layout!='true-full' || $page_content=='blog'){ ?>
    	<div class="container">
        <?php }?>
        	<?php if($content_padding!='off'){ ?>
        	<div class="content-pad-3x">
            <?php }?>
                <div class="row">
                    <div id="content" class="<?php echo ($layout != 'full' && $layout != 'true-full')?'col-md-9':'col-md-12' ?><?php echo ($layout == 'left') ? " revert-layout":"";?>" role="main">
                        <article class="single-page-content">
                        	<?php
							// The Loop
							if($page_content!='blog'){
								while ( have_posts() ) : the_post();
									the_content();
								endwhile;
								wp_reset_postdata();
							}else{
								$post_tags_ct = get_post_meta(get_the_ID(),'post_tags_ct',true);
								$order_by_ct = get_post_meta(get_the_ID(),'order_by_ct',true);
								$post_id_ct = get_post_meta(get_the_ID(),'post_id_ct',true);
								$cat = get_post_meta(get_the_ID(),'post_categories_ct',true);
								$paged = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
								if($post_id_ct!=''){ //specify IDs
									$post_id_ct = explode(",", $post_id_ct);
									$args = array(
										'posts_per_page'=> get_option('posts_per_page'),
										'paged'=>$paged,
										'orderby' => $order_by_ct,
										'post__in' => $post_id_ct,
										'ignore_sticky_posts' => 1,
									);
								}elseif($post_id_ct==''){
									$args = array(
										'posts_per_page'=> get_option('posts_per_page'),
										'paged'=>$paged,
										'orderby' => $order_by_ct,
										'tag' => $post_tags_ct,
										'ignore_sticky_posts' => 1,
									);
									if(!is_array($cat)) {
										$cats = explode(",",$cat);
										if(is_numeric($cats[0])){
											$args['category__in'] = $cats;
										}else{			 
											$args['category_name'] = $cat;
										}
									}elseif(count($cat) > 0){
										$args['category__in'] = $cat;
									}
								}
								$listing_query = null;
								$listing_query = new WP_Query($args);?>
									<div class="blog-listing">
										<?php
										// The Loop
										if($listing_query->have_posts()):
											while($listing_query->have_posts()): $listing_query->the_post();
												get_template_part('loop','item');
											endwhile;
											wp_reset_postdata();
										endif;
										?>
									</div>
									<?php
								if(function_exists('wp_pagenavi')){
									wp_pagenavi(array( 'query' => $listing_query ));
								}else{
									cactusthemes_content_nav('paging');
								}
							}
							?>
                        </article>
                    </div><!--/content-->
                    <?php if($layout != 'full' && $layout != 'true-full'){get_sidebar();} ?>
                </div><!--/row-->
            <?php if($content_padding!='off'){ ?>
            </div><!--/content-pad-3x-->
            <?php }?>
        <?php if($layout!='true-full' || $page_content=='blog'){ ?>
        </div><!--/container-->
        <?php }?>
    </div><!--/body-->
<?php get_footer(); ?>