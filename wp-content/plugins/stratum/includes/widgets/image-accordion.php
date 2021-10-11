<?php
/**
 * Class: Image_Accordion
 * Name: Image Accordion
 * Slug: image-accordion
 */

namespace Stratum;

use \Elementor\Plugin;
use Elementor\Repeater;
use \Elementor\Utils;
use Elementor\Scheme_Typography;
use \Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Css_Filter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Image_Accordion extends Stratum_Widget_Base {
	protected $widget_name = 'image-accordion';

	public function __construct($data = [], $args = null) {
		parent::__construct( $data, $args );
	}

	public function get_title() {
		return esc_html__( 'Image Accordion', 'stratum' );
	}

	public function get_icon() {
		return 'stratum-icon-image-accordion';
	}

	public function get_categories() {
		return [ 'stratum-widgets' ];
	}

	public function get_script_depends() {
		return [
			'font-awesome-4-shim'
        ];
    }

	public function get_style_depends() {
        return [
			'font-awesome-5-all',
			'font-awesome-4-shim'
        ];
	}

    protected function _register_controls() {
		$controls = $this;

		/*-----------------------------------------------------------------------------------*/
        /*	Content Tab
        /*-----------------------------------------------------------------------------------*/

        $controls->start_controls_section(
			'general_settings_section',
			[
				'label' => esc_html__( 'General Settings', 'stratum' )
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'stratum' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src()
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}::before, {{WRAPPER}} {{CURRENT_ITEM}} .stratum-image-accordion__background' => 'background-image: url("{{URL}}");',
				]
			]
		);

		$repeater->add_control(
			'image_size',
			[
				'label' => esc_html__( 'Size', 'stratum' ),
				'type'  => Controls_Manager::SELECT,
				'options' => [
					'auto'    => esc_html__( 'Auto'   , 'stratum' ),
					'contain' => esc_html__( 'Contain', 'stratum' ),
					'cover'   => esc_html__( 'Cover'  , 'stratum' ),
					'custom'  => esc_html__( 'Custom' , 'stratum' )
				],
				'default' => 'auto',
				'label_block' => true,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}::before, {{WRAPPER}} {{CURRENT_ITEM}} .stratum-image-accordion__background' => 'background-size: {{VALUE}}',
				]
			]
		);

		$repeater->add_control(
			'image_position',
			[
				'label'   => esc_html__( 'Position', 'stratum' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'top left'      => esc_html__( 'Top Left'     , 'stratum' ),
					'top center'    => esc_html__( 'Top Center'   , 'stratum' ),
					'top right' 	=> esc_html__( 'Top Right'    , 'stratum' ),
					'center center' => esc_html__( 'Center Center', 'stratum' ),
					'center left'   => esc_html__( 'Center Left'  , 'stratum' ),
					'center right'  => esc_html__( 'Center Right' , 'stratum' ),
					'bottom center' => esc_html__( 'Bottom Center', 'stratum' ),
					'bottom left'   => esc_html__( 'Bottom Left'  , 'stratum' ),
					'bottom right'  => esc_html__( 'Bottom Right' , 'stratum' )
				],
				'default' => 'center center',
				'label_block' => true,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}::before, {{WRAPPER}} {{CURRENT_ITEM}} .stratum-image-accordion__background' => 'background-position: {{VALUE}}',
				]
			]
		);

		$repeater->add_control(
			'image_repeat',
			[
				'label' => esc_html__( 'Repeat', 'stratum' ),
				'type'  => Controls_Manager::SELECT,
				'options' => [
					'repeat'    => esc_html__( 'Repeat'   , 'stratum' ),
					'no-repeat' => esc_html__( 'No-repeat', 'stratum' ),
					'repeat-x'  => esc_html__( 'Repeat-x' , 'stratum' ),
					'repeat-y'  => esc_html__( 'Repeat-y' , 'stratum' ),
				],
				'default' => 'repeat',
				'label_block' => true,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}::before, {{WRAPPER}} {{CURRENT_ITEM}} .stratum-image-accordion__background' => 'background-repeat: {{VALUE}}',
				]
			]
		);

		$repeater->add_control(
			'content_switcher',
			[
				'label' => esc_html__( 'Content', 'stratum' ),
				'type'  => Controls_Manager::SWITCHER,
				'default' => ''
			]
		);

		$repeater->add_control(
			'icon_switcher',
			[
				'label' => esc_html__( 'Icon', 'stratum' ),
				'type'  => Controls_Manager::SWITCHER,
				'default' => '',
				'condition' => [
					'content_switcher' => 'yes'
				]
			]
		);

		$repeater->add_control(
			'icon_updated',
			[
				'label'   => esc_html__( 'Icon', 'stratum' ),
				'type'    => Controls_Manager::ICON,
				'default' => 'fas fa-star',
				'label_block' => true,
				'condition' => [
					'icon_switcher' => 'yes'
				]
			]
		);

		$repeater->add_control(
			'item_title',
			[
				'label'     => esc_html__( 'Title', 'stratum' ),
				'type'      => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Type your title here...', 'stratum' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [
					'content_switcher' => 'yes'
				]
			]
		);

		$repeater->add_control(
			'item_description',
			[
				'label' => esc_html__( 'Description', 'stratum' ),
				'type'  => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Type your content here...', 'stratum' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [
					'content_switcher' => 'yes'
				]
			]
		);

		$repeater->add_control(
			'custom_position',
            [
                'label' => esc_html__( 'Custom Position','stratum' ),
                'type'      => Controls_Manager::SWITCHER,
				'default' => '',
				'condition' => [
					'content_switcher' => 'yes'
				]
            ]
		);

		$repeater->add_responsive_control(
			'horizontal_offset',
            [
                'label' => esc_html__( 'Horizontal Offset', 'stratum' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 400
                    ]
                ],
                'label_block' => true,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .stratum-image-accordion__content' => 'position: absolute; left: {{SIZE}}{{UNIT}}'
                ],
                'condition' => [
                    'custom_position' => 'yes'
                ]
            ]
        );

        $repeater->add_responsive_control(
			'ver_offset',
            [
                'label' => esc_html__( 'Vertical Offset', 'stratum' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 400
                    ]
                ],
                'label_block' => true,
                'selectors'   => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .stratum-image-accordion__content' => 'position: absolute; top: {{SIZE}}{{UNIT}}'
                ],
                'condition' => [
                    'custom_position' => 'yes'
                ]
            ]
		);

		$repeater->add_control(
			'show_button',
			[
				'label' => esc_html__( 'Show button', 'stratum' ),
				'type'  => Controls_Manager::SWITCHER,
				'default' => '',
				'separator' => 'before',
				'condition' => [
					'content_switcher' => 'yes'
				]
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label' => esc_html__( 'Button Text', 'stratum' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Click Here', 'stratum' ),
				'dynamic' => [
					'active' => true
				],
				'condition' => [
					'content_switcher' => 'yes',
					'show_button!' => ''
				]
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'stratum' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true
				],
				'condition' => [
					'show_button!' => ''
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'stratum' ),
				'condition' => [
					'content_switcher' => 'yes',
					'show_button!' => ''
				]
			]
		);

		$controls->add_control(
			'image_content',
			[
				'label' => '',
				'type'  => Controls_Manager::REPEATER,
				'default' => [
					[
						'item_title' => sprintf( esc_html__( 'Item #%d', 'stratum' ), 1 ),
						'item_description' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'stratum' )
					],
					[
						'item_title' => sprintf( esc_html__( 'Item #%d', 'stratum' ), 2 ),
						'item_description' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'stratum' )
					],
					[
						'item_title' => sprintf( esc_html__( 'Item #%d', 'stratum' ), 3 ),
						'item_description' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'stratum' )
					]
				],
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ item_title }}}'
			]
        );

		$controls->end_controls_section();

		$controls->start_controls_section(
			'display_options_section',
			[
				'label' => esc_html__( 'Display Options', 'stratum' )
			]
		);

		$controls->add_control(
			'hovered_default_active',
			[
                'label' => esc_html__( 'Hovered By Default Index', 'stratum' ),
				'type'  => Controls_Manager::NUMBER,
				'condition' => [
                    'active_type' => 'activate-on-hover'
                ],
				'description' => esc_html__( 'Set the index for the image to be hovered by default on page load, index starts from 1', 'stratum' )
            ]
		);

		$controls->add_control(
			'opened_default_active',
			[
                'label' => esc_html__( 'Opened By Default Index', 'stratum' ),
				'type'  => Controls_Manager::NUMBER,
				'condition' => [
                    'active_type' => 'activate-on-click'
                ],
                'description' => esc_html__( 'Set the index for the image to be opened by default on page load, index starts from 1', 'stratum' )
            ]
		);

		$controls->add_control(
			'direction',
            [
                'label'   => esc_html__( 'Direction', 'stratum' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => esc_html__( 'Horizontal','stratum' ),
                    'vertical'   => esc_html__( 'Vertical'  ,'stratum' )
                ],
                'label_block' => true
            ]
		);

		$controls->add_control(
			'skew_switcher',
            [
                'label' => esc_html__( 'Skew Images', 'stratum' ),
                'type'  => Controls_Manager::SWITCHER,
                'default' => '',
                'condition' => [
                    'direction' => 'horizontal'
                ]
            ]
		);

		$controls->add_control(
			'skew_direction',
            [
                'label'   => esc_html__( 'Skew Direction', 'stratum' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'right' => esc_html__( 'Right','stratum' ),
                    'left'  => esc_html__( 'Left' ,'stratum' )
                ],
                'label_block'  => true,
                'condition' => [
                    'direction'     => 'horizontal',
                    'skew_switcher' => 'yes'
                ]
            ]
        );

		$controls->add_control(
			'active_type',
			[
				'label' => esc_html__( 'Accordion Style', 'stratum' ),
				'type'  => Controls_Manager::SELECT,
				'default' => 'activate-on-click',
				'label_block' => false,
				'options' => [
					'activate-on-hover' => esc_html__( 'On Hover', 'stratum' ),
					'activate-on-click' => esc_html__( 'On Click', 'stratum' )
				],
				'label_block' => true
			]
		);

		$controls->add_responsive_control(
			'height',
            [
                'label' => esc_html__( 'Image Height', 'stratum' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'vh' ],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000
                    ]
                ],
                'label_block' => true,
                'selectors'   => [
                    '{{WRAPPER}} .stratum-image-accordion__item' => 'height: {{SIZE}}{{UNIT}}'
                ]
            ]
		);

		$controls->add_responsive_control(
			'content_position',
            [
                'label' => esc_html__( 'Content Vertical Position', 'stratum' ),
                'type'  => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Top', 'stratum' ),
                        'icon'  => 'eicon-v-align-top'
                    ],
                    'center' => [
                        'title' => esc_html__( 'Middle', 'stratum' ),
                        'icon'  => 'eicon-v-align-middle'
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Bottom', 'stratum' ),
                        'icon'  => 'eicon-v-align-bottom'
                    ]
                ],
                'toggle'  => false,
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .stratum-image-accordion__overlay' => 'justify-content: {{VALUE}};'
                ]
            ]
        );

        $controls->add_responsive_control(
			'content_align',
            [
                'label' => esc_html__( 'Content Alignment', 'stratum' ),
                'type'  => Controls_Manager::CHOOSE,
                'options'  => [
                    'left' => [
                        'title'=> esc_html__( 'Left', 'stratum' ),
                        'icon' => 'fa fa-align-left'
                    ],
                    'center' => [
                        'title'=> esc_html__( 'Center', 'stratum' ),
                        'icon' => 'fa fa-align-center'
                    ],
                    'right' => [
                        'title'=> esc_html__( 'Right', 'stratum' ),
                        'icon' => 'fa fa-align-right'
                    ]
                ],
                'default' => 'center',
                'toggle'  => false,
                'render_type' => 'template',
                'selectors'   => [
                    '{{WRAPPER}} .stratum-image-accordion__content' => 'text-align: {{VALUE}};'
                ]
            ]
        );

		$controls->end_controls_section();

		$controls->start_controls_section(
			'syle_front_section_section',
			[
				'label' => esc_html__( 'Images', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$controls->add_control(
			'overlay_background',
            [
                'label' => esc_html__( 'Overlay Color', 'stratum' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .stratum-image-accordion__overlay' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $controls->add_control(
			'overlay_hover_background',
            [
                'label' => esc_html__( 'Overlay Hover Color', 'stratum' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .stratum-image-accordion__item:hover .stratum-image-accordion__overlay'  => 'background-color: {{VALUE}};'
                ]
            ]
		);

		$controls->start_controls_tabs( 'images_tabs' );

			$controls->start_controls_tab(
				'image_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'stratum' )
				]
			);

				$controls->add_group_control(
					Group_Control_Css_Filter::get_type(),
					[
						'name' => 'css_filters_normal',
						'selector' => '{{WRAPPER}} .stratum-image-accordion__background'
					]
				);

        	$controls->end_controls_tab();

			$controls->start_controls_tab(
				'image_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'stratum' )
				]
			);

				$controls->add_group_control(
					Group_Control_Css_Filter::get_type(),
					[
						'name' => 'css_filters_hover',
						'selector' => '{{WRAPPER}} .stratum-image-accordion__item:hover .stratum-image-accordion__background'
					]
				);

        	$controls->end_controls_tab();

        $controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'icons_style_section',
			[
				'label' => esc_html__( 'Content', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$controls->start_controls_tabs( 'icons_active_tabs' );

			$controls->start_controls_tab(
				'icons_style_tab',
				[
					'label' => esc_html__( 'Icon', 'stratum' )
				]
			);

				$controls->add_control(
					'icon_color',
					[
						'label' => esc_html__( 'Color', 'stratum' ),
						'type'  => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .stratum-image-accordion__icon' => 'color: {{VALUE}};'
						]
					]
				);

				$controls->add_control(
					'icon_hover_color',
					[
						'label' => esc_html__( 'Hover Color', 'stratum' ),
						'type'  => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .stratum-image-accordion__icon:hover' => 'color: {{VALUE}};'
						]
					]
				);

				$controls->add_control(
					'icon_background_color',
					[
						'label' => esc_html__( 'Background Color', 'stratum' ),
						'type'  => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .stratum-image-accordion__icon' => 'background-color: {{VALUE}};'
						]
					]
				);

				$controls->add_control(
					'icon_background_hover_color',
					[
						'label' => esc_html__( 'Background Hover Color ', 'stratum' ),
						'type'  => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .stratum-image-accordion__icon:hover' => 'background-color: {{VALUE}};'
						]
					]
				);

				$controls->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name'     => 'icon_shadow',
						'selector' => '{{WRAPPER}} .stratum-image-accordion__icon'
					]
				);

				$controls->add_responsive_control(
					'icon_size',
					[
						'label' => esc_html__( 'Size', 'stratum' ),
						'type'  => Controls_Manager::SLIDER,
						'size_units' => ['px', 'em'],
						'range'      => [
							'px' => [
								'min' => 0,
								'max' => 500
							],
							'em' => [
								'min' => 0,
								'max' => 20
							]
						],
						'selectors' => [
							'{{WRAPPER}} .stratum-image-accordion__icon' => 'font-size: {{SIZE}}{{UNIT}};'
						]
					]
				);

				$controls->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'     => 'icon_border',
						'selector' => '{{WRAPPER}} .stratum-image-accordion__icon'
					]
				);

				$controls->add_control(
					'icon_border_radius',
					[
						'label' => esc_html__( 'Border Radius', 'stratum' ),
						'type'  => Controls_Manager::SLIDER,
						'size_units' => ['px', '%' ,'em'],
						'selectors' => [
							'{{WRAPPER}} .stratum-image-accordion__icon' => 'border-radius: {{SIZE}}{{UNIT}};'
						]
					]
				);

				$controls->add_responsive_control(
					'icon_margin',
					[
						'label' => esc_html__( 'Margin', 'stratum' ),
						'type'  => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', 'em', '%'],
						'selectors'  => [
							'{{WRAPPER}} .stratum-image-accordion__icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						]
					]
				);

				$controls->add_responsive_control(
					'icon_padding',
					[
						'label' => esc_html__( 'Padding', 'stratum' ),
						'type'  => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', 'em', '%'],
						'selectors'  => [
							'{{WRAPPER}} .stratum-image-accordion__icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						]
					]
				);

			$controls->end_controls_tab();

			$controls->start_controls_tab(
				'titles_style_tab',
				[
					'label' => esc_html__( 'Title', 'stratum' )
				]
			);

				$controls->add_control(
					'title_color',
					[
						'label' => esc_html__( 'Color ', 'stratum' ),
						'type'  => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .stratum-image-accordion__title' => 'color: {{VALUE}};'
						]
					]
				);

				$controls->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'title_typography',
						'selector' => '{{WRAPPER}} .stratum-image-accordion__title'
					]
				);

				$controls->add_group_control(
					Group_Control_Text_Shadow::get_type(),
					[
						'name'     => 'title_shadow',
						'selector' => '{{WRAPPER}} .stratum-image-accordion__title'
					]
				);

				$controls->add_responsive_control(
					'title_margin',
					[
						'label' => esc_html__( 'Margin', 'stratum' ),
						'type'  => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', 'em', '%'],
						'selectors'  => [
							'{{WRAPPER}} .stratum-image-accordion__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						]
					]
				);

				$controls->add_responsive_control(
					'title_padding',
					[
						'label' => esc_html__( 'Padding', 'stratum' ),
						'type'  => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', 'em', '%'],
						'selectors'  => [
							'{{WRAPPER}} .stratum-image-accordion__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						]
					]
				);

			$controls->end_controls_tab();

			$controls->start_controls_tab(
				'description_style_tab',
				[
					'label' => esc_html__( 'Description', 'stratum' )
				]
			);

				$controls->add_control(
					'description_color',
					[
						'label' => esc_html__( 'Color ', 'stratum' ),
						'type'  => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .stratum-image-accordion__description' => 'color: {{VALUE}};'
						]
					]
				);

				$controls->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'description_typography',
						'selector' => '{{WRAPPER}} .stratum-image-accordion__description'
					]
				);

				$controls->add_group_control(
					Group_Control_Text_Shadow::get_type(),
					[
						'name'     => 'description_shadow',
						'selector' => '{{WRAPPER}} .stratum-image-accordion__description'
					]
				);

				$controls->add_responsive_control(
					'description_margin',
					[
						'label' => esc_html__( 'Margin', 'stratum' ),
						'type'  => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', 'em', '%'],
						'selectors'  => [
							'{{WRAPPER}} .stratum-image-accordion__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						]
					]
				);

				$controls->add_responsive_control(
					'description_padding',
					[
						'label' => esc_html__( 'Padding', 'stratum' ),
						'type'  => Controls_Manager::DIMENSIONS,
						'size_units' => ['px', 'em', '%'],
						'selectors'  => [
							'{{WRAPPER}} .stratum-image-accordion__description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						]
					]
				);

			$controls->end_controls_tab();

		$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'button_style_section',
            [
                'label' => esc_html__( 'Button', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);
			$controls->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'button_typography',
					'selector' => '{{WRAPPER}} .stratum-image-accordion__button'
				]
			);

			$controls->start_controls_tabs( 'button_tabs' );

				$controls->start_controls_tab( 'normal',
					[
						'label' => esc_html__( 'Normal', 'stratum' )
					]
				);

					$controls->add_control(
						'button_text_color',
						[
							'label' => esc_html__( 'Text Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-image-accordion__button' => 'color: {{VALUE}};'
							]
						]
					);

					$controls->add_control(
						'button_background_color',
						[
							'label' => esc_html__( 'Background Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-image-accordion__button' => 'background-color: {{VALUE}};'
							]
						]
					);

					$controls->add_control(
						'button_border_color',
						[
							'label' => esc_html__( 'Border Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-image-accordion__button' => 'border-color: {{VALUE}};'
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'hover',
					[
						'label' => esc_html__( 'Hover', 'stratum' )
					]
				);

					$controls->add_control(
						'button_hover_text_color',
						[
							'label' => esc_html__( 'Text Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-image-accordion__button:hover' => 'color: {{VALUE}};'
							]
						]
					);

					$controls->add_control(
						'button_hover_background_color',
						[
							'label' => esc_html__( 'Background Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-image-accordion__button:hover' => 'background-color: {{VALUE}};'
							]
						]
					);

					$controls->add_control(
						'button_hover_border_color',
						[
							'label' => esc_html__( 'Border Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-image-accordion__button:hover' => 'border-color: {{VALUE}};'
							]
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

			$controls->add_responsive_control(
				'button_border_width',
				[
					'label' => esc_html__( 'Border Width', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 20
						]
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-image-accordion__button' => 'border-width: {{SIZE}}{{UNIT}};'
					],
					'separator' => 'before'
				]
			);

			$controls->add_responsive_control(
				'button_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-image-accordion__button' => 'border-radius: {{SIZE}}{{UNIT}};'
					],
					'separator' => 'after'
				]
			);

		$controls->end_controls_section();
	}

	protected function render() {
		$this->render_widget( 'php' );
	}

	public function image_accordion_render_button( $index, $button_text, $link ) {
		$out = '';
		$this->add_render_attribute( 'button' . $index, 'class', [
			'stratum-image-accordion__button'
		] );

		if ( ! empty( $link[ 'url' ] ) ) {
			$this->add_link_attributes( 'button' . $index, $link );
		}

		$button_class = $this->get_render_attribute_string( 'button' . $index );
		$out .= "<a " . ( empty( $link[ 'url' ] ) ? "href='#' " : '' ) . $button_class. ">" . esc_html( $button_text ) . "</a>";

		return $out;
	}

	protected function content_template() {}
	public function render_plain_content( $instance = [] ) {}
}

Plugin::instance()->widgets_manager->register_widget_type( new Image_Accordion() );