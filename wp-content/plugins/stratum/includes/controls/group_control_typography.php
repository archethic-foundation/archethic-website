<?php
namespace Stratum;

use \Elementor\Group_Control_Base;
use \Elementor\Group_Control_Typography;
use \Elementor\Controls_Manager;
use \Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Stratum_Group_Control_Typography extends Group_Control_Base {
	protected static $fields;

	public static function get_type() {
		return 'stratum_typography';
	}

	protected function init_fields() {
		$default_fields = new Group_Control_Typography();
		$fields = $default_fields->init_fields();

		//Extend control (Add field)
		$fields['html_tag'] = [
			'label' => esc_html__( 'HTML Tag', 'stratum' ),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'h1' => esc_html__( 'H1', 'stratum' ),
				'h2' => esc_html__( 'H2', 'stratum' ),
				'h3' => esc_html__( 'H3', 'stratum' ),
				'h4' => esc_html__( 'H4', 'stratum' ),
				'h5' => esc_html__( 'H5', 'stratum' ),
				'h6' => esc_html__( 'H6', 'stratum' ),
				'div' => esc_html__( 'div', 'stratum' ),
				'p' => esc_html__( 'p', 'stratum' ),
				'span' => esc_html__( 'span', 'stratum' ),
			],
		];

		return $fields;
	}

	protected function prepare_fields( $fields ) {
		array_walk(
			$fields, function( &$field, $field_name ) {
				if ( in_array( $field_name, [ 'typography', 'popover_toggle' ] ) ) {
					return;
				}

				$selector_value = ! empty( $field['selector_value'] ) ? $field['selector_value'] : str_replace( '_', '-', $field_name ) . ': {{VALUE}};';

				$typography_field = $this->get_args();
				if(isset($typography_field['defaults'])){
					$defaults_arr = $typography_field['defaults'];
				}

				if(isset($typography_field['mobile_defaults'])){
					$mobile_defaults_arr = $typography_field['mobile_defaults'];
				}
				if(isset($typography_field['tablet_defaults'])){
					$tablet_defaults_arr = $typography_field['tablet_defaults'];
				}

				//Set defaults values to all fields
				if (isset($typography_field['defaults'])){
					if (isset($defaults_arr)){
						if ( isset($defaults_arr[$field_name])){
							$field['default'] = $defaults_arr[$field_name];
						}
					}
				}

				if (isset($typography_field['mobile_defaults'])){
					if (isset($mobile_defaults_arr[$field_name])){
						$field['mobile_default'] = $mobile_defaults_arr[$field_name];
					}
				}

				if (isset($typography_field['tablet_defaults'])){
					if (isset($tablet_defaults_arr[$field_name])){
						$field['tablet_default'] = $tablet_defaults_arr[$field_name];
					}
				}
				//--Set defaults values to all fields

				if($field_name != 'html_tag'){ //Not render styles if
					$field['selectors'] = [
						'{{SELECTOR}}' => $selector_value,
					];
				}
			}
		);

		return parent::prepare_fields( $fields );
	}

	protected function get_default_options() {
		return [
			'popover' => [
				'starter_name' => 'typography',
				'starter_title' => esc_html_x( 'Typography', 'Typography Control', 'stratum' ),
			],
		];
	}
}

Plugin::instance()->controls_manager->add_group_control( 'stratum_typography', new Stratum_Group_Control_Typography() );