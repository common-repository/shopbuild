<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly      

/**
 * Function Without Shop Page
 */

// check cross sell is active on cart page
$is_cross_sell_active = pure_wc_sb_get_option('_pure_shopbuild_modules', 'pure_wc_cross_sell');
if(!$is_cross_sell_active){
   remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 10 );
}

add_action( 'pure_wc_cross_sell_display', 'pure_woocommerce_cross_sell_display', 10, 1 );


function pure_woocommerce_cross_sell_display($args = array()) {
   $columns = 2;
   $orderby = 'rand';
   $order = 'desc';
   $limit = 2;


   // Get visible cross sells then sort them at random.
   $cross_sells = array_filter( array_map( 'wc_get_product', WC()->cart->get_cross_sells() ), 'wc_products_array_filter_visible' );

   wc_set_loop_prop( 'name', 'cross-sells' );
   wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_cross_sells_columns', $columns ) );

   // Handle orderby and limit results.
   $orderby     = apply_filters( 'woocommerce_cross_sells_orderby', $orderby );
   $order       = apply_filters( 'woocommerce_cross_sells_order', $order );
   $cross_sells = wc_products_array_orderby( $cross_sells, $orderby, $order );
   /**
    * Filter the number of cross sell products should on the product page.
    *
    * @param int $limit number of cross sell products.
    * @since 3.0.0
    */
   $limit       = intval( apply_filters( 'woocommerce_cross_sells_total', $limit ) );
   $cross_sells = $limit > 0 ? array_slice( $cross_sells, 0, $limit ) : $cross_sells;

   $args_new = array(
      'pure_cross_sell_col' => $args['pure_cross_sell_col'],
      'cross_sells' => $cross_sells
   );

   if(!empty($args['pure_cross_sell_heading'])){
      $args_new['pure_cross_sell_heading'] = $args['pure_cross_sell_heading'];
   }

   wc_get_template('cart/cross-sells.php', $args_new);
}


function pure_wc_coupon_form( $button_title, $coupon_title = '', $coupon_style = 'default' ) {
   
   ?>

   <?php if($coupon_style == 'coupon_toggle') : ?>
   <div class="pure-coupon-toggle">
      <div class="pure-coupon-toggle-wrapper">
         <button class="pure-coupon-toggle-btn pure-coupon-toggle-opener-btn">
            <?php echo wp_kses($coupon_title, pure_wc_get_kses_extended_ruleset()); ?>
         </button>
      </div>
      <div class="pure-coupon-toggle-content">
         <div class="woocommerce">
            <div class="coupon">
                  <div class="sb-d-sm-flex sb-flex-wrap">
                     <input type="text" name="coupon_code" class="input-text col-7" id="pure_coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'shopbuild' ); ?>" />
                     <button name="apply_coupon" id="pure_coupon_submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"><?php echo esc_html( $button_title ); ?></button>
                  </div>
            </div>
         </div>
      </div>
   </div>

   <?php elseif($coupon_style == 'coupon_inline') : ?>
   <div class="pure-coupon-inline">
      <div class="woocommerce">
         <div class="coupon">
               <div class="pure-coupon-inline-content">
                  <input type="text" name="coupon_code" class="input-text" id="pure_coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'shopbuild' ); ?>" />
                  <button name="apply_coupon" id="pure_coupon_submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"><?php echo esc_html( $button_title ); ?></button>
               </div>
         </div>
      </div>
   </div>
   <?php elseif($coupon_style == 'coupon_toggle_inline') : ?>
   <div class="pure-coupon-toggle">
      <div class="pure-coupon-toggle-wrapper">
         <button class="pure-coupon-toggle-btn pure-coupon-toggle-opener-btn"><?php echo wp_kses($coupon_title, pure_wc_get_kses_extended_ruleset()); ?></button>
      </div>
      <div class="pure-coupon-toggle-content">
         <div class="woocommerce">
            <div class="coupon">
               <div class="pure-coupon-inline-content">
                  <input type="text" name="coupon_code" class="input-text" id="pure_coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'shopbuild' ); ?>" />
                  <button name="apply_coupon" id="pure_coupon_submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"><?php echo esc_html( $button_title ); ?></button>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php else : ?>
      <div class="woocommerce">
         <div class="coupon">
               <?php if(!empty($coupon_title)) : ?>
               <label for="pure_coupon_code" class="col-12"><?php echo esc_html($coupon_title); ?></label>
               <?php endif; ?>
               <div class="sb-d-sm-flex sb-flex-wrap">
                  <input type="text" name="coupon_code" class="input-text col-7" id="pure_coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'shopbuild' ); ?>" />
                  <button name="apply_coupon" id="pure_coupon_submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"><?php echo esc_html( $button_title ); ?></button>
               </div>
         </div>
      </div>
   <?php endif; ?>
   <?php
}

add_action('pure_wc_coupon_form', 'pure_wc_coupon_form', 10, 3);

/** 
 * Variation Swatches Action
 */
function pure_wc_swatches(){
   if( class_exists('Tp_Wvs') ){
      echo do_shortcode('[pure_wc_swatches]');
   }
}

$swatch_options = function_exists('pure_swatches_admin')? pure_swatches_admin()->get_settings() : '';
$swatch_position = !empty($swatch_options)? $swatch_options['tpwvs_shop']['swatch_position'] : 'after_title';

switch($swatch_position){
   case 'after_title':
      add_action( 'pure_wc_before_rating', 'pure_wc_swatches', 10 );
      break;
   case 'after_rating':
      add_action( 'pure_wc_before_price', 'pure_wc_swatches', 10 );
      break;
   case 'after_price':
      add_action( 'pure_wc_after_price', 'pure_wc_swatches', 10 );
      break;
   case 'after_thumbnail':
      add_action( 'pure_wc_before_tag', 'pure_wc_swatches', 10 );
      break;
   default:
      add_action( 'pure_wc_before_rating', 'pure_wc_swatches', 10 );
}


/**
 * Sale Badge
 */
function pure_wc_sale_badge(){
   global $post, $product;
   $options = pure_wc_sb_get_option('_pure_shopbuild_modules', 'pure_wc_sale_badge');

   if ( $product->is_on_sale() && $options ){
      echo '<span>' . esc_html__( 'Sale!', 'shopbuild' ) . '</span>';
   }
}
add_action( 'pure_wc_sale_badge', 'pure_wc_sale_badge' );


