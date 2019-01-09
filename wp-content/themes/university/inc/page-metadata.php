<?php

/**
 * Initialize the meta boxes. 
 */
add_action( 'admin_init', 'ct_page_meta_boxes' );

if ( ! function_exists( 'ct_page_meta_boxes' ) ){
	function ct_page_meta_boxes() {
	  //layout
	  $page_meta_box_layout = array(
		'id'        => 'page_layout',
		'title'     => __('Layout settings','cactusthemes'),
		'desc'      => '',
		'pages'     => array( 'page' ),
		'context'   => 'normal',
		'priority'  => 'high',
		'fields'    => array(
			array(
			  'id'          => 'sidebar_layout',
			  'label'       => __('Sidebar','cactusthemes'),
			  'desc'        => __('Select "Default" to use settings in Theme Options or Front page fullwidth','cactusthemes'),
			  'std'         => '',
			  'type'        => 'select',
			  'class'       => '',
			  'choices'     => array(
				  array(
					'value'       => 0,
					'label'       => __('Default','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'left',
					'label'       => __('Left','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'right',
					'label'       => __('Right','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'full',
					'label'       => __('Hidden','cactusthemes'),
					'src'         => ''
				  )
			   )
			),
			array(
			  'id'          => 'content_padding',
			  'label'       => __('Content Padding','cactusthemes'),
			  'desc'        => __('Enable default top and bottom padding for content (30px)','cactusthemes'),
			  'std'         => 'on',
			  'type'        => 'on-off',
			  'class'       => '',
			  'choices'     => array()
			),
		 )
		);
		ot_register_meta_box( $page_meta_box_layout );
	  //front page
	  $page_meta_front = array(
		'id'        => 'front_page_header',
		'title'     => __('Front Page Header Settings','cactusthemes'),
		'desc'      => '',
		'pages'     => array( 'page' ),
		'context'   => 'normal',
		'priority'  => 'high',
		'fields'    => array(
			array(
			  'id'          => 'header_background_style',
			  'label'       => __('Header Background','cactusthemes'),
			  'desc'        => __('Choose type of header background (Drag a widget into Front Page Sidebar for Custom content)','cactusthemes'),
			  'std'         => '',
			  'type'        => 'select',
			  'class'       => 'u-condition',
			  'choices'     => array(
				  array(
					'value'       => 'img',
					'label'       => __('Background Image','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'rev',
					'label'       => __('Revolution Slider','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'sidebar',
					'label'       => __('Custom Content','cactusthemes'),
					'src'         => ''
				  )
			   )
			),
			array(
			  'id'          => 'header_background_image',
			  'label'       => __('Background Image','cactusthemes'),
			  'desc'        => __('Choose background image','cactusthemes'),
			  'std'         => '',
			  'type'        => 'background',
			  'class'       => 'header_background_style-child header_background_style-img',
			  'choices'     => array()
			),
			array(
			  'id'          => 'header_background_rev',
			  'label'       => __('Revolution Slider','cactusthemes'),
			  'desc'        => __('Enter Revolution Slider Alias Name','cactusthemes'),
			  'std'         => '',
			  'type'        => 'text',
			  'class'       => 'header_background_style-child header_background_style-rev',
			  'choices'     => array()
			),
			array(
			  'id'          => 'header_background_rev_style',
			  'label'       => __('Enable University Style for Revolution Slider','cactusthemes'),
			  'desc'        => __('Enable to apply University slider\'s navigation & layer style','cactusthemes'),
			  'std'         => 'off',
			  'type'        => 'on-off',
			  'class'       => 'header_background_style-child header_background_style-rev',
			  'choices'     => array()
			),
			array(
			  'id'          => 'header_custom_height',
			  'label'       => __('Header Custom Height','cactusthemes'),
			  'desc'        => __('(Optional) Enter custom height (number of pixel, ex: 400)','cactusthemes'),
			  'std'         => '',
			  'type'        => 'text',
			  'class'       => '',
			  //'condition'	=> 'header_background_style:is(img)',
			),
			//content
			array(
			  'id'          => 'header_content_style',
			  'label'       => __('Overlay content','cactusthemes'),
			  'desc'        => __('Enable overlay content','cactusthemes'),
			  'std'         => '',
			  'type'        => 'select',
			  'class'       => 'u-condition',
			  'choices'     => array(
				  array(
					'value'       => '0',
					'label'       => __('None','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'scroller',
					'label'       => __('Post Scroller','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'carousel',
					'label'       => __('Post Carousel','cactusthemes'),
					'src'         => ''
				  ),
			   )
			),
			array(
			  'id'          => 'header_content_posttype',
			  'label'       => __('Post type','cactusthemes'),
			  'desc'        => __('Choose Post Type for Overlay Content','cactusthemes'),
			  'std'         => '',
			  'type'        => 'select',
			  'class'       => 'header_content_style-child header_content_style-scroller header_content_style-carousel',
			  'choices'     => array(
				  array(
					'value'       => 'post',
					'label'       => __('Post','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'u_event',
					'label'       => __('Event','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'u_course',
					'label'       => __('Course','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'sfwd-courses',
					'label'       => __('LearnDash Course','cactusthemes'),
					'src'         => ''
				  ),
			   )
			),
			array(
			  'id'          => 'header_content_cat',
			  'label'       => __('Category','cactusthemes'),
			  'desc'        => __('List of cat ID (or slug), separated by a comma (for Overlay Content)','cactusthemes'),
			  'std'         => '',
			  'type'        => 'text',
			  'class'       => 'header_content_style-child header_content_style-scroller header_content_style-carousel',
			  'choices'     => array()
			),
			array(
			  'id'          => 'header_content_tag',
			  'label'       => __('Tags','cactusthemes'),
			  'desc'        => __('List of tags, separated by a comma (for Overlay Content)','cactusthemes'),
			  'std'         => '',
			  'type'        => 'text',
			  'class'       => 'header_content_style-child header_content_style-scroller header_content_style-carousel',
			  'choices'     => array()
			),
			array(
			  'id'          => 'header_content_ids',
			  'label'       => __('IDs','cactusthemes'),
			  'desc'        => __('Specify post IDs to retrieve (for Overlay Content)','cactusthemes'),
			  'std'         => '',
			  'type'        => 'text',
			  'class'       => 'header_content_style-child header_content_style-scroller header_content_style-carousel',
			  'choices'     => array()
			),
			array(
			  'id'          => 'header_content_count',
			  'label'       => __('Count','cactusthemes'),
			  'desc'        => __('Number of posts to show (for Overlay Content)','cactusthemes'),
			  'std'         => '',
			  'type'        => 'text',
			  'class'       => 'header_content_style-child header_content_style-scroller header_content_style-carousel',
			  'choices'     => array()
			),
			array(
			  'id'          => 'header_content_visible',
			  'label'       => __('Visible items','cactusthemes'),
			  'desc'        => __('Number of items visible in Carousel. Default is 4 (for Overlay Content)','cactusthemes'),
			  'std'         => '',
			  'type'        => 'text',
			  'class'       => 'header_content_style-child header_content_style-carousel',
			  'choices'     => array()
			),
			array(
			  'id'          => 'header_content_order',
			  'label'       => __('Order','cactusthemes'),
			  'desc'        => '',
			  'std'         => '',
			  'type'        => 'select',
			  'class'       => 'header_content_style-child header_content_style-scroller header_content_style-carousel',
			  'choices'     => array(
				  array(
					'value'       => 'DESC',
					'label'       => __('DESC','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'ASC',
					'label'       => __('ASC','cactusthemes'),
					'src'         => ''
				  ),
			   )
			),
			array(
			  'id'          => 'header_content_orderby',
			  'label'       => __('Order by','cactusthemes'),
			  'desc'        => '',
			  'std'         => '',
			  'type'        => 'select',
			  'class'       => 'header_content_style-child header_content_style-scroller header_content_style-carousel',
			  'choices'     => array(
				  array(
					'value'       => 'date',
					'label'       => __('Date','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'ID',
					'label'       => __('ID','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'author',
					'label'       => __('Author','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'title',
					'label'       => __('Title','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'name',
					'label'       => __('Name','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'modified',
					'label'       => __('Modified','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'parent',
					'label'       => __('Parent','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'rand',
					'label'       => __('Random','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'comment_count',
					'label'       => __('Comment count','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'menu_order',
					'label'       => __('Menu order','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'meta_value',
					'label'       => __('Meta value','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'meta_value_num',
					'label'       => __('Meta value num','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'post__in',
					'label'       => __('Post__in','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'none',
					'label'       => __('None','cactusthemes'),
					'src'         => ''
				  ),
			   )
			),
			array(
			  'id'          => 'header_content_meta_key',
			  'label'       => __('Meta key','cactusthemes'),
			  'desc'        => __('Name of meta key for ordering (for Overlay Content)','cactusthemes'),
			  'std'         => '',
			  'type'        => 'text',
			  'class'       => 'header_content_style-child header_content_style-scroller header_content_style-carousel',
			  'choices'     => array()
			),
			//carousel
			array(
			  'id'          => 'header_content_show_date',
			  'label'       => __('Show date','cactusthemes'),
			  'desc'        => __('Show date info. With standard posts, this is Published Date. With Event and Course, this is Start Date', "cactustheme"),
			  'std'         => '',
			  'type'        => 'select',
			  'class'       => 'header_content_style-child header_content_style-carousel',
			  'choices'     => array(
				  array(
					'value'       => '1',
					'label'       => __('Show','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'hide',
					'label'       => __('Hide','cactusthemes'),
					'src'         => ''
				  ),
			   )
			),
			array(
			  'id'          => 'header_content_show_price',
			  'label'       => __('Show price','cactusthemes'),
			  'desc'        => '',
			  'std'         => '',
			  'type'        => 'select',
			  'class'       => 'header_content_style-child header_content_style-carousel',
			  'choices'     => array(
				  array(
					'value'       => '1',
					'label'       => __('Show','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'hide',
					'label'       => __('Hide','cactusthemes'),
					'src'         => ''
				  ),
			   )
			),
			array(
			  'id'          => 'header_content_show_venue',
			  'label'       => __('Show Venue','cactusthemes'),
			  'desc'        => __('Show Venue with Event & Course post type, or Show Author for Standard post', "cactustheme"),
			  'std'         => '',
			  'type'        => 'select',
			  'class'       => 'header_content_style-child header_content_style-carousel',
			  'choices'     => array(
				  array(
					'value'       => '1',
					'label'       => __('Show','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'hide',
					'label'       => __('Hide','cactusthemes'),
					'src'         => ''
				  ),
			   )
			),
			array(
			  'id'          => 'header_content_show_time',
			  'label'       => __('Show Time','cactusthemes'),
			  'desc'        => __('Show start time. Only works with Event & Course post type', "cactustheme"),
			  'std'         => '',
			  'type'        => 'select',
			  'class'       => 'header_content_style-child header_content_style-carousel',
			  'choices'     => array(
				  array(
					'value'       => '1',
					'label'       => __('Show','cactusthemes'),
					'src'         => ''
				  ),
				  array(
					'value'       => 'hide',
					'label'       => __('Hide','cactusthemes'),
					'src'         => ''
				  ),
			   )
			),
			//scroller
			array(
			  'id'          => 'header_content_link_text',
			  'label'       => __('"More" text','cactusthemes'),
			  'desc'        => __('Default is "MORE NEWS"','cactusthemes'),
			  'std'         => '',
			  'type'        => 'text',
			  'class'       => 'header_content_style-child header_content_style-scroller',
			  'choices'     => array()
			),
			array(
			  'id'          => 'header_content_link_url',
			  'label'       => __('"More" link','cactusthemes'),
			  'desc'        => __('If not set, this button is not shown','cactusthemes'),
			  'std'         => '',
			  'type'        => 'text',
			  'class'       => 'header_content_style-child header_content_style-scroller',
			  'choices'     => array()
			),
		 )
	  );
	  $front_page_content_blog = array(
		'id'        => 'front_page_content_blog',
		'title'     => __('Front Page Content Settings','cactusthemes'),
		'desc'      => '',
		'pages'     => array( 'page' ),
		'context'   => 'normal',
		'priority'  => 'high',
		'fields'    => array(
			array(
				  'id'          => 'page_content',
				  'label'       => __('Content','cactusthemes'),
				  'desc'        => '',
				  'std'         => 'page_ct',
				  'type'        => 'select',
				  'choices'     => array(
					array(
					  'value'       => 'page_ct',
					  'label'       => __( 'This Page Content', 'cactusthemes' ),
					  'src'         => ''
					),
					array(
					  'value'       => 'blog',
					  'label'       => __( 'Blog(latest post)', 'cactusthemes' ),
					  'src'         => ''
					),
				  )
			),
			array(
			  'id'          => 'post_categories_ct',
			  'label'       => __('Post categories', 'cactusthemes' ),
			  'desc'        => __('Enter category Ids or slugs to get posts from, separated by a comma', 'cactusthemes' ),
			  'std'         => '',
			  'type'        => 'text',
			),
			array(
			  'id'          => 'post_tags_ct',
			  'label'       => __('Post tags', 'cactusthemes' ),
			  'desc'        => __('Enter tags to get posts from, separated by a comma', 'cactusthemes' ),
			  'std'         => '',
			  'type'        => 'text',
			),
			array(
			  'id'          => 'post_id_ct',
			  'label'       => __('Post Ids', 'cactusthemes' ),
			  'desc'        => __('Enter post IDs, separated by a comma.If this param is used, other params are ignored', 'cactusthemes' ),
			  'std'         => '',
			  'type'        => 'text',
			),
			array(
				  'id'          => 'order_by_ct',
				  'label'       => __('Order by','cactusthemes'),
				  'desc'        => '',
				  'std'         => 'post-date',
				  'type'        => 'select',
				  'choices'     => array(
					array(
					  'value'       => 'post-date',
					  'label'       => __( 'Post date', 'cactusthemes' ),
					  'src'         => ''
					),
					array(
					  'value'       => 'random',
					  'label'       => __( 'Random', 'cactusthemes' ),
					  'src'         => ''
					)
				  )
			),
		 )
		);
      ot_register_meta_box( $front_page_content_blog );
	  ot_register_meta_box( $page_meta_front );
	}
}


