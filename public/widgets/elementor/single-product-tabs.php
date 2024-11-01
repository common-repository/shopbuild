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
class Pure_Product_Tabs_Widget extends Pure_Wc_Base_Widget {

	use PureWCSingle, PureWCCommonStyles;

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
		return 'single-product-tabs';
	}

	/**
	 * Get widget tabs.
	 *
	 * Retrieve button widget tabs.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget tabs.
	 */
	public function get_title() {
		return esc_html__( 'Single Product Tabs', 'shopbuild' );
	}

	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){
      
    }

    protected function register_style_controls(){

        $this->start_controls_section(
		 'pure_wc_product_single_tab',
			 [
			   'label' => esc_html__( 'Tab Style', 'shopbuild' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			 ]
		);
		
		$this->add_control(
		 	'pure_wc_product_single_tab_text',
			[
				'label'       => esc_html__( 'Text Color', 'shopbuild' ),
				'type'     => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
				'{{WRAPPER}} .sb-product-details-tab ul li a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
		 	'pure_wc_product_single_tab_text_hover',
			[
				'label'       => esc_html__( 'Text Hover Color', 'shopbuild' ),
				'type'     => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
				'{{WRAPPER}} .sb-product-details-tab ul li a:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
		 	'pure_wc_product_single_tab_text_hover_line',
			[
				'label'       => esc_html__( 'Text Hover Line Color', 'shopbuild' ),
				'type'     => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
				'{{WRAPPER}} .sb-product-details-tab ul li a::after' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'pure_wc_product_single_tab_text_typo',
			  'label'   => esc_html__( 'Typography', 'shopbuild' ),
			  'selector' => '{{WRAPPER}} .sb-product-details-tab ul li a',
			]
		  );
		
		$this->add_control(
		 'pure_wc_product_single_tab_text_padding',
		   [
			 'label'      => esc_html__( 'Padding', 'shopbuild' ),
			 'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			 'size_units' => [ 'px', '%', 'em' ],
			 'selectors'  => [
			   '{{WRAPPER}} .sb-product-details-tab ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			 ],
		   ]
		 );
		
		$this->add_control(
		 'pure_wc_product_single_tab_text_margin',
		   [
			 'label'      => esc_html__( 'Margin', 'shopbuild' ),
			 'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			 'size_units' => [ 'px', '%', 'em' ],
			 'selectors'  => [
			   '{{WRAPPER}} .sb-product-details-tab ul li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			 ],
		   ]
		 );
		
		$this->end_controls_section();

		$this->start_controls_section(
		 'pure_wc_product_single_desc',
			 [
			   'label' => esc_html__( 'Description Controls', 'shopbuild' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			 ]
		);
		

		$this->add_control(
		 'pure_wc_product_single_desc_title',
		 [
		   'label'       => esc_html__( 'Description Title', 'shopbuild' ),
		   'type'     => \Elementor\Controls_Manager::COLOR,
		   'selectors' => [
		   '{{WRAPPER}} .sb-product-details-tab .woocommerce-Tabs-panel--description h2, {{WRAPPER}} .woocommerce-Tabs-panel--additional_information h2, {{WRAPPER}} .woocommerce-Reviews-title' => 'color: {{VALUE}}',
		   ],
		 ]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'pure_wc_product_single_desc_title_typo',
			  'label'   => esc_html__( 'Title Typography', 'shopbuild' ),
			  'selector' => '{{WRAPPER}} .sb-product-details-tab .woocommerce-Tabs-panel--description h2',
			]
		  );

		$this->add_control(
		 'pure_wc_product_single_desc_text',
		 [
		   'label'       => esc_html__( 'Description Content', 'shopbuild' ),
		   'type'     => Controls_Manager::COLOR,
		   'selectors' => [
		   '{{WRAPPER}} .sb-product-details-tab .woocommerce-Tabs-panel--description p' => 'color: {{VALUE}}',
		   ],
		 ]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'pure_wc_product_single_desc_text_typo',
			  'label'   => esc_html__( 'Title Typography', 'shopbuild' ),
			  'selector' => '{{WRAPPER}} .sb-product-details-tab .woocommerce-Tabs-panel--description p',
			]
		  );
		
		$this->end_controls_section();

		$this->start_controls_section(
		 'pure_wc_product_additional_table_sec',
			 [
			   'label' => esc_html__( 'Additional Info Table', 'shopbuild' ),
			   'tab'   => Controls_Manager::TAB_STYLE,
			 ]
		);

		$this->add_control(
		 'pure_wc_product_additional_table_heading_color',
		 [
		   'label'       => esc_html__( 'Heading Color', 'shopbuild' ),
		   'type'     => \Elementor\Controls_Manager::COLOR,
		   'selectors' => [
		   '{{WRAPPER}} .sb-product-details-tab [class*="additional_information"] h2' => 'color: {{VALUE}}',
		   ],
		 ]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'pure_wc_product_additional_table_heading_typo',
			  'label'   => esc_html__( 'Heading Typography ', 'shopbuild' ),
			  'selector' => '{{WRAPPER}} .sb-product-details-tab [class*="additional_information"] h2',
			]
		  );

		
		$this->add_control(
		 'pure_wc_product_additional_table_th',
		 [
		   'label'       => esc_html__( 'Table Title', 'shopbuild' ),
		   'type'     => Controls_Manager::COLOR,
		   'selectors' => [
		   '{{WRAPPER}} .sb-product-details-tab .wc-tab table.shop_attributes tr th' => 'color: {{VALUE}} !important',
		   ],
		 ]
		);

		$this->add_control(
		 'pure_wc_product_additional_table_th_padding',
		   [
			 'label'      => esc_html__( 'Table Title Padding', 'shopbuild' ),
			 'type'       => Controls_Manager::DIMENSIONS,
			 'size_units' => [ 'px', '%', 'em' ],
			 'selectors'  => [
			   '{{WRAPPER}} .sb-product-details-tab .wc-tab table.shop_attributes tr th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
			 ],
		   ]
		 );
		
		 $this->add_group_control(
			 \Elementor\Group_Control_Typography::get_type(),
			 [
			   'name' => 'pure_wc_product_additional_table_th_typo',
			   'label'   => esc_html__( 'Table Title Typo', 'shopbuild' ),
			   'selector' => '{{WRAPPER}} .sb-product-details-tab .wc-tab table.shop_attributes tr th',
			 ]
		);

		// td controls

		$this->add_control(
		 'pure_wc_product_additional_table_td',
		 [
		   'label'       => esc_html__( 'Table Info', 'shopbuild' ),
		   'type'     => Controls_Manager::COLOR,
		   'selectors' => [
		   '{{WRAPPER}} .sb-product-details-tab .wc-tab table.shop_attributes tr td p' => 'color: {{VALUE}} !important',
		   ],
		 ]
		);

		$this->add_control(
		 'pure_wc_product_additional_table_td_padding',
		   [
			 'label'      => esc_html__( 'Table Info Padding', 'shopbuild' ),
			 'type'       => Controls_Manager::DIMENSIONS,
			 'size_units' => [ 'px', '%', 'em' ],
			 'selectors'  => [
			   '{{WRAPPER}} .sb-product-details-tab .wc-tab table.shop_attributes tr td p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important; ',
			 ],
		   ]
		 );
		
		 $this->add_group_control(
			 \Elementor\Group_Control_Typography::get_type(),
			 [
			   'name' => 'pure_wc_product_additional_table_td_typo',
			   'label'   => esc_html__( 'Table Info Typography', 'shopbuild' ),
			   'selector' => '{{WRAPPER}} .sb-product-details-tab .wc-tab table.shop_attributes tr td p ',
			 ]
		);

		$this->end_controls_section();
        

		$this->start_controls_section(
		 'pure_wc_product_details_comment_sec',
			 [
			   'label' => esc_html__( 'Comment Aavater Controls', 'shopbuild' ),
			   'tab'   => Controls_Manager::TAB_STYLE,
			 ]
		);
		

		$this->add_responsive_control(
		 'pure_wc_product_details_comment_avater',
			[
				'label'      => esc_html__( 'Comment Avater', 'shopbuild' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .sb-product-details-comment .commentlist li .comment_container > img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		 );

		$this->add_responsive_control(
			'pure_wc_product_details_comment_avater_width',
			[
				'label' => esc_html__( 'Width', 'shopbuild' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'default' => [
					'size' => 60,
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'range' => [
					'%' => [
						'min' => 5,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sb-product-details-comment .commentlist li .comment_container > img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'pure_wc_product_details_comment_avater_height',
			[
				'label' => esc_html__( 'Height', 'shopbuild' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 60,
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'%' => [
						'min' => 5,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sb-product-details-comment .commentlist li .comment_container > img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'pure_wc_product_details_comment_avater_border',
			[
				'label' => esc_html__( 'Border Radius', 'shopbuild' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .sb-product-details-comment .commentlist li .comment_container > img' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
		 'pure_wc_product_details_comment_rating',
		 [
		   'label'       => esc_html__( 'Rating Color', 'shopbuild' ),
		   'type'     => \Elementor\Controls_Manager::COLOR,
		   'selectors' => [
		   '{{WRAPPER}} .star-rating span, {{WRAPPER}} .star-rating span::before' => 'color: {{VALUE}}',
		   ],
		 ]
		);

		$this->add_control(
		 'pure_wc_product_details_comment_avater_name',
		 [
		   'label'       => esc_html__( 'Username Color', 'shopbuild' ),
		   'type'     => \Elementor\Controls_Manager::COLOR,
		   'selectors' => [
		   	'{{WRAPPER}} .sb-product-details-comment .commentlist li .comment_container p.meta strong' => 'color: {{VALUE}}',
		   ],
		 ]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'pure_wc_product_details_comment_avater_name_typo',
			  'label'   => esc_html__( 'Username Typography', 'shopbuild' ),
			  'selector' => '{{WRAPPER}} .sb-product-details-comment .commentlist li .comment_container p.meta strong',
			]
		  );

		$this->add_control(
		 'pure_wc_product_details_comment_avater_meta',
		 [
		   'label'       => esc_html__( 'Avater Meta', 'shopbuild' ),
		   'type'     => \Elementor\Controls_Manager::COLOR,
		   'selectors' => [
		   	'{{WRAPPER}} .sb-product-details-comment .commentlist li .comment_container p.meta time' => 'color: {{VALUE}}',
		   ],
		 ]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'pure_wc_product_details_comment_avater_meta_typo',
			  'label'   => esc_html__( 'Avater Typography', 'shopbuild' ),
			  'selector' => '{{WRAPPER}} .sb-product-details-comment .commentlist li .comment_container p.meta time',
			]
		  );

		$this->add_control(
		 'pure_wc_product_details_comment_review_text',
		 [
		   'label'       => esc_html__( 'Review Text', 'shopbuild' ),
		   'type'     => \Elementor\Controls_Manager::COLOR,
		   'selectors' => [
		   	'{{WRAPPER}} .sb-product-details-comment .commentlist li .comment_container .description p' => 'color: {{VALUE}}',
		   ],
		 ]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'pure_wc_product_details_comment_review_text_typo',
			  'label'   => esc_html__( 'Review Text Typography', 'shopbuild' ),
			  'selector' => '{{WRAPPER}} .sb-product-details-comment .commentlist li .comment_container .description p',
			]
		  );

		$this->end_controls_section();

		$this->start_controls_section(
		 'pure_wc_product_review_form_sec',
			 [
			   'label' => esc_html__( 'Review Form Controls', 'shopbuild' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			 ]
		);
		
		$this->add_control(
		 'pure_wc_product_review_form_title',
		 [
		   'label'       => esc_html__( 'Review Form Title', 'shopbuild' ),
		   'type'     => Controls_Manager::COLOR,
		   'selectors' => [
		   '{{WRAPPER}} .sb-product-details-comment .comment-reply-title' => 'color: {{VALUE}}',
		   ],
		 ]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'pure_wc_product_review_form_title_typo',
			  'label'   => esc_html__( 'Review Form Typography', 'shopbuild' ),
			  'selector' => '{{WRAPPER}} .sb-product-details-comment .comment-reply-title',
			]
		  );
		
		$this->add_control(
		 'pure_wc_product_review_rating_title',
		 [
		   'label'     	=> esc_html__( 'Review Rating Title', 'shopbuild' ),
		   'type'    	=> Controls_Manager::COLOR,
		   'selectors' 	=> [
		   '{{WRAPPER}} .sb-product-details-comment .comment-form-rating label[for="rating"]' => 'color: {{VALUE}}',
		   ],
		 ]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'pure_wc_product_review_rating_title_typo',
			  'label'   => esc_html__( 'Review Rating Typography', 'shopbuild' ),
			  'selector' => '{{WRAPPER}} .sb-product-details-comment .comment-form-rating label[for="rating"]',
			]
		);
		
		$this->add_control(
		 'pure_wc_product_review_rating_icon',
		 [
		   'label'     	=> esc_html__( 'Review Rating Icon', 'shopbuild' ),
		   'type'    	=> Controls_Manager::COLOR,
		   'selectors' 	=> [
		   '{{WRAPPER}} .sb-product-details-comment .comment-form-rating .woocommerce p.stars a' => 'color: {{VALUE}}',
		   ],
		 ]
		);


		$this->add_control(
		 'pure_wc_product_review_rating_label',
		 [
		   'label'       => esc_html__( 'Review Rating Label', 'shopbuild' ),
		   'type'     => \Elementor\Controls_Manager::COLOR,
		   'selectors' => [
		   '{{WRAPPER}} .sb-product-details-comment .comment-form-comment label' => 'color: {{VALUE}}',
		   ],
		 ]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'pure_wc_product_review_rating_label_typo',
			  'label'   => esc_html__( 'Review Rating Label', 'shopbuild' ),
			  'selector' => '{{WRAPPER}} .sb-product-details-comment .comment-form-comment label',
			]
		  );
		

		$this->end_controls_section();

		$this->pure_wc_input_controls_style('pure_wc_input_control', 'Review Input Controls', '.sb-product-details-comment .comment-form input' , '.sb-product-details-comment .comment-form textarea');

		$this->pure_wc_link_controls_style('pure_wc_input_button', 'Review Button', '.sb-product-details-comment .form-submit input[type="submit"]');
    }


    public function product_review_tab(){
        return null;
    }

    public function product_description_tab(){
        global $product;
        
        return $product->get_description();
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

            if( !$product ){
                return;
            }
            add_filter( 'woocommerce_product_tabs', function( $tabs ){
                $tabs = woocommerce_default_product_tabs();
                if( isset( $tabs['reviews'] ) ) {
                    $tabs['reviews']['callback'] = array( $this, 'product_review_tab' );
                }
                if( isset( $tabs['description'] ) ) {
                    $tabs['description']['callback'] = array( $this, 'product_description_tab' );
                }
                return $tabs;
            }, 9999 );
            pure_wc_get_template( 'single-product/tabs/tabs.php' );
        }else{
            $product = wc_get_product( get_the_ID() );
            if( !$product ){
                return;
            }
            pure_wc_get_template( 'single-product/tabs/tabs.php' );
        }
		
	}
}

$widgets_manager->register( new Pure_Product_Tabs_Widget() );