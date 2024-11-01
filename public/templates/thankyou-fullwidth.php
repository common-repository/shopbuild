<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see      https://docs.woocommerce.com/document/template-structure/
 * @author   WooThemes
 * @package  WooCommerce/Templates
 * @version  1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if( class_exists('\Elementor\Plugin') ){
	\Elementor\Plugin::$instance->frontend->add_body_class( 'elementor-template-full-width' );
}

global $post;

get_header( 'shop' );

do_action( 'elementor/page_templates/header-footer/before_content' ); 
?>

<div class="pure-wc-shopbuild-template-builder woocommerce">
	<div class="woocommerce-order">
		<?php 
			do_action( 'pure_wc_shopbuild_order_received_content', $post ); 
		?>
	</div>
</div>
<?php 
do_action( 'elementor/page_templates/header-footer/after_content' );
get_footer( 'shop' ); 
?>
