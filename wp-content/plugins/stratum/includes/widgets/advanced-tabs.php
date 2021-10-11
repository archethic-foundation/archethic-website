<?php
/**
 * Class: Advanced_Tabs
 * Name: Advanced Tabs
 * Slug: advanced-tabs
 */

namespace Stratum;

use Elementor\Core\Base\Document;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Controls_Manager;
use \Elementor\Utils;
use \Elementor\Plugin;
use \Elementor\Repeater;
use Stratum\Managers\Ajax_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Advanced_Tabs extends Stratum_Widget_Base {
	protected $widget_name = 'advanced-tabs';

    public function __construct($data = [], $args = null) {
        parent::__construct( $data, $args );
    }

	public function get_title() {
		return esc_html__( 'Advanced Tabs', 'stratum' );
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

	public function get_keywords() {
		return [ 'tabs', 'content', 'template' ];
	}

	public function get_icon() {
		return 'stratum-icon-advanced-tabs';
	}

	public function get_categories() {
		return [ 'stratum-widgets' ];
    }

    protected function _register_controls() {
		$controls = $this;

		$background_color = !empty(get_option( 'stratum_style' )) ? (!empty(get_option( 'stratum_style' )['background_color']) ? get_option( 'stratum_style' )['background_color'] : '') : '#71d7f7';
		$background_color_active = !empty(get_option( 'stratum_style' )) ? (!empty(get_option( 'stratum_style' )['background_color_active']) ? get_option( 'stratum_style' )['background_color_active'] : '') : '#0097c6';
		$background_color_hover = !empty(get_option( 'stratum_style' )) ? (!empty(get_option( 'stratum_style' )['background_color_hover']) ? get_option( 'stratum_style' )['background_color_hover'] : '') : '#008fbc';

		$document_types = Plugin::instance()->documents->get_document_types( [
			'show_in_library' => true,
		] );

        /*-----------------------------------------------------------------------------------*/
        /*	Content Tab
        /*-----------------------------------------------------------------------------------*/
		$controls->start_controls_section(
			'section_general',
			[
				'label' => esc_html__( 'General', 'stratum' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

			$controls->add_control(
				'tabs_layout',
				[
					'label' => esc_html__('Tabs Layout', 'stratum'),
					'type' => Controls_Manager::SELECT,
					'default' => 'horizontal',
					'label_block' => false,
					'options' => [
						'horizontal' => esc_html__('Horizontal', 'stratum'),
						'vertical' => esc_html__('Vertical', 'stratum'),
						'icon_box' => esc_html__('Icon Box', 'stratum'),
					],
				]
			);

			$controls->add_control(
				'tabs_interactivity',
				[
					'label'   => esc_html__( 'Interactivity', 'stratum' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'click',
					'options' => [
						'click' => esc_html__( 'Click', 'stratum' ),
						'mouseenter' => esc_html__( 'Hover', 'stratum' )
					],
				]
			);

			$repeater = new Repeater();

			$repeater->add_control(
				'tab_title',
				[
					'label'   => esc_html__( 'Title', 'stratum' ),
					'label_block' => true,
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'Title', 'stratum' ),
					'dynamic' => [ 'active' => true ]
				]
			);

			$repeater->add_control(
				'tab_icon',
				[
					'label' => esc_html__( 'Icon', 'stratum' ),
					'type' => Controls_Manager::ICONS,
					'default' => [
						'value' => 'fas fa-home',
						'library' => 'solid',
					],
				]
			);

			$repeater->add_control(
				'content_type',
				[
					'label' => esc_html__('Content Type', 'stratum'),
					'type' => Controls_Manager::SELECT,
					'default' => 'text',
					'label_block' => false,
					'options' => [
						'text' => esc_html__('Text', 'stratum'),
						'template' => esc_html__('Template', 'stratum'),
					],
				]
			);

			$repeater->add_control(
				'tab_text',
				[
					'label'   => esc_html__( 'Text', 'stratum' ),
					'type'    => Controls_Manager::WYSIWYG,
					'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'stratum' ),
					'dynamic' => [ 'active' => true ],
					'condition' => [
						'content_type' => 'text'
					],
				]
			);

			$repeater->add_control(
				'tab_template',
				[
					'label' => esc_html__('Template', 'stratum'),
					'type' => Stratum_AJAX_Control::QUERY,
					'label_block' => true,
					'multiple' => false,
					'ajax_route' => 'stratum_get_elementor_templates',
					'autocomplete' => [
						'object' => 'library_template',
						'query' => [
							'meta_query' => [
								[
									'key' => Document::TYPE_META_KEY,
									'value' => array_keys( $document_types ),
									'compare' => 'IN',
								],
							],
						],
					],
					'options' => Ajax_Manager::stratum_get_elementor_templates(),
					'condition' => [
						'content_type' => 'template'
					],
					'description' => esc_html__( 'Here you can see sections you saved as templates.', 'stratum' ),
				]
			);

			$repeater->add_control(
				'manage_templates',
				[
					'label' => esc_html__( 'Manage Templates', 'stratum' ),
					'label_block' => false,
					'type' => Controls_Manager::BUTTON,
					'button_type' => 'success',
					'text' => esc_html__( 'Library', 'stratum' ),
					'event' => 'stratum:OpenTemplatesLibrary',
					'condition' => [
						'content_type' => 'template'
					],
				]
			);

			$repeater->add_control(
				'active',
				[
					'label' => esc_html__( 'Active by default', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'default' => '',
				]
			);

			$controls->add_control(
				'tabs_items',
				[
					'label' => esc_html__( 'Tab items', 'stratum' ),
					'title_field' => '<i class="{{ tab_icon.value }}" aria-hidden="true"></i> {{{ tab_title }}}',
					'type'   => Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'show_label' => true,
					'default' => [
						[
							'text' => sprintf( esc_html__( 'Item #%d', 'stratum' ), 1 )
						]
					]
				]
			);

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_navigation_panel',
			[
				'label' => esc_html__( 'Navigation Panel Style', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$controls->add_responsive_control(
				'nav_panel_width',
				[
					'label' => esc_html__( 'Navigation Width', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'%' => [
							'min' => 0,
							'max' => 50,
						],
						'px' => [
							'min' => 0,
							'max' => 500,
						],
					],
					'default' => [
						'size' => '15',
						'unit' => '%',
					],
					'size_units' => [ '%', 'px' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-tabs.tabs-layout-vertical .stratum-advanced-tabs__navigation' => 'min-width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'tabs_layout' => ['vertical']
					],
				]
			);

			$controls->add_control(
				'tabs_spacing',
				[
					'label' => esc_html__( 'Spacing between tabs', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'size' => 5,
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-tabs.tabs-layout-horizontal .stratum-advanced-tabs__navigation-item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .stratum-advanced-tabs.tabs-layout-vertical .stratum-advanced-tabs__navigation-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .stratum-advanced-tabs.tabs-layout-icon_box .stratum-advanced-tabs__navigation-item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$controls->add_control(
				'nav_panel_postion_horizontal',
				[
					'label' => esc_html__( 'Tabs Position', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'top',
					'prefix_class' => 'stratum-advanced-tabs-nav-horizontal-position-',
					'toggle' => false,
					'options' => [
						'top'    => [
							'title' => esc_html__( 'Top', 'stratum' ),
							'icon' => 'eicon-v-align-top',
						],
						'bottom' => [
							'title' => esc_html__( 'Bottom', 'stratum' ),
							'icon' => 'eicon-v-align-bottom',
						],
					],
					'condition' => [
						'equal_height' => 'yes',
						'tabs_layout' => ['horizontal', 'icon_box']
					],
				]
			);

			$controls->add_control(
				'nav_panel_postion_vertical',
				[
					'label' => esc_html__( 'Tabs Position', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'left',
					'prefix_class' => 'stratum-advanced-tabs-nav-vertical-position-',
					'toggle' => false,
					'options' => [
						'left'    => [
							'title' => esc_html__( 'Left', 'stratum' ),
							'icon' => 'eicon-h-align-left',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'stratum' ),
							'icon' => 'eicon-h-align-right',
						],
					],
					'condition' => [
						'tabs_layout' => 'vertical'
					],
				]
			);

			$controls->add_control(
				'nav_panel_align_horizontal',
				[
					'label' => esc_html__( 'Tabs Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'left',
					'prefix_class' => 'stratum-advanced-tabs-nav-horizontal-align-',
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
					'condition' => [
						'tabs_layout' => ['horizontal', 'icon_box']
					],
				]
			);

			$controls->add_control(
				'nav_panel_align_vertical',
				[
					'label' => esc_html__( 'Tabs Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'top',
					'prefix_class' => 'stratum-advanced-tabs-nav-vertical-align-',
					'toggle' => false,
					'options' => [
						'top'    => [
							'title' => esc_html__( 'Top', 'stratum' ),
							'icon' => 'eicon-v-align-top',
						],
						'middle' => [
							'title' => esc_html__( 'Middle', 'stratum' ),
							'icon' => 'eicon-v-align-middle',
						],
						'bottom' => [
							'title' => esc_html__( 'Bottom', 'stratum' ),
							'icon' => 'eicon-v-align-bottom',
						],
						'stretch' => [
							'title' => esc_html__( 'Stretch', 'stratum' ),
							'icon' => 'eicon-v-align-stretch',
						],
					],
					'condition' => [
						'tabs_layout' => 'vertical'
					],
				]
			);

			$controls->add_responsive_control(
				'nav_panel_padding',
				[
					'label' => esc_html__( 'Padding', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__navigation' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'nav_panel_margin',
				[
					'label' => esc_html__( 'Margin', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__navigation' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'nav_panel_border',
					'label' => esc_html__( 'Border', 'stratum' ),
					'selector' => '{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__navigation',
					'separator' => 'before',
				]
			);

			$controls->add_responsive_control(
				'nav_panel_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'condition' => [
						'nav_panel_border_border!' => ''
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__navigation' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'nav_panel_shadow',
					'separator' => 'before',
					'selector' => '{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__navigation',
				]
			);

			$controls->add_control(
				'nav_panel_background_color',
				[
					'label'   => esc_html__( 'Background Color', 'stratum' ),
					'type'    => Controls_Manager::COLOR,
					'default' => '',
					'value'   => '',
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__navigation' => 'background-color: {{VALUE}}',
					]
				]
			);

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_navigation_items',
			[
				'label' => esc_html__( 'Tabs Style', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'nav_items_typography',
					'selector' => '{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__title',
					'label'	=> esc_html__( 'Typography', 'stratum' ),
					'render_type' => 'template',
					'defaults' => [
						'html_tag' => 'h3',
					],
				]
			);

			$controls->add_responsive_control(
				'nav_items_padding',
				[
					'label' => esc_html__( 'Padding', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__navigation-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'nav_items_margin',
				[
					'label' => esc_html__( 'Margin', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__navigation-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'nav_items_border',
					'label' => esc_html__( 'Border', 'stratum' ),
					'selector' => '{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__navigation-item',
					'separator' => 'before',
				]
			);

			$controls->add_responsive_control(
				'nav_items_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'condition' => [
						'nav_items_border_border!' => ''
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__navigation-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'nav_items_shadow',
					'separator' => 'before',
					'selector' => '{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__navigation-item',
				]
			);

			$controls->start_controls_tabs( 'nav_items_styles' );

				$controls->start_controls_tab(
					'nav_items_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$controls->add_control(
						'custom_nav_items_color',
						[
							'label'   => esc_html__( 'Title Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '',
							'value'   => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__navigation-item' => 'color: {{VALUE}}',
							]
						]
					);

					$controls->add_control(
						'custom_nav_items_background_color',
						[
							'label'   => esc_html__( 'Background Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => $background_color,
							'value'   => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__navigation-item' => 'background-color: {{VALUE}}',
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'active_normal',
					array(
						'label' => esc_html__( 'Active', 'stratum' ),
					)
				);

					$controls->add_control(
						'custom_active_nav_items_color',
						[
							'label'   => esc_html__( 'Title Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '',
							'value'   => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__navigation-item.active-nav' => 'color: {{VALUE}}',
							]
						]
					);

					$controls->add_control(
						'custom_active_nav_items_background_color',
						[
							'label'   => esc_html__( 'Background Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => $background_color_active,
							'value'   => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__navigation-item.active-nav' => 'background-color: {{VALUE}}',
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'nav_items_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'custom_hover_nav_items_color',
						[
							'label'   => esc_html__( 'Title Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '',
							'value'   => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__navigation-item:hover' => 'color: {{VALUE}}',
							]
						]
					);

					$controls->add_control(
						'custom_hover_nav_items_background_color',
						[
							'label'   => esc_html__( 'Background Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => $background_color_hover,
							'value'   => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__navigation-item:hover' => 'background-color: {{VALUE}}',
							]
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_style_icon',
			[
				'label' => esc_html__( 'Icon style', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$controls->add_control(
				'icon_position_horizontal',
				[
					'label' => esc_html__( 'Icon position', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'left',
					'prefix_class' => 'stratum-advanced-tabs-icons-horizontal-position-',
					'toggle' => false,
					'options' => [
						'left'    => [
							'title' => esc_html__( 'Left', 'stratum' ),
							'icon' => 'eicon-h-align-left',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'stratum' ),
							'icon' => 'eicon-h-align-right',
						],
					],
					'condition' => [
						'tabs_layout' => ['horizontal', 'vertical']
					],
				]
			);

			$controls->add_control(
				'icon_position_vertical',
				[
					'label' => esc_html__( 'Icon position', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'top',
					'prefix_class' => 'stratum-advanced-tabs-icons-vertical-position-',
					'toggle' => false,
					'options' => [
						'top'    => [
							'title' => esc_html__( 'Top', 'stratum' ),
							'icon' => 'eicon-v-align-top',
						],
						'bottom' => [
							'title' => esc_html__( 'Bottom', 'stratum' ),
							'icon' => 'eicon-v-align-bottom',
						],
					],
					'condition' => [
						'tabs_layout' => 'icon_box'
					],
				]
			);

			$controls->add_control(
				'icon_size',
				[
					'label' => esc_html__( 'Icon Size', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'size' => 16,
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__icon i'   => 'font-size: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__icon svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$controls->add_control(
				'icon_spacing',
				[
					'label' => esc_html__( 'Spacing', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'size' => 10,
					],
					'selectors' => [
						'{{WRAPPER}}.stratum-advanced-tabs-icons-horizontal-position-left .stratum-advanced-tabs .stratum-advanced-tabs__icon' => 'margin-right: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}}.stratum-advanced-tabs-icons-horizontal-position-right .stratum-advanced-tabs .stratum-advanced-tabs__icon' => 'margin-left: {{SIZE}}{{UNIT}}',

						'{{WRAPPER}}.stratum-advanced-tabs-icons-vertical-position-top .stratum-advanced-tabs .stratum-advanced-tabs__icon' => 'margin-bottom: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}}.stratum-advanced-tabs-icons-vertical-position-bottom .stratum-advanced-tabs .stratum-advanced-tabs__icon' => 'margin-top: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$controls->start_controls_tabs( 'icons_styles' );

				$controls->start_controls_tab(
					'icon_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$controls->add_control(
						'icon_color',
						[
							'label' => esc_html__( 'Icon Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'render_type' => 'ui',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__navigation-item .stratum-advanced-tabs__icon' => 'color: {{VALUE}}',
							],
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'icon_active',
					array(
						'label' => esc_html__( 'Active', 'stratum' ),
					)
				);

					$controls->add_control(
						'icon_active_color',
						[
							'label' => esc_html__( 'Icon Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'render_type' => 'ui',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__navigation-item.active-nav .stratum-advanced-tabs__icon' => 'color: {{VALUE}}',
							],
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'icon_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'icon_hover_color',
						[
							'label' => esc_html__( 'Icon Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'render_type' => 'ui',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__navigation-item:hover .stratum-advanced-tabs__icon' => 'color: {{VALUE}}',
							],
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content style', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$controls->add_control(
				'content_animation',
				[
					'label' => esc_html__( 'Animation', 'stratum' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'none' => esc_html__( 'None', 'stratum' ),
						'slide' => esc_html__( 'Slide', 'stratum' ),
						'fade' => esc_html__( 'Fade', 'stratum' ),
					],
				]
			);

			$controls->add_control(
				'equal_height',
				[
					'label' => esc_html__( 'Equal container height', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'default' => '',
				]
			);


			$controls->add_control(
				'custom_content_color',
				[
					'label'   => esc_html__( 'Text Color', 'stratum' ),
					'type'    => Controls_Manager::COLOR,
					'default' => '',
					'value'   => '',
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__content-item .stratum-advanced-tabs__text' => 'color: {{VALUE}}',
					]
				]
			);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'content_typography',
					'selector' => '{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__content-item .stratum-advanced-tabs__text',
					'label'	=> esc_html__( 'Typography', 'stratum' ),
					'render_type' => 'template',
					'defaults' => [
						'html_tag' => 'h3',
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'content_background',
					'types' => ['classic', 'gradient'],
					'selector' => '{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__content',
				]
			);

			$controls->add_control(
				'content_background_overlay',
				[
					'label' => esc_html__( 'Background Overlay', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__content-overlay' => 'background-color: {{VALUE}};'
					],
					'condition' => [
						'content_background_image[id]!' => ''
					]
				]
			);

			$controls->add_responsive_control(
				'content_padding',
				[
					'label' => esc_html__( 'Padding', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'separator' => 'before',
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'content_margin',
				[
					'label' => esc_html__( 'Margin', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'content_border',
					'separator' => 'before',
					'label' => esc_html__( 'Border', 'stratum' ),
					'selector' => '{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__content',
				]
			);

			$controls->add_responsive_control(
				'content_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'condition' => [
						'content_border_border!' => ''
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'content_shadow',
					'selector' => '{{WRAPPER}} .stratum-advanced-tabs .stratum-advanced-tabs__content',
				]
			);

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

Plugin::instance()->widgets_manager->register_widget_type( new Advanced_Tabs() );