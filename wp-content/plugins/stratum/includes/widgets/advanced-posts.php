<?php
/**
 * Class: Advanced_Posts
 * Name: Advanced Posts
 * Slug: advanced-posts
 */

namespace Stratum;

use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Controls_Manager;
use \Elementor\Utils;
use \Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Advanced_Posts extends Stratum_Widget_Base {
	protected $widget_name = 'advanced-posts';

	public $default_arrows_color = '#fff';

    public function __construct($data = [], $args = null) {
		parent::__construct( $data, $args );

		wp_register_style(
            'font-awesome-5-all',
            ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/all.min.css',
            false,
            ELEMENTOR_VERSION
		);
    }

	public function get_title() {
		return esc_html__( 'Advanced Posts', 'stratum' );
	}
	public function get_keywords() {
		return [ 'blog', 'posts', 'slider' ];
	}

    public function get_script_depends() {
        return [
			'swiper',
			'jquery-masonry',
			'anim-on-scroll',
			'modernizr-custom'
		];
	}

	public function get_style_depends() {
		return [
			'font-awesome-5-all',
			'font-awesome-4-shim',
			'scroll-anim-effects'
		];
	}

	public function get_icon() {
		return 'stratum-icon-advanced-posts';
	}

	public function get_categories() {
		return [ 'stratum-widgets' ];
    }

    public function get_post_types() {
		$post_type_args = array(
			'public'            => true,
			'show_in_nav_menus' => true
		);

		$post_types = get_post_types( $post_type_args, 'objects' );
		$post_lists = array();

		foreach ( $post_types as $post_type ) {
			$post_lists[ $post_type->name ] = $post_type->labels->singular_name;
		}

		return $post_lists;
	}

    protected function _register_controls() {
        $controls = $this;

        /*-----------------------------------------------------------------------------------*/
        /*	Content Tab
        /*-----------------------------------------------------------------------------------*/

		$sections = new \Stratum\Sections($this);

		$controls->start_controls_section(
			'section_general',
			[
				'label' => esc_html__( 'General', 'stratum' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

			$controls->add_control(
				'posts_layout',
				[
					'label'   => esc_html__( 'Layout', 'stratum' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'list',
					'options' => [
						'grid'   => esc_html__( 'Grid'  , 'stratum' ),
						'list'  => esc_html__( 'List' , 'stratum' ),
						'carousel' => esc_html__( 'Carousel', 'stratum' ),
					]
				]
			);

			$controls->add_responsive_control(
				'columns',
				[
					'label' => esc_html__( 'Columns', 'stratum' ),
					'type' => Controls_Manager::SELECT,
					'default' => '2',
					'tablet_default' => '2',
					'mobile_default' => '1',
					'options' => [
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
					],
					'condition' => [
						'posts_layout' => 'grid'
					],
				]
			);

			$controls->add_control(
				'masonry',
				[
					'label' => esc_html__( 'Masonry', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'label_off' => esc_html__( 'Off', 'stratum' ),
					'label_on' => esc_html__( 'On', 'stratum' ),
					'default' => '',
					'condition' => [
						'posts_layout' => 'grid',
						'columns!' => '1',
						'show_image' => 'yes',
					],
				]
			);

			$controls->add_control(
				'masonry_warning',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => esc_html__( 'Note: By enabling Masonry options, you disable some controls for customizing the Advanced Posts widget. Customize it before turning on Masonry.', 'stratum' ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
					'condition' => [
						'posts_layout' => 'grid',
						'columns!' => '1',
						'show_image' => 'yes',
					],
				]
			);

			$controls->add_control(
				'show_image',
				[
					'label' => esc_html__( 'Image', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'stratum' ),
					'label_off' => esc_html__( 'Hide', 'stratum' ),
					'default' => 'yes',
					'condition' => [
						'posts_layout' => ['grid', 'list']
					],
				]
			);

			$controls->add_control(
				'show_title',
				[
					'label' => esc_html__( 'Title', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'stratum' ),
					'label_off' => esc_html__( 'Hide', 'stratum' ),
					'default' => 'yes',
				]
			);

			$controls->add_control(
				'show_meta',
				[
					'label' => esc_html__( 'Meta Fields', 'stratum' ),
					'label_block' => true,
					'type' => Controls_Manager::SELECT2,
					'default' => ['date'],
					'multiple' => true,
					'options' => [
						'author' => esc_html__( 'Author', 'stratum' ),
						'date' => esc_html__( 'Date', 'stratum' ),
						'comments' => esc_html__( 'Comments', 'stratum' ),
						'categories' => esc_html__( 'Categories', 'stratum' ),
					],
				]
			);

			$controls->add_control(
				'meta_fields_divider',
				[
					'label' => esc_html__( 'Meta Fields Divider', 'stratum' ),
					'type' => Controls_Manager::TEXT,
					'default' => '/',
					'description' => esc_html__( 'Symbol to separate fields', 'stratum' ),
					'conditions' => [
						'relation' => 'or',
						'terms' => [
							[
								'name' => 'show_meta',
								'operator' => '!=',
								'value' => '',
							]
						],
					],
				]
			);

			$controls->add_control(
				'show_content',
				[
					'label' => esc_html__( 'Content', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'stratum' ),
					'label_off' => esc_html__( 'Hide', 'stratum' ),
					'default' => 'yes',
				]
			);

			$controls->add_control(
				'show_excerpt',
				[
					'label' => esc_html__( 'Use Excerpt', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'On', 'stratum' ),
					'label_off' => esc_html__( 'Off', 'stratum' ),
					'default' => 'yes',
					'condition' => [
						'show_content' => 'yes',
					],
				]
			);

			$controls->add_control(
				'excerpt_length',
				[
					'label' => esc_html__( 'Excerpt Length (Words)', 'stratum' ),
					'type' => Controls_Manager::NUMBER,
					'default' => apply_filters( 'excerpt_length', 25 ),
					'condition' => [
						'show_excerpt' => 'yes',
					],
				]
			);

			$controls->add_control(
				'show_read_more',
				[
					'separator' => 'before',
					'label' => esc_html__( 'Read More', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'stratum' ),
					'label_off' => esc_html__( 'Hide', 'stratum' ),
					'default' => 'yes',
				]
			);

			$controls->add_control(
				'read_more_text',
				[
					'label' => esc_html__( 'Read More Text', 'stratum' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Read More', 'stratum' ),
					'condition' => [
						'show_read_more' => 'yes',
					],
				]
			);

			$controls->add_control(
				'open_new_tab',
				[
					'label' => esc_html__( 'Open in new window', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'stratum' ),
					'label_off' => esc_html__( 'No', 'stratum' ),
					'default' => 'no',
					'render_type' => 'none',
					'condition' => [
						'show_read_more' => 'yes',
					],
				]
			);

			$controls->add_control(
				'pagination',
				[
					'label' => esc_html__( 'Pagination', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'stratum' ),
					'label_off' => esc_html__( 'No', 'stratum' ),
					'default' => '',
					'separator' => 'before',
					'condition' => [
						'posts_layout' => ['grid', 'list']
					],
				]
			);

			$controls->add_control(
				'page_pagination_style',
				[
					'label'   => esc_html__( 'Pagination style', 'stratum' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'navigation',
					'options' => [
						'navigation'   => esc_html__( 'Navigation'  , 'stratum' ),
						'load_more_btn'  => esc_html__( 'Load More Button' , 'stratum' ),
						'load_more_scroll' => esc_html__( 'Load on scroll', 'stratum' ),
					],
					'condition' => [
						'posts_layout' => ['grid', 'list'],
						'pagination' => 'yes'
					],
				]
			);

			$controls->add_control(
				'load_more_text',
				[
					'label' => esc_html__( 'Load More Text', 'stratum' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Load More', 'stratum' ),
					'condition' => [
						'posts_layout' => ['grid', 'list'],
						'pagination' => 'yes',
						'page_pagination_style' => 'load_more_btn',
					],
				]
			);

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query Settings', 'stratum' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

			$controls->add_control(
				'post_type',
				[
					'label'   => esc_html__( 'Post Type', 'stratum' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'post',
					'options' => $this->get_post_types()
				]
			);

			$controls->add_control(
				'posts_per_page',
				[
					'label' => esc_html__( 'Posts Per Page', 'stratum' ),
					'type' => Controls_Manager::NUMBER,
					'default' => 3,
				]
			);

			$controls->add_control(
				'order',
				[
					'label' => esc_html__( 'Order', 'stratum' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'desc',
					'options' => [
						'asc' => esc_html__( 'ASC', 'stratum' ),
						'desc' => esc_html__( 'DESC', 'stratum' ),
					],
				]
			);

			$controls->add_control(
				'orderby',
				[
					'label' => esc_html__( 'Order By', 'stratum' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'post_date',
					'options' => [
						'post_date' => esc_html__( 'Date', 'stratum' ),
						'post_title' => esc_html__( 'Title', 'stratum' ),
						'menu_order' => esc_html__( 'Menu Order', 'stratum' ),
					],
				]
			);

			$controls->add_control(
				'ignore_sticky_posts',
				[
					'label' => esc_html__( 'Ignore Sticky Posts', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'condition' => [
						'post_type' => 'post',
					],
				]
			);

			$controls->add_control(
				'include_ids',
				[
					'label' => esc_html__( 'Display only the specific posts (Include)', 'stratum' ),
					'type' => Controls_Manager::TEXT,
					'label_block' => true,
					'default' => '',
					'description' => esc_html__( 'Comma-separated IDs', 'stratum' ),
				]
			);

			$controls->add_control(
				'exclude_ids',
				[
					'label' => esc_html__( 'Display all posts but NOT the specified ones (Exclude)', 'stratum' ),
					'type' => Controls_Manager::TEXT,
					'label_block' => true,
					'default' => '',
					'description' => esc_html__( 'Comma-separated IDs', 'stratum' ),
				]
			);

			$controls->add_control(
				'exclude_current',
				[
					'label' => esc_html__( 'Exclude Current Post', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => 'yes',
				]
			);

			$controls->add_control(
				'taxonomies',
				[
					'label' => esc_html__( 'Taxonomies', 'stratum' ),
					'label_block' => true,
					'type' => Controls_Manager::SELECT2,
					'multiple' => true,
					'options' => stratum_get_taxonomies('post'),
					'condition' => [
						'post_type' => 'post',
					],
				]
			);

			foreach (stratum_get_taxonomies('post') as $key => $value) {
				$terms = stratum_get_terms($key);

				if (!empty($terms)){
					$controls->add_control(
						$key.'_terms',
						[
							'label' => sprintf( esc_html__( 'Terms (%s)', 'stratum' ), $value ),
							'label_block' => true,
							'type' => Controls_Manager::SELECT2,
							'multiple' => true,
							'options' => $terms,
							'condition' => [
								'taxonomies' => $key,
							],
						]
					);
				}
			}

			$controls->add_control(
				'terms_relation',
				[
					'label' => esc_html__( 'Terms Relation', 'stratum' ),
					'label_block' => true,
					'type' => Controls_Manager::SELECT,
					'default' => 'and',
					'options' => [
						'and' => esc_html__( 'Item must have all selected terms.', 'stratum' ),
						'or' => esc_html__( 'Item must have at least one of selected terms.', 'stratum' ),
					],
					'condition' => [
						'post_type' => 'post',
					],
				]
			);

		$controls->end_controls_section();

		//Section Carousel
        $sections->advanced_carousel(
			[
				'settings'   => Controls_Manager::TAB_CONTENT,
				'navigation' => Controls_Manager::TAB_STYLE
			],
			[
				'posts_layout' => 'carousel'
			],
			[
				'auto_height'
			]
		);

		$controls->start_controls_section(
			'section_carousel_style',
			[
				'label' => esc_html__( 'Carousel Style', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'posts_layout' => 'carousel'
				],
			]
		);

			$controls->add_responsive_control(
				'slide_paddings',
				[
					'label' => esc_html__( 'Slide Padding', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__slide-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'horizontal_slide_height',
				[
					'label' => esc_html__( 'Height', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 100,
							'max' => 1000,
						],
						'vh' => [
							'min' => 10,
							'max' => 100,
						],
					],
					'default' => [
						'size' => 450,
					],
					'size_units' => [ 'px', 'vh', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts .swiper-slide' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'slider_direction' => 'horizontal'
					],
				]
			);

			$controls->add_responsive_control(
				'vertical_slide_height',
				[
					'label' => esc_html__( 'Height', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 100,
							'max' => 1000,
						],
						'vh' => [
							'min' => 10,
							'max' => 100,
						],
					],
					'default' => [
						'size' => 450,
					],
					'size_units' => [ 'px', 'vh', 'em' ],
					'render_type' => 'template',
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts .swiper-slide' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'slider_direction' => 'vertical'
					],
				]
			);

			$controls->add_responsive_control(
				'slide_content_max_width',
				[
					'label' => esc_html__( 'Content Width', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'size_units' => [ '%', 'px' ],
					'default' => [
						'size' => '100',
						'unit' => '%',
					],
					'tablet_default' => [
						'unit' => '%',
					],
					'mobile_default' => [
						'unit' => '%',
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__slide-container' => 'max-width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'slide_block_horizontal_alignment',
				[
					'label' => esc_html__( 'Horizontal Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'center',
					'toggle' => false,
					'options' => [
						'flex-start'    => [
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
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__slide-wrapper' => 'align-items: {{VALUE}};'
					]
				]
			);

			$controls->add_responsive_control(
				'slide_block_vertical_alignment',
				[
					'label' => esc_html__( 'Vertical Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'center',
					'toggle' => false,
					'options' => [
						'flex-start'    => [
							'title' => esc_html__( 'Top', 'stratum' ),
							'icon' => 'eicon-v-align-top',
						],
						'center' => [
							'title' => esc_html__( 'Middle', 'stratum' ),
							'icon' => 'eicon-v-align-middle',
						],
						'flex-end' => [
							'title' => esc_html__( 'Bottom', 'stratum' ),
							'icon' => 'eicon-v-align-bottom',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__slide-wrapper' => 'justify-content: {{VALUE}};'
					]
				]
			);

			$controls->add_control(
				'slide_animation_effect',
				[
					'label'   => esc_html__( 'Hover Animation Effect', 'stratum' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'none'   => esc_html__( 'None'  , 'stratum' ),
						'aries'  => esc_html__( 'Aries' , 'stratum' ),
						'taurus' => esc_html__( 'Taurus', 'stratum' ),
						'gemini' => esc_html__( 'Gemini', 'stratum' ),
						'cancer' => esc_html__( 'Cancer', 'stratum' ),
						'leo'    => esc_html__( 'Leo'   , 'stratum' ),
						'virgo'  => esc_html__( 'Virgo' , 'stratum' )
					]
				]
			);

			$controls->add_control(
				'slide_text_animation_effect',
				[
					'label'   => esc_html__( 'Text Animation Effect', 'stratum' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'none'    		   => esc_html__( 'None'  		 , 'stratum' ),
						'opacity' 		   => esc_html__( 'Fade In' 	 , 'stratum' ),
						'opacity-top'      => esc_html__( 'Fade In Up'	 , 'stratum' ),
						'opacity-bottom'   => esc_html__( 'Fade In Down' , 'stratum' ),
						'opacity-left'     => esc_html__( 'Fade In Left' , 'stratum' ),
						'opacity-right'    => esc_html__( 'Fade In Right', 'stratum' ),
						'opacity-zoom-in'  => esc_html__( 'Zoom In'      , 'stratum' ),
						'opacity-zoom-out' => esc_html__( 'Zoom Out' 	 , 'stratum' )
					],
					'condition' => [
						'columns_count' => '1',
						'slides_in_columns' => '1'
					],
				]
			);

			$controls->add_control(
				'slide_image_animation_speed',
				[
					'label' => esc_html__( 'Hover Image Animation Speed', 'stratum' ),
					'description' => esc_html__( 'In Seconds', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => 0.25,
					],
					'range' => [
						'px' => [
							'min' => 0.1,
							'max' => 2,
							'step' => 0.01,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts__image' => 'transition: all {{SIZE}}s linear',
						'{{WRAPPER}} .stratum-advanced-posts__overlay' => 'transition: all {{SIZE}}s linear',
					],
				]
			);

			$controls->add_control(
				'slide_text_animation_delay',
				[
					'label' => esc_html__( 'Text Animation Delay', 'stratum' ),
					'description' => esc_html__( 'In Milliseconds ', 'stratum' ),
					'type' => Controls_Manager::NUMBER,
					'default' => 500,
					'condition' => [
						'slide_text_animation_effect!' => 'none',
						'columns_count' => '1',
						'slides_in_columns' => '1'
					],
				]
			);

			$controls->add_control(
				'slide_text_animation_speed',
				[
					'label' => esc_html__( 'Text Animation Speed', 'stratum' ),
					'description' => esc_html__( 'In Seconds', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => 0.35,
					],
					'range' => [
						'px' => [
							'min' => 0.1,
							'max' => 3,
							'step' => 0.01,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts__slide-container' => 'transition: all {{SIZE}}s linear',
					],
					'condition' => [
						'slide_text_animation_effect!' => 'none',
						'columns_count' => '1',
						'slides_in_columns' => '1'
					],
				]
			);


			$controls->start_controls_tabs( 'slide_overlay_styles' );

				$controls->start_controls_tab(
					'slide_overlay_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$controls->add_control(
						'slide_images_overlay_color',
						[
							'label' => esc_html__( 'Overlay Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '#00000057',
							'default' => '#00000057',
							'render_type' => 'ui',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__overlay' => 'background-color: {{VALUE}}',
							],
						]
					);

					$controls->add_control(
						'slide_images_line_color',
						[
							'label' => esc_html__( 'Line Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '#fff',
							'default' => '#fff',
							'render_type' => 'ui',
							'condition' => [
								'slide_animation_effect!' => 'none'
							],
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__slide-wrapper:before' => 'border-color: {{VALUE}}',
								'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__slide-wrapper:after' => 'border-color: {{VALUE}}',
							],
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'slide_overlay_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'slide_images_overlay_color_hover',
						[
							'label' => esc_html__( 'Overlay Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '#0000008A',
							'default' => '#0000008A',
							'render_type' => 'ui',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts:hover .stratum-advanced-posts__overlay' => 'background-color: {{VALUE}}',
							],
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_grid_style',
			[
				'label' => esc_html__( 'Grid/List Style', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'posts_layout!' => 'carousel'
				],
			]
		);

			$controls->add_responsive_control(
				'column_gap',
				[
					'label' => esc_html__( 'Columns Gap', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => 20,
					],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .masonry-disable.layout-grid .stratum-advanced-posts__wrapper' => 'grid-column-gap: {{SIZE}}{{UNIT}}',
						'.elementor-msie {{WRAPPER}} .masonry-disable.layout-grid .stratum-advanced-posts__wrapper article' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
						'.elementor-msie {{WRAPPER}} .masonry-disable.layout-grid .stratum-advanced-posts__wrapper' => 'margin-left: calc( -{{SIZE}}{{UNIT}}/2 ); margin-right: calc( -{{SIZE}}{{UNIT}}/2 );',
					],
					'condition' => [
						'posts_layout' => 'grid',
						'columns!' => '1',
						'masonry!' => 'yes',
					],
				]
			);

			$controls->add_responsive_control(
				'row_gap',
				[
					'label' => esc_html__( 'Rows Gap', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => 20,
					],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .masonry-disable.layout-grid .stratum-advanced-posts__wrapper' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
						'.elementor-msie {{WRAPPER}} .masonry-disable.layout-grid .stratum-advanced-posts__wrapper article' => 'padding-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'posts_layout' => 'grid',
						'masonry!' => 'yes',
					],
				]
			);

			$controls->add_responsive_control(
				'list_gap',
				[
					'label' => esc_html__( 'List Gap', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => 20,
					],
					'tablet_default' => [
						'size' => 20,
					],
					'mobile_default' => [
						'size' => 20,
					],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'render_type' => 'ui',
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts.layout-list .stratum-advanced-posts__post:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'posts_layout' => 'list'
					],
				]
			);

			$controls->add_control(
				'list_checkerboard',
				[
					'label' => esc_html__( 'List Checkerboard', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'return_value' => 'checkerboard',
					'default' => '',
					'prefix_class' => 'stratum-list-',
					'condition' => [
						'posts_layout' => 'list'
					],
				]
			);

			$controls->add_control(
				'grid_checkerboard',
				[
					'label' => esc_html__( 'Grid Checkerboard', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'return_value' => 'checkerboard',
					'default' => '',
					'prefix_class' => 'stratum-grid-',
					'condition' => [
						'posts_layout' => 'grid',
						'columns!' => '1',
					],
				]
			);

			$controls->add_control(
				'checkerboard_order',
				[
					'label' => esc_html__( 'Checkerboard order', 'stratum' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'even',
					'prefix_class' => 'stratum-checkerboard-',
					'options' => [
						'odd' => esc_html__( 'Odd', 'stratum' ),
						'even' => esc_html__( 'Even', 'stratum' ),
					],
					'condition' => [
						'posts_layout' => 'grid',
						'columns!' => '1',
						'grid_checkerboard' => 'checkerboard',
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'box_border',
					'label' => esc_html__( 'Box Border', 'stratum' ),
					'selector' => '{{WRAPPER}} .stratum-advanced-posts.layout-grid .stratum-advanced-posts__post, {{WRAPPER}} .stratum-advanced-posts.layout-list .stratum-advanced-posts__post',
				]
			);

			$controls->add_control(
				'box_radius',
				[
					'label' => esc_html__( 'Box Border Radius', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'condition' => [
						'box_border_border!' => ''
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts.layout-grid .stratum-advanced-posts__post' => 'border-radius: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .stratum-advanced-posts.layout-list .stratum-advanced-posts__post' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$controls->add_control(
				'box_border_inner',
				[
					'label' => esc_html__( 'Inner border', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'return_value' => 'inner',
					'default' => '',
					'prefix_class' => 'stratum-list-border-',
					'condition' => [
						'box_border_border!' => '',
						'posts_layout' => 'list'
					],
					'separator' => 'after',
				]
			);

			$controls->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'box_shadow',
					'selector' => '{{WRAPPER}} .stratum-advanced-posts.layout-grid .stratum-advanced-posts__post, {{WRAPPER}} .stratum-advanced-posts.layout-list .stratum-advanced-posts__post',
				]
			);

			$controls->add_responsive_control(
				'box_paddings',
				[
					'label' => esc_html__( 'Box Padding', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts.layout-grid .stratum-advanced-posts__post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .stratum-advanced-posts.layout-list .stratum-advanced-posts__post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'content_paddings',
				[
					'label' => esc_html__( 'Content Padding', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts.layout-grid .stratum-advanced-posts__content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .stratum-advanced-posts.layout-list .stratum-advanced-posts__content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'content_min_height',
				[
					'label' => esc_html__( 'Content Min Height', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 100,
							'max' => 1000,
						],
						'vh' => [
							'min' => 10,
							'max' => 100,
						],
					],
					'size_units' => [ 'px', 'vh', 'em' ],
					'selectors' => [
						'{{WRAPPER}}.stratum-grid-checkerboard .stratum-advanced-posts.layout-grid .stratum-advanced-posts__content-wrapper' => 'min-height: calc( {{SIZE}}{{UNIT}} - {{image_spacing_bottom.SIZE}}{{image_spacing_bottom.UNIT}} );',
					],
					'condition' => [
						'posts_layout' => 'grid',
						'columns!' => '1',
						'grid_checkerboard' => 'checkerboard',
					],
				]
			);

			$controls->add_control(
				'animate_on_scroll',
				[
					'label' => esc_html__( 'Animate on scroll', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'default' => '',
					'condition' => [
						'posts_layout' => ['grid', 'list']
					],
				]
			);

			$controls->add_control(
				'animation_effects',
				[
					'label' => esc_html__( 'Animation Effect', 'stratum' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'effect-2',
					'options' => [
						'effect-1' => esc_html__( 'Opacity', 'stratum' ),
						'effect-2' => esc_html__( 'Move Up', 'stratum' ),
						'effect-3' => esc_html__( 'Scale up', 'stratum' ),
						'effect-4' => esc_html__( 'Fall perspective', 'stratum' ),
						'effect-5' => esc_html__( 'Fly', 'stratum' ),
						'effect-6' => esc_html__( 'Flip', 'stratum' ),
						'effect-7' => esc_html__( 'Helix', 'stratum' ),
						'effect-8' => esc_html__( 'Zoom In 3D', 'stratum' ),
					],
					'condition' => [
						'animate_on_scroll' => 'yes',
					],
				]
			);

			$controls->start_controls_tabs( 'box_styles' );

				$controls->start_controls_tab(
					'box_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$controls->add_control(
						'box_color_background',
						[
							'label' => esc_html__( 'Box Background Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '',
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts.layout-grid .stratum-advanced-posts__post' => 'background-color: {{VALUE}};',
								'{{WRAPPER}} .stratum-advanced-posts.layout-list .stratum-advanced-posts__post' => 'background-color: {{VALUE}};',
							],
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'box_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'box_color_background_hover',
						[
							'label' => esc_html__( 'Box Background Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '',
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts.layout-grid .stratum-advanced-posts__post:hover' => 'background-color: {{VALUE}};',
								'{{WRAPPER}} .stratum-advanced-posts.layout-list .stratum-advanced-posts__post:hover' => 'background-color: {{VALUE}};',
							],
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_image' => 'yes'
				],
			]
		);

		$controls->add_responsive_control(
			'slide_image_vertical_alignment',
			[
				'label' => esc_html__( 'Vertical Alignment', 'stratum' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'toggle' => false,
				'options' => [
					'top'    => [
						'title' => esc_html__( 'Top', 'stratum' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Middle', 'stratum' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'stratum' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .stratum-advanced-posts.layout-carousel .stratum-advanced-posts__post .stratum-advanced-posts__image' => 'background-position: {{VALUE}};',
				],
				'condition' => [
					'posts_layout' => 'carousel',
				],
			]
		);

		$controls->add_control(
			'slide_image_background_size',
			[
				'label' => esc_html__( 'Image Background Size', 'stratum' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'cover' => esc_html__( 'Cover', 'stratum' ),
					'initial' => esc_html__( 'Initial', 'stratum' ),
				],
				'default' => 'cover',
				'selectors' => [
					'{{WRAPPER}} .stratum-advanced-posts.layout-carousel .stratum-advanced-posts__post .stratum-advanced-posts__image' => 'background-size: {{VALUE}};',
				],
				'condition' => [
					'posts_layout' => 'carousel',
				],
			]
		);

		$controls->add_responsive_control(
			'image_alignment',
			[
				'label' => esc_html__( 'Alignment', 'stratum' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'left',
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
				'prefix_class' => 'stratum-list-image-',
				'condition' => [
					'posts_layout' => 'list',
					'list_checkerboard' => ''
				],
			]
		);

			$controls->add_control(
				'image_hover_effect',
				[
					'label'   => esc_html__( 'Hover Animation Effect', 'stratum' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'none'   => esc_html__( 'None'  , 'stratum' ),
						'aries'  => esc_html__( 'Aries' , 'stratum' ),
						'taurus' => esc_html__( 'Taurus', 'stratum' ),
						'gemini' => esc_html__( 'Gemini', 'stratum' ),
						'cancer' => esc_html__( 'Cancer', 'stratum' ),
						'leo'    => esc_html__( 'Leo'   , 'stratum' ),
						'virgo'  => esc_html__( 'Virgo' , 'stratum' )
					],
					'condition' => [
						'posts_layout' => ['grid', 'list']
					],
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

			$controls->add_responsive_control(
				'image_height',
				[
					'label' => esc_html__( 'Image Height', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 100,
							'max' => 1000,
						],
						'vh' => [
							'min' => 10,
							'max' => 100,
						],
					],
					'size_units' => [ 'px', 'vh', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts.layout-grid .stratum-advanced-posts__post-thumbnail img' => 'height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.stratum-grid-checkerboard.stratum-checkerboard-odd .stratum-advanced-posts.layout-grid .stratum-advanced-posts__post:nth-child(odd) .stratum-advanced-posts__post-thumbnail img' => 'height: calc( {{SIZE}}{{UNIT}}*2 );',
						'{{WRAPPER}}.stratum-grid-checkerboard.stratum-checkerboard-even .stratum-advanced-posts.layout-grid .stratum-advanced-posts__post:nth-child(even) .stratum-advanced-posts__post-thumbnail img' => 'height: calc( {{SIZE}}{{UNIT}}*2 );',
						'{{WRAPPER}} .stratum-advanced-posts.layout-list .stratum-advanced-posts__post-thumbnail img' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'posts_layout' => ['grid', 'list']
					],
				]
			);

			$controls->add_responsive_control(
				'image_width',
				[
					'label' => esc_html__( 'Image Width', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'%' => [
							'min' => 10,
							'max' => 100,
						],
						'px' => [
							'min' => 10,
							'max' => 600,
						],
					],
					'default' => [
						'size' => 50,
						'unit' => '%',
					],
					'tablet_default' => [
						'size' => '',
						'unit' => '%',
					],
					'mobile_default' => [
						'size' => 100,
						'unit' => '%',
					],
					'size_units' => [ '%', 'px' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts.layout-list .stratum-advanced-posts__post-thumbnail' => 'width: {{SIZE}}{{UNIT}};max-width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'posts_layout' => 'list'
					],
				]
			);

			$controls->add_responsive_control(
				'image_spacing_horizontal',
				[
					'label' => esc_html__( 'Spacing (Horizontal)', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}}.stratum-list-image-left .stratum-advanced-posts.layout-list .stratum-advanced-posts__post-thumbnail' => 'margin-right: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}}.stratum-list-image-right .stratum-advanced-posts.layout-list .stratum-advanced-posts__post-thumbnail' => 'margin-left: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}}.stratum-list-checkerboard .stratum-advanced-posts.layout-list .stratum-advanced-posts__post .stratum-advanced-posts__post-thumbnail' => 'margin-right: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}}.stratum-list-checkerboard .stratum-advanced-posts.layout-list .stratum-advanced-posts__post:nth-child(even) .stratum-advanced-posts__post-thumbnail' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0px;',
					],
					'condition' => [
						'posts_layout' => 'list'
					],
				]
			);

			$controls->add_responsive_control(
				'image_spacing_bottom',
				[
					'label' => esc_html__( 'Spacing (Bottom)', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'size' => 15,
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts.layout-grid .stratum-advanced-posts__post-thumbnail' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'posts_layout' => 'grid'
					],
				]
			);

			$controls->start_controls_tabs( 'image_overlay_styles', array(
				'condition' => [
					'posts_layout' => ['grid', 'list']
				],
			) );

				$controls->start_controls_tab(
					'image_overlay_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$controls->add_control(
						'image_overlay_opacity',
						[
							'label' => esc_html__( 'Overlay Opacity', 'stratum' ),
							'type' => Controls_Manager::SLIDER,
							'default' => [
								'size' => 0.1
							],
							'range' => [
								'px' => [
									'max' => 1,
									'min' => 0,
									'step' => 0.01
								]
							],
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts.layout-grid .stratum-advanced-posts__post .stratum-advanced-posts__post-thumbnail-overlay' => 'opacity: {{SIZE}};',
								'{{WRAPPER}} .stratum-advanced-posts.layout-list .stratum-advanced-posts__post .stratum-advanced-posts__post-thumbnail-overlay' => 'opacity: {{SIZE}};'
							],
							'condition' => [
								'posts_layout' => ['grid', 'list']
							],
						]
					);

					$controls->add_control(
						'image_overlay_line_color',
						[
							'label' => esc_html__( 'Line Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '#fff',
							'default' => '#fff',
							'render_type' => 'ui',
							'condition' => [
								'image_hover_effect!' => 'none'
							],
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts.layout-grid .stratum-advanced-posts__post .stratum-advanced-posts__post-thumbnail-overlay:before' => 'border-color: {{VALUE}}',
								'{{WRAPPER}} .stratum-advanced-posts.layout-grid .stratum-advanced-posts__post .stratum-advanced-posts__post-thumbnail-overlay:after' => 'border-color: {{VALUE}}',

								'{{WRAPPER}} .stratum-advanced-posts.layout-list .stratum-advanced-posts__post .stratum-advanced-posts__post-thumbnail-overlay:before' => 'border-color: {{VALUE}}',
								'{{WRAPPER}} .stratum-advanced-posts.layout-list .stratum-advanced-posts__post .stratum-advanced-posts__post-thumbnail-overlay:after' => 'border-color: {{VALUE}}',
							],
						]
					);

					$controls->add_control(
						'image_overlay_color',
						[
							'label'   => esc_html__( 'Overlay Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '#000',
							'value'   => '#000',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts.layout-grid .stratum-advanced-posts__post .stratum-advanced-posts__post-thumbnail-overlay' => 'background-color: {{VALUE}};',
								'{{WRAPPER}} .stratum-advanced-posts.layout-list .stratum-advanced-posts__post .stratum-advanced-posts__post-thumbnail-overlay' => 'background-color: {{VALUE}};'
							],
							'condition' => [
								'posts_layout' => ['grid', 'list']
							],
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'image_overlay_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'image_overlay_hover_opacity',
						[
							'label' => esc_html__( 'Overlay Opacity', 'stratum' ),
							'type' => Controls_Manager::SLIDER,
							'default' => [
								'size' => 0.15
							],
							'range' => [
								'px' => [
									'max' => 1,
									'min' => 0,
									'step' => 0.01
								]
							],
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts.layout-grid .stratum-advanced-posts__post:hover .stratum-advanced-posts__post-thumbnail-overlay' => 'opacity: {{SIZE}};',
								'{{WRAPPER}} .stratum-advanced-posts.layout-list .stratum-advanced-posts__post:hover .stratum-advanced-posts__post-thumbnail-overlay' => 'opacity: {{SIZE}};'
							],
							'condition' => [
								'posts_layout' => ['grid', 'list']
							],
						]
					);

					$controls->add_control(
						'image_overlay_hover_color',
						[
							'label'   => esc_html__( 'Overlay Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '#000',
							'value'   => '#000',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts.layout-grid .stratum-advanced-posts__post:hover .stratum-advanced-posts__post-thumbnail-overlay' => 'background-color: {{VALUE}};',
								'{{WRAPPER}} .stratum-advanced-posts.layout-list .stratum-advanced-posts__post:hover .stratum-advanced-posts__post-thumbnail-overlay' => 'background-color: {{VALUE}};'
							],
							'condition' => [
								'posts_layout' => ['grid', 'list']
							],
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_style_title',
			[
				'label' => esc_html__( 'Title', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => 'yes'
				],
			]
		);

			$controls->add_control(
				'title_over_image',
				[
					'label' => esc_html__( 'Title over image', 'stratum' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'stratum' ),
					'label_off' => esc_html__( 'No', 'stratum' ),
					'default' => '',
					'separator' => 'before',
					'condition' => [
						'show_image' => 'yes',
						'posts_layout' => ['grid', 'list']
					],
				]
			);

			$controls->add_responsive_control(
				'title_align',
				[
					'label' => esc_html__( 'Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'center',
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
						'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__post-title' => 'text-align: {{VALUE}};',
					],
				]
			);

			$controls->add_responsive_control(
				'title_spacing',
				[
					'label' => esc_html__( 'Spacing', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__post-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'title_over_image' => '',
					],
				]
			);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'selector' => '{{WRAPPER}} .stratum-advanced-posts__post-title',
					'label'	=> esc_html__( 'Typography', 'stratum' ),
					'render_type' => 'template',
					'defaults' => [
						'html_tag' => 'h3',
					],
				]
			);

			$controls->start_controls_tabs( 'title_styles' );

				$controls->start_controls_tab(
					'title_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$controls->add_control(
						'custom_title_color',
						[
							'label'   => esc_html__( 'Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '',
							'value'   => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__post-title' => 'color: {{VALUE}}',
								'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__post-title a' => 'color: {{VALUE}}',
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'title_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'custom_hover_title_color',
						[
							'label'   => esc_html__( 'Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '',
							'value'   => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__post .stratum-advanced-posts__post-title:hover' => 'color: {{VALUE}}',
								'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__post .stratum-advanced-posts__post-title:hover a' => 'color: {{VALUE}}',
								'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__post-thumbnail:hover .stratum-advanced-posts__post-title' => 'color: {{VALUE}}',
								'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__post-thumbnail:hover .stratum-advanced-posts__post-title a' => 'color: {{VALUE}}',
							]
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_style_meta_fields',
			[
				'label' => esc_html__( 'Meta Fields', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_meta!' => ''
				],
			]
		);

		$controls->add_responsive_control(
			'meta_fields_align',
			[
				'label' => esc_html__( 'Alignment', 'stratum' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'toggle' => false,
				'options' => [
					'flex-start'    => [
						'title' => esc_html__( 'Left', 'stratum' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'stratum' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'Right', 'stratum' ),
						'icon' => 'eicon-text-align-right',
					],
					'space-between' => [
						'title' => esc_html__( 'Justified', 'cryptop' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__wrapper .stratum-advanced-posts__post-wrapper .stratum-advanced-posts__content-wrapper .stratum-advanced-posts__entry-header .stratum-advanced-posts__entry-meta' => 'justify-content: {{VALUE}};',
				]
			]
		);

			$controls->add_responsive_control(
				'meta_fields_spacing',
				[
					'label' => esc_html__( 'Spacing', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__entry-meta' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'meta_fields_typography',
					'selector' => '{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__entry-meta',
					'label'	=> esc_html__( 'Typography', 'stratum' ),
					'render_type' => 'ui',
					'exclude' => ['html_tag']
				]
			);

			$controls->start_controls_tabs( 'meta_fields_styles' );

				$controls->start_controls_tab(
					'meta_fields_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$controls->add_control(
						'custom_meta_fields_color',
						[
							'label'   => esc_html__( 'Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '',
							'value'   => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__post .stratum-advanced-posts__entry-meta a' => 'color: {{VALUE}}',
							]
						]
					);

					$controls->add_control(
						'custom_meta_fields_divider_color',
						[
							'label'   => esc_html__( 'Divider Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '',
							'value'   => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__post .stratum-advanced-posts__entry-meta' => 'color: {{VALUE}}',
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'meta_fields_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'custom_hover_meta_fields_color',
						[
							'label'   => esc_html__( 'Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '',
							'value'   => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__post:hover .stratum-advanced-posts__entry-meta a' => 'color: {{VALUE}}',
							]
						]
					);

					$controls->add_control(
						'custom_hover_meta_fields_divider_color',
						[
							'label'   => esc_html__( 'Divider Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '',
							'value'   => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__post:hover .stratum-advanced-posts__entry-meta' => 'color: {{VALUE}}',
							]
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_content' => 'yes'
				],
			]
		);

			$controls->add_responsive_control(
				'content_align',
				[
					'label' => esc_html__( 'Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'center',
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
						'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__post-content' => 'text-align: {{VALUE}};',
					],
				]
			);

			$controls->add_responsive_control(
				'content_spacing',
				[
					'label' => esc_html__( 'Spacing', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__post-content' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'content_typography',
					'selector' => '{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__post-content',
					'label'	=> esc_html__( 'Typography', 'stratum' ),
					'render_type' => 'ui',
					'exclude' => ['html_tag']
				]
			);

			$controls->start_controls_tabs( 'content_styles' );

				$controls->start_controls_tab(
					'content_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$controls->add_control(
						'custom_content_color',
						[
							'label'   => esc_html__( 'Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '',
							'value'   => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__post .stratum-advanced-posts__post-content' => 'color: {{VALUE}}',
							]
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'content_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'custom_hover_content_color',
						[
							'label'   => esc_html__( 'Color', 'stratum' ),
							'type'    => Controls_Manager::COLOR,
							'default' => '',
							'value'   => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__post:hover .stratum-advanced-posts__post-content' => 'color: {{VALUE}}',
							]
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Read More', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_read_more' => 'yes'
				],
			]
		);

			$controls->add_responsive_control(
				'button_align',
				[
					'label' => esc_html__( 'Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'center',
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
						'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__read-more' => 'text-align: {{VALUE}};',
					],
				]
			);

			$controls->add_responsive_control(
				'button_spacing',
				[
					'label' => esc_html__( 'Spacing', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__read-more' => 'margin-top: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'button_typography',
					'selector' => '{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__read-more a',
					'label'	=> esc_html__( 'Typography', 'stratum' ),
					'render_type' => 'ui',
					'exclude' => ['html_tag']
				]
			);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'button_border',
					'label' => esc_html__( 'Border', 'stratum' ),
					'selector' => '{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__read-more a',
				]
			);

			$controls->add_control(
				'button_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'condition' => [
						'button_border_border!' => ''
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__read-more a' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'button_paddings',
				[
					'label' => esc_html__( 'Button Padding', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__read-more a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->start_controls_tabs( 'button_styles' );

				$controls->start_controls_tab(
					'button_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$controls->add_control(
						'button_color_font',
						[
							'label' => esc_html__( 'Button Font Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '',
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__read-more a' => 'color: {{VALUE}}',
							],
						]
					);

					$controls->add_control(
						'button_color_background',
						[
							'label' => esc_html__( 'Button Background Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '',
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__read-more a' => 'background-color: {{VALUE}};',
							],
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'button_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'button_color_font_hover',
						[
							'label' => esc_html__( 'Button Font Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '',
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__read-more a:hover' => 'color: {{VALUE}}',
							],
						]
					);
					$controls->add_control(
						'button_color_background_hover',
						[
							'label' => esc_html__( 'Button Background Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '',
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts .stratum-advanced-posts__read-more a:hover' => 'background-color: {{VALUE}};',
							],
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_style_load_more',
			[
				'label' => esc_html__( 'Load More (Pagination)', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'posts_layout' => ['grid', 'list'],
					'pagination' => 'yes',
					'page_pagination_style' => ['load_more_btn','load_more_scroll'],
				],
			]
		);

			$controls->add_control(
				'scroll_icon',
				[
					'label'   => esc_html__( 'Icon', 'stratum' ),
					'type'    => Controls_Manager::ICON,
					'default' => 'fa fa-chevron-down',
					'include' => [
						'fa fa-arrow-down',
						'fa fa-angle-down',
						'fa fa-chevron-down',
						'fa fa-long-arrow-down',
						'fa fa-chevron-circle-down',
						'fa fa-angle-double-down',
						'fa fa-arrow-circle-down',
						'fa fa-arrow-circle-o-down',
					],
					'label_block' => true,
					'condition' => [
						'page_pagination_style' => 'load_more_scroll'
					]
				]
			);

			$controls->add_control(
				'icon_size',
				[
					'label' => esc_html__( 'Icon size', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 5,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts .ajax_load_more_pagination .stratum-advanced-posts__ajax-load-more-arrow' => 'font-size: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'page_pagination_style' => 'load_more_scroll',
					],
				]
			);

			$controls->add_control(
				'icon_color',
				[
					'label' => esc_html__( 'Icon Color', 'stratum' ),
					'type' => Controls_Manager::COLOR,
					'value' => '',
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts .ajax_load_more_pagination .stratum-advanced-posts__ajax-load-more-arrow' => 'color: {{VALUE}}',
					],
					'condition' => [
						'page_pagination_style' => 'load_more_scroll',
					],
				]
			);

			$controls->add_responsive_control(
				'load_more_align',
				[
					'label' => esc_html__( 'Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'center',
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
					'condition' => [
						'page_pagination_style' => 'load_more_btn',
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts .ajax_load_more_pagination' => 'text-align: {{VALUE}};',
					],
				]
			);

			$controls->add_control(
				'load_more_spacing',
				[
					'label' => esc_html__( 'Spacing', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts .ajax_load_more_pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$controls->add_group_control(
				Stratum_Group_Control_Typography::get_type(),
				[
					'name' => 'load_more_typography',
					'selector' => '{{WRAPPER}} .stratum-advanced-posts .ajax_load_more_pagination a',
					'label'	=> esc_html__( 'Typography', 'stratum' ),
					'render_type' => 'ui',
					'exclude' => ['html_tag'],
					'condition' => [
						'page_pagination_style' => 'load_more_btn',
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'load_more_border',
					'label' => esc_html__( 'Border', 'stratum' ),
					'selector' => '{{WRAPPER}} .stratum-advanced-posts .ajax_load_more_pagination a',
					'condition' => [
						'page_pagination_style' => 'load_more_btn',
					],
				]
			);

			$controls->add_control(
				'load_more_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'condition' => [
						'load_more_border!' => '',
						'page_pagination_style' => 'load_more_btn',
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts .ajax_load_more_pagination a' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'load_more_paddings',
				[
					'label' => esc_html__( 'Button Padding', 'stratum' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'allowed_dimensions' => [ 'top', 'right', 'bottom', 'left' ],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts .ajax_load_more_pagination a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'page_pagination_style' => 'load_more_btn',
					],
				]
			);

			$controls->start_controls_tabs( 'load_more_styles', array(
				'condition' => [
					'page_pagination_style' => 'load_more_btn',
				],
			));

				$controls->start_controls_tab(
					'load_more_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$controls->add_control(
						'load_more_color_font',
						[
							'label' => esc_html__( 'Button Font Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '',
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts .ajax_load_more_pagination a' => 'color: {{VALUE}}',
							],
							'condition' => [
								'page_pagination_style' => 'load_more_btn',
							],
						]
					);

					$controls->add_control(
						'load_more_color_background',
						[
							'label' => esc_html__( 'Button Background Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '',
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts .ajax_load_more_pagination a' => 'background-color: {{VALUE}};',
							],
							'condition' => [
								'page_pagination_style' => 'load_more_btn',
							],
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'load_more_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'load_more_color_font_hover',
						[
							'label' => esc_html__( 'Button Font Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '',
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts .ajax_load_more_pagination a:hover' => 'color: {{VALUE}}',
							],
							'condition' => [
								'page_pagination_style' => 'load_more_btn',
							],
						]
					);
					$controls->add_control(
						'load_more_color_background_hover',
						[
							'label' => esc_html__( 'Button Background Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '',
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .stratum-advanced-posts .ajax_load_more_pagination a:hover' => 'background-color: {{VALUE}};',
							],
							'condition' => [
								'page_pagination_style' => 'load_more_btn',
							],
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

		$controls->end_controls_section();

		$controls->start_controls_section(
			'section_style_navigation_links',
			[
				'label' => esc_html__( 'Navigation (Pagination)', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'posts_layout' => ['grid', 'list'],
					'pagination' => 'yes',
					'page_pagination_style' => 'navigation',
				],
			]
		);

			$controls->add_responsive_control(
				'navigation_links_align',
				[
					'label' => esc_html__( 'Alignment', 'stratum' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'center',
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
						'{{WRAPPER}} .stratum-advanced-posts .navigation.pagination .nav-links' => 'text-align: {{VALUE}};',
					],
				]
			);

			$controls->add_control(
				'navigation_links_spacing',
				[
					'label' => esc_html__( 'Spacing', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-advanced-posts .navigation.pagination .nav-links' => 'margin-top: {{SIZE}}{{UNIT}}',
					],
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

Plugin::instance()->widgets_manager->register_widget_type( new Advanced_Posts() );