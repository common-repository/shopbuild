<?php
/**
 * Modify Shop Page Contents
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
trait PureWCArchive{

    protected function set_products_per_page( $per_page = 8 ){
        $this->add_control(
			'products_limit',
			[
				'type' => \Elementor\Controls_Manager::NUMBER,
				'label' => esc_html__( 'Limit', 'shopbuild' ),
				'placeholder' => '8',
				'min' => 8,
				'max' => 100,
				'step' => 1,
				'default' => $per_page,
			]
		);
    }

	protected function wc_available_attributes(){
        $attribute_taxonomies = wc_get_attribute_taxonomies();
        $options = array('' => esc_html__( 'Default', 'shopbuild' ));
        foreach( $attribute_taxonomies as $taxonomy ){
            $options[$taxonomy->attribute_name] = esc_html( $taxonomy->attribute_label );
        }

        return $options;
    }

	protected function get_woo_categories(){
        $cat_list = get_categories( apply_filters( 'woocommerce_product_categories_widget_args', array(
			'hide_empty'	=> false, 
			'hierarchical' => 1,
			'taxonomy'     => 'product_cat') 
		) );
        $options = array('' => esc_html__( 'Default', 'shopbuild' ));
        foreach( $cat_list as $cat ){
            $options[$cat->term_id] = esc_html( $cat->name );
        }

        return $options;
    }
}