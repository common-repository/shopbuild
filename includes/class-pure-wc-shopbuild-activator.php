<?php
namespace PureWCShopbuild;
/**
 * Fired during plugin activation
 *
 * @link       https://themepure.net
 * @since      1.0.3
 *
 * @package    Pure_Wc_Shopuild
 * @subpackage Pure_Wc_Shopuild/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.3
 * @package    Pure_Wc_Shopuild
 * @subpackage Pure_Wc_Shopuild/includes
 * @author     ThemePure <themepure@gmail.com>
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Pure_Wc_Shopuild_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.3
	 */
	private static $instance = false;

	public function __construct(){
		$this->create_wishlist_page();
	}

	public static function activate() {
		if( !self::$instance ){
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function create_wishlist_page(){
		if(!function_exists('wc_create_page')){
			// Create Wishlist Page
			$page_data = array(
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'post_author'    => 1,
                'post_name'      => 'pure-wc-wishlist',
                'post_title'     => 'Pure WC Wishlist',
                'post_content'   => '<!-- wp:shortcode -->
				[pure_wc_wishlist_table]
				<!-- /wp:shortcode -->',
                'post_parent'    => 0,
                'comment_status' => 'closed',
            );
            $page_id = wp_insert_post( $page_data );
			update_option( 'pure_wc_wishlist_page_id', $page_id );
		}else{
			// Create Wishlist Page
			wc_create_page(
				'wishlist', 
				'pure_wc_wishlist_page_id', 
				'Wishlist',
				'<!-- wp:shortcode -->
				[pure_wc_wishlist_table]
				<!-- /wp:shortcode -->'
			);
		}

		// Make Wishlist, Compare, Quick View Enabled
		update_option('_pure_shopbuild_modules', array(
			'wishlist'	=> true,
			'compare'	=> true,
			'quickview'	=> true,
		));

		flush_rewrite_rules();
	}

}
