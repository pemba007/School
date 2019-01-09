<?php

if(!defined('PARENT_THEME')){
	define('PARENT_THEME','university');
}
if ( ! isset( $content_width ) ) $content_width = 900;
global $_theme_required_plugins;

/* Define list of recommended and required plugins */
$_theme_required_plugins = array(
		array(
            'name'      => 'WooCommerce',
            'slug'      => 'woocommerce',
            'required'  => false,
			'version' => '3.4'
        ),
        array(
            'name'      => 'WP Pagenavi',
            'slug'      => 'wp-pagenavi',
            'required'  => false
        ),
		array(
            'name'      => 'Contact Form 7',
            'slug'      => 'contact-form-7',
            'required'  => false
        ),
		array(
              'name'    => 'University - Shortcodes',
              'slug'    => 'u-shortcodes',
              'source'  => get_template_directory() . '/inc/plugins/u-shortcodes.zip',
              'required'    => true,
			  'version' => '2.0.21'
        ),
		array(
              'name'    => 'University Project',
              'slug'    => 'u-projects',
              'source'  => get_template_directory() . '/inc/plugins/u-projects.zip',
              'required'    => false,
			  'version' => '1.10.4.4'
        ),
		array(
              'name'    => 'University Event',
              'slug'    => 'u-event',
              'source'  => get_template_directory() . '/inc/plugins/u-event.zip',
              'required'    => false,
			  'version' => '1.14.4.1'
        ),
		array(
              'name'    => 'University Member',
              'slug'    => 'u-member',
              'source'  => get_template_directory() . '/inc/plugins/u-member.zip',
              'required'    => false,
			  'version' => '1.13.2.4'
        ),
		array(
              'name'    => 'University Course',
              'slug'    => 'u-course',
              'source'  => get_template_directory() . '/inc/plugins/u-course.zip',
              'required'    => false,
			  'version' => '1.14.4.1'
        ),
		array(
              'name'    => 'WPBakery Visual Composer',
              'slug'    => 'js_composer',
              'source'  => get_template_directory() . '/inc/plugins/js_composer.zip',
              'required'    => true,
			  'version' => '5.5.2'
        ),
		array(
              'name'    => 'Slider Revolution',
              'slug'    => 'revslider',
              'source'  => get_template_directory() . '/inc/plugins/revslider.zip',
              'required'    => false,
			  'version' => '5.4.8'
          ),
		array(
              'name'    => 'University Sample Data',
              'slug'    => 'cactus-unyson-backup-restore',
              'source'  => get_template_directory() . '/inc/plugins/university-sampledata.zip',
              'required'    => false,
			  'version' => '1.1.1'
          )  
    );
	
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); //for check plugin status
/**
 * Load core framework
 */
require_once 'inc/core/skeleton-core.php';

/**
 * Load Theme Options settings
 */ 
require_once 'inc/theme-options.php';

/**
 * Load Theme Core Functions, Hooks & Filter
 */
require_once 'inc/core/theme-core.php';

/*//////////////////////////////////////////////University////////////////////////////////////////////////*/



add_filter('widget_text', 'do_shortcode');

//add prev and next link rel on head
add_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

