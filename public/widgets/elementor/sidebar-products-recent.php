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
class Pure_Products_Sidebar_Widget extends Pure_Wc_Base_Widget {

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
		return 'sidebar-products-recent';
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
		return esc_html__( 'Sidebar Products Recent', 'shopbuild' );
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

		$this->add_control(
			'sidebar_recent_products_title_word_count',
			[
			  'label'   => esc_html__( 'Word Count', 'shopbuild' ),
			  'type'    => \Elementor\Controls_Manager::NUMBER,
			  'min'     => 1,
			  'max'     => 10000,
			  'step'    => 1,
			  'default' => 5,
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
				'name' => 'pure_wc_search_border',
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
			'pure_wc_link_title_link',
			[
				'label' => esc_html__('Box Title', 'shopbuild'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pure_wc_link_title_link_color',
			[
				'label' => esc_html__('Text Color', 'shopbuild'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sb-sidebar-product-rating-item .tp-el-box-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pure_wc_link_title_link_hover_color',
			[
				'label' => esc_html__('Text Hover Color', 'shopbuild'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sb-sidebar-product-rating-item .tp-el-box-title:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pure_wc_link_title_typography',
				'label' => esc_html__('Typography', 'shopbuild'),
				'selector' => '{{WRAPPER}} .sb-sidebar-product-rating-item .tp-el-box-title',
			]
		);
		$this->add_responsive_control(
			'pure_wc_link_title_link_padding',
			[
				'label' => esc_html__('Padding', 'shopbuild'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .sb-sidebar-product-rating-item .tp-el-box-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'pure_wc_link_title_link_margin',
			[
				'label' => esc_html__('Margin', 'shopbuild'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .sb-sidebar-product-rating-item .tp-el-box-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'pure_wc_price_text_section',
			[
				'label' => esc_html__('Price Style', 'shopbuild'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pure_wc_price_typography',
				'label' => esc_html__('Typography', 'shopbuild'),
				'selector' => '{{WRAPPER}} .tp-el-box-price-title .sb-sidebar-product-rating-price-wrapper span',
			]
		);

		$this->add_control(
			'pure_wc_price_text_color',
			[
				'label' => esc_html__('Price Color', 'shopbuild'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-el-box-price-title .sb-sidebar-product-rating-price-wrapper span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pure_wc_price_old_text_color',
			[
				'label' => esc_html__('Old Price Color', 'shopbuild'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-el-box-price-title .sb-sidebar-product-rating-price-wrapper, {{WRAPPER}} .tp-el-box-price-title .sb-sidebar-product-rating-price-wrapper del span, {{WRAPPER}} .tp-el-box-price-title .sb-sidebar-product-rating-price-wrapper del' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pure_wc_product_rating_section',
			[
				'label' => esc_html__('Rating Style', 'shopbuild'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pure_wc_product_rating_size',
			[
				'label' => esc_html__( 'Icon Size', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10000,
						'step' => 1,
					],
					'rem' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 12,
				],
				'selectors' => [
					'{{WRAPPER}} .sb-sidebar-product-rating-icon div.star-rating, {{WRAPPER}} .sb-sidebar-product-rating-icon div.star-rating::before, {{WRAPPER}} .sb-sidebar-product-rating-icon div.star-rating span::before' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);



		$this->add_control(
			'pure_wc_product_rating_color_default',
			[
				'label' => esc_html__('Normal Color', 'shopbuild'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sb-sidebar-product-rating-icon div.star-rating::before' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'pure_wc_product_rating_color',
			[
				'label' => esc_html__('Rated Icon Color', 'shopbuild'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sb-sidebar-product-rating-icon .star-rating span, {{WRAPPER}} .sb-sidebar-product-rating-icon .star-rating span::before' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
		 'pure_wc_product_sidebar_thumb_sec',
			 [
			   'label' => esc_html__( 'Thumbnail Style', 'shopbuild' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			 ]
		);
		
		$this->add_control(
		 'pure_wc_product_sidebar_thumb_margin',
		   [
			 'label'      => esc_html__( 'Margin', 'shopbuild' ),
			 'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			 'size_units' => [ 'px', '%', 'em' ],
			 'selectors'  => [
			   '{{WRAPPER}} .sb-sidebar-product-list .sb-sidebar-product-rating-thumb img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			 ],
		   ]
		 );

		 $this->add_control(
				'pure_wc_product_sidebar_thumb_width',
				[
					'label' => esc_html__( 'Width', 'shopbuild' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 5,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 70,
					],
					'selectors' => [
						'{{WRAPPER}} .sb-sidebar-product-list .sb-sidebar-product-rating-thumb img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
		);

		 $this->add_control(
				'pure_wc_product_sidebar_thumb_height',
				[
					'label' => esc_html__( 'Height', 'shopbuild' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'rem' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 5,
						],
						'rem' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 70,
					],
					'selectors' => [
						'{{WRAPPER}} .sb-sidebar-product-list .sb-sidebar-product-rating-thumb img' => 'height: {{SIZE}}{{UNIT}};',
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
        $settings = $this->get_settings_for_display();
       ?>
		
      <?php 
       ob_start();

		$number = ! empty( $settings['number'] ) ? absint( $settings['number'] ) : 5;

		$query_args = apply_filters(
			'woocommerce_top_rated_products_widget_args',
			array(
				'posts_per_page' => $number,
				'no_found_rows'  => 1,
				'post_status'    => 'publish',
				'post_type'      => 'product',
				'orderby'        => 'meta_value_num',
				'order'          => 'DESC',
			)
		); // WPCS: slow query ok.

		$r = new WP_Query( $query_args );

		if ( $r->have_posts() ) {

			?>
				<?php if(!empty($settings['sb_widget_title'])) : ?>
				<h3 class="sb-sidebar-product-widget-title tp-el-title"><?php echo esc_html($settings['sb_widget_title']); ?></h3>
				<?php endif; ?>
			<?php

			print wp_kses_post( apply_filters( 'woocommerce_before_widget_product_list', '<ul class="product_list_widget sb-sidebar-product-list">' ) );

			$template_args = array(
				'widget_id'   => isset( $args['widget_id'] ) ? $args['widget_id'] : 'product_top_rated',
				'show_rating' => true,
			);

			while ( $r->have_posts() ) {
				$r->the_post();
				global $product;

                if ( ! is_a( $product, 'WC_Product' ) ) {
                    return;
                }

                ?>
                <li>

					<div class="sb-sidebar-product-rating-item">
						<div class="sb-sidebar-product-rating-thumb">
							<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
								<?php echo wp_kses($product->get_image(), pure_wc_get_kses_extended_ruleset()); ?>
							</a>
						</div>
						<div class="sb-sidebar-product-rating-content">
							
							<div class="sb-sidebar-product-rating-rating-wrapper">
								<div class="sb-sidebar-product-rating-icon">
									<?php echo wp_kses(wc_get_rating_html( $product->get_average_rating() ), pure_wc_get_kses_extended_ruleset()); ?>
								</div>
							</div>
							<h4 class="sb-sidebar-product-rating-title">
								<a class="tp-el-box-title" href="<?php echo esc_url( $product->get_permalink() ); ?>">
									<?php echo wp_kses(wp_trim_words($product->get_name(), $settings['sidebar_recent_products_title_word_count']), pure_wc_get_kses_extended_ruleset()); ?>
								</a>
							</h4>
							<div class="sb-sidebar-product-rating-price-wrapper">
								<?php echo wp_kses($product->get_price_html(), pure_wc_get_kses_extended_ruleset()); ?>
							</div>
						</div>
					</div>

                </li>


			<?php }

			print wp_kses_post( apply_filters( 'woocommerce_after_widget_product_list', '</ul>' ) );

			
		}

		wp_reset_postdata();

		$content = ob_get_clean();
		echo '<div class="sb-sidebar-product-rating sb-sidebar-product-list tp-el-section tp-el-box-price-title">';
			print wp_kses_post($content); // WPCS: XSS ok.
		echo '</div>';

        
	}
}

$widgets_manager->register( new Pure_Products_Sidebar_Widget() );