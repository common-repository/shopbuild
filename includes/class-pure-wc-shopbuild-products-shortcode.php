<?php
namespace PureWCShopbuild;
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Pure_Shopbuild_Archive_Products extends \WC_Shortcode_Products {

    private $settings = array();
    private $is_added_product_filter = false;
    private $filterable = true;
    private $filter_args = array();
	public $query_args = array();
	private static $search_results;

	/**
	 * Attributes.
	 *
	 * @since 3.2.0
	 * @var   array
	 */
	public $attributes = array();

    public function __construct( $attributes = array(), $settings = array(), $type = 'products', $filterable = true, $filter_args = array() ) {
        $this->settings = $settings;
        $this->type = $type;

        // Product Filter Module
        $this->filterable  = $filterable;
        $this->filter_args = $filter_args;
        $this->attributes = $this->parse_attributes( $attributes );

        $this->query_args = $this->parse_query_args();
    }

	/**
	 * Parse attributes.
	 *
	 * @since  3.2.0
	 * @param  array $attributes Shortcode attributes.
	 * @return array
	 */
	protected function parse_attributes( $attributes ) {
		$attributes = $this->parse_legacy_attributes( $attributes );

		$attributes = shortcode_atts(
			array(
				'limit'          => '-1',      // Results limit.
				'columns'        => '',        // Number of columns.
				'rows'           => '',        // Number of rows. If defined, limit will be ignored.
				'orderby'        => '',        // menu_order, title, date, rand, price, popularity, rating, or id.
				'order'          => '',        // ASC or DESC.
				'ids'            => '',        // Comma separated IDs.
				'excludes'		 => array(),
				'skus'           => '',        // Comma separated SKUs.
				'category'       => '',        // Comma separated category slugs or ids.
				'cat_excludes'   => array(),
				'cat_operator'   => 'IN',      // Operator to compare categories. Possible values are 'IN', 'NOT IN', 'AND'.
				'attribute'      => '',        // Single attribute slug.
				'terms'          => '',        // Comma separated term slugs or ids.
				'terms_operator' => 'IN',      // Operator to compare terms. Possible values are 'IN', 'NOT IN', 'AND'.
				'tag'            => '',        // Comma separated tag slugs.
				'tag_operator'   => 'IN',      // Operator to compare tags. Possible values are 'IN', 'NOT IN', 'AND'.
				'visibility'     => 'visible', // Product visibility setting. Possible values are 'visible', 'catalog', 'search', 'hidden'.
				'class'          => '',        // HTML class.
				'page'           => 1,         // Page for pagination.
				'paginate'       => false,     // Should results be paginated.
				'cache'          => true,      // Should shortcode output be cached.
			),
			$attributes,
			$this->type
		);

		if ( ! absint( $attributes['columns'] ) ) {
			$attributes['columns'] = wc_get_default_products_per_row();
		}

		return $attributes;
	}

	/**
	 * Get wrapper classes.
	 *
	 * @since  3.2.0
	 * @param  int $columns Number of columns.
	 * @return array
	 */
	public function get_wrapper_classes( $columns ) {
		$classes = array( 'shopbuild' );

		if ( 'product' !== $this->type ) {
			$classes[] = 'columns-' . $columns;
		}

		$classes[] = $this->attributes['class'];

		return $classes;
	}

    /**
     * Override the original `get_query_results`
     * with modifications that:
     * 1. Remove `pre_get_posts` action if `is_added_product_filter`.
     *
     * @return bool|mixed|object
     */

    public function get_query_results() {
        $results = parent::get_query_results();
        // Start edit.
        if ( $this->is_added_product_filter ) {
            remove_action( 'pre_get_posts', [ WC()->query, 'product_query' ] );
        }
        // End edit.

        return $results;
    }

	public static function get_choosen_attributes(){
		// phpcs:disable WordPress.Security.NonceVerification.Recommended

		$chosen_attributes = array();

		if ( ! empty( $_GET ) ) {
			foreach ( $_GET as $key => $value ) {
				if ( 0 === strpos( $key, 'filter_' ) ) {
					$attribute    = wc_sanitize_taxonomy_name( str_replace( 'filter_', '', $key ) );
					$taxonomy     = wc_attribute_taxonomy_name( $attribute );
					$filter_terms = ! empty( $value ) ? explode( ',', wc_clean( wp_unslash( $value ) ) ) : array();

					if ( empty( $filter_terms ) || ! taxonomy_exists( $taxonomy ) || ! wc_attribute_taxonomy_id_by_name( $attribute ) ) {
						continue;
					}

					$query_type  = ! empty( $_GET[ 'query_type_' . $attribute ] ) && in_array( $_GET[ 'query_type_' . $attribute ], array( 'and', 'or' ), true ) ? wc_clean( sanitize_text_field(wp_unslash( $_GET[ 'query_type_' . $attribute ] )) ) : '';
					$chosen_attributes[ $taxonomy ]['terms'] = array_map( 'sanitize_title', $filter_terms ); // Ensures correct encoding.
					$chosen_attributes[ $taxonomy ]['query_type'] = $query_type ? $query_type : apply_filters( 'woocommerce_layered_nav_default_query_type', 'and' );
				}
			}
		}

		return $chosen_attributes;
		// phpcs:disable WordPress.Security.NonceVerification.Recommended
	}

    protected function parse_query_args() {
        $query_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'no_found_rows'       => false === wc_string_to_bool( $this->attributes['paginate'] ),
			'orderby'             => empty( $_GET['orderby'] ) ? $this->attributes['orderby'] : wc_clean( sanitize_text_field(wp_unslash( $_GET['orderby'] )) ), // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		);

		$orderby_value         = explode( '-', $query_args['orderby'] );
		$orderby               = esc_attr( $orderby_value[0] );
		$order                 = ! empty( $orderby_value[1] ) ? $orderby_value[1] : strtoupper( $this->attributes['order'] );
		$query_args['orderby'] = $orderby;
		$query_args['order']   = $order;

		if( !empty($this->attributes['excludes'] ) ){
			$query_args['post__not_in'] = $this->attributes['excludes'];
		}

		if( !empty($this->attributes['includes'] ) ){
			$query_args['post__in'] = $this->attributes['includes'];
		}


		if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
			$this->attributes['page'] = absint( empty( $_GET['product-page'] ) ? 1 : sanitize_text_field(wp_unslash($_GET['product-page'])) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}

		if ( ! empty( $this->attributes['rows'] ) ) {
			$this->attributes['limit'] = $this->attributes['columns'] * $this->attributes['rows'];
		}

		$ordering_args         = WC()->query->get_catalog_ordering_args( $query_args['orderby'], $query_args['order'] );
		$query_args['orderby'] = $ordering_args['orderby'];
		$query_args['order']   = $ordering_args['order'];
		if ( $ordering_args['meta_key'] ) {
			$query_args['meta_key'] = $ordering_args['meta_key']; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
		}
		$query_args['posts_per_page'] = intval( $this->attributes['limit'] );

		if ( 1 < $this->attributes['page'] || get_query_var('paged') > 1 ) {
			$query_args['paged'] = absint( get_query_var('paged') )  > 1 ? absint( get_query_var('paged') ) : absint( $this->attributes['page'] );
		}

		$query_args['meta_query'] = WC()->query->get_meta_query(); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
		$query_args['tax_query']  = array(); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query

		// Visibility.
		$this->set_visibility_query_args( $query_args );

		// SKUs.
		$this->set_skus_query_args( $query_args );

		// IDs.
		$this->set_ids_query_args( $query_args );

		// Set specific types query args.
		if ( method_exists( $this, "set_{$this->type}_query_args" ) ) {
			$this->{"set_{$this->type}_query_args"}( $query_args );
		}

		// Attributes.
		$this->set_attributes_query_args( $query_args );

		// Categories.
		$this->set_categories_query_args( $query_args );

		// Tags.
		$this->set_tags_query_args( $query_args );

		$query_args = apply_filters( 'woocommerce_shortcode_products_query', $query_args, $this->attributes, $this->type );

		// Always query only IDs.
		$query_args['fields'] = 'ids';

        if ( isset( $_GET['q'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $query_args['s'] = !empty( sanitize_text_field(wp_unslash( $_GET['q'] )) ) ? sanitize_text_field(wp_unslash( $_GET['q'] )) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        }

		$_chosen_attributes = \WC_Query::get_layered_nav_chosen_attributes();

        // Filterable products query.
        if( isset( $_GET['min_price'], $_GET['max_price'] ) && !empty(sanitize_text_field(wp_unslash($_GET['min_price']))) && !empty(sanitize_text_field(wp_unslash($_GET['max_price']))) ){ // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $query_args['meta_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
                array(
                    'key' => '_price',
                    'value' => sanitize_text_field(wp_unslash($_GET['min_price'])), // phpcs:ignore WordPress.Security.NonceVerification.Recommended
                    'compare' => '>=',
					'type'    => 'NUMERIC' // Treat price as a numeric value
                ),
                array(
                    'key' => '_price',
                    'value' => sanitize_text_field(wp_unslash($_GET['max_price'])), // phpcs:ignore WordPress.Security.NonceVerification.Recommended
                    'compare' => '<=',
					'type'    => 'NUMERIC' // Treat price as a numeric value
                )
            );
        }

		if(isset($_GET['categories']) || !empty( $this->attributes['category'] )){
			$categories = [];
			if(!empty($_GET['categories'])){
				$categories = is_array($_GET['categories'])? array_map('sanitize_text_field', wp_unslash($_GET['categories'])) : explode(',', sanitize_text_field(wp_unslash($_GET['categories'])));
			}
			if(!empty($this->attributes['category'])){
				$categories = is_array($this->attributes['category'])? $this->attributes['category'] : explode(',', $this->attributes['category']);
			}
	
			$query_args['tax_query'][] = array(
				// 'relation'	=> 'AND',
				array(
					'taxonomy' 	=> 'product_cat',
					'field' 	=> 'slug',
					'terms' 	=> $categories
				)
			);
		}

		if( !empty($_chosen_attributes) ){
			
			foreach( $_chosen_attributes as $taxonomy => $terms ){
				if( $terms['query_type'] == 'and' ){
					$query_args['tax_query'][] = array(
						'relation' => 'AND',
						array(
							'taxonomy' => $taxonomy,
							'field' => 'slug',
							'terms' => $terms['terms']
						)
					);
				}else{
					$query_args['tax_query'][] = array(
						'relation' => 'OR',
						array(
							'taxonomy' => $taxonomy,
							'field' => 'slug',
							'terms' => $terms['terms']
						)
					);
				}
				
			}
		}

		if(isset($_GET['availability'])){
			$availability = sanitize_text_field(wp_unslash($_GET['availability']));
			if($availability == 'in_stock'){
				$query_args['meta_query'] = array(
					array(
						'key' => '_stock_status',
						'value' => 'instock',
					)
				);
			} else if($availability == 'out_of_stock'){
				$query_args['meta_query'] = array(
					array(
						'key' => '_stock_status',
						'value' => 'outofstock',
					)
				);
			}
		}

		if(isset($_GET['ratings'])){
			$ratings = sanitize_text_field(wp_unslash($_GET['ratings']));
			$ratings = number_format((float)$ratings, 2, '.', '');
			$query_args['meta_key']  = '_wc_average_rating';
			$query_args['orderby']   = 'meta_value_num';
			$query_args['order']     = 'DESC'; // Sort by highest average rating
			$query_args['meta_query'] = array(
				array(
					'key'     => '_wc_average_rating',
					'value'   => $ratings,
				)
			);
		}

		if(isset($_GET['colors'])){
			$query_args['tax_query'][] = array(
				array(
					'taxonomy' => 'pa_color',
					'field' => 'slug',
					'terms' => is_array($_GET['colors'])? array_map('sanitize_text_field', wp_unslash($_GET['colors'])) : array()
				)
			);
		}
		if(isset($_GET['sizes'])){
			$query_args['tax_query'][] = array(
				array(
					'taxonomy' => 'pa_size',
					'field' => 'slug',
					'terms' => is_array($_GET['sizes'])? array_map('sanitize_text_field', wp_unslash($_GET['sizes'])) : array()
				)
			);
		}
		
		if(!empty($this->attributes['category']) && !empty($this->attributes['cat_excludes'])){
			
			$query_args['tax_query'][] = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'product_cat',
					'field' => 'slug',
					'terms' => is_array($this->attributes['cat_excludes'])? $this->attributes['cat_excludes'] : [],
					'operator'	=> 'NOT IN'
				),
				array(
					'taxonomy' => 'product_cat',
					'field' => 'slug',
					'terms' => is_array($this->attributes['category'])? $this->attributes['category'] : explode(',', $this->attributes['category']),
					'operator'	=> 'IN'
				),
			);
		}
       

        return $query_args;
    }

    protected function set_ids_query_args( &$query_args ) {
        if ( ! empty( $this->attributes['ids'] ) ) {
			$ids = array_map( 'trim', explode( ',', $this->attributes['ids'] ) );

			if ( 1 === count( $ids ) ) {
				$query_args['p'] = $ids[0];
			} else {
				$query_args['post__in'] = $ids;
			}
		}
    }

    protected function set_categories_query_args( &$query_args ) {
        if ( ! empty( $this->attributes['category'] ) ) {
			// $categories = array_map( 'sanitize_title', explode( ',', $this->attributes['category'] ) );
			// $field      = 'slug';

			// if ( is_numeric( $categories[0] ) ) {
			// 	$field      = 'term_id';
			// 	$categories = array_map( 'absint', $categories );
			// 	// Check numeric slugs.
			// 	foreach ( $categories as $cat ) {
			// 		$the_cat = get_term_by( 'slug', $cat, 'product_cat' );
			// 		if ( false !== $the_cat ) {
			// 			$categories[] = $the_cat->term_id;
			// 		}
			// 	}
			// }

			// $query_args['tax_query'][] = array(
			// 	'taxonomy'         => 'product_cat',
			// 	'terms'            => $categories,
			// 	'field'            => $field,
			// 	'operator'         => $this->attributes['cat_operator'],

			// 	/*
			// 	 * When cat_operator is AND, the children categories should be excluded,
			// 	 * as only products belonging to all the children categories would be selected.
			// 	 */
			// 	'include_children' => 'AND' === $this->attributes['cat_operator'] ? false : true,
			// );
		}
    }
    
    protected function set_tags_query_args( &$query_args ) {
        if ( ! empty( $this->attributes['tag'] ) ) {
			$query_args['tax_query'][] = array(
				'taxonomy' => 'product_tag',
				'terms'    => array_map( 'sanitize_title', explode( ',', $this->attributes['tag'] ) ),
				'field'    => 'slug',
				'operator' => $this->attributes['tag_operator'],
			);
		}
    }

	/**
	 * Get shortcode content.
	 *
	 * @since  3.2.0
	 * @return string
	 */
	public function get_custom_content($is_editor_mode, $args) {
		return $this->product_custom_loop($is_editor_mode, $args);
	}

	/**
	 * Get shortcode content.
	 *
	 * @since  3.2.0
	 * @return string
	 */
	public function get_custom_card_content($is_editor_mode, $args) {
		return $this->product_card_loop($is_editor_mode, $args);
	}

	/**
	 * Loop over found products.
	 *
	 * @since  3.2.0
	 * @return string
	 */
	protected function product_custom_loop($is_editor_mode, $args) {
		$columns  = 3;
	
		$classes  = $this->get_wrapper_classes( $columns );
		$products = $this->get_query_results();
		$search_results = apply_filters('products_search_results', $products->ids);
		self::$search_results = $search_results;
		ob_start();



		if ( $products && $products->ids ) {
			// Prime caches to reduce future queries.
			if ( is_callable( '_prime_post_caches' ) ) {
				_prime_post_caches( $products->ids );
			}

			// Setup the loop.
			wc_setup_loop(
				array(
					'columns'      => $columns,
					'name'         => $this->type,
					'is_shortcode' => true,
					'is_search'    => false,
					'is_paginated' => wc_string_to_bool( $this->attributes['paginate'] ),
					'total'        => $products->total,
					'total_pages'  => $products->total_pages,
					'per_page'     => $products->per_page,
					'current_page' => $products->current_page,
					'results'	   => $search_results,
					'pure_archive_responsive_columns' => isset($args['pure_archive_columns']) ? $args['pure_archive_columns'] : $columns
				)
			);

			$original_post = $GLOBALS['post'];

			do_action( "woocommerce_shortcode_before_{$this->type}_loop", $this->attributes );

			// Fire standard shop loop hooks when paginating results so we can show result counts and so on.
			if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
				// do_action( 'woocommerce_before_shop_loop' );
			}

			pure_wc_get_template('loop/loop-start.php');

			if ( wc_get_loop_prop( 'total' ) ) {
				foreach ( $products->ids as $product_id ) {
					$GLOBALS['post'] = get_post( $product_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					setup_postdata( $GLOBALS['post'] );

					// Set custom product visibility when querying hidden products.
					add_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );

					if($args['product_style'] > 0){
						pure_wc_product_style($args);
					}else{
						wc_get_template_part('content', 'product');
					}
					// Restore product visibility.
					remove_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );
				}
			}

			$GLOBALS['post'] = $original_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			pure_wc_get_template('loop/loop-end.php');

			do_action( "woocommerce_shortcode_after_{$this->type}_loop", $this->attributes );

			wp_reset_postdata();
			wc_reset_loop();
		} else {
			do_action( "woocommerce_shortcode_{$this->type}_loop_no_results", $this->attributes );
		}

		return '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">' . ob_get_clean() . '</div>';
	}

	/**
	 * Loop over found products.
	 *
	 * @since  3.2.0
	 * @return string
	 */
	protected function product_card_loop($is_editor_mode, $args) {
		// Pure_Wc_Shopuild_Helper::remove_wc_actions();
		$columns  = absint( $this->attributes['columns'] );
		$classes  = $this->get_wrapper_classes( $columns );
		$products = $this->get_query_results();
		$search_results = apply_filters('products_search_results', $products->ids);
		self::$search_results = $search_results;
		ob_start();



		if ( $products && $products->ids ) {
			// Prime caches to reduce future queries.
			if ( is_callable( '_prime_post_caches' ) ) {
				_prime_post_caches( $products->ids );
			}

			// Setup the loop.
			wc_setup_loop(
				array(
					'columns'      => $columns,
					'name'         => $this->type,
					'is_shortcode' => true,
					'is_search'    => false,
					'is_paginated' => wc_string_to_bool( $this->attributes['paginate'] ),
					'total'        => $products->total,
					'total_pages'  => $products->total_pages,
					'per_page'     => $products->per_page,
					'current_page' => $products->current_page,
					'results'	   => $search_results
				)
			);

			$original_post = $GLOBALS['post'];


			if ( wc_get_loop_prop( 'total' ) ) {
				foreach ( $products->ids as $product_id ) {
					$GLOBALS['post'] = get_post( $product_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					setup_postdata( $GLOBALS['post'] );

					// Set custom product visibility when querying hidden products.
					add_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );

					if($args['product_style'] > 0){
						pure_wc_product_style($args);
					}else{
						wc_get_template_part('content', 'product');
					}
					// Restore product visibility.
					remove_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );
				}
			}

			$GLOBALS['post'] = $original_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited


			wp_reset_postdata();
			wc_reset_loop();
		} else {
			do_action( "woocommerce_shortcode_{$this->type}_loop_no_results", $this->attributes );
		}

		return ob_get_clean();
	}

	/**
	 * get attributes
	 */
	public function get_attributes(){
		return $this->attributes;
	}



	/**
	 * Get search results count
	 */
	public static function get_search_result(){
		return self::$search_results;
	}

}