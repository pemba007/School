<?php
function parse_u_heading($atts, $content){
	$ID = isset($atts['ID']) ? $atts['ID'] : 'heading_'.rand(10,9999);
	$url = isset($atts['url']) ? $atts['url'] : '';
	$animation_class = '';
	if(isset($atts['css_animation'])){
		$animation_class = $atts['css_animation']?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	}
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	//display
	ob_start(); ?>
    <div class="un-heading <?php echo 'un-heading-'.$ID; echo ' '.$animation_class; ?>" data-delay=<?php echo $animation_delay; ?>>
    	<div class="un-heading-wrap">
            <span class="un-heading-line un-heading-before"><span></span></span>
            <?php if($url){ ?>
                <a href='<?php echo $url ?>' class='btn btn-default btn-lg btn-lighter un-heading-content'>
            <?php }else{ ?>
                <span class='btn btn-default btn-lg btn-lighter un-heading-content'>
            <?php }?>
                <?php echo $content ?>
            <?php if($url){ ?>
            	&nbsp;<i class="fa fa-angle-right"></i>
                </a>
            <?php }else{ ?>
                </span>
            <?php }?>
            <span class="un-heading-line un-heading-after"><span></span></span>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php
	//return
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'u_heading', 'parse_u_heading' );
add_action( 'after_setup_theme', 'reg_u_heading' );
function reg_u_heading(){
	if(function_exists('vc_map')){
		/* Register shortcode with Visual Composer */
		vc_map( array(
		   "name" => __("Heading",'cactusthemes'),
		   "base" => "u_heading",
		   "class" => "",
		   "controls" => "full",
		   "category" => 'Content',
		   "icon" => "icon-heading",
		   "params" => array(
			  array(
				 "type" => "textfield",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Heading text", 'cactusthemes'),
				 "param_name" => "content",
				 "value" => __("Heading text", 'cactusthemes'),
				 "description" => '',
			  ),
			  array(
				"type" => "textfield",
				"heading" => __("Heading URL", "cactusthemes"),
				"param_name" => "url",
				"value" => "",
				"description" => __("Optional", "cactusthemes"),
			  ),
		   )
		) );
	}
}