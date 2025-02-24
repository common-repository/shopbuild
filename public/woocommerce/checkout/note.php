<?php
/**
 * Checkout Note
 */
defined('ABSPATH') || exit;

$checkout = new \WC_Checkout();
?>

<div class="row">
    <div class="col-12">
        <div class="woocommerce-additional-fields">
            <?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

            <?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

                <div class="woocommerce-additional-fields__field-wrapper">
                    <?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
                        <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
                    <?php endforeach; ?>
                </div>

            <?php endif; ?>

            <?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
        </div>
    </div>
</div>