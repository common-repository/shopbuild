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
class Pure_Checkout_Shipping_Widget extends Pure_Wc_Base_Widget {

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
		return 'checkout-shipping';
	}

	/**
	 * Get widget checkout-shipping.
	 *
	 * Retrieve button widget checkout-shipping.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget checkout-shipping.
	 */
	public function get_title() {
		return esc_html__( 'Checkout Shipping', 'shopbuild' );
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
            '_form_title',
            [
                'label'         => esc_html__( 'Shipping Title', 'shopbuild' ),
				'type'          => Controls_Manager::TEXTAREA,
				'default'       => esc_html__( 'Shipping to a different address?', 'shopbuild' ),
				'placeholder'   => esc_html__( 'Type your title here', 'shopbuild' ),
            ]
        );

        $this->end_controls_section();
    }

    protected function register_style_controls(){

        $this->pure_wc_basic_style_controls('checkout_shipping_title', 'Title', '.pure-wc-checkout-shipping-title');
        
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
			'form_title' => $settings['_form_title'] 
		);
		?>
		<?php if( Plugin::instance()->editor->is_edit_mode() ): ?>
			<div class="woocommerce">
				<form>
				<?php 
					pure_wc_get_template('checkout/form-shipping.php', $args);
				?>
				</form>
			</div>
		<?php else: ?>
			<?php 
				if( is_null(WC()->cart) ){
					return;
				}	

				pure_wc_get_template('checkout/form-shipping.php', $args);
			?>
		<?php endif; ?>
		<?php
        
	}
}

$widgets_manager->register( new Pure_Checkout_Shipping_Widget() );