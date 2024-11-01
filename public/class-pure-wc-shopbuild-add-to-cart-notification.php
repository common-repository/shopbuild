<?php
namespace PureWCShopbuild\Frontend;
/**
 * Quick View Class For Product
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Pure_Wc_Shopbuild_Add_To_Cart_Notification {
    private static $instance;

    public function __construct() {
        // add_filter( 'wc_add_to_cart_message', array( $this, 'add_to_cart_message' ), 10, 2 );
        add_filter( 'wc_add_to_cart_message_html', array( $this, 'add_to_cart_message_html' ), 10, 2 );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'add_to_cart_fragments' ) );
        add_action( 'woocommerce_add_to_cart', array($this, 'get_recently_added_product_id'), 10, 6);
        add_action( 'wp_footer', array( $this, 'footer') );  
    }

    // public function add_to_cart_message( $message, $product_id ) {
    //     $product = wc_get_product( $product_id );
    //     $product_name = $product->get_name();
    //     $message = sprintf( '%s has been added to your cart.', $product_name );
    //     return $message;
    // }

    public function add_to_cart_message_html( $message, $products ) {
        // Customize your message here
        // $products is an array of product IDs or an array of product data for the items added to the cart
        $product_id = !empty($products)? array_keys($products)[0] : pure_wc_get_last_product_id();
        $product = wc_get_product( $product_id );
        // Example: Custom message
        // Translators: %s is the product label.
        $custom_message = sprintf( __( '%s has been successfully added to your cart!', 'shopbuild' ), $product->get_name() );
    
        return $custom_message; // Return the custom message
    }

    public static function get_instance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Enqueue scripts
     */
    public function enqueue_scripts() {
        wp_enqueue_script( 'pure-wc-cart-notification', PURE_WC_SHOPBUILD_URL . 'public/js/pure-wc-cart-notification.js', array( 'jquery' ), PURE_WC_SHOPBUILD_VERSION, true );
    }

    public function get_recently_added_product_id($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data) {
        // You can retrieve the product ID from the $product_id variable
        // Perform any further actions with the product ID here
        // For example, you can store it in a session variable or log it to a file
        $recently_added_product_id = $product_id;
    
        // Example: Store the product ID in a session variable for later use
        // if (!session_id()) {
        //     session_start();
        // }
        $_SESSION['recently_added_product_id'] = $recently_added_product_id;
    }

    /**
     * Add to cart fragments
     */
    public function add_to_cart_fragments( $fragments ) {
        // if (!session_id()) {
        //     session_start();
        // }
        ob_start();
        if(isset($_SESSION['recently_added_product_id'])){
            global $product;
            $product = wc_get_product( sanitize_text_field( wp_unslash($_SESSION['recently_added_product_id']) ) );
            pure_wc_product_info_for_cart_notification((int) $_SESSION['recently_added_product_id']);
            if(!empty($product)){
                $cross_sell_ids = $product->get_cross_sell_ids();
                if(!empty($cross_sell_ids)){
                    $fragments['div.pure_wc_cart_notification_cross_sell'] = ob_get_clean();
                }else{
                    $fragments['div.pure_wc_cart_notification'] = ob_get_clean();
                }
            }
        }
        
        return $fragments;
    }

    public function footer(){
        ?>
            <div class="pure-wc-cart-notification-box-wrapper"></div>
        <?php
    }
}
Pure_Wc_Shopbuild_Add_To_Cart_Notification::get_instance();

