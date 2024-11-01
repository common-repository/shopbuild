<?php

use Elementor\Controls_Manager;

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
class Pure_Products_Search_Widget extends Pure_Wc_Base_Widget {

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
		return 'sidebar-products-search';
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
		return esc_html__( 'Sidebar Products Search', 'shopbuild' );
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

        $this->pure_wc_input_controls_style('search_input', 'Form - Input', '.tp-el-box-input input');

		$this->pure_wc_link_controls_style('search_button', 'Form - Button', '.tp-el-box-btn button', '.tp-el-box-btn button:hover');
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
		?>
		<?php echo '<div class="sb-sidebar-product-search tp-el-section tp-el-box-input tp-el-box-btn">'; ?>

			<?php if(!empty($settings['sb_widget_title'])) : ?>
			<h3 class="sb-sidebar-product-widget-title tp-el-title"><?php echo esc_html($settings['sb_widget_title']); ?></h3>
			<?php endif; ?>

			<?php get_product_search_form();
			echo '</div>';
		?>
	<?php	
	}
}

$widgets_manager->register( new Pure_Products_Search_Widget() );