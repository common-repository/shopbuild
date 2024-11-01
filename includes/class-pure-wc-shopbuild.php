<?php
namespace PureWCShopbuild;
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://themepure.net
 * @since      1.0.3
 *
 * @package    Pure_Wc_Shopuild
 * @subpackage Pure_Wc_Shopuild/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.3
 * @package    Pure_Wc_Shopuild
 * @subpackage Pure_Wc_Shopuild/includes
 * @author     ThemePure <themepure@gmail.com>
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if ( ! function_exists( 'get_plugins' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}


class Pure_Wc_Shopuild {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.3
	 * @access   protected
	 * @var      Pure_Wc_Shopuild_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.3
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.3
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;
	

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.3
	 */
	public function __construct() {
		if ( defined( 'PURE_WC_SHOPBUILD_VERSION' ) ) {
			$this->version = PURE_WC_SHOPBUILD_VERSION;
		} else {
			$this->version = '1.0.3';
		}
		$this->plugin_name = 'shopbuild';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Pure_Wc_Shopuild_Loader. Orchestrates the hooks of the plugin.
	 * - Pure_Wc_Shopuild_i18n. Defines internationalization functionality.
	 * - Pure_Wc_Shopuild_Admin. Defines all hooks for the admin area.
	 * - Pure_Wc_Shopuild_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.3
	 * @access   private
	 */
	private function load_dependencies() {

		require_once PURE_WC_SHOPBUILD_PATH . 'includes/class-pure-wc-shopbuild-helper.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once PURE_WC_SHOPBUILD_PATH . 'includes/class-pure-wc-shopbuild-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once PURE_WC_SHOPBUILD_PATH . 'includes/class-pure-wc-shopbuild-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once PURE_WC_SHOPBUILD_PATH . 'admin/class-pure-wc-shopbuild-admin.php';

		require_once PURE_WC_SHOPBUILD_PATH . 'public/class-pure-wc-shopbuild-public.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once PURE_WC_SHOPBUILD_PATH . 'includes/class-pure-wc-shopbuild-post-type.php';

		$this->loader = new Pure_Wc_Shopuild_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Pure_Wc_Shopuild_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.3
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Pure_Wc_Shopuild_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.3
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Admin\Pure_Wc_Shopuild_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_notices', $plugin_admin, 'notices' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'admin_settings_menu' );
		$this->loader->add_action( 'admin_footer', $plugin_admin, 'render_template_popup' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_ajax_pure_wc_shopbuild_save', $plugin_admin, 'pure_wc_shopbuild_save' );
		$this->loader->add_action( 'wp_ajax_pure_wc_shopbuild_save_template', $plugin_admin, 'save_template' );
		$this->loader->add_action( 'wp_ajax_pure_wc_shopbuild_get_template', $plugin_admin, 'get_template' );
		$this->loader->add_filter( 'manage_pure_wc_template_posts_columns', $plugin_admin, 'add_column_to_templates' );
		$this->loader->add_action( 'manage_pure_wc_template_posts_custom_column', $plugin_admin, 'get_templates_column_data', 10, 2 );
		$this->loader->add_action( 'init', $plugin_admin, 'register_settings' );
		$this->loader->add_action( 'wp_trash_post', $plugin_admin, 'delete_meta_on_trash_custom_post_type');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.3
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new Frontend\Pure_Wc_Shopuild_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_ajax_shopbuild_woo_ajax_login', $plugin_public, 'checkout_login' );
		$this->loader->add_action( 'wp_ajax_nopriv_shopbuild_woo_ajax_login', $plugin_public, 'checkout_login' );
		$this->loader->add_action( 'wp', $plugin_public, 'remove_actions' );
		$this->loader->add_action( 'wp_ajax_products_load_more', $plugin_public, 'products_load_more' );
		$this->loader->add_action( 'wp_ajax_nopriv_products_load_more', $plugin_public, 'products_load_more' );
		$this->loader->add_action( 'wp_ajax_pure_wc_free_shipping', $plugin_public, 'pure_wc_free_shipping' );
		$this->loader->add_action( 'wp_ajax_nopriv_pure_wc_free_shipping', $plugin_public, 'pure_wc_free_shipping' );
		$this->loader->add_action( 'wp_ajax_woocommerce_ajax_add_to_cart', $plugin_public, 'ajax_add_to_cart' );
        $this->loader->add_action( 'wp_ajax_nopriv_woocommerce_ajax_add_to_cart', $plugin_public, 'ajax_add_to_cart' );
		// Handle AJAX request to update cart
		$this->loader->add_action('wp_ajax_custom_update_cart', $plugin_public, 'custom_update_cart' );
		$this->loader->add_action('wp_ajax_nopriv_custom_update_cart', $plugin_public, 'custom_update_cart' );
		$this->loader->add_action('elementor/editor/after_enqueue_scripts', $plugin_public, 'enqueue_elementor_scripts' );

	}

	public static function load_utils(){
		require_once PURE_WC_SHOPBUILD_PATH . 'admin/class-pure-wc-shopbuild-admin.php';
		$options = Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_shopbuild_modules');
		$quick_settings = Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_quickview_settings');
		$sale_notification = Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_sale_notification');

		if( class_exists('WooCommerce') ){
			require_once PURE_WC_SHOPBUILD_PATH . 'includes/class-pure-wc-shopbuild-products-shortcode.php';
			require_once PURE_WC_SHOPBUILD_PATH . 'includes/class-pure-wc-shopbuild-template-manager.php';
			require_once PURE_WC_SHOPBUILD_PATH . 'includes/class-pure-wc-shopbuild-widgets-manager.php';
			require_once PURE_WC_SHOPBUILD_PATH . 'includes/class-pure-wc-shopbuild-woocomerce.php';
	
			if($sale_notification['pure_wc_enable_sale_notification']){
				require_once PURE_WC_SHOPBUILD_PATH . 'public/class-pure-wc-shopbuild-sale-notification.php';
			}
			require_once PURE_WC_SHOPBUILD_PATH . 'public/traits/shopbuild-styles.php';
			require_once PURE_WC_SHOPBUILD_PATH . 'public/traits/shopbuild-query.php';
			require_once PURE_WC_SHOPBUILD_PATH . 'public/traits/shopbuild-slider.php';
			require_once PURE_WC_SHOPBUILD_PATH . 'public/traits/shopbuild-action-filters.php';
			require_once PURE_WC_SHOPBUILD_PATH . 'public/traits/shopbuild-common-style.php';
			require_once PURE_WC_SHOPBUILD_PATH . 'public/traits/woocommerce-archive.php';
			require_once PURE_WC_SHOPBUILD_PATH . 'public/traits/woocommerce-single.php';
			require_once PURE_WC_SHOPBUILD_PATH . 'public/traits/woocommerce-cart.php';
			require_once PURE_WC_SHOPBUILD_PATH . 'public/sb-product-hook.php';
		}
	
		if( $quick_settings['enable'] && class_exists('WooCommerce') ){
			require_once PURE_WC_SHOPBUILD_PATH . 'public/class-pure-wc-shopbuild-quickview.php';
		}
		if( $options['pure_wc_compare'] && class_exists('WooCommerce') ){
			require_once PURE_WC_SHOPBUILD_PATH . 'public/class-pure-wc-shopbuild-compare.php';
		}
		if( $options['pure_wc_wishlist'] && class_exists('WooCommerce') ){
			require_once PURE_WC_SHOPBUILD_PATH . 'public/class-pure-wc-shopbuild-wishlist.php';
		}
		if( $options['pure_wc_add_to_cart_notification'] && class_exists('WooCommerce') ){
			require_once PURE_WC_SHOPBUILD_PATH . 'public/class-pure-wc-shopbuild-add-to-cart-notification.php';
		}
		if( $options['pure_wc_cross_sell'] && class_exists('WooCommerce') ){
			require_once PURE_WC_SHOPBUILD_PATH . 'public/class-pure-wc-shopbuild-cross-sell.php';
		}

		$get_currency_option = Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_currency_switcher');
        if($get_currency_option['pure_wc_enable_module']){
            require_once PURE_WC_SHOPBUILD_PATH . 'public/class-pure-wc-currency-switcher.php';
        }

		$get_invoice_options = Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_invoice_settings');
		
        if($get_invoice_options['enable']){
			require_once PURE_WC_SHOPBUILD_PATH . 'admin/class-pure-wc-invoice.php';
		}
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.3
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.3
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.3
	 * @return    Pure_Wc_Shopuild_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.3
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