//add author social link meta
add_action( 'show_user_profile', 'un_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'un_show_extra_profile_fields' );
function un_show_extra_profile_fields( $user ) { ?>
	<h3><?php _e('Social informations','cactusthemes') ?></h3>
	<table class="form-table">
		<tr>
			<th><label for="twitter">Twitter</label></th>
			<td>
				<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Enter your Twitter profile url.','cactusthemes')?></span>
			</td>
		</tr>
        <tr>
			<th><label for="facebook">Facebook</label></th>
			<td>
				<input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Enter your Facebook profile url.','cactusthemes')?></span>
			</td>
		</tr>
        <tr>
			<th><label for="flickr">Flickr</label></th>
			<td>
				<input type="text" name="flickr" id="flickr" value="<?php echo esc_attr( get_the_author_meta( 'flickr', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Enter your Flickr profile url.','cactusthemes')?></span>
			</td>
		</tr>
        <tr>
			<th><label for="google-plus">Google+</label></th>
			<td>
				<input type="text" name="google" id="google" value="<?php echo esc_attr( get_the_author_meta( 'google', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Enter your Google+ profile url.','cactusthemes')?></span>
			</td>
		</tr>
	</table>
<?php }
add_action( 'personal_options_update', 'un_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'un_save_extra_profile_fields' );
function un_save_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;
	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
	update_user_meta( $user_id, 'facebook', $_POST['facebook'] );
	update_user_meta( $user_id, 'flickr', $_POST['flickr'] );
	update_user_meta( $user_id, 'google', $_POST['google'] );
}

/**
 * Sets up theme defaults and registers the various WordPress features that
 * theme supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 * 	custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 */
function cactusthemes_setup() {
	/*
	 * Makes theme available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 */
	load_theme_textdomain( 'cactusthemes', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
	// This theme supports woocommerce.
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
	// This theme supports a variety of post formats.
	
	add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary-menus', __( 'Primary Menus', 'cactusthemes' ) );
	register_nav_menu( 'secondary-menus', __( 'Secondary Menus', 'cactusthemes' ) );

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 255, 9999 ); // Unlimited height, soft crop
}
add_action( 'after_setup_theme', 'cactusthemes_setup' );

/**
 * Enqueues scripts and styles for front-end.
 */
function cactusthemes_scripts_styles() {
	global $wp_styles;
	/*
	 * Loads our main javascript.
	 */	
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', '', '', false );
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl-carousel/owl.carousel.min.js', array('jquery'), '', true );
	if(is_singular() ) wp_enqueue_script( 'comment-reply' );
	if(ot_get_option( 'nice-scroll', 'off')=='on'){
		wp_enqueue_script( 'smooth-scroll', get_template_directory_uri() . '/js/SmoothScroll.js', array('jquery'), '', true);
	}
	
	//wp_enqueue_script('jquery');
	//wp_enqueue_script('jquery-migrate');
	wp_enqueue_script( 'cactus-themes', get_template_directory_uri() . '/js/cactus-themes.js', array('jquery','jquery-migrate'), '2.1', false);
	/*
	 * Loads our main stylesheet.
	 */
	$u_all_font = array();
	if(ot_get_option('main_font') || ot_get_option( 'heading_font' )){
		if(ot_get_option('main_font') && ot_get_option('main_font') != 'custom-font-1' && ot_get_option('main_font') != 'custom-font-2'){
			$u_all_font[] = ot_get_option( 'main_font' );
		}
		if(ot_get_option('heading_font') && ot_get_option('heading_font')!='custom-font-1' && ot_get_option('heading_font') != 'custom-font-2'){
			$u_all_font[] = ot_get_option( 'heading_font' );
		}
		if(!empty($u_all_font)){
			$all_font = implode('|',$u_all_font);
		}
		if(ot_get_option('main_font') != 'custom-font-1' && ot_get_option('main_font') != 'custom-font-2' && ot_get_option('heading_font') != 'custom-font-1' && ot_get_option('heading_font')!='custom-font-2' && !empty($u_all_font)){
			wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family='.$all_font );
		}
	}
	wp_deregister_style( 'font-awesome' );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() .'/fonts/css/font-awesome.min.css');
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() .'/js/owl-carousel/owl.carousel.min.css');
	wp_enqueue_style( 'owl-carousel-theme', get_template_directory_uri() .'/js/owl-carousel/owl.theme.default.min.css');
	wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/style.css');
	//wp_enqueue_style( 'custom-css', get_template_directory_uri() . '/css/custom.css.php');
	if(ot_get_option( 'right_to_left', 0)){
		wp_enqueue_style( 'rtl', get_template_directory_uri() . '/rtl.css');
	}
	if(ot_get_option( 'responsive', 1)!=1){
		wp_enqueue_style( 'no-responsive', get_template_directory_uri() . '/css/no-responsive.css');
	}
	if(is_plugin_active( 'sfwd-lms/sfwd_lms.php' ) || class_exists('SFWD_LMS')){
		wp_enqueue_style( 'university-learndash', get_template_directory_uri() . '/css/u-learndash.css');
	}
	if(is_plugin_active( 'buddypress/bp-loader.php' )){
		wp_enqueue_style( 'university-buddypress', get_template_directory_uri() . '/css/u-buddypress.css');
	}
}
add_action( 'wp_enqueue_scripts', 'cactusthemes_scripts_styles' );

/* Enqueues for Admin */
function cactusthemes_admin_scripts_styles() {
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() .'/fonts/css/font-awesome.min.css');
}
add_action( 'admin_enqueue_scripts', 'cactusthemes_admin_scripts_styles' );

add_action('wp_head','cactus_wp_head',100);
if(!function_exists('cactus_wp_head')){
	function cactus_wp_head(){
		echo '<!-- custom css -->
				<style type="text/css">';
		
		require get_template_directory() . '/css/custom.css.php';
		
		echo '</style>
			<!-- end custom css -->';
	}
}

/**
 * Registers our main widget area and the front page widget areas.
 *
 * @since Twenty Twelve 1.0
 */
