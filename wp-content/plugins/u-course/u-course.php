<?php
/**
 * @package University
 * @version 2.0.25
 */
/*
Plugin Name: University Course
Description: Course-related features for University Theme
Author: CactusThemes
Version: 1.14.4.1
Author URI: http://www.cactusthemes.com
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
include('widget/latest-course.php');
include('widget/course-search.php');
include('course-list-table.php');
if(!class_exists('U_course')){
/*translate settings*/
$text_translate_course_st = __('General','cactusthemes').__('Course Slug','cactusthemes').__('Change course slug. Remember to save the permalink settings again in Settings > Permalinks','cactusthemes').__('Course Categories Slug','cactusthemes').__('Change course categories slug. Remember to save the permalink settings again in Settings > Permalinks','cactusthemes').__('Posts Per Page','cactusthemes').__('Filter bar','cactusthemes').__('Disable','cactusthemes').__('Enable','cactusthemes').__('Enable filter bar','cactusthemes').__('Single Course','cactusthemes').__('Sidebar','cactusthemes').__('Sidebar Right','cactusthemes').__('Sidebar left','cactusthemes').__('Full Width','cactusthemes').__('Select default layout for single course pages','cactusthemes').__('Related Courses','cactusthemes').__('Number of items','cactusthemes').__('Course Listing Order','cactusthemes').__('Course Listing Order Bar','cactusthemes').__('Show Price','cactusthemes').__('Hide','cactusthemes').__('Show','cactusthemes');	
class U_course{
	/* custom template relative url in theme, default is "u_course" */
	public $template_url;
	/* Plugin path */
	public $plugin_path;
	public static $woocommerce;
	/* Main query */
	public $query;
	
	public function __construct() {
		// constructor
		$this->includes();
		$this->register_configuration();
		
		add_action( 'init', array($this,'init'), 0);
	}
	// WC deposits support
	function ct_wc_disposit_form($product_id){
		if(class_exists('WC_Deposits_Product_Manager')){
			if ( WC_Deposits_Product_Manager::deposits_enabled( $product_id )) {
				wp_enqueue_script( 'wc-deposits-frontend' );?>
				<div class="wc-deposits-wrapper <?php echo WC_Deposits_Product_Manager::deposits_forced( $product_id ) ? 'wc-deposits-forced' : 'wc-deposits-optional'; ?>">
					<?php if ( ! WC_Deposits_Product_Manager::deposits_forced( $product_id ) ) : ?>
						<ul class="wc-deposits-option">
							<li><input type="radio" name="wc_deposit_option" value="yes" id="wc-option-pay-deposit" /><label for="wc-option-pay-deposit"><?php esc_html_e('Pay Deposit','cactusthemes');?></label></li>
							<li><input type="radio" name="wc_deposit_option" value="no" id="wc-option-pay-full" /><label for="wc-option-pay-full"><?php esc_html_e('Pay in Full','cactusthemes');?></label></li>
						</ul>
					<?php endif; ?>
				
					<?php if ( 'plan' === WC_Deposits_Product_Manager::get_deposit_type( $product_id ) ) : ?>
						<ul class="wc-deposits-payment-plans">
							<?php foreach( WC_Deposits_Plans_Manager::get_plans_for_product( $product_id ) as $key => $plan ) : ?>
								<li class="wc-deposits-payment-plan">
									<input type="radio" name="wc_deposit_payment_plan" <?php checked( $key, 0 ); ?> value="<?php echo esc_attr( $plan->get_id() ); ?>" id="wc-deposits-payment-plan-<?php echo esc_attr( $plan->get_id() ); ?>" /><label for="wc-deposits-payment-plan-<?php echo esc_attr( $plan->get_id() ); ?>">
										<strong class="wc-deposits-payment-plan-name"><?php echo esc_html( $plan->get_name() ); ?></strong>
										<small class="wc-deposits-payment-plan-description"><?php echo wp_kses_post( $plan->get_description() ); ?></small>
									</label>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php else : ?>
						<div class="wc-deposits-payment-description">
							<?php echo WC_Deposits_Product_Manager::get_formatted_deposit_amount( $product_id ); ?>
						</div>
					<?php endif; ?>
				</div>
				<?php
			}
		}
	}
	/**
	 * Gets product price
     *
     * @access public
	 * @param int $ID
	 * @param bool $numeric
     * @return string
     */
	function getPrice() {
		$price['text'] = __('Free', 'cactusthemes');
		$price['number'] = 0;
		$price['type'] = 'simple';
		$product_id = get_post_meta(get_the_ID(),'product_id_course', true );
		if(function_exists('wc_get_product')){
			$product = wc_get_product($product_id);
			if($product !== false) {

				if($product->is_type('variable')){
					$price['type'] = 'variable';
					$price = $variations = $product->get_available_variations();
					
				} else {
					if($product->get_price_html() != ''){
						$price['text'] = $product->get_price_html();
					}

					if($product->get_price() != ''){
						$price['number'] = $product->get_price();
					}
				}
			}
		}
		return $price;
	}
	function getPrice_num_course() {
		$price['text'] = __('Free', 'cactusthemes');
		$price['number'] = 0;
		$price['type'] = 'simple';
		$product_id = get_post_meta(get_the_ID(),'product_id_course', true );
		if(function_exists('wc_get_product')){
			$product = wc_get_product($product_id);
			if($product !== false) {
				
				$price['type'] = ($product->is_type('simple') ? 'simple' : ($product->is_type('variable') ? 'variable' : ''));

				$price = $product->get_price();
			}
		}
		return $price;
	}

