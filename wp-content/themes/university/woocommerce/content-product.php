<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

// Increase loop count
?>
<li <?php wc_product_class(  ); ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<a href="<?php the_permalink(); ?>">
	<?php if ($product->is_on_sale()) : ?>
    
        <?php echo apply_filters('woocommerce_sale_flash', '<span class="onsale">' . __( 'Sale!', 'woocommerce' ) . '</span>', $post, $product); ?>
    
    <?php endif; ?>
		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			//do_action( 'woocommerce_before_shop_loop_item_title' );
			if(has_post_thumbnail(get_the_ID())){
				echo '<div class="thumb item-thumbnail">
					<a href="'.get_permalink(get_the_ID()).'" title="'.the_title_attribute('echo=0').'">
						<div class="item-thumbnail">
							'.get_the_post_thumbnail(get_the_ID(),'thumb_263x263').'
							<div class="thumbnail-hoverlay main-color-1-bg"></div>
							<div class="thumbnail-hoverlay-cross"></div>
						</div>
					</a>
				</div>';
			}
		?>
		<div class="item-content">
			<h4><a href="<?php the_permalink(); ?>" class="main-color-1-hover"><?php the_title(); ?></a></h4>
        </div>
        <p class="line"></p>
		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>

	</a>

	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

</li>