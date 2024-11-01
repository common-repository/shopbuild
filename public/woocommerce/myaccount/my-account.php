<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * My Account navigation.
 *
 * @since 2.6.0
 */

do_action( 'woocommerce_account_navigation' ); ?>

<?php if(\PureWCShopbuild\Pure_Wc_Template_Manager::get_my_account_template_id() == 0 || !pure_wc_is_pro_active()): ?>
<div class="sb-col-lg-8">
<?php endif; ?>
	<div class="pure-woocommerce-MyAccount-content sb-myaccount-content-box">
		<?php
			/**
			 * My Account content.
			 *
			 * @since 2.6.0
			 */
			do_action( 'woocommerce_account_content' );
		?>
	</div>
<?php if(\PureWCShopbuild\Pure_Wc_Template_Manager::get_my_account_template_id() == 0 || !pure_wc_is_pro_active()): ?>
</div>

</div>
<?php endif; ?>
