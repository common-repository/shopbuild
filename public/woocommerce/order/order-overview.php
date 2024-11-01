<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly    

?>
<div class="sb-order-details">
    <div class="sb-order-details-top">
        <?php if(!empty($pure_wc_order_icon_svg) || $pure_wc_order_icon_image) : ?>
        <div class="sb-order-details-icon">

            <?php if( $pure_wc_order_icon_type == 'image' ) : ?>
                <span>
                    <?php if (!empty($pure_wc_order_icon_image['url'])): ?>
                    <img src="<?php echo esc_url($pure_wc_order_icon_image['url']); ?>" alt="<?php echo esc_attr(get_post_meta(attachment_url_to_postid($pure_wc_order_icon_image['url']), '_wp_attachment_image_alt', true)); ?>">
                    <?php endif; ?>
                </span>
            <?php else : ?>
                <span>
                    <?php if (!empty($pure_wc_order_icon_svg)): ?>
                    <?php echo wp_kses($pure_wc_order_icon_svg, pure_wc_get_kses_extended_ruleset()); ?>
                    <?php endif; ?>
                </span>
            <?php endif; ?>  
        </div>
        <?php endif; ?>
        
        <div class="sb-order-details-content">
            <?php if(!empty($pure_wc_order_heading)) : ?>
            <h3 class="sb-order-details-title"><?php echo esc_html($pure_wc_order_heading); ?></h3>
            <?php endif; ?>
            <?php if(!empty($pure_wc_order_desc)) : ?>
            <p><?php echo wp_kses($pure_wc_order_desc, pure_wc_get_kses_extended_ruleset()); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="sb-order-details-item-wrapper">
        <div class="sb-row">
            <div class="sb-col-sm-6">
                <div class="sb-order-details-item">
                    <h4><?php echo esc_html($pure_wc_order_date_title); ?></h4>
                    <p><?php echo esc_html(wc_format_datetime( $order->get_date_created() )); ?></p>
                </div>
            </div>
            <div class="sb-col-sm-6">
                <div class="sb-order-details-item">
                    <h4><?php echo esc_html($pure_wc_order_total_title); ?></h4>
                    <p><?php print wp_kses_post($order->get_formatted_order_total()); ?></p>
                </div>
            </div>
            <div class="sb-col-sm-6">
                <div class="sb-order-details-item">
                    <h4> <?php echo esc_html($pure_wc_order_number_title); ?></h4>
                    <p><?php esc_html_e( '#', 'shopbuild' ); ?><?php echo esc_html($order->get_order_number()); ?></p>
                </div>
            </div>
            <div class="sb-col-sm-6">
                <div class="sb-order-details-item">
                    <h4> <?php echo esc_html($pure_wc_order_payment_title); ?></h4>
                    <p><?php print wp_kses_post( $order->get_payment_method_title() ); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>