function pure_wc_added_wishlist($html, $null){

   if(is_singular()){
      $html =
         ' <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path fill-rule="evenodd" clip-rule="evenodd" d="M2.33541 7.54172C3.36263 10.6766 7.42094 13.2113 8.49945 13.8387C9.58162 13.2048 13.6692 10.6421 14.6635 7.5446C15.3163 5.54239 14.7104 3.00621 12.3028 2.24514C11.1364 1.8779 9.77578 2.1014 8.83648 2.81432C8.64012 2.96237 8.36757 2.96524 8.16974 2.81863C7.17476 2.08487 5.87499 1.86999 4.69024 2.24514C2.28632 3.00549 1.68259 5.54167 2.33541 7.54172ZM8.50115 15C8.4103 15 8.32018 14.9784 8.23812 14.9346C8.00879 14.8117 2.60674 11.891 1.29011 7.87081C1.28938 7.87081 1.28938 7.8701 1.28938 7.8701C0.462913 5.33895 1.38316 2.15812 4.35418 1.21882C5.7492 0.776121 7.26952 0.97088 8.49895 1.73195C9.69029 0.993159 11.2729 0.789057 12.6401 1.21882C15.614 2.15956 16.5372 5.33966 15.7115 7.8701C14.4373 11.8443 8.99571 14.8088 8.76492 14.9332C8.68286 14.9777 8.592 15 8.50115 15Z" fill="currentColor"></path>
               <path d="M8.49945 13.8387L8.42402 13.9683L8.49971 14.0124L8.57526 13.9681L8.49945 13.8387ZM14.6635 7.5446L14.5209 7.4981L14.5207 7.49875L14.6635 7.5446ZM12.3028 2.24514L12.348 2.10211L12.3478 2.10206L12.3028 2.24514ZM8.83648 2.81432L8.92678 2.93409L8.92717 2.9338L8.83648 2.81432ZM8.16974 2.81863L8.25906 2.69812L8.25877 2.69791L8.16974 2.81863ZM4.69024 2.24514L4.73548 2.38815L4.73552 2.38814L4.69024 2.24514ZM8.23812 14.9346L8.16727 15.0668L8.16744 15.0669L8.23812 14.9346ZM1.29011 7.87081L1.43266 7.82413L1.39882 7.72081H1.29011V7.87081ZM1.28938 7.8701L1.43938 7.87009L1.43938 7.84623L1.43197 7.82354L1.28938 7.8701ZM4.35418 1.21882L4.3994 1.36184L4.39955 1.36179L4.35418 1.21882ZM8.49895 1.73195L8.42 1.85949L8.49902 1.90841L8.57801 1.85943L8.49895 1.73195ZM12.6401 1.21882L12.6853 1.0758L12.685 1.07572L12.6401 1.21882ZM15.7115 7.8701L15.5689 7.82356L15.5686 7.8243L15.7115 7.8701ZM8.76492 14.9332L8.69378 14.8011L8.69334 14.8013L8.76492 14.9332ZM2.19287 7.58843C2.71935 9.19514 4.01596 10.6345 5.30013 11.744C6.58766 12.8564 7.88057 13.6522 8.42402 13.9683L8.57487 13.709C8.03982 13.3978 6.76432 12.6125 5.49626 11.517C4.22484 10.4185 2.97868 9.02313 2.47795 7.49501L2.19287 7.58843ZM8.57526 13.9681C9.12037 13.6488 10.4214 12.8444 11.7125 11.729C12.9999 10.6167 14.2963 9.17932 14.8063 7.59044L14.5207 7.49875C14.0364 9.00733 12.7919 10.4 11.5164 11.502C10.2446 12.6008 8.9607 13.3947 8.42364 13.7093L8.57526 13.9681ZM14.8061 7.59109C15.1419 6.5613 15.1554 5.39131 14.7711 4.37633C14.3853 3.35729 13.5989 2.49754 12.348 2.10211L12.2576 2.38816C13.4143 2.75381 14.1347 3.54267 14.4905 4.48255C14.8479 5.42648 14.8379 6.52568 14.5209 7.4981L14.8061 7.59109ZM12.3478 2.10206C11.137 1.72085 9.72549 1.95125 8.7458 2.69484L8.92717 2.9338C9.82606 2.25155 11.1357 2.03494 12.2577 2.38821L12.3478 2.10206ZM8.74618 2.69455C8.60221 2.8031 8.40275 2.80462 8.25906 2.69812L8.08043 2.93915C8.33238 3.12587 8.67804 3.12163 8.92678 2.93409L8.74618 2.69455ZM8.25877 2.69791C7.225 1.93554 5.87527 1.71256 4.64496 2.10213L4.73552 2.38814C5.87471 2.02742 7.12452 2.2342 8.08071 2.93936L8.25877 2.69791ZM4.64501 2.10212C3.39586 2.49722 2.61099 3.35688 2.22622 4.37554C1.84299 5.39014 1.85704 6.55957 2.19281 7.58826L2.478 7.49518C2.16095 6.52382 2.15046 5.42513 2.50687 4.48154C2.86175 3.542 3.58071 2.7534 4.73548 2.38815L4.64501 2.10212ZM8.50115 14.85C8.43415 14.85 8.36841 14.8341 8.3088 14.8023L8.16744 15.0669C8.27195 15.1227 8.38645 15.15 8.50115 15.15V14.85ZM8.30897 14.8024C8.19831 14.7431 6.7996 13.9873 5.26616 12.7476C3.72872 11.5046 2.07716 9.79208 1.43266 7.82413L1.14756 7.9175C1.81968 9.96978 3.52747 11.7277 5.07755 12.9809C6.63162 14.2373 8.0486 15.0032 8.16727 15.0668L8.30897 14.8024ZM1.29011 7.72081C1.31557 7.72081 1.34468 7.72745 1.37175 7.74514C1.39802 7.76231 1.41394 7.78437 1.42309 7.8023C1.43191 7.81958 1.43557 7.8351 1.43727 7.84507C1.43817 7.8504 1.43869 7.85518 1.43898 7.85922C1.43913 7.86127 1.43923 7.8632 1.43929 7.865C1.43932 7.86591 1.43934 7.86678 1.43936 7.86763C1.43936 7.86805 1.43937 7.86847 1.43937 7.86888C1.43937 7.86909 1.43937 7.86929 1.43938 7.86949C1.43938 7.86959 1.43938 7.86969 1.43938 7.86979C1.43938 7.86984 1.43938 7.86992 1.43938 7.86994C1.43938 7.87002 1.43938 7.87009 1.28938 7.8701C1.13938 7.8701 1.13938 7.87017 1.13938 7.87025C1.13938 7.87027 1.13938 7.87035 1.13938 7.8704C1.13938 7.8705 1.13938 7.8706 1.13938 7.8707C1.13938 7.8709 1.13938 7.87111 1.13938 7.87131C1.13939 7.87173 1.13939 7.87214 1.1394 7.87257C1.13941 7.87342 1.13943 7.8743 1.13946 7.8752C1.13953 7.87701 1.13962 7.87896 1.13978 7.88103C1.14007 7.88512 1.14059 7.88995 1.14151 7.89535C1.14323 7.90545 1.14694 7.92115 1.15585 7.93861C1.16508 7.95672 1.18114 7.97896 1.20762 7.99626C1.2349 8.01409 1.26428 8.02081 1.29011 8.02081V7.72081ZM1.43197 7.82354C0.623164 5.34647 1.53102 2.26869 4.3994 1.36184L4.30896 1.0758C1.23531 2.04755 0.302663 5.33142 1.14679 7.91665L1.43197 7.82354ZM4.39955 1.36179C5.7527 0.932384 7.22762 1.12136 8.42 1.85949L8.57791 1.60441C7.31141 0.820401 5.74571 0.619858 4.30881 1.07585L4.39955 1.36179ZM8.57801 1.85943C9.73213 1.14371 11.2694 0.945205 12.5951 1.36192L12.685 1.07572C11.2763 0.632908 9.64845 0.842602 8.4199 1.60447L8.57801 1.85943ZM12.5948 1.36184C15.4664 2.27018 16.3769 5.34745 15.5689 7.82356L15.8541 7.91663C16.6975 5.33188 15.7617 2.04893 12.6853 1.07581L12.5948 1.36184ZM15.5686 7.8243C14.9453 9.76841 13.2952 11.4801 11.7526 12.7288C10.2142 13.974 8.80513 14.7411 8.69378 14.8011L8.83606 15.0652C8.9555 15.0009 10.3826 14.2236 11.9413 12.9619C13.4957 11.7037 15.2034 9.94602 15.8543 7.91589L15.5686 7.8243ZM8.69334 14.8013C8.6337 14.8337 8.56752 14.85 8.50115 14.85V15.15C8.61648 15.15 8.73201 15.1217 8.83649 15.065L8.69334 14.8013Z" fill="currentColor"></path>
               <path fill-rule="evenodd" clip-rule="evenodd" d="M12.8384 6.93209C12.5548 6.93209 12.3145 6.71865 12.2911 6.43693C12.2427 5.84618 11.8397 5.34743 11.266 5.1656C10.9766 5.07361 10.8184 4.76962 10.9114 4.48718C11.0059 4.20402 11.3129 4.05023 11.6031 4.13934C12.6017 4.45628 13.3014 5.32371 13.3872 6.34925C13.4113 6.64606 13.1864 6.90622 12.8838 6.92993C12.8684 6.93137 12.8538 6.93209 12.8384 6.93209Z" fill="currentColor"></path>
               <path d="M12.8384 6.93209C12.5548 6.93209 12.3145 6.71865 12.2911 6.43693C12.2427 5.84618 11.8397 5.34743 11.266 5.1656C10.9766 5.07361 10.8184 4.76962 10.9114 4.48718C11.0059 4.20402 11.3129 4.05023 11.6031 4.13934C12.6017 4.45628 13.3014 5.32371 13.3872 6.34925C13.4113 6.64606 13.1864 6.90622 12.8838 6.92993C12.8684 6.93137 12.8538 6.93209 12.8384 6.93209" stroke="currentColor" stroke-width="0.3"></path>
            </svg>
            Added To Wishlist 
         ';
   }else{
      $html =
         '<svg class="sb-cart-wishlist-icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path fill-rule="evenodd" clip-rule="evenodd" d="M1.60355 7.98635C2.83622 11.8048 7.7062 14.8923 9.0004 15.6565C10.299 14.8844 15.2042 11.7628 16.3973 7.98985C17.1806 5.55102 16.4535 2.46177 13.5644 1.53473C12.1647 1.08741 10.532 1.35966 9.40484 2.22804C9.16921 2.40837 8.84214 2.41187 8.60476 2.23329C7.41078 1.33952 5.85105 1.07778 4.42936 1.53473C1.54465 2.4609 0.820172 5.55014 1.60355 7.98635ZM9.00138 17.0711C8.89236 17.0711 8.78421 17.0448 8.68574 16.9914C8.41055 16.8417 1.92808 13.2841 0.348132 8.3872C0.347252 8.3872 0.347252 8.38633 0.347252 8.38633C-0.644504 5.30321 0.459792 1.42874 4.02502 0.284605C5.69904 -0.254635 7.52342 -0.0174044 8.99874 0.909632C10.4283 0.00973263 12.3275 -0.238878 13.9681 0.284605C17.5368 1.43049 18.6446 5.30408 17.6538 8.38633C16.1248 13.2272 9.59485 16.8382 9.3179 16.9896C9.21943 17.0439 9.1104 17.0711 9.00138 17.0711Z" fill="currentColor"></path>
               <path fill-rule="evenodd" clip-rule="evenodd" d="M14.203 6.67473C13.8627 6.67473 13.5743 6.41474 13.5462 6.07159C13.4882 5.35202 13.0046 4.7445 12.3162 4.52302C11.9689 4.41097 11.779 4.04068 11.8906 3.69666C12.0041 3.35175 12.3724 3.16442 12.7206 3.27297C13.919 3.65901 14.7586 4.71561 14.8615 5.96479C14.8905 6.32632 14.6206 6.64322 14.2575 6.6721C14.239 6.67385 14.2214 6.67473 14.203 6.67473Z" fill="currentColor"></path>
         </svg>';
   }

   return $html;
}

