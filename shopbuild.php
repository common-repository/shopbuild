<?php
use \Elementor\Controls_Manager;
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://themepure.net
 * @since             1.0.3
 * @package           Pure_Wc_Shopuild
 *
 * @wordpress-plugin
 * Plugin Name:       StoreBuild
 * Plugin URI:        https://themepure.net/plugins/storebuild/
 * Description:       Build your shop with amazing woocommerce tools. Customize your shop and product page. Order invoices, order tracking now in one package.
 * Version:           1.0.3
 * Author:            ThemePure
 * Author URI:        https://themepure.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       shopbuild
 * Domain Path:       /languages
 * 
 * Requires Plugins: woocommerce, elementor
 * Elementor tested up to: 3.21.0
 * Elementor Pro tested up to: 3.21.0
 * 
 * WooCommerce tested up to: 8.8.3
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.3 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PURE_WC_SHOPBUILD_VERSION', '1.0.3' );
define( 'PURE_WC_SHOPBUILD_PATH', plugin_dir_path( __FILE__ ) );
define( 'PURE_WC_SHOPBUILD_URL', plugins_url( '/', __FILE__ ) );
define( 'PURE_WC_SHOPBUILD_PUBLIC_URL', plugins_url( '/public', __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pure-wc-shopbuild-activator.php
 */
if( !function_exists('pure_wc_shopbuild_activate') ){
	function pure_wc_shopbuild_activate() {
		require_once PURE_WC_SHOPBUILD_PATH . '/includes/class-pure-wc-shopbuild-activator.php';
		PureWCShopbuild\Pure_Wc_Shopuild_Activator::activate();
	}
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pure-wc-shopbuild-deactivator.php
 */
if( !function_exists('pure_wc_shopbuild_deactivate') ){
	function pure_wc_shopbuild_deactivate() {
		require_once PURE_WC_SHOPBUILD_PATH . '/includes/class-pure-wc-shopbuild-deactivator.php';
		PureWCShopbuild\Pure_Wc_Shopuild_Deactivator::deactivate();
	}	
}
register_activation_hook( __FILE__, 'pure_wc_shopbuild_activate' );
register_deactivation_hook( __FILE__, 'pure_wc_shopbuild_deactivate' );

// Custom register controls
function pure_wc_shopbuild_register_controls(Controls_Manager $controls_Manager){	
	require_once PURE_WC_SHOPBUILD_PATH . 'public/controls/tpgradient.php';
	$tpgradient = 'PureWCShopbuild\Elementor\Controls\Group_Control_PWCSGradient';
	$controls_Manager->add_group_control($tpgradient::get_type(), new $tpgradient());

	require_once PURE_WC_SHOPBUILD_PATH . 'public/controls/tpbggradient.php';
	$tpbggradient = 'PureWCShopbuild\Elementor\Controls\Group_Control_PWCSBGGradient';
	$controls_Manager->add_group_control($tpbggradient::get_type(), new $tpbggradient());
}
add_action('elementor/controls/controls_registered', 'pure_wc_shopbuild_register_controls');

/**
 * Add plugin custom actions links
 */
function pure_wc_shopbuild_row_actions($actions, $plugin_file) {
    $new_action = array(
        'settings' 	=> '<a href="'.admin_url('admin.php?page=pure-wc-shopbuild').'">Settings</a>',
        'pro' 		=> '<a href="https://help.themepure.net/support/" target="_blank">Go Pro</a>',
    );
    return array_merge($new_action, $actions);
}
add_filter('plugin_action_links_shopbuild/shopbuild.php', 'pure_wc_shopbuild_row_actions', 10, 2);


require_once PURE_WC_SHOPBUILD_PATH . 'functions.php';
require_once PURE_WC_SHOPBUILD_PATH . 'includes/class-pure-wc-shopbuild.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.3require_once PURE_WC_SHOPBUILD_PATH . 'admin/class-pure-wc-shopbuild-admin.php';
 */
if( !function_exists('pure_wc_shopbuild_init') ){
	function pure_wc_shopbuild_init() {

		$plugin = new PureWCShopbuild\Pure_Wc_Shopuild();
		$plugin->run();
	
	}
	pure_wc_shopbuild_init();
}

/**
 * Load the main dependecies
 */
function pure_wc_shopbuild_load(){
	// load utils
	PureWCShopbuild\Pure_Wc_Shopuild::load_utils();
	// Register Custom Post Types
	new PureWCShopbuild\Pure_Wc_Shopbuild_Post_Type(array(
		'name'				=> __( 'Templates', 'shopbuild' ),
		'plural_name'		=> __( 'Templates', 'shopbuild' ),
		'singular_name'		=> __( 'Template', 	'shopbuild' ),
		'slug'				=> 'pure_wc_template',
		'show_in_menu' 		=> false,
        'show_in_nav_menus' => false,
		'supports'      	=> ['title', 'editor', 'thumbnail', 'page-attributes', 'shopbuild']
	), 'pure_wc_template');
}
add_action( 'plugins_loaded', 'pure_wc_shopbuild_load' );
