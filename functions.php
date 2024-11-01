<?php
/**
 * 
 * This file is for developer for extending the plugin features
 */

use PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin;

/**
 * Map all the widgets to be registered
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly      

function pure_wc_elementor_addons_set_widgets(){
    $arr = array(
        'currency-switcher' => array(
            'title'     => __('Currency Switcher', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'shop'
        ),
        'pure-comparison' => array(
            'title'     => __('Comparison Slider', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'home'
        ),
        'pure-icon-box' => array(
            'title'     => __('Icon Box', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'home'
        ),
        'pure-funfact' => array(
            'title'     => __('Fun Fact', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'home'
        ),
        'pure-best-deals' => array(
            'title'     => __('Best Deals', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'offer'
        ),
        'pure-coupon' => array(
            'title'     => __('Coupon', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'cart'
        ),
        'pure-instagram' => array(
            'title'     => __('Instagram', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'home'
        ),
        'pure-brand' => array(
            'title'     => __('Brand', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'home'
        ),
        'pure-category' => array(
            'title'     => __('Category', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'home'
        ),
        'pure-hero-slider' => array(
            'title'     => __('Hero Slider', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'banner'
        ),
        'pure-banner' => array(
            'title'     => __('Banner', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'banner'
        ),
        'pure-testimonial' => array(
            'title'     => __('Testimonial', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'home'
        ),
        'pure-accordion' => array(
            'title'     => __('Accordion', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'home'
        ),
        'shop-features' => array(
            'title'     => __('Shop Features', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'home'
        ),
        'product-hotspot' => array(
            'title'     => __('Product Hotspot', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'offer'
        ),
        'product-card' => array(
            'title'     => __('Product Card', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'shop'
        ),
        'product-slider' => array(
            'title'     => __('Product Slider', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'home'
        ),
        'product-tab' => array(
            'title'     => __('Product Tab', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'home'
        ),
        'archive-products-grid' => array(
            'title'     => __('Archive Products Grid', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'shop'
        ),
        'archive-products-counts' => array(
            'title'     => __('Archive Products Counts', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'shop'
        ),
        'archive-products-ordering' => array(
            'title'     => __('Archive Products Ordering', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'shop'
        ),
        'sidebar-products-search' => array(
            'title'     => __('Sidebar Products Search', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'shop'
        ),
        'sidebar-products-price-filter' => array(
            'title'     => __('Sidebar Products Price Filter', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'shop'
        ),
        'sidebar-products-categories' => array(
            'title'     => __('Sidebar Products Categories', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'shop'
        ),
        'sidebar-attribute-filter' => array(
            'title'     => __('Sidebar Attribute Filter', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'shop'
        ),
        'sidebar-products-tags' => array(
            'title'     => __('Sidebar Products Tags', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'shop'
        ),
        'sidebar-top-rated' => array(
            'title'     => __('Sidebar Top Rated', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'shop'
        ),
        'sidebar-products-recent' => array(
            'title'     => __('Sidebar Products Recent', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'shop'
        ),
        'sidebar-ajax-categories' => array(
            'title'     => __('Sidebar Ajax Categories', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'shop'
        ),
        'sidebar-ajax-attributes' => array(
            'title'     => __('Sidebar Ajax Attributes', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'shop'
        ),
        'sidebar-ajax-stock' => array(
            'title'     => __('Sidebar Ajax Stock', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'shop'
        ),
        'sidebar-ajax-ratings' => array(
            'title'     => __('Sidebar Ajax Ratings', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'shop'
        ),
        'ajax-search' => array(
            'title'     => __('Shopbuild Ajax Search', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'shop'
        ),
        'archive-horizontal-filters' => array(
            'title'     => __('Horizontal Filters', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'shop'
        ),
        'single-product-title' => array(
            'title'     => __('Single Product Title', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'single'
        ),
        'single-product-price' => array(
            'title'     => __('Single Product Price', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'single'
        ),
        'single-product-add-to-cart' => array(
            'title'     => __('Single Add To Cart', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'single'
        ),
        'single-product-thumbnail' => array(
            'title'     => __('Single Product Thumbnail', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'single'
        ),
        'single-product-short-description' => array(
            'title'     => __('Single Product Short Description', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'single'
        ),
        'single-product-sku' => array(
            'title'     => __('Single Product SKU', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'single'
        ),
        'single-product-category' => array(
            'title'     => __('Single Product Category', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'single'
        ),
        'single-product-tags' => array(
            'title'     => __('Single Product Tags', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'single'
        ),
        'single-product-buy-now' => array(
            'title'     => __('Single Product Buy Now', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'single'
        ),
        'single-product-compare' => array(
            'title'     => __('Single Product Compare', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'single'
        ),
        'single-product-wishlist' => array(
            'title'     => __('Single Product Wishlist', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'single'
        ),
        'single-product-ratings' => array(
            'title'     => __('Single Product Ratings', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'single'
        ),
        'single-product-related' => array(
            'title'     => __('Single Product Related', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'single'
        ),
        'single-product-reviews' => array(
            'title'     => __('Single Product Reviews', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'single'
        ),
        'single-product-tabs' => array(
            'title'     => __('Single Product Tabs', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'single'
        ),
        'single-product-breadcrumb' => array(
            'title'     => __('Single Product Breadcrumb', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'single'
        ),
        'single-product-stock' => array(
            'title'     => __('Single Product Stock', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'single'
        ),
        'single-product-social' => array(
            'title'     => __('Single Product Social', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'single'
        ),
        'single-product-review-form' => array(
            'title'     => __('Single Product Review Form', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'single'
        ),
        'single-product-review-overview' => array(
            'title'     => __('Single Product Review Overview', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'single'
        ),
        'single-product-saletimer' => array(
            'title'     => __('Single Product Saletimer', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'single'
        ),
        'cart-table' => array(
            'title'     => __('Cart Table', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'cart'
        ),
        'cart-subtotal' => array(
            'title'     => __('Cart Subtotal', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'cart'
        ),
        'cart-coupon' => array(
            'title'     => __('Cart Coupon', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'cart'
        ),
        'cart-cross-sell' => array(
            'title'     => __('Cart Cross Sell', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'cart'
        ),
        'checkout-shipping' => array(
            'title'     => __('Checkout Shipping', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'checkout'
        ),
        'checkout-billing' => array(
            'title'     => __('Checkout Billing', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'checkout'
        ),
        'checkout-additional' => array(
            'title'     => __('Checkout Additional', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'checkout'
        ),
        'checkout-order' => array(
            'title'     => __('Checkout Order', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'checkout'
        ),
        'checkout-payment' => array(
            'title'     => __('Checkout Payment', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'checkout'
        ),
        'checkout-coupon' => array(
            'title'     => __('Checkout Coupon', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'checkout'
        ),
        'checkout-existing-login' => array(
            'title'     => __('Checkout Existing Login', 'shopbuild'),
            'icon'      => 'eicon-button',
            'preview'   => 'https://preview',
            'is_pro'    => false,
            'is_active' => true,
            'category'  => 'checkout'
        ),
        'order-thankyou-message' => array(
            'title'     => __('Order ThankYou Message', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'thankyou'
        ),
        'order-overview' => array(
            'title'     => __('Order Overview', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'thankyou'
        ),
        'order-number' => array(
            'title'     => __('Order Number', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'thankyou'
        ),
        'order-meta' => array(
            'title'     => __('Order Meta', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'thankyou'
        ),
        'order-details' => array(
            'title'     => __('Order Details', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'thankyou'
        ),
        'order-customer-details' => array(
            'title'     => __('Order Customer Details', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'thankyou'
        ),
        'order-shipping-progress' => array(
            'title'     => __('Order Shipping Progress', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'thankyou'
        ),
        'order-recommendation' => array(
            'title'     => __('Order Recommendation', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'thankyou'
        ),
        'my-account-content' => array(
            'title'     => __('My Account Content', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'myaccount'
        ),
        'logout-btn' => array(
            'title'     => __('Logout Button', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'myaccount'
        ),
        'my-account-content-box' => array(
            'title'     => __('My Account Content Box', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'myaccount'
        ),
        'my-account-user' => array(
            'title'     => __('My Account User', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'myaccount'
        ),
        'my-account-navigation' => array(
            'title'     => __('My Account Navigation', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'myaccount'
        ),
        'my-account-login' => array(
            'title'     => __('My Account Login', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'myaccount'
        ),
        'my-account-register' => array(
            'title'     => __('My Account Register', 'shopbuild'),
            'icon'      => 'storebuild-pro-promotion eicon-button',
            'action_url'=> 'https://themepure.net/plugins/storebuild/pricing/',
            'preview'   => 'https://preview',
            'is_pro'    => true,
            'is_active' => false,
            'category'  => 'myaccount'
        )
    );

    return $arr;
}


// Function to filter widgets that are pro
function pure_wc_elementor_addons_get_pro_widgets( $widgets ) {
    return array_filter($widgets, function($widget) {
        return $widget['is_pro'] === true;
    });
}

/**
 * Addons For Admin and React Settings
 */
