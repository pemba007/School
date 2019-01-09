<?php
class Widget_Event_Listing extends WP_Widget {	

	function __construct() {
    	$widget_ops = array(
			'classname'   => 'event_listing_widget', 
			'description' => __('University - Events Listing ','cactusthemes')
		);
    	parent::__construct('advanced-latest-event', __('University - Events Listing ','cactusthemes'), $widget_ops);
	}


	function widget($args, $instance) {
		$cache = wp_cache_get('widget_lastest_event', 'widget');		
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
		$tags 			= empty($instance['tags']) ? '' : $instance['tags'];
		$number 		= empty($instance['number']) ? 3 : $instance['number'];
		$sort_by 		= empty($instance['sort_by']) ? '' : $instance['sort_by'];	
		if($ids!=''){
			$ids = explode(",", $ids);
			$gc = array();
			foreach ( $ids as $grid_id ) {
				array_push($gc, $grid_id);
			}
			$args = array(
				'post_type' => 'u_event',
				'posts_per_page' => $number,
				'order' => 'DESC',
				'post_status' => 'publish',
				'post__in' =>  $gc,
				'ignore_sticky_posts' => 1,
			);
		} else {
		  	//tags
		  	if($tags!=''){
				$tags = explode(",",$tags);
				if(is_numeric($tags[0])){$field_tag = 'term_id'; }
				else{ $field_tag = 'slug'; }
				if(count($tags)>1){
					  $texo = array(
						  'relation' => 'OR',
					  );
					  foreach($tags as $iterm) {
						  $texo[] = 
							  array(
								  'taxonomy' => 'u_event_tags',
								  'field' => $field_tag,
								  'terms' => $iterm,
							  );
					  }
				  }else{
					  $texo = array(
						  array(
								  'taxonomy' => 'u_event_tags',
								  'field' => $field_tag,
								  'terms' => $tags,
							  )
					  );
				}
			}
			//cats
			if($cats!=''){
				$cats = explode(",",$cats);
				if(is_numeric($cats[0])){$field = 'term_id'; }
				else{ $field = 'slug'; }
				if(count($cats)>1){
					  $texo = array(
						  'relation' => 'OR',
					  );
					  foreach($cats as $iterm) {
						  $texo[] = 
							  array(
								  'taxonomy' => 'u_event_cat',
								  'field' => $field,
								  'terms' => $iterm,
							  );
					  }
				  }else{
					  $texo = array(
						  array(
								  'taxonomy' => 'u_event_cat',
								  'field' => $field,
								  'terms' => $cats,
							  )
					  );
				}
			}
			
			$args = array(
				'post_type' => 'u_event',
				'posts_per_page' => $number,
				'post_status' => 'publish',
			);
			if(isset($texo)){
				$args += array('tax_query' => $texo);
			}
		}
		$time_now =  strtotime("now");
		if($sort_by=='date'){ $args += array('orderby' => 'date',);}
		else if($sort_by=='upcoming'){
			$args += array('meta_key' => 'u-startdate', 'meta_value' => $time_now, 'meta_compare' => '>','orderby' => 'meta_value_num', 'order' => 'ASC');
		}else if($sort_by=='recent'){
			$args += array('meta_key' => 'u-startdate', 'meta_value' => $time_now, 'meta_compare' => '<','orderby' => 'meta_value_num', 'order' => 'DESC');
		}
		$the_query = new WP_Query( $args );
		$html = $before_widget;
		$html .='<div class="uni-lastest">';
		if ( $title ) $html .= $before_title . $title . $after_title; 
		if($the_query->have_posts()):
			while($the_query->have_posts()): $the_query->the_post();
				$date_format = get_option('date_format');
				$hour_format = get_option('time_format');
				$startdate = get_post_meta(get_the_ID(),'u-startdate', true );
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
					$html .='
					</div>';
				$html .='<div class="clearfix"></div></div>';
			endwhile;
		endif;
		$html .='</div>';
		$html .= $after_widget;
		echo $html;
		wp_reset_postdata();
		$cache[$argsxx['widget_id']] = ob_get_flush();
		wp_cache_set('widget_lastest_event', $cache, 'widget');
	}
	
	function flush_widget_cache() {
		wp_cache_delete('widget_custom_type_posts', 'widget');
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['ids'] = strip_tags($new_instance['ids']);
		$instance['sort_by'] = esc_attr($new_instance['sort_by']);
		$instance['tags'] = strip_tags($new_instance['tags']);
        $instance['cats'] = strip_tags($new_instance['cats']);
		$instance['number'] = absint($new_instance['number']);
		return $instance;
	}
	
	
	
	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$ids = isset($instance['ids']) ? esc_attr($instance['ids']) : '';
		$cats = isset($instance['cats']) ? esc_attr($instance['cats']) : '';
		$tags = isset($instance['tags']) ? esc_attr($instance['tags']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;?>
        
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','cactusthemes'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
      	<!-- /**/-->
        <p>
          <label for="<?php echo $this->get_field_id('ids'); ?>"><?php _e('ID list show:','cactusthemes'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('ids'); ?>" name="<?php echo $this->get_field_name('ids'); ?>" type="text" value="<?php echo $ids; ?>" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('tags'); ?>"><?php _e('Tags:','cactusthemes'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('tags'); ?>" name="<?php echo $this->get_field_name('tags'); ?>" type="text" value="<?php echo $tags; ?>" />
        </p>
      	<!-- /**/-->        
        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts:','cactusthemes'); ?></label>
        <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
		<!--//-->
         <p>
          <label for="<?php echo $this->get_field_id('cats'); ?>"><?php _e('Categories : (ID or Slug. Ex: 1, 2)','cactusthemes'); ?></label> 
          <textarea rows="4" cols="46" id="<?php echo $this->get_field_id('cats'); ?>" name="<?php echo $this->get_field_name('cats'); ?>"><?php echo $cats; ?></textarea>

        </p>
        <p>
        <label for="<?php echo $this->get_field_id("sort_by"); ?>">
        <?php _e('Sort by');	 ?>:
        <select id="<?php echo $this->get_field_id("sort_by"); ?>" name="<?php echo $this->get_field_name("sort_by"); ?>">
          <option value="date"<?php selected( $instance["sort_by"], "date" ); ?>>Published Date </option>
          <option value="upcoming"<?php selected( $instance["sort_by"], "upcoming" ); ?>>Start Date, Upcoming Events </option>
          <option value="recent"<?php selected( $instance["sort_by"], "recent" ); ?>>Start Date, Recent Events </option>
        </select>
        </label>
        </p>
<?php
	}
}

// register widget
add_action( 'widgets_init', create_function( '', 'return register_widget("Widget_Event_Listing");' ) );
?>