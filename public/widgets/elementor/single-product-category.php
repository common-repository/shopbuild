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
class Pure_Product_Category_Widget extends Pure_Wc_Base_Widget {

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
		return 'single-product-category';
	}

	/**
	 * Get widget category.
	 *
	 * Retrieve button widget category.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget category.
	 */
	public function get_title() {
		return esc_html__( 'Single Product Category', 'shopbuild' );
	}

	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Category Label', 'shopbuild'),
            ]
        );

		$this->add_control(
		 'enable_category_label',
		 [
		   'label'        => esc_html__( 'Enable Category Label?', 'shopbuild' ),
		   'type'         => \Elementor\Controls_Manager::SWITCHER,
		   'label_on'     => esc_html__( 'Show', 'shopbuild' ),
		   'label_off'    => esc_html__( 'Hide', 'shopbuild' ),
		   'return_value' => 'yes',
		   'default'      => 'no',
		 ]
		);

        $this->end_controls_section();
		
    }

    protected function register_style_controls(){

		$this->pure_wc_link_controls_style('product_breadcrumb_active', 'Product - Category', '.sb-product-details-category span a', '.sb-product-details-category span a:hover');
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
		$settings = $this->get_settings_for_display();

        if( Plugin::instance()->editor->is_edit_mode() ){
            $product = wc_get_product( pure_wc_get_last_product_id() );
        }else{
			$product_id = get_the_ID()? get_the_ID() : (isset($_SESSION['product_id'])? sanitize_text_field( wp_unslash($_SESSION['product_id'])) : 0);
            $product = wc_get_product( $product_id );
        }

		if( empty($product) ){
			return;
		}

		if($settings['enable_category_label'] == 'yes'){
			print wp_kses_post(wc_get_product_category_list( $product->get_id(), ', ', '<div class="sb-product-details-category"><span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'shopbuild' ) . ' ', '</span></div>' ));
		}else{
			print wp_kses_post(wc_get_product_category_list( $product->get_id(), ', ', '<div class="sb-product-details-category"><span class="posted_in">', '</span></div>'));
		}

	}
}

$widgets_manager->register( new Pure_Product_Category_Widget() );