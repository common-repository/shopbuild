<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.4.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); 
?>

<form class="woocommerce-cart-form  sb-cart-table" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<div class="sb-table-responsive">
		<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
			<thead>
				<tr>
					<th class="product-name" colspan="2"><?php esc_html_e( 'Product', 'shopbuild' ); ?></th>
					<th class="product-price"><?php esc_html_e( 'Price', 'shopbuild' ); ?></th>
					<th class="product-quantity"><?php esc_html_e( 'Quantity', 'shopbuild' ); ?></th>
					<th class="product-subtotal"><?php esc_html_e( 'Subtotal', 'shopbuild' ); ?></th>
					<th class="product-remove-heading"><?php esc_html_e( 'Action', 'shopbuild' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php do_action( 'woocommerce_before_cart_contents' ); ?>
	
				<?php
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
	
					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						?>
						<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
	
							<td class="product-thumbnail">
								<?php
								$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
	
								if ( ! $product_permalink ) {
									print wp_kses_post($thumbnail); // PHPCS: XSS ok.
								} else {
									printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), wp_kses_post($thumbnail) ); // PHPCS: XSS ok.
								}
								?>
							</td>
	
							<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'shopbuild' ); ?>">
							<?php
							if ( ! $product_permalink ) {
								print wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
							} else {
								print wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
							}
	
							do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
	
							// Meta data.
							print wp_kses_post(wc_get_formatted_cart_item_data( $cart_item )); // PHPCS: XSS ok.
	
							// Backorder notification.
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
								print wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'shopbuild' ) . '</p>', $product_id ) );
							}
							?>
							</td>
	
							<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'shopbuild' ); ?>">
								<?php
									print wp_kses_post(apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key )); // PHPCS: XSS ok.
								?>
							</td>
	
							<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'shopbuild' ); ?>">
							<?php
							if ( $_product->is_sold_individually() ) {
								$min_quantity = 1;
								$max_quantity = 1;
							} else {
								$min_quantity = 0;
								$max_quantity = $_product->get_max_purchase_quantity();
							}
	
							$product_quantity = woocommerce_quantity_input(
								array(
									'input_name'   => "cart[{$cart_item_key}][qty]",
									'input_value'  => $cart_item['quantity'],
									'max_value'    => $max_quantity,
									'min_value'    => $min_quantity,
									'product_name' => $_product->get_name(),
								),
								$_product,
								false
							);
	
								print wp_kses(apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ), pure_wc_get_kses_extended_ruleset());
							?>
							</td>
	
							<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'shopbuild' ); ?>">
								<?php
									print wp_kses(apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ), pure_wc_get_kses_extended_ruleset()); // PHPCS: XSS ok.
								?>
							</td>
	
							<td class="product-remove">
								<?php
									echo wp_kses(apply_filters( 
										'woocommerce_cart_item_remove_link',
										sprintf(
											'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">
												<svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path fill-rule="evenodd" clip-rule="evenodd" d="M9.53033 1.53033C9.82322 1.23744 9.82322 0.762563 9.53033 0.46967C9.23744 0.176777 8.76256 0.176777 8.46967 0.46967L5 3.93934L1.53033 0.46967C1.23744 0.176777 0.762563 0.176777 0.46967 0.46967C0.176777 0.762563 0.176777 1.23744 0.46967 1.53033L3.93934 5L0.46967 8.46967C0.176777 8.76256 0.176777 9.23744 0.46967 9.53033C0.762563 9.82322 1.23744 9.82322 1.53033 9.53033L5 6.06066L8.46967 9.53033C8.76256 9.82322 9.23744 9.82322 9.53033 9.53033C9.82322 9.23744 9.82322 8.76256 9.53033 8.46967L6.06066 5L9.53033 1.53033Z" fill="currentColor"></path>
												</svg>
												<span>Remove</span>
											</a>',
											esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
											esc_html__( 'Remove this item', 'shopbuild' ),
											esc_attr( $product_id ),
											esc_attr( $_product->get_sku() )
										),
										$cart_item_key
									), pure_wc_get_kses_extended_ruleset());
								?>
							</td>
						</tr>
						<?php
					}
				}
				?>
	
				<?php do_action( 'woocommerce_cart_contents' ); ?>
				<?php do_action( 'woocommerce_after_cart_contents' ); ?>
			</tbody>
		</table>
	</div>
	<div class="sb-row">
		<div class="sb-col-md-12">
			<div class="sb-cart-coupon-wrapper sb-d-flex sb-flex-wrap sb-align-items-start sb-justify-content-between">
				<div class="sb-cart-coupon-form">
					<?php if ( isset($show_coupon) && "yes" == $show_coupon ) : ?>
						<div class="coupon">
							<?php do_action( 'pure_wc_coupon_form', 'Apply' ); ?>
						</div>
					<?php endif; ?>
				</div>
				<div class="sb-cart-coupon-update">
					<button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'shopbuild' ); ?>" aria-disabled="true"><?php esc_html_e( 'Update cart', 'shopbuild' ); ?></button>
				</div>
	

				<?php do_action( 'woocommerce_cart_actions' ); ?>
	
				<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

			</div>
		</div>
	</div>
	<div class="sb-row woocommerce">
		<div class="sb-col-md-12">
		<?php
			if($show_cross_sell == 'yes'){
				$cross_sells = array_filter( array_map( 'wc_get_product', WC()->cart->get_cross_sells() ), 'wc_products_array_filter_visible' );
				pure_wc_get_template( 'cart/cross-sells.php', array(
					'cross_sells' => $cross_sells,
					'pure_cross_sell_col' => $pure_cross_sell_col,
					'pure_cross_sell_heading' => $pure_cross_sell_heading,
				));
			}
		?>
		</div>
	</div>
	
	<div class="sb-row sb-justify-content-end">
		<div class="sb-col-md-5">
			<div class="sb-cart-total">
				<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>
	
				<div class="cart-collaterals">
					<?php
						/**
						 * Cart collaterals hook.
						 *
						 * @hooked woocommerce_cross_sell_display
						 * @hooked woocommerce_cart_totals - 10
						 */
						//do_action( 'woocommerce_cart_collaterals' );
						if($show_cart_totals == 'yes'){
							woocommerce_cart_totals();
						}
					?>
				</div>
			</div>
		</div>
	</div>
	
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>



<?php do_action( 'woocommerce_after_cart' ); ?>
