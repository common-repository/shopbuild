<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;

// verify nonce
if(isset($_POST['add-to-cart-nonce-' . $product->get_id()]) && !wp_verify_nonce( wp_unslash( sanitize_text_field(wp_unslash($_POST['add-to-cart-nonce-' . $product->get_id()]))), 'add-to-cart-' . $product->get_id() )) {
	$quantity = 0;
}else{
	$quantity = (isset( $_POST['quantity'] )) ? absint( wp_unslash($_POST['quantity']) ) : $product->get_min_purchase_quantity();
}
?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<?php
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

	<button data-quantity="<?php echo esc_attr( $product->get_min_purchase_quantity() ); ?>" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>" type="submit" class="single_add_to_cart_button button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
