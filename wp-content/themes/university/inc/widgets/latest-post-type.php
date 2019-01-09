<?php
/*
Plugin Name: Latest post
Plugin URI: http://www.cactusthemes.com
Description: Adds a widget that can display recent posts from multiple categories or from custom post types.
Version: 1.0
Author: Cactusthemes
Author URI: http://www.cactusthemes.com
*/
/*  

*/

class Recent_Posts_Widget extends WP_Widget {	

	function __construct() {
    	$widget_ops = array(
			'classname'   => 'advanced_recent_posts_widget', 
			'description' => __('Latest Posts ','cactusthemes')
		);
    	parent::__construct('advanced-recent-posts', __('University - Latest Posts ','cactusthemes'), $widget_ops);
	}


	function widget($args, $instance) {
		$cache = wp_cache_get('widget_recent_posts', 'widget');		
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
		if($ids!=''){
			$ids = explode(",", $ids);
			$gc = array();
			foreach ( $ids as $grid_id ) {
				array_push($gc, $grid_id);
			}
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => $number,
				'orderby' => 'date',
				'order' => 'DESC',
				'post_status' => 'publish',
				'post__in' =>  $gc,
				'ignore_sticky_posts' => 1,
			);
		} else {
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => $number,
				'orderby' => 'date',
				'order' => 'DESC',
				'post_status' => 'publish',
			);
		}
		if(count($cats) > 0){
			$args += array('category__in' => $cats, 'showposts' => $number);
		}
		if($tags!=''){
			$args += array('tag' => $tags);
		}
		$the_query = new WP_Query( $args );
		$html = $before_widget;
		$html .='<div class="uni-lastest">';
		if ( $title ) $html .= $before_title . $title . $after_title; 
		if($the_query->have_posts()):
			while($the_query->have_posts()): $the_query->the_post();
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
						<h5><a href="'.get_permalink(get_the_ID()).'" title="'.the_title_attribute('echo=0').'" class="main-color-1-hover">'.the_title_attribute('echo=0').'</a></h5>
						<span>'.get_the_time(get_option('date_format'),get_the_ID()).'</span>
					</div>';
				$html .='<div class="clearfix"></div></div>';
			endwhile;
		endif;
		$html .='</div>';
		$html .= $after_widget;
		echo $html;
		wp_reset_postdata();
		$cache[$argsxx['widget_id']] = ob_get_flush();
		wp_cache_set('widget_recent_posts', $cache, 'widget');
	}
	
	function flush_widget_cache() {
		wp_cache_delete('widget_custom_type_posts', 'widget');
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['ids'] = strip_tags($new_instance['ids']);
		$instance['tags'] = strip_tags($new_instance['tags']);
        $instance['cats'] = $new_instance['cats'];
		$instance['number'] = absint($new_instance['number']);
		return $instance;
	}
	
	
	
	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$ids = isset($instance['ids']) ? esc_attr($instance['ids']) : '';
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
            <label for="<?php echo $this->get_field_id('cats'); ?>"><?php _e('Categories:','cactusthemes');?> 
            
                <?php
                   $categories=  get_categories('hide_empty=0');
                     echo "<br/>";
                     foreach ($categories as $cat) {
                         $option='<input type="checkbox" id="'. $this->get_field_id( 'cats' ) .'[]" name="'. $this->get_field_name( 'cats' ) .'[]"';
                            if (is_array($instance['cats'])) {
                                foreach ($instance['cats'] as $cats) {
                                    if($cats==$cat->term_id) {
                                         $option=$option.' checked="checked"';
                                    }
                                }
                            }
                            $option .= ' value="'.$cat->term_id.'" />';
        
                            $option .= $cat->cat_name;
                            
                            $option .= '<br />';
                            echo $option;
                         }
                    
                    ?>
            </label>
        </p>
<?php
	}
}

// register widget
add_action( 'widgets_init', create_function( '', 'return register_widget("Recent_Posts_Widget");' ) );
?>