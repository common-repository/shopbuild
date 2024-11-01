<?php

use Elementor\Controls_Manager;




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
class Pure_Product_Breadcrumb_Widget extends Pure_Wc_Base_Widget {

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
		return 'single-product-breadcrumb';
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
		return esc_html__( 'Single Product Breadcrumb', 'shopbuild' );
	}



	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){

    }

    protected function register_style_controls(){
		$this->pure_wc_link_controls_style('product_breadcrumb', 'Product - Breadcrumb', '.sb-product-details-breadcrumb a', '.sb-product-details-breadcrumb a:hover');
		$this->pure_wc_link_controls_style('product_breadcrumb_active', 'Product - Breadcrumb Active', '.sb-product-details-breadcrumb .woocommerce-breadcrumb', '.sb-product-details-breadcrumb .woocommerce-breadcrumb:hover');
		
		$this->start_controls_section(
		 'product_breadcrumb_dot_sec',
			 [
			   'label' => esc_html__( 'Product - Breadcrumb Dot', 'shopbuild' ),
			   'tab'   => Controls_Manager::TAB_STYLE,
			 ]
		);
		
		$this->add_group_control(
		   \Elementor\Group_Control_Background::get_type(),
		   [
			  'name'     => 'product_breadcrumb_dot_bg',
			  'label'   => esc_html__( 'Background Color', 'shopbuild' ),
			  'types'    => [ 'classic', 'gradient'],
			  'selector' => '{{WRAPPER}} .sb-product-details-breadcrumb .woocommerce-breadcrumb span.delimeter',
		   ]
		 );


		 $this->add_control(
		  'product_breadcrumb_dot_margin',
			[
			  'label'      => esc_html__( 'Margin', 'shopbuild' ),
			  'type'       => Controls_Manager::DIMENSIONS,
			  'size_units' => [ 'px', '%', 'em' ],
			  'selectors'  => [
				'{{WRAPPER}} .sb-product-details-breadcrumb .woocommerce-breadcrumb span.delimeter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			  ],
			]
		  );

		 $this->add_control(
		  'product_breadcrumb_dot_padding',
			[
			  'label'      => esc_html__( 'Padding', 'shopbuild' ),
			  'type'       => Controls_Manager::DIMENSIONS,
			  'size_units' => [ 'px', '%', 'em' ],
			  'selectors'  => [
				'{{WRAPPER}} .sb-product-details-breadcrumb .woocommerce-breadcrumb span.delimeter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $settings   = $this->get_settings_for_display();
        
		?>
		<div class="sb-product-details-breadcrumb">
			<?php woocommerce_breadcrumb(); ?>
		</div>
		<?php
	}
}

$widgets_manager->register( new Pure_Product_Breadcrumb_Widget() );