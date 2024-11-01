<?php
/**
 * Elementor button widget.
 *
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.3
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use Elementor\Controls_Manager;

use Elementor\Plugin;
class Pure_Product_Tags_Widget extends Pure_Wc_Base_Widget {

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
		return 'single-product-tags';
	}

	/**
	 * Get widget tags.
	 *
	 * Retrieve button widget tags.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget tags.
	 */
	public function get_title() {
		return esc_html__( 'Single Product Tags', 'shopbuild' );
	}


	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){
        $this->start_controls_section(
            'pure_wc_product_tag_sec',
            [
                'label' => esc_html__('Content Controls', 'shopbuild'),
            ]
        );

		$this->add_control(
			'pure_wc_product_tag_label',
			 [
				'label'       => esc_html__( 'Label', 'shopbuild' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Tags', 'shopbuild' ),
				'placeholder' => esc_html__( 'Your Text', 'shopbuild' ),
				'label_block' => true,
			 ]
		);

        $this->end_controls_section();
    }

    protected function register_style_controls(){


        $this->start_controls_section(
			'pure_wc_product_tag_style_sec',
			   [
				   'label' => esc_html__( 'Product - Tags', 'shopbuild' ),
				   'tab'   => Controls_Manager::TAB_STYLE,
			   ]
		   );
		   
		   $this->add_control(
			'pure_wc_product_tag_title_color',
			   [
				   'label'       	=> esc_html__( 'Text Color', 'shopbuild' ),
				   'type'     		=> \Elementor\Controls_Manager::COLOR,
				   'selectors' 	=> [
					   '{{WRAPPER}} .sb-product-details-tags span' => 'color: {{VALUE}}',
				   ],
			   ]
		   );
		   
		   $this->add_control(
			'pure_wc_product_tag_item_color',
			   [
				   'label'       => esc_html__( 'Tag Text Color', 'shopbuild' ),
				   'type'     	=> \Elementor\Controls_Manager::COLOR,
				   'selectors' 	=> [
					   '{{WRAPPER}} .sb-product-details-tags span a' => 'color: {{VALUE}}',
				   ],
			   ]
		   );
		   
		   $this->add_control(
			'pure_wc_product_tag_item_hover_color',
			   [
				   'label'       => esc_html__( 'Tag Hover Color', 'shopbuild' ),
				   'type'     	=> \Elementor\Controls_Manager::COLOR,
				   'selectors' 	=> [
					   '{{WRAPPER}} .sb-product-details-tags span a:hover' => 'color: {{VALUE}}',
				   ],
			   ]
		   );
   
		   $this->add_group_control(
			   \Elementor\Group_Control_Typography::get_type(),
			   [
				 'name' => 'pure_wc_product_tag_typo',
				 'label'   => esc_html__( 'Typography', 'shopbuild' ),
				 'selector' => '{{WRAPPER}} .sb-product-details-tags span, {{WRAPPER}} .sb-product-details-tags span a',
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
		$tag_label = !empty($settings['pure_wc_product_tag_label']) ? $settings['pure_wc_product_tag_label'] : '';
        global $product;

        if( Plugin::instance()->editor->is_edit_mode() ){
			?>
			<div class="sb-product-details-tags">
				<span class="tagged_as"><?php if(!empty($tag_label)){ echo wp_kses($tag_label, pure_wc_get_kses_extended_ruleset()); }; ?> 
					<a href="/cap" rel="tag">Cap</a>, 
					<a href="/clothing" rel="tag">Clothing</a>, 
					<a href="/decor" rel="tag">Decor</a>, 
					<a href="/hat" rel="tag">Hat</a>, 
					<a href="/hoodie" rel="tag">Hoodie</a>
				</span>
			</div>
			<?php
        }else{
			$product_id = get_the_ID()? get_the_ID() : (isset($_SESSION['product_id'])? sanitize_text_field( wp_unslash($_SESSION['product_id'])) : 0);
            $product = wc_get_product( $product_id );
			if( empty($product) ){
				return;
			}
			// Translators: %s is the tag label.
			$tag_label = sprintf( _n( '%s Tag', '%s Tags', count( $product->get_tag_ids() ), 'shopbuild' ), $tag_label );

			echo wp_kses_post( wc_get_product_tag_list( 
				$product->get_id(), 
				', ', 
				'<div class="sb-product-details-tags"><span class="tagged_as">' . $tag_label . ' ', 
				'</span></div>' 
			));

        }
	}
}

$widgets_manager->register( new Pure_Product_Tags_Widget() );