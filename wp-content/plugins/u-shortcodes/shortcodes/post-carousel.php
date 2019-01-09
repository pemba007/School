<?php
function parse_u_post_carousel($atts, $content=''){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$post_type = isset($atts['post_type']) ? $atts['post_type'] : 'post';
	$cat = isset($atts['cat']) ? $atts['cat'] : '';
	$tag = isset($atts['tag']) ? $atts['tag'] : '';
	$ids = isset($atts['ids']) ? $atts['ids'] : '';
	$count = isset($atts['count']) ? $atts['count'] : 8;
	$order = isset($atts['order']) ? $atts['order'] : 'DESC';
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : 'date';
	$meta_key = isset($atts['meta_key']) ? $atts['meta_key'] : '';
	
	$visible = isset($atts['visible']) ? $atts['visible'] : 4;
	$show_date = isset($atts['show_date']) ? $atts['show_date'] : 1;
	$show_price = isset($atts['show_price']) ? $atts['show_price'] : 1;
	$show_venue = isset($atts['show_venue']) ? $atts['show_venue'] : 1;
	$show_time = isset($atts['show_time']) ? $atts['show_time'] : 1;
	$animation_class = '';
	if(isset($atts['css_animation'])){
		$animation_class = $atts['css_animation']?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	}
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	//display
	ob_start();
	?>
    	<section class="un-post-carousel un-post-carousel-<?php echo $ID; echo ' '.$animation_class; ?>" data-delay=<?php echo $animation_delay; ?>>
        	<div class="section-inner">
                <div class="post-carousel-wrap">
                    <div class="is-carousel carousel-has-control <?php echo (!$show_venue&&!$show_time)?'no-overlay-bottom':'' ?>" data-items=<?php echo $visible ?> data-navigation=1>
                    <?php $the_query = u_shortcode_query($post_type,$cat,$tag,$ids,$count,$order,$orderby,$meta_key);
					if ( $the_query->have_posts() ) {
						while ( $the_query->have_posts() ) { $the_query->the_post(); ?>
                        <div class="post-carousel-item grid-item">
                        	<div class="grid-item-inner">
                            	<div class="grid-item-content event-item dark-div">
                                	<div class="event-thumbnail">
                                    	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                        	<?php if(has_post_thumbnail()){
												$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'thumb_554x674', true);
											}else{
												$thumbnail = u_get_default_image('grid');
											}?>
                                            <img src="<?php echo $thumbnail[0] ?>" width="<?php echo $thumbnail[1] ?>" height="<?php echo $thumbnail[2] ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                                        </a>
                                    </div>
                                    <?php
									if($post_type == 'u_event'){
										$startdate = get_post_meta(get_the_ID(),'u-startdate', true );
										$all_day = get_post_meta(get_the_ID(),'all_day', true );
										if($startdate){
											$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
											$con_date = new DateTime($startdate);
											$month = $con_date->format('M');
											$day = $con_date->format('d');
											$year = $con_date->format('YY');
											$start_datetime = $con_date->format(get_option('time_format'));
										}
										if(class_exists('U_event')){
											$u_event = new U_event;
											$price = $u_event->getPrice();
											$getPrice_num = $u_event->getPrice_num();
											$vailable = $u_event->getAvailable();
											global  $woocommerce;
										}
									}
									if($post_type == 'u_course'){
										$startdate = get_post_meta(get_the_ID(),'u-course-start', true );
										if($startdate){
											$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
											$con_date = new DateTime($startdate);
											$month = $con_date->format('M');
											$day = $con_date->format('d');
											$year = $con_date->format('YY');
											$start_datetime = $con_date->format(get_option('time_format'));
										}
									}
									if($show_date){
										$datetime_format = ot_get_option('shortcode_datetime_format','MM/DD');
										$year_class = '';
										$day_class = '';
										if($datetime_format=='MM/DD/YYYY' || $datetime_format=='DD/MM/YYYY'){
											$year_class = 'has-year year-bottom';
										}elseif($datetime_format=='YYYY/MM/DD' || $datetime_format=='YYYY/DD/MM'){
											$year_class = 'has-year year-top';
										}
										if($datetime_format=='MM/DD/YYYY' || $datetime_format=='YYYY/MM/DD' || $datetime_format=='MM/DD'){
											$day_class = 'day-bottom';
										}elseif($datetime_format=='DD/MM/YYYY' || $datetime_format=='YYYY/DD/MM' || $datetime_format=='DD/MM'){
											$day_class = 'day-top';
										}
										if($post_type == 'u_event' || $post_type == 'u_course'){ ?>
                                        <div class="date-block <?php echo $year_class ?>">
                                        	<?php if($year_class){ echo '<div class="year">'.date_i18n( 'Y', strtotime( $startdate ) ).'</div>'; } ?>
                                            <?php if($day_class == 'day-top'){ ?><div class="day"><?php echo $day; ?></div><?php } ?>
                                            <div class="month"><?php echo date_i18n( 'M', strtotime( $startdate ) ); ?></div>
                                            <?php if($day_class == 'day-bottom'){ ?><div class="day"><?php echo $day; ?></div><?php } ?>
                                        </div>
                                        <?php }else if($post_type != 'u_course'){ ?>
                                        <div class="date-block <?php echo $date_class ?>">
                                        	<?php if($year_class){ ?><div class="year"><?php the_time( 'Y' ); ?></div><?php } ?>
                                            <?php if($day_class == 'day-top'){ ?><div class="day"><?php the_time( 'd' ); ?></div><?php } ?>
                                            <div class="month"><?php the_time( 'M' ); ?></div>
                                            <?php if($day_class == 'day-bottom'){ ?><div class="day"><?php the_time( 'd' ); ?></div><?php } ?>
                                        </div>
                                    <?php } 
									}//if show date ?>
                                    <div class="event-overlay">
                                        <a class="overlay-top" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                            <h4><?php the_title(); ?></h4>
                                            <?php if($show_price && ($post_type=='u_event' ||  $post_type=='u_course')){ ?>
                                            <span class="price yellow">
											<?php 
												$vailable = $price ='';
												if(class_exists('U_course') && $post_type=='u_course'){
													$u_course = new U_course;
													$price = $u_course->getPrice();
													$getPrice_num = $u_course->getPrice_num_course();
													$vailable = $u_course->getAvailable();
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
												} ?></span>
                                            <?php }elseif($show_price && $post_type=='sfwd-courses'){
												$meta = get_post_meta( get_the_ID(), '_sfwd-courses', true );
												$option = learndash_get_option("sfwd-courses");
												?>
												<span class="price yellow">
													<?php echo $meta['sfwd-courses_course_price']==''?__('Free','cactusthemes'):$meta['sfwd-courses_course_price'].' '.$option['paypal_currency']; ?>
                                                </span>
											<?php }//if show price?>
                                        </a>
                                        <div class="overlay-bottom">
                                        	<?php if($post_type != 'u_course' && $post_type != 'post' ){ ?>
												<?php if($show_time){
													if($post_type == 'u_event'){ 
														if($all_day!=1){?>
                                                			<div><?php _e('At ','cactusthemes'); echo $start_datetime; ?></div>
                                                        <?php }?>
                                                    <?php }else {?>
                                                    	<div><?php _e('At ','cactusthemes'); the_time( get_option( 'time_format' ) ); ?></div>
                                                    <?php }?>
                                                <?php } ?>
                                                <?php if($show_venue){?>
                                                <div><?php echo ($post_type=='' || $post_type=='post')?__('By ','cactusthemes').get_the_author():get_post_meta(get_the_ID(),'u-adress', true ); ?></div>
                                                <?php }?>
                                            <?php } else {?>
                                            	<div class="course-exceprt"><?php echo wp_trim_words(get_the_excerpt(),9,$more = '');?></div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div><!--/event-item-->
                            </div>
                        </div><!--/post-carousel-item-->
                    <?php
						}//while have_posts
					}//if have_posts
					wp_reset_postdata();
					?>
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
add_shortcode( 'u_post_carousel', 'parse_u_post_carousel' );

add_action( 'after_setup_theme', 'reg_u_post_carousel' );
function reg_u_post_carousel(){
	if(function_exists('vc_map')){
	$map_array = array(
	   "name" => __("Post Carousel"),
	   "base" => "u_post_carousel",
	   "class" => "",
	   "icon" => "icon-post-carousel",
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
			"type" => "textfield",
			"heading" => __("Visible items", "cactusthemes"),
			"param_name" => "visible",
			"value" => "4",
			"description" => __("Number of items visible in Carousel. Default is 4", 'cactusthemes'),
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
				__('Start Date, Upcoming Events or Course', 'cactusthemes') => 'upcoming',
				__('Start Date, Recent Events or Course', 'cactusthemes') => 'recent',
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
			 "description" => __('Show date info. With standard posts, this is Published Date. With Event and Course, this is Start Date', "cactustheme")
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Show Price", 'cactusthemes'),
			 "param_name" => "show_price",
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
			 "heading" => __("Show Venue", 'cactusthemes'),
			 "param_name" => "show_venue",
			 "value" => array(
			 	__('Show', 'cactusthemes') => 1,
				__('Hide', 'cactusthemes') => 0,
			 ),
			 "description" => __('Show Venue with Event & Course post type, or Show Author for Standard post','cactusthemes')
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Show Time", 'cactusthemes'),
			 "param_name" => "show_time",
			 "value" => array(
			 	__('Show', 'cactusthemes') => 1,
				__('Hide', 'cactusthemes') => 0,
			 ),
			 "description" => __('Show start time. Only works with Event & Course post type','cactusthemes')
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