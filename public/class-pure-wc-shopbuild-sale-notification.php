<?php
namespace PureWCShopbuild\Frontend;
/**
 * Quick View Class For Product
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Pure_Wc_Sale_Notification{

    private static $_instance = false;


    private $_products = array();

    public function __construct(){
        add_action( 'wp_footer', array( $this, 'footer') );        
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts') );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles') );
        add_action( 'wp_enqueue_scripts', array( $this, 'inline_styles') );
    }

    public function enqueue_scripts(){

        wp_enqueue_script( 'pure-wc-sale-notification', plugin_dir_url( __FILE__ ) . 'js/pure-wc-sale-notification.js', array( 'jquery' ), PURE_WC_SHOPBUILD_VERSION, true );
        
        wp_localize_script( 'pure-wc-sale-notification', 'pure_wc_sale_notification', array(
            'pure_sale_notification' => ''
		));
    }

    public function enqueue_styles(){
        wp_enqueue_style( 'pure-animate', plugin_dir_url( __FILE__ ) . 'css/animation.css', array(), PURE_WC_SHOPBUILD_VERSION, 'all' );
        wp_enqueue_style( 'pure-wc-sale-notification', plugin_dir_url( __FILE__ ) . 'css/pure-wc-sale-notification.css', array(), PURE_WC_SHOPBUILD_VERSION, 'all' );
    }

    // Product Price
    private function productprice($price) {
        if( empty( $price ) ){
            $price = 0;
        }
        return sprintf(
            get_woocommerce_price_format(),
            get_woocommerce_currency_symbol(),
            number_format($price,wc_get_price_decimals(),wc_get_price_decimal_separator(),wc_get_price_thousand_separator())
        );  
    }

    // Buyer Info
    private function buyer_info( $order ){
        $address = $order->get_address('billing');
        if(!isset($address['city']) || strlen($address['city']) == 0 ){
            $address = $order->get_address('shipping');
        }
        $buyerinfo = array(
            'fname'     => isset( $address['first_name']) && strlen($address['first_name'] ) > 0 ? ucfirst($address['first_name']) : '',
            'lname'     => isset( $address['last_name']) && strlen($address['last_name'] ) > 0 ? ucfirst($address['last_name']) : '',
            'city'      => isset( $address['city'] ) && strlen($address['city'] ) > 0 ? ucfirst($address['city']) : 'N/A',
            'state'     => isset( $address['state']) && strlen($address['state'] ) > 0 ? ucfirst($address['state']) : 'N/A',
            'country'   => isset( $address['country']) && strlen($address['country'] ) > 0 ? WC()->countries->countries[$address['country']] : 'N/A',
        );
        return $buyerinfo;
    }

    private function get_sale_products(){
        $_get_settings = \PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_sale_notification');
        $_real_or_manual = $_get_settings['pure_wc_real_or_manual'];
        $_products = array();
        if($_real_or_manual == 'real'){
            $args = array(
                'post_type'     => 'shop_order',
                'post_status'   => array('wc-completed', 'wc-pending', 'wc-processing', 'wc-on-hold'),
                'orderby'       => 'ID',
                'order'         => 'DESC',
                'posts_per_page' => $_get_settings['pure_wc_number_of_products'],
                'date_query' => array(
                    'after' => gmdate('Y-m-d', strtotime('-'.$_get_settings['pure_wc_how_old_product']))
                )
            );
            $posts = get_posts($args);
            
            foreach( $posts as $post ){
                $order = new \WC_Order( $post->ID );
                $order_items = $order->get_items();
                $first_item = array_values( $order_items )[0];
                $product_id = $first_item['product_id'];
        
                $product = wc_get_product( $product_id );
                if( !empty( $product ) ){
                    preg_match( '/src="(.*?)"/', $product->get_image( 'thumbnail' ), $imgurl );
                    $p = array(
                        'id'    => $first_item['order_id'],
                        'name'  => $product->get_title(),
                        'url'   => $product->get_permalink(),
                        'date'  => $post->post_date_gmt,
                        'image' => count($imgurl) === 2 ? $imgurl[1] : null,
                        'price' => $this->productprice(wc_get_price_to_display($product) ),
                        'buyer' => $this->buyer_info($order)
                    );
                    array_push( $_products, $p);
                }
            }
        }else{
            $posts = $_get_settings['pure_wc_manual_products'];
            $buyer = array(
                'fname' => $_get_settings['pure_wc_fname_of_buyer'],
                'lname' => $_get_settings['pure_wc_lname_of_buyer'],
                'city'  => $_get_settings['pure_wc_city_of_buyer'],
                'state' => $_get_settings['pure_wc_state_of_buyer'],
                'country' => $_get_settings['pure_wc_country_of_buyer']
            );
            foreach( $posts as $post ){
                $product = wc_get_product( $post['value'] );
                if( !empty( $product ) ){
                    preg_match( '/src="(.*?)"/', $product->get_image( 'thumbnail' ), $imgurl );
                    $p = array(
                        'name'  => $product->get_title(),
                        'url'   => $product->get_permalink(),
                        'image' => count($imgurl) === 2 ? $imgurl[1] : null,
                        'price' => $this->productprice(wc_get_price_to_display($product)),
                        'buyer' => $buyer
                    );
                    array_push( $_products, $p);
                }
            }
        }
        return $_products;
    }

    public function inline_styles(){
        $_get_settings = \PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_sale_notification');

        $custom_css = '';
        if( $_get_settings['pure_wc_notification_position'] == 'bottom_right' ){
            $custom_css = '
                .sb-notification-area{
                    right: 2%;
                    bottom:5%;
                }
            ';
        }
        if( $_get_settings['pure_wc_notification_position'] == 'bottom_left' ){
            $custom_css = '
                .sb-notification-area{
                    left: 2%;
                    bottom:5%;
                }
            ';
        }
        if( $_get_settings['pure_wc_notification_position'] == 'top_right' ){
            $custom_css = '
                .sb-notification-area{
                    right: 2%;
                    top:5%;
                }
            ';
        }
        if( $_get_settings['pure_wc_notification_position'] == 'top_left' ){
            $custom_css = '
                .sb-notification-area{
                    left: 2%;
                    top:5%;
                }
            ';
        }

        wp_add_inline_style('pure-wc-sale-notification', $custom_css);
    }

    public function footer(){
        $products = $this->get_sale_products();
        $_get_settings = \PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_sale_notification');
        $settings = array(
            'firstLoadtime' => $_get_settings['pure_wc_first_load_time'],
            'timeInterval'      => $_get_settings['pure_wc_notification_interval'],
            'notificationShowingTime' => $_get_settings['pure_wc_notification_showtime'],
        );

        $settings = wp_json_encode($settings);
        ?>
            <?php if($_get_settings['pure_wc_enable_sale_notification']): ?>
            <div id="pure-wc-sale-notification" data-settings="<?php echo esc_attr($settings); ?>">
                <div class="notification-container">
                    <?php if( !empty($products) ): ?>
                    <?php foreach($products as $product): ?>
                        <div class="sb-notification-area sb-notification-box sb-hide">
                            <div class="sb-notification-inner sb-d-flex">
                                <div class="sb-notification-thumb">
                                    <img src="<?php echo esc_url($product['image']); ?>" alt="<?php echo esc_url($product['name']); ?>">
                                </div>
                                <div class="sb-notification-content">
                                    <a href="<?php echo esc_url($product['url']); ?>" class="notification-contents"> 
                                        <span><?php echo esc_html__('Someone purchaed a', 'shopbuild'); ?></span>
                                        <h3 class="sb-notification-title">
                                            <?php echo esc_html($product['name']); ?>
                                        </h3>
                                        <?php if(!empty($product['buyer']) && isset($product['buyer']) ): ?>
                                        <p><strong><?php echo esc_html__('By:', 'shopbuild'); ?></strong> <?php echo esc_html($product['buyer']['fname'].' '.$product['buyer']['lname']); ?> </p>
                                        <p>
                                            <?php 
                                                $address = sprintf('%s %s %s', esc_html($product['buyer']['city']), esc_html($product['buyer']['state']), esc_html($product['buyer']['country']));
                                                print wp_kses_post($address);
                                            ?>
                                        </p>
                                        <?php endif; ?>
                                    </a>
                                </div>
                            </div>
                            <div class="sb-notification-close">
                                <button class="sb-notification-close-btn sb-notification-close" type="button">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 1L1 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1 1L11 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="sb-notification-view">
                                <a href="<?php echo esc_url($product['url']); ?>">
                                    <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.99948 5.06828C7.80247 5.06828 6.82956 6.04044 6.82956 7.23542C6.82956 8.42951 7.80247 9.40077 8.99948 9.40077C10.1965 9.40077 11.1703 8.42951 11.1703 7.23542C11.1703 6.04044 10.1965 5.06828 8.99948 5.06828ZM8.99942 10.7482C7.0581 10.7482 5.47949 9.17221 5.47949 7.23508C5.47949 5.29705 7.0581 3.72021 8.99942 3.72021C10.9407 3.72021 12.5202 5.29705 12.5202 7.23508C12.5202 9.17221 10.9407 10.7482 8.99942 10.7482Z" fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.41273 7.2346C3.08674 10.9265 5.90646 13.1215 8.99978 13.1224C12.0931 13.1215 14.9128 10.9265 16.5868 7.2346C14.9128 3.54363 12.0931 1.34863 8.99978 1.34773C5.90736 1.34863 3.08674 3.54363 1.41273 7.2346ZM9.00164 14.4703H8.99804H8.99714C5.27471 14.4676 1.93209 11.8629 0.0546754 7.50073C-0.0182251 7.33091 -0.0182251 7.13864 0.0546754 6.96883C1.93209 2.60759 5.27561 0.00288103 8.99714 0.000185582C8.99894 -0.000712902 8.99894 -0.000712902 8.99984 0.000185582C9.00164 -0.000712902 9.00164 -0.000712902 9.00254 0.000185582C12.725 0.00288103 16.0676 2.60759 17.945 6.96883C18.0188 7.13864 18.0188 7.33091 17.945 7.50073C16.0685 11.8629 12.725 14.4676 9.00254 14.4703H9.00164Z" fill="currentColor"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        <?php
    }

    public static function instance(){
        if( !self::$_instance ){
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}

Pure_Wc_Sale_Notification::instance();