<?php
function parse_textbox($atts, $content=''){
	$icon = isset($atts['icon']) ? $atts['icon'] : '';
	$heading = isset($atts['heading']) ? $atts['heading'] : '';
	$link = isset($atts['link']) ? $atts['link'] : '';
	$layout = isset($atts['layout']) ? $atts['layout'] : 'left';
	$target = isset($atts['target']) ? $atts['target'] : '';
	$schema = isset($atts['schema']) ? $atts['schema'] : '';
	$icon_background_color = isset($atts['icon_background_color']) ? $atts['icon_background_color'] : '';
	$icon_background_hover = isset($atts['icon_background_hover']) ? $atts['icon_background_hover'] : '';
	$heading_color = isset($atts['heading_color']) ? $atts['heading_color'] : '';
	$content_color = isset($atts['content_color']) ? $atts['content_color'] : '';
	
	$animation_class = '';
	if(isset($atts['css_animation'])){
		$animation_class = $atts['css_animation']?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	}
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	global $textbox_ID;
	if(!$textbox_ID){
		$textbox_ID = 1;
	}else{
		$textbox_ID++;
	}
	$op_l = '';
	if($target==1){ $op_l = 'target="_blank"';}
	if($link){ $heading = '<a href="'.$link.'" '.$op_l.'>'.$heading.'</a>';}
	//display
	ob_start(); ?>
    	<div id="un-icon-box-<?php echo $textbox_ID ?>" class="media un-icon-box <?php echo $schema; echo $schema=='dark'?' dark-div':''; echo ' '.$animation_class; ?>" data-delay=<?php echo $animation_delay; ?>>
            <div class="<?php echo $layout=='right'?'pull-right':($layout=='center'?'text-center':'pull-left') ?>">
            	<?php if($icon){ ?>
                <div class="un-icon">
                	<i class="fa <?php echo $icon; ?>"></i>
                </div>
                <?php } ?>
            </div>
            <div class="media-body <?php echo $layout=='right'?'text-right':($layout=='center'?'text-center':'') ?>">
                <?php
				echo $heading?'<h4 class="media-heading">'.$heading.'</h4>':'';
				echo $content?'<p>'.$content.'</p>':''
				?>
            </div>
        </div>
	<?php
	if($icon_background_color || $icon_background_hover || $heading_color || $content_color){ ?>
		<style scoped="scoped">
        <?php
        if($icon_background_color){ echo '#un-icon-box-'.$textbox_ID.' .un-icon{ background: '.$icon_background_color.'}'; }
        if($icon_background_hover){ echo '#un-icon-box-'.$textbox_ID.' .un-icon:hover{ background: '.$icon_background_hover.'}'; }
        if($heading_color){ echo '#un-icon-box-'.$textbox_ID.' .media-heading{ color: '.$heading_color.'}'; }
        if($content_color){ echo '#un-icon-box-'.$textbox_ID.' .media-body p{ color: '.$content_color.'}'; }
        ?>
        </style>
    <?php }
	
	//return
	$output_string=ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'textbox', 'parse_textbox' );

add_action( 'after_setup_theme', 'reg_textbox' );
function reg_textbox(){
	if(function_exists('vc_map')){
	vc_map( array(
	   "name" => __("Textbox"),
	   "base" => "textbox",
	   "class" => "",
	   "icon" => "textbox-icon",
	   "controls" => "full",
	   "category" => __('Content'),
	   "params" => array(
	      array(
			"type" => "textfield",
			"heading" => __("Icon", "cactusthemes"),
			"param_name" => "icon",
			"value" => "",
			"description" => __("FontAwesome 4.0+ icon name. For example: fa-star."),
		  ),
		  array(
			"type" => "textfield",
			"heading" => __("Link in title", "cactusthemes"),
			"param_name" => "link",
			"value" => "",
			"description" => '',
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
			"type" => "textfield",
			"heading" => __("Heading", "cactusthemes"),
			"param_name" => "heading",
			"value" => "",
			"description" => __("Heading text"),
		  ),
		  array(
			"type" => "textarea",
			"heading" => __("Content text", "cactusthemes"),
			"param_name" => "content",
			"value" => "",
			"description" => __("Content text"),
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Layout", 'cactusthemes'),
			 "param_name" => "layout",
			 "value" => array(
			 	__('Left', 'cactusthemes') => 'left',
				__('Right', 'cactusthemes') => 'right',
				__('Center', 'cactusthemes') => 'center',
			 ),
			 "description" => 'Choose icon layout'
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Schema", 'cactusthemes'),
			 "param_name" => "schema",
			 "value" => array(
			 	__('Default', 'cactusthemes') => '',
			 	__('Light', 'cactusthemes') => 'light',
				__('Dark', 'cactusthemes') => 'dark',
			 ),
			 "description" => 'Choose icon schema'
		  ),
		  array(
			 "type" => "colorpicker",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Icon Background Color", 'cactusthemes'),
			 "param_name" => "icon_background_color",
			 "value" => '',
			 "description" => 'Choose Icon Background Color (Optional)',
		  ),
		  array(
			 "type" => "colorpicker",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Icon Background Hover", 'cactusthemes'),
			 "param_name" => "icon_background_hover",
			 "value" => '',
			 "description" => 'Choose Icon Background when hovered (Optional)',
		  ),
		  array(
			 "type" => "colorpicker",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Heading Color", 'cactusthemes'),
			 "param_name" => "heading_color",
			 "value" => '',
			 "description" => 'Choose Heading Color (Optional)',
		  ),
		  array(
			 "type" => "colorpicker",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Content color", 'cactusthemes'),
			 "param_name" => "content_color",
			 "value" => '',
			 "description" => 'Choose Content color (Optional)',
		  )
	   )
	));
	}
}
