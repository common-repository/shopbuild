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
class Pure_Product_Pirce_Widget extends Pure_Wc_Base_Widget {

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
		return 'single-product-price';
	}

	/**
	 * Get widget price.
	 *
	 * Retrieve button widget price.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget price.
	 */
	public function get_title() {
		return esc_html__( 'Single Product Price', 'shopbuild' );
	}

	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){

    }

    protected function register_style_controls(){

		$this->start_controls_section(
			'pure_wc_product_price_styling',
			[
				'label' => esc_html__('Product - Price', 'shopbuild'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pure_wc_product_price_color',
			[
				'label' => esc_html__( 'Product Price Color', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sb-product-details-price .price span, {{WRAPPER}} .sb-product-details-price .price ins span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pure_wc_product_price_old_color',
			[
				'label' => esc_html__( 'Product Price Old Color', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sb-product-details-price .price del, {{WRAPPER}} .sb-product-details-price .price del span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pure_wc_product_price_typography',
				'label' => esc_html__('Typography', 'shopbuild'),
				'selector' => '{{WRAPPER}} .sb-product-details-price .price span',
			]
		);

		$this->add_group_control(
			Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pure_wc_product_price_old_typography',
				'label' => esc_html__('Old Typography', 'shopbuild'),
				'selector' => '{{WRAPPER}} .sb-product-details-price .price del, {{WRAPPER}} .sb-product-details-price .price del span',
			]
		);

		$this->add_responsive_control(
			'pure_wc_product_price_padding',
			[
				'label' => esc_html__('Padding', 'shopbuild'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .sb-product-details-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'pure_wc_product_price_margin',
			[
				'label' => esc_html__( 'Margin', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .sb-product-details-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

            if( !empty( $product->get_price_html() ) ){
                ?><div class="sb-product-details-price"><p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php print wp_kses_post($product->get_price_html()); ?></p><?php
            }else{
                echo '<p>'.esc_html__('Price does not set this product.','shopbuild').'</p>';
            }
        }else{
			
            if ( empty( $product ) ) { return; }
			?>

			<div class="sb-product-details-price">
				<?php woocommerce_template_single_price(); ?>
			</div>

			<?php
        }
		
	}
}

$widgets_manager->register( new Pure_Product_Pirce_Widget() );