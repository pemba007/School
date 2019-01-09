<?php
function parse_u_blog($atts, $content=''){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$title = isset($atts['title']) ? $atts['title'] : '';
	$post_type = isset($atts['post_type']) ? $atts['post_type'] : 'post';
	$cat = isset($atts['cat']) ? $atts['cat'] : '';
	$tag = isset($atts['tag']) ? $atts['tag'] : '';
	$ids = isset($atts['ids']) ? $atts['ids'] : '';
	$count = isset($atts['count']) ? $atts['count'] : 4;
	$order = isset($atts['order']) ? $atts['order'] : 'DESC';
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : 'date';
	$meta_key = isset($atts['meta_key']) ? $atts['meta_key'] : '';
	
	$show_date = isset($atts['show_date']) ? $atts['show_date'] : 1;
	$show_price = isset($atts['show_price']) ? $atts['show_price'] : 0;
	$show_cat_name = isset($atts['show_cat_name']) ? $atts['show_cat_name'] : 0;
	
	$show_comment_count = isset($atts['show_comment_count']) ? $atts['show_comment_count'] : 1;
	$more_text = isset($atts['more_text'])&&$atts['more_text'] ? $atts['more_text'] : __('VISIT BLOG','cactusthemes');
	$more_link = isset($atts['more_link']) ? $atts['more_link'] : '';
	$detail_text = isset($atts['detail_text']) ? $atts['detail_text'] : '';
	$column = isset($atts['column']) ? $atts['column'] : '2';
	
	$animation_class = '';
	if(isset($atts['css_animation'])){
		$animation_class = $atts['css_animation']?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	}
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	//display
	ob_start();
	?>
    	<section class="un-post-listing shortcode-blog-<?php echo $ID;  echo ' '.$animation_class;?>" data-delay=<?php echo $animation_delay; ?>>
            <div class="section-inner">
                <div class="section-header">
                    <?php echo $title?'<h1 class="pull-left main-color-2">'.$title.'</h1>':'' ?>
                    <?php if($more_link){ ?>
                    <a class="btn btn-default btn-lighter pull-right" href="<?php echo $more_link; ?>"><?php echo $more_text; ?> <i class="fa fa-angle-right"></i></a>
                    <?php } ?>
                    <div class="clearfix"></div>
                </div><!--/section-header-->
                <div class="section-body">
                	<div class="row">
                	<?php $the_query = u_shortcode_query($post_type,$cat,$tag,$ids,$count,$order,$orderby,$meta_key);
					if ( $the_query->have_posts() ) {
						$query_count = 0;
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							$query_count++;
							if($post_type == 'u_event'){
								$startdate = get_post_meta(get_the_ID(),'u-startdate', true );
								if($startdate){
									$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
									$con_date = new DateTime($startdate);
									$month = $con_date->format('M');
									$day = $con_date->format('d');
									$start_datetime = $con_date->format(get_option('date_format'));
								}
							}
							if($post_type == 'u_course'){
								$startdate = get_post_meta(get_the_ID(),'u-course-start', true );
								if($startdate){
									$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
									$con_date = new DateTime($startdate);
									$month = $con_date->format('M');
									$day = $con_date->format('d');
									$start_datetime = $con_date->format(get_option('date_format'));
								}
							}
							?>
							<div class="<?php echo $column=='1'?'col-md-12':'col-md-6 col-sm-6 col-xs-12'; ?> shortcode-blog-item">
                                <div class="content-pad">
                                    <div class="post-item row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="content-pad">
                                                <div class="item-thumbnail">
                                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
														<?php if(has_post_thumbnail()){
                                                            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'thumb_526x526', true);
                                                        }else{
                                                            $thumbnail = u_get_default_image('blog-square');
                                                        }?>
                                                        <img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                                                        <?php if($show_date){
															if($post_type =='u_event'){
																if($startdate){?>
                                                        		<span class="thumbnail-overlay"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $startdate ) ); ?></span>
                                                        <?php 	}//if have startdate
															}elseif($post_type =='u_course'){
																if($startdate){?>
                                                        		<span class="thumbnail-overlay"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $startdate ) ); ?></span>
                                                        <?php 	}//if have startdate
															}else{?>
																<span class="thumbnail-overlay"><?php the_time( get_option( 'date_format' ) ); ?></span>
														<?php }}?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="content-pad">
                                                <div class="item-content">
                                                    <h3 class="item-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="main-color-1-hover"><?php the_title(); ?></a></h3>
                                                    <?php
													if($show_price =='1'&&($post_type == 'u_event' || $post_type == 'u_course')){
													?>
                                                    <div class="price main-color-1" style="margin-top:-16px;"><?php 
													$vailable = $price ='';
													if($post_type == 'u_course'){
														if(class_exists('U_course')){
															$u_course = new U_course;
															$price = $u_course->getPrice();
															$getPrice_num = $u_course->getPrice_num_course();
															$vailable = $u_course->getAvailable();
														}
														$product_id = get_post_meta(get_the_ID(),'product_id_course', true );
													}
													if($post_type == 'u_event'){
														if(class_exists('U_event')){
															$u_event = new U_event;
															$price = $u_event->getPrice();
															$getPrice_num = $u_event->getPrice_num();
															$vailable = $u_event->getAvailable();
														}
														$product_id = get_post_meta(get_the_ID(),'product_id', true );
													}
													if($vailable == 'variable'){
														 //print_r($price);
														 _e('From ','cactusthemes');
														 $currency_pos = get_option( 'woocommerce_currency_pos' );
														 if($currency_pos=='left'){ echo get_woocommerce_currency_symbol(); }
														 else if($currency_pos=='left_space'){ echo get_woocommerce_currency_symbol().' '; }
														 echo $getPrice_num;
														 if($currency_pos=='right'){ echo get_woocommerce_currency_symbol(); }
														 else if($currency_pos=='right_space'){ echo ' '.get_woocommerce_currency_symbol(); }
														 //foreach($price as $items => $item){ ?>
															   <span><?php //echo strip_tags($item['price_html']) ?></span>
														 <?php //}
													} 
													else { 
														if(isset($price['number']) && $price['number']!=0){
														   $currency_pos = get_option( 'woocommerce_currency_pos' );
														   if($currency_pos=='left'){ echo get_woocommerce_currency_symbol(); }
														   else if($currency_pos=='left_space'){ echo get_woocommerce_currency_symbol().' '; }
														   echo  ($price['number']); 
														   if($currency_pos=='right'){ echo get_woocommerce_currency_symbol(); }
														   else if($currency_pos=='right_space'){ echo ' '.get_woocommerce_currency_symbol(); }
														}else if(isset($price['text'])){
															 echo $price['text'];
														}
													} ?></div>
                                                    <?php 
													}?>
                                                    <div class="shortcode-blog-excerpt"><?php echo get_the_excerpt(); ?></div>
                                                    <?php 
													if($show_cat_name==1 && $post_type !='post'){
													?>
                                                    <div class="sc-blog-texonomy">
													<?php 
														if($post_type =='u_event'){
															$name_tx = 'u_event_cat';
														}elseif($post_type =='u_course'){
															$name_tx = 'u_course_cat';
														}
                                                        $terms = wp_get_post_terms( get_the_ID(), $name_tx);
                                                        $count = 0; $i=0;
                                                            foreach ($terms as $term) {
                                                                $count ++;
                                                            }
                                                            foreach ($terms as $term) {
                                                                $i++;
                                                                echo '<a href="'.get_term_link($term->slug, $name_tx).'" class="cat-link">'.$term->name.'</a> ';
                                                                if($i!=$count){ echo ', ';}
                                                            }
                                                        ?>                                                    
                                                    </div>
                                                    <?php }?>
                                                    <div class="item-meta">
                                                    	<?php if($detail_text){ ?>
                                                        <a class="btn btn-default btn-lighter" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo $detail_text ?> <i class="fa fa-angle-right"></i></a>
														<?php }?>
                                                        <?php if($show_comment_count && comments_open()){ ?>
                                                        <a href="<?php the_permalink(); ?>#comment" class="main-color-1-hover" title="<?php _e('View comments','cactusthemes'); ?>"><?php comments_number(__('0 COMMENTS','cactusthemes'),__('1 COMMENT','cactusthemes'),__('% COMMENTS','cactusthemes')); ?></a>
														<?php }?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--/post-item-->
                                </div>
                            </div><!--/shortcode-blog-item-->
							<?php
							if($query_count%2==0 && $query_count != $the_query->post_count){ ?>
                            	</div><!--/row-->
                                <div class="row">
							<?php
							}
						}//while have_posts
					}//if have_posts
					wp_reset_postdata();
					?>
                    </div><!--/row-->
                </div><!--/section-body-->
            </div>
        </section><!--/un-blog-listing-->
	<?php
	//return
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'u_blog', 'parse_u_blog' );

