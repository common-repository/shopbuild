<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Handle WooCommerce related functionality
 */

use PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin;

class Pure_Wc_Shopbuild_Woo{

    private static $instance = false;


    public function __construct(){
        
        // Add custom image upload field to coupon editing page
        add_action( 'woocommerce_coupon_options', [$this, 'add_coupon_custom_image_field'] );
        add_action( 'wp_ajax_wc_group_ajax_add_to_cart', [$this, 'group_product_custom_ajax_add_to_cart'] );
        add_action( 'wp_ajax_nopriv_wc_group_ajax_add_to_cart', [$this, 'custom_ajax_add_to_cart'] );
        add_filter( 'woocommerce_update_order_review_fragments', [$this, 'custom_modify_order_review_fragments'] );
    }

    /**
     * Add custom image upload field to coupon editing page
     */
    public function add_coupon_custom_image_field() {
        $image_id = get_post_meta(get_the_ID(), 'coupon_image_id', true);
        $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
        ?>
        <input type="hidden" name="_coupon-nonce" value="<?php echo wp_kses_post(wp_create_nonce('pure-wc-coupon-nonce')); ?>">
        <div class="options_group">
            <p class="form-field">
                <label for="coupon_image"><?php esc_html_e('Coupon Image', 'shopbuild'); ?></label>
                <input type="hidden" name="coupon_image_id" id="coupon_image_id" value="<?php echo esc_html($image_id); ?>"/>
                <div id="coupon_image_container">
                    <?php if ($image_url) : ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php esc_html_e('Coupon Image', 'shopbuild'); ?>" style="max-width: 100px; max-height: 100px;" />
                    <?php endif; ?>
                </div>
                <button type="button" class="button" id="upload_coupon_image"><?php esc_html_e('Upload/Add Image', 'shopbuild'); ?></button>
                <button type="button" class="button" id="remove_coupon_image"><?php esc_html_e('Remove Image', 'shopbuild'); ?></button>
            </p>
        </div>
        <?php
    }

    /**
     * Save uploaded image data when the coupon is saved
     */
    public function save_coupon_custom_image_field($post_id) {
        if( isset($_POST['_coupon-nonce']) && !wp_verify_nonce( sanitize_text_field( wp_unslash($_POST['_coupon-nonce']) ), 'pure-wc-coupon-nonce')){
            return;
        }
        if (isset($_POST['coupon_image_id'])) {
            update_post_meta($post_id, 'coupon_image_id', absint( sanitize_text_field(wp_unslash($_POST['coupon_image_id'])) ));
        }
    }

    /**
     * Group product add to cart
     */
    public function group_product_custom_ajax_add_to_cart() {
        // Check for nonce security
        check_ajax_referer( 'shopbuild_ajax_add_to_cart', 'security' );
    
        // Get the grouped product ID and the child product quantities
        $quantities = isset($_POST['quantities'])? array_map('absint', wp_unslash($_POST['quantities'])) : array();
    
        // Loop through the quantities and add each to the cart
        foreach ( $quantities as $child_id => $quantity ) {
            if ( $quantity > 0 ) {
                WC()->cart->add_to_cart( $child_id, $quantity );
            }
        }
    
        // Return a success response
        \WC_AJAX::get_refreshed_fragments();

        wp_die();
    }

    public function custom_modify_order_review_fragments($fragments) {
        // Example: Modify the order review table
        if (isset($fragments['.woocommerce-checkout-review-order-table'])) {
            ob_start();
            session_start();
            $args = array(
                'pure_checkout_order_style' => isset($_SESSION['checkout_order_style'])? sanitize_text_field(wp_unslash($_SESSION['checkout_order_style'])) : 'default',
            );
            pure_wc_get_template('checkout/review-order.php', $args);
            // Modify the fragment HTML as needed
            $fragments['.woocommerce-checkout-review-order-table'] = ob_get_clean();
        }

        // You can modify other fragments too
        return $fragments;
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

Pure_Wc_Shopbuild_Woo::init();