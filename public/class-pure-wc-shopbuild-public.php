<?php
namespace PureWCShopbuild\Frontend;
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://themepure.net
 * @since      1.0.3
 *
 * @package    Pure_Wc_Shopuild
 * @subpackage Pure_Wc_Shopuild/public
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly      

class Pure_Wc_Shopuild_Public {

	/**
	 * Query Args
	 */

	private $wc_shortcode_object = array();

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.3
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.3
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.3
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.3
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pure_Wc_Shopuild_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pure_Wc_Shopuild_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( 'pure-wc-popup', plugin_dir_url( __FILE__ ) . 'css/pure-wc-popup.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'pure-wc-tab', plugin_dir_url( __FILE__ ) . 'css/pure-wc-tab.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'shopbuild', plugin_dir_url( __FILE__ ) . 'css/pure-wc-shopbuild.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'pure-comparison-slider', plugin_dir_url( __FILE__ ) . 'css/pure-comparison-slider.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'elegant-icon', plugin_dir_url( __FILE__ ) . 'css/elegant_icon.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'perfect-scrollbar', plugin_dir_url( __FILE__ ) . 'css/perfect-scrollbar.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'slick', plugin_dir_url( __FILE__ ) . 'css/slick.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'pure-wc-animation', plugin_dir_url( __FILE__ ) . 'css/animation.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'sb-main', plugin_dir_url( __FILE__ ) . 'css/sb-main.css', array(), $this->version, 'all' );


		/**
		 * Widget Styles
		 */
		wp_register_style( 'currency-switcher', plugin_dir_url( __FILE__ ) . '/widgets/elementor/currency-switcher/style.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.3
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pure_Wc_Shopuild_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pure_Wc_Shopuild_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'slick', plugin_dir_url( __FILE__ ) . 'js/slick.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'countdown', plugin_dir_url( __FILE__ ) . 'js/countdown.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'perfect-scrollbar', plugin_dir_url( __FILE__ ) . 'js/perfect-scrollbar.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'shopbuild-counter', plugin_dir_url( __FILE__ ) . 'js/pure-wc-counter.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'shopbuild-comparison-slider', plugin_dir_url( __FILE__ ) . 'js/pure-comparison-slider.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'shopbuild-product', plugin_dir_url( __FILE__ ) . 'js/pure-wc-product.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'shopbuild-accordion', plugin_dir_url( __FILE__ ) . 'js/pure-wc-accordion.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'shopbuild-hero-slider', plugin_dir_url( __FILE__ ) . 'js/pure-wc-hero-slider.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'pure-wc-tab', plugin_dir_url( __FILE__ ) . 'js/pure-wc-tab.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'shopbuild', plugin_dir_url( __FILE__ ) . 'js/pure-wc-shopbuild.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'pure-wc-popup', plugin_dir_url( __FILE__ ) . 'js/pure-wc-popup.js', array( 'imagesloaded' ), $this->version, true );
		$is_product_cat = function_exists('is_product_category')? is_product_category() : false;
		$is_product_tag = function_exists('is_product_tag')? is_product_tag() : false;



		$attrs = apply_filters('pure_wc_shopbuild_products_args', array(
			'category'       => $is_product_cat ? $this->get_archive_query_objects() : '', // Comma separated category slugs or ids.
			'tag'            => $is_product_tag ? $this->get_archive_query_objects() : '', // Comma separated tag slugs.
		));

		$wc_shortcode_object =  class_exists('WooCommerce')? new \PureWCShopbuild\Pure_Shopbuild_Archive_Products( $attrs ) : false;
		$query_results =  class_exists('WooCommerce')? $wc_shortcode_object->get_query_results() : false;


		wp_localize_script( 'shopbuild', 'pure_wc_shopbuild', array(
			'current_page' => $query_results? $query_results->current_page : 1,
			'is_shop'	   => is_shop(),
			'is_product'   => is_product(),
			'is_checkout'  => is_checkout(),
			'ajax_url'	   => admin_url( 'admin-ajax.php' ),
			'cart_nonce'   => wp_create_nonce( 'shopbuild_ajax_add_to_cart' ),
			'search_nonce' => wp_create_nonce( 'shopbuild-search-nonce' ),
			'wc_update_cart_nonce'  => wp_create_nonce('update-cart-nonce'),
			'ajax_cart_endpoint' 	=> esc_url( \WC_AJAX::get_endpoint( 'update_order_review' ) ),
			'cart_url' => wc_get_cart_url(),
			'shopbuild_nonce' => wp_create_nonce( 'shopbuild_nonce' ),
			'query_args'  	=> $wc_shortcode_object? apply_filters('pure_wc_product_grid_args', $wc_shortcode_object->query_args) : array(),
			'per_page'  	=> $query_results ? $query_results->per_page : 0,
			'total'  		=> $query_results? $query_results->total : 0,
		));

