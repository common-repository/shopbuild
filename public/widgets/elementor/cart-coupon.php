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
class Pure_Cart_Coupon_Widget extends Pure_Wc_Base_Widget {

	use PureWCCart, PureWCCommonStyles;

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
		return 'cart-coupon';
	}

	/**
	 * Get widget cart-coupon.
	 *
	 * Retrieve button widget cart-coupon.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget cart-coupon.
	 */
	public function get_title() {
		return esc_html__( 'Cart Coupon', 'shopbuild' );
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
            '_apply_button_ttile',
            [
                'label'         => esc_html__( 'Apply Button Title', 'shopbuild' ),
				'type'          => Controls_Manager::TEXT,
				'default'       => esc_html__( 'Apply Coupon', 'shopbuild' ),
				'placeholder'   => esc_html__( 'Type your title here', 'shopbuild' ),
				'label_block'   => true,
            ]
        );
        $this->add_control(
            '_coupon_label_title',
            [
                'label'         => esc_html__( 'Coupon Label', 'shopbuild' ),
				'type'          => Controls_Manager::TEXT,
				'default'       => esc_html__( 'Cooupon', 'shopbuild' ),
				'placeholder'   => esc_html__( 'Type your title here', 'shopbuild' ),
				'label_block'   => true,
				'condition'     => [
					'pure_coupon_style' => 'default',
				]
            ]
        );
        
		$this->add_control(
		 'pure_coupon_style',
		 [
		   'label'   => esc_html__( 'Coupon Style', 'shopbuild' ),
		   'type' => \Elementor\Controls_Manager::SELECT,
		   'options' => [
			 'coupon_toggle_inline'  => esc_html__( 'Toggle Inline', 'shopbuild' ),
			 'coupon_inline'  => esc_html__( 'Inline', 'shopbuild' ),
			 'coupon_toggle'  => esc_html__( 'Toggle', 'shopbuild' ),
			 'default'  => esc_html__( 'Default', 'shopbuild' ),
		   ],
		   'default' => 'default',
		 ]
		);

		$this->add_control(
		 'pure_coupon_toggle_title',
		 [
		   'label'       => esc_html__( 'Coupon Title', 'shopbuild' ),
		   'type'        => \Elementor\Controls_Manager::TEXTAREA,
		   'rows'        => 10,
		   'default'     => esc_html__( 'Have a Coupon?', 'shopbuild' ),
		   'placeholder' => esc_html__( 'Your Text', 'shopbuild' ),
		   'condition'   => [
			 'pure_coupon_style' => ['coupon_toggle', 'coupon_toggle_inline'],
		   ],
		 ]
		);

        $this->end_controls_section();
    }

    protected function register_style_controls(){

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

		$this->pure_wc_input_controls_style('pure_wc_input_control', 'Review Input Controls', '.sb-cart-coupon-wrapper input#pure_coupon_code');

		$this->pure_wc_link_controls_style('product_action_btn', 'Product - Action Button', '.sb-cart-coupon-wrapper button#pure_coupon_submit', '.sb-cart-coupon-wrapper button#pure_coupon_submit:hover');
        
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

		$coupon_style = $settings['pure_coupon_style'];

		if($coupon_style == 'coupon_toggle' || $coupon_style == 'coupon_toggle_inline'){
			$coupon_title = $settings['pure_coupon_toggle_title'];
		}else{
			$coupon_title = $settings['_coupon_label_title'];
		}


		$args = array(
			'button_title' => $settings['_apply_button_ttile'],
			'coupon_title' => $coupon_title,
			'coupon_style' => $coupon_style,
		);
		if( is_null(WC()->cart) ){
			return;
		}

		if( Plugin::instance()->editor->is_edit_mode() ): ?>
			<div class="sb-cart-coupon-wrapper sb-cart-coupon-wrapper-2">
				<?php pure_wc_get_template('cart/cart-coupon.php', $args); ?>
			</div>
		<?php else:
			if(WC()->cart->is_empty()){
				return;
			}
			if ( wc_coupons_enabled() ) { ?>

				<div class="sb-cart-coupon-wrapper sb-cart-coupon-wrapper-2">
					<?php pure_wc_get_template('cart/cart-coupon.php', $args); ?>
				</div>
				<?php
			}
		endif;
	}
}

$widgets_manager->register( new Pure_Cart_Coupon_Widget() );