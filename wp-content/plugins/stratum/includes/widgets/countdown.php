<?php
/**
 * Class: Counter
 * Name: Counter
 * Slug: stratum-countdown
 */

namespace Stratum;

use \Elementor\Core\Schemes;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Utils;
use \Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class Countdown extends Stratum_Widget_Base {
	protected $widget_name = 'countdown';

    public function __construct($data = [], $args = null) {
        parent::__construct( $data, $args );
    }

    public function get_script_depends() {
		$script_depends = [
			'jquery-plugin',
			'jquery-countdown'
		];

		preg_match( '/^(.*)_/', get_locale(), $current_locale );
		$locale_prefix = isset( $current_locale[ 1 ] ) && $current_locale[ 1 ] !='en' ? $current_locale[ 1 ] : '';

		if ( $locale_prefix != '' ) {
			$locale_path = 'vendors/jquery.countdown/localization/jquery.countdown-' . $locale_prefix . '.js';

			if ( file_exists( stratum_get_plugin_path( $locale_path ) ) ) {
				$script_depends[] = 'jquery-countdown-' . $locale_prefix;
			}
		}

        return $script_depends;
     }

	public function get_title() {
		return esc_html__( 'Countdown', 'stratum' );
	}

	public function get_icon() {
		return 'stratum-icon-countdown';
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
				'date_time',
				[
					'label' => esc_html__( 'Select Date', 'stratum' ),
					'type' => Controls_Manager::DATE_TIME,
					'default' => gmdate( 'Y-m-d H:i', strtotime( '+1 week' ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ),
					/* translators: %s: Time zone. */
					'description' => sprintf( esc_html__( 'Date set according to your timezone: %s.', 'stratum' ), Utils::get_timezone_string() ),
				]
			);

			$controls->add_control(
				'show_years',
				[
					'label' => esc_html__( 'Years', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'stratum' ),
					'label_off' => esc_html__( 'Hide', 'stratum' ),
					'default' => 'yes',
				]
			);

			$controls->add_control(
				'show_months',
				[
					'label' => esc_html__( 'Months', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'stratum' ),
					'label_off' => esc_html__( 'Hide', 'stratum' ),
					'default' => 'yes',
				]
			);

			$controls->add_control(
				'show_weeks',
				[
					'label' => esc_html__( 'Weeks', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'stratum' ),
					'label_off' => esc_html__( 'Hide', 'stratum' ),
					'default' => 'yes',
				]
			);

			$controls->add_control(
				'show_days',
				[
					'label' => esc_html__( 'Days', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'stratum' ),
					'label_off' => esc_html__( 'Hide', 'stratum' ),
					'default' => 'yes',
				]
			);

			$controls->add_control(
				'show_hours',
				[
					'label' => esc_html__( 'Hours', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'stratum' ),
					'label_off' => esc_html__( 'Hide', 'stratum' ),
					'default' => 'yes',
				]
			);

			$controls->add_control(
				'show_minutes',
				[
					'label' => esc_html__( 'Minutes', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'stratum' ),
					'label_off' => esc_html__( 'Hide', 'stratum' ),
					'default' => 'yes',
				]
			);

			$controls->add_control(
				'show_seconds',
				[
					'label' => esc_html__( 'Seconds', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'stratum' ),
					'label_off' => esc_html__( 'Hide', 'stratum' ),
					'default' => 'yes',
				]
			);

			$controls->add_control(
				'stratum_expire_actions',
				[
					'label' => esc_html__( 'Actions After Expire', 'stratum' ),
					'description' => sprintf( esc_html__( 'Redirect, hide or show custom message', 'stratum' ), Utils::get_timezone_string() ),
					'type' => Controls_Manager::SELECT2,
					'options' => [
						'redirect' => esc_html__( 'Redirect', 'stratum' ),
						'hide' => esc_html__( 'Hide', 'stratum' ),
						'message' => esc_html__( 'Show Message', 'stratum' ),
					],
					'label_block' => true,
					'separator' => 'before',
					'render_type' => 'none',
					'multiple' => true
				]
			);

			$controls->add_control(
				'message_after_expire',
				[
					'label' => esc_html__( 'Message', 'stratum' ),
					'type' => Controls_Manager::WYSIWYG,
					'separator' => 'before',
					'render_type' => 'none',
					'dynamic' => [
						'active' => true,
					],
					'condition' => [
						'stratum_expire_actions' => 'message',
					]
				]
			);

			$controls->add_control(
				'expire_redirect_url',
				[
					'label' => esc_html__( 'Redirect URL', 'stratum' ),
					'type' => Controls_Manager::URL,
					'separator' => 'before',
					'options' => false,
					'render_type' => 'none',
					'dynamic' => [
						'active' => true,
					],
					'condition' => [
						'stratum_expire_actions' => 'redirect',
					],
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
				'show_labels',
				[
					'label' => esc_html__( 'Show Label', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'stratum' ),
					'label_off' => esc_html__( 'Hide', 'stratum' ),
					'default' => 'yes',
					'separator' => 'before',
				]
			);

			$controls->add_control(
				'custom_labels',
				[
					'label' => esc_html__( 'Custom Label', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'condition' => [
						'show_labels!' => '',
					],
				]
			);

			$controls->add_control(
				'label_years',
				[
					'label' => esc_html__( 'Years', 'stratum' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Years', 'stratum' ),
					'placeholder' => esc_html__( 'Years', 'stratum' ),
					'condition' => [
						'show_labels!' => '',
						'custom_labels!' => '',
						'show_years' => 'yes',
					],
				]
			);

			$controls->add_control(
				'label_months',
				[
					'label' => esc_html__( 'Months', 'stratum' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Months', 'stratum' ),
					'placeholder' => esc_html__( 'Months', 'stratum' ),
					'condition' => [
						'show_labels!' => '',
						'custom_labels!' => '',
						'show_months' => 'yes',
					],
				]
			);

			$controls->add_control(
				'label_weeks',
				[
					'label' => esc_html__( 'Weeks', 'stratum' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Weeks', 'stratum' ),
					'placeholder' => esc_html__( 'Weeks', 'stratum' ),
					'condition' => [
						'show_labels!' => '',
						'custom_labels!' => '',
						'show_weeks' => 'yes',
					],
				]
			);

			$controls->add_control(
				'label_days',
				[
					'label' => esc_html__( 'Days', 'stratum' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Days', 'stratum' ),
					'placeholder' => esc_html__( 'Days', 'stratum' ),
					'condition' => [
						'show_labels!' => '',
						'custom_labels!' => '',
						'show_days' => 'yes',
					],
				]
			);

			$controls->add_control(
				'label_hours',
				[
					'label' => esc_html__( 'Hours', 'stratum' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Hours', 'stratum' ),
					'placeholder' => esc_html__( 'Hours', 'stratum' ),
					'condition' => [
						'show_labels!' => '',
						'custom_labels!' => '',
						'show_hours' => 'yes',
					],
				]
			);

			$controls->add_control(
				'label_minutes',
				[
					'label' => esc_html__( 'Minutes', 'stratum' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Minutes', 'stratum' ),
					'placeholder' => esc_html__( 'Minutes', 'stratum' ),
					'condition' => [
						'show_labels!' => '',
						'custom_labels!' => '',
						'show_minutes' => 'yes',
					],
				]
			);

			$controls->add_control(
				'label_seconds',
				[
					'label' => esc_html__( 'Seconds', 'stratum' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Seconds', 'stratum' ),
					'placeholder' => esc_html__( 'Seconds', 'stratum' ),
					'condition' => [
						'show_labels!' => '',
						'custom_labels!' => '',
						'show_seconds' => 'yes',
					],
				]
			);

			$controls->add_responsive_control(
				'box_width',
				[
					'label' => esc_html__( 'Box Width', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => 100,
					],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 300,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-countdown .countdown-section' => 'min-width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$controls->add_control(
				'box_align_horizontal',
				[
					'label' => esc_html__( 'Box Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'center',
					'prefix_class' => 'stratum-countdown-horizontal-align-',
					'toggle' => false,
					'options' => [
						'left'    => [
							'title' => esc_html__( 'Left', 'stratum' ),
							'icon' => 'eicon-h-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'stratum' ),
							'icon' => 'eicon-h-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'stratum' ),
							'icon' => 'eicon-h-align-right',
						],
						'stretch' => [
							'title' => esc_html__( 'Stretch', 'stratum' ),
							'icon' => 'eicon-h-align-stretch',
						],
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'box_border',
					'selector' => '{{WRAPPER}} .stratum-countdown .countdown-section',
					'separator' => 'before',
				]
			);

			$controls->add_control(
				'box_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-countdown .countdown-section' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'box_spacing',
				[
					'label' => esc_html__( 'Space Between', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => 10,
					],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-countdown .countdown-section' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
						'{{WRAPPER}} .stratum-countdown .countdown-section' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
					],
				]
			);

			$controls->add_responsive_control(
				'box_padding',
				[
					'label' => esc_html__( 'Padding', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-countdown .countdown-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'digits_typography',
					'selector' => '{{WRAPPER}} .stratum-countdown .countdown-section .countdown-amount',
					'label'	=> esc_html__( 'Digits Typography', 'stratum' ),
					'render_type' => 'ui',
					'exclude' => ['html_tag']
				]
			);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'label_typography',
					'selector' => '{{WRAPPER}} .stratum-countdown .countdown-section .countdown-period',
					'label'	=> esc_html__( 'Label Typography', 'stratum' ),
					'render_type' => 'ui',
					'exclude' => ['html_tag']
				]
			);

			$controls->start_controls_tabs( 'countdown_styles' );

				$controls->start_controls_tab(
					'countdown_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$controls->add_control(
						'box_color',
						[
							'label'   => esc_html__( 'Box Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-countdown .countdown-section' => 'background-color: {{VALUE}}'
							]
						]
					);

					$controls->add_control(
						'digit_color',
						[
							'label'   => esc_html__( 'Digit Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-countdown .countdown-section .countdown-amount' => 'color: {{VALUE}}'
							]
						]
					);

					$controls->add_control(
						'label_color',
						[
							'label'   => esc_html__( 'Label Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-countdown .countdown-section .countdown-period' => 'color: {{VALUE}}'
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'countdown_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'hover_box_color',
						[
							'label'   => esc_html__( 'Box Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}:hover .stratum-countdown .countdown-section' => 'background-color: {{VALUE}}'
							]
						]
					);

					$controls->add_control(
						'hover_digit_color',
						[
							'label'   => esc_html__( 'Digit Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}:hover .stratum-countdown .countdown-section .countdown-amount' => 'color: {{VALUE}}'
							]
						]
					);

					$controls->add_control(
						'hover_label_color',
						[
							'label'   => esc_html__( 'Label Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}:hover .stratum-countdown .countdown-section .countdown-period' => 'color: {{VALUE}}'
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
    }

	protected function content_template() {}
	public function render_plain_content( $instance = [] ) {}
}

Plugin::instance()->widgets_manager->register_widget_type( new Countdown() );