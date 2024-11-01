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
class Pure_Product_Review_Widget extends Pure_Wc_Base_Widget {

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
		return 'single-product-reviews';
	}

	/**
	 * Get widget reviews.
	 *
	 * Retrieve button widget reviews.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget reviews.
	 */
	public function get_title() {
		return esc_html__( 'Single Product Reviews', 'shopbuild' );
	}


	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){

    }

    protected function register_style_controls(){

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
            ?>
			<div class="sb-product-details-comment-widget sb-product-details-comment">
				<ol class="commentlist">
					<li class="review byuser comment-author-admin bypostauthor even thread-even depth-1" id="li-comment-4">
						<div id="comment-4" class="comment_container">
							<img alt="" src="<?php echo esc_url(PURE_WC_SHOPBUILD_PUBLIC_URL . '/img/avatar.jpg'); ?>" class="avatar avatar-60 photo" height="60" width="60" loading="lazy" decoding="async">
							<div class="comment-text">
								<div class="star-rating" role="img" aria-label="Rated 2 out of 5">
									<span style="width:40%">Rated <strong class="rating">2</strong> out of 5</span>
								</div>
								<p class="meta">
									<strong class="woocommerce-review__author">John Doe </strong>
									<span class="woocommerce-review__dash">–</span><time class="woocommerce-review__published-date" datetime="2023-05-27T10:00:39+00:00">May 27, 2023</time>
								</p>
								<div class="description">
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s</p>
								</div>
							</div>
						</div>
					</li><!-- #comment-## -->
					<li class="review byuser comment-author-admin bypostauthor even thread-even depth-1" id="li-comment-4">
						<div id="comment-4" class="comment_container">
							<img alt="" src="<?php echo esc_url(PURE_WC_SHOPBUILD_PUBLIC_URL . '/img/avatar.jpg'); ?>" class="avatar avatar-60 photo" height="60" width="60" loading="lazy" decoding="async">
							<div class="comment-text">
								<div class="star-rating" role="img" aria-label="Rated 2 out of 5">
									<span style="width:40%">Rated <strong class="rating">2</strong> out of 5</span>
								</div>
								<p class="meta">
									<strong class="woocommerce-review__author">John Doe </strong>
									<span class="woocommerce-review__dash">–</span><time class="woocommerce-review__published-date" datetime="2023-05-27T10:00:39+00:00">May 27, 2023</time>
								</p>
								<div class="description">
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s</p>
								</div>
							</div>
						</div>
					</li><!-- #comment-## -->
					<li class="review byuser comment-author-admin bypostauthor even thread-even depth-1" id="li-comment-4">
						<div id="comment-4" class="comment_container">
							<img alt="" src="<?php echo esc_url(PURE_WC_SHOPBUILD_PUBLIC_URL . '/img/avatar.jpg'); ?>" class="avatar avatar-60 photo" height="60" width="60" loading="lazy" decoding="async">
							<div class="comment-text">
								<div class="star-rating" role="img" aria-label="Rated 2 out of 5">
									<span style="width:40%">Rated <strong class="rating">2</strong> out of 5</span>
								</div>
								<p class="meta">
									<strong class="woocommerce-review__author">John Doe </strong>
									<span class="woocommerce-review__dash">–</span><time class="woocommerce-review__published-date" datetime="2023-05-27T10:00:39+00:00">May 27, 2023</time>
								</p>
								<div class="description">
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s</p>
								</div>
							</div>
						</div>
					</li><!-- #comment-## -->
				</ol>
        	</div>
			<?php
        }else{
            $product = wc_get_product( get_the_ID() );
			if( !$product ){
				return;
			}
	
			$args = array ('post_type' => 'product', 'post_id' => $product->get_id());
			$comments = get_comments( $args );
			?>
			<div class="sb-product-details-comment-widget sb-product-details-comment">
				<ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ), $comments ); ?>
				</ol>
			</div>
			<?php
        }
			
		?>
        <?php
	}
}

$widgets_manager->register( new Pure_Product_Review_Widget() );