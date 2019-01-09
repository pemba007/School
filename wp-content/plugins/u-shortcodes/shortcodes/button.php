<?php
function parse_button($atts, $content=''){
	$ID = isset($atts['id']) ? $atts['id'] : rand(1,99999);
	$size = isset($atts['size']) ? $atts['size'] : '';
	$solid = isset($atts['solid']) ? $atts['solid'] : '';
	$link = isset($atts['link']) ? $atts['link'] : '#';

	$arrow = isset($atts['arrow']) ? $atts['arrow'] : (isset($atts['has_arrow']) ? $atts['has_arrow'] : 0);
	$icon = isset($atts['icon']) ? $atts['icon'] : '';
	$color = isset($atts['color']) ? $atts['color'] : '';
	$target = isset($atts['target']) ? $atts['target'] : '';
	$animation_class = '';
	if(isset($atts['css_animation'])){
		$animation_class = $atts['css_animation']?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	}
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	//display
	ob_start(); ?>
    	<a class="btn<?php echo $ID?' button-'.$ID:''; echo $solid?' btn-primary':' btn-default'; echo $size=='big'?' btn-lg':''; echo ' '.$animation_class;  ?>" href="<?php echo $link ?>" data-delay=<?php echo $animation_delay; ?> <?php if($target==1){ ?> target="_blank" <?php }?>>
        <?php
			echo $icon?'<i class="fa '.$icon.'"></i>'.($content?'&nbsp;&nbsp;':''):'';
			echo $content;
			echo $arrow?'&nbsp;&nbsp;<i class="fa fa-angle-right"></i>':'';
		?>
        </a>
        <?php
		if($color && $color!='#'){ ?>
			<style scoped="scoped">
				.button-<?php echo $ID ?>{
					<?php if($solid){ ?>
					background-color: <?php echo $color ?>;
					<?php }else{ ?>
					color: <?php echo $color ?>;
					<?php }?>
					border-color: <?php echo $color ?>
				}
			</style>
		<?php }
	//return
	$output_string=ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'ct_button', 'parse_button' );

add_action( 'after_setup_theme', 'reg_ct_button' );
function reg_ct_button(){
	if(function_exists('vc_map')){
	vc_map( array(
	   "name" => __("University Button",'cactusthemes'),
	   "base" => "ct_button",
	   "class" => "",
	   "icon" => "icon-button",
	   "controls" => "full",
	   "category" => __('Content'),
	   "params" => array(
	   	  array(
			"type" => "textfield",
			"heading" => __("Button Text", "cactusthemes"),
			"param_name" => "content",
			"value" => "",
			"description" => "",
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Button Link", "cactusthemes"),
			"param_name" => "link",
			"value" => "",
			"description" => "",
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Icon", "cactusthemes"),
			"param_name" => "icon",
			"value" => "",
			"description" => __("Font Awesome Icon (ex: fa-apple)", "cactustheme"),
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Open Link in", "cactusthemes"),
			 "param_name" => "target",
			 "value" => array(
			 	__('Curent Tab', 'cactusthemes') => '',
				__('New Tab', 'cactusthemes') => '1',
			 ),
			 "description" => "",
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Button Size", "cactusthemes"),
			 "param_name" => "size",
			 "value" => array(
			 	__('Small', 'cactusthemes') => 'small',
				__('Big', 'cactusthemes') => 'big',
			 ),
			 "description" => "",
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Solid Background", 'cactusthemes'),
			 "param_name" => "solid",
			 "value" => array(
			 	__('No', 'cactusthemes') => 0,
				__('Yes', 'cactusthemes') => 1,
			 ),
			 "description" => '',
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Has arrow?", 'cactusthemes'),
			 "param_name" => "has_arrow",
			 "value" => array(
				__('No', 'cactusthemes') => 0,
				__('Yes', 'cactusthemes') => 1,
			 ),
			 "description" => "",
		  ),
		  array(
			 "type" => "colorpicker",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Button Color", 'cactusthemes'),
			 "param_name" => "color",
			 "value" => '',
			 "description" => '',
		  )
	   )
	));
	}
}
