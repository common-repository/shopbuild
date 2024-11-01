<?php
/**
 * Modify Shop Page Contents
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
trait PureWCCart{

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

    protected function switch_control( $id = 'show_title', $label = 'Show Title', $condition = ''){
        $this->add_control(
            '_'.$id,
			[
				'label'         => esc_html($label),
				'type'          => \Elementor\Controls_Manager::SWITCHER,
				'label_on'      => esc_html__( 'Show', 'shopbuild' ),
				'label_off'     => esc_html__( 'Hide', 'shopbuild' ),
				'return_value'  => 'yes',
				'default'       => 'yes',
                'condition'     => $condition
			]
        );
    }
}