<?php
/**
 * Class: Flip_box
 * Name: Flip Box
 * Slug: flip-box
 */

namespace Stratum;

use \Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use \Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Flip_box extends Stratum_Widget_Base {
	protected $widget_name = 'flip-box';

	public function __construct($data = [], $args = null) {
		parent::__construct( $data, $args );
	}

	public function get_title() {
		return esc_html__( 'Flip Box', 'stratum' );
	}

	public function get_icon() {
		return 'stratum-icon-flip-box';
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
        /*	 Content Tab
        /*-----------------------------------------------------------------------------------*/

        $controls->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'General Settings', 'stratum' )
			]
		);

			$controls->add_control(
				'flip_effect',
				[
					'label'       => esc_html__( 'Flip Effect', 'stratum' ),
					'type' 		  => Controls_Manager::SELECT,
					'default' 	  => 'flip',
					'label_block' => false,
					'options' => [
						'flip'     => esc_html__( 'Flip'    , 'stratum' ),
						'slide'    => esc_html__( 'Slide'   , 'stratum' ),
						'push'     => esc_html__( 'Push'    , 'stratum' ),
						'fade'     => esc_html__( 'Fade'    , 'stratum' ),
						'zoom-in'  => esc_html__( 'Zoom In' , 'stratum' ),
						'zoom-out' => esc_html__( 'Zoom Out', 'stratum' )
					]
				]
			);

			$controls->add_control(
				'flip_direction',
				[
					'label'       => esc_html__( 'Flip Direction', 'stratum' ),
					'type' 		  => Controls_Manager::SELECT,
					'default' 	  => 'right',
					'label_block' => false,
					'options' => [
						'right' => esc_html__( 'Right' , 'stratum' ),
						'left'  => esc_html__( 'Left'  , 'stratum' ),
						'up'    => esc_html__( 'Up'   , 'stratum' ),
						'down'  => esc_html__( 'Down', 'stratum' )
					],
					'condition' => [
						'flip_effect!' => [
							'fade',
							'zoom-in',
							'zoom-out'
						]
					]
				]
			);

			$controls->add_responsive_control(
				'height',
				[
					'label' => esc_html__( 'Height', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 100,
							'max' => 1000
						],
						'vh' => [
							'min' => 10,
							'max' => 100
						]
					],
					'size_units' => [ 'px', 'vh' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box' => 'height: {{SIZE}}{{UNIT}};'
					]
				]
			);

			$controls->add_control(
				'border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 200
						]
					],
					'separator' => 'after',
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__layer' => 'border-radius: {{SIZE}}{{UNIT}}'
					]
				]
			);

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_front_content',
			[
				'label' => esc_html__( 'Front', 'stratum' )
			]
		);

			$controls->start_controls_tabs( 'front_content_tabs' );

				$controls->start_controls_tab( 'front_content_tab', [ 'label' => esc_html__( 'Content', 'stratum' ) ] );

					$controls->add_control(
						'graphic_element',
						[
							'label' => esc_html__( 'Graphic Element', 'stratum' ),
							'type' => Controls_Manager::CHOOSE,
							'options' => [
								'icon' => [
									'title' => esc_html__( 'Icon', 'stratum' ),
									'icon' => 'eicon-star'
								],
								'image' => [
									'title' => esc_html__( 'Image', 'stratum' ),
									'icon' => 'fas fa-image'
								],
								'none' => [
									'title' => esc_html__( 'None', 'stratum' ),
									'icon' => 'eicon-ban'
								],
							],
							'default' => 'icon'
						]
					);

					$controls->add_control(
						'selected_icon',
						[
							'label'   => esc_html__( 'Icon', 'stratum' ),
							'type'    => Controls_Manager::ICON,
							'default' => 'fas fa-star',
							'label_block' => true,
							'condition' => [
								'graphic_element' => 'icon'
							]
						]
					);

					$controls->add_control(
						'icon_view',
						[
							'label' => esc_html__( 'View', 'stratum' ),
							'type' => Controls_Manager::SELECT,
							'options' => [
								'default' => esc_html__( 'Default', 'stratum' ),
								'stacked' => esc_html__( 'Stacked', 'stratum' ),
								'framed'  => esc_html__( 'Framed' , 'stratum' )
							],
							'default' => 'default',
							'condition' => [
								'graphic_element' => 'icon'
							]
						]
					);

					$controls->add_control(
						'icon_shape',
						[
							'label' => esc_html__( 'Shape', 'stratum' ),
							'type'  => Controls_Manager::SELECT,
							'options' => [
								'circle' => esc_html__( 'Circle', 'stratum' ),
								'square' => esc_html__( 'Square', 'stratum' )
							],
							'default' => 'circle',
							'condition' => [
								'icon_view!' => 'default',
								'graphic_element' => 'icon'
							]
						]
					);

					$controls->add_control(
						'image',
						[
							'label' => esc_html__( 'Choose Image', 'stratum' ),
							'type' => Controls_Manager::MEDIA,
							'default' => [
								'url' => Utils::get_placeholder_image_src()
							],
							'dynamic' => [
								'active' => true
							],
							'condition' => [
								'graphic_element' => 'image'
							]
						]
					);

					$controls->add_control(
						'image_size',
						[
							'type'    => 'select',
							'label'   => esc_html__( 'Image Size', 'stratum' ),
							'default' => 'full',
							'options' => Stratum::get_instance()->get_scripts_manager()->get_image_sizes(),
							'condition' => [
								'graphic_element' => 'image'
							]
						]
					);

					$controls->add_control(
						'front_title_text',
						[
							'label' => esc_html__( 'Title & Description', 'stratum' ),
							'type'  => Controls_Manager::TEXT,
							'default' => esc_html__( 'This is the title', 'stratum' ),
							'placeholder' => esc_html__( 'Enter your title', 'stratum' ),
							'dynamic' => [
								'active' => true
							],
							'label_block' => true,
							'separator'   => 'before'
						]
					);

					$controls->add_control(
						'front_description_text',
						[
							'label' => esc_html__( 'Description', 'stratum' ),
							'type' => Controls_Manager::TEXTAREA,
							'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'stratum' ),
							'placeholder' => esc_html__( 'Enter your description', 'stratum' ),
							'separator' => 'none',
							'dynamic'   => [
								'active' => true
							],
							'rows' => 10,
							'show_label' => false
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab( 'front_background_tab', [ 'label' => esc_html__( 'Background', 'stratum' ) ] );

					$controls->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name' => 'front_background',
							'types' => [ 'classic', 'gradient' ],
							'selector' => '{{WRAPPER}} .stratum-flip-box__front'
						]
					);

					$controls->add_control(
						'front_background_overlay',
						[
							'label' => esc_html__( 'Background Overlay', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-flip-box__front .stratum-flip-box__layer__overlay' => 'background-color: {{VALUE}};'
							],
							'separator' => 'before',
							'condition' => [
								'front_background_image[id]!' => ''
							]
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_back_content',
			[
				'label' => esc_html__( 'Back', 'stratum' )
			]
		);

			$controls->start_controls_tabs( 'back_content_tabs' );

				$controls->start_controls_tab( 'back_content_tab', [ 'label' => esc_html__( 'Content', 'stratum' ) ] );

					$controls->add_control(
						'back_title_text',
						[
							'label' => esc_html__( 'Title & Description', 'stratum' ),
							'type'  => Controls_Manager::TEXT,
							'default' => esc_html__( 'This is the title', 'stratum' ),
							'placeholder' => esc_html__( 'Enter your title', 'stratum' ),
							'dynamic' => [
								'active' => true
							],
							'label_block' => true,
							'separator'   => 'before'
						]
					);

					$controls->add_control(
						'back_description_text',
						[
							'label' => esc_html__( 'Description', 'stratum' ),
							'type' => Controls_Manager::TEXTAREA,
							'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'stratum' ),
							'placeholder' => esc_html__( 'Enter your description', 'stratum' ),
							'separator' => 'none',
							'dynamic'   => [
								'active' => true
							],
							'rows' => 10,
							'show_label' => false
						]
					);

					$controls->add_control(
						'show_button',
						[
							'label' => esc_html__( 'Show button', 'stratum' ),
							'type'  => Controls_Manager::SWITCHER,
							'default' => '',
							'separator' => 'before'
						]
					);

					$controls->add_control(
						'button_text',
						[
							'label' => esc_html__( 'Button Text', 'stratum' ),
							'type' => Controls_Manager::TEXT,
							'default' => esc_html__( 'Click Here', 'stratum' ),
							'dynamic' => [
								'active' => true
							],
							'condition' => [
								'show_button!' => ''
							],
						]
					);

					$controls->add_control(
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
							'placeholder' => esc_html__( 'https://your-link.com', 'stratum' )
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab( 'back_background_tab', [ 'label' => esc_html__( 'Background', 'stratum' ) ] );

					$controls->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name' => 'back_background',
							'types' => [ 'classic', 'gradient' ],
							'selector' => '{{WRAPPER}} .stratum-flip-box__back',
						]
					);

					$controls->add_control(
						'back_background_overlay',
						[
							'label' => esc_html__( 'Background Overlay', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-flip-box__back .stratum-flip-box__layer__overlay' => 'background-color: {{VALUE}};'
							],
							'separator' => 'before',
							'condition' => [
								'back_background_image[id]!' => ''
							]
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
        /*	 Style Tab
        /*-----------------------------------------------------------------------------------*/

		$controls->start_controls_section(
			'section_syle_front',
			[
				'label' => esc_html__( 'Front', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

			$controls->add_responsive_control(
				'front_padding',
				[
					'label' => esc_html__( 'Padding', 'stratum' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-flip-box__front .stratum-flip-box__layer__overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

			$controls->add_control(
				'front_alignment',
				[
					'label' => esc_html__( 'Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'stratum' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'stratum' ),
							'icon' => 'eicon-text-align-center'
						],
						'right' => [
							'title' => esc_html__( 'Right', 'stratum' ),
							'icon' => 'eicon-text-align-right'
						],
					],
					'default' => 'center',
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__front .stratum-flip-box__layer__inner' => 'text-align: {{VALUE}}'
					]
				]
			);

			$controls->add_responsive_control(
				'front_vertical_position',
				[
					'label' => esc_html__( 'Vertical Position', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'top' => [
							'title' => esc_html__( 'Top', 'stratum' ),
							'icon' => 'eicon-v-align-top'
						],
						'middle' => [
							'title' => esc_html__( 'Middle', 'stratum' ),
							'icon' => 'eicon-v-align-middle'
						],
						'bottom' => [
							'title' => esc_html__( 'Bottom', 'stratum' ),
							'icon' => 'eicon-v-align-bottom'
						]
					],
					'selectors_dictionary' => [
						'top' => 'flex-start',
						'middle' => 'center',
						'bottom' => 'flex-end'
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__front .stratum-flip-box__layer__overlay' => 'justify-content: {{VALUE}}'
					],
					'default'   => 'middle',
					'separator' => 'after'
				]
			);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'front_border',
					'selector' => '{{WRAPPER}} .stratum-flip-box__front',
					'separator' => 'before'
				]
			);

			$controls->add_control(
				'heading_icon_style',
				[
					'type' => Controls_Manager::HEADING,
					'label' => esc_html__( 'Icon', 'stratum' ),
					'condition' => [
						'graphic_element' => 'icon'
					],
					'separator' => 'before'
				]
			);

			$controls->add_responsive_control(
				'icon_spacing',
				[
					'label' => esc_html__( 'Spacing', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100
						]
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__icon-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};'
					],
					'condition' => [
						'graphic_element' => 'icon'
					]
				]
			);

			$controls->add_control(
				'icon_primary_color',
				[
					'label' => esc_html__( 'Primary Color', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .stratum-view-default .stratum-flip-box__icon' => 'color: {{VALUE}}',
						'{{WRAPPER}} .stratum-view-stacked .stratum-flip-box__icon' => 'background-color: {{VALUE}}',
						'{{WRAPPER}} .stratum-view-framed  .stratum-flip-box__icon' => 'border-color: {{VALUE}}'
					],
					'condition' => [
						'graphic_element' => 'icon',
					],
				]
			);

			$controls->add_control(
				'icon_secondary_color',
				[
					'label' => esc_html__( 'Secondary Color', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'condition' => [
						'graphic_element' => 'icon',
						'icon_view!' => 'default'
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__icon' => 'color: {{VALUE}};'
					]
				]
			);

			$controls->add_responsive_control(
				'icon_size',
				[
					'label' => esc_html__( 'Icon Size', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 6,
							'max' => 300
						]
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__icon' => 'font-size: {{SIZE}}{{UNIT}};'
					],
					'condition' => [
						'graphic_element' => 'icon'
					]
				]
			);

			$controls->add_responsive_control(
				'icon_padding',
				[
					'label' => esc_html__( 'Icon Padding', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__icon' => 'padding: {{SIZE}}{{UNIT}};'
					],
					'range' => [
						'em' => [
							'min' => 0,
							'max' => 5
						]
					],
					'condition' => [
						'graphic_element' => 'icon',
						'icon_view!' => 'default'
					]
				]
			);

			$controls->add_responsive_control(
				'icon_rotate',
				[
					'label' => esc_html__( 'Icon Rotation', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'deg' => [
							'min'  => 0,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'  => [
						'unit' => 'deg'
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__icon i' => 'transform: rotate({{SIZE}}deg);'
					],
					'condition' => [
						'graphic_element' => 'icon'
					]
				]
			);

			$controls->add_responsive_control(
				'icon_border_width',
				[
					'label' => esc_html__( 'Border Width', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__icon' => 'border-width: {{SIZE}}{{UNIT}}'
					],
					'condition' => [
						'graphic_element' => 'icon',
						'icon_view' => 'framed'
					]
				]
			);

			$controls->add_responsive_control(
				'icon_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
					'condition' => [
						'graphic_element' => 'icon',
						'icon_view!' => 'default',
						'icon_shape!' => 'circle'
					]
				]
			);

			$controls->add_control(
				'heading_image_style',
				[
					'type' => Controls_Manager::HEADING,
					'label' => esc_html__( 'Image', 'stratum' ),
					'condition' => [
						'graphic_element' => 'image'
					],
					'separator' => 'before'
				]
			);

			$controls->add_responsive_control(
				'image_spacing',
				[
					'label' => esc_html__( 'Spacing', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100
						]
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__image' => 'margin-bottom: {{SIZE}}{{UNIT}};'
					],
					'condition' => [
						'graphic_element' => 'image'
					]
				]
			);

			$controls->add_responsive_control(
				'image_width',
				[
					'label' => esc_html__( 'Size', 'stratum' ) . ' (%)',
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ '%' ],
					'default' => [
						'unit' => '%'
					],
					'range' => [
						'%' => [
							'min' => 5,
							'max' => 100
						]
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__image img' => 'width: {{SIZE}}{{UNIT}}'
					],
					'condition' => [
						'graphic_element' => 'image'
					]
				]
			);

			$controls->add_control(
				'image_opacity',
				[
					'label' => esc_html__( 'Opacity', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => 1,
					],
					'range' => [
						'px' => [
							'max' => 1,
							'min' => 0.10,
							'step' => 0.01
						]
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__image' => 'opacity: {{SIZE}};'
					],
					'condition' => [
						'graphic_element' => 'image'
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'image_border',
					'selector' => '{{WRAPPER}} .stratum-flip-box__image img',
					'condition' => [
						'graphic_element' => 'image'
					],
					'separator' => 'before'
				]
			);

			$controls->add_responsive_control(
				'image_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 200
						]
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__image img' => 'border-radius: {{SIZE}}{{UNIT}}'
					],
					'condition' => [
						'graphic_element' => 'image'
					]
				]
			);

			$controls->add_control(
				'front_heading_title_style',
				[
					'type' => Controls_Manager::HEADING,
					'label' => esc_html__( 'Title', 'stratum' ),
					'separator' => 'before',
					'condition' => [
						'front_title_text!' => ''
					]
				]
			);

			$controls->add_responsive_control(
				'front_title_spacing',
				[
					'label' => esc_html__( 'Spacing', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100
						]
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__front .stratum-flip-box__title' => 'margin-bottom: {{SIZE}}{{UNIT}};'
					],
					'condition' => [
						'front_description_text!' => '',
						'front_title_text!' => ''
					]
				]
			);

			$controls->add_control(
				'front_title_color',
				[
					'label' => esc_html__( 'Text Color', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__front .stratum-flip-box__title' => 'color: {{VALUE}}'

					],
					'condition' => [
						'front_title_text!' => ''
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'front_title_typography',
					'scheme' => Schemes\Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .stratum-flip-box__front .stratum-flip-box__title',
					'condition' => [
						'front_title_text!' => ''
					]
				]
			);

			$controls->add_control(
				'front_heading_description_style',
				[
					'type' => Controls_Manager::HEADING,
					'label' => esc_html__( 'Description', 'stratum' ),
					'separator' => 'before',
					'condition' => [
						'front_description_text!' => ''
					]
				]
			);

			$controls->add_control(
				'front_description_color',
				[
					'label' => esc_html__( 'Text Color', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__front .stratum-flip-box__description' => 'color: {{VALUE}}'
					],
					'condition' => [
						'front_description_text!' => ''
					]
				]
			);

			$controls->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'front_description_typography',
					'scheme' => Schemes\Typography::TYPOGRAPHY_3,
					'selector' => '{{WRAPPER}} .stratum-flip-box__front .stratum-flip-box__description',
					'condition' => [
						'front_description_text!' => ''
					]
				]
			);

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_syle_back',
			[
				'label' => esc_html__( 'Back', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

			$controls->add_responsive_control(
				'back_padding',
				[
					'label' => esc_html__( 'Padding', 'stratum' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-flip-box__back .stratum-flip-box__layer__overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

			$controls->add_responsive_control(
				'back_alignment',
				[
					'label' => esc_html__( 'Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'stratum' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'stratum' ),
							'icon' => 'eicon-text-align-center'
						],
						'right' => [
							'title' => esc_html__( 'Right', 'stratum' ),
							'icon' => 'eicon-text-align-right'
						],
					],
					'default' => 'center',
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__back .stratum-flip-box__layer__inner' => 'text-align: {{VALUE}}'
					]
				]
			);

			$controls->add_responsive_control(
				'back_vertical_position',
				[
					'label' => esc_html__( 'Vertical Position', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'top' => [
							'title' => esc_html__( 'Top', 'stratum' ),
							'icon' => 'eicon-v-align-top'
						],
						'middle' => [
							'title' => esc_html__( 'Middle', 'stratum' ),
							'icon' => 'eicon-v-align-middle'
						],
						'bottom' => [
							'title' => esc_html__( 'Bottom', 'stratum' ),
							'icon' => 'eicon-v-align-bottom'
						]
					],
					'selectors_dictionary' => [
						'top' => 'flex-start',
						'middle' => 'center',
						'bottom' => 'flex-end'
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__back .stratum-flip-box__layer__overlay' => 'justify-content: {{VALUE}}'
					],
					'default'   => 'middle',
					'separator' => 'after'
				]
			);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'back_border',
					'selector' => '{{WRAPPER}} .stratum-flip-box__back',
					'separator' => 'before'
				]
			);

			$controls->add_control(
				'back_heading_title_style',
				[
					'type' => Controls_Manager::HEADING,
					'label' => esc_html__( 'Title', 'stratum' ),
					'separator' => 'before',
					'condition' => [
						'back_title_text!' => ''
					]
				]
			);

			$controls->add_responsive_control(
				'back_title_spacing',
				[
					'label' => esc_html__( 'Spacing', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100
						]
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__back .stratum-flip-box__title' => 'margin-bottom: {{SIZE}}{{UNIT}};'
					],
					'condition' => [
						'back_description_text!' => '',
						'back_title_text!' => ''
					]
				]
			);

			$controls->add_control(
				'back_title_color',
				[
					'label' => esc_html__( 'Text Color', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__back .stratum-flip-box__title' => 'color: {{VALUE}}'

					],
					'condition' => [
						'back_title_text!' => ''
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'back_title_typography',
					'scheme' => Schemes\Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .stratum-flip-box__back .stratum-flip-box__title',
					'condition' => [
						'back_title_text!' => ''
					]
				]
			);

			$controls->add_control(
				'back_heading_description_style',
				[
					'type' => Controls_Manager::HEADING,
					'label' => esc_html__( 'Description', 'stratum' ),
					'separator' => 'before',
					'condition' => [
						'back_description_text!' => ''
					]
				]
			);

			$controls->add_control(
				'back_description_color',
				[
					'label' => esc_html__( 'Text Color', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__back .stratum-flip-box__description' => 'color: {{VALUE}}'
					],
					'condition' => [
						'back_description_text!' => ''
					]
				]
			);

			$controls->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'back_description_typography',
					'scheme' => Schemes\Typography::TYPOGRAPHY_3,
					'selector' => '{{WRAPPER}} .stratum-flip-box__back .stratum-flip-box__description',
					'condition' => [
						'back_description_text!' => ''
					]
				]
			);

			$controls->add_responsive_control(
				'back_description_spacing',
				[
					'label' => esc_html__( 'Spacing', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100
						]
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-flip-box__back .stratum-flip-box__description' => 'margin-bottom: {{SIZE}}{{UNIT}};'
					],
					'condition' => [
						'back_description_text!' => '',
						'back_title_text!' => ''
					]
				]
			);

			$controls->add_control(
				'heading_button',
				[
					'type' => Controls_Manager::HEADING,
					'label' => esc_html__( 'Button', 'stratum' ),
					'separator' => 'before',
					'condition' => [
						'button_text!' => '',
						'show_button!' => ''
					]
				]
			);

			$controls->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'button_typography',
					'selector' => '{{WRAPPER}} .stratum-flip-box__button',
					'scheme' => Schemes\Typography::TYPOGRAPHY_4,
					'condition' => [
						'button_text!' => '',
						'show_button!' => ''
					]
				]
			);

			$controls->start_controls_tabs( 'button_tabs' );

				$controls->start_controls_tab( 'normal',
					[
						'label' => esc_html__( 'Normal', 'stratum' ),
						'condition' => [
							'button_text!' => '',
							'show_button!' => ''
						]
					]
				);

					$controls->add_control(
						'button_text_color',
						[
							'label' => esc_html__( 'Text Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-flip-box__button' => 'color: {{VALUE}};'
							],
						]
					);

					$controls->add_control(
						'button_background_color',
						[
							'label' => esc_html__( 'Background Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-flip-box__button' => 'background-color: {{VALUE}};'
							],
						]
					);

					$controls->add_control(
						'button_border_color',
						[
							'label' => esc_html__( 'Border Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-flip-box__button' => 'border-color: {{VALUE}};',
							],
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'hover',
					[
						'label' => esc_html__( 'Hover', 'stratum' ),
						'condition' => [
							'button_text!' => '',
							'show_button!' => ''
						]
					]
				);

					$controls->add_control(
						'button_hover_text_color',
						[
							'label' => esc_html__( 'Text Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-flip-box__button:hover' => 'color: {{VALUE}};'
							]
						]
					);

					$controls->add_control(
						'button_hover_background_color',
						[
							'label' => esc_html__( 'Background Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-flip-box__button:hover' => 'background-color: {{VALUE}};'
							]
						]
					);

					$controls->add_control(
						'button_hover_border_color',
						[
							'label' => esc_html__( 'Border Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-flip-box__button:hover' => 'border-color: {{VALUE}};'
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
						'{{WRAPPER}} .stratum-flip-box__button' => 'border-width: {{SIZE}}{{UNIT}};'
					],
					'separator' => 'before',
					'condition' => [
						'button_text!' => '',
						'show_button!' => ''
					]
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
						'{{WRAPPER}} .stratum-flip-box__button' => 'border-radius: {{SIZE}}{{UNIT}};'
					],
					'separator' => 'after',
					'condition' => [
						'button_text!' => '',
						'show_button!' => ''
					]
				]
			);

		$controls->end_controls_section();
	}

	protected function render() {
		$this->render_widget( 'php' );
	}

	public function flip_box_render_icon($settings) {
		$out = '';
		$icon_wrapper = $this->get_render_attribute_string( 'icon-wrapper' );
		$icon = $settings['selected_icon'];

		$out .= "<div ".$icon_wrapper."'>";
			$out .= "<div class='".esc_attr( $this->get_name().'__icon' )."'>";
				$out .= "<i class='".esc_attr( $icon )."'></i>";
			$out .= "</div>";
		$out .= "</div>";

		return $out;
	}

	public function flip_box_render_image($image, $image_size) {
		$out = '';
		$id = $image[ 'id' ];

		if ( !empty( $id ) ) {
			$url = wp_get_attachment_image_url( $image[ 'id' ], $image_size );
			$srcset = wp_get_attachment_image_srcset( $image[ 'id' ], $image_size );
		}

		$out .= "<div class='".esc_attr( $this->get_name().'__image' )."'>";
			$out .= "<img src='".(empty( $id ) ? Utils::get_placeholder_image_src() : esc_url( $url ))."' class='".esc_attr( $this->get_name().'__image' ).(!empty( $id ) ? " wp-image-".esc_attr( $id ) : '' ).(!empty( $id ) ? "' srcset='".$srcset : '')."'/>";
		$out .= "</div>";

		return $out;
	}

	public function flip_box_render_button($button_text, $link) {
		$out = '';
		$this->add_render_attribute( 'button', 'class', [
			'stratum-flip-box__button'
		]);
		if ( ! empty( $link['url'] ) ) {
			$this->add_link_attributes( 'button', $link );
		}
		$button_class = $this->get_render_attribute_string( 'button' );
		$out .= "<a ".(empty($link['url']) ? "href='#' " : '').$button_class.">".esc_html( $button_text )."</a>";

		return $out;
	}

	protected function content_template() {}
	public function render_plain_content( $instance = [] ) {}
}

Plugin::instance()->widgets_manager->register_widget_type( new Flip_box() );