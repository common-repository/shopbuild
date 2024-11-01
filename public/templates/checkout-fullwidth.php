<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
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
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( class_exists('\Elementor\Plugin') ){
	\Elementor\Plugin::$instance->frontend->add_body_class( 'elementor-template-full-width' );
}

get_header( 'shop' );

/**
 * Before Header-Footer page template content.
 *
 * Fires before the content of Elementor Header-Footer page template.
 *
 * @since 2.0.0
 */

do_action( 'elementor/page_templates/header-footer/before_content' ); 
$checkout = new \WC_Checkout();

// do_action( 'woocommerce_before_checkout_form', $checkout );
// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'shopbuild' ) ) );
    return;
}
?>

	<div class="pure-wc-shopbuild-template-container woocommerce">
		<?php while ( have_posts() ) : the_post(); ?>

        <div class="pure-wc-shopbuild-template-builder woocommerce">
            <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
            <?php
                do_action( 'pure_wc_shopbuild_checkout_content' );
            ?>
            </form>
        </div>

		<?php endwhile; // end of the loop. ?>
	</div>

<?php 
// do_action( 'woocommerce_after_checkout_form', $checkout );
/**
 * After Header-Footer page template content.
 *
 * Fires after the content of Elementor Header-Footer page template.
 *
 * @since 2.0.0
 */
do_action( 'elementor/page_templates/header-footer/after_content' );

get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
