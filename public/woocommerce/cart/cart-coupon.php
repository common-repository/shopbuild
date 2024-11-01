<?php
/**
 * Cart Coupon
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly    
$button_title = isset($button_title)? $button_title : esc_html__('Apply', 'shopbuild');
$coupon_title = isset($coupon_title)? $coupon_title : esc_html__('Coupon:', 'shopbuild');
$coupon_style = isset($coupon_style)? $coupon_style : 'default';
do_action( 'pure_wc_coupon_form', $button_title, $coupon_title, $coupon_style );
?>