<?php
   /*
   Plugin Name: University - Shortcodes
   Plugin URI: http://www.cactusthemes.com
   Description: Shortcodes for University Theme
   Version: 2.0.21
   Author: CactusThemes
   Author URI: http://www.cactusthemes.com
   License: Commercial
   */
   /* Package: University 2.1.3 */
   
if ( ! defined( 'U_SHORTCODE_BASE_FILE' ) )
    define( 'U_SHORTCODE_BASE_FILE', __FILE__ );
if ( ! defined( 'U_SHORTCODE_BASE_DIR' ) )
    define( 'U_SHORTCODE_BASE_DIR', dirname( U_SHORTCODE_BASE_FILE ) );
if ( ! defined( 'U_SHORTCODE_PLUGIN_URL' ) )
    define( 'U_SHORTCODE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/* ================================================================
 *
 * 
 * Class to register shortcode with TinyMCE editor
 *
 * Add to button to tinyMCE editor
 *
 */
class CactusThemeShortcodes{
	
	function __construct()
	{
		add_action('init',array(&$this, 'init'));
	}
	
	function init(){		
		if(is_admin()){
			// CSS for button styling
			wp_enqueue_style("ct_shortcode_admin_style", U_SHORTCODE_PLUGIN_URL . '/shortcodes/shortcodes.css');
		}
		if(!is_admin()){
			wp_enqueue_script( 'format-datetime-master', U_SHORTCODE_PLUGIN_URL . '/shortcodes/calendar-js/format-datetime-master/jquery.formatDateTime.min.js', array('jquery'), '', true );
			wp_enqueue_script( 'underscore-min', U_SHORTCODE_PLUGIN_URL . '/shortcodes/calendar-js/underscore/underscore-min.js', array(), '', true );
			wp_enqueue_script( 'jquery-migrate', U_SHORTCODE_PLUGIN_URL . '/shortcodes/calendar-js/jquery-migrate-1.2.1.min.js', array('jquery'), '', true );
		}
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
	    	return;
		}
	 
		if ( get_user_option('rich_editing') == 'true' ) {
			add_filter( 'mce_external_plugins', array(&$this, 'regplugins'));
			add_filter( 'mce_buttons_3', array(&$this, 'regbtns') );
			
			// remove a button. Used to remove a button created by another plugin
			remove_filter('mce_buttons_3', array(&$this, 'remobtns'));
		}
	}
	
	function remobtns($buttons){
		// add a button to remove
		// array_push($buttons, 'ct_shortcode_collapse');
		return $buttons;	
	}
	
	function regbtns($buttons)
	{
		array_push($buttons, 'shortcode_button_cactus');
		array_push($buttons, 'shortcode_button');
		array_push($buttons, 'shortcode_blog');
		array_push($buttons, 'shortcode_post_carousel');
		array_push($buttons, 'shortcode_post_grid');
		array_push($buttons, 'shortcode_testimonial');
		array_push($buttons, 'shortcode_dropcap');
		array_push($buttons, 'shortcode_textbox');
		array_push($buttons, 'shortcode_course_list');
		array_push($buttons, 'shortcode_member');
		//array_push($buttons, 'shortcode_headline');	
		array_push($buttons, 'shortcode_heading');
		array_push($buttons, 'shortcode_countdown');
		//array_push($buttons, 'shortcode_padding');
		array_push($buttons, 'cactus_compare_table');		
		array_push($buttons, 'shortcode_post_scroller');
		array_push($buttons, 'shortcode_video_banner');		
		return $buttons;
	}
	
	function regplugins($plgs)
	{
		$plgs['shortcode_button_cactus'] = U_SHORTCODE_PLUGIN_URL . 'shortcodes/js/button-shortcode.js';
		$plgs['shortcode_button'] = U_SHORTCODE_PLUGIN_URL . 'shortcodes/js/button.js';
		$plgs['shortcode_blog'] = U_SHORTCODE_PLUGIN_URL . 'shortcodes/js/blog.js';
		$plgs['shortcode_post_carousel'] = U_SHORTCODE_PLUGIN_URL . 'shortcodes/js/post-carousel.js';
		$plgs['shortcode_post_grid'] = U_SHORTCODE_PLUGIN_URL . 'shortcodes/js/post-grid.js';
		$plgs['shortcode_textbox'] = U_SHORTCODE_PLUGIN_URL . 'shortcodes/js/textbox.js';
		$plgs['shortcode_testimonial'] = U_SHORTCODE_PLUGIN_URL . 'shortcodes/js/testimonial.js';
		$plgs['shortcode_dropcap'] = U_SHORTCODE_PLUGIN_URL . 'shortcodes/js/dropcap.js';
		$plgs['shortcode_course_list'] = U_SHORTCODE_PLUGIN_URL . 'shortcodes/js/course-list-table.js';		
		$plgs['shortcode_post_scroller'] = U_SHORTCODE_PLUGIN_URL . 'shortcodes/js/post-scroller.js';
		$plgs['shortcode_member'] = U_SHORTCODE_PLUGIN_URL . 'shortcodes/js/member.js';
		$plgs['shortcode_heading'] = U_SHORTCODE_PLUGIN_URL . 'shortcodes/js/heading.js';
		$plgs['shortcode_countdown'] = U_SHORTCODE_PLUGIN_URL . 'shortcodes/js/shortcode_countdown.js';
		$plgs['shortcode_video_banner'] = U_SHORTCODE_PLUGIN_URL . 'shortcodes/js/video-banner.js';
		$plgs['cactus_compare_table'] = U_SHORTCODE_PLUGIN_URL . 'shortcodes/js/compare-table.js';
		return $plgs;
	}
}