add_action( 'after_setup_theme', 'reg_u_blog' );
function reg_u_blog(){
	if(function_exists('vc_map')){
	$map_array = array(
	   "name" => __("Blog"),
	   "base" => "u_blog",
	   "class" => "",
	   "icon" => "icon-blog",
	   "controls" => "full",
	   "category" => __('Content'),
	   "params" => array(
	   	  array(
			"type" => "textfield",
			"heading" => __("Title", "cactusthemes"),
			"param_name" => "title",
			"value" => "",
			"description" => "",
		  ),
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
			"value" => "4",
			"description" => __("Number of posts to show. Default is 4", 'cactusthemes'),
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
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Show Date", 'cactusthemes'),
			 "param_name" => "show_date",
			 "value" => array(
			 	__('Show', 'cactusthemes') => 1,
				__('Hide', 'cactusthemes') => 0,
			 ),
			 "description" => __('Show or hide published date (for post) or start-date (for course, event)', "cactustheme")
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Show Price", 'cactusthemes'),
			 "param_name" => "show_price",
			 "value" => array(
			 	__('Hide', 'cactusthemes') => 0,
			 	__('Show', 'cactusthemes') => 1,
			 ),
			 "description" => ''
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Show Comment Count", 'cactusthemes'),
			 "param_name" => "show_comment_count",
			 "value" => array(
			 	__('Show', 'cactusthemes') => 1,
				__('Hide', 'cactusthemes') => 0,
			 ),
			 "description" => ''
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Show Category name", 'cactusthemes'),
			 "param_name" => "show_cat_name",
			 "value" => array(
			 	__('Hide', 'cactusthemes') => 0,
				__('Show', 'cactusthemes') => 1,
			 ),
			 "description" => ''
		  ),
		  array(
			"type" => "textfield",
			"heading" => __('"More" text', "cactusthemes"),
			"param_name" => "more_text",
			"value" => "",
			"description" => __('Default is "Visit Blog"', "cactustheme"),
		  ),
		  array(
			"type" => "textfield",
			"heading" => __('"More" link', "cactusthemes"),
			"param_name" => "more_link",
			"value" => "",
			"description" => __("If not set, this button is not shown", "cactustheme"),
		  ),
		   array(
			"type" => "textfield",
			"heading" => __('"Detail" text', "cactusthemes"),
			"param_name" => "detail_text",
			"value" => "",
			"description" => __("If not set, this button is not shown", "cactustheme"),
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Columns", 'cactusthemes'),
			 "param_name" => "column",
			 "value" => array(
			 	__('2 Columns', 'cactusthemes') => 2,
				__('1 Columns', 'cactusthemes') => 1,
			 ),
			 "description" => ''
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