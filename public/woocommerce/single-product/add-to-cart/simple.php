<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}
echo wp_kses(wc_get_stock_html( $product ), pure_wc_get_kses_extended_ruleset()); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
		<div class="add-to-cart-wrap sb-d-flex sb-align-items-center w-100">
		<?php
		// verify nonce
		if(isset($_POST['add-to-cart-nonce-' . $product->get_id()]) && !wp_verify_nonce( wp_unslash( sanitize_text_field(wp_unslash($_POST['add-to-cart-nonce-' . $product->get_id()]))), 'add-to-cart-' . $product->get_id() )) {
			$quantity = 0;
		}else{
			$quantity = (isset( $_POST['quantity'] )) ? absint( wp_unslash($_POST['quantity']) ) : $product->get_min_purchase_quantity();
		}

		do_action( 'woocommerce_before_add_to_cart_quantity' );
		wp_nonce_field('add-to-cart-' .$product->get_id(), 'add-to-cart-nonce-' .$product->get_id());
		woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => esc_attr($quantity),
			)
		);
		do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>

		<button data-quantity="<?php echo esc_attr( $product->get_min_purchase_quantity() ); ?>" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>" type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="pure_single_add_to_cart_button button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
