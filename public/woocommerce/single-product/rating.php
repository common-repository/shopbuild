<?php
/**
 * Single Product Rating
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/rating.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

if ( ! wc_review_ratings_enabled() ) {
	return;
}

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();

if ( $rating_count > 0 ) : ?>
	<div class="woocommerce-product-rating">
		<?php print wp_kses(wc_get_rating_html( $average, $rating_count ), pure_wc_get_kses_extended_ruleset()); ?>
		<?php if ( comments_open() ) : ?>
			<a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<?php printf(
					esc_html(
						/* translators: 1: customer review count 2: customer review counts */
						_n( 
							'%s customer review', 
							'%s customer reviews',
							$review_count,
							'shopbuild' 
						)
					),
					wp_kses_post('<span class="count">' . number_format_i18n( $review_count ) . '</span>'),
			); ?>)</a>
		<?php endif ?>
	</div>
<?php endif; ?>
