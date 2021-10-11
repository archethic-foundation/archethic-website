<?php
/**
 * Class: Advanced_Accordion
 * Name: Advanced Accordion
 * Slug: advanced-accordion
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

class Advanced_Accordion extends Stratum_Widget_Base {
	protected $widget_name = 'advanced-accordion';

    public function __construct($data = [], $args = null) {
        parent::__construct( $data, $args );
    }

	public function get_title() {
		return esc_html__( 'Advanced Accordion', 'stratum' );
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
		return [ 'accordion', 'content', 'template' ];
	}

	public function get_icon() {
		return 'stratum-icon-advanced-accordion';
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
				'accordion_type',
				[
					'label' => esc_html__('Accordion Type', 'stratum'),
					'type' => Controls_Manager::SELECT,
					'default' => 'accordion',
					'label_block' => false,
					'options' => [
						'accordion' => esc_html__('Accordion', 'stratum'),
						'toggle' => esc_html__('Toggle', 'stratum'),
					],
				]
			);

			$controls->add_control(
				'accordion_collapsible',
				[
					'label' => esc_html__( 'Collapsible', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'condition' => [
						'accordion_type' => 'accordion'
					],
				]
			);

			$controls->add_control(
				'accordion_interactivity',
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
				'title',
				[
					'label'   => esc_html__( 'Title', 'stratum' ),
					'label_block' => true,
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'Lorem ipsum dolor sit amet.', 'stratum' ),
					'dynamic' => [ 'active' => true ]
				]
			);

			$repeater->start_controls_tabs( 'title_icon_styles' );

				$repeater->start_controls_tab(
					'title_icon_tab',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$repeater->add_control(
						'title_icon',
						[
							'label' => esc_html__( 'Icon', 'stratum' ),
							'type' => Controls_Manager::ICONS,
						]
					);

				$repeater->end_controls_tab();

				$repeater->start_controls_tab(
					'title_icon_active_tab',
					array(
						'label' => esc_html__( 'Active', 'stratum' ),
					)
				);

					$repeater->add_control(
						'title_icon_active',
						[
							'label' => esc_html__( 'Icon', 'stratum' ),
							'type' => Controls_Manager::ICONS,
						]
					);

				$repeater->end_controls_tab();

			$repeater->end_controls_tabs();

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
					'separator' => 'before',
				]
			);

			$repeater->add_control(
				'text',
				[
					'label'   => esc_html__( 'Text', 'stratum' ),
					'type'    => Controls_Manager::WYSIWYG,
					'dynamic' => [ 'active' => true ],
					'condition' => [
						'content_type' => 'text'
					],
				]
			);

			$repeater->add_control(
				'accordion_template',
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
					'label' => esc_html__( 'Unfolded by default', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'default' => '',
				]
			);

			$controls->add_control(
				'accordion_items',
				[
					'label' => esc_html__( 'Accordion items', 'stratum' ),
					'type'  => Controls_Manager::REPEATER,
					'title_field' => '{{{ title }}}',
					'show_label'  => true,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'text' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'stratum' ),
							'active' => 'yes'
						],
						[
							'text' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'stratum' ),
							'active' => 'no'
						]
					]
				]
			);

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'General Style', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$controls->add_control(
				'equal_height',
				[
					'label' => esc_html__( 'Equal container height', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'default' => '',
					'condition' => [
						'accordion_type' => 'accordion'
					],
				]
			);

			$controls->add_control(
				'items_spacing',
				[
					'label' => esc_html__( 'Spacing between items', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'size' => 1,
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$controls->add_responsive_control(
				'accordion_padding',
				[
					'label' => esc_html__( 'Items Padding', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'accordion_margin',
				[
					'label' => esc_html__( 'Items Margin', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'accordion_border',
					'label' => esc_html__( 'Border', 'stratum' ),
					'selector' => '{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item',
					'separator' => 'before',
				]
			);

			$controls->add_responsive_control(
				'accordion_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'condition' => [
						'accordion_border_border!' => ''
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'accordion_shadow',
					'separator' => 'before',
					'selector' => '{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item',
				]
			);

        $controls->end_controls_section();

		$controls->start_controls_section(
			'section_style_icon',
			[
				'label' => esc_html__( 'Expand icon style', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$controls->add_control(
				'icon_position',
				[
					'label' => esc_html__( 'Icon position', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'right',
					'prefix_class' => 'stratum-advanced-accordion-icons-position-',
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
						'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__expand-icon' => 'font-size: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__expand-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
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
						'{{WRAPPER}}.stratum-advanced-accordion-icons-position-left .stratum-advanced-accordion .stratum-advanced-accordion__expand-icon' => 'margin-right: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}}.stratum-advanced-accordion-icons-position-right .stratum-advanced-accordion .stratum-advanced-accordion__expand-icon' => 'margin-left: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$controls->start_controls_tabs( 'expand_icon_styles' );

				$controls->start_controls_tab(
					'expand_icon_tab',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$controls->add_control(
						'expand_icon_color',
						[
							'label' => esc_html__( 'Icon Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'render_type' => 'ui',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item-header .stratum-advanced-accordion__expand-icon .normal' => 'color: {{VALUE}}',
							],
						]
					);

					$controls->add_control(
						'expand_icon',
						[
							'label' => esc_html__( 'Icon', 'stratum' ),
							'type' => Controls_Manager::ICONS,
							'default' => [
								'value' => 'fas fa-chevron-right',
								'library' => 'solid',
							],
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'expand_icon_active_tab',
					array(
						'label' => esc_html__( 'Active', 'stratum' ),
					)
				);

					$controls->add_control(
						'expand_icon_active_color',
						[
							'label' => esc_html__( 'Icon Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'render_type' => 'ui',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item-header .stratum-advanced-accordion__expand-icon .active' => 'color: {{VALUE}}',
							],
						]
					);

					$controls->add_control(
						'expand_icon_active',
						[
							'label' => esc_html__( 'Icon', 'stratum' ),
							'type' => Controls_Manager::ICONS,
							'default' => [
								'value' => 'fas fa-chevron-down',
								'library' => 'solid',
							],
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'expand_icon_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'expand_icon_hover_color',
						[
							'label' => esc_html__( 'Icon Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'render_type' => 'ui',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item-header:hover .stratum-advanced-accordion__expand-icon span' => 'color: {{VALUE}}',
							],
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_style_header',
			[
				'label' => esc_html__( 'Header style', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
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
						'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__title' => 'text-align: {{VALUE}};',
					],
				]
			);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'header_typography',
					'selector' => '{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__title',
					'label'	=> esc_html__( 'Typography', 'stratum' ),
					'render_type' => 'template',
					'defaults' => [
						'html_tag' => 'h3',
					],
				]
			);

			$controls->add_responsive_control(
				'header_padding',
				[
					'label' => esc_html__( 'Padding', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'header_margin',
				[
					'label' => esc_html__( 'Margin', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_control(
				'head_icon_size',
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
						'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__title-icon i'   => 'font-size: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__title-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
					],
					'separator' => 'before',
				]
			);

			$controls->add_control(
				'head_icon_spacing',
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
						'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__title-icon' => 'margin-right: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'header_border',
					'label' => esc_html__( 'Border', 'stratum' ),
					'separator' => 'before',
					'selector' => '{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item-header',
				]
			);


			$controls->add_responsive_control(
				'header_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'condition' => [
						'header_border_border!' => ''
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item-header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'header_shadow',
					'separator' => 'before',
					'selector' => '{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item-header',
				]
			);

			$controls->start_controls_tabs( 'header_styles' );

				$controls->start_controls_tab(
					'header_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$controls->add_control(
						'head_icon_color',
						[
							'label' => esc_html__( 'Icon Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'render_type' => 'ui',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item-header .stratum-advanced-accordion__title-icon .normal' => 'color: {{VALUE}}',
							],
						]
					);

					$controls->add_control(
						'custom_header_color',
						[
							'label'   => esc_html__( 'Title Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '',
							'value'   => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item .stratum-advanced-accordion__title' => 'color: {{VALUE}}',
							]
						]
					);

					$controls->add_control(
						'custom_header_background_color',
						[
							'label'   => esc_html__( 'Background Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => $background_color,
							'value'   => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item .stratum-advanced-accordion__item-header' => 'background-color: {{VALUE}}',
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
						'head_icon_active_color',
						[
							'label' => esc_html__( 'Icon Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'render_type' => 'ui',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item-header .stratum-advanced-accordion__title-icon .active' => 'color: {{VALUE}}',
							],
						]
					);

					$controls->add_control(
						'custom_active_header_color',
						[
							'label'   => esc_html__( 'Title Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '',
							'value'   => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item.active-accordion .stratum-advanced-accordion__title' => 'color: {{VALUE}}',
							]
						]
					);

					$controls->add_control(
						'custom_active_header_background_color',
						[
							'label'   => esc_html__( 'Background Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => $background_color_active,
							'value'   => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item.active-accordion .stratum-advanced-accordion__item-header' => 'background-color: {{VALUE}}',
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'header_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'head_icon_hover_color',
						[
							'label' => esc_html__( 'Icon Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'render_type' => 'ui',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item-header:hover .stratum-advanced-accordion__title-icon span' => 'color: {{VALUE}}',
							],
						]
					);

					$controls->add_control(
						'custom_hover_header_color',
						[
							'label'   => esc_html__( 'Title Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '',
							'value'   => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item .stratum-advanced-accordion__item-header:hover .stratum-advanced-accordion__title' => 'color: {{VALUE}}',
							]
						]
					);

					$controls->add_control(
						'custom_hover_header_background_color',
						[
							'label'   => esc_html__( 'Background Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => $background_color_hover,
							'value'   => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item .stratum-advanced-accordion__item-header:hover' => 'background-color: {{VALUE}}',
							]
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
				'custom_content_color',
				[
					'label'   => esc_html__( 'Text Color', 'stratum' ),
					'type'    => Controls_Manager::COLOR,
					'default' => '',
					'value'   => '',
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item-content .stratum-advanced-accordion__text' => 'color: {{VALUE}}',
					]
				]
			);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'content_typography',
					'selector' => '{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item-content .stratum-advanced-accordion__text',
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
					'selector' => '{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item-wrapper',
				]
			);

			$controls->add_control(
				'content_background_overlay',
				[
					'label' => esc_html__( 'Background Overlay', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item-content-overlay' => 'background-color: {{VALUE}};'
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
						'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'render_type' => 'template',
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
						'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'render_type' => 'template',
				]
			);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'content_border',
					'separator' => 'before',
					'label' => esc_html__( 'Border', 'stratum' ),
					'selector' => '{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item-wrapper',
					'render_type' => 'template',
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
						'{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'content_shadow',
					'selector' => '{{WRAPPER}} .stratum-advanced-accordion .stratum-advanced-accordion__item-wrapper',
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

Plugin::instance()->widgets_manager->register_widget_type( new Advanced_Accordion() );