$ctshortcode = new CactusThemeShortcodes();
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); //for check plugin status
// Register element with visual composer and do shortcode

//include('shortcodes/alert.php');
//include('shortcodes/checklist.php');
//include('shortcodes/member.php');
include('shortcodes/textbox.php');
//include('shortcodes/tooltip.php');
//include('shortcodes/headline.php');
include('shortcodes/button.php');
//include('shortcodes/carousel.php');
include('shortcodes/dropcap.php');
//include('shortcodes/padding.php');
include('shortcodes/heading.php');
//include('shortcodes/smart-content.php');
include('shortcodes/testimonial.php');
//include('shortcodes/pricingtables.php');
include('shortcodes/blog.php');
include('shortcodes/countdown_clock.php');
include('shortcodes/post-carousel.php');
include('shortcodes/post-grid.php');
include('shortcodes/post-scroller.php');
include('shortcodes/video-link.php');
include('shortcodes/compare-table.php');
include('shortcodes/price.php');
include('shortcodes/calendar.php');

//add animation param
function un_add_param() {
	if(class_exists('WPBMap')){
		//get default textblock params
		$shortcode_vc_column_text_tmp = WPBMap::getShortCode('vc_column_text');
		//get animation params
		$attributes = array();
		foreach($shortcode_vc_column_text_tmp['params'] as $param){
			if($param['param_name']=='css_animation'){
				$attributes = $param;
				break;
			}
		}
		if(!empty($attributes)){
			//add animation param
			vc_add_param('textbox', $attributes);
			vc_add_param('ct_button', $attributes);
			vc_add_param('u_heading', $attributes);
			vc_add_param('u_testimonial', $attributes);
			vc_add_param('u_blog', $attributes);
			vc_add_param('u_countdown', $attributes);
			vc_add_param('u_post_carousel', $attributes);
			vc_add_param('u_post_grid', $attributes);
			vc_add_param('u_post_scroller', $attributes);
			vc_add_param('u_video_link', $attributes);
		}
		//delay param
		$delay = array(
			'type' => 'textfield',
			'heading' => __("Animation Delay",'cactusthemes'),
			'param_name' => 'animation_delay',
			'description' => __("Enter Animation Delay in second (ex: 1.5)",'cactusthemes')
		);
		vc_add_param('textbox', $delay);
		vc_add_param('ct_button', $delay);
		vc_add_param('u_heading', $delay);
		vc_add_param('u_testimonial', $delay);
		vc_add_param('u_blog', $delay);
		vc_add_param('u_countdown', $delay);
		vc_add_param('u_post_carousel', $delay);
		vc_add_param('u_post_grid', $delay);
		vc_add_param('u_post_scroller', $delay);
		vc_add_param('u_video_link', $delay);
	}
}
add_action('init', 'un_add_param');

//load animation js
function un_animation_scripts_styles() {
	global $wp_styles;
	wp_enqueue_script( 'waypoints' );
}
add_action( 'wp_enqueue_scripts', 'un_animation_scripts_styles' );

