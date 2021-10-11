<?php
/**
 * Class: Banner
 * Name: Banner
 * Slug: stratum-banner
 */

namespace Stratum;

use \Elementor\Controls_Manager;
use \Elementor\Utils;
use \Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Banner extends Stratum_Widget_Base {
	protected $widget_name = 'banner';

	public function get_title() {
		return esc_html__( 'Banner', 'stratum' );
	}

	public function get_icon() {
		return 'stratum-icon-banner';
	}

	public function get_categories() {
		return [ 'stratum-widgets' ];
	}

    protected function _register_controls() {
		$controls = $this;

		//Colors
		$theme_colors_first_color = '#080808';

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
			'image',
			[
				'label'   => esc_html__( 'Image', 'stratum' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src()
				],
				'dynamic' => [ 'active' => true ],
				'condition' => [
					'background_type' => 'image'
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
					'background_type' => 'image'
				]
			]
		);

		$this->add_control(
			'hosted_url',
			[
				'label' => esc_html__( 'Choose File', 'stratum' ),
				'type' => Controls_Manager::MEDIA,
				'media_type' => 'video',
				'condition' => [
					'background_type' => 'video'
				]
			]
		);

		$controls->add_control(
			'background_type',
			array(
				'type'  => 'select',
				'label' => esc_html__( 'Background Type', 'stratum' ),
				'default' => 'image',
				'options' => [
					'image'   => esc_html__( 'Image', 'stratum' ),
					'video'   => esc_html__( 'Video', 'stratum' )
				]
			)
		);

		$controls->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'stratum' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title', 'stratum' ),
				'dynamic' => [ 'active' => true ]
			]
		);

		$controls->add_control(
			'text',
			[
				'label'   => esc_html__( 'Description', 'stratum' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'stratum' ),
				'dynamic' => [ 'active' => true ]
			]
		);

		$controls->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'stratum' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Paste URL or type to search', 'stratum' )
			]
		);

		$controls->add_control(
			'link_target',
			[
				'label'        => esc_html__( 'Open link in new window', 'stratum' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => '_blank',
				'condition'    => [
					'link!' => ''
				]
			]
		);

		$controls->add_control(
			'link_rel',
			[
				'label'        => esc_html__( 'Add nofollow', 'stratum' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'nofollow',
				'condition'    => [
					'link!' => ''
				]
			]
		);

		$controls->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
        /*	Style Tab
        /*-----------------------------------------------------------------------------------*/

		$controls->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$controls->add_responsive_control(
			'height',
			[
				'label'     => esc_html__( 'Banner Height', 'stratum' ),
				'type'      => Controls_Manager::NUMBER,
				'dynamic'   => [ 'active' => true ],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .stratum-banner__wrapper' => 'height: {{VALUE}}px;'
				]
			]
		);

		$controls->add_responsive_control(
			'block_paddings',
			[
				'label' => esc_html__( 'Padding', 'stratum' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
				'selectors' => [
					'{{WRAPPER}} .stratum-banner .stratum-banner__content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$controls->add_control(
			'animation_effect',
			[
				'label'   => esc_html__( 'Animation Effect', 'stratum' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'aries',
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
				]
			]
		);

		$controls->add_responsive_control(
			'title_align',
			[
				'label' => esc_html__( 'Title Alignment', 'stratum' ),
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
					'{{WRAPPER}} .stratum-banner .stratum-banner__title' => 'text-align: {{VALUE}};',
				],
			]
		);

		$controls->add_group_control(
			Stratum_Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .stratum-banner__title',
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
			'title_width',
			[
				'label'     => esc_html__( 'Title Width', 'stratum' ),
				'type'      => Controls_Manager::NUMBER,
				'dynamic'   => [ 'active' => true ],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .stratum-banner__title' => 'max-width: {{VALUE}}px;'
				]
			]
		);

		$controls->add_responsive_control(
			'text_align',
			[
				'label' => esc_html__( 'Text Alignment', 'stratum' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'left',
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
					'{{WRAPPER}} .stratum-banner .stratum-banner__text' => 'text-align: {{VALUE}};',
				],
			]
		);

		$controls->add_group_control(
			Stratum_Group_Control_Typography::get_type(),
			[
				'name' => 'subtitles_typography',
				'selector' => '{{WRAPPER}} .stratum-banner__text',
				'label'	=> esc_html__( 'Description Typography', 'stratum' ),
				'render_type' => 'template',
				'condition' => [
					'text!' => ''
				],
				'defaults' => [
					'html_tag' => 'h5',
				],
			]
		);

		$controls->add_responsive_control(
			'text_width',
			[
				'label'     => esc_html__( 'Description Width', 'stratum' ),
				'type'      => Controls_Manager::NUMBER,
				'dynamic'   => [ 'active' => true ],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .stratum-banner__text' => 'max-width: {{VALUE}}px;'
				]
			]
		);

		$controls->add_responsive_control(
			'block_horizontal_alignment',
			[
				'label' => esc_html__( 'Block Horizontal Alignment', 'stratum' ),
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
					'{{WRAPPER}} .stratum-banner__content-wrapper' => 'align-items: {{VALUE}};'
				]
			]
		);

		$controls->add_responsive_control(
			'block_vertical_alignment',
			[
				'label' => esc_html__( 'Block Vertical Alignment', 'stratum' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'flex-end',
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
					'{{WRAPPER}} .stratum-banner__content-wrapper' => 'justify-content: {{VALUE}};'
				]
			]
		);

		$controls->start_controls_tabs( 'banner_styles' );

			$controls->start_controls_tab(
				'banner_normal',
				array(
					'label' => esc_html__( 'Normal', 'stratum' ),
				)
			);

				$controls->add_control(
					'opacity',
					[
						'label' => esc_html__( 'Overlay Opacity', 'stratum' ),
						'type' => Controls_Manager::SLIDER,
						'default' => [
							'size' => 0.35
						],
						'range' => [
							'px' => [
								'max' => 1,
								'min' => 0,
								'step' => 0.01
							]
						],
						'selectors' => [
							'{{WRAPPER}} .stratum-banner__wrapper .stratum-banner__overlay' => 'opacity: {{SIZE}};'
						]
					]
				);

				$controls->add_control(
					'custom_overlay_color',
					[
						'label'   => esc_html__( 'Overlay Color', 'stratum' ),
						'type'    => Controls_Manager::COLOR,
						'default' => $theme_colors_first_color,
						'value'   => $theme_colors_first_color,
						'selectors' => [
							'{{WRAPPER}} .stratum-banner__wrapper .stratum-banner__overlay' => 'background-color: {{VALUE}}'
						]
					]
				);

				$controls->add_control(
					'custom_title_color',
					[
						'label'   => esc_html__( 'Title Color', 'stratum' ),
						'type'    => Controls_Manager::COLOR,
						'default' => '#FFFFFF',
						'value'   => '#FFFFFF',
						'selectors' => [
							'{{WRAPPER}} .stratum-banner__wrapper .stratum-banner__title' => 'color: {{VALUE}}',
						]
					]
				);

				$controls->add_control(
					'custom_text_color',
					[
						'label'   => esc_html__( 'Text Color', 'stratum' ),
						'type'    => Controls_Manager::COLOR,
						'default' => '#FFFFFF',
						'value'   => '#FFFFFF',
						'selectors' => [
							'{{WRAPPER}} .stratum-banner__wrapper .stratum-banner__text' => 'color: {{VALUE}}'
						]
					]
				);

			$controls->end_controls_tab();

			$controls->start_controls_tab(
				'banner_hover',
				array(
					'label' => esc_html__( 'Hover', 'stratum' ),
				)
			);

				$controls->add_control(
					'custom_hover_opacity',
					[
						'label' => esc_html__( 'Overlay Opacity', 'stratum' ),
						'type' => Controls_Manager::SLIDER,
						'default' => [
							'size' => 0.5
						],
						'range' => [
							'px' => [
								'max' => 1,
								'min' => 0,
								'step' => 0.01
							]
						],
						'selectors' => [
							'{{WRAPPER}} .stratum-banner__wrapper:hover .stratum-banner__overlay' => 'opacity: {{SIZE}};'
						]
					]
				);

				$controls->add_control(
					'custom_hover_overlay_color',
					[
						'label'   => esc_html__( 'Overlay Color', 'stratum' ),
						'type'    => Controls_Manager::COLOR,
						'default' => $theme_colors_first_color,
						'value'   => $theme_colors_first_color,
						'selectors' => [
							'{{WRAPPER}} .stratum-banner__wrapper:hover .stratum-banner__overlay' => 'background-color: {{VALUE}}'
						]
					]
				);

				$controls->add_control(
					'custom_hover_title_color',
					[
						'label'   => esc_html__( 'Title Color', 'stratum' ),
						'type'    => Controls_Manager::COLOR,
						'default' => '#FFFFFF',
						'value'   => '#FFFFFF',
						'selectors' => [
							'{{WRAPPER}} .stratum-banner__wrapper:hover .stratum-banner__title' => 'color: {{VALUE}}',
							'{{WRAPPER}} .stratum-banner__wrapper .stratum-banner__content-wrapper:before' => 'border-color: {{VALUE}}',
							'{{WRAPPER}} .stratum-banner__wrapper .stratum-banner__content-wrapper:after' => 'border-color: {{VALUE}}',
						]
					]
				);

				$controls->add_control(
					'custom_hover_text_color',
					[
						'label'   => esc_html__( 'Text Color', 'stratum' ),
						'type'    => Controls_Manager::COLOR,
						'default' => '#FFFFFF',
						'value'   => '#FFFFFF',
						'selectors' => [
							'{{WRAPPER}} .stratum-banner__wrapper:hover .stratum-banner__text' => 'color: {{VALUE}}'
						]
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

Plugin::instance()->widgets_manager->register_widget_type( new Banner() );