	/**
	 * Gets available
     *
     */
	function getAvailable() {
		$variations = '';
		$product_id = get_post_meta(get_the_ID(),'product_id_course', true );
		if(function_exists('wc_get_product')){
		$product = wc_get_product($product_id);
			if($product !== false) {
				$variations = ($product->is_type('simple') ? 'simple' : ($product->is_type('variable') ? 'variable' : ''));
			}
		}
		return $variations;
	}
	//check and add to cart
	public static function checkCourse() {
		if(is_singular('u_course')|| is_singular('u_event')){
			$product_id = get_post_meta(get_the_ID(),'product_id', true );
			if($product_id==''){
			$product_id = get_post_meta(get_the_ID(),'product_id_course', true );
			}
			if(isset($_POST['event_action'])) {	
				switch($_POST['event_action']) {
					case 'add':
						//if($status =='premium') {
							self::addProduct($product_id,$_POST['num_ticket'],$_POST['event_variation']);
						//} else {
							//self::addUser();
						//}
					break;
					
					case 'remove':
						
					break;
				}
			}
		}
	}
	//Add product and redirect
	public static function addProduct($ID=0,$num_ticket,$variation) {
		self::$woocommerce->cart->empty_cart();
		self::$woocommerce->cart->add_to_cart($ID, $num_ticket,$variation);
		wp_redirect(self::$woocommerce->cart->get_checkout_url());
		exit();
	}	
	function u_course_scripts_styles() {
		global $wp_styles;
		
		/*
		 * Loads our main javascript.
		 */	
		
		wp_enqueue_script( 'custom',plugins_url('/js/custom.js', __FILE__) , array(), '', true );
	}
	
	function includes(){
		// custom meta boxes
		include_once('course-functions.php');
		if(!function_exists('cmb_init')){
			if(!class_exists('CMB_Meta_Box')){
				include_once('includes/Custom-Meta-Boxes-master/custom-meta-boxes.php');
			}
		}
		if(!class_exists('Options_Page')){
			include_once('includes/options-page/options-page.php');
		}
		
		//include_once('classes/u-course-query.php');
	}
	
	/* This is called as soon as possible to set up options page for the plugin
	 * after that, $this->get_option($name) can be called to get options.
	 *
	 */
	function register_configuration(){
		global $u_course_settings;

		$u_course_settings = new Options_Page('u_course', array('option_file'=>dirname(__FILE__) . '/options.xml','menu_title'=> __('U-Course Settings','cactusthemes'),'menu_position'=>null), array('page_title'=> __('U-Course Setting Page','cactusthemes'),'submit_text'=>'Save'));
		
	}
	
	/* Get main options of the plugin. If there are any sub options page, pass Options Page Id to the second args
	 *
	 *
	 */
	function get_option($option_name, $op_id = ''){
		return $GLOBALS[$op_id != ''?$op_id:'u_course_settings']->get($option_name);
	}
	
