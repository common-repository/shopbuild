<?php
namespace PureWCShopbuild;
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://themepure.net
 * @since      1.0.3
 *
 * @package    Pure_Wc_Shopuild
 * @subpackage Pure_Wc_Shopuild/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.3
 * @package    Pure_Wc_Shopuild
 * @subpackage Pure_Wc_Shopuild/includes
 * @author     ThemePure <themepure@gmail.com>
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Pure_Wc_Shopuild_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.3
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'shopbuild',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
