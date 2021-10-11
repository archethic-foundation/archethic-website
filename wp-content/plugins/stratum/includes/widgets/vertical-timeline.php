<?php
/**
 * Class: Vertical_Timeline
 * Name: Vertical Timeline
 * Slug: vertical-timeline
 */

namespace Stratum;

use \Elementor\Plugin;
use Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vertical_Timeline extends Stratum_Widget_Base {
	protected $widget_name = 'vertical-timeline';

	public function __construct($data = [], $args = null) {
		parent::__construct( $data, $args );
	}

	public function get_title() {
		return esc_html__( 'Vertical Timeline', 'stratum' );
	}

	public function get_icon() {
		return 'stratum-icon-vertical-timeline';
	}

	public function get_categories() {
		return [ 'stratum-widgets' ];
	}

    protected function _register_controls() {
		$controls = $this;

		$primary_color = !empty(get_option( 'stratum_style' )) ? (!empty(get_option( 'stratum_style' )['primary_color']) ? get_option( 'stratum_style' )['primary_color'] : '') : '#71d7f7';

		/*-----------------------------------------------------------------------------------*/
        /*	Content Tab
        /*-----------------------------------------------------------------------------------*/

        $controls->start_controls_section(
			'general_settings',
			[
				'label' => esc_html__( 'Items', 'stratum' )
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'show_item_image',
			[
				'label' => esc_html__( 'Show Image', 'stratum' ),
				'type'  => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'stratum' ),
				'label_off' => esc_html__( 'No' , 'stratum' ),
				'return_value' => 'yes',
				'default' => ''
			]
		);

		$repeater->add_control(
			'item_image',
			[
				'label'   => esc_html__( 'Image', 'stratum' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src()
				],
				'condition' => [
					'show_item_image' => 'yes'
				]
			]
		);

		$repeater->add_control(
			'image_size',
			[
				'type'    => 'select',
				'label'   => esc_html__( 'Image Size', 'stratum' ),
				'default' => 'full',
				'options' => Stratum::get_instance()->get_scripts_manager()->get_image_sizes(),
				'condition' => [
					'show_item_image' => 'yes'
				]
			]
		);

		$repeater->add_control(
			'item_title',
			[
				'label'   => esc_html__( 'Title', 'stratum' ),
				'type'    => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Type your title here...', 'stratum' ),
				'dynamic' => [ 'active' => true ]
			]
		);

		$repeater->add_control(
			'item_link',
			[
				'label'       => esc_html__( 'Link', 'stratum' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' 	   => true
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'stratum' )
			]
		);


		$repeater->add_control(
			'item_meta',
			[
				'label'   => esc_html__( 'Meta', 'stratum' ),
				'type'    => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Type your meta here...', 'stratum' ),
				'dynamic' => [ 'active' => true ]
			]
		);

		$repeater->add_control(
			'item_description_type',
			[
				'label'       	   => esc_html__( 'Content Type', 'stratum' ),
				'type' 	      	   => Controls_Manager::CHOOSE,
				'toggle'      	   => false,
				'default'	  	   => 'default',
				'label_block' 	   => false,
				'options'	  	   => [
					'default'	   => [
						'title'	   => esc_html__( 'Default', 'stratum' ),
						'icon'	   => 'eicon-edit'
					],
					'editor'	   => [
						'title'	   => esc_html__( 'Editor', 'stratum' ),
						'icon'	   => 'eicon-editor-code'
					]
				],
			]
		);

		$repeater->add_control(
			'item_description',
			[
				'label'       => esc_html__( 'Description', 'stratum' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Type your description here...', 'stratum' ),
				'dynamic'     => [ 'active' => true ]
			]
		);

		$repeater->add_control(
			'item_description_editor',
			[
				'label'     => esc_html__( 'Description', 'stratum' ),
				'type'      => Controls_Manager::WYSIWYG,
				'condition'	=> [
					'item_description_type' => 'editor',
				],
			]
		);

		$repeater->add_control(
			'item_point',
			[
				'label'     => esc_html__( 'Point', 'stratum' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'item_point_type',
			[
				'label'   => esc_html__( 'Point Content Type', 'stratum' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon' => esc_html__( 'Icon', 'stratum' ),
					'text' => esc_html__( 'Text', 'stratum' )
				]
			]
		);

		$repeater->add_control(
			'item_point_icon',
			[
				'label' => esc_html__( 'Icon', 'stratum' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fa fa-shopping-cart',
					'library' => 'fa-solid'
				],
				'condition' => [
					'item_point_type' => 'icon'
				]
			]
		);

		$repeater->add_control(
			'item_point_text',
			[
				'label'     => esc_html__( 'Point Text', 'stratum' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'A',
				'condition' => [
					'item_point_type' => 'text'
				]
			]
		);

		$controls->add_control(
			'image_content',
			[
				'type'  => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'item_title'       		  => sprintf( esc_html__( 'Item #%d', 'stratum' ), 1 ),
						'item_description' 		  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'stratum' ),
						'item_description_editor' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'stratum' ),
						'item_meta'        		  => 'July 13, 2020'
					],
					[
						'item_title'       		  => sprintf( esc_html__( 'Item #%d', 'stratum' ), 2 ),
						'item_description' 		  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'stratum' ),
						'item_description_editor' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'stratum' ),
						'item_meta'        		  => 'August 12, 2020'
					],
					[
						'item_title'       		  => sprintf( esc_html__( 'Item #%d', 'stratum' ), 3 ),
						'item_description' 		  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'stratum' ),
						'item_description_editor' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'stratum' ),
						'item_meta'        		  => 'September 18, 2020'
					]
				],
				'title_field' => '{{{ item_title }}}'
			]
		);

		$controls->add_control(
			'title_tag',
			[
				'label' => esc_html__( 'Title HTML Tag', 'stratum' ),
				'type'  => Controls_Manager::SELECT,
				'options' => [
					'h1'   => esc_html__( 'H1', 'stratum' ),
					'h2'   => esc_html__( 'H2', 'stratum' ),
					'h3'   => esc_html__( 'H3', 'stratum' ),
					'h4'   => esc_html__( 'H4', 'stratum' ),
					'h5'   => esc_html__( 'H5', 'stratum' ),
					'h6'   => esc_html__( 'H6', 'stratum' ),
					'div'  => esc_html__( 'div' , 'stratum' ),
					'span' => esc_html__( 'span', 'stratum' ),
					'p'    => esc_html__( 'p', 'stratum' )
				],
				'default'   => 'h5',
				'separator' => 'before'
			]
		);

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'stratum' )
			]
		);

			$controls->add_control(
				'animate_cards',
				[
					'label' => esc_html__( 'Animate Cards', 'stratum' ),
					'type'  => Controls_Manager::SELECT,
					'options' => [
						'none'         => esc_html__( 'None'       , 'stratum' ),
						'slideInSides' => esc_html__( 'Slide In'   , 'stratum' ),
						'slideInUp'    => esc_html__( 'Slide In Up', 'stratum' ),
						'fadeIn'       => esc_html__( 'Fade In'    , 'stratum' )
					],
					'default' => 'none'
				]
			);

			$controls->add_control(
				'horizontal_alignment',
				[
					'label' => esc_html__( 'Horizontal Alignment', 'stratum' ),
					'type'  => Controls_Manager::CHOOSE,
					'default' => 'chess',
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'stratum' ),
							'icon'  => 'eicon-h-align-left'
						],
						'chess' => [
							'title' => esc_html__( 'Middle', 'stratum' ),
							'icon'  => 'eicon-h-align-center'
						],
						'right'  => [
							'title' => esc_html__( 'Right', 'stratum' ),
							'icon'  => 'eicon-h-align-right'
						]
					]
				]
			);

			$controls->add_control(
				'vertical_alignment',
				[
					'label' => esc_html__( 'Vertical Alignment', 'stratum' ),
					'type'  => Controls_Manager::CHOOSE,
					'default' => 'middle',
					'options' => [
						'top' => [
							'title' => esc_html__( 'Top', 'stratum' ),
							'icon'  => 'eicon-v-align-top'
						],
						'middle' => [
							'title' => esc_html__( 'Middle', 'stratum' ),
							'icon'  => 'eicon-v-align-middle'
						],
						'bottom' => [
							'title' => esc_html__( 'Bottom', 'stratum' ),
							'icon'  => 'eicon-v-align-bottom'
						]
					]
				]
			);

			$controls->add_responsive_control(
				'horizontal_space',
				[
					'label' => esc_html__( 'Horizontal Space', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 150
						]
					],
					'default' => [
						'size' => 20,
						'unit' => 'px'
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-vertical-timeline-item__point' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}}'
					]
				]
			);

			$controls->add_responsive_control(
				'vertical_space',
				[
					'label' => esc_html__( 'Vertical Space', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'size_units' => [
						'px'
					],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 150
						]
					],
					'default' => [
						'size' => 30,
						'unit' => 'px'
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-vertical-timeline-item + .stratum-vertical-timeline-item' => 'margin-top: {{SIZE}}{{UNIT}};'
					]
				]
			);

		$controls->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
        /*	Style Tab
		/*-----------------------------------------------------------------------------------*/

		$controls->start_controls_section(
			'section_cards_style',
			[
				'label' => esc_html__( 'Cards', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'show_label' => false
			]
		);
			$controls->add_responsive_control(
				'cards_padding',
				[
					'label' => esc_html__( 'Padding', 'stratum' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__card-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
					'separator' => 'after'
				]
			);

			$controls->start_controls_tabs( 'cards_style_tabs' );

				$controls->start_controls_tab( 'cards_normal_styles', [ 'label' => esc_html__( 'Normal', 'stratum' ) ] );

					$controls->add_control(
						'cards_background_normal',
						[
							'label' => esc_html__( 'Background', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__card' => 'background-color: {{VALUE}}',
							]
						]
					);

					$controls->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'cards_box_shadow_normal',
							'selector' => '{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__card, {{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__card-arrow',
							'exclude'  => [
								'box_shadow_position'
							]
						]
					);

					$controls->add_group_control(
						Group_Control_Border::get_type(),
						[
							'name'  => 'cards_border_type_normal',
							'label' => esc_html__( 'Border', 'stratum' ),
							'placeholder' => '1px',
							'default'     => '1px',
							'selector'    => '{{WRAPPER}} .stratum-vertical-timeline-item__card, {{WRAPPER}} .stratum-vertical-timeline-item__card-arrow'
						]
					);

					$controls->add_responsive_control(
						'cards_border_radius_normal',
						[
							'label' => esc_html__( 'Border Radius', 'stratum' ),
							'type'  => Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', '%' ],
							'selectors'  => [
								'{{WRAPPER}} .stratum-vertical-timeline-item__card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
								'{{WRAPPER}} .stratum-vertical-timeline-item__card-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab( 'cards_hover_styles', [ 'label' => esc_html__( 'Hover', 'stratum' ) ] );

					$controls->add_control(
						'cards_background_hover',
						[
							'label' => esc_html__( 'Background', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item:hover .stratum-vertical-timeline-item__card' => 'background-color: {{VALUE}}',
							]
						]
					);

					$controls->add_control(
						'cards_border_color_hover',
						[
							'label'     => esc_html__( 'Border Color', 'stratum' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item:hover .stratum-vertical-timeline-item__card' => 'border-color: {{VALUE}};'
							],
							'condition' => [
								'cards_border_border!' => ''
							]
						]
					);

					$controls->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'cards_box_shadow_hover',
							'selector' => '{{WRAPPER}} .stratum-vertical-timeline-item:hover .stratum-vertical-timeline-item__card',
							'exclude'  => [
								'box_shadow_position'
							]
						]
					);

					$controls->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'label' => 'Arrows Box Shadow',
							'name' => 'arrows_box_shadow_hover',
							'selector' => '{{WRAPPER}} .stratum-vertical-timeline-item:hover .stratum-vertical-timeline-item__card-arrow',
							'exclude' => [
								'box_shadow_position'
							]
						]
					);

					$controls->add_group_control(
						Group_Control_Border::get_type(),
						[
							'name'  => 'cards_border_type_hover',
							'label' => esc_html__( 'Border', 'stratum' ),
							'placeholder' => '1px',
							'default'     => '1px',
							'selector'    => '{{WRAPPER}} .stratum-vertical-timeline-item:hover .stratum-vertical-timeline-item__card, {{WRAPPER}} .stratum-vertical-timeline-item:hover .stratum-vertical-timeline-item__card-arrow'
						]
					);

					$controls->add_responsive_control(
						'cards_border_radius_hover',
						[
							'label' => esc_html__( 'Border Radius', 'stratum' ),
							'type'  => Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', '%' ],
							'selectors'  => [
								'{{WRAPPER}} .stratum-vertical-timeline-item:hover .stratum-vertical-timeline-item__card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
								'{{WRAPPER}} .stratum-vertical-timeline-item:hover .stratum-vertical-timeline-item__card-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab( 'cards_active_styles', [ 'label' => esc_html__( 'Active', 'stratum' ) ] );

					$controls->add_control(
						'cards_background_active',
						[
							'label' => esc_html__( 'Background', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item.is-active .stratum-vertical-timeline-item__card' => 'background-color: {{VALUE}}',
							]
						]
					);

					$controls->add_control(
						'cards_border_color_active',
						[
							'label' => esc_html__( 'Border Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .stratum-vertical-timeline-item.is-active .stratum-vertical-timeline-item__card' => 'border-color: {{VALUE}};'
							),
							'condition' => [
								'cards_border_border!' => ''
							]
						]
					);

					$controls->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'cards_box_shadow_active',
							'selector' => '{{WRAPPER}} .stratum-vertical-timeline-item.is-active .stratum-vertical-timeline-item__card',
							'exclude'  => [
								'box_shadow_position'
							]
						]
					);

					$controls->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'label' => 'Arrows Box Shadow',
							'name' => 'arrows_box_shadow_active',
							'selector' => '{{WRAPPER}} .stratum-vertical-timeline-item.is-active .stratum-vertical-timeline-item__card-arrow',
							'exclude'  => [
								'box_shadow_position'
							]
						]
					);

					$controls->add_group_control(
						Group_Control_Border::get_type(),
						[
							'name'  => 'cards_border_type_active',
							'label' => esc_html__( 'Border', 'stratum' ),
							'placeholder' => '1px',
							'default'     => '1px',
							'selector'    => '{{WRAPPER}} .stratum-vertical-timeline-item.is-active .stratum-vertical-timeline-item__card, {{WRAPPER}} .stratum-vertical-timeline-item.is-active .stratum-vertical-timeline-item__card-arrow'
						]
					);

					$controls->add_responsive_control(
						'cards_border_radius_active',
						[
							'label' => esc_html__( 'Border Radius', 'stratum' ),
							'type'  => Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', '%' ],
							'selectors'  => [
								'{{WRAPPER}} .stratum-vertical-timeline-item.is-active .stratum-vertical-timeline-item__card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
								'{{WRAPPER}} .stratum-vertical-timeline-item.is-active .stratum-vertical-timeline-item__card-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
							]
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_image_style',
			[
				'label' => esc_html__( 'Image', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'show_label' => false
			]
		);

			$controls->add_responsive_control(
				'image_spacing',
				[
					'label' => esc_html__( 'Spacing', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'size_units' => [
						'px'
					],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 200
						]
					],
					'default' => [
						'size' => 0,
						'unit' => 'px'
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__card-image' => 'margin-bottom: {{SIZE}}{{UNIT}};'
					]
				]
			);

			$controls->add_control(
				'image_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__card-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;'
					]
				]
			);

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_meta_style',
			[
				'label' => esc_html__( 'Meta', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'show_label' => false
			]
		);

			$controls->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'meta_typography',
					'selector' => '{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__meta-content'
				]
			);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'        => 'meta_border',
					'label'       => esc_html__( 'Border', 'stratum' ),
					'placeholder' => '1px',
					'default'     => '1px',
					'selector'    => '{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__meta-content'
				]
			);

			$controls->add_control(
				'meta_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__meta-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;'
					]
				]
			);

			$controls->add_responsive_control(
				'meta_padding',
				[
					'label'      => esc_html__( 'Padding', 'stratum' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__meta-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

			$controls->add_responsive_control(
				'meta_margin',
				[
					'label'      => esc_html__( 'Margin', 'stratum' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__meta-content'=> 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
					'separator' => 'after'
				]
			);

			$controls->start_controls_tabs( 'meta_style_tabs' );

				$controls->start_controls_tab( 'meta_normal_styles', [ 'label' => esc_html__( 'Normal', 'stratum' ) ] );

					$controls->add_control(
						'meta_normal_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__meta-content' => 'color: {{VALUE}}'
							]
						]
					);

					$controls->add_control(
						'meta_normal_background_color',
						[
							'label' => esc_html__( 'Background Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__meta-content' => 'background-color: {{VALUE}}'
							]
						]
					);

					$controls->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'     => 'meta_normal_box_shadow',
							'selector' => '{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__meta-content'
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab( 'meta_hover_styles', [ 'label' => esc_html__( 'Hover', 'stratum' ) ] );

					$controls->add_control(
						'meta_hover_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item:hover .stratum-vertical-timeline-item__meta-content' => 'color: {{VALUE}}'
							]
						]
					);

					$controls->add_control(
						'meta_hover_background_color',
						[
							'label' => esc_html__( 'Background Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item:hover .stratum-vertical-timeline-item__meta-content' => 'background-color: {{VALUE}}'
							]
						]
					);

					$controls->add_control(
						'meta_hover_border_color',
						[
							'label' => esc_html__( 'Border Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .stratum-vertical-timeline-item:hover .stratum-vertical-timeline-item__meta-content' => 'border-color: {{VALUE}}'
							),
							'condition' => [
								'meta_border_border!' => ''
							]
						]
					);

					$controls->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'     => 'meta_hover_box_shadow',
							'selector' => '{{WRAPPER}} .stratum-vertical-timeline-item:hover .stratum-vertical-timeline-item__meta-content'
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab( 'meta_active_styles', [ 'label' => esc_html__( 'Active', 'stratum' ) ] );

					$controls->add_control(
						'meta_active_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item.is-active .stratum-vertical-timeline-item__meta-content' => 'color: {{VALUE}}'
							]
						]
					);

					$controls->add_control(
						'meta_active_background_color',
						[
							'label' => esc_html__( 'Background Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item.is-active .stratum-vertical-timeline-item__meta-content' => 'background-color: {{VALUE}}'
							]
						]
					);

					$controls->add_control(
						'meta_active_border_color',
						[
							'label' => esc_html__( 'Border Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .stratum-vertical-timeline-item.is-active .stratum-vertical-timeline-item__meta-content' => 'border-color: {{VALUE}}'
							),
							'condition' => [
								'meta_border_border!' => ''
							]
						]
					);

					$controls->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'     => 'meta_active_box_shadow',
							'selector' => '{{WRAPPER}} .stratum-vertical-timeline-item.is-active .stratum-vertical-timeline-item__meta-content'
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_card_content_style',
			[
				'label' => esc_html__( 'Content', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'show_label' => false
			]
		);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'        => 'card_content_border',
					'label'       => esc_html__( 'Border', 'stratum' ),
					'placeholder' => '1px',
					'default'     => '1px',
					'selector'    => '{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__card-content'
				]
			);

			$controls->add_control(
				'card_content_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'stratum' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__card-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;'
					]
				]
			);

			$controls->add_responsive_control(
				'card_content_padding',
				[
					'label'      => esc_html__( 'Padding', 'stratum' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__card-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
					'separator' => 'after'
				]
			);

			$controls->start_controls_tabs( 'card_content_style_tabs' );

				$controls->start_controls_tab( 'card_content_normal_styles', [ 'label' => esc_html__( 'Normal', 'stratum' ) ] );

					$controls->add_control(
						'card_content_normal_background_color',
						[
							'label' => esc_html__( 'Background Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__card-content' => 'background-color: {{VALUE}}'
							]
						]
					);

					$controls->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'     => 'card_content_normal_shadow',
							'selector' => '{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__card-content'
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab( 'card_content_hover_styles', [ 'label' => esc_html__( 'Hover', 'stratum' ) ] );

					$controls->add_control(
						'card_content_hover_background_color',
						[
							'label' => esc_html__( 'Background Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item:hover .stratum-vertical-timeline-item__card-content' => 'background-color: {{VALUE}}'
							]
						]
					);

					$controls->add_control(
						'card_content_hover_border_color',
						[
							'label' => esc_html__( 'Border Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item:hover .stratum-vertical-timeline-item__card-content' => 'border-color: {{VALUE}}'
							],
							'condition' => [
								'card_content_border_border!' => ''
							]
						]
					);

					$controls->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'     => 'card_content_hover_shadow',
							'selector' => '{{WRAPPER}} .stratum-vertical-timeline-item:hover .stratum-vertical-timeline-item__card-content'
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab( 'card_content_active_styles', [ 'label' => esc_html__( 'Active', 'stratum' ) ] );

					$controls->add_control(
						'card_content_active_background_color',
						[
							'label' => esc_html__( 'Background Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item.is-active .stratum-vertical-timeline-item__card-content' => 'background-color: {{VALUE}}'
							]
						]
					);

					$controls->add_control(
						'card_content_active_border_color',
						[
							'label' => esc_html__( 'Border Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item.is-active .stratum-vertical-timeline-item__card-content'=> 'border-color: {{VALUE}}'
							],
							'condition' => [
								'card_content_border_border!' => ''
							]
						]
					);

					$controls->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'card_content_active_shadow',
							'selector' => '{{WRAPPER}} .stratum-vertical-timeline-item.is-active .stratum-vertical-timeline-item__card-content'
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_card_title_style',
			[
				'label' => esc_html__( 'Title', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'show_label' => false
			]
		);

			$controls->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'card_title_typography',
					'selector' => '{{WRAPPER}}  .stratum-vertical-timeline-item .stratum-vertical-timeline-item__card-title'
				]
			);

			$controls->add_responsive_control(
				'card_title_margin',
				[
					'label' => esc_html__( 'Margin', 'stratum' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__card-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
					'separator' => 'after'
				]
			);

			$controls->start_controls_tabs( 'card_title_style_tabs' );

				$controls->start_controls_tab( 'card_title_normal_styles', [ 'label' => esc_html__( 'Normal', 'stratum' ) ] );

					$controls->add_control(
						'card_title_normal_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__card-title' => 'color: {{VALUE}}'
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab( 'card_title_hover_styles', [ 'label' => esc_html__( 'Hover', 'stratum' ) ] );

					$controls->add_control(
						'card_title_hover_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item:hover .stratum-vertical-timeline-item__card-title' => 'color: {{VALUE}}'
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab( 'card_title_active_styles', [ 'label' => esc_html__( 'Active', 'stratum' ) ] );

					$controls->add_control(
						'card_title_active_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item.is-active .stratum-vertical-timeline-item__card-title'=> 'color: {{VALUE}}'
							]
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_description_style',
			[
				'label' => esc_html__( 'Description', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'show_label' => false
			]
		);

			$controls->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'card_description_typography',
					'selector' => '{{WRAPPER}}  .stratum-vertical-timeline-item .stratum-vertical-timeline-item__card-description'
				]
			);

			$controls->add_responsive_control(
				'card_description_margin',
				[
					'label'      => esc_html__( 'Margin', 'stratum' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__card-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
				]
			);

			$controls->start_controls_tabs( 'card_description_style_tabs' );

				$controls->start_controls_tab( 'card_description_normal_styles', [ 'label' => esc_html__( 'Normal', 'stratum' ) ] );

					$controls->add_control(
						'card_description_normal_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item .stratum-vertical-timeline-item__card-description' => 'color: {{VALUE}}'
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab( 'card_description_hover_styles', [ 'label' => esc_html__( 'Hover', 'stratum' ) ] );

					$controls->add_control(
						'card_description_hover_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item:hover .stratum-vertical-timeline-item__card-description' => 'color: {{VALUE}}'
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab( 'card_description_active_styles', [ 'label' => esc_html__( 'Active', 'stratum' ) ] );

					$controls->add_control(
						'card_description_active_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item.is-active .stratum-vertical-timeline-item__card-description'=> 'color: {{VALUE}}'
							]
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

        $controls->start_controls_section(
			'section_point_style',
			[
				'label' => esc_html__( 'Point', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'show_label' => false
			]
		);

			$controls->start_controls_tabs( 'point_type_style_tabs' );

				$controls->start_controls_tab( 'point_type_text_styles', [ 'label' => esc_html__( 'Text', 'stratum' ) ] );

					$controls->add_group_control(
						Group_Control_Typography::get_type(),
						[
							'name' => 'point_text_typography',
							'selector' => '{{WRAPPER}} .stratum-vertical-timeline-item__point-content--text'
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab( 'point_type_icon_styles', [ 'label' => esc_html__( 'Icon', 'stratum' ) ] );

					$controls->add_responsive_control(
						'point_type_icon_size',
						[
							'label' => esc_html__( 'Icon Size', 'stratum' ),
							'type' => Controls_Manager::SLIDER,
							'size_units' => [ 'px', 'em', 'rem' ],
							'range' => [
								'px' => [
									'min' => 5,
									'max' => 100
								]
							],
							'default' => [
								'size' => 16,
								'unit' => 'px'
							],
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item__point-content--icon .stratum-vertical-timeline-item__icon' => 'font-size: {{SIZE}}{{UNIT}};',
								'{{WRAPPER}} .stratum-vertical-timeline-item__point-content--icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'

							]
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

			$controls->add_responsive_control(
				'point_size',
				[
					'label' => esc_html__( 'Point Size', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em', 'rem' ],
					'range' => [
						'px' => [
							'min' => 10,
							'max' => 100
						]
					],
					'default' => [
						'size' => 40,
						'unit' => 'px'
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-vertical-timeline-item__point-content' => 'height:{{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};'
					],
					'separator' => 'before'
				]
			);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'        => 'point_border',
					'label'       => esc_html__( 'Border', 'stratum' ),
					'placeholder' => '1px',
					'default'     => '1px',
					'selector'    => '{{WRAPPER}}  .stratum-vertical-timeline-item__point-content'
				]
			);

			$controls->add_control(
				'point_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', '%' ],
					'selectors'  => [
						'{{WRAPPER}}  .stratum-vertical-timeline-item__point-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

			$controls->start_controls_tabs( 'point_style_tabs', [ 'separator' => 'before' ] );

				$controls->start_controls_tab( 'point_normal_styles', [ 'label' => esc_html__( 'Normal', 'stratum' ) ] );

					$controls->add_control(
						'point_normal_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}  .stratum-vertical-timeline-item__point-content' => 'color: {{VALUE}}'
							]
						]
					);

					$controls->add_control(
						'point_normal_background_color',
						[
							'label' => esc_html__( 'Background Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item__point-content' => 'background-color: {{VALUE}}'
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab( 'point_hover_styles', [ 'label' => esc_html__( 'Hover', 'stratum' ) ] );

					$controls->add_control(
						'point_hover_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item:hover .stratum-vertical-timeline-item__point-content' => 'color: {{VALUE}}'
							]
						]
					);

					$controls->add_control(
						'point_hover_background_color',
						[
							'label' => esc_html__( 'Background Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item:hover .stratum-vertical-timeline-item__point-content' => 'background-color: {{VALUE}}'
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab( 'point_active_styles', [ 'label' => esc_html__( 'Active', 'stratum' ) ] );

					$controls->add_control(
						'point_active_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item.is-active .stratum-vertical-timeline-item__point-content' => 'color: {{VALUE}}'
							]
						]
					);

					$controls->add_control(
						'point_active_background_color',
						[
							'label' => esc_html__( 'Background Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'default' => $primary_color,
							'selectors' => [
								'{{WRAPPER}} .stratum-vertical-timeline-item.is-active .stratum-vertical-timeline-item__point-content' => 'background-color: {{VALUE}}'
							]
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_line_style',
			[
				'label' => esc_html__( 'Line', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'show_label' => false
			]
		);

			$controls->add_control(
				'line_background_color',
				[
					'label' => esc_html__( 'Line Color', 'stratum' ),
					'type'  => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .stratum-vertical-timeline__line' => 'background-color: {{VALUE}}'
					]
				]
			);

			$controls->add_control(
				'progress_background_color',
				[
					'label' => esc_html__( 'Progress Color', 'stratum' ),
					'default' => $primary_color,
					'type'  => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .stratum-vertical-timeline__line-progress' => 'background-color: {{VALUE}}'
					]
				]
			);

			$controls->add_responsive_control(
				'line_width',
				[
					'label' => esc_html__( 'Thickness', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range' => [
						'px' => [
							'min' => 1,
							'max' => 15
						]
					],
					'default' => [
						'size' => 2,
						'unit' => 'px'
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-vertical-timeline__line'=> 'width: {{SIZE}}{{UNIT}};'
					]
				]
			);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'        => 'line_border',
					'label'       => esc_html__( 'Border', 'stratum' ),
					'placeholder' => '1px',
					'default'     => '1px',
					'selector'    => '{{WRAPPER}} .stratum-vertical-timeline__line'
				]
			);

			$controls->add_control(
				'line_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-vertical-timeline__line' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

		$controls->end_controls_section();
	}

	protected function render() {
		$this->render_widget( 'php' );
	}

	public function _get_timeline_image($class, $item) {
		$out 		= '';
		$id 		= $item[ 'item_image' ][ 'id' ];
		$image_size = $item[ 'image_size' ];

		$url 		= wp_get_attachment_image_url( $id, $image_size );
		$srcset 	= wp_get_attachment_image_srcset( $id, $image_size );

		$out .= "<div class='".esc_attr( $class.'-item__card-image' )."'>";
			$out .= "<img src='".(empty( $id ) ? Utils::get_placeholder_image_src() : esc_url( $url )."' class='wp-image-".esc_attr($id)."' srcset='".$srcset)."'/>";
		$out .= "</div>";

		return $out;
	}

	public function _generate_point_content($class, $item, $index) {

		$out = "";
		$point_type = $item[ 'item_point_type' ];
		$point_text = $item[ 'item_point_text' ];

		ob_start();
			Icons_Manager::render_icon( $item[ 'item_point_icon' ], [ 'aria-hidden' => 'true' ] );
		$icon_html = ob_get_clean();

		$this->add_render_attribute( 'content'.$index, [
			'class' => [
				$class.'-item__point-content',
				$point_type == 'icon' ? $class.'-item__point-content--icon' : $class.'-item__point-content--text'
			]
		] );

		$content_classes = $this->get_render_attribute_string( 'content'.$index );

		if ( $point_type == 'icon' ) {
			$out .= "<div ".$content_classes.">";
				$out .= "<span class='".esc_attr( $class.'-item__icon' )."'>";
					$out .= "{$icon_html}";
				$out .= "</span>";
            $out .= "</div>";
		} else {
			$out .= "<div ".$content_classes.">".esc_html( $point_text )."</div>";
		}

		return $out;
	}

	public function _get_alignment($settings, $position) {
		$horisontal_position = $settings[ 'horizontal_alignment' ];
		$vertical_position = $settings[ 'vertical_alignment' ];

		$position = $position == 'horizontal' ? $horisontal_position : $vertical_position;

		switch ( $position ) {
			case 'left':
				return 'card-left';
			case 'chess':
				return 'card-chess';
			case 'right':
				return 'card-right';
			case 'top':
				return '--point-top';
			case 'bottom':
				return '--point-bottom';
			case 'chess':
				return '';
		}
	}

	protected function content_template() {}
	public function render_plain_content( $instance = [] ) {}
}

Plugin::instance()->widgets_manager->register_widget_type( new Vertical_Timeline() );