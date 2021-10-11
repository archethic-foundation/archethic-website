<?php
/**
 * Widget: Audio player for Local hosted audio and Soundcloud and other embeded audio
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

// Load widget
if (!function_exists('trx_addons_widget_audio_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_audio_load' );
	function trx_addons_widget_audio_load() {
		register_widget( 'trx_addons_widget_audio' );
	}
}

// Widget Class
class trx_addons_widget_audio extends TRX_Addons_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_audio', 'description' => esc_html__('Play audio from Soundcloud and other audio hostings or Local hosted audio', 'trx_addons') );
		parent::__construct( 'trx_addons_widget_audio', esc_html__('ThemeREX Audio player', 'trx_addons'), $widget_ops );
	}

	// Show widget
	function widget( $args, $instance ) {

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '' );
		$url = isset($instance['url']) ? $instance['url'] : '';
		$embed = isset($instance['embed']) ? str_replace("`", '"', $instance['embed']) : '';
		if (empty($url) && empty($embed)) return;
		$caption = isset($instance['caption']) ? $instance['caption'] : '';
		$author = isset($instance['author']) ? $instance['author'] : '';
		$cover = isset($instance['cover']) ? $instance['cover'] : '';
		if ($cover!='') $cover = trx_addons_get_attachment_url($cover, trx_addons_get_thumb_size('big'));

		trx_addons_get_template_part(TRX_ADDONS_PLUGIN_WIDGETS . 'audio/tpl.default.php',
									'trx_addons_args_widget_audio',
									apply_filters('trx_addons_filter_widget_args',
												array_merge($args, compact('title', 'url', 'embed', 'cover', 'caption', 'author')),
												$instance, 'trx_addons_widget_audio')
									);
	}

	// Update the widget settings.
	function update( $new_instance, $instance ) {
		$instance = array_merge($instance, $new_instance);
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['caption'] = strip_tags( $new_instance['caption'] );
		$instance['author'] = strip_tags( $new_instance['author'] );
		$instance['url'] = strip_tags( $new_instance['url'] );
		$instance['embed'] = trim( $new_instance['embed'] );
		$instance['cover'] = strip_tags( $new_instance['cover'] );
		return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_widget_audio');
	}

	// Displays the widget settings controls on the widget panel.
	function form( $instance ) {
		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
			'title' => '',
			'caption' => '',
			'author' => '',
			'cover' => '',
			'url' => '',
			'embed' => ''
			), 'trx_addons_widget_audio')
		);
		
		do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_widget_audio');
		
		$this->show_field(array('name' => 'title',
								'title' => __('Title:', 'trx_addons'),
								'value' => $instance['title'],
								'type' => 'text'));
		
		do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_widget_audio');
		
		$this->show_field(array('name' => 'caption',
								'title' => __('Caption:', 'trx_addons'),
								'value' => $instance['caption'],
								'type' => 'text'));
		
		$this->show_field(array('name' => 'author',
								'title' => __('Author:', 'trx_addons'),
								'value' => $instance['author'],
								'type' => 'text'));

		$this->show_field(array('name' => 'cover',
								'title' => __('Cover image URL:<br />(leave empty if you not need the cover)', 'trx_addons'),
								'value' => $instance['cover'],
								'type' => 'image'));

		$this->show_field(array('name' => 'url',
								'title' => __('Select local hosted audio:', 'trx_addons'),
								'value' => $instance['url'],
								'type' => 'audio'));

		$this->show_field(array('name' => 'embed',
								'title' => __('or paste HTML code to embed audio:', 'trx_addons'),
								'value' => $instance['embed'],
								'type' => 'textarea'));
		
		do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_widget_audio');
	}
}

	
// Merge widget specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_audio_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_widget_audio_merge_styles');
	function trx_addons_widget_audio_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'audio/_audio.scss';
		return $list;
	}
}



// trx_widget_audio
//-------------------------------------------------------------
/*
[trx_widget_audio id="unique_id" title="Widget title" embed="HTML code" cover="image url"]
*/
if ( !function_exists( 'trx_addons_sc_widget_audio' ) ) {
	function trx_addons_sc_widget_audio($atts, $content=null){	
		$atts = trx_addons_sc_prepare_atts('trx_widget_audio', $atts, array(
			// Individual params
			'title' => '',
			'caption' => '',
			'author' => '',
			'url' => '',
			'embed' => '',
			'cover' => '',
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);
		if (!empty($atts['embed']) && function_exists('vc_value_from_safe')) 
			$atts['embed'] = trim( vc_value_from_safe( $atts['embed'] ) );
		extract($atts);
		$type = 'trx_addons_widget_audio';
		$output = '';
		global $wp_widget_factory;
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
			$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
							. ' class="widget_area sc_widget_audio' 
								. (trx_addons_exists_visual_composer() ? ' vc_widget_audio wpb_content_element' : '') 
								. (!empty($class) ? ' ' . esc_attr($class) : '') 
								. '"'
							. ($css ? ' style="'.esc_attr($css).'"' : '')
						. '>';
			ob_start();
			the_widget( $type, $atts, trx_addons_prepare_widgets_args($id ? $id.'_widget' : 'widget_audio', 'widget_audio') );
			$output .= ob_get_contents();
			ob_end_clean();
			$output .= '</div>';
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_widget_audio', $atts, $content);
	}
}


// Add [trx_widget_audio] in the VC shortcodes list
if (!function_exists('trx_addons_sc_widget_audio_add_in_vc')) {
	function trx_addons_sc_widget_audio_add_in_vc() {
		
		add_shortcode("trx_widget_audio", "trx_addons_sc_widget_audio");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_widget_audio", 'trx_addons_sc_widget_audio_add_in_vc_params');
		class WPBakeryShortCode_Trx_Widget_Audio extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_widget_audio_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_widget_audio_add_in_vc_params')) {
	function trx_addons_sc_widget_audio_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_widget_audio",
				"name" => esc_html__("Audio player", 'trx_addons'),
				"description" => wp_kses_data( __("Insert widget with embedded audio from popular audio hosting: SoundCloud, etc. or with local hosted audio", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_widget_audio',
				"class" => "trx_widget_audio",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "title",
							"heading" => esc_html__("Widget title", 'trx_addons'),
							"description" => wp_kses_data( __("Title of the widget", 'trx_addons') ),
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "url",
							"heading" => esc_html__("Audio URL", 'trx_addons'),
							"description" => wp_kses_data( __("URL for local hosted audio file", 'trx_addons') ),
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "embed",
							"heading" => esc_html__("Embed code", 'trx_addons'),
							"description" => wp_kses_data( __("or paste HTML code to embed audio", 'trx_addons') ),
							"type" => "textarea_safe"
						),
						array(
							"param_name" => "caption",
							"heading" => esc_html__("Audio caption", 'trx_addons'),
							"description" => wp_kses_data( __("Caption of this audio", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"admin_label" => true,
							"type" => "textfield"
						),
						array(
							"param_name" => "author",
							"heading" => esc_html__("Author name", 'trx_addons'),
							"description" => wp_kses_data( __("Name of the author", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"type" => "textfield"
						),
						array(
							"param_name" => "cover",
							"heading" => esc_html__("Cover image", 'trx_addons'),
							"description" => wp_kses_data( __("Select or upload cover image or write URL from other site", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"type" => "attach_image"
						)
					),
					trx_addons_vc_add_id_param()
				)
			), 'trx_widget_audio' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_widget_audio_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_widget_audio_add_in_elementor' );
	function trx_addons_sc_widget_audio_add_in_elementor() {
		class TRX_Addons_Elementor_Widget_Audio extends TRX_Addons_Elementor_Widget {

			/**
			 * Widget base constructor.
			 *
			 * Initializing the widget base class.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @param array      $data Widget data. Default is an empty array.
			 * @param array|null $args Optional. Widget default arguments. Default is null.
			 */
			public function __construct( $data = [], $args = null ) {
				parent::__construct( $data, $args );
				$this->add_plain_params([
					'cover' => 'url'
				]);
			}

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_widget_audio';
			}

			/**
			 * Retrieve widget title.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget title.
			 */
			public function get_title() {
				return __( 'Widget: Audio', 'trx_addons' );
			}

			/**
			 * Retrieve widget icon.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget icon.
			 */
			public function get_icon() {
				return 'eicon-posts-ticker';
			}

			/**
			 * Retrieve the list of categories the widget belongs to.
			 *
			 * Used to determine where to display the widget in the editor.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return array Widget categories.
			 */
			public function get_categories() {
				return ['trx_addons-widgets'];
			}

			/**
			 * Register widget controls.
			 *
			 * Adds different input fields to allow the user to change and customize the widget settings.
			 *
			 * @since 1.6.41
			 * @access protected
			 */
			protected function _register_controls() {
				$this->start_controls_section(
					'section_sc_audio',
					[
						'label' => __( 'Widget: Audio', 'trx_addons' ),
					]
				);
				
				$this->add_control(
					'title',
					[
						'label' => __( 'Title', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Widget title", 'trx_addons' ),
						'default' => ''
					]
				);
				
				$this->add_control(
					'url',
					[
						'label' => __( 'URL', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( 'http://audio.url', 'trx_addons' ),
					]
				);

				$this->add_control(
					'embed',
					[
						'label' => __( 'Embed code', 'trx_addons' ),
						'label_block' => true,
						'description' => wp_kses_data( __("Paste HTML code to embed audio (to use it instead URL from the field above)", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::TEXTAREA,
						'default' => '',
						'rows' => 10,
					]
				);
				
				$this->add_control(
					'caption',
					[
						'label' => __( 'Audio caption', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Caption", 'trx_addons' ),
						'default' => ''
					]
				);
				
				$this->add_control(
					'author',
					[
						'label' => __( 'Author', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Author name", 'trx_addons' ),
						'default' => ''
					]
				);

				$this->add_control(
					'cover',
					[
						'label' => __( 'Cover image', 'trx_addons' ),
						'label_block' => true,
						'type' => \Elementor\Controls_Manager::MEDIA,
						'default' => [
							'url' => '',
						]
					]
				);

				$this->end_controls_section();
			}

			/**
			 * Render widget's template for the editor.
			 *
			 * Written as a Backbone JavaScript template and used to generate the live preview.
			 *
			 * @since 1.6.41
			 * @access protected
			 */
			protected function _content_template() {
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_WIDGETS . "audio/tpe.audio.php",
										'trx_addons_args_widget_audio',
										array('element' => $this)
									);
			}
		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Audio() );
	}
}
?>