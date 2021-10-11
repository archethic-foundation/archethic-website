<?php

namespace Stratum;

class Excerpt_Helper {
	/**
	 * @var Excerpt_Helper
	 */
	private static $instance = null;

	/**
	 * @var int
	 */
	private static $excerpt_length;

    /**
     * @return Stratum
     */
    public static function get_instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
		}

        return self::$instance;
    }

	public function setExcerptLength( $excerpt_length ) {
		self::$excerpt_length = $excerpt_length;
	}

	public static function excerpt_length() {
		return self::$excerpt_length;
	}

}