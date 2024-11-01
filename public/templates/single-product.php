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

/**
 * Hook for print notices.
 * woocommerce_before_single_product hook.
 *
 * @hooked wc_print_notices - 10
 */
global $post;
global $product;

if ( post_password_required() ) {
	print wp_kses_post(get_the_password_form());
	return;
}
?>
<div class="elementor-section elementor-section-boxed elementor-element">
	<div class="elementor-container elementor-column-gap-default">
		<div class="elementor-column">
			<div class="elementor-widget-wrap elementor-element-populated">
				<div class="elementor-widget-container">
					<?php
						do_action( 'woocommerce_before_single_product' );
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="product-<?php the_ID(); ?>" <?php post_class(); ?> <?php wc_product_class( '', $product ); ?>>
	<div class="pure-wc-shopbuild-template-builder">
		<?php
			do_action( 'pure_wc_shopbuild_single_product_content', $post );
		?>
	</div>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
