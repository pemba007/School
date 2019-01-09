<?php
/**
 * @package University
 * @version 2.0.25
 */
/*
Plugin Name: University Project
Description: Project-related features for University theme
Author: Cactusthemes
Version: 1.10.4.4
Author URI: http://www.cactusthemes.com
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if(!class_exists('U_project')){	
/*translate settings*/
$text_translate_member_st = __('General','cactusthemes').__('Project Slug','cactusthemes').__('Change project slug. Remember to save the permalink settings again in Settings > Permalinks','cactusthemes').__('Project Categories Slug','cactusthemes').__('Change project categories slug. Remember to save the permalink settings again in Settings > Permalinks','cactusthemes').__('Default Metadata','cactusthemes').__('Define default metadata for all projects, ex: Client, Services...','cactusthemes').__('Filter bar','cactusthemes').__('Enable','cactusthemes').__('Disable','cactusthemes').__('Enable filter bar','cactusthemes').__('Single Project','cactusthemes').__('Sidebar','cactusthemes').__('Full Width','cactusthemes').__('Sidebar Right','cactusthemes').__('Sidebar left','cactusthemes').__('Select default layout for single project pages ','cactusthemes').__('Related Project','cactusthemes').__('Number of items','cactusthemes').__('Project navigation','cactusthemes').__('All projects ','cactusthemes').__('Same category','cactusthemes').__('Choose which project to navigate when in a single project page','cactusthemes');
class U_project{
	/* custom template relative url in theme, default is "U_project" */
	public $template_url;
	public static $woocommerce;
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
	function u_project_scripts_styles() {
		global $wp_styles;
		
		/*
		 * Loads our main javascript.
		 */	
		
		wp_enqueue_script( 'custom',plugins_url('/js/custom.js', __FILE__) , array(), '', true );
	}
	
	function includes(){
		// custom meta boxes
		include_once('project-functions.php');
		if(!function_exists('cmb_init')){
			if(!class_exists('CMB_Meta_Box')){
				include_once('includes/Custom-Meta-Boxes-master/custom-meta-boxes.php');
			}
		}
		if(!class_exists('Options_Page')){
			include_once('includes/options-page/options-page.php');
		}
		//include_once('classes/u-project-query.php');
	}
	
	/* This is called as soon as possible to set up options page for the plugin
	 * after that, $this->get_option($name) can be called to get options.
	 *
	 */
	function register_configuration(){
		global $u_project_settings;
		$u_project_settings = new Options_Page('u_project_settings', array('option_file'=>dirname(__FILE__) . '/options.xml','menu_title'=>__('U-Project Settings','cactusthemes'),'menu_position'=>null), array('page_title'=>__('U-Project Setting Page','cactusthemes'),'submit_text'=>'Save'));
	}
	
	/* Get main options of the plugin. If there are any sub options page, pass Options Page Id to the second args
	 *
	 *
	 */
	function get_option($option_name, $op_id = ''){
		return $GLOBALS[$op_id != ''?$op_id:'u_project_settings']->get($option_name);
	}
	