function pure_wc_elementor_addons(){
    $default_addons = apply_filters('pure_wc_elementor_addons_widgets_map', pure_wc_elementor_addons_set_widgets());
    $new_addons = array();
    foreach( $default_addons as $key => $item ){
        $_key = trim(strtolower(str_replace('-',  '_', $key)));
        $new_addons[$_key] = $item;
    }

    if(!empty(get_option('_pure_shopbuild_elements'))){
        $db_values  = get_option('_pure_shopbuild_elements');
        // echo '<pre>';
        // var_dump($db_values);
        $new_addons = wp_parse_args($new_addons, $db_values);
        // update_option('_pure_shopbuild_elements', $new_addons);
    }

   

    if(!isset($GLOBALS['pure_wc_elementor_addons'])){
        $GLOBALS['pure_wc_elementor_addons'] = $new_addons;
    }

    return $GLOBALS['pure_wc_elementor_addons'];
}

/**
* Woocommerce Product last product id return
*/
function pure_wc_get_last_product_id(){

    $last_product_id = wp_cache_get( 'pure_wc_last_product_id' );
    if( false == $last_product_id ){
        // Getting last Product ID (max value)
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 1,
            'orderby'        => 'ID',
            'order'          => 'DESC',
            'post_status'    => 'publish'
        );

        $products_query = new WP_Query($args);
        if ($products_query->have_posts()) {
            $last_product_id = $products_query->posts[0]->ID;
            wp_cache_set('pure_wc_last_product_id', $last_product_id);
        }
        wp_reset_postdata();
    }
    return $last_product_id;
}

/*
 * HTML Tag Validation
 * return strig
 */
function pure_wc_validate_html_tag( $tag ) {
    $allowed_html_tags = [
        'article',
        'aside',
        'footer',
        'header',
        'section',
        'nav',
        'main',
        'div',
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
        'p',
        'span',
    ];
    return in_array( strtolower( $tag ), $allowed_html_tags ) ? $tag : 'div';
}

/**
 * Get all post caegories
 */
function pure_wc_get_categories($taxonomy)
{
    $terms = get_terms(array(
        'taxonomy' => $taxonomy,
        'hide_empty' => true,
    ));
    $options = array();
    if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            $options[$term->slug] = $term->name;
        }
    }
    return $options;
}

/**
 * Get all post types
 */
