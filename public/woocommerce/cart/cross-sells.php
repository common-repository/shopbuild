<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

defined( 'ABSPATH' ) || exit;

if ( $cross_sells ) : ?>

	<div class="cross-sells">
		<?php if ( !empty($pure_cross_sell_heading) ) : ?>
			<h2 class="sb-el-cart-cross-sell-heading"><?php echo esc_html( $pure_cross_sell_heading );   ?></h2>
		<?php endif; ?> 

		<div class="sb-row <?php echo isset($pure_cross_sell_col)? esc_attr($pure_cross_sell_col): ''; ?>">

			<?php foreach ( $cross_sells as $cross_sell ) : ?>

				<?php
					$post_object = get_post( $cross_sell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

					wc_get_template_part( 'content', 'product' );
				?>

			<?php endforeach; ?>

		</div>
	</div>
	<?php
endif;

wp_reset_postdata();
