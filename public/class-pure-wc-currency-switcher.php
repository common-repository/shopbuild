<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Handle WooCommerce related functionality
 */

use PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin;

class Pure_Wc_Shopbuild_Currency_Switcher{

    private static $instance = false;


    public function __construct(){

        add_filter('woocommerce_get_price_html', [$this, 'convert_prices'], 10, 2);

    }

    // Hook into WooCommerce price display
    public function convert_prices($price, $product) {
        $price_html = '';
        $currency = isset($_GET['currency'], $_GET['_wpnonce']) && wp_verify_nonce( sanitize_text_field( wp_unslash($_GET['_wpnonce'])), 'currency-switcher-nonce') ? sanitize_text_field( wp_unslash($_GET['currency']) ) : get_woocommerce_currency();
        $currency_switcher_settings  = Pure_Wc_Shopuild_Admin::get_option('_pure_currency_switcher');
        $currencies       = $currency_switcher_settings['pure_wc_currency_switcher_list'];
        $current_currency = array_filter($currencies, function($curr) use ($currency){
            return $curr['currency'] === $currency;
        });

        $current_currency = array_values($current_currency);
        // Convert price based on selected currency and exchange rate
        $converted_price = (floatval($product->get_price()) * $current_currency[0]['rate']);
        // Check if the product is a grouped product
        if ($product->is_type('grouped')) {
            // Get child product IDs
            $child_ids = $product->get_children();

            // Initialize variables for min and max prices
            $min_price = false;
            $max_price = false;

            // Loop through child products
            foreach ($child_ids as $child_id) {
                // Get child product object
                $child_product = wc_get_product($child_id);
                
                // Get child product price
                $child_price = $child_product->get_price();

                // Update min and max prices
                if ($min_price === false || $child_price < $min_price) {
                    $min_price = (floatval($child_price) * $current_currency[0]['rate']);
                }

                if ($max_price === false || $child_price > $max_price) {
                    $max_price = (floatval($child_price) * $current_currency[0]['rate']);
                }
            }

            // Format the price range HTML
            if ($min_price !== false && $max_price !== false) {
                $price_html = wc_price($min_price, array('currency' => $currency)).' - '.wc_price($max_price, array('currency' => $currency));
                return $price_html;
            }
        }

        if($product->get_sale_price() > 0){
            $converted_price = (floatval($product->get_regular_price()) * $current_currency[0]['rate']);
            $converted_sale_price = (floatval($product->get_sale_price()) * $current_currency[0]['rate']);
            return '<del>' . wc_price($converted_price, array('currency' => $currency)) . '</del> <ins>' . wc_price($converted_sale_price, array('currency' => $currency)) . '</ins>';

        }
        return wc_price($converted_price, array('currency' => $currency));
    }

    /**
     * Init Method
     */
    public static function init(){
        if(!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }
}

Pure_Wc_Shopbuild_Currency_Switcher::init();