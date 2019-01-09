<?php
function parse_u_post_scroller($atts, $content=''){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$post_type = isset($atts['post_type']) ? $atts['post_type'] : 'post';
	$cat = isset($atts['cat']) ? $atts['cat'] : '';
	$tag = isset($atts['tag']) ? $atts['tag'] : '';
	$ids = isset($atts['ids']) ? $atts['ids'] : '';
	$count = isset($atts['count']) ? $atts['count'] : 8;
	$order = isset($atts['order']) ? $atts['order'] : 'DESC';
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : 'date';
	$meta_key = isset($atts['meta_key']) ? $atts['meta_key'] : '';
	
	//$visible = isset($atts['visible']) ? $atts['visible'] : 4;
	$link_text = isset($atts['link_text']) ? $atts['link_text'] : __('MORE NEWS','cactusthemes');
	$link_url = isset($atts['link_url']) ? $atts['link_url'] : '';
	$animation_class = '';
	if(isset($atts['css_animation'])){
		$animation_class = $atts['css_animation']?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	}
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	//display
	ob_start();
	?>
    	<section class="un-post-scroller un-post-scroller-<?php echo $ID; echo ' '.$animation_class; ?>" data-delay=<?php echo $animation_delay; ?>>
        	<div class="section-inner-no-padding">
                <div class="post-scroller-wrap">
                    <div class="post-scroller-carousel" data-next='.post-scroller-down' data-prev='.post-scroller-up'>
                    <div class="post-scroller-carousel-inner">
                    <?php $the_query = u_shortcode_query($post_type,$cat,$tag,$ids,$count,$order,$orderby,$meta_key);
					if ( $the_query->have_posts() ) {
						while ( $the_query->have_posts() ) { $the_query->the_post(); ?>
                        <div class="post-scroller-item">
                        	<div class="scroller-item-inner">
                            	<div class="scroller-item-content post-item-mini">
                                	<div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-4 post-thumbnail-mini">
                                        	<div class="item-thumbnail">
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                                <?php $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'thumbnail', true); ?>
                                                <img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                                                <div class="thumbnail-hoverlay main-color-1-bg"></div>
												<div class="thumbnail-hoverlay-cross"></div>
                                            </a>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xs-8 post-content-mini">
                                            <h4><a class="post-title-mini main-color-1-hover" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
                                            <div class="post-excerpt-mini"><?php echo get_the_excerpt() ?></div>
                                        </div>
                                    </div>
                                </div><!--/post-item-mini-->
                            </div>
                        </div><!--/post-scroller-item-->
                    <?php
						}//while have_posts
					}//if have_posts
					wp_reset_postdata();
					?>
                    </div>
                    </div>
                    <div class="post-scroller-control">
                        <span class="post-scroller-button-wrap">
                        	<a class="btn btn-primary post-scroller-button post-scroller-down" href="#"><i class="fa fa-angle-down"></i></a>
                        	<a class="btn btn-primary post-scroller-button post-scroller-up" href="#"> <i class="fa fa-angle-up"></i></a>
                        </span>
                        <?php if($link_url){ ?>
                    	<a class="post-scroller-more" href="<?php echo $link_url; ?>"><?php echo $link_text; ?> &nbsp;<i class="fa fa-angle-right"></i></a>
                        <?php }?>
                    </div>
                </div>
            </div><!--/section-inner-->
        </section><!--/u-post-carousel-->
	<?php
	//return
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'u_post_scroller', 'parse_u_post_scroller' );

add_action( 'after_setup_theme', 'reg_u_post_scroller' );
function reg_u_post_scroller(){
	if(function_exists('vc_map')){
	$map_array = array(
	   "name" => __("Post Scroller"),
	   "base" => "u_post_scroller",
	   "class" => "",
	   "icon" => "icon-post-scroller",
	   "controls" => "full",
	   "category" => __('Content'),
	   "params" => array(
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Post Type", "cactusthemes"),
			 "param_name" => "post_type",
			 "value" => array(
			 	__('Post', 'cactusthemes') => 'post',
				__('Event', 'cactusthemes') => 'u_event',
				__('Course', 'cactusthemes') => 'u_course',
				__('Project', 'cactusthemes') => 'u_project',
			 ),
			 "description" => __('Choose post type','cactusthemes')
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Category", "cactusthemes"),
			"param_name" => "cat",
			"value" => "",
			"description" => __("List of cat ID (or slug), separated by a comma", "cactustheme"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Tags", "cactusthemes"),
			"param_name" => "tag",
			"value" => "",
			"description" => __("list of tags, separated by a comma", "cactustheme"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("IDs", "cactusthemes"),
			"param_name" => "ids",
			"value" => "",
			"description" => __("Specify post IDs to retrieve", "cactustheme"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Count", "cactusthemes"),
			"param_name" => "count",
			"value" => "8",
			"description" => __("Number of posts to show. Default is 8", 'cactusthemes'),
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Order", 'cactusthemes'),
			 "param_name" => "order",
			 "value" => array(
			 	__('DESC', 'cactusthemes') => 'DESC',
				__('ASC', 'cactusthemes') => 'ASC',
			 ),
			 "description" => ''
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Order by", 'cactusthemes'),
			 "param_name" => "orderby",
			 "value" => array(
			 	__('Date', 'cactusthemes') => 'date',
				__('ID', 'cactusthemes') => 'ID',
				__('Author', 'cactusthemes') => 'author',
			 	__('Title', 'cactusthemes') => 'title',
				__('Name', 'cactusthemes') => 'name',
				__('Modified', 'cactusthemes') => 'modified',
			 	__('Parent', 'cactusthemes') => 'parent',
				__('Random', 'cactusthemes') => 'rand',
				__('Comment count', 'cactusthemes') => 'comment_count',
				__('Menu order', 'cactusthemes') => 'menu_order',
				__('Meta value', 'cactusthemes') => 'meta_value',
				__('Meta value num', 'cactusthemes') => 'meta_value_num',
				__('Post__in', 'cactusthemes') => 'post__in',
				__('None', 'cactusthemes') => 'none',
			 ),
			 "description" => ''
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Meta key", "cactusthemes"),
			"param_name" => "meta_key",
			"value" => "",
			"description" => __("Name of meta key for ordering", "cactustheme"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => __('"More" text', "cactusthemes"),
			"param_name" => "link_text",
			"value" => "",
			"description" => __('Default is "MORE NEWS"', "cactustheme"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => __('"More" link', "cactusthemes"),
			"param_name" => "link_url",
			"value" => "",
			"description" => __("If not set, this button is not shown", "cactustheme"),
		  ),
	   )
	);
	if ( class_exists('SFWD_LMS') ) {
		foreach($map_array['params'] as $key => $param){
			if($param['param_name'] == 'post_type'){
				$map_array['params'][$key]['value'][__('LearnDash Course', 'cactusthemes')]='sfwd-courses';
			}
		}
	}
	vc_map($map_array);
	}
}