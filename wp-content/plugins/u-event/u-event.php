<?php
/**
 * @package University
 * @version 2.0.25
 */
/*
Plugin Name: University Event
Description: Event-related features for University Theme
Author: CactusThemes
Version: 1.14.4.1
Author URI: http://www.cactusthemes.com
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
include('widget/latest-event.php');
if(!class_exists('U_event')){
/*translate settings*/
$text_translate_events_st = __('General','cactusthemes').__('Events Slug','cactusthemes').__('Change event slug. Remember to save the permalink settings again in Settings > Permalinks','cactusthemes').__('Events Categories Slug','cactusthemes').__('Change event categories slug. Remember to save the permalink settings again in Settings > Permalinks','cactusthemes').__('Events Tags Slug','cactusthemes').__('Change event tag slug. Remember to save the permalink settings again in Settings > Permalinks','cactusthemes').__('Listing Style','cactusthemes').__('Classic','cactusthemes').__('Grid','cactusthemes').__('Select style for Events Listing page','cactusthemes').__('Posts Per Page','cactusthemes').__('Filter bar','cactusthemes').__('Disable','cactusthemes').__('Enable','cactusthemes').__('Enable filter bar','cactusthemes').__('Event Listing Order','cactusthemes').__('Default','cactusthemes').__('Upcoming','cactusthemes').__('Start Date','cactusthemes').__('Modified Date','cactusthemes').__('Event Listing Order Bar','cactusthemes').__('Disable','cactusthemes').__('Enable','cactusthemes').__('Single Event','cactusthemes').__('Sidebar','cactusthemes').__('Sidebar Right','cactusthemes').__('Sidebar left','cactusthemes').__('Full Width','cactusthemes').__('Select default layout for single events pages ','cactusthemes').__('Header Style','cactusthemes').__('Title Only ','cactusthemes').__('Big Feature Image','cactusthemes').__('Select default style for header of single event pages','cactusthemes').__('Related Events','cactusthemes').__('Related by','cactusthemes').__('Categories','cactusthemes').__('Tags','cactusthemes').__('Number of items','cactusthemes').__('Categories','cactusthemes').__('Disable','cactusthemes').__('Enable','cactusthemes').__('Enable Categories info ','cactusthemes').__('Tags','cactusthemes').__('Disable','cactusthemes').__('Enable','cactusthemes').__('Enable Tags info ','cactusthemes');		
class U_event{
	/* custom template relative url in theme, default is "u_event" */
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
	//Get course price
	function getStatus() {
		$status= '';
		$status=get_post_meta(get_the_ID(),'ev_status', true );
		return $status;
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
		$product_id = get_post_meta(get_the_ID(),'product_id', true );
		if(function_exists('wc_get_product')){
			$product = wc_get_product($product_id);
			if($product !== false) {

				if($product->is_type('variable')){
					$price['type'] = 'variable';
					$price = $variations = $product->get_available_variations();
					//foreach($variations as $items => $item){
					//	$price = $item['variation_id'];
					//}
				} else{
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
	function getPrice_num() {
		$price['text']=__('Free', 'cactusthemes');
		$price['number']=0;
		$price['type']='simple';
		$product_id = get_post_meta(get_the_ID(),'product_id', true );
		if(function_exists('wc_get_product')){
			$product = wc_get_product($product_id);
			if($product !== false) {
				$price['type'] = 'simple';
				
				if($product->is_type('variable')){
					$price['type'] = 'variable';
				}

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
		$product_id = get_post_meta(get_the_ID(),'product_id', true );
		if(function_exists('wc_get_product')){
		$product = wc_get_product($product_id);
			if($product !== false) {
				$variations = ($product->is_type('simple') ? 'simple' : ($product->is_type('variable') ? 'variable' : ''));
			}
		}
		return $variations;
	}
	//check and add to cart
	public static function checkEvent() {
		//$status=self::getStatus();
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
	
	function u_event_scripts_styles() {
		global $wp_styles;
		
		/*
		 * Loads our main javascript.
		 */	
		
		wp_enqueue_script( 'custom',plugins_url('/js/custom.js', __FILE__) , array(), '', true );
	}
	
	function admin_event_scripts_styles() {
		global $wp_styles;
		wp_enqueue_script( 'custom-admin',plugins_url('/js/custom-admin.js', __FILE__) , array(), '', true );
	}
	function includes(){
		// custom meta boxes
		include_once('event-functions.php');
		if(!function_exists('cmb_init')){
			if(!class_exists('CMB_Meta_Box')){
				include_once('includes/Custom-Meta-Boxes-master/custom-meta-boxes.php');
			}
		}
		if(!class_exists('Options_Page')){
			include_once('includes/options-page/options-page.php');
		}
		
		include_once('event-list-table.php');
	}
	
	/* This is called as soon as possible to set up options page for the plugin
	 * after that, $this->get_option($name) can be called to get options.
	 *
	 */
	function register_configuration(){
		global $u_event_settings;
		$u_event_settings = new Options_Page('u_event_settings', array('option_file'=>dirname(__FILE__) . '/options.xml','menu_title'=> __('U-Event Settings','cactusthemes'),'menu_position'=>null), array('page_title'=> __('U-Event Setting Page','cactusthemes'),'submit_text'=>'Save'));
	}
	
	/* Get main options of the plugin. If there are any sub options page, pass Options Page Id to the second args
	 *
	 *
	 */
	function get_option($option_name, $op_id = ''){
		return $GLOBALS[$op_id != ''?$op_id:'u_event_settings']->get($option_name);
	}
	
	function init(){
		// Variables
		$this->template_url			= apply_filters( 'u_event_template_url', 'u-event/' );
		if(isset($GLOBALS['woocommerce'])){
			self::$woocommerce=$GLOBALS['woocommerce'];
		}
		$this->register_taxonomies();		
		add_filter( 'cmb_meta_boxes', array($this,'register_post_type_metadata') );
		
		add_action('template_redirect', array(__CLASS__,'checkEvent'));
		// add custom columns to the {u_event} manage page
		// refer: http://justintadlock.com/archives/2011/06/27/custom-columns-for-custom-post-types
//		add_filter('manage_edit-u_event_columns', array($this,'custom_u_event_column_manage'));
//		add_action('manage_u_event_posts_custom_column', array($this,'custom_u_event_column_value'));
//		
//		add_filter('manage_edit-affproduct_columns', array($this,'custom_affproduct_column_manage'));
//		add_action('manage_affproduct_posts_custom_column', array($this,'custom_affproduct_column_value'));
//		
//		add_filter('manage_edit-u_event_cat_columns', array($this,'custom_u_event_cat_column_manage'));
//		add_filter('manage_u_event_cat_custom_column', array($this,'custom_u_event_cat_column_value'));
		
		/*if ( ! is_admin() || defined('DOING_AJAX') ) {
			$this->query = new U_event_Query();
		}*/
		
		add_filter( 'template_include', array( $this, 'template_loader' ) );
		add_action( 'template_redirect', array($this, 'template_redirect' ) );
		add_action( 'wp_enqueue_scripts', array($this, 'u_event_scripts_styles') );
		add_action( 'admin_enqueue_scripts', array($this, 'admin_event_scripts_styles') );
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
		$find = array('u-event.php');
		$file = '';
		
		if(is_post_type_archive( 'u_event' ) || is_page('event')){
			$file = 'event-listing.php';
			$find[] = $file;
			$find[] = $this->template_url . $file;
		}
		elseif(is_singular('u_event')){
			$file = 'single-event.php';
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
		global $u_event, $wp_query;

		// When default permalinks are enabled, redirect stores page to post type archive url
		if ( ! empty( $_GET['page_id'] ) && get_option( 'permalink_structure' ) == "" && $_GET['page_id'] ==  'event' ) {
			wp_safe_redirect( get_post_type_archive_link('u_event') );
			exit;
		}
	}
	
	function register_taxonomies(){
		$this->register_u_event();
	}
	
	/* Register u_event post type and its custom taxonomies */
	function register_u_event(){
		$labels = array(
			'name'               => __('Event', 'cactusthemes'),
			'singular_name'      => __('Event', 'cactusthemes'),
			'add_new'            => __('Add New Event', 'cactusthemes'),
			'add_new_item'       => __('Add New Event', 'cactusthemes'),
			'edit_item'          => __('Edit Event', 'cactusthemes'),
			'new_item'           => __('New Event', 'cactusthemes'),
			'all_items'          => __('All Events', 'cactusthemes'),
			'view_item'          => __('View Event', 'cactusthemes'),
			'search_items'       => __('Search Event', 'cactusthemes'),
			'not_found'          => __('No Event found', 'cactusthemes'),
			'not_found_in_trash' => __('No Event found in Trash', 'cactusthemes'),
			'parent_item_colon'  => '',
			'menu_name'          => __('U-Event', 'cactusthemes'),
		  );
		$slug_ev =  $this->get_option('uevent-slug');
		$slug_cat_ev =  $this->get_option('uevent-cat-slug');
		$slug_tag_ev =  $this->get_option('uevent-tag-slug');
		if($slug_ev==''){
			$slug_ev = 'event';
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
		register_post_type( 'u_event', $args );
		
		/* Register Event Categories */
		$u_event_cat_labels = array(
			'name'=> __('U-Event Categories','cactusthemes'),
			'singular_name'=> __('U-Event Category','cactusthemes')
		);
		$u_event_tag_labels = array(
			'name'=> __('U-Event Tags','cactusthemes'),
			'singular_name'=> __('U-Event Tags','cactusthemes')
		);
		register_taxonomy('u_event_tags', 'u_event', array('labels'=>$u_event_tag_labels,'rewrite'=>array('slug'=>$slug_tag_ev),'meta_box_cb'=>array($this,'u_event_type_meta_box_cb')));
		register_taxonomy('u_event_cat', 'u_event', array('labels'=>$u_event_cat_labels,'show_admin_column'=>true,'hierarchical'=>true,'rewrite'=>array('slug'=>$slug_cat_ev),'meta_box_cb'=>array($this,'u_event_categories_meta_box_cb')));
	}
		
	/* Register meta box for Store Type 
	 * Wordpress 3.8
	 */
	function u_event_type_meta_box_cb($post, $box){
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
	function u_event_categories_meta_box_cb( $post, $box ) {
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
		$u_event_fields_layout = array(	
			array( 'id' => 'event-sidebar', 'name' => __('Sidebar', 'cactusthemes'), 'type' => 'select', 'options' => array( 'def' => __('Default', 'cactusthemes'), 'left' => __('Left', 'cactusthemes'), 'right' => __('Right', 'cactusthemes'), 'full' => __('Hidden', 'cactusthemes')),'desc' => __('Select "Default" to use settings in Theme Options', 'cactusthemes') , 'repeatable' => false, 'multiple' => false),
			array( 'id' => 'event-ctpadding', 'name' => __('Content Padding', 'cactusthemes'), 'type' => 'select', 'options' => array( 'on' => __('On', 'cactusthemes'), 'off' => __('Off', 'cactusthemes')),'desc' => __('Enable default top and bottom padding  for content (30px)', 'cactusthemes'), 'repeatable' => false, 'multiple' => false),
			array( 'id' => 'event-layout-header', 'name' => __('Layout', 'cactusthemes'), 'type' => 'select', 'options' => array( 'def' => __('Default', 'cactusthemes'), 'title-only' => __('Title Only ', 'cactusthemes'), 'feature-image' => __('Big Feature Image', 'cactusthemes')),'desc' => '', 'repeatable' => false, 'multiple' => false),
		);
        
        
                
		$u_event_fields = array(	
				array( 'id' => 'u-startdate', 'name' => __('Start Date', 'cactusthemes'), 'type' => 'datetime_unix' , 'repeatable' => false, 'multiple' => false, 'desc' => __('The time zone is set in Settings > General. This time in in local time. Date Format: Y/m/d h:i A','cactusthemes')),	
				array( 'id' => 'u-enddate', 'name' => __('End Date', 'cactusthemes'), 'type' => 'datetime_unix', 'repeatable' => false, 'multiple' => false, 'desc' => __('The time zone is set in Settings > General. This time in in local time. Date Format: Y/m/d h:i A','cactusthemes')),	
				array( 'id' => 'all_day',  'name' => __('All Day Event', 'cactusthemes'), 'type' => 'checkbox' ),
				array( 'id' => 'u-eventid', 'name' => __('Event ID', 'cactusthemes'), 'type' => 'text' , 'repeatable' => false, 'multiple' => false),
				array( 'id' => 'product_id', 'name' => __('Product','cactusthemes'), 'type' => 'post_select', 'use_ajax' => true, 'query' => array( 'post_type' => 'product' ),'allow_none' => true, 'desc' => __('Select a WooCommerce product to sell this event', 'cactusthemes'), 'repeatable' => false, 'multiple' => false ),	
				array( 'id' => 'member_id', 'name' => __('Speakers','cactusthemes'), 'type' => 'post_select', 'use_ajax' => true, 'query' => array( 'post_type' => 'u_member' ), 'multiple' => true,  'desc' => __('Choose from members','cactusthemes') , 'repeatable' => false),
				array( 'id' => 'u-callaction', 'name' => __('Call to action', 'cactusthemes'), 'type' => 'textarea','desc' => __('Text that appears before subscribe button', 'cactusthemes') , 'repeatable' => false, 'multiple' => false ),
				array( 'id' => 'u-linkssub', 'name' => __('Subscribe URL', 'cactusthemes'), 'type' => 'text', 'textarea','desc' => __('Link to a Subscription Form, if this event does not have a related WooCommerce Product. If empty, button is invisible', 'cactusthemes') , 'repeatable' => false, 'multiple' => false),
				array( 'id' => 'u-textsub', 'name' => __('Subscribe Button Text', 'cactusthemes'), 'type' => 'text', 'textarea','desc' => __('Text that appears on the subscribe button.', 'cactusthemes'), 'repeatable' => false, 'multiple' => false )
			);

		$meta_boxes[] = array(
			'title' => __('Layout settings','cactusthemes'),
			'pages' => 'u_event',
			'fields' => $u_event_fields_layout,
			'priority' => 'high'
		);	
		$meta_boxes[] = array(
			'title' => __('Event Info','cactusthemes'),
			'pages' => 'u_event',
			'fields' => $u_event_fields,
			'priority' => 'high'
		);	
		$u_event_fields2 = array(	
				array( 'id' => 'u-adress', 'name' => __('Address:', 'cactusthemes'), 'type' => 'text','desc' => __('Location Address of event', 'cactusthemes') , 'repeatable' => false, 'multiple' => false),
				array( 'id' => 'u-phone', 'name' => __('Phone:', 'cactusthemes'), 'type' => 'text','desc' => __('Contact Number of event', 'cactusthemes'), 'repeatable' => false, 'multiple' => false ),
				array( 'id' => 'u-website', 'name' => __('Website:', 'cactusthemes'), 'type' => 'text','desc' => __('Website URL of event', 'cactusthemes') , 'repeatable' => false, 'multiple' => false),	
				array( 'id' => 'u-email', 'name' => __('Email:', 'cactusthemes'), 'type' => 'text','desc' => __('Email Contact of event', 'cactusthemes'), 'repeatable' => false, 'multiple' => false ),	
				//array(	'id' => 'product', 'name' => __('Product','cactusthemes'), 'type' => 'cmb_post_select'),
				//, array('id' => 'type', 'name' => 'Type of store', 'type' => 'select', 'options' => array( 'retailer' => 'Retailer', 'physical' => 'Physical'))
			);

		
		$meta_boxes[] = array(
			'title' => __('Event Location','cactusthemes'),
			'pages' => 'u_event',
			'fields' => $u_event_fields2,
			'priority' => 'high'
		);		
		return $meta_boxes;
	}
}


} // class_exists check
if ( ! function_exists( 'u_event_get_page_id' ) ) {

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
	 /* function u_event_get_page_id( $page ) {
		  global $affiliatez;
		  $page = apply_filters('affiliatez_get_' . $page . '_page_id', $affiliatez->get_option($page . '-page-id'));
		  return ( $page ) ? $page : -1;
	  }*/
}

/**
 * Init u_event
 */
$GLOBALS['u_event'] = new U_event();
?>