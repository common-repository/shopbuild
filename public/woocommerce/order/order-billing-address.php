<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.6.0
 */

defined( 'ABSPATH' ) || exit;

$order_id = get_query_var('order-received');
$order = wc_get_order( $order_id );

if ( !$order ){
	return;
}

if(!empty($order_billing_heading)){
    $billing_heading = $order_billing_heading;
}

?>
<div class="woocommerce-customer-details">
	<div class="sb-billing-address-item">
		<div class="sb-billing-address-content">
            <?php if(!empty($billing_heading)) : ?>
			<h3 class="sb-billing-address-title woocommerce-column__title"><?php echo wp_kses($billing_heading, pure_wc_get_kses_extended_ruleset()); ?></h3>
            <?php endif; ?>
			
			<!-- street -->
			<?php if ( $order->get_formatted_billing_full_name() ) : ?>
			<p><span><?php esc_html_e( 'Name:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_formatted_billing_full_name() ); ?></p>
			<?php endif; ?>
			<!-- street -->
			<?php if ( $order->get_billing_email() ) : ?>
			<p><span><?php esc_html_e( 'Email:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_billing_email() ); ?></p>
			<?php endif; ?>
			<!-- phone -->
			<?php if ( $order->get_billing_phone() ) : ?>
			<p><span><?php esc_html_e( 'Phone number:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_billing_phone() ); ?></p>
			<?php endif; ?>
			<!-- street -->
			<?php if ( $order->get_billing_company() ) : ?>
			<p><span><?php esc_html_e( 'Company:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_billing_company() ); ?></p>
			<?php endif; ?>
			<!-- street -->
			<?php if ( $order->get_billing_address_1() ) : ?>
			<p><span><?php esc_html_e( 'Address 1:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_billing_address_1() ); ?></p>
			<?php endif; ?>
			<!-- street -->
			<?php if ( $order->get_billing_address_2() ) : ?>
			<p><span><?php esc_html_e( 'Address 2:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_billing_address_2() ); ?></p>
			<?php endif; ?>
			<!-- city -->
			<?php if ( $order->get_billing_city() ) : ?>
			<p><span><?php esc_html_e( 'City:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_billing_city() ); ?></p>
			<?php endif; ?>
			<!-- state -->
			<?php if ( $order->get_billing_state() ) : ?>
			<p><span><?php esc_html_e( 'State/province/area:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_billing_state() ); ?></p>
			<?php endif; ?>
			<!-- zip code -->
			<?php if ( $order->get_billing_postcode() ) : ?>
			<p><span><?php esc_html_e( 'Zip code:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_billing_postcode() ); ?></p>
			<?php endif; ?>
			<!-- country -->
			<?php if ( $order->get_billing_country() ) : ?>
			<p><span><?php esc_html_e( 'Country:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_billing_country() ); ?></p>
			<?php endif; ?>
		</div>
	</div>


	<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>

</div>
