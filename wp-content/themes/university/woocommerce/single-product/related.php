<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
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

global $woocommerce_loop;

if ( $related_products ) return;

$woocommerce_loop['columns'] = $columns;
?>
<div class="content-pad social-product">
    <ul class="list-inline social-light">
        <?php cactus_social_share(); ?>
    </ul>
</div>

<?php
if ( $related_products ) : ?>

	<div class="related-event">

		<h3><?php esc_html_e( 'Related Products', 'woocommerce' ); ?></h3>
		<div class="ev-content">
		<?php woocommerce_product_loop_start();
		
		 ?>
			<div class="row">
			<?php foreach ( $related_products as $related_product ) :
				$post_object = get_post( $related_product->get_id() );

				setup_postdata( $GLOBALS['post'] = $post_object );
			 ?>
				<div class="col-sm-4 related-item">
					<?php if(has_post_thumbnail(get_the_ID())){ ?> 
                    		<div class="thumb"><a href="<?php echo get_permalink(get_the_ID())?>"><?php echo get_the_post_thumbnail( get_the_ID(), 'thumb_80x80' ); ?></a></div>
                        <?php }?>
                        <div class="ev-title item-content"> <a class="main-color-1-hover" href="<?php echo get_permalink(get_the_ID())?>"><?php echo get_the_title(get_the_ID()); ?></a></div>
                        <div><?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?></div>
                        <div class="clear"></div>
				</div>
                 
			<?php endforeach; // end of the loop. ?>
			</div>
		<?php woocommerce_product_loop_end(); ?>
		</div>
	</div>

<?php endif;

wp_reset_postdata();