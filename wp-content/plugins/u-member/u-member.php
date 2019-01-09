<?php
/**
 * @package University
 * @version 2.0.25
 */
/*
Plugin Name: University Member
Description: Add Members post type. A member can be attached to a U-Course or a LearnDash Course
Author: CactusThemes
Version: 1.13.2.4
Author URI: http://www.cactusthemes.com
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
include('widget/department.php');
include('member-shortcode.php');
include('learndash-lecturers.php');
if(!class_exists('U_member')){	
/*translate settings*/
$text_translate_member_st = __('General','cactusthemes').__('Members Slug','cactusthemes').__('Change member slug. Remember to save the permalink settings again in Settings > Permalinks','cactusthemes').__('Members Department Slug','cactusthemes').__('Change department slug. Remember to save the permalink settings again in Settings > Permalinks','cactusthemes').__('Alphabet filter bar','cactusthemes').__('On','cactusthemes').__('Off','cactusthemes').__('Enable Alphabet filter bar','cactusthemes').__('Department filter bar','cactusthemes').__('Off','cactusthemes').__('On','cactusthemes').__('>Enable Department filter bar','cactusthemes').__('Member Listing Order','cactusthemes').__('Default','cactusthemes').__('Modified Date ','cactusthemes').__('Alphabetically','cactusthemes').__('Single Member','cactusthemes').__('Sidebar','cactusthemes').__('Sidebar Right','cactusthemes').__('Sidebar left','cactusthemes').__('Full Width','cactusthemes').__('Select layout for single member ','cactusthemes').__('Seperate Upcoming and Paste Events/Course Table','cactusthemes').__('Off','cactusthemes').__('On','cactusthemes');
class U_member{
	/* custom template relative url in theme, default is "u_member" */
	public $template_url;
	/* Plugin path */
	public $plugin_path;
	
	/* Main query */
	public $query;
	
	public function __construct() {
		// constructor
		$this->includes();
		$this->register_configuration();
		
		add_action( 'init', array($this,'init'), 0);
	}

	function u_member_scripts_styles() {
		global $wp_styles;
		
		/*
		 * Loads our main javascript.
		 */	
		
		wp_enqueue_script( 'custom',plugins_url('/js/custom.js', __FILE__) , array(), '', true );
	}
	
	function includes(){
		// custom meta boxes
		include_once('member-functions.php');
		if(!function_exists('cmb_init')){
			include_once('includes/Custom-Meta-Boxes-master/custom-meta-boxes.php');
			include_once('includes/options-page/options-page.php');
		}
		
		//include_once('classes/u-member-query.php');
	}
	
	/* This is called as soon as possible to set up options page for the plugin
	 * after that, $this->get_option($name) can be called to get options.
	 *
	 */
	function register_configuration(){
		global $u_member_settings;

		$u_member_settings = new Options_Page('u_member', array('option_file'=>dirname(__FILE__) . '/options.xml','menu_title'=>__('U-Member Settings','cactusthemes'),'menu_position'=>null), array('page_title'=>__('U-Member Setting Page','cactusthemes'),'submit_text'=>'Save'));
		
	}
	
	/* Get main options of the plugin. If there are any sub options page, pass Options Page Id to the second args
	 *
	 *
	 */
	function get_option($option_name, $op_id = ''){
		//return $GLOBALS[$op_id != ''?$op_id:'u_member_settings']->get($option_name);
	}
	