function pure_wc_product_wishlist($output, $id, $is_wishlisted){
   if($is_wishlisted){
      $output = sprintf( 
         '<button data-bs-toggle="tooltip" type="button" data-bs-placement="bottom" class="sb-product-action-btn sb-product-added-to-wishlist-btn pure-wc-wishlist-btn button wp-element-button pure-tooltip" data-id="%s" title="Add To Compare">
            <svg class="sb-cart-wishlist-icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path fill-rule="evenodd" clip-rule="evenodd" d="M1.60355 7.98635C2.83622 11.8048 7.7062 14.8923 9.0004 15.6565C10.299 14.8844 15.2042 11.7628 16.3973 7.98985C17.1806 5.55102 16.4535 2.46177 13.5644 1.53473C12.1647 1.08741 10.532 1.35966 9.40484 2.22804C9.16921 2.40837 8.84214 2.41187 8.60476 2.23329C7.41078 1.33952 5.85105 1.07778 4.42936 1.53473C1.54465 2.4609 0.820172 5.55014 1.60355 7.98635ZM9.00138 17.0711C8.89236 17.0711 8.78421 17.0448 8.68574 16.9914C8.41055 16.8417 1.92808 13.2841 0.348132 8.3872C0.347252 8.3872 0.347252 8.38633 0.347252 8.38633C-0.644504 5.30321 0.459792 1.42874 4.02502 0.284605C5.69904 -0.254635 7.52342 -0.0174044 8.99874 0.909632C10.4283 0.00973263 12.3275 -0.238878 13.9681 0.284605C17.5368 1.43049 18.6446 5.30408 17.6538 8.38633C16.1248 13.2272 9.59485 16.8382 9.3179 16.9896C9.21943 17.0439 9.1104 17.0711 9.00138 17.0711Z" fill="currentColor"></path>
               <path fill-rule="evenodd" clip-rule="evenodd" d="M14.203 6.67473C13.8627 6.67473 13.5743 6.41474 13.5462 6.07159C13.4882 5.35202 13.0046 4.7445 12.3162 4.52302C11.9689 4.41097 11.779 4.04068 11.8906 3.69666C12.0041 3.35175 12.3724 3.16442 12.7206 3.27297C13.919 3.65901 14.7586 4.71561 14.8615 5.96479C14.8905 6.32632 14.6206 6.64322 14.2575 6.6721C14.239 6.67385 14.2214 6.67473 14.203 6.67473Z" fill="currentColor"></path>
            </svg>
            <span class="sb-product-tooltip sb-product-tooltip-right">Add To Wishlist</span>
         </button> 
         ',
         esc_attr( $id )
      );
   }else{
      $output = sprintf( 
         '<button data-bs-toggle="tooltip" type="button" data-bs-placement="bottom" class="sb-product-action-btn sb-product-add-to-wishlist-btn pure-wc-wishlist-btn button wp-element-button pure-tooltip" data-id="%s" title="Add To Compare">
            <svg class="sb-cart-wishlist-icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path fill-rule="evenodd" clip-rule="evenodd" d="M1.60355 7.98635C2.83622 11.8048 7.7062 14.8923 9.0004 15.6565C10.299 14.8844 15.2042 11.7628 16.3973 7.98985C17.1806 5.55102 16.4535 2.46177 13.5644 1.53473C12.1647 1.08741 10.532 1.35966 9.40484 2.22804C9.16921 2.40837 8.84214 2.41187 8.60476 2.23329C7.41078 1.33952 5.85105 1.07778 4.42936 1.53473C1.54465 2.4609 0.820172 5.55014 1.60355 7.98635ZM9.00138 17.0711C8.89236 17.0711 8.78421 17.0448 8.68574 16.9914C8.41055 16.8417 1.92808 13.2841 0.348132 8.3872C0.347252 8.3872 0.347252 8.38633 0.347252 8.38633C-0.644504 5.30321 0.459792 1.42874 4.02502 0.284605C5.69904 -0.254635 7.52342 -0.0174044 8.99874 0.909632C10.4283 0.00973263 12.3275 -0.238878 13.9681 0.284605C17.5368 1.43049 18.6446 5.30408 17.6538 8.38633C16.1248 13.2272 9.59485 16.8382 9.3179 16.9896C9.21943 17.0439 9.1104 17.0711 9.00138 17.0711Z" fill="currentColor"></path>
               <path fill-rule="evenodd" clip-rule="evenodd" d="M14.203 6.67473C13.8627 6.67473 13.5743 6.41474 13.5462 6.07159C13.4882 5.35202 13.0046 4.7445 12.3162 4.52302C11.9689 4.41097 11.779 4.04068 11.8906 3.69666C12.0041 3.35175 12.3724 3.16442 12.7206 3.27297C13.919 3.65901 14.7586 4.71561 14.8615 5.96479C14.8905 6.32632 14.6206 6.64322 14.2575 6.6721C14.239 6.67385 14.2214 6.67473 14.203 6.67473Z" fill="currentColor"></path>
            </svg>
            <span class="sb-product-tooltip sb-product-tooltip-right">Add To Wishlist</span>
         </button> 
         ',
         esc_attr( $id )
      );
   }
   return $output;
}

