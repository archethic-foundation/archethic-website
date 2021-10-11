<?php
/**
 * Plugin support: SiteOrigin Panels
 *
 * Additional param's type 'icons': dropdown or inline list with images or font icons
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.30
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// Option 'only_socials' => true | false
// Option 'style' => 'icons' | 'images'
// Option 'mode' => 'inline' | 'dropdown'
// Option 'return' => 'slug' | 'full'
class SiteOrigin_Widget_Field_Icons extends SiteOrigin_Widget_Field_Base {

	protected $icons_callback;

	protected function render_field( $value, $instance ) {
		?><div class="trx_addons_sow_param_icons">
			<input type="hidden" name="<?php echo esc_attr( $this->element_name ) ?>" value="<?php echo esc_attr( $value ) ?>"
			       class="siteorigin-widget-icons-icon siteorigin-widget-input <?php echo esc_attr($this->field_options['type']); ?>_field" />
			<?php
			trx_addons_show_layout(trx_addons_options_show_custom_field(
									$this->element_name, 
									array_merge($this->field_options, array(
																			'options' => $this->get_widget_icons()
																			)
									), 
									$value));
		?></div><?php
	}

	protected function initialize() {
		if (empty($this->field_options['style']))	$this->field_options['style'] = 'icons';
		if (empty($this->field_options['mode']))	$this->field_options['mode'] = 'dropdown';
		if (empty($this->field_options['return']))	$this->field_options['return'] = 'full';
	}

	// Alphanumeric characters and hyphens.
	protected function sanitize_field_input( $value, $instance ) {
		$sanitized_value = $value;
		if ($this->field_options['style'] == 'icons') {
			if ( preg_match( '/[\w\d]+[\w\d-]*/', $sanitized_value, $sanitized_matches ) )
				$sanitized_value = $sanitized_matches[0];
			else
				$sanitized_value = '';
		}
		$widget_icons = $this->get_widget_icons();
		if ( empty($sanitized_value) 
			|| ( ($this->field_options['style'] == 'icons' || $this->field_options['return']=='slug') && !isset($widget_icons[$sanitized_value]) ) ) {
			$sanitized_value = isset( $this->default ) ? $this->default : '';
		}
		return $sanitized_value;
	}

	private function get_widget_icons() {
		if (!empty($this->field_options['options']) && is_array($this->field_options['options']) && count($this->field_options['options']) > 0)
			$icons = $this->field_options['options'];
		else if (!empty($this->icons_callback))
			$icons = call_user_func( $this->icons_callback );
		else
			$icons = $this->field_options['style'] == 'icons' 
						? trx_addons_array_from_list(trx_addons_get_list_icons()) 
						: trx_addons_get_list_files(!empty($this->field_options['only_socials']) ? 'css/socials' : 'css/icons.png', 'png');
		return $icons;
	}

	public function enqueue_scripts(){
		wp_enqueue_script('trx_addons-sow-icon-field', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_API . 'siteorigin-panels/params/icons/icons.js'), array( 'jquery' ), TRX_ADDONS_VERSION);
	}

}
?>