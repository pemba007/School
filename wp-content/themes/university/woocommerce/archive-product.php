<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$layout = get_post_meta(get_option('woocommerce_shop_page_id'),'sidebar_layout',true);
$content_padding = get_post_meta(get_option('woocommerce_shop_page_id'),'content_padding',true);
if($layout==''){
	$layout =  ot_get_option('page_layout');
} 
get_header( 'shop' ); ?>
<?php get_template_part( 'header', 'heading' ); ?>  
<div class="container">
	<?php if($content_padding!='off'){ ?>
    <div class="content-pad-3x">
    <?php }?>
	<div class="row">
	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		//do_action( 'woocommerce_before_main_content' );
	?>
		<div id="content" class="<?php echo ($layout != 'full' && $layout != 'true-full')?'col-md-9':'col-md-12' ?><?php echo ($layout == 'left') ? " revert-layout":"";?>">
		<?php // if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

			<!--<h1 class="page-title"><?php // woocommerce_page_title(); ?></h1>-->

		<?php //endif; ?>

		<?php do_action( 'woocommerce_archive_description' ); ?>

		<?php if ( woocommerce_product_loop() ) : ?>

			<?php
				/**
				 * Hook: woocommerce_before_shop_loop.
				 *
				 * @hooked wc_print_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>
				
			<?php if ( wc_get_loop_prop( 'total' ) ) { ?>

				<?php while ( have_posts() ) : the_post(); 
				
					/**
					 * Hook: woocommerce_shop_loop.
					 *
					 * @hooked WC_Structured_Data::generate_product_data() - 10
					 */
					do_action( 'woocommerce_shop_loop' );
					
					?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>
				
			<?php } ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php else : ?>

			<?php
			
			/**
			 * Hook: woocommerce_no_products_found.
			 *
			 * @hooked wc_no_products_found - 10
			 */
			do_action( 'woocommerce_no_products_found' );
			
			?>

		<?php endif; ?>
	</div>
	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		//do_action( 'woocommerce_after_main_content' );
	?>
	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		if($layout != 'full' && $layout != 'true-full'){do_action( 'woocommerce_sidebar' );}
	?>
	</div>
    <?php if($content_padding!='off'){ ?>
    </div><!--/content-pad-3x-->
    <?php }?>
</div>
<?php get_footer( 'shop' ); ?>