	function init(){
		// Variables
		$this->template_url			= apply_filters( 'u_member_template_url', 'u-member/' );
		$this->register_taxonomies();		
		add_filter( 'cmb_meta_boxes', array($this,'register_post_type_metadata') );
		
		//add_filter('manage_edit-u_member_columns', array($this,'custom_u_member_column_manage'));
		add_action('manage_u_member_posts_custom_column', array($this,'custom_u_member_column_value'));
		
		//add_filter('manage_edit-affproduct_columns', array($this,'custom_affproduct_column_manage'));
		//add_action('manage_affproduct_posts_custom_column', array($this,'custom_affproduct_column_value'));
		
		add_filter('manage_edit-u_member_cat_columns', array($this,'custom_u_member_cat_column_manage'));
		add_filter('manage_u_member_cat_custom_column', array($this,'custom_u_member_cat_column_value'));
		
		/*if ( ! is_admin() || defined('DOING_AJAX') ) {
			$this->query = new U_member_Query();
		}*/
		
		add_filter( 'template_include', array( $this, 'template_loader' ) );
		add_action( 'template_redirect', array($this, 'template_redirect' ) );
		add_action( 'wp_enqueue_scripts', array($this, 'u_member_scripts_styles') );
		
		add_image_size('thumb_255x255',255,255, true);
	}	
	/**
	 * Get the plugin path.
	 *
	 * @access public
	 * @return string
	 */
	public function plugin_path() {
		if ( $this->plugin_path ) return $this->plugin_path;

		return $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
	}
	/**
	 *
	 * Load custom page template for specific pages 
	 *
	 * @return string
	 */
	function template_loader($template){
		$find = array('u-member.php');
		$file = '';
		
		if(is_post_type_archive( 'u_member' ) || is_page('member') || is_tax('u_department')){
			$file = 'member-listing.php';
			$find[] = $file;
			$find[] = $this->template_url . $file;
		}elseif(is_singular('u_member')){
			$file = 'single-member.php';
			$find[] = $file;
			$find[] = $this->template_url . $file;
		}
		if ( $file ) {
			$template = locate_template( $find );
			
			if ( ! $template ) $template = $this->plugin_path() . '/templates/' . $file;
		}
		return $template;	
	}	
	/**
	 * Handle redirects before content is output - hooked into template_redirect so is_page works.
	 *
	 * @access public
	 * @return void
	 */
	function template_redirect(){
		global $u_member, $wp_query;

		// When default permalinks are enabled, redirect stores page to post type archive url
		if ( ! empty( $_GET['page_id'] ) && get_option( 'permalink_structure' ) == "" && $_GET['page_id'] ==  'member' ) {
			wp_safe_redirect( get_post_type_archive_link('u_member') );
			exit;
		}
	}
	
	/* Add or remove columns in u_member manage page */
	function custom_u_member_column_manage($columns) {
		// add or reset columns
		if($this->get_option('store-cat-enabled') == 1){ 
			$columns['taxonomy-u_member_cat'] = __('U-Member Categories','cactusthemes');
		}
		if($this->get_option('store-type-enabled') == 1){ 
			$columns['taxonomy-u_member_type'] = __('Store Type','cactusthemes');
		}
		if($this->get_option('store-tag-enabled') == 1){ 
			$columns['taxonomy-u_member_tag'] = __('Store Tags','cactusthemes');
		}
		$columns['views'] = __('Clicks/Views','cactusthemes');
		$columns['product_count'] = __('Products','cactusthemes');
		
		$columns_show = $this->get_option('store-admin-columns');
		// All columns: category,type,tag,view,product
		$alls = array("taxonomy-u_member_cat","taxonomy-u_member_type","taxonomy-u_member_tag","views","product_count");
		foreach($alls as $col){
			if(!in_array($col,$columns_show)){
				unset($columns[$col]);
			}
		}
		
		return $columns;
    }
	
	/* Add or remove columns in u_member_cat manage page */
	function custom_u_member_cat_column_manage($columns) {
		// add or reset columns		
		
		return $columns;
    }
	
	/* return value for columns in u_member manage page */
	function custom_u_member_column_value($name) {
		global $post;
		$val = '';
		
		switch ($name) {
			case 'views':
				$view = get_post_meta($post->ID, 'views', true);
				$click = get_post_meta($post->ID, 'clicks', true);
				if($view == '') $view = 0;
				if($click == '') $click = 0;
				$val = $view . '/' . $click;
				break;
			case 'product_count':
				$args = array('meta_key'=>'store_id','meta_value'=>$post->ID,'post_type'=>'affproduct');
				$query = new WP_Query($args);
				$val = $query->found_posts;
				break;
		}
		
		echo $val;
    }
	
