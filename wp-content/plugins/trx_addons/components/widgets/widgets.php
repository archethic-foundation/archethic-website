<?php
/**
 * ThemeREX Widgets
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.1
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}

// Define list with widgets
if (!function_exists('trx_addons_widgets_setup')) {
	add_action( 'after_setup_theme', 'trx_addons_widgets_setup', 2 );
	function trx_addons_widgets_setup() {
		static $loaded = false;
		if ($loaded) return;
		$loaded = true;
		global $TRX_ADDONS_STORAGE;
		$TRX_ADDONS_STORAGE['widgets_list'] = apply_filters('trx_addons_widgets_list', array(
			'aboutme' => array(
							'title' => __('About Me', 'trx_addons')
						),
			'audio' => array(
							'title' => __('Audio player', 'trx_addons')
						),
			'banner' => array(
							'title' => __('Banner', 'trx_addons')
						),
			'calendar' => array(
							'title' => __('Calendar', 'trx_addons')
						),
			'categories_list' => array(
							'title' => __('Categories list', 'trx_addons'),
							'layouts_sc' => array(
								1 => esc_html__('Style 1'),
								2 => esc_html__('Style 2'),
								3 => esc_html__('Style 3')
							)
						),
			'contacts' => array(
							'title' => __('Contacts', 'trx_addons')
						),
			'flickr' => array(
							'title' => __('Flickr', 'trx_addons')
						),
			'popular_posts' => array(
							'title' => __('Popular posts', 'trx_addons')
						),
			'recent_news' => array(
							'title' => __('Recent news', 'trx_addons'),
							'layouts_sc' => array(
								'news-announce'	=> esc_html__('Announce',	'trx_addons'),
								'news-excerpt'	=> esc_html__('Excerpt',	'trx_addons'),
								'news-magazine'	=> esc_html__('Magazine',	'trx_addons'),
								'news-portfolio'=> esc_html__('Portfolio',	'trx_addons')
							)
						),
			'recent_posts' => array(
							'title' => __('Recent posts', 'trx_addons')
						),
			'slider' => array(
							'title' => __('Slider', 'trx_addons'),
							'layouts_sc' => array(
								'default' => esc_html__('Default', 'trx_addons'),
								'modern' => esc_html__('Modern', 'trx_addons')
							),
							// Always enabled!!!
							'std' => 1,
							'hidden' => false
						),
			'socials' => array(
							'title' => __('Social icons', 'trx_addons')
						),
			'twitter' => array(
							'title' => __('Twitter feed', 'trx_addons'),
							'layouts_sc' => array(
								'list' => esc_html__('List', 'trx_addons'),
								'default' => esc_html__('Default', 'trx_addons')
							)
						),
			'video' => array(
							'title' => __('Video player', 'trx_addons'),
							// Always enabled!!!
							'std' => 1,
							'hidden' => false
						)
			)
		);
	}
}

// Include files with widgets
if (!function_exists('trx_addons_widgets_load')) {
	add_action( 'after_setup_theme', 'trx_addons_widgets_load', 6 );
	function trx_addons_widgets_load() {
		static $loaded = false;
		if ($loaded) return;
		$loaded = true;
		// Get theme-specific widget's args (if need)
		global $TRX_ADDONS_STORAGE;
		$TRX_ADDONS_STORAGE['widgets_args'] = apply_filters('trx_addons_widgets_args', $TRX_ADDONS_STORAGE['widgets_args']);
		if (is_array($TRX_ADDONS_STORAGE['widgets_list']) && count($TRX_ADDONS_STORAGE['widgets_list']) > 0) {
			foreach ($TRX_ADDONS_STORAGE['widgets_list'] as $w=>$params) {
				if (trx_addons_components_is_allowed('widgets', $w)
					&& ($fdir = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_WIDGETS . "{$w}/{$w}.php")) != '') { 
					include_once $fdir;
				}
			}
		}
	}
}



// Add 'Widgets' block in the ThemeREX Addons Components
if (!function_exists('trx_addons_widgets_components')) {
	add_filter( 'trx_addons_filter_components_blocks', 'trx_addons_widgets_components');
	function trx_addons_widgets_components($blocks=array()) {
		$blocks['widgets'] = __('Widgets', 'trx_addons');
		return $blocks;
	}
}



/* Widgets utilities
------------------------------------------------------------------------------------- */

