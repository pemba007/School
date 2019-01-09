<?php
class Widget_Course_Search extends WP_Widget {	

	function __construct() {
    	$widget_ops = array(
			'classname'   => 'course_search_widget', 
			'description' => __('University - Courses Search ','cactusthemes')
		);
    	parent::__construct('course-search-widget', __('University - Courses Search ','cactusthemes'), $widget_ops);
	}


	function widget($args, $instance) {
		$cache = wp_cache_get('widget_course_search', 'widget');		
		if ( !is_array($cache) )
			$cache = array();

		if ( !isset( $argsxx['widget_id'] ) )
			$argsxx['widget_id'] = $this->id;
		if ( isset( $cache[ $argsxx['widget_id'] ] ) ) {
			echo $cache[ $argsxx['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);
		
		$ids 			= empty($instance['ids']) ? '' : $instance['ids'];
		$title 			= empty($instance['title']) ? '' : $instance['title'];
		$title          = apply_filters('widget_title', $title);
		$cats 			= empty($instance['cats']) ? '' : $instance['cats'];

		
		$args = array(
			'hide_empty'        => false, 
			'include'           => explode(",",$cats)
		); 
		
		$terms = get_terms('u_course_cat', $args);
		
		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title; ?>
        
        <form role="search" method="get" id="searchform" class="u-course-search-form" action="<?php echo home_url(); ?>/">
        	<div class="input-group">
            
            <?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){ ?>
              <div class="input-group-btn u-course-search-dropdown">
                <button name="u_course_cat" type="button" class="btn btn-default dropdown-toggle u-course-search-dropdown-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="button-label"><?php esc_html_e('All','cactusthemes'); ?></span> <span class="fa fa-angle-down"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="#" data-value=""><?php esc_html_e('All','cactusthemes'); ?></a></li>
                  <?php 
				  foreach ( $terms as $term ) {
				  	echo '<li><a href="#" data-value="'. $term->slug .'">'. $term->name .'</a></li>';
				  }
				  ?>
                </ul>
              </div><!-- /btn-group -->
            <?php } //if have terms ?>
            
              <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" placeholder="<?php esc_html_e('SEARCH','cactusthemes'); ?>" class="form-control" />
              <input type="hidden" name="post_type" value="u_course" />
              <input type="hidden" name="u_course_cat" class="u-course-search-cat" value="" />
              <span class="input-group-btn">
              	<button type="submit" id="searchsubmit" class="btn btn-default u-course-search-submit" ><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <script>
		jQuery(document).ready(function(e) {
            jQuery(".u-course-search-dropdown").on('click', 'li a', function(){
			  jQuery(".u-course-search-dropdown-button .button-label").html(jQuery(this).text());
			  jQuery(".u-course-search-cat").val(jQuery(this).data('value'));
			  jQuery(".u-course-search-dropdown").removeClass('open');
			  return false;
			});
        });
		</script>
        <?php
		echo $after_widget;
		
		$cache[$argsxx['widget_id']] = ob_get_flush();
		wp_cache_set('widget_lastest_course', $cache, 'widget');
	}
	
	function flush_widget_cache() {
		wp_cache_delete('widget_custom_type_posts', 'widget');
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
        $instance['cats'] = strip_tags($new_instance['cats']);
		return $instance;
	}
	
	
	
	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$cats = isset($instance['cats']) ? esc_attr($instance['cats']) : '';?>
        
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','cactusthemes'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
      	<!-- /**/-->
        <p>
          <label for="<?php echo $this->get_field_id('cats'); ?>"><?php _e('Included Categories (IDs. Ex: 68, 86)','cactusthemes'); ?></label> 
          <textarea rows="4" cols="46" id="<?php echo $this->get_field_id('cats'); ?>" name="<?php echo $this->get_field_name('cats'); ?>"><?php echo $cats; ?></textarea>
        </p>
<?php
	}
}

// register widget
add_action( 'widgets_init', create_function( '', 'return register_widget("Widget_Course_Search");' ) );

function u_course_search_result(){
			
			$args = array(
				'post_type' => 'u_course',
				'posts_per_page' => $number,
				'post_status' => 'publish',
			);
			
		$time_now =  strtotime("now");
		if($sort_by=='date'){ $args += array('orderby' => 'date',);}
		else if($sort_by=='upcoming'){
			$args += array('meta_key' => 'u-course-start', 'meta_value' => $time_now, 'meta_compare' => '>','orderby' => 'meta_value_num', 'order' => 'ASC');
		}else if($sort_by=='recent'){
			$args += array('meta_key' => 'u-course-start', 'meta_value' => $time_now, 'meta_compare' => '<','orderby' => 'meta_value_num', 'order' => 'DESC');
		}
		$the_query = new WP_Query( $args );
	$html .='<div class="uni-lastest">';
		if ( $title ) $html .= $before_title . $title . $after_title; 
		if($the_query->have_posts()):
			while($the_query->have_posts()): $the_query->the_post();
				$date_format = get_option('date_format');
				$hour_format = get_option('time_format');
				$startdate = get_post_meta(get_the_ID(),'u-course-start', true );
				if($startdate){
					$startdate_cal = gmdate("Ymd\THis\Z", $startdate);
					$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
					$con_date = new DateTime($startdate);
					$con_hour = new DateTime($startdate);
					$start_datetime = $con_date->format($date_format);
					$start_hourtime = $con_date->format($hour_format);
				}
				$html .='<div class="item">';
					if(has_post_thumbnail(get_the_ID())){
						$html .='<div class="thumb item-thumbnail">
							<a href="'.get_permalink(get_the_ID()).'" title="'.the_title_attribute('echo=0').'">
								<div class="item-thumbnail">
									'.get_the_post_thumbnail(get_the_ID(),'thumb_80x80').'
									<div class="thumbnail-hoverlay main-color-1-bg"></div>
									<div class="thumbnail-hoverlay-cross"></div>
								</div>
							</a>
						</div>';
					}
					$html .='<div class="u-details item-content">
						<h5><a href="'.get_permalink(get_the_ID()).'" title="'.the_title_attribute('echo=0').'" class="main-color-1-hover">'.the_title_attribute('echo=0').'</a></h5>';
						if($startdate){
							$html .='<span>'.date_i18n( get_option('date_format'), strtotime($startdate)).'</span>';
						}
					$html .='</div>';
				$html .='<div class="clearfix"></div></div>';
			endwhile;
		endif;
		$html .='</div>';
}
function u_search_course_filter($query) {
	if ( !is_admin() && $query->is_main_query() ) {
		$post_type = @$_GET['post_type'];
		if ($query->is_search && $post_type == 'u_course') {
			// do something
		}
	}
	
    return $query;
};

add_filter('pre_get_posts','u_search_course_filter');
