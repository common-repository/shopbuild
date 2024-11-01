<?php
/**
 * Order Item Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-item.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
	return;
}


?>

<?php if($pure_wc_order_details_style == 2) : 
	$is_visible        = $product && $product->is_visible();
	$product_permalink = apply_filters( 'woocommerce_order_item_permalink', $is_visible ? $product->get_permalink( $item ) : '', $item, $order );

	$qty          = $item->get_quantity();
	$refunded_qty = $order->get_qty_refunded_for_item( $item_id );
	
	if ( $refunded_qty ) {
		$qty_display = '<del>' . esc_html( $qty ) . '</del> <ins>' . esc_html( $qty - ( $refunded_qty * -1 ) ) . '</ins>';
	} else {
		$qty_display = esc_html( $qty );
	}

	
?>
<div class="sb-order-info-items-wrapper <?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'woocommerce-table__line-item order_item', $item, $order ) ); ?>">
	<!-- item list -->
	<div class="sb-order-info-item-2 sb-d-flex sb-align-items-center sb-justify-content-between">
		<div class="sb-order-info-content-inner-2 sb-d-flex sb-align-items-center">
	
			<?php if( has_post_thumbnail($item->get_product_id()) ) : ?>
				<div class="sb-order-info-thumb-2">
					<?php echo wp_kses(get_the_post_thumbnail($item->get_product_id(), [120, 120]), pure_wc_get_kses_extended_ruleset()); ?>
					<span class="order-qty"><?php echo esc_html($qty_display); ?></span>
				</div>
			<?php endif; ?>
			<div class="sb-order-info-content-2">
				<h3 class="sb-order-info-title-2"><?php print wp_kses_post( apply_filters( 'woocommerce_order_item_name', $product_permalink ? sprintf( '<a href="%s">%s</a>', $product_permalink, $item->get_name() ) : $item->get_name(), $item, $is_visible ) ); ?></h3>

				<?php
					do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false );
		
					wc_display_item_meta( $item ); 
			
					do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false );
				?>
			</div>
		</div>
		<div class="sb-order-info-price-2">
			<span>
				<?php echo wp_kses($order->get_formatted_line_subtotal( $item ), pure_wc_get_kses_extended_ruleset()); ?>
			</span>
		</div>
	</div>

	<?php if ( $show_purchase_note && $purchase_note ) : ?>

	<div class="woocommerce-table__product-purchase-note product-purchase-note">
		<?php echo wp_kses_post(wpautop( do_shortcode( wp_kses_post( $purchase_note ) ) ));  ?>
	</div>

	<?php endif; ?>
</div>


<?php else : ?>
	<!-- item list -->
	<li class="sb-order-info-list-desc <?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'woocommerce-table__line-item order_item', $item, $order ) ); ?>">
		<div class="sb-order-info-list-content">
			<p class="woocommerce-table__product-name">
				<?php
				$is_visible        = $product && $product->is_visible();
				$product_permalink = apply_filters( 'woocommerce_order_item_permalink', $is_visible ? $product->get_permalink( $item ) : '', $item, $order );
		
				print wp_kses_post( apply_filters( 'woocommerce_order_item_name', $product_permalink ? sprintf( '<a href="%s">%s</a>', $product_permalink, $item->get_name() ) : $item->get_name(), $item, $is_visible ) );
		
				$qty          = $item->get_quantity();
				$refunded_qty = $order->get_qty_refunded_for_item( $item_id );
		
				if ( $refunded_qty ) {
					$qty_display = '<del>' . esc_html( $qty ) . '</del> <ins>' . esc_html( $qty - ( $refunded_qty * -1 ) ) . '</ins>';
				} else {
					$qty_display = esc_html( $qty );
				}
		
				echo wp_kses(apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $qty_display ) . '</strong>', $item ), pure_wc_get_kses_extended_ruleset()); 
		
				do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false );
		
				wc_display_item_meta( $item ); 
		
				do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false );
				?>
			</p>
		</div>
		<span class="woocommerce-table__product-total"><?php echo wp_kses($order->get_formatted_line_subtotal( $item ), pure_wc_get_kses_extended_ruleset());  ?></span>
	</li>

	<?php if ( $show_purchase_note && $purchase_note ) : ?>

	<li class="woocommerce-table__product-purchase-note product-purchase-note">
		<?php echo wp_kses_post(wpautop( do_shortcode( wp_kses_post( $purchase_note ) ) ));  ?>
	</li>
	<?php endif; ?>
<?php endif; ?>
