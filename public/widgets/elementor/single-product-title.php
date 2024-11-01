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
class Pure_Product_Title_Widget extends Pure_Wc_Base_Widget {

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
		return 'single-product-title';
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
		return esc_html__( 'Single Product Title', 'shopbuild' );
	}



	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Content Controls', 'shopbuild'),
            ]
        );

        $this->title_tags();

        $this->end_controls_section();
    }

    protected function register_style_controls(){

		$this->pure_wc_link_controls_style('product_breadcrumb_active', 'Product - Title', '.sb-product-details-title', '.sb-product-details-title:hover');
        
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

        $title_html_tag = pure_wc_validate_html_tag( $settings['product_title_html_tag'] );

        if( Plugin::instance()->editor->is_edit_mode() ){
            $title = get_the_title( pure_wc_get_last_product_id() );
            echo wp_kses_post(sprintf( "<%s class='product_title sb-product-details-title entry-title'>%s</%s>", esc_html($title_html_tag), esc_html($title), esc_html($title_html_tag) ));
        }else{
			$product_id = get_the_ID()? get_the_ID() : (isset($_SESSION['product_id'])? sanitize_text_field( wp_unslash($_SESSION['product_id'])) : 0);
			$product = wc_get_product( $product_id );
			$title = get_the_title( $product_id );
            echo wp_kses_post(sprintf( "<%s class='product_title sb-product-details-title entry-title'>%s</%s>", esc_html($title_html_tag), esc_html($title), esc_html($title_html_tag)  ));
        }
		
	}
}

$widgets_manager->register( new Pure_Product_Title_Widget() );