// Prepare widgets args - substitute id and class in parameter 'before_widget'
if (!function_exists('trx_addons_prepare_widgets_args')) {
	function trx_addons_prepare_widgets_args($id, $class, $args=false) {
		if ($args === false) {
			global $TRX_ADDONS_STORAGE;
			$args = $TRX_ADDONS_STORAGE['widgets_args'];
		}
		if (!empty($args['before_widget'])) $args['before_widget'] = str_replace(array('%1$s', '%2$s'), array($id, $class), $args['before_widget']);
		return $args;
	}
}



// Custom Widgets areas
//--------------------------------------------------------------------

// Add Form to register a new custom widgets area
if (!function_exists('trx_addons_widgets_add_form')) {
	add_action('widgets_admin_page', 'trx_addons_widgets_add_form');
	function trx_addons_widgets_add_form() {
		?><div class="trx_addons_widgets_form_wrap">
			<h2 class="trx_addons_widgets_form_title"><?php esc_html_e('Add custom widgets area', 'trx_addons'); ?></h2>
			<form class="trx_addons_widgets_form" method="post">
				<?php wp_nonce_field( 'trx_addons_action_create_widgets_area', 'trx_addons_widgets_wpnonce' ); ?>
				<div class="trx_addons_widgets_area_name">
					<div class="trx_addons_widgets_area_label"><?php esc_html_e('Name (required):', 'trx_addons'); ?></div>
					<div class="trx_addons_widgets_area_field"><input name="trx_addons_widgets_area_name" value="" type="text"></div>
				</div>
				<div class="trx_addons_widgets_area_description">
					<div class="trx_addons_widgets_area_label"><?php esc_html_e('Description:', 'trx_addons'); ?></div>
					<div class="trx_addons_widgets_area_field"><input name="trx_addons_widgets_area_description" value="" type="text"></div>
				</div>
				<div class="trx_addons_widgets_area_submit">
					<div class="trx_addons_widgets_area_field">
						<input value="<?php esc_html_e('Add', 'trx_addons'); ?>" class="trx_addons_widgets_area_button trx_addons_widgets_area_add button-primary" type="submit" title="<?php esc_html_e('To create new widgets area specify it name (required) and description (optional) and press this button', 'trx_addons'); ?>">
						<input value="<?php esc_html_e('Delete', 'trx_addons'); ?>" class="trx_addons_widgets_area_button trx_addons_widgets_area_delete button" name="trx_addons_widgets_area_delete" type="submit" title="<?php esc_html_e('To delete custom widgets area specify it name (required) and press this button', 'trx_addons'); ?>">
					</div>
				</div>
			</form>
		</div><?php
	}
}

// Create a new custom widgets area
if (!function_exists('trx_addons_widgets_create_sidebar')) {
	add_action('widgets_init', 'trx_addons_widgets_create_sidebar', 2);
	function trx_addons_widgets_create_sidebar() {
		// If get data from the form
		if ( !empty($_POST['trx_addons_widgets_area_name'])) {
			if (check_admin_referer( 'trx_addons_action_create_widgets_area', 'trx_addons_widgets_wpnonce' ) ) {
				$name = trim(trx_addons_get_value_gp('trx_addons_widgets_area_name'));
				$sidebars = get_option('trx_addons_widgets_areas', false);
				if ($sidebars === false) $sidebars = array();
				if ( !empty($_POST['trx_addons_widgets_area_delete'])) {
					foreach ($sidebars as $i=>$sb) {
						if ($sidebars[$i]['name'] == $name) {
							unset($sidebars[$i]);
							break;
						}
					}
				} else {
					$id = count($sidebars) > 0 ? $sidebars[count($sidebars)-1]['id']+1 : 1;
					$sidebars[] = array(
									'id' => $id,
									'name' => $name,
									'description' => trim(trx_addons_get_value_gp('trx_addons_widgets_area_description'))
									);
				}
				update_option('trx_addons_widgets_areas', $sidebars);
			}
		}
	}
}

