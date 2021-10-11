<?php
/**
 * Class: Image_Hot_Spot
 * Name: Image Hot Spots
 * Slug: stratum-image-hotspot
 */

namespace Stratum;

use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Image_Hot_Spot extends Stratum_Widget_Base {
	protected $widget_name = 'image-hotspot';

	public function __construct($data = [], $args = null) {
		parent::__construct( $data, $args );
	}

	public function get_title() {
		return esc_html__( 'Image Hotspot', 'stratum' );
	}

	public function get_script_depends() {
		return [
			'popper',
			'tippy',
			'draggabilly',
			'font-awesome-4-shim'
        ];
    }

	public function get_style_depends() {
        return [
			'tippy-themes',
			'tippy-animation',
			'font-awesome-5-all',
			'font-awesome-4-shim'
        ];
	}

	public function get_icon() {
		return 'stratum-icon-image-hotspot';
	}

	public function get_categories() {
		return [ 'stratum-widgets' ];
    }

    protected function _register_controls() {

        /*-----------------------------------------------------------------------------------*/
        /*	Content Tab
		/*-----------------------------------------------------------------------------------*/

		$controls = $this;

        $controls->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'stratum' )
			]
        );

        $controls->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'stratum' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src()
				],
				'dynamic' => [ 'active' => true ]
			]
		);

		$controls->add_control(
			'image_size',
			[
				'type'    => 'select',
				'label'   => esc_html__( 'Image Size', 'stratum' ),
				'default' => 'full',
				'options' => Stratum::get_instance()->get_scripts_manager()->get_image_sizes()
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'hot_spots_tabs' );

			$repeater->start_controls_tab ( 'tab_content', [ 'label' => esc_html__( 'Content', 'stratum' ) ]);

				$repeater->add_control(
					'hotspot_icon',
					[
						'label'   => esc_html__( 'Icon', 'stratum' ),
						'type'    => Controls_Manager::ICON,
						'default' => 'fa fa-plus',
						'label_block' => true,
					]
				);

			$repeater->end_controls_tab();

			$repeater->start_controls_tab( 'position', [ 'label' => esc_html__( 'Position', 'stratum' ) ] );

				$repeater->add_control(
					'left_position',
					[
						'label' => esc_html__( 'Left Position', 'stratum' ),
						'type'  => Controls_Manager::SLIDER,
						'range' => [
							'px' => [
								'min'  => 0,
								'max'  => 100,
								'step' => 0.1
							]
						],
						'default' => [
							'unit' => '%',
							'size' => 50
						],
						'render_type' => 'ui',
						'selectors' => [
							'{{WRAPPER}} {{CURRENT_ITEM}}' => 'left: {{SIZE}}%;'
						]
					]
				);

				$repeater->add_control(
					'top_position',
					[
						'label' => esc_html__( 'Top Position', 'stratum' ),
						'type'  => Controls_Manager::SLIDER,
						'range' => [
							'px' => [
								'min'  => 0,
								'max'  => 100,
								'step' => 0.1
							]
						],
						'default' => [
							'unit' => '%',
							'size' => 50
						],
						'render_type' => 'ui',
						'selectors' => [
							'{{WRAPPER}} {{CURRENT_ITEM}}' => 'top: {{SIZE}}%;'
						]
					]
				);

			$repeater->end_controls_tab();

			$repeater->start_controls_tab( 'tab_tooltip', [ 'label' => esc_html__( 'Tooltip', 'stratum' ) ] );

				$repeater->add_control(
					'tooltip',
					[
						'label'        => esc_html__( 'Tooltip', 'stratum' ),
						'type'         => Controls_Manager::SWITCHER,
						'default'      => '',
						'label_on'     => esc_html__( 'Yes', 'stratum' ),
						'label_off'    => esc_html__( 'No' , 'stratum' ),
						'return_value' => 'yes'
					]
				);

				$repeater->add_control(
					'tooltip_title',
					[
						'label'			=> esc_html__( 'Title', 'stratum' ),
						'type'			=> Controls_Manager::TEXT,
						'default' 		=> esc_html__( 'Lorem ipsum dolor sit amet.', 'stratum' ),
						'label_block'	=> true,
						'placeholder'	=> esc_html__( 'Type your title here...', 'stratum' ),
						'condition'		=> [
							'tooltip' => 'yes'
						]
					]
				);

				$repeater->add_control(
					'tooltip_content',
					[
						'label'			=> esc_html__( 'Tooltip Content', 'stratum' ),
						'type'			=> Controls_Manager::TEXTAREA,
						'dynamic'		=> [
							'active' => true,
						],
						'default'		=> esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'stratum' ),
						'label_block'	=> true,
						'placeholder'	=> esc_html__( 'Type your content here...', 'stratum' ),
						'condition'		=> [
							'tooltip' => 'yes'
						]
					]
				);

				$repeater->add_control(
					'open_by_default',
					[
						'label'        => esc_html__( 'Opened by default', 'stratum' ),
						'type'         => Controls_Manager::SWITCHER,
						'default'      => '',
						'label_on'     => esc_html__( 'Yes', 'stratum' ),
						'label_off'    => esc_html__( 'No', 'stratum' ),
						'return_value' => 'yes',
						'condition' => [
							'tooltip' => 'yes'
						]
					]
				);

				$repeater->add_control(
					'tooltip_arrow',
					[
						'label'        => esc_html__( 'Use Arrow', 'stratum' ),
						'type'         => Controls_Manager::SWITCHER,
						'default'      => 'yes',
						'label_on'     => esc_html__( 'Yes', 'stratum' ),
						'label_off'    => esc_html__( 'No' , 'stratum' ),
						'return_value' => 'yes',
						'condition' => [
							'tooltip' => 'yes'
						]
					]
				);

				$repeater->add_control(
					'placement',
					[
						'label'   => esc_html__( 'Placement', 'stratum' ),
						'type'    => Controls_Manager::SELECT,
						'default' => 'top',
						'options' => [
							'top'    => esc_html__( 'Top'   , 'stratum' ),
							'right'  => esc_html__( 'Right' , 'stratum' ),
							'bottom' => esc_html__( 'Bottom', 'stratum' ),
							'left'   => esc_html__( 'Left'  , 'stratum' )
						],
						'condition'       => [
							'tooltip' => 'yes'
						]
					]
				);

				$repeater->add_control(
					'tooltip_theme',
					[
						'label'   => esc_html__( 'Theme', 'stratum' ),
						'type'    => Controls_Manager::SELECT,
						'default' => 'light',
						'options' => [
							'light'        => esc_html__( 'Light'       , 'stratum' ),
							'dark'         => esc_html__( 'Dark'        , 'stratum' ),
							'light-border' => esc_html__( 'Light Border', 'stratum' ),
							'google'       => esc_html__( 'Google'      , 'stratum' ),
							'translucent'  => esc_html__( 'Translucent' , 'stratum' )
						],
						'condition'       => [
							'tooltip' => 'yes'
						]
					]
				);

				$repeater->add_control(
					'tooltip_animation',
					[
						'label'   => esc_html__( 'Animation', 'stratum' ),
						'type'    => Controls_Manager::SELECT,
						'default' => 'fade',
						'options' => [
							'shift-away'   => esc_html__( 'Shift Away'  , 'stratum' ),
							'shift-toward' => esc_html__( 'Shift Toward', 'stratum' ),
							'fade'         => esc_html__( 'Fade'        , 'stratum' ),
							'scale'        => esc_html__( 'Scale'       , 'stratum' ),
							'perspective'  => esc_html__( 'Perspective' , 'stratum' )
						],
						'condition' => [
							'tooltip' => 'yes'
						]
					]
				);

				$repeater->add_control(
					'tooltip_interactivity',
					[
						'label'   => esc_html__( 'Interactivity', 'stratum' ),
						'type'    => Controls_Manager::SELECT,
						'default' => 'hover',
						'options' => [
							'hover' => esc_html__( 'Hover', 'stratum' ),
							'click' => esc_html__( 'Click', 'stratum' )
						],
						'condition' => [
							'tooltip' => 'yes'
						]
					]
				);

			$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$controls->add_control(
			'hotspot_dot_animation',
			[
				'label'        => esc_html__( 'Animation', 'stratum' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'Yes', 'stratum' ),
				'label_off'    => esc_html__( 'No', 'stratum' ),
				'return_value' => 'yes'
			]
		);

		$controls->add_control(
            'hot_spots',
            [
				'label' => '',
				'title_field' => '<i class="{{ hotspot_icon }}" aria-hidden="true"></i> {{{ tooltip_title }}}',
                'type'  => Controls_Manager::REPEATER,
                'default' => [
                    [
						'feature_icon'  => 'fa fa-plus',
                        'left_position' => 20,
                        'top_position'  => 30
                    ]
                ],
                'fields' => $repeater->get_controls()
            ]
        );

		$controls->end_controls_section();

		$controls->start_controls_section(
            'section_hotspot_style',
            [
                'label' => esc_html__( 'Hotspot', 'stratum' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
		);

		$controls->add_responsive_control(
            'hotspot_icon_size',
            [
                'label' => esc_html__( 'Size', 'stratum' ),
                'type'  => Controls_Manager::SLIDER,
                'default' => [ 'size' => '20' ],
                'range'   => [
                    'px' => [
                        'min'  => 6,
                        'max'  => 50,
                        'step' => 1
                    ]
				],
                'size_units' => [ 'px' ],
                'selectors'  => [
					'{{WRAPPER}} .stratum-image-hotspot__dot-content' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
		);

		$controls->add_responsive_control(
            'hotspot_dot_padding',
            [
                'label' => esc_html__( 'Point Spacing', 'stratum' ),
                'type'  => Controls_Manager::SLIDER,
                'default' => [ 'size' => '0' ],
                'range'   => [
                    'px' => [
                        'min'  => 6,
                        'max'  => 100,
                        'step' => 1
                    ]
				],
                'size_units' => [ 'px' ],
                'selectors'  => [
					'{{WRAPPER}} .stratum-image-hotspot__dot' => 'padding: {{SIZE}}{{UNIT}};'
                ]
            ]
		);

		$controls->add_responsive_control(
            'hotspot_dot_opacity',
            [
                'label' => esc_html__( 'Point Opacity', 'stratum' ),
                'type'  => Controls_Manager::SLIDER,
                'default' => [ 'size' => '1' ],
                'range'   => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1,
                        'step' => 0.1
                    ]
				],
                'selectors'  => [
					'{{WRAPPER}} .stratum-image-hotspot__dot' => 'opacity: {{SIZE}};'
                ]
            ]
        );

        $controls->add_control(
            'icon_color_normal',
            [
                'label' => esc_html__( 'Color', 'stratum' ),
                'type'  => Controls_Manager::COLOR,
                'default'   => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .stratum-image-hotspot__dot-icon' => 'color: {{VALUE}}'
                ]
            ]
        );

        $controls->add_control(
            'icon_bg_color_normal',
            [
                'label' => esc_html__( 'Background Color', 'stratum' ),
                'type'  => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .stratum-image-hotspot__dot' => 'background-color: {{VALUE}}'
                ]
            ]
		);

		$controls->end_controls_section();
    }

    protected function render() {
		$this->render_widget( 'php' );
	}

	protected function _content_template() {
        $this->render_widget( 'js' );
	}

	protected function content_template() {}
	public function render_plain_content( $instance = [] ) {}

	public function get_dot_template($class, $dot_class, $wrapper_class, $icon_class, $type, $item = null) {
		$out = "";
		$out .= "<div ".$dot_class.">";
			$out .= "<div ".$wrapper_class."'>";
				$out .= "<div class='".esc_attr( $class."__dot-content" )."'>";
					$out .= "<i class='".esc_attr( $class."__dot-icon ".$icon_class )."'></i>";
				$out .= "</div>";
			$out .= "</div>";
		$out .= "</div>";

		return $out;
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Image_Hot_Spot() );