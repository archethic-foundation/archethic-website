<?php
/**
 * Class: Stratum_Instagram
 * Name: Instagram
 * Slug: stratum-instagram
 */

namespace Stratum;

// use \Stratum\Stratum_Widget_Base;

use \Elementor\Controls_Manager;
use \Elementor\Utils;
use \Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Instagram extends Stratum_Widget_Base {
	protected $widget_name = 'instagram';

    public function __construct($data = [], $args = null) {
        parent::__construct( $data, $args );
    }

	public function get_title() {
		return esc_html__( 'Instagram', 'stratum' );
	}

    public function get_script_depends() {
        return [
			'anim-on-scroll',
			'modernizr-custom',
		];
	}

	public function get_style_depends() {
        return [
			'scroll-anim-effects',
        ];
	}

	public function get_icon() {
		return 'stratum-icon-instagram';
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
				'label' => esc_html__( 'Content', 'stratum' ),
				'tab'   => Controls_Manager::TAB_CONTENT
			]
		);

		$controls->add_control(
			'items',
			[
				'label' => esc_html__( 'Number of items', 'stratum' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => 1,
				'max'   => 100,
				'step'   => 1,
				'default' => 6
			]
		);

		$stratum_api = get_option( 'stratum_api', [] );
		$access_token = isset( $stratum_api['instagram_access_token'] ) ? $stratum_api['instagram_access_token'] : '';

		if (empty($access_token)){
			$controls->add_control(
				'api_key',
				[
					'label' => esc_html__( 'API KEY', 'stratum' ),
					'label_block' => true,
					'type' => Controls_Manager::RAW_HTML,
					'raw' => wp_kses(
						sprintf(
							__( 'Instagram Access Token is not set. <a href="%s" target="_blank">Connect Instagram Account</a>.', 'stratum' ),
							admin_url( 'admin.php?page=stratum-settings#stratum_api' )
						),
						array( 'a' => array( 'href' => array(), 'target' => array() ) )
					),
					'content_classes' => 'api-key-description',
				]
			);
		}

		$controls->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
        /*	Style Tab
        /*-----------------------------------------------------------------------------------*/

		$controls->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$controls->add_control(
			'animate_on_scroll',
			[
				'label' => esc_html__( 'Animate on scroll', 'stratum' ),
				'type'  => Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		$controls->add_control(
			'animation_effects',
			[
				'label' => esc_html__( 'Animation Effect', 'stratum' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'effect-2',
				'options' => [
					'effect-1' => esc_html__( 'Opacity', 'stratum' ),
					'effect-2' => esc_html__( 'Move Up', 'stratum' ),
					'effect-3' => esc_html__( 'Scale up', 'stratum' ),
					'effect-4' => esc_html__( 'Fall perspective', 'stratum' ),
					'effect-5' => esc_html__( 'Fly', 'stratum' ),
					'effect-6' => esc_html__( 'Flip', 'stratum' ),
					'effect-7' => esc_html__( 'Helix', 'stratum' ),
					'effect-8' => esc_html__( 'Zoom In 3D', 'stratum' ),
				],
				'condition' => [
					'animate_on_scroll' => 'yes',
				],
			]
		);

		$controls->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'stratum' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => 1,
				'max'   => 6,
				'step'  => 1,
				'default' => 3,
				'selectors' => [
					'{{WRAPPER}} .stratum-instagram .stratum-instagram__wrapper' => '--columns: {{VALUE}}',
				],
			]
		);

		$controls->add_responsive_control(
			'padding_item',
			[
				'label' => esc_html__( 'Spacing', 'stratum' ),
				'description' => esc_html__( 'In Pixels (px)', 'stratum' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 5,
				],
				'tablet_default' => [
					'size' => 5,
				],
				'mobile_default' => [
					'size' => 5,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 30,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .stratum-instagram .stratum-instagram__item' => 'padding: {{SIZE}}px',
					'{{WRAPPER}} .stratum-instagram .stratum-instagram__wrapper' => 'margin: -{{SIZE}}px',
				],
			]
		);

		$controls->start_controls_tabs( 'instagram_styles' );

			$controls->start_controls_tab(
				'instagram_normal',
				array(
					'label' => esc_html__( 'Normal', 'stratum' ),
				)
			);

				$controls->add_control(
					'background_color',
					[
						'label' => esc_html__( 'Background Color', 'stratum' ),
						'type' => Controls_Manager::COLOR,
						'value' => '#00000000',
						'default' => '#00000000',
						'selectors' => [
							'{{WRAPPER}} .stratum-instagram .stratum-instagram__media-link:before' => 'background-color: {{VALUE}}',
						],
					]
				);

			$controls->end_controls_tab();

			$controls->start_controls_tab(
				'instagram_hover',
				array(
					'label' => esc_html__( 'Hover', 'stratum' ),
				)
			);

				$controls->add_control(
					'background_hover_color',
					[
						'label' => esc_html__( 'Background Color', 'stratum' ),
						'type' => Controls_Manager::COLOR,
						'value' => '#0000002e',
						'default' => '#0000002e',
						'selectors' => [
							'{{WRAPPER}} .stratum-instagram .stratum-instagram__media-link:hover:before' => 'background-color: {{VALUE}}',
						],
					]
				);

			$controls->end_controls_tab();

		$controls->end_controls_tabs();

		$controls->end_controls_section();
	}
	protected function render( $instance = [] ) {
		$this->render_widget( 'php' );
	}

	protected function content_template() {}
	public function render_plain_content( $instance = [] ) {}
}

Plugin::instance()->widgets_manager->register_widget_type( new Instagram() );