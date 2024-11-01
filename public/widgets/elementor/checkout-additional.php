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
class Pure_Checkout_Additional_Widget extends Pure_Wc_Base_Widget {

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
		return 'checkout-additional';
	}

	/**
	 * Get widget checkout-additional.
	 *
	 * Retrieve button widget checkout-additional.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget checkout-additional.
	 */
	public function get_title() {
		return esc_html__( 'Checkout Additional', 'shopbuild' );
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

        $this->end_controls_section();
    }

    protected function register_style_controls(){
		$this->start_controls_section(
			'pure_wc_billing_label_sec',
				[
				  'label' => esc_html__( 'Input Label', 'shopbuild' ),
				  'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				]
		   );
		   $this->add_control(
			'pure_wc_billing_label_title',
			[
			  'label'       => esc_html__( 'Label Color', 'shopbuild' ),
			  'type'     => \Elementor\Controls_Manager::COLOR,
			  'selectors' => [
			  '{{WRAPPER}} .sb-billing-wrapper label' => 'color: {{VALUE}}',
			  ],
			]
		   );
		   
		   $this->add_group_control(
			   \Elementor\Group_Control_Typography::get_type(),
			   [
				 'name' => 'pure_wc_billing_label_typo',
				 'label'   => esc_html__( 'Label Typography', 'shopbuild' ),
				 'selector' => '{{WRAPPER}} .sb-billing-wrapper label',
			   ]
			 );
		   
		   $this->end_controls_section();

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
		?>
		<?php if( Plugin::instance()->editor->is_edit_mode() ): ?>
		<div class="woocommerce">
			<form>
				<div class="sb-checkout-additional sb-billing-wrapper">
					<?php wc_get_template('checkout/note.php'); ?>
				</div>
			</form>
		</div>

		<?php else: ?>
			<?php if ( $checkout->get_checkout_fields() ) : 
					if( is_null(WC()->cart) ){
						return;
					}	
				?>
				<div class="sb-checkout-additional sb-billing-wrapper">
					<?php wc_get_template('checkout/note.php'); ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<?php
        
	}
}

$widgets_manager->register( new Pure_Checkout_Additional_Widget() );