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

class Pure_Products_Tags_Widget extends Pure_Wc_Base_Widget {

	use PureWCArchive, PureWCCommonStyles;

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
		return 'sidebar-products-tags';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve button widget title.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Sidebar Products Tags', 'shopbuild' );
	}


	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}

	protected function register_content_controls(){
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'shopbuild' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'_number_of_tags',
				[
					'label'	=> __('Number of tags to show', 'shopbuild'),
					'type'	=> \Elementor\Controls_Manager::NUMBER,
					'default'	=> 5,
					'min'	=> 5,
					'max'	=> 15
				]
			);
		$this->end_controls_section();
	}

    protected function register_style_controls(){

		$this->pure_wc_link_controls_style('tag_item', 'Tag - Style', '.tp-el-tag a', '.tp-el-tag a:hover');
        
    }

    /**
	 * Returns topic count text.
	 *
	 * @since 3.4.0
	 * @param int $count Count text.
	 * @return string
	 */
	public function topic_count_text( $count ) {
		/* translators: %s: product count */
		return sprintf( _n( '%s product', '%s products', $count, 'shopbuild' ), number_format_i18n( $count ) );
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
	   ?>
	   <div class="pure-sidebar-widget">
		<div class="products-tags-cloud tp-el-tag">
			<?php
			wp_tag_cloud(
				apply_filters(
					'woocommerce_product_tag_cloud_widget_args',
					array(
						'taxonomy'                  => 'product_tag',
						'topic_count_text_callback' => array( $this, 'topic_count_text' ),
						'number'	=> $settings['_number_of_tags']
					)
				)
			);
			?>
		</div>
	   </div>
	   <?php
	}
}

$widgets_manager->register( new Pure_Products_Tags_Widget() );