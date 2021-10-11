<?php
/**
 * Class: Price_Menu
 * Name: Price Menu
 * Slug: stratum-price-menu
 */

namespace Stratum;

use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Controls_Manager;
use Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Price_Menu extends Stratum_Widget_Base {
    protected $widget_name = 'price-menu';

    public function __construct($data = [], $args = null) {
        parent::__construct( $data, $args );
    }

	public function get_title() {
		return esc_html__( 'Price Menu', 'stratum' );
	}

	public function get_icon() {
		return 'stratum-icon-price-menu';
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

			$repeater = new Repeater();

			$repeater->add_control(
				'menu_title',
				[
					'label' => esc_html__( 'Title', 'stratum' ),
					'type'  => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'label_block' => true,
					'placeholder' => esc_html__( 'Title', 'stratum' ),
					'default' => esc_html__( 'Title', 'stratum' )
				]
			);

			$repeater->add_control(
				'title_html_tag',
				[
					'label' => esc_html__( 'Title HTML Tag', 'stratum' ),
					'type'  => Controls_Manager::SELECT,
					'options' => [
						'h1'   => esc_html__( 'H1'  , 'stratum' ),
						'h2'   => esc_html__( 'H2'  , 'stratum' ),
						'h3'   => esc_html__( 'H3'  , 'stratum' ),
						'h4'   => esc_html__( 'H4'  , 'stratum' ),
						'h5'   => esc_html__( 'H5', 'stratum' ),
						'h6'   => esc_html__( 'H6'  , 'stratum' ),
						'div'  => esc_html__( 'div' , 'stratum' ),
						'span' => esc_html__( 'span', 'stratum' ),
						'p'    => esc_html__( 'p'   , 'stratum' )
					],
					'default' => 'span'
				]
			);

			$repeater->add_control(
				'menu_description',
				[
					'label'       => esc_html__( 'Description', 'stratum' ),
					'type'        => Controls_Manager::TEXTAREA,
					'dynamic'     => [
						'active'  => true,
					],
					'label_block' => true,
					'placeholder' => esc_html__( 'Description', 'stratum' ),
					'default'     => esc_html__( 'Description', 'stratum' )
				]
			);

			$repeater->add_control(
				'menu_price',
				[
					'label' => esc_html__( 'Price', 'stratum' ),
					'type'  => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default' => '$49'
				]
			);

			$repeater->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Title Color', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .stratum-price-menu__title' => 'color: {{VALUE}}',
					]
				]
			);

			$repeater->add_control(
				'price_color',
				[
					'label' => esc_html__( 'Price Color', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .stratum-price-menu__price' => 'color: {{VALUE}}',
					]
				]
			);

			$repeater->add_control(
				'description_color',
				[
					'label' => esc_html__( 'Description Color', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .stratum-price-menu__description' => 'color: {{VALUE}}',
					]
				]
			);

			$repeater->add_control(
				'show_image',
				[
					'label' => esc_html__( 'Show Image', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'default' => '',
					'label_on'  => esc_html__( 'On', 'stratum' ),
					'label_off' => esc_html__( 'Off', 'stratum' ),
					'return_value' => 'yes'
				]
			);

			$repeater->add_control(
				'image_size',
				[
					'label'   => esc_html__( 'Image Size', 'stratum' ),
					'type'    => 'select',
					'default' => 'full',
					'options' => Stratum::get_instance()->get_scripts_manager()->get_image_sizes(),
					'condition' => [
						'show_image' => 'yes'
					]
				]
			);

			$repeater->add_control(
				'image_align',
				[
					'label' => esc_html__( 'Image Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'left',
					'toggle' => false,
					'options' => [
						'left'    => [
							'title' => esc_html__( 'Left', 'stratum' ),
							'icon' => 'fa fa-align-left',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'stratum' ),
							'icon' => 'fa fa-align-right',
						],
					],
					'condition' => [
						'show_image' => 'yes'
					]
				]
			);

			$repeater->add_control(
				'image',
				[
					'label' => esc_html__( 'Image', 'stratum' ),
					'type'  => Controls_Manager::MEDIA,
					'default' => [
						'url' => Utils::get_placeholder_image_src()
					],
					'dynamic' => [
						'active' => true
					],
					'condition' => [
						'show_image' => 'yes'
					]
				]
			);

        $controls->add_control(
			'menu_items',
			[
				'label' => '',
				'type'  => Controls_Manager::REPEATER,
				'title_field' => '{{{ menu_title }}}',
				'default' => [
					[
						'menu_title' => sprintf( esc_html__( 'Item #%d', 'stratum' ), 1 ),
						'menu_price' => '$69'
                    ],
                    [
						'menu_title' => sprintf( esc_html__( 'Item #%d', 'stratum' ), 2 ),
						'menu_price' => '$49'
                    ],
                    [
						'menu_title' => sprintf( esc_html__( 'Item #%d', 'stratum' ), 3 ),
						'menu_price' => '$19'
					]
				],
				'fields' => $repeater->get_controls()
			]
        );

        $controls->add_control(
            'title_price_connector',
            [
                'label'        => esc_html__( 'Title-Price Separator', 'stratum' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'no',
                'label_on'     => esc_html__( 'Yes', 'stratum' ),
                'label_off'    => esc_html__( 'No', 'stratum'  ),
            ]
		);

        $controls->add_control(
            'items_divider',
            [
                'label'        => esc_html__( 'Items Separator', 'stratum' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'no',
                'label_on'     => esc_html__( 'Yes', 'stratum' ),
                'label_off'    => esc_html__( 'No', 'stratum' ),
            ]
        );

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$controls->add_control(
				'items_animate',
				[
					'label' => esc_html__( 'Animate items', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'return_value' => 'animate',
					'default' => '',
					'prefix_class' => 'stratum-price-menu-items-',
				]
			);

			$controls->add_responsive_control(
				'items_gap',
				[
					'label' => esc_html__( 'Items Gap', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'size_units' => [ 'px', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-price-menu .stratum-price-menu__item-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'items_images_width',
				[
					'label' => esc_html__( 'Image width', 'stratum' ),
					'description'	=> esc_html__( 'In Percent (%)', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'%' => [
							'min' => 0,
							'max' => 80,
						],
					],
					'size_units' => [ '%' ],
					'default' => [
						'size' => '50',
						'unit' => '%',
					],
					'tablet_default' => [
						'unit' => '%',
					],
					'mobile_default' => [
						'unit' => '%',
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-price-menu .stratum-price-menu__image' => 'width: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.stratum-price-menu-items-animate .stratum-price-menu__image.image-align-left' => 'margin-left: -{{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.stratum-price-menu-items-animate .stratum-price-menu__image.image-align-right' => 'margin-right: -{{SIZE}}{{UNIT}};',
					],
				]
			);

			$controls->add_control(
				'items_background_color',
				[
					'label' => esc_html__( 'Background Color', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'render_type' => 'ui',
					'selectors' => [
						'{{WRAPPER}} .stratum-price-menu .stratum-price-menu__item-wrapper' => 'background-color: {{VALUE}}',
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'items_border',
					'label' => esc_html__( 'Border', 'stratum' ),
					'selector' => '{{WRAPPER}} .stratum-price-menu .stratum-price-menu__item-wrapper',
				]
			);

			$controls->add_control(
				'items_border_radius',
				[
					'label' => esc_html__('Border Radius', 'stratum'),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', 'em', '%'],
					'condition' => [
						'items_border_border!' => ''
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-price-menu .stratum-price-menu__item-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'items_shadow',
					'selector' => '{{WRAPPER}} .stratum-price-menu .stratum-price-menu__item-wrapper',
				]
			);

			$controls->add_responsive_control(
				'items_paddings',
				[
					'label' => esc_html__( 'Content Padding', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-price-menu .stratum-price-menu__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
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

Plugin::instance()->widgets_manager->register_widget_type( new Price_Menu() );