function pure_wc_product_quick_view($output, $attrs){
   $output = sprintf( 
      '<button data-bs-toggle="tooltip" type="button" data-bs-placement="bottom" class="sb-product-action-btn sb-product-quick-view-btn button wp-element-button pure-tooltip %s" data-id="%s" title="Quickview">
         <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.99948 5.06828C7.80247 5.06828 6.82956 6.04044 6.82956 7.23542C6.82956 8.42951 7.80247 9.40077 8.99948 9.40077C10.1965 9.40077 11.1703 8.42951 11.1703 7.23542C11.1703 6.04044 10.1965 5.06828 8.99948 5.06828ZM8.99942 10.7482C7.0581 10.7482 5.47949 9.17221 5.47949 7.23508C5.47949 5.29705 7.0581 3.72021 8.99942 3.72021C10.9407 3.72021 12.5202 5.29705 12.5202 7.23508C12.5202 9.17221 10.9407 10.7482 8.99942 10.7482Z" fill="currentColor"></path>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M1.41273 7.2346C3.08674 10.9265 5.90646 13.1215 8.99978 13.1224C12.0931 13.1215 14.9128 10.9265 16.5868 7.2346C14.9128 3.54363 12.0931 1.34863 8.99978 1.34773C5.90736 1.34863 3.08674 3.54363 1.41273 7.2346ZM9.00164 14.4703H8.99804H8.99714C5.27471 14.4676 1.93209 11.8629 0.0546754 7.50073C-0.0182251 7.33091 -0.0182251 7.13864 0.0546754 6.96883C1.93209 2.60759 5.27561 0.00288103 8.99714 0.000185582C8.99894 -0.000712902 8.99894 -0.000712902 8.99984 0.000185582C9.00164 -0.000712902 9.00164 -0.000712902 9.00254 0.000185582C12.725 0.00288103 16.0676 2.60759 17.945 6.96883C18.0188 7.13864 18.0188 7.33091 17.945 7.50073C16.0685 11.8629 12.725 14.4676 9.00254 14.4703H9.00164Z" fill="currentColor"></path>
         </svg>
         <span class="sb-product-tooltip sb-product-tooltip-right">Quick View</span>
      </button> 
      ',
      esc_attr( $attrs['class'] ),
      esc_attr( $attrs['id'] )
  );

  return $output;
}

function pure_wc_compare_button($output, $attrs){

   $output = sprintf( 
      '<button data-bs-toggle="tooltip" type="button" data-bs-placement="bottom" class="sb-product-action-btn sb-product-add-to-compare-btn button wp-element-button pure-tooltip %1$s" data-id="%2$s" title="Add To Compare">
         <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11.4144 6.16828L14 3.58412L11.4144 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M1.48883 3.58374L14 3.58374" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M4.07446 8.32153L1.48884 10.9057L4.07446 13.4898" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M14 10.9058H1.48883" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
         </svg>
         <span class="sb-product-tooltip sb-product-tooltip-right">Add To Compare</span>
      </button> 
      ',
      esc_attr( $attrs['class'] ),
      esc_attr( $attrs['id'] )
   );
   
  return $output;
}


/** 
 * Functions that depend on shop page
 */
$template_manager = \PureWCShopbuild\Pure_Wc_Template_Manager::get_instance();
$archive_template_id = $template_manager::get_archive_template_id();
if($archive_template_id == 0 || !$template_manager::is_template_active( $archive_template_id ) || !$template_manager::is_templates_exists()){
   return;
}

Pure_Wc_Shopuild_Helper::remove_wc_actions();
// if custom theme
add_filter('pure_wc_quickview_position', '__return_false');
add_filter('pure_wc_compare_position', '__return_false');
add_filter('pure_wc_wishlist_position', '__return_false');
/**
 * Map all the widgets to be registered
 */
add_filter( 'pure_wc_wishlist_btn_html', 'pure_wc_product_wishlist', 10, 3 );
add_filter( 'pure_wc_quickview_btn_html', 'pure_wc_product_quick_view', 10, 2 );
add_filter( 'pure_wc_compare_btn_html', 'pure_wc_compare_button', 10, 2 );
add_filter( 'pure_wc_wishlist_added_html', 'pure_wc_added_wishlist', 10, 2 );


add_filter( 'woocommerce_breadcrumb_defaults', 'pure_wc_sb_breadcrumb_delimiter' );
function pure_wc_sb_breadcrumb_delimiter( $defaults ) {
  $defaults['delimiter'] = ' <span class="delimeter"></span> ';
  return $defaults;
}

function pure_wc_sale_countdown($product){

   $option = pure_wc_sb_get_option('_pure_shopbuild_modules', 'pure_wc_flash_sale_countdown');
   
   if(is_null($product->get_date_on_sale_to()) || !$option ){
      return;
   }
   $_sale_date_end = $product->get_date_on_sale_to()->date("M d Y h:m:i");
   ?>

   <div class="sb-product-countdown">
      <div class="sb-product-countdown-time" data-countdown data-date="<?php echo esc_attr($_sale_date_end); ?>">
         <ul>
            <li><span data-days>491</span>D</li>
            <li><span data-hours>5</span>H</li>
            <li><span data-minutes>46</span>M</li>
            <li><span data-seconds>57</span>S</li>
         </ul>
      </div>
   </div>
<?php
}
add_action('pure_wc_sale_countdown', 'pure_wc_sale_countdown', 10, 1);


