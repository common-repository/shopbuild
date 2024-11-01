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
class Pure_Cart_Table_Widget extends Pure_Wc_Base_Widget {

	use PureWCCart, PureWCCommonStyles, Pure_WC_Common_Style;

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
		return 'cart-table';
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
		return esc_html__( 'Cart Table', 'shopbuild' );
	}


	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){
        $this->start_controls_section(
            'show_cross_content_sec',
            [
                'label' => esc_html__('Content Controls', 'shopbuild'),
            ]
        );

        $this->switch_control('show_coupon', 'Show coupon');
        $this->switch_control('show_cart_totals', 'Show cart totals');
        $this->switch_control('show_cross_sell', 'Show cross sell');

        $this->end_controls_section();
		$this->start_controls_section(
		'section_id',
			[
				'label' => esc_html__( 'Cross Sell Contents', 'shopbuild' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'show_cross_sell' => 'yes',
				],
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

		$this->table_style();
        
		$this->coupon_label_style();

		$this->pure_wc_input_controls_style('pure_wc_input_control', 'Review Input Controls', '.sb-cart-coupon-wrapper input#pure_coupon_code');

		$this->pure_wc_link_controls_style('product_action_btn', 'Product - Coupon Button', '.sb-cart-coupon-wrapper button#pure_coupon_submit', '.sb-cart-coupon-wrapper button#pure_coupon_submit:hover');
		$this->pure_wc_link_controls_style('product_update_btn', 'Product - Update Button', '.sb-cart-coupon-wrapper button[name="update_cart"]', '.sb-cart-coupon-wrapper button[name="update_cart"]:hover');
		$this->pure_wc_link_controls_style('product_check_btn', 'Product - Checkout Button', '.sb-cart-total a.checkout-button', '.sb-cart-total a.checkout-button:hover');

		$this->start_controls_section(
		'product_cart_checkout_sec',
			[
				'label' => esc_html__( 'Checkout Table', 'shopbuild' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
		'product_checkout_table_border',
		[
			'label'       => esc_html__( 'Border Color', 'shopbuild' ),
			'type'     => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
			'{{WRAPPER}} .sb-cart-total table td, {{WRAPPER}} .sb-cart-total table th' => 'border-color: {{VALUE}}',
			],
		]
		);

		$this->add_control(
		'pure_wc_checkout_table_caption',
		[
			'label'       => esc_html__( 'Checkout Table Title', 'shopbuild' ),
			'type'     => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
			'{{WRAPPER}} .sb-cart-total h2' => 'color: {{VALUE}}',
			],
		]
		);

		$this->add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name' => 'pure_wc_checkout_table_caption_typo',
			'label'   => esc_html__( 'Checkout Table Title Typography', 'shopbuild' ),
			'selector' => '{{WRAPPER}} .sb-cart-total h2',
		]
		);
		
		$this->add_control(
		'pure_wc_checkout_table_head',
		[
			'label'       => esc_html__( 'Checkout Heading Color', 'shopbuild' ),
			'type'     => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
			'{{WRAPPER}} .sb-cart-total table th' => 'color: {{VALUE}}',
			],
		]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pure_wc_checkout_table_head_typo',
				'label'   => esc_html__( 'Table Heading Typography', 'shopbuild' ),
				'selector' => '{{WRAPPER}} .sb-cart-total table th',
			]
			);

			$this->add_control(
			'pure_wc_checkout_table_td',
			[
				'label'       => esc_html__( 'Checkout Data Color', 'shopbuild' ),
				'type'     => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
				'{{WRAPPER}} .sb-cart-total table td, {{WRAPPER}} .sb-cart-total #shipping_method li label' => 'color: {{VALUE}}',
				],
			]
			);
	


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pure_wc_checkout_table_td_typo',
				'label'   => esc_html__( 'Table Data Typography', 'shopbuild' ),
				'selector' => '{{WRAPPER}} .sb-cart-total table td, {{WRAPPER}} .sb-cart-total #shipping_method li label',
			]
		);
		
		$this->end_controls_section();
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
            'show_coupon' => $settings['_show_coupon'],
			'pure_cross_sell_col' => $columns_data,
			'pure_cross_sell_heading' => $settings['pure_cross_sell_heading'],
			'show_cart_totals' => $settings['_show_cart_totals'],
			'show_cross_sell' => $settings['_show_cross_sell']
        );

		$class = 'coupon-none';

		if( $settings['_show_coupon'] == 'yes' ){
			$class = '';
		}

        if( is_null(WC()->cart) ){
            return;
        }
		?>
		<div class="pure-wc-cart sb-cart-table <?php echo esc_attr($class); ?>">
			<?php
			if(WC()->cart->is_empty()){
				wc_get_template('cart/cart-empty.php');
			}else{
				pure_wc_get_template('cart/cart.php', $args);
			}?>
		</div>
		<?php
	}
}

$widgets_manager->register( new Pure_Cart_Table_Widget() );