		/**
		 * Widget Scripts
		 */
		wp_register_script( 'currency-switcher', plugin_dir_url( __FILE__ ) . '/widgets/elementor/currency-switcher/main.js', array('jquery'), $this->version, true );
		wp_localize_script( 'currency-switcher', 'currency_switcher', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'currency_switcher_nonce' => wp_create_nonce( 'currency-switcher-nonce' ),
		));

	}

	public function enqueue_elementor_scripts(){
		wp_enqueue_style('storebuild-elementor-editor', plugin_dir_url( __FILE__ ) . 'css/pure-wc-shopbuild-elementor.css', array( 'elementor-editor' ), $this->version );

		$all_widgets = pure_wc_elementor_addons();
		$pro_widgets = array_filter($all_widgets, function($widget){
			return $widget['is_pro'];
		});

		$pro_widgets = array_values($pro_widgets);
		
		wp_enqueue_script( 'pure-wc-pro-widget', plugin_dir_url( __FILE__ ) . 'js/pure-wc-shopbuild-elementor.js', array( 'elementor-editor' ), $this->version, true );
		wp_localize_script( 'pure-wc-pro-widget', 'storebuildPro', array(
			'proWidgets' 	=> $pro_widgets,
			'hasPro' 	=> pure_wc_is_pro_active(),
		));
	}

	public function remove_actions(){
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
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


	public function products_load_more(){
		check_ajax_referer('shopbuild_nonce', 'security');
		
		$wc_shortcode_object = new \PureWCShopbuild\Pure_Shopbuild_Archive_Products();
		$wc_shortcode_object->query_args['paged'] = isset($_POST['paged'])? intval(sanitize_text_field(wp_unslash($_POST['paged']))) : 1;
		$wc_shortcode_object->query_args['posts_per_page'] = isset($_POST['per_page'])? intval(sanitize_text_field(wp_unslash($_POST['per_page']))) : apply_filters('pure_wc_products_per_page', null);

		$columns  = absint( $wc_shortcode_object->attributes['columns'] );
		$products = $wc_shortcode_object->get_query_results();
		

		if ( $products && $products->ids ) {
			// Setup the loop.
			wc_setup_loop(
				array(
					'columns'      => $columns,
					'name'         => 'product',
					'is_shortcode' => true,
					'is_search'    => false,
					'is_paginated' => wc_string_to_bool( $wc_shortcode_object->attributes['paginate'] ),
					'total'        => $products->total,
					'total_pages'  => $products->total_pages,
					'per_page'     => $products->per_page,
					'current_page' => $products->current_page,
				)
			);

			$original_post = $GLOBALS['post'];

			if ( wc_get_loop_prop( 'total' ) ) {
				foreach ( $products->ids as $product_id ) {
					$GLOBALS['post'] = get_post( $product_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					setup_postdata( $GLOBALS['post'] );
					// Render product template.
					wc_get_template_part( 'content', 'product' );
				}
			}

			$GLOBALS['post'] = $original_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

			wp_reset_postdata();
			wc_reset_loop();
		} else {
			// do_action( "woocommerce_shortcode_products_loop_no_results", $wc_shortcode_object->attributes );
			// wp_send_json_error( __( 'No products found', 'shopbuild' ) );
			echo wp_kses_post("<div class='woocommerce-notices-wrapper' style='width: 100%;'><div class='woocommerce-info'>No more products found!</div></div>");
		}
		wp_die();
	}

	/**
	 * Checkout page login to existing account
	 */
	public function checkout_login(){

		check_ajax_referer( 'woocommerce-login', 'nonce' );

		if ( isset($_POST['username'], $_POST['password']) ) {
			$username = sanitize_user(wp_unslash($_POST['username']));
			$password = sanitize_text_field(wp_unslash($_POST['password']));
			$creds = array(
				'user_login'    => wp_unslash(trim( $username )),
				'user_password' => wp_unslash($password),
				'remember'      => isset($_POST['rememberme'])? sanitize_text_field( wp_unslash($_POST['rememberme']) ) : false,
			);

			$validation_error = new \WP_Error();
			$validation_error = apply_filters( 'woocommerce_process_login_errors', $validation_error, $creds['user_login'], $creds['user_password'] );

			if ( $validation_error->get_error_code() ) {
				wp_send_json_error('<strong>' . __( 'Error:', 'shopbuild' ) . '</strong> ' . $validation_error->get_error_message(), 200);
			}

			if ( empty( $creds['user_login'] ) ) {
				wp_send_json_error('<strong>' . __( 'Error:', 'shopbuild' ) . '</strong> ' . __( 'Username is required.', 'shopbuild' ), 200);
			}

			// On multisite, ensure user exists on current site, if not add them before allowing login.
			if ( is_multisite() ) {
				$user_data = get_user_by( is_email( $creds['user_login'] ) ? 'email' : 'login', $creds['user_login'] );

				if ( $user_data && ! is_user_member_of_blog( $user_data->ID, get_current_blog_id() ) ) {
					add_user_to_blog( get_current_blog_id(), $user_data->ID, 'customer' );
				}
			}

			// Perform the login.
			$user = wp_signon( apply_filters( 'woocommerce_login_credentials', $creds ), is_ssl() );

			if ( is_wp_error( $user ) ) {
				wp_send_json_error($user->get_error_message(), 200);
			} else {
				
				if ( ! empty( $_POST['redirect'] ) ) {
					$redirect = sanitize_text_field(wp_unslash( $_POST['redirect'] )); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
				} elseif ( wc_get_raw_referer() ) {
					$redirect = wc_get_raw_referer();
				} else {
					$redirect = wc_get_page_permalink( 'myaccount' );
				}
				wp_send_json_success( $redirect, 200);
			}
		}
	}

	/**
	 * Free shipping calculations
	 */
	public function pure_wc_free_shipping(){
		check_ajax_referer( 'pure-wc-free-shipping', 'security' );

		if(isset($_REQUEST['free_shipping_id'])){
			$free_shipping_id = sanitize_text_field(wp_unslash($_REQUEST['free_shipping_id']));
			$free_shipping = get_option("woocommerce_free_shipping_{$free_shipping_id}_settings");
			$free_shipping_min_amount = (!empty($free_shipping['min_amount']) && (floatval($free_shipping['min_amount']) > 0))? $free_shipping['min_amount'] : 0;
			$cart_totals = (WC()->cart->get_cart_contents_total() > $free_shipping_min_amount)? $free_shipping_min_amount : WC()->cart->get_cart_contents_total();
			$percent = ($cart_totals / $free_shipping_min_amount) * 100;
			$progress_html = sprintf('<div class="sb-progress-back" data-value="%s"><div class="sb-progress" style="width:%stransition: width 2s;"><span>%s</span></div></div>', intval($percent).'%', intval($percent).'%', ($cart_totals >= $free_shipping_min_amount)? 'Shipping is free for your cart amount.' : 'Min amount for free shipping: '.$free_shipping_min_amount);
			print wp_kses_post($progress_html);
		}else{
			$package = WC()->cart->get_shipping_packages()[0];
			$zone = \WC_Shipping_Zones::get_zone_matching_package($package);
			$methods = $zone->get_shipping_methods(true, 'values');
			$progress_html = '';
			if(!empty($methods)){
				foreach($methods as $method){
					if($method->id == 'free_shipping'){
						$min_amount  = $method->instance_settings['min_amount'];
						$cart_amount = (WC()->cart->get_cart_contents_total() > $min_amount)? $min_amount : WC()->cart->get_cart_contents_total();
						$percent = ($cart_amount / $min_amount) * 100;
						$progress_html = sprintf('<div class="sb-progress-back" data-value="%s"><div class="sb-progress" style="width:%s;transition: width 2s;"></div><span>%s</span></div>', intval($percent).'%', intval($percent).'%', ($cart_amount >= $min_amount)? 'Shipping is free for your cart amount.' : 'Min amount for free shipping for this zone: '.wc_price($min_amount));
						print wp_kses_post(apply_filters('pure_wc_free_shipping_progress', $progress_html));
					}
				}
			}
		}
		wp_die();
	}

	/**
	 *  Ajax add to cart
	 */
	public function ajax_add_to_cart() {
        check_ajax_referer( 'shopbuild_ajax_add_to_cart', 'security' );

		if ( empty( $_POST['product_id'] ) ) {
			return;
		}

        $product_id         = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
        $quantity           = ! empty( $_POST['quantity'] ) ? wc_stock_amount( absint($_POST['quantity']) ) : 1;
        $variation_id       = ! empty( $_POST['variation_id'] ) ? absint( wp_unslash($_POST['variation_id']) ) : 0;
        $variation          = ! empty( $_POST['variation'] ) ? array_map( 'sanitize_text_field', wp_unslash($_POST['variation']) ) : array();
        $passed_validation  = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variation);
        $product_status = get_post_status($product_id);

        if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation) && 'publish' === $product_status) {

            do_action('woocommerce_ajax_added_to_cart', $product_id);

            if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
                wc_add_to_cart_message(array($product_id => $quantity), true);
            }

			\WC_AJAX::get_refreshed_fragments();
			
        } else {

            $data = array(
                'error' => true,
                'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
            );

            wp_send_json($data);
        }

    }

	/**
	 * Update Cart
	 */
	public function custom_update_cart() {
		if (isset($_POST['nonce']) && wp_verify_nonce( sanitize_text_field( wp_unslash($_POST['nonce']) ), 'update-cart-nonce')) {
			$cart_item_key = isset($_POST['cart_item_key'])? sanitize_text_field( wp_unslash($_POST['cart_item_key']) ) : '';
			$quantity = isset($_POST['quantity'])? sanitize_text_field( wp_unslash($_POST['quantity']) ) : '';
	
			// Update cart item quantity
			WC()->cart->set_quantity($cart_item_key, $quantity);
	
			// Return updated cart fragments
			\WC_AJAX::get_refreshed_fragments();
		}
		wp_die();
	}

}
