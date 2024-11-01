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
class Pure_Product_ShortDescription_Widget extends Pure_Wc_Base_Widget {

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
		return 'single-product-short-description';
	}

	/**
	 * Get widget short-description.
	 *
	 * Retrieve button widget short-description.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget short-description.
	 */
	public function get_title() {
		return esc_html__( 'Single Product Short Description', 'shopbuild' );
	}


	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){

    }

    protected function register_style_controls(){

        $this->start_controls_section(
			'pure_wc_product_single_rating',
				[
				  'label' => esc_html__( 'Product - Description', 'shopbuild' ),
				  'tab'   => Controls_Manager::TAB_STYLE,
				]
		   );
		      
		   $this->add_control(
			'pure_wc_product_single_rating_text_color',
			   [
			   'label'    	=> esc_html__( 'Description Text Color', 'shopbuild' ),
			   'type'     	=> Controls_Manager::COLOR,
			   'selectors' => [
					   '{{WRAPPER}} .sb-product-details-short-desc p' => 'color: {{VALUE}}',
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
        global $post, $product;

        if( Plugin::instance()->editor->is_edit_mode() ){
            $product = wc_get_product( pure_wc_get_last_product_id() );
        ?>
            <div class="woocommerce-product-details__short-description">
				<div class="sb-product-details-short-desc woocommerce-product-details__short-description">
					<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
				</div>
            </div>
        <?php
        }else{
			$product_id = get_the_ID()? get_the_ID() : (isset($_SESSION['product_id'])? sanitize_text_field( wp_unslash($_SESSION['product_id'])) : 0);
			$product = wc_get_product( $product_id );
			if ( ! $product ) {
                return;
            }
            $short_description = apply_filters( 'woocommerce_short_description', $product->get_short_description() );

            if ( ! $short_description ) {
                return;
            }
        ?>
        <div class="sb-product-details-short-desc woocommerce-product-details__short-description">
            <?php print wp_kses_post($short_description); // WPCS: XSS ok. ?>
        </div>
        <?php
        }
	}
}

$widgets_manager->register( new Pure_Product_ShortDescription_Widget() );