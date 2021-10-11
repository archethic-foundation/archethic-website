<?php
/**
 * ThemeREX Addons Layouts: SiteOrigin Panels utilities
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.30
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Add CPT 'Layouts' to the supported SOP post_types
// ------------------------------------------------------------------------
if (!function_exists('trx_addons_cpt_layouts_sop_siteorigin_panels_settings')) {
	add_filter('siteorigin_panels_settings', 'trx_addons_cpt_layouts_sop_siteorigin_panels_settings');
	function trx_addons_cpt_layouts_sop_siteorigin_panels_settings($settings) {
		if (!empty($settings['post-types']) && is_array($settings['post-types']) && !in_array(TRX_ADDONS_CPT_LAYOUTS_PT, $settings['post-types'])) {
			array_push($settings['post-types'], TRX_ADDONS_CPT_LAYOUTS_PT);
		}
		return $settings;
	}
}

// Add group to the standard SOP rows and cells
// ------------------------------------------------------------------------
if ( !function_exists( 'trx_addons_cpt_layouts_sop_add_group' ) ) {
	add_filter( 'siteorigin_panels_general_style_groups', 'trx_addons_cpt_layouts_sop_add_group', 10, 3 );
	function trx_addons_cpt_layouts_sop_add_group($groups, $post_id, $args) {
		$groups['custom_layouts'] = array(
			'name'     => __( 'Custom Layouts', 'trx_addons' ),
			'priority' => 30
		);
		return $groups;
	}
}


// Add params to the standard SOP rows
// ------------------------------------------------------------------------
if ( !function_exists( 'trx_addons_cpt_layouts_sop_add_row_params' ) ) {
	add_filter( 'siteorigin_panels_row_style_fields', 'trx_addons_cpt_layouts_sop_add_row_params', 10, 3 );
	function trx_addons_cpt_layouts_sop_add_row_params($fields, $post_id, $args) {
		$fields['row_type'] = array(
			'name'        => esc_html__( 'Row type', 'trx_addons' ),
			'description' => wp_kses_data( __( 'Select row type to decorate header widgets. Attention! Use this parameter to decorate custom layouts only!', 'trx_addons' )),
			'group'       => 'custom_layouts',
			'priority'    => 5,
			'default'     => 'inherit',
			'options'     => trx_addons_get_list_sc_layouts_row_types(),
			'type'        => 'select'
		);
		$fields['row_delimiter'] = array(
			'name'        => esc_html__( 'Row delimiter', 'trx_addons' ),
			'label'       => esc_html__( 'Show delimiter', 'trx_addons' ),
			'description' => wp_kses_data( __( 'Show delimiter after the row', 'trx_addons' )),
			'group'       => 'custom_layouts',
			'priority'    => 10,
			'default'     => false,
			'type'        => 'checkbox'
		);
		$fields['row_fixed'] = array(
			'name'        => esc_html__( 'Fix this row when scroll', 'trx_addons' ),
			'label'       => esc_html__( 'Fix row', 'trx_addons' ),
			'description' => wp_kses_data( __( 'Fix this row to the top of the window when scrolling down', 'trx_addons' )),
			'group'       => 'custom_layouts',
			'priority'    => 15,
			'default'     => false,
			'type'        => 'checkbox'
		);
		$fields['hide_on_desktop'] = array(
			'name'        => esc_html__( 'Hide on desktop', 'trx_addons' ),
			'label'        => esc_html__( 'Hide', 'trx_addons' ),
			'description' => wp_kses_data( __( 'Hide this item on desktops', 'trx_addons' )),
			'group'       => 'custom_layouts',
			'priority'    => 20,
			'default'     => false,
			'type'        => 'checkbox'
		);
		$fields['hide_on_notebook'] = array(
			'name'        => esc_html__( 'Hide on notebook', 'trx_addons' ),
			'label'        => esc_html__( 'Hide', 'trx_addons' ),
			'description' => wp_kses_data( __( 'Hide this item on notebooks', 'trx_addons' )),
			'group'       => 'custom_layouts',
			'priority'    => 21,
			'default'     => false,
			'type'        => 'checkbox'
		);
		$fields['hide_on_tablet'] = array(
			'name'        => esc_html__( 'Hide on tablets', 'trx_addons' ),
			'label'        => esc_html__( 'Hide', 'trx_addons' ),
			'description' => wp_kses_data( __( 'Hide this item on tablets', 'trx_addons' )),
			'group'       => 'custom_layouts',
			'priority'    => 22,
			'default'     => false,
			'type'        => 'checkbox'
		);
		$fields['hide_on_mobile'] = array(
			'name'        => esc_html__( 'Hide on mobile devices', 'trx_addons' ),
			'label'        => esc_html__( 'Hide', 'trx_addons' ),
			'description' => wp_kses_data( __( 'Hide this item on mobile devices', 'trx_addons' )),
			'group'       => 'custom_layouts',
			'priority'    => 23,
			'default'     => false,
			'type'        => 'checkbox'
		);
		$fields['hide_on_frontpage'] = array(
			'name'        => esc_html__( 'Hide on Frontpage', 'trx_addons' ),
			'label'        => esc_html__( 'Hide', 'trx_addons' ),
			'description' => wp_kses_data( __( 'Hide this item on Frontpage', 'trx_addons' )),
			'group'       => 'custom_layouts',
			'priority'    => 30,
			'default'     => false,
			'type'        => 'checkbox'
		);
		return $fields;
	}
}

// Add layouts specific classes to the standard SOP rows
if ( !function_exists( 'trx_addons_cpt_layouts_sop_row_style_attributes' ) ) {
	add_filter( 'siteorigin_panels_row_style_attributes', 'trx_addons_cpt_layouts_sop_row_style_attributes', 10, 2 );
	function trx_addons_cpt_layouts_sop_row_style_attributes($attributes, $style) {
		if ( !empty($style['row_type']) && !trx_addons_is_inherit($style['row_type']) ) {
			$attributes['class'][] = 'sc_layouts_row';
			$attributes['class'][] = 'sc_layouts_row_type_' . $style['row_type'];
		}
		if ( !empty($style['row_delimiter']) && !trx_addons_is_inherit($style['row_delimiter']) )
			$attributes['class'][] = 'sc_layouts_row_delimiter';
		if ( !empty($style['row_fixed']) && !trx_addons_is_inherit($style['row_fixed']) )
			$attributes['class'][] = 'sc_layouts_row_fixed';
		if ( !empty($style['hide_on_desktop']) && !trx_addons_is_inherit($style['hide_on_desktop']) )
			$attributes['class'][] = 'sc_layouts_hide_on_desktop';
		if ( !empty($style['hide_on_notebook']) && !trx_addons_is_inherit($style['hide_on_notebook']) )
			$attributes['class'][] = 'sc_layouts_hide_on_notebook';
		if ( !empty($style['hide_on_tablet']) && !trx_addons_is_inherit($style['hide_on_tablet']) )
			$attributes['class'][] = 'sc_layouts_hide_on_tablet';
		if ( !empty($style['hide_on_mobile']) && !trx_addons_is_inherit($style['hide_on_mobile']) )
			$attributes['class'][] = 'sc_layouts_hide_on_mobile';
		if ( !empty($style['hide_on_frontpage']) && !trx_addons_is_inherit($style['hide_on_frontpage']) )
			$attributes['class'][] = 'sc_layouts_hide_on_frontpage';
		return $attributes;
	}
}


// Add params to the standard SOP cells (columns)
// ------------------------------------------------------------------------
if ( !function_exists( 'trx_addons_cpt_layouts_sop_add_cell_params' ) ) {
	add_filter( 'siteorigin_panels_cell_style_fields', 'trx_addons_cpt_layouts_sop_add_cell_params', 10, 3 );
	function trx_addons_cpt_layouts_sop_add_cell_params($fields, $post_id, $args) {
		$fields['column_align'] = array(
			'name'        => esc_html__( 'Column alignment', 'trx_addons' ),
			'description' => wp_kses_data( __( 'Select alignment of the inner widgets in this column. Attention! Use this parameter to decorate custom layouts only!', 'trx_addons' )),
			'group'       => 'custom_layouts',
			'priority'    => 5,
			'default'     => 'inherit',
			'options'     => trx_addons_get_list_sc_aligns(),
			'type'        => 'select'
		);
		$fields['icons_position'] = array(
			'name'        => esc_html__( 'Icons position', 'trx_addons' ),
			'description' => wp_kses_data( __( "Select icons position of the inner widgets 'Layouts: xxx' in this column. Attention! Use this parameter to decorate custom layouts only!", 'trx_addons' )),
			'group'       => 'custom_layouts',
			'priority'    => 10,
			'default'     => 'left',
			'options'     => trx_addons_get_list_sc_layouts_icons_positions(),
			'type'        => 'select'
		);
		return $fields;
	}
}

// Add layouts specific classes to the standard SOP cells (columns)
if ( !function_exists( 'trx_addons_cpt_layouts_sop_cell_style_attributes' ) ) {
	add_filter( 'siteorigin_panels_cell_style_attributes', 'trx_addons_cpt_layouts_sop_cell_style_attributes', 10, 2 );
	function trx_addons_cpt_layouts_sop_cell_style_attributes($attributes, $style) {
		if ( !empty($style['column_align']) && !trx_addons_is_inherit($style['column_align']) ) {
			$attributes['class'][] = 'sc_layouts_column';
			$attributes['class'][] = 'sc_layouts_column_align_' . $style['column_align'];
		}
		if ( !empty($style['icons_position']) && !trx_addons_is_inherit($style['icons_position']) )
			$attributes['class'][] = 'sc_layouts_column_icons_position_' . $style['icons_position'];
		return $attributes;
	}
}


// Add params to the standard SOP widgets
// ------------------------------------------------------------------------
if ( !function_exists( 'trx_addons_cpt_layouts_sop_add_widget_params' ) ) {
	add_filter( 'siteorigin_panels_widget_style_fields', 'trx_addons_cpt_layouts_sop_add_widget_params', 10, 3 );
	function trx_addons_cpt_layouts_sop_add_widget_params($fields, $post_id, $args) {
		$fields['content_width'] = array(
			'name'        => esc_html__( 'Width of the content area', 'trx_addons' ),
			'description' => wp_kses_data( __( 'Select width of the block', 'trx_addons' )),
			'group'       => 'custom_layouts',
			'priority'    => 5,
			'default'     => 'inherit',
			'options'     => trx_addons_get_list_sc_content_widths(),
			'type'        => 'select'
		);
		return $fields;
	}
}

// Add layouts specific classes to the standard SOP widgets
if ( !function_exists( 'trx_addons_cpt_layouts_sop_widget_style_attributes' ) ) {
	add_filter( 'siteorigin_panels_widget_style_attributes', 'trx_addons_cpt_layouts_sop_widget_style_attributes', 10, 2 );
	function trx_addons_cpt_layouts_sop_widget_style_attributes($attributes, $style) {
		if ( !empty($style['content_width']) && !trx_addons_is_inherit($style['content_width']) ) 
			$attributes['class'][] = 'sc_content_width_'.str_replace('/', '_', $style['content_width']);
		return $attributes;
	}
}


// Wrap SOW output to the 'div.sc_layouts_item'
// ------------------------------------------------------------------------
if ( !function_exists( 'trx_addons_cpt_layouts_sop_sc_wrap' ) ) {
	add_filter( 'siteorigin_panels_widget_classes', 'trx_addons_cpt_layouts_sop_sc_wrap', 1000, 4 );
	function trx_addons_cpt_layouts_sop_sc_wrap($classes, $widget_class, $instance, $widget_info) {
		if (trx_addons_sc_stack_check('show_layout')						// Wrap shortcodes in the headers and footers
			&& !trx_addons_sc_stack_check('trx_sc_layouts') 				// Don't wrap shortcodes inside content
			&& $widget_class != 'SiteOrigin_Panels_Widgets_Layout'			// Don't wrap SOP Widget Layout
			) {
			$classes[] = 'sc_layouts_item';
			if (!empty($instance['hide_on_desktop']) && empty($instance['mobile_button']))
				$classes[] = 'sc_layouts_hide_on_desktop';
			if (!empty($instance['hide_on_notebook']) && empty($instance['mobile_button']))
				$classes[] = 'sc_layouts_hide_on_notebook';
			if (!empty($instance['hide_on_tablet']) && empty($instance['mobile_button']))
				$classes[] = 'sc_layouts_hide_on_tablet';
			if (!empty($instance['hide_on_mobile']) && empty($instance['mobile_button']))
				$classes[] = 'sc_layouts_hide_on_mobile';
		}
		return $classes;
	}
}


// Generate content to show layout
//------------------------------------------------------------------------
if ( !function_exists( 'trx_addons_cpt_layouts_sop_layout_content' ) ) {
	add_filter('trx_addons_filter_sc_layout_content', 'trx_addons_cpt_layouts_sop_layout_content', 10, 2);
	function trx_addons_cpt_layouts_sop_layout_content($content, $post_id) {
		// Check if this post has panels_data
		if ( strpos($content, '[vc_row')===false && trx_addons_exists_sop() && get_post_meta( $post_id, 'panels_data', true ) ) {
			$panel_content = SiteOrigin_Panels::renderer()->render(
				$post_id,
				// Add CSS if this is not the main single post, this is handled by add_single_css
				$post_id !== get_queried_object_id()
			);
			if ( !empty($panel_content) ) {
				$content = $panel_content;
				// This is an archive page, so try strip out anything after the more text
				if ( ! is_singular() ) {
					if ( preg_match( '/<!--more(.*?)?-->/', $content, $matches ) ) {
						$content = explode( $matches[0], $content, 2 );
						$content = $content[0];
						$content = force_balance_tags( $content );
						if ( ! empty( $matches[1] ) && ! empty( $more_link_text ) ) {
							$more_link_text = strip_tags( wp_kses_no_null( trim( $matches[1] ) ) );
						} else {
							$more_link_text = __( 'Read More', 'trx_addons' );
						}
	
						$more_link = apply_filters( 'the_content_more_link', ' <a href="' . get_permalink() . "#more-{$post->ID}\" class=\"more-link\">$more_link_text</a>", $more_link_text );
						$content .= '<p>' . $more_link . '</p>';
					}
				}
			}
		}
		return $content;
	}
}


// One-click import support
//------------------------------------------------------------------------

// Export custom layouts
if ( !function_exists( 'trx_addons_cpt_layouts_sop_export_meta' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_cpt_layouts_export_meta', 'trx_addons_cpt_layouts_sop_export_meta', 10, 2 );
	function trx_addons_cpt_layouts_sop_export_meta($meta, $post) {
		$meta['panels_data'] = serialize(get_post_meta( $post->ID, 'panels_data', true ));
		return $meta;
	}
}
?>