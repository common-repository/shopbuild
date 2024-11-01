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
class Pure_Cart_Cross_Sell_Widget extends Pure_Wc_Base_Widget {

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
		return 'cart-cross-sell';
	}

	/**
	 * Get widget cart-table.
	 *
	 * Retrieve button widget cart-table.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget cart-table.
	 */
	public function get_title() {
		return esc_html__( 'Cart Cross Sell', 'shopbuild' );
	}


	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){
		$this->start_controls_section(
		 'section_id',
			 [
			   'label' => esc_html__( 'Cross Sell Contents', 'shopbuild' ),
			   'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			 ]
		);
		
		$this->add_control(
			'pure_cross_sell_heading',
			 [
				'label'       => esc_html__( 'Cross Sell Heading', 'shopbuild' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'You may be interested in...', 'shopbuild' ),
				'placeholder' => esc_html__( 'Your Text', 'shopbuild' ),
				'label_block' => true,
			 ]
		);

		$this->add_responsive_control(
			'pure_cross_sell_heading_alignment',
			[
			 'label'   => esc_html__( 'Alignment', 'shopbuild' ),
			  'type'    => \Elementor\Controls_Manager::CHOOSE,
			  'options' => [
				'left'   => [
				  'title' => esc_html__( 'Left', 'shopbuild' ),
				  'icon'  => 'eicon-text-align-left',
			  ],
				'center' => [
				'title' => esc_html__( 'Center', 'shopbuild' ),
				'icon'  => 'eicon-text-align-center',
				],
				'right'  => [
				  'title' => esc_html__( 'Right', 'shopbuild' ),
				  'icon'  => 'eicon-text-align-right',
				],
			  ],
			  'default' => 'center',
			  'toggle'  => true,
			  'selectors' => [
				'{{WRAPPER}} .sb-el-cart-cross-sell-heading' => 'text-align: {{VALUE}}',
			  ],
			]
		   );
		
		$this->end_controls_section();
		$this->pure_wc_columns('pure_cross_sell_col', 'Cross Sell Columns');
    }

    protected function register_style_controls(){
		$this->pure_wc_basic_style_controls('pure_cross_sell', 'Heading', '.sb-el-cart-cross-sell-heading');
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

		$columns_data = $this->pure_row_cols_show($settings, 'pure_cross_sell_col');

        $args = array(
			'pure_cross_sell_col' => $columns_data,
			'pure_cross_sell_heading' => $settings['pure_cross_sell_heading'],
        );


        if( is_null(WC()->cart) ){
            return;
        }
		?>
		<div class="pure-wc-cart-cross-sell">
            <?php do_action( 'pure_wc_cross_sell_display', $args ); ?>
        </div>
		<?php
	}
}

$widgets_manager->register( new Pure_Cart_Cross_Sell_Widget() );