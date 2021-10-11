<?php
/**
 * Class: Counter
 * Name: Counter
 * Slug: stratum-counter
 */

namespace Stratum;

use \Elementor\Controls_Manager;
use \Elementor\Utils;
use \Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Counter extends Stratum_Widget_Base {
	protected $widget_name = 'counter';

    public function __construct($data = [], $args = null) {
        parent::__construct( $data, $args );
    }

    public function get_script_depends() {
        return [ 'countup', 'waypoints' ];
     }

	public function get_title() {
		return esc_html__( 'Counter', 'stratum' );
	}

	public function get_icon() {
		return 'stratum-icon-counter';
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
				'start',
				[
					'label'     => esc_html__( 'Start Value', 'stratum' ),
					'type'      => Controls_Manager::NUMBER,
					'dynamic'   => [ 'active' => true ],
					'default'   => 0
				]
			);

			$controls->add_control(
				'end',
				[
					'label'     => esc_html__( 'End Value', 'stratum' ),
					'type'      => Controls_Manager::NUMBER,
					'dynamic'   => [ 'active' => true ],
					'default'   => 100
				]
			);

			$controls->add_control(
				'duration',
				[
					'label'   => esc_html__( 'Animation Duration', 'stratum' ),
					'type'    => Controls_Manager::NUMBER,
					'dynamic' => [ 'active' => true ],
					'default' => 3
				]
			);

			$controls->add_control(
				'smooth_animation',
				[
					'label' => esc_html__( 'Smooth Animation', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'default' => ''
				]
			);

			$controls->add_control(
				'prefix',
				[
					'label'       => esc_html__( 'Counter Prefix', 'stratum' ),
					'label_block' => true,
					'type'        => Controls_Manager::TEXT,
					'default'     => ''
				]
			);

			$controls->add_control(
				'suffix',
				[
					'label'       => esc_html__( 'Counter Suffix', 'stratum' ),
					'label_block' => true,
					'type'        => Controls_Manager::TEXT,
					'default'     => ''
				]
			);

			$controls->add_responsive_control(
				'horizontal_alignment',
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
						'{{WRAPPER}} .stratum-counter' => 'justify-content: {{VALUE}};'
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

			$controls->add_control(
				'animation_effect',
				[
					'label'   => esc_html__( 'Animation Effect', 'stratum' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'outExpo',
					'options' => [
						'outExpo'    => esc_html__( 'OutExpo'   , 'stratum' ),
						'outQuintic' => esc_html__( 'OutQuintic', 'stratum' ),
						'outCubic'   => esc_html__( 'OutCubic'  , 'stratum' )
					]
				]
			);

			$controls->add_control(
				'display_separator',
				[
					'label' => esc_html__( 'Display Thousands Separator', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'default' => ''
				]
			);

			$controls->add_control(
				'thousands_separator',
				[
					'label'       => esc_html__( 'Thousands Separator', 'stratum' ),
					'label_block' => true,
					'type'        => Controls_Manager::TEXT,
					'default'     => ','
				]
			);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'prefix__typography',
					'selector' => '{{WRAPPER}} .stratum-counter__prefix',
					'label'	=> esc_html__( 'Prefix Typography', 'stratum' ),
					'render_type' => 'ui',
					'exclude' => ['html_tag']
				]
			);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'number__typography',
					'selector' => '{{WRAPPER}} .stratum-counter__number',
					'label'	=> esc_html__( 'Number Typography', 'stratum' ),
					'render_type' => 'ui',
					'exclude' => ['html_tag']
				]
			);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'suffix__typography',
					'selector' => '{{WRAPPER}} .stratum-counter__suffix',
					'label'	=> esc_html__( 'Suffix Typography', 'stratum' ),
					'render_type' => 'ui',
					'exclude' => ['html_tag']
				]
			);

			$controls->add_control(
				'decimal_places',
				[
					'label'   => esc_html__( 'Decimal Places', 'stratum' ),
					'type'    => Controls_Manager::NUMBER,
					'dynamic' => [ 'active' => true ],
					'min' => '0',
					'default' => '0'
				]
			);

			$controls->add_control(
				'decimal_separator',
				[
					'label'       => esc_html__( 'Decimal Separator', 'stratum' ),
					'label_block' => true,
					'type'        => Controls_Manager::TEXT,
					'default'     => '.'
				]
			);

			$controls->add_control(
				'numerals',
				[
					'label'   => esc_html__( 'Numerals', 'stratum' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
						'default'        => esc_html__( 'Default'       , 'stratum' ),
						'eastern_arabic' => esc_html__( 'Eastern Arabic', 'stratum' ),
						'farsi'          => esc_html__( 'Farsi'         , 'stratum' )
					],
					'default' => 'default'
				]
			);

			$controls->start_controls_tabs( 'counter_styles' );

				$controls->start_controls_tab(
					'counter_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$controls->add_control(
						'prefix_color',
						[
							'label'   => esc_html__( 'Prefix Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-counter .stratum-counter__prefix' => 'color: {{VALUE}}'
							]
						]
					);

					$controls->add_control(
						'number_color',
						[
							'label'   => esc_html__( 'Number Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-counter .stratum-counter__number' => 'color: {{VALUE}}'
							]
						]
					);

					$controls->add_control(
						'suffix_color',
						[
							'label'   => esc_html__( 'Suffix Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-counter .stratum-counter__suffix' => 'color: {{VALUE}}'
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'counter_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'hover_prefix_color',
						[
							'label'   => esc_html__( 'Prefix Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}:hover .stratum-counter .stratum-counter__prefix' => 'color: {{VALUE}}'
							]
						]
					);

					$controls->add_control(
						'hover_number_color',
						[
							'label'   => esc_html__( 'Number Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}:hover .stratum-counter .stratum-counter__number' => 'color: {{VALUE}}'
							]
						]
					);

					$controls->add_control(
						'hover_suffix_color',
						[
							'label'   => esc_html__( 'Suffix Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}:hover .stratum-counter .stratum-counter__suffix' => 'color: {{VALUE}}'
							]
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

	protected function content_template() {}
	public function render_plain_content( $instance = [] ) {}
}

Plugin::instance()->widgets_manager->register_widget_type( new Counter() );
