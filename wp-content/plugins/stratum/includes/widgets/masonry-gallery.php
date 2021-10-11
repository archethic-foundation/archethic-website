<?php
/**
 * Class: Images_Masonry
 * Name: Images Masonry
 * Slug: masonry-gallery
 */

namespace Stratum;

use \Elementor\Controls_Manager;
use \Elementor\Utils;
use \Elementor\Plugin;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Images_Masonry extends Stratum_Widget_Base {
    protected $widget_name = 'masonry-gallery';

    public function __construct($data = [], $args = null) {
        parent::__construct( $data, $args );
    }

	public function get_title() {
		return esc_html__( 'Masonry Gallery', 'stratum' );
	}

    public function get_script_depends() {
        return [
			'jquery-masonry',
			'anim-on-scroll',
			'modernizr-custom'
		];
	}

	public function get_style_depends() {
		return [
			'scroll-anim-effects'
		];
	}

	public function get_icon() {
		return 'stratum-icon-masonry-gallery';
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
			'section_general',
			[
				'label' => esc_html__( 'General', 'stratum' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

			$controls->add_control(
				'gallery_images',
				[
					'label' => esc_html__( 'Gallery', 'stratum' ),
					'type' => Controls_Manager::GALLERY,
					'default' => [],
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
				'image_size',
				[
					'type'    => 'select',
					'label'   => esc_html__( 'Image Size', 'stratum' ),
					'default' => 'full',
					'options' => Stratum::get_instance()->get_scripts_manager()->get_image_sizes()
				]
			);

			$controls->add_control(
				'animate_on_scroll',
				[
					'label' => esc_html__( 'Animate on scroll', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'default' => 'no',
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

			$controls->add_control(
				'gallery_columns',
				[
					'label' => esc_html__( 'Columns', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => 2,
					],
					'range' => [
						'px' => [
							'min' => 2,
							'max' => 10,
							'step' => 1,
						],
					],
				]
			);

			$controls->add_control(
				'gutter',
				[
					'label' => esc_html__( 'Gutter', 'stratum' ),
					'description' => esc_html__( 'In Pixels (px)', 'stratum' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'size' => 2,
					],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 30,
							'step' => 1,
						],
					],
				]
			);

			$controls->add_control(
				'image_animation_speed',
				[
					'label' => esc_html__( 'Hover Animation Speed', 'stratum' ),
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
						'{{WRAPPER}} .stratum-masonry-gallery__image'   => 'transition: all {{SIZE}}s linear',
						'{{WRAPPER}} .stratum-masonry-gallery__overlay' => 'transition: all {{SIZE}}s linear',
						'{{WRAPPER}} .stratum-masonry-gallery__caption' => 'transition: all {{SIZE}}s linear',
					],
				]
			);

			$controls->add_control(
				'zoom_effect',
				[
					'prefix_class' => 'stratum-masonry-gallery-effect-',
					'return_value' => 'zoom',
					'label' => esc_html__( 'Zoom on hover', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'default' => 'no',
				]
			);

			$controls->add_control(
				'grayscale_effect',
				[
					'prefix_class' => 'stratum-masonry-gallery-effect-',
					'return_value' => 'grayscale',
					'label' => esc_html__( 'Colorize on hover', 'stratum' ),
					'type'  => Controls_Manager::SWITCHER,
					'default' => 'no',
				]
			);

			$controls->start_controls_tabs( 'overlay_styles' );

				$controls->start_controls_tab(
					'overlay_normal',
					array(
						'label' => esc_html__( 'Normal', 'stratum' ),
					)
				);

					$controls->add_control(
						'images_overlay_color',
						[
							'label' => esc_html__( 'Overlay Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '#00000078',
							'default' => '#00000078',
							'render_type' => 'ui',
							'selectors' => [
								'{{WRAPPER}} .stratum-masonry-gallery__item .stratum-masonry-gallery__overlay' => 'background-color: {{VALUE}}',
							],
						]
					);

				$controls->end_controls_tab();

				$controls->start_controls_tab(
					'overlay_hover',
					array(
						'label' => esc_html__( 'Hover', 'stratum' ),
					)
				);

					$controls->add_control(
						'images_overlay_color_hover',
						[
							'label' => esc_html__( 'Overlay Color', 'stratum' ),
							'type' => Controls_Manager::COLOR,
							'value' => '#00000000',
							'default' => '#00000000',
							'render_type' => 'ui',
							'selectors' => [
								'{{WRAPPER}} .stratum-masonry-gallery__item:hover .stratum-masonry-gallery__overlay' => 'background-color: {{VALUE}}',
							],
						]
					);

				$controls->end_controls_tab();

			$controls->end_controls_tabs();

        $controls->end_controls_section();

        $controls->start_controls_section(
			'section_caption',
			[
				'label' => esc_html__( 'Caption', 'stratum' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$controls->add_responsive_control(
				'caption_padding',
				[
					'label'	     => __( 'Padding', 'stratum' ),
					'type'	     => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .stratum-masonry-gallery__item .stratum-masonry-gallery__caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$controls->add_responsive_control(
				'caption_horizontal_align',
				[
					'label'   => esc_html__( 'Horizontal Alignment', 'stratum' ),
					'type'    => Controls_Manager::CHOOSE,
					'default' => 'center',
					'toggle'  => false,
					'options' => [
						'left'      => [
							'title' => esc_html__( 'Left', 'stratum' ),
							'icon'  => 'fa fa-align-left',
						],
						'center'    => [
							'title' => esc_html__( 'Center', 'stratum' ),
							'icon'  => 'fa fa-align-center',
						],
						'right' 	=> [
							'title' => esc_html__( 'Right', 'stratum' ),
							'icon'  => 'fa fa-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-masonry-gallery__item .stratum-masonry-gallery__caption' => 'text-align: {{VALUE}};',
					],
				]
			);

			$controls->add_responsive_control(
				'caption_vertical_align',
				[
					'label'   => esc_html__( 'Vertical Alignment', 'stratum' ),
					'type'    => Controls_Manager::CHOOSE,
					'default' => 'bottom',
					'toggle'  => false,
					'options' => [
						'top'	  	  => [
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
					'selectors_dictionary' => [
						'top'    => 'top: 0; bottom: 0;',
						'middle' => 'top: 50%; bottom: 0;',
						'bottom' => 'bottom: 0; top: unset;',
					],
					'selectors' => [
						'{{WRAPPER}} .stratum-masonry-gallery__item .stratum-masonry-gallery__caption' => '{{VALUE}}',
					],
				]
			);

			$controls->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     		 => 'background',
					'types'    		 => [ 'classic', 'gradient' ],
					'exclude'		 => [ 'image' ],
					'selector' 		 => '{{WRAPPER}} .stratum-masonry-gallery__item .stratum-masonry-gallery__caption',
				]
			);

			$controls->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'        => 'caption_typography',
					'selector'    => '{{WRAPPER}} .stratum-masonry-gallery__item .stratum-masonry-gallery__caption',
					'label'	      => esc_html__( 'Typography', 'stratum' ),
				]
			);

			$controls->add_control(
				'caption_color',
				[
					'label'     => __( 'Text Color', 'stratum' ),
					'type' 	    => Controls_Manager::COLOR,
					'default'   => '#FFFFFF',
					'value'     => '',
					'selectors' => [
						'{{WRAPPER}} .stratum-masonry-gallery__item .stratum-masonry-gallery__caption' => 'color: {{VALUE}}',
					]
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

	public function _get_image_attributes( $id ) {
		$attachment = get_post( $id );
		$image_data = [
			'alt' 	  	  => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
			'caption'     => $attachment->post_excerpt,
			'description' => $attachment->post_content,
			'title' 	  => $attachment->post_title,
		];

		return $image_data;
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Images_Masonry() );
