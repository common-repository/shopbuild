<?php
/**
 * Modify Shop Page Contents
 */
use PureWCShopbuild\Elementor\Controls\Group_Control_PWCSGradient;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

trait PureWCCommonStyles{

    protected function pure_wc_icon_style($control_id = null, $control_name = 'Icon/Image Style', $selector = '.single-service .icon'){
        $this->start_controls_section(
            'pure_wc_'.$control_id.'_media_style',
            [
                'label' => esc_html($control_name),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_group_control(
            Group_Control_PWCSGradient::get_type(),
            [
                'name' => 'pure_wc_' . $control_id . '_color',
                'label' => esc_html__('Color', 'shopbuild'),
                'selector' => '{{WRAPPER}} '. $selector . ' span',
            ]
        );

        $this->add_control(
            'pure_wc_' . $control_id . 'area_background',
            [
                'label' => esc_html__('Background Color', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ' span' => 'background: {{VALUE}}  ;',
                ],
            ]
        );

        $this->add_responsive_control(
            'pure_wc_'.$control_id.'_icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'shopbuild' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} '. $selector .' span' => 'font-size: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        $this->add_responsive_control(
            'pure_wc_'.$control_id.'_image_width',
            [
                'label' => esc_html__( 'Image/SVG Width', 'shopbuild' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 400,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} '. $selector .' img, {{WRAPPER}} '. $selector .' svg' => 'width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        $this->add_responsive_control(
            'pure_wc_'.$control_id.'_image_height',
            [
                'label' => esc_html__( 'Image/SVG Height', 'shopbuild' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 400,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} '. $selector .' img, {{WRAPPER}} '. $selector .' svg' => 'height: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        $this->add_responsive_control(
            'pure_wc_'.$control_id.'_image_spacing',
            [
                'label' => esc_html__( 'Bottom Spacing', 'shopbuild' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} '. $selector .' img, {{WRAPPER}} '. $selector .' i, {{WRAPPER}} '. $selector .' svg' => 'margin-bottom: {{SIZE}}{{UNIT}}  ;',
                ],
            ]
        );
        $this->add_responsive_control(
            'pure_wc_'.$control_id.'_image_padding',
            [
                'label' => esc_html__( 'Padding', 'shopbuild' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} '. $selector .' img, {{WRAPPER}} '. $selector .' i, {{WRAPPER}} '. $selector .' svg' => 'padding: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }



    /*
        
    ===========================================
    ========= TP Basic Style Controls =========
    ===========================================

    1. $control_id -> Tab ID
    2. $control_name -> Tab Title
    3. $control_selector -> Selector Class or ID

    */
    
    protected function pure_wc_basic_style_controls($control_id = null, $control_name = null, $control_selector = null)
    {

        $this->start_controls_section(
            'pure_wc_' . $control_id . '_styling',
            [
                'label' => esc_html($control_name),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_PWCSGradient::get_type(),
            [
                'name' => 'pure_wc_' . $control_id . '_advs',
                'label' => esc_html__('Color', 'shopbuild'),
                'selector' => '{{WRAPPER}} ' . $control_selector,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'pure_wc_' . $control_id . '_typography',
                'label' => esc_html__('Typography', 'shopbuild'),
                'selector' => '{{WRAPPER}} ' . $control_selector,
            ]
        );
        $this->add_responsive_control(
            'pure_wc_' . $control_id . '_padding',
            [
                'label' => esc_html__('Padding', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'pure_wc_' . $control_id . '_margin',
            [
                'label' => esc_html__('Margin', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->end_controls_section();
    }
    
    
    /*
        
    ===========================================
    ========= TP Basic Style Controls 2 =========
    ===========================================

    1. $control_id -> Tab ID
    2. $control_name -> Tab Title
    3. $control_selector -> Selector Class or ID

    */
    
    protected function pure_wc_basic_style_controls_2($control_id = null, $control_name = null, $control_selector = null)
    {

        $this->start_controls_section(
            'pure_wc_' . $control_id . '_styling',
            [
                'label' => esc_html($control_name),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'pure_wc_' . $control_id . '_bg',
                'label'   => esc_html__( 'Background', 'shopbuild' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} ' . $control_selector,
            ]
            );

            $this->add_control(
            'pure_wc_' . $control_id . '_advs',
            [
            'label'       => esc_html__( 'Color', 'shopbuild' ),
            'type'     => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} ' . $control_selector => 'color: {{VALUE}}',
            ],
            ]
            );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'pure_wc_' . $control_id . '_typography',
                'label' => esc_html__('Typography', 'shopbuild'),
                'selector' => '{{WRAPPER}} ' . $control_selector,
            ]
        );
        $this->add_responsive_control(
            'pure_wc_' . $control_id . '_padding',
            [
                'label' => esc_html__('Padding', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'pure_wc_' . $control_id . '_margin',
            [
                'label' => esc_html__('Margin', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->end_controls_section();
    }

    protected function pure_wc_slider_style_controls(){
            $this->start_controls_section(
             'pure_wc_slider_style',
                 [
                   'label' => esc_html__( 'Slider Dot Style', 'shopbuild' ),
                   'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                 ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                  'name' => 'pure_wc_slider_style_num_typography',
                  'label'   => esc_html__( 'Font Size', 'shopbuild' ),
                  'selector' => '{{WRAPPER}} .sb-el-slider-dot ul.slick-dots li button',
                  'description' => esc_html__( 'Set the font size for number style.', 'shopbuild' ),
                ]
            );
            
            $this->add_control(
             'pure_wc_slider_style_dot',
             [
               'label'       => esc_html__( 'Dot Color', 'shopbuild' ),
               'type'     => \Elementor\Controls_Manager::COLOR,
               'selectors' => [
               '{{WRAPPER}} .sb-el-slider-dot ul.slick-dots li button' => 'background-color: {{VALUE}}',
               ],
             ]
            );
            $this->add_control(
             'pure_wc_slider_style_dot_hover',
             [
               'label'       => esc_html__( 'Dot Hover Color', 'shopbuild' ),
               'type'     => \Elementor\Controls_Manager::COLOR,
               'selectors' => [
               '{{WRAPPER}} .sb-el-slider-dot ul.slick-dots li button:hover' => 'background-color: {{VALUE}}',
               '{{WRAPPER}} .sb-el-slider-dot ul.slick-dots li.slick-active button:hover' => 'background-color: {{VALUE}}',
               ],
             ]
            );
            
            $this->add_control(
             'pure_wc_slider_style_dot_active',
             [
               'label'       => esc_html__( 'Active Dot Color', 'shopbuild' ),
               'type'     => \Elementor\Controls_Manager::COLOR,
               'selectors' => [
               '{{WRAPPER}} .sb-el-slider-dot ul.slick-dots li.slick-active button' => 'background-color: {{VALUE}}',
               ],
             ]
            );
            
    
            $this->add_control(
                'pure_wc_slider_style_dot_width',
                [
                  'label' => esc_html__( 'Width', 'shopbuild' ),
                  'type' => \Elementor\Controls_Manager::SLIDER,
                  'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                  'range' => [
                    'px' => [
                      'min' => 0,
                      'max' => 1000,
                      'step' => 5,
                    ],
                    '%' => [
                      'min' => 0,
                      'max' => 100,
                    ],
                  ],
                  'default' => [
                    'unit' => 'px',
                    'size' => 8,
                  ],
                  'selectors' => [
                    '{{WRAPPER}} .sb-el-slider-dot ul.slick-dots li button' => 'width: {{SIZE}}{{UNIT}};',
                  ],
                ]
              );
    
            $this->add_control(
                'pure_wc_slider_style_dot_height',
                [
                  'label' => esc_html__( 'Height', 'shopbuild' ),
                  'type' => \Elementor\Controls_Manager::SLIDER,
                  'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                  'range' => [
                    'px' => [
                      'min' => 0,
                      'max' => 1000,
                      'step' => 5,
                    ],
                    '%' => [
                      'min' => 0,
                      'max' => 100,
                    ],
                  ],
                  'default' => [
                    'unit' => 'px',
                    'size' => 8,
                  ],
                  'selectors' => [
                    '{{WRAPPER}} .sb-el-slider-dot ul.slick-dots li button' => 'height: {{SIZE}}{{UNIT}};',
                  ],
                ]
              );
    
              $this->add_control(
                  'pure_wc_slider_style_dot_radius',
                  [
                    'label' => esc_html__( 'Radius', 'shopbuild' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                    'range' => [
                      'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                      ],
                      '%' => [
                        'min' => 0,
                        'max' => 100,
                      ],
                    ],
                    'default' => [
                      'unit' => '%',
                      'size' => 50,
                    ],
                    'selectors' => [
                      '{{WRAPPER}} .sb-el-slider-dot ul.slick-dots li button' => 'border-radius: {{SIZE}}{{UNIT}};',
                    ],
                  ]
                );
    
              $this->add_control(
               'pure_wc_slider_style_dot_margin',
                 [
                   'label'      => esc_html__( 'Margin', 'shopbuild' ),
                   'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                   'size_units' => [ 'px', '%', 'em' ],
                   'selectors'  => [
                     '{{WRAPPER}} .sb-el-slider-dot ul.slick-dots li button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                   ],
                 ]
               );
            
            $this->end_controls_section();
            $this->pure_wc_link_controls_style('pure_wc_slider_btn', 'Slider Button Style', '.sb-el-slider-btn button.slick-arrow', '.sb-el-slider-btn button.slick-arrow:hover');
    
            $this->start_controls_section(
             'pure_wc_slider_btn_position_sec',
                 [
                   'label' => esc_html__( 'Slider Button Position', 'shopbuild' ),
                   'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                 ]
            );
            
            $this->start_controls_tabs(
               'pure_wc_slider_btn_position_tab',
             );
            
            $this->start_controls_tab(
               'pure_wc_slider_btn_position_prev',
               [
                 'label'   => esc_html__( 'Previous', 'shopbuild' ),
               ]
             );
    
             $this->add_responsive_control(
                'pure_wc_slider_btn_position_prev_top',
                [
                  'label' => esc_html__( 'Top', 'shopbuild' ),
                  'type' => \Elementor\Controls_Manager::SLIDER,
                  'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                  'range' => [
                    'px' => [
                      'min' => -1000,
                      'max' => 1000,
                      'step' => 5,
                    ],
                    '%' => [
                      'min' => -100,
                      'max' => 100,
                    ],
                  ],
                  'default' => [
                    'unit' => '%',
                    'size' => 50,
                  ],
                  'selectors' => [
                    '{{WRAPPER}} .sb-el-slider-btn button.slick-prev' => 'top: {{SIZE}}{{UNIT}};',
                  ],
                ]
              );
             $this->add_responsive_control(
                'pure_wc_slider_btn_position_prev_left',
                [
                  'label' => esc_html__( 'Left', 'shopbuild' ),
                  'type' => \Elementor\Controls_Manager::SLIDER,
                  'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                  'range' => [
                    'px' => [
                      'min' => -1000,
                      'max' => 1000,
                      'step' => 5,
                    ],
                    '%' => [
                      'min' => -100,
                      'max' => 100,
                    ],
                  ],
                  'default' => [
                    'unit' => 'px',
                    'size' => -100,
                  ],
                  'selectors' => [
                    '{{WRAPPER}}  .sb-el-slider-btn button.slick-prev' => 'Left: {{SIZE}}{{UNIT}};',
                  ],
                ]
              );
            
            $this->end_controls_tab();
            
            $this->start_controls_tab(
               'pure_wc_slider_btn_position_next',
               [
                 'label'   => esc_html__( 'Next', 'shopbuild' ),
               ]
             );
    
             $this->add_responsive_control(
                'pure_wc_slider_btn_position_next_top',
                [
                  'label' => esc_html__( 'Top', 'shopbuild' ),
                  'type' => \Elementor\Controls_Manager::SLIDER,
                  'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                  'range' => [
                    'px' => [
                      'min' => -1000,
                      'max' => 1000,
                      'step' => 5,
                    ],
                    '%' => [
                      'min' => -100,
                      'max' => 100,
                    ],
                  ],
                  'default' => [
                    'unit' => '%',
                    'size' => 50,
                  ],
                  'selectors' => [
                    '{{WRAPPER}} .sb-el-slider-btn button.slick-next' => 'top: {{SIZE}}{{UNIT}};',
                  ],
                ]
              );
    
             $this->add_responsive_control(
                'pure_wc_slider_btn_position_next_right',
                [
                  'label' => esc_html__( 'Top', 'shopbuild' ),
                  'type' => \Elementor\Controls_Manager::SLIDER,
                  'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                  'range' => [
                    'px' => [
                      'min' => -1000,
                      'max' => 1000,
                      'step' => 5,
                    ],
                    '%' => [
                      'min' => -100,
                      'max' => 100,
                    ],
                  ],
                  'default' => [
                    'unit' => 'px',
                    'size' => -100,
                  ],
                  'selectors' => [
                    '{{WRAPPER}} .sb-el-slider-btn button.slick-next' => 'right: {{SIZE}}{{UNIT}};',
                  ],
                ]
              );
            
            $this->end_controls_tab();
            
            $this->end_controls_tabs();
            
            $this->end_controls_section();
        
    }
    
    
    /*
        
    ===========================================
    ========= TP Basic Style Controls 2 =========
    ===========================================

    1. $control_id -> Tab ID
    2. $control_name -> Tab Title
    3. $control_selector -> Selector Class or ID

    */
    
    protected function pure_wc_basic_style_controls_repeater($repeater = null, $control_id = null, $control_name = null, $control_selector = null, $condition_condition = null)
    {

        $repeater->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'pure_wc_' . $control_id . '_bg',
                'label'   => esc_html__( 'Background', 'shopbuild' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}' . $control_selector,
                'condition' => [
                    $condition_condition => 'yes'
                ]

            ]
            );

            $repeater->add_control(
            'pure_wc_' . $control_id . '_advs',
            [
            'label'       => esc_html__( 'Color', 'shopbuild' ),
            'type'     => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}}' . $control_selector => 'color: {{VALUE}}',
            ],
            'condition' => [
                $condition_condition => 'yes'
            ]
            ]
            );

        $repeater->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'pure_wc_' . $control_id . '_typography',
                'label' => esc_html__('Typography', 'shopbuild'),
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}' . $control_selector,
                'condition' => [
                    $condition_condition => 'yes'
                ]
            ]
        );
        $repeater->add_responsive_control(
            'pure_wc_' . $control_id . '_padding',
            [
                'label' => esc_html__('Padding', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' . $control_selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
                'condition' => [
                    $condition_condition => 'yes'
                ]
            ]
        );
        $repeater->add_responsive_control(
            'pure_wc_' . $control_id . '_margin',
            [
                'label' => esc_html__('Margin', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' . $control_selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
                'condition' => [
                    $condition_condition => 'yes'
                ]
            ]
        );
    }

    /*
        
    =============================================
    ========= TP Section Style Controls =========
    =============================================

    1. $control_id -> Tab ID
    2. $control_name -> Tab Title
    3. $control_selector -> Selector Class or ID

    */
    
    
    protected function pure_wc_section_style_controls($control_id = null, $control_name = null, $control_selector = null)
    {
        $this->start_controls_section(
            'pure_wc_' . $control_id . '_area_styling',
            [
                'label' => esc_html($control_name),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'pure_wc_' . $control_id . 'area_background',
                'label' => esc_html__('Background', 'shopbuild'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} ' . $control_selector,
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'pure_wc_' . $control_id . '_btn_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'shopbuild' ),
                'selector' => '{{WRAPPER}} ' . $control_selector,
            ]
        );

        $this->pure_wc_get_border_controls($control_id, $control_name, $control_selector);
    
        $this->add_responsive_control(
            'pure_wc_' . $control_id . '_area_padding',
            [
                'label' => esc_html__('Padding', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}  ;',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'pure_wc_' . $control_id . '_area_margin',
            [
                'label' => esc_html__('Margin', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}  ;',
                ],
                'separator' => 'before',
            ]
        );
        $this->end_controls_section();
    }

    /*
        
    ==========================================
    ========= TP Link Style Controls =========
    ==========================================

    1. $control_id -> Tab ID
    2. $control_name -> Tab Title
    3. $control_selector -> Selector Class or ID

    */
    
    protected function pure_wc_link_controls_style($control_id = null, $control_name = null, $control_selector = null, $control_selector_hover = null)
    {

        $control_main_selector = '';
        if($control_selector != null){
            $normal_state_arr = explode(',', $control_selector);

            $wrap_main = '{{WRAPPER}} ';

            $control_main_selector = '';
            for ($i=0; $i < count($normal_state_arr); $i++) { 
                $comma = ($i < (count($normal_state_arr) - 1)) ? ', ' : '';

                $control_main_selector .= $wrap_main . $normal_state_arr[$i] . ' '. $comma .'';
            }
        }

        $control_hover_selector = '';

        if($control_selector_hover != null){
            $newArr = explode(',', $control_selector_hover);

            $wrap = '{{WRAPPER}} ';
            $control_hover_selector = '';

            for ($i=0; $i < count($newArr); $i++) { 
                $comma = ($i < (count($newArr) - 1)) ? ', ' : '';

                $control_hover_selector .= $wrap . $newArr[$i] . ' '. $comma .'';
            }
        }

        

        /**
         * Button One
         */
        $this->start_controls_section(
            'pure_wc_' . $control_id . '_button',
            [
                'label' => esc_html($control_name),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'pure_wc_' . $control_id . '_typography',
                'selector' => ' '. $control_main_selector . ' ',
            ]
        );


        $this->start_controls_tabs('pure_wc_' . $control_id . '_button_tabs');

        // Normal State Tab
        $this->start_controls_tab('pure_wc_' . $control_id . '_btn_normal', ['label' => esc_html__('Normal', 'shopbuild')]);

        $this->add_control(
            'pure_wc_' . $control_id . '_btn_normal_text_color',
            [
                'label' => esc_html__('Text Color', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '' . $control_main_selector . '' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pure_wc_' . $control_id . '_btn_normal_bg_color',
            [
                'label' => esc_html__('Background Color', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '' . $control_main_selector . '' => 'background: {{VALUE}}  ;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'pure_wc_' . $control_id . '_btn_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'shopbuild' ),
                'selector' => '' . $control_main_selector . '',
            ]
        );

        $this->add_control(
            'pure_wc_' . $control_id . '_btn_normal_border_style',
            [
                'label' => esc_html__('Border Style', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'shopbuild'),
                    'none' => esc_html__('None', 'shopbuild'),
                    'solid' => esc_html__('Solid', 'shopbuild'),
                    'double' => esc_html__('Double', 'shopbuild'),
                    'dotted' => esc_html__('Dotted', 'shopbuild'),
                    'dashed' => esc_html__('Dashed', 'shopbuild'),
                    'groove' => esc_html__('Groove', 'shopbuild'),
                ],
                'selectors' => [
                    '' . $control_main_selector . '' => 'border-style: {{VALUE}}  ;',
                ],
            ]
        );

        $this->add_responsive_control(
            'pure_wc_' . $control_id . '_btn_normal_border_width',
            [
                'label' => esc_html__('Border Width', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '' . $control_main_selector => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}  ;',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'pure_wc_' . $control_id . '_btn_normal_border_color',
            [
                'label' => esc_html__('Border Color', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '' . $control_main_selector . '' => 'border-color: {{VALUE}}  ;',
                ],
            ]

        );


        $this->add_control(
            'pure_wc_' . $control_id . '_btn_border_radius',
            [
                'label' => esc_html__('Border Radius', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '' . $control_main_selector . '' => 'border-radius: {{SIZE}}px;',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab('pure_wc_' . $control_id . '_btn_hover', ['label' => esc_html__('Hover', 'shopbuild')]);

        $this->add_control(
            'pure_wc_' . $control_id . '_btn_hover_text_color',
            [
                'label' => esc_html__('Text Color', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '' . $control_hover_selector . '' => 'color: {{VALUE}}  ;',
                ],
            ]
        );

        $this->add_control(
            'pure_wc_' . $control_id . '_btn_hover_bg_color',
            [
                'label' => esc_html__('Background Color', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '' . $control_hover_selector . '' => 'background: {{VALUE}}  ;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'pure_wc_' . $control_id . '_btn_hover_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'shopbuild' ),
                'selector' => '' . $control_hover_selector . '',
            ]
        );

        $this->add_control(
            'pure_wc_' . $control_id . '_btn_hover_border_style',
            [
                'label' => esc_html__('Border Style', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'shopbuild'),
                    'none' => esc_html__('None', 'shopbuild'),
                    'solid' => esc_html__('Solid', 'shopbuild'),
                    'double' => esc_html__('Double', 'shopbuild'),
                    'dotted' => esc_html__('Dotted', 'shopbuild'),
                    'dashed' => esc_html__('Dashed', 'shopbuild'),
                    'groove' => esc_html__('Groove', 'shopbuild'),
                ],
                'selectors' => [
                    '' . $control_hover_selector . '' => 'border-style: {{VALUE}}  ;',
                ],
            ]
        );

        $this->add_responsive_control(
            'pure_wc_' . $control_id . '_btn_hover_border_width',
            [
                'label' => esc_html__('Border Width', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '' . $control_hover_selector => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}  ;',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'pure_wc_' . $control_id . '_btn_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '' . $control_hover_selector . '' => 'border-color: {{VALUE}}  ;',
                ],
            ]
        );




        $this->end_controls_tab();

        $this->end_controls_tabs();

                $this->add_responsive_control(
            'pure_wc_' . $control_id . '_padding',
            [
                'label' => esc_html__('Padding', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector . '' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'pure_wc_' . $control_id . '_margin',
            [
                'label' => esc_html__('Margin', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector . '' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /*
        
    ==========================================
    ========= TP Input Style Controls =========
    ==========================================

    1. $control_id -> Tab ID
    2. $control_name -> Tab Title
    3. $control_selector -> Selector Class or ID

    */
    
    protected function pure_wc_input_controls_style($control_id = null, $control_name = null, $control_selector = '.tp-input', $control_selector2 = '.tp-textarea')
    {
        /**
         * Button One
         */
        $this->start_controls_section(
            'pure_wc_' . $control_id . '_button',
            [
                'label' => esc_html($control_name),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'pure_wc_' . $control_id . '_typography',
                'selector' => '{{WRAPPER}} ' . $control_selector . ', {{WRAPPER}} ' . $control_selector2 . '',
            ]
        );


        $this->start_controls_tabs('pure_wc_' . $control_id . '_button_tabs');

        // Normal State Tab
        $this->start_controls_tab('pure_wc_' . $control_id . '_btn_normal', ['label' => esc_html__('Normal', 'shopbuild')]);

        $this->add_control(
            'pure_wc_' . $control_id . '_btn_normal_text_color',
            [
                'label' => esc_html__('Text Color', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector . ', {{WRAPPER}} ' . $control_selector2 . '' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pure_wc_' . $control_id . '_btn_normal_bg_color',
            [
                'label' => esc_html__('Background Color', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector . ', {{WRAPPER}} ' . $control_selector2 . '' => 'background: {{VALUE}}  ;',
                ],
            ]
        );

        $this->add_control(
            'pure_wc_' . $control_id . '_btn_normal_placeholder_color',
            [
                'label' => esc_html__('Placeholder Color', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector . '::placeholder, {{WRAPPER}} ' . $control_selector2 . '::placeholder' => 'color: {{VALUE}}  ;',
                ],
            ]
        );


        $this->add_control(
            'pure_wc_' . $control_id . '_btn_normal_border_color',
            [
                'label' => esc_html__('Border Color', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector . ', {{WRAPPER}} ' . $control_selector2 . '' => 'border-color: {{VALUE}}  ;;',
                ],
            ]

        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'pure_wc_' . $control_id . '_btn_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'shopbuild' ),
                'selector' => '{{WRAPPER}} ' . $control_selector . ', {{WRAPPER}} ' . $control_selector2 . '',
            ]
        );

        $this->add_control(
            'pure_wc_' . $control_id . '_btn_border_radius',
            [
                'label' => esc_html__('Border Radius', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector . ', {{WRAPPER}} ' . $control_selector2 . '' => 'border-radius: {{SIZE}}px;',
                ],
            ]
        );

        $this->end_controls_tab();

        // Focus State Tab
        $this->start_controls_tab('pure_wc_' . $control_id . '_btn_hover', ['label' => esc_html__('Focus', 'shopbuild')]);

        $this->add_control(
            'pure_wc_' . $control_id . '_btn_hover_bg_color',
            [
                'label' => esc_html__('Background Color', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector . ':focus,{{WRAPPER}} ' . $control_selector2 . ':focus' => 'background: {{VALUE}}  ;',
                ],
            ]
        );

        $this->add_control(
            'pure_wc_' . $control_id . '_btn_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector . ':focus,{{WRAPPER}} ' . $control_selector2 . ':focus' => 'border-color: {{VALUE}}  ;',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'pure_wc_' . $control_id . '_btn_hover_box_shadow',
                'label' => esc_html__( 'Box Shadow', 'shopbuild' ),
                'selector' => '{{WRAPPER}} ' . $control_selector . ':focus,{{WRAPPER}} ' . $control_selector2 . ':focus',
            ]
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'pure_wc_' . $control_id . '_padding',
            [
                'label' => esc_html__('Padding', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector . ',{{WRAPPER}} ' . $control_selector2 . '' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'pure_wc_' . $control_id . '_margin',
            [
                'label' => esc_html__('Margin', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector . ',{{WRAPPER}} ' . $control_selector2 . '' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    
    protected function pure_wc_columns($control_id = 'columns_options', $control_name = 'Select Columns', $control_condition = null, $default_for_lg = '4', $default_for_md = '4', $default_for_sm = '3', $default_for_xs = '1', $default_for_all = '4'){


        if(!empty($control_condition)){
            $this->start_controls_section(
                'pure_wc_' . $control_id . 'columns_section',
                [
                    'label' => esc_html($control_name),
                    'condition' => $control_condition
                ]
            );
        }else{
            $this->start_controls_section(
                'pure_wc_' . $control_id . 'columns_section',
                [
                    'label' => esc_html($control_name),
                ]
            );
        }
        
        

        $this->add_control(
            'pure_wc_' . $control_id . '_for_desktop',
            [
                'label' => esc_html__( 'Columns for Desktop', 'shopbuild' ),
                'description' => esc_html__( 'Screen width equal to or greater than 1200px', 'shopbuild' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1' => esc_html__( '1 Columns', 'shopbuild' ),
                    '2' => esc_html__( '2 Columns', 'shopbuild' ),
                    '3' => esc_html__( '3 Columns', 'shopbuild' ),
                    '4' => esc_html__( '4 Columns', 'shopbuild' ),
                    '5' => esc_html__( '5 Columns', 'shopbuild' ),
                    '6' => esc_html__( '6 Columns', 'shopbuild' ),
                ],
                'separator' => 'before',
                'default' => $default_for_lg,
                'style_transfer' => true,
            ]
        );
        $this->add_control(
            'pure_wc_' . $control_id . '_for_laptop',
            [
                'label' => esc_html__( 'Columns for Large', 'shopbuild' ),
                'description' => esc_html__( 'Screen width equal to or greater than 992px', 'shopbuild' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1' => esc_html__( '1 Columns', 'shopbuild' ),
                    '2' => esc_html__( '2 Columns', 'shopbuild' ),
                    '3' => esc_html__( '3 Columns', 'shopbuild' ),
                    '4' => esc_html__( '4 Columns', 'shopbuild' ),
                    '5' => esc_html__( '5 Columns', 'shopbuild' ),
                    '6' => esc_html__( '6 Columns', 'shopbuild' ),
                ],
                'separator' => 'before',
                'default' => $default_for_md,
                'style_transfer' => true,
            ]
        );
        $this->add_control(
            'pure_wc_' . $control_id . '_for_tablet',
            [
                'label' => esc_html__( 'Columns for Tablet', 'shopbuild' ),
                'description' => esc_html__( 'Screen width equal to or greater than 768px', 'shopbuild' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1' => esc_html__( '1 Columns', 'shopbuild' ),
                    '2' => esc_html__( '2 Columns', 'shopbuild' ),
                    '3' => esc_html__( '3 Columns', 'shopbuild' ),
                    '4' => esc_html__( '4 Columns', 'shopbuild' ),
                    '5' => esc_html__( '5 Columns', 'shopbuild' ),
                    '6' => esc_html__( '6 Columns', 'shopbuild' ),
                ],
                'separator' => 'before',
                'default' => $default_for_sm,
                'style_transfer' => true,
            ]
        );
        $this->add_control(
            'pure_wc_' . $control_id . '_for_mobile',
            [
                'label' => esc_html__( 'Columns for Mobile', 'shopbuild' ),
                'description' => esc_html__( 'Screen width equal to or greater than 576px', 'shopbuild' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1' => esc_html__( '1 Columns', 'shopbuild' ),
                    '2' => esc_html__( '2 Columns', 'shopbuild' ),
                    '3' => esc_html__( '3 Columns', 'shopbuild' ),
                    '4' => esc_html__( '4 Columns', 'shopbuild' ),
                    '5' => esc_html__( '5 Columns', 'shopbuild' ),
                    '6' => esc_html__( '6 Columns', 'shopbuild' ),
                ],
                'separator' => 'before',
                'default' => $default_for_all,
                'style_transfer' => true,
            ]
        );
        $this->add_control(
            'pure_wc_' . $control_id . '_for_xs',
            [
                'label' => esc_html__( 'Columns for Extra Small', 'shopbuild' ),
                'description' => esc_html__( 'Screen width less than 575px', 'shopbuild' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1' => esc_html__( '1 Columns', 'shopbuild' ),
                    '2' => esc_html__( '2 Columns', 'shopbuild' ),
                    '3' => esc_html__( '3 Columns', 'shopbuild' ),
                    '4' => esc_html__( '4 Columns', 'shopbuild' ),
                    '5' => esc_html__( '5 Columns', 'shopbuild' ),
                    '6' => esc_html__( '6 Columns', 'shopbuild' ),
                ],
                'separator' => 'before',
                'default' => $default_for_all,
                'style_transfer' => true,
            ]
        );

        $this->end_controls_section();
    }

    protected function pure_col_show($data, $key = 'col')
    {
        $desktop = "sb-col-xl-" . esc_attr($data['pure_wc_'.$key.'_for_desktop']);
        $laptop = "sb-col-lg-" . esc_attr($data['pure_wc_'.$key.'_for_laptop']);
        $tablet = "sb-col-md-" . esc_attr($data['pure_wc_'.$key.'_for_tablet']);
        $tablet = "sb-col-md-" . esc_attr($data['pure_wc_'.$key.'_for_tablet']);
        $mobile = "sb-col-sm-" . esc_attr($data['pure_wc_'.$key.'_for_mobile']);
        $xs = "sb-col-" . esc_attr($data['pure_wc_'.$key.'_for_xs']);

        $total_col = $desktop . " " . $laptop . " " . $tablet . " " . $mobile . " " . $xs;

        return $total_col;
    }

    // colum show
    protected function pure_row_cols_show($data, $key = 'col')
    {
        $desktop = "sb-row-cols-xl-" . esc_attr($data['pure_wc_'.$key.'_for_desktop']);
        $laptop = "sb-row-cols-lg-" . esc_attr($data['pure_wc_'.$key.'_for_laptop']);
        $tablet = "sb-row-cols-md-" . esc_attr($data['pure_wc_'.$key.'_for_tablet']);
        $tablet = "sb-row-cols-md-" . esc_attr($data['pure_wc_'.$key.'_for_tablet']);
        $mobile = "sb-row-cols-sm-" . esc_attr($data['pure_wc_'.$key.'_for_mobile']);
        $xs = "sb-row-cols-" . esc_attr($data['pure_wc_'.$key.'_for_xs']);

        $total_col = $desktop . " " . $laptop . " " . $tablet . " " . $mobile . " " . $xs;

        return $total_col;
    }


    protected function pure_wc_product_feature($enableTitleWordCount = false){
        $this->start_controls_section(
            'product_card_sec',
                [
                  'label' => esc_html__( 'Product Card', 'shopbuild' ),
                  'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
           );
           
           $this->add_control(
            'product_style',
               [
                   'label'   => esc_html__( 'Product Style', 'shopbuild' ),
                   'type' => \Elementor\Controls_Manager::SELECT,
                   'options' => [
                       '1'  => esc_html__( 'Default Style', 'shopbuild' ),
                   ],
                   'default' => '1',
               ]
           );

           $this->add_control(
            'product_content_align',
            [
              'label'   => esc_html__( 'Content Align', 'shopbuild' ),
              'type' => \Elementor\Controls_Manager::SELECT,
              'options' => [
                'default'  => esc_html__( 'Default', 'shopbuild' ),
                'left'  => esc_html__( 'Left', 'shopbuild' ),
                'right'  => esc_html__( 'Right', 'shopbuild' ),
                'center'  => esc_html__( 'Center', 'shopbuild' ),
              ],
              'default' => 'default',
            ]
           );



           $this->add_control(
            'product_rating_switch',
               [
                   'label'        => esc_html__( 'Enable Rating?', 'shopbuild' ),
                   'type'         => \Elementor\Controls_Manager::SWITCHER,
                   'label_on'     => esc_html__( 'Show', 'shopbuild' ),
                   'label_off'    => esc_html__( 'Hide', 'shopbuild' ),
                   'return_value' => 'yes',
                   'default'      => 'yes',
               ]
           );
           
              $this->add_control(
                'review_text_switch',
                [
                     'label'        => esc_html__( 'Enable Rating Text?', 'shopbuild' ),
                     'type'         => \Elementor\Controls_Manager::SWITCHER,
                     'label_on'     => esc_html__( 'Show', 'shopbuild' ),
                     'label_off'    => esc_html__( 'Hide', 'shopbuild' ),
                     'return_value' => 'yes',
                     'default'      => 'yes',
                ]
              );

           $this->add_control(
            'action_style',
               [
                   'label'   => esc_html__( 'Action Style', 'shopbuild' ),
                   'type' => \Elementor\Controls_Manager::SELECT,
                   'options' => [
                       'default'  => esc_html__( 'Default Style', 'shopbuild' ),
                       '2'  => esc_html__( 'Style 2', 'shopbuild' ),
                       '3'  => esc_html__( 'Style 3', 'shopbuild' ),
                       '4'  => esc_html__( 'Style 4', 'shopbuild' ),
                       '5'  => esc_html__( 'Style 5', 'shopbuild' ),
                       '6'  => esc_html__( 'Style 6', 'shopbuild' ),
                   ],
                   'default' => 'default',
               ]
           );

           $this->add_control(
            'action_type',
            [
              'label'   => esc_html__( 'Action Type', 'shopbuild' ),
              'type' => \Elementor\Controls_Manager::SELECT,
              'options' => [
                'on_hover'  => esc_html__( 'On Hover', 'shopbuild' ),
                'fixed'  => esc_html__( 'Fixed', 'shopbuild' ),
              ],
              'default' => 'on_hover',
            ]
           );

           $this->add_control(
            'select_type_attribute_position',
            [
                'label'   => esc_html__( 'Select Type Attribute', 'shopbuild' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'on_thumbnail'  => esc_html__( 'On Thumbnail', 'shopbuild' ),
                    'before_content'  => esc_html__( 'Before Content', 'shopbuild' ),
                ],
                'description' => 'Select Type Attribute Position',
                'default' => 'on_thumbnail',
                'condition' => [
                    'action_style' => '6',
                ],
            ]
           );
           $this->add_control(
            'color_type_attribute_position',
            [
                'label'   => esc_html__( 'Color Type Attribute', 'shopbuild' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'on_thumbnail'  => esc_html__( 'On Thumbnail', 'shopbuild' ),
                    'before_content'  => esc_html__( 'Before Content', 'shopbuild' ),
                ],
                'description' => 'Color Type Attribute Position',
                'default' => 'on_thumbnail',
                'condition' => [
                    'action_style' => '6',
                ],
            ]
           );

              $this->add_control(
                'image_type_attribute_position',
                 [
                    'label'   => esc_html__( 'Image Type Attribute', 'shopbuild' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => [
                        'on_thumbnail'  => esc_html__( 'On Thumbnail', 'shopbuild' ),
                        'before_content'  => esc_html__( 'Before Content', 'shopbuild' ),
                    ],
                    'description' => 'Image Type Attribute Position',
                    'default' => 'on_thumbnail',
                    'condition' => [
                        'action_style' => '6',
                    ],
                    'separator' => 'after',
                 ]
              );
              $this->add_control(
                'none_type_attribute_position',
                 [
                 'label'   => esc_html__( 'None Type Attribute', 'shopbuild' ),
                 'type' => \Elementor\Controls_Manager::SELECT,
                 'options' => [
                      'on_thumbnail'  => esc_html__( 'On Thumbnail', 'shopbuild' ),
                      'before_content'  => esc_html__( 'Before Content', 'shopbuild' ),
                 ],
                 'description' => 'None Type Attribute Position',
                 'default' => 'on_thumbnail',
                      'condition' => [
                            'action_style' => '6',
                      ],
                      'separator' => 'after',
                 ]
              );

           
           $this->add_control(
            'action_button_position',
               [
                   'label'   => esc_html__( 'Action Button Position', 'shopbuild' ),
                   'type' => \Elementor\Controls_Manager::SELECT,
                   'options' => [
                       'left'  => esc_html__( 'Left', 'shopbuild' ),
                       'right'  => esc_html__( 'Right', 'shopbuild' ),
                       'top'  => esc_html__( 'Top', 'shopbuild' ),
                       'bottom'  => esc_html__( 'Bottom', 'shopbuild' ),
                   ],
                   'default' => 'left',
               ]
           );
           
           $this->add_control(
            'tootltip_position',
               [
                   'label'   => esc_html__( 'Tooltip Position', 'shopbuild' ),
                   'type' => \Elementor\Controls_Manager::SELECT,
                   'options' => [
                       'left'  => esc_html__( 'Left', 'shopbuild' ),
                       'right'  => esc_html__( 'Right', 'shopbuild' ),
                       'top'  => esc_html__( 'Top', 'shopbuild' ),
                       'bottom'  => esc_html__( 'Bottom', 'shopbuild' ),
                   ],
                   'default' => 'right',
               ]
           );
           
           $this->add_control(
            'sale_badge_position',
               [
                   'label'   => esc_html__( 'Sale Badge Position', 'shopbuild' ),
                   'type' => \Elementor\Controls_Manager::SELECT,
                   'options' => [
                       'default_positon'  => esc_html__( 'Default', 'shopbuild' ),
                       'left_top'  => esc_html__( 'Left Top', 'shopbuild' ),
                       'left_bottom'  => esc_html__( 'Left Bottom', 'shopbuild' ),
                       'right_top'  => esc_html__( 'Right Top', 'shopbuild' ),
                       'right_bottom'  => esc_html__( 'Right Bottom', 'shopbuild' ),
                   ],
                   'default' => 'default_positon',
               ]
           );
   
           
           $this->end_controls_section();
   
           $this->start_controls_section(
            'product_action_switch_sec',
                [
                  'label' => esc_html__( 'Product Action Button', 'shopbuild' ),
                  'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
           );
           
           $this->add_control(
            'pure_wc_tooltip_switch',
            [
              'label'        => esc_html__( 'Enable Tooltip?', 'shopbuild' ),
              'type'         => \Elementor\Controls_Manager::SWITCHER,
              'label_on'     => esc_html__( 'Show', 'shopbuild' ),
              'label_off'    => esc_html__( 'Hide', 'shopbuild' ),
              'return_value' => 'yes',
              'default'      => 'yes',
            ]
           );
           
           $this->add_control(
            'pure_wc_quick_view_switch',
            [
              'label'        => esc_html__( 'Enable Quick View?', 'shopbuild' ),
              'type'         => \Elementor\Controls_Manager::SWITCHER,
              'label_on'     => esc_html__( 'Show', 'shopbuild' ),
              'label_off'    => esc_html__( 'Hide', 'shopbuild' ),
              'return_value' => 'yes',
              'default'      => 'yes',
            ]
           );
           
           $this->add_control(
            'pure_wc_wishlist_switch',
            [
              'label'        => esc_html__( 'Enable Wishlist?', 'shopbuild' ),
              'type'         => \Elementor\Controls_Manager::SWITCHER,
              'label_on'     => esc_html__( 'Show', 'shopbuild' ),
              'label_off'    => esc_html__( 'Hide', 'shopbuild' ),
              'return_value' => 'yes',
              'default'      => 'yes',
            ]
           );
           
           $this->add_control(
            'pure_wc_compare_switch',
               [
                   'label'        => esc_html__( 'Enable Compare?', 'shopbuild' ),
                   'type'         => \Elementor\Controls_Manager::SWITCHER,
                   'label_on'     => esc_html__( 'Show', 'shopbuild' ),
                   'label_off'    => esc_html__( 'Hide', 'shopbuild' ),
                   'return_value' => 'yes',
                   'default'      => 'yes',
               ]
           );
           
           if($enableTitleWordCount){
            $this->add_control(
                'pure_wc_trim_title_word',
                [
                    'label' => esc_html__('Title Word Count', 'shopbuild'),
                    'description' => esc_html__('Set how many word you want to display!', 'shopbuild'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 6,
                ]
            );
           }
           
           $this->end_controls_section();
    }

    protected function pure_wc_get_border_controls($control_id = null, $control_name = 'Border', $control_selector = '.pure-my-border'){

        $this->add_control(
            'pure_wc_' . $control_id . '_btn_normal_border_style',
            [
                'label' => esc_html__('Border Type', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'shopbuild'),
                    'none' => esc_html__('None', 'shopbuild'),
                    'solid' => esc_html__('Solid', 'shopbuild'),
                    'double' => esc_html__('Double', 'shopbuild'),
                    'dotted' => esc_html__('Dotted', 'shopbuild'),
                    'dashed' => esc_html__('Dashed', 'shopbuild'),
                    'groove' => esc_html__('Groove', 'shopbuild'),
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector . '' => 'border-style: {{VALUE}}  ;',
                ],
            ]
        );

        $this->add_responsive_control(
            'pure_wc_' . $control_id . '_btn_normal_border_width',
            [
                'label' => esc_html__('Border Width', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}  ;',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'pure_wc_' . $control_id . '_btn_normal_border_color',
            [
                'label' => esc_html__('Border Color', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector . '' => 'border-color: {{VALUE}}  ;;',
                ],
            ]

        );


        $this->add_control(
            'pure_wc_' . $control_id . '_btn_border_radius',
            [
                'label' => esc_html__('Border Radius', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector . '' => 'border-radius: {{SIZE}}px;',
                ],
            ]
        );
    }

    protected function pure_wc_product_feature_options($settings){
        $contents_style = array(
			"pure_wc_trim_title_word" => !empty($settings['pure_wc_trim_title_word']) ? $settings['pure_wc_trim_title_word'] : 6,
			"product_style" => $settings['product_style'],
			"product_content_align" => $settings['product_content_align'],
			"product_rating_switch" => $settings['product_rating_switch'],
			"review_text_switch" => $settings['review_text_switch'],
			"action_style" => $settings['action_style'],
			"tootltip_position" => $settings['tootltip_position'],
			"action_button_position" => $settings['action_button_position'],
			"sale_badge_position" => $settings['sale_badge_position'],
			"pure_wc_tooltip_switch" => $settings['pure_wc_tooltip_switch'],
			"pure_wc_quick_view_switch" => $settings['pure_wc_quick_view_switch'],
			"pure_wc_wishlist_switch" => $settings['pure_wc_wishlist_switch'],
			"pure_wc_compare_switch" => $settings['pure_wc_compare_switch'],
			"select_type_attribute_position" => $settings['select_type_attribute_position'],
			"color_type_attribute_position" => $settings['color_type_attribute_position'],
			"image_type_attribute_position" => $settings['image_type_attribute_position'],
			"none_type_attribute_position" => $settings['none_type_attribute_position'],
            "action_type" => $settings['action_type'],
            'pure_slider_arrow' => array_key_exists('pure_slider_arrow', $settings) ?? '',
            'pure_slider_arrow_prev_icon' => array_key_exists('pure_slider_arrow_prev_icon', $settings) ?? '',
            'pure_slider_arrow_next_icon' => array_key_exists('pure_slider_arrow_next_icon', $settings) ?? '',
            'pure_slider_dots' => array_key_exists('pure_slider_dots', $settings) ?? '',
            'pure_slider_autoplay' => array_key_exists('pure_slider_autoplay', $settings) ?? '',
            'pure_slider_autoplay_speed' => array_key_exists('pure_slider_autoplay_speed', $settings) ?? '',
            'pure_slider_infinite' => array_key_exists('pure_slider_infinite', $settings) ?? '',
            'pure_slider_speed' => array_key_exists('pure_slider_speed', $settings) ?? '',
            'pure_slider_slides_to_show' => array_key_exists('pure_slider_slides_to_show', $settings) ?? '',
            'pure_slider_slides_to_scroll' => array_key_exists('pure_slider_slides_to_scroll', $settings) ?? '',
            'pure_slider_center_mode' => array_key_exists('pure_slider_center_mode', $settings) ?? '',
            'pure_slider_center_padding' => array_key_exists('pure_slider_center_padding', $settings) ?? '',
            'pure_slider_pause_on_hover' => array_key_exists('pure_slider_pause_on_hover', $settings) ?? '',
            'pure_slider_rtl' => array_key_exists('pure_slider_rtl', $settings) ?? '',
            'pure_slider_fade' => array_key_exists('pure_slider_fade', $settings) ?? '',
            'pure_slider_gap' => array_key_exists('pure_slider_gap', $settings) ?? '',
            'pure_archive_columns' => isset($settings['pure_archive_columns'])? $settings['pure_archive_columns'] : '1',

		);

        return apply_filters('pure_wc_product_feature_options', $contents_style);
    }

    protected function pure_wc_product_card_style(){
        
    }
}