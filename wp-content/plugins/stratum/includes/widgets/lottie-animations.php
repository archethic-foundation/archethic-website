<?php
/**
 * Class: Lottie_Animations
 * Name: Lottie Animations
 * Slug: lottie-animations
 */

namespace Stratum;

use \Elementor\Plugin;
use Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Lottie_Animations extends Stratum_Widget_Base {
	protected $widget_name = 'lottie-animations';

	public function __construct($data = [], $args = null) {
		parent::__construct( $data, $args );
	}

	public function get_title() {
		return esc_html__( 'Lottie Animations', 'stratum' );
	}

	public function get_icon() {
		return 'stratum-icon-lottie-animations';
	}

	public function get_categories() {
		return [ 'stratum-widgets' ];
	}

	public function get_script_depends() {
		return [
			'lottie-animations-api'
        ];
    }

    protected function _register_controls() {
		$controls = $this;

		/*-----------------------------------------------------------------------------------*/
        /*	Content Tab
        /*-----------------------------------------------------------------------------------*/

        $controls->start_controls_section(
			'general_settings',
			[
				'label' => esc_html__( 'General Settings', 'stratum' )
			]
		);

			$controls->add_control(
				'lottie_url',
				[
					'label' => esc_html__( 'Animation JSON URL', 'stratum' ),
					'type'  => Controls_Manager::TEXT,
					'dynamic' => [ 'active' => true ],
					'description' => 'Get JSON code URL from <a href="https://lottiefiles.com/" target="_blank">here</a>',
					'label_block' => true
				]
			);

			$controls->add_control(
				'lottie_loop',
				[
					'label' => esc_html__( 'Loop','stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'return_value' => 'true',
					'default'      => ''
				]
			);

			$controls->add_control(
				'lottie_reverse',
				[
					'label' => esc_html__( 'Reverse', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'return_value' => 'true',
					'default' => '',
					'condition' => [
						'lottie_loop' => 'true',
					]
				]
			);

			$controls->add_control(
				'lottie_hover',
				[
					'label' => esc_html__( 'Only Play on Hover','stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'return_value'  => 'true',
					'default' => ''
				]
			);

			$controls->add_control(
				'lottie_speed',
				[
					'label'   => esc_html__( 'Animation Speed', 'stratum' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 1,
					'min'     => 0.1,
					'max'     => 3,
					'step'    => 0.1
				]
			);

			$controls->add_control(
				'animate_on_scroll',
				[
					'label' => esc_html__( 'Animate On Scroll', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'return_value'  => 'false',
					'condition' => [
						'lottie_hover!'   => 'true',
						'lottie_reverse!' => 'true'
					]
				]
			);

			$controls->add_control(
				'animate_speed',
				[
					'label' => esc_html__( 'Speed', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'default' => [
						'size' => 4
					],
					'range' => [
						'px' => [
							'max' => 10,
							'step' => 0.1
						]
					],
					'condition'     => [
						'lottie_hover!' => 'true',
						'animate_on_scroll' => 'true',
						'lottie_reverse!'   => 'true'
					]
				]
			);

			$controls->add_control(
				'animate_view',
				[
					'label' => esc_html__( 'Viewport', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'default' => [
						'sizes' => [
							'start' => 0,
							'end' => 100
						],
						'unit' => '%'
					],
					'labels' => [
						esc_html__( 'Bottom', 'stratum' ),
						esc_html__( 'Top', 'stratum' )
					],
					'scales' => 1,
					'handles' => 'range',
					'condition' => [
						'lottie_hover!' => 'true',
						'animate_on_scroll' => 'true',
						'lottie_reverse!'   => 'true'
					]
				]
			);

			$controls->add_responsive_control(
				'animation_size',
				[
					'label' => esc_html__( 'Size', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'size_units' => ['px', 'em', '%'],
					'default'    => [
						'unit' => 'px',
						'size' => 600
					],
					'range' => [
						'px' => [
							'min' => 1,
							'max' => 800
						],
						'em' => [
							'min' => 1,
							'max' => 30
						]
					],
					'render_type' => 'template',
					'separator'   => 'before',
					'selectors'   => [
						'{{WRAPPER}} .stratum-lottie-animations__wrapper' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}'
					]
				]
			);

			$controls->add_control(
				'lottie_rotate',
				[
					'label' => esc_html__( 'Rotate (degrees)', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'description' => esc_html__( 'Set rotation value in degress', 'stratum' ),
					'range' => [
						'px' => [
							'min' => -180,
							'max' => 180
						]
					],
					'default' => [
						'size' => 0
					],
					'selectors'     => [
						'{{WRAPPER}} .stratum-lottie-animations__wrapper' => 'transform: rotate({{SIZE}}deg)'
					]
				]
			);

			$controls->add_responsive_control(
				'animation_align',
				[
					'label' => esc_html__( 'Alignment', 'stratum' ),
					'type'  => Controls_Manager::CHOOSE,
					'options' => [
						'flex-start' => [
							'title'=> esc_html__( 'Left', 'stratum' ),
							'icon' => 'fa fa-align-left'
						],
						'center' => [
							'title'=> esc_html__( 'Center', 'stratum' ),
							'icon' => 'fa fa-align-center'
						],
						'flex-end' => [
							'title'=> esc_html__( 'Right', 'stratum' ),
							'icon' => 'fa fa-align-right'
						]
					],
					'default' => 'center',
					'toggle'  => false,
					'separator' => 'before',
					'selectors' => [
						'{{WRAPPER}} .stratum-lottie-animations' => 'justify-content: {{VALUE}}'
					]
				]
			);

			$controls->add_control(
				'lottie_renderer',
				[
					'label'   => esc_html__( 'Render As', 'stratum' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
						'svg'    => esc_html__( 'SVG', 'stratum' ),
						'canvas' => esc_html__( 'Canvas', 'stratum' )
					],
					'default'      => 'svg',
					'prefix_class' => 'stratum-lottie-',
					'render_type'  => 'template',
					'label_block'  => true,
					'separator'    => 'before'
				]
			);

			$controls->add_control('render_notice',
				[
					'raw'   => esc_html__( 'Set render type to canvas if you\'re having performance issues on the page.', 'stratum' ),
					'type' => Controls_Manager::RAW_HTML,
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info'
				]
			);

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_lottie_style',
			[
				'label' => esc_html__( 'Animation', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'show_label' => false
			]
		);

			$controls->start_controls_tabs( 'tabs_lottie' );

				$controls->start_controls_tab(
					'tab_lottie_normal',
					[
						'label' => esc_html__( 'Normal', 'stratum' )
					]
				);

					$controls->add_control(
						'lottie_background',
						[
							'label' => esc_html__( 'Background Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-lottie-animations__wrapper' => 'background-color: {{VALUE}}'
							]
						]
					);

					$controls->add_control(
						'opacity',
						[
							'label' => esc_html__( 'Opacity', 'stratum' ),
							'type'  => Controls_Manager::SLIDER,
							'range' => [
								'px' => [
									'max' => 1,
									'min' => 0.10,
									'step' => 0.01
								]
							],
							'selectors' => [
								'{{WRAPPER}} .stratum-lottie-animations__wrapper' => 'opacity: {{SIZE}}'
							]
						]
					);

					$controls->add_group_control(
						Group_Control_Css_Filter::get_type(),
						[
							'name' => 'css_filters',
							'selector' => '{{WRAPPER}} .stratum-lottie-animations__wrapper'
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'tab_lottie_hover',
					[
						'label' => esc_html__( 'Hover', 'stratum' )
					]
				);

					$controls->add_control(
						'lottie_hover_background',
						[
							'label' => esc_html__( 'Background Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-lottie-animations__wrapper:hover' => 'background-color: {{VALUE}}'
							]
						]
					);

					$controls->add_control(
						'hover_opacity',
						[
							'label' => esc_html__( 'Opacity', 'stratum' ),
							'type'  => Controls_Manager::SLIDER,
							'range' => [
								'px' => [
									'max'  => 1,
									'min'  => 0.10,
									'step' => 0.01
								],
							],
							'selectors' => [
								'{{WRAPPER}} .stratum-lottie-animations__wrapper:hover' => 'opacity: {{SIZE}}'
							]
						]
					);

					$controls->add_group_control(
						Group_Control_Css_Filter::get_type(),
						[
							'name' => 'hover_css_filters',
							'selector' => '{{WRAPPER}} .stratum-lottie-animations__wrapper:hover'
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'lottie_border',
					'selector'  => '{{WRAPPER}} .stratum-lottie-animations__wrapper',
					'separator' => 'before'
				]
			);

			$controls->add_control('lottie_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-lottie-animations__wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);

			$controls->add_responsive_control('animation_padding',
				[
					'label' => esc_html__( 'Padding', 'stratum' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-lottie-animations__wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);

		$controls->end_controls_section();
	}

	protected function render() {
		$this->render_widget( 'php' );
	}

	protected function content_template() {}
	public function render_plain_content( $instance = [] ) {}
}

Plugin::instance()->widgets_manager->register_widget_type( new Lottie_Animations() );