function pure_wc_get_all_types_post($post_type)
{

    $posts_args = get_posts(array(
        'post_type' => $post_type,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish',
        'posts_per_page' => 20,
    ));

    $posts = array();

    if (!empty($posts_args) && !is_wp_error($posts_args)) {
        foreach ($posts_args as $post) {
            $posts[$post->ID] = $post->post_title;
        }
    }

    return $posts;
}

/**
 * Post Orderby Options
 */
function pure_wc_get_orderby_options()
{
    $orderby = array(
        'ID' => 'Post ID',
        'author' => 'Post Author',
        'title' => 'Title',
        'date' => 'Date',
        'modified' => 'Last Modified Date',
        'parent' => 'Parent Id',
        'rand' => 'Random',
        'comment_count' => 'Comment Count',
        'menu_order' => 'Menu Order',
    );
    return $orderby;
}

/**
 * get woocommerce template
 */
function pure_wc_get_template( $name, $args = array() ){
    extract($args);
    if( file_exists( PURE_WC_SHOPBUILD_PATH . 'public/woocommerce/' . $name ) ){
        include(PURE_WC_SHOPBUILD_PATH . 'public/woocommerce/' . $name);
    }
}

/**
 * Custom Filter
 */

function pure_wc_shopbuild_products_shortcode_atts( $args ){
    $woocoomerce_settings  = Pure_Wc_Shopuild_Admin::get_option('_pure_shopbuild_woocommerce');
    $limit = $woocoomerce_settings? $woocoomerce_settings['pure_wc_products_limits'] : 12;

    $defaults = array(
        'limit'          => apply_filters('pure_wc_products_per_page', $limit),
        'columns'        => 3,
        'rows'           => '',        // Number of rows. If defined, limit will be ignored.
        'orderby'        => '',        // menu_order, title, date, rand, price, popularity, rating, or id.
        'order'          => '',        // ASC or DESC.
        'ids'            => '',        // Comma separated IDs. (post ids)
        'skus'           => '',        // Comma separated SKUs.
        'category'       => '',        // Comma separated category slugs or ids.
        'cat_operator'   => 'IN',      // Operator to compare categories. Possible values are 'IN', 'NOT IN', 'AND'.
        'attribute'      => '',        // Single attribute slug. (Ex. Colors, Sizes etc)
        'terms'          => '',        // Comma separated term slugs or ids.
        'terms_operator' => 'IN',      // Operator to compare terms. Possible values are 'IN', 'NOT IN', 'AND'.
        'tag'            => '',        // Comma separated tag slugs.
        'tag_operator'   => 'IN',
        'class'          => '',        // HTML class.
        'paginate'       => true,     	// Should results be paginated.
        'cache'          => false,
        'excludes'       => array(),    //  product not in
    );

    $parse = wp_parse_args( $args, $defaults ); 

    return $parse;
}
add_filter('pure_wc_shopbuild_products_args', 'pure_wc_shopbuild_products_shortcode_atts');

/**
 * Prouct Per Page Filter
 */
function pure_wc_products_per_page( $limit ){
    return $limit;
}
add_filter('pure_wc_products_per_page', 'pure_wc_products_per_page');


/**
 * Check elementor is on edit mode
 */
function pure_wc_is_elementor_edit(){
    if( did_action( 'elementor/loaded' ) ){
        if( \Elementor\Plugin::instance()->editor->is_edit_mode() ){
            return true;
        }
    }

    return false;
}


/**
 * Custom KSES
 */
