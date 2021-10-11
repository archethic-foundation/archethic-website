<?php
/**
 * Class: Content_Switcher
 * Name: Content Switcher
 * Slug: stratum-content-switcher
 */

namespace Stratum;

use \Elementor\Core\Base\Document;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Utils;
use \Elementor\Plugin;
use \Elementor\Repeater;

use Stratum\Managers\Ajax_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Content_Switcher extends Stratum_Widget_Base {
	protected $widget_name = 'content-switcher';

	public function get_title() {
		return esc_html__( 'Content Switcher', 'stratum' );
	}

	public function get_icon() {
		return 'eicon-dual-button';
	}

	public function get_categories() {
		return [ 'stratum-widgets', 'switch', 'content' ];
	}

	protected function _register_controls() {
		$controls = $this;

		$document_types = Plugin::instance()->documents->get_document_types( [
			'show_in_library' => true,
		] );

		$controls->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'stratum' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

			$controls->add_control(
				'content_type',
				[
					'label'       => esc_html__( 'Style', 'stratum' ),
					'type'        => Controls_Manager::SELECT,
					'description' => esc_html__( '', 'stratum' ),
					'default'     => 'multiple',
					'options' 	  => [
						'multiple' => esc_html__( 'Multiple Tabs', 'stratum' ),
						'toggle'   => esc_html__( 'Toggle Tabs', 'stratum' ),
					],
				]
			);

			$controls->add_control(
				'content_type_description',
				[
					'raw' 		      => '<strong>' . __( 'Please note:', 'stratum' ) . '</strong> ' . __( 'This style applies to only first two tabs.', 'stratum' ),
					'type' 		      => Controls_Manager::RAW_HTML,
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
					'render_type' 	  => 'ui',
					'condition' 	  => [
						'content_type' => 'toggle',
					],
				]
			);

			$repeater = new Repeater();

			$repeater->add_control(
				'title',
				[
					'label'       => __( 'Title', 'stratum' ),
					'type' 	      => Controls_Manager::TEXT,
					'default'	  => __( 'Annual', 'stratum' ),
					'label_block' => true,
				]
			);

			$repeater->add_control(
				'content_template',
				[
					'label' 	   => esc_html__( 'Template', 'stratum' ),
					'type'         => Stratum_AJAX_Control::QUERY,
					'label_block'  => true,
					'multiple'     => false,
					'ajax_route'   => 'stratum_get_elementor_templates',
					'autocomplete' => [
						'object'   => 'library_template',
						'query'    => [
							'meta_query' => [
								[
									'key'     => Document::TYPE_META_KEY,
									'value'   => array_keys( $document_types ),
									'compare' => 'IN',
								],
							],
						],
					],
					'options'      => Ajax_Manager::stratum_get_elementor_templates(),
					'description'  => esc_html__( 'Here you can see sections you saved as templates.', 'stratum' ),
				]
			);

			$repeater->add_control(
				'active',
				[
					'label'   => esc_html__( 'Unfolded by default', 'stratum' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => '',
				]
			);

			$controls->add_control(
				'content_items',
				[
					'label' 	  => esc_html__( 'Items', 'stratum' ),
					'type'  	  => Controls_Manager::REPEATER,
					'title_field' => '{{{ title }}}',
					'fields' 	  => $repeater->get_controls(),
					'default'     => [
						[
							'title'  => esc_html__( 'Starter', 'stratum' ),
							'active' => 'yes'
						],
						[
							'title'   => esc_html__( 'Advanced', 'stratum' ),
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

			$controls->add_responsive_control(
				'tabs_alignment',
				[
					'label'   => esc_html__( 'Navigation Alignment', 'stratum' ),
					'type'    => Controls_Manager::CHOOSE,
					'default' => 'center',
					'toggle'  => false,
					'options' => [
						'flex-start' => [
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
						]
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-content-switcher .stratum-content-switcher__nav' => 'justify-content: {{VALUE}};',
					]
				]
			);

			$controls->add_responsive_control(
				'content_items_padding',
				[
					'label'      => esc_html__( 'Padding', 'stratum' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-content-switcher.is-multiple .stratum-content-switcher__nav-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .stratum-content-switcher.is-toggle .stratum-content-switcher__label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'content_items_border_radius',
				[
					'label' 			 => esc_html__( 'Border Radius', 'stratum' ),
					'type' 			     => Controls_Manager::DIMENSIONS,
					'size_units' 		 => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'default'			 => [
						'top'	 =>  '20',
						'bottom' =>  '20',
						'left'	 =>  '20',
						'right'	 =>  '20',
						'unit'	 =>	 'px'
					],
					'selectors' 		 => [
						'{{WRAPPER}} .stratum-content-switcher.is-multiple .stratum-content-switcher__nav-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .stratum-content-switcher.is-toggle .stratum-content-switcher__label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_control(
				'tab_content_brcolor_multiple',
				[
					'label' 	  => esc_html__( 'Background Color', 'stratum' ),
					'type' 		  => Controls_Manager::COLOR,
					'render_type' => 'ui',
					'default'     => '#FFFFFF',
					'selectors'   => [
						'{{WRAPPER}} .stratum-content-switcher.is-multiple .stratum-content-switcher__nav-content' => 'background-color: {{VALUE}}',
					],
					'condition'   => [
						'content_type' => 'multiple',
					],
				]
			);

			$controls->add_control(
				'tab_content_brcolor_toggle',
				[
					'label' 	  => esc_html__( 'Background Color', 'stratum' ),
					'type' 		  => Controls_Manager::COLOR,
					'render_type' => 'ui',
					'selectors'   => [
						'{{WRAPPER}} .stratum-content-switcher.is-toggle .stratum-content-switcher__label' => 'background-color: {{VALUE}}',
					],
					'condition'   => [
						'content_type' => 'toggle',
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' 	   		 => 'content_items_shadow_multiple',
					'selector' 		 => '{{WRAPPER}} .stratum-content-switcher.is-multiple .stratum-content-switcher__nav-content',
					'fields_options' => [
						'box_shadow_type' => [
							'default' 	  => 'yes',
						],
						'box_shadow'      => [
							'default'     => [
								'horizontal' => 0,
								'vertical'   => 4,
								'blur'       => 24,
								'spread' 	 => 0,
								'color' 	 => 'rgba(0,0,0,0.1)',
							],
						],
					],
					'condition'   => [
						'content_type' => 'multiple',
					],
				]
			);


			$controls->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' 	   		 => 'content_items_shadow_toggle',
					'selector' 		 => '{{WRAPPER}} .stratum-content-switcher.is-toggle .stratum-content-switcher__label',
					'condition'   => [
						'content_type' => 'toggle',
					],
				]
			);

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_tabs_style',
			[
				'label' => esc_html__( 'Tabs Style', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$controls->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'        => 'tabs_items_typography',
					'selector'    => '{{WRAPPER}} .stratum-content-switcher .stratum-content-switcher__nav-title',
					'label'       => esc_html__( 'Typography', 'stratum' ),
				]
			);

			$controls->add_responsive_control(
				'tabs_items_padding_multiple',
				[
					'label'      		 => esc_html__( 'Padding', 'stratum' ),
					'type'       		 => Controls_Manager::DIMENSIONS,
					'size_units' 		 => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'default'			 => [
						'top'	 =>  '12',
						'bottom' =>  '12',
						'left'	 =>  '23',
						'right'	 =>  '23',
						'unit'	 =>	 'px'
					],
					'selectors' 		 => [
						'{{WRAPPER}} .stratum-content-switcher.is-multiple .stratum-content-switcher__nav-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'   => [
						'content_type' => 'multiple',
					],
				]
			);

			$controls->add_responsive_control(
				'tabs_items_padding_toggle',
				[
					'label'      		 => esc_html__( 'Padding', 'stratum' ),
					'type'       		 => Controls_Manager::DIMENSIONS,
					'size_units' 		 => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'default'			 => [
						'top'	 =>  '0',
						'bottom' =>  '0',
						'left'	 =>  '15',
						'right'	 =>  '15',
						'unit'	 =>	 'px'
					],
					'selectors' 		 => [
						'{{WRAPPER}} .stratum-content-switcher.is-toggle .stratum-content-switcher__nav-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'   => [
						'content_type' => 'toggle',
					],
				]
			);

			$controls->add_responsive_control(
				'tabs_items_border_radius',
				[
					'label' 			 => esc_html__( 'Border Radius', 'stratum' ),
					'type' 			     => Controls_Manager::DIMENSIONS,
					'size_units' 		 => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'default'			 => [
						'top'	 =>  '20',
						'bottom' =>  '20',
						'left'	 =>  '20',
						'right'	 =>  '20',
						'unit'	 =>	 'px'
					],
					'selectors' 		 => [
						'{{WRAPPER}} .stratum-content-switcher.is-multiple .stratum-content-switcher__nav-pill' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->start_controls_tabs( 'tabs_styles' );

				$controls->start_controls_tab(
					'tab_normal',
					[
						'label' => esc_html__( 'Normal', 'stratum' ),
					]
				);

					$controls->add_control(
						'tab_text_color',
						[
							'label' 	  => esc_html__( 'Text Color', 'stratum' ),
							'type' 		  => Controls_Manager::COLOR,
							'render_type' => 'ui',
							'default'	  => '#22262C',
							'selectors'   => [
								'{{WRAPPER}} .stratum-content-switcher.is-multiple .stratum-content-switcher__nav-button' => 'color: {{VALUE}}',
								'{{WRAPPER}} .stratum-content-switcher.is-toggle .stratum-content-switcher__nav-item > .stratum-content-switcher__nav-title' => 'color: {{VALUE}}',
							],
						]
					);

					$controls->add_control(
						'tab_pill_bgcolor',
						[
							'label' 	  => esc_html__( 'Pill Background Color', 'stratum' ),
							'type' 		  => Controls_Manager::COLOR,
							'render_type' => 'ui',
							'default'	  => '#F74A00',
							'selectors'   => [
								'{{WRAPPER}} .stratum-content-switcher.is-multiple .stratum-content-switcher__nav-pill' => 'background-color: {{VALUE}}',
							],
							'condition'   => [
								'content_type' => 'multiple',
							],
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'tab_hover',
					[
						'label' => esc_html__( 'Hover', 'stratum' ),
					]
				);

					$controls->add_control(
						'tab_text_color_hover',
						[
							'label' 	  => esc_html__( 'Text Color', 'stratum' ),
							'type' 		  => Controls_Manager::COLOR,
							'render_type' => 'ui',
							'selectors'   => [
								'{{WRAPPER}} .stratum-content-switcher.is-multiple .stratum-content-switcher__nav-item:hover > .stratum-content-switcher__nav-button' => 'color: {{VALUE}}',
								'{{WRAPPER}} .stratum-content-switcher.is-toggle .stratum-content-switcher__nav-item:hover > .stratum-content-switcher__nav-title' => 'color: {{VALUE}}',
							],
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'tab_active',
					[
						'label' => esc_html__( 'Active', 'stratum' ),
					]
				);

					$controls->add_control(
						'tab_text_color_active_multiple',
						[
							'label' 	  => esc_html__( 'Text Color', 'stratum' ),
							'type' 		  => Controls_Manager::COLOR,
							'render_type' => 'ui',
							'default'	  => '#FFFFFF',
							'selectors'   => [
								'{{WRAPPER}} .stratum-content-switcher.is-multiple .stratum-content-switcher__nav-item.is-active > .stratum-content-switcher__nav-button' => 'color: {{VALUE}}',
							],
							'condition'   => [
								'content_type' => 'multiple',
							],
						]
					);

					$controls->add_control(
						'tab_text_color_active_toggle',
						[
							'label' 	  => esc_html__( 'Text Color', 'stratum' ),
							'type' 		  => Controls_Manager::COLOR,
							'render_type' => 'ui',
							'default'	  => '#5D74DE',
							'selectors'   => [
								'{{WRAPPER}} .stratum-content-switcher.is-toggle .stratum-content-switcher__nav-item.is-active > .stratum-content-switcher__nav-title' => 'color: {{VALUE}}',
							],
							'condition'   => [
								'content_type' => 'toggle',
							],
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_switch_tabs_style',
			[
				'label' 	=> esc_html__( 'Toggle Style', 'stratum' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
				'condition' => [
					'content_type' => 'toggle',
				],
			]
		);

			$controls->add_responsive_control(
				'switch_checkbox_container_padding',
				[
					'label'      		 => esc_html__( 'Padding', 'stratum' ),
					'type'       		 => Controls_Manager::DIMENSIONS,
					'size_units' 	     => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'default'			 => [
						'top'    		 => '6',
						'right'  		 => '16',
						'bottom' 		 => '6',
						'left' 	 		 => '16',
						'unit' 	 		 => 'px',
					],
					'selectors'  		 => [
						'{{WRAPPER}} .stratum-content-switcher.is-toggle .stratum-content-switcher__toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'switch_checkbox_size',
				[
					'label'   	 => esc_html__( 'Checkbox Switcher Size', 'stratum' ),
					'type'    	 => Controls_Manager::SLIDER,
					'range'   	 => [
						'px'  	 => [
							'min' => 0,
							'max' => 100,
						],
						'%'  	 => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default'    => [
						'size'   => 9,
						'unit'   => 'px',
					],
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-content-switcher.is-toggle .stratum-content-switcher__toggle::before' => '--toggle-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'switch_checkbox_container_radius',
				[
					'label'   	 => esc_html__( 'Switcher Border Radius', 'stratum' ),
					'type'    	 => Controls_Manager::SLIDER,
					'range'   	 => [
						'px'  	 => [
							'min' => 0,
							'max' => 100,
						],
						'%'  	 => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default'    => [
						'size'   => 10,
						'unit'   => 'px',
					],
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-content-switcher.is-toggle .stratum-content-switcher__toggle' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'switch_checkbox_radius',
				[
					'label'   	 => esc_html__( 'Checkbox Switcher Border Radius', 'stratum' ),
					'type'    	 => Controls_Manager::SLIDER,
					'range'   	 => [
						'px'  	 => [
							'min' => 0,
							'max' => 100,
						],
						'%'  	 => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default'    => [
						'size'   => 50,
						'unit'   => '%',
					],
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-content-switcher.is-toggle .stratum-content-switcher__toggle::before' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$controls->add_control(
				'switch_checkbox_bgcolor',
				[
					'label' 	  => esc_html__( 'Switcher Background Color', 'stratum' ),
					'type' 		  => Controls_Manager::COLOR,
					'render_type' => 'ui',
					'default'	  => '#5D74DEA1',
					'selectors'   => [
						'{{WRAPPER}} .stratum-content-switcher.is-toggle .stratum-content-switcher__toggle' => 'background: {{VALUE}}',
					],
				]
			);

			$controls->add_control(
				'switch_checkbox_color',
				[
					'label' 	  => esc_html__( 'Checkbox Switcher Color', 'stratum' ),
					'type' 		  => Controls_Manager::COLOR,
					'render_type' => 'ui',
					'default'	  => '#5D74DE',
					'selectors'   => [
						'{{WRAPPER}} .stratum-content-switcher.is-toggle .stratum-content-switcher__toggle::before' => 'background: {{VALUE}}',
					],
				]
			);

		$controls->end_controls_section();


		$controls->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content Style', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$controls->add_responsive_control(
				'content_margin',
				[
					'label' 			 => esc_html__( 'Margin', 'stratum' ),
					'type' 			     => Controls_Manager::DIMENSIONS,
					'size_units' 		 => [ 'px' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'default'			 => [
						'top'	 =>  '20',
						'bottom' =>  '20',
						'left'	 =>  '20',
						'right'	 =>  '20',
						'unit'	 =>	 'px'
					],
					'selectors' 		 => [
						'{{WRAPPER}} .stratum-content-switcher__item-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_control(
				'content_animation',
				[
					'label'   => esc_html__( 'Animation', 'stratum' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'fade',
					'options' => [
						'none'  => esc_html__( 'None', 'stratum' ),
						'fade'  => esc_html__( 'Fade', 'stratum' ),
					],
				]
			);

		$controls->end_controls_section();
	}

	// PHP template (refresh elements)
	protected function render() {
		$this->render_widget( 'php' );
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Content_Switcher() );