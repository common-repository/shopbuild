<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Plugin;
use PureWCShopbuild\Elementor\Controls\Group_Control_PWCSGradient;
use PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin;
use PureWCShopbuild\Pure_Wc_Template_Manager;

/**
 * Elementor button widget.
 *
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.3
 */
class Pure_Products_Widget extends Pure_Wc_Base_Widget {

	use PureWCArchive, PureWCCommonStyles, PureWCQuery, PureWCActionFilter, Pure_WC_Common_Style;

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
		return 'archive-products-grid';
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
		return esc_html__( 'Archive Products Grid', 'shopbuild' );
	}


	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){

		// product feature
		$this->pure_wc_product_feature();

		$this->pure_wc_query_controls('product', 'Product', false, true, false, 6, 10, 'product', 'product_cat', 12, 0, 'date', 'desc');

		$this->pure_wc_columns('product_columns', 'Product Columns');
    }

    protected function register_style_controls(){

		$this->card_style();

		$this->pagination_style();

		$this->pure_wc_link_controls_style('product_load_more_btn', 'Load More Button', 'button.sb-product-load-more-btn', 'button.sb-product-load-more-btn:hover');
	}


	protected function get_archive_query_objects(){
		$query_object = get_queried_object();
		if( is_product_tag() ){
			return $query_object->slug;
		}else if( is_product_category() ){
			return $query_object->term_id;
		}else{
			return $query_object;
		}
	}

	protected function get_args(){
		if(isset($_GET['_pure_wc_nonce']) && !wp_verify_nonce( sanitize_text_field( wp_unslash($_GET['_pure_wc_nonce']) ))){
			return;
		}

		$settings = $this->get_settings_for_display();
		$limit = $this->get_settings_for_display('posts_per_page') ?  $this->get_settings_for_display('posts_per_page')  : get_option('pure_wc_product_limit') ;
		$query_object = $this->get_archive_query_objects();


		$product_include_items = $settings['post_include'];
		$categories = (isset($_GET['categories']) && is_array($_GET['categories']))? array_map('sanitize_text_field', wp_unslash($_GET['categories'])) : '';

		$categories_data = [];
		if(isset($_GET['categories'])){
			$categories_data = is_array($_GET['categories'])? array_map('sanitize_text_field', wp_unslash($_GET['categories'])) : explode(',', sanitize_text_field( wp_unslash($_GET['categories'])));
		}
		
		$categories = !empty($categories_data)? implode(',', $categories_data) : (is_array($settings['category']) ? implode(',', $settings['category']) : '');

		if(!empty($query_object) && is_product_category()){
			$term = get_term_by('id', $query_object, 'product_cat');
			$categories = array($term->slug);
		}

		$args = array(
			'columns'        => $this->get_settings_for_display('pureproducts_columns'),
			'category'       => $categories,        // Comma separated category slugs or ids.
			'tag'            => is_product_tag() ? $query_object : '',        // Comma separated tag slugs.
			'page'       	 => absint( get_query_var('paged') )  > 1 ? absint( get_query_var('paged') ) : 1,
			'paginate'       => true,     	// Should results be paginated.
			'limit' 		 => $limit,
			'ids'       	 => is_array($product_include_items) ? implode(',', $product_include_items) : '',
			'orderby'        => $settings['orderby'],
			'order'          => $settings['order'],   
			'excludes'       => isset($settings['post__not_in']) && is_array($settings['post__not_in']) ? $settings['post__not_in'] : [],
			'cat_excludes'	 => isset($settings['exclude_category']) && is_array($settings['exclude_category']) ? $settings['exclude_category'] : [],

		);


		if(isset($_GET['price'])){
			$args['orderby'] = 'price';
			$args['order']	= ($_GET['price'] == 'price')? 'asc' : 'desc';
		}


		return apply_filters('pure_wc_shopbuild_products_args', $args);
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
		$woocoomerce_settings  = Pure_Wc_Shopuild_Admin::get_option('_pure_shopbuild_woocommerce');
		
		$settings = $this->get_settings_for_display();

		$is_editor_mode = pure_wc_is_elementor_edit();

		$settings['pure_archive_columns'] = $this->pure_row_cols_show($settings, 'product_columns');
		
		$attrs = $this->get_args();
		
		$limit = $settings['posts_per_page'] ?  $settings['posts_per_page']  : $woocoomerce_settings['products_limits'];
		$woocoomerce_settings['products_limits'] = $limit;

		$contents = new PureWCShopbuild\Pure_Shopbuild_Archive_Products( $attrs );
		$results  = $contents->get_custom_content($is_editor_mode, $this->pure_wc_product_feature_options($settings));
		$no_contents = pure_wc_shopbuild_no_contents();
		

		$theme = wp_get_theme();
		$is_template_active = Pure_Wc_Template_Manager::get_archive_template_id();
		$classes = $is_template_active > 0? '' : 'woocommerce';
		
		$theme_name = '';
		if( !empty($theme) ){
			$theme_name = strtolower($theme->Name);
		}
		echo wp_kses('<div class="'.$classes.' products-grid-wrapper '.esc_html($theme_name).'">', pure_wc_get_kses_extended_ruleset());
		if( wp_strip_all_tags( trim($results) )){
			print wp_kses($results, pure_wc_get_kses_extended_ruleset()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}else{
			print wp_kses($no_contents, pure_wc_get_kses_extended_ruleset());
		}
		echo '</div>';
		
		

		if( $settings['products_pagination'] == 'default_pagination' ){
			global $wp;
			$total   = $contents->get_query_results()->total_pages;
			$current = $contents->get_query_results()->current_page;
			$format  = '?product-page=%#%';
			$base    = home_url( $wp->request ) . "/{$format}";

			if ( $total <= 1 ) {
				return;
			}
			echo '<div class="woocommerce sb-pagination">';
			wc_get_template( 'loop/pagination.php', array( 
				'total' 	=> $total, 
				'current' 	=> $current, 
				'format' 	=> $format,
				'base'   	=> $base
			));
			echo '</div>';
			
		}else{
			remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
			
			if( Plugin::instance()->editor->is_edit_mode() ){
				if( count($contents->get_query_results()->ids) >= $limit ){
					echo '<div class="d-flex woocommerce">';
						echo '<button class="sb-product-load-more-btn button wp-element-button" id="products-load-more">
							<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M1 8.5C1 4.36 4.33 1 8.5 1C13.5025 1 16 5.17 16 5.17M16 5.17V1.42M16 5.17H12.67" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
								<path d="M15.9175 8.5C15.9175 12.64 12.5575 16 8.4175 16C4.2775 16 1.75 11.83 1.75 11.83M1.75 11.83H5.14M1.75 11.83V15.58" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
							</svg>
							Load More Products
						</button>';
					echo '</div>';
				}
			}else{
				
				if( count($contents->get_query_results()->ids) >= $limit ){
					echo '<div class="d-flex woocommerce">';
						echo '
							<button class="sb-product-load-more-btn button wp-element-button" id="products-load-more">
								<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 8.5C1 4.36 4.33 1 8.5 1C13.5025 1 16 5.17 16 5.17M16 5.17V1.42M16 5.17H12.67" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
									<path d="M15.9175 8.5C15.9175 12.64 12.5575 16 8.4175 16C4.2775 16 1.75 11.83 1.75 11.83M1.75 11.83H5.14M1.75 11.83V15.58" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
								</svg>
								Load More Products
							</button>';
					echo '</div>';
				}
			}
			
		}		
		
		Pure_Wc_Shopuild_Admin::update_settings('_pure_shopbuild_woocommerce', wp_json_encode($woocoomerce_settings));
		add_filter('pure_wc_product_grid_args', array( $this, 'get_args'));
	}
}

$widgets_manager->register( new Pure_Products_Widget() );