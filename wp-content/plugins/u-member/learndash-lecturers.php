<?php
function parse_learndash_member_list($atts, $content){
	$id 			= isset($atts['id']) && $atts['id'] != '' ? $atts['id'] : get_the_ID();	
	ob_start();
	?>
	<div class="event-speaker learndash-lecturers">
        <?php 
		$member_id = get_post_meta($id,'learndash_member_id', true );
		if(is_array($member_id)){?>
        <h5 class="small-text"><?php _e('INSTRUCTORS:','cactusthemes') ?></h5>
        <div class="row">        
        <?php
		foreach($member_id as $item){
			//echo $item;
		?>                
        		<div class="col-md-6 col-sm-6">
                    <div class="media professor">
                        <div class="pull-left">
                            <a href="<?php echo get_permalink($item); ?>" class="main-color-2"><?php echo get_the_post_thumbnail( $item, 'thumb_50x50' ); ?></a>
                        </div>
                        <div class="media-body">
                            <h6 class="media-heading main-color-2"><a class="main-color-2" href="<?php echo get_permalink($item); ?>"><?php echo get_the_title($item); ?></a></h6>
                            <span><?php echo get_post_meta($item,'u-member-pos', true ); ?></span>
                        </div>
                    </div>
                </div>
           <?php }?>
		   </div>
		   <?php }?> 
        </div>
	<?php
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;

}
add_shortcode( 'learndash-lecturers', 'parse_learndash_member_list' );
add_action( 'after_setup_theme', 'reg_learndash_member_list' );
function reg_learndash_member_list(){
	if(function_exists('vc_map')){
		/* Register shortcode with Visual Composer */
		vc_map( array(
		   "name" => __("Learndash Lecturers",'cactusthemes'),
		   "base" => "learndash-lecturers",
		   "class" => "",
		   "controls" => "full",
		   "category" => 'Content',
		   "icon" => "icon-member",
		   "params" => array(
			  array(
				 "type" => "textfield",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Id", 'cactusthemes'),
				 "param_name" => "id",
				 "value" =>"",
				 "description" => __("", "cactusthemes"),
			  ),
		   )
		) );
	}
}