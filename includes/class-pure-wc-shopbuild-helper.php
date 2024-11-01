<?php

/**
 * Helper Class For Woocommerce Custom Settings
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Pure_Wc_Shopuild_Helper{

	private static $values = 8;

	public static function get_templates(){
		$get_templates_loop = new \WP_Query(array(
			'post_status' => 'publish',
			'post_type'   => 'pure_wc_template',
			'posts_per_page' => -1,
			'orderby'	=> 'title',
			'order'		=> 'DESC',
			'ignore_sticky_posts' => 1
		));

		$templates = array(
			array(
				'value'	=> 0,
				'label'	=> 'No saved template found.',
				'selected'	=> true,
				'type'		=> 'none'
			)
		);

		if( $get_templates_loop->have_posts() ){
			while( $get_templates_loop->have_posts() ){
				$get_templates_loop->the_post();
				$templates[]= array(
					'value' => get_the_ID(),
					'label'	=> get_the_title(),
					'type'	=> get_post_meta(get_the_ID(), '_pure_wc_shopbuild_tmpl_type', true)
				);
			}
		}

		return $templates;
	}
	

	/**
	 * Remove actions
	 */

	public static function remove_wc_actions(){
		add_filter('woocommerce_enqueue_styles', '__return_false');		
		remove_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20);
		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
		remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
		remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
		remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
		remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
		remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
		remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
		remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
		remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
		remove_action('woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10);
	}

	/**
	 * Setter Method
	 */
	public static function set_values( $val ){
		self::$values = $val;
	}

	/**
	 * Getter Method
	 */
	public static function get_values(){
		return self::$values;
	}
}