// product-content
if( !function_exists('pure_wc_loop_product_thumbnail') ) {
   function pure_wc_loop_product_thumbnail( ) {
      pure_wc_product_style(apply_filters('pure_wc_product_feature_options', array()));
   }
}
add_action( 'woocommerce_before_shop_loop_item', 'pure_wc_loop_product_thumbnail', 10 );


///////////////////////////////////////////////////////////////
 //                 PRODUCT CARD STYLE 
///////////////////////////////////////////////////////////////
function pure_wc_product_style($args){

   if(is_array($args)){
 
      if($args['product_style'] == 2){
         pure_wc_product_style_grid($args);
      }else{
         pure_wc_product_style_default($args);
      }
   }
}

function pure_wc_product_style_grid( $args ){
   return;
}

function pure_wc_product_style_default($args){
   global $product;
   $rating  = wc_get_rating_html($product->get_average_rating());

   $rating_count = $product->get_rating_count();
   $review_count = $product->get_review_count();
   $average      = $product->get_average_rating();

   $is_in_stock = $product->is_in_stock();

   // is product on sale
   $has_sale = $product->is_on_sale() ? ' sb-product-on-sale' : '';

   $terms   = get_the_terms(get_the_ID(), 'product_cat');
   $options = \PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_shopbuild_modules');
   $quickview = \PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_quickview_settings');

   $action_style = $args['action_style'];
   $product_content_align = $args['product_content_align'];
   $review_text_switch = $args['review_text_switch'];

   if($product_content_align == 'left'){
      $price_alignment = 'price-left';
   }elseif($product_content_align == 'right'){
      $price_alignment = 'price-right';
   }elseif($product_content_align == 'center'){
      $price_alignment = 'price-center';
   }else{
      $price_alignment = 'price-left';
   }


   if($args['product_content_align'] == 'left'){
      $rating_align = 'sb-justify-content-start';
   }elseif($args['product_content_align'] == 'right'){
      $rating_align = 'sb-justify-content-end';
   }elseif($args['product_content_align'] == 'center'){
      $rating_align = 'sb-justify-content-center';
   }else{
      $rating_align = 'sb-justify-content-start';
   }

   $action_style_calss = $args['action_style'] == '6' ? 'sb-product-action-style-5' : 'sb-product-action-style-5';
 
   // product action class for style 5
   $product_action_class = 'action-position-'.$args['action_button_position'] .'  ' .  $action_style_calss .' tooltip-position-' . $args['tootltip_position'];

   $flex_column = ($args['action_button_position'] == 'left' || $args['action_button_position'] == 'right') ? 'sb-flex-column' : '';
   $tooltip_hide = ($args['pure_wc_tooltip_switch'] == 'yes') ? '' : 'hide-tooltip';

   $action_style_system_select = array_key_exists('select_type_attribute_position', $args) ? $args['select_type_attribute_position'] : 'default';
   $action_style_system_color = array_key_exists('color_type_attribute_position', $args) ? $args['color_type_attribute_position'] : 'default';
   $action_style_system_image = array_key_exists('image_type_attribute_position', $args) ? $args['image_type_attribute_position'] : 'default';
   $action_style_system_none = array_key_exists('none_type_attribute_position', $args) ? $args['none_type_attribute_position'] : 'default';
   $action_type = array_key_exists('action_type', $args) ? $args['action_type'] : 'on_hover';

   $variation_position_class = 'select-type-position-' . $action_style_system_select . ' color-type-position-' . $action_style_system_color . ' image-type-position-' . $action_style_system_image . ' none-type-position-' . $action_style_system_none . '  action-type-' . $action_type . $has_sale; ;


?>

   
   <div <?php wc_product_class( "sb-product-item $variation_position_class", $product ); ?>>
      <div class="sb-product-thumb">
      <?php if( has_post_thumbnail($product->get_id()) ) : ?>
         <?php echo wp_kses(wp_get_attachment_image( get_post_thumbnail_id( $product->get_id() ), 'full' ), pure_wc_get_kses_extended_ruleset()); ?>
      <?php endif; ?>

      <?php if(!$is_in_stock) : ?>
         <div class="sb-product-out-of-stock-overlay"></div>
         <div class="sb-product-out-of-stock">
            <span class="sb-d-flex sb-align-items-center">
               <svg viewBox="0 0 22 22">
                  <path d="M11,22C4.93,22,0,17.07,0,11S4.93,0,11,0s11,4.93,11,11S17.07,22,11,22z M11,2c-4.96,0-9,4.04-9,9s4.04,9,9,9s9-4.04,9-9
                  S15.96,2,11,2z M15.42,15.91c0.5-0.23,0.72-0.83,0.49-1.33C15.31,13.3,13.44,12,11,12c-2.15,0-4.07,0.99-4.88,2.53
                  c-0.26,0.49-0.07,1.09,0.42,1.35c0.49,0.26,1.09,0.07,1.35-0.42C8.27,14.74,9.38,14,11,14c1.59,0,2.82,0.83,3.09,1.42
                  C14.26,15.79,14.62,16,15,16C15.14,16,15.28,15.97,15.42,15.91z M7,10c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2S8.1,10,7,10z M7,8L7,8
                  L7,8z M15,10c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2S16.1,10,15,10z M15,8L15,8L15,8z" fill="currentColor"></path>
               </svg>
               <?php echo esc_html__('Sold Out', 'shopbuild'); ?>
            </span>
         </div>
      <?php endif; ?>

         <?php if($action_style == '5' || $action_style == '6') : ?>
            <!-- product action -->
            <div class="sb-product-action <?php echo esc_attr($product_action_class); ?>  <?php echo esc_attr($tooltip_hide); ?>">
                  <div class="sb-product-action-item sb-d-flex <?php echo esc_attr($flex_column); ?>">
                     <?php
                        if($quickview['enable'] && class_exists('WooCommerce') && ($args['pure_wc_quick_view_switch'] == 'yes')){
                           echo do_shortcode('[pure_wc_quickview]'); 
                        }
                     ?>

                     <?php 
                        if($options['pure_wc_wishlist'] && class_exists('WooCommerce') && ($args['pure_wc_wishlist_switch'] == 'yes')){
                           echo do_shortcode('[pure_wc_wishlist]'); 
                        }
                     ?>

                     <?php 
                        if($options['pure_wc_compare'] && class_exists('WooCommerce') && ($args['pure_wc_compare_switch'] == 'yes')){
                           echo do_shortcode('[pure_wc_compare]'); 
                        }
                     ?>

                  </div>
            </div>
            <div class="sb-product-action-with-variation">
               <?php do_action('pure_wc_before_tag'); ?>
               <?php pure_wc_sb_woocommerce_add_to_cart(); ?>
            </div>

         <?php else: ?>
            <?php pure_wc_product_action_style($args, $options); ?>
         <?php endif; ?>

         <div class="sb-product-sale-countdown">
            <?php do_action('pure_wc_sale_countdown', $product); ?>
         </div>

         <?php if($is_in_stock) : ?>
         <div class="sb-product-on-sale-wrap badge-position-<?php echo esc_attr($args['sale_badge_position']); ?>">
            <?php do_action('pure_wc_sale_badge'); ?> 
         </div>
         <?php endif; ?>
         
      </div>
      <div class="sb-product-content text-<?php echo esc_attr($product_content_align); ?>">
         <?php 
         
            if(!($action_style == '5') || !($action_style == '6')) {
               if(!($action_style == '6')) {
                  do_action('pure_wc_before_tag');
               }
            }
         
            if($action_style == '6') {
               do_action('pure_wc_before_tag');
            }
           
         ?>
         <div class="sb-product-tag">

            <?php
            if(is_array($terms) && !empty($terms)) :
            foreach ($terms as $key => $term) : 
               $count = count($terms) - 1;

               $name = ($count > $key) ? $term->name . ', ' : $term->name
            ?>
               <a href="<?php echo esc_url(get_term_link($term->slug, 'product_cat')); ?> "> <?php echo esc_html($name); ?></a>

            <?php endforeach; endif; ?>

         </div>
         <?php do_action('pure_wc_before_title'); ?>
         <h3 class="sb-product-title">
            <a href="<?php the_permalink(); ?>"><?php echo wp_kses_post(wp_trim_words(get_the_title($product->get_id()), $args['pure_wc_trim_title_word'], '')); ?></a>
         </h3>
         <?php do_action('pure_wc_before_rating'); ?>
         <?php if( !empty($rating) && ($args['product_rating_switch'] == 'yes')) : ?>
            <div class="sb-product-rating-icon sb-d-flex sb-align-items-center <?php echo esc_attr($rating_align); ?>">
               <?php print wp_kses_post($rating); ?> 
               <?php if($review_text_switch == 'yes') : ?>
               <div class="sb-product-rating-text  sb-d-inline-block">
                  <?php 
                     printf( 
                        esc_html(
                           /* translators: 1: Review 2: Reviews*/
                           _n( 
                              '( %s Review )', 
                              '( %s Reviews )', 
                              esc_html($review_count), 
                              'shopbuild' 
                           )
                        ), 
                        wp_kses_post('<span class="count">' . number_format_i18n( $review_count ) . '</span>') 
                     ); 
                  ?>
               </div>
               <?php endif; ?>
            </div>
         <?php endif; ?>
         <?php do_action('pure_wc_before_price'); ?>
         <div class="sb-product-price-wrapper <?php echo esc_attr($price_alignment); ?>">

            <?php if($action_style == 3) : ?>

               <div class="sb-product-price-inner p-relative">
                  <div class="sb-product-action-price">
                     <?php pure_wc_sb_woocommerce_add_to_cart(); ?>
                  </div>
                  <div class="sb-product-price">
                  <?php woocommerce_template_loop_price(); ?>
                  </div>
               </div>

            <?php elseif($action_style == 4): ?>

               <div class="sb-product-price-style-4">
                  <div class="sb-product-price">
                  <?php woocommerce_template_loop_price(); ?>
                  </div>
                  <div class="sb-product-action-price-4">
                     <?php pure_wc_sb_woocommerce_add_to_cart(); ?>
                  </div>
               </div>


             <?php else:
                  woocommerce_template_loop_price();  
               endif; ?>

         </div>
         <?php do_action('pure_wc_after_price'); ?>
      </div>
   </div>

<?php
}

