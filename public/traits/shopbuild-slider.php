<?php


trait PureWCCommonSlider
{
    protected function pure_wc_common_slider($control_id = null, $control_name = 'Slider Controls'){
        
        $this->start_controls_section(
            'pure_'.$control_id.'_slider_controls',
                [
                  'label' => esc_html( $control_name ),
                  'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
           );
           
           $this->add_control(
            'pure_'.$control_id.'_slider_arrow',
            [
              'label'        => esc_html__( 'Arrow', 'shopbuild' ),
              'type'         => \Elementor\Controls_Manager::SWITCHER,
              'label_on'     => esc_html__( 'Show', 'shopbuild' ),
              'label_off'    => esc_html__( 'Hide', 'shopbuild' ),
              'return_value' => 'yes',
              'default'      => 'no',
            ]
           );
   
           $this->add_control(
            'pure_'.$control_id.'_slider_arrow_prev_icon',
            [
              'label'       => esc_html__( 'Arrow Prev Icon', 'shopbuild' ),
              'type'        => \Elementor\Controls_Manager::TEXTAREA,
              'rows'        => 10,
              'default'     => esc_html__( 'Prev', 'shopbuild' ),
              'placeholder' => esc_html__( 'Your Icon', 'shopbuild' ),
              'condition'   => [
                'pure_'.$control_id.'_slider_arrow' => 'yes',
              ],
            ]
           );
   
           $this->add_control(
            'pure_'.$control_id.'_slider_arrow_next_icon',
            [
              'label'       => esc_html__( 'Arrow Next Icon', 'shopbuild' ),
              'type'        => \Elementor\Controls_Manager::TEXTAREA,
              'rows'        => 10,
              'default'     => esc_html__( 'Next', 'shopbuild' ),
              'placeholder' => esc_html__( 'Your Icon', 'shopbuild' ),
              'condition'   => [
                'pure_'.$control_id.'_slider_arrow' => 'yes',
              ],
            ]
           );
   
           $this->add_control(
            'pure_'.$control_id.'_slider_dots',
               [
                   'label'        => esc_html__( 'Enable Dots?', 'shopbuild' ),
                   'type'         => \Elementor\Controls_Manager::SWITCHER,
                   'label_on'     => esc_html__( 'Show', 'shopbuild' ),
                   'label_off'    => esc_html__( 'Hide', 'shopbuild' ),
                   'return_value' => 'yes',
                   'default'      => 'yes',
               ]
           );
           
           $this->add_control(
            'pure_'.$control_id.'_slider_dots_type',
               [
                   'label'   => esc_html__( 'Dots Type', 'shopbuild' ),
                   'type' => \Elementor\Controls_Manager::SELECT,
                   'options' => [
                       'dots'  => esc_html__( 'Dot Style', 'shopbuild' ),
                       'number'  => esc_html__( 'Number Style', 'shopbuild' ),
                       'line' => esc_html__( 'Line Style', 'shopbuild' ),
                       'line_2' => esc_html__( 'Line Style 2', 'shopbuild' ),
                       'capsule' => esc_html__( 'Capsule Style', 'shopbuild' ),
                   ],
                   'default' => 'dots',
                   'condition' => [
                       'pure_'.$control_id.'_slider_dots' => 'yes',
                   ],
               ]
           );
           $this->add_control(
            'pure_'.$control_id.'_slider_dots_align',
            [
              'label'   => esc_html__( 'Dots Alignment', 'shopbuild' ),
              'type'    => \Elementor\Controls_Manager::CHOOSE,
              'options' => [
                'left'   => [
                  'title' => esc_html__( 'Left', 'shopbuild' ),
                  'icon'  => 'eicon-h-align-left',
                ],
                'center' => [
                  'title' => esc_html__( 'Center', 'shopbuild' ),
                  'icon'  => 'eicon-h-align-center',
                ],
                'right'  => [
                  'title' => esc_html__( 'Right', 'shopbuild' ),
                  'icon'  => 'eicon-h-align-right',
                ],
              ],
              'default' => 'center',
              'condition' => [
                   'pure_'.$control_id.'_slider_dots' => 'yes',
               ],
            ]
           );
           
   
           $this->add_control(
            'pure_'.$control_id.'_slider_autoplay',
            [
              'label'        => esc_html__( 'Autoplay', 'shopbuild' ),
              'type'         => \Elementor\Controls_Manager::SWITCHER,
              'label_on'     => esc_html__( 'Yes', 'shopbuild' ),
              'label_off'    => esc_html__( 'No', 'shopbuild' ),
              'return_value' => 'yes',
              'default'      => 'no',
            ]
           );
   
           $this->add_control(
            'pure_'.$control_id.'_slider_autoplay_speed',
            [
              'label'     => esc_html__( 'Autoplay Speed', 'shopbuild' ),
              'type'      => \Elementor\Controls_Manager::NUMBER,
              'min'       => 100,
              'max'       => 10000,
              'step'      => 100,
              'default'   => 5000,
              'condition' => [
                'pure_'.$control_id.'_slider_autoplay' => 'yes',
              ],
            ]
           );
   
           $this->add_control(
            'pure_'.$control_id.'_slider_pause_on_hover',
            [
              'label'        => esc_html__( 'Pause On Hover', 'shopbuild' ),
              'type'         => \Elementor\Controls_Manager::SWITCHER,
              'label_on'     => esc_html__( 'Yes', 'shopbuild' ),
              'label_off'    => esc_html__( 'No', 'shopbuild' ),
              'return_value' => 'yes',
              'default'      => 'no',
              'condition'    => [
                'pure_'.$control_id.'_slider_autoplay' => 'yes',
              ],
            ]
           );
   
           $this->add_control(
            'pure_'.$control_id.'_slider_infinite',
            [
              'label'        => esc_html__( 'Infinite Loop', 'shopbuild' ),
              'type'         => \Elementor\Controls_Manager::SWITCHER,
              'label_on'     => esc_html__( 'Yes', 'shopbuild' ),
              'label_off'    => esc_html__( 'No', 'shopbuild' ),
              'return_value' => 'yes',
              'default'      => 'yes',
            ]
           );
   
   
           $this->add_control(
            'pure_'.$control_id.'_slider_rtl',
            [
              'label'        => esc_html__( 'Enable RTL?', 'shopbuild' ),
              'type'         => \Elementor\Controls_Manager::SWITCHER,
              'label_on'     => esc_html__( 'Show', 'shopbuild' ),
              'label_off'    => esc_html__( 'Hide', 'shopbuild' ),
              'return_value' => 'yes',
              'default'      => 'no',
            ]
           );
   
           $this->add_control(
            'pure_'.$control_id.'_slider_fade',
            [
              'label'        => esc_html__( 'Fade Effect', 'shopbuild' ),
              'type'         => \Elementor\Controls_Manager::SWITCHER,
              'label_on'     => esc_html__( 'Show', 'shopbuild' ),
              'label_off'    => esc_html__( 'Hide', 'shopbuild' ),
              'return_value' => 'yes',
              'default'      => 'no',
            ]
           );
   
           $this->add_control(
            'pure_'.$control_id.'_slider_center_mode',
            [
              'label'        => esc_html__( 'Center Mode', 'shopbuild' ),
              'type'         => \Elementor\Controls_Manager::SWITCHER,
              'label_on'     => esc_html__( 'Show', 'shopbuild' ),
              'label_off'    => esc_html__( 'Hide', 'shopbuild' ),
              'return_value' => 'yes',
              'default'      => 'no',
            ]
           );
   
           $this->add_control(
            'pure_'.$control_id.'_slider_gap',
            [
              'label'   => esc_html__( 'Slider Gap/Spacing', 'shopbuild' ),
              'type'    => \Elementor\Controls_Manager::NUMBER,
              'min'     => 0,
              'max'     => 1000,
              'step'    => 5,
              'default' => 15,
            ]
           );
   
           $this->add_control(
               'pure_'.$control_id.'_slider_speed',
               [
                 'label'     => esc_html__( 'Transition Speed', 'shopbuild' ),
                 'type'      => \Elementor\Controls_Manager::NUMBER,
                 'min'       => 100,
                 'max'       => 10000,
                 'step'      => 100,
                 'default'   => 300,
               ]
              );
   
              $this->add_control(
               'pure_'.$control_id.'_slider_center_padding',
               [
                 'label'   => esc_html__( 'Center Padding', 'shopbuild' ),
                 'type'    => \Elementor\Controls_Manager::NUMBER,
                 'min'     => 0,
                 'max'     => 10000,
                 'step'    => 10,
                 'default' => 0,
                 'separator' => 'after',
               ]
              );
   
              
   
              $this->add_control(
               'pure_'.$control_id.'_slider_slides_to_show',
               [
                 'label'     => esc_html__( 'Slides to Show', 'shopbuild' ),
                 'type'      => \Elementor\Controls_Manager::NUMBER,
                 'description' => 'Set the number of slides to show at a time.',
                 'min'       => 1,
                 'max'       => 100,
                 'step'      => 1,
                 'default'   => 1,
               ]
              );
   
                 
              $this->add_control(
               'pure_'.$control_id.'_slider_slides_to_scroll',
               [
                 'label'     => esc_html__( 'Desktop Slides to Scroll', 'shopbuild' ),
                 'type'      => \Elementor\Controls_Manager::NUMBER,
                 'description' => 'Set the number of slides to scroll at a time.',
                 'min'       => 1,
                 'max'       => 100,
                 'step'      => 1,
                 'default'   => 1,
                 'separator' => 'after',
               ]
              );
   
              $this->add_control(
               $control_id.'_desktop_width',
               [
                 'label'   => esc_html__( 'Desktop Width', 'shopbuild' ),
                 'description' => esc_html__( 'Set the width of the slider for desktop devices.', 'shopbuild' ),
                 'type'    => \Elementor\Controls_Manager::NUMBER,
                 'min'     => 0,
                 'max'     => 10000,
                 'step'    => 100,
                 'default' => 1200,
               ]
              );
      
              $this->add_control(
               $control_id.'_desktop_slides_to_show',
               [
                 'label'     => esc_html__( 'Desktop Slides to Show', 'shopbuild' ),
                 'type'      => \Elementor\Controls_Manager::NUMBER,
                 'min'       => 1,
                 'max'       => 100,
                 'step'      => 1,
                 'default'   => 1,
               ]
              );
      
              $this->add_control(
               $control_id.'_desktop_slides_to_scroll',
               [
                 'label'     => esc_html__( 'Desktop Slides to Scroll', 'shopbuild' ),
                 'type'      => \Elementor\Controls_Manager::NUMBER,
                 'min'       => 1,
                 'max'       => 100,
                 'step'      => 1,
                 'default'   => 1,
               ]
              );
   
   
              $this->add_control(
               $control_id.'_tablet_width',
               [
                 'label'   => esc_html__( 'Tablet Width', 'shopbuild' ),
                 'description' => esc_html__( 'Set the width of the slider for tablet devices.', 'shopbuild' ),
                 'type'    => \Elementor\Controls_Manager::NUMBER,
                 'min'     => 0,
                 'max'     => 10000,
                 'step'    => 100,
                 'default' => 992,
                 'separator' => 'before',
               ]
              );
   
              $this->add_control(
               $control_id.'_tablet_slides_to_show',
               [
                 'label'     => esc_html__( 'Tablet Display Column', 'shopbuild' ),
                 'type'      => \Elementor\Controls_Manager::NUMBER,
                 'min'       => 1,
                 'max'       => 100,
                 'step'      => 1,
                 'default'   => 1,
               ]
              );
   
              $this->add_control(
               $control_id.'_tablet_slides_to_scroll',
               [
                 'label'     => esc_html__( 'Tablet Slides to Scroll', 'shopbuild' ),
                 'type'      => \Elementor\Controls_Manager::NUMBER,
                 'min'       => 1,
                 'max'       => 100,
                 'step'      => 1,
                 'default'   => 1,
               ]
              );
   
              $this->add_control(
               $control_id.'_medium_width',
               [
                 'label'   => esc_html__( 'Medium Width', 'shopbuild' ),
                 'description' => esc_html__( 'Set the width of the slider for medium devices.', 'shopbuild' ),
                 'type'    => \Elementor\Controls_Manager::NUMBER,
                 'min'     => 0,
                 'max'     => 10000,
                 'step'    => 100,
                 'default' => 768,
                 'separator' => 'before',
               ]
              );
   
              $this->add_control(
               $control_id.'_medium_slides_to_show',
               [
                 'label'     => esc_html__( 'Medium Display Column', 'shopbuild' ),
                 'type'      => \Elementor\Controls_Manager::NUMBER,
                 'min'       => 1,
                 'max'       => 100,
                 'step'      => 1,
                 'default'   => 1,
               ]
              );
   
              $this->add_control(
               $control_id.'_medium_slides_to_scroll',
               [
                 'label'     => esc_html__( 'Medium Slides to Scroll', 'shopbuild' ),
                 'type'      => \Elementor\Controls_Manager::NUMBER,
                 'min'       => 1,
                 'max'       => 100,
                 'step'      => 1,
                 'default'   => 1,
               ]
              );
   
              $this->add_control(
               $control_id.'_small_width',
               [
                 'label'   => esc_html__( 'Small Width', 'shopbuild' ),
                 'description' => esc_html__( 'Set the width of the slider for small devices.', 'shopbuild' ),
                 'type'    => \Elementor\Controls_Manager::NUMBER,
                 'min'     => 0,
                 'max'     => 10000,
                 'step'    => 100,
                 'default' => 576,
                 'separator' => 'before',
               ]
              );
   
              $this->add_control(
               $control_id.'_small_slides_to_show',
               [
                 'label'     => esc_html__( 'Small Display Column', 'shopbuild' ),
                 'type'      => \Elementor\Controls_Manager::NUMBER,
                 'min'       => 1,
                 'max'       => 100,
                 'step'      => 1,
                 'default'   => 1,
               ]
              );
   
              $this->add_control(
               $control_id.'_small_slides_to_scroll',
               [
                 'label'     => esc_html__( 'Small Slides to Scroll', 'shopbuild' ),
                 'type'      => \Elementor\Controls_Manager::NUMBER,
                 'min'       => 1,
                 'max'       => 100,
                 'step'      => 1,
                 'default'   => 2,
               ]
              );
   
              $this->add_control(
               $control_id.'_mobile_width',
               [
                 'label'   => esc_html__( 'Mobile Width', 'shopbuild' ),
                 'description' => esc_html__( 'Set the width of the slider for mobile devices.', 'shopbuild' ),
                 'type'    => \Elementor\Controls_Manager::NUMBER,
                 'min'     => 0,
                 'max'     => 10000,
                 'step'    => 100,
                 'default' => 0,
                 'separator' => 'before',
               ]
              );
   
              $this->add_control(
               $control_id.'_mobile_slides_to_show',
               [
                 'label'     => esc_html__( 'Mobile Display Column', 'shopbuild' ),
                 'type'      => \Elementor\Controls_Manager::NUMBER,
                 'min'       => 1,
                 'max'       => 100,
                 'step'      => 1,
                 'default'   => 1,
               ]
              );
   
              $this->add_control(
               $control_id.'_mobile_slides_to_scroll',
               [
                 'label'     => esc_html__( 'Mobile Slides to Scroll', 'shopbuild' ),
                 'type'      => \Elementor\Controls_Manager::NUMBER,
                 'min'       => 1,
                 'max'       => 100,
                 'step'      => 1,
                 'default'   => 1,
               ]
              );
   
           
           $this->end_controls_section();
    }

    protected function pure_wc_common_slider_settings($settings = null, $control_id = null){
        $direction = $settings['pure_'.$control_id.'_slider_rtl'] == 'rtl' ? 'rtl' : 'ltr';

		$slider_settings = [
			'pure_slider_arrow' 			=> 'yes' === $settings['pure_'.$control_id.'_slider_arrow'] ? true : false,
            'pure_slider_arrow_prev_icon'   => $settings['pure_'.$control_id.'_slider_arrow_prev_icon'],
            'pure_slider_arrow_next_icon'   => $settings['pure_'.$control_id.'_slider_arrow_next_icon'],
            'pure_slider_dots' 				=> 'yes' === $settings['pure_'.$control_id.'_slider_dots'] ? true : false,
            'pure_slider_autoplay' 			=> 'yes' === $settings['pure_'.$control_id.'_slider_autoplay'] ? true : false,
            'pure_slider_autoplay_speed' 	=> $settings['pure_'.$control_id.'_slider_autoplay_speed'],
            'pure_slider_infinite' 			=> 'yes' === $settings['pure_'.$control_id.'_slider_infinite'] ? true : false,
            'pure_slider_speed' 			=> $settings['pure_'.$control_id.'_slider_speed'],
            'pure_slider_center_mode'		=> 'yes' === $settings['pure_'.$control_id.'_slider_center_mode'] ? true : false,
            'pure_slider_center_padding' 	=> $settings['pure_'.$control_id.'_slider_center_padding'],
            'pure_slider_pause_on_hover' 	=> 'yes' === $settings['pure_'.$control_id.'_slider_pause_on_hover'] ? true : false,
            'pure_slider_rtl' 				=> 'yes' === $settings['pure_'.$control_id.'_slider_rtl'] ? true : false,
            'pure_slider_fade' 				=> 'yes' === $settings['pure_'.$control_id.'_slider_fade'] ? true : false,
			'pure_slider_gap' 				=> $settings['pure_'.$control_id.'_slider_gap'] ?? '',

			'pure_slider_slides_to_scroll'  => $settings['pure_'.$control_id.'_slider_slides_to_scroll'],
            'pure_slider_slides_to_show'    => $settings['pure_'.$control_id.'_slider_slides_to_show'],

			'desktop_width' 				=> $settings[$control_id.'_desktop_width'],
            'desktop_slides_to_show' 		=> $settings[$control_id.'_desktop_slides_to_show'],
            'desktop_slides_to_scroll' 		=> $settings[$control_id.'_desktop_slides_to_scroll'],
            
			
			'tablet_width' 					=> $settings[$control_id.'_tablet_width'],
            'tablet_slides_to_show' 		=> $settings[$control_id.'_tablet_slides_to_show'],
            'tablet_slides_to_scroll' 		=> $settings[$control_id.'_tablet_slides_to_scroll'],

			'medium_width' 					=> $settings[$control_id.'_medium_width'],
            'medium_slides_to_show' 		=> $settings[$control_id.'_medium_slides_to_show'],
            'medium_slides_to_scroll' 		=> $settings[$control_id.'_medium_slides_to_scroll'],

			'small_width' 					=> $settings[$control_id.'_small_width'],
            'small_slides_to_show' 			=> $settings[$control_id.'_small_slides_to_show'],
            'small_slides_to_scroll' 		=> $settings[$control_id.'_small_slides_to_scroll'],

			'mobile_width' 					=> $settings[$control_id.'_mobile_width'],
            'mobile_slides_to_show' 		=> $settings[$control_id.'_mobile_slides_to_show'],
            'mobile_slides_to_scroll' 		=> $settings[$control_id.'_mobile_slides_to_scroll'],
		];

		
		$dot_style = $settings['pure_'.$control_id.'_slider_dots_type'];
		$dot_alignment = $settings['pure_'.$control_id.'_slider_dots_align'];

		$dot_class = 'pure-slider-dots-type-'.$dot_style.' pure-slider-dots-align-'.$dot_alignment;

        return [
            'slider_settings' => $slider_settings,
            'dot_class' => $dot_class,
            'direction' => $direction
        ];
    }
}
