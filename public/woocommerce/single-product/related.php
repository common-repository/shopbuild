<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

	<section class="related products">

		<?php
		$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related products', 'shopbuild' ) );
		$args = array(
			"product_style" => '1',
			"pure_wc_trim_title_word" => '6',
			"product_content_align" => 'default',
			"product_rating_switch" => 'yes',
			"review_text_switch" => 'yes',
			"action_style" => 'default',
			"tootltip_position" => 'right',
			"action_button_position" => 'left',
			"sale_badge_position" => 'default_positon',
			"pure_wc_tooltip_switch" => 'yes',
			"pure_wc_quick_view_switch" => 'yes',
			"pure_wc_wishlist_switch" => 'yes',
			"pure_wc_compare_switch" => 'yes',
			"select_type_attribute_position" => 'on_thumbnail',
			"color_type_attribute_position" => 'on_thumbnail',
			"image_type_attribute_position" => 'on_thumbnail',
			"none_type_attribute_position" => 'on_thumbnail',
			"action_type" => 'on_hover',
		);
		
		if ( $heading ) :
			?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<?php 
			$related_class = count($related_products) > 4 ? 'tp-woo-related-product-related-active' : '';

			?>				
			<div class="<?php echo esc_attr($related_class); ?>">
			<?php woocommerce_product_loop_start(); ?>
				<?php foreach ( $related_products as $related_product ) : ?>
					<?php
						$post_object = get_post( $related_product->get_id() );

						setup_postdata( $GLOBALS['post'] =& $post_object );

						

						if($args['product_style'] > 0){
							pure_wc_product_style($args);
						}else{
							wc_get_template_part( 'content', 'product' );
						}
					?>
				<?php endforeach; ?>

			<?php woocommerce_product_loop_end(); ?>
			</div>
	</section>
	<?php
endif;

wp_reset_postdata();