///////////////////////////////////////////////////////////////
 //                 PRODUCT ACTION STYLE 
///////////////////////////////////////////////////////////////
function pure_wc_product_action_style($action_args, $options){
   if($action_args['action_style'] == 2){
      pure_wc_product_action_style2($action_args, $options);
   }
   elseif($action_args['action_style'] == 3){
      pure_wc_product_action_style3($action_args, $options);
   }
   elseif($action_args['action_style'] == 4){
      pure_wc_product_action_style4($action_args, $options);
   }
   elseif($action_args['action_style'] == 5){
      pure_wc_product_action_style5($action_args, $options);
   }
   else{
      pure_wc_product_action_styledefault($action_args, $options);
   }
}

function pure_wc_product_action_styledefault($action_args, $options){
   extract($action_args);

   $product_action_class = 'action-position-'.$action_button_position .' sb-product-action-style-' . $action_style .' tooltip-position-' . $tootltip_position;

   $flex_column = ($action_button_position == 'left' || $action_button_position == 'right') ? 'sb-flex-column' : '';
   $tooltip_hide = ($pure_wc_tooltip_switch == 'yes') ? '' : 'hide-tooltip';
   $quickview = \PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_quickview_settings');
   ?>

      <!-- product action -->
      <div class="sb-product-action <?php echo esc_attr($product_action_class); ?>  <?php echo esc_attr($tooltip_hide); ?>">
            <div class="sb-product-action-item sb-d-flex <?php echo esc_attr($flex_column); ?>">
               <?php pure_wc_sb_woocommerce_add_to_cart(); ?>

               <?php  
                  if($quickview['enable'] && class_exists('WooCommerce') && ($pure_wc_quick_view_switch == 'yes')){
                     echo wp_kses(do_shortcode('[pure_wc_quickview]'), pure_wc_get_kses_extended_ruleset()); 
                  }
               ?>

               <?php 
                  if($options['pure_wc_wishlist'] && class_exists('WooCommerce') && ($pure_wc_wishlist_switch == 'yes')){
                     echo wp_kses(do_shortcode('[pure_wc_wishlist]'), pure_wc_get_kses_extended_ruleset()); 
                  }
               ?>

               <?php 
                  if($options['pure_wc_compare'] && class_exists('WooCommerce') && ($pure_wc_compare_switch == 'yes')){
                     echo wp_kses(do_shortcode('[pure_wc_compare]'), pure_wc_get_kses_extended_ruleset()); 
                  }
               ?>

            </div>
         </div>

<?php
}


function pure_wc_product_action_style2($action_args, $options){ 
   extract($action_args);

   $product_action_class = 'action-position-'.$action_button_position .' sb-product-action-style-' . $action_style .' tooltip-position-' . $tootltip_position;

   $flex_column = ($action_button_position == 'left' || $action_button_position == 'right') ? 'sb-flex-column' : '';
   $tooltip_hide = ($pure_wc_tooltip_switch == 'yes') ? '' : 'hide-tooltip';
   $quickview = \PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_quickview_settings');
   ?>

      <!-- product action -->
      <div class="sb-product-action <?php echo esc_attr($product_action_class); ?>  <?php echo esc_attr($tooltip_hide); ?>">
            <div class="sb-product-action-item sb-d-flex <?php echo esc_attr($flex_column); ?>">

               <?php  
                  if($quickview['enable'] && class_exists('WooCommerce') && ($pure_wc_quick_view_switch == 'yes')){
                     echo wp_kses(do_shortcode('[pure_wc_quickview]'), pure_wc_get_kses_extended_ruleset()); 
                  }
               ?>

               <?php 
                  if($options['pure_wc_wishlist'] && class_exists('WooCommerce') && ($pure_wc_wishlist_switch == 'yes')){
                     echo wp_kses(do_shortcode('[pure_wc_wishlist]'), pure_wc_get_kses_extended_ruleset()); 
                  }
               ?>

               <?php 
                  if($options['pure_wc_compare'] && class_exists('WooCommerce') && ($pure_wc_compare_switch == 'yes')){
                     echo wp_kses(do_shortcode('[pure_wc_compare]'), pure_wc_get_kses_extended_ruleset()); 
                  }
               ?>

            </div>
      </div>
      <div class="sb-product-action-addToCart-bottom">
         <?php pure_wc_sb_woocommerce_add_to_cart(); ?>
      </div>

<?php
}

