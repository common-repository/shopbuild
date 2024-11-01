<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use PureWCShopbuild\Elementor\Controls\Group_Control_PWCSGradient;
use PureWCShopbuild\Admin\Pure_Wc_Shopuild_Admin;
use TPCore\Widgets\TP_Column_Trait;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor button widget.
 *
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.3
 */
class Pure_Coupon extends Pure_Wc_Base_Widget {

	use PureWCCommonStyles;

	/**
	 * Get widget name.
	 *
	 * Retrieve button widget name.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'pure-coupon';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve button widget title.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Shopbuild Coupon', 'shopbuild' );
	}


	protected function register_controls() {

		$this->register_content_controls();
        $this->register_style_controls();

	}


    protected function register_content_controls(){

        $this->start_controls_section(
            'pure_wc_sec',
                [
                  'label' => esc_html__( 'Coupon Layout', 'shopbuild' ),
                  'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
           );
           
           $this->add_control(
            'pure_wc_layout',
            [
              'label'   => esc_html__( 'Select Layout', 'shopbuild' ),
              'type' => \Elementor\Controls_Manager::SELECT,
              'options' => [
                'layout-1'  => esc_html__( 'Default', 'shopbuild' ),
              ],
              'default' => 'layout-1',
            ]
           );
   
    
           $this->end_controls_section();


           $this->start_controls_section(
            'pure_wc_coupon_query',
                [
                  'label' => esc_html__( 'Coupon Query', 'shopbuild' ),
                  'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
           );
           
           $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__('Show Items Number', 'shopbuild'),
                'description' => esc_html__('How many items you wnat to show .Leave blank or enter -1 for all.', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => -1,
            ]
        );

           $this->add_control(
            'post_include',
            [
                'label' => esc_html__('Include Item', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => pure_wc_get_all_types_post('shop_coupon'),
                'multiple' => true,
                'label_block' => true
            ]
        );

        $this->add_control(
            'post__not_in',
            [
                'label' => esc_html__('Exclude Item', 'shopbuild'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => pure_wc_get_all_types_post('shop_coupon'),
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
                'default' => 'title',

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
                'default' => 'asc',

            ]
        );

        $this->add_control(
         'pure_wc_coupon_hide',
         [
           'label'        => esc_html__( 'Hide Expire Coupons?', 'shopbuild' ),
           'type'         => \Elementor\Controls_Manager::SWITCHER,
           'label_on'     => esc_html__( 'Show', 'shopbuild' ),
           'label_off'    => esc_html__( 'Hide', 'shopbuild' ),
           'return_value' => 'yes',
           'default'      => 'no',
         ]
        );
           
        $this->add_control(
        'pure_wc_coupon_offer_text',
         [
            'label'       => esc_html__( 'Offer Text', 'shopbuild' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => esc_html__( 'Off', 'shopbuild' ),
            'placeholder' => esc_html__( 'Your Text', 'shopbuild' ),
         ]
        );
           
        $this->add_control(
         'pure_wc_coupon_symbol_position',
         [
           'label'   => esc_html__( 'Symbol Position', 'shopbuild' ),
           'type' => \Elementor\Controls_Manager::SELECT,
           'options' => [
             'left'  => esc_html__( 'Left', 'shopbuild' ),
             'right'  => esc_html__( 'Right', 'shopbuild' ),
           ],
           'default' => 'left',
         ]
        );
           
        $this->add_control(
         'pure_wc_coupon_percent_symbol_position',
         [
           'label'   => esc_html__( 'Percent Symbol Position', 'shopbuild' ),
           'type' => \Elementor\Controls_Manager::SELECT,
           'options' => [
             'left'  => esc_html__( 'Left', 'shopbuild' ),
             'right'  => esc_html__( 'Right', 'shopbuild' ),
           ],
           'default' => 'right',
         ]
        );

        $this->add_control(
        'pure_wc_coupon_status_label',
         [
            'label'       => esc_html__( 'Status Label', 'shopbuild' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => esc_html__( 'Coupon: ', 'shopbuild' ),
            'placeholder' => esc_html__( 'Your Text', 'shopbuild' ),
            'label_block' => true,
         ]
        );

        $this->add_control(
        'pure_wc_coupon_status_active_text',
         [
            'label'       => esc_html__( 'Active Text', 'shopbuild' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => esc_html__( 'Active', 'shopbuild' ),
            'placeholder' => esc_html__( 'Your Text', 'shopbuild' ),
            'label_block' => true,
         ]
        );

        $this->add_control(
         'pure_wc_coupon_status_expired_text',
         [
           'label'       => esc_html__( 'Expired Text', 'shopbuild' ),
           'type'        => \Elementor\Controls_Manager::TEXT,
           'default'     => esc_html__( 'Expired', 'shopbuild' ),
           'placeholder' => esc_html__( 'Your Text', 'shopbuild' ),
           'label_block' => true,
         ]
        );
        $this->end_controls_section();

        $this->pure_wc_columns('coupon_col');
	}

    protected function register_style_controls(){

        $this->start_controls_section(
         'pure_wc_coupon_style_title_sec',
             [
               'label' => esc_html__( 'Box Style', 'shopbuild' ),
               'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
             ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
               'name'     => 'pure_wc_coupon_style_bg',
               'label'   => esc_html__( 'Box Background', 'shopbuild' ),
               'types'    => [ 'classic', 'gradient' ],
               'selector' => '{{WRAPPER}} .sb-el-coupon-box',
            ]
          );

          $this->add_group_control(
           \Elementor\Group_Control_Border::get_type(),
           [
             'name'     => 'pure_wc_coupon_style_border',
             'label'    => esc_html__( 'Box Border', 'shopbuild' ),
             'selector' => '{{WRAPPER}} .sb-el-coupon-box',
           ]
          );
        
        $this->end_controls_section();

        $this->start_controls_section(
         'pure_wc_coupon_style_thumb_sec',
             [
               'label' => esc_html__( 'Thumbnail Style', 'shopbuild' ),
               'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
             ]
        );
        
        $this->add_control(
                'pure_wc_coupon_style_thumb_width',
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
                        'unit' => '%',
                        'size' => 50,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sb-el-coupon-thumbnail img' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
        
        $this->add_control(
                'pure_wc_coupon_style_thumb_height',
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
                        'unit' => '%',
                        'size' => 50,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sb-el-coupon-thumbnail img' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
        
        $this->end_controls_section();

        $this->start_controls_section(
         'pure_wc_coupon_style_cut_sec',
             [
               'label' => esc_html__( 'Cutout Style', 'shopbuild' ),
               'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
             ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
              'name'     => 'pure_wc_coupon_style_cut_border',
              'label'    => esc_html__( 'Cut Border', 'shopbuild' ),
              'selector' => '{{WRAPPER}} .sb-el-coupon-cut',
            ]
           );

           $this->add_responsive_control(
                'pure_wc_coupon_style_cut_position',
                [
                    'label' => esc_html__( 'Cut Position', 'shopbuild' ),
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
                        'size' => 35,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sb-el-coupon-cut' => 'right: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

           $this->add_responsive_control(
            'pure_wc_coupon_style_cut_width',
            [
              'label'   => esc_html__( 'Cut Width', 'shopbuild' ),
              'type'    => \Elementor\Controls_Manager::NUMBER,
              'min'     => 0,
              'max'     => 100,
              'step'    => 2,
              'default' => 24,
                'selectors' => [
                    '{{WRAPPER}} .sb-el-coupon-cut::after' => 'width: {{VALUE}}px',
                    '{{WRAPPER}} .sb-el-coupon-cut::before' => 'width: {{VALUE}}px',
                ],
            ]
           );

           $this->add_control(
            'pure_wc_coupon_style_cut_height',
            [
              'label'   => esc_html__( 'Cut Height', 'shopbuild' ),
              'type'    => \Elementor\Controls_Manager::NUMBER,
              'min'     => 0,
              'max'     => 100,
              'step'    => 2,
              'default' => 24,
                'selectors' => [
                    '{{WRAPPER}} .sb-el-coupon-cut::after' => 'height: {{VALUE}}px',
                    '{{WRAPPER}} .sb-el-coupon-cut::before' => 'height: {{VALUE}}px',
                ],
            ]
           );

           $this->add_control(
            'pure_wc_coupon_style_cut_top',
            [
                'label' => esc_html__( 'Top Cut', 'shopbuild' ),
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
                    'size' => -13,
                ],
                'selectors' => [
                    '{{WRAPPER}} .sb-el-coupon-cut::before' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
            );

           $this->add_responsive_control(
            'pure_wc_coupon_style_cut_bottom',
            [
                'label' => esc_html__( 'Bottom Cut', 'shopbuild' ),
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
                    'size' => -13,
                ],
                'selectors' => [
                    '{{WRAPPER}} .sb-el-coupon-cut::after' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
            );

            $this->add_control(
             'pure_wc_coupon_style_cut_bg',
             [
               'label'       => esc_html__( 'Cut Background', 'shopbuild' ),
               'type'     => \Elementor\Controls_Manager::COLOR,
               'selectors' => [
               '{{WRAPPER}} .sb-el-coupon-cut::after' => 'background: {{VALUE}}',
                '{{WRAPPER}} .sb-el-coupon-cut::before' => 'background: {{VALUE}}',
               ],
             ]
            );

            $this->add_control(
             'pure_wc_coupon_style_cut_bg_border',
             [
               'label'       => esc_html__( 'Cut Border Color', 'shopbuild' ),
               'type'     => \Elementor\Controls_Manager::COLOR,
               'selectors' => [
               '{{WRAPPER}} .sb-el-coupon-cut::after' => 'border-color: {{VALUE}}',
                '{{WRAPPER}} .sb-el-coupon-cut::before' => 'border-color: {{VALUE}}',
               ],
             ]
            );


            $this->add_control(
                    'pure_wc_coupon_style_cut_bg_border_width',
                    [
                        'label' => esc_html__( 'Cut Border Width', 'shopbuild' ),
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
                            'size' => 1,
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .sb-el-coupon-cut::after' => 'border-width: {{SIZE}}{{UNIT}};',
                            '{{WRAPPER}} .sb-el-coupon-cut::before' => 'border-width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

           
        
        $this->end_controls_section();

        $this->start_controls_section(
            'pure_wc_coupon_style',
            [
                'label' => esc_html__('Title Style', 'shopbuild'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


            $this->add_control(
             'pure_wc_coupon_style_title_color',
             [
               'label'       => esc_html__( 'Color', 'shopbuild' ),
               'type'     => \Elementor\Controls_Manager::COLOR,
               'selectors' => [
               '{{WRAPPER}} .sb-el-coupon-title' => 'color: {{VALUE}}',
               ],
             ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                  'name' => 'pure_wc_coupon_style_title_typo',
                  'label'   => esc_html__( 'Typography', 'shopbuild' ),
                  'selector' => '{{WRAPPER}} .sb-el-coupon-title',
                ]
            );

            $this->add_responsive_control(
             'pure_wc_coupon_style_title_margin',
               [
                 'label'      => esc_html__( 'Margin', 'shopbuild' ),
                 'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                 'size_units' => [ 'px', '%', 'em' ],
                 'selectors'  => [
                   '{{WRAPPER}} .sb-el-coupon-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ],
               ]
             );


        $this->end_controls_section();

        $this->start_controls_section(
         'pure_wc_coupon_style_offer_text_sec',
             [
               'label' => esc_html__( 'Offer Style', 'shopbuild' ),
               'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
             ]
        );
        
        $this->add_control(
            'pure_wc_coupon_style_ammout_color',
            [
              'label'       => esc_html__( 'Ammout Color', 'shopbuild' ),
              'type'     => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
              '{{WRAPPER}} .sb-el-coupon-offer span' => 'color: {{VALUE}}',
              ],
            ]
           );
           $this->add_control(
            'pure_wc_coupon_style_offer_color',
            [
              'label'       => esc_html__( 'Text Color', 'shopbuild' ),
              'type'     => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
              '{{WRAPPER}} .sb-el-coupon-offer' => 'color: {{VALUE}}',
              ],
            ]
           );

           $this->add_group_control(
               \Elementor\Group_Control_Typography::get_type(),
               [
                 'name' => 'pure_wc_coupon_style_offer_typo',
                 'label'   => esc_html__( 'Typography', 'shopbuild' ),
                 'selector' => '{{WRAPPER}} .sb-el-coupon-offer',
               ]
             );
        
        $this->end_controls_section();

        $this->start_controls_section(
            'pure_wc_coupon_style_countdown_sec',
            [
                'label' => esc_html__('Countdown Style', 'shopbuild'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'pure_wc_coupon_style_countdown_time_color',
            [
              'label'       => esc_html__( 'Time Color', 'shopbuild' ),
              'type'     => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
              '{{WRAPPER}} .sb-el-coupon-countdown ul li span' => 'color: {{VALUE}}',
              ],
            ]
           );

           $this->add_group_control(
               \Elementor\Group_Control_Typography::get_type(),
               [
                 'name' => 'pure_wc_coupon_style_countdown_time_typo',
                 'label'   => esc_html__( 'Time Typography', 'shopbuild' ),
                 'selector' => '{{WRAPPER}} .sb-el-coupon-countdown ul li span',
               ]
             );

           $this->add_control(
            'pure_wc_coupon_style_countdown_text_color',
            [
              'label'       => esc_html__( 'Label Color', 'shopbuild' ),
              'type'     => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
              '{{WRAPPER}} .sb-el-coupon-countdown ul li' => 'color: {{VALUE}}',
              ],
            ]
           );

           $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
              'name' => 'pure_wc_coupon_style_countdown_text_typo',
              'label'   => esc_html__( 'Label Typography', 'shopbuild' ),
              'selector' => '{{WRAPPER}} .sb-el-coupon-countdown ul li',
            ]
          );

          $this->add_control(
           'pure_wc_coupon_style_countdown_line_color',
           [
             'label'       => esc_html__( 'Line Color', 'shopbuild' ),
             'type'     => \Elementor\Controls_Manager::COLOR,
             'selectors' => [
             '{{WRAPPER}} .sb-el-coupon-countdown ul li:not(:last-child)::after' => 'background-color: {{VALUE}}',
             ],
           ]
          );

          $this->add_control(
                'pure_wc_coupon_style_countdown_line_height',
                [
                    'label' => esc_html__( 'Line Height', 'shopbuild' ),
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
                        'size' => 17,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sb-el-coupon-countdown ul li:not(:last-child)::after' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
         'pure_wc_coupon_style_status_sec',
             [
               'label' => esc_html__( 'Status Style', 'shopbuild' ),
               'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
             ]
        );

        $this->add_control(
            'pure_wc_coupon_style_status_label_color',
            [
              'label'       => esc_html__( 'Label Color', 'shopbuild' ),
              'type'     => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
              '{{WRAPPER}} .sb-el-coupon-status h4' => 'color: {{VALUE}}',
              ],
            ]
           );

           $this->add_group_control(
               \Elementor\Group_Control_Typography::get_type(),
               [
                 'name' => 'pure_wc_coupon_style_status_label_typo',
                 'label'   => esc_html__( 'Label Typography', 'shopbuild' ),
                 'selector' => '{{WRAPPER}} .sb-el-coupon-status h4',
               ]
             );


        
        $this->add_control(
            'pure_wc_coupon_style_status_active_color',
            [
              'label'       => esc_html__( 'Active Color', 'shopbuild' ),
              'type'     => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
              '{{WRAPPER}} .sb-el-coupon-status span.active' => 'color: {{VALUE}}',
              ],
            ]
           );

           $this->add_group_control(
               \Elementor\Group_Control_Typography::get_type(),
               [
                 'name' => 'pure_wc_coupon_style_status_active_typo',
                 'label'   => esc_html__( 'Active Typography', 'shopbuild' ),
                 'selector' => '{{WRAPPER}} .sb-el-coupon-status span.active',
               ]
             );

           $this->add_control(
            'pure_wc_coupon_style_status_expired_color',
            [
              'label'       => esc_html__( 'Expired Color', 'shopbuild' ),
              'type'     => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
              '{{WRAPPER}} .sb-el-coupon-status span.expired' => 'color: {{VALUE}}',
              ],
            ]
           );

           $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
              'name' => 'pure_wc_coupon_style_status_expired_typo',
              'label'   => esc_html__( 'Expired Typography', 'shopbuild' ),
              'selector' => '{{WRAPPER}} .sb-el-coupon-status span.expired',
            ]
          );
        
        
        $this->end_controls_section();


        $this->start_controls_section(
         'pure_wc_coupon_style_toooltip_sec',
             [
               'label' => esc_html__( 'Tooltip Style', 'shopbuild' ),
               'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
             ]
        );


         $this->add_control(
          'pure_wc_coupon_style_toooltip_bg',
          [
            'label'       => esc_html__( 'Background', 'shopbuild' ),
            'type'     => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .sb-el-coupon-tooltip' => 'background-color: {{VALUE}}',
                '{{WRAPPER}} .sb-el-coupon-tooltip::after' => 'background-color: {{VALUE}}',
            ],
          ]
         );

         $this->add_control(
          'pure_wc_coupon_style_toooltip_color',
          [
            'label'       => esc_html__( 'Text', 'shopbuild' ),
            'type'     => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .sb-el-coupon-tooltip p' => 'color: {{VALUE}}',
            ],
          ]
         );

         $this->add_group_control(
             \Elementor\Group_Control_Typography::get_type(),
             [
               'name' => 'pure_wc_coupon_style_toooltip_typo',
               'label'   => esc_html__( 'Text Typography', 'shopbuild' ),
               'selector' => '{{WRAPPER}} .sb-el-coupon-tooltip p',
             ]
           );
        
        $this->add_responsive_control(
         'pure_wc_coupon_style_toooltip_padding',
           [
             'label'      => esc_html__( 'Padding', 'shopbuild' ),
             'type'       => \Elementor\Controls_Manager::DIMENSIONS,
             'size_units' => [ 'px', '%', 'em' ],
             'selectors'  => [
               '{{WRAPPER}} .sb-el-coupon-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
             ],
           ]
         );
        
        $this->end_controls_section();

        $this->start_controls_section(
         'pure_wc_coupon_style_code',
             [
               'label' => esc_html__( 'Code Style', 'shopbuild' ),
               'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
             ]
        );
        
        $this->add_control(
         'pure_wc_coupon_style_code_color',
         [
           'label'       => esc_html__( 'Text', 'shopbuild' ),
           'type'     => \Elementor\Controls_Manager::COLOR,
           'selectors' => [
           '{{WRAPPER}} .sb-el-coupon-code span' => 'color: {{VALUE}}',
           ],
         ]
        );

        $this->add_group_control(
           \Elementor\Group_Control_Background::get_type(),
           [
              'name'     => 'pure_wc_coupon_style_code_bg',
              'label'   => esc_html__( 'Background', 'shopbuild' ),
              'types'    => [ 'classic', 'gradient' ],
              'selector' => '{{WRAPPER}} .sb-el-coupon-code span',
           ]
         );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
              'name' => 'pure_wc_coupon_style_code_typo',
              'label'   => esc_html__( 'Typography', 'shopbuild' ),
              'selector' => '{{WRAPPER}} .sb-el-coupon-code span',
            ]
        );

        $this->add_group_control(
         \Elementor\Group_Control_Border::get_type(),
         [
           'name'     => 'pure_wc_coupon_style_code_border',
           'label'    => esc_html__( 'label', 'shopbuild' ),
           'selector' => '{{WRAPPER}} .sb-el-coupon-code span',
         ]
        );

        $this->add_responsive_control(
         'pure_wc_coupon_style_code_margin',
           [
             'label'      => esc_html__( 'Margin', 'shopbuild' ),
             'type'       => \Elementor\Controls_Manager::DIMENSIONS,
             'size_units' => [ 'px', '%', 'em' ],
             'selectors'  => [
               '{{WRAPPER}} .sb-el-coupon-code span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
             ],
           ]
         );

         $this->add_responsive_control(
          'pure_wc_coupon_style_code_padding',
            [
              'label'      => esc_html__( 'Padding', 'shopbuild' ),
              'type'       => \Elementor\Controls_Manager::DIMENSIONS,
              'size_units' => [ 'px', '%', 'em' ],
              'selectors'  => [
                '{{WRAPPER}} .sb-el-coupon-code span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
              ],
            ]
          );
        
        $this->end_controls_section();

    }
	/**
	 * Render button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.3
	 * @access protected
	 */
	protected function render() {
		
		$settings = $this->get_settings_for_display();

        $coupon = new WC_Coupon();

        $args = array(
            'posts_per_page'   =>  !empty($settings['posts_per_page']) ? $settings['posts_per_page'] : -1,
            'orderby'          => !empty($settings['orderby']) ? $settings['orderby'] : 'title',
            'order'            => !empty($settings['order']) ? $settings['order'] : 'asc',
            'post__in'         => !empty($settings['post_include']) ? $settings['post_include'] : '',
            'post__not_in'     => !empty($settings['post__not_in']) ? $settings['post__not_in'] : '',
            'post_type'        => 'shop_coupon',
            'post_status'      => 'publish',
        );
    
        $coupons = get_posts( $args );



        if($settings['pure_wc_layout'] == 'layout-2') : 


        ?>

        <?php else: 

        ?>

        <div class="sb-row <?php echo esc_attr($this->pure_row_cols_show($settings, 'coupon_col')); ?>">

        <?php if(!empty($coupons)) : ?>
            <?php foreach($coupons as $coupon) : 
                $coupon_details = new WC_Coupon($coupon->post_title);
                $title = $coupon->post_title;
                $ammount = $coupon_details->get_amount();
                $type = $coupon_details->get_discount_type();
                $img = wp_get_attachment_image_url($coupon_details->get_meta_data()[0]->get_data()['value'], 'full');
                $expDate = $coupon_details->get_date_expires() == null ? '' : $coupon_details->get_date_expires() ;
                
                $date = gmdate("M d Y h:m:i",  strtotime($expDate));
                $currencySymbol = get_woocommerce_currency_symbol();
                $desc = $coupon_details->get_description();
                $code = $coupon_details->get_code();


                $uploaded_date = new DateTime($date);
                $current_time = new DateTime(gmdate('y-m-d'));

                $date_diff = $current_time < $uploaded_date;

                $symbol_positon = $settings['pure_wc_coupon_symbol_position'];

                if($settings['pure_wc_coupon_hide'] == 'yes' && !$date_diff){
                    continue;
                }

            ?>
            <div class="sb-col">
                <div class="sb-coupon-item mb-30 sb-d-md-flex  sb-justify-content-between sb-align-items-center sb-el-coupon-box">
                    <span class="sb-coupon-border sb-el-coupon-cut"></span>
                    <div class="sb-coupon-item-left sb-d-sm-flex sb-align-items-center">

                        <?php if(!empty($img)): ?>
                        <div class="sb-coupon-thumb">
                            <img alt="coupon-thumbnail" src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($title); ?>">
                        </div>
                        <?php endif; ?>

                        <div class="sb-coupon-content">

                            <?php if(!empty($title)): ?>
                            <h3 class="sb-coupon-title sb-el-coupon-title"><?php echo esc_html($title); ?></h3>
                            <?php endif; ?>

                            <?php if($type === 'percent'): ?>
                                <p class="sb-coupon-offer mb-15 sb-el-coupon-offer">
                                    <span>
                                        <?php
                                            if($settings['pure_wc_coupon_percent_symbol_position'] == 'left') {
                                                echo esc_html__('%', 'shopbuild') . esc_html($ammount);
                                            }
                                            else{
                                                echo esc_html($ammount) . esc_html__('%', 'shopbuild');
                                            }
                                        
                                        ?>
                                    </span>
                                        <?php echo esc_html($settings['pure_wc_coupon_offer_text']); ?>
                                </p>
                            <?php else: ?>
                                <p class="sb-coupon-offer mb-15 sb-el-coupon-offer">
                                    <span>
                                        <?php if($symbol_positon == 'left') {
                                            echo esc_html($currencySymbol) . esc_html($ammount);
                                        }
                                         else{
                                            echo esc_html($ammount) . esc_html($currencySymbol);
                                        } ?>
                                    </span>

                                    <?php echo esc_html($settings['pure_wc_coupon_offer_text']); ?>
                                </p>
                            <?php endif; ?>
                            <div class="sb-coupon-countdown" data-countdown="" data-date="<?php echo esc_attr($date); ?>">
                                <div class="sb-coupon-countdown-inner sb-el-coupon-countdown">
                                    <ul>
                                        <li><span data-days><?php echo esc_html__('0', 'shopbuild'); ?></span><?php echo esc_html__('Days', 'shopbuild'); ?></li>
                                        <li><span data-hours><?php echo esc_html__('0', 'shopbuild'); ?></span><?php echo esc_html__('Hrs', 'shopbuild'); ?></li>
                                        <li><span data-minutes><?php echo esc_html__('0', 'shopbuild'); ?></span><?php echo esc_html__('Min', 'shopbuild'); ?></li>
                                        <li><span data-seconds><?php echo esc_html__('0', 'shopbuild'); ?></span><?php echo esc_html__('Sec', 'shopbuild'); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sb-coupon-item-right">
                        <div class="sb-coupon-status mb-10 sb-d-flex sb-align-items-center sb-el-coupon-status">
                            <?php
                                $status_class = $date_diff ? 'active' : 'expired';
                                $status_text = $date_diff ? $settings['pure_wc_coupon_status_active_text'] : $settings['pure_wc_coupon_status_expired_text'];
                            ?>
                            <h4>
                                <?php echo wp_kses($settings['pure_wc_coupon_status_label'], pure_wc_get_kses_extended_ruleset()); ?>
                                <span class="<?php echo esc_attr($status_class); ?>">
                                    <?php echo wp_kses($status_text, pure_wc_get_kses_extended_ruleset()); ?>
                                </span>
                            </h4>
                            
                            <?php if(!empty($desc)): ?>
                            <div class="sb-coupon-info-details">
                                <span>
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9 1.5C4.99594 1.5 1.75 4.74594 1.75 8.75C1.75 12.7541 4.99594 16 9 16C13.0041 16 16.25 12.7541 16.25 8.75C16.25 4.74594 13.0041 1.5 9 1.5ZM0.25 8.75C0.25 3.91751 4.16751 0 9 0C13.8325 0 17.75 3.91751 17.75 8.75C17.75 13.5825 13.8325 17.5 9 17.5C4.16751 17.5 0.25 13.5825 0.25 8.75ZM9 7.75C9.55229 7.75 10 8.19771 10 8.75V11.95C10 12.5023 9.55229 12.95 9 12.95C8.44771 12.95 8 12.5023 8 11.95V8.75C8 8.19771 8.44771 7.75 9 7.75ZM9 4.5498C8.44771 4.5498 8 4.99752 8 5.5498C8 6.10209 8.44771 6.5498 9 6.5498H9.008C9.56028 6.5498 10.008 6.10209 10.008 5.5498C10.008 4.99752 9.56028 4.5498 9.008 4.5498H9Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                <div class="sb-coupon-info-tooltip sb-el-coupon-tooltip">
                                    <p>
                                        <?php echo wp_kses($desc, pure_wc_get_kses_extended_ruleset()); ?>
                                    </p>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php if(!empty($code)): ?>
                        <div class="sb-coupon-date sb-el-coupon-code">
                            <button type="button" class="sb-copy-btn">
                                <span><?php echo wp_kses($code, pure_wc_get_kses_extended_ruleset()); ?></span>
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <?php else: ?>
            <p class="sb-notification sb-notification-info"><?php echo esc_html__('Please Select A Product', 'shopbuild') ?></p>
            <?php endif; ?>
        </div>

            
        <?php endif; ?>
  
<?php
	}
}

$widgets_manager->register( new Pure_Coupon() );