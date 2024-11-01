<?php

use Elementor\Controls_Manager;
use PureWCShopbuild\Elementor\Controls\Group_Control_PWCSGradient;
use PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin;

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
class Pure_Product_Card extends Pure_Wc_Base_Widget {

	use PureWCArchive, PureWCCommonStyles, PureWCQuery, PureWCActionFilter;

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
		return 'product-card';
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
		return esc_html__( 'Shopbuild Product Card', 'shopbuild' );
	}

	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){


		// product feature
		$this->pure_wc_product_feature();

		$this->pure_wc_query_controls('product', 'Product', false, false, false, 6, 10, 'product', 'product_cat', 12, 0, 'date', 'desc');

		$this->pure_wc_columns('product', 'Product Columns');
    }

    protected function register_style_controls(){

		$this->start_controls_section(
			'pure_wc_search_styling',
			[
				'label' => esc_html__('Product - Title', 'shopbuild'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_PWCSGradient::get_type(),
			[
				'name' => 'pure_wc_search_advs',
				'label' => esc_html__('Color', 'shopbuild'),
				'selector' => '{{WRAPPER}} .sb-product-title a',
			]
		);

		$this->add_group_control(
			Group_Control_PWCSGradient::get_type(),
			[
				'name' => 'pure_wc_search__hover_advs',
				'label' => esc_html__('Hover Color', 'shopbuild'),
				'selector' => '{{WRAPPER}} .sb-product-title a:hover ',
			]
		);

		$this->add_group_control(
			Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pure_wc_search_typography',
				'label' => esc_html__('Typography', 'shopbuild'),
				'selector' => '{{WRAPPER}} .sb-product-title ',
			]
		);

		$this->add_responsive_control(
			'pure_wc_search_padding',
			[
				'label' => esc_html__('Padding', 'shopbuild'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .sb-product-title ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'pure_wc_product_title_margin',
			[
				'label' => esc_html__('Margin', 'shopbuild'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .sb-product-title ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
        
		$this->start_controls_section(
			'pure_wc_product_tag_styling',
			[
				'label' => esc_html__('Product - Category', 'shopbuild'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pure_wc_product_tag_color',
			[
				'label' => esc_html__( 'Product Tag Color', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sb-product-tag a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .sb-product-tag a::after' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pure_wc_product_tag_hover_color',
			[
				'label' => esc_html__( 'Product Tag Hover Color', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sb-product-tag a:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .sb-product-tag a:hover::after' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pure_wc_product_tag_typography',
				'label' => esc_html__('Typography', 'shopbuild'),
				'selector' => '{{WRAPPER}} .sb-product-tag a',
			]
		);
		$this->add_responsive_control(
			'pure_wc_product_tag_padding',
			[
				'label' => esc_html__('Padding', 'shopbuild'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .sb-product-tag a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'pure_wc_product_tag_margin',
			[
				'label' => esc_html__( 'Margin', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .sb-product-tag a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
        
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
					'{{WRAPPER}} .sb-product-price-wrapper span, {{WRAPPER}} .sb-product-price-wrapper' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pure_wc_product_price_old_color',
			[
				'label' => esc_html__( 'Product Price Old Color', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sb-product-price-wrapper span del, {{WRAPPER}} .sb-product-price-wrapper span del span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pure_wc_product_price_typography',
				'label' => esc_html__('Price Typography', 'shopbuild'),
				'selector' => '{{WRAPPER}} .sb-product-price-wrapper span',
			]
		);

		$this->add_group_control(
			Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pure_wc_product_price_typography_old',
				'label' => esc_html__('Old Price Typography', 'shopbuild'),
				'selector' => '{{WRAPPER}} .sb-product-price-wrapper span del span',
			]
		);
		$this->add_responsive_control(
			'pure_wc_product_price_padding',
			[
				'label' => esc_html__('Padding', 'shopbuild'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .sb-product-price-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .sb-product-price-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
		 'pure_wc_product_variation_sec',
			 [
			   'label' => esc_html__( 'Product Variation', 'shopbuild' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			 ]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'variation_typo',
			  'label'   => esc_html__( 'Variation Typography', 'shopbuild' ),
			  'selector' => '{{WRAPPER}} .sb-product-item .tpwvs-shop-variations.variations ul li .tpwvs-attr-button',
			]
		  );

		   $this->start_controls_tabs(
			  'variation_tabs',
			);
		   
				$this->start_controls_tab(
					'variation_tab_normal',
						[
							'label'   => esc_html__( 'Normal', 'shopbuild' ),
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Background::get_type(),
						[
						   'name'     => 'variation_bg',
						   'label'   => esc_html__( 'Variation Background', 'shopbuild' ),
						   'types'    => [ 'classic', 'gradient', 'video' ],
						   'selector' => '{{WRAPPER}} .sb-product-item .tpwvs-shop-variations.variations ul li .tpwvs-attr-button',
						]
					  );
		   
					  $this->add_control(
					   'variation_color',
					   [
						 'label'       => esc_html__( 'Variation Text Color', 'shopbuild' ),
						 'type'     => \Elementor\Controls_Manager::COLOR,
						 'selectors' => [
						 '{{WRAPPER}} .sb-product-item .tpwvs-shop-variations.variations ul li .tpwvs-attr-button' => 'color: {{VALUE}}',
						 ],
					   ]
					  );
				   
					  $this->add_group_control(
					   \Elementor\Group_Control_Border::get_type(),
					   [
						 'name'     => 'variation_border',
						 'label'    => esc_html__( 'Variation Border', 'shopbuild' ),
						 'selector' => '{{WRAPPER}} .sb-product-item .tpwvs-shop-variations.variations ul li .tpwvs-attr-button',
						 'separator' => 'after',
					   ]
					  );
				
				$this->end_controls_tab();

				
				$this->start_controls_tab(
				   'variation_tab_hover',
				   [
					 'label'   => esc_html__( 'Hover', 'shopbuild' ),
				   ]
				 );
				
				 $this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
					   'name'     => 'variation_bg_hover',
					   'label'   => esc_html__( 'Variation Background', 'shopbuild' ),
					   'types'    => [ 'classic', 'gradient', 'video' ],
					   'selector' => '{{WRAPPER}} .sb-product-item .tpwvs-shop-variations.variations ul li .tpwvs-attr-button:hover',
					]
				  );
	   
				  $this->add_control(
				   'variation_color_hover',
				   [
					 'label'       => esc_html__( 'Variation Text Color', 'shopbuild' ),
					 'type'     => \Elementor\Controls_Manager::COLOR,
					 'selectors' => [
					 '{{WRAPPER}} .sb-product-item .tpwvs-shop-variations.variations ul li .tpwvs-attr-button:hover' => 'color: {{VALUE}}',
					 ],
				   ]
				  );
			   
				  $this->add_group_control(
				   \Elementor\Group_Control_Border::get_type(),
				   [
					 'name'     => 'variation_borde_hover',
					 'label'    => esc_html__( 'Variation Border', 'shopbuild' ),
					 'selector' => '{{WRAPPER}} .sb-product-item .tpwvs-shop-variations.variations ul li .tpwvs-attr-button:hover',
					 'separator' => 'after',
				   ]
				  );

				$this->end_controls_tab();
				
				$this->start_controls_tab(
				   'variation_tab_active',
				   [
					 'label'   => esc_html__( 'Active', 'shopbuild' ),
				   ]
				 );
				
				 $this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
					   'name'     => 'variation_bg_active',
					   'label'   => esc_html__( 'Variation Background', 'shopbuild' ),
					   'types'    => [ 'classic', 'gradient', 'video' ],
					   'selector' => '{{WRAPPER}} .sb-product-item .tpwvs-shop-variations.variations ul li span.tpwvs-attr-button.button-active',
					]
				  );
	   
				  $this->add_control(
				   'variation_color_active',
				   [
					 'label'       => esc_html__( 'Variation Text Color', 'shopbuild' ),
					 'type'     => \Elementor\Controls_Manager::COLOR,
					 'selectors' => [
					 '{{WRAPPER}} .sb-product-item .tpwvs-shop-variations.variations ul li span.tpwvs-attr-button.button-active' => 'color: {{VALUE}}',
					 ],
				   ]
				  );
			   
				  $this->add_group_control(
				   \Elementor\Group_Control_Border::get_type(),
				   [
					 'name'     => 'variation_borde_active',
					 'label'    => esc_html__( 'Variation Border', 'shopbuild' ),
					 'selector' => '{{WRAPPER}} .sb-product-item .tpwvs-shop-variations.variations ul li span.tpwvs-attr-button.button-active',
					 'separator' => 'after',
				   ]
				  );

				$this->end_controls_tab();
				
		   
		   $this->end_controls_tabs();



		   $this->add_control(
			'variation_padding',
			  [
				'label'      => esc_html__( 'Variation Single Padding', 'shopbuild' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
				  '{{WRAPPER}} .sb-product-item .tpwvs-shop-variations.variations ul li .tpwvs-attr-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			  ]
			);
		   $this->add_control(
			'variation_margin',
			  [
				'label'      => esc_html__( 'Variation Single Margin', 'shopbuild' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
				  '{{WRAPPER}} .sb-product-item .tpwvs-shop-variations.variations ul li .tpwvs-attr-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			  ]
			);
			

		$this->add_control(
			'pure_wc_product_variation_space',
			[
				'label' => esc_html__( 'Margin Without Last Child', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .sb-product-item .tpwvs-shop-variations.variations ul li:not(:last-child)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pure_wc_product_variation_wrap_margin',
			[
				'label' => esc_html__( 'Outer Margin', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .sb-product-item .tpwvs-shop-variations.variations ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
		 'pure_wc_product_variation_wrapper_sec',
			 [
			   'label' => esc_html__( 'Variation Wrapper', 'shopbuild' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			 ]
		);
		
		$this->add_group_control(
		   \Elementor\Group_Control_Background::get_type(),
		   [
			  'name'     => 'pure_wc_product_variation_bg',
			  'label'   => esc_html__( 'Background', 'shopbuild' ),
			  'types'    => [ 'classic', 'gradient', 'video' ],
			  'selector' => '{{WRAPPER}} .sb-product-item .sb-product-action-with-variation',
		   ]
		 );
		
		 $this->add_control(
		  'pure_wc_product_variation_margin',
			[
			  'label'      => esc_html__( 'Margin', 'shopbuild' ),
			  'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			  'size_units' => [ 'px', '%', 'em' ],
			  'selectors'  => [
				'{{WRAPPER}} .sb-product-item .sb-product-action-with-variation' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			  ],
			]
		  );
		
		 $this->add_control(
		  'pure_wc_product_variation_padding',
			[
			  'label'      => esc_html__( 'Padding', 'shopbuild' ),
			  'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			  'size_units' => [ 'px', '%', 'em' ],
			  'selectors'  => [
				'{{WRAPPER}} .sb-product-item .sb-product-action-with-variation' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			  ],
			]
		  );
		
		$this->end_controls_section();

		$this->start_controls_section(
		 'pure_wc_product_rating_sec',
			 [
			   'label' => esc_html__( 'Product Rating', 'shopbuild' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			 ]
		);
		
		$this->add_control(
			'pure_wc_product_rating_color',
			[
				'label' => esc_html__( 'Product Rating Color', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sb-product-rating-icon .star-rating span, {{WRAPPER}} .sb-product-rating-icon .star-rating span::before' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
		 'pure_wc_product_rating_text_color',
		 [
		   'label'       => esc_html__( 'Product Rating Text Color', 'shopbuild' ),
		   'type'     => \Elementor\Controls_Manager::COLOR,
		   'selectors' => [
		   '{{WRAPPER}} .sb-product-rating-icon .sb-product-rating-text' => 'color: {{VALUE}}',
		   ],
		 ]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'pure_wc_product_rating_text_typo',
			  'label'   => esc_html__( 'Product Rating Text Typography', 'shopbuild' ),
			  'selector' => '{{WRAPPER}} .sb-product-rating-icon .sb-product-rating-text',
			]
		  );

		  $this->add_responsive_control(
			'pure_wc_product_rating_text_padding',
			[
				'label' => esc_html__('Padding', 'shopbuild'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .sb-product-rating-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

				'separator' => 'before',
			]
		);

		$this->add_control(
			'pure_wc_product_rating_text_margin',
			[
				'label' => esc_html__( 'Margin', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .sb-product-rating-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
		 'pure_wc_product_countdown_sec',
			 [
			   'label' => esc_html__( 'Product Countdown', 'shopbuild' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			 ]
		);

		$this->add_control(
			'pure_wc_product_countdown_bg',
			[
				'label' => esc_html__( 'Product Countdown BG Color', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sb-product-countdown-time' => 'background-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'pure_wc_product_countdown_color',
			[
				'label' => esc_html__( 'Product Countdown Color', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sb-product-countdown ul li, {{WRAPPER}} .sb-product-countdown ul li span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pure_wc_product_countdown_typography',
				'label' => esc_html__('Typography', 'shopbuild'),
				'selector' => '{{WRAPPER}} .sb-product-countdown ul li, {{WRAPPER}} .sb-product-countdown ul li span',
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
		 'pure_wc_product_sale_sec',
			 [
			   'label' => esc_html__( 'Product Sale', 'shopbuild' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			 ]
		);

		$this->add_control(
			'pure_wc_product_sale_bg',
			[
				'label' => esc_html__( 'Product Sale BG Color', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sb-product-on-sale-wrap span' => 'background-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'pure_wc_product_sale_color',
			[
				'label' => esc_html__( 'Product Sale Color', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sb-product-on-sale-wrap span, {{WRAPPER}} .sb-product-on-sale-wrap span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pure_wc_product_sale_typography',
				'label' => esc_html__('Typography', 'shopbuild'),
				'selector' => '{{WRAPPER}} .sb-product-on-sale-wrap span, {{WRAPPER}} .sb-product-on-sale-wrap span',
			]
		);

		$this->add_control(
		 'pure_wc_product_sale_margin',
		   [
			 'label'      => esc_html__( 'Margin', 'shopbuild' ),
			 'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			 'size_units' => [ 'px', '%', 'em' ],
			 'selectors'  => [
			   '{{WRAPPER}} .sb-product-on-sale-wrap span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			 ],
		   ]
		 );

		$this->add_control(
		 'pure_wc_product_sale_padding',
		   [
			 'label'      => esc_html__( 'Padding', 'shopbuild' ),
			 'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			 'size_units' => [ 'px', '%', 'em' ],
			 'selectors'  => [
			   '{{WRAPPER}} .sb-product-on-sale-wrap span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			 ],
		   ]
		 );
		
		$this->end_controls_section();

		$this->start_controls_section(
		 'proudct_action_wrapper_sec',
			 [
			   'label' => esc_html__( 'Product Action Wrapper', 'shopbuild' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			 ]
		);

		$this->add_group_control(
		   \Elementor\Group_Control_Background::get_type(),
		   [
			  'name'     => 'pure_wc_product_action_wrapper_bg',
			  'label'   => esc_html__( 'Action Wrapper Background', 'shopbuild' ),
			  'types'    => [ 'classic', 'gradient', 'video' ],
			  'selector' => '{{WRAPPER}} .sb-product-item .sb-product-action-item',
		   ]
		 );

		  $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .sb-product-item .sb-product-action-item',
			]
		);

		 $this->add_group_control(
		  \Elementor\Group_Control_Border::get_type(),
		  [
			'name'     => 'pure_wc_product_action_wrapper_border',
			'label'    => esc_html__( 'label', 'shopbuild' ),
			'selector' => '{{WRAPPER}} .sb-product-item .sb-product-action-item',
		  ]
		 );
		
		$this->add_control(
			'pure_wc_product_action_wrapper_margin',
			[
				'label' => esc_html__( 'Margin', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .sb-product-item .sb-product-action-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'pure_wc_product_action_wrapper_padding',
			[
				'label' => esc_html__( 'Padding', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .sb-product-item .sb-product-action-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		
		$this->end_controls_section();


		$this->pure_wc_link_controls_style('product_action_btn', 'Product - Action Button', '.sb-product-action-item .sb-product-action-btn[class], .sb-product-action-item a.sb-product-action-btn, .sb-product-action-item a.added_to_cart.wc-forward', '.sb-product-action-item .sb-product-action-btn[class]:hover, .sb-product-action-item a.added_to_cart.wc-forward:hover');

		$this->pure_wc_link_controls_style('product_add_to_cart_btn', 'Product - Add To Cart Button', '.sb-product-item .sb-product-add-to-cart-btn.sb-product-action-btn[class], .sb-product-item a.sb-product-action-btn.sb-product-add-to-cart-btn, .sb-product-item a.added_to_cart.wc-forward', '.sb-product-item .sb-product-add-to-cart-btn.sb-product-action-btn[class]:hover, .sb-product-item a.added_to_cart.wc-forward:hover');
		
		$this->start_controls_section(
		 'pure_wc_pagination_sec',
			 [
			   'label' => esc_html__( 'Pagination', 'shopbuild' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			 ]
		);
		
		$this->add_group_control(
		   \Elementor\Group_Control_Background::get_type(),
		   [
			  'name'     => 'pure_wc_pagination_bg',
			  'label'   => esc_html__( 'Background', 'shopbuild' ),
			  'types'    => [ 'classic', 'gradient', 'video' ],
			  'selector' => '{{WRAPPER}} nav.sb-pagination ul li a',
		   ]
		 );

		 $this->add_group_control(
		  \Elementor\Group_Control_Border::get_type(),
		  [
			'name'     => 'pure_wc_pagination_border',
			'label'    => esc_html__( 'Border', 'shopbuild' ),
			'selector' => '{{WRAPPER}} nav.sb-pagination ul li a',
		  ]
		 );

		 $this->add_group_control(
			 \Elementor\Group_Control_Typography::get_type(),
			 [
			   'name' => 'pure_wc_pagination_typpo',
			   'label'   => esc_html__( 'Typography', 'shopbuild' ),
			   'selector' => '{{WRAPPER}} nav.sb-pagination ul li a',
			 ]
		   );


		   $this->add_control(
			'pure_wc_pagination_margin',
			  [
				'label'      => esc_html__( 'Margin', 'shopbuild' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
				  '{{WRAPPER}} nav.sb-pagination ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			  ]
			);
		
		
		$this->end_controls_section();

		$this->pure_wc_link_controls_style('product_load_more_btn', 'Load More Button', 'button.sb-product-load-more-btn', 'button.sb-product-load-more-btn:hover');
	}


	protected function get_archive_query_objects(){
		$query_object = get_queried_object();
		if( is_product_tag() ){
			return $query_object->slug;
		}else if( is_product_category() ){
			return $query_object->term_id;
		}else{
			return $query_object;
		}
	}

	public function get_args(){
		$settings = $this->get_settings_for_display();
		$limit = $this->get_settings_for_display('posts_per_page') ?  $this->get_settings_for_display('posts_per_page')  : get_option('pure_wc_product_limit') ;
		$query_object = $this->get_archive_query_objects();


		$product_include_items = $settings['post_include'];


		return apply_filters('pure_wc_shopbuild_products_args', array(
			'columns'        => $this->get_settings_for_display('products_columns'),
			'category'       => is_product_category() ? $query_object : '',        // Comma separated category slugs or ids.
			'tag'            => is_product_tag() ? $query_object : '',        // Comma separated tag slugs.
			'page'       	 => absint( get_query_var('paged') )  > 1 ? absint( get_query_var('paged') ) : 1,
			'paginate'       => true,     	// Should results be paginated.
			'limit' 		 => $limit,
			'ids'       	 => is_array($product_include_items) ? implode(',', $product_include_items) : '',
			'orderby'        => $settings['orderby'],
			'order'          => $settings['order'],
			'excludes'       => !empty($settings['post__not_in']) ? $settings['post__not_in'] : '',      
			'includes'       => !empty($settings['exclude_category']) ? $settings['exclude_category'] : '',
		));
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
		$woocoomerce_settings  = Pure_Wc_Shopuild_Admin::get_option('_pure_shopbuild_woocommerce');
		$this->actionFilters();
		$settings = $this->get_settings_for_display();

		$is_editor_mode = pure_wc_is_elementor_edit();
		
		$attrs = $this->get_args();
		$limit = $settings['posts_per_page'] ?  $settings['posts_per_page']  : $woocoomerce_settings['products_limits'];
		$woocoomerce_settings['products_limits'] = $limit;


		$contents = new PureWCShopbuild\Pure_Shopbuild_Archive_Products( $attrs );
		$results  = $contents->get_custom_card_content($is_editor_mode, $this->pure_wc_product_feature_options($settings));
		$no_contents = pure_wc_shopbuild_no_contents();


		$theme = wp_get_theme();
		$theme_name = '';
		if( !empty($theme) ){
			$theme_name = strtolower($theme->Name);
		}
		echo '<div class="products-grid-wrapper '.esc_html($theme_name).'">';
		if( wp_strip_all_tags( trim($results) )){?>
            <div class="sb-row <?php echo esc_attr($this->pure_row_cols_show($settings, 'product')); ?>">
                <?php print wp_kses($results, pure_wc_get_kses_extended_ruleset());  ?>
            </div>
            <?php
			
		}else{
			print wp_kses($no_contents, pure_wc_get_kses_extended_ruleset());
		}
		echo '</div>';


		Pure_Wc_Shopuild_Admin::update_settings('_pure_shopbuild_woocommerce', wp_json_encode($woocoomerce_settings));
		add_filter('pure_wc_product_grid_args', array( $this, 'get_args'));
	}
}

$widgets_manager->register( new Pure_Product_Card() );