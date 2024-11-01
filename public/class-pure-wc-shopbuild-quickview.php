<?php
namespace PureWCShopbuild\Frontend;
/**
 * Quick View Class For Product
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Pure_Wc_QuickView{

    private static $_instance = false;

    public function __construct(){
        add_action( 'init', array($this, 'init') );
        add_action( 'wp_ajax_pure_quickview', array( $this, 'quickview') );
        add_action( 'wp_ajax_nopriv_pure_quickview', array( $this, 'quickview') );
        
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts') );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles') );
    }

    public function enqueue_scripts(){
        // Enqueue Flexslider JS and CSS
        // wp_enqueue_style('pure-flexslider-css', plugin_dir_url( __FILE__ ) . 'css/flexslider.css', array(), PURE_WC_SHOPBUILD_VERSION, 'all');
        // wp_enqueue_style('pure-swiper-css', plugin_dir_url( __FILE__ ) . 'css/swiper.min.css', array(), PURE_WC_SHOPBUILD_VERSION, 'all');
        // wp_enqueue_script('pure-flexslider-js', plugin_dir_url( __FILE__ ). 'js/flexslider.js', array('jquery'), PURE_WC_SHOPBUILD_VERSION, true);
        wp_enqueue_script('pure-swiper-js', plugin_dir_url( __FILE__ ). 'js/swiper.min.js', array(), PURE_WC_SHOPBUILD_VERSION, true);
        if( is_shop() || is_singular() ){
            wp_enqueue_script( 'pure-wc-popup', plugin_dir_url( __FILE__ ) . 'js/pure-wc-popup.js', array( 'jquery' ), PURE_WC_SHOPBUILD_VERSION, true );
            wp_enqueue_script( 'slick', plugin_dir_url( __FILE__ ) . 'js/slick.min.js', array( 'jquery' ), PURE_WC_SHOPBUILD_VERSION, true );
            wp_enqueue_script( 'pure-wc-quickview', plugin_dir_url( __FILE__ ) . 'js/pure-wc-quickview.js', array( 'jquery', 'wc-add-to-cart-variation', 'wc-single-product', 'flexslider' ), PURE_WC_SHOPBUILD_VERSION, true );
            
            wp_localize_script( 'pure-wc-quickview', 'pure_wc_quickview', array(
                '_nonce'   => wp_create_nonce( 'ajax-nonce' ),
                'ajax_url'	   => admin_url( 'admin-ajax.php' ),
                'cart_url'     => function_exists('wc_get_cart_url')? wc_get_cart_url() : '#',
                'unavailable_text'       => __( 'Selected variant is unavailable.', 'shopbuild' ),
                'ajax_add_to_cart_nonce' => wp_create_nonce( 'shopbuild_ajax_add_to_cart' )
            ));
        }
    }

    public function enqueue_styles(){
       if( is_shop() || is_singular() ){
        wp_enqueue_style( 'pure-wc-popup', plugin_dir_url( __FILE__ ) . 'css/pure-wc-popup.css', array(), PURE_WC_SHOPBUILD_VERSION, 'all' );
        wp_enqueue_style( 'slick', plugin_dir_url( __FILE__ ) . 'css/slick.css', array(), PURE_WC_SHOPBUILD_VERSION, 'all' );
        wp_enqueue_style( 'pure-wc-quickview', plugin_dir_url( __FILE__ ) . 'css/pure-wc-quickview.css', array(), PURE_WC_SHOPBUILD_VERSION, 'all' );
       }
    }

    public function init() {
        // image size
        add_image_size( 'pure_wc_quickview', 460, 460, true );

        // shortcode
        add_shortcode( 'pure_wc_quickview', [ $this, 'quickview_shortcode' ] );

        // position
        $position = apply_filters('pure_wc_quickview_position', 'before_title');

        if ( ! empty( $position ) ) {
            switch ( $position ) {
                case 'before_title':
                    add_action( 'woocommerce_shop_loop_item_title', array( $this, 'quickview_button' ), 9 );
                    break;
                case 'after_title':
                    add_action( 'woocommerce_shop_loop_item_title', array( $this, 'quickview_button' ), 11 );
                    break;
                case 'after_rating':
                    add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'quickview_button' ), 6 );
                    break;
                case 'after_price':
                    add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'quickview_button' ), 11 );
                    break;
                case 'before_add_to_cart':
                    add_action( 'woocommerce_after_shop_loop_item', array( $this, 'quickview_button' ), 9 );
                    break;
                case 'after_add_to_cart':
                    add_action( 'woocommerce_after_shop_loop_item', array( $this, 'quickview_button' ), 11 );
                    break;
                default:
                    add_action( 'pure_wc_button_position_' . $position, array( $this, 'quickview_button' ) );
            }
            add_action( 'pure_wc_button_position_' . $position, array( $this, 'quickview_button' ) );
        }
    }

    public function quickview_shortcode( $attrs ){

        $attrs = shortcode_atts( [
            'id'      => null,
            'class'   => 'pure-wc-quickview-btn'
        ], $attrs, 'pure_wc_quickview' );

        if ( ! $attrs['id'] ) {
            global $product;
            if(is_null($product) || !is_a($product, 'WC_Product') ){
                return;
            }
            $attrs['id'] = $product->get_id();
        }

        $output = sprintf( 
            '<button data-bs-toggle="tooltip" data-bs-placement="bottom" class="button wp-element-button pure-tooltip %s" data-id="%s" title="Quickview"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
          </svg></button>',
            esc_attr( $attrs['class'] ),
            esc_attr( $attrs['id'] )
        );

        return apply_filters( 'pure_wc_quickview_btn_html', $output, $attrs );
    }

    public function quickview_button(){
        echo wp_kses(do_shortcode('[pure_wc_quickview]'), pure_wc_get_kses_extended_ruleset());
    }

    public function quickview(){
        check_ajax_referer('ajax-nonce', 'nonce');
        global $post, $product;
        $product_id = isset($_REQUEST['product_id'])? absint( sanitize_key( wp_unslash($_REQUEST['product_id']) ) ) : -1;
        $_SESSION['product_id'] = $product_id;
        $product    = wc_get_product( $product_id );
        $settings = \PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_quickview_settings');

        if( (isset($settings['template_type']) && $settings['template_type'] == 'custom') && pure_wc_is_pro_active() ){
            echo '<div class="product-quickview-wrapper sb-product-quickview-modal sb-ps-active">';
                pure_wc_render_elementor_template_by_id( $settings['template'] );
            echo '</div>';
        }else{
            if ( $product ) {
                $post = get_post( $product_id );
                setup_postdata( $post );
    
                $attachment_ids = $product->get_gallery_image_ids();
                ?>
                <div class="product-quickview-wrapper sb-product-quickview-modal sb-ps-active">
                    <div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
    
                        <?php 
                            $slider_main_active = !empty($attachment_ids) ? 'sb-product-quickview-main-thumb-slider' : '';
    
                            $slider_thumb_active = !empty($attachment_ids) ? ' sb-product-quickview-nav-slider' : 'sb-d-none';
                        ?>
                        <div class="sb-thumbnails-wrapper">
                            <div class="sb-thumbnails pure-quickview-thumbnails <?php echo esc_attr($slider_main_active); ?>">
                                <?php
    
                                    if ( $attachment_ids && $product->get_image_id() ) {
                                        $post_thumbnail_id = $product->get_image_id();
                                        if ( $post_thumbnail_id ) {
                                            $html = sprintf( '<div class="sb-thumbnail" data-id="%s">', esc_attr($post_thumbnail_id) );
                                            $html .= wp_get_attachment_image( $post_thumbnail_id, 'full' );
                                            $html .= '</div>';
                                        } else {
                                            $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
                                            $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'shopbuild' ) );
                                            $html .= '</div>';
                                        }
                                        print wp_kses_post(apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ));
                                        
                                        foreach ( $attachment_ids as $attachment_id ) {
                                            $html = sprintf( '<div class="sb-thumbnail" data-id="%s">', esc_attr($attachment_id) );
                                            $html .= wp_get_attachment_image( $attachment_id, 'full' );
                                            $html .= '</div>';
                                            print wp_kses_post(apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id )); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
                                        }
                                    }else{
                                        $post_thumbnail_id = $product->get_image_id();
                                        if ( $post_thumbnail_id ) {
                                            $html = '<div class="sb-thumbnail">';
                                            $html .= wp_get_attachment_image( $post_thumbnail_id, 'full' );
                                            $html .= '</div>';
                                        } else {
                                            $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
                                            $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'shopbuild' ) );
                                            $html .= '</div>';
                                        }
                                        print wp_kses_post(apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ));
                                    }
                                    
                                ?>
                            </div>
    
    
                            <div class="sb-thumbnails <?php echo esc_attr($slider_thumb_active); ?>">
                                <?php
                                    $attachment_ids = $product->get_gallery_image_ids();
    
                                    if ( $attachment_ids && $product->get_image_id() ) {
                                        $post_thumbnail_id = $product->get_image_id();
                                        if ( $post_thumbnail_id ) {
                                            $html = sprintf( '<div class="sb-thumbnail" data-id="%s">', esc_attr($post_thumbnail_id) );
                                            $html .= wp_get_attachment_image( $post_thumbnail_id, 'full' );
                                            $html .= '</div>';
                                        } else {
                                            $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
                                            $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'shopbuild' ) );
                                            $html .= '</div>';
                                        }
                                        print wp_kses_post(apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ));
                                        
                                        foreach ( $attachment_ids as $attachment_id ) {
                                            $html = sprintf( '<div class="sb-thumbnail" data-id="%s">', esc_attr($attachment_id) );
                                            $html .= wp_get_attachment_image( $attachment_id, 'full' );
                                            $html .= '</div>';
                                            print wp_kses_post(apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id )); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
                                        }
                                    }else{
                                        $post_thumbnail_id = $product->get_image_id();
                                        if ( $post_thumbnail_id ) {
                                            $html = '<div class="sb-thumbnail">';
                                            $html .= wp_get_attachment_image( $post_thumbnail_id, 'full' );
                                            $html .= '</div>';
                                        } else {
                                            $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
                                            $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'shopbuild' ) );
                                            $html .= '</div>';
                                        }
                                        print wp_kses_post(apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ));
                                    }
                                    
                                ?>
                            </div>
                        </div>
                        
    
                        <div class="summary entry-summary">
                            <?php
                                woocommerce_template_single_title();
                                woocommerce_template_single_rating();
                                woocommerce_template_single_excerpt();
                                woocommerce_template_single_price();
                                woocommerce_template_single_add_to_cart();
                                woocommerce_template_single_meta();
                                woocommerce_template_single_sharing();
                            ?>
                        </div>
                    </div>
                </div>
    
                <?php
    
                wp_reset_postdata();
            }
        }


        wp_die();
    }

    public function is_already_added_to_cart( $search_products ) {
        $count = 0; // Initializing
    
        if ( ! WC()->cart->is_empty() ) {
            // Loop though cart items
            foreach(WC()->cart->get_cart() as $cart_item ) {
                // Handling also variable products and their products variations
                $cart_item_ids = array($cart_item['product_id'], $cart_item['variation_id']);
    
                // Handle a simple product Id (int or string) or an array of product Ids 
                if( ( is_array($search_products) && array_intersect($search_products, $cart_item_ids) ) || ( !is_array($search_products) && in_array($search_products, $cart_item_ids) ) )
                    $count++; // incrementing items count
            }
        }
        return $count; // returning matched items count 
    }

    public static function instance(){
        if( !self::$_instance ){
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}

Pure_Wc_QuickView::instance();