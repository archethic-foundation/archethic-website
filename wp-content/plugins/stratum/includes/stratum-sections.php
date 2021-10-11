<?php

namespace Stratum;

use \Elementor\Controls_Manager;
use \Elementor\Utils;
use \Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Sections {

	public $widget;

	public function __construct($widget) {
		$this->widget = $widget;
	}

	public function carousel() {
		$controls = $this->widget;

		$animation_in_arr = [
			'bounceIn' => 'BounceIn',
			'bounceInDown' => 'BounceInDown',
			'bounceInLeft' => 'BounceInLeft',
			'bounceInRight' => 'BounceInRight',
			'bounceInUp' => 'BounceInUp',
			'fadeIn' => 'FadeIn',
			'fadeInDown' => 'FadeInDown',
			'fadeInDownBig' => 'FadeInDownBig',
			'fadeInLeft' => 'FadeInLeft',
			'fadeInLeftBig' => 'FadeInLeftBig',
			'fadeInRight' => 'FadeInRight',
			'fadeInRightBig' => 'FadeInRightBig',
			'fadeInUp' => 'FadeInUp',
			'fadeInUpBig' => 'FadeInUpBig',
			'flipInX' => 'FlipInX',
			'flipInY' => 'FlipInY',
			'lightSpeedIn' => 'LightSpeedIn',
			'rotateIn' => 'RotateIn',
			'rotateInDownLeft' => 'RotateInDownLeft',
			'rotateInDownRight' => 'RotateInDownRight',
			'rotateInUpLeft' => 'RotateInUpLeft',
			'rotateInUpRight' => 'RotateInUpRight',
			'jackInTheBox' => 'JackInTheBox',
			'rollIn' => 'RollIn',
			'zoomIn' => 'ZoomIn',
			'zoomInDown' => 'ZoomInDown',
			'zoomInLeft' => 'ZoomInLeft',
			'zoomInRight' => 'ZoomInRight',
			'zoomInUp' => 'ZoomInUp',
			'slideInDown' => 'SlideInDown',
			'slideInLeft' => 'SlideInLeft',
			'slideInRight' => 'SlideInRight',
			'slideInUp' => 'SlideInUp'
		];

		$animation_out_arr = [
			'bounceOut' => 'BounceOut',
			'bounceOutDown' => 'BounceOutDown',
			'bounceOutLeft' => 'BounceOutLeft',
			'bounceOutRight' => 'BounceOutRight',
			'bounceOutUp' => 'BounceOutUp',
			'fadeOut' => 'FadeOut',
			'fadeOutDown' => 'FadeOutDown',
			'fadeOutDownBig' => 'FadeOutDownBig',
			'fadeOutLeft' => 'FadeOutLeft',
			'fadeOutLeftBig' => 'FadeOutLeftBig',
			'fadeOutRight' => 'FadeOutRight',
			'fadeOutRightBig' => 'FadeOutRightBig',
			'fadeOutUp' => 'FadeOutUp',
			'fadeOutUpBig' => 'FadeOutUpBig',
			'flipOutX' => 'FlipOutX',
			'flipOutY' => 'FlipOutY',
			'lightSpeedOut' => 'LightSpeedOut',
			'rotateOut' => 'RotateOut',
			'rotateOutDownLeft' => 'RotateOutDownLeft',
			'rotateOutDownRight' => 'RotateOutDownRight',
			'rotateOutUpLeft' => 'RotateOutUpLeft',
			'rotateOutUpRight' => 'RotateOutUpRight',
			'rollOut' => 'RollOut',
			'zoomOut' => 'ZoomOut',
			'zoomOutDown' => 'ZoomOutDown',
			'zoomOutLeft' => 'ZoomOutLeft',
			'zoomOutRight' => 'ZoomOutRight',
			'zoomOutUp' => 'ZoomOutUp',
			'slideOutDown' => 'SlideOutDown',
			'slideOutLeft' => 'SlideOutLeft',
			'slideOutRight' => 'SlideOutRight',
			'slideOutUp' => 'SlideOutUp'
		];

		$controls->start_controls_section(
			'section_carousel',
			[
				'label' => esc_html__( 'Carousel', 'stratum' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

			$slides_to_show = range( 1, 4 );
			$slides_to_show = array_combine( $slides_to_show, $slides_to_show );

			$controls->add_responsive_control(
				'slides_to_show',
				[
					'label' => esc_html__( 'Slides to Show', 'stratum' ),
					'type' => Controls_Manager::SELECT,
					'default' => '1',
					'tablet_default' => '1',
					'mobile_default' => '1',
					'options' => $slides_to_show,
					'frontend_available' => true,
				]
			);

			$controls->add_control(
				'navigation',
				[
					'label' => esc_html__( 'Navigation', 'stratum' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'both',
					'options' => [
						'both' => esc_html__( 'Arrows and Dots', 'stratum' ),
						'arrows' => esc_html__( 'Arrows', 'stratum' ),
						'dots' => esc_html__( 'Dots', 'stratum' ),
						'none' => esc_html__( 'None', 'stratum' ),
					],
					'frontend_available' => true,
				]
			);

			$controls->add_control(
				'auto_height',
				[
					'label' => esc_html__( 'Auto Height', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
				]
			);

			$controls->add_control(
				'item_margins',
				[
					'label' => esc_html__( 'Item margins', 'stratum' ),
					"description"	=> esc_html__( 'In Pixels (px)', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 10,
					],
				]
			);

			$controls->add_control(
				'item_stage_paddings',
				[
					'label' => esc_html__( 'Stage paddings', 'stratum' ),
					"description"	=> esc_html__( 'In Pixels (px)', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 0,
					],
				]
			);

			$controls->add_control(
				'item_center',
				[
					'label' => esc_html__( 'Center item', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
				]
			);

			$controls->add_control(
				'autoplay',
				[
					'label' => esc_html__( 'Autoplay', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
				]
			);

			$controls->add_control(
				'autoplay_speed',
				[
					'label' => esc_html__( 'Autoplay speed', 'stratum' ),
					'type' => Controls_Manager::NUMBER,
					'min' => 100,
					'max' => 10000,
					'step' => 1000,
					'default' => 3000,
					'condition' => [
						'autoplay' => 'yes'
					],
				]
			);

			$controls->add_control(
				'pause_on_hover',
				[
					'label' => esc_html__( 'Pause on Hover', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
					'condition' => [
						'autoplay' => 'yes'
					],
				]
			);

			$controls->add_control(
				'infinite',
				[
					'label' => esc_html__( 'Infinite Loop', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
					'condition' => [
						'slides_in_columns' => '1',
					],
				]
			);

			$controls->add_control(
				'animation_in',
				[
					'label' => esc_html__( 'Animation (In)', 'stratum' ),
					'type' => Controls_Manager::SELECT2,
					'default' => 'default',
					'options' => [
						'default' => esc_html__( 'Default', 'stratum' ),
					] + $animation_in_arr,
					'condition' => [
						'slides_to_show' => '1',
					],
					'frontend_available' => true,
				]
			);

			$controls->add_control(
				'animation_out',
				[
					'label' => esc_html__( 'Animation (Out)', 'stratum' ),
					'type' => Controls_Manager::SELECT2,
					'default' => 'default',
					'options' => [
						'default' => esc_html__( 'Default', 'stratum' ),
					] + $animation_out_arr,
					'condition' => [
						'slides_to_show' => '1',
					],
					'frontend_available' => true,
				]
			);

			$controls->add_control(
				'animation_speed',
				[
					'label' => esc_html__( 'Animation Speed', 'stratum' ),
					'type' => Controls_Manager::NUMBER,
					'default' => 250,
					'frontend_available' => true,
				]
			);

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_style_navigation',
			[
				'label' => esc_html__( 'Navigation', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'relation' => 'and',
							'terms' => [
								[
									'name' => 'use_carousel',
									'operator' => '==',
									'value' => 'yes'
								]
							]
						], [
							'relation' => 'or',
							'terms' => [
								[
									'name' => 'navigation',
									'operator' => '==',
									'value' => 'arrows'
								], [
									'name' => 'navigation',
									'operator' => '==',
									'value' => 'dots'
								], [
									'name' => 'navigation',
									'operator' => '==',
									'value' => 'both'
								]
							]
						]
					]
				]
			]
		);

			$controls->add_control(
				'heading_style_arrows',
				[
					'label' => esc_html__( 'Arrows', 'stratum' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'navigation' => [ 'arrows', 'both' ],
					],
				]
			);

			$controls->add_control(
				'arrows_position',
				[
					'label' => esc_html__( 'Position', 'stratum' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'inside',
					'options' => [
						'inside' => esc_html__( 'Inside', 'stratum' ),
						'outside' => esc_html__( 'Outside', 'stratum' ),
					],
					'condition' => [
						'navigation' => [ 'arrows', 'both' ],
					],
				]
			);

			$controls->add_control(
				'arrows_size',
				[
					'label' => esc_html__( 'Size', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 20,
							'max' => 60,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-image-carousel-wrapper .slick-slider .slick-prev:before, {{WRAPPER}} .elementor-image-carousel-wrapper .slick-slider .slick-next:before' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'navigation' => [ 'arrows', 'both' ],
					],
				]
			);

			$controls->add_control(
				'arrows_color',
				[
					'label' => esc_html__( 'Color', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-image-carousel-wrapper .slick-slider .slick-prev:before, {{WRAPPER}} .elementor-image-carousel-wrapper .slick-slider .slick-next:before' => 'color: {{VALUE}};',
					],
					'condition' => [
						'navigation' => [ 'arrows', 'both' ],
					],
				]
			);

			$controls->add_control(
				'heading_style_dots',
				[
					'label' => esc_html__( 'Dots', 'stratum' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'navigation' => [ 'dots', 'both' ],
					],
				]
			);

			$controls->add_control(
				'dots_position',
				[
					'label' => esc_html__( 'Position', 'stratum' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'outside',
					'options' => [
						'outside' => esc_html__( 'Outside', 'stratum' ),
						'inside' => esc_html__( 'Inside', 'stratum' ),
					],
					'condition' => [
						'navigation' => [ 'dots', 'both' ],
					],
				]
			);

			$controls->add_control(
				'dots_size',
				[
					'label' => esc_html__( 'Size', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 5,
							'max' => 10,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-image-carousel-wrapper .elementor-image-carousel .slick-dots li button:before' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'navigation' => [ 'dots', 'both' ],
					],
				]
			);

			$controls->add_control(
				'dots_color',
				[
					'label' => esc_html__( 'Color', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-image-carousel-wrapper .elementor-image-carousel .slick-dots li button:before' => 'color: {{VALUE}};',
					],
					'condition' => [
						'navigation' => [ 'dots', 'both' ],
					],
				]
			);

		$controls->end_controls_section();

	}

	public function advanced_carousel($tabs = ['settings' => Controls_Manager::TAB_LAYOUT, 'navigation' => Controls_Manager::TAB_LAYOUT], $condition = [], $disable_controls = [])
	{
		$controls = $this->widget;

		// Section Carousel
		$controls->start_controls_section(
			'section_carousel',
			[
				'label' => esc_html__( 'Carousel Settings', 'stratum' ),
				'tab' => $tabs['settings'],
			] + (!empty($condition) ? [
				'condition' => $condition
				] : []
			)
		);

			$slides_view = range( 1, 4 );
			$slides_view = array_combine( $slides_view, $slides_view );

			$controls->add_responsive_control(
				'columns_count', //slidesPerView
				[
					'label' => esc_html__( 'Columns', 'stratum' ),
					'type' => Controls_Manager::SELECT,
					'default' => '1',
					'tablet_default' => '1',
					'mobile_default' => '1',
					'options' => [
						'auto' => esc_html__( 'Auto', 'stratum' ),
					] + $slides_view,
					'frontend_available' => true,
				]
			);

			$slides_in_columns = range( 1, 4 );
			$slides_in_columns = array_combine( $slides_in_columns, $slides_in_columns );

			$controls->add_responsive_control(
				'slides_in_columns', //slidesPerColumn
				[
					'label' => esc_html__( 'Rows', 'stratum' ),
					'type' => Controls_Manager::SELECT,
					'default' => '1',
					'tablet_default' => '1',
					'mobile_default' => '1',
					'options' => $slides_in_columns,
					'frontend_available' => true,
					'condition' => [
						'columns_count!' => 'auto',
						'slider_direction' => 'horizontal',
					],
				]
			);

			$slides_scroll = range( 1, 4 );
			$slides_scroll = array_combine( $slides_scroll, $slides_scroll );

			$controls->add_responsive_control(
				'slides_to_scroll', //slidesPerGroup
				[
					'label' => esc_html__( 'Slides to scroll', 'stratum' ),
					'type' => Controls_Manager::SELECT,
					'default' => '1',
					'tablet_default' => '1',
					'mobile_default' => '1',
					'options' => $slides_scroll,
					'frontend_available' => true,
				]
			);

			$controls->add_control(
				'slider_direction', //direction
				[
					'label' => esc_html__( 'Slider direction', 'stratum' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'horizontal',
					'options' => [
						'horizontal' => esc_html__( 'Horizontal', 'stratum' ),
						'vertical' => esc_html__( 'Vertical', 'stratum' ),
					],
					'render_type' => 'template',
					'prefix_class' => 'stratum-swiper-direction-',
					'frontend_available' => true,
				]
			);

			$controls->add_control(
				'auto_height', //autoHeight
				[
					'label' => esc_html__( 'Auto height', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
					'condition' => [
						'slides_in_columns' => '1',
						'slider_direction!' => 'vertical',
						'free_mode' => '',
					],
				]
			);

			$controls->add_control(
				'navigation', //navigation, pagination
				[
					'label' => esc_html__( 'Navigation', 'stratum' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'both',
					'options' => [
						'both' => esc_html__( 'Arrows and Pagination', 'stratum' ),
						'arrows' => esc_html__( 'Arrows', 'stratum' ),
						'pagination' => esc_html__( 'Pagination', 'stratum' ),
						'none' => esc_html__( 'None', 'stratum' ),
					],
					'frontend_available' => true,
				]
			);


			$controls->add_control(
				'pagination_style', //pagination type
				[
					'label' => esc_html__( 'Pagination style', 'stratum' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'bullets',
					'options' => [
						'bullets' => esc_html__( 'Bullets', 'stratum' ), //pagination clickable
						'fraction' => esc_html__( 'Numbers', 'stratum' ),
						'progressbar' => esc_html__( 'Progress bar', 'stratum' ),
						'scrollbar' => esc_html__( 'Scrollbar', 'stratum' ), //scrollbar draggable
					],
					'condition' => [
						'navigation' => ['both', 'pagination']
					],
					'frontend_available' => true,
				]
			);

			$controls->add_control(
				'dynamic_bullets', //dynamicBullets
				[
					'label' => esc_html__( 'Dynamic Bullets', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
					'condition' => [
						'navigation' => ['both', 'pagination'],
						'pagination_style' => 'bullets',
					],
				]
			);

			$controls->add_control(
				'keyboard_control', //keyboard enabled
				[
					'label' => esc_html__( 'Keyboard Control', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
				]
			);

			$controls->add_control(
				'mousewheel_control', //mousewheel
				[
					'label' => esc_html__( 'Mousewheel Control', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
				]
			);

			$controls->add_control(
				'item_center', //centeredSlides
				[
					'label' => esc_html__( 'Center item', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
					'condition' => [
						'columns_count!' => ['auto','1'],
					],
				]
			);

			$controls->add_responsive_control(
				'spacing_slides', //spaceBetween
				[
					'label' => esc_html__( 'Spacing between slides', 'stratum' ),
					'description' => esc_html__( 'In Pixels (px)', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 200,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 0,
					],
					'tablet_default' => [
						'unit' => 'px',
						'size' => 0,
					],
					'mobile_default' => [
						'unit' => 'px',
						'size' => 0,
					],
				]
			);

			$controls->add_control(
				'free_mode', //freeMode
				[
					'label' => esc_html__( 'Free Move mode', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
				]
			);

			$controls->add_control(
				'slide_effects', //effect
				[
					'label' => esc_html__( 'Slide effects', 'stratum' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'slide',
					'options' => [
						'slide' => esc_html__( 'Slide', 'stratum' ),
						'fade' => esc_html__( 'Fade', 'stratum' ),
						'cube' => esc_html__( 'Cube', 'stratum' ),
						'coverflow' => esc_html__( 'Coverflow', 'stratum' ),
					],
					'frontend_available' => true,
				]
			);

			$controls->add_control(
				'coverflow_visible', //centeredSlides
				[
					'label' => esc_html__( 'Coverflow visible', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
					'description'	=> esc_html__( 'Works only if "Stretch Section" option is enabled', 'stratum' ),
					'return_value' => 'visible',
					'prefix_class' => 'stratum-coverflow-',
					'condition' => [
						'slide_effects' => 'coverflow',
						'slider_direction' => 'horizontal',
					],
				]
			);

			$controls->add_control(
				'autoplay', //autoplay
				[
					'label' => esc_html__( 'Autoplay', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
				]
			);

			$controls->add_control(
				'autoplay_speed', //delay
				[
					'label' => esc_html__( 'Autoplay speed', 'stratum' ),
					'type' => Controls_Manager::NUMBER,
					'min' => 100,
					'max' => 10000,
					'step' => 1000,
					'default' => 3000,
					'condition' => [
						'autoplay' => 'yes'
					],
				]
			);

			$controls->add_control(
				'pause_on_hover', //autoplay start or autoplay stop
				[
					'label' => esc_html__( 'Pause on Hover', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'condition' => [
						'autoplay' => 'yes'
					],
				]
			);

			$controls->add_control(
				'loop', //loop
				[
					'label' => esc_html__( 'Infinite Loop', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
				]
			);

			$controls->add_control(
				'animation_speed', //speed
				[
					'label' => esc_html__( 'Animation Speed', 'stratum' ),
					'type' => Controls_Manager::NUMBER,
					'default' => 300,
					'frontend_available' => true,
				]
			);

			$controls->add_control(
				'simulate_touch', //simulate_touch
				[
					'label'   => esc_html__( 'Simulate Touch', 'stratum' ),
					'description' => esc_html__( 'Disable click and swipe slide change on touch screens.', 'stratum' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => '',
				]
			);

		$controls->end_controls_section();

		$navigation_condition = [
			'relation' => 'and',
			'terms' => [
				[
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'navigation',
							'operator' => '==',
							'value' => 'arrows'
						], [
							'name' => 'navigation',
							'operator' => '==',
							'value' => 'pagination'
						], [
							'name' => 'navigation',
							'operator' => '==',
							'value' => 'both'
						]
					]
				]
			]
		];

		if (!empty($condition)){
			//Get condition from params
			$condition_key = array_keys($condition)[0];
			$condition_val = array_values($condition)[0];

			$navigation_condition['terms'][] =
			[
				'relation' => 'and',
				'terms' => [
					[
						'name' => $condition_key,
						'operator' => '==',
						'value' => $condition_val
					]
				]
			];
		}

		$controls->start_controls_section(
			'section_style_navigation',
			[
				'label' => esc_html__( 'Navigation style', 'stratum' ),
				'tab' => $tabs['navigation'],
				'conditions' => $navigation_condition
			]
		);

			//Arrows
			$controls->add_control(
				'heading_style_arrows',
				[
					'label' => esc_html__( 'Arrows', 'stratum' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'navigation' => [ 'arrows', 'both' ],
					],
				]
			);

			$controls->add_control(
				'arrows_position',
				[
					'label' => esc_html__( 'Position', 'stratum' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'inside',
					'options' => [
						'inside' => esc_html__( 'Inside', 'stratum' ),
						'outside' => esc_html__( 'Outside', 'stratum' ),
					],
					'condition' => [
						'navigation' => [ 'arrows', 'both' ],
					],
					'render_type' => 'template',
					'prefix_class' => 'stratum-navigation-arrow-position-',
				]
			);

			$controls->add_control(
				'arrows_size',
				[
					'label' => esc_html__( 'Size', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 16,
							'max' => 50,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 16,
					],
					'render_type' => 'template',
					'selectors' => [
						'{{WRAPPER}} .stratum-swiper-button-prev, {{WRAPPER}} .stratum-swiper-button-next' => 'font-size: {{SIZE}}{{UNIT}};',

						//Outside

							//horizontal
							'{{WRAPPER}}.stratum-navigation-arrow-position-outside.stratum-swiper-direction-horizontal .stratum-swiper-button-prev, {{WRAPPER}}.stratum-navigation-arrow-position-outside.stratum-swiper-direction-horizontal .stratum-swiper-button-next' => 'width: calc( ({{arrows_spacing.SIZE}}{{arrows_spacing.UNIT}}/2) + {{SIZE}}{{UNIT}} );',
							'{{WRAPPER}}.stratum-navigation-arrow-position-outside.stratum-swiper-direction-horizontal .elementor-widget-container > div' => 'margin-left: calc( {{arrows_offset.SIZE}}{{arrows_offset.UNIT}} + ( ({{arrows_spacing.SIZE}}{{arrows_spacing.UNIT}}/2) + {{SIZE}}{{UNIT}} ) ); margin-right: calc( {{arrows_offset.SIZE}}{{arrows_offset.UNIT}} + ( ({{arrows_spacing.SIZE}}{{arrows_spacing.UNIT}}/2) + {{SIZE}}{{UNIT}} ) );',

							//vertical
							'{{WRAPPER}}.stratum-navigation-arrow-position-outside.stratum-swiper-direction-vertical .stratum-swiper-button-prev, {{WRAPPER}}.stratum-navigation-arrow-position-outside.stratum-swiper-direction-vertical .stratum-swiper-button-next' => 'height: calc( ({{arrows_spacing.SIZE}}{{arrows_spacing.UNIT}}/2) + {{SIZE}}{{UNIT}} );',
							'{{WRAPPER}}.stratum-navigation-arrow-position-outside.stratum-swiper-direction-vertical .elementor-widget-container > div' => 'margin-top: calc( {{arrows_offset.SIZE}}{{arrows_offset.UNIT}} + ( ({{arrows_spacing.SIZE}}{{arrows_spacing.UNIT}}/2) + {{SIZE}}{{UNIT}} ) ); margin-bottom: calc( {{arrows_offset.SIZE}}{{arrows_offset.UNIT}} + ( ({{arrows_spacing.SIZE}}{{arrows_spacing.UNIT}}/2) + {{SIZE}}{{UNIT}} ) );',

						//Inside

							//horizontal
							'{{WRAPPER}}.stratum-navigation-arrow-position-inside.stratum-swiper-direction-horizontal .stratum-swiper-button-prev, {{WRAPPER}}.stratum-navigation-arrow-position-inside.stratum-swiper-direction-horizontal .stratum-swiper-button-next' => 'width: calc( ({{arrows_spacing.SIZE}}{{arrows_spacing.UNIT}}/2) + {{SIZE}}{{UNIT}} );',
							'{{WRAPPER}}.stratum-navigation-arrow-position-inside.stratum-swiper-direction-horizontal .stratum-swiper-button-prev' => 'left: calc( {{arrows_offset.SIZE}}{{arrows_offset.UNIT}} + ( ({{arrows_spacing.SIZE}}{{arrows_spacing.UNIT}}/2) ) );',
							'{{WRAPPER}}.stratum-navigation-arrow-position-inside.stratum-swiper-direction-horizontal .stratum-swiper-button-next' => 'right: calc( {{arrows_offset.SIZE}}{{arrows_offset.UNIT}} + ( ({{arrows_spacing.SIZE}}{{arrows_spacing.UNIT}}/2) ) );',

							//vertical
							'{{WRAPPER}}.stratum-navigation-arrow-position-inside.stratum-swiper-direction-vertical .stratum-swiper-button-prev, {{WRAPPER}}.stratum-navigation-arrow-position-inside.stratum-swiper-direction-vertical .stratum-swiper-button-next' => 'height: calc( ({{arrows_spacing.SIZE}}{{arrows_spacing.UNIT}}/2) + {{SIZE}}{{UNIT}} );',
							'{{WRAPPER}}.stratum-navigation-arrow-position-inside.stratum-swiper-direction-vertical .stratum-swiper-button-prev' => 'top: calc( {{arrows_offset.SIZE}}{{arrows_offset.UNIT}} + ( ({{arrows_spacing.SIZE}}{{arrows_spacing.UNIT}}/2) ) );',
							'{{WRAPPER}}.stratum-navigation-arrow-position-inside.stratum-swiper-direction-vertical .stratum-swiper-button-next' => 'bottom: calc( {{arrows_offset.SIZE}}{{arrows_offset.UNIT}} + ( ({{arrows_spacing.SIZE}}{{arrows_spacing.UNIT}}/2) ) );',
					],
					'condition' => [
						'navigation' => [ 'arrows', 'both' ],
					],
				]
			);

			$controls->add_control(
				'arrows_spacing',
				[
					'label' => esc_html__( 'Spacing', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 200,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 10,
					],
					'render_type' => 'template',
					'condition' => [
						'navigation' => [ 'arrows', 'both' ],
					],
				]
			);

			$controls->add_control(
				'arrows_offset',
				[
					'label' => esc_html__( 'Offset', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 200,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 0,
					],
					'render_type' => 'template',
					'condition' => [
						'navigation' => [ 'arrows', 'both' ],
					],
				]
			);

			$controls->add_control(
				'arrows_color',
				[
					'label' => esc_html__( 'Color', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'default' => $this->widget->default_arrows_color,
					'value'   => $this->widget->default_arrows_color,
					'selectors' => [
						'{{WRAPPER}} .stratum-swiper-button-prev, {{WRAPPER}} .stratum-swiper-button-next' => 'color: {{VALUE}};',
					],
					'condition' => [
						'navigation' => [ 'arrows', 'both' ],
					],
				]
			);

			//Bullets
			$controls->add_control(
				'heading_style_bullets',
				[
					'label' => esc_html__( 'Bullets', 'stratum' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'navigation' => [ 'pagination', 'both' ],
						'pagination_style' => [ 'bullets' ],
					],
				]
			);

			$controls->add_control(
				'bullets_squared',
				[
					'label' => esc_html__( 'Square bullets', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
					'prefix_class' => 'stratum-navigation-bullets-',
					'return_value' => 'squared',
					'condition' => [
						'navigation' => [ 'pagination', 'both' ],
						'pagination_style' => [ 'bullets' ],
					],
				]
			);

			$controls->add_control(
				'bullets_size',
				[
					'label' => esc_html__( 'Size', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 1,
							'max' => 10,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 6,
					],
					'selectors' => [
						'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'navigation' => [ 'pagination', 'both' ],
						'pagination_style' => [ 'bullets' ],
					],
				]
			);

			$controls->add_control(
				'bullets_spacing',
				[
					'label' => esc_html__( 'Spacing', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 1,
							'max' => 10,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 6,
					],
					'selectors' => [
						'{{WRAPPER}} .swiper-container-horizontal>.swiper-pagination-bullets .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .swiper-container-vertical>.swiper-pagination-bullets .swiper-pagination-bullet' => 'margin: {{SIZE}}{{UNIT}} 0;',
					],
					'condition' => [
						'navigation' => [ 'pagination', 'both' ],
						'pagination_style' => [ 'bullets' ],
					],
				]
			);

			$controls->add_control(
				'bullets_color',
				[
					'label' => esc_html__( 'Color', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'navigation' => [ 'pagination', 'both' ],
						'pagination_style' => [ 'bullets' ],
					],
				]
			);

			//Numbers
			$controls->add_control(
				'heading_style_fraction',
				[
					'label' => esc_html__( 'Numbers', 'stratum' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'navigation' => [ 'pagination', 'both' ],
						'pagination_style' => [ 'fraction' ],
					],
				]
			);

			$controls->add_control(
				'fraction_color',
				[
					'label' => esc_html__( 'Color', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .swiper-pagination.swiper-pagination-fraction' => 'color: {{VALUE}};',
					],
					'condition' => [
						'navigation' => [ 'pagination', 'both' ],
						'pagination_style' => [ 'fraction' ],
					],
				]
			);

			//Progress bar
			$controls->add_control(
				'heading_style_progressbar',
				[
					'label' => esc_html__( 'Progress bar', 'stratum' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'navigation' => [ 'pagination', 'both' ],
						'pagination_style' => [ 'progressbar' ],
					],
				]
			);

			$controls->add_control(
				'progressbar_size',
				[
					'label' => esc_html__( 'Size', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 1,
							'max' => 10,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 4,
					],
					'selectors' => [
						'{{WRAPPER}} .swiper-container-horizontal>.swiper-pagination-progressbar' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'navigation' => [ 'pagination', 'both' ],
						'pagination_style' => [ 'progressbar' ],
					],
				]
			);

			$controls->add_control(
				'progressbar_color',
				[
					'label' => esc_html__( 'Color', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .swiper-pagination-progressbar .swiper-pagination-progressbar-fill' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'navigation' => [ 'pagination', 'both' ],
						'pagination_style' => [ 'progressbar' ],
					],
				]
			);

			//Scrollbar
			$controls->add_control(
				'heading_style_scrollbar',
				[
					'label' => esc_html__( 'Scrollbar', 'stratum' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'navigation' => [ 'pagination', 'both' ],
						'pagination_style' => [ 'scrollbar' ],
					],
				]
			);

			$controls->add_control(
				'scrollbar_squared',
				[
					'label' => esc_html__( 'Square Scrollbar', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => '',
					'prefix_class' => 'stratum-navigation-scrollbar-',
					'return_value' => 'squared',
					'condition' => [
						'navigation' => [ 'pagination', 'both' ],
						'pagination_style' => [ 'scrollbar' ],
					],
				]
			);

			$controls->add_control(
				'scrollbar_size',
				[
					'label' => esc_html__( 'Size', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 1,
							'max' => 10,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 5,
					],
					'selectors' => [
						'{{WRAPPER}} .swiper-container-horizontal>.swiper-scrollbar' => 'height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .swiper-container-vertical>.swiper-scrollbar' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'navigation' => [ 'pagination', 'both' ],
						'pagination_style' => [ 'scrollbar' ],
					],
				]
			);

			$controls->add_control(
				'scrollbar_color',
				[
					'label' => esc_html__( 'Color', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .swiper-container-horizontal>.swiper-scrollbar .swiper-scrollbar-drag' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .swiper-container-vertical>.swiper-scrollbar .swiper-scrollbar-drag' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'navigation' => [ 'pagination', 'both' ],
						'pagination_style' => [ 'scrollbar' ],
					],
				]
			);
		$controls->end_controls_section();

		//Disable controls
		if (!empty($disable_controls)){
			Plugin::instance()->controls_manager->remove_control_from_stack( $controls->get_unique_name(), $disable_controls );
		}
	}
}