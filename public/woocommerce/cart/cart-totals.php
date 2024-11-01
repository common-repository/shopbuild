<?php
/**
 * Cart Total
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly    

$cart_total_title = !empty($cart_total_title) ? $cart_total_title : 'Cart Total';
$button_title = !empty($button_title) ? $button_title : 'Proceed to Checkout';
?>

<div class="woocommerce sb-cart-total">
<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">
    <?php if(!empty($cart_total_title)): ?>
    <h2><?php echo esc_html( $cart_total_title ); ?></h2>
    <?php endif; ?>


    <table cellspacing="0" class="shop_table shop_table_responsive">
        <tr class="cart-subtotal">
            <th><?php esc_html_e( 'Subtotal', 'shopbuild' ); ?></th>
            <td data-title="<?php esc_attr_e( 'Subtotal', 'shopbuild' ); ?>">
                <?php wc_cart_totals_subtotal_html(); ?></td>
        </tr>

        <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
        <tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
            <th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
            <td data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>">
                <?php wc_cart_totals_coupon_html( $coupon ); ?></td>
        </tr>
        <?php endforeach; ?>

        <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : 
            $package = WC()->cart->get_shipping_packages()[0];
            WC()->cart->calculate_shipping();
            $available_methods = WC()->shipping->get_packages()[0];
            $chosen_method = WC()->session->get( 'chosen_shipping_methods' )[0];
            $args = array(
                'package' => array(
                    'destination'   => $package['destination']
                ),
                'package_name'      => 'Shipping',
                'available_methods' => $available_methods['rates'],
                'show_package_details' => '',
                'index'             => 0,
                'chosen_method'     => $chosen_method
            );
            wc_get_template('cart/cart-shipping.php', $args);    
        ?>
        <?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

        <tr class="shipping">
            <th><?php esc_html_e( 'Shipping', 'shopbuild' ); ?></th>
            <td data-title="<?php esc_attr_e( 'Shipping', 'shopbuild' ); ?>">
                <div class="pure-cart-shipping">
                    <?php woocommerce_shipping_calculator(); ?>
                </div>
            </td>
        </tr>

        <?php endif; ?>

        <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
        <tr class="fee">
            <th><?php echo esc_html( $fee->name ); ?></th>
            <td data-title="<?php echo esc_attr( $fee->name ); ?>"><?php wc_cart_totals_fee_html( $fee ); ?></td>
        </tr>
        <?php endforeach; ?>

        <?php
			if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
				$taxable_address = WC()->customer->get_taxable_address();
				$estimated_text  = '';

				if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
					/* translators: %s location. */
					$estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'shopbuild' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
				}

				if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
					foreach ( WC()->cart->get_tax_totals() as $code => $tax ) { 
        ?>
        <tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
            <th><?php print wp_kses_post( $tax->label . $estimated_text ); ?>
            </th>
            <td data-title="<?php echo esc_attr( $tax->label ); ?>">
                <?php print wp_kses_post( $tax->formatted_amount ); ?></td>
        </tr>
        <?php
                }
            } else {
		?>
        <tr class="tax-total">
            <th><?php print wp_kses_post( WC()->countries->tax_or_vat() . $estimated_text); ?>
            </th>
            <td data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>">
                <?php wc_cart_totals_taxes_total_html(); ?></td>
        </tr>
        <?php
				}
			}
		?>

        <tr class="order-total">
            <th><?php esc_html_e( 'Total', 'shopbuild' ); ?></th>
            <td data-title="<?php esc_attr_e( 'Total', 'shopbuild' ); ?>">
                <?php wc_cart_totals_order_total_html(); ?></td>
        </tr>

    </table>

    <?php if(!empty($button_title)) : ?>
    <div class="wc-proceed-to-checkout">
        <?php 
            $checkout = sprintf(
                '<a href="%s" class="checkout-button button alt wc-forward wp-element-button">%s</a>',
                wc_get_checkout_url(),
                $button_title
            );
            print wp_kses_post($checkout);
        ?>
    </div>
    <?php endif; ?>
</div>
</div>