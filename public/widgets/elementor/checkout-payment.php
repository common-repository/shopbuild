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
class Pure_Checkout_Payment_Widget extends Pure_Wc_Base_Widget {

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
		return 'checkout-payment';
	}

	/**
	 * Get widget checkout-payment.
	 *
	 * Retrieve button widget checkout-payment.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget checkout-payment.
	 */
	public function get_title() {
		return esc_html__( 'Checkout Payment', 'shopbuild' );
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
            '_order_btn_text',
            [
                'label'         => esc_html__( 'Make Payment', 'shopbuild' ),
				'type'          => Controls_Manager::TEXT,
				'default'       => esc_html__( 'Make Payment', 'shopbuild' ),
				'placeholder'   => esc_html__( 'Type your title here', 'shopbuild' )
            ]
        );

        $this->end_controls_section();
    }

    protected function register_style_controls(){

        $this->start_controls_section(
		 'pure_wc_payment_sec',
			 [
			   'label' => esc_html__( 'Payment Style', 'shopbuild' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			 ]
		);
		
		$this->add_control(
		 'pure_wc_payment_title',
		 [
		   'label'       => esc_html__( 'Title', 'shopbuild' ),
		   'type'     => \Elementor\Controls_Manager::COLOR,
		   'selectors' => [
		   '{{WRAPPER}} .sb-checkout-payment .wc_payment_methods .wc_payment_method label' => 'color: {{VALUE}}',
		   ],
		 ]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'pure_wc_payment_title_typo',
			  'label'   => esc_html__( 'Title Typography', 'shopbuild' ),
			  'selector' => '{{WRAPPER}} .sb-checkout-payment .wc_payment_methods .wc_payment_method label',
			]
		);


		$this->add_control(
		 'pure_wc_payment_title_desc',
		 [
		   'label'       => esc_html__( 'Description', 'shopbuild' ),
		   'type'     => \Elementor\Controls_Manager::COLOR,
		   'selectors' => [
		   '{{WRAPPER}} .sb-checkout-payment .wc_payment_methods .wc_payment_method .payment_box p' => 'color: {{VALUE}}',
		   
		   ],
		 ]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
			   'name'     => 'pure_wc_payment_box',
			   'label'    => esc_html__( 'Payment Box', 'shopbuild' ),
			   'types'    => [ 'classic', 'gradient', 'video' ],
			   'selector' => '{{WRAPPER}} .sb-checkout-payment .wc_payment_methods .wc_payment_method .payment_box p, {{WRAPPER}} .sb-checkout-payment .wc_payment_methods .wc_payment_method .payment_box::after',
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' 		=> 'pure_wc_payment_title_desc_typo',
			  'label'   	=> esc_html__( 'Description Typography', 'shopbuild' ),
			  'selector' 	=> '{{WRAPPER}} .sb-checkout-payment .wc_payment_methods .wc_payment_method .payment_box p, {{WRAPPER}} .sb-checkout-payment .wc_payment_methods .wc_payment_method .payment_box::after',
			]
		);

		$this->add_group_control(
		 \Elementor\Group_Control_Border::get_type(),
		 [
		   'name'     => 'pure_wc_payment_title_desc_border',
		   'label'    => esc_html__( 'Border Style', 'shopbuild' ),
		   'selector' => '{{WRAPPER}} .sb-checkout-payment .wc_payment_methods',
		 ]
		);

		
		$this->end_controls_section();

		$this->start_controls_section(
		 'pure_wc_policy_text_sec',
			 [
			   'label' => esc_html__( 'Policy Text Control', 'shopbuild' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			 ]
		);
		
		$this->add_control(
		 'pure_wc_policy_text',
		 [
		   'label'       => esc_html__( 'Policy Text', 'shopbuild' ),
		   'type'     => \Elementor\Controls_Manager::COLOR,
		   'selectors' => [
		   '{{WRAPPER}} .sb-checkout-payment .woocommerce-privacy-policy-text p' => 'color: {{VALUE}}',
		   ],
		 ]
		);
		
		$this->add_control(
		 'pure_wc_policy_text_inner',
		 [
		   'label'       => esc_html__( 'Policy Link Text', 'shopbuild' ),
		   'type'     => \Elementor\Controls_Manager::COLOR,
		   'selectors' => [
		   '{{WRAPPER}} .sb-checkout-payment .woocommerce-privacy-policy-text p a' => 'color: {{VALUE}}',
		   ],
		 ]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'pure_wc_policy_text_typo',
			  'label'   => esc_html__( 'Policy Typography', 'shopbuild' ),
			  'selector' => '{{WRAPPER}} .sb-checkout-payment .woocommerce-privacy-policy-text p',
			]
		  );

		$this->end_controls_section();
		
		$this->pure_wc_link_controls_style('product_action_btn', 'Product - Coupon Button', '.sb-checkout-payment button[type="submit"]', '.sb-checkout-payment button[type="submit"]:hover');
        
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
        $args = array(
            'order_button_text' => $settings['_order_btn_text']
        );
		?>
		<?php if( Plugin::instance()->editor->is_edit_mode() ): ?>
        <div id="order_review" class="woocommerce-page woocommerce-checkout sb-checkout-payment">
            <div class="woocommerce">
                <form>
                <div class="woocommerce-checkout-review-order">
                <div id="payment" class="woocommerce-checkout-payment">
                    <ul class="wc_payment_methods payment_methods methods">
                        <li class="wc_payment_method payment_method_cod">
                            <input id="payment_method_cod" type="radio" class="input-radio" name="payment_method" value="cod" data-order_button_text="" />
                            <label for="payment_method_cod"><?php esc_html_e('Cash on delivery', 'shopbuild'); ?></label>
                            <div class="payment_box payment_method_cod" style="display:none;">
                                <p><?php esc_html_e('Pay with cash upon delivery.', 'shopbuild'); ?></p>
                            </div>
                        </li>
                    </ul>
                    <div class="form-row place-order">
                        <noscript>
                            <?php
                            /* translators: $1 and $2 opening and closing emphasis tags respectively */
                            printf( esc_html__( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'shopbuild' ), '<em>', '</em>' );
                            ?>
                            <br/><button type="submit" class="button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'shopbuild' ); ?>"><?php esc_html_e( 'Update totals', 'shopbuild' ); ?></button>
                        </noscript>

                        <div class="woocommerce-terms-and-conditions-wrapper">
                            <div class="woocommerce-privacy-policy-text">
                                <p><?php esc_html_e('Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our', 'shopbuild'); ?> <a href="#" class="woocommerce-privacy-policy-link" target="_blank"><?php esc_html_e('privacy policy', 'shopbuild'); ?></a>.</p>
                            </div>
			            </div>
						<?php
							$terms = (isset( $_POST['terms'], $_POST['woocommerce-process-checkout-nonce']) && wp_verify_nonce( sanitize_text_field( wp_unslash($_POST['woocommerce-process-checkout-nonce'])), 'woocommerce-process_checkout' )) ? sanitize_text_field( wp_unslash($_POST['terms']) ) : '';
						?>
                        <p class="form-row validate-required">
                            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                            <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', $terms ), true ); ?> id="terms" />
                                <span class="woocommerce-terms-and-conditions-checkbox-text"><?php wc_terms_and_conditions_checkbox_text(); ?></span>&nbsp;<abbr class="required" title="<?php esc_attr_e( 'required', 'shopbuild' ); ?>">*</abbr>
                            </label>
                            <input type="hidden" name="terms-field" value="1" />
							<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
                        </p>

                        <?php echo wp_kses(apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="button alt' . esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ) . '" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $settings['_order_btn_text'] ) . '" data-value="' . esc_attr( $settings['_order_btn_text'] ) . '">' . esc_html( $settings['_order_btn_text'] ) . '</button>' ), pure_wc_get_kses_extended_ruleset());?>
                    </div>
                </div>
                </div>
                </form>
            </div>
        </div>
		<?php else: ?>
			<div class="sb-checkout-payment">
				<?php pure_wc_get_template('checkout/payment.php', $args); ?>  
			</div>
		<?php endif; ?>
		<?php
        
	}
}

$widgets_manager->register( new Pure_Checkout_Payment_Widget() );