<?php


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
class Pure_Product_Thumbnail_Widget extends Pure_Wc_Base_Widget {

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
		return 'single-product-thumbnail';
	}

	/**
	 * Get widget thumbnail.
	 *
	 * Retrieve button widget thumbnail.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget thumbnail.
	 */
	public function get_title() {
		return esc_html__( 'Single Product Thumbnail', 'shopbuild' );
	}


	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){
       $this->start_controls_section(
		'pure_wc_product_thumbnail_sec',
			[
			  'label' => esc_html__( 'Thumbnails Layout', 'shopbuild' ),
			  'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
	   );
	   
	   $this->add_control(
		'pure_wc_product_thumbnail_layout',
		[
		  'label'   => esc_html__( 'Select Layout', 'shopbuild' ),
		  'type' => \Elementor\Controls_Manager::SELECT,
		  'options' => [
			'default'  => esc_html__( 'Default', 'shopbuild' ),
			'left_sidebar'  => esc_html__( 'Left Sidebar', 'shopbuild' ),
			'right_sidebar'  => esc_html__( 'Right Sidebar', 'shopbuild' ),
			'top_sidebar'  => esc_html__( 'Top Sidebar', 'shopbuild' ),
			'grid_view'  => esc_html__( 'Grid View', 'shopbuild' ),
			'list_view'  => esc_html__( 'List View', 'shopbuild' ),
		  ],
		  'default' => 'default',
		]
	   );

	   $this->add_responsive_control(
		'pure_wc_product_thumbnail_grid_gap',
		[
		  'label'   => esc_html__( 'Column Gap', 'shopbuild' ),
		  'type'    => \Elementor\Controls_Manager::NUMBER,
		  'min'     => 0,
		  'max'     => 1000,
		  'step'    => 1,
		  'default' => 10,
		  'selectors' => [
			'{{WRAPPER}} .sb-product-details-thumbnail .sb-row' => '--sb-gutter-x: {{VALUE}}px;',
		  ],
		  'condition' => [
			'pure_wc_product_thumbnail_layout' => 'grid_view',
		  ],
		]
	   );
	   $this->add_responsive_control(
		'pure_wc_product_thumbnail_grid_row_gap',
		[
			'label'   => esc_html__( 'Row Gap', 'shopbuild' ),
			'type'    => \Elementor\Controls_Manager::NUMBER,
			'min'     => 0,
			'max'     => 1000,
			'step'    => 1,
			'default' => 10,
			'selectors' => [
			'{{WRAPPER}} .sb-product-details-thumbnail .sb-row' => 'row-gap: {{VALUE}}px;',
			],
			'condition' => [
				'pure_wc_product_thumbnail_layout' => 'grid_view',
		  	],
		]
	   );

	   
	   $this->end_controls_section();

	   $this->pure_wc_columns('pure_wc_product_single_grid_columns', 'Grid Columns', ['pure_wc_product_thumbnail_layout' => 'grid_view']);
	   
    }

    protected function register_style_controls(){

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
					   '{{WRAPPER}} .sb-product-details-thumbnail span.onsale' => 'background-color: {{VALUE}}',
				   ],
			   ]
		   );
		   
		   $this->add_control(
			   'pure_wc_product_sale_color',
			   [
				   'label' => esc_html__( 'Product Sale Color', 'shopbuild' ),
				   'type' => \Elementor\Controls_Manager::COLOR,
				   'selectors' => [
					   '{{WRAPPER}} .sb-product-details-thumbnail span.onsale, {{WRAPPER}} .sb-product-details-thumbnail span.onsale' => 'color: {{VALUE}}',
				   ],
			   ]
		   );
   
		   $this->add_group_control(
			   Elementor\Group_Control_Typography::get_type(),
			   [
				   'name' => 'pure_wc_product_sale_typography',
				   'label' => esc_html__('Typography', 'shopbuild'),
				   'selector' => '{{WRAPPER}} .sb-product-details-thumbnail span.onsale, {{WRAPPER}} .sb-product-details-thumbnail span.onsale',
			   ]
		   );

		   $this->end_controls_section();

		   $this->start_controls_section(
			'pure_wc_product_list_style',
				[
				  'label' => esc_html__( 'List Style', 'shopbuild' ),
				  'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				]
		   );
		   
		   $this->add_responsive_control(
			'pure_wc_product_list_item_margin',
			  [
				'label'      => esc_html__( 'Margin', 'shopbuild' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
				  '{{WRAPPER}} .sb-product-details-thumbnail .pure-wc-product-single-list .woocommerce-product-gallery__image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        global $product;


		$args = array(
			'single_style'	=> !empty($settings['pure_wc_product_thumbnail_layout']) ? $settings['pure_wc_product_thumbnail_layout'] : 'default',
		);

		if($settings['pure_wc_product_thumbnail_layout'] == 'grid_view'){
			$cols = $this->pure_row_cols_show($settings, 'pure_wc_product_single_grid_columns');

			$args['columns_class'] = $cols;
		}

		$single_style = isset($settings['pure_wc_product_thumbnail_layout']) ? $settings['pure_wc_product_thumbnail_layout'] : 'default';
		$is_vertical = false;

		if($single_style == 'left_sidebar') {
			$layout_class = 'pure-single-product-gallery-vertical-sidebar left_side ' ;
			$is_vertical = true;
		}elseif($single_style == 'right_sidebar') {
			$layout_class = 'pure-single-product-gallery-vertical-sidebar right_side';
			$is_vertical = true;
		}elseif($single_style == 'top_sidebar') {
			$layout_class = 'pure-single-product-gallery-top-sidebar';
		}else {
			$layout_class = 'pure-single-product-gallery-default';
		}

        if( Plugin::instance()->editor->is_edit_mode() ){
            $product = wc_get_product( pure_wc_get_last_product_id() );
            $columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
            $post_thumbnail_id = $product->get_image_id();
            $wrapper_classes   = apply_filters(
                'woocommerce_single_product_image_gallery_classes',
                array(
                    'woocommerce-product-gallery',
                    'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
                    'woocommerce-product-gallery--columns-' . absint( $columns ),
					'images'
                )
            );

            ?>

			<?php if($single_style == 'grid_view') : ?>
				<div class="sb-product-details-thumbnail">
					<div class="pure-wc-product-single-grid sb-row <?php echo esc_attr($args['columns_class']); ?>">
						<?php
							if ( $post_thumbnail_id ) {
								$html = wc_get_gallery_image_html( $post_thumbnail_id, true );
							} else {
								$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
								$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'shopbuild' ) );
								$html .= '</div>';
							}
	
							for ($i=0; $i < 4; $i++) {
								print wp_kses(apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ), pure_wc_get_kses_extended_ruleset());
							}
	
						?>
					</div>
				</div>

			<?php elseif($single_style == 'list_view') : ?>
				<div class="sb-product-details-thumbnail">
					<div class="pure-wc-product-single-list ">
						<?php
							if ( $post_thumbnail_id ) {
								$html = wc_get_gallery_image_html( $post_thumbnail_id, true );
							} else {
								$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
								$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'shopbuild' ) );
								$html .= '</div>';
							}
	
							for ($i=0; $i < 4; $i++) {
								print wp_kses(apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ), pure_wc_get_kses_extended_ruleset());
							}
	
						?>
					</div>
				</div>

			<?php else : ?>

            <div class="sb-product-details-thumbnail <?php echo esc_attr($layout_class); ?>  <?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>">
                <figure class="woocommerce-product-gallery__wrapper">
                    <?php
                    if ( $post_thumbnail_id ) {
                        $html = wc_get_gallery_image_html( $post_thumbnail_id, true );
                    } else {
                        $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
                        $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'shopbuild' ) );
                        $html .= '</div>';
                    }

                    print wp_kses(apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ), pure_wc_get_kses_extended_ruleset());

                    ?>
                </figure>

				<ol class="flex-control-nav edit-mode">
					<?php for ($i=0; $i < 4; $i++): ?>
					<li>
						<?php echo wp_get_attachment_image($post_thumbnail_id); ?>
					</li>
					<?php endfor; ?>
				</ol>
            </div>
			<?php endif; ?>

            <?php
        }else{
			$product_id = get_the_ID()? get_the_ID() : (isset($_SESSION['product_id'])? sanitize_text_field( wp_unslash($_SESSION['product_id'])) : 0);
            $product = wc_get_product( $product_id );

			if( empty($product) ){
				return;
			}

			$post_thumbnail_id = $product->get_image_id();
			$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
			$wrapper_classes   = apply_filters(
                'woocommerce_single_product_image_gallery_classes',
                array(
                    'woocommerce-product-gallery',
                    'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
                    'woocommerce-product-gallery--columns-' . absint( $columns ),
					'images'
                )
            );
			$attachment_ids = $product->get_gallery_image_ids();
			global $product;
			
			?>
			<?php if(is_single()) : ?>
			<div class="sb-product-details-thumbnail">
				<?php pure_wc_get_template( 'single-product/product-image.php', $args ); ?>
			</div>
			<?php else :
			if($single_style == 'grid_view' || $single_style == 'list_view'){?>
				<div class="sb-product-details-thumbnail">
					<?php pure_wc_get_template( 'single-product/product-image.php', $args ); ?>
				</div>
			<?php
				return;
			}
			$slider_main_active = !empty($attachment_ids) ? 'sb-product-quickview-main-thumb-slider' : '';
    
			$slider_thumb_active = !empty($attachment_ids) ? ' sb-product-quickview-nav-slider' : 'sb-d-none';	
			?>
			<div class="sb-product-details-thumbnail <?php echo esc_attr($layout_class); ?>  <?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>">
				<div class="sb-thumbnails-wrapper">
					<div class="sb-thumbnails pure-quickview-thumbnails <?php echo esc_attr($slider_main_active); ?>">
						<?php

							if ( $attachment_ids && $product->get_image_id() ) {
								$post_thumbnail_id = $product->get_image_id();
								if ( $post_thumbnail_id ) {
									$html = sprintf( '<div class="sb-thumbnail" data-id="%s">', esc_attr($post_thumbnail_id) );
									$html .= wp_get_attachment_image( $post_thumbnail_id, 'full' );
									$html .= '</div>';
								} else {
									$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
									$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'shopbuild' ) );
									$html .= '</div>';
								}
								print wp_kses_post(apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ));
								
								foreach ( $attachment_ids as $attachment_id ) {
									$html = sprintf( '<div class="sb-thumbnail" data-id="%s">', esc_attr($attachment_id) );
									$html .= wp_get_attachment_image( $attachment_id, 'full' );
									$html .= '</div>';
									print wp_kses_post(apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id )); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
								}
							}else{
								$post_thumbnail_id = $product->get_image_id();
								if ( $post_thumbnail_id ) {
									$html = '<div class="sb-thumbnail">';
									$html .= wp_get_attachment_image( $post_thumbnail_id, 'full' );
									$html .= '</div>';
								} else {
									$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
									$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'shopbuild' ) );
									$html .= '</div>';
								}
								print wp_kses_post(apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ));
							}
							
						?>
					</div>


					<div class="sb-thumbnails <?php echo esc_attr($slider_thumb_active); ?>" data-vertical="<?php echo esc_attr($is_vertical); ?>">
						<?php
							$attachment_ids = $product->get_gallery_image_ids();

							if ( $attachment_ids && $product->get_image_id() ) {
								$post_thumbnail_id = $product->get_image_id();
								if ( $post_thumbnail_id ) {
									$html = sprintf( '<div class="sb-thumbnail" data-id="%s">', esc_attr($post_thumbnail_id) );
									$html .= wp_get_attachment_image( $post_thumbnail_id, 'full' );
									$html .= '</div>';
								} else {
									$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
									$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'shopbuild' ) );
									$html .= '</div>';
								}
								print wp_kses_post(apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ));
								
								foreach ( $attachment_ids as $attachment_id ) {
									$html = sprintf( '<div class="sb-thumbnail" data-id="%s">', esc_attr($attachment_id) );
									$html .= wp_get_attachment_image( $attachment_id, 'full' );
									$html .= '</div>';
									print wp_kses_post(apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id )); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
								}
							}else{
								$post_thumbnail_id = $product->get_image_id();
								if ( $post_thumbnail_id ) {
									$html = '<div class="sb-thumbnail">';
									$html .= wp_get_attachment_image( $post_thumbnail_id, 'full' );
									$html .= '</div>';
								} else {
									$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
									$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'shopbuild' ) );
									$html .= '</div>';
								}
								print wp_kses_post(apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ));
							}
							
						?>
					</div>
				</div>
            </div>
			<?php endif; ?>
			<?php
        }
	}
}

$widgets_manager->register( new Pure_Product_Thumbnail_Widget() );