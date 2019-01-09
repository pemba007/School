<?php

/**
 * Search SQL filter for matching against post title only.
 *
 * @link    http://wordpress.stackexchange.com/a/11826/1685
 *
 * @param   string      $search
 * @param   WP_Query    $wp_query
 */
function u_course_search_by_title( $search, $wp_query ) {
	$course_search = 'default';
	if(function_exists('cop_get')){
		$course_search =  cop_get('u_course_settings','u-course-search');
	}
	
	// if search by title only
	if($course_search == 'title'){
		if ( ! empty( $search ) && ! empty( $wp_query->query_vars['search_terms'] ) ) {
			global $wpdb;

			$q = $wp_query->query_vars;
			$n = ! empty( $q['exact'] ) ? '' : '%';

			$search = array();

			foreach ( ( array ) $q['search_terms'] as $term )
				$search[] = $wpdb->prepare( "$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like( $term ) . $n );

			if ( ! is_user_logged_in() )
				$search[] = "$wpdb->posts.post_password = ''";

			$search = ' AND ' . implode( ' AND ', $search );
		}
	}

    return $search;
}

add_filter( 'posts_search', 'u_course_search_by_title', 10, 2 );