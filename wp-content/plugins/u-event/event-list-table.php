<?php
function parse_u_event_list($atts, $content){
	$number = isset($atts['count']) ? $atts['count'] : '-1';
	$ids = isset($atts['ids']) ? $atts['ids'] : '';
	$cat = isset($atts['cat']) ? $atts['cat'] : '';
	$order = isset($atts['order']) ? $atts['order'] : 'ASC';
	$orderby = isset($atts['orderby']) ? $atts['orderby'] : 'title';
	ob_start(); ?>
    <?php 
		if($ids != ''){ //specify IDs
			$ids = explode(",", $ids);
			$args = array(
				'post_type' => 'u_event',
				'post_status' => 'publish',
				'orderby' => 'post__in',
				'post__in' => $ids,
				'ignore_sticky_posts' => 1,
			);
		}else{
			if($cat!=''){
				$cat = explode(",",$cat);
				if(is_numeric($cat[0])){
					$field = 'term_id';
				}else{			 
					$field = 'slug';
				}
			}
			$args = array(
				'post_type' => 'u_event',
				'posts_per_page' => $number,
				'orderby' => $orderby,
				'order' => $order,
				'post_status' => 'publish',
			);
			if($orderby =='meta_value_num'){
				$args += array(
					'meta_key' => 'u-startdate',
				);
			}
			$time_now =  strtotime("now");
			if($orderby == 'upcoming'){
				$args += array('meta_key' => 'u-startdate', 'meta_value' => $time_now, 'meta_compare' => '>');
				$args['orderby'] ='meta_value_num';
				if($order==''){$args['order'] ='ASC';}
			}
			if($cat!=''){
				$args += array(
					'tax_query' => array(
						array(
							'taxonomy' => 'u_event_cat',
							'field' => $field,
							'terms' => $cat 
						)
					)
				);
			}
		}
		
		$args = apply_filters('u_event_list_table_shortcode_args', $args, $atts);
		
		global $the_query;
		$date_format = get_option('date_format');
		$the_query = new WP_Query( $args ); ?>
        <div class="courses-list">
         <?php if ( $the_query->have_posts() ) : ?>
         <table class="table course-list-table">
          <thead class="main-color-1-bg dark-div">
            <tr>
              <th><?php _e('ID','cactusthemes'); ?></th>
              <th><?php _e('Event Name','cactusthemes'); ?></th>
              <th><?php _e('Start Date','cactusthemes'); ?></th>
              <th><?php _e('End Date','cactusthemes'); ?></th>
            </tr>
          </thead>
          <tbody>                          
          <?php
            while ( $the_query->have_posts() ) : $the_query->the_post(); 
            $startdate = get_post_meta(get_the_ID(),'u-startdate', true );
            if($startdate){
                $startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
                $con_date = new DateTime($startdate);
                $start_datetime = $con_date->format($date_format);
            }
			$enddate = get_post_meta(get_the_ID(),'u-enddate', true );
			if($enddate){
                $enddate = gmdate("Y-m-d\TH:i:s\Z", $enddate);// convert date ux
                $con_date = new DateTime($enddate);
                $end_datetime = $con_date->format($date_format);
            }
			
             ?>
                <tr>
                  <td><a href="<?php echo get_permalink(); ?>"><?php echo get_post_meta(get_the_ID(),'u-eventid', true ); ?></a></td>
                  <td><a href="<?php echo get_permalink(); ?>"><?php the_title() ?></a></td>
                  <td><?php if($startdate){ echo date_i18n( get_option('date_format'), strtotime($startdate)); } ?></td>
				  <td><?php if($enddate){ echo date_i18n( get_option('date_format'), strtotime($enddate)); } ?></td>
                </tr>
            <?php endwhile; ?>
          <?php endif;
          wp_reset_postdata(); ?>
          </tbody>
        </table>
        </div><!--/courses-list-->
    <?php
	//return
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'u_event_list', 'parse_u_event_list' );
add_action( 'after_setup_theme', 'reg_u_event_list' );
function reg_u_event_list(){
	if(function_exists('vc_map')){
		/* Register shortcode with Visual Composer */
		vc_map( array(
		   "name" => __("Events List table",'cactusthemes'),
		   "base" => "u_event_list",
		   "class" => "",
		   "controls" => "full",
		   "category" => 'Content',
		   "icon" => "icon-course-list",
		   "params" => array(
			  array(
				 "type" => "textfield",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Number of item", 'cactusthemes'),
				 "param_name" => "count",
				 "value" =>"",
				 "description" => '',
			  ),
			  array(
				 "type" => "textfield",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("IDs", 'cactusthemes'),
				 "param_name" => "ids",
				 "value" =>"",
				 "description" => __("Specify post IDs to retrieve", "cactustheme"),
			  ),
			  array(
				 "type" => "dropdown",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Order", 'cactusthemes'),
				 "param_name" => "order",
				 "value" => array(
				 	__('ASC', 'cactusthemes') => 'ASC',
					__('DESC', 'cactusthemes') => 'DESC',
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
				 	__('Title', 'cactusthemes') => 'title',
					__('Publish Date', 'cactusthemes') => 'date',
					__('Start Date', 'cactusthemes') => 'meta_value_num',
					__('Start Date, Upcoming Events', 'cactusthemes') => 'upcoming',
				 ),
				 "description" => ''
			  ),

			  array(
				"type" => "exploded_textarea",
				"heading" => __("Categories", "cactusthemes"),
				"param_name" => "cat",
				"value" => "",
				"description" => __("Fill slug or ID of categories. Ex: 12, 13", "cactusthemes"),
			  ),
		   )
		) );
	}
}