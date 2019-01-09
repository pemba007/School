<?php
function parse_u_testimonial($atts, $content=''){
	//get parameter
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$scroll = isset($atts['scroll']) ? $atts['scroll'] : 0;
	$animation_class = '';
	if(isset($atts['css_animation'])){
		$animation_class = $atts['css_animation']?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	}
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	//display
	ob_start(); ?>
		<section class="testimonials testimonials-<?php echo $ID;  echo ' '.$animation_class; ?>" data-delay=<?php echo $animation_delay; ?>>
        	<div class="section-inner">
                <div class="testimonial-carousel owl-carousel is-carousel single-carousel" <?php if($scroll){ ?>data-autoplay=5000<?php } ?> >
                    <?php echo do_shortcode($content); ?>
                </div>
            </div>
        </section><!--/testimonial-->
	<?php
	//return
	$output_string=ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'u_testimonial', 'parse_u_testimonial' );

function parse_u_testimonial_item($atts, $content=''){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$name = isset($atts['name']) ? $atts['name'] : '';
	$title = isset($atts['title']) ? $atts['title'] : '';
	$avatar = isset($atts['avatar']) ? $atts['avatar'] : '';
	ob_start(); ?>
		<div class="carousel-item testimonial-item-<?php echo $ID; ?>">
            <div class="testimonial-item text-center">
                <p class="minion"><?php echo do_shortcode($content); ?></p>
                <div class="media professor">
                	<?php if($avatar){ ?>
                    <div class="pull-left">
                    	<?php $thumbnail = wp_get_attachment_image_src($avatar,'thumbnail', true); ?>
                        <img src="<?php echo $thumbnail[0] ?>" width="50" height="50" alt="<?php echo esc_attr($name) ?>">
                    </div>
                    <?php }?>
                    <div class="media-body">
                        <h6 class="media-heading main-color-2"><?php echo $name ?></h6>
                        <span><?php echo $title ?></span>
                    </div>
                </div>
            </div>
        </div><!--/carousel-item-->
	<?php
	//return
	$output_string=ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'u_testimonial_item', 'parse_u_testimonial_item' );

//Visual Composer
add_action( 'after_setup_theme', 'reg_u_testimonial' );
function reg_u_testimonial(){
	if(function_exists('vc_map')){
		//parent
		vc_map( array(
			"name" => __("Testimonials", "cactusthemes"),
			"base" => "u_testimonial",
			"as_parent" => array('only' => 'u_testimonial_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
			"content_element" => true,
			"show_settings_on_create" => false,
			"icon" => "icon-testimonial",
			"params" => array(
				// add params same as with any other content element
				array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __("Auto Scroll", "cactusthemes"),
					"param_name" => "scroll",
					"value" => array(
						__('No', 'cactusthemes') => '0',
						__('Yes', 'cactusthemes') => '1',
					),
					"description" => __('Auto scroll Testimonials','cactusthemes')
				),
			),
			"js_view" => 'VcColumnView'
		) );
		
		//child
		vc_map( array(
			"name" => __("Testimonial Item", "cactusthemes"),
			"base" => "u_testimonial_item",
			"content_element" => true,
			"as_child" => array('only' => 'u_testimonial_item'), // Use only|except attributes to limit parent (separate multiple values with comma)
			"icon" => "icon-testimonial-item",
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => __("Name", "cactusthemes"),
					"param_name" => "name",
					"value" => "",
					"description" => ""
				),
				array(
					"type" => "textfield",
					"heading" => __("Title", "cactusthemes"),
					"param_name" => "title",
					"value" => "",
					"description" => __("Title of person (Ex: Professor)", "cactusthemes"),
				),
				array(
					"type" => "attach_image",
					"heading" => __("Avatar", "cactusthemes"),
					"param_name" => "avatar",
					"value" => "",
					"description" => __("Avatar of person", "cactusthemes"),
				),
				array(
					"type" => "textarea",
					"heading" => __("Testimonial content", "cactusthemes"),
					"param_name" => "content",
					"value" => "",
					"description" => "",
				),
			)
		) );
		
	}
}
if(class_exists('WPBakeryShortCode') && class_exists('WPBakeryShortCodesContainer')){
class WPBakeryShortCode_u_testimonial extends WPBakeryShortCodesContainer{}
class WPBakeryShortCode_u_testimonial_item extends WPBakeryShortCode{}
}