function pure_wc_get_kses_extended_ruleset() {
    $kses_defaults = wp_kses_allowed_html( 'post' );

    $allowed_tags = array(
        'a'                         => array(
           'class'   => true,
           'href'    => true,
           'rel'     => true,
           'title'   => true,
           'target'  => true,
           'data-product_id'    => true,
           'data-product_sku'   => true,
           'data-coupon'        => true,
           'data-filter'    => true,
           'data-value'     => true,
           'data-quanity'   => true,
        ),      
        'abbr'                      => array(
           'title' => true,
        ),
        'b'                         => true,
        'blockquote'                => array(
           'cite' => true,
        ),
        'cite'                      => array(
           'title' => true,
        ),
        'code'                      => true,
        'del'                    => array(
           'datetime'   => true,
           'title'      => true,
        ),
        'dd'                     => true,
        'div'                    => array(
           'class'   => true,
           'title'   => true,
           'style'   => true,
           'id'      => true,
           'data-thumb' => true,
           'data-alt'   => true,
           'data-id' => true,
           'data-element_type' => true,
           'data-widget_type' => true,
           'data-model-cid' => true,
           'data-product_variations'   => true,
           'data-product_id'   => true,
           'data-attributes'    => true,
           'area-label'         => true,
           'data-settings'      => true,
           'dir'              => true,
           'data-*'           => true,
        ),
        'dl'                     => true,
        'dt'                     => true,
        'em'                     => true,
        'h1'                     => array(
          'class'   => true,
          'id'      => true,
          'style'   => true,
          'title'   => true,
          'data-*'  => true,
        ),
        'h2'                     => array(
          'class'   => true,
          'id'      => true,
          'style'   => true,
          'title'   => true,
          'data-*'  => true,
        ),
        'h3'                     => array(
          'class'   => true,
          'id'      => true,
          'style'   => true,
          'title'   => true,
          'data-*'  => true,
        ),
        'h4'                     => array(
          'class'   => true,
          'id'      => true,
          'style'   => true,
          'title'   => true,
          'data-*'  => true,
        ),
        'h5'                     => array(
          'class'   => true,
          'id'      => true,
          'style'   => true,
          'title'   => true,
          'data-*'  => true,
        ),
        'h6'                     => array(
          'class'   => true,
          'id'      => true,
          'style'   => true,
          'title'   => true,
          'data-*'  => true,
        ),
        'i'                      => array(
           'class'   => true,
          'id'      => true,
          'style'   => true,
          'title'   => true,
          'data-*'  => true,
        ),
        'img'                    => array(
           'alt'        => true,
           'class'      => true,
           'height'     => true,
           'src'        => true,
           'width'      => true,
           'fetchpriority' => true,
           'decoding' => true,
           'title'  => true,
           'data-large_image' => true,
           'data-large_image_width' => true,
           'data-large_image_height'    => true,
           'srcset' => true,
           'sizes'  => true,
           'data-src'   => true
        ),
        'li'                     => array(
           'class' => true,
           'data-filter' => true,
           'data-value'  => true,
        ),
        'ol'                     => array(
           'class' => true,
        ),
        'p'                         => array(
           'class' => true,
        ),
        'q'                         => array(
           'cite'    => true,
           'title'   => true,
        ),
        'span'                      => array(
           'class'   => true,
           'title'   => true,
           'style'   => true,
           'data-attributes'    => true,
           'area-label'         => true,
           'data-width'         => true,
           'data-bg-color'      => true,
           'data-*'            => true,
        ),
        'iframe'                 => array(
           'width'         => true,
           'height'     => true,
           'scrolling'     => true,
           'frameborder'   => true,
           'allow'         => true,
           'src'        => true,
        ),
        'strike'                 => true,
        'br'                     => true,
        'strong'                 => true,
        'data-wow-duration'            => true,
        'data-wow-delay'            => true,
        'data-wallpaper-options'       => true,
        'data-stellar-background-ratio'   => true,
        'ul'                     => array(
           'class' => true,
        ),
        'svg' => array(
             'class' => true,
             'aria-hidden' => true,
             'aria-labelledby' => true,
             'role' => true,
             'xmlns' => true,
             'width' => true,
             'height' => true,
             'fill' => true,
             'viewbox' => true, // <= Must be lower case!
         ),
        'g'     => array( 'fill' => true ),
        'title' => array( 'title' => true ),
        'path'  => array( 
            'd' => true, 
            'fill' => true, 
            'stroke' => true,
            'stroke-width' => true,
            'stroke-linecap' => true,
            'stroke-linejoin' => true,
            'stroke-dasharray' => true,
            'stroke-dashoffset' => true,
            'opacity' => true,
        ),
        'input' => array(
            'type'  =>  true,
            'id'    =>  true,
            'class' =>  true,
            'name'  =>  true,
            'min'   =>  true,
            'max'   =>  true,
            'value' =>  true,
            'step'  =>  true,
            'autocomplete'  =>  true,
            'inputmode'  =>  true,
            'placeholder'  =>  true,
            'title'  =>  true,
            'size'      =>  true,
            'checked'   => true
        ),
        'label' => array(
            'class' => true,
            'for'   => true
        ),
        'form' => array(
            'class' => true,
            'id'    => true,
            'action' => true,
            'method' => true,
            'data-*' => true,
        ),
        'select'   => array(
            'class' => true,
            'id'    => true,
            'name'  => true,
            'size'  => true,
            'multiple' => true,
            'data-label' => true,
            'data-placeholder' => true,
            'tabindex' => true,
            'area-hidden' => true,
            'autocomplete' => true,
        ),
        'option'   => array(
            'value' => true,
            'selected' => true,
            'disabled' => true,
        ),
        'style' => array(
            'type' => true,
            'media' => true,
            'scoped' => true,
            'title' => true,
            'nonce' => true,
        ),
        'script' => array(
            'type' => true,
            'src' => true,
            'async' => true,
            'defer' => true,
            'crossorigin' => true,
            'integrity' => true,
            'nonce' => true,
        ),
        'noscript' => true,
    );
    return array_merge( $kses_defaults, $allowed_tags );
}

/*
 * Products not found content.
 */
function pure_wc_shopbuild_no_contents(){
    return '<div class="products-not-found"><p class="woocommerce-info">' . esc_html__( 'No products were found matching your selection.','shopbuild' ) . '</p></div>';
}

/**
 * WP kses allowed tags
 */
