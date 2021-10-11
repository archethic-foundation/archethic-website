<?php
/**
 * Plugin's options customizer
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Add ThemeREX Addons item in the Appearance menu
if (!function_exists('trx_addons_add_menu_items')) {
	add_action( 'admin_menu', 'trx_addons_add_menu_items' );
	function trx_addons_add_menu_items() {
		add_theme_page(
			esc_html__('ThemeREX Addons', 'trx_addons'),	//page_title
			esc_html__('ThemeREX Addons', 'trx_addons'),	//menu_title
			'manage_options',								//capability
			'trx_addons_options',							//menu_slug
			'trx_addons_options_page_builder'				//callback

		);
	}
}


// Load scripts and styles
if (!function_exists('trx_addons_options_page_load_scripts')) {
	add_action("admin_enqueue_scripts", 'trx_addons_options_page_load_scripts');
	function trx_addons_options_page_load_scripts() {
		if (apply_filters('trx_addons_filter_need_options', isset($_REQUEST['page']) && $_REQUEST['page']=='trx_addons_options')) {
			// WP styles & scripts
			wp_enqueue_style( 'wp-color-picker', false, array(), null);
			wp_enqueue_script('wp-color-picker', false, array('jquery'), null, true);
			wp_enqueue_script('jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true);
			wp_enqueue_script('jquery-ui-accordion', false, array('jquery', 'jquery-ui-core'), null, true);
			wp_enqueue_script('jquery-ui-sortable', false, array('jquery', 'jquery-ui-core'), null, true);
			wp_enqueue_script('jquery-ui-datepicker', false, array('jquery', 'jquery-ui-core'), null, true);
			// Font with icons must be loaded before main stylesheet
			wp_enqueue_style( 'trx_addons-icons', trx_addons_get_file_url('css/font-icons/css/trx_addons_icons-embedded.css'), array(), null );
			// Internal styles & scripts
			wp_enqueue_style( 'trx_addons-options', trx_addons_get_file_url('css/trx_addons.options.css'), array(), null );
			wp_enqueue_script( 'trx_addons-options', trx_addons_get_file_url('js/trx_addons.options.js'), array('jquery'), null, true );
			wp_enqueue_script( 'trx_addons-options-map', trx_addons_get_file_url('js/trx_addons.options.map.js'), array('jquery'), null, true );
			wp_enqueue_script( 'trx_addons-options-maskedinput', trx_addons_get_file_url('js/maskedinput/jquery.maskedinput.min.js'), array('jquery'), null, true );
			if (isset($_REQUEST['page']) && $_REQUEST['page']=='trx_addons_options') {
				wp_localize_script( 'trx_addons-options', 'TRX_ADDONS_DEPENDENCIES', trx_addons_get_options_dependencies() );
			} else {
				$screen = function_exists('get_current_screen') ? get_current_screen() : false;
				if (is_object($screen) && trx_addons_meta_box_is_registered($screen->post_type)) {
					wp_localize_script( 'trx_addons-options', 'TRX_ADDONS_DEPENDENCIES', 
								trx_addons_get_options_dependencies(trx_addons_meta_box_get($screen->post_type)) );
				}
			}
		}
	}
}


// Build options page
if (!function_exists('trx_addons_options_page_builder')) {
	function trx_addons_options_page_builder() {
		$result = trx_addons_get_admin_message();
		?>
		<div class="trx_addons_options">
			<h2 class="trx_addons_options_title"><?php esc_html_e('ThemeREX Addons Settings', 'trx_addons'); ?></h2>
			<div class="trx_addons_options_result">
				<?php
				if (!empty($result['error'])) {
					?><div class="error"><p><?php echo wp_kses_data($result['error']); ?></p></div><?php
				} else if (!empty($result['success'])) {
					?><div class="updated"><p><?php echo wp_kses_data($result['success']); ?></p></div><?php
				}
				?>
			</div>
			<form id="trx_addons_options_form" action="#" method="post" enctype="multipart/form-data">
				<input type="hidden" name="trx_addons_nonce" value="<?php echo esc_attr(wp_create_nonce(admin_url())); ?>" />
				<?php trx_addons_options_show_fields(); ?>
				<div class="trx_addons_options_buttons">
					<input type="button" class="trx_addons_options_button_submit" value="<?php esc_html_e('Save Options', 'trx_addons'); ?>">
				</div>
			</form>
		</div>
		<?php		
	}
}


// Display all option's fields
if ( !function_exists('trx_addons_options_show_fields') ) {
	function trx_addons_options_show_fields($options=false, $post_type=false) {
		global $TRX_ADDONS_STORAGE;
		if (empty($options)) $options = $TRX_ADDONS_STORAGE['options'];
		// Call filter to fill options-dependent arrays
		$options = apply_filters('trx_addons_filter_before_show_options', $options, $post_type);
		$tabs_titles = $tabs_content = $tabs_empty = array();
		$last_section = 'default';
		$last_panel = '';
		foreach ($options as $k=>$v) {
			if ($v['type']=='section') {
				if (!isset($tabs_titles[$k])) {
					$tabs_titles[$k] = $v['title'];
					$tabs_content[$k] = '';
					$tabs_empty[$k] = true;
				}
				if (!empty($last_panel)) {
					$tabs_content[$last_section] .= '</div></div>';
					$last_panel = '';
				}
				$last_section = $k;
			} else if ($v['type']=='panel') {
				if (empty($last_panel))
					$tabs_content[$last_section] = (!isset($tabs_content[$last_section]) ? '' : $tabs_content[$last_section]) 
													. '<div class="trx_addons_options_panels">';
				else
					$tabs_content[$last_section] .= '</div>';
				$tabs_content[$last_section] .= '<h4 class="trx_addons_options_panel_title">' . esc_html($v['title']) . '</h4>'
												. '<div class="trx_addons_options_panel_content">';
				$last_panel = $k;
			} else if ($v['type']=='panel_end') {
				if (!empty($last_panel)) {
					$tabs_content[$last_section] .= '</div></div>';
					$last_panel = '';
				}
			} else if ($v['type']=='group') {
				$tabs_empty[$last_section] = false;
				if (count($v['fields']) > 0) {
					$tabs_content[$last_section] = (!isset($tabs_content[$last_section]) ? '' : $tabs_content[$last_section]) 
													. '<div class="trx_addons_options_group">';
					if (!isset($v['val']) || !is_array($v['val']) || count($v['val'])==0)
						$v['val'] = array(array());
					foreach ($v['val'] as $idx=>$values) {
						$tabs_content[$last_section] .= '<div class="trx_addons_options_fields_set' 
															. (!empty($v['clone']) ? ' trx_addons_options_clone' : '')
															. '">'
							. (!empty($v['clone']) 
									? '<span class="trx_addons_options_clone_control trx_addons_options_clone_control_move"'
											. ' title="'.esc_attr__('Drag to sort cloned fields', 'trx_addons').'"'
											. '></span>'
										. '<span class="trx_addons_options_clone_control trx_addons_options_clone_control_add"'
											. ' title="'.esc_attr__('Click to clone this set of the fields', 'trx_addons').'"'
											. '></span>'
										. '<span class="trx_addons_options_clone_control trx_addons_options_clone_control_delete"'
											. ' title="'.esc_attr__('Click to delete this set of the fields', 'trx_addons').'"'
											. '></span>'
									: ''
								);
						foreach ($v['fields'] as $k1=>$v1) {
							$v1['val'] = isset($values[$k1]) ? $values[$k1] : $v1['std'];
							$tabs_content[$last_section] .= trx_addons_options_show_field($k1, $v1, "{$k}[{$idx}]");
						}
						$tabs_content[$last_section] .= '</div>';
					}
					$tabs_content[$last_section] .= '</div>';
				}
			} else {
				if (empty($v['hidden']) && $v['type']!='hidden') $tabs_empty[$last_section] = false;
				$tabs_content[$last_section] = (!isset($tabs_content[$last_section]) ? '' : $tabs_content[$last_section]) 
												. trx_addons_options_show_field($k, $v);
			}
		}
		if (!empty($last_panel)) {
			$tabs_content[$last_section] .= '</div></div>';
		}
		
		if (count($tabs_content) > 0) {
			?>
			<div id="trx_addons_options_tabs" class="<?php echo count($tabs_titles) > 1 ? 'with_tabs' : 'no_tabs'; ?>">
				<?php if (count($tabs_titles) > 1) { ?>
					<ul><?php
						$cnt = 0;
						foreach ($tabs_titles as $k=>$v) {
							$cnt++;
							?><li<?php if ($tabs_empty[$k]) echo ' class="trx_addons_options_item_hidden"'; ?>><a href="#trx_addons_options_section_<?php echo esc_attr($cnt); ?>"><?php echo esc_html($v); ?></a></li><?php
						}
					?></ul>
				<?php
				}
				$cnt = 0;
				foreach ($tabs_content as $k=>$v) {
					$cnt++;
					?>
					<div id="trx_addons_options_section_<?php echo esc_attr($cnt); ?>" class="trx_addons_options_section">
						<?php trx_addons_show_layout($v); ?>
					</div>
					<?php
				}
				?>
			</div>
			<?php
		}
	}
}


// Display single option's field
if ( !function_exists('trx_addons_options_show_field') ) {
	function trx_addons_options_show_field($name, $field, $group='') {
		static $last_post_type = '';

		// Prepare 'name' for the group fields
		if (!empty($group)) $name = $group . "[{$name}]";
		$id = str_replace(array('[', ']'), array('_', ''), $name);

		$output = (!empty($field['class']) && strpos($field['class'], 'trx_addons_new_row')!==false 
					? '<div class="trx_addons_new_row_before"></div>'
					: '')
				. '<div class="trx_addons_options_item'
						. ' trx_addons_options_item_'.esc_attr($field['type'])
						. (!empty($field['hidden']) && $field['type']!='hidden' ? ' trx_addons_options_item_hidden' : '')
						. (!empty($field['class']) ? ' '.esc_attr($field['class']) : '')
						. '">'
							. '<h4 class="trx_addons_options_item_title'
								. (!empty($field['title_class']) ? ' '.esc_attr($field['title_class']) : '')
								. '">' . esc_html($field['title']) . '</h4>'
							. '<div class="trx_addons_options_item_data">'
								. '<div class="trx_addons_options_item_field' 
									. (!empty($field['dir']) ? ' trx_addons_options_item_field_'.esc_attr($field['dir']) : '') 
									. '"'
									. ' data-param="'.esc_attr($name).'"'
									. '>';

		// Type 'text' and 'time'
		if ($field['type'] == 'hidden') {
			$output .= '<input type="hidden"' 
								. (!empty($field['class_field']) ? ' class="'.esc_attr($field['class_field']).'"' : '') 
								. ' name="trx_addons_options_field_'.esc_attr($name).'"'
								. ' value="'.esc_attr($field['val']).'"'
								. ' />';

		// Type 'checkbox'
		} else if ($field['type']=='checkbox') {
			$output .= '<label class="trx_addons_options_item_label">'
						. '<input type="checkbox"'
								. (!empty($field['class_field']) ? ' class="'.esc_attr($field['class_field']).'"' : '') 
								. ' name="trx_addons_options_field_'.esc_attr($name).'"'
								. ' value="1"'
								. (!empty($field['val']) ? ' checked="checked"' : '')
								. ' />'
						. esc_html($field['title'])
					. '</label>';

		// Type 'checklist'
		} else if ($field['type']=='checklist') {
			$output .= '<div class="trx_addons_options_item_choises' . (!empty($field['sortable']) ? ' trx_addons_options_sortable' : '') . '">';
			// Sort options by values order
			if (!empty($field['sortable']) && is_array($field['val'])) {
				$field['options'] = trx_addons_array_merge($field['val'], $field['options']);
			}
			foreach ($field['options'] as $k=>$v) {
				$output .= '<label class="trx_addons_options_item_label' 
								. (!empty($field['sortable']) ? ' trx_addons_options_item_sortable' : '') 
								. '">'
							. '<input type="checkbox"'
								. (!empty($field['class_field']) ? ' class="'.esc_attr($field['class_field']).'"' : '') 
								. ' name="trx_addons_options_field_'.esc_attr($name).'['.$k.']"'
								. ' value="1"'
								. ' data-name="'.$k.'"'
								. ( isset($field['val'][$k]) && (int) $field['val'][$k] == 1 ? ' checked="checked"' : '')
								. ' />'
							. (substr($v, 0, 4)=='http' ? '<img src="'.esc_url($v).'">' : esc_html($v))
						. '</label>';
			}
			$output .= '<input type="hidden" name="trx_addons_options_field_'.esc_attr($name).'"'
							. ' value="'.trx_addons_options_put_field_value($field).'"'
							. ' />'
					. '</div>';

		// Type 'radio' (many items) and 'switch' (two items)
		} else if ($field['type']=='radio' || $field['type']=='switch') {
			foreach ($field['options'] as $k=>$v) {
				$output .= '<label class="trx_addons_options_item_label">'
								. '<input type="radio"'
										. (!empty($field['class_field']) ? ' class="'.esc_attr($field['class_field']).'"' : '') 
										. ' name="trx_addons_options_field_'.esc_attr($name).'"'
										. ' value="'.esc_attr($k).'"'
										. ($field['val']==$k ? ' checked="checked"' : '')
										. '>'
								. esc_html($v)
							. '</label>';
			}

		// Type 'button' - call specified js function
		} else if ($field['type']=='button') {
			$output .= '<input type="button"'
							. (!empty($field['class_field']) ? ' class="'.esc_attr($field['class_field']).'"' : '') 
							. ' name="trx_addons_options_field_'.esc_attr($name).'"'
							. ' value="'.esc_attr($field['title']).'"'
							. ' data-action="'.esc_attr($field['val']).'"'
							. '>';

		// Type 'date'
		} else if ($field['type']=='date') {
			$output .= '<input type="text"'
						. (!empty($field['class_field']) ? ' class="'.esc_attr($field['class_field']).'"' : '') 
						. ' name="trx_addons_options_field_'.esc_attr($name).'"'
						. ' value="'.esc_attr($field['val']).'"'
						. ' data-format="' . esc_attr(!empty($field['format']) ? $field['format'] : 'yy-mm-dd') . '"'
						. ' data-months="' . esc_attr(!empty($field['months']) ? $field['months'] : 1) . '"'
						. (!empty($field['mask']) ? ' data-mask="'.esc_attr($field['mask']).'"' : '')
						. (!empty($field['placeholder']) ? ' placeholder="'.esc_attr($field['placeholder']).'"' : '')
						. ' />';

		// Type 'text' and 'time'
		} else if (in_array($field['type'], array('text', 'time'))) {
			$output .= '<input type="text"'
						. (!empty($field['class_field']) ? ' class="'.esc_attr($field['class_field']).'"' : '') 
						. ' name="trx_addons_options_field_'.esc_attr($name).'"'
						. ' value="'.esc_attr($field['val']).'"'
						. (!empty($field['placeholder']) ? ' placeholder="'.esc_attr($field['placeholder']).'"' : '')
						. ' />';

		// Type 'textarea'
		} else if ($field['type']=='textarea') {
			$output .= '<textarea'
						. (!empty($field['class_field']) ? ' class="'.esc_attr($field['class_field']).'"' : '') 
						. ' name="trx_addons_options_field_'.esc_attr($name).'"'
						. (!empty($field['placeholder']) ? ' placeholder="'.esc_attr($field['placeholder']).'"' : '')
						. '>'
							. esc_attr($field['val'])
						. '</textarea>';

		// Type 'select', 'select2', 'post_type', 'taxonomy'
		} else if (in_array($field['type'], array('select', 'select2', 'post_type', 'taxonomy'))) {
			if ($field['type']=='select2') {
				trx_addons_enqueue_select2();
				$field['class_field'] = (!empty($field['class_field']) ? $field['class_field'] . ' ' : '') . 'select2_field';
			} else if ($field['type']=='post_type') {
				if (empty($field['options'])) $field['options'] = trx_addons_get_list_posts_types();
				$last_post_type = !empty($field['val']) ? $field['val'] : trx_addons_array_get_first($field['options']);
				$field['class_field'] = (!empty($field['class_field']) ? $field['class_field'] . ' ' : '') . 'trx_addons_post_type_selector';
			} else if ($field['type']=='taxonomy' && empty($field['options'])) {
				$field['options'] = empty($last_post_type) ? array() : trx_addons_get_list_taxonomies(false, $last_post_type);
				$field['class_field'] = (!empty($field['class_field']) ? $field['class_field'] . ' ' : '') . 'trx_addons_taxonomy_selector';
			}
			$output .= '<select'
							. (!empty($field['class_field']) ? ' class="' . esc_attr($field['class_field']) . '"' : '') 
							. ' name="trx_addons_options_field_'.esc_attr($name).(!empty($field['multiple']) ? '[]' : '').'"'
							. (!empty($field['multiple']) ? ' multiple="multiple"' : ' size="1"')
							. '>';
			foreach ($field['options'] as $k=>$v) {
				$output .= '<option value="'.esc_attr($k).'"'.(in_array($k, (array)$field['val']) ? ' selected="selected"' : '')
									.' class="'.esc_attr($k).'">'
								. esc_html($v)
								. '</option>';
			}
			$output .= '</select>';

		// Type 'icon'
		} else if ($field['type']=='icon') {
			$output .= '<select size="1"'
							. (!empty($field['class_field']) ? ' class="'.esc_attr($field['class_field']).'"' : '') 
							. ' name="trx_addons_options_field_'.esc_attr($name).'"'
							. '>';
			$socials_type = !empty($field['style']) ? $field['style'] : trx_addons_get_setting('socials_type');
			foreach ($field['options'] as $k=>$v) {
				$sn = $socials_type=='images' ? $k : $v;
				$output .= '<option class="'.esc_attr($sn).'"'
							. ' value="'.esc_attr($sn).'"'
							. ($field['val']==$sn ? ' selected="selected"' : '')
							. '>'
							. esc_html(str_replace(array('trx_addons_icon-', 'icon-'), '', $sn))
							. '</option>';
			}
			$output .= '</select>';

		// Type 'icons'
		} else if ($field['type']=='icons') {
			$output .= '<input type="hidden" name="trx_addons_options_field_'.esc_attr($name).'"'
							. ' value="'.esc_attr($field['val']).'"'
							. ' />'
						. trx_addons_options_show_custom_field('trx_addons_options_field_'.esc_attr($id), 
								$field,
								$field['val']);

		// Type 'color'
		} else if ($field['type']=='color') {
			$output .= '<input type="text"'
							. ' class="trx_addons_color_selector'
								. (!empty($field['class_field']) ? ' '.esc_attr($field['class_field']) : '') 
								. '"'
							. ' name="trx_addons_options_field_'.esc_attr($name).'"'
							. ' value="'.esc_attr($field['val']).'"'
							. ' />';

		// Type 'image', 'media', 'video' or 'audio'
		} else if (in_array($field['type'], array('image', 'media', 'video', 'audio'))) {
			$output .= (!empty($field['multiple']) 
							? '<input type="hidden" id="trx_addons_options_field_'.esc_attr($id).'"'
								. ' name="trx_addons_options_field_'.esc_attr($name).'"'
								. ' value="' . esc_attr($field['val']) .'"'
								. '>'
							: '<input type="text" id="trx_addons_options_field_'.esc_attr($id).'"'
								. ' name="trx_addons_options_field_'.esc_attr($name).'"'
								. ' value="'.esc_attr($field['val']).'"'
								. ' />')
						. trx_addons_options_show_custom_field('trx_addons_options_field_'.esc_attr($id).'_button', 
								array(
									'type' => 'mediamanager',
									'multiple' => !empty($field['multiple']),
									'data_type' => $field['type'],
									'button_caption' => !empty($field['button_caption']) ? $field['button_caption'] : '',
									'class_field' => !empty($field['class_field']) ? ' '.esc_attr($field['class_field']) : '',
									'linked_field_id' => 'trx_addons_options_field_'.esc_attr($id)
									),
								$field['val']);

		// Type 'googlemap'
		} else if ($field['type']=='googlemap') {
			$output .= '<input type="hidden" id="trx_addons_options_field_'.esc_attr($id).'"'
							. ' name="trx_addons_options_field_'.esc_attr($name).'"'
							. ' value="'.esc_attr($field['val']).'"'
							. ' />'
						. trx_addons_options_show_custom_field('trx_addons_options_field_'.esc_attr($name).'_map', 
								array(
									'type' => 'googlemap',
									'class_field' => !empty($field['class_field']) ? ' '.esc_attr($field['class_field']) : '',
									'height' => (!empty($field['height']) ? $field['height'] : 200),
									'linked_field_id' => 'trx_addons_options_field_'.esc_attr($id)
								),
								$field['val']);
		}

		$output .=  		'</div><!-- /.trx_addons_options_item_field -->'
							. '<div class="trx_addons_options_item_description">'
								. (!empty($field['override']['desc']) 	// param 'desc' already processed with wp_kses()!
									? trim($field['override']['desc']) 
									: trim($field['desc'])
									)
							. '</div><!-- /.trx_addons_options_item_description -->'
						. '</div><!-- /.trx_addons_options_item_data -->'
					. '</div><!-- /.trx_addons_options_item -->';
		return $output;
	}
}

// Display custom option's field
if (!function_exists('trx_addons_options_show_custom_field')) {
	function trx_addons_options_show_custom_field($id, $field, $value=null) {
		$output = '';
		switch ($field['type']) {

			case 'mediamanager':
				wp_enqueue_media( );
				$title = !empty($field['button_caption']) 
							? $field['button_caption']
							: (empty($field['data_type']) || $field['data_type']=='image'
								? esc_html__( 'Choose Image', 'trx_addons')
								: esc_html__( 'Choose Media', 'trx_addons')
								);
				$output .= '<input type="button"'
								. ' id="'.esc_attr($id).'"'
								. ' class="button mediamanager trx_addons_media_selector'
									. (!empty($field['class_field']) ? ' '.esc_attr($field['class_field']) : '') 
									. '"'
								. ' data-choose="' . esc_attr(!empty($field['multiple']) ? esc_html__( 'Choose Images', 'trx_addons') : $title) . '"'
								. '	data-update="' . esc_attr(!empty($field['multiple']) ? esc_html__( 'Add to Gallery', 'trx_addons') : $title) . '"'
								. ' data-multiple="' . esc_attr(!empty($field['multiple']) ? '1' : '0') . '"'
								. ' data-type="' . esc_attr(!empty($field['data_type']) ? $field['data_type'] : 'image') . '"'
								. ' data-linked-field="' . esc_attr($field['linked_field_id']) . '"'
								. ' value="'
									. (!empty($field['multiple'])
										? (empty($field['data_type']) || $field['data_type']=='image'
											? esc_attr__( 'Add Images', 'trx_addons')
											: esc_attr__( 'Add Files', 'trx_addons')
											)
										: esc_attr($title)
										)
									. '"'
								. '>';
				$output .= '<span class="trx_addons_media_selector_preview">';
				$images = explode('|', $value);
				if (is_array($images)) {
					foreach ($images as $img)
						$output .= $img 
							? '<span>'
									. (in_array(trx_addons_get_file_ext($img), array('gif', 'jpg', 'jpeg', 'png'))
											? '<img src="' . esc_url($img) . '" alt="">'
											: '<a href="' . esc_attr($img) . '">' . esc_html(basename($img)) . '</a>'
										)
								. '</span>' 
							: '';
				}
				$output .= '</span>';
				break;

			case 'googlemap':
				trx_addons_enqueue_googlemap();
				$output .= '<div id="'.esc_attr($id).'"'
							. ' class="trx_addons_options_googlemap'
								. (!empty($field['class_field']) ? ' '.esc_attr($field['class_field']) : '') 
								. '"'
							. ' data-coords="' . esc_attr($value) . '"'
							. ' style="height:' . esc_attr(empty($field['height']) 
															? '300px' 
															: trx_addons_prepare_css_value($field['height'])
														) . '"'
							. '>'
							. '</div>'
							. '<div class="trx_addons_options_googlemap_search">'
								. '<input type="text" class="trx_addons_options_googlemap_search_text" value="" />'
								. '<input type="button" class="trx_addons_options_googlemap_search_button"'
										. ' value="'.esc_html__('Find by address', 'trx_addons').'" />'
							. '</div>';
				break;
		
			case 'icons':
				if (is_array($field['options']) && count($field['options']) > 0) {
					if (empty($field['style'])) $field['style'] = trx_addons_get_setting('socials_type');
					if (empty($field['return'])) $field['return'] = 'full';
					if (empty($field['mode'])) $field['mode'] = 'dropdown';
					$output .= ($field['mode'] == 'dropdown'
									? '<span class="trx_addons_icon_selector'
													. (!empty($field['class_field']) ? ' '.esc_attr($field['class_field']) : '') 
													. ($field['style']=='icons' && !empty($value) ? ' '.esc_attr($value) : '')
													. '"'
											. ' title="'.esc_attr__('Select icon', 'trx_addons').'"'
											. ' data-style="'.($field['style']=='images' ? 'images' : 'icons').'"'
											. ($field['style']=='images' && !empty($value) 
													? ' style="background-image: url('.esc_url($field['return']=='slug' 
																									? $field['options'][$value] 
																									: $value).');"' 
													: '')
										. '></span>'
									: '')
								. '<div class="trx_addons_list_icons trx_addons_list_icons_'.esc_attr($field['mode']).'">'
								. ($field['mode'] == 'dropdown'
									? '<input type="text" class="trx_addons_list_icons_search" placeholder="'.esc_attr__('Search icon ...', 'trx_addons').'">'
									: ''
									);
					foreach ($field['options'] as $slug=>$icon) {
						$output .= '<span class="'.esc_attr($field['style']=='icons' ? $icon : $slug)
												. (($field['return']=='full' ? $icon : $slug) == $value ? ' trx_addons_active' : '')
											.'"'
											. ' title="'.esc_attr($slug).'"'
											. ' data-icon="'.esc_attr($field['return']=='full' ? $icon : $slug).'"'
											. ($field['style']=='images' ? ' style="background-image: url('.esc_url($icon).');"' : '')
									. '>'
										. ($field['mode']!='dropdown' ? '<i>'.esc_html($slug).'</i>' : '')
									. '</span>';
					}
					$output .= '</div>';
				}
				break;
		}
		return $output;
	}
}


// Save options
if (!function_exists('trx_addons_options_save')) {
	add_action('after_setup_theme', 'trx_addons_options_save', 4);
	function trx_addons_options_save() {

		if (!isset($_REQUEST['page']) || $_REQUEST['page']!='trx_addons_options' || trx_addons_get_value_gp('trx_addons_nonce')=='') return;

		global $TRX_ADDONS_STORAGE;

		// verify nonce
		if ( !wp_verify_nonce( trx_addons_get_value_gp('trx_addons_nonce'), admin_url() ) ) {
			trx_addons_set_admin_message(__('Bad security code! Options are not saved!', 'trx_addons'), 'error');
			return;
		}

		// Check permissions
		if (!current_user_can('manage_options')) {
			trx_addons_set_admin_message(__('Manage options is denied for the current user! Options are not saved!', 'trx_addons'), 'error');
			return;
		}

		// Save options
		$options = array();
		foreach ($TRX_ADDONS_STORAGE['options'] as $k=>$v) {
			// Skip options without value (section, info, etc.)
			if (!isset($v['std'])) continue;
			// Get option value from POST
			$TRX_ADDONS_STORAGE['options'][$k]['val'] = $options[$k] = trx_addons_options_get_field_value($k, $v);
		}
		update_option('trx_addons_options', apply_filters('trx_addons_filter_options_save', $options));

		do_action('trx_addons_action_just_save_options');

		// Apply action - moved to the delayed state (see below) to load all enabled modules and apply changes after
		// Not need here: do_action('trx_addons_action_save_options');
		update_option('trx_addons_action', 'trx_addons_action_save_options');
		
		// Return result
		trx_addons_set_admin_message(__('Options are saved', 'trx_addons'), 'success', true);
		if (!empty($_SERVER['HTTP_REFERER'])) {
			wp_safe_redirect($_SERVER['HTTP_REFERER']);
			exit();
		}
	}
}
?>