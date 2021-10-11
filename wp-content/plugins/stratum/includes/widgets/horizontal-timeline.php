<?php
/**
 * Class: Horizontal_Timeline
 * Name: Horizontal Timeline
 * Slug: horizontal-timeline
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

class Horizontal_Timeline extends Stratum_Widget_Base {
	protected $widget_name = 'horizontal-timeline';

	public function __construct($data = [], $args = null) {
		parent::__construct( $data, $args );
	}

	public function get_title() {
		return esc_html__( 'Horizontal Timeline', 'stratum' );
	}

	public function get_icon() {
		return 'stratum-icon-horizontal-timeline';
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
			'section_items',
			[
				'label' => esc_html__( 'Items', 'stratum' )
			]
		);

			$repeater = new Repeater();

			$repeater->add_control(
				'is_item_active',
				[
					'label' => esc_html__( 'Active', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'default' => ''
				]
			);

			$repeater->add_control(
				'show_item_image',
				[
					'label' => esc_html__( 'Show Image', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'default' => ''
				]
			);

			$repeater->add_control(
				'item_image',
				[
					'label' => esc_html__( 'Image', 'stratum' ),
					'type'  => Controls_Manager::MEDIA,
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'show_item_image' => 'yes'
					],
					'dynamic' => ['active' => true ]
				]
			);

			$repeater->add_control(
				'image_size',
				[
					'type'  => 'select',
					'label' => esc_html__( 'Image Size', 'stratum' ),
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
					'label' => esc_html__( 'Title', 'stratum' ),
					'type'  => Controls_Manager::TEXT,
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
					'label' => esc_html__( 'Meta', 'stratum' ),
					'type'  => Controls_Manager::TEXT,
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
						'editor'	  	   => [
							'title'	   => esc_html__( 'Editor', 'stratum' ),
							'icon'	   => 'eicon-editor-code'
						]
					],
				]
			);

			$repeater->add_control(
				'item_description',
				[
					'label'     => esc_html__( 'Description', 'stratum' ),
					'type'      => Controls_Manager::TEXTAREA,
					'dynamic'   => [ 'active' => true ],
					'condition'	=> [
						'item_description_type' => 'default',
					],
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
					'label' => esc_html__( 'Point', 'stratum' ),
					'type'  => Controls_Manager::HEADING,
					'separator' => 'before'
				]
			);

			$repeater->add_control(
				'item_point_type',
				[
					'label' => esc_html__( 'Point Content Type', 'stratum' ),
					'type'  => Controls_Manager::SELECT,
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
					'label' => esc_html__( 'Point Icon', 'stratum' ),
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
					'label' => esc_html__( 'Point Text', 'stratum' ),
					'type'  => Controls_Manager::TEXT,
					'default' => 'A',
					'condition' => [
						'item_point_type' => 'text'
					]
				]
			);

			$controls->add_control(
				'items_content',
				[
					'type'   => Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'is_item_active'   		  => 'yes',
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
						],
						[
							'item_title'       		  => sprintf( esc_html__( 'Item #%d', 'stratum' ), 4 ),
							'item_description' 		  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'stratum' ),
							'item_description_editor' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'stratum' ),
							'item_meta'        		  => 'September 22, 2020'
						]
					],
					'title_field' => '{{{ item_title }}}'
				]
			);

			$controls->add_control(
				'item_title_tag',
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
					'default' => 'h5',
					'separator' => 'before'
				]
			);

			$controls->add_control(
				'show_card_arrows',
				[
					'label' => esc_html__( 'Show Card Arrows', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'default' => ''
				]
			);

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'stratum' )
			]
		);

			$controls->add_responsive_control(
				'columns',
				[
					'label'   => esc_html__( 'Columns', 'stratum' ),
					'type'    => Controls_Manager::NUMBER,
					'min'     => 1,
					'max'     => 6,
					'default' => 3,
					'tablet_default' => 2,
					'mobile_default' => 1,
					'selectors' => [
						'{{WRAPPER}} .stratum-horizontal-timeline-item' => 'flex: 0 0 calc(100%/{{VALUE}}); max-width: calc(100%/{{VALUE}});'
					],
					'render_type' => 'template'
				]
			);

			$controls->add_control(
				'horisontal_layout',
				[
					'label' => esc_html__( 'Layout', 'stratum' ),
					'type'  => Controls_Manager::CHOOSE,
					'toggle'  => false,
					'default' => 'top',
					'options' => [
						'top' => [
							'title' => esc_html__( 'Top', 'stratum' ),
							'icon'  => 'eicon-v-align-top'
						],
						'chess' => [
							'title' => esc_html__( 'Chess', 'stratum' ),
							'icon'  => 'eicon-v-align-middle'
						],
						'bottom' => [
							'title' => esc_html__( 'Bottom', 'stratum' ),
							'icon'  => 'eicon-v-align-bottom'
						]
					]
				]
			);

			$controls->add_control(
				'horizontal_alignment',
				[
					'label' => esc_html__( 'Alignment', 'stratum' ),
					'type'  => Controls_Manager::CHOOSE,
					'toggle'  => false,
					'default' => 'left',
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'stratum' ),
							'icon'  => 'eicon-h-align-left'
						],
						'center' => [
							'title' => esc_html__( 'Center', 'stratum' ),
							'icon'  => 'eicon-h-align-center'
						],
						'right'  => [
							'title' => esc_html__( 'Right', 'stratum' ),
							'icon'  => 'eicon-h-align-right'
						]
					]
				]
			);

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_general_style',
			[
				'label' => esc_html__( 'General', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

			$controls->add_responsive_control(
				'items_gap',
				[
					'label' => esc_html__( 'Items Gap', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100
						]
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-horizontal-timeline-item' => 'padding-left: calc({{SIZE}}{{UNIT}}/2); padding-right: calc({{SIZE}}{{UNIT}}/2);'
					],
					'render_type' => 'template'
				]
			);

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_cards_style',
			[
				'label' => esc_html__( 'Cards', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'  => 'cards_border',
					'label' => esc_html__( 'Border', 'stratum' ),
					'placeholder' => '1px',
					'default'     => '1px',
					'selector'    => '{{WRAPPER}} .stratum-horizontal-timeline-item__card, {{WRAPPER}} .stratum-horizontal-timeline-item__card-arrow'
				]
			);

			$controls->add_responsive_control(
				'cards_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-horizontal-timeline-item__card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .stratum-horizontal-timeline-item__card-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

			$controls->add_responsive_control(
				'cards_padding',
				[
					'label' => esc_html__( 'Padding', 'stratum' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-horizontal-timeline-item__card-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

			$controls->add_responsive_control(
				'cards_spacing',
				[
					'label' => esc_html__( 'Spacing', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100
						]
					],
					'selectors'  => [
						'{{WRAPPER}} .stratum-horizontal-timeline__list--top .stratum-horizontal-timeline-item__card' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .stratum-horizontal-timeline__list--bottom .stratum-horizontal-timeline-item__card' => 'margin-top: {{SIZE}}{{UNIT}};'
					],
					'separator' => 'after'
				]
			);

			$controls->start_controls_tabs( 'cards_style_tabs' );

				$controls->start_controls_tab(
					'cards_normal_styles',
					[
						'label' => esc_html__( 'Normal', 'stratum' )
					]
				);

					$controls->add_control(
						'cards_background_normal',
						[
							'label' => esc_html__( 'Background', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item__card-inner' => 'background-color: {{VALUE}};',
								'{{WRAPPER}} .stratum-horizontal-timeline-item__card-arrow' => 'background-color: {{VALUE}};'
							]
						]
					);

					$controls->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'cards_box_shadow_normal',
							'selector' => '{{WRAPPER}} .stratum-horizontal-timeline-item__card, {{WRAPPER}} .stratum-horizontal-timeline-item__card-arrow',
							'exclude'  => [
								'box_shadow_position'
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'cards_hover_styles',
					[
						'label' => esc_html__( 'Hover', 'stratum' )
					]
				);

					$controls->add_control(
						'cards_background_hover',
						[
							'label' => esc_html__( 'Background', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item:hover .stratum-horizontal-timeline-item__card-inner' => 'background-color: {{VALUE}};',
								'{{WRAPPER}} .stratum-horizontal-timeline-item:hover .stratum-horizontal-timeline-item__card-arrow' => 'background-color: {{VALUE}};'
							]
						]
					);

					$controls->add_control(
						'cards_border_color_hover',
						[
							'label' => esc_html__( 'Border Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item:hover .stratum-horizontal-timeline-item__card' => 'border-color: {{VALUE}};',
								'{{WRAPPER}} .stratum-horizontal-timeline-item:hover .stratum-horizontal-timeline-item__card-arrow' => 'border-color: {{VALUE}};'
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
							'selector' => '{{WRAPPER}} .stratum-horizontal-timeline-item:hover .stratum-horizontal-timeline-item__card, {{WRAPPER}} .stratum-horizontal-timeline-item:hover .stratum-horizontal-timeline-item__card-arrow',
							'exclude'  => [
								'box_shadow_position'
							]
						]
					);

				$controls->end_controls_tab();

					$controls->start_controls_tab(
						'cards_active_styles',
						[
							'label' => esc_html__( 'Active', 'stratum' )
						]
					);

					$controls->add_control(
						'cards_background_active',
						[
							'label' => esc_html__( 'Background', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item.is-active .stratum-horizontal-timeline-item__card-inner' => 'background-color: {{VALUE}};',
								'{{WRAPPER}} .stratum-horizontal-timeline-item.is-active .stratum-horizontal-timeline-item__card-arrow' => 'background-color: {{VALUE}};'
							]
						]
					);

					$controls->add_control(
						'cards_border_color_active',
						[
							'label' => esc_html__( 'Border Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item.is-active .stratum-horizontal-timeline-item__card' => 'border-color: {{VALUE}};',
								'{{WRAPPER}} .stratum-horizontal-timeline-item.is-active .stratum-horizontal-timeline-item__card-arrow' => 'border-color: {{VALUE}};'
							],
							'condition' => [
								'cards_border_border!' => ''
							]
						]
					);

					$controls->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'cards_box_shadow_active',
							'selector' => '{{WRAPPER}} .stratum-horizontal-timeline-item.is-active .stratum-horizontal-timeline-item__card, {{WRAPPER}} .stratum-horizontal-timeline-item.is-active .stratum-horizontal-timeline-item__card-arrow',
							'exclude'  => [
								'box_shadow_position'
							]
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

			$controls->add_control(
				'cards_arrow_heading',
				[
					'label' => esc_html__( 'Arrow', 'stratum' ),
					'type'  => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'show_card_arrows' => 'yes'
					]
				]
			);

			$controls->add_responsive_control(
				'cards_arrow_width',
				[
					'label' => esc_html__( 'Size', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 50
						]
					],
					'selectors'  => [
						'{{WRAPPER}} .stratum-horizontal-timeline-item__card-arrow' => 'width:{{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
					],
					'condition' => [
						'show_card_arrows' => 'yes'
					]
				]
			);

			$controls->add_responsive_control(
				'cards_arrow_offset',
				[
					'label' => esc_html__( 'Offset', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100
						]
					],
					'selectors'  => [
						'{{WRAPPER}} .stratum-horizontal-timeline--align-left .stratum-horizontal-timeline-item__card-arrow' => 'left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .stratum-horizontal-timeline--align-right .stratum-horizontal-timeline-item__card-arrow' => 'right: {{SIZE}}{{UNIT}};'
					],
					'condition' => [
						'show_card_arrows' => 'yes',
						'horizontal_alignment!' => 'center'
					]
				]
			);

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_image_style',
			[
				'label' => esc_html__( 'Cards Content', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

			$controls->add_responsive_control(
				'cards_content_align',
				[
					'label' => esc_html__( 'Alignment', 'stratum' ),
					'type'  => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'stratum' ),
							'icon'  => 'fa fa-align-left'
						],
						'center' => [
							'title' => esc_html__( 'Center', 'stratum' ),
							'icon'  => 'fa fa-align-center'
						],
						'right' => [
							'title' => esc_html__( 'Right', 'stratum' ),
							'icon'  => 'fa fa-align-right'
						],
						'justify' => [
							'title' => esc_html__( 'Justified', 'stratum' ),
							'icon'  => 'fa fa-align-justify'
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-horizontal-timeline-item__card-inner' => 'text-align: {{VALUE}};'
					]
				]
			);

			$controls->add_control(
				'image_heading',
				[
					'label' => esc_html__( 'Image', 'stratum' ),
					'type'  => Controls_Manager::HEADING,
					'separator' => 'before'
				]
			);

			$controls->add_control(
				'image_margin',
				[
					'label' => esc_html__( 'Margin', 'stratum' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-horizontal-timeline-item__card-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
						'{{WRAPPER}} .stratum-horizontal-timeline-item__card-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

			$controls->add_control(
				'image_stretch',
				[
					'label' => esc_html__( 'Stretch Image', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'default' => '',
					'selectors'  => [
						'{{WRAPPER}} .stratum-horizontal-timeline-item__card-image img' => 'width: 100%;'
					]
				]
			);

			$controls->add_control(
				'title_heading',
				[
					'label' => esc_html__( 'Title', 'stratum' ),
					'type'  => Controls_Manager::HEADING,
					'separator' => 'before'
				]
			);

			$controls->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'card_title_typography',
					'selector' => '{{WRAPPER}} .stratum-horizontal-timeline-item__card-title'
				]
			);

			$controls->add_responsive_control(
				'card_title_margin',
				[
					'label' => esc_html__( 'Margin', 'stratum' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-horizontal-timeline-item__card-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

			$controls->start_controls_tabs( 'card_title_style_tabs' );

				$controls->start_controls_tab(
					'card_title_normal_styles',
					[
						'label' => esc_html__( 'Normal', 'stratum' )
					]
				);

					$controls->add_control(
						'card_title_normal_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item__card-title' => 'color: {{VALUE}};'
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'card_title_hover_styles',
					[
						'label' => esc_html__( 'Hover', 'stratum' )
					]
				);

					$controls->add_control(
						'card_title_hover_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item:hover .stratum-horizontal-timeline-item__card-title' => 'color: {{VALUE}};'
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'card_title_active_styles',
					[
						'label' => esc_html__( 'Active', 'stratum' )
					]
				);

					$controls->add_control(
						'card_title_active_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item.is-active .stratum-horizontal-timeline-item__card-title' => 'color: {{VALUE}};'
							]
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

			$controls->add_control(
				'desc_heading',
				[
					'label' => esc_html__( 'Description', 'stratum' ),
					'type'  => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$controls->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'card_desc_typography',
					'selector' => '{{WRAPPER}} .stratum-horizontal-timeline-item__card-description'
				]
			);

			$controls->add_responsive_control(
				'card_desc_margin',
				[
					'label' => esc_html__( 'Margin', 'stratum' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-horizontal-timeline-item__card-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

			$controls->start_controls_tabs( 'card_desc_style_tabs' );

				$controls->start_controls_tab(
					'card_desc_normal_styles',
					[
						'label' => esc_html__( 'Normal', 'stratum' )
					]
				);

					$controls->add_control(
						'card_desc_normal_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item__card-description'=> 'color: {{VALUE}};'
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'card_desc_hover_styles',
					[
						'label' => esc_html__( 'Hover', 'stratum' )
					]
				);

					$controls->add_control(
						'card_desc_hover_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item:hover .stratum-horizontal-timeline-item__card-description' => 'color: {{VALUE}};'
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'card_desc_active_styles',
					[
						'label' => esc_html__( 'Active', 'stratum' )
					]
				);

					$controls->add_control(
						'card_desc_active_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item.is-active .stratum-horizontal-timeline-item__card-description' => 'color: {{VALUE}};'
							]
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

			$controls->add_control(
				'orders_heading',
				[
					'label' => esc_html__( 'Orders', 'stratum' ),
					'type'  => Controls_Manager::HEADING,
					'separator' => 'before'
				]
			);

			$controls->add_control(
				'image_order',
				[
					'label' => esc_html__( 'Image Order', 'stratum' ),
					'type'  => Controls_Manager::NUMBER,
					'min'   => 0,
					'max'   => 10,
					'selectors' => [
						'{{WRAPPER}} .stratum-horizontal-timeline-item__card-image' => 'order: {{VALUE}};'
					]
				]
			);

			$controls->add_control(
				'title_order',
				[
					'label' => esc_html__( 'Title Order', 'stratum' ),
					'type'  => Controls_Manager::NUMBER,
					'min'   => 0,
					'max'   => 10,
					'selectors' => [
						'{{WRAPPER}} .stratum-horizontal-timeline-item__card-title' => 'order: {{VALUE}};'
					]
				]
			);

			$controls->add_control(
				'desc_order',
				[
					'label' => esc_html__( 'Description Order', 'stratum' ),
					'type'  => Controls_Manager::NUMBER,
					'min'   => 0,
					'max'   => 10,
					'selectors' => [
						'{{WRAPPER}} .stratum-horizontal-timeline-item__card-description' => 'order: {{VALUE}};'
					]
				]
			);

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_meta_style',
			[
				'label' => esc_html__( 'Meta', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

			$controls->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'meta_typography',
					'selector' => '{{WRAPPER}} .stratum-horizontal-timeline-item__meta'
				]
			);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'  => 'meta_border',
					'label' => esc_html__( 'Border', 'stratum' ),
					'placeholder' => '1px',
					'default'  => '1px',
					'selector' => '{{WRAPPER}} .stratum-horizontal-timeline-item__meta'
				]
			);

			$controls->add_control(
				'meta_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-horizontal-timeline-item__meta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;'
					]
				]
			);

			$controls->add_responsive_control(
				'meta_padding',
				[
					'label' => esc_html__( 'Padding', 'stratum' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-horizontal-timeline-item__meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					]
				]
			);

			$controls->add_responsive_control(
				'meta_spacing',
				[
					'label' => esc_html__( 'Spacing', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100
						]
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-horizontal-timeline__list--top .stratum-horizontal-timeline-item__meta' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .stratum-horizontal-timeline__list--bottom .stratum-horizontal-timeline-item__meta' => 'margin-top: {{SIZE}}{{UNIT}};'
					],
					'separator' => 'after'
				]
			);

			$controls->start_controls_tabs( 'meta_style_tabs' );

				$controls->start_controls_tab(
					'meta_normal_styles',
					[
						'label' => esc_html__( 'Normal', 'stratum' )
					]
				);

					$controls->add_control(
						'meta_normal_color',
						[
							'label'     => esc_html__( 'Color', 'stratum' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item__meta' => 'color: {{VALUE}};'
							]
						]
					);

					$controls->add_control(
						'meta_normal_background_color',
						[
							'label' => esc_html__( 'Background Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item__meta' => 'background-color: {{VALUE}};'
							]
						]
					);

					$controls->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'meta_normal_box_shadow',
							'selector' => '{{WRAPPER}} .stratum-horizontal-timeline-item__meta'
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'meta_hover_styles',
					[
						'label' => esc_html__( 'Hover', 'stratum' )
					]
				);

					$controls->add_control(
						'meta_hover_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item:hover .stratum-horizontal-timeline-item__meta' => 'color: {{VALUE}};'
							]
						]
					);

					$controls->add_control(
						'meta_hover_background_color',
						[
							'label' => esc_html__( 'Background Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item:hover .stratum-horizontal-timeline-item__meta' => 'background-color: {{VALUE}};'
							]
						]
					);

					$controls->add_control(
						'meta_hover_border_color',
						[
							'label'     => esc_html__( 'Border Color', 'stratum' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item:hover .stratum-horizontal-timeline-item__meta' => 'border-color: {{VALUE}};'
							],
							'condition' => [
								'meta_border_border!' => ''
							]
						]
					);

					$controls->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'meta_hover_box_shadow',
							'selector' => '{{WRAPPER}} .stratum-horizontal-timeline-item:hover .stratum-horizontal-timeline-item__meta'
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'meta_active_styles',
					[
						'label' => esc_html__( 'Active', 'stratum' )
					]
				);

					$controls->add_control(
						'meta_active_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item.is-active .stratum-horizontal-timeline-item__meta' => 'color: {{VALUE}};'
							]
						]
					);

					$controls->add_control(
						'meta_active_background_color',
						[
							'label' => esc_html__( 'Background Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item.is-active .stratum-horizontal-timeline-item__meta' => 'background-color: {{VALUE}};'
							]
						]
					);

					$controls->add_control(
						'meta_active_border_color',
						[
							'label'     => esc_html__( 'Border Color', 'stratum' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item.is-active .stratum-horizontal-timeline-item__meta' => 'border-color: {{VALUE}};'
							],
							'condition' => [
								'meta_border_border!' => ''
							]
						]
					);

					$controls->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'meta_active_box_shadow',
							'selector' => '{{WRAPPER}} .stratum-horizontal-timeline-item.is-active .stratum-horizontal-timeline-item__meta'
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_point_style',
			[
				'label' => esc_html__( 'Point', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

			$controls->start_controls_tabs( 'point_type_style_tabs' );

				$controls->start_controls_tab(
					'point_type_text_styles',
					[
						'label' => esc_html__( 'Text', 'stratum' )
					]
				);

					$controls->add_group_control(
						Group_Control_Typography::get_type(),
						[
							'name'     => 'point_text_typography',
							'selector' => '{{WRAPPER}} .stratum-horizontal-timeline-item__point-content'
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'point_type_icon_styles',
					[
						'label' => esc_html__( 'Icon', 'stratum' )
					]
				);

					$controls->add_responsive_control(
						'point_type_icon_size',
						[
							'label' => esc_html__( 'Icon Size', 'stratum' ),
							'type'  => Controls_Manager::SLIDER,
							'size_units' => [ 'px', 'em', 'rem' ],
							'range' => [
								'px' => [
									'min' => 1,
									'max' => 100,
								]
							],
							'selectors'  => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item__point-content--icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
								'{{WRAPPER}} .stratum-horizontal-timeline-item__point-content--icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
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
					'selectors'  => [
						'{{WRAPPER}} .stratum-horizontal-timeline-item__point-content' => 'width: {{SIZE}}{{UNIT}}; height:{{SIZE}}{{UNIT}};'
					],
					'separator' => 'before',
					'render_type' => 'template'
				]
			);

			$controls->add_responsive_control(
				'point_offset',
				[
					'label' => esc_html__( 'Offset', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100
						]
					],
					'selectors'  => [
						'{{WRAPPER}} .stratum-horizontal-timeline--align-left .stratum-horizontal-timeline-item__point-content' => 'margin-left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .stratum-horizontal-timeline--align-right .stratum-horizontal-timeline-item__point-content' => 'margin-right: {{SIZE}}{{UNIT}};'
					],
					'condition' => [
						'horizontal_alignment!' => 'center'
					],
					'render_type' => 'template'
				]
			);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'  => 'point_border',
					'label' => esc_html__( 'Border', 'stratum' ),
					'placeholder' => '1px',
					'default'     => '1px',
					'selector'    => '{{WRAPPER}} .stratum-horizontal-timeline-item__point-content'
				]
			);

			$controls->add_control(
				'point_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'stratum' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-horizontal-timeline-item__point-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
					],
					'separator' => 'after'
				]
			);

			$controls->start_controls_tabs( 'point_style_tabs' );

				$controls->start_controls_tab(
					'point_normal_styles',
					[
						'label' => esc_html__( 'Normal', 'stratum' )
					]
				);

					$controls->add_control(
						'point_normal_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item__point-content' => 'color: {{VALUE}};'
							]
						]
					);

					$controls->add_control(
						'point_normal_background_color',
						[
							'label' => esc_html__( 'Background Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item__point-content' => 'background-color: {{VALUE}};'
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'point_hover_styles',
					[
						'label' => esc_html__( 'Hover', 'stratum' )
					]
				);

					$controls->add_control(
						'point_hover_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item:hover .stratum-horizontal-timeline-item__point-content'=> 'color: {{VALUE}};'
							]
						]
					);

					$controls->add_control(
						'point_hover_background_color',
						[
							'label' => esc_html__( 'Background Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item:hover .stratum-horizontal-timeline-item__point-content' => 'background-color: {{VALUE}};'
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'point_active_styles',
					[
						'label' => esc_html__( 'Active', 'stratum' )
					]
				);

					$controls->add_control(
						'point_active_color',
						[
							'label' => esc_html__( 'Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item.is-active .stratum-horizontal-timeline-item__point-content' => 'color: {{VALUE}};'
							]
						]
					);

					$controls->add_control(
						'point_active_background_color',
						[
							'label' => esc_html__( 'Background Color', 'stratum' ),
							'type'  => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .stratum-horizontal-timeline-item.is-active .stratum-horizontal-timeline-item__point-content' => 'background-color: {{VALUE}};'
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
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

			$controls->add_control(
				'line_background_color',
				[
					'label' => esc_html__( 'Line Color', 'stratum' ),
					'type'  => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .stratum-horizontal-timeline__line' => 'background-color: {{VALUE}};'
					]
				]
			);

			$controls->add_responsive_control(
				'line_height',
				[
					'label' => esc_html__( 'Height', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 1,
							'max' => 15
						]
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-horizontal-timeline__line' => 'height: {{SIZE}}{{UNIT}};'
					]
				]
			);

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_scrollbar_style',
			[
				'label' => esc_html__( 'Scrollbar', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

			$controls->add_control(
				'non_webkit_notice',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw'  => esc_html__( 'Currently works only in -webkit- browsers', 'stratum' ),
					'content_classes' => 'elementor-descriptor'
				]
			);

			$controls->add_control(
				'scrollbar_bg',
				[
					'label' => esc_html__( 'Scrollbar Color', 'stratum' ),
					'type'  => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .stratum-horizontal-timeline__track::-webkit-scrollbar' => 'background-color: {{VALUE}};'
					]
				]
			);

			$controls->add_control(
				'scrollbar_thumb_bg',
				[
					'label' => esc_html__( 'Scrollbar Thumb Color', 'stratum' ),
					'type'  => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .stratum-horizontal-timeline__track::-webkit-scrollbar-thumb' => 'background-color: {{VALUE}};'
					]
				]
			);

			$controls->add_control(
				'scrollbar_height',
				[
					'label' => esc_html__( 'Scrollbar Height', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 1,
							'max' => 20
						]
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-horizontal-timeline__track::-webkit-scrollbar' => 'height: {{SIZE}}{{UNIT}};'
					]
				]
			);

			$controls->add_control(
				'scrollbar_offset',
				[
					'label' => esc_html__( 'Scrollbar Offset', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100
						]
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-horizontal-timeline__track' => 'padding-bottom: {{SIZE}}{{UNIT}};'
					]
				]
			);

			$controls->add_control(
				'scrollbar_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-horizontal-timeline__track::-webkit-scrollbar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .stratum-horizontal-timeline__track::-webkit-scrollbar-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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

		$url    	= wp_get_attachment_image_url( $id, $image_size );
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

	public function _generate_card_content($class, $item, $settings, $title_html_tag, $index) {
		$out = "";

		$out .= "<div class='".esc_attr( $class.'-item__card' )."'>";
			$out .= "<div class='".esc_attr( $class.'-item__card-inner' )."'>";

				if ( !empty( $item[ 'show_item_image' ] ) ) {
					$out .= $this->_get_timeline_image( $class, $item );
				}

				if ( ! empty( $item[ 'item_link' ][ 'url' ] ) ) {
					$this->add_link_attributes( 'url' . $index, $item[ 'item_link' ] );
					$out .= "<a class='".esc_attr( $class.'-item__card-link' )."' " . $this->get_render_attribute_string( 'url' . $index ) . ">";
				}

					$out .= "<{$title_html_tag} class='".esc_attr( $class.'-item__card-title' )."'>".esc_html( $item[ 'item_title' ] )."</{$title_html_tag}>";

				if ( ! empty( $item[ 'item_link' ][ 'url' ] ) ) {
					$out .= "</a>";
				}

				if ( $item[ 'item_description_type' ] === 'default' ) {
					$out .= "<div class='".esc_attr( $class.'-item__card-description' )."'>".esc_html( $item[ 'item_description' ] )."</div>";
				} else {
					$out .= "<div class='".esc_attr( $class.'-item__card-description' )."'>". $item[ 'item_description_editor' ] ."</div>";
				}

			$out .= "</div>";

			if ( !empty( $settings[ 'show_card_arrows' ] ) ) {
				$out .= "<div class='".esc_attr( $class.'-item__card-arrow' )."'></div>";
			}
		$out .= "</div>";

		return $out;
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Horizontal_Timeline() );