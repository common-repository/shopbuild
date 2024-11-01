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
class Pure_Products_Ordering_Widget extends Pure_Wc_Base_Widget {

	use PureWCArchive;

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
		return 'archive-products-ordering';
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
		return esc_html__( 'Archive Products Ordering', 'shopbuild' );
	}


	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){

    }

    protected function register_style_controls(){

		$this->start_controls_section(
			'pure_wc_product_filter',
				[
				  'label' => esc_html__( 'Filter', 'shopbuild' ),
				  'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				]
		   );
		   
		   $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
			  'name'     => 'pure_wc_product_filter_border',
			  'label'    => esc_html__( 'Border', 'shopbuild' ),
			  'selector' => '{{WRAPPER}} .sb-product-ordering select',
			]
		   );
   
		   $this->add_control(
			'pure_wc_product_filter_color',
			[
			  'label'       => esc_html__( 'Color', 'shopbuild' ),
			  'type'     => \Elementor\Controls_Manager::COLOR,
			  'selectors' => [
			  '{{WRAPPER}} .sb-product-ordering select' => 'color: {{VALUE}}',
			  ],
			]
		   );
   
		   $this->add_control(
			'pure_wc_product_filter_margin',
			  [
				'label'      => esc_html__( 'Margin', 'shopbuild' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
				  '{{WRAPPER}} .sb-product-ordering select' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			  ]
			);
		   
			$this->add_control(
			 'pure_wc_product_filter_padding',
			   [
				 'label'      => esc_html__( 'Padding', 'shopbuild' ),
				 'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				 'size_units' => [ 'px', '%', 'em' ],
				 'selectors'  => [
				   '{{WRAPPER}} .sb-product-ordering select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		echo '<div class="pure-sidebar-widget sb-product-ordering">';

        if( Plugin::instance()->editor->is_edit_mode() ){ ?>
            <form class="woocommerce-ordering" method="get">
                <select name="orderby" class="orderby">
                    <?php
                        $catalog_orderby = apply_filters( 'woocommerce_catalog_orderby', array(
                            'menu_order' => __( 'Default sorting', 'shopbuild' ),
                            'popularity' => __( 'Sort by popularity', 'shopbuild' ),
                            'rating'     => __( 'Sort by average rating', 'shopbuild' ),
                            'date'       => __( 'Sort by latest', 'shopbuild' ),
                            'price'      => __( 'Sort by price: low to high', 'shopbuild' ),
                            'price-desc' => __( 'Sort by price: high to low', 'shopbuild' ),
                        ) );
                        foreach ( $catalog_orderby as $id => $name ){
                            echo '<option value="' . esc_attr( $id ) . '" ' . selected( 'menu_order', $id, false ) . '>' . esc_attr( $name ) . '</option>';
                        }
                    ?>
                </select>
            </form>
        <?php }else{
            woocommerce_catalog_ordering();
        }
		echo '</div>';
		
	}
}

$widgets_manager->register( new Pure_Products_Ordering_Widget() );