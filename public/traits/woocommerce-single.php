<?php
/**
 * Modify Shop Page Contents
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
trait PureWCSingle{

    protected function title_tags(){
        $this->add_control(
            'product_title_html_tag',
            [
                'label'   => __( 'Title HTML Tag', 'shopbuild' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => $this->html_title_tags(),
                'default' => 'h2',
            ]
        );
    }

    protected function html_title_tags(){
        return array(
            'h1' => esc_html__('H1', 'shopbuild'),
            'h2' => esc_html__('H2', 'shopbuild'),
            'h3' => esc_html__('H3', 'shopbuild'),
            'h4' => esc_html__('H4', 'shopbuild'),
            'h5' => esc_html__('H5', 'shopbuild'),
            'h6' => esc_html__('H6', 'shopbuild')
        );
    }
}