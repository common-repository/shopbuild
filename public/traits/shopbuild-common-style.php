<?php
use PureWCShopbuild\Elementor\Controls\Group_Control_PWCSGradient;
use Elementor\Controls_Manager;


trait Pure_WC_Common_Style
{
    protected function card_style(){
        $this->start_controls_section(
			'pure_wc_search_styling',
			[
				'label' => esc_html__('Product - Title', 'shopbuild'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
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
		
    }

    protected function pagination_style(){
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
    }

    protected function table_style(){
        $this->start_controls_section(
            'pure_wc_cart_table',
                [
                  'label' => esc_html__( 'Cart Table', 'shopbuild' ),
                  'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                ]
           );
           
           $this->add_control(
            '`tp_cart_table_border`',
            [
              'label'       => esc_html__( 'Table Row Border Color', 'shopbuild' ),
              'type'     => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
              '{{WRAPPER}} .sb-cart-table table tbody tr:not(:last-child)' => 'border-color: {{VALUE}}',
              ],
            ]
           );
   
           $this->add_control(
            'pure_wc_cart_table_head',
            [
              'label'       => esc_html__( 'Table Heading Color', 'shopbuild' ),
              'type'     => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
              '{{WRAPPER}} .sb-cart-table table thead tr th' => 'color: {{VALUE}}',
              ],
            ]
           );
   
           $this->add_group_control(
               \Elementor\Group_Control_Typography::get_type(),
               [
                 'name' => 'pure_wc_cart_table_head_typo',
                 'label'   => esc_html__( 'Table Heading Typography', 'shopbuild' ),
                 'selector' => '{{WRAPPER}} .sb-cart-table table thead tr th',
               ]
             );
           
           $this->add_group_control(
              \Elementor\Group_Control_Background::get_type(),
              [
                 'name'     => 'pure_wc_cart_table_head_bg',
                 'label'   => esc_html__( 'Table Head Background', 'shopbuild' ),
                 'types'    => [ 'classic', 'gradient'],
                 'selector' => '{{WRAPPER}} .sb-cart-table table thead',
              ]
            );
   
           $this->add_control(
            'pure_wc_cart_table_product_title',
            [
              'label'       => esc_html__( 'Product - Title', 'shopbuild' ),
              'type'     => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
              '{{WRAPPER}} .sb-cart-table table tbody tr .product-name a' => 'color: {{VALUE}}',
              ],
            ]
           );
           $this->add_control(
            'pure_wc_cart_table_product_title_hover',
            [
              'label'       => esc_html__( 'Product - Title Hover', 'shopbuild' ),
              'type'     => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
              '{{WRAPPER}} .sb-cart-table table tbody tr .product-name a:hover' => 'color: {{VALUE}}',
              ],
            ]
           );
           $this->add_group_control(
               \Elementor\Group_Control_Typography::get_type(),
               [
                 'name' => 'pure_wc_cart_table_product_title_typo',
                 'label'   => esc_html__( 'Product Title Typhography', 'shopbuild' ),
                 'selector' => '{{WRAPPER}} .sb-cart-table table tbody tr .product-name a',
               ]
             );
   
           $this->add_control(
            'pure_wc_cart_table_product_price',
            [
              'label'       => esc_html__( 'Product Price', 'shopbuild' ),
              'type'     => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
              '{{WRAPPER}} .sb-cart-table table tbody tr .product-subtotal span, {{WRAPPER}} .sb-cart-table table tbody tr .product-price span' => 'color: {{VALUE}}',
              ],
            ]
           );
   
           $this->add_group_control(
               \Elementor\Group_Control_Typography::get_type(),
               [
                 'name' => 'pure_wc_cart_table_product_price_typo',
                 'label'   => esc_html__( 'Product Price Typhography', 'shopbuild' ),
                 'selector' => '{{WRAPPER}} .sb-cart-table table tbody tr .product-subtotal span, {{WRAPPER}} .sb-cart-table table tbody tr .product-price span',
               ]
             );
           
             $this->add_control(
              'pure_wc_cart_table_product_action',
              [
                'label'       => esc_html__( 'Product Action Color', 'shopbuild' ),
                'type'     => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                '{{WRAPPER}} .sb-cart-table table tbody tr .product-remove a' => 'color: {{VALUE}}',
                ],
              ]
             );
             $this->add_control(
              'pure_wc_cart_table_product_action_hover',
              [
                'label'       => esc_html__( 'Product Action Hover Color', 'shopbuild' ),
                'type'     => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                '{{WRAPPER}} .sb-cart-table table tbody tr .product-remove a:hover' => 'color: {{VALUE}}',
                ],
              ]
             );
   
             $this->add_group_control(
               \Elementor\Group_Control_Typography::get_type(),
               [
                 'name' => 'pure_wc_cart_table_product_action_typo',
                 'label'   => esc_html__( 'Product Action Typhography', 'shopbuild' ),
                 'selector' => '{{WRAPPER}} .sb-cart-table table tbody tr .product-remove a',
               ]
             );
   
           $this->end_controls_section();
   
   
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

	protected function coupon_label_style(){
		$this->start_controls_section(
			'pure_wc_coupon_sec',
				[
				  'label' => esc_html__( 'Coupon Label', 'shopbuild' ),
				  'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				]
		   );
		   
		$this->add_control(
		'pure_wc_coupon_label',
			[
				'label'       => esc_html__( 'Label Color', 'shopbuild' ),
				'type'     => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
				'{{WRAPPER}} .sb-cart-coupon-wrapper label[for="pure_coupon_code"]' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pure_wc_coupon_label_typo',
				'label'   => esc_html__( 'Label Typography', 'shopbuild' ),
				'selector' => '{{WRAPPER}} .sb-cart-coupon-wrapper label[for="pure_coupon_code"]',
			]
			);
		
		$this->end_controls_section();
	}
}