function cactusthemes_widgets_init() {
	$rtl = ot_get_option( 'righttoleft', 0);

	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'cactusthemes' ),
		'id' => 'main_sidebar',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'cactusthemes' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
		'after_widget' => '</div></div>',
		'before_title' => $rtl ? '<h2 class="widget-title maincolor2">' : '<h2 class="widget-title maincolor2">',
		'after_title' => $rtl ? '</h2>' : '</h2>',
	));
		
	register_sidebar( array(
		'name' => __( 'Navigation Sidebar ', 'cactusthemes' ),
		'id' => 'navigation_sidebar',
		'description' => __( 'To replace default navigation', 'cactusthemes' ),
		'before_widget' => '<div id="%1$s" class="%2$s"><div class="widget-inner">',
		'after_widget' => '</div></div>',
		'before_title' => '<h2 class="widget-title maincolor1">',
		'after_title' => '</h2>',
	));
	register_sidebar( array(
		'name' => __( 'Top Nav Sidebar', 'cactusthemes' ),
		'id' => 'topnav_sidebar',
		'description' => __( 'To replace Top Nav', 'cactusthemes' ),
		'before_widget' => '<div id="%1$s" class="%2$s"><div class="widget-inner">',
		'after_widget' => '</div></div>',
		'before_title' => '<h2 class="widget-title maincolor1">',
		'after_title' => '</h2>',
	));
	
	register_sidebar( array(
		'name' => __( 'Pathway Sidebar', 'cactusthemes' ),
		'id' => 'pathway_sidebar',
		'description' => __( 'Replace Pathway (Breadcrumbs) with your widgets', 'cactusthemes' ),
		'before_widget' => '<div id="%1$s" class="pathway-widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar( array(
		'name' => __( 'Front Page Sidebar ', 'cactusthemes' ),
		'id' => 'frontpage_sidebar',
		'description' => __( 'Used in Front Page templates only', 'cactusthemes' ),
		'before_widget' => '<div id="%1$s" class="frontpage-widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar( array(
		'name' => __( 'Top Sidebar', 'cactusthemes' ),
		'id' => 'top_sidebar',
		'description' => __( 'Appear above Page Content', 'cactusthemes' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
		'after_widget' => '</div></div>',
		'before_title' => '<h2 class="widget-title maincolor1">',
		'after_title' => '</h2>',
	));
	register_sidebar( array(
		'name' => __( 'Bottom Sidebar', 'cactusthemes' ),
		'id' => 'bottom_sidebar',
		'description' => __( 'Appear below page content', 'cactusthemes' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
		'after_widget' => '</div></div>',
		'before_title' => '<h2 class="widget-title maincolor1">',
		'after_title' => '</h2>',
	));
	register_sidebar( array(
		'name' => __( 'Footer Sidebar', 'cactusthemes' ),
		'id' => 'footer_sidebar',
		'description' => __( 'Appear at Page Footer', 'cactusthemes' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
		'after_widget' => '</div></div>',
		'before_title' => '<h2 class="widget-title maincolor1">',
		'after_title' => '</h2>',
	));
	if(class_exists('U_event')){
	register_sidebar( array(
		'name' => __( 'Events Sidebar', 'cactusthemes' ),
		'id' => 'u_event_sidebar',
		'description' => __( 'To replace main sidebar in all Events page', 'cactusthemes' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
		'after_widget' => '</div></div>',
		'before_title' => $rtl ? '<h2 class="widget-title maincolor2">' : '<h2 class="widget-title maincolor2">',
		'after_title' => $rtl ? '</h2>' : '</h2>',
	));
	}
	if(class_exists('U_course')){
	register_sidebar( array(
		'name' => __( 'Courses Sidebar', 'cactusthemes' ),
		'id' => 'u_course_sidebar',
		'description' => __( 'To replace main sidebar in all Courses page', 'cactusthemes' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
		'after_widget' => '</div></div>',
		'before_title' => $rtl ? '<h2 class="widget-title maincolor2">' : '<h2 class="widget-title maincolor2">',
		'after_title' => $rtl ? '</h2>' : '</h2>',
	));
	}
	if (class_exists('Woocommerce')) {
	register_sidebar( array(
		'name' => __( 'WooCommerce Sidebar', 'cactusthemes' ),
		'id' => 'woocommerce_sidebar',
		'description' => __( 'To replace main sidebar in WooCommerce page', 'cactusthemes' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
		'after_widget' => '</div></div>',
		'before_title' => $rtl ? '<h2 class="widget-title maincolor2">' : '<h2 class="widget-title maincolor2">',
		'after_title' => $rtl ? '</h2>' : '</h2>',
	));
	}
}
add_action( 'widgets_init', 'cactusthemes_widgets_init' );

add_image_size('thumb_139x89',139,89, true); //widget
add_image_size('thumb_277x337',277, 337, true); //event morderm listing
add_image_size('thumb_50x50',50, 50, true); //single event -member
add_image_size('thumb_80x80',80, 80, true); //single event -related
add_image_size('thumb_263x263',263,263, true); //shortcode blog, single event
add_image_size('thumb_409x258',409,258, true); //blog listing
//Retina
add_image_size('thumb_278x178',278,178, true); //widget
add_image_size('thumb_554x674',554, 674, true); //event morderm listing
add_image_size('thumb_100x100',100, 100, true); //single event -member
add_image_size('thumb_526x526',526,526, true); //shortcode blog, single event
add_image_size('thumb_818x516',818,516, true); //blog listing

// Hook widget 'SEARCH'
add_filter('get_search_form', 'cactus_search_form'); 
function cactus_search_form($text) {
	$text = str_replace('value=""', 'placeholder="'.__("SEARCH","cactusthemes").'"', $text);
    return $text;
}

require_once 'inc/google-adsense-responsive.php';

if(!function_exists('un_breadcrumbs')){
	function un_breadcrumbs(){
		/* === OPTIONS === */
		$text['home']     = __('Home','cactusthemes'); // text for the 'Home' link
		$text['category'] = '%s'; // text for a category page
		$text['search']   = __('Search Results for','cactusthemes').' "%s"'; // text for a search results page
		$text['tag']      = __('Tag','cactusthemes').' "%s"'; // text for a tag page
		$text['author']   = __('Author','cactusthemes').' %s'; // text for an author page
		$text['404']      = __('404','cactusthemes'); // text for the 404 page

		$show_current   = 0; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show
		$show_on_home   = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
		$show_title     = 1; // 1 - show the title for the links, 0 - don't show
		$delimiter      = ' \\ '; // delimiter between crumbs
		$before         = '<span class="current">'; // tag before the current crumb
		$after          = '</span>'; // tag after the current crumb
		/* === END OF OPTIONS === */

		global $post;
		$home_link    = home_url('/');
		$link_before  = '<span typeof="v:Breadcrumb">';
		$link_after   = '</span>';
		$link_attr    = ' rel="v:url" property="v:title"';
		$link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
		$parent_id    = $parent_id_2 = ($post) ? $post->post_parent : 0;
		$frontpage_id = get_option('page_on_front');
		$event_layout ='';
		
		if(is_front_page()) {

			if ($show_on_home == 1) echo '<div class="breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';

		}elseif(is_home()){
			$title = get_option('page_for_posts')?get_the_title(get_option('page_for_posts')):__('Blog','cactusthemes');
			echo '<div class="breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a> \ '.$title.'</div>';
		}else{

			echo '<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">';
			if ($show_home_link == 1) {
				if(function_exists ( "is_shop" ) && is_shop()){
					
				} else {
					echo '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $text['home'] . '</a>';
					if ($frontpage_id == 0 || $parent_id != $frontpage_id) echo $delimiter;
				}
			}

			if ( is_category() ) {
				$this_cat = get_category(get_query_var('cat'), false);
				if ($this_cat->parent != 0) {
					$cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
					if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
					$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
					$cats = str_replace('</a>', '</a>' . $link_after, $cats);
					if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
					echo $cats;
				}
				if ($show_current == 1) echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

			} elseif ( is_search() ) {
				echo $before . sprintf($text['search'], get_search_query()) . $after;

			} elseif ( is_day() ) {
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
				echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
				echo $before . get_the_time('d') . $after;

			} elseif ( is_month() ) {
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
				echo $before . get_the_time('F') . $after;

			} elseif ( is_year() ) {
				echo $before . get_the_time('Y') . $after;

			} elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
                    if(is_singular('product')){
                        $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
                        printf($link, $shop_page_url, str_replace('/', '', $slug['slug']));
                        if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
                    } else {
                        printf($link, $home_link . $slug['slug'] . '/', $slug['slug'] ? $slug['slug'] : $post_type->labels->singular_name);
                        if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
                    }
				} else {
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, $delimiter);
					if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
					$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
					$cats = str_replace('</a>', '</a>' . $link_after, $cats);
					if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
					echo $cats;
					if ($show_current == 1) echo $before . get_the_title() . $after;
				}

			} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
				if(function_exists ( "is_shop" ) && is_shop()){
					do_action( 'woocommerce_before_main_content' );
					do_action( 'woocommerce_after_main_content' );
				}else{
					$post_type = get_post_type_object(get_post_type());
					if($post_type){
						$slug = $post_type->rewrite;
						echo $before . (isset($slug['slug']) ? $slug['slug'] : (isset($post_type->labels->singular_name) ? $post_type->labels->singular_name : '')) . $after;
					}
				}

			} elseif ( is_attachment() ) {
				$parent = get_post($parent_id);
				$cat = get_the_category($parent->ID); $cat = isset($cat[0])?$cat[0]:'';
				if($cat){
					$cats = get_category_parents($cat, TRUE, $delimiter);
					$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
					$cats = str_replace('</a>', '</a>' . $link_after, $cats);
					if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
					echo $cats;
				}
				printf($link, get_permalink($parent), $parent->post_title);
				if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;

			} elseif ( is_page() && !$parent_id ) {
				if ($show_current == 1) echo $before . get_the_title() . $after;

			} elseif ( is_page() && $parent_id ) {
				if ($parent_id != $frontpage_id) {
					$breadcrumbs = array();
					while ($parent_id) {
						$page = get_page($parent_id);
						if ($parent_id != $frontpage_id) {
							$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
						}
						$parent_id = $page->post_parent;
					}
					$breadcrumbs = array_reverse($breadcrumbs);
					for ($i = 0; $i < count($breadcrumbs); $i++) {
						echo $breadcrumbs[$i];
						if ($i != count($breadcrumbs)-1) echo $delimiter;
					}
				}
				if ($show_current == 1) {
					if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;
					echo $before . get_the_title() . $after;
				}

			} elseif ( is_tag() ) {
				echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata($author);
				echo $before . sprintf($text['author'], $userdata->display_name) . $after;

			} elseif ( is_404() ) {
				echo $before . $text['404'] . $after;
			}

			if ( get_query_var('paged') ) {
				if(function_exists ( "is_shop" ) && is_shop()){
				}else{
					if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || is_home() ) echo ' (';
					echo __('Page','cactusthemes') . ' ' . get_query_var('paged');
					if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || is_home() ) echo ')';
				}
			}

			echo '</div><!-- .breadcrumbs -->';

		}
	} // end tm_breadcrumbs()
}
/* Display Icon Links to some social networks */
if(!function_exists('cactus_social_share')){
function cactus_social_share($id=false){
	if(!$id){ $id = get_the_ID(); }
	?>
	<?php if(ot_get_option('share_facebook','on')!='off'){ ?>
	<li><a class="btn btn-default btn-lighter social-icon" title="<?php _e('Share on Facebook','cactusthemes');?>" href="#" target="_blank" rel="nofollow" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+'<?php echo urlencode(get_permalink($id)); ?>','facebook-share-dialog','width=626,height=436');return false;"><i class="fa fa-facebook"></i></a></li>
    <?php } ?>
    <?php if(ot_get_option('share_twitter','on')!='off'){ ?>
    <li><a class="btn btn-default btn-lighter social-icon" href="#" title="<?php _e('Share on Twitter','cactusthemes');?>" rel="nofollow" target="_blank" onclick="window.open('http://twitter.com/share?text=<?php echo urlencode(get_the_title($id)); ?>&url=<?php echo urlencode(get_permalink($id)); ?>','twitter-share-dialog','width=626,height=436');return false;"><i class="fa fa-twitter"></i></a></li>
    <?php } ?>
    <?php if(ot_get_option('share_linkedin','on')!='off'){ ?>
    <li><a class="btn btn-default btn-lighter social-icon" href="#" title="<?php _e('Share on LinkedIn','cactusthemes');?>" rel="nofollow" target="_blank" onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink($id)); ?>&title=<?php echo urlencode(get_the_title($id)); ?>&source=<?php echo urlencode(get_bloginfo('name')); ?>','linkedin-share-dialog','width=626,height=436');return false;"><i class="fa fa-linkedin"></i></a></li>
    <?php } ?>
    <?php if(ot_get_option('share_tumblr','on')!='off'){ ?>
    <li><a class="btn btn-default btn-lighter social-icon" href="#" title="<?php _e('Share on Tumblr','cactusthemes');?>" rel="nofollow" target="_blank" onclick="window.open('http://www.tumblr.com/share/link?url=<?php echo urlencode(get_permalink($id)); ?>&name=<?php echo urlencode(get_the_title($id)); ?>','tumblr-share-dialog','width=626,height=436');return false;"><i class="fa fa-tumblr"></i></a></li>
    <?php } ?>
    <?php if(ot_get_option('share_google_plus','on')!='off'){ ?>
    <li><a class="btn btn-default btn-lighter social-icon" href="#" title="<?php _e('Share on Google Plus','cactusthemes');?>" rel="nofollow" target="_blank" onclick="window.open('https://plus.google.com/share?url=<?php echo urlencode(get_permalink($id)); ?>','googleplus-share-dialog','width=626,height=436');return false;"><i class="fa fa-google-plus"></i></a></li>
    <?php } ?>
    <?php if(ot_get_option('share_pinterest','on')!='off'){ ?>
    <li><a class="btn btn-default btn-lighter social-icon" href="#" title="<?php _e('Pin this','cactusthemes');?>" rel="nofollow" target="_blank" onclick="window.open('//pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink($id)) ?>&media=<?php echo urlencode(wp_get_attachment_url( get_post_thumbnail_id($id))); ?>&description=<?php echo urlencode(get_the_title($id)) ?>','pin-share-dialog','width=626,height=436');return false;"><i class="fa fa-pinterest"></i></a></li>
    <?php } ?>
    <?php if(ot_get_option('share_vk','on')!='off'){ ?>
    <li><a class="btn btn-default btn-lighter social-icon" href="#" title="<?php _e('Share on Vk','cactusthemes'); ?>" rel="nofollow" target="_blank" onclick="window.open('http://vkontakte.ru/share.php?url=<?php echo urlencode(get_permalink(get_the_ID())); ?>','vk-share-dialog','width=626,height=436');return false;"><i class="fa fa-vk"></i></a></li>
    <?php } ?>
    <?php if(ot_get_option('share_email','on')!='off'){ ?>
    <li><a class="btn btn-default btn-lighter social-icon" href="mailto:?subject=<?php echo get_the_title($id) ?>&body=<?php echo urlencode(get_permalink($id)) ?>" title="<?php _e('Email this','cactusthemes');?>"><i class="fa fa-envelope"></i></a></li>
    <?php } ?>
