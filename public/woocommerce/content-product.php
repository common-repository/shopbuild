<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly    

global $product;
// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$theme = wp_get_theme();
?>
<div <?php wc_product_class( 'sb-product-archive', $product ); ?>>
	<?php
	if( $theme->Name == 'OceanWP' ){
		woocommerce_template_loop_product_link_open();

		woocommerce_show_product_loop_sale_flash();
		woocommerce_template_loop_product_thumbnail();

		do_action( 'pure_wc_button_position_before_title' );

		woocommerce_template_loop_product_title();

		do_action( 'pure_wc_button_position_after_title' );

		woocommerce_template_loop_rating();

		do_action( 'pure_wc_button_position_after_rating' );

		woocommerce_template_loop_price();

		do_action( 'pure_wc_button_position_after_price' );

		woocommerce_template_loop_product_link_close();

		do_action( 'pure_wc_button_position_before_add_to_cart' );

		woocommerce_template_loop_add_to_cart();

		do_action( 'pure_wc_button_position_after_add_to_cart' );
	}else{
		/**
		 * Hook: woocommerce_before_shop_loop_item.
		 *
		 * @hooked woocommerce_template_loop_product_link_open - 10
		 */
		do_action( 'woocommerce_before_shop_loop_item' );
		/**
		 * Hook: woocommerce_before_shop_loop_item_title.
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
		// do_action( 'woocommerce_before_shop_loop_item_title' );

		/**
		 * Hook: woocommerce_shop_loop_item_title.
		 *
		 * @hooked woocommerce_template_loop_product_title - 10
		 */
		// do_action( 'woocommerce_shop_loop_item_title' );

		/**
		 * Hook: woocommerce_after_shop_loop_item_title.
		 *
		 * @hooked woocommerce_template_loop_rating - 5
		 * @hooked woocommerce_template_loop_price - 10
		 */
		// do_action( 'woocommerce_after_shop_loop_item_title' );

		/**
		 * Hook: woocommerce_after_shop_loop_item.
		 *
		 * @hooked woocommerce_template_loop_product_link_close - 5
		 * @hooked woocommerce_template_loop_add_to_cart - 10
		 */
		// do_action( 'woocommerce_after_shop_loop_item' );

	}
	?>
</div>