function pure_wc_shopbuild_kses($raw){

    $allowed_tags = array(
       'a'                         => array(
          'class'   => true,
          'href'    => true,
          'rel'  => true,
          'title'   => true,
          'target' => true,
       ),      
       'abbr'                      => array(
          'title' => true,
       ),
       'b'                         => true,
       'blockquote'                => array(
          'cite' => true,
       ),
       'cite'                      => array(
          'title' => true,
       ),
       'code'                      => true,
       'del'                    => array(
          'datetime'   => true,
          'title'      => true,
       ),
       'dd'                     => true,
       'div'                    => array(
          'class'   => true,
          'title'   => true,
          'style'   => true,
       ),
       'dl'                     => true,
       'dt'                     => true,
       'em'                     => true,
       'h1'                     => array(
         'class'   => true,
       ),
       'h2'                     => array(
         'class'   => true,
       ),
       'h3'                     => array(
         'class'   => true,
       ),
       'h4'                     => array(
         'class'   => true,
       ),
       'h5'                     => array(
         'class'   => true,
       ),
       'h6'                     => array(
         'class'   => true,
       ),
       'i'                         => array(
          'class' => true,
       ),
       'img'                    => array(
          'alt'  => true,
          'class'   => true,
          'height' => true,
          'src'  => true,
          'width'   => true,
       ),
       'li'                     => array(
          'class' => true,
       ),
       'ol'                     => array(
          'class' => true,
       ),
       'p'                         => array(
          'class' => true,
       ),
       'q'                         => array(
          'cite'    => true,
          'title'   => true,
       ),
       'span'                      => array(
          'class'   => true,
          'title'   => true,
          'style'   => true,
       ),
       'iframe'                 => array(
          'width'         => true,
          'height'     => true,
          'scrolling'     => true,
          'frameborder'   => true,
          'allow'         => true,
          'src'        => true,
       ),
       'strike'                 => true,
       'br'                     => true,
       'strong'                 => true,
       'data-wow-duration'            => true,
       'data-wow-delay'            => true,
       'data-wallpaper-options'       => true,
       'data-stellar-background-ratio'   => true,
       'data-filter' => true,
       'data-value' => true,
       'ul'                     => array(
          'class' => true,
       ),
       'svg' => array(
            'class' => true,
            'aria-hidden' => true,
            'aria-labelledby' => true,
            'role' => true,
            'xmlns' => true,
            'width' => true,
            'height' => true,
            'fill' => true,
            'viewbox' => true, // <= Must be lower case!
        ),
        'g'     => array( 'fill' => true ),
        'title' => array( 'title' => true ),
        'path'  => array( 
            'd' => true, 
            'fill' => true, 
            'stroke' => true,
            'stroke-width' => true,
            'stroke-linecap' => true,
            'stroke-linejoin' => true
        ),
        'input' => array(
            'type'  =>  true,
            'id'    =>  true,
            'class' =>  true,
            'name'  =>  true,
            'min'   =>  true,
            'max'   =>  true,
            'value' =>  true,
            'step'  =>  true,
            'autocomplete'  =>  true,
            'inputmode'  =>  true,
            'placeholder'  =>  true,
            'title'  =>  true,
            'size'  =>  true,
            'data-filter' => true,
            'data-value' => true,
        ),
        'label' => array(
            'class' => true,
            'for'   => true
        )
    );
 
    if (function_exists('wp_kses')) { // WP is here
       $allowed = wp_kses($raw, $allowed_tags);
    } else {
       $allowed = $raw;
    }
    
    return $allowed;
}

/**
 * Custom render
 */
function pure_wc_shopbuild_render( $render_data ){
    return $render_data;
}

function pure_wc_product_feature_options( $args ){

    $defaults = array(
        "product_style" => '1',
        "pure_wc_trim_title_word" => '6',
        "product_content_align" => 'default',
        "product_rating_switch" => 'yes',
        "review_text_switch" => 'yes',
        "action_style" => 'default',
        "tootltip_position" => 'right',
        "action_button_position" => 'left',
        "sale_badge_position" => 'default_positon',
        "pure_wc_tooltip_switch" => 'yes',
        "pure_wc_quick_view_switch" => 'yes',
        "pure_wc_wishlist_switch" => 'yes',
        "pure_wc_compare_switch" => 'yes',
        "select_type_attribute_position" => 'on_thumbnail',
        "color_type_attribute_position" => 'on_thumbnail',
        "image_type_attribute_position" => 'on_thumbnail',
        "none_type_attribute_position" => 'on_thumbnail',
        "action_type" => 'on_hover',
        'pure_slider_arrow' => 'no',
        'pure_slider_arrow_prev_icon' => 'prev',
        'pure_slider_arrow_next_icon' => 'next',
        'pure_slider_dots' => 'no',
        'pure_slider_autoplay' => 'no',
        'pure_slider_autoplay_speed' => 5000,
        'pure_slider_speed' => 500,
        'pure_slider_infinite' => 'yes',
        'pure_slider_pause_on_hover' => 'yes',
        'pure_slider_slides_to_show' => 4,
        'pure_slider_slides_to_scroll' => 4,
        'pure_slider_center_mode' => 'no',
        'pure_slider_center_padding' => 50,
        'pure_slider_gap' => 15,
        'pure_slider_rtl' => 'no',
        'pure_slider_fade' => 'no',
    );

    $parse = wp_parse_args( $args, $defaults ); 

    return $parse;
}
add_filter('pure_wc_product_feature_options', 'pure_wc_product_feature_options');

/**
 * Changing the default nonce lifetime
 */
add_filter( 'nonce_life', function () { return 4 * HOUR_IN_SECONDS; } );

/**
 * Get Min Max Prices
 */
function pure_wc_shopbuild_minmax_price_limit() {
    $meta_key = '_price';
    $min_price_cache = wp_cache_get( 'pure_wc_min_' . $meta_key, 'cache' );
    $max_price_cache = wp_cache_get( 'pure_wc_max_' . $meta_key, 'cache' );

    if( false === $min_price_cache ){
        $args = array(
            'post_type'      => 'product', // Assuming your post type is 'product', adjust if needed
            'posts_per_page' => -1, // Retrieve all posts
            'meta_key'       => '_price',
            'orderby'        => 'meta_value_num',
            'order'          => 'ASC',
        );
        
        $posts = get_posts($args);
        $value_min = !empty($posts)? get_post_meta($posts[0]->ID, '_price', true) : 0;

        if ( $value_min ) {
            wp_cache_set( 'pure_wc_min_' . $meta_key, $value_min, 'cache', HOUR_IN_SECONDS );
        }
    }
    if( false === $max_price_cache ){
        $args = array(
            'post_type'      => 'product', // Assuming your post type is 'product', adjust if needed
            'posts_per_page' => -1, // Retrieve all posts
            'meta_key'       => '_price',
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC',
        );
        
        $posts = get_posts($args);
        $value_max = !empty($posts)? get_post_meta($posts[0]->ID, '_price', true) : 99;
        if( $value_min ){
            wp_cache_set( 'pure_wc_max_' . $meta_key, $value_max, 'cache', HOUR_IN_SECONDS );
        }
    }
    return [
        'min' => (int)$value_min,
        'max' => (int)$value_max,
    ];
}


/**
 * Check if Elementor version is less than 2.6.0
 */
