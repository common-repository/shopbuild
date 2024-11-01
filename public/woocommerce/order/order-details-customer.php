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

$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();

?>
<section class="woocommerce-customer-details">

	<?php if ( $show_shipping ) : ?>

	<section class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses sb-d-flex col2-set addresses sb-order-customer-details">
		<div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address sb-col-6">

	<?php endif; ?>

	<div class="sb-billing-address-item sb-d-sm-flex sb-align-items-start">
		<div class="sb-billing-address-icon">
			<span>
				<svg enable-background="new 0 0 32 32" viewBox="0 0 32 32">
					<g>
						<path fill="currentColor" d="m31.494 23.128-.959-.844v-3.708c0-1.315-1.067-2.382-2.382-2.382-1.144 0-2.126.813-2.34 1.937l-.821-.721c-.954-.835-2.378-.835-3.332 0l-6.5 5.717c-.307.276-.332.748-.057 1.055.262.292.704.331 1.014.091v5.326c.001 1.187.963 2.149 2.15 2.15h10.119c1.187-.001 2.148-.963 2.149-2.15v-5.326c.323.257.793.204 1.05-.119.248-.311.208-.763-.091-1.026zm-4.227-4.552c-.016-.488.366-.897.854-.913s.897.366.913.854c.001.02.001.04 0 .059v2.389l-1.767-1.554zm-2.625 11.671h-2.5v-1.748c.001-.613.497-1.109 1.11-1.11h.285c.613.001 1.109.497 1.11 1.11zm4.393-.648c0 .171-.068.336-.189.457h-.004c-.122.123-.287.191-.46.191h-2.24v-1.748c-.002-1.441-1.169-2.608-2.61-2.61h-.285c-1.441.002-2.608 1.169-2.61 2.61v1.746h-2.373c-.359-.001-.649-.291-.65-.65v-6.63l5.035-4.428c.387-.339.965-.339 1.352 0l5.034 4.426z"></path>
						<path fill="currentColor" d="m21.106 22.318c0 1.226.993 2.219 2.219 2.219s2.219-.994 2.219-2.219v-.001c-.002-1.225-.994-2.217-2.219-2.218-1.226 0-2.219.993-2.219 2.219zm2.938-.001c-.002.396-.323.716-.719.717v.002c-.397 0-.719-.322-.719-.719s.322-.719.719-.719.719.322.719.719z"></path>
						<path fill="currentColor" d="m23.001 10.145c0-.414-.336-.75-.75-.75h-15.462c-.414 0-.75.336-.75.75s.336.75.75.75h15.463c.414-.001.749-.336.749-.75z"></path>
						<path fill="currentColor" d="m6.789 14.216c-.414 0-.75.336-.75.75s.336.75.75.75h10.572c.414 0 .75-.336.75-.75s-.336-.75-.75-.75z"></path>
						<path fill="currentColor" d="m12.075 19.039h-5.286c-.414 0-.75.336-.75.75s.336.75.75.75h5.286c.414 0 .75-.336.75-.75s-.336-.75-.75-.75z"></path>
						<path fill="currentColor" d="m11.556 30.247h-9.03c-.427-.001-.772-.346-.773-.773v-25.653c.001-.27.142-.52.372-.661l2.11-1.283c.268-.164.609-.148.862.039l1.404 1.037c.749.558 1.764.598 2.554.1l1.9-1.183c.26-.163.593-.156.846.018l1.629 1.111c.766.527 1.776.532 2.547.013l1.692-1.133c.255-.171.587-.175.846-.009l1.836 1.171c.783.504 1.796.476 2.55-.072l1.425-1.027c.265-.191.622-.195.891-.01l1.736 1.2c.21.144.335.382.335.637v8.089c0 .414.336.75.75.75s.75-.336.75-.75v-8.093c-.001-.748-.37-1.449-.987-1.872l-1.733-1.194c-.792-.544-1.839-.532-2.619.028l-1.425 1.025c-.256.186-.6.196-.867.025l-1.836-1.17c-.761-.485-1.736-.474-2.486.028l-1.692 1.133c-.262.177-.606.177-.868 0l-1.63-1.119c-.746-.509-1.722-.529-2.488-.05l-1.896 1.181c-.269.169-.614.155-.868-.034l-1.406-1.037c-.742-.55-1.744-.593-2.531-.11l-2.11 1.279c-.677.414-1.09 1.15-1.093 1.943v25.653c.001 1.255 1.018 2.272 2.273 2.273h9.03c.414 0 .75-.336.75-.75s-.336-.75-.75-.75z"></path>
					</g>
				</svg>
			</span>
		</div>
		<div class="sb-billing-address-content">
			<h3 class="sb-billing-address-title woocommerce-column__title"><?php esc_html_e( 'Billing address', 'shopbuild' ); ?></h3>
			
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

	<?php if ( $show_shipping ) : ?>

		</div><!-- /.col-1 -->

		<div class="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address sb-col-6">
			<div class="sb-billing-address-item sb-d-sm-flex sb-align-items-start">
				<div class="sb-billing-address-icon">
					<span>
						<svg enable-background="new 0 0 32 32" viewBox="0 0 32 32">
							<g>
								<path fill="currentColor" d="m31.494 23.128-.959-.844v-3.708c0-1.315-1.067-2.382-2.382-2.382-1.144 0-2.126.813-2.34 1.937l-.821-.721c-.954-.835-2.378-.835-3.332 0l-6.5 5.717c-.307.276-.332.748-.057 1.055.262.292.704.331 1.014.091v5.326c.001 1.187.963 2.149 2.15 2.15h10.119c1.187-.001 2.148-.963 2.149-2.15v-5.326c.323.257.793.204 1.05-.119.248-.311.208-.763-.091-1.026zm-4.227-4.552c-.016-.488.366-.897.854-.913s.897.366.913.854c.001.02.001.04 0 .059v2.389l-1.767-1.554zm-2.625 11.671h-2.5v-1.748c.001-.613.497-1.109 1.11-1.11h.285c.613.001 1.109.497 1.11 1.11zm4.393-.648c0 .171-.068.336-.189.457h-.004c-.122.123-.287.191-.46.191h-2.24v-1.748c-.002-1.441-1.169-2.608-2.61-2.61h-.285c-1.441.002-2.608 1.169-2.61 2.61v1.746h-2.373c-.359-.001-.649-.291-.65-.65v-6.63l5.035-4.428c.387-.339.965-.339 1.352 0l5.034 4.426z"></path>
								<path fill="currentColor" d="m21.106 22.318c0 1.226.993 2.219 2.219 2.219s2.219-.994 2.219-2.219v-.001c-.002-1.225-.994-2.217-2.219-2.218-1.226 0-2.219.993-2.219 2.219zm2.938-.001c-.002.396-.323.716-.719.717v.002c-.397 0-.719-.322-.719-.719s.322-.719.719-.719.719.322.719.719z"></path>
								<path fill="currentColor" d="m23.001 10.145c0-.414-.336-.75-.75-.75h-15.462c-.414 0-.75.336-.75.75s.336.75.75.75h15.463c.414-.001.749-.336.749-.75z"></path>
								<path fill="currentColor" d="m6.789 14.216c-.414 0-.75.336-.75.75s.336.75.75.75h10.572c.414 0 .75-.336.75-.75s-.336-.75-.75-.75z"></path>
								<path fill="currentColor" d="m12.075 19.039h-5.286c-.414 0-.75.336-.75.75s.336.75.75.75h5.286c.414 0 .75-.336.75-.75s-.336-.75-.75-.75z"></path>
								<path fill="currentColor" d="m11.556 30.247h-9.03c-.427-.001-.772-.346-.773-.773v-25.653c.001-.27.142-.52.372-.661l2.11-1.283c.268-.164.609-.148.862.039l1.404 1.037c.749.558 1.764.598 2.554.1l1.9-1.183c.26-.163.593-.156.846.018l1.629 1.111c.766.527 1.776.532 2.547.013l1.692-1.133c.255-.171.587-.175.846-.009l1.836 1.171c.783.504 1.796.476 2.55-.072l1.425-1.027c.265-.191.622-.195.891-.01l1.736 1.2c.21.144.335.382.335.637v8.089c0 .414.336.75.75.75s.75-.336.75-.75v-8.093c-.001-.748-.37-1.449-.987-1.872l-1.733-1.194c-.792-.544-1.839-.532-2.619.028l-1.425 1.025c-.256.186-.6.196-.867.025l-1.836-1.17c-.761-.485-1.736-.474-2.486.028l-1.692 1.133c-.262.177-.606.177-.868 0l-1.63-1.119c-.746-.509-1.722-.529-2.488-.05l-1.896 1.181c-.269.169-.614.155-.868-.034l-1.406-1.037c-.742-.55-1.744-.593-2.531-.11l-2.11 1.279c-.677.414-1.09 1.15-1.093 1.943v25.653c.001 1.255 1.018 2.272 2.273 2.273h9.03c.414 0 .75-.336.75-.75s-.336-.75-.75-.75z"></path>
							</g>
						</svg>
					</span>
				</div>
				<div class="sb-billing-address-content">
					<h3 class="sb-billing-address-title woocommerce-column__title"><?php esc_html_e( 'Shipping address', 'shopbuild' ); ?></h3>
					
					<!-- street -->
					<?php if ( $order->get_formatted_shipping_full_name() ) : ?>
					<p><span><?php esc_html_e( 'Name:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_formatted_shipping_full_name() ); ?></p>
					<?php endif; ?>

					<?php if ( $order->get_shipping_address_1() ) : ?>
					<p><span><?php esc_html_e( 'Address 1:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_shipping_address_1() ); ?></p>
					<?php endif; ?>
					<?php if ( $order->get_shipping_address_2() ) : ?>
					<p><span><?php esc_html_e( 'Address 2:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_shipping_address_2() ); ?></p>
					<?php endif; ?>
					
					<?php if ( $order->get_shipping_city() ) : ?>
					<p><span><?php esc_html_e( 'City:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_shipping_city() ); ?></p>
					<?php endif; ?>
					<?php if ( $order->get_shipping_company() ) : ?>
					<p><span><?php esc_html_e( 'Company:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_shipping_company() ); ?></p>
					<?php endif; ?>
					<?php if ( $order->get_shipping_country() ) : ?>
					<p><span><?php esc_html_e( 'Country:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_shipping_country() ); ?></p>
					<?php endif; ?>
					<?php if ( $order->get_shipping_method() ) : ?>
					<p><span><?php esc_html_e( 'Method:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_shipping_method() ); ?></p>
					<?php endif; ?>
					<?php if ( $order->get_shipping_phone() ) : ?>
					<p><span><?php esc_html_e( 'Phone:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_shipping_phone() ); ?></p>
					<?php endif; ?>
					<?php if ( $order->get_shipping_postcode() ) : ?>
					<p><span><?php esc_html_e( 'Zip Code:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_shipping_postcode() ); ?></p>
					<?php endif; ?>
					<?php if ( $order->get_shipping_state() ) : ?>
					<p><span><?php esc_html_e( 'State:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_shipping_state() ); ?></p>
					<?php endif; ?>
					<?php if ( $order->get_shipping_tax() ) : ?>
					<p><span><?php esc_html_e( 'Tax:', 'shopbuild' ); ?></span><?php print wp_kses_post( $order->get_shipping_tax() ); ?></p>
					<?php endif; ?>
					<?php if ( $order->get_shipping_to_display() ) : ?>
					<p><span><?php esc_html_e( 'Tax Display:', 'shopbuild' ); ?></span><?php print wp_kses_post( $order->get_shipping_to_display() ); ?></p>
					<?php endif; ?>
					<?php if ( $order->get_shipping_total() ) : ?>
					<p><span><?php esc_html_e( 'Total:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_shipping_total() ); ?></p>
					<?php endif; ?>
					<?php if ( $order->get_total_shipping_refunded() ) : ?>
					<p><span><?php esc_html_e( 'Refund:', 'shopbuild' ); ?></span><?php echo esc_html( $order->get_total_shipping_refunded() ); ?></p>
					<?php endif; ?>

				</div>
			</div>
		</div><!-- /.col-2 -->

	</section><!-- /.col2-set -->

	<?php endif; ?>

	<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>

</section>
