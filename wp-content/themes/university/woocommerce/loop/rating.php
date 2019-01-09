<?php
/**
 * Loop Rating
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/rating.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

if($product->is_type('variable')){
	$price_html = $product->get_price(); ?>
		<span class="price"><?php _e('From  ','cactusthemes') ?><?php  
		   $currency_pos = get_option( 'woocommerce_currency_pos' );
		   if($currency_pos == 'left'){ echo get_woocommerce_currency_symbol(); }
		   else if($currency_pos == 'left_space'){ echo get_woocommerce_currency_symbol() . ' '; }
		   echo $price_html; 
		   if($currency_pos == 'right'){ echo get_woocommerce_currency_symbol(); }
		   else if($currency_pos == 'right_space'){ echo ' ' . get_woocommerce_currency_symbol(); }		
		?></span>
	<?php 
}else{
	if ( $price_html = $product->get_price_html() ) : ?>
		<span class="price"><?php echo $price_html; ?></span>
	<?php endif; 	
}
?>

<?php
if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' )
	return;

echo wc_get_rating_html( $product->get_average_rating() );