if( !function_exists('pure_wc_is_elementor_version')){
    function pure_wc_is_elementor_version($operator = '<', $version = '2.6.0')
    {
        return defined('ELEMENTOR_VERSION') && version_compare(ELEMENTOR_VERSION, $version, $operator);
    }
}

/**
 * Get previous orders id exclude current order id
 */
function pure_wc_get_previous_order_ids($order_id){
    $last_order_ids = wp_cache_get('pure_wc_last_orders_id');
    if (false === $last_order_ids) {
        // Get order item IDs for the current order
        $order = wc_get_order($order_id);
        $order_items = !empty($order)? $order->get_items() : array();
        $order_item_ids = array();
        foreach ($order_items as $order_item) {
            $order_item_ids[] = $order_item->get_id();
        }

        // Query to retrieve distinct order IDs excluding the current order
        $args = array(
            'post_type'      => 'shop_order',
            'post_status'    => 'wc-completed',
            'posts_per_page' => 3,
            'order'          => 'DESC',
            'orderby'        => 'ID',
            'meta_query'     => array(
                'relation' => 'AND',
                array(
                    'key'     => '_order_id',
                    'value'   => $order_item_ids,
                    'compare' => 'NOT IN',
                ),
            ),
        );

        // Get the order IDs
        $last_orders = get_posts($args);
        $last_order_ids = wp_list_pluck($last_orders, 'ID');

        // Cache the result
        wp_cache_set('pure_wc_last_orders_id', $last_order_ids);
    }
    return $last_order_ids;
}

/**
 * Get last order id
 */
function pure_wc_get_last_order_id(){
    // Get last order ID
    $last_order_id = wp_cache_get('pure_wc_last_order_id');
    if (false === $last_order_id) {
        $args = array(
            'post_type'      => 'shop_order',
            'post_status'    => 'wc-completed',
            'posts_per_page' => 1,
            'order'          => 'DESC',
            'orderby'        => 'ID',
        );

        $last_order = get_posts($args);
        if ($last_order) {
            $last_order_id = $last_order[0]->ID;
            wp_cache_set('pure_wc_last_order_id', $last_order_id);
        }
    }
    return $last_order_id;

}

/**
 * Render icon html with backward compatibility
 *
 * @param array $settings
 * @param string $old_icon_id
 * @param string $new_icon_id
 * @param array $attributes
 */
if(!function_exists('pure_wc_render_icon')){
    function pure_wc_render_icon($settings = [], $old_icon_id = 'icon', $new_icon_id = 'selected_icon', $attributes = [])
    {
        // Check if its already migrated
        $migrated = isset($settings['__fa4_migrated'][$new_icon_id]);
        // Check if its a new widget without previously selected icon using the old Icon control
        $is_new = empty($settings[$old_icon_id]);

        $attributes['aria-hidden'] = 'true';

        if (pure_wc_is_elementor_version('<=', '2.6.0') && ($is_new || $migrated)) {
            \Elementor\Icons_Manager::render_icon($settings[$new_icon_id], $attributes);
        } else {
            if (empty($attributes['class'])) {
                $attributes['class'] = $settings[$old_icon_id];
            } else {
                if (is_array($attributes['class'])) {
                    $attributes['class'][] = $settings[$old_icon_id];
                } else {
                    $attributes['class'] .= ' ' . $settings[$old_icon_id];
                }
            }
            echo wp_kses(sprintf('<i %s></i>', \Elementor\Utils::render_html_attributes($attributes)), pure_wc_get_kses_extended_ruleset());
        }
    }
}
if(!function_exists('pure_wc_render_icon_item')){
    function pure_wc_render_icon_item($item = [], $old_icon_id = 'icon', $new_icon_id = 'selected_icon', $attributes = [])
    {
        // Check if its already migrated
        $migrated = isset($item['__fa4_migrated'][$new_icon_id]);
        // Check if its a new widget without previously selected icon using the old Icon control
        $is_new = empty($item[$old_icon_id]);

        $attributes['aria-hidden'] = 'true';

        if (pure_wc_is_elementor_version('<=', '2.6.0') && ($is_new || $migrated)) {
            \Elementor\Icons_Manager::render_icon($item[$new_icon_id], $attributes);
        } else {
            if (empty($attributes['class'])) {
                $attributes['class'] = $item[$old_icon_id];
            } else {
                if (is_array($attributes['class'])) {
                    $attributes['class'][] = $item[$old_icon_id];
                } else {
                    $attributes['class'] .= ' ' . $item[$old_icon_id];
                }
            }
            echo wp_kses(sprintf('<i %s></i>', \Elementor\Utils::render_html_attributes($attributes)), pure_wc_get_kses_extended_ruleset());
        }
    }
}

if(!function_exists('pure_kses')){
    function pure_kses($data){
        return wp_kses($data, pure_wc_get_kses_extended_ruleset());
    }
   
}

// Add custom fields to category creation form
add_action('product_cat_add_form_fields', 'pure_wc_add_category_custom_fields');

function pure_wc_add_category_custom_fields() {
    ?>
    <div class="form-field">
        <label for="pure_wc_cagetory_svg_code"><?php esc_html_e('SVG Code', 'shopbuild'); ?></label>
        <textarea name="pure_wc_cagetory_svg_code" id="pure_wc_cagetory_svg_code" rows="5"></textarea>
        <p class="description"><?php esc_html_e('Enter your SVG code here.', 'shopbuild'); ?></p>
    </div>
    <div class="form-field">
        <label for="pure_wc_cagetory_icon_code"><?php esc_html_e('Text', 'shopbuild'); ?></label>
        <input type="text" name="pure_wc_cagetory_icon_code" id="pure_wc_cagetory_icon_code" />
        <p class="description"><?php esc_html_e('Enter your text here.', 'shopbuild'); ?></p>
    </div>
    <div class="form-field">
        <label for="pure_wc_cagetory_count_color"><?php esc_html_e('Text', 'shopbuild'); ?></label>
        <input type="color" name="pure_wc_cagetory_count_color" id="pure_wc_cagetory_count_color" />
        <p class="description"><?php esc_html_e('Count Text Color.', 'shopbuild'); ?></p>
    </div>


    <?php
}

