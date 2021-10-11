<?php
/**
 * Class: Advanced_Slider
 * Name: Advanced Slider
 * Slug: advanced-slider
 */

namespace Stratum;

use \Elementor\Group_Control_Border;
use \Elementor\Controls_Manager;
use \Elementor\Utils;
use \Elementor\Plugin;
use \Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Advanced_Slider extends Stratum_Widget_Base {
	protected $widget_name = 'advanced-slider';

	public $default_arrows_color = '#fff';

    public function __construct($data = [], $args = null) {
        parent::__construct( $data, $args );
    }

	public function get_title() {
		return esc_html__( 'Advanced Slider', 'stratum' );
	}

	public function get_script_depends() {
        return [
			'swiper',
			'font-awesome-4-shim'
		];
	}

	public function get_style_depends() {
        return [
			'font-awesome-5-all',
			'font-awesome-4-shim'
        ];
	}

	public function get_keywords() {
		return [ 'carousel', 'image', 'slider' ];
	}

	public function get_icon() {
		return 'stratum-icon-advanced-slider';
	}

	public function get_categories() {
		return [ 'stratum-widgets' ];
    }

    protected function _register_controls() {
        $controls = $this;

        /*-----------------------------------------------------------------------------------*/
        /*	Content Tab
        /*-----------------------------------------------------------------------------------*/

		$sections = new \Stratum\Sections($this);

		$controls->start_controls_section(
			'section_general',
			[
				'label' => esc_html__( 'General', 'stratum' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

			$repeater = new Repeater();

			$repeater->add_control(
				'sub_title',
				[
					'label'   => esc_html__( 'Subtitle', 'stratum' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'Subtitle', 'stratum' ),
					'dynamic' => [ 'active' => true ]
				]
			);

			$repeater->add_control(
				'title',
				[
					'label'   => esc_html__( 'Title', 'stratum' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'Title', 'stratum' ),
					'dynamic' => [ 'active' => true ]
				]
			);

			$repeater->add_control(
				'description',
				[
					'label'   => esc_html__( 'Description', 'stratum' ),
					'type'    => Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'stratum' ),
					'dynamic' => [ 'active' => true ]
				]
			);

			$repeater->add_control(
				'button_text',
				[
					'label'   => esc_html__( 'Button Text', 'stratum' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'Button', 'stratum' ),
					'dynamic' => [ 'active' => true ]
				]
			);

			$repeater->add_control(
				'button_link',
				[
					'label' => esc_html__( 'URL', 'stratum' ),
					'type' => Controls_Manager::URL,
					'placeholder' => 'https://',
					'show_external' => true,
					'default' => [
						'url' => '',
						'is_external' => true,
						'nofollow' => true,
					],
				]
			);

			$repeater->add_control(
				'custom_alignment',
				[
					'label' => esc_html__( 'Custom Alignment', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'default' => '',
				]
			);

			$repeater->add_responsive_control(
				'override_block_horizontal_alignment',
				[
					'label' => esc_html__( 'Horizontal Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'toggle' => true,
					'options' => [
						'flex-start'    => [
							'title' => esc_html__( 'Left', 'stratum' ),
							'icon' => 'eicon-h-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'stratum' ),
							'icon' => 'eicon-h-align-center',
						],
						'flex-end' => [
							'title' => esc_html__( 'Right', 'stratum' ),
							'icon' => 'eicon-h-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider {{CURRENT_ITEM}} .stratum-advanced-slider__slide-wrapper' => 'align-items: {{VALUE}};'
					],
					'condition' => [
						'custom_alignment!' => '',
					],
				]
			);

			$repeater->add_responsive_control(
				'override_block_vertical_alignment',
				[
					'label' => esc_html__( 'Vertical Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'toggle' => true,
					'options' => [
						'flex-start'    => [
							'title' => esc_html__( 'Top', 'stratum' ),
							'icon' => 'eicon-v-align-top',
						],
						'center' => [
							'title' => esc_html__( 'Middle', 'stratum' ),
							'icon' => 'eicon-v-align-middle',
						],
						'flex-end' => [
							'title' => esc_html__( 'Bottom', 'stratum' ),
							'icon' => 'eicon-v-align-bottom',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider {{CURRENT_ITEM}} .stratum-advanced-slider__slide-wrapper' => 'justify-content: {{VALUE}};'
					],
					'condition' => [
						'custom_alignment!' => '',
					],
				]
			);

			$repeater->add_responsive_control(
				'override_sub_title_align',
				[
					'label' => esc_html__( 'Subtitle Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'toggle' => true,
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
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider {{CURRENT_ITEM}} .stratum-advanced-slider__sub-title' => 'text-align: {{VALUE}};',
					],
					'condition' => [
						'custom_alignment!' => '',
					],
				]
			);
			$repeater->add_responsive_control(
				'override_title_align',
				[
					'label' => esc_html__( 'Title Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'toggle' => true,
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
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider {{CURRENT_ITEM}} .stratum-advanced-slider__title' => 'text-align: {{VALUE}};',
					],
					'condition' => [
						'custom_alignment!' => '',
					],
				]
			);
			$repeater->add_responsive_control(
				'override_description_align',
				[
					'label' => esc_html__( 'Description Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'toggle' => true,
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
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider {{CURRENT_ITEM}} .stratum-advanced-slider__description' => 'text-align: {{VALUE}};',
					],
					'condition' => [
						'custom_alignment!' => '',
					],
				]
			);
			$repeater->add_responsive_control(
				'override_button_align',
				[
					'label' => esc_html__( 'Button Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'toggle' => true,
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
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider {{CURRENT_ITEM}} .stratum-advanced-slider__button' => 'text-align: {{VALUE}};',
					],
					'condition' => [
						'custom_alignment!' => '',
					],
					'separator' => 'after',
				]
			);

			$repeater->add_control(
				'image',
				[
					'label' => esc_html__( 'Image', 'stratum' ),
					'type' => Controls_Manager::MEDIA,
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
				]
			);

			$repeater->add_control(
				'image_attachment',
				[
					'label' => esc_html_x( 'Image Attachment', 'Background Control', 'stratum' ),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						'' => esc_html_x( 'Default', 'Background Control', 'stratum' ),
						'scroll' => esc_html_x( 'Scroll', 'Background Control', 'stratum' ),
						'fixed' => esc_html_x( 'Fixed', 'Background Control', 'stratum' ),
					],
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .stratum-advanced-slider__image' => 'background-attachment: {{VALUE}};',
					],
				]
			);

			$repeater->start_controls_tabs( 'image_style' );

				$repeater->start_controls_tab(
					'image_style_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

				$repeater->add_control(
					'image_position',
					[
						'label' => esc_html_x( 'Image Position', 'Background Control', 'stratum' ),
						'type' => Controls_Manager::SELECT,
						'options' => [
							'center center' => esc_html_x( 'Center Center', 'Background Control', 'stratum' ),
							'center left' => esc_html_x( 'Center Left', 'Background Control', 'stratum' ),
							'center right' => esc_html_x( 'Center Right', 'Background Control', 'stratum' ),
							'top center' => esc_html_x( 'Top Center', 'Background Control', 'stratum' ),
							'top left' => esc_html_x( 'Top Left', 'Background Control', 'stratum' ),
							'top right' => esc_html_x( 'Top Right', 'Background Control', 'stratum' ),
							'bottom center' => esc_html_x( 'Bottom Center', 'Background Control', 'stratum' ),
							'bottom left' => esc_html_x( 'Bottom Left', 'Background Control', 'stratum' ),
							'bottom right' => esc_html_x( 'Bottom Right', 'Background Control', 'stratum' ),
						],
						'default' => 'center center',
						'selectors' => [
							'{{WRAPPER}} {{CURRENT_ITEM}} .stratum-advanced-slider__image' => 'background-position: {{VALUE}};',
						],
					]
				);

				$repeater->end_controls_tab();

				$repeater->start_controls_tab(
					'image_style_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$repeater->add_control(
						'image_position_hover',
						[
							'label' => esc_html_x( 'Image Position', 'Background Control', 'stratum' ),
							'type' => Controls_Manager::SELECT,
							'options' => [
								'center center' => esc_html_x( 'Center Center', 'Background Control', 'stratum' ),
								'center left' => esc_html_x( 'Center Left', 'Background Control', 'stratum' ),
								'center right' => esc_html_x( 'Center Right', 'Background Control', 'stratum' ),
								'top center' => esc_html_x( 'Top Center', 'Background Control', 'stratum' ),
								'top left' => esc_html_x( 'Top Left', 'Background Control', 'stratum' ),
								'top right' => esc_html_x( 'Top Right', 'Background Control', 'stratum' ),
								'bottom center' => esc_html_x( 'Bottom Center', 'Background Control', 'stratum' ),
								'bottom left' => esc_html_x( 'Bottom Left', 'Background Control', 'stratum' ),
								'bottom right' => esc_html_x( 'Bottom Right', 'Background Control', 'stratum' ),
							],
							'default' => 'center center',
							'selectors' => [
								'{{WRAPPER}} {{CURRENT_ITEM}}:hover .stratum-advanced-slider__image' => 'background-position: {{VALUE}};',
							],
						]
					);

				$repeater->end_controls_tab();

			$repeater->end_controls_tabs();

			$controls->add_control(
				'slides',
				[
					'label' => esc_html__( 'Slides', 'stratum' ),
					'type'  => Controls_Manager::REPEATER,
					'show_label' => true,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'text' => sprintf( esc_html__( 'Item #%d', 'stratum' ), 1 )
						]
					]
				]
			);

		$controls->end_controls_section();

		//Section Carousel
        $sections->advanced_carousel(
			[
				'settings'   => Controls_Manager::TAB_LAYOUT,
				'navigation' => Controls_Manager::TAB_LAYOUT
			],
			[],
			[
				'auto_height'
			]
		);

		$controls->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$controls->add_control(
				'image_size',
				[
					'type'    => 'select',
					'label'   => esc_html__( 'Image Size', 'stratum' ),
					'default' => 'full',
					'options' => Stratum::get_instance()->get_scripts_manager()->get_image_sizes()
				]
			);

			$controls->add_responsive_control(
				'slide_paddings',
				[
					'label' => esc_html__( 'Padding', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__slide-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'horizontal_slides_height',
				[
					'label' => esc_html__( 'Height', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 100,
							'max' => 1000,
						],
						'vh' => [
							'min' => 10,
							'max' => 100,
						],
					],
					'default' => [
						'size' => 450,
					],
					'size_units' => [ 'px', 'vh', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider .swiper-slide' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'slider_direction' => 'horizontal'
					],
				]
			);

			$controls->add_responsive_control(
				'vertical_slides_height',
				[
					'label' => esc_html__( 'Height', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 100,
							'max' => 1000,
						],
						'vh' => [
							'min' => 10,
							'max' => 100,
						],
					],
					'default' => [
						'size' => 450,
					],
					'size_units' => [ 'px', 'vh', 'em' ],
					'render_type' => 'template',
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider .swiper-slide' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'slider_direction' => 'vertical'
					],
				]
			);

			$controls->add_responsive_control(
				'content_max_width',
				[
					'label' => esc_html__( 'Content Width', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'size_units' => [ '%', 'px' ],
					'default' => [
						'size' => '60',
						'unit' => '%',
					],
					'tablet_default' => [
						'unit' => '%',
					],
					'mobile_default' => [
						'unit' => '%',
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__slide-container' => 'max-width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'block_horizontal_alignment',
				[
					'label' => esc_html__( 'Horizontal Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'flex-start',
					'toggle' => false,
					'options' => [
						'flex-start'    => [
							'title' => esc_html__( 'Left', 'stratum' ),
							'icon' => 'eicon-h-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'stratum' ),
							'icon' => 'eicon-h-align-center',
						],
						'flex-end' => [
							'title' => esc_html__( 'Right', 'stratum' ),
							'icon' => 'eicon-h-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider__slide-wrapper' => 'align-items: {{VALUE}};'
					]
				]
			);

			$controls->add_responsive_control(
				'block_vertical_alignment',
				[
					'label' => esc_html__( 'Vertical Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'center',
					'toggle' => false,
					'options' => [
						'flex-start'    => [
							'title' => esc_html__( 'Top', 'stratum' ),
							'icon' => 'eicon-v-align-top',
						],
						'center' => [
							'title' => esc_html__( 'Middle', 'stratum' ),
							'icon' => 'eicon-v-align-middle',
						],
						'flex-end' => [
							'title' => esc_html__( 'Bottom', 'stratum' ),
							'icon' => 'eicon-v-align-bottom',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider__slide-wrapper' => 'justify-content: {{VALUE}};'
					]
				]
			);

			$controls->add_control(
				'animation_effect',
				[
					'label'   => esc_html__( 'Hover Animation Effect', 'stratum' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'none'   => esc_html__( 'None'  , 'stratum' ),
						'aries'  => esc_html__( 'Aries' , 'stratum' ),
						'taurus' => esc_html__( 'Taurus', 'stratum' ),
						'gemini' => esc_html__( 'Gemini', 'stratum' ),
						'cancer' => esc_html__( 'Cancer', 'stratum' ),
						'leo'    => esc_html__( 'Leo'   , 'stratum' ),
						'virgo'  => esc_html__( 'Virgo' , 'stratum' )
					]
				]
			);

			$controls->add_control(
				'text_animation_effect',
				[
					'label'   => esc_html__( 'Text Animation Effect', 'stratum' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'none'    		   => esc_html__( 'None'  		 , 'stratum' ),
						'opacity' 		   => esc_html__( 'Fade In' 	 , 'stratum' ),
						'opacity-top'      => esc_html__( 'Fade In Up'	 , 'stratum' ),
						'opacity-bottom'   => esc_html__( 'Fade In Down' , 'stratum' ),
						'opacity-left'     => esc_html__( 'Fade In Left' , 'stratum' ),
						'opacity-right'    => esc_html__( 'Fade In Right', 'stratum' ),
						'opacity-zoom-in'  => esc_html__( 'Zoom In'      , 'stratum' ),
						'opacity-zoom-out' => esc_html__( 'Zoom Out' 	 , 'stratum' )
					],
					'condition' => [
						'columns_count' => '1',
						'slides_in_columns' => '1'
					],
				]
			);

			$controls->add_control(
				'image_animation_speed',
				[
					'label' => esc_html__( 'Hover Image Animation Speed', 'stratum' ),
					'description' => esc_html__( 'In Seconds', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => 0.25,
					],
					'range' => [
						'px' => [
							'min' => 0.1,
							'max' => 2,
							'step' => 0.01,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider__image' => 'transition: all {{SIZE}}s linear',
						'{{WRAPPER}} .stratum-advanced-slider__overlay' => 'transition: all {{SIZE}}s linear',
					],
				]
			);

			$controls->add_control(
				'slide_text_animation_delay',
				[
					'label' => esc_html__( 'Text Animation Delay', 'stratum' ),
					'description' => esc_html__( 'In Milliseconds ', 'stratum' ),
					'type' => Controls_Manager::NUMBER,
					'default' => 500,
					'condition' => [
						'text_animation_effect!' => 'none',
						'columns_count' => '1',
						'slides_in_columns' => '1'
					],
				]
			);

			$controls->add_control(
				'slide_text_animation_speed',
				[
					'label' => esc_html__( 'Text Animation Speed', 'stratum' ),
					'description' => esc_html__( 'In Seconds', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => 0.35,
					],
					'range' => [
						'px' => [
							'min' => 0.1,
							'max' => 3,
							'step' => 0.01,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider__slide-container' => 'transition: all {{SIZE}}s linear',
					],
					'condition' => [
						'text_animation_effect!' => 'none',
						'columns_count' => '1',
						'slides_in_columns' => '1'
					],
				]
			);

			$controls->start_controls_tabs( 'overlay_styles' );

				$controls->start_controls_tab(
					'overlay_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$controls->add_control(
						'images_overlay_color',
						[
							'label' => esc_html__( 'Overlay Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '#00000057',
							'default' => '#00000057',
							'render_type' => 'ui',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__overlay' => 'background-color: {{VALUE}}',
							],
						]
					);

					$controls->add_control(
						'images_line_color',
						[
							'label' => esc_html__( 'Line Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '#fff',
							'default' => '#fff',
							'render_type' => 'ui',
							'condition' => [
								'animation_effect!' => 'none'
							],
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__slide-wrapper:before' => 'border-color: {{VALUE}}',
								'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__slide-wrapper:after' => 'border-color: {{VALUE}}',
							],
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'overlay_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'images_overlay_color_hover',
						[
							'label' => esc_html__( 'Overlay Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '#0000008A',
							'default' => '#0000008A',
							'render_type' => 'ui',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-slider:hover .stratum-advanced-slider__overlay' => 'background-color: {{VALUE}}',
							],
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

        $controls->end_controls_section();


		$controls->start_controls_section(
			'section_style_sub_title',
			[
				'label' => esc_html__( 'Subtitle', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$controls->add_responsive_control(
				'sub_title_align',
				[
					'label' => esc_html__( 'Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'left',
					'toggle' => false,
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
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__sub-title' => 'text-align: {{VALUE}};',
					],
				]
			);

			$controls->add_responsive_control(
				'sub_title_spacing',
				[
					'label' => esc_html__( 'Spacing', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__sub-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'sub_title_typography',
					'selector' => '{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__sub-title',
					'label'	=> esc_html__( 'Typography', 'stratum' ),
					'render_type' => 'template',
					'defaults' => [
						'html_tag' => 'div',
					],
				]
			);

			$controls->start_controls_tabs( 'sub_title_styles' );

				$controls->start_controls_tab(
					'sub_title_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$controls->add_control(
						'custom_sub_title_color',
						[
							'label'   => esc_html__( 'Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '#FFFFFF',
							'value'   => '#FFFFFF',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__sub-title' => 'color: {{VALUE}}',
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'sub_title_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'custom_hover_sub_title_color',
						[
							'label'   => esc_html__( 'Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '#FFFFFF',
							'value'   => '#FFFFFF',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-slider:hover .stratum-advanced-slider__sub-title' => 'color: {{VALUE}}',
							]
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_style_title',
			[
				'label' => esc_html__( 'Title', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$controls->add_responsive_control(
				'title_align',
				[
					'label' => esc_html__( 'Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'left',
					'toggle' => false,
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
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__title' => 'text-align: {{VALUE}};',
					],
				]
			);

			$controls->add_responsive_control(
				'title_spacing',
				[
					'label' => esc_html__( 'Spacing', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'selector' => '{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__title',
					'label'	=> esc_html__( 'Typography', 'stratum' ),
					'render_type' => 'template',
					'defaults' => [
						'html_tag' => 'h3',
					],
				]
			);

			$controls->start_controls_tabs( 'title_styles' );

				$controls->start_controls_tab(
					'title_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$controls->add_control(
						'custom_title_color',
						[
							'label'   => esc_html__( 'Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '#FFFFFF',
							'value'   => '#FFFFFF',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__title' => 'color: {{VALUE}}',
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'title_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'custom_hover_title_color',
						[
							'label'   => esc_html__( 'Title Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '#FFFFFF',
							'value'   => '#FFFFFF',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-slider:hover .stratum-advanced-slider__title' => 'color: {{VALUE}}',
							]
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_style_description',
			[
				'label' => esc_html__( 'Description', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$controls->add_responsive_control(
				'description_align',
				[
					'label' => esc_html__( 'Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'left',
					'toggle' => false,
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
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__description' => 'text-align: {{VALUE}};',
					],
				]
			);

			$controls->add_responsive_control(
				'description_spacing',
				[
					'label' => esc_html__( 'Spacing', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__description' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'description_typography',
					'selector' => '{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__description',
					'label'	=> esc_html__( 'Typography', 'stratum' ),
					'render_type' => 'template',
					'defaults' => [
						'html_tag' => 'div',
					],
				]
			);

			$controls->start_controls_tabs( 'description_styles' );

				$controls->start_controls_tab(
					'description_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$controls->add_control(
						'custom_description_color',
						[
							'label'   => esc_html__( 'Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '#FFFFFF',
							'value'   => '#FFFFFF',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__description' => 'color: {{VALUE}}',
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'description_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'custom_hover_description_color',
						[
							'label'   => esc_html__( 'Title Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '#FFFFFF',
							'value'   => '#FFFFFF',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-slider:hover .stratum-advanced-slider__description' => 'color: {{VALUE}}',
							]
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Button', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$controls->add_responsive_control(
				'button_align',
				[
					'label' => esc_html__( 'Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'left',
					'toggle' => false,
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
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__button' => 'text-align: {{VALUE}};',
					],
				]
			);

			$controls->add_responsive_control(
				'button_spacing',
				[
					'label' => esc_html__( 'Spacing', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__button' => 'margin-top: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'button_typography',
					'selector' => '{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__button a',
					'label'	=> esc_html__( 'Typography', 'stratum' ),
					'render_type' => 'template',
					'exclude' => ['html_tag']
				]
			);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'border',
					'label' => esc_html__( 'Border', 'stratum' ),
					'selector' => '{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__button a',
				]
			);

			$controls->add_control(
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
					'condition' => [
						'border_border!' => ''
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__button a' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'button_paddings',
				[
					'label' => esc_html__( 'Button Padding', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->start_controls_tabs( 'button_styles' );

				$controls->start_controls_tab(
					'button_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$controls->add_control(
						'button_color_font',
						[
							'label' => esc_html__( 'Button Font Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '#fff',
							'default' => '#fff',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__button a' => 'color: {{VALUE}}',
							],
						]
					);

					$controls->add_control(
						'button_color_background',
						[
							'label' => esc_html__( 'Button Background Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '',
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__button a' => 'background-color: {{VALUE}};',
							],
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'button_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'button_color_font_hover',
						[
							'label' => esc_html__( 'Button Font Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '#000',
							'default' => '#000',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__button a:hover' => 'color: {{VALUE}}',
							],
						]
					);
					$controls->add_control(
						'button_color_background_hover',
						[
							'label' => esc_html__( 'Button Background Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '#fff',
							'default' => '#fff',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-slider .stratum-advanced-slider__button a:hover' => 'background-color: {{VALUE}};',
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
	protected function content_template() {
    }

	public function render_plain_content( $instance = [] ) {}
}

Plugin::instance()->widgets_manager->register_widget_type( new Advanced_Slider() );