//function
if(!function_exists('cactus_hex2rgb')){
	function cactus_hex2rgb($hex) {
	   $hex = str_replace("#", "", $hex);
	
	   if(strlen($hex) == 3) {
		  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
		  $r = hexdec(substr($hex,0,2));
		  $g = hexdec(substr($hex,2,2));
		  $b = hexdec(substr($hex,4,2));
	   }
	   $rgb = array($r, $g, $b);
	   //return implode(",", $rgb); // returns the rgb values separated by commas
	   return $rgb; // returns an array with the rgb values
	}
}
function u_shortcode_query($post_type='post',$cat='',$tag='',$ids='',$count='',$order='',$orderby='',$meta_key='',$custom_args=''){
	$args = array();
	if($custom_args!=''){ //custom array
		$args = $custom_args;
	}elseif($ids!=''){ //specify IDs
		$ids = explode(",", $ids);
		$args = array(
			'post_type' => $post_type,
			'posts_per_page' => $count,
			'order' => $order,
			'orderby' => $orderby,
			'meta_key' => $meta_key,
			'post__in' => $ids,
			'ignore_sticky_posts' => 1,
		);
	}elseif($ids==''){
		$args = array(
			'post_type' => $post_type,
			'posts_per_page' => $count,
			'order' => $order,
			'orderby' => $orderby,
			//'meta_key' => $meta_key,
			'ignore_sticky_posts' => 1,
		);
		if($post_type=='u_course'){
			if(!is_array($cat) && $cat!='') {
				$cats = explode(",",$cat);
				if(is_numeric($cats[0])){
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'u_course_cat',
							'field'    => 'id',
							'terms'    => $cats,
							'operator' => 'IN',
						)
					);
				}else{
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'u_course_cat',
							'field'    => 'slug',
							'terms'    => $cats,
							'operator' => 'IN',
						)
					);
				}
			}elseif(count($cat) > 0 && $cat!=''){
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'u_course_cat',
						'field'    => 'id',
						'terms'    => $cat,
						'operator' => 'IN',
					)
				);
			}
		}elseif($post_type=='u_event'){
			if(!is_array($cat) && $cat!='') {
				$cats = explode(",",$cat);
				if(is_numeric($cats[0])){
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'u_event_cat',
							'field'    => 'id',
							'terms'    => $cats,
							'operator' => 'IN',
						)
					);
				}else{
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'u_event_cat',
							'field'    => 'slug',
							'terms'    => $cats,
							'operator' => 'IN',
						)
					);
				}
			}elseif(count($cat) > 0 && $cat!=''){
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'u_event_cat',
						'field'    => 'id',
						'terms'    => $cat,
						'operator' => 'IN',
					)
				);
			}
			//tag
			if($tag) {
				$tags = explode(",",$tag);
				$args['tax_query'][] = array(
					'taxonomy' => 'u_event_tags',
					'field'    => 'slug',
					'terms'    => $tags,
					'operator' => 'IN',
				);
			}
		}elseif($post_type=='u_project'){
			if(!is_array($cat) && $cat!='') {
				$cats = explode(",",$cat);
				if(is_numeric($cats[0])){
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'u_project_cat',
							'field'    => 'id',
							'terms'    => $cats,
							'operator' => 'IN',
						)
					);
				}else{
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'u_project_cat',
							'field'    => 'slug',
							'terms'    => $cats,
							'operator' => 'IN',
						)
					);
				}
			}elseif(count($cat) > 0 && $cat!=''){
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'u_project_cat',
						'field'    => 'id',
						'terms'    => $cat,
						'operator' => 'IN',
					)
				);
			}
		}else{
			if(!is_array($cat)) {
				$cats = explode(",",$cat);
				if(is_numeric($cats[0])){
					$args['category__in'] = $cats;
				}else{			 
					$args['category_name'] = $cat;
				}
			}elseif(count($cat) > 0){
				$args['category__in'] = $cat;
			}
			$args['tag'] = $tag;
		}
		$time_now =  strtotime("now");
		if($orderby=='upcoming' && $post_type=='u_event'){
			$args += array('meta_key' => 'u-startdate', 'meta_value' => $time_now, 'meta_compare' => '>');
			$args['orderby'] ='meta_value_num';
			if($order==''){$args['order'] ='ASC';}
			//print_r($args);exit;
		}elseif($orderby=='recent' && $post_type=='u_event'){
			$args += array('meta_key' => 'u-startdate', 'meta_value' => $time_now, 'meta_compare' => '<');
			$args['orderby'] ='meta_value_num';
			if($order==''){$args['order'] ='DESC';}
		}
		
		if($orderby=='upcoming' && $post_type=='u_course'){
			$args += array('meta_key' => 'u-course-start', 'meta_value' => $time_now, 'meta_compare' => '>');
			$args['orderby'] ='meta_value_num';
			if($order==''){$args['order'] ='ASC';}
			//print_r($args);exit;
		}elseif($orderby=='recent' && $post_type=='u_course'){
			$args += array('meta_key' => 'u-course-start', 'meta_value' => $time_now, 'meta_compare' => '<');
			$args['orderby'] ='meta_value_num';
			if($order==''){$args['order'] ='DESC';}
		}
		$args += array(
		'meta_key' => $meta_key
		);
	}
	$args['post_status'] = $post_type=='attachment'?'inherit':'publish';
	$args['suppress_filters'] = 0;
	$shortcode_query = new WP_Query($args);
	//echo '<pre>';print_r($shortcode_query);echo'</pre>';
	return $shortcode_query;
}
function calendar_data_json() {	
	if(isset($_GET['cal_json'])&& $_GET['cal_json']==1){
		if (class_exists('SitePress')) {
			global $wpdb,$sitepress;
			if (method_exists($sitepress, 'switch_lang') && $_GET['action_language']!='') {
				$sitepress->switch_lang($_GET['action_language'], true);
			}
		}
        
        $default_time_zone = date_default_timezone_get();
        $dateTimeZoneServer = new DateTimeZone($default_time_zone);
        $dateTimeUTC = new DateTime("now", new DateTimeZone('UTC'));

        $UTCConverGet = $dateTimeZoneServer->getOffset($dateTimeUTC);
            
		$post_type = $_GET['post_type'];
		if($post_type!='u_course'){
			$tag = $_GET['tag'];
			$args = array(
				'post_type' => 'u_event',
				'posts_per_page' => -1,
				'post_status' => 'publish',
				'post__not_in' => array($_GET['exclude']),
				'ignore_sticky_posts' => 1,
			);
			
			$cat = $_GET['cat'];
			$ignore = $_GET['ignore'];
			if((isset($_GET['month-data'])&& isset($_GET['listview'])&& $_GET['listview']==1) || isset($_GET['action_dt_stt'])){
				$month_start = date("Y-m-01", strtotime($_GET['month-data'])) ;
				$month_end = date("Y-m-t", strtotime($month_start));
				if(isset($_GET['action_dt_stt'])){
					$action_dt_stt = $_GET['action_dt_stt'];
					$y_stt = (int)date("Y", strtotime($month_start));
					$yac_stt = (int)date("Y", strtotime($action_dt_stt));
					$year_crr= (int)date("Y");
					//echo $y_stt.''.$yac_stt;
					if($ignore=='upcoming'){
						if( ($action_dt_stt =='none')){
							$mon_stt = (int)date("m", strtotime($month_end));
							//echo $mon_stt;
							$mon_crr= (int)date("m");
							if(($mon_stt < $mon_crr) && ($y_stt <= $year_crr)){
								$month_end=date("Y-m-t", strtotime($month_start)) ;
								//echo $month_start.''.$month_end;
							}else{
								$month_end=date("m/d/Y") ;
							}
						}elseif($action_dt_stt !='none'){
							$mon_stt = (int)date("m", strtotime($month_end));
							//echo $mon_stt;
							$mon_crr= (int)date("m", strtotime($action_dt_stt));
							$mon_cr2= (int)date("m");
							//echo $y_stt.'  '.$yac_stt.' '.$mon_crr ;
							if(($mon_stt < $mon_crr) && ($y_stt <= $yac_stt)){
								$month_end=date("Y-m-t", strtotime($month_start)) ;
								//echo $month_start.''.$month_end;
							}elseif($mon_crr < $mon_cr2 ){
								$month_end=date("m/t/Y", strtotime($action_dt_stt)) ;
							}else{
								$month_end=date("m/d/Y") ;
							}
						}
					}elseif($ignore=='recent'){
						if($action_dt_stt =='none'){
							$mon_stt = (int)date("m", strtotime($month_end));
							$y_stt = (int)date("Y", strtotime($month_end));
							//echo $mon_stt;
							$mon_crr= (int)date("m");
							$year_crr= (int)date("Y");
							//echo $y_stt.' '.$year_crr;
							if(($mon_stt > $mon_crr) || ($y_stt > $year_crr)){
								$month_start=date("Y-m-d", strtotime($month_start)) ;
								//echo $month_start.''.$month_end;
							}else{
								$month_start=date("m/d/Y") ;
							}
						}elseif($action_dt_stt !='none'){
							$y_stt = (int)date("Y", strtotime($month_end));
							$year_crr= (int)date("Y");
							$mon_stt = (int)date("m", strtotime($month_end));
							//echo $mon_stt;
							$mon_crr= (int)date("m", strtotime($action_dt_stt));
							$mon_cr2= (int)date("m");
							if(($mon_stt > $mon_crr) || ($y_stt > $year_crr)){
								$month_start=date("Y-m-d", strtotime($month_start)) ;
								//echo $month_start.''.$month_end;
							}elseif(($mon_crr > $mon_cr2) ){
								$month_start=date("m/01/Y", strtotime($action_dt_stt)) ;
							}else{
								$month_start=date("m/d/Y") ;
							}
							//echo $month_start.''.$month_end;
						}
					}
				}else{
					if($ignore=='upcoming'){ $month_end=date('m/d/Y');}
					elseif($ignore=='recent'){ $month_start=date('m/d/Y');}
				}
				if(!isset($order) || $order==''){$order='DESC';}
				$args += array(
						 'meta_key' => 'u-startdate',
						 'orderby' => 'meta_value_num',
						 'order' => $order,
						 'meta_query' => array(
						 'relation' => 'AND',
						  array('key'  => 'u-enddate',
							   'value' => strtotime($month_start),
							   'compare' => '>='),
						  array('key'  => 'u-startdate',
							   'value' => strtotime($month_end)+86399,
							   'compare' => '<=')
						 )
				);
			}else{
			$time_now =  strtotime("now");
				if($ignore=='recent'){
					if($order==''){$order='ASC';}
					$args += array('meta_key' => 'u-startdate', 'meta_value' => $time_now, 'meta_compare' => '>','orderby' => 'meta_value_num', 'order' => $order);
				}elseif($ignore=='upcoming'){
					if($order==''){$order='DESC';}
					$args += array('meta_key' => 'u-startdate', 'meta_value' => $time_now, 'meta_compare' => '<','orderby' => 'meta_value_num', 'order' => $order);
				}
			}
			if(!is_array($cat) && $cat!='') {
				$cats = explode(",",$cat);
				if(is_numeric($cats[0])){
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'u_event_cat',
							'field'    => 'id',
							'terms'    => $cats,
							'operator' => 'IN',
						)
					);
				}else{
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'u_event_cat',
							'field'    => 'slug',
							'terms'    => $cats,
							'operator' => 'IN',
						)
					);
				}
			}elseif(count($cat) > 0 && $cat!=''){
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'u_event_cat',
						'field'    => 'id',
						'terms'    => $cat,
						'operator' => 'IN',
					)
				);
			}
			//tag
			if($tag) {
				$tags = explode(",",$tag);
				$args['tax_query'][] = array(
					'taxonomy' => 'u_event_tags',
					'field'    => 'slug',
					'terms'    => $tags,
					'operator' => 'IN',
				);
			}
			$the_query = new WP_Query( $args );
			$it = $the_query->post_count;
			$success =0;
			$data_rs = array();
			$rs=array();
			$success = 1;
			$alert = 'null';
			if($the_query->have_posts()){
				$date_format = get_option('date_format');
				$hour_format = get_option('time_format');
				while($the_query->have_posts()){ $the_query->the_post();
					$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'thumb_255x255' );
					$startdate = get_post_meta(get_the_ID(),'u-startdate', true );
					if($startdate){
						$startdate_cal = gmdate("Ymd\THis", $startdate);
						$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
						$con_date = new DateTime($startdate);
						$con_hour = new DateTime($startdate);
						$start_datetime = $con_date->format($date_format);
						$start_hourtime = $con_date->format($hour_format);
					}
					$enddate = get_post_meta(get_the_ID(),'u-enddate', true );
					//$endtime = get_post_meta(get_the_ID(),'endtime_time', true );
					if($enddate){
						$enddate_cal = gmdate("Ymd\THis", $enddate);
						$enddate = gmdate("Y-m-d\TH:i:s\Z", $enddate);
						$conv_enddate = new DateTime($enddate);
						$conv_hourtime = new DateTime($enddate);
						$end_datetime = $conv_enddate->format($date_format);
						$end_hourtime = $conv_enddate->format($hour_format);
					}
					$all_day = get_post_meta(get_the_ID(),'all_day', true );
					if($all_day==1){$start_hourtime = $end_hourtime = '';}
					$color_event = get_post_meta(get_the_ID(),'color_event', true );
					$color_def =array('#ed1c24','#00FF00','#0000FF','#660066','#000000');
					if($color_event==''){$color_event = $color_def[array_rand($color_def)];}
					$ar_rs= array(
						  'id'=> get_the_ID(),
						  'title'=> get_the_title(),
						  'posttype'=> $post_type,
						  'url'=> get_permalink(),
						  'class'=> $color_event,
						  'start'=>get_post_meta(get_the_ID(),'u-startdate', true )*1000 + ($UTCConverGet*60*60*1000),
						  'end'=>get_post_meta(get_the_ID(),'u-enddate', true )*1000 + ($UTCConverGet*60*60*1000),
						  'startDate'=> date_i18n( get_option('date_format'), strtotime($start_datetime)).' '.$start_hourtime,
						  'endDate'=> date_i18n( get_option('date_format'), strtotime($end_datetime)).' '.$end_hourtime,
						  'picture' => $image_src[0],
						  'location' => get_post_meta(get_the_ID(),'u-adress', true ),
						  'buyticket' => get_post_meta(get_the_ID(),'cost', true ),
					  );
					  //array_push($rs,$ar_rs);
					  $rs[]=$ar_rs;
				}
			}else{
				$alert = __('No events for this month','cactusthemes');
			}
			$dis_able ='null';
			if(isset($_GET['action_dt_stt']) && $_GET['action_dt_stt'] !='none' && $ignore !=''){
				$mo_c = strtotime(date("Y-m-t", strtotime($_GET['action_dt_stt'])));
				$mo_data = strtotime(date("Y-m-t", strtotime($_GET['month-data'])));
				$mo_cr= (int)date("m");
				if($ignore=='upcoming' && ($mo_data >= $mo_c)){ $dis_able = 'remo_next';}
				elseif($ignore=='recent'&&($mo_data <= $mo_c)){ $dis_able = 'remo_previous';}
			}elseif(isset($_GET['action_dt_stt']) && $_GET['action_dt_stt'] =='none' && $ignore !=''){
				$mo_c = strtotime(date("Y-m-t"));
				$mo_data = strtotime(date("Y-m-t", strtotime($_GET['month-data'])));
				//echo $mo_data.' '.$mo_c;
				if($ignore=='upcoming' && ($mo_data >= $mo_c)){ $dis_able = 'remo_next';}
				elseif($ignore=='recent'&&($mo_data <= $mo_c)){ $dis_able = 'remo_previous';}
			}
			$data_rs = array(
				'success'=>$success,
				'arrow' =>$dis_able,
				'alert'=> $alert,
				'result'=> $rs,
			);
			//print_r($rs);
			echo str_replace('\/', '/', json_encode($data_rs));
			exit;
		}else{
			if (class_exists('SitePress')) {
				global $wpdb,$sitepress;
				if (method_exists($sitepress, 'switch_lang') && $_GET['action_language']!='') {
					$sitepress->switch_lang($_GET['action_language'], true);
				}
			}
			$tag = $_GET['tag'];
			$args = array(
				'post_type' => 'u_course',
				'posts_per_page' => -1,
				'post_status' => 'publish',
				'post__not_in' => array($_GET['exclude']),
				'ignore_sticky_posts' => 1,
			);

			$cat = $_GET['cat'];
			$ignore = $_GET['ignore'];
			if(isset($_GET['month-data'])&& $_GET['listview']==1){
				$month_start = date("Y-m-01", strtotime($_GET['month-data'])) ;
				$month_end = date("Y-m-t", strtotime($month_start));
				if(isset($_GET['action_dt_stt'])){
					$action_dt_stt = $_GET['action_dt_stt'];
					$y_stt = (int)date("Y", strtotime($month_start));
					$yac_stt = (int)date("Y", strtotime($action_dt_stt));
					$year_crr= (int)date("Y");
					//echo $y_stt.''.$yac_stt;
					if($ignore=='upcoming'){
						if( ($action_dt_stt =='none')){
							$mon_stt = (int)date("m", strtotime($month_end));
							//echo $mon_stt;
							$mon_crr= (int)date("m");
							if(($mon_stt < $mon_crr) && ($y_stt <= $year_crr)){
								$month_end=date("Y-m-t", strtotime($month_start)) ;
								//echo $month_start.''.$month_end;
							}else{
								$month_end=date("m/d/Y") ;
							}
						}elseif($action_dt_stt !='none'){
							$mon_stt = (int)date("m", strtotime($month_end));
							//echo $mon_stt;
							$mon_crr= (int)date("m", strtotime($action_dt_stt));
							$mon_cr2= (int)date("m");
							//echo $y_stt.'  '.$yac_stt.' '.$mon_crr ;
							if(($mon_stt < $mon_crr) && ($y_stt <= $yac_stt)){
								$month_end=date("Y-m-t", strtotime($month_start)) ;
								//echo $month_start.''.$month_end;
							}elseif($mon_crr < $mon_cr2 ){
								$month_end=date("m/t/Y", strtotime($action_dt_stt)) ;
							}else{
								$month_end=date("m/d/Y") ;
							}
						}
					}elseif($ignore=='recent'){
						if($action_dt_stt =='none'){
							$mon_stt = (int)date("m", strtotime($month_end));
							$y_stt = (int)date("Y", strtotime($month_end));
							//echo $mon_stt;
							$mon_crr= (int)date("m");
							$year_crr= (int)date("Y");
							//echo $y_stt.' '.$year_crr;
							if(($mon_stt > $mon_crr) || ($y_stt > $year_crr)){
								$month_start=date("Y-m-d", strtotime($month_start)) ;
								//echo $month_start.''.$month_end;
							}else{
								$month_start=date("m/d/Y") ;
							}
						}elseif($action_dt_stt !='none'){
							$y_stt = (int)date("Y", strtotime($month_end));
							$year_crr= (int)date("Y");
							$mon_stt = (int)date("m", strtotime($month_end));
							//echo $mon_stt;
							$mon_crr= (int)date("m", strtotime($action_dt_stt));
							$mon_cr2= (int)date("m");
							if(($mon_stt > $mon_crr) || ($y_stt > $year_crr)){
								$month_start=date("Y-m-d", strtotime($month_start)) ;
								//echo $month_start.''.$month_end;
							}elseif(($mon_crr > $mon_cr2) ){
								$month_start=date("m/01/Y", strtotime($action_dt_stt)) ;
							}else{
								$month_start=date("m/d/Y") ;
							}
							//echo $month_start.''.$month_end;
						}
					}
				}else{
					if($ignore=='upcoming'){ $month_end=date('m/d/Y');}
					elseif($ignore=='recent'){ $month_start=date('m/d/Y');}
				}
				if($order==''){$order='DESC';}
				$args += array(
						 'meta_key' => 'u-course-start',
						 'orderby' => 'meta_value_num',
						 'order' => $order,
						 'meta_query' => array(
						 'relation' => 'AND',
						  array('key'  => 'u-course-start',
							   'value' => strtotime($month_start),
							   'compare' => '>='),
						  array('key'  => 'u-course-start',
							   'value' => strtotime($month_end)+86399,
							   'compare' => '<=')
						 )
				);
			}else{
			$time_now =  strtotime("now");
				if($ignore=='recent'){
					if($order==''){$order='ASC';}
					$args += array('meta_key' => 'u-course-start', 'meta_value' => $time_now, 'meta_compare' => '>','orderby' => 'meta_value_num', 'order' => $order);
				}elseif($ignore=='upcoming'){
					if($order==''){$order='DESC';}
					$args += array('meta_key' => 'u-course-start', 'meta_value' => $time_now, 'meta_compare' => '<','orderby' => 'meta_value_num', 'order' => $order);
				}
			}
			if(!is_array($cat) && $cat!='') {
				$cats = explode(",",$cat);
				if(is_numeric($cats[0])){
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'u_course_cat',
							'field'    => 'id',
							'terms'    => $cats,
							'operator' => 'IN',
						)
					);
				}else{
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'u_course_cat',
							'field'    => 'slug',
							'terms'    => $cats,
							'operator' => 'IN',
						)
					);
				}
			}elseif(count($cat) > 0 && $cat!=''){
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'u_course_cat',
						'field'    => 'id',
						'terms'    => $cat,
						'operator' => 'IN',
					)
				);
			}
			$the_query = new WP_Query( $args );
			$it = $the_query->post_count;
			$success =0;
			$data_rs = array();
			$rs=array();
			$success = 1;
			$alert = 'null';
			if($the_query->have_posts()){
				$date_format = get_option('date_format');
				$hour_format = get_option('time_format');
				while($the_query->have_posts()){ $the_query->the_post();
					$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'thumb_255x255' );
					$startdate = get_post_meta(get_the_ID(),'u-course-start', true );
					if($startdate){
						$startdate_cal = gmdate("Ymd\THis", $startdate);
						$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
						$con_date = new DateTime($startdate);
						$con_hour = new DateTime($startdate);
						$start_datetime = $con_date->format($date_format);
						$start_hourtime = $con_date->format($hour_format);
					}
					$enddate = get_post_meta(get_the_ID(),'u-course-start', true );
					//$endtime = get_post_meta(get_the_ID(),'endtime_time', true );
					if($enddate){
						$enddate_cal = gmdate("Ymd\THis", $enddate);
						$enddate = gmdate("Y-m-d\TH:i:s\Z", $enddate);
						$conv_enddate = new DateTime($enddate);
						$conv_hourtime = new DateTime($enddate);
						$end_datetime = $conv_enddate->format($date_format);
						$end_hourtime = $conv_enddate->format($hour_format);
					}
					$color_event = get_post_meta(get_the_ID(),'color_event', true );
					$color_def =array('#ed1c24','#00FF00','#0000FF','#660066','#000000');
					if($color_event==''){$color_event = $color_def[array_rand($color_def)];}
					$ar_rs= array(
						  'id'=> get_the_ID(),
						  'title'=> get_the_title(),
						  'posttype'=> $post_type,
						  'url'=> get_permalink(),
						  'class'=> $color_event,
						  'start'=>get_post_meta(get_the_ID(),'u-course-start', true )*1000 + ($UTCConverGet*60*60*1000),
						  'end'=>get_post_meta(get_the_ID(),'u-course-start', true )*1000 + ($UTCConverGet*60*60*1000),
						  'startDate'=> date_i18n( get_option('date_format'), strtotime($start_datetime)),
						  'endDate'=> date_i18n( get_option('date_format'), strtotime($end_datetime)),
						  'picture' => $image_src[0],
						  'location' => get_post_meta(get_the_ID(),'u-course-addr', true ),
						  'buyticket' => '',
					  );
					  //array_push($rs,$ar_rs);
					  $rs[]=$ar_rs;
				}
			}else{
				$alert = __('No course for this month','cactusthemes');
			}
			$dis_able ='null';
			if(isset($_GET['action_dt_stt']) && $_GET['action_dt_stt'] !='none' && $ignore !=''){
				$mo_c = strtotime(date("Y-m-t", strtotime($_GET['action_dt_stt'])));
				$mo_data = strtotime(date("Y-m-t", strtotime($_GET['month-data'])));
				$mo_cr= (int)date("m");
				if($ignore=='upcoming' && ($mo_data >= $mo_c)){ $dis_able = 'remo_next';}
				elseif($ignore=='recent'&&($mo_data <= $mo_c)){ $dis_able = 'remo_previous';}
			}elseif(isset($_GET['action_dt_stt']) && $_GET['action_dt_stt'] =='none' && $ignore !=''){
				$mo_c = strtotime(date("Y-m-t"));
				$mo_data = strtotime(date("Y-m-t", strtotime($_GET['month-data'])));
				//echo $mo_data.' '.$mo_c;
				if($ignore=='upcoming' && ($mo_data >= $mo_c)){ $dis_able = 'remo_next';}
				elseif($ignore=='recent'&&($mo_data <= $mo_c)){ $dis_able = 'remo_previous';}
			}
			$data_rs = array(
				'success'=>$success,
				'arrow' =>$dis_able,
				'alert' =>$alert,
				'result'=> $rs,
			);
			//print_r($rs);
			echo str_replace('\/', '/', json_encode($data_rs));
			exit;			
		}
	}
		
}
add_action( 'wp_ajax_calendar_data', 'calendar_data_json' );
add_action( 'wp_ajax_nopriv_calendar_data', 'calendar_data_json' );
