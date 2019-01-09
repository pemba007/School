<?php

/**
 * Get template part (for templates like the stores-loop).
 *
 * @access public
 * @param mixed $slug
 * @param string $name (default: '')
 * @return void
 */
if(!function_exists('course_edit_columns')) {
	function course_edit_columns( $columns ) {
		$columns = array(
			'cb' 			=> '<input type="checkbox" />',
			'id' 			=> __( 'ID', 'cactusthemes' ),
			'title' 		=> __( 'Title', 'cactusthemes' ),
			'course_start_date' 	=> __( 'Start date', 'cactusthemes' ),
			'author' 	=> __( 'Author', 'cactusthemes' ),
			'taxonomy-u_course_cat' 		=> __( 'U-Course Categories', 'cactusthemes' )
		);
		return $columns;
	}
	add_filter( 'manage_u_course_posts_columns', 'course_edit_columns' );
}
if(!function_exists('course_custom_columns')) {
	// return the values for each coupon column on edit.php page
	function course_custom_columns( $column ) {
		global $post;
		global $wpdb;
		$date_format = get_option('date_format');
		$hour_format = get_option('time_format');
		$startdate = get_post_meta($post->ID,'u-course-start', true );
		$start_datetime = '';
		$start_hourtime = '';
		if($startdate){
			$startdate_cal = gmdate("Ymd\THis", $startdate);
			$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
			$con_date = new DateTime($startdate);
			$con_hour = new DateTime($startdate);
			$start_datetime = $con_date->format($date_format);
		}
		switch ( $column ) {
			case 'course_start_date':
				echo date_i18n( get_option('date_format'), strtotime($startdate));
				break;
		}
	}
	add_action( 'manage_posts_custom_column', 'course_custom_columns' );
}
function course_get_template_part( $slug, $name = '' ) {
	global $u_member;
	$template = '';

	// Look in yourtheme/slug-name.php and yourtheme/affiliatez/slug-name.php
	if ( $name )
		$template = locate_template( array ( "{$slug}-{$name}.php", "{$u_member->template_url}{$slug}-{$name}.php" ) );

	// Get default slug-name.php
	if ( !$template && $name && file_exists( $u_member->plugin_path() . "/templates/{$slug}-{$name}.php" ) )
		$template = $u_member->plugin_path() . "/templates/{$slug}-{$name}.php";

	// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/u_member/slug.php
	if ( !$template )
		$template = locate_template( array ( "{$slug}.php", "{$u_member->template_url}{$slug}.php" ) );

	if ( $template )
		load_template( $template, false );
}

include_once('course-data-functions.php');
include_once('course-front-functions.php');
