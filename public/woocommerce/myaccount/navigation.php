<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
$design_style = $design_style?? '';
?>
<?php if(\PureWCShopbuild\Pure_Wc_Template_Manager::get_my_account_template_id() == 0 || !pure_wc_is_pro_active()): ?>
<div class="sb-row">
<div class="sb-col-lg-4">
<?php endif; ?>
<?php if($design_style == 'style_2') : ?>
<div class="sb-myaccount-nav-list sb-el-pure-my-account-section">
	<div class="woocommerce-MyAccount-navigation-list">
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
		<div class="sb-myaccount-nav-item-list sb-el-myaccount-nav <?php echo esc_attr(wc_get_account_menu_item_classes( $endpoint )); ?>">
			<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo wp_kses( $label, pure_wc_get_kses_extended_ruleset() ); ?></a>
		</div>
		<?php endforeach; ?>
	</div>
</div>
<?php elseif($design_style == 'style_3') : ?>
<div class="sb-myaccount-nav-list sb-myaccount-nav-list-border sb-el-pure-my-account-section">
	<div class="woocommerce-MyAccount-navigation-list woocommerce-MyAccount-navigation-list-border-none">
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
		<div class="sb-myaccount-nav-item-list sb-el-myaccount-nav <?php echo esc_attr(wc_get_account_menu_item_classes( $endpoint )); ?> sb-el-pure-myaccount-btn-underline">
			<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo wp_kses( $label, pure_wc_get_kses_extended_ruleset() ); ?></a>
		</div>
		<?php endforeach; ?>
	</div>
</div>
<?php else : ?>	
<div class="sb-myaccount-nav sb-myaccount-nav-default sb-el-pure-my-account-section">
	<div class="woocommerce-MyAccount-navigation">
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
		<div class="sb-myaccount-nav-item sb-el-myaccount-nav <?php echo esc_attr(wc_get_account_menu_item_classes( $endpoint )); ?>">
			<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo wp_kses( $label, pure_wc_get_kses_extended_ruleset() ); ?></a>
		</div>
		<?php endforeach; ?>
	</div>
</div>
<?php endif; ?>
<?php if(\PureWCShopbuild\Pure_Wc_Template_Manager::get_my_account_template_id() == 0 || !pure_wc_is_pro_active()): ?>
</div>
<?php endif; ?>
<?php do_action( 'woocommerce_after_account_navigation' ); ?>
