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
class Pure_Product_AddToCart_Widget extends Pure_Wc_Base_Widget {

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
		return 'single-product-add-to-cart';
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
		return esc_html__( 'Single Add To Cart', 'shopbuild' );
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
		 'pure_wc_product_signle_variation_sec',
			 [
			   'label' => esc_html__( 'Variations Controls', 'shopbuild' ),
			   'tab'   => Controls_Manager::TAB_STYLE,
			 ]
		);
		
		$this->add_control(
		 'pure_wc_product_signle_variation_color',
			[
			'label'       => esc_html__( 'Text Color', 'shopbuild' ),
			'type'     => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .sb-product-details-add-to-cart form table tbody tr th.label label' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
		 'pure_wc_product_signle_variation_select_color',
			[
			'label'       => esc_html__( 'Select Text Color', 'shopbuild' ),
			'type'     => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .sb-product-details-add-to-cart .woocommerce-variation-description p' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
		 'pure_wc_product_signle_variation_desc_color',
			[
			'label'       => esc_html__( 'Description Text Color', 'shopbuild' ),
			'type'     => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .sb-product-details-add-to-cart form table.variations select' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
		 \Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'pure_wc_product_signle_variation_select_border',
				'label'    => esc_html__( 'Select Border Color', 'shopbuild' ),
				'selector' => '{{WRAPPER}} .sb-product-details-add-to-cart form table.variations select',
			]
		);

		$this->add_control(
		 'pure_wc_product_signle_variation_padding',
		   [
			 'label'      => esc_html__( 'Text Padding', 'shopbuild' ),
			 'type'       => Controls_Manager::DIMENSIONS,
			 'size_units' => [ 'px', '%', 'em' ],
			 'selectors'  => [
			   '{{WRAPPER}} .sb-product-details-add-to-cart form table td, {{WRAPPER}} .sb-product-details-add-to-cart form table th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			 ],
		   ]
		 );
		
		$this->end_controls_section();


		$this->pure_wc_link_controls_style('product_add_cart_btn', 'Product - Add Cart Button', '.sb-product-details-add-to-cart .single_add_to_cart_button[type="submit"]', '.sb-product-details-add-to-cart .single_add_to_cart_button[type="submit"]:hover');

		$this->start_controls_section(
		 'pure_wc_product_single_quantity',
			 [
			   'label' => esc_html__( 'Quantity - Field', 'shopbuild' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			 ]
		);
		
		$this->add_group_control(
		   \Elementor\Group_Control_Background::get_type(),
		   [
			  'name'     => 'pure_wc_product_single_quantity_bg',
			  'label'   => esc_html__( 'Background Color', 'shopbuild' ),
			  'types'    => [ 'classic', 'gradient'],
			  'selector' => '{{WRAPPER}} .sb-product-quantity .sb-cart-input[type="text"]',
		   ]
		 );

		 $this->add_control(
		  'pure_wc_product_single_quantity_color',
		  [
			'label'       => esc_html__( 'Text Color', 'shopbuild' ),
			'type'     => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .sb-product-quantity .sb-cart-input[type="text"]' => 'color: {{VALUE}}',
			],
		  ]
		 );


		 $this->add_control(
		  'pure_wc_product_single_quantity_action_color',
		  [
			'label'       => esc_html__( 'Plus Minus Color', 'shopbuild' ),
			'type'     => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .sb-product-quantity .sb-cart-plus, {{WRAPPER}} .sb-product-quantity .sb-cart-minus' => 'color: {{VALUE}}',
			],
		  ]
		 );

		 $this->add_control(
		  'pure_wc_product_single_quantity_action_hover_color',
		  [
			'label'       => esc_html__( 'Plus Minus Hover Color', 'shopbuild' ),
			'type'     => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .sb-product-quantity .sb-cart-plus:hover, {{WRAPPER}} .sb-product-quantity .sb-cart-minus:hover' => 'color: {{VALUE}}',
			],
		  ]
		 );

		 $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
			   'name'     => 'pure_wc_product_single_quantity_action_bg',
			   'label'   => esc_html__( 'Background Color', 'shopbuild' ),
			   'types'    => [ 'classic', 'gradient'],
			   'selector' => '{{WRAPPER}} .sb-product-quantity .sb-cart-plus, {{WRAPPER}} .sb-product-quantity .sb-cart-minus',
			]
		  );

		 $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
			   'name'     => 'pure_wc_product_single_quantity_action_hover_bg',
			   'label'   => esc_html__( 'Background Hover Color', 'shopbuild' ),
			   'types'    => [ 'classic', 'gradient'],
			   'selector' => '{{WRAPPER}} .sb-product-quantity .sb-cart-plus:hover, {{WRAPPER}} .sb-product-quantity .sb-cart-minus:hover',
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
		?>
		<?php if( Plugin::instance()->editor->is_edit_mode() ): ?>
		<div class="sb-product-details-add-to-cart">
			<form class="cart" action="#">
				<div class="sb-product-quantity-wrapper">
					<div class="quantity sb-product-quantity">
						<label class="screen-reader-text" for="quantity_6471c5505dfc7">Quantity</label>
						<div class="qty_button minus sb-cart-minus">
							<svg width="11" height="2" viewBox="0 0 11 2" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M1 1H10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
							</svg>  
						</div>
						<input type="text" id="quantity_6471c5505dfc7" class="input-text sb-cart-input qty sb-cart-input text" step="1" min="1" max="" name="quantity" value="1" title="Qty" size="4" placeholder="" inputmode="numeric" autocomplete="off">
						<div class="qty_button plus sb-cart-plus">
							<svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M1 6H10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
								<path d="M5.5 10.5V1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
							</svg>
						</div>
					</div>
				</div>
				<button type="submit" class="single_add_to_cart_button button alt wp-element-button">Add to cart</button>
			</form>	
		</div>
		<?php else: 
			global $product;

			$product_id = get_the_ID()? get_the_ID() : (isset($_SESSION['product_id'])? sanitize_text_field( wp_unslash($_SESSION['product_id'])) : 0);
			$product = wc_get_product( $product_id );

			if( !$product ){
				return;
			}	
		?>
		<div class="sb-product-details-add-to-cart">
			<?php 
				woocommerce_template_single_add_to_cart();
			?>
		</div>
        <?php endif; ?>
		<?php
	}
}

$widgets_manager->register( new Pure_Product_AddToCart_Widget() );