// Register custom widgets areas after the theme's areas
if (!function_exists('trx_addons_widgets_register_sidebars')) {
	add_action('widgets_init', 'trx_addons_widgets_register_sidebars', 11);
	function trx_addons_widgets_register_sidebars() {
		global $TRX_ADDONS_STORAGE;
		// Load previously created sidebars
		$sidebars = get_option('trx_addons_widgets_areas', false);
		if (is_array($sidebars) && count($sidebars) > 0) {
			foreach ($sidebars as $sb) {
				register_sidebar( array(
										'name'          => $sb['name'],
										'description'   => $sb['description'],
										'id'            => 'custom_widgets_'.intval($sb['id']),
										'before_widget' => $TRX_ADDONS_STORAGE['widgets_args']['before_widget'],
										'after_widget'  => $TRX_ADDONS_STORAGE['widgets_args']['after_widget'],
										'before_title'  => $TRX_ADDONS_STORAGE['widgets_args']['before_title'],
										'after_title'   => $TRX_ADDONS_STORAGE['widgets_args']['after_title']
										)
								);
			}
		}
	}
}



// Widget class
//--------------------------------------------------------------------

if (!class_exists('TRX_Addons_Widget')) {
	class TRX_Addons_Widget extends WP_Widget {
		function __construct($class, $title, $params) {
			parent::__construct($class, $title, $params);
		}

		// Show one field in the widget's form
		function show_field($params=array()) {
			$params = array_merge(array(
										'type' => 'text',		// Field's type
										'name' => '',			// Field's name
										'title' => '',			// Title
										'description' => '',	// Description
										'class' => '',			// Additional classes
										'class_button' => '',	// Additional classes for button in mediamanager
										'multiple' => false,	// Allow select multiple images
										'rows' => 5,			// Number of rows in textarea
										'options' => array(),	// Options for select, checklist, radio, switch
										'params' => array(),	// Additional params for icons, etc.
										'label' => '',			// Alternative label for checkbox
										'value' => ''			// Field's value
										),
										$params);
			?><div class="widget_field_type_<?php echo esc_attr($params['type']);
					if (!empty($params['dir'])) echo ' widget_field_dir_'.esc_attr($params['dir']);
			?>"><?php
				if (!empty($params['title'])) {
					?><label class="widget_field_title"<?php if ($params['type']!='info') echo ' for="'.esc_attr($this->get_field_id($params['name'])).'"'; ?>><?php
						echo wp_kses_post($params['title']);
					?></label><?php
				}
				if (!empty($params['description'])) {
					?><div class="widget_field_description"><?php echo wp_kses_post($params['description']); ?></div>
					<?php
				}
				if ($params['type'] == 'select') {
					?><select id="<?php echo esc_attr($this->get_field_id($params['name'])); ?>"
							name="<?php echo esc_attr($this->get_field_name($params['name'])); ?>"
							class="widgets_param_fullwidth<?php if (!empty($params['class'])) echo ' '.esc_attr($params['class']); ?>"><?php
					if (is_array($params['options']) && count($params['options']) > 0) {
						foreach ($params['options'] as $slug => $name) {
							echo '<option value="' . esc_attr($slug) . '"'
							.(( is_array($params['value']) ? in_array($slug, $params['value']) : ( $slug==$params['value'] ))
								? ' selected="selected"'
								: ''
							  )
						.'>'
						  . esc_html($name)
						. '</option>';
						}
					}
					?></select><?php
	
				} else if (in_array($params['type'], array('radio', 'switch'))) {
					if (is_array($params['options']) && count($params['options']) > 0) {
						?><div class="widgets_param_box<?php
							if (!empty($params['class'])) echo ' class="'.esc_attr($params['class']).'"';
						?>"><?php
						foreach ($params['options'] as $slug => $name) {
							?><label><input type="radio"
										id="<?php echo esc_attr($this->get_field_id($params['name']).'_'.$slug); ?>"
										name="<?php echo esc_attr($this->get_field_name($params['name'])); ?>"
										value="<?php echo esc_attr($slug); ?>"
										<?php if ($params['value']==$slug) echo ' checked="checked"'; ?> />
							<?php echo esc_html($name); ?></label> <?php
						}
						?></div><?php
					}

				} else if ($params['type'] == 'checkbox') {
					?><label<?php if (!empty($params['class'])) echo ' class="'.esc_attr($params['class']).'"'; ?>><?php
						?><input type="checkbox" id="<?php echo esc_attr($this->get_field_id($params['name'])); ?>" 
									name="<?php echo esc_attr($this->get_field_name($params['name'])); ?>" 
									value="1" <?php echo (1==$params['value'] ? ' checked="checked"' : ''); ?> /><?php
							echo esc_html(!empty($params['label']) ? $params['label'] : $params['title']);
					?></label><?php

				} else if ($params['type'] == 'checklist') {
					?><span class="widgets_param_box<?php
									if (!empty($params['class'])) echo ' '.esc_attr($params['class']);
									?>"
							data-field_name="<?php echo esc_attr($this->get_field_name($params['name'])); ?>[]">
						<?php 
						foreach ($params['options'] as $slug => $name) {
							?><label><input type="checkbox"
										value="<?php echo esc_attr($slug); ?>" 
										name="<?php echo esc_attr($this->get_field_name($params['name'])); ?>[]"
										<?php if (strpos(','.$params['value'].',', ','.$slug.',')!==false) echo ' checked="checked"'; ?>><?php
								echo esc_html($name);
							?></label><?php
						}
					?></span><?php
	
				} else if ($params['type'] == 'color') {
					?><input type="text"
							id="<?php echo esc_attr($this->get_field_id($params['name'])); ?>" 
							name="<?php echo esc_attr($this->get_field_name($params['name'])); ?>"
							value="<?php echo esc_attr($params['value']); ?>"
							class="trx_addons_color_selector<?php if (!empty($params['class'])) echo ' '.esc_attr($params['class']); ?>" /><?php
	
				} else if (in_array($params['type'], array('image', 'media', 'video', 'audio'))) {
					?><input type="text"
							id="<?php echo esc_attr($this->get_field_id($params['name'])); ?>" 
							name="<?php echo esc_attr($this->get_field_name($params['name'])); ?>"
							<?php if (!empty($params['class'])) echo ' class="'.esc_attr($params['class']).'"'; ?>
							value="<?php echo esc_attr($params['value']); ?>" /><?php
					trx_addons_show_layout(trx_addons_options_show_custom_field($this->get_field_id($params['name']).'_button', 
									array(
										'type' => 'mediamanager',
										'multiple' => !empty($params['multiple']),
										'data_type' => $params['type'],
										'class_field' => !empty($params['class_button']) ? ' '.esc_attr($params['class_button']) : '',
										'linked_field_id' => $this->get_field_id($params['name'])
										),
									$params['value']));
	
				} else if ($params['type'] == 'icons') {
					?><input type="hidden"
							id="<?php echo esc_attr($this->get_field_id($params['name'])); ?>" 
							name="<?php echo esc_attr($this->get_field_name($params['name'])); ?>"
							value="<?php echo esc_attr($params['value']); ?>" /><?php
					trx_addons_show_layout(trx_addons_options_show_custom_field('trx_addons_options_field_'.esc_attr($this->get_field_id($params['name'])), 
									array_merge($params, $params['params']),
									$params['value']));
	
	
				} else if ($params['type'] == 'textarea') {
					?><textarea id="<?php echo esc_attr($this->get_field_id($params['name'])); ?>" 
							name="<?php echo esc_attr($this->get_field_name($params['name'])); ?>"
							rows="<?php echo esc_attr($params['rows']); ?>"
							class="widgets_param_fullwidth<?php if (!empty($params['class'])) echo ' '.esc_attr($params['class']); ?>"><?php
								echo esc_html($params['value']);
					?></textarea><?php
	
				} else if ($params['type'] == 'text') {
					?><input type="text"
							id="<?php echo esc_attr($this->get_field_id($params['name'])); ?>" 
							name="<?php echo esc_attr($this->get_field_name($params['name'])); ?>"
							value="<?php echo esc_attr($params['value']); ?>"
							class="widgets_param_fullwidth<?php if (!empty($params['class'])) echo ' '.esc_attr($params['class']); ?>" /><?php
				}
				?>
			</div><?php
		}


		// Display widget's common params
		//---------------------------------------------------------
		
		// Show ID, Class
		function show_fields_id_param($instance, $group=false) {
			if ($group===false)
				$group = __('ID &amp; Class', 'trx_addons');
			if (!empty($group))
				$this->show_field(array('title' => $group,
										'type' => 'info'));
			
			$this->show_field(array('name' => 'id',
									'title' => __('Element ID:', 'trx_addons'),
									'value' => $instance['id'],
									'type' => 'text'));

			$this->show_field(array('name' => 'class',
									'title' => __('Element CSS class:', 'trx_addons'),
									'value' => $instance['class'],
									'type' => 'text'));
		}
		
		// Show slider params
		function show_fields_slider_param($instance, $group=false, $add_params=array()) {
			if ($group===false)
				$group = __('Slider', 'trx_addons');
			if (!empty($group))
				$this->show_field(array('title' => $group,
										'type' => 'info'));
			
			$this->show_field(array('name' => 'slider',
									'title' => '',
									'label' => __('Slider', 'trx_addons'),
									'value' => (int) $instance['slider'],
									'type' => 'checkbox'));

			$this->show_field(array('name' => 'slides_space',
									'title' => __('Space between slides:', 'trx_addons'),
									'value' => (int) $instance['slides_space'],
									'type' => 'text'));

			$this->show_field(array('name' => 'slider_controls',
									'title' => __('Slider controls:', 'trx_addons'),
									'value' => $instance['slider_controls'],
									'options' => trx_addons_get_list_sc_slider_controls(),
									'type' => 'switch'));

			$this->show_field(array('name' => 'slider_pagination',
									'title' => __('Slider pagination:', 'trx_addons'),
									'value' => $instance['slider_pagination'],
									'options' => trx_addons_get_list_sc_slider_paginations(),
									'type' => 'switch'));

			// Additional params
			if (is_array($add_params) && count($add_params) > 0) {
				foreach ($add_params as $v)
					$this->show_field($v);
			}
		}
		
		// Show title params
		function show_fields_title_param($instance, $group=false, $button=true) {
			if ($group===false)
				$group = __('Titles', 'trx_addons');
			if (!empty($group))
				$this->show_field(array('title' => $group,
										'type' => 'info'));
			
			$this->show_field(array('name' => 'title_style',
									'title' => __('Title style:', 'trx_addons'),
									'value' => $instance['title_style'],
									'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'title'), 'trx_sc_title' ),
									'type' => 'switch'));

			$this->show_field(array('name' => 'title_tag',
									'title' => __('Title tag:', 'trx_addons'),
									'value' => $instance['title_tag'],
									'options' => trx_addons_get_list_sc_title_tags(),
									'type' => 'select'));

			$this->show_field(array('name' => 'title_align',
									'title' => __('Title alignment:', 'trx_addons'),
									'value' => $instance['title_align'],
									'options' => trx_addons_get_list_sc_aligns(),
									'type' => 'switch'));

			$this->show_field(array('name' => 'title',
									'title' => __('Title:', 'trx_addons'),
									'value' => $instance['title'],
									'type' => 'text'));

			$this->show_field(array('name' => 'subtitle',
									'title' => __('Subtitle:', 'trx_addons'),
									'value' => $instance['subtitle'],
									'type' => 'text'));

			$this->show_field(array('name' => 'description',
									'title' => __('Description:', 'trx_addons'),
									'value' => $instance['description'],
									'type' => 'textarea'));
			
			// Add button's params
			if ($button) {
				$this->show_field(array('name' => 'link',
										'title' => __('Button URL:', 'trx_addons'),
										'value' => $instance['link'],
										'type' => 'text'));
				$this->show_field(array('name' => 'link_text',
										'title' => __('Button text:', 'trx_addons'),
										'value' => $instance['link_text'],
										'type' => 'text'));
				$this->show_field(array('name' => 'link_style',
										'title' => __('Button style:', 'trx_addons'),
										'value' => $instance['link_style'],
										'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'button'), 'trx_sc_button'),
										'type' => 'select'));
				$this->show_field(array('name' => 'link_image',
										'title' => __('Background image for the button:', 'trx_addons'),
										'value' => $instance['link_image'],
										'type' => 'image'));
			}
		}
		
		// Show query params
		function show_fields_query_param($instance, $group=false, $add_params=array()) {
			if ($group===false)
				$group = __('Query', 'trx_addons');
			if (!empty($group))
				$this->show_field(array('title' => $group,
										'type' => 'info'));

			$this->show_field(array('name' => 'ids',
									'title' => __('IDs to show (comma-separated list):', 'trx_addons'),
									'value' => $instance['ids'],
									'type' => 'text'));

			$this->show_field(array('name' => 'count',
									'title' => __('Count:', 'trx_addons'),
									'value' => (int) $instance['count'],
									'type' => 'text'));

			$this->show_field(array('name' => 'columns',
									'title' => __('Columns:', 'trx_addons'),
									'value' => (int) $instance['columns'],
									'type' => 'text'));

			$this->show_field(array('name' => 'offset',
									'title' => __('Offset:', 'trx_addons'),
									'value' => (int) $instance['offset'],
									'type' => 'text'));
	
			$this->show_field(array('name' => 'orderby',
									'title' => __('Order by:', 'trx_addons'),
									'value' => $instance['orderby'],
									'options' => trx_addons_get_list_sc_query_orderby('', 'date,price,title'),
									'type' => 'select'));
	
			$this->show_field(array('name' => 'order',
									'title' => __('Order:', 'trx_addons'),
									'value' => $instance['order'],
									'options' => trx_addons_get_list_sc_query_orders(),
									'type' => 'switch'));
	
			// Additional params
			if (is_array($add_params) && count($add_params) > 0) {
				foreach ($add_params as $v)
					$this->show_field($v);
			}
		}
		
		// Show icon params
		function show_fields_icon_param($instance, $group=false, $only_socials=false) {
			if ($group===false)
				$group = __('Icons', 'trx_addons');
			if (!empty($group))
				$this->show_field(array('title' => $group,
										'type' => 'info'));

			// Internal popup with icons list
			$style = $only_socials ? trx_addons_get_setting('socials_type') : trx_addons_get_setting('icons_type');
	
			$this->show_field(array('name' => 'icon',
									'title' => __('Icon:', 'trx_addons'),
									'value' => $instance['icon'],
									'style' => $style,
									'options' => $style == 'icons' 
														? trx_addons_array_from_list(trx_addons_get_list_icons()) 
														: trx_addons_get_list_files($only_socials ? 'css/socials' : 'css/icons.png', 'png'),
									'type' => 'icons'));
		}
	}
}
?>