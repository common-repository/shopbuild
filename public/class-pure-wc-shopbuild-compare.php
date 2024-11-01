<?php
namespace PureWCShopbuild\Frontend;
/**
 * Quick View Class For Product
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Pure_Wc_Compare{

    private static $_instance = false;

    public function __construct(){
        add_action( 'init', array( $this, 'init' ) );
        add_action( 'wp_footer', array( $this, 'footer') );
        add_action( 'wp_ajax_pure_wc_compare', array( $this, 'compare') );
        add_action( 'wp_ajax_nopriv_pure_wc_compare', array( $this, 'compare') );
        // add_action( 'wp_ajax_woocommerce_ajax_add_to_cart', array( $this, 'ajax_add_to_cart' ) );
        // add_action( 'wp_ajax_nopriv_woocommerce_ajax_add_to_cart', array( $this, 'ajax_add_to_cart' ) );
        
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts') );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles') );
    }

    public function enqueue_scripts(){
        if( is_shop() || is_singular() ){
            wp_enqueue_script( 'pure-wc-compare', plugin_dir_url( __FILE__ ) . 'js/pure-wc-compare.js', array( 'jquery', 'jquery-ui-sortable' ), PURE_WC_SHOPBUILD_VERSION, true );
            
            wp_localize_script( 'pure-wc-compare', 'pure_wc_compare', array(
                '_nonce'       => wp_create_nonce( 'ajax-nonce' ),
                'ajax_url'	   => admin_url( 'admin-ajax.php' ),
                'cart_url'     => function_exists('wc_get_cart_url')? wc_get_cart_url() : '#'
            ));
        }
    }

    public function enqueue_styles(){
        if( is_shop() || is_singular() ){
            wp_enqueue_style( 'pure-wc-compare', plugin_dir_url( __FILE__ ) . 'css/pure-wc-compare.css', array(), PURE_WC_SHOPBUILD_VERSION, 'all' );
        }
    }

    public function init() {
        // image size
        add_image_size( 'pure_wc_compare', 460, 460, true );

        // shortcode
        add_shortcode( 'pure_wc_compare', [ $this, 'compare_shortcode' ] );

        // position
        $position = apply_filters('pure_wc_compare_position', 'before_title');

        if ( ! empty( $position ) ) {
            switch ( $position ) {
                case 'before_title':
                    add_action( 'woocommerce_shop_loop_item_title', [ $this, 'compare_button' ], 9 );
                    break;
                case 'after_title':
                    add_action( 'woocommerce_shop_loop_item_title', [ $this, 'compare_button' ], 11 );
                    break;
                case 'after_rating':
                    add_action( 'woocommerce_after_shop_loop_item_title', [ $this, 'compare_button' ], 6 );
                    break;
                case 'after_price':
                    add_action( 'woocommerce_after_shop_loop_item_title', [ $this, 'compare_button' ], 11 );
                    break;
                case 'before_add_to_cart':
                    add_action( 'woocommerce_after_shop_loop_item', [ $this, 'compare_button' ], 9 );
                    break;
                case 'after_add_to_cart':
                    add_action( 'woocommerce_after_shop_loop_item', [ $this, 'compare_button' ], 11 );
                    break;
                default:
                    add_action( 'pure_wc_button_position_' . $position, [ $this, 'compare_button' ] );
            }
            add_action( 'pure_wc_button_position_' . $position, [ $this, 'compare_button' ] );
        }
    }

    public function compare_shortcode( $attrs ){
        global $product;

        $compared_list = get_user_meta( get_current_user_id(), 'pure_compared_list', true );
        if( empty($product) ){
            return;
        }
        $attrs = shortcode_atts( [
            'id'      => null,
            'class'   => 'pure-wc-compare-btn'
        ], $attrs, 'pure_wc_compare' );

        if ( ! $attrs['id'] ) {
            $attrs['id'] = $product->get_id();
        }

        
        if( !empty($compared_list) && in_array( $product->get_id(), $compared_list ) ){
            $attrs['text'] = 'Listed';
        }

        $output = sprintf( 
            '<button data-bs-toggle="tooltip" data-bs-placement="bottom" class="button wp-element-button pure-tooltip %s" data-id="%s" title="Add To Compare"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5zm14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5z"/>
          </svg></button>',
            esc_attr( $attrs['class'] ),
            esc_attr( $attrs['id'] )
        );

        return apply_filters( 'pure_wc_compare_btn_html', $output, $attrs );
    }

    public function compare_button(){
        echo wp_kses(do_shortcode('[pure_wc_compare]'), pure_wc_get_kses_extended_ruleset());
    }

    public function compare(){
        check_ajax_referer('ajax-nonce', 'nonce');
        
        $product_id     = isset($_REQUEST['product_id']) ? absint( sanitize_key( $_REQUEST['product_id'] ) ) : pure_wc_get_last_product_id();
        $remove_action  = isset($_REQUEST['remove']) ? absint( sanitize_key( $_REQUEST['remove'] ) ) : 0;
        $is_product     = wc_get_product( $product_id );
        $compared_list  = array();

        if ( $is_product ) {
            if(!is_user_logged_in()){
                if( isset($_COOKIE['pure_wc_compared_list']) ){
                    $compared_list = explode(",", sanitize_text_field( wp_unslash($_COOKIE['pure_wc_compared_list'])));
                    if(is_array($compared_list)){
                        if($remove_action == 2){
                            setcookie("pure_wc_compared_list", '', time()-3600, "/");
                            $compared_list = array();
                        }else{
                            $search = array_search( $product_id, $compared_list );
                            if( ($remove_action == 1) && ($search >= 0)){
                                unset($compared_list[$search]);
                            }
                            if( is_bool($search) && ($search == false) ){
                                array_push($compared_list, $product_id);
                            }
                            setcookie("pure_wc_compared_list", implode(",", $compared_list), time()+(86400*7), "/");
                        }
                    }else{
                        if($remove_action == 2){
                            setcookie("pure_wc_compared_list", '', time()-3600, "/");
                            $compared_list = array();
                        }else{
                            if($remove_action == 1){
                                setcookie("pure_wc_compared_list", '', time()-3600, "/");
                            }else{
                                $compared_list[] = isset($_COOKIE['pure_wc_compared_list']) ? sanitize_text_field( wp_unslash($_COOKIE['pure_wc_compared_list']) ) : 0;
                                if(intval($product_id) != intval($_COOKIE['pure_wc_compared_list'])){
                                    array_push($compared_list, $product_id);
                                }
                                setcookie("pure_wc_compared_list", implode(",", $compared_list), time()+(86400*7), "/");
                            }
                        }
                    }
                }else{
                    setcookie("compare_list", implode(",", array($product_id)), time()+(86400*7), "/");
                    $compared_list = array($product_id);
                }
            }else{
                $compared_list = get_user_meta( get_current_user_id(), 'pure_compared_list', true );
            
                if( empty($compared_list) ){
                    update_user_meta( get_current_user_id(), 'pure_compared_list', array( $product_id ) );
                    $compared_list = get_user_meta( get_current_user_id(), 'pure_compared_list', true );
                }else{
                    $search = array_search( $product_id, $compared_list );

                    if( is_bool($search) && ($search == false) ){
                        array_push($compared_list, $product_id);
                    }
                    if( ($remove_action > 0) && ($search >= 0)){
                        unset($compared_list[$search]);
                    }
                    update_user_meta( get_current_user_id(), 'pure_compared_list', $compared_list );
                    $compared_list = get_user_meta( get_current_user_id(), 'pure_compared_list', true );
                }

                if($remove_action == 2){
                    update_user_meta( get_current_user_id(), 'pure_compared_list', array() );
                    $compared_list = array();
                }
            }

            $td_width =  (count($compared_list) < 4) ? "sb-product-compare-td-has-placeholder" : ' ';
            ?>
            <div class="product-compare-wrapper sb-product-compare-modal sb-ps-active">
                <div class="action-bar">
                    <span class="total-count">
                        <strong><?php esc_html_e('Total Added:', 'shopbuild'); ?></strong>
                        <?php echo esc_html(count($compared_list)); ?>
                    </span>
                    <a href="javascript:void(0);" class="pure-wc-compare-remove-all button wp-element-button"><span><?php esc_html_e('Remove All', 'shopbuild'); ?></span></a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <?php foreach( $compared_list as $item ): ?>
                                <th>
                                    <div class="products-name">
                                        <?php 
                                            $single_item    = wc_get_product( $item );
                                            if($single_item){
                                                echo esc_html($single_item->get_name());
                                            }
                                        ?>
                                        <a href="javascript:void(0)" class="remove-compare" data-product_id="<?php echo esc_attr($item); ?>">  
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.53033 1.53033C9.82322 1.23744 9.82322 0.762563 9.53033 0.46967C9.23744 0.176777 8.76256 0.176777 8.46967 0.46967L5 3.93934L1.53033 0.46967C1.23744 0.176777 0.762563 0.176777 0.46967 0.46967C0.176777 0.762563 0.176777 1.23744 0.46967 1.53033L3.93934 5L0.46967 8.46967C0.176777 8.76256 0.176777 9.23744 0.46967 9.53033C0.762563 9.82322 1.23744 9.82322 1.53033 9.53033L5 6.06066L8.46967 9.53033C8.76256 9.82322 9.23744 9.82322 9.53033 9.53033C9.82322 9.23744 9.82322 8.76256 9.53033 8.46967L6.06066 5L9.53033 1.53033Z" fill="currentColor"></path>
                                            </svg>
                                            Remove
                                        </a>
                                    </div>
                                </th>
                            <?php endforeach; ?>
                            <?php for ($i=1; $i <= ( 3 - count($compared_list)); $i++) : ?>
                                <th>Title</th>
                            <?php endfor; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="sb-product-compare-title sb-product-compare-td-image <?php echo esc_attr($td_width); ?>-is-label"><?php echo esc_html__('Product Image', 'shopbuild'); ?></td>
                            <?php foreach( $compared_list as $item ): ?>
                            <td class="<?php echo esc_attr($td_width); ?>">
                                <div class="thumbnails thumbnails-<?php echo esc_attr($item); ?>">
                                    <?php
                                        $single_item    = wc_get_product( $item );
                                        if ( ! $single_item ) {
                                            continue;
                                        }
                                        $attachment_ids = $single_item->get_gallery_image_ids();
                                        if ( $attachment_ids && $single_item->get_image_id() ) {
                                            $post_thumbnail_id = $single_item->get_image_id();
                                            if ( $post_thumbnail_id ) {
                                                $html = sprintf( '<div class="thumbnail" data-id="%s">', esc_attr($post_thumbnail_id) );
                                                $html .= wp_get_attachment_image( $post_thumbnail_id, 460 );
                                                $html .= '</div>';
                                            } else {
                                                $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
                                                $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'shopbuild' ) );
                                                $html .= '</div>';
                                            }
                                            print wp_kses_post(apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id )); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
                                            
                                            foreach ( $attachment_ids as $attachment_id ) {
                                                $html = sprintf( '<div class="thumbnail" data-id="%s">', esc_attr($attachment_id) );
                                                $html .= wp_get_attachment_image( $attachment_id, 460 );
                                                $html .= '</div>';
                                                print wp_kses_post(apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id )); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
                                            }
                                        }else{
                                            $post_thumbnail_id = $single_item->get_image_id();
                                            if ( $post_thumbnail_id ) {
                                                $html = '<div class="thumbnail">';
                                                $html .= wp_get_attachment_image( $post_thumbnail_id, 460 );
                                                $html .= '</div>';
                                            } else {
                                                $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
                                                $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'shopbuild' ) );
                                                $html .= '</div>';
                                            }
                                            print wp_kses_post(apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id )); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
                                        }
                                    ?>
                                </div>
                            </td>
                            <!-- copy -->
                            <?php endforeach; ?>

                            <?php for ($i=1; $i <= ( 3 - count($compared_list)); $i++) : ?>
                            <td class="<?php echo esc_attr($td_width); ?>">
                                <div class="sb-product-compare-td-placeholder-img">
                                    <img src="<?php echo esc_url(PURE_WC_SHOPBUILD_URL); ?>/public/img/placeholder.png" alt="">
                                </div>
                            </td>
                            <?php endfor; ?>
                        </tr>
                        
                        <tr>
                            <td class="sb-product-compare-title sb-product-compare-td-price"><?php esc_html_e('Product Price', 'shopbuild'); ?></td>
                            <?php foreach( $compared_list as $item ): ?>
                                <td>
                                    <?php 
                                        $single_item    = wc_get_product( $item );
                                        if ( ! $single_item ) {
                                            continue;
                                        }
                                    ?>
                                    <div class="products-price product-price-<?php echo esc_attr($single_item->get_id()); ?>">
                                        <p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php print wp_kses_post($single_item->get_price_html()); ?></p>
                                    </div>
                                    
                                </td>
                            <?php endforeach; ?>

                            <?php for ($i=1; $i <= ( 3 - count($compared_list)); $i++) : ?>
                            <td class="sb-product-compare-td-placeholder">
                                <span class="sb-product-compare-td-placeholder-span"></span>
                            </td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <td class="sb-product-compare-title sb-product-compare-td-variation"><?php esc_html_e('Product Variations', 'shopbuild'); ?></td>
                            <?php 
                            
                            foreach( $compared_list as $item ): 
                                $single_item    = wc_get_product( $item );
                                if ( ! $single_item ) {
                                    continue;
                                }
                            ?>
                                <td>
                                    <div <?php wc_product_class( "products-variations", $single_item ); ?>>
                                        <?php
                                            if( $single_item->is_type('variable') ){
                                                $get_variations       = count( $single_item->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $single_item );
                                                $available_variations = $get_variations ? $this->get_available_variations( $single_item ) : false;
                                                $attributes           = $this->get_variation_attributes( $single_item );
                                                
                                                $attribute_keys  = array_keys( $attributes );
                                                $variations_json = wp_json_encode( $available_variations );
                                                
                                                ?>
                                                
                                                <form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $single_item->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo esc_attr(absint( $item )); ?>" data-product_variations="<?php echo esc_attr($variations_json); // WPCS: XSS ok. ?>">
                                                
                                                    <?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
                                                        <p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'Not in stock', 'shopbuild' ) ) ); ?></p>
                                                    <?php else : ?>
                                                        <table class="variations" cellspacing="0" role="presentation">
                                                            <tbody>
                                                                <?php foreach ( $attributes as $attribute_name => $options ) : ?>
                                                                    <tr>
                                                                        <th class="label"><label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo esc_html(wc_attribute_label( $attribute_name )); // WPCS: XSS ok. ?></label></th>
                                                                        <td class="value">
                                                                            <?php
                                                                                wc_dropdown_variation_attribute_options(
                                                                                    array(
                                                                                        'options'   => $options,
                                                                                        'attribute' => $attribute_name,
                                                                                        'product'   => $single_item,
                                                                                    )
                                                                                );
                                                                                echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'shopbuild' ) . '</a>' ) ) : '';
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    <?php endif; ?>
                                                
                                                    <button data-quantity="<?php echo esc_attr( $single_item->get_min_purchase_quantity() ); ?>" data-product_id="<?php echo esc_attr( $single_item->get_id() ); ?>" type="submit" class="pure_single_add_to_cart_button button wc-variation-selection-needed alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"><?php echo esc_html( $single_item->single_add_to_cart_text() ); ?></button>

                                                    <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

                                                    <input type="hidden" name="add-to-cart" value="<?php echo esc_html(absint( $single_item->get_id() )); ?>" />
                                                    <input type="hidden" name="product_id" value="<?php echo esc_html(absint( $single_item->get_id() )); ?>" />
                                                    <input type="hidden" name="variation_id" class="variation_id" value="0" />
                                                </form>
                                                
                                                
                                                <?php
                                                
                                            }else{ ?>
                                                <form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $single_item->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
                                                
                                        
                                                <?php
                                                
                                                woocommerce_quantity_input(
                                                    array(
                                                        'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $single_item->get_min_purchase_quantity(), $single_item ),
                                                        'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $single_item->get_max_purchase_quantity(), $single_item ),
                                                        'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( absint($_POST['quantity']) ) ) : $single_item->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                                                    )
                                                );
                                        
                                                
                                                ?>
                                        
                                                <button data-quantity="<?php echo esc_attr($single_item->get_min_purchase_quantity()); ?>" data-product_id="<?php echo esc_attr($single_item->get_id()); ?>" type="submit" name="add-to-cart" value="<?php echo esc_attr( $single_item->get_id() ); ?>" class="pure_single_add_to_cart_button button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>">
                                                    <span class="sbp-spinner"></span>
                                                    <svg class="sb-cart-icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.54431 4.80484L4.08701 11.2487C4.12661 11.7447 4.53251 12.1167 5.02841 12.1167H5.03201H14.8519H14.8537C15.3227 12.1167 15.7232 11.7681 15.7898 11.3053L16.6448 5.41221C16.6646 5.27205 16.6295 5.13189 16.544 5.01868C16.4594 4.90457 16.3352 4.8309 16.1948 4.81113C16.0067 4.81832 8.20092 4.80754 3.54431 4.80484ZM5.02647 13.4642C3.84117 13.4642 2.83766 12.5405 2.74136 11.359L1.91696 1.57098L0.560653 1.33738C0.192551 1.27269 -0.0531497 0.924974 0.00985058 0.557495C0.0746508 0.190017 0.430152 -0.0489788 0.790154 0.00852392L2.66216 0.331977C2.96366 0.384987 3.19316 0.634765 3.21926 0.940248L3.43076 3.45689C16.2792 3.46228 16.3206 3.46857 16.3827 3.47576C16.884 3.54854 17.325 3.80999 17.6256 4.21251C17.9262 4.61413 18.0522 5.1092 17.9802 5.60516L17.1261 11.4974C16.965 12.6187 15.9894 13.4642 14.8554 13.4642H14.8509H5.03367H5.02647Z" fill="currentColor"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M13.4079 8.12567H10.9131C10.5396 8.12567 10.2381 7.82379 10.2381 7.45181C10.2381 7.07984 10.5396 6.77795 10.9131 6.77795H13.4079C13.7805 6.77795 14.0829 7.07984 14.0829 7.45181C14.0829 7.82379 13.7805 8.12567 13.4079 8.12567Z" fill="currentColor"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.63943 15.9048C4.91033 15.9048 5.12903 16.1235 5.12903 16.3944C5.12903 16.6653 4.91033 16.8849 4.63943 16.8849C4.36763 16.8849 4.14893 16.6653 4.14893 16.3944C4.14893 16.1235 4.36763 15.9048 4.63943 15.9048Z" fill="currentColor"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.63859 16.2097C4.53689 16.2097 4.45409 16.2925 4.45409 16.3942C4.45409 16.5985 4.82399 16.5985 4.82399 16.3942C4.82399 16.2925 4.74029 16.2097 4.63859 16.2097ZM4.6386 17.5569C3.996 17.5569 3.474 17.0349 3.474 16.3933C3.474 15.7518 3.996 15.2307 4.6386 15.2307C5.28121 15.2307 5.80411 15.7518 5.80411 16.3933C5.80411 17.0349 5.28121 17.5569 4.6386 17.5569Z" fill="currentColor"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7918 15.9048C15.0627 15.9048 15.2823 16.1235 15.2823 16.3944C15.2823 16.6653 15.0627 16.8849 14.7918 16.8849C14.52 16.8849 14.3013 16.6653 14.3013 16.3944C14.3013 16.1235 14.52 15.9048 14.7918 15.9048Z" fill="currentColor"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7906 16.2098C14.6898 16.2098 14.607 16.2926 14.607 16.3943C14.6079 16.6004 14.9769 16.5986 14.976 16.3943C14.976 16.2926 14.8923 16.2098 14.7906 16.2098ZM14.7909 17.5569C14.1483 17.5569 13.6263 17.0349 13.6263 16.3933C13.6263 15.7518 14.1483 15.2307 14.7909 15.2307C15.4344 15.2307 15.9573 15.7518 15.9573 16.3933C15.9573 17.0349 15.4344 17.5569 14.7909 17.5569Z" fill="currentColor"/>
                                                    </svg> 
                                                    <?php echo esc_html( $single_item->single_add_to_cart_text() ); ?>                                                        
                                                </button>
                                            </form>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </td>
                            <?php endforeach; ?>

                            <?php for ($i=1; $i <= ( 3 - count($compared_list)); $i++) : ?>
                            <td class="sb-product-compare-td-placeholder">
                                <span class="sb-product-compare-td-placeholder-span"></span>
                            </td>
                            <?php endfor; ?>
                        </tr>
                        <?php
                        if ( ! wc_review_ratings_enabled() ) {
                            return;
                        }else{
                        ?>
                        <tr>
                            <td class="sb-product-compare-title sb-product-compare-td-rating"><?php esc_html_e('Product Rating', 'shopbuild'); ?></td>
                            <?php foreach( $compared_list as $item ): ?>
                                <td>
                                    <div class="products-rating">
                                        <?php 
                                            $single_item    = wc_get_product( $item );
                                            if ( ! $single_item ) {
                                                continue;
                                            }
                                            $rating_count = $single_item->get_rating_count();
                                            $review_count = $single_item->get_review_count();
                                            $average      = $single_item->get_average_rating();
                                            
                                            if ( $rating_count > 0 ) : ?>
                                            
                                                <div class="woocommerce-product-rating">
                                                    <?php print wp_kses_post(wc_get_rating_html( $average, $rating_count )); // WPCS: XSS ok. ?>
                                                    <?php if ( comments_open() ) : ?>
                                                        <?php //phpcs:disable ?>
                                                        <a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<?php echo 
                                                            wp_kses(
                                                                _n( 
                                                                    '%s customer review', 
                                                                    '%s customer reviews',
                                                                    '<span class="count">' . esc_html( $review_count ) . '</span>',
                                                                    'shopbuild' 
                                                                ), 
                                                                pure_wc_get_kses_extended_ruleset()
                                                            ); ?>)</a>
                                                        <?php // phpcs:enable ?>
                                                    <?php endif ?>
                                                </div>
                                            <?php else: ?>

                                                <div class="sbp-product-compare-rating-not-found">
                                                    <span><?php esc_html_e('No Ratings', 'shopbuild'); ?></span>
                                                </div>
                                            
                                        <?php endif; ?>
                                    </div>
                                </td>
                            <?php endforeach; ?>
                            <?php for ($i=1; $i <= ( 3 - count($compared_list)); $i++) : ?>
                            <td class="sb-product-compare-td-placeholder">
                                <span class="sb-product-compare-td-placeholder-span"></span>
                            </td>
                            <?php endfor; ?>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td class="sb-product-compare-title sb-product-compare-td-sku"><?php esc_html_e('Product SKU', 'shopbuild'); ?></td>
                            <?php foreach( $compared_list as $item ): ?>
                                <td>
                                    <div class="products-sku">
                                        <?php 
                                            $single_item    = wc_get_product( $item );
                                            if ( ! $single_item ) {
                                                continue;
                                            }
                                            if ( wc_product_sku_enabled() && ( $single_item->get_sku() || $single_item->is_type( 'variable' ) ) ) : ?>

                                                <span class="sku"><?php echo ( $sku = $single_item->get_sku() ) ? esc_html($sku) : esc_html__( 'N/A', 'shopbuild' ); ?></span>
                                        
                                        <?php endif; ?>
                                    </div>
                                </td>
                            <?php endforeach; ?>

                            <?php for ($i=1; $i <= ( 3 - count($compared_list)); $i++) : ?>
                            <td class="sb-product-compare-td-placeholder">
                                <span class="sb-product-compare-td-placeholder-span"></span>
                            </td>
                            <?php endfor; ?>

                        </tr>
                        
                        <tr>
                            <td class="sb-product-compare-title sb-product-compare-td-desc"><?php esc_html_e('Product Descriptions', 'shopbuild'); ?></td>
                            <?php foreach( $compared_list as $item ): ?>
                                <td>
                                    <div class="products-descriptions">
                                        <?php 
                                            $single_item    = wc_get_product( $item );
                                            if ( ! $single_item ) {
                                                continue;
                                            }
                                            echo esc_html($single_item->get_description());
                                        ?>
                                    </div>
                                </td>
                            <?php endforeach; ?>

                            <?php for ($i=1; $i <= ( 3 - count($compared_list)); $i++) : ?>
                            <td class="sb-product-compare-td-placeholder">
                                <span class="sb-product-compare-td-placeholder-span"></span>
                            </td>
                            <?php endfor; ?>

                        </tr>
                    </tbody>
                </table>
            </div>
            <?php
        }
        wp_die();
    }


    // public function ajax_add_to_cart() {
    //     check_ajax_referer( 'shopbuild_ajax_add_to_cart', 'security' );

	// 	if ( empty( $_POST['product_id'] ) ) {
	// 		return;
	// 	}

    //     $product_id         = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    //     $quantity           = empty($_POST['quantity']) ? 1 : wc_stock_amount( absint($_POST['quantity']));
    //     $variation_id       = ! empty( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : 0;
    //     $variation          = ! empty( $_POST['variation'] ) ? array_map( 'sanitize_text_field', $_POST['variation'] ) : array();
    //     $passed_validation  = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variation);
    //     $product_status = get_post_status($product_id);

    //     if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation) && 'publish' === $product_status) {

    //         do_action('woocommerce_ajax_added_to_cart', $product_id);

    //         if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
    //             wc_add_to_cart_message(array($product_id => $quantity), true);
    //         }

    //         \WC_AJAX::get_refreshed_fragments();
    //     } else {

    //         $data = array(
    //             'error' => true,
    //             'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
    //         );

    //         wp_send_json($data); 
    //     }

        

    //     wp_die();
    // }

    public function get_available_variations( $product, $return = 'array' ) {
        $variation_ids        = $product->get_children();
        $available_variations = array();
    
        if ( is_callable( '_prime_post_caches' ) ) {
            _prime_post_caches( $variation_ids );
        }
    
        foreach ( $variation_ids as $variation_id ) {
    
            $variation = wc_get_product( $variation_id );
    
            // Hide out of stock variations if 'Hide out of stock items from the catalog' is checked.
            if ( ! $variation || ! $variation->exists() || ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) && ! $variation->is_in_stock() ) ) {
                continue;
            }
    
            // Filter 'woocommerce_hide_invisible_variations' to optionally hide invisible variations (disabled variations and variations with empty price).
            if ( apply_filters( 'woocommerce_hide_invisible_variations', true, $product->get_id(), $variation ) && ! $this->variation_is_visible( $variation ) ) {
                continue;
            }
    
            if ( 'array' === $return ) {
                $available_variations[] = $product->get_available_variation( $variation );
            } else {
                $available_variations[] = $variation;
            }
        }
    
        if ( 'array' === $return ) {
            $available_variations = array_values( array_filter( $available_variations ) );
        }
    
        return $available_variations;
    }

    public function variation_is_visible( $product ) {
        return apply_filters( 'woocommerce_variation_is_visible', 'publish' === get_post_status( $product->get_id() ) && '' !== $product->get_price(), $product->get_id(), $product->get_parent_id(), $product );
    }

    public function get_variation_attributes( $product ) {
        $attributes           = $product->get_attributes();
        $variation_attributes = array();
    
        foreach ( $attributes as $key => $value ) {
            
            if(taxonomy_exists($key)){
                $taxonomies = wc_get_product_terms( $product->get_id(), $key );
                $tax_values = array();
                foreach( $taxonomies as $taxonomy ){
                    array_push( $tax_values, $taxonomy->slug );
                }
                $variation_attributes[ $key ] = $tax_values;
            }else{
                $variation_attributes[ $value->get_name() ] = $value->get_options();
            }
            
        }
        return $variation_attributes;
    }

    public function footer(){
        $class = !is_user_logged_in() ? 'login_in_message' : ' ' ;
        $compared_list = get_user_meta( get_current_user_id(), 'pure_compared_list', true );
        ?>
        <div id="pure-wc-compare-popup" class="sb-product-compare-modal white-popup purewcmfp-hide <?php echo esc_attr($class); ?>">
            <div class="pure-wc-compare-loading">
                <div class="pure-wc-compare-loading-icon-wrapper">
                    <span class="pure-wc-compare-loading-icon"></span>
                </div>
            </div>
            <div class="sb-product-compare-modal-content"></div>
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
Pure_Wc_Compare::instance();