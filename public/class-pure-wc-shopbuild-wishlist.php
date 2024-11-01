<?php
namespace PureWCShopbuild\Frontend;
/**
 * Quick View Class For Product
 */
use Elementor\Plugin;
use PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Pure_Wc_Wishlists{

    private static $_instance = false;

    public function __construct(){
        add_action( 'init', array( $this, 'init' ) );
        add_action( 'wp_footer', array( $this, 'footer') );
        add_action( 'wp_ajax_pure_wc_wishlist', array( $this, 'wishlist') );
        add_action( 'wp_ajax_nopriv_pure_wc_wishlist', array( $this, 'wishlist') );
        add_action( 'wp_ajax_pure_wc_remove_wishlist', array( $this, 'remove_wishlist') );
        add_action( 'wp_ajax_nopriv_pure_wc_remove_wishlist', array( $this, 'remove_wishlist') );
        
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts') );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles') );
    }

    public function enqueue_scripts(){

        wp_enqueue_script( 'pure-wc-wishlist', plugin_dir_url( __FILE__ ) . 'js/pure-wc-wishlist.js', array( 'jquery' ), PURE_WC_SHOPBUILD_VERSION, true );
        
        wp_localize_script( 'pure-wc-wishlist', 'pure_wc_wishlist', array(
            '_nonce'        => wp_create_nonce('wishlist_nonce'),
			'ajax_url'	    => admin_url( 'admin-ajax.php' ),
            'action'        => esc_html('pure_wc_wishlist'),
            'wishlist_added' => apply_filters( 
                'pure_wc_wishlist_added_html', 
                '<svg class="sb-cart-wishlist-icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1.60355 7.98635C2.83622 11.8048 7.7062 14.8923 9.0004 15.6565C10.299 14.8844 15.2042 11.7628 16.3973 7.98985C17.1806 5.55102 16.4535 2.46177 13.5644 1.53473C12.1647 1.08741 10.532 1.35966 9.40484 2.22804C9.16921 2.40837 8.84214 2.41187 8.60476 2.23329C7.41078 1.33952 5.85105 1.07778 4.42936 1.53473C1.54465 2.4609 0.820172 5.55014 1.60355 7.98635ZM9.00138 17.0711C8.89236 17.0711 8.78421 17.0448 8.68574 16.9914C8.41055 16.8417 1.92808 13.2841 0.348132 8.3872C0.347252 8.3872 0.347252 8.38633 0.347252 8.38633C-0.644504 5.30321 0.459792 1.42874 4.02502 0.284605C5.69904 -0.254635 7.52342 -0.0174044 8.99874 0.909632C10.4283 0.00973263 12.3275 -0.238878 13.9681 0.284605C17.5368 1.43049 18.6446 5.30408 17.6538 8.38633C16.1248 13.2272 9.59485 16.8382 9.3179 16.9896C9.21943 17.0439 9.1104 17.0711 9.00138 17.0711Z" fill="currentColor"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.203 6.67473C13.8627 6.67473 13.5743 6.41474 13.5462 6.07159C13.4882 5.35202 13.0046 4.7445 12.3162 4.52302C11.9689 4.41097 11.779 4.04068 11.8906 3.69666C12.0041 3.35175 12.3724 3.16442 12.7206 3.27297C13.919 3.65901 14.7586 4.71561 14.8615 5.96479C14.8905 6.32632 14.6206 6.64322 14.2575 6.6721C14.239 6.67385 14.2214 6.67473 14.203 6.67473Z" fill="currentColor"></path>
                </svg>
                ', 
                null 
            )
		));
    }

    public function enqueue_styles(){
        wp_enqueue_style( 'pure-wc-wishlist', plugin_dir_url( __FILE__ ) . 'css/pure-wc-wishlist.css', array(), PURE_WC_SHOPBUILD_VERSION, 'all' );
    }

    public function init() {
        // image size
        add_image_size( 'pure_wc_wishlist', 100, 100, true );

        // shortcode for wishlist button
        add_shortcode( 'pure_wc_wishlist', [ $this, 'wishlist_shortcode' ] );
        // shortcode for wishlist table
        add_shortcode( 'pure_wc_wishlist_table', [ $this, 'wishlist_table_shortcode' ] );

        // position
        $position = apply_filters('pure_wc_wishlist_position', 'before_title');

        if ( ! empty( $position ) ) {
            switch ( $position ) {
                case 'before_title':
                    add_action( 'woocommerce_shop_loop_item_title', [ $this, 'wishlist_button' ], 9 );
                    break;
                case 'after_title':
                    add_action( 'woocommerce_shop_loop_item_title', [ $this, 'wishlist_button' ], 11 );
                    break;
                case 'after_rating':
                    add_action( 'woocommerce_after_shop_loop_item_title', [ $this, 'wishlist_button' ], 6 );
                    break;
                case 'after_price':
                    add_action( 'woocommerce_after_shop_loop_item_title', [ $this, 'wishlist_button' ], 11 );
                    break;
                case 'before_add_to_cart':
                    add_action( 'woocommerce_after_shop_loop_item', [ $this, 'wishlist_button' ], 9 );
                    break;
                case 'after_add_to_cart':
                    add_action( 'woocommerce_after_shop_loop_item', [ $this, 'wishlist_button' ], 11 );
                    break;
                default:
                    add_action( 'pure_wc_button_position_' . $position, [ $this, 'wishlist_button' ] );
            }
            add_action( 'pure_wc_button_position_' . $position, [ $this, 'wishlist_button' ] );
        }
    }

    public function wishlist_shortcode( $attrs ){
        global $product;

        $wishlist_list = get_user_meta( get_current_user_id(), 'pure_wishlist_list', true );
        if( empty($product) ){
            return;
        }
        $is_wishlisted = !empty($wishlist_list) && in_array( $product->get_id(), $wishlist_list );
        $attrs = shortcode_atts( [
            'id'      => null,
            'class'   => 'pure-wc-wishlist-btn'
        ], $attrs, 'pure_wc_wishlist' );

        if ( ! $attrs['id'] ) {
            $attrs['id'] = $product->get_id();
        }

        $output = sprintf( 
            '<button data-bs-toggle="tooltip" data-bs-placement="bottom" class="pure-wc-wishlist-btn button wp-element-button pure-tooltip %s" data-id="%s" title="Add To Wishlist"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
          </svg></button>',
            esc_attr( $attrs['class'] ),
            esc_attr( $attrs['id'] )
        );

        
        if( !empty($wishlist_list) && in_array( $product->get_id(), $wishlist_list ) ){
            $attrs['class']     = 'pure-wc-wishlist-btn added';
            $output = sprintf( 
                '<button data-bs-toggle="tooltip" data-bs-placement="bottom" class="pure-wc-wishlist-btn button wp-element-button pure-tooltip %s" data-id="%s" title="Already Added"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
              </svg></button>',
                esc_attr( $attrs['class'] ),
                esc_attr( $attrs['id'] )
            );
        }

        

        return apply_filters( 'pure_wc_wishlist_btn_html', $output, $attrs['id'], $is_wishlisted );
    }

    public function wishlist_button(){
        echo wp_kses(do_shortcode('[pure_wc_wishlist]'), pure_wc_get_kses_extended_ruleset());
    }

    public function remove_wishlist(){
    
        check_ajax_referer('wishlist_nonce', 'nonce');

        $product_id = isset($_REQUEST['product_id'])? absint( sanitize_text_field( wp_unslash($_REQUEST['product_id']) ) ) : 0;
        $remove_action = isset($_REQUEST['remove'])? absint( sanitize_text_field( wp_unslash($_REQUEST['remove']) )) : 1;
        $wishlist_list = array();
        
        if(!is_user_logged_in()){
            if( isset($_COOKIE['pure_wc_wishlist']) ){
                $wishlist_list = explode(",", sanitize_text_field( wp_unslash($_COOKIE['pure_wc_wishlist']) ));
                if(is_array($wishlist_list)){
                    if($remove_action == 2){
                        setcookie("pure_wc_wishlist", '', time()-3600, "/");
                        $wishlist_list = array();
                    }else{
                        $search = array_search( $product_id, $wishlist_list );
                        if( ($remove_action == 1) && ($search >= 0)){
                            unset($wishlist_list[$search]);
                        }
                        setcookie("pure_wc_wishlist", implode(",", $wishlist_list), time()+(86400*7), "/");
                    }
                }else{
                    if($remove_action == 2){
                        setcookie("pure_wc_wishlist", '', time()-3600, "/");
                        $wishlist_list = array();
                    }else{
                        if($remove_action == 1){
                            setcookie("pure_wc_wishlist", '', time()-3600, "/");
                            $wishlist_list = array();
                        }
                    }
                }
            }
        }else{
            $wishlist_list = get_user_meta( get_current_user_id(), 'pure_wishlist_list', true );
            $search = array_search( $product_id, $wishlist_list );
            if( $search >= 0 ){
                unset($wishlist_list[$search]);
                update_user_meta( get_current_user_id(), 'pure_wishlist_list', $wishlist_list );
            }
        }
        if( !empty($wishlist_list) ):
        ?>
            <thead>
                <tr>
                    <th class="sb-wishlist-table-th-product"><?php echo esc_html__('Product', 'shopbuild'); ?></th>
                    <th class="sb-wishlist-table-th-product"><?php echo esc_html__('Price', 'shopbuild'); ?></th>
                    <th class="sb-wishlist-table-th-product"><?php echo esc_html__('Stocks', 'shopbuild'); ?></th>
                    <th colspan="2"><?php echo esc_html__('Action', 'shopbuild'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach( $wishlist_list as $product_id ):
                    global $product;
                    $product = wc_get_product( $product_id );
                ?>
                <tr>
                    <td>
                        <div class="sb-product-wishlist-table-item-info sb-d-flex sb-align-items-center">
                            <div class="product-thumbnail">
                                <?php echo wp_get_attachment_image( $product->get_image_id(), 'pure_wc_wishlist' ); ?>
                            </div>
                            <div class="product-info-content">
                                <p class="product-name"><a href="<?php echo esc_url(get_permalink($product->get_id())); ?>"><?php echo esc_html( $product->get_name() ); ?></a></p>
                                <!-- <p class="product-price"><?php print wp_kses_post( $product->get_price_html() ); ?></p> -->
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="sb-product-wishlist-table-item-info sb-d-flex sb-align-items-center">
                            <div class="product-info-content">
                                <p class="product-price"><?php print wp_kses_post( $product->get_price_html() ); ?></p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="sb-product-wishlist-table-item-info sb-d-flex sb-align-items-center">
                            <div class="product-info-content">
                                <p class="product-price"><?php print wp_kses_post( $product->get_stock_status() ); ?></p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="wishlist-action">
                            <?php 
                                $is_quickview_active = Pure_Wc_Shopuild_Admin::get_option('_pure_quickview_settings');
                                if($is_quickview_active['enable']){
                                    echo wp_kses(do_shortcode('[pure_wc_quickview]'), pure_wc_get_kses_extended_ruleset());
                                }
                            ?>
                            <a data-quantity="<?php echo esc_attr($product->get_min_purchase_quantity()); ?>" data-product_id="<?php echo esc_attr($product->get_id()); ?>" data-product_sku="<?php echo esc_attr($product->get_sku());?>" class="single_add_to_cart_button add_to_cart_button ajax_add_to_cart pure_wc_cart_btn button alt wp-element-button" href="<?php echo esc_url( $product->add_to_cart_url() ); ?>">
                                <svg class="sb-cart-icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.54431 4.80484L4.08701 11.2487C4.12661 11.7447 4.53251 12.1167 5.02841 12.1167H5.03201H14.8519H14.8537C15.3227 12.1167 15.7232 11.7681 15.7898 11.3053L16.6448 5.41221C16.6646 5.27205 16.6295 5.13189 16.544 5.01868C16.4594 4.90457 16.3352 4.8309 16.1948 4.81113C16.0067 4.81832 8.20092 4.80754 3.54431 4.80484ZM5.02647 13.4642C3.84117 13.4642 2.83766 12.5405 2.74136 11.359L1.91696 1.57098L0.560653 1.33738C0.192551 1.27269 -0.0531497 0.924974 0.00985058 0.557495C0.0746508 0.190017 0.430152 -0.0489788 0.790154 0.00852392L2.66216 0.331977C2.96366 0.384987 3.19316 0.634765 3.21926 0.940248L3.43076 3.45689C16.2792 3.46228 16.3206 3.46857 16.3827 3.47576C16.884 3.54854 17.325 3.80999 17.6256 4.21251C17.9262 4.61413 18.0522 5.1092 17.9802 5.60516L17.1261 11.4974C16.965 12.6187 15.9894 13.4642 14.8554 13.4642H14.8509H5.03367H5.02647Z" fill="currentColor"></path>
                                <path d="M13.4079 8.12567H10.9131C10.5396 8.12567 10.2381 7.82379 10.2381 7.45181C10.2381 7.07984 10.5396 6.77795 10.9131 6.77795H13.4079C13.7805 6.77795 14.0829 7.07984 14.0829 7.45181C14.0829 7.82379 13.7805 8.12567 13.4079 8.12567Z" fill="currentColor"></path>
                                <path d="M4.63943 15.9048C4.91033 15.9048 5.12903 16.1235 5.12903 16.3944C5.12903 16.6653 4.91033 16.8849 4.63943 16.8849C4.36763 16.8849 4.14893 16.6653 4.14893 16.3944C4.14893 16.1235 4.36763 15.9048 4.63943 15.9048Z" fill="currentColor"></path>
                                <path d="M4.63859 16.2097C4.53689 16.2097 4.45409 16.2925 4.45409 16.3942C4.45409 16.5985 4.82399 16.5985 4.82399 16.3942C4.82399 16.2925 4.74029 16.2097 4.63859 16.2097ZM4.6386 17.5569C3.996 17.5569 3.474 17.0349 3.474 16.3933C3.474 15.7518 3.996 15.2307 4.6386 15.2307C5.28121 15.2307 5.80411 15.7518 5.80411 16.3933C5.80411 17.0349 5.28121 17.5569 4.6386 17.5569Z" fill="currentColor"></path>
                                <path d="M14.7918 15.9048C15.0627 15.9048 15.2823 16.1235 15.2823 16.3944C15.2823 16.6653 15.0627 16.8849 14.7918 16.8849C14.52 16.8849 14.3013 16.6653 14.3013 16.3944C14.3013 16.1235 14.52 15.9048 14.7918 15.9048Z" fill="currentColor"></path>
                                <path d="M14.7906 16.2098C14.6898 16.2098 14.607 16.2926 14.607 16.3943C14.6079 16.6004 14.9769 16.5986 14.976 16.3943C14.976 16.2926 14.8923 16.2098 14.7906 16.2098ZM14.7909 17.5569C14.1483 17.5569 13.6263 17.0349 13.6263 16.3933C13.6263 15.7518 14.1483 15.2307 14.7909 15.2307C15.4344 15.2307 15.9573 15.7518 15.9573 16.3933C15.9573 17.0349 15.4344 17.5569 14.7909 17.5569Z" fill="currentColor"></path>
                                </svg>
                            </a>
                            <a href="javascript:void(0)" title="Remove" class="remove-wishlist-btn" data-id="<?php echo esc_attr( $product_id ); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>
                            </a>

                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        <?php
        else:
        ?>
            <tbody>
                
                <tr>
                    <td>
                        <p><strong><?php echo esc_html__('Wishlist is empty!', 'shopbuild'); ?></strong></p>
                    </td>
                </tr>
                
            </tbody>
        <?php
        endif;
    }

    public function wishlist_table_shortcode(){
        $wishlist_list = array();
        if(!is_user_logged_in()){
            $wishlist_list_cookie = isset($_COOKIE['pure_wc_wishlist'])? explode(",", sanitize_text_field( wp_unslash($_COOKIE['pure_wc_wishlist']) )) : array();
            if( !is_array($wishlist_list_cookie) ){
                $wishlist_list[] = $wishlist_list_cookie;
            }else{
                $wishlist_list = $wishlist_list_cookie;
            }
        }else{
            $wishlist_list = get_user_meta( get_current_user_id(), 'pure_wishlist_list', true );
        }
        
        if( class_exists('Elementor\Plugin') && !Plugin::instance()->editor->is_edit_mode() && function_exists('wc_print_notices') ){
            woocommerce_output_all_notices();
        }
       
        if( !empty($wishlist_list) ):
            ob_start();
        ?>
        <div class="sb-cart-table sb-wishlist-table">
            <table class="pure-wc-wishlist-table">
                <thead>
                    <tr>
                        <th class="sb-wishlist-table-th-product"><?php echo esc_html__('Product', 'shopbuild'); ?></th>
                        <th class="sb-wishlist-table-th-product"><?php echo esc_html__('Price', 'shopbuild'); ?></th>
                        <th class="sb-wishlist-table-th-product"><?php echo esc_html__('Stocks', 'shopbuild'); ?></th>
                        <th colspan="2"><?php echo esc_html__('Action', 'shopbuild'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach( $wishlist_list as $product_id ):
                        global $product;
                        $product = wc_get_product( $product_id );
                        if( $product ):
                    ?>
                    <tr>
                        
                        <td>
                            <div class="sb-product-wishlist-table-item-info sb-d-flex">
                                <div class="product-thumbnail">
                                    <?php echo wp_get_attachment_image( $product->get_image_id(), 'pure_wc_wishlist' ); ?>
                                </div>
                                <div class="product-info-content">
                                    <p class="product-name"><a href="<?php echo esc_url(get_permalink($product->get_id())); ?>"><?php echo esc_html( $product->get_name() ); ?></a></p>
                                    <!-- <p class="product-price"><?php print wp_kses_post( $product->get_price_html() ); ?></p> -->
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="sb-product-wishlist-table-item-info sb-d-flex sb-align-items-center">
                                <div class="product-info-content">
                                    <p class="product-price"><?php print wp_kses_post( $product->get_price_html() ); ?></p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="sb-product-wishlist-table-item-info sb-d-flex sb-align-items-center">
                                <div class="product-info-content">
                                    <p class="product-price"><?php print wp_kses_post( $product->get_stock_status() ); ?></p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="wishlist-action">
                                <?php 
                                    $is_quickview_active = Pure_Wc_Shopuild_Admin::get_option('_pure_quickview_settings');
                                    if($is_quickview_active['enable']){
                                        echo wp_kses(do_shortcode('[pure_wc_quickview]'), pure_wc_get_kses_extended_ruleset());
                                    }
                                ?>
                                <a data-quantity="<?php echo esc_attr($product->get_min_purchase_quantity()); ?>" data-product_id="<?php echo esc_attr($product->get_id()); ?>" data-product_sku="<?php echo esc_attr($product->get_sku());?>" class="single_add_to_cart_button add_to_cart_button ajax_add_to_cart pure_wc_cart_btn button alt wp-element-button" href="<?php echo esc_url( $product->add_to_cart_url() ); ?>">
                                    <svg class="sb-cart-icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.54431 4.80484L4.08701 11.2487C4.12661 11.7447 4.53251 12.1167 5.02841 12.1167H5.03201H14.8519H14.8537C15.3227 12.1167 15.7232 11.7681 15.7898 11.3053L16.6448 5.41221C16.6646 5.27205 16.6295 5.13189 16.544 5.01868C16.4594 4.90457 16.3352 4.8309 16.1948 4.81113C16.0067 4.81832 8.20092 4.80754 3.54431 4.80484ZM5.02647 13.4642C3.84117 13.4642 2.83766 12.5405 2.74136 11.359L1.91696 1.57098L0.560653 1.33738C0.192551 1.27269 -0.0531497 0.924974 0.00985058 0.557495C0.0746508 0.190017 0.430152 -0.0489788 0.790154 0.00852392L2.66216 0.331977C2.96366 0.384987 3.19316 0.634765 3.21926 0.940248L3.43076 3.45689C16.2792 3.46228 16.3206 3.46857 16.3827 3.47576C16.884 3.54854 17.325 3.80999 17.6256 4.21251C17.9262 4.61413 18.0522 5.1092 17.9802 5.60516L17.1261 11.4974C16.965 12.6187 15.9894 13.4642 14.8554 13.4642H14.8509H5.03367H5.02647Z" fill="currentColor"></path>
                                    <path d="M13.4079 8.12567H10.9131C10.5396 8.12567 10.2381 7.82379 10.2381 7.45181C10.2381 7.07984 10.5396 6.77795 10.9131 6.77795H13.4079C13.7805 6.77795 14.0829 7.07984 14.0829 7.45181C14.0829 7.82379 13.7805 8.12567 13.4079 8.12567Z" fill="currentColor"></path>
                                    <path d="M4.63943 15.9048C4.91033 15.9048 5.12903 16.1235 5.12903 16.3944C5.12903 16.6653 4.91033 16.8849 4.63943 16.8849C4.36763 16.8849 4.14893 16.6653 4.14893 16.3944C4.14893 16.1235 4.36763 15.9048 4.63943 15.9048Z" fill="currentColor"></path>
                                    <path d="M4.63859 16.2097C4.53689 16.2097 4.45409 16.2925 4.45409 16.3942C4.45409 16.5985 4.82399 16.5985 4.82399 16.3942C4.82399 16.2925 4.74029 16.2097 4.63859 16.2097ZM4.6386 17.5569C3.996 17.5569 3.474 17.0349 3.474 16.3933C3.474 15.7518 3.996 15.2307 4.6386 15.2307C5.28121 15.2307 5.80411 15.7518 5.80411 16.3933C5.80411 17.0349 5.28121 17.5569 4.6386 17.5569Z" fill="currentColor"></path>
                                    <path d="M14.7918 15.9048C15.0627 15.9048 15.2823 16.1235 15.2823 16.3944C15.2823 16.6653 15.0627 16.8849 14.7918 16.8849C14.52 16.8849 14.3013 16.6653 14.3013 16.3944C14.3013 16.1235 14.52 15.9048 14.7918 15.9048Z" fill="currentColor"></path>
                                    <path d="M14.7906 16.2098C14.6898 16.2098 14.607 16.2926 14.607 16.3943C14.6079 16.6004 14.9769 16.5986 14.976 16.3943C14.976 16.2926 14.8923 16.2098 14.7906 16.2098ZM14.7909 17.5569C14.1483 17.5569 13.6263 17.0349 13.6263 16.3933C13.6263 15.7518 14.1483 15.2307 14.7909 15.2307C15.4344 15.2307 15.9573 15.7518 15.9573 16.3933C15.9573 17.0349 15.4344 17.5569 14.7909 17.5569Z" fill="currentColor"></path>
                                    </svg>
                                </a>
                                <a href="javascript:void(0)" title="Remove" class="remove-wishlist-btn" data-id="<?php echo esc_attr( $product_id ); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endif; endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
        $html = ob_get_clean();
        return $html;
        else:
        ob_start();
        ?>
        <table class="pure-wc-wishlist-table">
            <tbody>
                
                <tr>
                    <td>
                        <p><strong><?php echo esc_html__('Wishlist is empty!', 'shopbuild'); ?></strong></p>
                    </td>
                </tr>
                
            </tbody>
        </table>
        <?php
        $html = ob_get_clean();
        return $html;
        endif;
        
    }

    public function is_added_to_cart( $search_products ) {
        $count = 0; // Initializing
    
        if ( ! WC()->cart->is_empty() ) {
            // Loop though cart items
            foreach(WC()->cart->get_cart() as $cart_item ) {
                // Handling also variable products and their products variations
                $cart_item_ids = array($cart_item['product_id'], $cart_item['variation_id']);
    
                // Handle a simple product Id (int or string) or an array of product Ids 
                if( ( is_array($search_products) && array_intersect($search_products, $cart_item_ids) ) || ( !is_array($search_products) && in_array($search_products, $cart_item_ids) ) ){
                    $count++; // incrementing items count
                }
            }
        }
        return $count; // returning matched items count 
    }

    public function wishlist(){
        check_ajax_referer('wishlist_nonce', 'nonce');
        add_image_size( 'pure_wc_wishlist', 100, 100, true );
        global $product;
        $product_id     = isset($_REQUEST['product_id'])? absint( sanitize_key( wp_unslash($_REQUEST['product_id'] ) ) ) : 0;
        $remove_action  = isset($_REQUEST['remove']) ? absint( sanitize_key( wp_unslash($_REQUEST['remove']) ) ) : 0;
        $product        = wc_get_product( $product_id );
        $wishlist_list = array();

        if ( $product ) {
            if(!is_user_logged_in()){
                if( isset($_COOKIE['pure_wc_wishlist']) ){
                    $wishlist_list = explode(",", sanitize_text_field( wp_unslash($_COOKIE['pure_wc_wishlist']) ));
                    if(is_array($wishlist_list)){
                        if($remove_action == 2){
                            setcookie("pure_wc_wishlist", '', time()-3600, "/");
                            $wishlist_list = array();
                        }else{
                            $search = array_search( $product_id, $wishlist_list );
                            if( ($remove_action == 1) && ($search >= 0)){
                                unset($wishlist_list[$search]);
                            }
                            if( is_bool($search) && ($search == false) ){
                                array_push($wishlist_list, $product_id);
                            }
                            setcookie("pure_wc_wishlist", implode(",", $wishlist_list), time()+(86400*7), "/");
                        }
                    }else{
                        if($remove_action == 2){
                            setcookie("pure_wc_wishlist", '', time()-3600, "/");
                            $wishlist_list = array();
                        }else{
                            if($remove_action == 1){
                                setcookie("pure_wc_wishlist", '', time()-3600, "/");
                            }else{
                                $wishlist_list[] = isset($_COOKIE['pure_wc_wishlist'])? sanitize_text_field( wp_unslash($_COOKIE['pure_wc_wishlist']) ) : array();
                                if(intval($product_id) != intval($_COOKIE['pure_wc_wishlist'])){
                                    array_push($wishlist_list, $product_id);
                                }
                                setcookie("pure_wc_wishlist", implode(",", $wishlist_list), time()+(86400*7), "/");
                            }
                        }
                    }
                }else{
                    setcookie("pure_wc_wishlist", implode(",", array($product_id)), time()+(86400*7), "/");
                    $wishlist_list = array($product_id);
                }
            }else{
                $wishlist_list = get_user_meta( get_current_user_id(), 'pure_wishlist_list', true );
                if( empty($wishlist_list) || is_null( $wishlist_list ) ){
                    update_user_meta( get_current_user_id(), 'pure_wishlist_list', array( $product_id ) );
                    $wishlist_list = get_user_meta( get_current_user_id(), 'pure_wishlist_list', true );
                }else{
                    $search = array_search( $product_id, $wishlist_list );
                    
                    if( is_bool($search) && $search == false ){
                        array_push($wishlist_list, $product_id); 
                    }

                    if( ($remove_action > 0) && ($search >= 0)){
                        unset($wishlist_list[$search]);
                    }

                    update_user_meta( get_current_user_id(), 'pure_wishlist_list', $wishlist_list );
                    $wishlist_list = get_user_meta( get_current_user_id(), 'pure_wishlist_list', true );
                    
                }
            }
            ob_start();
            ?>
            <div class="sb-product-wishlist-modal-top sb-d-flex sb-align-items-center sb-justify-content-between">
                <div class="sb-product-wishlist-modal-title">
                    <span><?php echo esc_html__('Wishlist (', 'shopbuild'); ?><?php echo esc_html(count($wishlist_list)); ?><?php echo esc_html__(')', 'shopbuild'); ?> </span>
                </div>
                <button class="sb-product-wishlist-modal-close pure-wc-wishlist-modal-close" type="button">
                    <svg height="16" viewBox="0 0 512 512" width="16" xmlns="http://www.w3.org/2000/svg">
                        <path fill="currentColor" d="m25 512a25 25 0 0 1 -17.68-42.68l462-462a25 25 0 0 1 35.36 35.36l-462 462a24.93 24.93 0 0 1 -17.68 7.32z"></path>
                        <path fill="currentColor" d="m487 512a24.93 24.93 0 0 1 -17.68-7.32l-462-462a25 25 0 0 1 35.36-35.36l462 462a25 25 0 0 1 -17.68 42.68z"></path>
                    </svg>
                </button>
            </div>
            <div class="sb-wishlist-item-wrapper sb-ps-active">
                <?php foreach($wishlist_list as $item): 
                    $product = wc_get_product($item);
                    if($product):
                ?>
                <div <?php wc_product_class( "sb-wishlist-item ", $product ); ?>>
                    <div class="sb-wishlist-thumb">
                        <?php echo wp_get_attachment_image( $product->get_image_id(), 'pure_wc_wishlist', false, array( 'class' => 'img-fluid') ); ?>
                    </div>
                    <div class="sb-wishlist-content">
                        <h5 class="sb-wishlist-title">
                            <a href="<?php echo esc_url(get_permalink($product->get_id())); ?>"><?php echo esc_html($product->get_name()); ?></a>
                        </h5>
                        <div class="sb-wishlist-price-wrapper">
                            <?php print wp_kses_post($product->get_price_html()); ?>
                        </div>
                        <a data-quantity="<?php echo esc_attr($product->get_min_purchase_quantity()); ?>" data-product_id="<?php echo esc_attr($product->get_id()); ?>" data-product_sku="<?php echo esc_attr($product->get_sku());?>" class="single_add_to_cart_button add_to_cart_button ajax_add_to_cart pure_wc_cart_btn button alt wp-element-button" href="<?php echo esc_url( $product->add_to_cart_url() ); ?>">
                            <span class="sbp-spinner"></span>
                            <svg class="sb-cart-icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.54431 4.80484L4.08701 11.2487C4.12661 11.7447 4.53251 12.1167 5.02841 12.1167H5.03201H14.8519H14.8537C15.3227 12.1167 15.7232 11.7681 15.7898 11.3053L16.6448 5.41221C16.6646 5.27205 16.6295 5.13189 16.544 5.01868C16.4594 4.90457 16.3352 4.8309 16.1948 4.81113C16.0067 4.81832 8.20092 4.80754 3.54431 4.80484ZM5.02647 13.4642C3.84117 13.4642 2.83766 12.5405 2.74136 11.359L1.91696 1.57098L0.560653 1.33738C0.192551 1.27269 -0.0531497 0.924974 0.00985058 0.557495C0.0746508 0.190017 0.430152 -0.0489788 0.790154 0.00852392L2.66216 0.331977C2.96366 0.384987 3.19316 0.634765 3.21926 0.940248L3.43076 3.45689C16.2792 3.46228 16.3206 3.46857 16.3827 3.47576C16.884 3.54854 17.325 3.80999 17.6256 4.21251C17.9262 4.61413 18.0522 5.1092 17.9802 5.60516L17.1261 11.4974C16.965 12.6187 15.9894 13.4642 14.8554 13.4642H14.8509H5.03367H5.02647Z" fill="currentColor"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.4079 8.12567H10.9131C10.5396 8.12567 10.2381 7.82379 10.2381 7.45181C10.2381 7.07984 10.5396 6.77795 10.9131 6.77795H13.4079C13.7805 6.77795 14.0829 7.07984 14.0829 7.45181C14.0829 7.82379 13.7805 8.12567 13.4079 8.12567Z" fill="currentColor"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.63943 15.9048C4.91033 15.9048 5.12903 16.1235 5.12903 16.3944C5.12903 16.6653 4.91033 16.8849 4.63943 16.8849C4.36763 16.8849 4.14893 16.6653 4.14893 16.3944C4.14893 16.1235 4.36763 15.9048 4.63943 15.9048Z" fill="currentColor"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.63859 16.2097C4.53689 16.2097 4.45409 16.2925 4.45409 16.3942C4.45409 16.5985 4.82399 16.5985 4.82399 16.3942C4.82399 16.2925 4.74029 16.2097 4.63859 16.2097ZM4.6386 17.5569C3.996 17.5569 3.474 17.0349 3.474 16.3933C3.474 15.7518 3.996 15.2307 4.6386 15.2307C5.28121 15.2307 5.80411 15.7518 5.80411 16.3933C5.80411 17.0349 5.28121 17.5569 4.6386 17.5569Z" fill="currentColor"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7918 15.9048C15.0627 15.9048 15.2823 16.1235 15.2823 16.3944C15.2823 16.6653 15.0627 16.8849 14.7918 16.8849C14.52 16.8849 14.3013 16.6653 14.3013 16.3944C14.3013 16.1235 14.52 15.9048 14.7918 15.9048Z" fill="currentColor"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7906 16.2098C14.6898 16.2098 14.607 16.2926 14.607 16.3943C14.6079 16.6004 14.9769 16.5986 14.976 16.3943C14.976 16.2926 14.8923 16.2098 14.7906 16.2098ZM14.7909 17.5569C14.1483 17.5569 13.6263 17.0349 13.6263 16.3933C13.6263 15.7518 14.1483 15.2307 14.7909 15.2307C15.4344 15.2307 15.9573 15.7518 15.9573 16.3933C15.9573 17.0349 15.4344 17.5569 14.7909 17.5569Z" fill="currentColor"/>
                            </svg> 
                            <?php echo esc_html__('Add To Cart', 'shopbuild'); ?>
                        </a>
                    </div>
                    <a href="javascript:void(0)" class="sb-wishlist-del remove-wishlist-btn-modal" data-id="<?php echo esc_attr( $product->get_id() ); ?>">
                        <svg height="10" viewBox="0 0 512 512" width="10" xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor" d="m25 512a25 25 0 0 1 -17.68-42.68l462-462a25 25 0 0 1 35.36 35.36l-462 462a24.93 24.93 0 0 1 -17.68 7.32z"/>
                            <path fill="currentColor" d="m487 512a24.93 24.93 0 0 1 -17.68-7.32l-462-462a25 25 0 0 1 35.36-35.36l462 462a25 25 0 0 1 -17.68 42.68z"/>
                        </svg>
                    </a>
                </div>
                <?php endif; endforeach; ?>
            </div>
            <?php
            wp_send_json( wp_json_encode(array(
                "success" => 1,
                "body"  => ob_get_clean()
            )));             
            
        }

        wp_die();
    }

    public function footer(){
        $wishlist_page_id = get_option('pure_wc_wishlist_page_id');
        ?>
        <div class="sb-product-wishlist-modal-bg"></div>

        <div id="pure-wc-wishlist-modal" class="pure-wc-wishlist-modal sb-product-wishlist-modal">
            <div class="sb-product-wishlist-modal-overlay"></div>
            <div class="pure-wc-wishlist-modal-content"></div>
            <div class="sb-product-wishlist-modal-footer">
                <a href="<?php echo !empty($wishlist_page_id)? esc_url(get_page_link($wishlist_page_id)) : '#';?>" class="sb-product-wishlist-modal-footer-link"><?php esc_html_e('Go To wishlist', 'shopbuild'); ?></a>
            </div>
            
        </div>
        <?php
    }

    public static function instance(){
        if( !self::$_instance ){
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}

Pure_Wc_Wishlists::instance();