// Save custom fields when category is created or edited
add_action('created_product_cat', 'pure_wc_save_category_custom_fields', 10, 2);
add_action('edited_product_cat', 'pure_wc_save_category_custom_fields', 10, 2);

function pure_wc_save_category_custom_fields($term_id) {
    if(isset($_POST['_cat-nonce']) && !wp_verify_nonce( sanitize_text_field( wp_unslash($_POST['_cat-nonce'])), 'cat-nonce')){
        return;
    }
    if (isset($_POST['pure_wc_cagetory_svg_code'])) {
        update_term_meta($term_id, 'pure_wc_cagetory_svg_code', sanitize_text_field(wp_unslash($_POST['pure_wc_cagetory_svg_code'])));
    }
    if (isset($_POST['pure_wc_cagetory_icon_code'])) {
        update_term_meta($term_id, 'pure_wc_cagetory_icon_code', sanitize_text_field(wp_unslash($_POST['pure_wc_cagetory_icon_code'])));
    }
    if (isset($_POST['pure_wc_cagetory_count_color'])) {
        update_term_meta($term_id, 'pure_wc_cagetory_count_color', sanitize_text_field(wp_unslash($_POST['pure_wc_cagetory_count_color'])));
    }
}

// Display custom fields on category edit form
add_action('product_cat_edit_form_fields', 'pure_wc_edit_category_custom_fields');

function pure_wc_edit_category_custom_fields($term) {
    $pure_wc_cagetory_svg_code = get_term_meta($term->term_id, 'pure_wc_cagetory_svg_code', true);
    $pure_wc_cagetory_icon_code = get_term_meta($term->term_id, 'pure_wc_cagetory_icon_code', true);
    $pure_wc_cagetory_count_color = get_term_meta($term->term_id, 'pure_wc_cagetory_count_color', true);
    ?>
    <input type="hidden" name="_cat-nonce" value="<?php echo esc_html(wp_create_nonce('cat-nonce')); ?>">
    <tr class="form-field">
        <th scope="row" valign="top"><label for="pure_wc_cagetory_svg_code"><?php esc_html_e('SVG Code', 'shopbuild'); ?></label></th>
        <td>
            <textarea name="pure_wc_cagetory_svg_code" id="pure_wc_cagetory_svg_code" rows="5"><?php echo esc_textarea($pure_wc_cagetory_svg_code); ?></textarea>
            <p class="description"><?php esc_html_e('Enter your SVG code here. (Field From ShopBuild)', 'shopbuild'); ?></p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="pure_wc_cagetory_icon_code"><?php esc_html_e('Icon Class Name', 'shopbuild'); ?></label></th>
        <td>
            <input type="text" name="pure_wc_cagetory_icon_code" id="pure_wc_cagetory_icon_code" value="<?php echo esc_attr($pure_wc_cagetory_icon_code); ?>" />
            <p class="description"><?php esc_html_e('Enter your class name here. (Field From ShopBuild)', 'shopbuild'); ?></p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="pure_wc_cagetory_count_color"><?php esc_html_e('Count Color', 'shopbuild'); ?></label></th>
        <td>
            <input type="color" name="pure_wc_cagetory_count_color" id="pure_wc_cagetory_count_color" value="<?php echo esc_attr($pure_wc_cagetory_count_color); ?>" />
            <p class="description"><?php esc_html_e('Select Count Color. This field is only for layout 3 (Field From ShopBuild) ' , 'shopbuild'); ?></p>
        </td>
    </tr>
    <?php
}


/**
 * Product info for cart notification
 */
function pure_wc_product_info_for_cart_notification($product_id){
    $product = wc_get_product($product_id);
    $product_info = array(
        'product_id' => $product_id,
        'product_name' => $product->get_name(),
        'product_price' => $product->get_price(),
        'product_image' => $product->get_image(),
        'cart_url' => wc_get_cart_url(),
    );

    $cross_sell_ids = $product->get_cross_sell_ids();
    $cross_sell_products = array();

    if (!empty($cross_sell_ids)) {
        foreach ($cross_sell_ids as $cross_sell_id) {
            $cross_sell_product = wc_get_product($cross_sell_id);
            if ($cross_sell_product) {
                $cross_sell_products[] = array(
                    'product_id' => $cross_sell_id,
                    'product_name' => $cross_sell_product->get_name(),
                    'product_price' => $cross_sell_product->get_price(),
                    'product_image' => $cross_sell_product->get_image(),
                    'product_url' => get_permalink($cross_sell_id),
                );
            }
        }
    }

    $options = \PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_shopbuild_modules');

    ?>
    <?php if($options['pure_wc_add_to_cart_notification']): ?>
    <div class="pure-add-to-cart-notification">
        <div class="pure-add-to-cart-notification-info">
            <div class="pure-add-to-cart-notification-image">
                <?php echo wp_kses($product_info['product_image'], pure_wc_get_kses_extended_ruleset()); ?>
            </div>
            <div class="pure-add-to-cart-notification-content">
                <span class="pure-add-to-cart-notification-subtitle">
                    <?php echo esc_html__('Successfully Added To Cart', 'shopbuild'); ?>
                    <i class="icon_box-checked"></i>
                </span>
                <h4 class="pure-add-to-cart-notification-title">
                    <?php echo esc_html($product_info['product_name']); ?>
                </h4>
                
                <a href="<?php echo esc_url($product_info['cart_url']); ?>" class="pure-add-to-cart-notification-btn pure-wc-product-link">
                    <?php esc_html_e('Go to cart', 'shopbuild'); ?>
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php
}

