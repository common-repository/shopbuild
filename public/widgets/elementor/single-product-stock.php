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
class Pure_Product_Stock_Widget extends Pure_Wc_Base_Widget {

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
		return 'single-product-stock';
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
		return esc_html__( 'Single Product Stock', 'shopbuild' );
	}

    public function get_script_depends(){
        return array('countdown');
    }

	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){

    }

    protected function register_style_controls(){

		$this->pure_wc_link_controls_style('product_in_stock', 'Product - Stock', '.sb-stock-badge.sb-in-stock', '.sb-stock-badge.sb-in-stock:hover');
		$this->pure_wc_link_controls_style('product_out_stock', 'Product - Out Of Stock', '.sb-stock-badge.sb-out-of-stock', '.sb-stock-badge.sb-out-of-stock:hover');
        
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

        $settings   = $this->get_settings_for_display();
        global $product;

        if( Plugin::instance()->editor->is_edit_mode() ){
            $product = wc_get_product( pure_wc_get_last_product_id() );
            if( !$product ){
                return;
            }

            if($product->is_in_stock()){
                echo "<span class='sb-stock-badge sb-in-stock'>In Stock</span>";
            }else{
                echo "<span class='sb-stock-badge sb-out-of-stock'>Out of stock</span>";
            }
        }else{
            if( !$product ){
                return;
            }

            if($product->is_in_stock()){
                echo "<span class='sb-stock-badge sb-in-stock'>In Stock</span>";
            }else{
                echo "<span class='sb-stock-badge sb-out-of-stock'>Out of stock</span>";
            }
        }
	}
}

$widgets_manager->register( new Pure_Product_Stock_Widget() );