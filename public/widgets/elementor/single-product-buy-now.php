<?php

use Elementor\Controls_Manager;


use Elementor\Plugin;


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
class Pure_Product_BuyNow_Widget extends Pure_Wc_Base_Widget {

	use PureWCSingle, PureWCCommonStyles;

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
		return 'single-product-buy-now';
	}

	/**
	 * Get widget add-to-cart.
	 *
	 * Retrieve button widget add-to-cart.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget add-to-cart.
	 */
	public function get_title() {
		return esc_html__( 'Single Buy Now', 'shopbuild' );
	}



	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){

    }

    protected function register_style_controls(){

		$this->pure_wc_link_controls_style('pure_wc_buy_now', 'Button', '.sb-product-details-buy-now-btn',  '.sb-product-details-buy-now-btn:hover');
        
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
        global $product;
		?>
		<?php if( Plugin::instance()->editor->is_edit_mode() ): ?>
            <a href="#" class="sb-product-details-buy-now-btn single_add_to_cart_button button alt wp-element-button">Buy Now</a>
		<?php else: 
			
			if( !$product ){
				return;
			}	
		?>
		<div class="sb-product-details-buy-now">
            <a href="<?php echo esc_url(wc_get_cart_url().'?add-to-cart='. $product->get_id()); ?>" class="sb-product-details-buy-now-btn ingle_add_to_cart_button button alt wp-element-button"><?php echo esc_html__('Buy Now', 'shopbuild') ?></a>
		</div>
        <?php endif; ?>
		<?php
	}
}

$widgets_manager->register( new Pure_Product_BuyNow_Widget() );