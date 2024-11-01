<?php

use Elementor\Controls_Manager;


use PureWCShopbuild\Elementor\Controls\Group_Control_PWCSGradient;
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
class Pure_Product_Related_Widget extends Pure_Wc_Base_Widget {

	use PureWCSingle, PureWCCommonStyles, PureWCActionFilter;

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
		return 'single-product-related';
	}

	/**
	 * Get widget related.
	 *
	 * Retrieve button widget related.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget related.
	 */
	public function get_title() {
		return esc_html__( 'Single Product Related', 'shopbuild' );
	}


	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){

		$this->pure_wc_product_feature(true);

        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Content Controls', 'shopbuild'),
            ]
        );

		// controls for related heading
		$this->add_control(
			'pure_wc_related_heading',
			[
				'label' => esc_html__('Related Heading', 'shopbuild'),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__('Related Products', 'shopbuild'),
				'placeholder' => esc_html__('Type your title here', 'shopbuild'),
			]
		);

		$this->add_control(
		 'pure_wc_related_heading_tag',
		 [
		  'label'   => esc_html__( 'Tag', 'shopbuild' ),
		   'type'    => \Elementor\Controls_Manager::CHOOSE,
		   'options' => [
				'h1'  => [
					'title' => esc_html__( 'H1', 'shopbuild' ),
					'icon'  => 'eicon-editor-h1',
				],
				'h2'  => [
					'title' => esc_html__( 'H2', 'shopbuild' ),
					'icon'  => 'eicon-editor-h2',
				],
				'h3'  => [
					'title' => esc_html__( 'H3', 'shopbuild' ),
					'icon'  => 'eicon-editor-h3',
				],
				'h4'  => [
					'title' => esc_html__( 'H4', 'shopbuild' ),
					'icon'  => 'eicon-editor-h4',
				],
				'h5'  => [
					'title' => esc_html__( 'H5', 'shopbuild' ),
					'icon'  => 'eicon-editor-h5',
				],
				'h6'  => [
					'title' => esc_html__( 'H5', 'shopbuild' ),
					'icon'  => 'eicon-editor-h5',
				],
		   	],
		   'default' => 'h4',
		   'toggle'  => true,
		 ]
		);

		$this->add_responsive_control(
		 'pure_wc_related_heading_alignment',
		 [
		  'label'   => esc_html__( 'Section Label', 'shopbuild' ),
		   'type'    => \Elementor\Controls_Manager::CHOOSE,
		   'options' => [
			 'start'   => [
			   'title' => esc_html__( 'Left', 'shopbuild' ),
			   'icon'  => 'eicon-text-align-left',
		   ],
			 'center' => [
			 'title' => esc_html__( 'Center', 'shopbuild' ),
			 'icon'  => 'eicon-text-align-center',
			 ],
			 'end'  => [
			   'title' => esc_html__( 'Right', 'shopbuild' ),
			   'icon'  => 'eicon-text-align-right',
			 ],
		   ],
		   'selectors' => [
			 '{{WRAPPER}} .sb-product-related-heading' => 'text-align: {{VALUE}};',
		   ],
		   'default' => 'center',
		   'toggle'  => true,
		 ]
		);
		
		// _posts_per_page
		$this->add_control(
		 '_posts_per_page',
		 [
		   'label'   => esc_html__( 'Post Per Page', 'shopbuild' ),
		   'type'    => \Elementor\Controls_Manager::NUMBER,
		   'min'     => -100000,
		   'max'     => 100000,
		   'step'    => 2,
		   'default' => -1,
		 ]
		);

		// orderby
		$this->add_control(
			'_orderby',
			[
				'label' => esc_html__('Order By', 'shopbuild'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'date' => esc_html__('Date', 'shopbuild'),
					'title' => esc_html__('Title', 'shopbuild'),
					'rand' => esc_html__('Random', 'shopbuild'),
					'ID' => esc_html__('ID', 'shopbuild'),
				],
				'default' => 'date',
			]
		);

		// order
		$this->add_control(
			'_order',
			[
				'label' => esc_html__('Order', 'shopbuild'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'ASC' => esc_html__('ASC', 'shopbuild'),
					'DESC' => esc_html__('DESC', 'shopbuild'),
				],
				'default' => 'DESC',
			]
		);

        $this->end_controls_section();

		$this->pure_wc_columns('pure_wc_related_products', 'Columns');
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
				'label' => esc_html__('Typography', 'shopbuild'),
				'selector' => '{{WRAPPER}} .sb-product-price-wrapper',
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
		
		$this->end_controls_section();

		$this->pure_wc_link_controls_style('product_action_btn', 'Product - Action Button', '.sb-product-action-item .sb-product-action-btn, .sb-product-action-item .added_to_cart.wc-forward', '.sb-product-action-item .sb-product-action-btn:hover, .sb-product-action-item .added_to_cart.wc-forward:hover');

		$this->pure_wc_basic_style_controls('pure_wc_related_title', 'Related Title', '.sb-product-related-heading');
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
        $settings = $this->get_settings_for_display();
        
		$new_args = $this->pure_wc_product_feature_options($settings);

		$columns = $this->pure_row_cols_show($settings, 'pure_wc_related_products');

		$related_title = $settings['pure_wc_related_heading'];

        if( Plugin::instance()->editor->is_edit_mode() ){
            $product = wc_get_product(pure_wc_get_last_product_id());
            

            $related_product_demo = array(1, 2, 3, 4);

        ?>
			<section class="woocommerce related products">
				<?php if(!empty($related_title)) : ?>
				<div class="pure-wc-related-product-heading">
					<?php
						printf( '<%1$s class="sb-product-related-heading">%2$s</%1$s>', esc_attr($settings['pure_wc_related_heading_tag']), wp_kses($related_title, pure_wc_get_kses_extended_ruleset()));
					?>
				</div>
				<?php endif; ?>

				<?php $related_class = $settings['_posts_per_page'] > 4 ? 'tp-woo-related-product-related-active' : ' sb-row '.$columns; ?>	

				<div class="<?php echo esc_attr($related_class); ?>">
		
					<?php for ( $i = 1; $i<=$settings['_posts_per_page']; $i++ ) : ?>

						<?php pure_wc_product_style($new_args); ?>
						
					<?php endfor; ?>
					</div>
			</section>
        <?php
        }else{
            $product = wc_get_product( get_the_ID() );
            if ( ! $product ) { return; }
            $args = [
                'posts_per_page' => $settings['_posts_per_page'],
                'columns' => 4,
                'orderby' => $settings['_orderby'],
                'order' => $settings['_order'],
            ];
            if ( ! empty( $settings['_posts_per_page'] ) ) {
                $args['posts_per_page'] = $settings['_posts_per_page'];
            }
            if ( ! empty( $settings['_columns'] ) ) {
                $args['columns'] = $settings['_columns'];
            }
			
            // Get related Product
            $args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), 
            $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );
            $args['related_products'] = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );
		
        
            if ( $args['related_products'] ) : ?>
                <section class="related products">
					<?php if(!empty($related_title)) : ?>
					<div class="pure-wc-related-product-heading">
						<?php
							printf( '<%1$s class="sb-product-related-heading">%2$s</%1$s>', esc_attr($settings['pure_wc_related_heading_tag']), wp_kses($related_title, pure_wc_get_kses_extended_ruleset()));
						?>
					</div>
					<?php endif; ?>
					<?php 
						$related_class = count($args['related_products']) > 4 ? 'tp-woo-related-product-related-active' : ' sb-row '.$columns;
					?>	
					<div class="<?php echo esc_attr($related_class); ?>">
						<?php foreach ( $args['related_products'] as $related_product ) : ?>
							<?php
								$post_object = get_post( $related_product->get_id() );
			
								setup_postdata( $GLOBALS['post'] =& $post_object ); 
			
								if($settings['product_style'] > 0){
									pure_wc_product_style($new_args);
								}else{
									wc_get_template_part( 'content', 'product' );
								}
								
							?>
						<?php endforeach; ?>
					</div>
                </section>
                <?php
            endif;
            
            wp_reset_postdata();
        }
		
	}
}

$widgets_manager->register( new Pure_Product_Related_Widget() );