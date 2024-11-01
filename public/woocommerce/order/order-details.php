<?php
    defined( 'ABSPATH' ) || exit;
    $order_id = isset($order_id)? $order_id : get_query_var('order-received');
    $order = wc_get_order( $order_id );

    if ( !$order ){
        return;
    }
    $order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
    $show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
    $pure_wc_order_details_style = isset($pure_wc_order_details_style)? $pure_wc_order_details_style : 2;
?>

<?php if($pure_wc_order_details_style == '2') : ?>

    <div class="sb-order-info-wrapper-2">
        <?php
            foreach ( $order_items as $item_id => $item ) {
                $item = new \WC_Order_Item_Product( $item );
                $product = $item->get_product();

                wc_get_template(
                    'order/order-details-item.php',
                    array(
                        'order'              => $order,
                        'item_id'            => $item_id,
                        'item'               => $item,
                        'show_purchase_note' => $show_purchase_note,
                        'purchase_note'      => $product ? $product->get_purchase_note() : '',
                        'product'            => $product,
                        'pure_wc_order_details_style' => $pure_wc_order_details_style,
                    )
                );
            }
        ?>
    </div>

    <?php
        foreach ( $order->get_order_item_totals() as $key => $total ) :
    ?>
    <div class="sb-order-info-list-total-2 sb-d-flex sb-align-items-center sb-justify-content-between">
        <span class="<?php echo esc_attr($key); ?>"><?php echo esc_html( $total['label'] ); ?></span>
        <span class="<?php echo esc_attr($key); ?>"><?php echo ( 'payment_method' === $key ) ? esc_html( $total['value'] ) : wp_kses_post( $total['value'] );  ?></span>
    </div>
    <?php endforeach; ?>

    <?php if ( $order->get_customer_note() ) : ?>
    <div class="sb-order-info-list-total-2 sb-d-flex sb-align-items-center sb-justify-content-between">
        <span><?php esc_html_e( 'Note:', 'shopbuild' ); ?></span>
        <span><?php print wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></span>
    </div>
    <?php endif; ?>

<?php else: ?>
<div class="woocommerce-order-details sb-order-info-wrapper">
    <div class="woocommerce-table woocommerce-table--order-details shop_table order_details sb-order-info-list">
        <ul>

            <!-- header -->
            <li class="sb-order-info-list-header">
                <h4 class="woocommerce-table__product-name"><?php esc_html_e( 'Product', 'shopbuild' ); ?></h4>
                <h4><?php esc_html_e( 'Total', 'shopbuild' ); ?></h4>
            </li>

            <li class="sb-order-info-list-inner">
                <ul>
                <?php
                    foreach ( $order_items as $item_id => $item ) {
                        $item = new \WC_Order_Item_Product( $item );
                        $product = $item->get_product();

                        wc_get_template(
                            'order/order-details-item.php',
                            array(
                                'order'              => $order,
                                'item_id'            => $item_id,
                                'item'               => $item,
                                'show_purchase_note' => $show_purchase_note,
                                'purchase_note'      => $product ? $product->get_purchase_note() : '',
                                'product'            => $product,
                                'pure_wc_order_details_style' => $pure_wc_order_details_style,
                            )
                        );
                    }
                    ?>
                </ul>
            </li>
            

            <!-- total -->
            <?php
                foreach ( $order->get_order_item_totals() as $key => $total ) :
            ?>
            <li class="sb-order-info-list-total">
                <span><?php echo esc_html( $total['label'] ); ?></span>
                <span><?php echo ( 'payment_method' === $key ) ? esc_html( $total['value'] ) : wp_kses_post( $total['value'] );  ?></span>
            </li>
            <?php endforeach; ?>

            <?php if ( $order->get_customer_note() ) : ?>
            <li class="sb-order-info-list-total">
                <span><?php esc_html_e( 'Note:', 'shopbuild' ); ?></span>
                <span><?php print wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></span>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<?php endif; ?>