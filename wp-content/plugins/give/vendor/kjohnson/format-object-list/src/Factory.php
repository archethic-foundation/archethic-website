<?php

namespace FormatObjectList;

class Factory {
    /**
	 * Format a JS label/value object where the $key is the `value` and the $value is the `label`.
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	public static function fromKeyValue( $data ) {
		return new Formatter( $data, function( $key, $value ) {
			return [
				'value' => $key,
				'label' => $value,
			];
		});
	}

	/**
	 * Format a JS label/value object where the $key is the `label` and the $value is the `value`.
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	public static function fromValueKey( $data ) {
		return new Formatter( $data, function( $key, $value ) {
			return [
				'value' => $value,
				'label' => $key,
			];
		});
	}
}