<?php
use Elementor\Controls_Manager;




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
class Pure_Checkout_Existing_Widget extends Pure_Wc_Base_Widget {

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
		return 'checkout-existing-login';
	}

	/**
	 * Get widget checkout-coupon.
	 *
	 * Retrieve button widget checkout-coupon.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget checkout-coupon.
	 */
	public function get_title() {
		return esc_html__( 'Checkout Existing Login', 'shopbuild' );
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
				'placeholder'   => esc_html__( 'Type your title here', 'shopbuild' )
            ]
        );

		$this->add_control(
            '_update_button_title',
            [
                'label'         => esc_html__( 'Update Cart Button Title', 'shopbuild' ),
				'type'          => Controls_Manager::TEXT,
				'default'       => esc_html__( 'Update Cart', 'shopbuild' ),
				'placeholder'   => esc_html__( 'Type your title here', 'shopbuild' )
            ]
        );
        

        $this->end_controls_section();
    }

    protected function register_style_controls(){


		$this->start_controls_section(
		 'checkout_coupon_sec',
			 [
			   'label' => esc_html__( 'Checkout - Coupon', 'shopbuild' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			 ]
		);
		
		$this->add_group_control(
		   \Elementor\Group_Control_Background::get_type(),
		   [
			  'name'     => 'checkout_coupon_bg',
			  'label'   => esc_html__( 'Coupon Background', 'shopbuild' ),
			  'types'    => [ 'classic', 'gradient', 'video' ],
			  'selector' => '{{WRAPPER}} .sb-checkout-coupon .woocommerce-info',
		   ]
		 );
		
		
		 $this->add_group_control(
		  \Elementor\Group_Control_Border::get_type(),
		  [
			'name'     => 'checkout_coupon_border',
			'label'    => esc_html__( 'Coupon Border', 'shopbuild' ),
			'selector' => '{{WRAPPER}} .sb-checkout-coupon .woocommerce-info',
		  ]
		 );

		 $this->add_control(
		  'checkout_coupon_margin',
			[
			  'label'      => esc_html__( 'Coupon Margin', 'shopbuild' ),
			  'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			  'size_units' => [ 'px', '%', 'em' ],
			  'selectors'  => [
				'{{WRAPPER}} .sb-checkout-coupon .woocommerce-info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			  ],
			]
		  );

		  $this->add_control(
		   'checkout_coupon_padding',
			 [
			   'label'      => esc_html__( 'Coupon Padding', 'shopbuild' ),
			   'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			   'size_units' => [ 'px', '%', 'em' ],
			   'selectors'  => [
				 '{{WRAPPER}} .sb-checkout-coupon .woocommerce-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			   ],
			 ]
		   );

		$this->end_controls_section();

		$this->start_controls_section(
		 'checkout_coupon_text_sec',
			 [
			   'label' => esc_html__( 'Coupon Text', 'shopbuild' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			 ]
		);
		
		$this->add_control(
		 'checkout_coupon_text_color',
		 [
		   'label'       => esc_html__( 'Color', 'shopbuild' ),
		   'type'     => \Elementor\Controls_Manager::COLOR,
		   'selectors' => [
		   '{{WRAPPER}} .sb-checkout-coupon .woocommerce-info' => 'color: {{VALUE}}',
		   ],
		 ]
		);

		$this->add_control(
		 'checkout_coupon_text_inner_color',
		 [
		   'label'       => esc_html__( 'Link Text Color', 'shopbuild' ),
		   'type'     => \Elementor\Controls_Manager::COLOR,
		   'selectors' => [
		   '{{WRAPPER}} .sb-checkout-coupon .woocommerce-info .showcoupon' => 'color: {{VALUE}}',
		   '{{WRAPPER}} .sb-checkout-coupon .woocommerce-info a.showcoupon' => 'border-color: {{VALUE}}',
		   ],
		 ]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'checkout_coupon_text_inner_typo',
			  'label'   => esc_html__( 'Coupon Typography', 'shopbuild' ),
			  'selector' => '{{WRAPPER}} .sb-checkout-coupon .woocommerce-info',
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

		$message = esc_html__( 'If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the Billing section.', 'shopbuild' );
		$redirect =  wc_get_checkout_url();
		$hidden = true;
        
		?>
		<?php if(pure_wc_is_elementor_edit()): ?>
		<div class="sb-checkout-existing-login sb-checkout-payment">
			<div class="woocommerce-form-login-toggle">
				<div class="woocommerce-info"><?php echo esc_html__(' Returning customer?', 'shopbuild'); ?> <a href="#" class="showlogin"><?php echo esc_html__('Click here to login', 'shopbuild'); ?></a></div>
			</div>
			<div class="woocommerce-form woocommerce-form-login login" <?php echo ( $hidden ) ? 'style="display:none;"' : ''; ?>>
				<?php do_action( 'woocommerce_login_form_start' ); ?>

				<?php echo wp_kses(( $message ) ? wpautop( wptexturize( $message ) ) : '', pure_wc_get_kses_extended_ruleset());  ?>

				<p class="form-row form-row-first">
					<label for="username"><?php esc_html_e( 'Username or email', 'shopbuild' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="text" class="input-text" name="username" id="username" autocomplete="username" />
				</p>
				<p class="form-row form-row-last">
					<label for="password"><?php esc_html_e( 'Password', 'shopbuild' ); ?>&nbsp;<span class="required">*</span></label>
					<input class="input-text woocommerce-Input" type="password" name="password" id="password" autocomplete="current-password" />
				</p>
				<div class="clear"></div>

				<?php do_action( 'woocommerce_login_form' ); ?>

				<p class="form-row">
					<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
						<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'shopbuild' ); ?></span>
					</label>
					<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
					<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ); ?>" />
					<button class="woocommerce-button button woocommerce-form-login__submit<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="login" value="<?php esc_attr_e( 'Login', 'shopbuild' ); ?>"><?php esc_html_e( 'Login', 'shopbuild' ); ?></button>
				</p>
				<p class="lost_password">
					<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'shopbuild' ); ?></a>
				</p>

				<div class="clear"></div>

				<?php do_action( 'woocommerce_login_form_end' ); ?>
			</div>
        </div>
		<?php else: 
			if ( is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) {
				return;
			}	
		?>
			<div class="sb-checkout-existing-login sb-checkout-payment">
			<div class="woocommerce-form-login-toggle">
				<div class="woocommerce-info"><?php echo esc_html__(' Returning customer?', 'shopbuild'); ?> <a href="#" class="showlogin"><?php echo esc_html__('Click here to login', 'shopbuild'); ?></a></div>
			</div>
			<div class="woocommerce-form woocommerce-form-login login" <?php echo ( $hidden ) ? 'style="display:none;"' : ''; ?>>
				<?php do_action( 'woocommerce_login_form_start' ); ?>

				<?php echo wp_kses_post( ( $message ) ? wpautop( wptexturize( $message ) ) : '' );  ?>

				<p class="form-row form-row-first">
					<label for="username"><?php esc_html_e( 'Username or email', 'shopbuild' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="text" class="input-text" name="username" id="username" autocomplete="username" />
				</p>
				<p class="form-row form-row-last">
					<label for="password"><?php esc_html_e( 'Password', 'shopbuild' ); ?>&nbsp;<span class="required">*</span></label>
					<input class="input-text woocommerce-Input" type="password" name="password" id="password" autocomplete="current-password" />
				</p>
				<div class="clear"></div>

				<?php do_action( 'woocommerce_login_form' ); ?>

				<p class="form-row">
					<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
						<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'shopbuild' ); ?></span>
					</label>
					<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
					<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ); ?>" />
					<button class="woocommerce-button button woocommerce-form-login__submit<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="login" value="<?php esc_attr_e( 'Login', 'shopbuild' ); ?>"><?php esc_html_e( 'Login', 'shopbuild' ); ?></button>
				</p>
				<p class="lost_password">
					<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'shopbuild' ); ?></a>
				</p>

				<div class="clear"></div>

				<?php do_action( 'woocommerce_login_form_end' ); ?>
			</div>
        </div>
		<?php
		endif; 
	}
}

$widgets_manager->register( new Pure_Checkout_Existing_Widget() );