function pure_wc_product_action_style3($action_args, $options){ 
   extract($action_args);

   $product_action_class = 'action-position-'.$action_button_position .' sb-product-action-style-' . $action_style .' tooltip-position-' . $tootltip_position;

   $flex_column = ($action_button_position == 'left' || $action_button_position == 'right') ? 'sb-flex-column' : '';
   $tooltip_hide = ($pure_wc_tooltip_switch == 'yes') ? '' : 'hide-tooltip';
   $quickview = \PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_quickview_settings');
   ?>

      <!-- product action -->
      <div class="sb-product-action <?php echo esc_attr($product_action_class); ?>  <?php echo esc_attr($tooltip_hide); ?>">
            <div class="sb-product-action-item sb-d-flex <?php echo esc_attr($flex_column); ?>">

               <?php  
                  if($quickview['enable'] && class_exists('WooCommerce') && ($pure_wc_quick_view_switch == 'yes')){
                     echo wp_kses(do_shortcode('[pure_wc_quickview]'), pure_wc_get_kses_extended_ruleset()); 
                  }
               ?>

               <?php 
                  if($options['pure_wc_wishlist'] && class_exists('WooCommerce') && ($pure_wc_wishlist_switch == 'yes')){
                     echo wp_kses(do_shortcode('[pure_wc_wishlist]'), pure_wc_get_kses_extended_ruleset()); 
                  }
               ?>

               <?php 
                  if($options['pure_wc_compare'] && class_exists('WooCommerce') && ($pure_wc_compare_switch == 'yes')){
                     echo wp_kses(do_shortcode('[pure_wc_compare]'), pure_wc_get_kses_extended_ruleset()); 
                  }
               ?>

            </div>
      </div>
<?php
}

function pure_wc_product_action_style4($action_args, $options){ 
   extract($action_args);

   $product_action_class = 'action-position-'.$action_button_position .' sb-product-action-style-' . $action_style .' tooltip-position-' . $tootltip_position;

   $flex_column = ($action_button_position == 'left' || $action_button_position == 'right') ? 'sb-flex-column' : '';
   $tooltip_hide = ($pure_wc_tooltip_switch == 'yes') ? '' : 'hide-tooltip';
   $quickview = \PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_quickview_settings');
   ?>

      <!-- product action -->
      <div class="sb-product-action <?php echo esc_attr($product_action_class); ?>  <?php echo esc_attr($tooltip_hide); ?>">
            <div class="sb-product-action-item sb-d-flex <?php echo esc_attr($flex_column); ?>">

               <?php  
                  if($quickview['enable'] && class_exists('WooCommerce') && ($pure_wc_quick_view_switch == 'yes')){
                     echo wp_kses(do_shortcode('[pure_wc_quickview]'), pure_wc_get_kses_extended_ruleset()); 
                  }
               ?>

               <?php 
                  if($options['pure_wc_wishlist'] && class_exists('WooCommerce') && ($pure_wc_wishlist_switch == 'yes')){
                     echo wp_kses(do_shortcode('[pure_wc_wishlist]'), pure_wc_get_kses_extended_ruleset()); 
                  }
               ?>

               <?php 
                  if($options['pure_wc_compare'] && class_exists('WooCommerce') && ($pure_wc_compare_switch == 'yes')){
                     echo wp_kses(do_shortcode('[pure_wc_compare]'), pure_wc_get_kses_extended_ruleset()); 
                  }
               ?>

            </div>
      </div>
<?php
}

function pure_wc_product_action_style5($action_args, $options){ 
   extract($action_args);

   $product_action_class = 'action-position-'.$action_button_position .' sb-product-action-style-' . $action_style .' tooltip-position-' . $tootltip_position;

   $flex_column = ($action_button_position == 'left' || $action_button_position == 'right') ? 'sb-flex-column' : '';
   $tooltip_hide = ($pure_wc_tooltip_switch == 'yes') ? '' : 'hide-tooltip';
   
   $quickview = \PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_quickview_settings');
   ?>

      <!-- product action -->
      <div class="sb-product-action <?php echo esc_attr($product_action_class); ?>  <?php echo esc_attr($tooltip_hide); ?>">
            <div class="sb-product-action-item sb-d-flex <?php echo esc_attr($flex_column); ?>">
               <?php  
                  if($quickview['enable'] && class_exists('WooCommerce') && ($pure_wc_quick_view_switch == 'yes')){
                     echo wp_kses(do_shortcode('[pure_wc_quickview]'), pure_wc_get_kses_extended_ruleset()); 
                  }
               ?>

               <?php 
                  if($options['pure_wc_wishlist'] && class_exists('WooCommerce') && ($pure_wc_wishlist_switch == 'yes')){
                     echo wp_kses(do_shortcode('[pure_wc_wishlist]'), pure_wc_get_kses_extended_ruleset()); 
                  }
               ?>

               <?php 
                  if($options['pure_wc_compare'] && class_exists('WooCommerce') && ($pure_wc_compare_switch == 'yes')){
                     echo wp_kses(do_shortcode('[pure_wc_compare]'), pure_wc_get_kses_extended_ruleset()); 
                  }
               ?>

            </div>
      </div>
<?php
}


// get_product_search_form
add_filter( 'get_product_search_form' , 'pure_wc_custom_product_searchform' );
function pure_wc_custom_product_searchform( $form ) {

	$form = '<form role="search" method="get" id="searchform" action="' . esc_url( home_url( '/'  ) ) . '">
		<div>
			<label class="screen-reader-text" for="s">' . __( 'Enter Keyword or Product Number', 'shopbuild' ) . '</label>
			<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __( 'Search...', 'shopbuild' ) . '" />
         <button type="submit" id="searchsubmit" class="sb-sidebar-product-search-btn">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M8.11111 15.2222C12.0385 15.2222 15.2222 12.0385 15.2222 8.11111C15.2222 4.18375 12.0385 1 8.11111 1C4.18375 1 1 4.18375 1 8.11111C1 12.0385 4.18375 15.2222 8.11111 15.2222Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
               <path d="M16.9995 17L13.1328 13.1333" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
         </button>
			<input type="hidden" name="post_type" value="product" />
		</div>
	</form>';

	return $form;
}

