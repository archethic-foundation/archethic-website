<?php
/**
 * Class: Advanced_Google_Map
 * Name: Advanced Google Map
 * Slug: advanced-google-map
 */

namespace Stratum;

use \Elementor\Controls_Manager;
use \Elementor\Utils;
use Elementor\Repeater;
use \Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Advanced_Google_Map extends Stratum_Widget_Base {
	protected $widget_name = 'advanced-google-map';

	public function __construct($data = [], $args = null) {
		parent::__construct( $data, $args );
	}

	public function get_title() {
		return esc_html__( 'Advanced Google Map', 'stratum' );
	}

	public function get_icon() {
		return 'stratum-icon-advanced-google-map';
	}

	public function get_categories() {
		return [ 'stratum-widgets' ];
	}

	public function get_script_depends() {
		return [
			'google-map-api',
			'google-map-styles'
        ];
    }

    protected function _register_controls() {
		$controls = $this;

		/*-----------------------------------------------------------------------------------*/
        /*	Content Tab
        /*-----------------------------------------------------------------------------------*/

        $controls->start_controls_section(
			'general_settings',
			[
				'label' => esc_html__( 'General Settings', 'stratum' )
			]
		);

		$controls->add_control(
			'map_type_setup',
				[
					'label'       => esc_html__( 'Google Map Type', 'stratum' ),
				    'type' 	      => Controls_Manager::SELECT,
				    'default'     => 'single',
					'label_block' => false,
				    'options'     => [
					   'single'   => esc_html__( 'Single', 'stratum' ),
					   'multiple' => esc_html__( 'Multiple Marker', 'stratum' )
					],
					'render_type' => 'none',
					'frontend_available' => true
				]
		);

		$controls->add_control(
			'interaction',
			[
				'label'       => esc_html__( 'Zoom & Pan Interaction', 'stratum' ),
				'type' 	      => Controls_Manager::SELECT,
				'default'     => 'cooperative',
				'label_block' => false,
				'separator'   => 'after',
				'description' => esc_html__( 'These options are applied on frontend only.', 'stratum' ),
				'options' => [
					'cooperative' => esc_html__( 'Prevent zoom on page scroll', 'stratum' ),
					'greedy' => esc_html__( 'Enable zoom and pan', 'stratum' ),
					'none'   => esc_html__( ' Disable zoom and pan' , 'stratum' )
				],
				'render_type' => 'none',
				'frontend_available' => true
			]
		);

		$controls->add_control(
			'zoom_level',
			[
				'label' => esc_html__( 'Zoom Level', 'stratum' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 2,
					'unit' => 'px'
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 22
					]
				],
				'render_type' => 'none',
				'frontend_available' => true
			]
		);

		$controls->add_control(
			'map_lat',
			[
				'label' => esc_html__( 'Center Latitude', 'stratum' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
				'render_type' => 'none',
				'frontend_available' => true,
				'default' => esc_html__( '48.208174', 'stratum' )
			]
		);

		$controls->add_control(
			'map_lng',
			[
				'label' => esc_html__( 'Center Longitude', 'stratum' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => false,
				'render_type' => 'none',
				'frontend_available' => true,
				'default' => esc_html__( '16.373819', 'stratum' )
			]
		);

		$controls->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
        /*	Map Marker Settings Tab
		/*-----------------------------------------------------------------------------------*/

		/**
  		 * Map Settings (With Marker only for single)
  		 */
		$controls->start_controls_section(
			'map_marker_section',
			[
				'label'	=> esc_html__( 'Map Marker Settings', 'stratum' ),
				'condition' => [
					'map_type_setup' => ['single']
				]
			]
		);

		$controls->add_control(
			'marker_title',
			[
				'label' => esc_html__( 'Title', 'stratum' ),
				'type' => Controls_Manager::TEXT,

				'label_block' => true,
				'default'     => esc_html__( 'Marker', 'stratum' ),
				'placeholder' => esc_html__( 'Type your title here...', 'stratum' ),
				'condition' => [
					'map_type_setup' => ['single']
				],
				'render_type' => 'none',
				'frontend_available' => true
			]
		);

		$controls->add_control(
            'marker_type_setup',
            [
                'label' => esc_html__( 'Address Type', 'stratum' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
					'address' => [
						'title' => esc_html__( 'Address', 'stratum' ),
						'icon' => 'fa fa-map'
					],
					'coordinates' => [
						'title' => esc_html__( 'Coordinates', 'stratum' ),
						'icon' => 'fa fa-map-marker'
					]
				],
				'default' => 'coordinates',
				'condition' => [
					'map_type_setup' => ['single']
				],
				'render_type' => 'none',
				'frontend_available' => true
            ]
		);

		$controls->add_control(
			'map_geo_address',
			[
				'label' => esc_html__( 'Geo Address', 'stratum' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Wien, Austria', 'stratum' ),
				'condition' => [
					'map_type_setup' => ['single'],
					'marker_type_setup' => ['address']
				],
				'render_type' => 'none',
				'frontend_available' => true
			]
		);

		$controls->add_control(
			'marker_lat',
			[
				'label' => esc_html__( 'Marker Latitude', 'stratum' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( '48.208174', 'stratum' ),
				'condition' => [
					'map_type_setup' => ['single'],
					'marker_type_setup' => ['coordinates']
				],
				'render_type' => 'none',
				'frontend_available' => true
			]
		);

		$controls->add_control(
			'marker_lng',
			[
				'label' => esc_html__( 'Marker Longitude', 'stratum' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( '16.373819', 'stratum' ),
				'condition' => [
					'map_type_setup' => ['single'],
					'marker_type_setup' => ['coordinates']
				],
				'render_type' => 'none',
				'frontend_available' => true
			]
		);

		$controls->add_control(
			'marker_content',
			[
				'label' => esc_html__( 'Content', 'stratum' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default'     => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'stratum' ),
				'placeholder' => esc_html__( 'Type your content here...', 'stratum' ),
				'condition' => [
					'map_type_setup' => ['single']
				],
				'render_type' => 'none',
				'frontend_available' => true
			]
		);

		$controls->add_control(
			'is_open_popup',
			[
				'label'        => esc_html__( 'Opened by default', 'stratum' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => esc_html__( 'Yes', 'stratum' ),
				'label_off'    => esc_html__( 'No' , 'stratum' ),
				'condition' => [
					'map_type_setup' => ['single']
				],
				'render_type' => 'none',
				'frontend_available' => true
			]
		);

		$controls->add_control(
			'popup_max_width',
			[
				'label' => esc_html__( 'Popup Width', 'stratum' ),
				'type' => Controls_Manager::NUMBER,
				'label_block' => false,
				'default' => 250,
				'condition' => [
					'map_type_setup' => ['single']
				],
				'render_type' => 'none',
				'frontend_available' => true
			]
		);

		$controls->add_control(
			'use_custom_icon',
			[
				'label' => esc_html__( 'Use Custom Icon', 'stratum' ),
				'type'  => Controls_Manager::SWITCHER,
				'default'   => '',
				'label_on'  => esc_html__( 'Yes', 'stratum' ),
				'label_off' => esc_html__( 'No' , 'stratum' ),
				'render_type' => 'none',
				'frontend_available' => true
			]
		);

		$controls->add_control(
			'marker_icon',
			[
				'label' => esc_html__( 'Custom Icon', 'stratum' ),
				'type'  => Controls_Manager::MEDIA,
				'condition' => [
					'use_custom_icon' => 'yes'
				],
				'default' => [ 'url' => '' ],
				'render_type' => 'none',
				'frontend_available' => true
			]
		);

		$controls->add_control(
			'marker_icon_width',
			[
				'label' => esc_html__( 'Icon Width', 'stratum' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 32,
					'unit' => 'px'
				],
				'range' => [
					'px' => [
						'max' => 150
					]
				],
				'condition' => [
					'use_custom_icon' => 'yes',
					'marker_icon[url]!' => ''
				],
				'render_type' => 'none',
				'frontend_available' => true
			]
		);

		$controls->add_control(
			'marker_icon_height',
			[
				'label' => esc_html__( 'Icon Height', 'stratum' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 32,
					'unit' => 'px'
				],
				'range' => [
					'px' => [
						'max' => 150
					]
				],
				'condition' => [
					'use_custom_icon' => 'yes',
					'marker_icon[url]!' => ''
				],
				'render_type' => 'none',
				'frontend_available' => true
			]
		);

		$controls->end_controls_section();

		/**
  		 * Map Settings (With Markers only for Multiple)
  		 */
		$controls->start_controls_section(
			'map_markers_section',
			[
				'label'	=> esc_html__( 'Map Marker Settings', 'stratum' ),
				'condition' => [
					'map_type_setup' => ['multiple']
				]
			]
		);

		$controls->add_control(
			'markers',
			[
				'label' => '',
				'type'  => Controls_Manager::REPEATER,
				'title_field' => '<i class="fa fa-map-marker" aria-hidden="true"></i> {{{ marker_title }}}',
				'default' => [
					[ 'marker_title' => esc_html__( 'Marker', 'stratum' ) ]
				],
				'item_actions' => [ 'sort' => false ],
				'fields' => [
					[
						'name'  => 'marker_title',
						'label' => esc_html__( 'Title', 'stratum' ),
						'type'  => Controls_Manager::TEXT,
						'label_block' => true,
						'default' => esc_html__( 'Marker', 'stratum' ),
						'placeholder' => esc_html__( 'Type your title here...', 'stratum' )
					],
					[
						'name'  => 'marker_lat',
						'label' => esc_html__( 'Marker Latitude', 'stratum' ),
						'type'  => Controls_Manager::TEXT,
						'label_block' => true,
						'default' => esc_html__( '48.208174', 'stratum' )
					],
					[
						'name'  => 'marker_lng',
						'label' => esc_html__( 'Marker Longitude', 'stratum' ),
						'type'  => Controls_Manager::TEXT,
						'label_block' => true,
						'default' => esc_html__( '16.373819', 'stratum' )
					],
					[
						'name'  => 'marker_content',
						'label' => esc_html__( 'Content', 'stratum' ),
						'type'  => Controls_Manager::TEXTAREA,
						'label_block' => true,
						'default'     => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'stratum' ),
						'placeholder' => esc_html__( 'Type your content here...', 'stratum' )
					],
					[
						'name'      => 'is_open_popup',
						'label'     => esc_html__( 'Opened by default', 'stratum' ),
						'type'      => Controls_Manager::SWITCHER,
						'default'   => '',
						'label_on'  => esc_html__( 'Yes', 'stratum' ),
						'label_off' => esc_html__( 'No', 'stratum' )
					],
					[
						'name'  => 'popup_max_width',
						'label' => esc_html__( 'Popup Width', 'stratum' ),
						'type'  => Controls_Manager::NUMBER,
						'label_block' => false,
						'default' => 250
					],
					[
						'name'  => 'use_custom_icon',
						'label' => esc_html__( 'Use Custom Icon', 'stratum' ),
						'type'  => Controls_Manager::SWITCHER,
						'default'   => '',
						'label_on'  => esc_html__( 'Yes', 'stratum' ),
						'label_off' => esc_html__( 'No', 'stratum' )
					],
					[
						'name'  => 'marker_icon',
						'label' => esc_html__( 'Custom Icon', 'stratum' ),
						'type'  => Controls_Manager::MEDIA,
						'condition' => [
							'use_custom_icon' => 'yes'
						],
						'default' => [ 'url' => '' ]
					],
					[
						'name'  => 'marker_icon_width',
						'label' => esc_html__( 'Icon Width', 'stratum' ),
						'type' => Controls_Manager::SLIDER,
						'default' => [
							'size' => 32,
							'unit' => 'px',
						],
						'range' => [
							'px' => [
								'max' => 150
							]
						],
						'condition' => [
							'use_custom_icon' => 'yes',
							'marker_icon[url]!' => ''
						]
					],
					[
						'name'  => 'marker_icon_height',
						'label' => esc_html__( 'Icon Height', 'stratum' ),
						'type' => Controls_Manager::SLIDER,
						'default' => [
							'size' => 32,
							'unit' => 'px',
						],
						'range' => [
							'px' => [
								'max' => 150
							]
						],
						'condition' => [
							'use_custom_icon' => 'yes',
							'marker_icon[url]!' => ''
						]
					]
				]
			]
        );

		$controls->end_controls_section();

		$controls->start_controls_section(
			'map_controls',
			[
				'label'	=> esc_html__( 'Map Controls', 'stratum' )
			]
		);

		$controls->add_control(
			'street_view_control',
			[
				'label'     => esc_html__( 'Street View Controls', 'stratum' ),
				'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_on'  => esc_html__( 'On', 'stratum' ),
				'label_off' => esc_html__( 'Off', 'stratum' ),
				'render_type' => 'none',
				'frontend_available' => true
			]
		);

		$controls->add_control(
			'map_type_control',
			[
				'label'     => esc_html__( 'Map Type Control', 'stratum' ),
				'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_on'  => esc_html__( 'On', 'stratum' ),
				'label_off' => esc_html__( 'Off', 'stratum' ),
				'render_type' => 'none',
				'frontend_available' => true
			]
		);

		$controls->add_control(
			'zoom_control',
			[
				'label'     => esc_html__( 'Zoom Control', 'stratum' ),
				'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_on'  => esc_html__( 'On', 'stratum' ),
				'label_off' => esc_html__( 'Off', 'stratum' ),
				'render_type' => 'none',
				'frontend_available' => true
			]
		);

		$controls->add_control(
			'fullscreen_control',
			[
				'label'     => esc_html__( 'Fullscreen Control', 'stratum' ),
				'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_on'  => esc_html__( 'On', 'stratum' ),
				'label_off' => esc_html__( 'Off', 'stratum' ),
				'render_type' => 'none',
				'frontend_available' => true
			]
		);

		$controls->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
        /*	Map Marker Style Tab
		/*-----------------------------------------------------------------------------------*/

		$controls->start_controls_section(
			'section_map_style_controls',
			[
				'label' => esc_html__( 'General Style', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$controls->add_responsive_control(
			'map_height',
			[
				'label' => esc_html__( 'Height', 'stratum' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 480,
					'unit' => 'px'
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1400,
						'step' => 10
					]
				],
				'selectors' => [
					'{{WRAPPER}} .stratum-advanced-google-map__container' => 'height: {{SIZE}}{{UNIT}};'
				],
				'render_type' => 'ui'
			]
		);

		$controls->end_controls_section();

		$controls->start_controls_section(
			'map_theme',
			[
				'label' => esc_html__( 'Map Theme', 'stratum' )
			]
		);

		$controls->add_control(
            'map_theme_source',
            [
                'label'	=> esc_html__( 'Theme Source', 'stratum' ),
				'type'  => Controls_Manager::CHOOSE,
                'options' => [
					'standard' => [
						'title' => esc_html__( 'Google Standard', 'stratum' ),
						'icon'  => 'fa fa-map'
					],
					'snazzymaps' => [
						'title'  => esc_html__( 'Snazzy Maps', 'stratum' ),
						'icon'   => 'fa fa-map-marker'
					],
					'custom' => [
						'title' => esc_html__( 'Custom', 'stratum' ),
						'icon'  => 'fa fa-edit'
					]
				],
				'default' => 'standard',
				'render_type' => 'none',
				'frontend_available' => true
            ]
		);

		$controls->add_control(
			'map_standards_styles',
			[
				'label'   => esc_html__( 'Google Themes', 'stratum' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'standard',
				'options' => [
					'standard'     => esc_html__( 'Standard'      , 'stratum' ),
					'silver'       => esc_html__( 'Silver'        , 'stratum' ),
					'retro'        => esc_html__( 'Retro'         , 'stratum' ),
					'dark'         => esc_html__( 'Dark'          , 'stratum' ),
					'night'        => esc_html__( 'Night'         , 'stratum' ),
					'aubergine'    => esc_html__( 'Aubergine'     , 'stratum' )
				],
				'description' => sprintf( '<a href="https://mapstyle.withgoogle.com/" target="_blank">%1$s</a> %2$s', esc_html__( 'Click here', 'stratum' ), esc_html__( 'to generate your own theme and use JSON within a Custom style field.', 'stratum' ) ),
				'condition'	=> [
					'map_theme_source' => 'standard'
				],
				'render_type' => 'none',
				'frontend_available' => true
			]
		);

		$controls->add_control(
			'map_snazzy_styles',
			[
				'label'       => esc_html__( 'Snazzy Maps Themes', 'stratum' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'default'     => 'blueWater',
				'options' => [
					'blueWater'    => esc_html__( 'Blue Water'    , 'stratum' ),
					'ultraLight'   => esc_html__( 'Ultra Light'   , 'stratum' ),
					'silverFox'    => esc_html__( 'Silver Fox'    , 'stratum' ),
					'shadesOfGrey' => esc_html__( 'Shades of Grey', 'stratum' ),
					'noLabels'     => esc_html__( 'No Labels'     , 'stratum' ),
					'trekWild'     => esc_html__( 'Trek Wild'     , 'stratum' ),
					'vintage'      => esc_html__( 'Vintage'       , 'stratum' ),
					'wireframe'    => esc_html__( 'Wireframe'     , 'stratum' ),
					'lightDream'   => esc_html__( 'Light Dream'   , 'stratum' )
				],
				'description' => sprintf( '<a href="https://snazzymaps.com/explore" target="_blank">%1$s</a> %2$s', esc_html__( 'Click here', 'stratum' ), esc_html__( 'to explore more themes and use JSON within a custom style field.', 'stratum' ) ),
				'condition'	=> [
					'map_theme_source'=> 'snazzymaps'
				],
				'render_type' => 'none',
				'frontend_available' => true
			]
		);

		$controls->add_control(
			'map_custom_style',
			[
				'label'       => esc_html__( 'Custom Style', 'stratum' ),
				'description' => sprintf( '<a href="https://mapstyle.withgoogle.com/" target="_blank">%1$s</a> %2$s', esc_html__( 'Click here', 'stratum' ), esc_html__( 'to get JSON style code to style your map', 'stratum' ) ),
				'type'        => Controls_Manager::TEXTAREA,
                'condition'   => [
                    'map_theme_source' => 'custom'
				],
				'render_type' => 'none',
				'frontend_available' => true
			]
		);

		$controls->end_controls_section();
	}

	protected function render() {
		$this->render_widget( 'php' );
	}

	protected function content_template() {}
	public function render_plain_content( $instance = [] ) {}

	public function get_single_marker_option($marker) {
		$single_options = [
			'markerTitle'   => $marker[ 'marker_title' ],
			'markerContent' => $marker[ 'marker_content' ],
			'popupMaxWidth' => $marker[ 'popup_max_width' ],
			'isOpenPopup' => !empty( $marker[ 'is_open_popup' ] ) ? true : false
		];
		if ( $marker[ 'use_custom_icon' ] ) {
			$custom_icon = [
				'markerIcon'       => $marker[ 'marker_icon' ],
				'markerIconWidth'  => $marker[ 'marker_icon_width' ],
				'markerIconHeight' => $marker[ 'marker_icon_height' ]
			];
			$single_options[ 'customIcon' ] = $custom_icon;
		}
		return $single_options;
	}

	public function get_markers_options($settings) {
		$map_markers_amount = $settings[ 'map_type_setup' ];
		if ( $map_markers_amount == 'multiple' ) {

			$markers_options = [];
			foreach ( $settings[ 'markers' ] as $marker ) {
				$marker_coords = [
					'markerLat' => $marker[ 'marker_lat' ],
					'markerLng' => $marker[ 'marker_lng' ]
				];

				$marker_options = $this->get_single_marker_option( $marker );
				$markers_options []= array_merge( $marker_options, $marker_coords );
			}
			return $markers_options;
		} else {
			$marker_options = [];

			$type_setup = $settings[ 'marker_type_setup' ];
			if ( $type_setup == 'coordinates' ) {

				$marker_coords = [
					'markerLat' => $settings[ 'marker_lat' ],
					'markerLng' => $settings[ 'marker_lng' ]
				];

				$marker_options []= array_merge( $marker_coords, $this->get_single_marker_option( $settings ) );
			} else {
				$geo = [ 'mapGeoAddress' => $settings[ 'map_geo_address' ] ];
				$marker_options []= array_merge( $geo, $this->get_single_marker_option( $settings ) );
			}
			return $marker_options;
		}
	}

	public function set_map_theme_style($settings) {
		$theme_source     = $settings[ 'map_theme_source' ];
		$standards_styles = $settings[ 'map_standards_styles' ];
		$snazzy_styles    = $settings[ 'map_snazzy_styles' ];

		if ( $theme_source == 'standard' ) {
			return $standards_styles;
		} else if ( $theme_source == 'snazzymaps' ) {
			return $snazzy_styles;
		} else {
			return json_decode(strip_tags(
				$settings[ 'map_custom_style' ]
			));
		}
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Advanced_Google_Map() );