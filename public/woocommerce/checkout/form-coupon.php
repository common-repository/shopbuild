<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) {
	return;
}

$btn_title = !empty($coupon_btn_title) ? $coupon_btn_title : '';
$coupon_title = !empty($coupon_title) ? $coupon_title : '';
$coupon_desc = !empty($coupon_desc) ? $coupon_desc : '';

?>
<?php if($coupon_style == 'coupon_static') : ?>
<div class="woocommerce">

	<div class="checkout_coupon woocommerce-form-coupon sb-d-block" method="post">

		<?php if(!empty($coupon_desc)) : ?>
		<p><?php echo wp_kses($coupon_desc, pure_wc_get_kses_extended_ruleset()) ?></p>
		<?php endif; ?>

		<div class="form-rows form-row-firsts mb-15">
			<label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'shopbuild' ); ?></label>
			<input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( 'Coupon code', 'shopbuild' ); ?>" id="pure_coupon_code" value="" />
		</div>

		<div class="form-rows form-row-lasts">
			<button 
				class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" 
				name="apply_coupon" 
				id="pure_checkout_coupon_submit" 
				value="<?php esc_attr_e( 'Apply coupon', 'shopbuild' ); ?>">
				<?php echo esc_html($btn_title); ?>
			</button>
		</div>

		<div class="clear"></div>
	</div>
</div>

<?php elseif($coupon_style == 'coupon_inline') : ?>
<div class="woocommerce">
	<div class="checkout_coupon woocommerce-form-coupon sb-d-block" method="post">

		<?php if(!empty($coupon_desc)) : ?>
		<p><?php echo wp_kses($coupon_desc, pure_wc_get_kses_extended_ruleset()) ?></p>
		<?php endif; ?>

		<div class="pure-checkout-coupon-inline">
			<input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( 'Coupon code', 'shopbuild' ); ?>" id="pure_coupon_code" value="" />
			<button 
				class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" 
				name="apply_coupon" 
				id="pure_checkout_coupon_submit" 
				value="<?php esc_attr_e( 'Apply coupon', 'shopbuild' ); ?>">
				<?php echo esc_html($btn_title); ?>
			</button>
		</div>

		<div class="clear"></div>
	</div>
</div>

<?php elseif($coupon_style == 'coupon_toggle_inline') : ?>
	<div class="woocommerce">
		<div class="woocommerce-form-coupon-toggle">
			<?php
			if( pure_wc_is_elementor_edit() ){
				$notice  = sprintf('<div class="woocommerce-info">%s</div>', apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon?', 'shopbuild' ) . ' <a href="#" class="showcoupon">' . esc_html__( 'Click here to enter your code', 'shopbuild' ) . '</a>' ));
				print wp_kses_post($notice);
			}else{
				wc_print_notice( apply_filters( 'woocommerce_checkout_coupon_message', wp_kses($coupon_title, pure_wc_get_kses_extended_ruleset()) ), 'notice' );
			}
			?>
		</div>

	<div class="checkout_coupon woocommerce-form-coupon" method="post" style="display:none">

		<?php if(!empty($coupon_desc)) : ?>
		<p><?php echo wp_kses($coupon_desc, pure_wc_get_kses_extended_ruleset()) ?></p>
		<?php endif; ?>

		<div class="pure-checkout-coupon-inline">
			<input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( 'Coupon code', 'shopbuild' ); ?>" id="pure_coupon_code" value="" />
			<button 
				class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" 
				name="apply_coupon" 
				id="pure_checkout_coupon_submit" 
				value="<?php esc_attr_e( 'Apply coupon', 'shopbuild' ); ?>">
				<?php echo esc_html($btn_title); ?>
			</button>
		</div>

		<div class="clear"></div>
	</div>
</div>

<?php else: ?>

<div class="woocommerce">
	<div class="woocommerce-form-coupon-toggle">
		<?php
		if( pure_wc_is_elementor_edit() ){
			$notice  = sprintf('<div class="woocommerce-info">%s</div>', apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon?', 'shopbuild' ) . ' <a href="#" class="showcoupon">' . esc_html__( 'Click here to enter your code', 'shopbuild' ) . '</a>' ));
			print wp_kses_post($notice);
		}else{
			wc_print_notice( apply_filters( 'woocommerce_checkout_coupon_message', wp_kses($coupon_title, pure_wc_get_kses_extended_ruleset()) ), 'notice' );

			; 
		}
		?>
	</div>

	<div class="checkout_coupon woocommerce-form-coupon" method="post" style="display:none">

		<?php if(!empty($coupon_desc)) : ?>
		<p><?php echo wp_kses($coupon_desc, pure_wc_get_kses_extended_ruleset()) ?></p>
		<?php endif; ?>

		<div class="form-rows form-row-firsts mb-15">
			<label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'shopbuild' ); ?></label>
			<input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( 'Coupon code', 'shopbuild' ); ?>" id="pure_coupon_code" value="" />
		</div>

		<div class="form-rows form-row-lasts">
			<button 
				class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" 
				name="apply_coupon" 
				id="pure_checkout_coupon_submit" 
				value="<?php esc_attr_e( 'Apply coupon', 'shopbuild' ); ?>">
				<?php echo esc_html($btn_title); ?>
			</button>
		</div>

		<div class="clear"></div>
	</div>
</div>
<?php endif; ?>
