<?php
/**
 * Review Order
 */
defined( 'ABSPATH' ) || exit;

use Elementor\Plugin;


$pure_checkout_order_style = isset($_SESSION['checkout_order_style'])? sanitize_text_field(wp_unslash($_SESSION['checkout_order_style'])) : 'default';
?>


<table class="shop_table woocommerce-checkout-review-order-table">
    <thead>
        <tr>
            <th class="product-name"><?php esc_html_e( 'Product', 'shopbuild' ); ?></th>
            <th class="product-total"><?php esc_html_e( 'Subtotal', 'shopbuild' ); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
            if( !is_null(WC()->cart) ){
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
        ?>
        <tr
            class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
            <td class="product-name">
                <?php
                if(!empty($pure_checkout_order_style) && $pure_checkout_order_style == 'style_2') : 
                    $product_image = wp_get_attachment_image_src( get_post_thumbnail_id($_product->get_id()), 'single-post-thumbnail' );
                ?>
                <div class="sb-d-flex sb-align-items-center pure-checkout-order-style-2">
                    <?php if(!empty($product_image[0])) : ?>
                        <div class="pure-checkout-order-thumbnail p-relative mr-10">
                            <img class="d-inline-block mr-10" src="<?php echo esc_url( $product_image[0] ); ?>" alt="<?php echo esc_attr( $_product->get_name() ); ?>" width="64" height="64" />

                            <div class="pure-checkout-order-qty">
                            <?php echo wp_kses(apply_filters( 'woocommerce_checkout_cart_item_quantity', sprintf( '%s', $cart_item['quantity'] ), $cart_item, $cart_item_key ), pure_wc_get_kses_extended_ruleset());  ?>
                            </div>
                        </div>
                    <?php endif;?>

                    <p class="pure-checkout-product-title m-0">
                        <?php print wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) . '&nbsp;'; ?>
                    </p>
                    
                  
                </div>
                <?php else: ?>

                <div class="sb-d-flex sb-align-items-center p-relative">
                    <p class="pure-checkout-product-title m-0">
                        <?php print wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) . '&nbsp;'; ?>

                        <?php echo wp_kses(apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ), pure_wc_get_kses_extended_ruleset());  ?>
                        
                        <?php echo wp_kses(wc_get_formatted_cart_item_data( $cart_item ), pure_wc_get_kses_extended_ruleset());  ?>
                    </p>
                    
                </div>
                <?php endif; ?>

            </td>
            <td class="product-total">
                <?php echo wp_kses(apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ), pure_wc_get_kses_extended_ruleset());  ?>
            </td>
        </tr>
        <?php
            }
        }
        }else{
            $_product = wc_get_product( pure_wc_get_last_product_id() );
        ?>
        <tr class=" <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item' ) ); ?>">
            <td class="product-name">
            <?php if($pure_checkout_order_style == 'style_2') : 
                $product_image = wp_get_attachment_image_src( get_post_thumbnail_id($_product->get_id()), 'single-post-thumbnail' );
            ?>
               <?php if(!empty($product_image[0])) : ?>
                    <div class="pure-checkout-order-thumbnail p-relative mr-10">
                        <img class="d-inline-block mr-10" src="<?php echo esc_url( $product_image[0] ); ?>" alt="<?php echo esc_attr( $_product->get_name() ); ?>" width="64" height="64" />
                    </div>
                <?php endif;?>
            <?php endif; ?>
                <?php echo esc_html( $_product->get_name() ); ?>
                <?php echo wp_kses_post(apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', 1 ) . '</strong>' ));?>
                <?php echo wp_kses_post(wc_get_formatted_cart_item_data( array('data' => $_product) )); ?>
            </td>
            <td class="product-total">
                <?php echo wp_kses_post($_product->get_price_html()); ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>

        <tr class="cart-subtotal">
            <th><?php esc_html_e( 'Subtotal', 'shopbuild' ); ?></th>
            <td>
                <?php 
                    if( !is_null(WC()->cart) ){
                        wc_cart_totals_subtotal_html(); 
                    }else{
                        $_product = wc_get_product( pure_wc_get_last_product_id());
                        print wp_kses_post($_product->get_price_html());
                    }
                ?>
            </td>
        </tr>

        <?php if( !is_null(WC()->cart) ){ ?>
        <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
                <tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                    <th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
                    <td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
                </tr>
        <?php endforeach; ?>
        <?php  } ?>
        <?php 
            if( !is_null(WC()->cart) ){
                if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : 
                    do_action( 'woocommerce_review_order_before_shipping' );
                    wc_cart_totals_shipping_html();
                    do_action( 'woocommerce_review_order_after_shipping' );
                endif; 
            }  
        ?>

        <?php 
            if( !is_null(WC()->cart) ){
            foreach ( WC()->cart->get_fees() as $fee ) : ?>
            <tr class="fee">
                <th><?php echo esc_html( $fee->name ); ?></th>
                <td><?php wc_cart_totals_fee_html( $fee ); ?></td>
            </tr>
        <?php 
            endforeach; 
            }
        ?>

        <?php if ( !Plugin::instance()->editor->is_edit_mode()  && wc_tax_enabled() && ! WC()->cart->display_prices_including_tax()) : ?>
        <?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
        <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
        <tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
            <th><?php echo esc_html( $tax->label ); ?></th>
            <td><?php print wp_kses_post( $tax->formatted_amount ); ?></td>
        </tr>
        <?php endforeach; ?>
        <?php else : ?>
        <tr class="tax-total">
            <th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
            <td><?php wc_cart_totals_taxes_total_html(); ?></td>
        </tr>
        <?php endif; ?>
        <?php endif; ?>
        <tr class="order-total">
            <th><?php esc_html_e( 'Total', 'shopbuild' ); ?></th>
            <td>
                <?php 
                    if( !is_null(WC()->cart) ){
                        wc_cart_totals_order_total_html(); 
                    }else{
                        $_product = wc_get_product( pure_wc_get_last_product_id());
                        print wp_kses_post($_product->get_price_html());
                    }
                ?>
            </td>
        </tr>
    </tfoot>
</table>