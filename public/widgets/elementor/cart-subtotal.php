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
class Pure_Cart_Subtotal_Widget extends Pure_Wc_Base_Widget {

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
		return 'cart-subtotal';
	}

	/**
	 * Get widget cart-subtotal.
	 *
	 * Retrieve button widget cart-subtotal.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget cart-subtotal.
	 */
	public function get_title() {
		return esc_html__( 'Cart Subtotal', 'shopbuild' );
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
            '_cart_totals_title',
            [
                'label'         => esc_html__( 'Title', 'shopbuild' ),
				'type'          => Controls_Manager::TEXT,
				'default'       => esc_html__( 'Cart Totals', 'shopbuild' ),
				'placeholder'   => esc_html__( 'Type your title here', 'shopbuild' ),
            ]
        );

		$this->add_control(
            '_cart_checkout_title',
            [
                'label'         => esc_html__( 'Checkout Button', 'shopbuild' ),
				'type'          => Controls_Manager::TEXT,
				'default'       => esc_html__( 'Checkout Button', 'shopbuild' ),
				'placeholder'   => esc_html__( 'Type your title here', 'shopbuild' )
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
			  '{{WRAPPER}} .sb-cart-total table td, {{WRAPPER}} .sb-cart-total table th' => 'border-color: {{VALUE}}',
			  ],
			]
		   );

		   $this->add_control(
			'pure_wc_checkout_table_caption',
			[
			  'label'       => esc_html__( 'Checkout Table Title', 'shopbuild' ),
			  'type'     => \Elementor\Controls_Manager::COLOR,
			  'selectors' => [
			  '{{WRAPPER}} .sb-cart-total h2' => 'color: {{VALUE}}',
			  ],
			]
		   );

		   $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'pure_wc_checkout_table_caption_typo',
			  'label'   => esc_html__( 'Checkout Table Title Typography', 'shopbuild' ),
			  'selector' => '{{WRAPPER}} .sb-cart-total h2',
			]
		  );
		   
		   $this->add_control(
			'pure_wc_checkout_table_head',
			[
			  'label'       => esc_html__( 'Checkout Heading Color', 'shopbuild' ),
			  'type'     => \Elementor\Controls_Manager::COLOR,
			  'selectors' => [
			  '{{WRAPPER}} .sb-cart-total table th' => 'color: {{VALUE}}',
			  ],
			]
		   );
   
		   $this->add_group_control(
			   \Elementor\Group_Control_Typography::get_type(),
			   [
				 'name' => 'pure_wc_checkout_table_head_typo',
				 'label'   => esc_html__( 'Table Heading Typography', 'shopbuild' ),
				 'selector' => '{{WRAPPER}} .sb-cart-total table th',
			   ]
			 );

			 $this->add_control(
				'pure_wc_checkout_table_td',
				[
				  'label'       => esc_html__( 'Checkout Data Color', 'shopbuild' ),
				  'type'     => \Elementor\Controls_Manager::COLOR,
				  'selectors' => [
				  '{{WRAPPER}} .sb-cart-total table td, {{WRAPPER}} .sb-cart-total #shipping_method li label' => 'color: {{VALUE}}',
				  ],
				]
			   );
	   

   
		   $this->add_group_control(
			   \Elementor\Group_Control_Typography::get_type(),
			   [
				 'name' => 'pure_wc_checkout_table_td_typo',
				 'label'   => esc_html__( 'Table Data Typography', 'shopbuild' ),
				 'selector' => '{{WRAPPER}} .sb-cart-total table td, {{WRAPPER}} .sb-cart-total #shipping_method li label',
			   ]
			);
		   
		   $this->end_controls_section();

		   $this->pure_wc_link_controls_style('product_check_btn', 'Product - Checkout Button', '.sb-cart-total a.checkout-button', '.sb-cart-total a.checkout-button:hover');
        
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

		$args = array(
			'cart_total_title' => $settings['_cart_totals_title'],
			'button_title' => $settings['_cart_checkout_title']
		);

		if( is_null(WC()->cart) ){
			return;
		}
		?>
		<?php if( Plugin::instance()->editor->is_edit_mode() ): ?>
			<div class="sb-cart-total sb-cart-total-2">
				<?php pure_wc_get_template('cart/cart-totals.php', $args); ?>
			</div>
			<?php
		?>
		
		<?php else: 
			if( WC()->cart->is_empty() ){
				return;
			}	
			?>
			<div class="sb-cart-total sb-cart-total-2">
				<?php pure_wc_get_template('cart/cart-totals.php', $args); ?>
			</div>
			<?php
		?>

		<?php
		endif;
	}
}

$widgets_manager->register( new Pure_Cart_Subtotal_Widget() );