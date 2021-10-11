<?php
/**
 * Class: Circle_Progress_Bar
 * Name: Circle progress bar
 * Slug: circle-progress-bar
 */

namespace Stratum;

use \Elementor\Controls_Manager;
use \Elementor\Utils;
use \Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Circle_Progress_Bar extends Stratum_Widget_Base {
    protected $widget_name = 'circle-progress-bar';

    public function __construct($data = [], $args = null) {
        parent::__construct( $data, $args );
    }

	public function get_title() {
		return esc_html__( 'Circle Progress Bar', 'stratum' );
	}

    public function get_script_depends() {
        return [ 'donutty', 'waypoints' ];
     }

	public function get_icon() {
		return 'stratum-icon-circle-progress-bar';
	}

	public function get_categories() {
		return [ 'stratum-widgets' ];
    }

    protected function _register_controls() {
        $controls = $this;

        $first_color = !empty(get_option( 'stratum_style' )) ? (!empty(get_option( 'stratum_style' )['primary_color']) ? get_option( 'stratum_style' )['primary_color'] : '') : '#3878ff';

        /*-----------------------------------------------------------------------------------*/
        /*	Content Tab
        /*-----------------------------------------------------------------------------------*/

		$controls->start_controls_section(
			'section_general',
			[
				'label' => esc_html__( 'General', 'stratum' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

        $controls->add_responsive_control(
            'widget_align',
            [
                'label' => esc_html__( 'Alignment', 'stratum' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
                'toggle' => false,
                'prefix_class' => 'stratum-circle-progress-bar-align%s-',
                'options' => [
                    'left'    => [
                        'title' => esc_html__( 'Left', 'stratum' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'stratum' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'stratum' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
            ]
        );

		$controls->add_control(
			'text',
			[
				'label' => esc_html__( 'Text', 'stratum' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your title', 'stratum' ),
				'default' => esc_html__( 'Text', 'stratum' ),
                'label_block' => true,
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'show_percents',
                            'operator' => '!=',
                            'value' => 'yes',
                        ],
                    ],
                ],
			]
        );

		$controls->add_control(
			'show_percents',
			[
				'label' => esc_html__( 'Show percent', 'stratum' ),
				'type'  => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
        );

        $controls->add_responsive_control(
            'widget_width',
            [
				'label' => esc_html__( 'Width', 'stratum' ),
				"description"	=> esc_html__( 'In Pixels (px)', 'stratum' ),
                'type' => Controls_Manager::SLIDER,
                'render_type' => 'ui',
                'default' => [
                    'size' => 150,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .stratum-circle-progress-bar__wrapper' => 'width: {{SIZE}}px',
                ],
            ]
        );

		$controls->add_control(
			'value',
			[
				'label' => esc_html__( 'Progress', 'stratum' ),
				'description'	=> esc_html__( 'In Percent (%)', 'stratum' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => '%' ,
				'render_type' => 'template',
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 75,
                ],
			]
        );

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

            $controls->add_control(
                'round',
                [
                    'label' => esc_html__( 'Round Corners', 'stratum' ),
                    'type'  => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                ]
            );

            $controls->add_control(
                'circle',
                [
                    'label' => esc_html__( 'Circle', 'stratum' ),
                    'type'  => Controls_Manager::SWITCHER,
                    'default' => 'yes'
                ]
            );

            $controls->add_control(
                'padding',
                [
                    'label' => esc_html__( 'Background Padding', 'stratum' ),
                    "description"	=> esc_html__( 'In Pixels (px)', 'stratum' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => '%' ,
                    'render_type' => 'template',
                    'range' => [
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 4,
                    ],
                ]
            );

            $controls->add_control(
                'thickness',
                [
                    'label' => esc_html__( 'Line Thickness', 'stratum' ),
                    "description"	=> esc_html__( 'In Pixels (px)', 'stratum' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => '%' ,
                    'render_type' => 'template',
                    'range' => [
                        '%' => [
                            'min' => 1,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 10,
                    ],
                ]
            );

            $controls->add_group_control(
                Stratum_Group_Control_Typography::get_type(),
                [
                    'name' => 'text_style',
                    'selector' => '{{WRAPPER}} .stratum-circle-progress-bar .donut-text, {{WRAPPER}} .stratum-circle-progress-bar__title',
                    'label'	=> esc_html__( 'Text Typography', 'stratum' ),
                    'render_type' => 'ui',
                    'exclude' => ['html_tag']
                ]
            );

            $controls->start_controls_tabs( 'tabs_color_style');
                $controls->start_controls_tab(
                    'tab_color_normal',
                    [
                        'label' => esc_html__( 'Normal', 'stratum' ),
                    ]
                );

                    $controls->add_control(
                        'text_color',
                        [
                            'label' => esc_html__( 'Text Color', 'stratum' ),
                            'type' => Controls_Manager::COLOR,
                            'value' => '#000000',
                            'default' => '#000000',
                            'selectors' => [
                                '{{WRAPPER}} .stratum-circle-progress-bar .donut-text, {{WRAPPER}} .stratum-circle-progress-bar .stratum-circle-progress-bar__title' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $controls->add_control(
                        'line_color',
                        [
                            'label' => esc_html__( 'Line Color', 'stratum' ),
                            'type' => Controls_Manager::COLOR,
                            'value' => $first_color,
                            'default' => $first_color,
                            'render_type' => 'ui',
                            'selectors' => [
                                '{{WRAPPER}} .stratum-circle-progress-bar svg .donut-fill' => 'stroke: {{VALUE}}',
                            ],
                        ]
                    );

                    $controls->add_control(
                        'background_color',
                        [
                            'label' => esc_html__( 'Background Color', 'stratum' ),
                            'type' => Controls_Manager::COLOR,
                            'value' => '#4682b426',
                            'default' => '#4682b426',
                            'render_type' => 'ui',
                            'selectors' => [
                                '{{WRAPPER}} .stratum-circle-progress-bar svg .donut-bg' => 'stroke: {{VALUE}}',
                            ],
                        ]
                    );

                $controls->end_controls_tab();

                $controls->start_controls_tab(
                    'tab_color_hover',
                    [
                        'label' => esc_html__( 'Hover', 'stratum' ),
                    ]
                );

                    $controls->add_control(
                        'text_color_hover',
                        [
                            'label' => esc_html__( 'Text Color', 'stratum' ),
                            'type' => Controls_Manager::COLOR,
                            'value' => '#000000',
                            'default' => '#000000',
                            'selectors' => [
                                '{{WRAPPER}} .stratum-circle-progress-bar:hover .donut-text, {{WRAPPER}} .stratum-circle-progress-bar:hover .stratum-circle-progress-bar__title' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $controls->add_control(
                        'line_color_hover',
                        [
                            'label' => esc_html__( 'Line Color', 'stratum' ),
                            'type' => Controls_Manager::COLOR,
                            'value' => $first_color,
                            'default' => $first_color,
                            'render_type' => 'ui',
                            'selectors' => [
                                '{{WRAPPER}} .stratum-circle-progress-bar:hover svg .donut-fill' => 'stroke: {{VALUE}}',
                            ],
                        ]
                    );

                    $controls->add_control(
                        'background_color_hover',
                        [
                            'label' => esc_html__( 'Background Color', 'stratum' ),
                            'type' => Controls_Manager::COLOR,
                            'value' => '#4682b426',
                            'default' => '#4682b426',
                            'render_type' => 'ui',
                            'selectors' => [
                                '{{WRAPPER}} .stratum-circle-progress-bar:hover svg .donut-bg' => 'stroke: {{VALUE}}',
                            ],
                        ]
                    );

                $controls->end_controls_tab();
            $controls->end_controls_tabs();

		$controls->end_controls_section();
    }

    //PHP template (refresh elements)
    protected function render() {
        $this->render_widget( 'php' );
	}

    //JavaScript "Backbone" template (live preview)
	protected function _content_template() {
        $this->render_widget( 'js' );
    }

	public function render_plain_content( $instance = [] ) {}
}

Plugin::instance()->widgets_manager->register_widget_type( new Circle_Progress_Bar() );
