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
class Pure_Checkout_Coupon_Widget extends Pure_Wc_Base_Widget {

	use PureWCCart, PureWCCommonStyles;

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
		return 'checkout-coupon';
	}

	/**
	 * Get widget checkout-coupon.
	 *
	 * Retrieve button widget checkout-coupon.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget checkout-coupon.
	 */
	public function get_title() {
		return esc_html__( 'Checkout Coupon', 'shopbuild' );
	}

	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){
        $this->start_controls_section(
            'pure_checkout_coupon_sec',
            [
                'label' => esc_html__('Content Controls', 'shopbuild'),
            ]
        );

        $this->add_control(
            'pure_checkout_coupon_btn_title',
            [
                'label'         => esc_html__( 'Apply Button Title', 'shopbuild' ),
				'type'          => Controls_Manager::TEXT,
				'default'       => esc_html__( 'Apply Coupon', 'shopbuild' ),
				'placeholder'   => esc_html__( 'Type your title here', 'shopbuild' ),
				'label_block'   => true,
            ]
        );

		$this->add_control(
			'pure_checkout_coupon_style',
			[
			  'label'   => esc_html__( 'Coupon Style', 'shopbuild' ),
			  'type' => \Elementor\Controls_Manager::SELECT,
			  'options' => [
				'coupon_toggle_inline'  => esc_html__( 'Toggle Inline', 'shopbuild' ),
				'coupon_inline'  => esc_html__( 'Inline', 'shopbuild' ),
				'coupon_static'  => esc_html__( 'Static', 'shopbuild' ),
				'default'  => esc_html__( 'Default', 'shopbuild' ),
			  ],
			  'default' => 'default',
			]
		);

		$this->add_control(
		 'pure_checkout_coupon_title',
		 [
		   'label'       => esc_html__( 'Coupon Label', 'shopbuild' ),
		   'type'        => \Elementor\Controls_Manager::TEXTAREA,
		   'rows'        => 10,
		   'default'     => esc_html__( 'Have a Coupon ?', 'shopbuild' ),
		   'description' => esc_html__( 'Your text must contain anchor tag and class. Example: <a href="#" class="showcoupon">Click here to enter your code </a> .', 'shopbuild' ),
		   'placeholder' => esc_html__( 'Your Text', 'shopbuild' ),
		   'condition' => [
			'pure_checkout_coupon_style' => ['default', 'coupon_toggle_inline']
		   ]
		 ]
		);
		$this->add_control(
		 'pure_checkout_coupon_desc',
		 [
		   'label'       => esc_html__( 'Coupon Description', 'shopbuild' ),
		   'type'        => \Elementor\Controls_Manager::TEXTAREA,
		   'rows'        => 10,
		   'default'     => esc_html__( 'If you have a coupon code, please apply it below.', 'shopbuild' ),
		   'placeholder' => esc_html__( 'Your Text', 'shopbuild' ),
		   'condition' => [
			'pure_checkout_coupon_style' => ['default']
		   ]
		 ]
		);


        $this->end_controls_section();
    }

    protected function register_style_controls(){


		$this->start_controls_section(
		 'checkout_coupon_sec',
			 [
			   'label' => esc_html__( 'Checkout - Coupon', 'shopbuild' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			 ]
		);
		
		$this->add_group_control(
		   \Elementor\Group_Control_Background::get_type(),
		   [
			  'name'     => 'checkout_coupon_bg',
			  'label'   => esc_html__( 'Coupon Background', 'shopbuild' ),
			  'types'    => [ 'classic', 'gradient', 'video' ],
			  'selector' => '{{WRAPPER}} .sb-checkout-coupon .woocommerce-info',
		   ]
		 );
		
		
		 $this->add_group_control(
		  \Elementor\Group_Control_Border::get_type(),
		  [
			'name'     => 'checkout_coupon_border',
			'label'    => esc_html__( 'Coupon Border', 'shopbuild' ),
			'selector' => '{{WRAPPER}} .sb-checkout-coupon .woocommerce-info',
		  ]
		 );

		 $this->add_control(
		  'checkout_coupon_margin',
			[
			  'label'      => esc_html__( 'Coupon Margin', 'shopbuild' ),
			  'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			  'size_units' => [ 'px', '%', 'em' ],
			  'selectors'  => [
				'{{WRAPPER}} .sb-checkout-coupon .woocommerce-info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			  ],
			]
		  );

		  $this->add_control(
		   'checkout_coupon_padding',
			 [
			   'label'      => esc_html__( 'Coupon Padding', 'shopbuild' ),
			   'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			   'size_units' => [ 'px', '%', 'em' ],
			   'selectors'  => [
				 '{{WRAPPER}} .sb-checkout-coupon .woocommerce-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			   ],
			 ]
		   );

		$this->end_controls_section();

		$this->start_controls_section(
		 'checkout_coupon_text_sec',
			 [
			   'label' => esc_html__( 'Coupon Text', 'shopbuild' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			 ]
		);
		
		$this->add_control(
		 'checkout_coupon_text_color',
		 [
		   'label'       => esc_html__( 'Color', 'shopbuild' ),
		   'type'     => \Elementor\Controls_Manager::COLOR,
		   'selectors' => [
		   '{{WRAPPER}} .sb-checkout-coupon .woocommerce-info' => 'color: {{VALUE}}',
		   ],
		 ]
		);

		$this->add_control(
		 'checkout_coupon_text_inner_color',
		 [
		   'label'       => esc_html__( 'Link Text Color', 'shopbuild' ),
		   'type'     => \Elementor\Controls_Manager::COLOR,
		   'selectors' => [
		   '{{WRAPPER}} .sb-checkout-coupon .woocommerce-info .showcoupon' => 'color: {{VALUE}}',
		   '{{WRAPPER}} .sb-checkout-coupon .woocommerce-info a.showcoupon' => 'border-color: {{VALUE}}',
		   ],
		 ]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'checkout_coupon_text_inner_typo',
			  'label'   => esc_html__( 'Coupon Typography', 'shopbuild' ),
			  'selector' => '{{WRAPPER}} .sb-checkout-coupon .woocommerce-info',
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

        if ( ! wc_coupons_enabled() ) { 
            return;
        }

		$args = [
			'coupon_style' => $settings['pure_checkout_coupon_style'],
			'coupon_btn_title' => $settings['pure_checkout_coupon_btn_title'],
			'coupon_title' => $settings['pure_checkout_coupon_title'],
			'coupon_desc' => $settings['pure_checkout_coupon_desc'],
		];
		?>
		<div class="sb-checkout-coupon">
			<?php pure_wc_get_template('checkout/form-coupon.php', $args); ?>
		</div>
		<?php
	}
}

$widgets_manager->register( new Pure_Checkout_Coupon_Widget() );