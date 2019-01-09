<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

wc_print_notices();
?>
<script>
jQuery(document).ready(function(e) {
	jQuery('#checkout-uni a:first').tab('show');
	jQuery('#billinginfo_uni').click(function(){
	<?php if ( WC()->cart->needs_shipping_address() === true ) { ?>
		jQuery('#ticketinfo').addClass('active');
		jQuery('#ticket_info').addClass('active');
	<?php }else{ ?>
		jQuery('#review_pay').addClass('active');
		jQuery('#review_payment').addClass('active');
	<?php } ?>
		jQuery('#bllinginfo').removeClass('active');
		jQuery('#blling_info').removeClass('active');
        jQuery("html, body").animate({ scrollTop: 0 }, 680);
  		return false;
	});	
	jQuery('#ticketinfo_uni').click(function(){
		jQuery('#review_pay').addClass('active');
		jQuery('#review_payment').addClass('active');
		jQuery('#ticketinfo').removeClass('active');
		jQuery('#ticket_info').removeClass('active');
		jQuery("html, body").animate({ scrollTop: 0 }, 680);
		return false;
	});	
});
</script>
<div class="row" >
      <div class="col-md-12 checkout-event coupon">
			<?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?>
      </div>
</div>
<div class="row" >
    <div class="col-md-3">
        <ul class="nav nav-tabs" id="checkout-uni">
          <li class="active" id="bllinginfo"><a href="#blling_info" data-toggle="tab"><?php _e( 'Billing Info', 'cactusthemes' ); ?></a></li>
          <?php if ( WC()->cart->needs_shipping_address() === true ) { ?>
          <li id="ticketinfo"><a href="#ticket_info" data-toggle="tab"><?php _e( 'Details', 'cactusthemes' ); ?></a></li>
          <?php } ?>
          <li id="review_pay"><a href="#review_payment" data-toggle="tab"><?php _e( 'Review and Payment', 'cactusthemes' ); ?></a></li>
        </ul>
    </div>
    <div class="col-md-9 checkout-detail">
<?php
// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', wc_get_checkout_url() ); ?>
<div class="tab-content">
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( $get_checkout_url ); ?>">

	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
            <div class="col2-set tab-content" id="customer_details">
            	<div class="tab-pane active" id="blling_info">
                    <div class="col-md-12 checkout-event">
                        <?php do_action( 'woocommerce_checkout_billing' ); ?>
                    </div>
                </div>
                <div class="tab-pane" id="ticket_info">
                    <div class="col-md-12 checkout-event">
                        <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                    </div>
                </div>
		<?php  do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>
    <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
        <div class="tab-pane" id="review_payment">
                <div class="col-md-12 checkout-event">
                    <h2 id="order_review_heading"><?php _e( 'Review and Payment', 'cactusthemes' ); ?></h2>
                    <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php  do_action( 'woocommerce_checkout_order_review' ); ?>
                    </div>
                </div>
        </div>
    <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
    </div>
</form>
</div>
</div>
</div>
<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>