	/* return value for columns in u_member_cat manage page */
	function custom_u_member_cat_column_value($name) {
		global $post;
		switch ($name) {
			case 'views':
				$views = get_post_meta($post->ID, 'views', true);
		}
		
		return 'no';
    }
	
	function register_taxonomies(){
		$this->register_u_member();
	}
	
	/* Register u_member post type and its custom taxonomies */
	function register_u_member(){
		$labels = array(
			'name'               => __('Member', 'cactusthemes'),
			'singular_name'      => __('Member', 'cactusthemes'),
			'add_new'            => __('Add New Member', 'cactusthemes'),
			'add_new_item'       => __('Add New Member', 'cactusthemes'),
			'edit_item'          => __('Edit Member', 'cactusthemes'),
			'new_item'           => __('New Member', 'cactusthemes'),
			'all_items'          => __('All Members', 'cactusthemes'),
			'view_item'          => __('View Member', 'cactusthemes'),
			'search_items'       => __('Search Member', 'cactusthemes'),
			'not_found'          => __('No Member found', 'cactusthemes'),
			'not_found_in_trash' => __('No Member found in Trash', 'cactusthemes'),
			'parent_item_colon'  => '',
			'menu_name'          => __('U-Member', 'cactusthemes'),
		  );
		$slug_mb =  cop_get('u_member_settings','umember-slug');
		$slug_tax_mb =  cop_get('u_member_settings','umember-dep');
		if($slug_mb==''){
			$slug_mb = 'member';
		}
		if ( $slug_mb )
			$rewrite =  array( 'slug' => untrailingslashit( $slug_mb ), 'with_front' => false, 'feeds' => true );
		else
			$rewrite = false;	

		  $args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => $rewrite,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
		  );
		register_post_type( 'u_member', $args );
		/* Register member Categories */
		$u_department_labels = array(
			'name'=> __('U-Department','cactusthemes'),
			'singular_name'=>__('U-Department','cactusthemes')
		);
		//register_taxonomy('u_project_tags', 'u_project', array('labels'=>$u_project_tag_labels,'meta_box_cb'=>array($this,'u_project_type_meta_box_cb')));
		register_taxonomy('u_department', 'u_member', array('labels'=>$u_department_labels,'show_admin_column'=>true,'hierarchical'=>true,'rewrite'=>array('slug'=> $slug_tax_mb),'meta_box_cb'=>array($this,'u_member_categories_meta_box_cb')));
	}
		
	/* Register meta box for Store Type 
	 * Wordpress 3.8
	 */
	function u_member_type_meta_box_cb($post, $box){
		$defaults = array('taxonomy' => 'post_tag');
		if ( !isset($box['args']) || !is_array($box['args']) )
			$args = array();
		else
			$args = $box['args'];
		extract( wp_parse_args($args, $defaults), EXTR_SKIP );
		$tax_name = esc_attr($taxonomy);
		$taxonomy = get_taxonomy($taxonomy);
		$user_can_assign_terms = current_user_can( $taxonomy->cap->assign_terms );
		$comma = _x( ',', 'tag delimiter' );
		?>
		<div class="tagsdiv" id="<?php echo $tax_name; ?>">
			<div class="jaxtag">
			<div class="nojs-tags hide-if-js">
			<p><?php echo $taxonomy->labels->add_or_remove_items; ?></p>
			<textarea name="<?php echo "tax_input[$tax_name]"; ?>" rows="3" cols="20" class="the-tags" id="tax-input-<?php echo $tax_name; ?>" <?php disabled( ! $user_can_assign_terms ); ?>><?php echo str_replace( ',', $comma . ' ', get_terms_to_edit( $post->ID, $tax_name ) ); // textarea_escaped by esc_attr() ?></textarea></div>
			<?php if ( $user_can_assign_terms ) : ?>
			<div class="ajaxtag hide-if-no-js">
				<label class="screen-reader-text" for="new-tag-<?php echo $tax_name; ?>"><?php echo $box['title']; ?></label>
				<div class="taghint"><?php echo $taxonomy->labels->add_new_item; ?></div>
				<p><input type="text" id="new-tag-<?php echo $tax_name; ?>" name="newtag[<?php echo $tax_name; ?>]" class="newtag form-input-tip" size="16" autocomplete="off" value="" />
				<input type="button" class="button tagadd" value="<?php esc_attr_e('Add'); ?>" /></p>
			</div>
			<p class="howto"><?php echo $taxonomy->labels->separate_items_with_commas; ?></p>
			<?php endif; ?>
			</div>
			<div class="tagchecklist"></div>
		</div>
		<?php if ( $user_can_assign_terms ) : ?>
		<p class="hide-if-no-js"><a href="#titlediv" class="tagcloud-link" id="link-<?php echo $tax_name; ?>"><?php echo $taxonomy->labels->choose_from_most_used; ?></a></p>
		<?php endif; ?>
		<?php
	}
	
	/**
	 * Display post categories form fields.
	 *
	 * @since 2.6.0
	 *
	 * @param object $post
	 */
	function u_member_categories_meta_box_cb( $post, $box ) {
	$defaults = array('taxonomy' => 'category');
	if ( !isset($box['args']) || !is_array($box['args']) )
		$args = array();
	else
		$args = $box['args'];
	extract( wp_parse_args($args, $defaults), EXTR_SKIP );
	$tax = get_taxonomy($taxonomy);

	?>
	<div id="taxonomy-<?php echo $taxonomy; ?>" class="categorydiv">
		<ul id="<?php echo $taxonomy; ?>-tabs" class="category-tabs">
			<li class="tabs"><a href="#<?php echo $taxonomy; ?>-all"><?php echo $tax->labels->all_items; ?></a></li>
			<li class="hide-if-no-js"><a href="#<?php echo $taxonomy; ?>-pop"><?php _e( 'Most Used' ); ?></a></li>
		</ul>

		<div id="<?php echo $taxonomy; ?>-pop" class="tabs-panel" style="display: none;">
			<ul id="<?php echo $taxonomy; ?>checklist-pop" class="categorychecklist form-no-clear" >
				<?php $popular_ids = wp_popular_terms_checklist($taxonomy); ?>
			</ul>
		</div>

		<div id="<?php echo $taxonomy; ?>-all" class="tabs-panel">
			<?php
            $name = ( $taxonomy == 'category' ) ? 'post_category' : 'tax_input[' . $taxonomy . ']';
            echo "<input type='hidden' name='{$name}[]' value='0' />"; // Allows for an empty term set to be sent. 0 is an invalid Term ID and will be ignored by empty() checks.
            ?>
			<ul id="<?php echo $taxonomy; ?>checklist" data-wp-lists="list:<?php echo $taxonomy?>" class="categorychecklist form-no-clear">
				<?php wp_terms_checklist($post->ID, array( 'taxonomy' => $taxonomy, 'popular_cats' => $popular_ids ) ) ?>
			</ul>
		</div>
	<?php if ( current_user_can($tax->cap->edit_terms) ) : ?>
			<div id="<?php echo $taxonomy; ?>-adder" class="wp-hidden-children">
				<h4>
					<a id="<?php echo $taxonomy; ?>-add-toggle" href="#<?php echo $taxonomy; ?>-add" class="hide-if-no-js">
						<?php
							/* translators: %s: add new taxonomy label */
							printf( __( '+ %s' ), $tax->labels->add_new_item );
						?>
					</a>
				</h4>
				<p id="<?php echo $taxonomy; ?>-add" class="category-add wp-hidden-child">
					<label class="screen-reader-text" for="new<?php echo $taxonomy; ?>"><?php echo $tax->labels->add_new_item; ?></label>
					<input type="text" name="new<?php echo $taxonomy; ?>" id="new<?php echo $taxonomy; ?>" class="form-required form-input-tip" value="<?php echo esc_attr( $tax->labels->new_item_name ); ?>" aria-required="true"/>
					<label class="screen-reader-text" for="new<?php echo $taxonomy; ?>_parent">
						<?php echo $tax->labels->parent_item_colon; ?>
					</label>
					<?php wp_dropdown_categories( array( 'taxonomy' => $taxonomy, 'hide_empty' => 0, 'name' => 'new'.$taxonomy.'_parent', 'orderby' => 'name', 'hierarchical' => 1, 'show_option_none' => '&mdash; ' . $tax->labels->parent_item . ' &mdash;' ) ); ?>
					<input type="button" id="<?php echo $taxonomy; ?>-add-submit" data-wp-lists="add:<?php echo $taxonomy ?>checklist:<?php echo $taxonomy ?>-add" class="button category-add-submit" value="<?php echo esc_attr( $tax->labels->add_new_item ); ?>" />
					<?php wp_nonce_field( 'add-'.$taxonomy, '_ajax_nonce-add-'.$taxonomy, false ); ?>
					<span id="<?php echo $taxonomy; ?>-ajax-response"></span>
				</p>
			</div>
		<?php endif; ?>
	</div>
	<?php

}
	
	function register_post_type_metadata(array $meta_boxes){
		// register aff store metadata
		$u_member_fields_layout = array(	
			array( 'id' => 'member-sidebar', 'name' => __('Sidebar', 'cactusthemes'), 'type' => 'select', 'options' => array( 'def' => __('Default', 'cactusthemes'), 'left' => __('Left', 'cactusthemes'), 'right' => __('Right', 'cactusthemes'), 'full' => __('Hidden', 'cactusthemes')),'desc' => __('Select "Default" to use settings in Theme Options', 'cactusthemes'), 'repeatable' => false, 'multiple' => false),
			array( 'id' => 'member-ctpadding', 'name' => __('Content Padding', 'cactusthemes'), 'type' => 'select', 'options' => array( 'on' => __('On', 'cactusthemes'), 'off' => __('Off', 'cactusthemes')),'desc' => __('Enable default top and bottom padding  for content (30px)', 'cactusthemes'), 'repeatable' => false, 'multiple' => false ),
		);
		
		$meta_boxes[] = array(
			'title' => __('Layout settings','cactusthemes'),
			'pages' => 'u_member',
			'fields' => $u_member_fields_layout,
			'priority' => 'high'
		);	
		$u_member_fields2 = array(	
				array( 'id' => 'u-member-pos', 'name' => __('Position:', 'cactusthemes'), 'type' => 'text','desc' => __('Position/Title of member', 'cactusthemes') , 'repeatable' => false, 'multiple' => false ),
				array( 'id' => 'umb-facebook', 'name' => __('Facebook:', 'cactusthemes'), 'type' => 'text' ,'desc' => __('Enter full link to member profile page', 'cactusthemes'), 'repeatable' => false, 'multiple' => false ),
				array( 'id' => 'umb-instagram', 'name' => __('Instagram:', 'cactusthemes'), 'type' => 'text' ,'desc' => __('Enter full link to member profile page', 'cactusthemes'), 'repeatable' => false, 'multiple' => false ),	
				array( 'id' => 'umb-envelope', 'name' => __('Email:', 'cactusthemes'), 'type' => 'text' ,'desc' => __('Enter email contact of member', 'cactusthemes'), 'repeatable' => false, 'multiple' => false ),
				array( 'id' => 'umb-twitter', 'name' => __('Twitter:', 'cactusthemes'), 'type' => 'text' ,'desc' => __('Enter full link to member profile page', 'cactusthemes'), 'repeatable' => false, 'multiple' => false ),
				array( 'id' => 'umb-linkedin', 'name' => __('LinkedIn:', 'cactusthemes'), 'type' => 'text' ,'desc' => __('Enter full link to member profile page', 'cactusthemes'), 'repeatable' => false, 'multiple' => false),	
				array( 'id' => 'umb-tumblr', 'name' => __('Tumblr:', 'cactusthemes'), 'type' => 'text' ,'desc' => __('Enter full link to member profile page', 'cactusthemes'), 'repeatable' => false, 'multiple' => false ),	
				array( 'id' => 'umb-google-plus', 'name' => __('Google Plus:', 'cactusthemes'), 'type' => 'text' ,'desc' => __('Enter full link to member profile page', 'cactusthemes'), 'repeatable' => false, 'multiple' => false ),
				array( 'id' => 'umb-pinterest', 'name' => __('Pinterest:', 'cactusthemes'), 'type' => 'text' ,'desc' => __('Enter full link to member profile page', 'cactusthemes') , 'repeatable' => false, 'multiple' => false),	
				array( 'id' => 'umb-youtube', 'name' => __('YouTube:', 'cactusthemes'), 'type' => 'text' ,'desc' => __('Enter full link to member profile page', 'cactusthemes'), 'repeatable' => false, 'multiple' => false ),	
				array( 'id' => 'umb-flickr', 'name' => __('Flickr:', 'cactusthemes'), 'type' => 'text' ,'desc' => __('Enter full link to member profile page', 'cactusthemes') , 'repeatable' => false, 'multiple' => false),	
				array( 'id' => 'umb-github ', 'name' => __('GitHub:', 'cactusthemes'), 'type' => 'text' ,'desc' => __('Enter full link to member profile page', 'cactusthemes'), 'repeatable' => false, 'multiple' => false ),	
				array( 'id' => 'umb-dribbble', 'name' => __('Dribbble:', 'cactusthemes'), 'type' => 'text' ,'desc' => __('Enter full link to member profile page', 'cactusthemes') , 'repeatable' => false, 'multiple' => false),
				array( 'id' => 'umb-vk', 'name' => __('VK:', 'cactusthemes'), 'type' => 'text' ,'desc' => __('Enter full link to member profile page', 'cactusthemes') , 'repeatable' => false, 'multiple' => false),
			);

		$meta_boxes[] = array(
			'title' => __('Member Info','cactusthemes'),
			'pages' => 'u_member',
			'fields' => $u_member_fields2,
			'priority' => 'high'
		);
		$u_member_fields3 = array(	
				array( 'id' => 'learndash_member_id', 'name' => __('Speakers','cactusthemes'), 'type' => 'post_select', 'use_ajax' => true, 'query' => array( 'post_type' => 'u_member' ), 'multiple' => true,  'desc' => __('Choose from members','cactusthemes') , 'repeatable' => false),
			);

		$meta_boxes[] = array(
			'title' => __('Speakers','cactusthemes'),
			'pages' => 'sfwd-courses',
			'fields' => $u_member_fields3,
			'priority' => 'high'
		);		
		return $meta_boxes;
	}
}


} // class_exists check
if ( ! function_exists( 'u_member_get_page_id' ) ) {

	/**
	 * Affiliatez page IDs
	 *
	 * retrieve page ids - used for myaccount, edit_address, change_password, shop, cart, checkout, pay, view_order, thanks, terms
	 *
	 * returns -1 if no page is found
	 *
	 * @access public
	 * @param string $page
	 * @return int
	 */
	/*function u_member_get_page_id( $page ) {
		global $affiliatez;
		$page = apply_filters('affiliatez_get_' . $page . '_page_id', $affiliatez->get_option($page . '-page-id'));
		return ( $page ) ? $page : -1;
	}*/
}

/**
 * Init u_member
 */
$GLOBALS['u_member'] = new U_member();
?>