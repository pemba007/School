<?php

/**
 * Get template part (for templates like the stores-loop).
 *
 * @access public
 * @param mixed $slug
 * @param string $name (default: '')
 * @return void
 */
function member_get_template_part( $slug, $name = '' ) {
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
add_filter('manage_u_member_posts_columns', 'mb_posts_columns_id', 1);
add_action('manage_u_member_posts_custom_column', 'tm_posts_custom_id_columns', 1, 2);
function mb_posts_columns_id($defaults){
    $defaults['wps_post_id'] = __('ID');
    return $defaults;
}
function tm_posts_custom_id_columns($column_name, $id){
        if($column_name === 'wps_post_id'){
                echo $id;
    }
}
include_once('member-data-functions.php');
include_once('member-front-functions.php');