// product add to cart button
function pure_wc_sb_woocommerce_add_to_cart( $args = array() ) {
   global $product;

   if ( $product ) {
      $defaults = array(
         'quantity'   => 1,
         'class'      => implode(
               ' ',
               array_filter(
                  array(
                     'cart-button icon-btn button',
                     'product_type_' . $product->get_type(),
                     $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                     $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
                  )
               )
         ),
         'attributes' => array(
               'data-product_id'  => $product->get_id(),
               'data-product_sku' => $product->get_sku(),
               'aria-label'       => $product->add_to_cart_description(),
               'rel'              => 'nofollow',
         ),
      );

      $args = wp_parse_args( $args, $defaults );

      if ( isset( $args['attributes']['aria-label'] ) ) {
         $args['attributes']['aria-label'] = wp_strip_all_tags( $args['attributes']['aria-label'] );
      }
   }


   // check product type 
   if( $product->is_type( 'simple' ) ){
      $btntext = esc_html__("Add to Cart", 'shopbuild');
   } elseif( $product->is_type( 'variable' ) ){
      $btntext = esc_html__("Select Options", 'shopbuild');
   } elseif( $product->is_type( 'external' ) ){
      $btntext = esc_html__("Buy Now", 'shopbuild');
   } elseif( $product->is_type( 'grouped' ) ){
      $btntext = esc_html__("View Products", 'shopbuild');
   }
   else{
      $btntext = esc_html__("Add to Cart", 'shopbuild');
   } 

   $button = sprintf( '<a href="%1$s" data-quantity="%2$s" class="sb-product-action-btn sb-product-add-to-cart-btn %3$s" %4$s>%5$s</a>',
      esc_url( $product->add_to_cart_url() ),
      esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
      esc_attr( isset( $args['class'] ) ? $args['class'] : 'sb-product-action-btn-test' ),
      isset( $args['attributes'] ) ? wp_kses_post(wc_implode_html_attributes( $args['attributes'] )) : '',
      '<svg class="sb-cart-icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" clip-rule="evenodd" d="M3.54431 4.80484L4.08701 11.2487C4.12661 11.7447 4.53251 12.1167 5.02841 12.1167H5.03201H14.8519H14.8537C15.3227 12.1167 15.7232 11.7681 15.7898 11.3053L16.6448 5.41221C16.6646 5.27205 16.6295 5.13189 16.544 5.01868C16.4594 4.90457 16.3352 4.8309 16.1948 4.81113C16.0067 4.81832 8.20092 4.80754 3.54431 4.80484ZM5.02647 13.4642C3.84117 13.4642 2.83766 12.5405 2.74136 11.359L1.91696 1.57098L0.560653 1.33738C0.192551 1.27269 -0.0531497 0.924974 0.00985058 0.557495C0.0746508 0.190017 0.430152 -0.0489788 0.790154 0.00852392L2.66216 0.331977C2.96366 0.384987 3.19316 0.634765 3.21926 0.940248L3.43076 3.45689C16.2792 3.46228 16.3206 3.46857 16.3827 3.47576C16.884 3.54854 17.325 3.80999 17.6256 4.21251C17.9262 4.61413 18.0522 5.1092 17.9802 5.60516L17.1261 11.4974C16.965 12.6187 15.9894 13.4642 14.8554 13.4642H14.8509H5.03367H5.02647Z" fill="currentColor"/>
      <path fill-rule="evenodd" clip-rule="evenodd" d="M13.4079 8.12567H10.9131C10.5396 8.12567 10.2381 7.82379 10.2381 7.45181C10.2381 7.07984 10.5396 6.77795 10.9131 6.77795H13.4079C13.7805 6.77795 14.0829 7.07984 14.0829 7.45181C14.0829 7.82379 13.7805 8.12567 13.4079 8.12567Z" fill="currentColor"/>
      <path fill-rule="evenodd" clip-rule="evenodd" d="M4.63943 15.9048C4.91033 15.9048 5.12903 16.1235 5.12903 16.3944C5.12903 16.6653 4.91033 16.8849 4.63943 16.8849C4.36763 16.8849 4.14893 16.6653 4.14893 16.3944C4.14893 16.1235 4.36763 15.9048 4.63943 15.9048Z" fill="currentColor"/>
      <path fill-rule="evenodd" clip-rule="evenodd" d="M4.63859 16.2097C4.53689 16.2097 4.45409 16.2925 4.45409 16.3942C4.45409 16.5985 4.82399 16.5985 4.82399 16.3942C4.82399 16.2925 4.74029 16.2097 4.63859 16.2097ZM4.6386 17.5569C3.996 17.5569 3.474 17.0349 3.474 16.3933C3.474 15.7518 3.996 15.2307 4.6386 15.2307C5.28121 15.2307 5.80411 15.7518 5.80411 16.3933C5.80411 17.0349 5.28121 17.5569 4.6386 17.5569Z" fill="currentColor"/>
      <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7918 15.9048C15.0627 15.9048 15.2823 16.1235 15.2823 16.3944C15.2823 16.6653 15.0627 16.8849 14.7918 16.8849C14.52 16.8849 14.3013 16.6653 14.3013 16.3944C14.3013 16.1235 14.52 15.9048 14.7918 15.9048Z" fill="currentColor"/>
      <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7906 16.2098C14.6898 16.2098 14.607 16.2926 14.607 16.3943C14.6079 16.6004 14.9769 16.5986 14.976 16.3943C14.976 16.2926 14.8923 16.2098 14.7906 16.2098ZM14.7909 17.5569C14.1483 17.5569 13.6263 17.0349 13.6263 16.3933C13.6263 15.7518 14.1483 15.2307 14.7909 15.2307C15.4344 15.2307 15.9573 15.7518 15.9573 16.3933C15.9573 17.0349 15.4344 17.5569 14.7909 17.5569Z" fill="currentColor"/>
      </svg>
      <i class="sb-cart-loading icon_loading"></i>
      <svg class="sb-cart-added" width="14" height="12" viewBox="0 0 24 18" fill="none" xmlns="http://www.w3.org/2000/svg">
         <path fill="currentColor" d="M7.74919 17.6625C7.06793 17.6628 6.41457 17.392 5.93325 16.9099L0.443061 11.4217C-0.147687 10.8308 -0.147687 9.8729 0.443061 9.28196C1.034 8.69121 1.99191 8.69121 2.58284 9.28196L7.74919 14.4483L21.4172 0.780341C22.0081 0.189593 22.966 0.189593 23.5569 0.780341C24.1477 1.37128 24.1477 2.32919 23.5569 2.92012L9.56513 16.9099C9.08381 17.392 8.43045 17.6628 7.74919 17.6625Z"/>
      </svg>
      <span class="sb-product-tooltip sb-product-tooltip-right">'.esc_html($btntext).'</span>'.esc_html($btntext).''
   );

   echo wp_kses($button, pure_wc_get_kses_extended_ruleset());
}

/**
 * Product Thumbnails Gallery
 */

add_action('woocommerce_product_thumbnails', 'pure_wc_product_thumbnails_gallery');

function  pure_wc_product_thumbnails_gallery(){
   if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
      return;
   }
   
   global $product;
   
   $attachment_ids = $product->get_gallery_image_ids();
   
   if ( $attachment_ids && $product->get_image_id() ) {
      foreach ( $attachment_ids as $attachment_id ) {
         print wp_kses(apply_filters( 'woocommerce_single_product_image_thumbnail_html', wc_get_gallery_image_html( $attachment_id ), $attachment_id ), pure_wc_get_kses_extended_ruleset()); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
      }
   }
}