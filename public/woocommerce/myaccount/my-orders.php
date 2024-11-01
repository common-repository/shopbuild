<?php
/**
 * My Orders - Deprecated
 *
 * @deprecated 2.6.0 this template file is no longer used. My Account shortcode uses orders.php.
 * @package WooCommerce\Templates
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly      

$my_orders_columns = apply_filters(
	'woocommerce_my_account_my_orders_columns',
	array(
		'order-number'  => esc_html__( 'Order', 'shopbuild' ),
		'order-date'    => esc_html__( 'Date', 'shopbuild' ),
		'order-status'  => esc_html__( 'Status', 'shopbuild' ),
		'order-total'   => esc_html__( 'Total', 'shopbuild' ),
		'order-actions' => '&nbsp;',
	)
);

$customer_orders = get_posts(
	apply_filters(
		'woocommerce_my_account_my_orders_query',
		array(
			'numberposts' => $order_count,
			'meta_key'    => '_customer_user', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'meta_value'  => get_current_user_id(), // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
			'post_type'   => wc_get_order_types( 'view-orders' ),
			'post_status' => array_keys( wc_get_order_statuses() ),
		)
	)
);

if ( $customer_orders ) : ?>

	<div class="sb-myaccount-table ddd">
		
		<h2><?php echo esc_html(apply_filters( 'woocommerce_my_account_my_orders_title', esc_html__( 'Recent orders', 'shopbuild' ) ));  ?></h2>
	
		<table class="shop_table shop_table_responsive my_account_orders ">
	
			<thead>
				<tr>
					<?php foreach ( $my_orders_columns as $column_id => $column_name ) : ?>
						<th class="<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
					<?php endforeach; ?>
				</tr>
			</thead>
	
			<tbody>
				<?php
				foreach ( $customer_orders as $customer_order ) :
					$order      = wc_get_order( $customer_order );
					$item_count = $order->get_item_count();
					?>
					<tr class="order">
						<?php foreach ( $my_orders_columns as $column_id => $column_name ) : ?>
							<td class="<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
								<?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
									<?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>
	
								<?php elseif ( 'order-number' === $column_id ) : ?>
									<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
										<?php echo esc_html(_x( '#', 'hash before order number', 'shopbuild' ). $order->get_order_number()); ?>
									</a>
	
								<?php elseif ( 'order-date' === $column_id ) : ?>
									<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>
	
								<?php elseif ( 'order-status' === $column_id ) : ?>
									<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
	
								<?php elseif ( 'order-total' === $column_id ) : ?>
									<?php
										printf(
											esc_html(
												/* translators: 1: number of items, 2: total price */
												_n(
													'%1$s for %2$s item',
													'%1$s for %2$s items',
													$item_count,
													'shopbuild'
												)
											),
											esc_html(number_format_i18n($item_count)),
											esc_html(number_format_i18n($order->get_formatted_order_total())),
										);
									?>
	
								<?php elseif ( 'order-actions' === $column_id ) : ?>
									<?php
									$actions = wc_get_account_orders_actions( $order );
	
									if ( ! empty( $actions ) ) {
										foreach ( $actions as $key => $action ) {
											echo '<a href="' . esc_url( sanitize_url($action['url']) ) . '" class="button ' . sanitize_html_class( $key ) . '">' . esc_html( sanitize_text_field( $action['name'] ) ) . '</a>';
										}
									}
									?>
								<?php endif; ?>
							</td>
						<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
<?php endif; ?>
