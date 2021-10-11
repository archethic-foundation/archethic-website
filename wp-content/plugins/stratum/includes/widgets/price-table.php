<?php
/**
 * Class: Price_Table
 * Name: Price Table
 * Slug: stratum-price-table
 */

namespace Stratum;

use \Elementor\Group_Control_Border;
use \Elementor\Controls_Manager;
use \Elementor\Utils;
use \Elementor\Plugin;
use \Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Price_Table extends Stratum_Widget_Base {
	protected $widget_name = 'price-table';

	public function __construct($data = [], $args = null) {
        parent::__construct( $data, $args );
    }

	public function get_title() {
		return esc_html__( 'Price Table', 'stratum' );
	}

	public function get_icon() {
		return 'stratum-icon-price-table';
	}

	public function get_categories() {
		return [ 'stratum-widgets' ];
    }

    protected function _register_controls() {
        $controls = $this;

        $first_color = '#000';
        $second_color = '#000';

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

			$controls->add_control(
				'title',
				[
					'label' => esc_html__( 'Title', 'stratum' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Premium', 'stratum' ),
					'title' => esc_html__( 'Title', 'stratum' ),
				]
			);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'selector' => '{{WRAPPER}} .stratum-price-table__header .stratum-price-table__title',
					'label'	=> esc_html__( 'Title Typography', 'stratum' ),
					'render_type' => 'template',
					'condition' => [
						'title!' => ''
					],
					'defaults' => [
						'html_tag' => 'h5',
					],
				]
			);

			$controls->add_control(
				'subtitle',
				[
					'label' => esc_html__( 'Subtitle', 'stratum' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Plan', 'stratum' ),
					'title' => esc_html__( 'Subtitle', 'stratum' ),
				]
			);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'subtitles_typography',
					'selector' => '{{WRAPPER}} .stratum-price-table__subtitle',
					'label'	=> esc_html__( 'Subtitle Typography', 'stratum' ),
					'render_type' => 'template',
					'condition' => [
						'subtitle!' => ''
					],
					'defaults' => [
						'html_tag' => 'h4',
					],
				]
			);

			$controls->add_control(
				'price_text',
				[
					'label' => esc_html__( 'Price Text', 'stratum' ),
					'type' => Controls_Manager::TEXTAREA,
					'rows' => 10,
					'default' => esc_html__( 'Min Price', 'stratum' ),
					'title' => esc_html__( 'Price Text', 'stratum' ),
				]
			);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'price_text_typography',
					'selector' => '{{WRAPPER}} .stratum-price-table__price-text',
					'label'	=> esc_html__( 'Price Subtitle Typography', 'stratum' ),
					'render_type' => 'template',
					'condition' => [
						'subtitle!' => ''
					],
                    'exclude' => ['html_tag']
				]
			);

			$controls->add_control(
				'price',
				[
					'label' => esc_html__( 'Price', 'stratum' ),
					'type' => Controls_Manager::NUMBER,
					'step' => 1,
					'default' => 7.50,
				]
			);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'price_typography',
					'selector' => '{{WRAPPER}} .stratum-price-table__price-wrapper .stratum-price-table__price',
					'label'	=> esc_html__( 'Price Typography', 'stratum' ),
					'render_type' => 'template',
					'condition' => [
						'price!' => ''
					],
					'defaults' => [
						'html_tag' => 'h5',
					],
				]
			);

			$controls->add_control(
				'price_currency',
				[
					'label' => esc_html__( 'Currency', 'stratum' ),
					'type' => Controls_Manager::TEXT,
					'default' => '$',
					'title' => esc_html__( 'Currency', 'stratum' ),
					'condition' => [
						'price!' => ''
					],
				]
			);

			$controls->add_control(
				'currency_align',
				[
					'label' => esc_html__( 'Currency Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'right',
					'prefix_class' => 'stratum-price-table-currency-align%s-',
					'toggle' => false,
					'options' => [
						'left'    => [
							'title' => esc_html__( 'Left', 'stratum' ),
							'icon' => 'fa fa-align-left',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'stratum' ),
							'icon' => 'fa fa-align-right',
						],
					],
				]
			);

			$controls->add_control(
				'price_description',
				[
					'label' => esc_html__( 'Price description', 'stratum' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'per 10GH/s', 'stratum' ),
					'title' => esc_html__( 'Price description', 'stratum' ),
				]
			);

			$repeater = new Repeater();

			$repeater->add_control(
				'item_text',
				[
					'label' => esc_html__( 'Item text', 'stratum' ),
					'type'  => Controls_Manager::TEXT,
					'label_block' => true,
					'placeholder' => esc_html__( 'Caption', 'stratum' ),
					'default' => esc_html__( 'Text', 'stratum' )
				]
			);

			$repeater->add_control(
				'item_icon',
				[
					'label_block' => true,
					'label' => esc_html__( 'Item icon', 'stratum' ),
					'type' => Controls_Manager::ICON
				]
			);

			$repeater->add_control(
				'icon_color',
				[
					'label' => esc_html__( 'Icon Color', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}}.stratum-price-table__content i' => 'color: {{VALUE}}',
					],
					'condition' => [
						'item_icon!' => ''
					]
				]
			);

			$repeater->add_control(
				'icon_color_hover',
				[
					'label' => esc_html__( 'Icon Color (Hover)', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}:hover {{CURRENT_ITEM}}.stratum-price-table__content i' => 'color: {{VALUE}}',
					],
					'condition' => [
						'item_icon!' => ''
					]
				]
			);

            $controls->add_control(
                'content_items',
                [
                    'label' => esc_html__( 'List items', 'stratum' ),
                    'type'  => Controls_Manager::REPEATER,
                    'title_field' => '{{{ item_text }}}',
                    'default' => [
                        [
                            'item_text' => esc_html__( 'First', 'stratum' )
                        ],
                        [
                            'item_text' => esc_html__( 'Second', 'stratum' )
                        ],
                        [
                            'item_text' => esc_html__( 'Third', 'stratum' )
                        ]
                    ],
                    'fields' => $repeater->get_controls()
                ]
            );

			$controls->add_responsive_control(
				'align',
				[
					'label' => esc_html__( 'List Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'center',
					'toggle' => false,
					'options' => [
						'left'    => [
							'title' => esc_html__( 'Left', 'stratum' ),
							'icon' => 'fa fa-align-left',
						],
						'center' => [
							'title' => esc_html__( 'None', 'stratum' ),
							'icon' => 'fa fa-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'stratum' ),
							'icon' => 'fa fa-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-price-table__wrapper .stratum-price-table__content-wrapper' => 'text-align: {{VALUE}};',
					],
				]
			);

			$controls->add_control(
				'line_border',
				[
					'label' => esc_html__( 'List border', 'stratum' ),
					'type' => Controls_Manager::POPOVER_TOGGLE,
					'label_off' => esc_html__( 'Default', 'stratum' ),
					'label_on' => esc_html__( 'Custom', 'stratum' ),
					'return_value' => 'yes',
				]
			);

			/*------------------------BORDER POPOVER------------------------*/
			$controls->start_popover();

				$controls->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'border',
						'label' => esc_html__( 'Border', 'stratum' ),
						'selector' => '{{WRAPPER}} .stratum-price-table__content-wrapper li',
						'condition' => [
							'line_border' => 'yes'
						],
					]
				);

			$controls->end_popover();
			/*------------------------------------------------*/

			$controls->add_control(
				'button_show',
				[
					'label' => esc_html__( 'Show button', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'separator' => 'before',
				]
			);

			$controls->add_responsive_control(
				'button_align',
				[
					'label' => esc_html__( 'Button Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'center',
					'toggle' => false,
					'prefix_class' => 'stratum-price-table-button-align%s-',
					'options' => [
						'left'    => [
							'title' => esc_html__( 'Left', 'stratum' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'stratum' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'stratum' ),
							'icon' => 'eicon-text-align-right',
						],
						'full' => [
							'title' => esc_html__( 'Justified', 'stratum' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'condition' => [
						'button_show' => 'yes'
					],
				]
			);

			$controls->add_control(
				'button_text',
				[
					'label' => esc_html__( 'Button caption', 'stratum' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Purchase', 'stratum' ),
					'title' => esc_html__( 'Button caption', 'stratum' ),
					'condition' => [
						'button_show' => 'yes'
					],
				]
			);

			$controls->add_control(
				'button_url',
				[
					'label' => esc_html__( 'Button URL', 'stratum' ),
					'type' => Controls_Manager::URL,
					'placeholder' => 'https://',
					'show_external' => true,
					'default' => [
						'url' => '',
						'is_external' => true,
						'nofollow' => true,
					],
					'condition' => [
						'button_text!' => '',
						'button_show' => 'yes'
					],
				]
			);

			$controls->add_control(
				'stratum_button_border',
				[
					'label'    => esc_html__( 'Button Border', 'stratum' ),
					'type'     => Controls_Manager::SELECT,
					'options'  => [
						'' 		 => esc_html__( 'None', 'stratum' ),
						'solid'  => esc_html__( 'Solid', 'stratum' ),
						'double' => esc_html__( 'Double', 'stratum' ),
						'dotted' => esc_html__( 'Dotted', 'stratum' ),
						'dashed' => esc_html__( 'Dashed', 'stratum' ),
						'groove' => esc_html__( 'Groove', 'stratum' ),
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-price-table__button .button' => 'border-style: {{VALUE}};',
					],
				]
			);

			$controls->add_responsive_control(
				'button_border_width',
				[
					'label'      => esc_html__( 'Button Border Width', 'stratum' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'default' => [
						'top'    => 1,
						'right'  => 1,
						'bottom' => 1,
						'left'   => 1,
					],
					'selectors'   => [
						'{{WRAPPER}} .stratum-price-table__button .button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'stratum_button_border!' => '',
					]
				]
			);

			$controls->add_control(
				'button_radius',
				[
					'label' => esc_html__( 'Button Border Radius', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'condition' => [
						'stratum_button_border!' => ''
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-price-table__button .button' => 'border-radius: {{SIZE}}{{UNIT}};',
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

			$controls->start_controls_tabs( 'price_table_styles' );

				$controls->start_controls_tab(
					'price_table_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$controls->add_control(
						'title_color',
						[
							'label' => esc_html__( 'Title Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-price-table__header .stratum-price-table__title' => 'color: {{VALUE}}',
							],
							'conditions' => [
								'relation' => 'and',
								'terms' => [
									[
										'name' => 'title',
										'operator' => '!=',
										'value' => '',
									],
								],
							],
						]
					);

					$controls->add_control(
						'subtitle_color',
						[
							'label' => esc_html__( 'Subtitle Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-price-table__subtitle' => 'color: {{VALUE}}',
							],
							'conditions' => [
								'relation' => 'and',
								'terms' => [
									[
										'relation' => 'or',
										'terms' => [
											[
												'name' => 'subtitle',
												'operator' => '!=',
												'value' => ''
											], [
												'name' => 'price_text',
												'operator' => '!=',
												'value' => ''
											]
										]
									]
								],
							],
						]
					);

					$controls->add_control(
						'price_color',
						[
							'label' => esc_html__( 'Price Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-price-table__price-wrapper .stratum-price-table__price' => 'color: {{VALUE}}',
							],
							'conditions' => [
								'relation' => 'and',
								'terms' => [
									[
										'name' => 'price',
										'operator' => '!=',
										'value' => '',
									],
								],
							],
						]
					);

					$controls->add_control(
						'price_text_color',
						[
							'label' => esc_html__( 'Price Text Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-price-table__price-text' => 'color: {{VALUE}}',
							],
							'conditions' => [
								'relation' => 'and',
								'terms' => [
									[
										'relation' => 'or',
										'terms' => [
											[
												'name' => 'subtitle',
												'operator' => '!=',
												'value' => ''
											], [
												'name' => 'price_text',
												'operator' => '!=',
												'value' => ''
											]
										]
									]
								],
							],
						]
					);

					$controls->add_control(
						'description_color',
						[
							'label' => esc_html__( 'Description Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-price-table__price-wrapper .stratum-price-table__price-description' => 'color: {{VALUE}}',
							],
							'conditions' => [
								'relation' => 'and',
								'terms' => [
									[
										'name' => 'price_description',
										'operator' => '!=',
										'value' => '',
									],
								],
							],
						]
					);

					$controls->add_control(
						'content_color',
						[
							'label' => esc_html__( 'Content Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-price-table__content-wrapper .stratum-price-table__content' => 'color: {{VALUE}}',
							],
						]
					);

					$controls->add_control(
						'button_color_font',
						[
							'label' => esc_html__( 'Button Font Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-price-table__button .button' => 'color: {{VALUE}}',
							],
						]
					);

					$controls->add_control(
						'button_color_background',
						[
							'label' => esc_html__( 'Button Background Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-price-table__button .button' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
							],
						]
					);

					$controls->add_control(
						'button_color_border',
						[
							'label' => esc_html__( 'Button Border Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-price-table__button .button' => 'border-color: {{VALUE}};',
							],
							'condition'  => [
								'stratum_button_border!' => '',
							],
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'price_table_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'title_color_hover',
						[
							'label' => esc_html__( 'Title Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}:hover .stratum-price-table__header .stratum-price-table__title' => 'color: {{VALUE}}',
							],
							'conditions' => [
								'relation' => 'and',
								'terms' => [
									[
										'name' => 'title',
										'operator' => '!=',
										'value' => '',
									],
								],
							],
						]
					);


					$controls->add_control(
						'subtitle_color_hover',
						[
							'label' => esc_html__( 'Subtitle Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}:hover .stratum-price-table__subtitle' => 'color: {{VALUE}}',
							],
							'conditions' => [
								'relation' => 'and',
								'terms' => [
									[
										'relation' => 'or',
										'terms' => [
											[
												'name' => 'subtitle',
												'operator' => '!=',
												'value' => ''
											], [
												'name' => 'price_text',
												'operator' => '!=',
												'value' => ''
											]
										]
									]
								],
							],
						]
					);

					$controls->add_control(
						'price_color_hover',
						[
							'label' => esc_html__( 'Price Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}:hover .stratum-price-table__price-wrapper .stratum-price-table__price' => 'color: {{VALUE}}',
							],
							'conditions' => [
								'relation' => 'and',
								'terms' => [
									[
										'name' => 'price',
										'operator' => '!=',
										'value' => '',
									],
								],
							],
						]
					);

					$controls->add_control(
						'price_text_color_hover',
						[
							'label' => esc_html__( 'Price Text Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}:hover .stratum-price-table__price-text' => 'color: {{VALUE}}',
							],
							'conditions' => [
								'relation' => 'and',
								'terms' => [
									[
										'relation' => 'or',
										'terms' => [
											[
												'name' => 'subtitle',
												'operator' => '!=',
												'value' => ''
											], [
												'name' => 'price_text',
												'operator' => '!=',
												'value' => ''
											]
										]
									]
								],
							],
						]
					);

					$controls->add_control(
						'description_color_hover',
						[
							'label' => esc_html__( 'Description Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}:hover .stratum-price-table__price-wrapper .stratum-price-table__price-description' => 'color: {{VALUE}}',
							],
							'conditions' => [
								'relation' => 'and',
								'terms' => [
									[
										'name' => 'price_description',
										'operator' => '!=',
										'value' => '',
									],
								],
							],
						]
					);

					$controls->add_control(
						'content_color_hover',
						[
							'label' => esc_html__( 'Content Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}:hover .stratum-price-table__content-wrapper .stratum-price-table__content' => 'color: {{VALUE}}',
							],
						]
					);

					$controls->add_control(
						'button_color_font_hover',
						[
							'label' => esc_html__( 'Button Font Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}:hover .stratum-price-table__button .button:hover' => 'color: {{VALUE}}',
							],
						]
					);
					$controls->add_control(
						'button_color_background_hover',
						[
							'label' => esc_html__( 'Button Background Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}:hover .stratum-price-table__button .button:hover' => 'background-color: {{VALUE}};',
							],
						]
					);

					$controls->add_control(
						'button_color_border_hover',
						[
							'label' => esc_html__( 'Button Border Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}:hover .stratum-price-table__button .button:hover' => 'border-color: {{VALUE}};',
							],
							'condition'  => [
								'stratum_button_border!' => '',
							],
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();
    }

    protected function render() {
        $this->render_widget( 'php' );
	}

	protected function content_template() {}
	public function render_plain_content( $instance = [] ) {}
}

Plugin::instance()->widgets_manager->register_widget_type( new Price_Table() );