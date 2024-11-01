<?php

use Elementor\Controls_Manager;

use Elementor\Plugin;
use PureWCShopbuild\Elementor\Controls\Group_Control_PWCSGradient;
use Automattic\WooCommerce\Internal\ProductAttributesLookup\Filterer;


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
class Pure_Products_Attribute_Filter_Widget extends Pure_Wc_Base_Widget {

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
		return 'sidebar-attribute-filter';
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
		return esc_html__( 'Sidebar Attribute Filter', 'shopbuild' );
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
			'products_attributes',
			[
				'label' => esc_html__( 'Products Attribute', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $this->wc_available_attributes()
			]
		);

		$this->add_control(
			'pure_wc_attribute_style',
			[
				'label' => esc_html__( 'Attribute Style', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'style_1' => esc_html__( 'Style 1', 'shopbuild' ),
					'style_2' => esc_html__( 'Style 2', 'shopbuild' )
				],
				'default' => 'style_1'
			]
		);

        $this->add_control(
			'filter_query_type',
			[
				'label' => esc_html__( 'Query type', 'shopbuild' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'or',
				'options' => array(
                    'and'   => 'AND',
                    'or'    => 'OR'
                )
			]
		);

		$this->add_control(
			'_number_of_items',
			 [
				'label'       => esc_html__( 'Number of items to show', 'shopbuild' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'default'     => 8,
				'label_block' => true
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

		$this->start_controls_section(
			'pure_wc_link_title_link',
			[
				'label' => esc_html__('Attribute Style', 'shopbuild'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pure_wc_link_title_link_color',
			[
				'label' => esc_html__('Text Color', 'shopbuild'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-el-box-btn ul li span.count, {{WRAPPER}} .tp-el-box-btn ul li a' => 'color: {{VALUE}} ;',
				],
			]
		);

		$this->add_control(
			'pure_wc_link_title_link_hover_color',
			[
				'label' => esc_html__('Text Hover Color', 'shopbuild'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-el-box-btn li a:hover, {{WRAPPER}} .tp-el-box-btn ul li span.count:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pure_wc_link_title_typography',
				'label' => esc_html__('Typography', 'shopbuild'),
				'selector' => '{{WRAPPER}} .tp-el-box-btn ul li span.count, {{WRAPPER}} .tp-el-box-btn ul li a',
			]
		);
		$this->add_responsive_control(
			'pure_wc_link_title_link_padding',
			[
				'label' => esc_html__('Padding', 'shopbuild'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .tp-el-box-btn ul li span.count, {{WRAPPER}} .tp-el-box-btn ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'pure_wc_link_title_link_margin',
			[
				'label' => esc_html__('Margin', 'shopbuild'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .tp-el-box-btn ul li span.count, {{WRAPPER}} .tp-el-box-btn ul li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
    }

    protected function wc_available_attributes(){
        $attribute_taxonomies = wc_get_attribute_taxonomies();
        $options = array('' => esc_html__( 'Default', 'shopbuild' ));
        foreach( $attribute_taxonomies as $taxonomy ){
            $options[$taxonomy->attribute_name] = esc_html( $taxonomy->attribute_label );
        }

        return $options;
    }

    /**
	 * Return the currently viewed term slug.
	 *
	 * @return int
	 */
	protected function get_current_term_slug() {
		return absint( is_tax() ? get_queried_object()->slug : 0 );
	}

    /**
	 * Return the currently viewed taxonomy name.
	 *
	 * @return string
	 */
	protected function get_current_taxonomy() {
		return is_tax() ? get_queried_object()->taxonomy : '';
	}

	/**
	 * Return the currently viewed term ID.
	 *
	 * @return int
	 */
	protected function get_current_term_id() {
		return absint( is_tax() ? get_queried_object()->term_id : 0 );
	}

    /**
	 * Get current page URL with various filtering props supported by WC.
	 *
	 * @return string
	 * @since  3.3.0
	 */
	protected function get_current_page_url() {
		if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
			$link = home_url();
		} elseif ( is_shop() ) {
			$link = get_permalink( wc_get_page_id( 'shop' ) );
		} elseif ( is_product_category() ) {
			$link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
		} elseif ( is_product_tag() ) {
			$link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
		} else {
			$queried_object = get_queried_object();

			$link           = !empty($queried_object->taxonomy) && !empty($queried_object->slug)? get_term_link( $queried_object->slug, $queried_object->taxonomy ) : '';
		}
		
		// Min/Max.
		if ( isset( $_GET['min_price'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$link = add_query_arg( 'min_price', wc_clean( sanitize_text_field(wp_unslash( $_GET['min_price'] )) ), $link ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}

		if ( isset( $_GET['max_price'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$link = add_query_arg( 'max_price', wc_clean( sanitize_text_field(wp_unslash( $_GET['max_price']) ) ), $link ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}

		// Order by.
		if ( isset( $_GET['orderby'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$link = add_query_arg( 'orderby', wc_clean( sanitize_text_field(wp_unslash( $_GET['orderby']) ) ), $link );// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}

		/**
		 * Search Arg.
		 * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
		 */
		if ( get_search_query() ) {
			$link = add_query_arg( 's', rawurlencode( htmlspecialchars_decode( get_search_query() ) ), $link );
		}

		// Post Type Arg.
		if ( isset( $_GET['post_type'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$link = add_query_arg( 'post_type', wc_clean( sanitize_text_field(wp_unslash( $_GET['post_type']) ) ), $link ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

			// Prevent post type and page id when pretty permalinks are disabled.
			if ( is_shop() ) {
				$link = remove_query_arg( 'page_id', $link );
			}
		}

		// Min Rating Arg.
		if ( isset( $_GET['rating_filter'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$link = add_query_arg( 'rating_filter', wc_clean( sanitize_text_field(wp_unslash( $_GET['rating_filter'] )) ), $link ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}

		// All current filters.
		if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) { // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.FoundInControlStructure, WordPress.CodeAnalysis.AssignmentInCondition.Found
			foreach ( $_chosen_attributes as $name => $data ) {
				$filter_name = wc_attribute_taxonomy_slug( $name );
				
				if ( ! empty( $data['terms'] ) ) {
					$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
				}
				if ( 'or' === $data['query_type'] ) {
					$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
				}
			}
		}

		return apply_filters( 'woocommerce_widget_get_current_page_url', $link, $this );
	}

    /**
	 * Count products within certain terms, taking the main WP query into consideration.
	 *
	 * This query allows counts to be generated based on the viewed products, not all products.
	 *
	 * @param  array  $term_ids Term IDs.
	 * @param  string $taxonomy Taxonomy.
	 * @param  string $query_type Query Type.
	 * @return array
	 */
	protected function get_filtered_term_product_counts( $term_ids, $taxonomy, $query_type ) {
		return wc_get_container()->get( Filterer::class )->get_filtered_term_product_counts( $term_ids, $taxonomy, $query_type );
	}


	protected function get_product_count_by_term( $taxonomy, $term_slug ) {
		$args = [
			'post_type'      => 'product',
			'posts_per_page' => -1,
			'tax_query'      => [
				[
					'taxonomy' => $taxonomy,  // e.g., 'product_cat', 'product_tag'
					'field'    => 'slug',
					'terms'    => $term_slug,
				]
			]
		];
	
		$query = new WP_Query( $args );
		return $query->found_posts; // Returns the count of products
	}

    /**
	 * Show list based layered nav.
	 *
	 * @param  array  $terms Terms.
	 * @param  string $taxonomy Taxonomy.
	 * @param  string $query_type Query Type.
	 * @return bool   Will nav display?
	 */
	protected function layered_nav_list( $terms, $taxonomy, $query_type ) {
		$settings = $this->get_settings_for_display();
		// List display.
		$style = $settings['pure_wc_attribute_style'];
		echo wp_kses('<ul class="woocommerce-widget-layered-nav-list sb-sidebar-product-color-filter sb-sidebar-ajax-attrs '.$style.'">', pure_wc_get_kses_extended_ruleset());

		// $term_counts        = $this->get_filtered_term_product_counts( wp_list_pluck( $terms, 'term_id' ), $taxonomy, $query_type );
		$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
		$found              = false;
		$base_link          = $this->get_current_page_url();

		if(!empty($terms)){
			$found = true;
		}

		foreach ( $terms as $term ) {
			$current_values = isset( $_chosen_attributes[ $taxonomy ]['terms'] ) ? $_chosen_attributes[ $taxonomy ]['terms'] : array();
			$option_is_set  = in_array( $term->slug, $current_values, true );
			$count          = $this->get_product_count_by_term( $taxonomy, $term->slug );
			// $count          = 0;
			// var_dump($term->term_id, $taxonomy, $query_type);

			// Skip the term for the current archive.
			if ( $this->get_current_term_id() === $term->term_id ) {
				continue;
			}


			$filter_name = 'filter_' . wc_attribute_taxonomy_slug( $taxonomy );
			
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( sanitize_text_field(wp_unslash( $_GET[ $filter_name ] )) ) ) : array();

			$current_filter = array_map( 'sanitize_title', $current_filter );

			if ( ! in_array( $term->slug, $current_filter, true ) ) {
				$current_filter[] = $term->slug;
			}

			$link = !is_wp_error($base_link)? remove_query_arg( $filter_name, $base_link ) : '';

			// Add current filters to URL.
			foreach ( $current_filter as $key => $value ) {
				// Exclude query arg for current term archive term.
				if ( $value === $this->get_current_term_slug() ) {
					unset( $current_filter[ $key ] );
				}

				// Exclude self so filter can be unset on click.
				if ( $option_is_set && $value === $term->slug ) {
					unset( $current_filter[ $key ] );
				}
			}

			if ( ! empty( $current_filter ) ) {
				asort( $current_filter );
				$link = add_query_arg( $filter_name, implode( ',', $current_filter ), $link );

				// Add Query type Arg to URL.
				if ( 'or' === $query_type && ! ( 1 === count( $current_filter ) && $option_is_set ) ) {
					$link = add_query_arg( 'query_type_' . wc_attribute_taxonomy_slug( $taxonomy ), 'or', $link );
				}
				$link = str_replace( '%2C', ',', $link );
			}

			$term_html = '';

			$attr_type = class_exists('TP_Wvs_Helper')? TP_Wvs_Helper::get_attr_type_by_name( 'pa_'.$settings['products_attributes'] ) : 'select';

			if( $attr_type == 'color' ){
				$term_meta = !empty(get_term_meta( $term->term_id, 'tpwvs_color', true ))? get_term_meta( $term->term_id, 'tpwvs_color', true ) : $term->slug;
				if( $settings['pure_wc_attribute_style'] == 'style_1' ){
					$term_html .= '<span style="background:'.esc_attr($term_meta).'" class="sidebar-ajax-checkbox is-color sb-filter-type-color"></span>';
				}
				if( $settings['pure_wc_attribute_style'] == 'style_2' ){
					$term_html .= '<button type="button" class="ajax-attr-link color sb-filter-type-color sb-color-variation-btn sb-sidebar-tooltip" data-filter="'.esc_attr($filter_name).'" data-value="'.esc_attr($term->slug).'">
							<span class="sb-color-variation-swatch" style="background-color: '.esc_attr($term_meta).'"></span>
							<span class="sb-sidebar-tooltip-content">'.esc_html($term->name).'</span>
						</button>
					';
				}
			}
			if( $attr_type == 'select' ){
				if( $settings['pure_wc_attribute_style'] == 'style_1' ){
					$term_html .= '<span class="sidebar-ajax-checkbox is-size sb-filter-type-select"></span>';
				}
				if( $settings['pure_wc_attribute_style'] == 'style_2' ){
					$label = get_term_meta( $term->term_id, 'tpwvs_select', true );
					$term_html .= '<button type="button" data-filter="'.esc_attr($filter_name).'" data-value="'.esc_attr($term->slug).'" class="select sb-filter-type-select sb-select-variation-btn ajax-attr-link sb-sidebar-tooltip">
							<span class="sb-sidebar-checkbox-btn">'.esc_attr($term->name).'</span>
							<span class="sb-sidebar-tooltip-content">'.esc_html($label).'</span>
						</button>
					';
				}
			}
			if( $attr_type == 'image' ){
				$term_meta = !empty(get_term_meta( $term->term_id, 'tpwvs_image', true ))? get_term_meta( $term->term_id, 'tpwvs_image', true ) : $term->slug;
				$term_html .= '<a data-filter="'.esc_attr($filter_name).'" data-value="'.esc_attr($term->slug).'" class="ajax-attr-link sb-filter-type-image" rel="nofollow" href="' . esc_url( $link ) . '"><img class="sidebar-ajax-img" src="'.esc_url($term_meta).'"/></a>';
			}

			if ( $count > 0 || $option_is_set ) {
				$link      = apply_filters( 'woocommerce_layered_nav_link', $link, $term, $taxonomy );
				if($settings['pure_wc_attribute_style'] == 'style_1' && $attr_type != 'image'){
					$term_html .= '<a data-filter="'.esc_attr($filter_name).'" data-value="'.esc_attr($term->slug).'" class="ajax-attr-link" rel="nofollow" href="' . esc_url( $link ) . '">' . esc_html( $term->name ) . '</a>';
				}
			} else {
				$link      = false;
				if($settings['pure_wc_attribute_style'] == 'style_1'){
					$term_html .= '<span>' . esc_html( $term->name ) . '</span>';
				}
			}

			
			if($settings['pure_wc_attribute_style'] == 'style_1'){
				$term_html .= ' ' . apply_filters( 'woocommerce_layered_nav_count', '<span class="count">(' . absint( $count ) . ')</span>', $count, $term );
			}

			echo wp_kses('<li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term ' . ( $option_is_set ? 'woocommerce-widget-layered-nav-list__item--chosen chosen' : '' ) . '">', pure_wc_get_kses_extended_ruleset());

			echo wp_kses(apply_filters( 'woocommerce_layered_nav_term_html', $term_html, $term, $link, $count ), pure_wc_get_kses_extended_ruleset());
			echo '</li>';
		}

		echo '</ul>';

		return $found;
	}

    /**
	 * Get this widgets taxonomy.
	 *
	 * @param array $instance Array of instance options.
	 * @return string
	 */
	protected function get_instance_taxonomy( $attribute ) {
		if ( isset( $attribute ) ) {
			return wc_attribute_taxonomy_name( $attribute );
		}

		$attribute_taxonomies = wc_get_attribute_taxonomies();

		if ( ! empty( $attribute_taxonomies ) ) {
			foreach ( $attribute_taxonomies as $tax ) {
				if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
					return wc_attribute_taxonomy_name( $tax->attribute_name );
				}
			}
		}

		return '';
	}

    /**
	 * Get this widgets query type.
	 *
	 * @param array $instance Array of instance options.
	 * @return string
	 */
	protected function get_instance_query_type( $query_type ) {
		return isset( $query_type ) ? $query_type : 'and';
	}

    protected function preview_mode_list( $terms ){
        $found = false;

		$settings = $this->get_settings_for_display();
		
		$style = $settings['pure_wc_attribute_style'];

        if( !empty($terms) ){
            $found = true;
            echo wp_kses('<ul class="woocommerce-widget-layered-nav-list sb-sidebar-product-color-filter sb-sidebar-ajax-attrs '.$style.' ">', pure_wc_get_kses_extended_ruleset());
            foreach( $terms as $term ){
				$term_html = '<li>';
				
				$term_product_counts = new \WP_Query( array(
					'post_type' => 'product',
					'post_status' => 'publish',
					'tax_query' => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
						'relation' => 'OR',
						array(
							'taxonomy' => 'pa_'.$settings['products_attributes'],
							'field'	=> 'slug',
							'terms' => array( $term->slug )
						)
					)
				));

				$attr_type = class_exists('TP_Wvs_Helper')? TP_Wvs_Helper::get_attr_type_by_name( 'pa_'.$settings['products_attributes'] ): 'select';

				if( $attr_type == 'select' ){

					if( $settings['pure_wc_attribute_style'] == 'style_1' ){
						$term_html .= '<span class="sidebar-ajax-checkbox is-size sb-filter-type-select"></span>';
					}

					if( $settings['pure_wc_attribute_style'] == 'style_2' ){
						$label = get_term_meta( $term->term_id, 'tpwvs_select', true );
						$term_html .= '<button type="button" class="select sb-select-variation-btn sb-sidebar-tooltip sb-filter-type-select">
								<span class="sb-sidebar-checkbox-btn">'.esc_attr($term->name).'</span>
								<span class="sb-sidebar-tooltip-content">'.esc_html($label).'</span>
							</button>
						';
					}
				}

				if( $attr_type == 'color' ){
					$term_meta = !empty(get_term_meta( $term->term_id, 'tpwvs_color', true ))? get_term_meta( $term->term_id, 'tpwvs_color', true ) : $term->slug;
					if( $settings['pure_wc_attribute_style'] == 'style_1' ){
						$term_html .= '<span style="background:'.esc_attr($term_meta).'" class="sidebar-ajax-checkbox is-color sb-filter-type-color"></span>';
					}
					if( $settings['pure_wc_attribute_style'] == 'style_2' ){
						$term_html .= '<button type="button" class="color sb-filter-type-color sb-color-variation-btn sb-sidebar-tooltip">
								<span class="sb-color-variation-swatch" style="background-color: '.esc_attr($term_meta).'"></span>
								<span class="sb-sidebar-tooltip-content">'.esc_html($term->name).'</span>
							</button>
						';
					}
				}
				if( $attr_type == 'image' ){
					$term_meta = !empty(get_term_meta( $term->term_id, 'tpwvs_image', true ))? get_term_meta( $term->term_id, 'tpwvs_image', true ) : $term->slug;
					$term_html .= '<img class="sidebar-ajax-img sb-filter-type-image" src="'.esc_url($term_meta).'"/>';
				}
				if($settings['pure_wc_attribute_style'] == 'style_1'){
					$term_html .= $term->name;
					$term_html .= ' <span>('.$term_product_counts->found_posts.')</span>';
				}
				
				
				$term_html .= '</li>';

				print wp_kses_post($term_html);
				wp_reset_query();
            }
            echo '</ul>';
        }

        return $found;
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
		

        $settings           = $this->get_settings_for_display(); 
		$taxonomy           = $this->get_instance_taxonomy( $settings['products_attributes'] );
		$query_type         = $this->get_instance_query_type( $settings['filter_query_type'] );
		$hide_empty         = $settings['hide_empty'] === 'yes' ? true : false;

		if ( ! taxonomy_exists( $taxonomy ) ) {
			return;
		}

		$terms = get_terms( array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => $hide_empty,
			'number'     => $settings['_number_of_items'],
		));

		if ( 0 == count( $terms ) ) {
			return;
		}

        ob_start();
		?>
		<div class="tp-el-section tp-el-box-btn">
			<?php if(!empty($settings['sb_widget_title'])) : ?>
			<h3 class="sb-sidebar-product-widget-title tp-el-title"><?php echo esc_html($settings['sb_widget_title']); ?></h3>
			<?php endif; ?>

		<?php
        if( Plugin::instance()->editor->is_edit_mode() ){
            $found = $this->preview_mode_list( $terms );
        }else{
            $found = $this->layered_nav_list( $terms, $taxonomy, $query_type );
        }

		if ( ! $found ) {
			ob_end_clean();
		} else {
			echo wp_kses(ob_get_clean(), pure_wc_get_kses_extended_ruleset()); 
		?> 
		</div>
			
		<?php
		}
		?>
		
		<?php

	}
}

$widgets_manager->register( new Pure_Products_Attribute_Filter_Widget() );