<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see      https://docs.woocommerce.com/document/template-structure/
 * @author   WooThemes
 * @package  WooCommerce/Templates
 * @version  1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
get_header( 'shop' );

$checkout = new \WC_Checkout();

// do_action( 'woocommerce_before_checkout_form', $checkout );
// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'shopbuild' ) ) );
    return;
}
?>

<div class="pure-wc-shopbuild-template-builder woocommerce">
    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
    <?php
        do_action( 'pure_wc_shopbuild_checkout_content' );
    ?>
    </form>
</div>

<?php 
// do_action( 'woocommerce_after_checkout_form', $checkout );
get_footer( 'shop' );
?>
