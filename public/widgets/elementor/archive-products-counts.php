<?php


use Elementor\Plugin;
use PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin;
use PureWCShopbuild\Pure_Shopbuild_Archive_Products;

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
class Pure_Products_Counts_Widget extends Pure_Wc_Base_Widget {

	use PureWCArchive, PureWCCommonStyles, PureWCActionFilter;

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
		return 'archive-products-counts';
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
		return esc_html__( 'Archive Products Counts', 'shopbuild' );
	}


	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){
    }

    protected function register_style_controls(){

        $this->pure_wc_basic_style_controls('pure_wc_input_control', 'Product Count', '.sb-product-show-result p');
        

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
		

		$product_results = new PureWCShopbuild\Pure_Shopbuild_Archive_Products;

		$woocoomerce_settings  = Pure_Wc_Shopuild_Admin::get_option('_pure_shopbuild_woocommerce');
		
        // $total    = wc_get_loop_prop( 'total' )? wc_get_loop_prop( 'total' ) : wp_count_posts( 'product' )->publish;
        $total    = wc_get_loop_prop( 'total' )? wc_get_loop_prop( 'total' ) : $product_results->get_query_results()->total;

        $per_page = isset($woocoomerce_settings['products_limits'])? $woocoomerce_settings['products_limits'] : apply_filters('pure_wc_products_per_page', null);

        if( Plugin::instance()->editor->is_edit_mode() ){
            $args = array(
                'total'    => wp_count_posts( 'product' )->publish,
                'per_page' => $per_page,
                'current'  => 1,
            );
			?>
			<div class="sb-product-show-result">
				<?php wc_get_template( 'loop/result-count.php', $args ); ?>
			</div>
			<?php
        }else{
			if( absint( get_query_var('paged') ) > 0 ){
				$page =  absint( get_query_var('paged') );
			}else{
				$page = empty( $_GET['product-page'] ) ? 1  : absint( sanitize_text_field( wp_unslash($_GET['product-page'])) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			}



            wc_set_loop_prop( 'total', $total );
            wc_set_loop_prop( 'per_page', $per_page );
            wc_set_loop_prop( 'current_page', $page );
    
            $args = array(
                'total'    => wc_get_loop_prop( 'total' ),
                'per_page' => wc_get_loop_prop( 'per_page' ),
                'current'  => wc_get_loop_prop( 'current_page' ),
                'results'  => wc_get_loop_prop( 'results' ),
            );
			?>
			<div class="sb-product-show-result">
				<?php wc_get_template( 'loop/result-count.php', $args ); ?>
			</div>
			<?php
        }
		
	}
}

$widgets_manager->register( new Pure_Products_Counts_Widget() );