	function init(){
		// Variables
		$this->template_url			= apply_filters( 'u_course_template_url', 'u-course/' );
		$this->register_taxonomies();		
		add_filter( 'cmb_meta_boxes', array($this,'register_post_type_metadata') );
		if(isset($GLOBALS['woocommerce'])){
			self::$woocommerce=$GLOBALS['woocommerce'];
		}
		add_action('template_redirect', array(__CLASS__,'checkCourse'));		
		//add_filter('manage_edit-u_course_columns', array($this,'custom_u_course_column_manage'));
		//add_action('manage_u_course_posts_custom_column', array($this,'custom_u_course_column_value'));
		
		//add_filter('manage_edit-affproduct_columns', array($this,'custom_affproduct_column_manage'));
		//add_action('manage_affproduct_posts_custom_column', array($this,'custom_affproduct_column_value'));
		
		//add_filter('manage_edit-u_course_cat_columns', array($this,'custom_u_course_cat_column_manage'));
		//add_filter('manage_u_course_cat_custom_column', array($this,'custom_u_course_cat_column_value'));
		
		if ( ! is_admin() || defined('DOING_AJAX') ) {
			//$this->query = new U_course_Query();
		}
		
		add_filter( 'template_include', array( $this, 'template_loader' ) );
		add_action( 'template_redirect', array($this, 'template_redirect' ) );
		add_action( 'wp_enqueue_scripts', array($this, 'u_course_scripts_styles') );
		
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
		$find = array('u-course.php');
		$file = '';			
		if(is_search() && is_post_type_archive( 'u_course' )){
			$file = 'course-search-result.php';
			$find[] = $file;
			$find[] = $this->template_url . $file;
		}elseif(is_post_type_archive( 'u_course' ) || is_page('course')){
			$file = 'course-listing.php';
			$find[] = $file;
			$find[] = $this->template_url . $file;
		}
		elseif(is_singular('u_course')){
			$file = 'single-course.php';
			$find[] = $file;
			$find[] = $this->template_url . $file;
		}
		elseif(is_tax('u_course_cat')){
			$file = 'course-categories.php';
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
		global $u_course, $wp_query;

		// When default permalinks are enabled, redirect stores page to post type archive url
		if ( ! empty( $_GET['page_id'] ) && get_option( 'permalink_structure' ) == "" && $_GET['page_id'] ==  'course' ) {
			wp_safe_redirect( get_post_type_archive_link('u_course') );
			exit;
		}
	}
		
	function register_taxonomies(){
		$this->register_u_course();
	}
	
	/* Register u_course post type and its custom taxonomies */
	function register_u_course(){
		$labels = array(
			'name'               => __('Course', 'cactusthemes'),
			'singular_name'      => __('Course', 'cactusthemes'),
			'add_new'            => __('Add New Course', 'cactusthemes'),
			'add_new_item'       => __('Add New Course', 'cactusthemes'),
			'edit_item'          => __('Edit Course', 'cactusthemes'),
			'new_item'           => __('New Course', 'cactusthemes'),
			'all_items'          => __('All Courses', 'cactusthemes'),
			'view_item'          => __('View Course', 'cactusthemes'),
			'search_items'       => __('Search Course', 'cactusthemes'),
			'not_found'          => __('No Course found', 'cactusthemes'),
			'not_found_in_trash' => __('No Course found in Trash', 'cactusthemes'),
			'parent_item_colon'  => '',
			'menu_name'          => __('U-Course', 'cactusthemes'),
		  );
		$slug_course =  $this->get_option('ucourse-slug');
		$slug_cat_course =  $this->get_option('ucourse-cat-slug');
		if($slug_course==''){
			$slug_course = 'course';
		}

		if ( $slug_course )
			$rewrite =  array( 'slug' => untrailingslashit( $slug_course ), 'with_front' => false, 'feeds' => true );
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
		register_post_type( 'u_course', $args );
	/* Register Course Categories */
		$u_course_cat_labels = array(
			'name'=> __('U-Course Categories','cactusthemes'),
			'singular_name'=> __('U-Course Category','cactusthemes')
		);
		register_taxonomy('u_course_cat', 'u_course', array('labels'=>$u_course_cat_labels,'show_admin_column'=>true,'hierarchical'=>true,'rewrite'=>array('slug'=>$slug_cat_course),'meta_box_cb'=>array($this,'u_course_categories_meta_box_cb')));
	}		
	/* Register meta box for Store Type 
	 * Wordpress 3.8
	 */
	function u_course_type_meta_box_cb($post, $box){
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
	function u_course_categories_meta_box_cb( $post, $box ) {
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
		$u_course_fields_layout = array(	
			array( 'id' => 'course-sidebar', 'name' => __('Sidebar','cactusthemes'), 'type' => 'select', 'options' => array( 'def' => __('Default', 'cactusthemes'), 'left' => __('Left','cactusthemes'), 'right' => __('Right','cactusthemes'), 'full' => __('Hidden','cactusthemes')),'desc' => __('Select "Default" to use settings in Theme Options','cactusthemes'), 'repeatable' => false, 'multiple' => false),
			array( 'id' => 'course-ctpadding', 'name' => __('Content Padding','cactusthemes'), 'type' => 'select', 'options' => array( 'on' => __('On','cactusthemes'), 'off' => __('Off','cactusthemes')),'desc' => __('Enable default top and bottom','cactusthemes'), 'repeatable' => false, 'multiple' => false),
		);

		$u_course_fields = array(	
			array( 'id' => 'u-course-start', 'name' => __('Start Date:','cactusthemes'), 'type' => 'date_unix' , 'repeatable' => false, 'multiple' => false, 'desc' => __('Date Format: Y/m/d h:i A','cactusthemes')),
			array( 'id' => 'u-courseid', 'name' => __('Course ID','cactusthemes'), 'type' => 'text' , 'repeatable' => false, 'multiple' => false),
			array( 'id' => 'product_id_course', 'name' => __('Product','cactusthemes'), 'type' => 'post_select', 'use_ajax' => true, 'query' => array( 'post_type' => 'product' ),'allow_none' => true, 'desc' => __('Select a WooCommerce product to sell this course','cactusthemes'), 'repeatable' => false, 'multiple' => false ),
			array( 'id' => 'u-course-addr', 'name' => __('Address:','cactusthemes'), 'type' => 'text','desc' => __('Location Address of course','cactusthemes'), 'repeatable' => false, 'multiple' => false ),
			array( 'id' => 'u-course-dur', 'name' =>  __('Duration:','cactusthemes'), 'type' => 'text','desc' => __('Course duration info','cactusthemes'), 'repeatable' => false, 'multiple' => false ),
			array( 'id' => 'course_member_id', 'name' => __('Speakers','cactusthemes') ,'desc' => __('Choose from members','cactusthemes'), 'type' => 'post_select', 'use_ajax' => true, 'query' => array( 'post_type' => 'u_member' ), 'multiple' => true, 'repeatable' => false),
			array( 'id' => 'u-course-cre', 'name' => __('Credit:','cactusthemes'), 'type' => 'text','desc' => __('Number of course credits','cactusthemes'), 'repeatable' => false, 'multiple' => false),
			array( 'id' => 'u-course-sub', 'name' => __('Subscribe URL:','cactusthemes'), 'type' => 'text' ,'desc' => __('Link to a Subscription Form, if this event does not have a related WooCommerce Product. If empty, button is invisible','cactusthemes'), 'repeatable' => false, 'multiple' => false),
			array( 'id' => 'u-course-label', 'name' => __('Subscribe Button Text:','cactusthemes'), 'type' => 'text' ,'desc' => __('Text that appears on the subscribe button.','cactusthemes'), 'repeatable' => false, 'multiple' => false),
			array( 'id' => 'u-course-dl', 'name' => __('Download Button URL','cactusthemes'), 'type' => 'text','desc' => __('Download URL for course documents. If empty, button is invisible','cactusthemes'), 'repeatable' => false, 'multiple' => false),
			array( 'id' => 'u-course-label-bro', 'name' => __('Download Button Text','cactusthemes'), 'type' => 'text' ,'desc' => __('Text that appears on download button','cactusthemes'), 'repeatable' => false, 'multiple' => false),
			array( 'id' => 'u-cour-callaction', 'name' => __('Call to Action Text','cactusthemes'), 'type' => 'textarea','desc' => __('Text that appears before Subscribe Button','cactusthemes'), 'repeatable' => false, 'multiple' => false),
		);
		$meta_boxes[] = array(
			'title' => __('Layout settings','cactusthemes'),
			'pages' => 'u_course',
			'fields' => $u_course_fields_layout,
			'priority' => 'high'
		);	
		$meta_boxes[] = array(
			'title' => __('Course Info','cactusthemes'),
			'pages' => 'u_course',
			'fields' => $u_course_fields,
			'priority' => 'high'
		);	
		return $meta_boxes;
	}
}


} // class_exists check
if ( ! function_exists( 'u_course_get_page_id' ) ) {

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
//	function u_course_get_page_id( $page ) {
//		global $affiliatez;
//		$page = apply_filters('affiliatez_get_' . $page . '_page_id', $affiliatez->get_option($page . '-page-id'));
//		return ( $page ) ? $page : -1;
//	}
}

/**
 * Init u_course
 */
$GLOBALS['u_course'] = new U_course();
	/*show ID Texonomy*/
	foreach ( get_taxonomies() as $taxonomy ) {
    add_action( "manage_edit-u_course_cat_columns",          't5_add_col');
    add_filter( "manage_edit-u_course_cat_sortable_columns", 't5_add_col');
    add_filter( "manage_u_course_cat_custom_column",         't5_show_id', 10, 3 );
	}
	add_action( 'admin_print_styles-edit-tags.php', 't5_tax_id_style' );
	
	function t5_add_col( $columns )
	{
		return $columns + array ( 'tax_id' => 'ID' );
	}
	function t5_show_id( $v, $name, $id )
	{    
		return 'tax_id' === $name ? $id : $v;
	}
	function t5_tax_id_style()
	{
		print '<style>#tax_id{width:4em}</style>';
	}
?>