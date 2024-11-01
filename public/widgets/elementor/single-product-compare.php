<?php



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
class Pure_Product_Compare_Widget extends Pure_Wc_Base_Widget {

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
		return 'single-product-compare';
	}

	/**
	 * Get widget compare.
	 *
	 * Retrieve button widget compare.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget compare.
	 */
	public function get_title() {
		return esc_html__( 'Single Product Compare', 'shopbuild' );
	}


	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){

    }

    protected function register_style_controls(){

		$this->pure_wc_link_controls_style('product_add_cart_btn', 'Product - Compare', '.sb-product-details-action-btn', '.sb-product-details-action-btn:hover');
        
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

		if(Plugin::instance()->editor->is_edit_mode()){
			$product = wc_get_product(pure_wc_get_last_product_id());
		}

        if( empty($product) ){
            return;
        }

		$output = sprintf('<button data-bs-toggle="tooltip" type="button" data-bs-placement="bottom" class="sb-product-details-action-btn button wp-element-button pure-tooltip pure-wc-compare-btn" data-id="%s" title="Add To Compare">
			<svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M1 3.16431H10.8622C12.0451 3.16431 12.9999 4.08839 12.9999 5.23315V7.52268" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
			<path d="M3.25177 0.985168L1 3.16433L3.25177 5.34354" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
			<path d="M12.9999 12.5983H3.13775C1.95486 12.5983 1 11.6742 1 10.5295V8.23993" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
			<path d="M10.748 14.7774L12.9998 12.5983L10.748 10.4191" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
			</svg>
			Compare
		</button>', $product->get_id());
		
		print wp_kses($output, pure_wc_get_kses_extended_ruleset());
	}
}

$widgets_manager->register( new Pure_Product_Compare_Widget() );