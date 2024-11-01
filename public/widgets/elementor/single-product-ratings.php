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
class Pure_Product_Ratings_Widget extends Pure_Wc_Base_Widget {

	use PureWCSingle;

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
		return 'single-product-ratings';
	}

	/**
	 * Get widget ratings.
	 *
	 * Retrieve button widget ratings.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget ratings.
	 */
	public function get_title() {
		return esc_html__( 'Single Product Ratings', 'shopbuild' );
	}


	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){
        // $this->start_controls_section(
        //     'section_content',
        //     [
        //         'label' => esc_html__('Content Controls', 'shopbuild'),
        //     ]
        // );

        // $this->end_controls_section();
    }

    protected function register_style_controls(){

        $this->start_controls_section(
		 'pure_wc_product_single_rating',
			 [
			   'label' => esc_html__( 'Product - Rating', 'shopbuild' ),
			   'tab'   => Controls_Manager::TAB_STYLE,
			 ]
		);
		
		$this->add_control(
		 'pure_wc_product_single_rating_color',
			[
			'label'     => esc_html__( 'Rating Icon Color', 'shopbuild' ),
			'type'     	=> Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .sb-product-details-rating i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
		 'pure_wc_product_single_rating_text_color',
			[
			'label'    	=> esc_html__( 'Rating Text Color', 'shopbuild' ),
			'type'     	=> Controls_Manager::COLOR,
			'selectors' => [
					'{{WRAPPER}} .sb-product-details-rating.details-rating span' => 'color: {{VALUE}}',
				],
			]
		);
		
		
		$this->end_controls_section();
        
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

        if( Plugin::instance()->editor->is_edit_mode() ){
            $product = wc_get_product( pure_wc_get_last_product_id() );
        }else{
			$product_id = get_the_ID()? get_the_ID() : (isset($_SESSION['product_id'])? sanitize_text_field( wp_unslash($_SESSION['product_id'])) : 0);
            $product = wc_get_product( $product_id );
        }

		if( empty($product) ){
			return;
		}

        if ( ! wc_review_ratings_enabled() ) {
            return;
        }

        $rating = $product->get_average_rating();
        $review = 'Rating ' . $rating . ' out of 5';
        $html   = '';
        $html   .= '<div class="sb-product-details-rating details-rating mb-10" title="' . $review . '">';
        for ( $i = 0; $i <= 4; $i ++ ) {
            if ( $i < floor( $rating ) ) {
                $html .= '<i class="icon_star"></i>';
            } else {
                $html .= '<i class="icon_star_alt"></i>';
            }
        }
        $html .= '<span>( ' . $rating . ' out of 5 )</span>';
        $html .= '</div>';

        print wp_kses_post($html);
	}
}

$widgets_manager->register( new Pure_Product_Ratings_Widget() );