/**
 * Product info for crosssell notification
 */
function pure_wc_product_info_for_crosssell_notification($product_id){
    $product = wc_get_product($product_id);
    $product_info = array(
        'product_id' => $product_id,
        'product_name' => $product->get_name(),
        'product_price' => $product->get_price(),
        'product_image' => $product->get_image(),
        'cart_url' => wc_get_cart_url(),
    );

    $cross_sell_ids = $product->get_cross_sell_ids();
    $cross_sell_products = array();

    if (!empty($cross_sell_ids)) {
        foreach ($cross_sell_ids as $cross_sell_id) {
            $cross_sell_product = wc_get_product($cross_sell_id);
            if ($cross_sell_product) {
                $cross_sell_products[] = array(
                    'product_id' => $cross_sell_id,
                    'product_name' => $cross_sell_product->get_name(),
                    'product_price' => $cross_sell_product->get_price(),
                    'product_image' => $cross_sell_product->get_image(),
                    'product_url' => get_permalink($cross_sell_id),
                );
            }
        }
    }

    $options = \PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin::get_option('_pure_shopbuild_modules');

    ?>
    <?php if($options['pure_wc_cross_sell']&& !empty($cross_sell_ids)): ?>
    <div class="pure-add-to-cart-notification-cross-sell">
        <a href="javascript:void(0)" class="sb-close-crosssell-popup">
            <i class="icon_close"></i>
        </a>

        <div class="pure-notification-header stb-cross-sell-header">
            <h3><?php echo esc_html($product_info['product_name']); ?></h3>
            <div class="pure-header-action-buttons">
                <a href="<?php echo esc_url($product_info['cart_url']); ?>" class="stb-btn-sm">
                    <?php esc_html_e('Go to cart', 'shopbuild'); ?>
                </a>
                <a class="stb-btn-sm stb-btn-sm-trans" href="<?php echo esc_url(home_url('shop')); ?>">
                    <?php esc_html_e('Continue Shopping', 'shopbuild'); ?>
                </a>
            </div>
        </div>

        <div class="pure-add-to-cart-notification-content">
            <span class="pure-success-add">
                <?php echo esc_html__('Successfully Added To Cart', 'shopbuild'); ?>
                <i class="icon_box-checked"></i>
            </span>
            <div class="pure-add-to-cart-notification-cross-sell-content">
                <h5 class="stb-cross-sell-title ">
                    <?php echo esc_html__('You may also like', 'shopbuild'); ?>
                </h5>
                <div class="sb-row sb-row-cols-xl-3 sb-row-cols-lg-3 sb-row-cols-md-2 sb-row-cols-sm-2 sb-row-cols-1">
                    <?php foreach ($cross_sell_products as $cross_sell_product): ?>
                    <div class="pure-cross-sell-product">
                        <div class="pure-cross-sell-image">
                            <?php echo wp_kses($cross_sell_product['product_image'], pure_wc_get_kses_extended_ruleset()); ?>
                            <div class="stb-view-btn">
                                <a href="<?php echo esc_url($cross_sell_product['product_url']); ?>" class="pure-cross-sell-btn">
                                    <?php esc_html_e('View Product', 'shopbuild'); ?>
                                </a>
                            </div>
                        </div>
                        <div class="pure-cross-sell-content">
                            <h4 class="pure-cross-sell-name">
                                <a href="<?php echo esc_url($cross_sell_product['product_url']); ?>"><?php echo esc_html($cross_sell_product['product_name']); ?></a>
                            </h4>
                            <span class="pure-cross-sell-price">
                                <?php echo wp_kses(wc_price($cross_sell_product['product_price']), pure_wc_get_kses_extended_ruleset()); ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php
}


// Get invoice templates
function pure_wc_get_invoice_templates( $template = '', $args = array() ){
    extract($args);
    if( !empty($template) ){
        include(PURE_WC_SHOPBUILD_PATH . 'invoice-templates/'.$template.'.php');
    }
}

// check is pro plugin is active or not
function pure_wc_is_pro_active(){
    $pro_path = 'shopbuild-pro/shopbuild-pro.php';
    $check_installation = file_exists(WP_PLUGIN_DIR . '/' . $pro_path);
    $check = function_exists('shopbuild_pro_active_status')? shopbuild_pro_active_status() : false;
    if($check && $check_installation){
        return true;
    }

    return false;
}

/**
 * Delete all meta by post id
 */
function delete_all_post_meta($post_id) {
    // Get all post meta keys for the specified post
    $post_meta = get_post_meta($post_id);
    
    // Loop through each meta key and delete it
    foreach ($post_meta as $meta_key => $meta_value) {
        delete_post_meta($post_id, $meta_key);
    }
}



// Function to echo Elementor template by ID
function pure_wc_render_elementor_template_by_id( $template_id ) {
    if ( \Elementor\Plugin::instance()->documents->get( $template_id )->is_built_with_elementor() ) {
        echo wp_kses(\Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id ), pure_wc_get_kses_extended_ruleset());
    } else {
        echo esc_html__('The selected template is not built with Elementor.', 'shopbuild');
    }
}

/**
 * Get option settings by key
 */
function pure_wc_sb_get_option( $option, $key ) {
    $admin = new \PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin();
    $defaults = $admin->get_settings();
    $db_values = get_option( $option, [] );
    $settings = wp_parse_args( $db_values, $defaults[ $option ] );

    return isset( $settings[ $key ] ) ? $settings[ $key ] : '';
}