<?php }
}

/*default image*/
if(!function_exists('u_get_default_image')){
	function u_get_default_image($size = 'grid'){
		if($size == 'grid'){
			return array(get_template_directory_uri().'/images/default-photo-grid.jpg',554,674);
		}elseif($size == 'blog-square'){
			return array(get_template_directory_uri().'/images/default-photo-blog-square.jpg',526,526);
		}
	}
}

/* Extend Visual Composer Row - wrap VC row inside a <u_row> */
function vc_theme_before_vc_row($atts, $content = null) {
	$style = isset($atts['u_row_style']) ? $atts['u_row_style'] : 0; //style full width or not
	$paralax = isset($atts['u_row_paralax']) ? $atts['u_row_paralax'] : 0;
	$scheme = isset($atts['u_row_scheme']) ? $atts['u_row_scheme'] : 0;
	global $global_page_layout;
	ob_start(); 
	?>
		<div class="u_row<?php echo ($style || $global_page_layout == 'true-full') ? ' u_full_row' : ''; echo $scheme ? ' dark-div' : ''; echo $paralax ? ' u_paralax' : '' ?>">
        <?php if(!$style && $global_page_layout == 'true-full'){ ?>
        	<div class="container">
        <?php }?>
	<?php
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}

function vc_theme_after_vc_row($atts, $content = null) {
	$style = isset($atts['u_row_style']) ? $atts['u_row_style'] : 0; //style full width or not
	global $global_page_layout;
	ob_start(); ?>
    	<?php if(!$style && $global_page_layout == 'true-full'){ ?>
        	</div>
        <?php }?>
		</div><!--/u_row-->
	<?php
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}

