<?php
function parse_u_countdown($atts, $content){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$year 		= isset($atts['year']) ? $atts['year'] : 2014;
	$month 		= isset($atts['month']) ? $atts['month'] : 1;
	$day 		= isset($atts['day']) ? $atts['day'] : 1;
	$hour 		= isset($atts['hour']) ? $atts['hour'] : 0;
	$minute		= isset($atts['minute']) ? $atts['minute'] : 0;
	$show_second= isset($atts['show_second']) ? $atts['show_second'] : 1;
	$bg_color	= isset($atts['bg_color']) ? $atts['bg_color'] : '';
	$num_color	= isset($atts['num_color']) ? $atts['num_color'] : '';
	$animation_class = '';
	if(isset($atts['css_animation'])){
		$animation_class = $atts['css_animation']?'wpb_'.$atts['css_animation'].' wpb_animate_when_almost_visible':'';
	}
	$animation_delay = isset($atts['animation_delay']) ? $atts['animation_delay'] : 0;
	//display
	wp_enqueue_script( 'final-countdown', get_template_directory_uri() . '/js/jquery.countdown.min.js', array('jquery'), '', true );
	ob_start(); ?>
    <div class="u_countdown u_countdown-<?php echo $ID; echo ' '.$animation_class; ?>" data-countdown="<?php echo $year.'/'.$month.'/'.$day.' '.$hour.':'.$minute.':00' ?>" data-daylabel='<?php _e('Days','cactustheme') ?>' data-hourlabel='<?php _e('Hrs','cactustheme') ?>' data-minutelabel='<?php _e('Mins','cactustheme') ?>' data-secondlabel='<?php _e('Secs','cactustheme') ?>' data-showsecond='<?php echo $show_second ?>' data-delay=<?php echo $animation_delay; ?>></div>
    <?php if(($bg_color&&$bg_color!='#') || $num_color){ ?>
    <style scoped="scoped">
		<?php if($bg_color&&$bg_color!='#'){?>
		.u_countdown-<?php echo $ID; ?> .countdown-number{
			background-color:<?php echo $bg_color ?>
		}
		.u_countdown-<?php echo $ID; ?> .countdown-label{
			color:<?php echo $bg_color ?>
		}
		<?php }
		if($num_color){ ?>
		.u_countdown-<?php echo $ID; ?> .countdown-number{
			color:<?php echo $num_color ?>
		}
		<?php }?>
	</style>
	<?php
	}
	//return
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'u_countdown', 'parse_u_countdown' );



/* Register shortcode with Visual Composer */

add_action( 'after_setup_theme', 'reg_u_countdown' );
function reg_u_countdown(){
	if(function_exists('vc_map')){
	$current_year = date("Y");
	$years = array();
	for($i=0; $i<15; $i++){
		$years[$current_year+$i] = ($current_year+$i);
	}
	$months = array();
	for($i=1; $i<=12; $i++){
		$months[date("F", mktime(0, 0, 0, $i, 10))] = $i;
	}
	$days = array();
	for($i=1; $i<=31; $i++){
		$days[$i] = $i;
	}
	$hours = array();
	for($i=0; $i<=23; $i++){
		$hours[$i] = $i;
	}
	$minutes = array();
	for($i=0; $i<=59; $i++){
		$minutes[$i] = $i;
	}
	vc_map( array(
	   "name" => __("Countdown"),
	   "base" => "u_countdown",
	   "class" => "",
	   "icon" => "icon-countdown",
	   "controls" => "full",
	   "category" => __('Content'),
	   "params" => array(
	   	  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Year:", 'cactusthemes'),
			 "param_name" => "year",
			 "value" => $years,
			 "description" => ''
		  ),	  
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Month", 'cactusthemes'),
			 "param_name" => "month",
			 "value" => $months,
			 "description" => ''
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Day", 'cactusthemes'),
			 "param_name" => "day",
			 "value" => $days,
			 "description" => ''
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Hour", 'cactusthemes'),
			 "param_name" => "hour",
			 "value" => $hours,
			 "description" => ''
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Minute", 'cactusthemes'),
			 "param_name" => "minute",
			 "value" => $minutes,
			 "description" => ''
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Show Second?", "cactusthemes"),
			 "param_name" => "show_second",
			 "value" => array(
			 	__('Yes', 'cactusthemes') => '1',
				__('No', 'cactusthemes') => '0',
			 ),
			 "description" => __('Choose post type','cactusthemes')
		  ),
		  array(
			 "type" => "colorpicker",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Background Color", 'cactusthemes'),
			 "param_name" => "bg_color",
			 "value" => '',
			 "description" => ''
		  ),
		  array(
			 "type" => "colorpicker",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Number Color", 'cactusthemes'),
			 "param_name" => "num_color",
			 "value" => '',
			 "description" => ''
		  ),
	   )
	));
	}
}