	function init(){
		// Variables
		$this->template_url			= apply_filters( 'u_project_template_url', 'u-project/' );
		if(isset($GLOBALS['woocommerce'])){
			self::$woocommerce=$GLOBALS['woocommerce'];
		}
		$this->register_taxonomies();		
		add_filter( 'cmb_meta_boxes', array($this,'register_post_type_metadata') );
		add_action( 'admin_init', array( $this, 'project_meta' ) );		
		add_filter( 'template_include', array( $this, 'template_loader' ) );
		add_action( 'template_redirect', array($this, 'template_redirect' ) );
		add_action( 'wp_enqueue_scripts', array($this, 'u_project_scripts_styles') );
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
		$find = array('u-project.php');
		$file = '';
		
		if(is_post_type_archive( 'u_project' ) || is_page('project') || is_tax('u_project_cat')){
			$file = 'project-listing.php';
			$find[] = $file;
			$find[] = $this->template_url . $file;
		}
		elseif(is_singular('u_project')){
			$file = 'single-project.php';
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
		global $u_project, $wp_query;

		// When default permalinks are enabled, redirect stores page to post type archive url
		if ( ! empty( $_GET['page_id'] ) && get_option( 'permalink_structure' ) == "" && $_GET['page_id'] ==  'project' ) {
			wp_safe_redirect( get_post_type_archive_link('u_project') );
			exit;
		}
	}
	
	function register_taxonomies(){
		$this->register_u_project();
	}
	
	/* Register u_project post type and its custom taxonomies */
	function register_u_project(){
		$labels = array(
			'name'               => __('Project', 'cactusthemes'),
			'singular_name'      => __('Project', 'cactusthemes'),
			'add_new'            => __('Add New Project', 'cactusthemes'),
			'add_new_item'       => __('Add New Project', 'cactusthemes'),
			'edit_item'          => __('Edit Project', 'cactusthemes'),
			'new_item'           => __('New Project', 'cactusthemes'),
			'all_items'          => __('All Projects', 'cactusthemes'),
			'view_item'          => __('View Project', 'cactusthemes'),
			'search_items'       => __('Search Project', 'cactusthemes'),
			'not_found'          => __('No Project found', 'cactusthemes'),
			'not_found_in_trash' => __('No Project found in Trash', 'cactusthemes'),
			'parent_item_colon'  => '',
			'menu_name'          => __('U-Project', 'cactusthemes'),
		  );
		$slug_ev =  $this->get_option('uproject-slug');
		$slug_cat_project =  $this->get_option('uproject-cat-slug');
		if($slug_ev==''){
			$slug_ev = 'project';
		}
		if ( $slug_ev )
			$rewrite =  array( 'slug' => untrailingslashit( $slug_ev ), 'with_front' => false, 'feeds' => true );
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
		register_post_type( 'u_project', $args );
		
		/* Register project Categories */
		$u_project_cat_labels = array(
			'name'=>__('U-Project Categories','cactusthemes'),
			'singular_name'=>__('U-Project Category','cactusthemes')
		);
		$u_project_tag_labels = array(
			'name'=>'U-Project Tags',
			'singular_name'=>'U-Project Tags'
		);
		//register_taxonomy('u_project_tags', 'u_project', array('labels'=>$u_project_tag_labels,'meta_box_cb'=>array($this,'u_project_type_meta_box_cb')));
		register_taxonomy('u_project_cat', 'u_project', array('labels'=>$u_project_cat_labels,'show_admin_column'=>true,'hierarchical'=>true,'rewrite'=>array('slug'=>$slug_cat_project),'meta_box_cb'=>array($this,'u_project_categories_meta_box_cb')));
	}
		
	/* Register meta box for Store Type 
	 * Wordpress 3.8
	 */
	function u_project_type_meta_box_cb($post, $box){
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
	function u_project_categories_meta_box_cb( $post, $box ) {
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
		$u_project_fields_layout = array(	
			array( 'id' => 'project-sidebar', 'name' => __('Sidebar', 'cactusthemes'), 'type' => 'select', 'options' => array( 'def' => __('Default', 'cactusthemes'), 'left' => __('Left', 'cactusthemes'), 'right' => __('Right', 'cactusthemes'), 'full' => __('Hidden', 'cactusthemes')),'desc' => __('Select "Default" to use settings in Theme Options', 'cactusthemes'), 'repeatable' => false, 'multiple' => false),
			array( 'id' => 'project-ctpadding', 'name' => __('Content Padding', 'cactusthemes'), 'type' => 'select', 'options' => array( 'on' => __('On', 'cactusthemes'), 'off' => __('Off', 'cactusthemes') ),'desc' => __('Enable default top and bottom padding  for content (30px)', 'cactusthemes'), 'repeatable' => false, 'multiple' => false),
		);
		$meta_boxes[] = array(
			'title' => __('Layout settings','cactusthemes'),
			'pages' => 'u_project',
			'fields' => $u_project_fields_layout,
			'priority' => 'high'
		);	
		return $meta_boxes;
	}
	
	function project_meta(){
		//option tree
		  $meta_box_review = array(
			'id'        => 'meta_box_project',
			'title'     => __('Metadata', 'cactusthemes'),
			'desc'      => __('Metadata is set in U-Project Settings > Default Metadata. You can also add new metadata here', 'cactusthemes'),
			'pages'     => array( 'u_project' ),
			'context'   => 'normal',
			'priority'  => 'high',
			'fields'    => array(
		  	)
		  );
		  $tmr_criteria = $this->get_option('uproject-defmeta');
		  $tmr_criteria = $tmr_criteria?explode(",", $tmr_criteria):'';
		  if($tmr_criteria){
			  foreach($tmr_criteria as $criteria){
				  $meta_box_review['fields'][] = array(
					  'id'          => 'project_'.sanitize_title($criteria),
					  'label'       => $criteria,
					  'desc'        => '',
					  'std'         => '',
					  'type'        => 'text',
					  'class'       => '',
					  'choices'     => array()
				  );
			  }
		  }
		  $meta_box_review['fields'][] = array(
				'label'       => __('Custom Metadata', 'cactusthemes'),
				'id'          => 'custom_meta',
				'type'        => 'list-item',
				'class'       => '',
				'desc'        => __('Add custom Metadata', 'cactusthemes'),
				'choices'     => array(),
				'settings'    => array(
					 array(
						'label'       => __('Content', 'cactusthemes'),
						'id'          => 'conttent_custom',
						'type'        => 'text',
						'desc'        => '',
						'std'         => '',
						'rows'        => '',
						'post_type'   => '',
						'taxonomy'    => ''
					 ),
				)
		  );
		  if (function_exists('ot_register_meta_box')) {
			ot_register_meta_box( $meta_box_review );
		  }
	}

}


} // class_exists check
if ( ! function_exists( 'u_project_get_page_id' ) ) {

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
	 /* function u_project_get_page_id( $page ) {
		  global $affiliatez;
		  $page = apply_filters('affiliatez_get_' . $page . '_page_id', $affiliatez->get_option($page . '-page-id'));
		  return ( $page ) ? $page : -1;
	  }*/
}

/**
 * Init u_project
 */
$GLOBALS['u_project'] = new U_project();
?>