add_action( 'after_setup_theme', 'u_add_vc_row_param' );
function u_add_vc_row_param(){
	$attributes = array(
		'type' => 'dropdown',
		'heading' => "Row Style",
		'param_name' => 'u_row_style',
		'value' => array(
			__('Default (In container)', 'cactusthemes') => 0,
			__('Full-width (Side to side)', 'cactusthemes') => 1,
		 ),
		'description' => __("Choose row style (In page template Front Page, this style is used for row's content)", 'cactusthemes')
	);
	if(function_exists('vc_add_param')){
		vc_add_param('vc_row', $attributes);
	}
}
add_action( 'after_setup_theme', 'u_add_vc_row_param2',10,10 );
function u_add_vc_row_param2(){
	$attributes = array(
		'type' => 'dropdown',
		'heading' => "Row Paralax",
		'param_name' => 'u_row_paralax',
		'value' => array(
			__('No', 'cactusthemes') => 0,
			__('Yes', 'cactusthemes') => 1,
		 ),
		'description' => __("Enable palalax effect for row's background", 'cactusthemes')
	);
	if(function_exists('vc_add_param')){
		vc_add_param('vc_row', $attributes);
	}
}
add_action( 'after_setup_theme', 'u_add_vc_row_param3',10,11 );
function u_add_vc_row_param3(){
	$attributes = array(
		'type' => 'dropdown',
		'heading' => "Row Scheme",
		'param_name' => 'u_row_scheme',
		'value' => array(
			__('Default', 'cactusthemes') => 0,
			__('Dark-div', 'cactusthemes') => 1,
		 ),
		'description' => __("Choose row scheme (in Dark-div, default text, buttons will have white color)", 'cactusthemes')
	);
	if(function_exists('vc_add_param')){
		vc_add_param('vc_row', $attributes);
	}
}


