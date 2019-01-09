<?php
/**
 * Initialize the custom theme options.
 */
add_action( 'admin_init', 'custom_theme_options' );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( 'option_tree_settings', array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array( 
      'sidebar'       => ''
    ),
    'sections'        => array( 
      array(
        'id'          => 'general',
        'title'       => '<i class="fa fa-cogs"><!-- --></i>'.__('General','cactusthemes'),
      ),
      array(
        'id'          => 'color',
        'title'       => '<i class="fa fa-magic"><!-- --></i>'.__('Colors','cactusthemes'),
      ),
      array(
        'id'          => 'fonts',
        'title'       => '<i class="fa fa-font"><!-- --></i>'.__('Fonts','cactusthemes'),
      ),
	  array(
        'id'          => 'nav',
        'title'       => '<i class="fa fa-bars"><!-- --></i>'.__('Navigation','cactusthemes'),
      ),
      array(
        'id'          => 'single_post',
        'title'       => '<i class="fa fa-file-text-o"><!-- --></i>'.__('Single Post','cactusthemes'),
      ),
      array(
        'id'          => 'single_page',
        'title'       => '<i class="fa fa-file"><!-- --></i>'.__('Single Page','cactusthemes'),
      ),
      array(
        'id'          => 'archive',
        'title'       => '<i class="fa fa-pencil-square"><!-- --></i>'.__('Archives','cactusthemes'),
      ),
      array(
        'id'          => '404',
        'title'       => '<i class="fa fa-exclamation-triangle"><!-- --></i>'.__('404','cactusthemes'),
      ),
	  array(
        'id'          => 'woocommerce',
        'title'       => '<i class="fa fa-shopping-cart "><!-- --></i>'.__('WooCommerce','cactusthemes'),
      ),
      array(
        'id'          => 'social_account',
        'title'       => '<i class="fa fa-twitter-square"><!-- --></i>'.__('Social Accounts','cactusthemes'),
      ),
      array(
        'id'          => 'social_share',
        'title'       => '<i class="fa fa-share-square"><!-- --></i>'.__('Social Sharing','cactusthemes'),
      ),
    ),
    'settings'        => array( 
	   array(
        'id'          => 'enable_search',
        'label'       => __('Enable Search','cactusthemes'),
        'desc'        => __('Enable or disable default search form in every pages','cactusthemes'),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
	  array(
        'id'          => 'echo_meta_tags',
        'label'       => __('SEO - Echo Meta Tags','cactusthemes'),
        'desc'        => __('By default, University generates its own SEO meta tags (for example: Facebook Meta Tags). If you are using another SEO plugin like YOAST or a Facebook plugin, you can turn off this option','cactusthemes'),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),  
	  array(
        'id'          => 'copyright',
        'label'       => __('Copyright Text','cactusthemes'),
        'desc'        => __('Appear in footer','cactusthemes'),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'right_to_left',
        'label'       => __('RTL mode','cactusthemes'),
        'desc'        => '',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => '1',
            'label'       => __('Enable RTL','cactusthemes'),
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'custom_css',
        'label'       => __('Custom CSS','cactusthemes'),
        'desc'        => __('Enter custom CSS. Ex: <i>.class{ font-size: 13px; }</i>','cactusthemes'),
        'std'         => '',
        'type'        => 'css',
        'section'     => 'general',
        'rows'        => '5',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
	  array(
        'id'          => 'google_analytics_code',
        'label'       => __('Custom Code','cactusthemes'),
        'desc'        => __('Enter custom code or JS code here. For example, enter Google Analytics','cactusthemes'),
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'general',
        'rows'        => '5',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'logo_image',
        'label'       => __('Logo Image','cactusthemes'),
        'desc'        => __('Upload your logo image','cactusthemes'),
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'retina_logo',
        'label'       => __('Retina Logo (optional)','cactusthemes'),
        'desc'        => __('Retina logo should be two time bigger than the custom logo. Retina Logo is optional, use this setting if you want to strictly support retina devices.','cactusthemes'),
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
	  array(
        'id'          => 'login_logo',
        'label'       => __('Login Logo Image','cactusthemes'),
        'desc'        => __('Upload your Admin Login logo image','cactusthemes'),
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),  
	  array(
        'id'          => 'off_gototop',
        'label'       => __('Scroll Top button','cactusthemes'),
        'desc'        => __('Enable Scroll Top button','cactusthemes'),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),  
	  array(
        'id'          => 'pre-loading',
        'label'       => __('Pre-loading Effect','cactusthemes'),
        'desc'        => __('Enable Pre-loading Effect','cactusthemes'),
        'std'         => '2',
        'type'        => 'select',
        'section'     => 'general',
        'rows'        => '',
		'choices'     => array( 
          array(
            'value'       => '-1',
            'label'       => __('Disable','cactusthemes'),
            'src'         => ''
          ),
		  array(
            'value'       => '1',
            'label'       => __('Enable','cactusthemes'),
            'src'         => ''
          ),
		  array(
            'value'       => '2',
            'label'       => __('Enable for Homepage Only','cactusthemes'),
            'src'         => ''
          )
        ),
      ),
	  array(
        'id'          => 'loading_bg',
        'label'       => __('Pre-Loading Background Color','cactusthemes'),
        'desc'        => __('Default is Black','cactusthemes'),
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'general',
      ),
      array(
        'id'          => 'loading_spin_color',
        'label'       => __('Pre-Loading Spinners Color','cactusthemes'),
        'desc'        => __('Default is White','cactusthemes'),
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'general',
      ),
	  
	  array(
        'id'          => 'shortcode_datetime_format',
        'label'       => __('DateTime format for shortcode','cactusthemes'),
        'desc'        => __('DateTime format for items in shortcodes','cactusthemes'),
        'std'         => '2',
        'type'        => 'select',
        'section'     => 'general',
        'rows'        => '',
		'choices'     => array( 
          array(
            'value'       => 'MM/DD',
            'label'       => __('MM/DD','cactusthemes'),
            'src'         => ''
          ),
		  array(
            'value'       => 'DD/MM',
            'label'       => __('DD/MM','cactusthemes'),
            'src'         => ''
          ),
		  array(
            'value'       => 'YYYY/MM/DD',
            'label'       => __('YYYY/MM/DD','cactusthemes'),
            'src'         => ''
          ),
		  array(
            'value'       => 'YYYY/DD/MM',
            'label'       => __('YYYY/DD/MM','cactusthemes'),
            'src'         => ''
          ),
		  array(
            'value'       => 'MM/DD/YYYY',
            'label'       => __('MM/DD/YYYY','cactusthemes'),
            'src'         => ''
          ),
		  array(
            'value'       => 'DD/MM/YYYY',
            'label'       => __('DD/MM/YYYY','cactusthemes'),
            'src'         => ''
          ),
        ),
      ),
	  
	  //color
      array(
        'id'          => 'main_color_1',
        'label'       => __('Main color 1','cactusthemes'),
        'desc'        => __('Choose Main color 1 (Default is light blue #46a5e5)','cactusthemes'),
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'color',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'main_color_2',
        'label'       => __('Main color 2','cactusthemes'),
        'desc'        => __('Choose Main color 2 (Default is dark blue #17376e)','cactusthemes'),
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'color',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
	  array(
        'id'          => 'footer_bg',
        'label'       => __('Footer Background Color','cactusthemes'),
        'desc'        => __('Choose Footer background color (Default is Main color 2)','cactusthemes'),
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'color',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
	  //font
      array(
        'id'          => 'main_font',
        'label'       => __('Main Font Family','cactusthemes'),
        'desc'        => __('Enter font-family name here. <a href="http://www.google.com/fonts/" target="_blank">Google Fonts</a> are supported. For example, if you choose "Source Code Pro" Google Font with font-weight 400,500,600, enter <i>Source Code Pro:400,500,600</i>','cactusthemes'),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'fonts',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
	  array(
        'id'          => 'heading_font',
        'label'       => __('Heading Font Family','cactusthemes'),
        'desc'        => __('Enter font-family name here. <a href="http://www.google.com/fonts/" target="_blank">Google Fonts</a> are supported. For example, if you choose "Source Code Pro" Google Font with font-weight 400,500,600, enter <i>Source Code Pro:400,500,600</i> (Only few heading texts are affected)','cactusthemes'),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'fonts',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'main_size',
        'label'       => __('Main Font Size','cactusthemes'),
        'desc'        => __('Select base font size (px)','cactusthemes'),
        'std'         => '13',
        'type'        => 'numeric-slider',
        'section'     => 'fonts',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '10,18,1',
        'class'       => ''
      ),
      array(
        'id'          => 'custom_font_1',
        'label'       => __('Upload Custom Font 1','cactusthemes'),
        'desc'        => __('Upload your own font and enter name "custom-font-1" in "Main Font Family" or "Heading Font Family" setting above','cactusthemes'),
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'fonts',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
	  array(
        'id'          => 'custom_font_2',
        'label'       => __('Upload Custom Font 2','cactusthemes'),
        'desc'        => __('Upload your own font and enter name "custom-font-2" in "Main Font Family" or "Heading Font Family" setting above','cactusthemes'),
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'fonts',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
	  array(
		'id'          => 'letter_spacing',
        'label'       => __('Content Letter Spacing','cactusthemes'),
        'desc'        => __('Ex: 2px','cactusthemes'),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'fonts',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
	  array(
		'id'          => 'letter_spacing_heading',
        'label'       => __('Heading Letter Spacing','cactusthemes'),
        'desc'        => __('Ex: 2px','cactusthemes'),
        'std'         => '0',
        'type'        => 'text',
        'section'     => 'fonts',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
	  array(
        'id'          => 'nav_style',
        'label'       => __('Style','cactusthemes'),
        'desc'        => '',
        'std'         => '1',
        'type'        => 'select',
        'section'     => 'nav',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => '1',
            'label'       => __('Style 1 (Default)','cactusthemes'),
            'src'         => ''
          ),
          array(
            'value'       => '2',
            'label'       => __('Style 2','cactusthemes'),
            'src'         => ''
          ),
		  array(
            'value'       => '3',
            'label'       => __('Style 3','cactusthemes'),
            'src'         => ''
          ),
        ),
      ),
	  array(
        'id'          => 'nav_callout_text',
        'label'       => __('Callout Text','cactusthemes'),
        'desc'        => __('Display on Main Navigation, used with Style 3','cactusthemes'),
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'nav',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
	  array(
        'id'          => 'nav_sticky',
        'label'       => __('Sticky Menu','cactusthemes'),
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'nav',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => '',
            'label'       => __('No','cactusthemes'),
            'src'         => ''
          ),
          array(
            'value'       => '1',
            'label'       => __('Dark','cactusthemes'),
            'src'         => ''
          ),
		  array(
            'value'       => '2',
            'label'       => __('Light','cactusthemes'),
            'src'         => ''
          ),
        ),
      ),
	  
	  array(
        'id'          => 'nav_logo_sticky',
        'label'       => __('Sticky Menu Layout ','cactusthemes'),
        'desc'        => __('Select: Use Logo | Only Menu','cactusthemes'),
        'std'         => '1',
        'type'        => 'select',
        'section'     => 'nav',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => '1',
            'label'       => __('Only Menu','cactusthemes'),
            'src'         => ''
          ),
          array(
            'value'       => '2',
            'label'       => __('Use Logo','cactusthemes'),
            'src'         => ''
          ),
        ),
      ),
	  array(
        'id'          => 'logo_image_sticky',
        'label'       => __('Logo Image For Sticky Menu','cactusthemes'),
        'desc'        => __('Upload your logo image for sticky menu','cactusthemes'),
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'nav',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'nav_logo_sticky:is(2)',
        'operator'    => 'and'
      ), 
      array(
        'id'          => 'post_layout',
        'label'       => __('Sidebar','cactusthemes'),
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'single_post',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'right',
            'label'       => __('Sidebar Right','cactusthemes'),
            'src'         => ''
          ),
          array(
            'value'       => 'left',
            'label'       => __('Sidebar Left','cactusthemes'),
            'src'         => ''
          ),
		  array(
            'value'       => 'full',
            'label'       => __('Hidden','cactusthemes'),
            'src'         => ''
          ),
        ),
      ),
	  array(
        'id'          => 'enable_author',
        'label'       => __('Author','cactusthemes'),
        'desc'        => __('Enable Author info','cactusthemes'),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'single_post',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
	  array(
        'id'          => 'enable_author_info',
        'label'       => __('About Author','cactusthemes'),
        'desc'        => __('Enable About Author info','cactusthemes'),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'single_post',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'single_published_date',
        'label'       => __('Published Date','cactusthemes'),
        'desc'        => __('Enable Published Date info','cactusthemes'),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'single_post',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),	
	  array(
        'id'          => 'single_categories',
        'label'       => __('Categories','cactusthemes'),
        'desc'        => __('Enable Categories info','cactusthemes'),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'single_post',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),	
	  array(
        'id'          => 'single_tags',
        'label'       => __('Tags','cactusthemes'),
        'desc'        => __('Enable Categories info','cactusthemes'),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'single_post',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
	  array(
        'id'          => 'single_cm_count',
        'label'       => __('Comment Count','cactusthemes'),
        'desc'        => __('Enable Comment Count Info','cactusthemes'),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'single_post',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
	  array(
        'id'          => 'single_navi',
        'label'       => __('Post Navigation','cactusthemes'),
        'desc'        => __('Enable Post Navigation','cactusthemes'),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'single_post',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),	  

      array(
        'id'          => 'page_layout',
        'label'       => __('Sidebar','cactusthemes'),
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'single_page',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'right',
            'label'       => __('Right Sidebar','cactusthemes'),
            'src'         => ''
          ),
          array(
            'value'       => 'left',
            'label'       => __('Left Sidebar','cactusthemes'),
            'src'         => ''
          ),
          array(
            'value'       => 'full',
            'label'       => __('Hidden','cactusthemes'),
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'archive_sidebar',
        'label'       =>  __('Sidebar','cactusthemes'),
        'desc'        =>  __('Select Sidebar position for Archive pages','cactusthemes'),
        'std'         => '',
        'type'        => 'select',
        'section'     => 'archive',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'right',
            'label'       => __('Right','cactusthemes'),
            'src'         => ''
          ),
          array(
            'value'       => 'left',
            'label'       => __('Left','cactusthemes'),
            'src'         => ''
          ),
          array(
            'value'       => 'full',
            'label'       => __('Hidden','cactusthemes'),
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'page404_title',
        'label'       => __('Page Title','cactusthemes'),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => '404',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'page404_content',
        'label'       => __('Page Content','cactusthemes'),
        'desc'        => '',
        'std'         => '',
        'type'        => 'textarea',
        'section'     => '404',
        'rows'        => '8',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
	  array(
        'id'          => 'page404_search',
        'label'       => __('Search Form','cactusthemes'),
        'desc'        => __('Enable Search Form in 404 page','cactusthemes'),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => '404',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
	     array(
        'id'          => 'woocommerce_layout',
        'label'       => __('Product Page Layout','cactusthemes'),
        'desc'        => __('Select default layout of single product pages','cactusthemes'),
        'std'         => '',
        'type'        => 'select',
        'section'     => 'woocommerce',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'right',
            'label'       => __('Right Sidebar','cactusthemes'),
            'src'         => ''
          ),
          array(
            'value'       => 'left',
            'label'       => __('Left Sidebar','cactusthemes'),
            'src'         => ''
          ),
          array(
            'value'       => 'full',
            'label'       => __('No Sidebar','cactusthemes'),
            'src'         => ''
          )
        ),
      ),
	  array(
        'id'          => 'woo_per_page',
        'label'       => __('Posts per page','cactusthemes'),
        'desc'        => __('Enter number','cactusthemes'),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'woocommerce',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
	  
      array(
        'id'          => 'acc_facebook',
        'label'       => __('Facebook','cactusthemes'),
        'desc'        => __('Enter full link to your account (including http://)','cactusthemes'),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_account',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'acc_twitter',
        'label'       => __('Twitter','cactusthemes'),
        'desc'        => __('Enter full link to your account (including http://)','cactusthemes'),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_account',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'acc_linkedin',
        'label'       => __('LinkedIn','cactusthemes'),
        'desc'        => __('Enter full link to your account (including http://)','cactusthemes'),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_account',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'acc_tumblr',
        'label'       => __('Tumblr','cactusthemes'),
        'desc'        => __('Enter full link to your account (including http://)','cactusthemes'),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_account',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'acc_google-plus',
        'label'       => __('Google Plus','cactusthemes'),
        'desc'        => __('Enter full link to your account (including http://)','cactusthemes'),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_account',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'acc_pinterest',
        'label'       => __('Pinterest','cactusthemes'),
        'desc'        => __('Enter full link to your account (including http://)','cactusthemes'),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_account',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'acc_youtube',
        'label'       => __('Youtube','cactusthemes'),
        'desc'        => __('Enter full link to your account (including http://)','cactusthemes'),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_account',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'acc_flickr',
        'label'       => __('Flickr','cactusthemes'),
        'desc'        => __('Enter full link to your account (including http://)','cactusthemes'),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_account',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
	  array(
        'id'          => 'acc_vk',
        'label'       => __('VK','cactusthemes'),
        'desc'        => 'Enter full link to your account (including http://)',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_account',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
	  array(
			'label'       => __('Custom Social Account','cactusthemes'),
			'id'          => 'custom_acc',
			'type'        => 'list-item',
			'class'       => '',
			'section'     => 'social_account',
			'desc'        => __('Add Social Account','cactusthemes'),
			'choices'     => array(),
			'settings'    => array(
				 array(
					'label'       => __('Icon Font Awesome','cactusthemes'),
					'id'          => 'icon',
					'type'        => 'text',
					'desc'        => __('Enter Font Awesome class (Ex: fa-facebook)','cactusthemes'),
					'std'         => '',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => ''
				 ),
				 array(
					'label'       => __('URL','cactusthemes'),
					'id'          => 'link',
					'type'        => 'text',
					'desc'        => __('Enter full link to your account (including http://)','cactusthemes'),
					'std'         => '',
					'rows'        => '',
					'post_type'   => '',
					'taxonomy'    => ''
				 ),
			)
	  ),
	  array(
        'id'          => 'social_link_open',
        'label'       => __('Open Social link in new tab?','cactusthemes'),
        'desc'        => '',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'social_account',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'share_facebook',
        'label'       => __('Facebook Share','cactusthemes'),
        'desc'        => __('Enable Facebook Share button','cactusthemes'),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'social_share',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'share_twitter',
        'label'       => __('Twitter Share','cactusthemes'),
        'desc'        => __('Enable Twitter Tweet button','cactusthemes'),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'social_share',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'share_linkedin',
        'label'       => __('LinkedIn Share','cactusthemes'),
        'desc'        => __('Enable LinkedIn Share button','cactusthemes'),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'social_share',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'share_tumblr',
        'label'       => __('Tumblr Share','cactusthemes'),
        'desc'        => __('Enable Tumblr Share button','cactusthemes'),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'social_share',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'share_google_plus',
        'label'       => __('Google+ Share','cactusthemes'),
        'desc'        => __('Enable Google+ Share button','cactusthemes'),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'social_share',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'share_pinterest',
        'label'       => __('Pinterest Share','cactusthemes'),
        'desc'        => __('Enable Pinterest Pin button','cactusthemes'),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'social_share',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
	  array(
        'id'          => 'share_vk',
        'label'       => __('VK Share','cactusthemes'),
        'desc'        => __('Enable VK share button','cactusthemes'),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'social_share',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'share_email',
        'label'       => __('Email Share','cactusthemes'),
        'desc'        => __('Enable Email button','cactusthemes'),
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'social_share',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
	  //scroll
	  array(
        'id'          => 'nice-scroll',
        'label'       => __('Enable Smooth Scroll Effect','cactusthemes'),
        'desc'        => '',
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'general',
        'min_max_step'=> '',
      ),
	  array(
        'id'          => 'show_details_order',
        'label'       => __('Show event, course details in order page','cactusthemes'),
        'desc'        => __('Use once product for each event or course','cactusthemes'),
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'woocommerce',
        'min_max_step'=> '',
      ),
	  
    )
  );
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( 'option_tree_settings_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings ); 
  }
}