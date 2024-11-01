<?php

use Elementor\Controls_Manager;

use Elementor\Plugin;
use PureWCShopbuild\Elementor\Controls\Group_Control_PWCSGradient;

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
class Pure_Products_Price_Filter_Widget extends Pure_Wc_Base_Widget {

	use PureWCArchive, PureWCCommonStyles;

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
		return 'sidebar-price-filter';
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
		return esc_html__( 'Sidebar Price Filter', 'shopbuild' );
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
			'sb_widget_title',
			 [
				'label'       => esc_html__( 'Title', 'shopbuild' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'ShopBuild Widget Title', 'shopbuild' ),
				'placeholder' => esc_html__( 'Your Text', 'shopbuild' ),
				'label_block' => true
			 ]
		);

        $this->end_controls_section();
    }

    protected function register_style_controls(){

		$this->start_controls_section(
			'pure_wc_search_styling',
			[
				'label' => esc_html__('Widget - Title', 'shopbuild'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_PWCSGradient::get_type(),
			[
				'name' => 'pure_wc_search_advs',
				'label' => esc_html__('Color', 'shopbuild'),
				'selector' => '{{WRAPPER}} .tp-el-title ',
			]
		);

		$this->add_group_control(
			Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pure_wc_search_typography',
				'label' => esc_html__('Typography', 'shopbuild'),
				'selector' => '{{WRAPPER}} .tp-el-title ',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .tp-el-title',
			]
		);
		$this->add_responsive_control(
			'pure_wc_search_padding',
			[
				'label' => esc_html__('Padding', 'shopbuild'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .tp-el-title ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'pure_wc_search_margin',
			[
				'label' => esc_html__('Margin', 'shopbuild'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .tp-el-title ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->end_controls_section();

        $this->start_controls_section(
			'pure_wc_price_filter_line_area_styling',
			[
				'label' => esc_html__('Price Filter ', 'shopbuild'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'pure_wc_price_filter_area_background',
				'label' => esc_html__('Background', 'shopbuild'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .sb-sidebar-product-price-filter .ui-slider-horizontal .ui-slider-range, {{WRAPPER}} .sb-sidebar-product-price-filter .ui-slider .ui-slider-handle'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pure_wc_price_text_color_area',
			[
				'label' => esc_html__('Price Text ', 'shopbuild'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pure_wc_price_text_color',
			[
				'label' => esc_html__('Text Color', 'shopbuild'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .price_label' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();

		$this->pure_wc_link_controls_style('search_button', 'Form - Button', '.tp-el-box-btn button[type="submit"]', '.tp-el-box-btn button[type="submit"]:hover');
        
    }


    public function get_script_depends(){
        return array( 'wc-price-slider' );
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
        global $wp;
		$settings = $this->get_settings_for_display();
		
		// Round values to nearest 10 by default.
		$step = max( apply_filters( 'woocommerce_price_filter_widget_step', 10 ), 1 );

		// Find min and max price in current result set.
		$prices    = function_exists('pure_wc_shopbuild_minmax_price_limit') ? pure_wc_shopbuild_minmax_price_limit() : array('min' => 0,'max' => 100);

		$min_price = $prices['min'];
		$max_price = $prices['max'];

		// var_dump($min_price, $max_price);

		// Check to see if we should add taxes to the prices if store are excl tax but display incl.
		$tax_display_mode = get_option( 'woocommerce_tax_display_shop' );

		if ( wc_tax_enabled() && ! wc_prices_include_tax() && 'incl' === $tax_display_mode ) {
			$tax_class = apply_filters( 'woocommerce_price_filter_widget_tax_class', '' ); // Uses standard tax class.
			$tax_rates = WC_Tax::get_rates( $tax_class );

			if ( $tax_rates ) {
				$min_price += WC_Tax::get_tax_total( WC_Tax::calc_exclusive_tax( $min_price, $tax_rates ) );
				$max_price += WC_Tax::get_tax_total( WC_Tax::calc_exclusive_tax( $max_price, $tax_rates ) );
			}
		}

		

		$min_price = apply_filters( 'woocommerce_price_filter_widget_min_amount', floor( $min_price / $step ) * $step );
		$max_price = apply_filters( 'woocommerce_price_filter_widget_max_amount', ceil( $max_price / $step ) * $step );
		
		// If both min and max are equal, we don't need a slider.
		if ( $min_price === $max_price ) {
			return;
		}


		$current_min_price = isset( $_GET['min_price'] ) ? floor( floatval( wp_unslash( $_GET['min_price'] ) ) / $step ) * $step : $min_price; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$current_max_price = isset( $_GET['max_price'] ) ? ceil( floatval( wp_unslash( $_GET['max_price'] ) ) / $step ) * $step : $max_price; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		if ( '' === get_option( 'permalink_structure' ) ) {
			$form_action = remove_query_arg( array( 'page', 'paged', 'product-page' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
		} else {
			$form_action = preg_replace( '%\/page/[0-9]+%', '', home_url( trailingslashit( $wp->request ) ) );
		}
		echo wp_kses_post('<div class="sb-sidebar-product-price-filter tp-el-box-btn tp-el-section">');
		
		?>
			<?php if(!empty($settings['sb_widget_title'])) :
				echo "<h3 class='sb-sidebar-product-widget-title tp-el-title'>" . esc_html($settings['sb_widget_title']) . "  </h3>";
			endif; ?>

		<?php
		
		wc_get_template(
			'content-widget-price-filter.php',
			array(
				'form_action'       => $form_action,
				'step'              => $step,
				'min_price'         => $min_price,
				'max_price'         => $max_price,
				'current_min_price' => $current_min_price,
				'current_max_price' => $current_max_price,
			)
		);


		echo wp_kses_post('</div>');
	}
}

$widgets_manager->register( new Pure_Products_Price_Filter_Widget() );