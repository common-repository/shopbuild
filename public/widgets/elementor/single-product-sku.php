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
class Pure_Product_SKU_Widget extends Pure_Wc_Base_Widget {

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
		return 'single-product-sku';
	}

	/**
	 * Get widget sku.
	 *
	 * Retrieve button widget sku.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget sku.
	 */
	public function get_title() {
		return esc_html__( 'Single Product SKU', 'shopbuild' );
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
		'pure_wc_product_sku_label',
		 [
			'label'       => esc_html__( 'Label', 'shopbuild' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__( 'SKU', 'shopbuild' ),
			'placeholder' => esc_html__( 'Your Text', 'shopbuild' ),
			'label_block' => true,
		 ]
		);

        $this->end_controls_section();
    }

    protected function register_style_controls(){

        $this->start_controls_section(
		 'pure_wc_product_sku_sec',
			[
				'label' => esc_html__( 'Product - SKU', 'shopbuild' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
		 'pure_wc_product_sku_title_color',
			[
				'label'       	=> esc_html__( 'Text Color', 'shopbuild' ),
				'type'     		=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .sb-product-details-sku > span.sku-title' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
		 'pure_wc_product_sku_item_color',
			[
				'label'       	=> esc_html__( 'SKU Text Color', 'shopbuild' ),
				'type'     		=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .sb-product-details-sku span.sku' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'pure_wc_product_sku_typo',
			  'label'   => esc_html__( 'Typography', 'shopbuild' ),
			  'selector' => '{{WRAPPER}} .sb-product-details-sku span',
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
        if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ){
        ?>
        <div class="sb-product-details-sku">
			<p class="sku_wrapper">
				<?php if(!empty($settings['pure_wc_product_sku_label'])) : ?>
				<span class="sku-title"><?php echo wp_kses($settings['pure_wc_product_sku_label'], pure_wc_get_kses_extended_ruleset()); ?> </span>
				<?php endif; ?>

				<span class="sku">
					<?php echo ( $sku = $product->get_sku() ) ? esc_html($sku) : esc_html__( 'N/A', 'shopbuild' ); ?>
				</span>
			</p>
		</div>
        <?php
        }
	}
}

$widgets_manager->register( new Pure_Product_SKU_Widget() );