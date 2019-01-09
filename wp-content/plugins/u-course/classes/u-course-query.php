<?php
class U_course_Query{
	/** @public array Product IDs that match the layered nav + price filter */
	public $post__in 		= array();

	/** @public array The meta query for the page */
	public $meta_query 		= '';
	
	public function __construct() {
		add_filter( 'pre_get_posts', array( $this, 'pre_get_posts' ) );		
	}
	
	function pre_get_posts($q){
		global $affiliatez;

		// We only want to affect the main query
		if ( ! $q->is_main_query() )
			return;

		// When orderby is set, WordPress shows posts. Get around that here.
		if ( $q->is_home() && 'page' == get_option('show_on_front') && get_option('page_on_front') == u_course_get_page_id( 'course' ) ) {
			$_query = wp_parse_args( $q->query );
			if ( empty( $_query ) || ! array_diff( array_keys( $_query ), array( 'preview', 'page', 'paged', 'cpage', 'orderby' ) ) ) {
				$q->is_page = true;
				$q->is_home = false;
				$q->set( 'page_id', get_option('page_on_front') );
				$q->set( 'post_type', 'u_course' );
			}
		}

		// Special check for shops with the product archive on front
		
		if ( $q->is_page() && 'page' == get_option( 'show_on_front' ) && $q->get('page_id') == u_course_get_page_id( 'course' ) ) {

			// This is a front-page shop
			$q->set( 'post_type', 'u_course' );
			$q->set( 'page_id', '' );
			if ( isset( $q->query['paged'] ) )
				$q->set( 'paged', $q->query['paged'] );

			// Define a variable so we know this is the front page shop later on
			define( 'SHOP_IS_ON_FRONT', true );

			// Get the actual WP page to avoid errors and let us use is_front_page()
			// This is hacky but works. Awaiting http://core.trac.wordpress.org/ticket/21096
			global $wp_post_types;

			$shop_page 	= get_post( u_course_get_page_id( 'course' ) );
			$q->is_page = true;

			$wp_post_types['u_course']->ID 			= $shop_page->ID;
			$wp_post_types['u_course']->post_title 	= $shop_page->post_title;
			$wp_post_types['u_course']->post_name 	= $shop_page->post_name;

			// Fix conditional Functions like is_front_page
			$q->is_singular = false;
			$q->is_post_type_archive = true;
			$q->is_archive = true;
		} else {

			// Only apply to product categories, the product post archive, the shop page, product tags, and product attribute taxonomies
		    if 	( ! $q->is_post_type_archive( 'u_course' ) && ! $q->is_tax( get_object_taxonomies( 'u_course' ) ) )
		   		return;

		}

		$this->product_query( $q );

		if ( is_search() ) {
		    //add_filter( 'posts_where', array( $this, 'search_post_excerpt' ) );
		    //add_filter( 'wp', array( $this, 'remove_posts_where' ) );
		}

		// We're on a shop page so queue the woocommerce_get_products_in_view function
		//add_action( 'wp', array( $this, 'get_products_in_view' ), 2);

		// And remove the pre_get_posts hook
		$this->remove_product_query();
	}
	
	/**
	 * Remove the query
	 *
	 * @access public
	 * @return void
	 */
	public function remove_product_query() {
		remove_filter( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
	}
	
	/**
	 * Query the products, applying sorting/ordering etc. This applies to the main wordpress loop
	 *
	 * @access public
	 * @param mixed $q
	 * @return void
	 */
	public function product_query( $q ) {

		// Meta query
		$meta_query = $this->get_meta_query( $q->get( 'meta_query' ) );

		// Ordering
		$ordering = $this->get_catalog_ordering_args();

		// Get a list of post id's which match the current filters set (in the layered nav and price filter)
		$post__in = array_unique( apply_filters( 'loop_shop_post_in', array() ) );

		// Ordering query vars
		$q->set( 'orderby', $ordering['orderby'] );
		$q->set( 'order', $ordering['order'] );
		if ( isset( $ordering['meta_key'] ) )
			$q->set( 'meta_key', $ordering['meta_key'] );

		// Query vars that affect posts shown
		if ( ! $q->is_tax( 'product_cat' ) && ! $q->is_tax( 'product_tag' ) )
			$q->set( 'post_type', 'u_course' );
		$q->set( 'meta_query', $meta_query );
		$q->set( 'post__in', $post__in );
		$q->set( 'posts_per_page', $q->get( 'posts_per_page' ) ? $q->get( 'posts_per_page' ) : apply_filters( 'loop_shop_per_page', get_option( 'posts_per_page' ) ) );

		// Set a special variable
		$q->set( 'wc_query', true );

		// Store variables
		$this->post__in   = $post__in;
		$this->meta_query = $meta_query;

		//do_action( 'woocommerce_product_query', $q, $this );
	}
	
	/**
	 * Appends meta queries to an array.
	 *
	 * @access public
	 * @return void
	 */
	public function get_meta_query( $meta_query = array() ) {
		if ( ! is_array( $meta_query ) )
			$meta_query = array();

		return array_filter( $meta_query );
	}
	
	/**
	 * Returns an array of arguments for ordering products based on the selected values
	 *
	 * @access public
	 * @return array
	 */
	public function get_catalog_ordering_args( $orderby = '', $order = '' ) {
		global $affiliatez;
/*
		// Get ordering from query string unless defined
		if ( ! $orderby ) {
			$orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );

			// Get order + orderby args from string
			$orderby_value = explode( '-', $orderby_value );
			$orderby       = esc_attr( $orderby_value[0] );
			$order         = ! empty( $orderby_value[1] ) ? $orderby_value[1] : $order;
		}

		$orderby = strtolower( $orderby );
		$order   = strtoupper( $order );

		$args = array();

		// default - menu_order
		$args['orderby']  = 'menu_order title';
		$args['order']    = $order == 'DESC' ? 'DESC' : 'ASC';
		$args['meta_key'] = '';

		switch ( $orderby ) {
			case 'date' :
				$args['orderby']  = 'date';
				$args['order']    = $order == 'ASC' ? 'ASC' : 'DESC';
			break;
			case 'price' :
				$args['orderby']  = 'meta_value_num';
				$args['order']    = $order == 'DESC' ? 'DESC' : 'ASC';
				$args['meta_key'] = '_price';
			break;
			case 'popularity' :
				$args['meta_key'] = 'total_sales';

				// Sorting handled later though a hook
				add_filter( 'posts_clauses', array( $this, 'order_by_popularity_post_clauses' ) );
			break;
			case 'rating' :
				// Sorting handled later though a hook
				add_filter( 'posts_clauses', array( $this, 'order_by_rating_post_clauses' ) );
			break;
			case 'title' :
				$args['orderby']  = 'title';
				$args['order']    = $order == 'DESC' ? 'DESC' : 'ASC';
			break;
		}

		return apply_filters( 'woocommerce_get_catalog_ordering_args', $args );*/
		return array('orderby'=>'title','order'=>'ASC');
	}
}
