<?php
namespace PureWCShopbuild\Admin;

use PureWCShopbuild\Pure_Wc_Template_Manager;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://themepure.net
 * @since      1.0.3
 *
 * @package    Pure_Wc_Shopuild
 * @subpackage Pure_Wc_Shopuild/admin
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly   

class Pure_Wc_Shopuild_Admin {
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
	 * Keep default values of all settings.
	 *
	 * @var array
	 * @since  1.0.3
	 */
	private static $defaults;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.3
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name = '', $version = '' ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		self::$defaults = array(
			'_pure_shopbuild_woocommerce' => array(
				'pure_wc_products_limits' 	=> 12,
				'pure_wc_shop_page_id' 		=> 0,
				'pure_wc_single_page_id' 	=> 0,
				'pure_wc_cart_page_id' 		=> 0,
				'pure_wc_checkout_page_id' 	=> 0,
				'pure_wc_thankyou_page_id' 	=> 0,
				'pure_wc_my_account_page_id'	=> 0,
				'pure_wc_my_account_login_page_id'	=> 0,
			),
			'_pure_shopbuild_elements' => array(),
			'_pure_shopbuild_modules'  => array(
				'pure_wc_wishlist'	=> false,
				'pure_wc_compare'	=> false,
				'pure_wc_quickview'	=> false,
				'pure_wc_add_to_cart_notification'	=> false,
				'pure_wc_cross_sell'	=> false,
				'pure_wc_up_sell'		=> false,
				'pure_wc_sale_badge'	=> false,
				'pure_wc_flash_sale_countdown'	=> false,
			),
			'_pure_sale_notification'  => array(
				'pure_wc_real_or_manual'			=> 'real',
				'pure_wc_fname_of_buyer'			=> 'Salim',
				'pure_wc_lname_of_buyer'			=> 'Rana',
				'pure_wc_city_of_buyer'				=> 'Mirpur',
				'pure_wc_state_of_buyer'			=> 'Dhaka',
				'pure_wc_country_of_buyer'			=> 'Bangladesh',
				'pure_wc_manual_products'			=> array(),
				'pure_wc_number_of_products'		=> 5,
				'pure_wc_how_old_product'			=> '1 week',
				'pure_wc_notification_position'		=> 'bottom_left',
				'pure_wc_first_load_time'			=> 5,
				'pure_wc_notification_interval'		=> 10,
				'pure_wc_notification_showtime'		=> 4,
				'pure_wc_enable_sale_notification'	=> false
			),
			'_pure_currency_switcher'  => array(
				'pure_wc_enable_module'	=> false,	
				'pure_wc_currency_switcher_list'	=> array(
					array(
						'currency'	=> 'USD',
						'rate'		=> 1,
						'symbol'	=> '$',
						'position'	=> 'left',
						'display'	=> true
					),
					array(
						'currency'	=> 'EUR',
						'rate'		=> 0.85,
						'symbol'	=> '€',
						'position'	=> 'left',
						'display'	=> true
					)
				)
			),
			'_pure_invoice_settings'	=> array(
				'enable'		=> false,
				'invoice_logo'	=> array(
					'url'	=> PURE_WC_SHOPBUILD_URL . 'admin/img/logo.png',
					'alt'	=> esc_html__('Shopbuild', 'shopbuild')
				),
				'invoice_phone'	=> esc_html__('+880 123 456 789', 'shopbuild'),
				'invoice_email'	=> get_option('admin_email'),
				'invoice_address'		=> esc_html__('Mirpur, Dhaka, Bangladesh', 'shopbuild'),
				'invoice_footer_note' 	=> esc_html__('Thank you for shopping with us.', 'shopbuild'),
				'invoice_terms'	=> esc_html__('Lorem, ipsum dolor sit amet consectetur adipisicing elit. Expedita laborum aut aspernatur vero tenetur. Non quo provident tempore laborum laboriosam aut architecto, mollitia, vero eveniet quae, beatae dolores incidunt animi.', 'shopbuild'),
			),
			'_pure_quickview_settings'	=> array(
				'enable'		=> false,
				'template_type'	=> 'default',
				'template'	=> 1,
			),
			'_pure_quick_checkout_settings'	=> array(
				'enable'		=> false,
				'template_type'	=> 'default',
				'template'	=> 1,
				'show_in_archive'	=> false,
				'button_text'	=> apply_filters('pure_wc_quick_checkout_button_text', esc_html__('Buy Now', 'shopbuild')),
			),
			'_pure_preorder_settings'	=> array(
				'enable'				=> false,
				'enable_countdown'		=> false,
				'manage_price_label'	=> '{original_price} Pre order price: {preorder_price}',
				'availability_date_label'	=> 'Available on: {availability_date}',
			),
			'_pure_backorder_settings'	=> array(
				'enable'		=> false,
				'limit'	=> 0,
				'availability_date'	=> '',
				'availability_message'	=> 'On Backorder: Will be available on {availability_date}',
			),
			'_pure_shopbuild_styles'   => array(),
			'_pure_shopbuild_settings' => array(
				'pure_wc_enable_all_elements' => true,
				'pure_wc_enable_all_modules'  => true
			),
			'_pure_shopbuild_elements' => $this->elementor_addons()
		);
	}

	public static function get_templates_by_type( $type = 'shop' ){
        $templates = array(
			array(
				'value' => -1,
				'label' => 'Choose Template'
			)
		);
        $get_posts = get_posts( array(
            'post_type' => 'pure_wc_template',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_pure_wc_shopbuild_tmpl_type',
                    'value' => $type,
                    'compare' => '='
                )
            )
        ) );
        if(!empty($get_posts)){
            foreach($get_posts as $post){
                $templates[] = array(
					'value' => $post->ID,
					'label' => $post->post_title
				);
            }
        }
        
        return $templates;
    }

	/**
	 * Register Settings
	 */
	public function register_settings(){
		$currency_default_settings = array(
			'pure_wc_currency_switcher_list'	=> array(
				array(
					'currency'	=> 'USD',
					'rate'		=> 1,
					'symbol'	=> '$',
					'position'	=> 'left',
					'display'	=> true
				),
				array(
					'currency'	=> 'EUR',
					'rate'		=> 0.85,
					'symbol'	=> '€',
					'position'	=> 'left',
					'display'	=> true
				)
			),
		);
		$currency_schema  = array(
			'type'       => 'object',
			'properties' => array(
				'pure_wc_currency_switcher_list'	=> array(
					'type'  => 'array',
					'items' => array(
						'type' => 'object',
						'properties' => array(
							'currency'	=> array( 'type' => 'string' ),
							'rate'		=> array( 'type' => 'number' ),
							'symbol'	=> array( 'type' => 'string' ),
							'position'	=> array( 'type' => 'string' ),
							'display'	=> array( 'type' => 'boolean' ),
						),
					),
				),
				'pure_wc_enable_module'	=> array(
					'type'  => 'boolean'
				),
			),
		);
		register_setting(
			'options',
			'_pure_currency_switcher',
			array(
				'type'         => 'object',
				'default'      => $currency_default_settings,
				'show_in_rest' => array(
					'schema' => $currency_schema,
				),
			)
		);

		$invoice_settings = array(
			'_pure_invoice_settings'	=> array(
				'enable'		=> false,
				'invoice_logo'	=> array(
					'url'	=> PURE_WC_SHOPBUILD_URL . 'admin/img/logo.png',
					'alt'	=> esc_html__('Shopbuild', 'shopbuild')
				),
				'invoice_phone'	=> esc_html__('+880 123 456 789', 'shopbuild'),
				'invoice_email'	=> get_option('admin_email'),
				'invoice_address'		=> esc_html__('Mirpur, Dhaka, Bangladesh', 'shopbuild'),
				'invoice_footer_note' 	=> esc_html__('Thank you for shopping with us.', 'shopbuild'),
				'invoice_terms'	=> esc_html__('Lorem, ipsum dolor sit amet consectetur adipisicing elit. Expedita laborum aut aspernatur vero tenetur. Non quo provident tempore laborum laboriosam aut architecto, mollitia, vero eveniet quae, beatae dolores incidunt animi.', 'shopbuild'),
			)
		);
		$invoice_settings_schema  = array(
			'type'       => 'object',
			'properties' => array(
				'enable'		=> array(
					'type'  => 'boolean'
				),
				'invoice_logo'	=> array(
					'type' => 'object',
					'properties' => array(
						'url'	=> array( 'type' => 'string' ),
						'alt'	=> array( 'type' => 'string' ),
					),
				),
				'invoice_phone'	=> array(
					'type'  => 'string'
				),
				'invoice_email'	=> array(
					'type'  => 'string'
				),
				'invoice_address'		=> array(
					'type'  => 'string'
				),
				'invoice_footer_note' 	=> array(
					'type'  => 'string'
				),
				'invoice_terms'	=> array(
					'type'  => 'string'
				),
			),
		);
		
		register_setting(
			'options',
			'_pure_invoice_settings',
			array(
				'type'         => 'object',
				'default'      => $invoice_settings,
				'show_in_rest' => array(
					'schema'   => $invoice_settings_schema,
				),
			)
		);

		$quickview_settings = array(
			'_pure_quickview_settings'	=> array(
				'enable'		=> false,
				'template_type'	=> 'default',
				'template'	=> 1,
			)
		);
		$quickview_settings_schema  = array(
			'type'       => 'object',
			'properties' => array(
				'enable'		=> array(
					'type'  => 'boolean'
				),
				'template_type'	=> array(
					'type' => 'string',
				),
				'template'	=> array(
					'type'  => 'number'
				)
			),
		);
		
		register_setting(
			'options',
			'_pure_quickview_settings',
			array(
				'type'         => 'object',
				'default'      => $quickview_settings,
				'show_in_rest' => array(
					'schema'   => $quickview_settings_schema,
				),
			)
		);

		$quick_checkout_settings = array(
			'_pure_quick_checkout_settings'	=> array(
				'enable'		=> false,
				'template_type'	=> 'default',
				'template'	=> 1,
				'show_in_archive'	=> false,
				'button_text'	=> apply_filters('pure_wc_quick_checkout_button_text', esc_html__('Buy Now', 'shopbuild')),
			)
		);
		$quick_checkout_settings_schema  = array(
			'type'       => 'object',
			'properties' => array(
				'enable'		=> array(
					'type'  => 'boolean'
				),
				'template_type'	=> array(
					'type' => 'string',
				),
				'template'	=> array(
					'type'  => 'number'
				),
				'show_in_archive'		=> array(
					'type'  => 'boolean'
				),
				'button_text'	=> array(
					'type' => 'string',
				),
			),
		);
		
		register_setting(
			'options',
			'_pure_quick_checkout_settings',
			array(
				'type'         => 'object',
				'default'      => $quick_checkout_settings,
				'show_in_rest' => array(
					'schema'   => $quick_checkout_settings_schema,
				),
			)
		);

		$backorder_settings = array(
			'_pure_backorder_settings'	=> array(
				'enable'			=> false,
				'limit'	=> 0,
				'availability_date'	=> '',
				'availability_message'	=> 'On Backorder: Will be available on {availability_date}',
			)
		);
		$backorder_settings_schema  = array(
			'type'       => 'object',
			'properties' => array(
				'enable'		=> array(
					'type'  	=> 'boolean'
				),
				'limit'	=> array(
					'type' 	=> 'number',
				),
				'availability_date'	=> array(
					'type'  => 'string',
				),
				'availability_message'	=> array(
					'type'  => 'string',
				)
			),
		);
		
		register_setting(
			'options',
			'_pure_backorder_settings',
			array(
				'type'         => 'object',
				'default'      => $backorder_settings,
				'show_in_rest' => array(
					'schema'   => $backorder_settings_schema,
				),
			)
		);

		$preorder_settings = array(
			'_pure_preorder_settings'	=> array(
				'enable'			=> false,
				'enable_countdown'	=> false,
				'manage_price_label'		=> '{original_price} Pre order price: {preorder_price}',
				'availability_date_label'	=> 'Available on: {availability_date}',
			)
		);
		$preorder_settings_schema  = array(
			'type'       => 'object',
			'properties' => array(
				'enable'		=> array(
					'type'  	=> 'boolean'
				),
				'manage_price_label'	=> array(
					'type'  => 'string',
				),
				'availability_date_label'	=> array(
					'type'  => 'string',
				),
				'enable_countdown'		=> array(
					'type'  	=> 'boolean'
				),
			),
		);
		
		register_setting(
			'options',
			'_pure_preorder_settings',
			array(
				'type'         => 'object',
				'default'      => $preorder_settings,
				'show_in_rest' => array(
					'schema'   => $preorder_settings_schema,
				),
			)
		);
	}

	/**
	 * Show notices
	 */
	public function notices(){
		$installed_plugins = get_plugins();
		$woocommerce = 'woocommerce/woocommerce.php';
		$is_woocommerce_installed = isset( $installed_plugins[ $woocommerce ] );

		if( $is_woocommerce_installed  ){
			$woo_message = __( 'Please activate <strong>WooCommerce</strong> plugin as the dependency for this plugin to run.', 'shopbuild' );
			$woo_button_link = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $woocommerce . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $woocommerce );
			
		}else{
			$woo_message = __( 'Please install <strong>WooCommerce</strong> plugin as the dependency for this plugin to run.', 'shopbuild' );
			$woo_button_link = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ), 'install-plugin_woocommerce' );
		}
		if( !class_exists('WooCommerce', false) ){
			?>
			<div class="notice notice-error is-dismissible">
				<p><?php print wp_kses_post($woo_message); ?></p>
				<p><a class="button-primary" href="<?php echo esc_url($woo_button_link); ?>"><?php esc_html_e('Activate WooCommerce', 'shopbuild'); ?></a></p>
			</div>
			<?php
		}

		$elementor = 'elementor/elementor.php';

		$is_elementor_installed = isset( $installed_plugins[ $elementor ] );
		if( $is_elementor_installed  ){
			$elementor_message = __( 'Please activate <strong>Elementor</strong> plugin as the dependency for this plugin to run.', 'shopbuild' );
			$elementor_button_link = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $elementor . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $elementor );
			
		}else{
			$elementor_message = __( 'Please install <strong>Elementor</strong> plugin as the dependency for this plugin to run.', 'shopbuild' );
			$elementor_button_link = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
		}
		
	
		if( ! did_action( 'elementor/loaded' ) ){
			?>
			<div class="notice notice-error is-dismissible">
				<p><?php print wp_kses_post($elementor_message); ?></p>
				<p><a class="button-primary" href="<?php echo esc_url($elementor_button_link); ?>"><?php esc_html_e('Activate Elementor', 'shopbuild'); ?></a></p>
			</div>
			<?php
		}
	}

	/**
	 * Get all the settings from DB
	 */

	public function get_settings(){
		$defaults = self::$defaults;
		$settings = array();
		foreach( $defaults as $key => $data ){
			$settings[$key] = $this->get_option($key);
		}

		return $settings;
	}

	/**
	 * Addons For Admin and React Settings
	 */

	public function elementor_addons(){
		$default_addons = function_exists('pure_wc_elementor_addons')? pure_wc_elementor_addons() : array();

		return $default_addons;
	}

	public static function get_all_products(){
		$products = function_exists('wc_get_products') ? wc_get_products(array(
			'limit'  => -1,
			'status' => 'publish',
		)) : array();

		$_products_arr = array(
			array(
				'value' => -1,
				'label'	=> 'Choose products'
			)
		);
		if( !empty($products) ){
			foreach($products as $product){
				$_products_arr[] = array(
					'value' => $product->get_id(),
					'label' => $product->get_name(),
				);
			}
		}

		return $_products_arr;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.3
	 */
	public function enqueue_styles( $admin_page ) {

		$_screen = get_current_screen();

		wp_enqueue_style( 'storebuild-icons', plugin_dir_url( __FILE__ ) . 'css/storebuild-icons.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'storebuild-admin', plugin_dir_url( __FILE__ ) . 'css/admin.css', array(), $this->version, 'all' );

		if ( 'toplevel_page_shopbuild' !== $admin_page && $_screen->post_type !== 'pure_wc_template' ) {
			return;
		}

		$asset_file = plugin_dir_path( __DIR__ ) . 'build/index.asset.php';

		if ( ! file_exists( $asset_file ) ) {
			return;
		}

		$asset = include $asset_file;

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
		
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pure-wc-shopbuild-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'pure-wc-toaster', plugin_dir_url( __FILE__ ) . 'css/pure-wc-toastr.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'pure-nice-select', plugin_dir_url( __FILE__ ) . 'css/nice-select.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'pure-wc-popup', plugin_dir_url( __FILE__ ) . 'css/pure-wc-popup.css', array(), $this->version, 'all' );
		wp_enqueue_style( 
			'react-style', 
			plugin_dir_url( __DIR__ ) . 'build/index.css', 
			array_filter(
				$asset['dependencies'],
				function ( $style ) {
					return wp_style_is( $style, 'registered' );
				}
			),
			$this->version
		);
		wp_enqueue_style( 'wp-components' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.3
	 */
	public function enqueue_scripts( $admin_page ) {
		wp_enqueue_script( 
			'storebuild-admin', 
			plugin_dir_url( __DIR__ ) . 'admin/js/admin.js', 
			array('jquery'),
			$this->version, 
			['in_footer' => true] 
		);

		$_screen = get_current_screen();
		if ( 'toplevel_page_shopbuild' !== $admin_page && $_screen->post_type !== 'pure_wc_template' ) {
			return;
		}

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tp_Wvs_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tp_Wvs_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_media();
		if('toplevel_page_shopbuild' == $admin_page){
			$asset_file = plugin_dir_path( __DIR__ ) . 'build/index.asset.php';
	
			if ( ! file_exists( $asset_file ) ) {
				return;
			}
	
			$asset = include $asset_file;
			// Build the dynamic URL
			$variation_plugin_url = add_query_arg(
				array(
					's' => 'pure variation swatches',
					'tab' => 'search',
					'type' => 'term'
				),
				admin_url('plugin-install.php')
			);
			$data = apply_filters('storebuild_react_data', array(
				'default_currency'	=> array(
					'currency'	=> class_exists('WooCommerce')? get_woocommerce_currency() : 'USD',
					'symbol'	=> class_exists('WooCommerce')? get_woocommerce_currency_symbol() : '$',
				),
				'templates' => \Pure_Wc_Shopuild_Helper::get_templates(),
				'quickview_templates' => self::get_templates_by_type('quickview'),
				'settings' 	=> $this->get_settings(),
				'pure_swatches_settings' => function_exists('pure_swatches_admin')? pure_swatches_admin()->get_settings() : array(),
				'pure_products' => self::get_all_products(),
				'ajax_url' 		=> admin_url('admin-ajax.php'),
				'nonce'			=> wp_create_nonce('pure_wc_shopbuild_save'),
				'variation_swatch' 	=> $variation_plugin_url,
			));

			wp_enqueue_script( 
				'pure-wc-shopbuild-react-script', 
				plugin_dir_url( __DIR__ ) . 'build/index.js', 
				$asset['dependencies'],
				$this->version, 
				['in_footer' => true] 
			);
			wp_localize_script('pure-wc-shopbuild-react-script', 'pure_wc_shopbuild', $data);
		}

		if($_screen->post_type == 'pure_wc_template'){

			$get_templates = \PureWCShopbuild\Pure_Wc_Template_Manager::get_templates();
			
			$data = array(
				'types'	 => array(
					array( "label" => "Shop", "value" => "shop" ),
					array( "label" => "Single", "value" => "single" ),
					array( "label" => "Cart", "value" => "cart" ),
					array( "label" => "Checkout", "value" => "checkout" ),
					array( "label" => "Thank You", "value" => "thankyou" ),
					array( "label" => "My Account", "value" => "myaccount" ),
					array( "label" => "My Account Login", "value" => "myaccountlogin" ),
					array( "label" => "Quickview", "value" => "quickview" ),
				),
				'ajax_url' 		=> admin_url('admin-ajax.php'),
				'plugin_url' 	=> PURE_WC_SHOPBUILD_URL,
				'plugin_path' 	=> PURE_WC_SHOPBUILD_PATH,
				'api_url' 		=> \PureWCShopbuild\Pure_Wc_Template_Manager::API_URL,
				'templates' 	=> $get_templates,
				'old_templates' => $get_templates,
				'template_nonce'		=> wp_create_nonce('pure_wc_shopbuild_save_template'),
				'template_get_nonce'	=> wp_create_nonce('pure_wc_shopbuild_get_template'),
				'admin_post_url' 		=> admin_url('post.php')
			);
			wp_enqueue_script('pure-wc-toaster', plugin_dir_url(__DIR__). 'admin/js/pure-wc-toastr.js', array('jquery'), $this->version, true);
			wp_enqueue_script('nice-select', plugin_dir_url(__DIR__). 'admin/js/nice-select.js', array('jquery'), $this->version, true);
			wp_enqueue_script('pure-wc-popup', plugin_dir_url(__DIR__). 'admin/js/pure-wc-popup.js', array('jquery'), $this->version, true);
			wp_enqueue_script('pure-wc-template-manager', plugin_dir_url(__DIR__). 'admin/js/pure-wc-template-manager.js', array('jquery'), $this->version, true);
			wp_localize_script('pure-wc-template-manager', 'PURE_WC_SHOPBUILD', $data);
		}
		
	}

	// save template
    public function save_template(){
        check_ajax_referer( 'pure_wc_shopbuild_save_template', 'security' );

        if( !current_user_can('manage_options') && !isset($_POST['security']) && !wp_verify_nonce( sanitize_text_field(wp_unslash($_POST['security'])), 'pure_wc_shopbuild_save_template')){
            $errormessage = array(
				'message'  => __('Nonce Varification Faild !','shopbuild')
			);
			wp_send_json_error( $errormessage );
        }

        $template_name  = isset($_POST['template_name'])? sanitize_text_field(wp_unslash($_POST['template_name'])) : '';
        $template_type  = isset($_POST['template_type'])? sanitize_text_field(wp_unslash($_POST['template_type'])) : '';
        $set_as_default = isset($_POST['set_as_default'])? sanitize_text_field(wp_unslash($_POST['set_as_default'])) : 'default';
        $template_demo 	= isset($_POST['template_demo'])? sanitize_text_field(wp_unslash($_POST['template_demo'])) : '';
        $template_demo_id 	= isset($_POST['template_demo_id'])? sanitize_text_field(wp_unslash($_POST['template_demo_id'])) : '';
        $post_id 		= isset($_POST['template_id'])? sanitize_text_field(wp_unslash($_POST['template_id'])) : '';
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
		$wp_rewrite->init();

		if(!empty($post_id) && isset($post_id)){
			$update_args = array(
				'ID'			=> $post_id,
				'post_title'	=> $template_name
			);

			$template_id = wp_update_post( $update_args, true, true );
		}else{
			$template_id = wp_insert_post([
				'post_title'  => $template_name,
				'post_status' => 'publish',
				'post_type'   => \PureWCShopbuild\Pure_Wc_Template_Manager::CPT_TYPE
			]);
		}

        if( !is_wp_error($template_id) ){
			update_post_meta( $template_id, '_pure_wc_shopbuild_tmpl_type', $template_type);
            $this->update_the_default_template_option($template_id, $set_as_default);
			update_post_meta( $template_id, '_wp_page_template', 'elementor_header_footer' );
			update_post_meta( $template_id, '_elementor_edit_mode', 'builder' );

			if(!empty($template_demo)){
				require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
				require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';
	
				$wp_filesystem 		= new \WP_Filesystem_Direct(null);
				$template_data 		= $wp_filesystem->get_contents($template_demo);
				$template_decode 	= json_decode($template_data, true );
				$template_content 	= !is_null($template_data)? $template_decode['content'] : '';
				update_post_meta( $template_id, '_elementor_data', $template_content );
				self::set_default_template($template_type, $template_demo_id);
			}else{
				// update_post_meta( $template_id, '_elementor_data', '' );
				// // Optional: Clear the _elementor_edit_mode to ensure no issues in Elementor editor.
				// update_post_meta( $template_id, '_elementor_edit_mode', '' );
				// update_post_meta( $template_id, '_elementor_page_assets', '' );
				// update_post_meta( $template_id, '_elementor_css', '' );
				// $update_args = array(
				// 	'ID'			=> $template_id,
				// 	'post_content'	=> ''
				// );
				// wp_update_post( $update_args, true, true );

			}
			if( $set_as_default == 'default' ){
				$this->save_template_as_default($template_type, $template_id);
			}
			if( $set_as_default == 'inactive' ){
				$this->save_template_as_default($template_type, 0);
			}

            wp_send_json_success(array(
                'ID'    		=> $template_id,
                'editor_url'    => self::get_edit_with_elementor_link( $template_id )
            ), 200);
        }
    }

	// update default template
	public function update_the_default_template_option($template_id, $set_as_default){
		update_post_meta( $template_id, '_pure_wc_shopbuild_tmpl_set_as', $set_as_default);
	}

	// save option for default template
	public static function set_default_template($type, $template_id){
		if( $type == 'shop' ){
            return update_option('pure_wc_shop_template', $template_id);
        }else if( $type == 'single' ){
            return update_option('pure_wc_single_template', $template_id);
        }else if( $type == 'cart' ){
			return update_option('pure_wc_cart_template', $template_id);
        }else if( $type == 'checkout' ){
			return update_option('pure_wc_checkout_template', $template_id);
        }else if( $type == 'thankyou' ){
            return update_option('pure_wc_thankyou_template', $template_id);
        }else if( $type == 'myaccount' ){
            return update_option('pure_wc_myaccount_template', $template_id);
        }else if( $type == 'myaccountlogin' ){
            return update_option('pure_wc_myaccountlogin_template', $template_id);
        }else{
            return false;
        }
	}

	public function delete_meta_on_trash_custom_post_type($post_id) {
		// Get the post type of the post being trashed
		$post_type = get_post_type($post_id);
	
		// Check if the post is of the custom post type you want to target
		if ($post_type === 'pure_wc_template') {
			// Get all post meta for the post
			$post_meta = get_post_meta($post_id);

			$template_type = get_post_meta( $post_id, '_pure_wc_shopbuild_tmpl_type', true);
			self::set_default_template($template_type, 0);
			
			// Loop through and delete each meta key
			foreach ($post_meta as $meta_key => $meta_value) {
				delete_post_meta($post_id, $meta_key);
			}
		}
	}

	// save option for default template
	public static function check_default_template($type){
		if( $type == 'shop' ){
            return get_option('pure_wc_shop_template');
        }else if( $type == 'single' ){
            return get_option('pure_wc_single_template');
        }else if( $type == 'cart' ){
			return get_option('pure_wc_cart_template');
        }else if( $type == 'checkout' ){
			return get_option('pure_wc_checkout_template');
        }else if( $type == 'thankyou' ){
            return get_option('pure_wc_thankyou_template');
        }else if( $type == 'myaccount' ){
            return get_option('pure_wc_myaccount_template');
        }else if( $type == 'myaccountlogin' ){
            return get_option('pure_wc_myaccountlogin_template');
        }else{
            return false;
        }
	}

	// get template
    public function get_template(){
        check_ajax_referer( 'pure_wc_shopbuild_get_template', 'security' );
        if( !current_user_can('manage_options') && !isset($_POST['security']) && !wp_verify_nonce( sanitize_text_field(wp_unslash($_POST['security'])), 'pure_wc_shopbuild_get_template')){
            $errormessage = array(
				'message'  => __('Nonce Varification Faild !','shopbuild')
			);
			wp_send_json_error( $errormessage );
        }

        $template_id  = isset($_POST['ID'])? sanitize_text_field(wp_unslash($_POST['ID'])) : -1;
		$tmpl_data = get_post($template_id, ARRAY_A);
        if( !empty($tmpl_data) ){
            $tmpl_type = get_post_meta( $template_id, '_pure_wc_shopbuild_tmpl_type', true);
            $tmpl_set_as = get_post_meta( $template_id, '_pure_wc_shopbuild_tmpl_set_as', true);
            wp_send_json_success(array(
                'title'    		=> $tmpl_data['post_title'],
                'type'    		=> $tmpl_type,
				'set_as'		=> $tmpl_set_as
            ), 200);
        }
    }

    public static function get_edit_with_elementor_link( $template_id ){
        $args = array(
            'post'      => $template_id,
            'action'    => 'elementor'
        );
        
        return add_query_arg($args, admin_url('post.php'));
    }

	public function add_column_to_templates( $columns ){
		$columns['_pure_wc_shopbuild_tmpl_type']	= __('Type', 'shopbuild');
		$columns['_pure_wc_shopbuild_tmpl_set_as']	= __('Set as', 'shopbuild');
		return $columns;
	}

	public function get_templates_column_data( $column, $post_id ){
		switch($column){
			case '_pure_wc_shopbuild_tmpl_type':
				echo esc_html(get_post_meta( $post_id, $column, true ) );
				break;
			case '_pure_wc_shopbuild_tmpl_set_as':
				echo esc_html(get_post_meta( $post_id, $column, true ) );
				break;
			default:
				echo esc_html__('Not data fond!', 'shopbuild');
		}
	}

	public function save_template_as_default( $type, $template_id ){
		if( !current_user_can('manage_options') ){
			$errormessage = array(
				'message'  => __('You dont have enough permission!','shopbuild')
			);
			wp_send_json_error( $errormessage );
		}
        $woocoomerce_settings  = $this->get_option('_pure_shopbuild_woocommerce');
        if( $type == 'shop' ){
            $woocoomerce_settings['pure_wc_shop_page_id'] = $template_id;
        }else if( $type == 'single' ){
            $woocoomerce_settings['pure_wc_single_page_id'] = $template_id;
        }else if( $type == 'cart' ){
            $woocoomerce_settings['pure_wc_cart_page_id'] = $template_id;
        }else if( $type == 'checkout' ){
            $woocoomerce_settings['pure_wc_checkout_page_id'] = $template_id;
        }else if( $type == 'thankyou' ){
            $woocoomerce_settings['pure_wc_thankyou_page_id'] = $template_id;
        }else if( $type == 'myaccount' ){
            $woocoomerce_settings['pure_wc_my_account_page_id'] = $template_id;
        }else if( $type == 'myaccountlogin' ){
            $woocoomerce_settings['pure_wc_my_account_login_page_id'] = $template_id;
        }else{
            return $this->update_settings('_pure_shopbuild_woocommerce', wp_json_encode($woocoomerce_settings));
        }
		
		self::set_all_templates_inactive( $type, $template_id );

        return $this->update_settings('_pure_shopbuild_woocommerce', wp_json_encode($woocoomerce_settings));
    }

	/**
	 * Update template status
	 */
	public static function set_all_templates_inactive( $type, $exclude_id = '' ){
		$args = array(
			'post_type' 		=> \PureWCShopbuild\Pure_Wc_Template_Manager::CPT_TYPE,
			'fields'			=> 'ids',
			'numberposts'		=> -1,
			'meta_query'		=> array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				array(
					'key'	=> '_pure_wc_shopbuild_tmpl_type',
					'value'	=> $type
				)
			),
			'post__not_in'		=> array($exclude_id) // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_post__not_in
		);

		if(!empty($exclude_id)){
			$args['post__not_in'] = array($exclude_id);
		}

		$all_posts = get_posts($args);

		if(!empty($all_posts)){
			foreach($all_posts as $post){
				update_post_meta($post, '_pure_wc_shopbuild_tmpl_set_as', 'inactive');
			}
		}
		wp_reset_postdata();
	}

	/**
	 * Render Template Popup
	 */
	public function render_template_popup(){
		$_screen = get_current_screen();
		if($_screen->post_type == 'pure_wc_template'){
			?>
			<div id="pure-wc-shopbuild-tmpl-popup"></div>
			<?php
			include(PURE_WC_SHOPBUILD_PATH . 'admin/app/template-popup.php');
		}
	}


	/**
	* Admin Settings Menus Page
	*/
	public function admin_settings_menu(){
		add_menu_page(
			__('StoreBuild', 'shopbuild'),
			__('StoreBuild', 'shopbuild'),
			'manage_options',
			$this->plugin_name,
			array($this, 'admin_settings_template'),
			'dashicons-storebuild',
			55
		);

		add_submenu_page(
			$this->plugin_name,
			__('Templates', 'shopbuild'),
			__('Templates', 'shopbuild'),
			'manage_options',
			'edit.php?post_type=pure_wc_template',
			'',
			5
		);

		if(!pure_wc_is_pro_active()){
			add_submenu_page(
				$this->plugin_name,
				__('Go Premium', 'shopbuild'), // Page title
				__('Go Premium', 'shopbuild'), // Menu title
				'manage_options', // Capability
				'shopbuild_go_premium', // Menu slug
				function () {
					// Redirect to the external URL
					wp_redirect('https://themepure.net/plugins/storebuild/pricing/');
					exit;
				},
				5 // Position
			);
		}
	}

	/**
	 * 
	 * Admin Settings Template
	 */

	public function admin_settings_template(){
		require_once plugin_dir_path(__FILE__) . 'app/app.php';
	}

	/**
	 * 
	 * React Base URL
	 */
	public function admin_react_base_url(){
		$home_url = isset($_SERVER['HTTP_HOST'])? sanitize_url(wp_unslash($_SERVER['HTTP_HOST'])) : '';
		if(is_ssl()){
			$home_url = esc_url("https://{$home_url}"); 
		}else{
			$home_url = esc_url("http://{$home_url}"); 
		}

		$react_base_url = str_replace($home_url, '', menu_page_url($this->plugin_name, false));
		return esc_url($react_base_url);
	}

	/**
	 * Ajax handler for submit action on settings page.
	 * Updates settings data in database.
	 *
	 * @return void
	 * @since  1.0.3
	 */
	public function pure_wc_shopbuild_save() {
		check_ajax_referer( 'pure_wc_shopbuild_save', 'security' );

		// Check if user has permission to save settings.
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( [ 'message' => __( 'You do not have permission to save settings.', 'shopbuild' ) ] );
		}

		$keys = [];
		if ( ! empty( $_POST[ '_pure_shopbuild_woocommerce' ] ) ) {
			$keys[] = '_pure_shopbuild_woocommerce';
		}

		if ( ! empty( $_POST[ '_pure_shopbuild_elements' ] ) ) {
			$keys[] = '_pure_shopbuild_elements';
		}

		if ( ! empty( $_POST[ '_pure_shopbuild_modules' ] ) ) {
			$keys[] = '_pure_shopbuild_modules';
		}

		if ( ! empty( $_POST[ '_pure_shopbuild_styles' ] ) ) {
			$keys[] = '_pure_shopbuild_styles';
		}

		if ( ! empty( $_POST[ '_pure_sale_notification' ] ) ) {
			$keys[] = '_pure_sale_notification';
		}
		if ( ! empty( $_POST[ '_pure_shopbuild_settings' ] ) ) {
			$keys[] = '_pure_shopbuild_settings';
		}

		if ( empty( $keys ) ) {
			wp_send_json_error( [ 'message' => __( 'No valid setting keys found.', 'shopbuild' ) ] );
		}

		$succeded = 0;
		foreach ( $keys as $key ) {
			if( "_pure_shopbuild_woocommerce" == $key ){
				$wc_settings = isset($_POST[ $key ])? sanitize_text_field(wp_unslash($_POST[ $key ])) : '';
				$wc_settings = ! empty( $wc_settings ) ? json_decode( stripslashes( $wc_settings ), true ) : array(); // phpcs:ignore
				
				if(intval($wc_settings['pure_wc_shop_page_id']) > 0){
					$this->update_the_default_template_option(intval($wc_settings['pure_wc_shop_page_id']), 'default');
				}else{
					$this->set_all_templates_inactive('shop');
				}
				if(intval($wc_settings['pure_wc_single_page_id']) > 0){
					$this->update_the_default_template_option(intval($wc_settings['pure_wc_single_page_id']), 'default');
				}else{
					$this->set_all_templates_inactive('single');
				}
				if(intval($wc_settings['pure_wc_cart_page_id']) > 0){
					$this->update_the_default_template_option(intval($wc_settings['pure_wc_cart_page_id']), 'default');
				}else{
					$this->set_all_templates_inactive('cart');
				}
				if(intval($wc_settings['pure_wc_checkout_page_id']) > 0){
					$this->update_the_default_template_option(intval($wc_settings['pure_wc_checkout_page_id']), 'default');
				}else{
					$this->set_all_templates_inactive('checkout');
				}
				if(intval($wc_settings['pure_wc_thankyou_page_id']) > 0){
					$this->update_the_default_template_option(intval($wc_settings['pure_wc_thankyou_page_id']), 'default');
				}else{
					$this->set_all_templates_inactive('thankyou');
				}
				if(intval($wc_settings['pure_wc_my_account_page_id']) > 0){
					$this->update_the_default_template_option(intval($wc_settings['pure_wc_my_account_page_id']), 'default');
				}else{
					$this->set_all_templates_inactive('myaccount');
				}
				if(intval($wc_settings['pure_wc_my_account_login_page_id']) > 0){
					$this->update_the_default_template_option(intval($wc_settings['pure_wc_my_account_login_page_id']), 'default');
				}else{
					$this->set_all_templates_inactive('myaccountlogin');
				}
			}
			if ( $this->update_settings( $key, (isset($_POST[ $key ])? sanitize_text_field(wp_unslash($_POST[ $key ])) : '' )) ) {
				$succeded++;
			}
		}

		if ( count( $keys ) === $succeded ) {
			wp_send_json_success( [ 'message' => __( 'Settings saved successfully.', 'shopbuild' ) ] );
		}

		wp_send_json_error( [ 'message' => __( 'Failed to save settings.', 'shopbuild' ) ] );
	}

	/**
	 * Get option value from database and retruns value merged with default values
	 *
	 * @param string $option option name to get value from.
	 * @return array
	 * @since  1.0.3
	 */
	public static function get_option( $option ) {
		$db_values = get_option( $option, [] );
		return wp_parse_args( $db_values, self::$defaults[ $option ] );
	}

	/**
	 * Update dettings data in database
	 *
	 * @param string $key options key.
	 * @param string $data user input to be saved in database.
	 * @return boolean
	 * @since  1.0.3
	 */
	public static function update_settings( $key, $data ) {
		$data = ! empty( $data) ? json_decode( stripslashes( $data ), true ) : array(); // phpcs:ignore
		$default_data = self::get_option( $key );
		if ( $data === $default_data ) {
			return true;
		}
		$data = wp_parse_args( $data, $default_data );
		return update_option( $key, $data );
	}

}
