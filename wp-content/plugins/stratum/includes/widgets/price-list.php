<?php
/**
 * Class: Price_List
 * Name: Price List
 * Slug: stratum-price-list
 */

namespace Stratum;

use \Elementor\Controls_Manager;
use Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Price_List extends Stratum_Widget_Base {
	protected $widget_name = 'price-list';

	public function __construct($data = [], $args = null) {
        parent::__construct( $data, $args );
    }

	public function get_title() {
		return esc_html__( 'Price List', 'stratum' );
	}

	public function get_icon() {
		return 'stratum-icon-price-list';
	}

	public function get_categories() {
		return [ 'stratum-widgets' ];
    }

    protected function _register_controls() {
        $controls = $this;

        /*-----------------------------------------------------------------------------------*/
        /*	Content Tab
        /*-----------------------------------------------------------------------------------*/

        $controls->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'stratum' )
			]
        );

        $controls->add_control(
			'list_title',
			[
				'label'   => esc_html__( 'Heading', 'stratum' ),
				'type'    => Controls_Manager::TEXT,
                'dynamic' => [ 'active' => true ],
                'default'     => esc_html__( 'List Heading', 'stratum' )
			]
        );

        $controls->add_control(
			'title_html_tag',
			[
				'label' => esc_html__( 'Heading HTML Tag', 'stratum' ),
                'type'  => Controls_Manager::SELECT,
                'options' => [
                    'h1'  => esc_html__( 'H1'  , 'stratum' ),
                    'h2'  => esc_html__( 'H2'  , 'stratum' ),
                    'h3'  => esc_html__( 'H3'  , 'stratum' ),
                    'h4'  => esc_html__( 'H4'  , 'stratum' ),
                    'h5'  => esc_html__( 'H5', 'stratum' ),
                    'h6'  => esc_html__( 'H6'  , 'stratum' ),
                    'div' => esc_html__( 'div' , 'stratum' ),
                    'p'   => esc_html__( 'p'   , 'stratum' )
                ],
                'default' => 'h5'
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_title',
			[
				'label' => esc_html__( 'Title', 'stratum' ),
				'type'  => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true
				],
				'label_block' => true,
				'placeholder' => esc_html__( 'Title', 'stratum' ),
				'default' => esc_html__( 'Title', 'stratum' )
			]
		);

		$repeater->add_control(
			'title_html_tag',
			[
				'label' => esc_html__( 'Title HTML Tag', 'stratum' ),
				'type'  => Controls_Manager::SELECT,
				'options' => [
					'h1'   => esc_html__( 'H1'  , 'stratum' ),
					'h2'   => esc_html__( 'H2'  , 'stratum' ),
					'h3'   => esc_html__( 'H3'  , 'stratum' ),
					'h4'   => esc_html__( 'H4'  , 'stratum' ),
					'h5'   => esc_html__( 'H5  ', 'stratum' ),
					'h6'   => esc_html__( 'H6'  , 'stratum' ),
					'div'  => esc_html__( 'div' , 'stratum' ),
					'span' => esc_html__( 'span', 'stratum' ),
					'p'    => esc_html__( 'p'   , 'stratum' )
				],
				'default' => 'span'
			]
		);

		$repeater->add_control(
			'item_price',
			[
				'label' => esc_html__( 'Price', 'stratum' ),
				'type'  => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => '$11'
			]
		);

        $controls->add_control(
			'list_items',
			[
				'label' => '',
				'type'  => Controls_Manager::REPEATER,
				'title_field' => '{{{ item_title }}}',
				'default' => [
					[
						'item_title' => sprintf( esc_html__( 'Item #%d', 'stratum' ), 1 ),
						'item_price' => '$69'
                    ],
                    [
						'item_title' => sprintf( esc_html__( 'Item #%d', 'stratum' ), 2 ),
						'item_price' => '$49'
                    ],
                    [
						'item_title' => sprintf( esc_html__( 'Item #%d', 'stratum' ), 3 ),
						'item_price' => '$19'
					]
				],
				'fields' => $repeater->get_controls()
			]
        );

        $controls->add_control(
            'show_image',
            [
                'label'        => esc_html__( 'Show Image', 'stratum' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'no',
                'label_on'     => esc_html__( 'On', 'stratum' ),
                'label_off'    => esc_html__( 'Off', 'stratum' ),
                'return_value' => 'yes'
            ]
        );

        $controls->add_control(
            'image_size',
            [
                'label'   => esc_html__( 'Image Size', 'stratum' ),
                'type'    => 'select',
                'default' => 'full',
                'options' => \Stratum\Stratum::get_instance()->get_scripts_manager()->get_image_sizes(),
                'condition' => [
                    'show_image' => 'yes'
                ]
            ]
        );

        $controls->add_control(
            'image',
            [
                'label' => esc_html__( 'Image', 'stratum' ),
                'type'  => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src()
                ],
                'dynamic'    => [
                    'active' => true
                ],
                'condition' => [
                    'show_image' => 'yes'
                ]
            ]
        );

        $controls->add_control(
			'image_width',
			[
				'label' => esc_html__( 'Image Width', 'stratum' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
                    'size' => 250,
                    'unit' => 'px'
				],
				'range' => [
					'px' => [
						'max' => 600,
						'min' => 10,
						'step' => 1
					]
				],
				'selectors' => [
					'{{WRAPPER}} .stratum-price-list__image-wrapper' => 'width: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'show_image' => 'yes'
                ]
			]
		);

        $controls->add_control(
			'image_position',
			[
				'label'   => esc_html__( 'Image position', 'stratum' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'has-image-left',
				'options' => [
                    'has-image-top'   => esc_html__( 'Top'   , 'stratum' ),
					'has-image-left'  => esc_html__( 'Left' , 'stratum' ),
					'has-image-right' => esc_html__( 'Right', 'stratum' )
                ],
                'condition' => [
                    'show_image' => 'yes'
                ]
			]
        );

        $controls->add_control(
            'title_price_connector',
            [
                'label'        => esc_html__( 'Title-Price Separator', 'stratum' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'no',
                'label_on'     => esc_html__( 'Yes', 'stratum' ),
                'label_off'    => esc_html__( 'No', 'stratum'  ),
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

			$controls->add_responsive_control(
				'content_padding',
				[
					'label' => esc_html__( 'Content Padding', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'selectors' => [
						'{{WRAPPER}} .stratum-price-list .stratum-price-list__wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					],
					'separator' => 'before'
				]
			);

			$controls->start_controls_tabs( 'price_styles' );

				$controls->start_controls_tab(
					'price_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);



					$controls->add_control(
						'heading_color',
						[
							'label' => esc_html__( 'Heading Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-price-list .stratum-price-list__heading' => 'color: {{VALUE}}',
							],
						]
					);

					$controls->add_control(
						'title_color',
						[
							'label' => esc_html__( 'Title Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-price-list__items .stratum-price-list__title' => 'color: {{VALUE}}',
							],
						]
					);

					$controls->add_control(
						'price_color',
						[
							'label' => esc_html__( 'Price Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-price-list__items .stratum-price-list__price' => 'color: {{VALUE}}',
							],
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'price_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'heading_hover_color',
						[
							'label' => esc_html__( 'Heading Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-price-list:hover .stratum-price-list__heading' => 'color: {{VALUE}}',
							],
						]
					);

					$controls->add_control(
						'title_hover_color',
						[
							'label' => esc_html__( 'Title Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-price-list:hover .stratum-price-list__title' => 'color: {{VALUE}}',
							],
						]
					);

					$controls->add_control(
						'price_hover_color',
						[
							'label' => esc_html__( 'Price Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-price-list:hover .stratum-price-list__price' => 'color: {{VALUE}}',
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

Plugin::instance()->widgets_manager->register_widget_type( new Price_List() );