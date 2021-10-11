<?php

/**
 * Class: Table
 * Name: Table
 * Slug: table
 */

namespace Stratum;

use Elementor\Core\Base\Document;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Controls_Manager;
use \Elementor\Utils;
use \Elementor\Plugin;
use \Elementor\Repeater;

use Stratum\Managers\Ajax_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Table extends Stratum_Widget_Base {
	protected $widget_name = 'table';

    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
    }

	public function get_title() {
		return esc_html__( 'Table', 'stratum' );
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
		return [ 'table', 'columns' ];
	}

	public function get_icon() {
		return 'eicon-table';
	}

	public function get_categories() {
		return [ 'stratum-widgets' ];
    }

    protected function _register_controls() {
		$controls = $this;

		$document_types = Plugin::instance()->documents->get_document_types( [
			'show_in_library' => true,
		] );

        /*-----------------------------------------------------------------------------------*/
        /*	Head Table
        /*-----------------------------------------------------------------------------------*/
		$controls->start_controls_section(
			'section_table_heading',
			[
				'label' => esc_html__( 'Heading', 'stratum' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

			$repeater = new Repeater();

			$repeater->add_control(
				'table_colspan_head',
				[
					'label' 	  => esc_html__( 'Column Span', 'stratum' ),
					'type'  	  => Controls_Manager::NUMBER,
					'description' => esc_html__( 'Sets the number of cells to be merged horizontally.', 'stratum' ),
				]
			);

			$repeater->start_controls_tabs( 'table_repeater' );

				$repeater->start_controls_tab( 'table_content', [ 'label' => __( 'Content', 'stratum' ) ] );

					$repeater->add_control(
						'table_content_alignment',
						[
							'label'       	   => __( 'Alignment', 'stratum' ),
							'type' 	      	   => Controls_Manager::CHOOSE,
							'label_block' 	   => false,
							'options'	  	   => [
								'left'	  	   => [
									'title'	   => esc_html__( 'Left', 'stratum' ),
									'icon'	   => 'eicon-text-align-left'
								],
								'center'	   => [
									'title'	   => esc_html__( 'Center', 'stratum' ),
									'icon'	   => 'eicon-text-align-center'
								],
								'right'	  	   => [
									'title'	   => esc_html__( 'Right', 'stratum' ),
									'icon'	   => 'eicon-text-align-right'
								],
							],
						]
					);

					$repeater->add_control(
						'table_head_title',
						[
							'label'       => __( 'Title', 'stratum' ),
							'type' 	      => Controls_Manager::TEXT,
							'default'	  => __( 'Table', 'stratum' ),
							'label_block' => true,
						]
					);

					$repeater->add_control(
						'table_head_icon_type',
						[
							'label'       => __( 'Icon Type', 'stratum' ),
							'type' 	      => Controls_Manager::CHOOSE,
							'toggle'      => false,
							'default'	  => 'none',
							'label_block' => false,
							'options'	  => [
								'none'	  => [
									'title'	  => esc_html__( 'None', 'stratum' ),
									'icon'	  => 'eicon-ban'
								],
								'icon'	  => [
									'title'	  => esc_html__( 'Icon', 'stratum' ),
									'icon'	  => 'eicon-star-o'
								],
								'image'	  => [
									'title'	  => esc_html__( 'Image', 'stratum' ),
									'icon'	  => 'eicon-image'
								],
							]
						]
					);

					$repeater->add_control(
						'table_head_icons',
						[
							'label'       	   => __( 'Icon', 'stratum' ),
							'type' 	      	   => Controls_Manager::ICONS,
							'fa4compatibility' => 'table_head_icon',
							'default'	  	   => [
								'value'	  => '',
							],
							'condition'	  	   => [
								'table_head_icon_type' => 'icon'
							],
						]
					);

					$repeater->add_control(
						'table_head_image',
						[
							'label'       	   => __( 'Image', 'stratum' ),
							'type' 	      	   => Controls_Manager::MEDIA,
							'default'	  	   => [
								'url'	  	=> Utils::get_placeholder_image_src(),
							],
							'condition'	  	   => [
								'table_head_icon_type' => 'image',
							],
						]
					);

					$repeater->add_control(
						'table_head_image_size',
						[
							'label'     => __( 'Image Size', 'stratum' ),
							'type'      => Controls_Manager::NUMBER,
							'default'   => 25,
							'required'  => true,
							'condition'	  	=> [
								'table_head_icon_type' => 'image',
							],
						]
					);

					$repeater->add_control(
						'table_head_pos',
						[
							'label'       	   => __( 'Position', 'stratum' ),
							'type' 	      	   => Controls_Manager::CHOOSE,
							'toggle'      	   => false,
							'default'	  	   => 'left',
							'label_block' 	   => false,
							'options'	  	   => [
								'left'	  	   => [
									'title'	   => esc_html__( 'Left', 'stratum' ),
									'icon'	   => 'eicon-h-align-left'
								],
								'right'	  	   => [
									'title'	   => esc_html__( 'Right', 'stratum' ),
									'icon'	   => 'eicon-h-align-right'
								],
								'top'	  	   => [
									'title'	   => esc_html__( 'Top', 'stratum' ),
									'icon'	   => 'eicon-v-align-top'
								],
								'bottom'	   => [
									'title'	   => esc_html__( 'Bottom', 'stratum' ),
									'icon'	   => 'eicon-v-align-bottom'
								],
							],
							'condition'	  	   => [
								'table_head_icon_type' => [ 'icon', 'image' ],
								'table_head_title!'    => '',
							],
						]
					);

					$repeater->add_control(
						'table_head_icon_margin',
						[
							'label'	     => __( 'Margin', 'stratum' ),
							'type'	     => Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', 'em', '%', 'rem' ],
							'condition'	 => [
								'table_head_icon_type' => [ 'icon', 'image' ],
							],
						]
					);

				$repeater->end_controls_tab();

				$repeater->start_controls_tab( 'table_style_normal', [ 'label' => __( 'Style', 'stratum' ) ] );

					$repeater->add_control(
						'table_head_unique_icon_color',
						[
							'label'       	   => __( 'Icon Color', 'stratum' ),
							'type' 	      	   => Controls_Manager::COLOR,
							'condition'	  	   => [
								'table_head_icon_type' => 'icon',
							],
						]
					);

					$repeater->add_control(
						'table_head_unique_text_color',
						[
							'label'     => __( 'Text Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
						]
					);

					$repeater->add_control(
						'table_head_unique_bgcolor',
						[
							'label'     => __( 'Background Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
						]
					);

				$repeater->end_controls_tab();

			$repeater->end_controls_tabs();

			$controls->add_control(
				'table_head_items',
				[
					'label' 	   => null,
					'type'         => Controls_Manager::REPEATER,
					'title_field'  => '{{{ table_head_title }}}',
					'show_label'   => true,
					'fields'       => $repeater->get_controls(),
					'default'      => [
						[ 'table_head_title'   => __( 'Heading', 'stratum' ) ],
						[ 'table_head_title'   => __( 'Heading', 'stratum' ) ],
						[ 'table_head_title'   => __( 'Heading', 'stratum' ) ],
						[ 'table_head_title'   => __( 'Heading', 'stratum' ) ],
					]
				]
			);

		$controls->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*	Body Table
		/*-----------------------------------------------------------------------------------*/
		$controls->start_controls_section(
			'section_table_body',
			[
				'label' => esc_html__( 'Body', 'stratum' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

			$repeater = new Repeater();

			$repeater->add_control(
				'table_col_select',
				[
					'label'        => __( 'Row Type', 'stratum' ),
					'type' 	       => Controls_Manager::SELECT,
					'default'	   => 'Col',
					'label_block'  => false,
					'options'	   => [
						'Row'	=> __( 'New Row', 'stratum' ),
						'Col'	=> __( 'New Column', 'stratum' ),
					]
				]
			);

			$repeater->add_control(
				'table_colspan_body',
				[
					'label' 	  => esc_html__( 'Column Span', 'stratum' ),
					'type'  	  => Controls_Manager::NUMBER,
					'description' => esc_html__( 'Sets the number of cells to be merged horizontally.', 'stratum' ),
					'condition'	  => [
						'table_col_select!'   => 'Row',
					],
				]
			);

			$repeater->start_controls_tabs( 'table_body_repeater' );

				$repeater->start_controls_tab(
					'table_body_content',
					[
						'label' 	=> __( 'Content', 'stratum' ),
						'condition' => [
							'table_col_select!' => 'Row',
						]
					]
				);

					$repeater->add_control(
						'table_col_content_type',
						[
							'label'       	   => __( 'Content Type', 'stratum' ),
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
								],
								'template'	  	   => [
									'title'	   => esc_html__( 'Template', 'stratum' ),
									'icon'	   => 'eicon-post-content'
								],
							],
							'condition'	  	   => [
								'table_col_select!'   => 'Row',
							],
						]
					);

					$repeater->add_control(
						'table_col_content_alignment',
						[
							'label'       	   => __( 'Alignment', 'stratum' ),
							'type' 	      	   => Controls_Manager::CHOOSE,
							'label_block' 	   => false,
							'options'	  	   => [
								'left'	  	   => [
									'title'	   => esc_html__( 'Left', 'stratum' ),
									'icon'	   => 'eicon-text-align-left'
								],
								'center'	   => [
									'title'	   => esc_html__( 'Center', 'stratum' ),
									'icon'	   => 'eicon-text-align-center'
								],
								'right'	  	   => [
									'title'	   => esc_html__( 'Right', 'stratum' ),
									'icon'	   => 'eicon-text-align-right'
								],
							],
							'condition'	  => [
								'table_col_select!' 	 => 'Row',
								'table_col_content_type' => 'default'
							],
						]
					);

					$repeater->add_control(
						'table_col_title',
						[
							'label'       => __( 'Title', 'stratum' ),
							'type' 	      => Controls_Manager::TEXT,
							'default'	  => __( 'Content', 'stratum' ),
							'label_block' => true,
							'condition'	  => [
								'table_col_select!' 	 => 'Row',
								'table_col_content_type' => 'default'
							],
						]
					);

					$repeater->add_control(
						'table_col_editor',
						[
							'label'       => __( 'Column Editor', 'stratum' ),
							'type' 	      => Controls_Manager::WYSIWYG,
							'default'	  => __( 'Content', 'stratum' ),
							'label_block' => true,
							'condition'	  => [
								'table_col_select!' 	 => 'Row',
								'table_col_content_type' => 'editor'
							],
						]
					);

					$repeater->add_control(
						'table_col_template',
						[
							'label' 	   => __( 'Template', 'stratum' ),
							'type' 		   => Stratum_AJAX_Control::QUERY,
							'label_block'  => true,
							'multiple'     => false,
							'ajax_route'   => 'stratum_get_elementor_templates',
							'autocomplete' => [
								'object'   => 'library_template',
								'query'     => [
									'meta_query' => [
										[
											'key'     => Document::TYPE_META_KEY,
											'value'   => array_keys( $document_types ),
											'compare' => 'IN',
										],
									],
								],
							],
							'options'     => Ajax_Manager::stratum_get_elementor_templates(),
							'condition'	  => [
								'table_col_select!' 	 => 'Row',
								'table_col_content_type' => 'template'
							],
							'description' => esc_html__( 'Here you can see sections you saved as templates.', 'stratum' ),
						]
					);

					$repeater->add_control(
						'table_col_icon_type',
						[
							'label'       => __( 'Icon Type', 'stratum' ),
							'type' 	      => Controls_Manager::CHOOSE,
							'toggle'      => false,
							'default'	  => 'none',
							'label_block' => false,
							'options'	  => [
								'none'	  => [
									'title'	  => esc_html__( 'None', 'stratum' ),
									'icon'	  => 'eicon-ban'
								],
								'icon'	  => [
									'title'	  => esc_html__( 'Icon', 'stratum' ),
									'icon'	  => 'eicon-star-o'
								],
								'image'	  => [
									'title'	  => esc_html__( 'Image', 'stratum' ),
									'icon'	  => 'eicon-image'
								],
							],
							'condition'	  => [
								'table_col_content_type' => 'default',
								'table_col_select!' 	 => 'Row'
							],
						]
					);

					$repeater->add_control(
						'table_col_icons',
						[
							'label'       	   => __( 'Icon', 'stratum' ),
							'type' 	      	   => Controls_Manager::ICONS,
							'fa4compatibility' => 'table_col_icon',
							'default'	  	   => [
								'value'	  => '',
							],
							'condition'	  	   => [
								'table_col_select!'      => 'Row',
								'table_col_content_type' => 'default',
								'table_col_icon_type'    => 'icon'
							],
						]
					);

					$repeater->add_control(
						'table_col_image',
						[
							'label'       	   => __( 'Image', 'stratum' ),
							'type' 	      	   => Controls_Manager::MEDIA,
							'default'	  	   => [
								'url'	  	   => Utils::get_placeholder_image_src(),
							],
							'condition'	  	   => [
								'table_col_icon_type' => 'image',
							],
						]
					);

					$repeater->add_control(
						'table_col_image_size',
						[
							'label'     => __( 'Image Size', 'stratum' ),
							'type'      => Controls_Manager::NUMBER,
							'default'   => 25,
							'required'  => true,
							'condition'	  	=> [
								'table_col_icon_type' => 'image',
							],
						]
					);

					$repeater->add_control(
						'table_col_pos',
						[
							'label'       	   => __( 'Position', 'stratum' ),
							'type' 	      	   => Controls_Manager::CHOOSE,
							'toggle'      	   => false,
							'default'	  	   => 'left',
							'label_block' 	   => false,
							'options'	  	   => [
								'left'	  	   => [
									'title'	   => esc_html__( 'Left', 'stratum' ),
									'icon'	   => 'eicon-h-align-left'
								],
								'right'	  	   => [
									'title'	   => esc_html__( 'Right', 'stratum' ),
									'icon'	   => 'eicon-h-align-right'
								],
								'top'	  	   => [
									'title'	   => esc_html__( 'Top', 'stratum' ),
									'icon'	   => 'eicon-v-align-top'
								],
								'bottom'	   => [
									'title'	   => esc_html__( 'Bottom', 'stratum' ),
									'icon'	   => 'eicon-v-align-bottom'
								],
							],
							'condition'	  	   => [
								'table_col_select!'      => 'Row',
								'table_col_title!'		 => '',
								'table_col_content_type' => 'default',
								'table_col_icon_type'    => [ 'icon', 'image' ]
							],
						]
					);

					$repeater->add_control(
						'table_col_margin',
						[
							'label'	     => __( 'Margin', 'stratum' ),
							'type'	     => Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', 'em', '%', 'rem' ],
							'condition'	 => [
								'table_col_select!'      => 'Row',
								'table_col_content_type' => 'default',
								'table_col_icon_type'    => [ 'icon', 'image' ]
							],
						]
					);

				$repeater->end_controls_tab();

				$repeater->start_controls_tab(
					'table_body_style_normal',
					[
						'label' 	=> __( 'Style', 'stratum' ),
						'condition' => [
							'table_col_select!'  => 'Row',
						],
					]
				);

					$repeater->add_control(
						'table_body_unique_icon_color',
						[
							'label'       	   => __( 'Icon Color', 'stratum' ),
							'type' 	      	   => Controls_Manager::COLOR,
							'condition'	  	   => [
								'table_col_content_type' => 'default',
								'table_col_icon_type' 	 => 'icon',
							],
						]
					);

					$repeater->add_control(
						'table_body_unique_text_color',
						[
							'label'     => __( 'Text Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
							'condition'	=> [
								'table_col_content_type' => 'default'
							]
						]
					);

					$repeater->add_control(
						'table_body_unique_bgcolor',
						[
							'label'     => __( 'Background Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
						]
					);

				$repeater->end_controls_tab();

			$repeater->end_controls_tabs();

			$controls->add_control(
				'table_body_items',
				[
					'label' 	   => null,
					'type'         => Controls_Manager::REPEATER,
					'title_field'  => '{{{ table_col_select }}}::{{{ table_col_title }}}',
					'show_label'   => true,
					'fields'       => $repeater->get_controls(),
					'default'      => [
						[ 'table_col_select' => 'Row' ],
						[ 'table_col_select' => 'Col' ],
						[ 'table_col_select' => 'Col' ],
						[ 'table_col_select' => 'Col' ],
						[ 'table_col_select' => 'Col' ],
						[ 'table_col_select' => 'Row' ],
						[ 'table_col_select' => 'Col' ],
						[ 'table_col_select' => 'Col' ],
						[ 'table_col_select' => 'Col' ],
						[ 'table_col_select' => 'Col' ],
					]
				]
			);

		$controls->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*	General Styles
		/*-----------------------------------------------------------------------------------*/
		$controls->start_controls_section(
			'section_general_style',
			[
				'label' => esc_html__( 'General Style', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$controls->add_control(
				'table_layout',
				[
					'label'      => esc_html__( 'Table Layout', 'stratum' ),
					'type'       => Controls_Manager::SELECT,
					'options'    => [
						'auto'   => esc_html__( 'Auto', 'stratum' ),
						'fixed'  => esc_html__( 'Fixed', 'stratum' ),
					],
					'default' 	 => 'auto',
					'selectors'  => [
						'{{WRAPPER}} .stratum-table__table' => 'table-layout: {{VALUE}};',
					],
				]
			);

			$controls->add_responsive_control(
				'table_width',
				[
					'label' => esc_html__( 'Width', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'range' => [
						'%' => [
							'min' => 10,
							'max' => 100,
						],
						'px' => [
							'min' => 10,
							'max' => 1200,
						],
					],
					'default' => [
						'size' => 100,
						'unit' => '%',
					],
					'tablet_default' => [
						'size' => 100,
						'unit' => '%',
					],
					'mobile_default' => [
						'size' => 100,
						'unit' => '%',
					],
					'size_units' => [ '%', 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-table__table' => 'max-width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$controls->add_control(
				'table_alignment',
				[
					'label'       	   => __( 'Alignment', 'stratum' ),
					'type' 	      	   => Controls_Manager::CHOOSE,
					'toggle'      	   => false,
					'default'	  	   => 'center',
					'label_block' 	   => false,
					'options'	  	   => [
						'left'	  	   => [
							'title'	   => esc_html__( 'Left', 'stratum' ),
							'icon'	   => 'eicon-h-align-left'
						],
						'center'	   => [
							'title'	   => esc_html__( 'Center', 'stratum' ),
							'icon'	   => 'eicon-h-align-center'
						],
						'right'	  	   => [
							'title'	   => esc_html__( 'Right', 'stratum' ),
							'icon'	   => 'eicon-h-align-right'
						],
					],
					'selectors_dictionary' => [
						'left'   => 'margin-right: auto;',
						'center' => 'margin-left: auto; margin-right: auto;',
						'right'  => 'margin-left: auto;',
					],
					'selectors'            => [
						'{{WRAPPER}} .stratum-table__table'  => '{{VALUE}}',
					],
				]
			);

			$controls->add_control(
				'general_border_style',
				[
					'label'    => esc_html__( 'Border Style', 'stratum' ),
					'type'     => Controls_Manager::SELECT,
					'options'  => [
						'' 		 => esc_html__( 'None', 'stratum' ),
						'solid'  => esc_html__( 'Solid', 'stratum' ),
						'double' => esc_html__( 'Double', 'stratum' ),
						'dotted' => esc_html__( 'Dotted', 'stratum' ),
						'dashed' => esc_html__( 'Dashed', 'stratum' ),
						'groove' => esc_html__( 'Groove', 'stratum' ),
					],
					'default' 	=> 'solid',
					'selectors' => [
						'{{WRAPPER}} thead th' => 'border-style: {{VALUE}};',
						'{{WRAPPER}} tbody td' => 'border-style: {{VALUE}};',
					],
				]
			);

			$controls->add_responsive_control(
				'general_border_width',
				[
					'label'  => esc_html__( 'Border Width', 'stratum' ),
					'type'   => Controls_Manager::SLIDER,
					'range'  => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'size' => 1,
						'unit' => 'px',
					],
					'selectors'   => [
						'{{WRAPPER}} thead th' => 'border-top-width: {{SIZE}}{{UNIT}}; border-bottom-width: {{SIZE}}{{UNIT}}; border-right-width: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} thead th:first-child' => 'border-left-width: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} tbody td' => 'border-bottom-width: {{SIZE}}{{UNIT}}; border-right-width: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} tbody td:first-child' => 'border-left-width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'general_border_style!' => '',
					],
				]
			);

			$controls->add_control(
				'general_border_color',
				[
					'label'     => __( 'Border Color', 'stratum' ),
					'type' 	    => Controls_Manager::COLOR,
					'default'   => '#000000',
					'value'     => '',
					'selectors' => [
						'{{WRAPPER}} thead th' => 'border-color: {{VALUE}}',
						'{{WRAPPER}} tbody td' => 'border-color: {{VALUE}}',
					],
					'condition' => [
						'general_border_style!' => ''
					],
				]
			);

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_table_head_style',
			[
				'label' => esc_html__( 'Heading', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$controls->add_responsive_control(
				'table_head_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'size' => 12,
						'unit' => 'px',
					],
					'size_units' => [ 'px' ],
					'selectors'  => [
						'{{WRAPPER}} thead th:first-child' => 'border-top-left-radius: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} thead th:last-child' => 'border-top-right-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'table_head_height',
				[
					'label' => esc_html__( 'Column Height', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 800,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'size' => 50,
						'unit' => 'px',
					],
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} thead th' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'table_head_padding',
				[
					'label'	     => __( 'Padding', 'stratum' ),
					'type'	     => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} thead th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_control(
				'table_head_alignment_horizontal',
				[
					'label'       => __( 'Horizontal Alignment', 'stratum' ),
					'type' 	      => Controls_Manager::CHOOSE,
					'toggle'      => false,
					'default'	  => 'center',
					'label_block' => false,
					'options'	  => [
						'left'	  => [
							'title'	  => esc_html__( 'Left', 'stratum' ),
							'icon'	  => 'eicon-text-align-left'
						],
						'center'	  => [
							'title'	  => esc_html__( 'Center', 'stratum' ),
							'icon'	  => 'eicon-text-align-center'
						],
						'right'	  => [
							'title'	  => esc_html__( 'Right', 'stratum' ),
							'icon'	  => 'eicon-text-align-right'
						],
					]
				]
			);

			$controls->add_control(
				'table_head_alignment_vertical',
				[
					'label'       => __( 'Vertical Alignment', 'stratum' ),
					'type' 	      => Controls_Manager::CHOOSE,
					'toggle'      => false,
					'default'	  => 'middle',
					'label_block' => false,
					'options'	  => [
						'top'	  => [
							'title'	  => esc_html__( 'Top', 'stratum' ),
							'icon'	  => 'eicon-v-align-top'
						],
						'middle'	  => [
							'title'	  => esc_html__( 'Center', 'stratum' ),
							'icon'	  => 'eicon-v-align-middle'
						],
						'bottom'	  => [
							'title'	  => esc_html__( 'Bottom', 'stratum' ),
							'icon'	  => 'eicon-v-align-bottom'
						],
					],
					'selectors'  => [
						'{{WRAPPER}} thead th' => 'vertical-align: {{VALUE}};',
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'        => 'table_header_typography',
					'selector'    => '{{WRAPPER}} th .stratum-table__cell-title',
					'label'	      => esc_html__( 'Typography', 'stratum' ),
				]
			);

			$controls->add_responsive_control(
				'table_header_icon_size',
				[
					'label'     => __( 'Icon Size', 'stratum' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 16,
					'min'       => 1,
					'max'       => 1000,
					'required'  => true,
					'selectors' => [
						'{{WRAPPER}} th .stratum-table__cell-icon > i' => 'font-size: {{VALUE}}px',
						'{{WRAPPER}} th .stratum-table__cell-icon > svg' => 'width: {{VALUE}}px; height: {{VALUE}}px;',
					],
				]
			);

			$controls->start_controls_tabs( 'table_head_styles' );

				$controls->start_controls_tab(
					'table_head_state_normal',
					[
						'label' => esc_html__( 'Normal', 'stratum' ),
					]
				);

					$controls->add_control(
						'table_title_color',
						[
							'label'     => __( 'Text Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
							'selectors' => [
								'{{WRAPPER}} th .stratum-table__cell-title' => 'color: {{VALUE}}',
							]
						]
					);

					$controls->add_control(
						'table_head_bgcolor',
						[
							'label'     => __( 'Background Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
							'selectors' => [
								'{{WRAPPER}} th' => 'background-color: {{VALUE}}',
							]
						]
					);

					$controls->add_control(
						'table_header_icon_color',
						[
							'label'     => __( 'Icon Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
							'selectors' => [
								'{{WRAPPER}} th .stratum-table__cell-icon' => 'color: {{VALUE}}',
							],
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'table_head_state_hover',
					[
						'label' => esc_html__( 'Hover', 'stratum' ),
					]
				);

					$controls->add_control(
						'table_title_color_hover',
						[
							'label'     => __( 'Text Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
							'selectors' => [
								'{{WRAPPER}} th:hover .stratum-table__cell-title' => 'color: {{VALUE}}!important',
							]
						]
					);

					$controls->add_control(
						'table_head_bgcolor_hover',
						[
							'label'     => __( 'Background Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
							'selectors' => [
								'{{WRAPPER}} th:hover' => 'background-color: {{VALUE}}!important',
							]
						]
					);

					$controls->add_control(
						'table_icon_color_hover',
						[
							'label'     => __( 'Icon Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
							'selectors' => [
								'{{WRAPPER}} th:hover .stratum-table__cell-icon' => 'color: {{VALUE}}!important',
							],
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_table_body_style',
			[
				'label' => esc_html__( 'Body', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$controls->add_responsive_control(
				'table_body_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'size' => 12,
						'unit' => 'px',
					],
					'size_units' => [ 'px' ],
					'selectors'  => [
						'{{WRAPPER}} tbody tr:last-child > td:first-child' => 'border-bottom-left-radius: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} tbody tr:last-child > td:last-child' => 'border-bottom-right-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'table_body_height',
				[
					'label' => esc_html__( 'Column Height', 'stratum' ),
					'type'  => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 800,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'size' => 50,
						'unit' => 'px',
					],
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} tbody td' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'table_body_padding',
				[
					'label'	     => __( 'Padding', 'stratum' ),
					'type'	     => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} tbody td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_control(
				'table_body_alignment_horizontal',
				[
					'label'       => __( 'Horizontal Alignment', 'stratum' ),
					'type' 	      => Controls_Manager::CHOOSE,
					'toggle'      => false,
					'default'	  => 'center',
					'label_block' => false,
					'options'	  => [
						'left'  => [
							'title'	  => esc_html__( 'Left', 'stratum' ),
							'icon'	  => 'eicon-text-align-left'
						],
						'center'	  => [
							'title'	  => esc_html__( 'Center', 'stratum' ),
							'icon'	  => 'eicon-text-align-center'
						],
						'right'	  => [
							'title'	  => esc_html__( 'Right', 'stratum' ),
							'icon'	  => 'eicon-text-align-right'
						],
					],
				]
			);

			$controls->add_control(
				'table_body_alignment_vertical',
				[
					'label'       => __( 'Vertical Alignment', 'stratum' ),
					'type' 	      => Controls_Manager::CHOOSE,
					'toggle'      => false,
					'default'	  => 'inherit',
					'label_block' => false,
					'options'	  => [
						'top'	  => [
							'title'	  => esc_html__( 'Top', 'stratum' ),
							'icon'	  => 'eicon-v-align-top'
						],
						'middle'	  => [
							'title'	  => esc_html__( 'Center', 'stratum' ),
							'icon'	  => 'eicon-v-align-middle'
						],
						'bottom'	  => [
							'title'	  => esc_html__( 'Bottom', 'stratum' ),
							'icon'	  => 'eicon-v-align-bottom'
						],
					],
					'selectors'  => [
						'{{WRAPPER}} tbody td' => 'vertical-align: {{VALUE}};',
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'        => 'table_body_typography',
					'selector'    => '{{WRAPPER}} td .stratum-table__cell-title',
					'label'	      => esc_html__( 'Typography', 'stratum' ),
				]
			);

			$controls->add_responsive_control(
				'table_body_icon_size',
				[
					'label'     => __( 'Icon Size', 'stratum' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 16,
					'min'       => 1,
					'max'       => 1000,
					'required'  => true,
					'selectors' => [
						'{{WRAPPER}} td .stratum-table__cell-icon > i' => 'font-size: {{VALUE}}px',
						'{{WRAPPER}} td .stratum-table__cell-icon > svg' => 'width: {{VALUE}}px; height: {{VALUE}}px;',
					],
				]
			);

			$controls->start_controls_tabs( 'table_body_styles' );

				$controls->start_controls_tab(
					'table_body_state_odd',
					[
						'label' => esc_html__( 'Even', 'stratum' ),
					]
				);

					$controls->add_control(
						'table_body_even_text',
						[
							'label'     => __( 'Text Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
							'selectors' => [
								'{{WRAPPER}} tbody tr:nth-child(odd) .stratum-table__cell-title' => 'color: {{VALUE}}',
							]
						]
					);

					$controls->add_control(
						'table_body_even_bgcolor',
						[
							'label'     => __( 'Background Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
							'selectors' => [
								'{{WRAPPER}} tbody tr:nth-child(odd) > td' => 'background-color: {{VALUE}}',
							]
						]
					);

					$controls->add_control(
						'table_body_even_icon_color',
						[
							'label'     => __( 'Icon Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
							'selectors' => [
								'{{WRAPPER}} tbody tr:nth-child(odd) > td .stratum-table__cell-icon' => 'color: {{VALUE}}',
							],
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'table_body_state_paired',
					[
						'label' => esc_html__( 'Even Hover', 'stratum' ),
					]
				);

					$controls->add_control(
						'table_body_even_text_hover',
						[
							'label'     => __( 'Text Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
							'selectors' => [
								'{{WRAPPER}} tbody tr:nth-child(odd) > td:hover .stratum-table__cell-title' => 'color: {{VALUE}}!important',
							]
						]
					);

					$controls->add_control(
						'table_body_even_bgcolor_hover',
						[
							'label'     => __( 'Background Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
							'selectors' => [
								'{{WRAPPER}} tbody tr:nth-child(odd) > td:hover' => 'background-color: {{VALUE}}!important',
							]
						]
					);

					$controls->add_control(
						'table_body_even_icon_color_hover',
						[
							'label'     => __( 'Icon Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
							'selectors' => [
								'{{WRAPPER}} tbody tr:nth-child(odd) > td:hover .stratum-table__cell-icon' => 'color: {{VALUE}}!important',
							],
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'table_body_state_normal',
					[
						'label' => esc_html__( 'Odd', 'stratum' ),
					]
				);

					$controls->add_control(
						'table_body_odd_text',
						[
							'label'     => __( 'Text Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
							'selectors' => [
								'{{WRAPPER}} tbody tr:nth-child(even) > td .stratum-table__cell-title' => 'color: {{VALUE}}',
							]
						]
					);

					$controls->add_control(
						'table_body_odd_bgcolor',
						[
							'label'     => __( 'Background Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
							'selectors' => [
								'{{WRAPPER}} tbody tr:nth-child(even) > td' => 'background-color: {{VALUE}}',
							]
						]
					);

					$controls->add_control(
						'table_body_odd_icon_color',
						[
							'label'     => __( 'Icon Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
							'selectors' => [
								'{{WRAPPER}} tbody tr:nth-child(even) > td .stratum-table__cell-icon' => 'color: {{VALUE}}',
							],
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'table_body_state_hover',
					[
						'label' => esc_html__( 'Odd Hover', 'stratum' ),
					]
				);

					$controls->add_control(
						'table_body_odd_text_hover',
						[
							'label'     => __( 'Text Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
							'selectors' => [
								'{{WRAPPER}} tbody tr:nth-child(even) > td:hover .stratum-table__cell-title' => 'color: {{VALUE}}!important',
							]
						]
					);

					$controls->add_control(
						'table_body_odd_bgcolor_hover',
						[
							'label'     => __( 'Background Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
							'selectors' => [
								'{{WRAPPER}} tbody tr:nth-child(even) > td:hover' => 'background-color: {{VALUE}}!important',
							]
						]
					);


					$controls->add_control(
						'table_body_odd_icon_color_hover',
						[
							'label'     => __( 'Icon Color', 'stratum' ),
							'type' 	    => Controls_Manager::COLOR,
							'default'   => '',
							'value'     => '',
							'selectors' => [
								'{{WRAPPER}} tbody tr:nth-child(even) > td:hover .stratum-table__cell-icon' => 'color: {{VALUE}}!important',
							],
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();
    }

    // PHP template (refresh elements)
    protected function render() {
        $this->render_widget( 'php' );
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Table() );