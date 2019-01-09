<?php
/*
Plugin Name: Divider
Plugin URI: http://www.cactusthemes.com
Description: Divider widget.
Version: 1.0
Author: Cactusthemes
Author URI: http://www.cactusthemes.com
*/
/*  

*/

class Divider_Widget extends WP_Widget {	

	function __construct() {
    	$widget_ops = array(
			'classname'   => 'divider_widget', 
			'description' => __('A divider','cactusthemes')
		);
    	parent::__construct('divider', __('U-Divider','cactusthemes'), $widget_ops);
	}


	function widget($args, $instance) {
		$cache = wp_cache_get('widget_divider', 'widget');		
		if ( !is_array($cache) )
			$cache = array();

		if ( !isset( $argsxx['widget_id'] ) )
			$argsxx['widget_id'] = $this->id;
		if ( isset( $cache[ $argsxx['widget_id'] ] ) ) {
			echo $cache[ $argsxx['widget_id'] ];
			return;
		}

		extract($args);
		
		$title 			= empty($instance['title']) ? '' : $instance['title'];
		$style 		= empty($instance['style']) ? '' : $instance['style'];
		$link 		= empty($instance['link']) ? '#' : $instance['link'];	

        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );        
		
		ob_start();
		echo $before_widget;
		if($style!='empty'){
		?>
        <div class="un-heading un-separator">
            <div class="un-heading-wrap">
                <span class="un-heading-line un-heading-before"><span></span></span>
                <?php if($title!=''){ ?>
                <a href="<?php echo $link ?>" class="btn btn-default <?php echo $style=='big_box'?'btn-lg':'' ?> btn-lighter un-heading-content">
                	<?php echo $title ?> &nbsp;<i class="fa fa-angle-right"></i>
                </a>
                <?php }?>
                <span class="un-heading-line un-heading-after"><span></span></span>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php
		}
		echo $after_widget;
		$output_string = ob_get_contents();
		ob_end_clean();
		echo $output_string;
		
		wp_reset_postdata();
		$cache[$argsxx['widget_id']] = $output_string;
		wp_cache_set('widget_divider', $cache, 'widget');
	}
	
	function flush_widget_cache() {
		wp_cache_delete('widget_divider', 'widget');
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['style'] = esc_attr($new_instance['style']);
		$instance['link'] = esc_attr($new_instance['link']);
		return $instance;
	}
	
	
	
	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$style = isset($instance['style']) ? esc_attr($instance['style']) : '';
		$link = isset($instance['link']) ? esc_attr($instance['link']) : '';
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','cactusthemes'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
        <p><label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link:','cactusthemes'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $link; ?>" /></p>
        <p><label for="<?php echo $this->get_field_id("style"); ?>">
        <?php _e('Style','cactusthemes');	 ?>:
        <select id="<?php echo $this->get_field_id("style"); ?>" name="<?php echo $this->get_field_name("style"); ?>">
          <option value="big_box"<?php selected($style, "big_box" ); ?>>Big Box</option>
          <option value="small_box"<?php selected($style, "small_box" ); ?>>Small Box</option>
          <option value="empty"<?php selected($style, "empty" ); ?>>Empty divider</option>
        </select>
      	</label></p>
<?php
	}
}
// register RecentPostsPlus widget
add_action( 'widgets_init', create_function( '', 'return register_widget("Divider_Widget");' ) );
?>