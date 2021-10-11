<?php
/**
 * Class: Testimonial_Carousel
 * Name: Testimonial Carousel
 * Slug: stratum-testimonial-carousel
 */

namespace Stratum;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Core\Schemes;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Testimonial_Carousel extends Stratum_Widget_Base {
	protected $widget_name = 'testimonial-carousel';

	public $default_arrows_color = '#7a7a7a';

	public function __construct($data = [], $args = null) {
		parent::__construct( $data, $args );
	}

	public function get_title() {
		return esc_html__( 'Testimonial Carousel', 'stratum' );
	}

	public function get_script_depends() {
		return [
			'swiper'
        ];
    }

	public function get_icon() {
		return 'stratum-icon-testimonial-carousel';
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

		$repeater = new Repeater();

		$repeater->add_control(
			'content',
			[
				'label' => esc_html__( 'Content', 'stratum' ),
				'type'  => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'default' => esc_html__( 'Type your content here...', 'stratum' )
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
				'dynamic' => [ 'active' => true ]
			]
		);

		$repeater->add_control(
			'image_size',
			[
				'type'    => 'select',
				'label'   => esc_html__( 'Image Size', 'stratum' ),
				'default' => 'full',
				'options' => Stratum::get_instance()->get_scripts_manager()->get_image_sizes()
			]
		);

		$repeater->add_control(
			'heading',
			[
				'label' => esc_html__( 'Heading', 'stratum' ),
				'type'  => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'placeholder' => esc_html__( 'Write heading...', 'stratum' )
			]
		);

		$repeater->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'stratum' ),
				'type'  => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
				'placeholder' => esc_html__( 'Write subtitle...', 'stratum' )
			]
		);

        $controls->add_control(
			'slides',
			[
				'label'   => 'Slides',
                'type'    => Controls_Manager::REPEATER,
                'separator' => 'after',
				'default' => [
					[
						'heading' => esc_html__( 'Title', 'stratum' ),
						'subtitle' => esc_html__( 'Subtitle', 'stratum' ),
						'content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'stratum' )
					],
					[
						'heading' => esc_html__( 'Title', 'stratum' ),
						'subtitle' => esc_html__( 'Subtitle', 'stratum' ),
						'content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'stratum' )
					],
					[
						'heading' => esc_html__( 'Title', 'stratum' ),
						'subtitle' => esc_html__( 'Subtitle', 'stratum' ),
						'content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'stratum' )
					],
				],
				'fields' => $repeater->get_controls()
			]
        );

        $controls->add_responsive_control(
			'alignment',
			[
				'label' => esc_html__( 'Alignment', 'stratum' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'stratum' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'stratum' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'stratum' ),
						'icon' => 'eicon-text-align-right',
					],
				],
                'prefix_class' => 'stratum-testimonial-carousel-align%s-',
                'separator' => 'before'
			]
        );

        $controls->add_responsive_control(
			'slider_width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Slider Width', 'stratum' ),
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1140
					],
					'%' => [
						'min' => 50
					],
				],
				'size_units' => [ '%', 'px' ],
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
					'size' => 100,
				],
				'mobile_default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .stratum-testimonial-carousel .stratum-testimonial-carousel__container' => 'max-width: {{SIZE}}{{UNIT}};'
				],
			]
		);

        $controls->add_responsive_control(
			'content_width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Content Width', 'stratum' ),
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1140
					],
					'%' => [
						'min' => 50
					],
				],
				'size_units' => [ '%', 'px' ],
				'default' => [
					'unit' => '%'
				],
				'tablet_default' => [
					'unit' => '%',
					'size' => 100,
				],
				'mobile_default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .stratum-testimonial-carousel .stratum-testimonial-carousel__content' => 'max-width: {{SIZE}}{{UNIT}};'
				],
			]
		);

        $controls->end_controls_section();

        $controls->start_controls_section(
			'section_slides_style',
			[
				'label' => esc_html__( 'Slides', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
        );

        $controls->add_control(
			'slide_background_color',
			[
				'label' => esc_html__( 'Background Color', 'stratum' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .stratum-main-swiper .swiper-slide .stratum-testimonial-carousel__container' => 'background-color: {{VALUE}}'
				],
			]
		);

		$controls->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'slide_box_shadow',
				'selector' => '{{WRAPPER}} .stratum-main-swiper .swiper-slide .stratum-testimonial-carousel__container',
			]
		);

		$controls->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'slide_box_border',
				'label' => esc_html__( 'Box Border', 'stratum' ),
				'selector' => '{{WRAPPER}} .stratum-main-swiper .swiper-slide .stratum-testimonial-carousel__container',
				'separator' => 'before'
			]
		);

        $controls->add_control(
			'slide_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'stratum' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'%' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .stratum-main-swiper .swiper-slide .stratum-testimonial-carousel__container' => 'border-radius: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'slide_box_border_border!' => ''
				],
			]
        );

		$controls->add_responsive_control(
			'slide_padding',
			[
				'label' => esc_html__( 'Padding', 'stratum' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .stratum-main-swiper .swiper-slide .stratum-testimonial-carousel__container-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				],
				'separator' => 'before'
			]
		);

		$controls->add_responsive_control(
			'slide_margin',
			[
				'label' => esc_html__( 'Margin', 'stratum' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .stratum-main-swiper .swiper-slide .stratum-testimonial-carousel__wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
				],
				'separator' => 'before'
			]
		);

        $controls->end_controls_section();

        $controls->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'stratum' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$controls->add_control(
			'image_style',
			[
				'label' => esc_html__( 'Image', 'stratum' ),
				'type' => Controls_Manager::HEADING,
			]
        );

		$controls->add_responsive_control(
			'image_spacing',
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
					'{{WRAPPER}} .stratum-testimonial-carousel__footer' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$controls->add_control(
			'heading_style',
			[
				'label' => esc_html__( 'Heading', 'stratum' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$controls->add_responsive_control(
			'heading_spacing',
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
					'{{WRAPPER}} .stratum-testimonial-carousel__heading' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$controls->add_control(
			'heading_color',
			[
				'label' => esc_html__( 'Text Color', 'stratum' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .stratum-testimonial-carousel__heading' => 'color: {{VALUE}}'
				],
			]
		);

		$controls->add_group_control(
			Stratum_Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'selector' => '{{WRAPPER}} .stratum-testimonial-carousel__heading',
				'label'	=> esc_html__( 'Heading Typography', 'stratum' ),
				'render_type' => 'template',
				'defaults' => [
					'html_tag' => 'h3',
				],
			]
		);

		$controls->add_control(
			'subtitle_style',
			[
				'label' => esc_html__( 'Subtitle', 'stratum' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
        );

		$controls->add_responsive_control(
			'subtitle_spacing',
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
					'{{WRAPPER}} .stratum-testimonial-carousel__subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

        $controls->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Text Color', 'stratum' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .stratum-testimonial-carousel__subtitle' => 'color: {{VALUE}}'
				],
			]
		);

		$controls->add_group_control(
			Stratum_Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .stratum-testimonial-carousel__subtitle',
				'label'	=> esc_html__( 'Subtitle Typography', 'stratum' ),
				'render_type' => 'template',
				'defaults' => [
					'html_tag' => 'span',
				],
			]
		);

		$controls->add_control(
			'content_style',
			[
				'label' => esc_html__( 'Content', 'stratum' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
        );

        $controls->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Text Color', 'stratum' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .stratum-testimonial-carousel__text' => 'color: {{VALUE}}'
				],
			]
        );

        $controls->add_group_control(
			Stratum_Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .stratum-testimonial-carousel__text',
				'label'	=> esc_html__( 'Text Typography', 'stratum' ),
				'render_type' => 'template'
			]
		);

        $controls->end_controls_section();

        $sections = new \Stratum\Sections( $this );
        $sections->advanced_carousel(
			[
				'settings'   => Controls_Manager::TAB_CONTENT,
				'navigation' => Controls_Manager::TAB_STYLE
			],
			[],
			[
				'mousewheel_control',
				'slides_to_scroll',
				'dynamic_bullets',
			]
		);
	}

    protected function render() {
		$this->render_widget( 'php' );
    }

    protected function content_template() {}
	public function render_plain_content( $instance = [] ) {}
}

Plugin::instance()->widgets_manager->register_widget_type( new Testimonial_Carousel() );