<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	)
);

$single_style = isset($single_style) ? $single_style : 'default';

if($single_style == 'left_sidebar') {
	$layout_class = 'pure-single-product-gallery-vertical-sidebar left_side ' ;
} elseif($single_style == 'right_sidebar') {
	$layout_class = 'pure-single-product-gallery-vertical-sidebar right_side';
} elseif($single_style == 'top_sidebar') {
	$layout_class = 'pure-single-product-gallery-top-sidebar';
}else {
	$layout_class = 'pure-single-product-gallery-default';
}

$layout_class .= count( $product->get_gallery_image_ids()) > 0 ? ' has-thumbnails' : 'no-thumbnails ';



?>

<?php if($single_style == 'grid_view') : ?>
	<div class="pure-wc-product-single-grid sb-row <?php echo esc_attr($columns_class); ?>">
		<?php
			
			if ( $post_thumbnail_id ) {
				$html = wc_get_gallery_image_html( $post_thumbnail_id, true );
			} else {
				$wrapper_classname = $product->is_type( 'variable' ) && ! empty( $product->get_available_variations( 'image' ) ) ?
					'woocommerce-product-gallery__image woocommerce-product-gallery__image--placeholder' :
					'woocommerce-product-gallery__image--placeholder';
				$html              = sprintf( '<div class="%s">', esc_attr( $wrapper_classname ) );
				$html             .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'shopbuild' ) );
				$html             .= '</div>';
			}

			print wp_kses(apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ), pure_wc_get_kses_extended_ruleset());

			// do_action( 'woocommerce_product_thumbnails' );
			$attachment_ids = $product->get_gallery_image_ids();

			if ( $attachment_ids && $product->get_image_id() ) {
				foreach ( $attachment_ids as $attachment_id ) {
					print wp_kses(apply_filters( 'woocommerce_single_product_image_thumbnail_html', wc_get_gallery_image_html( $attachment_id ), $attachment_id ), pure_wc_get_kses_extended_ruleset()); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
				}
			}
		?>
	</div>

<?php elseif($single_style == 'list_view') : ?>
	<div class="pure-wc-product-single-list">
		<?php
			
			if ( $post_thumbnail_id ) {
				$html = wc_get_gallery_image_html( $post_thumbnail_id, true );
			} else {
				$wrapper_classname = $product->is_type( 'variable' ) && ! empty( $product->get_available_variations( 'image' ) ) ?
					'woocommerce-product-gallery__image woocommerce-product-gallery__image--placeholder' :
					'woocommerce-product-gallery__image--placeholder';
				$html              = sprintf( '<div class="%s">', esc_attr( $wrapper_classname ) );
				$html             .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'shopbuild' ) );
				$html             .= '</div>';
			}

			print wp_kses(apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ), pure_wc_get_kses_extended_ruleset());

			// do_action( 'woocommerce_product_thumbnails' );
			$attachment_ids = $product->get_gallery_image_ids();

			if ( $attachment_ids && $product->get_image_id() ) {
				foreach ( $attachment_ids as $attachment_id ) {
					print wp_kses(apply_filters( 'woocommerce_single_product_image_thumbnail_html', wc_get_gallery_image_html( $attachment_id ), $attachment_id ), pure_wc_get_kses_extended_ruleset()); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
				}
			}
		?>
	</div>

<?php else: ?>
<div class="<?php echo esc_attr($layout_class); ?> <?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>">
	<?php woocommerce_show_product_sale_flash();  ?>
	<figure class="woocommerce-product-gallery__wrapper">
		<?php
		
		if ( $post_thumbnail_id ) {
			$html = wc_get_gallery_image_html( $post_thumbnail_id, true );
		} else {
			$wrapper_classname = $product->is_type( 'variable' ) && ! empty( $product->get_available_variations( 'image' ) ) ?
				'woocommerce-product-gallery__image woocommerce-product-gallery__image--placeholder' :
				'woocommerce-product-gallery__image--placeholder';
			$html              = sprintf( '<div class="%s">', esc_attr( $wrapper_classname ) );
			$html             .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'shopbuild' ) );
			$html             .= '</div>';
		}

		print wp_kses(apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ), pure_wc_get_kses_extended_ruleset());

		// do_action( 'woocommerce_product_thumbnails' );
		$attachment_ids = $product->get_gallery_image_ids();

		if ( $attachment_ids && $product->get_image_id() ) {
			foreach ( $attachment_ids as $attachment_id ) {
				print wp_kses(apply_filters( 'woocommerce_single_product_image_thumbnail_html', wc_get_gallery_image_html( $attachment_id ), $attachment_id ), pure_wc_get_kses_extended_ruleset()); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
			}
		}
		?>
	</figure>
</div>
<?php endif; ?>