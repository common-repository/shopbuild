<?php
/**
 * Modify Shop Page Contents
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

trait PureWCQuery{

    protected function pure_wc_query_controls($control_id = null, $control_name = null, $control_condition_for_column = true, $control_condition_for_pagination = true, $is_tab_query = false, $default_title_num = 6, $default_content_limit = '10', $post_type = 'any', $taxonomy = 'category', $posts_per_page = '12', $offset = '0', $orderby = 'date', $order = 'desc')
    {

        $this->start_controls_section(
            'pure_wc_' . $control_id . '_query',
            [
                'label' => sprintf(
                    /* translators: %s: Control's Name */
                    esc_html__('Query %s', 'shopbuild'), 
                    esc_html($control_name) 
                )
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__('Posts Per Page', 'shopbuild'),
                'description' => esc_html__('Leave blank or enter -1 for all.', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => $posts_per_page,
            ]
        );
        $this->add_control(
            'category',
            [
                'label' => esc_html__('Include Categories', 'shopbuild'),
                'description' => esc_html__('Select a category to include or leave blank for all.', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => pure_wc_get_categories($taxonomy),
                'label_block' => true,
            ]
        );

        if(!$is_tab_query){
            $this->add_control(
                'exclude_category',
                [
                    'label' => esc_html__('Exclude Categories', 'shopbuild'),
                    'description' => esc_html__('Select a category to exclude', 'shopbuild'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'multiple' => true,
                    'options' => pure_wc_get_categories($taxonomy),
                    'label_block' => true
                ]
            );
        }

 
        $this->add_control(
            'post_include',
            [
                'label' => esc_html__('Include Item', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => pure_wc_get_all_types_post($post_type),
                'multiple' => true,
                'label_block' => true
            ]
        );
        $this->add_control(
            'post__not_in',
            [
                'label' => esc_html__('Exclude Item', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => pure_wc_get_all_types_post($post_type),
                'multiple' => true,
                'label_block' => true
            ]
        );
        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => pure_wc_get_orderby_options(),
                'default' => $orderby,

            ]
        );
        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'asc' 	=> esc_html__( 'Ascending', 'shopbuild' ),
                    'desc' 	=> esc_html__( 'Descending', 'shopbuild' )
                ],
                'default' => $order,

            ]
        );

        $this->add_control(
            'pure_wc_trim_title_word',
            [
                'label' => esc_html__('Title Word Count', 'shopbuild'),
                'description' => esc_html__('Set how many word you want to display!', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => $default_title_num,
            ]
        );

        if($control_condition_for_column){
            $this->add_control(
                'products_columns',
                [
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'label' => esc_html__( 'Columns', 'shopbuild' ),
                    'options' => [
                        '2' => esc_html__( '2 Cols', 'shopbuild' ),
                        '3' => esc_html__( '3 Cols', 'shopbuild' ),
                        '4' => esc_html__( '4 Cols', 'shopbuild' ),
                        '5' => esc_html__( '5 Cols', 'shopbuild' ),
                    ],
                    'default' => '2',
                ]
            );
        }

        if($control_condition_for_pagination){
            $this->add_control(
                'products_pagination',
                [
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'label' => esc_html__( 'Pagination', 'shopbuild' ),
                    'options' => [
                        'default_pagination' => esc_html__( 'Default Pagination', 'shopbuild' ),
                        'ajax_load' => esc_html__( 'Ajax Load More', 'shopbuild' )
                    ],
                    'default' => 'default_pagination',
                ]
            );
        }



        $this->end_controls_section();

    }

}