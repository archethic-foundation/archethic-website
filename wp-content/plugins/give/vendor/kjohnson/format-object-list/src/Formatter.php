<?php

namespace FormatObjectList;

/**
 * A higher-order object to format a JS value/label object.
 */
class Formatter {

	/**
	 * @param array $data
	 * @param callable $function
	 */
	public function __construct( $data, $callback ) {
		$this->data = $data;
		$this->callback = $callback;
	}

    /**
	 * @return array
	 */
	public function format() {
		return array_map(
			$this->callback,
			array_keys( $this->data ),
			array_values( $this->data )
		);
	}
}