<?php

use PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor button widget.
 *
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.3
 */
class Pure_Currency_Swicther extends Pure_Wc_Base_Widget {

	use PureWCArchive, PureWCCommonStyles, PureWCQuery;

	/**
	 * Get widget name.
	 *
	 * Retrieve button widget name.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'currency-switcher';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve button widget title.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Pure Currency Switcher', 'shopbuild' );
	}

	/**
	 * Get script dependancies.
	 */
	public function get_script_depends() {
		return [ 'currency-switcher' ];
	}

	/**
	 * Get style dependancies.
	 */
	public function get_style_depends() {
		return [ 'currency-switcher' ];
	}


	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){

    }

    protected function register_style_controls(){

	}

	

	/**
	 * Render button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.3
	 * @access protected
	 */
	protected function render() {
		$currency_switcher_settings  = Pure_Wc_Shopuild_Admin::get_option('_pure_currency_switcher');
		
		$settings = $this->get_settings_for_display();

		$is_editor_mode = pure_wc_is_elementor_edit();

        ?>
        <div class="pure-currency-switcher">
            <div class="currency-switcher">
                <div class="currency-switcher__current">
                    <h3 class="currency-switcher__current__label sb-sidebar-product-widget-title tp-el-title"><?php echo esc_html__('Currency:', 'shopbuild'); ?></h3>
                </div>
                <div class="currency-switcher__dropdown">
                    <select class="currency-switcher__dropdown__list">
                        <?php
                        
                        $currencies       = $currency_switcher_settings['pure_wc_currency_switcher_list'];
                        $current_currency = isset($_GET['currency'], $_GET['_wpnonce']) && wp_verify_nonce( sanitize_text_field( wp_unslash($_GET['_wpnonce']) ), 'currency-switcher-nonce') ? sanitize_text_field( wp_unslash($_GET['currency']) ) : get_woocommerce_currency();
                        foreach ($currencies as $currency) {
                            $selected = ($current_currency === $currency['currency']) ? 'selected' : '';
                            $option = sprintf('<option value="%s" %s>%s</option>', $currency['currency'], $selected, $currency['currency']);
                            echo wp_kses($option, [
                                'option' => [
                                    'value' => [],
                                    'selected' => [],
                                ],
                            ]);
                        }
                        ?>
                    </select>
                </div>
            </div>
		</div>
        <?php
	}
}

$widgets_manager->register( new Pure_Currency_Swicther() );
