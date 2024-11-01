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
class Pure_Checkout_Billing_Widget extends Pure_Wc_Base_Widget {

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
		return 'checkout-billing';
	}

	/**
	 * Get widget checkout-billing.
	 *
	 * Retrieve button widget checkout-billing.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget checkout-billing.
	 */
	public function get_title() {
		return esc_html__( 'Checkout Billing', 'shopbuild' );
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
		'pure_checkout_billing_title',
		 [
			'label'       => esc_html__( 'Title', 'shopbuild' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__( 'Billing Details', 'shopbuild' ),
			'placeholder' => esc_html__( 'Your Text', 'shopbuild' ),
			'label_block' => true,
		 ]
		);
      
        

        $this->end_controls_section();
    }

    protected function register_style_controls(){

		$this->pure_wc_basic_style_controls('pure_checkout_billing_title', 'Title', '.pure-checkout-billing-heading');
		$this->pure_wc_basic_style_controls('pure_checkout_billing_input_label', 'Input Label', '.sb-billing-wrapper label');

		$this->pure_wc_input_controls_style('pure_wc_input_control', 'Input Controls', '.sb-billing-wrapper input[type="text"], .sb-billing-wrapper input[type="email"], .sb-billing-wrapper input[type="tel"], .sb-billing-wrapper input[type="url"],.sb-billing-wrapper input[type="password"], .sb-billing-wrapper .select2-container--default .select2-selection--single', '.sb-billing-wrapper textarea');
        
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

        $checkout = new \WC_Checkout();
		$args = [
			'checkout' => $checkout,
			'pure_checkout_billing_title' => $settings['pure_checkout_billing_title'],
		];
		?>
        <?php if( Plugin::instance()->editor->is_edit_mode() ): ?>
            <div class="woocommerce">
                <form>
                    <?php pure_wc_get_template('checkout/form-billing.php', $args); ?>
                </form>
            </div>
        <?php else: ?>
            <?php 
            if ( $checkout->get_checkout_fields() ) : 
             pure_wc_get_template('checkout/form-billing.php', $args);
            endif; 
            ?>
        <?php endif; ?>
		<?php
        
	}
}

$widgets_manager->register( new Pure_Checkout_Billing_Widget() );