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
class Pure_Checkout_Order_Widget extends Pure_Wc_Base_Widget {

	use PureWCCart;

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
		return 'checkout-order';
	}

	/**
	 * Get widget checkout-order.
	 *
	 * Retrieve button widget checkout-order.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget checkout-order.
	 */
	public function get_title() {
		return esc_html__( 'Checkout Order', 'shopbuild' );
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

		$this->add_control(
		 'pure_checkout_order_style',
		 [
		   'label'   => esc_html__( 'Select Layout', 'shopbuild' ),
		   'type' => \Elementor\Controls_Manager::SELECT,
		   'options' => [
			   'default'  => esc_html__( 'Default', 'shopbuild' ),
			 'style_2'  => esc_html__( 'Style 2', 'shopbuild' ),
		   ],
		   'default' => 'default',
		 ]
		);
        

        $this->end_controls_section();
    }

    protected function register_style_controls(){

		$this->start_controls_section(
			'product_cart_checkout_sec',
				[
				  'label' => esc_html__( 'Checkout Table', 'shopbuild' ),
				  'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				]
		   );

		   $this->add_control(
			'product_checkout_table_border',
			[
			  'label'       => esc_html__( 'Border Color', 'shopbuild' ),
			  'type'     => \Elementor\Controls_Manager::COLOR,
			  'selectors' => [
			  '{{WRAPPER}} .sb-checkout-order-review table.shop_table tbody tr, {{WRAPPER}} .sb-checkout-order-review table.shop_table thead tr, {{WRAPPER}}  .sb-checkout-order-review table.shop_table tfoot tr:not(:last-child)' => 'border-color: {{VALUE}}',
			  ],
			]
		   );

		   $this->add_control(
			'pure_wc_checkout_table_caption',
			[
			  'label'       => esc_html__( 'Checkout Heading Color', 'shopbuild' ),
			  'type'     => \Elementor\Controls_Manager::COLOR,
			  'selectors' => [
			  '{{WRAPPER}} .sb-checkout-order-review table.shop_table thead tr th, {{WRAPPER}} .sb-checkout-order-review table.shop_table tfoot tr th' => 'color: {{VALUE}}',
			  ],
			]
		   );

		   $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'pure_wc_checkout_table_caption_typo',
			  'label'   => esc_html__( 'Checkout Heading Typography', 'shopbuild' ),
			  'selector' => '{{WRAPPER}} .sb-checkout-order-review table.shop_table thead tr th, {{WRAPPER}} .sb-checkout-order-review table.shop_table tfoot tr th',
			]
		  );
		   
			$this->add_control(
				'pure_wc_checkout_table_td',
				[
				  'label'       => esc_html__( 'Checkout Data Color', 'shopbuild' ),
				  'type'     => \Elementor\Controls_Manager::COLOR,
				  'selectors' => [
				  '{{WRAPPER}} .sb-checkout-order-review table.shop_table tbody tr td, {{WRAPPER}} .sb-checkout-order-review table.shop_table tfoot tr td' => 'color: {{VALUE}}',
				  ],
				]
			);
	   
		   $this->add_group_control(
			   \Elementor\Group_Control_Typography::get_type(),
			   [
				 'name' => 'pure_wc_checkout_table_td_typo',
				 'label'   => esc_html__( 'Table Data Typography', 'shopbuild' ),
				 'selector' => '{{WRAPPER}} .sb-checkout-order-review table.shop_table tbody tr td, {{WRAPPER}} .sb-checkout-order-review table.shop_table tfoot tr td',
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

        $settings = $this->get_settings_for_display();

		$_SESSION['checkout_order_style'] = $settings['pure_checkout_order_style'];
		// setcookie('pure_checkout_order_style', $settings['pure_checkout_order_style'], time() + HOUR_IN_SECONDS, "/");

		?>
		<div class="woocommerce sb-checkout-order-review">
    		<div id="order_review" class="woocommerce-checkout-review-order">
				<?php pure_wc_get_template('checkout/review-order.php'); ?>
			</div>
		</div>
		<?php
	}
}

$widgets_manager->register( new Pure_Checkout_Order_Widget() );