/*facebook comment*/
if(!function_exists('u_update_custom_comment')){
	function u_update_custom_comment(){
		if(is_plugin_active('facebook/facebook.php')&&get_option('facebook_comments_enabled')&&is_single()){
			global $post;
			//$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			if(class_exists('Facebook_Comments')){
				//$comment_count = Facebook_Comments::get_comments_number_filter(0,$post->ID);
				$comment_count = get_comments_number($post->ID);
			}else{
				$actual_link = get_permalink($post->ID);
				$fql  = "SELECT url, normalized_url, like_count, comment_count, ";
				$fql .= "total_count, commentsbox_count, comments_fbid FROM ";
				$fql .= "link_stat WHERE url = '".$actual_link."'";
				$apifql = "https://api.facebook.com/method/fql.query?format=json&query=".urlencode($fql);
				$json = file_get_contents($apifql);
				//print_r( json_decode($json));
				$link_fb_stat = json_decode($json);
				$comment_count = $link_fb_stat[0]->commentsbox_count?$link_fb_stat[0]->commentsbox_count:0;
			}
			update_post_meta($post->ID, 'custom_comment_count', $comment_count);
		}
	}
}
add_action('wp_footer', 'u_update_custom_comment', 100);
/*Filter bar*/
function ct_filter_bar($taxono,$slug_pro){
	?>
        <div class="project-listing">
        <div class="filter-cat">
            <?php
            $pageURL = 'http';
             if(isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on")) {$pageURL .= "s";}
             $pageURL .= "://";
             if ($_SERVER["SERVER_PORT"] != "80") {
              $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
             } else {
              $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
             }
            
            $project_cat = home_url().'/'.$slug_pro.'/';
            $selected ='';
            $bg_cr ='';
            if(strpos($pageURL, $project_cat) !== false){$bg_cr = 'style="background-color: #666666;border-color: #666666; color:#fff"';$selected = 'selected="selected"';}
            ?>
            <a href="<?php echo $project_cat; ?>" class="btn btn-lighter" <?php echo $bg_cr ?> ><?php echo __('All','cactusthemes'); ?></a>
            <?php 
            $pro_cat = get_terms( $taxono, 'orderby=count&hide_empty=1' );
            foreach ($pro_cat as $p_term) {
                $link_t = get_term_link($p_term->slug, $taxono);
                $bg_cr2 ='';
                if(strpos($pageURL, $link_t) !== false){$bg_cr2 = 'style="background-color: #666666;border-color: #666666; color:#fff"';}
                echo '<a href="'.get_term_link($p_term->slug, $taxono).'" class="btn btn-lighter" '.$bg_cr2.'>'.$p_term->name.'</a> ';
            }?>
            <select id="uni-project">
            <option value="<?php echo $project_cat; ?>" <?php echo $selected ?>><?php echo __('All','cactusthemes'); ?></option>
            <?php
            foreach ($pro_cat as $p_term) {
                $link_t = get_term_link($p_term->slug, $taxono);
                $selected ='';
                if(strpos($pageURL, $link_t) !== false){$selected = 'selected="selected"';}
                echo '<option value="'.get_term_link($p_term->slug, $taxono).'" '.$selected.' ><a href="'.get_term_link($p_term->slug, $taxono).'" class="btn btn-lighter">'.$p_term->name.'</a></option>';
            }
            ?>
            </select>
        </div>
        </div>
    
    <?php
}
function cactus_custom_posts_per_page($query){
	$course_per_page = $event_per_page = '';
	$post_per_page = get_option('posts_per_page');
	if(function_exists('cop_get')){ 
		$event_per_page =  cop_get('u_event_settings','uevent-per-page');
		$course_per_page =  cop_get('u_course_settings','ucourse-per-page');
	}
	$woo_per_page = ot_get_option('woo_per_page');
	if($woo_per_page==''){$woo_per_page = $post_per_page;} 
	if($event_per_page==''){$event_per_page = $post_per_page;} 
	if($course_per_page==''){$course_per_page = $post_per_page;} 
	if(isset($query->query_vars['post_type']) && $query->is_main_query()){
		switch ( $query->query_vars['post_type'] )
		{
			case 'u_event':  // Post Type named 'Event'
				$query->query_vars['posts_per_page'] = $event_per_page;
				break;
	
			case 'u_course':  // Post Type named 'Course'
				$query->query_vars['posts_per_page'] = $course_per_page;
				break;
	
			case 'productgf':  // Post Type named 'Product'
				$query->query_vars['posts_per_page'] = $woo_per_page;
				break;
	
			default:
				break;
		}
	}
	if(is_tax('u_course_cat')){
		$query->query_vars['posts_per_page'] = $course_per_page;
	}
	if(is_tax('u_event_cat')){
		$query->query_vars['posts_per_page'] = $event_per_page;
	}
    return $query;
}
function cactus_custom_order_member($query){
	$member_order_by = $event_order_by = '';
	$time_now = strtotime("now");
	
	if(function_exists('cop_get')){ 
		$member_order_by =  cop_get('u_member_settings','u-member-order');
		if($member_order_by == 'modified'){$member_order = 'DESC';}
		elseif($member_order_by == 'title'){$member_order = 'ASC';}
		//event
		$event_order_by =  cop_get('u_event_settings','uevent-order');
		$pt_ck = 0;
		if((isset($query->query_vars['post_type']) && ($query->query_vars['post_type']=='u_course')) || ($query->is_main_query() && is_tax('u_course_cat'))){
			$pt_ck = 1;
			$event_order_by =  cop_get('u_course_settings','ucourse-order');
		}
		if(isset($_GET['orderby'])&&($_GET['orderby'] == 'upcoming' || $_GET['orderby']=='startdate' || $_GET['orderby']=='modified' )){
			$event_order_by = $_GET['orderby'];
		}
		if($event_order_by == 'upcoming'){
			$metakey = 'u-startdate';
		}elseif($event_order_by == 'startdate'){
			$metakey = 'u-startdate';
		}elseif($event_order_by == 'modified'){
			$event_order = 'DESC';
		}
		if(($pt_ck == 1) && ($event_order_by == 'upcoming')){
			$time_now =  strtotime("now");
			$metakey = 'u-course-start';
		}elseif(($pt_ck == 1) &&$event_order_by == 'startdate'){
			$metakey = 'u-course-start';
		}
	}	
	if( ($member_order_by != '') && isset($query->query_vars['post_type']) && ($query->query_vars['post_type']=='u_member') && $query->is_main_query()){
		$query->set('orderby', $member_order_by);
		$query->set('order', $member_order);
	}elseif( $event_order_by != ''){
		if((isset($query->query_vars['post_type']) && ($query->query_vars['post_type']=='u_event') && $query->is_main_query() && !is_single()) || ($query->is_main_query() && is_tax('u_event_cat')) || (isset($query->query_vars['post_type']) && ($query->query_vars['post_type']=='u_course') && $query->is_main_query() && !is_single()) || ($query->is_main_query() && is_tax('u_course_cat')) ){
			if($event_order_by == 'upcoming'){
				$query->set('orderby', 'meta_value_num');
				$query->set('order', 'ASC');
				$query->set('meta_key', $metakey);
				
				// as u-startdate stores local time, we need to compare with local time of WordPress blog
				$query->set('meta_value', current_time('timestamp')); 
				$query->set('meta_compare', '>');
			}elseif($event_order_by == 'startdate'){
				$query->set('orderby', 'meta_value_num');
				$query->set('order', 'DESC');
				$query->set('meta_key', $metakey);
			}elseif($event_order_by == 'modified'){
				$query->set('orderby', $event_order_by);
				$query->set('order', $event_order);
			}
		}
	}
}
if( ! is_admin() )
{
   add_action('pre_get_posts', 'cactus_custom_order_member');
   add_filter( 'pre_get_posts', 'cactus_custom_posts_per_page' );
}
function cactus_custom_pro_per_page(){
	$woo_per_page = ot_get_option('woo_per_page');
	add_filter( 'loop_shop_per_page', create_function( '$cols', 'return '.$woo_per_page.';' ), 20 );

}
add_action( 'after_setup_theme', 'cactus_custom_pro_per_page',10,11 );
if(!function_exists('ct_filter_order_lis')){
	function ct_filter_order_lis($post_type = false){
		if(function_exists('cop_get')){
			$filter_order =  cop_get('u_event_settings','uevent-filter-order');
			if(isset($post_type) && $post_type =='u_course'){
				$filter_order =  cop_get('u_course_settings','ucourse-filter-order');
			}
			if($filter_order == 1){
				$event_order_by =  cop_get('u_event_settings','uevent-order');
				$pageURL = 'http';
				if(isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on")) {$pageURL .= "s";}
				$pageURL .= "://";
				if ($_SERVER["SERVER_PORT"] != "80") {
					$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
				} else {
					$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
				}
				?>
				<!-- order bar -->
				<style type="text/css">
					.project-listing { float:right}
					.event-listing.event-listing-classic{ clear:both}
					.uni-orderbar{ margin-bottom:20px}
					@media(max-width:768px){
						.uni-orderbar { width:100%; margin-bottom:20px}
						.uni-orderbar button{ width:100%; text-align:left; padding-left:15px; padding-right:5px}
						.uni-orderbar .dropdown-menu li a{ text-align:left; padding-left:5px}
						.uni-orderbar .dropdown-menu{ width:100%; text-align:center}
						.project-listing { float:left; width:100%; }
						.uni-orderbar button .caret{ float:right; margin-top:7px}
					}
				</style>
				<div class="btn-group uni-orderbar">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					<?php 
					if( (strpos($pageURL, add_query_arg( array('orderby' => 'startdate'), $pageURL )) !== false)){
						echo '<i class="fa fa-calendar"></i>';
						echo __('Start Date','cactusthemes');
					}elseif( (strpos($pageURL, add_query_arg( array('orderby' => 'upcoming'), $pageURL )) !== false) ){
						echo '<i class="fa fa-calendar"></i>';
						echo __('Upcoming','cactusthemes');
					}elseif( (strpos($pageURL, add_query_arg( array('orderby' => 'modified'), $pageURL )) !== false)){
						echo '<i class="fa fa-pencil"></i>';
						echo __('Modified Date','cactusthemes');
					}else{
						echo __('Sort By','cactusthemes'); 
					}?><span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu" role="menu">
					<li>
						<a href="<?php echo esc_url(add_query_arg( array('orderby' => 'upcoming'), $pageURL )); ?>" class="main-color-1"><i class="fa fa-calendar"></i><?php echo __('Upcoming','cactusthemes'); ?></a>
					</li>
					<li>
						<a href="<?php echo esc_url(add_query_arg( array('orderby' => 'startdate'), $pageURL )); ?>" class="main-color-1"><i class="fa fa-chevron-circle-right"></i><?php echo __('Start Date','cactusthemes'); ?></a>
					</li>
					<li>
						<a href="<?php echo esc_url(add_query_arg( array('orderby' => 'modified'), $pageURL )); ?>" class="main-color-1"><i class="fa fa-pencil"></i><?php echo __('Modified Date','cactusthemes'); ?></a>
					</li>
				  </ul>
				</div>
			<?php }
		}
	}
}

if(!function_exists('ct_details_event_course')){
	function check_event_course($product_id){
		$post_type = 'null';
		$args = array(
			'posts_per_page'   => 1,
			'meta_key'         => 'product_id',
			'meta_value'       => $product_id,
			'post_type'        => 'u_event',
		);
		$posts_array = new WP_Query( $args );
		$num_it = $posts_array->post_count;
		if($num_it > 0){
			$post_type = 'u_event';
		}else{
			$args = array(
				'posts_per_page'   => 1,
				'meta_key'         => 'product_id_course',
				'meta_value'       => $product_id,
				'post_type'        => 'u_course',
			);
			$posts_array = new WP_Query( $args );
			$num_it = $posts_array->post_count;
			if($num_it > 0){
				$post_type = 'u_course';
			}
		}
		return $post_type;
	}
	function ct_details_event_course($product_id, $data_if=false){
		$post_type = 'u_event';
		$args = array(
			'posts_per_page'   => 1,
			'meta_key'         => 'product_id',
			'meta_value'       => $product_id,
			'post_type'        => $post_type,
		);
		$posts_array = new WP_Query( $args );
		$num_it = $posts_array->post_count;
		if($num_it < 1){
			$post_type = 'u_course';
			$args = array(
				'posts_per_page'   => 1,
				'meta_key'         => 'product_id_course',
				'meta_value'       => $product_id,
				'post_type'        => $post_type,
			);
			$posts_array = new WP_Query( $args );
		}
		
		if($posts_array->have_posts()){
			while($posts_array->have_posts()){ $posts_array->the_post();
				$it_info_id = get_the_ID();?>
                <?php if($data_if=='checkout'){ ?>
                <td class="event-cpurse-if"><h4 style="margin-bottom:0"><?php if(check_event_course($product_id)=='u_event'){ echo __('Event Details', 'cactusthemes');}elseif(check_event_course($product_id)=='u_course'){ echo __('Course Details', 'cactusthemes');}?></h4></td>
				<?php
				}?>
				<td class="product-event-course" style="padding-top:20px; padding-bottom:20px; <?php if($data_if=='email'){ ?>border:1px solid #eee;border-right:0;<?php }?>">
					<span><a href="<?php the_permalink()?>" title="<?php the_title_attribute()?>"><?php echo get_the_title();  ?></a></span><br>
					<?php 
						if($post_type == 'u_course'){
							$date_format = get_option('date_format');
							$startdate = get_post_meta(get_the_ID(),'u-course-start', true );
							if($startdate){
								$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
								$con_date = new DateTime($startdate);
								$start_datetime = $con_date->format($date_format);
							}?>
							<span class="small-text"><?php _e('START:','cactusthemes') ?><?php echo date_i18n( get_option('date_format'), strtotime($startdate));?></span><br>
							<span class="small-text"><?php _e('DURATION:','cactusthemes') ?><?php echo get_post_meta(get_the_ID(),'u-course-dur', true );?></span><br>
						<?php
						}else{
							$all_day = get_post_meta(get_the_ID(),'all_day', true );
							$date_format = get_option('date_format');
							$hour_format = get_option('time_format');
							$startdate = get_post_meta(get_the_ID(),'u-startdate', true );
							$start_datetime = '';
							$start_hourtime = '';
							if($startdate){
								$startdate_cal = gmdate("Ymd\THis", $startdate);
								$startdate = gmdate("Y-m-d\TH:i:s\Z", $startdate);// convert date ux
								$con_date = new DateTime($startdate);
								$con_hour = new DateTime($startdate);
								$start_datetime = $con_date->format($date_format);
								$start_hourtime = $con_date->format($hour_format);
							}
							$enddate = get_post_meta(get_the_ID(),'u-enddate', true );
							$end_datetime = '';
							$end_hourtime = '';
							if($enddate){
								$enddate_cal = gmdate("Ymd\THis", $enddate);
								$enddate = gmdate("Y-m-d\TH:i:s\Z", $enddate);
								$conv_enddate = new DateTime($enddate);
								$conv_hourtime = new DateTime($enddate);
								$end_datetime = $conv_enddate->format($date_format);
								$end_hourtime = $conv_enddate->format($hour_format);
							}
							?>
								<span class="small-text"><?php esc_html_e('START:','cactusthemes') ?><?php if($startdate){ echo date_i18n( get_option('date_format'), strtotime($startdate));} if($start_datetime && $all_day !=1){ echo ' - '.$start_hourtime;}?></span><br>
								<span class="small-text"><?php esc_html_e('END: ','cactusthemes') ?><?php if($enddate){echo date_i18n( get_option('date_format'), strtotime($enddate));  } if($end_hourtime && $all_day !=1){ echo ' - '.$end_hourtime;}?></span><br>
							<?php
						}
						?>
				</td>
                <?php
				break;
				
			}
			wp_reset_postdata();
		}
		
	}
}
add_theme_support( 'custom-header' );
add_theme_support( 'custom-background' );
/* Functions, Hooks, Filters and Registers in Admin */
require_once 'inc/functions-admin.php';
