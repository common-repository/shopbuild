<?php

use Elementor\Controls_Manager;

use PureWCShopbuild\Elementor\Controls\Group_Control_PWCSGradient;

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
class Pure_Products_Categories_Widget extends Pure_Wc_Base_Widget {

	use PureWCArchive, PureWCCommonStyles;

    /**
	 * Category ancestors.
	 *
	 * @var array
	 */
	protected $cat_ancestors;

	/**
	 * Current Category.
	 *
	 * @var bool
	 */
	protected $current_cat;

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
		return 'sidebar-products-categories';
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
		return esc_html__( 'Sidebar Products Categories', 'shopbuild' );
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
			'sb_widget_title',
			 [
				'label'       => esc_html__( 'Title', 'shopbuild' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'ShopBuild Widget Title', 'shopbuild' ),
				'placeholder' => esc_html__( 'Your Text', 'shopbuild' ),
				'label_block' => true
			 ]
		);

        $this->add_control(
			'show_product_count',
			[
				'label' => esc_html__( 'Show product counts', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'shopbuild' ),
				'label_off' => esc_html__( 'Hide', 'shopbuild' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_control(
			'show_as_dropdown',
			[
				'label' => esc_html__( 'Show as dropdown', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'shopbuild' ),
				'label_off' => esc_html__( 'Hide', 'shopbuild' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_control(
			'show_children_only',
			[
				'label' => esc_html__( 'Show children only', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'shopbuild' ),
				'label_off' => esc_html__( 'Hide', 'shopbuild' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_control(
			'hide_empty',
			[
				'label' => esc_html__( 'Hide empty', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'shopbuild' ),
				'label_off' => esc_html__( 'Hide', 'shopbuild' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_control(
			'show_hierarchical',
			[
				'label' => esc_html__( 'Show hierarchical', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'shopbuild' ),
				'label_off' => esc_html__( 'Hide', 'shopbuild' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_control(
			'orderby',
			[
				'label' => esc_html__( 'Order by', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'multiple' => true,
				'options' => [
					'name'  => esc_html__( 'Name', 'shopbuild' ),
					'order' => esc_html__( 'Category order', 'shopbuild' )
				],
				'default' => array( 'name' ),
			]
		);

        $this->add_control(
			'max_depth',
			[
				'label' => esc_html__( 'Max depth', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 10,
				'step' => 1,
				'default' => 0,
			]
		);
		
		$this->add_control(
			'_number_of_categories',
			 [
				'label'       => esc_html__( 'Number of categores to show', 'shopbuild' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'default'     => 8,
				'label_block' => true
			 ]
		);
		$this->add_control(
			'_include_categories',
			[
				'label' => esc_html__( 'Include categories', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $this->get_woo_categories(),
				'multiple' => true,
			]
		);
		$this->add_control(
			'_exclude_categories',
			[
				'label' => esc_html__( 'Exclude categories', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $this->get_woo_categories(),
				'multiple' => true,
			]
		);

        $this->end_controls_section();
    }

    protected function register_style_controls(){

		$this->start_controls_section(
			'pure_wc_search_styling',
			[
				'label' => esc_html__('Widget - Title', 'shopbuild'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_PWCSGradient::get_type(),
			[
				'name' => 'pure_wc_search_advs',
				'label' => esc_html__('Color', 'shopbuild'),
				'selector' => '{{WRAPPER}} .tp-el-title ',
			]
		);

		$this->add_group_control(
			Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pure_wc_search_typography',
				'label' => esc_html__('Typography', 'shopbuild'),
				'selector' => '{{WRAPPER}} .tp-el-title ',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .tp-el-title',
			]
		);
		$this->add_responsive_control(
			'pure_wc_search_padding',
			[
				'label' => esc_html__('Padding', 'shopbuild'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .tp-el-title ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'pure_wc_search_margin',
			[
				'label' => esc_html__('Margin', 'shopbuild'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .tp-el-title ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->end_controls_section();

		$this->pure_wc_link_controls_style('link_controls', 'List - Style', '.tp-el-list li a', '.tp-el-list li a:hover');
        
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
    
        global $wp_query, $post;
        $settings = $this->get_settings_for_display();

		$count              = isset( $settings['show_product_count'] ) ? $settings['show_product_count'] : $settings['count']['std'];
		$hierarchical       = isset( $settings['show_hierarchical'] ) ? $settings['show_hierarchical'] : $settings['hierarchical']['std'];
		$show_children_only = isset( $settings['show_children_only'] ) ? $settings['show_children_only'] : $settings['show_children_only']['std'];
		$dropdown           = isset( $settings['show_as_dropdown'] ) ? $settings['show_as_dropdown'] : $settings['dropdown']['std'];
		$orderby            = isset( $settings['orderby'] ) ? $settings['orderby'] : $settings['orderby']['std'];
		$hide_empty         = isset( $settings['hide_empty'] ) ? $settings['hide_empty'] : $settings['hide_empty']['std'];
		$dropdown_args      = array(
			'hide_empty' => $hide_empty,
		);
		$list_args          = array(
			'show_count'   => $count,
			'hierarchical' => $hierarchical,
			'taxonomy'     => 'product_cat',
			'hide_empty'   => $hide_empty,
			'number'       => $settings['_number_of_categories'],
			'include'      => $settings['_include_categories'],
			'exclude'      => $settings['_exclude_categories'],
		);
		$max_depth          = absint( isset( $settings['max_depth'] ) ? $settings['max_depth'] : $settings['max_depth']['std'] );

		$list_args['menu_order'] = false;
		$dropdown_args['depth']  = $max_depth;
		$list_args['depth']      = $max_depth;

		if ( 'order' === $orderby ) {
			$list_args['orderby']      = 'meta_value_num';
			$dropdown_args['orderby']  = 'meta_value_num';
			$list_args['meta_key']     = 'order'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			$dropdown_args['meta_key'] = 'order'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
		}

		$this->current_cat   = false;
		$this->cat_ancestors = array();

		if ( is_tax( 'product_cat' ) ) {
			$this->current_cat   = $wp_query->queried_object;
			$this->cat_ancestors = get_ancestors( $this->current_cat->term_id, 'product_cat' );

		} elseif ( is_singular( 'product' ) ) {
			$terms = wc_get_product_terms(
				$post->ID,
				'product_cat',
				apply_filters(
					'woocommerce_product_categories_widget_product_terms_args',
					array(
						'orderby' => 'parent',
						'order'   => 'DESC',
					)
				)
			);

			if ( $terms ) {
				$main_term           = apply_filters( 'woocommerce_product_categories_widget_main_term', $terms[0], $terms );
				$this->current_cat   = $main_term;
				$this->cat_ancestors = get_ancestors( $main_term->term_id, 'product_cat' );
			}
		}

		// Show Siblings and Children Only.
		if ( $show_children_only && $this->current_cat ) {
			if ( $hierarchical ) {
				$include = array_merge(
					$this->cat_ancestors,
					array( $this->current_cat->term_id ),
					get_terms(
						array(
							'taxonomy'		=> 'product_cat',
							'fields'       => 'ids',
							'parent'       => 0,
							'hierarchical' => true,
							'hide_empty'   => false,
						)
					),
					get_terms(
						array(
							'taxonomy'		=> 'product_cat',
							'fields'       => 'ids',
							'parent'       => $this->current_cat->term_id,
							'hierarchical' => true,
							'hide_empty'   => false,
						)
					)
				);
				// Gather siblings of ancestors.
				if ( $this->cat_ancestors ) {
					foreach ( $this->cat_ancestors as $ancestor ) {
						$include = array_merge(
							$include,
							get_terms(
								array(
									'taxonomy'		=> 'product_cat',
									'fields'       => 'ids',
									'parent'       => $ancestor,
									'hierarchical' => false,
									'hide_empty'   => false,
								)
							)
						);
					}
				}
			} else {
				// Direct children.
				$include = get_terms(
					array(
						'taxonomy'		=> 'product_cat',
						'fields'       => 'ids',
						'parent'       => $this->current_cat->term_id,
						'hierarchical' => true,
						'hide_empty'   => false,
					)
				);
			}

			$list_args['include']     = implode( ',', $include );
			$dropdown_args['include'] = $list_args['include'];

			if ( empty( $include ) ) {
				return;
			}
		} elseif ( $show_children_only ) {
			$dropdown_args['depth']        = 1;
			$dropdown_args['child_of']     = 0;
			$dropdown_args['hierarchical'] = 1;
			$list_args['depth']            = 1;
			$list_args['child_of']         = 0;
			$list_args['hierarchical']     = 1;
		}


		if(!empty($settings['sb_widget_title'])) :
			echo "<h3 class='sb-sidebar-product-widget-title tp-el-title'>" . esc_html($settings['sb_widget_title']) . "  </h3>";
		endif; 

		if ( $dropdown ) {
			echo "<div class='sb-sidebar-product-category-select tp-el-section'>";
			?>
			

			<?php
			wc_product_dropdown_categories(
				apply_filters(
					'woocommerce_product_categories_widget_dropdown_args',
					wp_parse_args(
						$dropdown_args,
						array(
							'show_count'         => $count,
							'hierarchical'       => $hierarchical,
							'show_uncategorized' => 0,
							'selected'           => $this->current_cat ? $this->current_cat->slug : '',
						)
					)
				)
			);
			echo "</div>";

			wp_enqueue_script( 'selectWoo' );
			wp_enqueue_style( 'select2' );

			wc_enqueue_js(
				"
				jQuery( '.dropdown_product_cat' ).on( 'change', function() {
					if ( jQuery(this).val() != '' ) {
						var this_page = '';
						var home_url  = '" . esc_js( home_url( '/' ) ) . "';
						if ( home_url.indexOf( '?' ) > 0 ) {
							this_page = home_url + '&product_cat=' + jQuery(this).val();
						} else {
							this_page = home_url + '?product_cat=' + jQuery(this).val();
						}
						location.href = this_page;
					} else {
						location.href = '" . esc_js( wc_get_page_permalink( 'shop' ) ) . "';
					}
				});

				if ( jQuery().selectWoo ) {
					var wc_product_cat_select = function() {
						jQuery( '.dropdown_product_cat' ).selectWoo( {
							placeholder: '" . esc_js( __( 'Select a category', 'shopbuild' ) ) . "',
							minimumResultsForSearch: 5,
							width: '100%',
							allowClear: true,
							language: {
								noResults: function() {
									return '" . esc_js( _x( 'No matches found', 'enhanced select', 'shopbuild' ) ) . "';
								}
							}
						} );
					};
					wc_product_cat_select();
				}
			"
			);
		} else {
			include_once WC()->plugin_path() . '/includes/walkers/class-wc-product-cat-list-walker.php';

			$list_args['walker']                     = new WC_Product_Cat_List_Walker();
			$list_args['title_li']                   = '';
			$list_args['pad_counts']                 = 1;
			$list_args['show_option_none']           = __( 'No product categories exist.', 'shopbuild' );
			$list_args['current_category']           = ( $this->current_cat ) ? $this->current_cat->term_id : '';
			$list_args['current_category_ancestors'] = $this->cat_ancestors;
			$list_args['max_depth']                  = $max_depth;

			echo '<ul class="sb-sidebar-product-categories tp-el-list sb-sidebar-checkbox">';

			wp_list_categories( apply_filters( 'woocommerce_product_categories_widget_args', $list_args ) );

			echo '</ul>';
		}
	}
}

$widgets_manager->register( new Pure_Products_Categories_Widget() );