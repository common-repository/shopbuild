<?php
/**
 * Modify Shop Page Contents
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

trait PureWCActionFilter{
    protected function actionFilters(){
        add_filter( 'pure_wc_wishlist_btn_html', 'pure_wc_product_wishlist', 10, 3 );
        add_filter( 'pure_wc_quickview_btn_html', 'pure_wc_product_quick_view', 10, 2 );
        add_filter( 'pure_wc_compare_btn_html', 'pure_wc_compare_button', 10, 2 );
        add_filter( 'pure_wc_wishlist_added_html', 'pure_wc_added_wishlist', 10, 2 );
    }
}