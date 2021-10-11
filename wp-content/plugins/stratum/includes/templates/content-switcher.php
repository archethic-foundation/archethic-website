<?php

use \Elementor\Frontend;

extract( shortcode_atts( array(
	'content_type'    	=> '',
	'content_items'    	=> array(),
	'content_animation' => '',
), $settings ) );

$frontend 	     = new Frontend;

$class = 'stratum-content-switcher';
$wrap_class = $class;

$animation_class = stratum_css_class( [ ( $content_animation != 'none' ? $content_animation.'-animation' : 'none-animation' ) ] );


if ( $content_type === 'multiple' ) {
	$wrap_class .= ' is-multiple';
}

if ( $content_type === 'toggle' ) {
	$wrap_class .= ' is-toggle';
}

$once_active_nav     = false;
$once_active_sw      = false;
$once_active_content = false;

$is_active	         = false;

$unique_id 			 = uniqid();

foreach ( $content_items as $index => $item ) {
	if ( $item[ 'active' ] ) {
		$is_active = true;
	}
}

$out	= "";

$out	.= "<div class='" . esc_attr( $wrap_class ) . "'>";
	$out	.= "<div class='" . esc_attr( $class . '__wrapper' ) . "'>";
		$out	.= "<div class='" . esc_attr( $class . '__nav' ) . "'>";
			if ( $content_type === 'multiple' ) :
				$out	.= "<div class='" . esc_attr( $class . '__nav-content' ) . "'>";
					$out	.= "<div class='" . esc_attr( $class . '__nav-pill' ) . "'></div>";
					$out	.= "<ul class='" . esc_attr( $class . '__nav-items' ) . "'>";
						foreach ( $content_items as $index => $item ) :
							$item_class   = stratum_css_class( [
								$class . '__nav-item',
								( ( $item[ 'active' ] == 'yes' && $once_active_nav == false) || ( $index == 0 && $is_active == false ) ? 'is-active' : '' )
							] );

							if ( $item[ 'active' ] == 'yes' ) :
								$once_active_nav = true;
							endif;

							if ( $content_type !== 'multiple' ) {
								$toggleNavCounter++;

								if ( $toggleNavCounter === 3 ) {
									break;
								}
							}

							if ( $item[ 'title' ] != '' ) :
								$out	.= "<li data-tab-id='" . esc_attr( $index ) . "' class='" . esc_attr( $item_class ) . "'>";
									$out    .= "<a class='" . esc_attr( $class . '__nav-button' ) . "' href='#' data-content='id-content-" . esc_attr( $item[ '_id' ] . $unique_id ) . "'>";
										$out	.= "<span class='" . esc_attr( $class . '__nav-title' ) . "'>" . esc_html__( $item[ 'title' ], 'stratum' ) . "</span>";
									$out    .= "</a>";
								$out    .= "</li>";
							endif;
						endforeach;
					$out    .= "</ul>";
				$out    .= "</div>";
			else :
				$toggleNavCounter = 0;

				$out	.= "<label class='" . esc_attr( $class . '__label' ) . "'>";

					foreach ( $content_items as $index => $item ) :
						$toggleNavCounter++;

						$item_class   = stratum_css_class( [
							$class . '__nav-item',
							( ( $item[ 'active' ] == 'yes' && $once_active_sw == false) || ( $index == 0 && $is_active == false ) ? 'is-active' : '' )
						] );

						if ( $item[ 'active' ] == 'yes' ) :
							$once_active_sw = true;
						endif;

						if ( $toggleNavCounter === 3 ) {
							break;
						}

						if ( $item[ 'title' ] != '' ) :

							$out    .= "<a class='" . esc_attr( $item_class . ' ' . $class . '__nav-button' ) . "' href='#' data-content='id-content-" . esc_attr( $item[ '_id' ] . $unique_id ) . "'>";
								$out	.= "<span class='" . esc_attr( $class . '__nav-title' ) . "'>" . esc_html__( $item[ 'title' ], 'stratum' ) . "</span>";
							$out    .= "</a>";

							if ( $toggleNavCounter === 1 ) {
								$out	.= "<input type='checkbox' />";
								$out	.= "<i class='" . esc_attr( $class . '__toggle' ) . "'></i>";
							}

						endif;
					endforeach;
				$out    .= "</label>";
			endif;
		$out    .= "</div>";

		$out	.= "<div class='" . esc_attr( $class . '__content' . ' ' . $animation_class ) . "'>";
			foreach ( $content_items as $index => $item ) :
				$item_class   = stratum_css_class( [
					$class . '__item',
					( ( $item[ 'active' ] == 'yes' && $once_active_content == false) || ( $index == 0 && $is_active == false ) ? 'is-active' : '' )
				] );

				if ( $item[ 'active' ] == 'yes' ) :
					$once_active_content = true;
				endif;

				if ( $content_type !== 'multiple' ) {
					$toggleContentCounter = 0;
					$toggleContentCounter++;

					if ( $toggleContentCounter === 3 ) {
						break;
					}
				}

				if ( ! empty( $item[ 'content_template' ] ) ) :
					$out	.= "<div class='" . esc_attr( $item_class ) . "' id='id-content-" . esc_attr( $item[ '_id' ] . $unique_id ) . "' >";
						$out    .= "<div class='" . esc_attr( $class . '__item-wrapper' ) . "'>";
							$out	.=  $frontend->get_builder_content( $item[ 'content_template' ], true );
						$out    .= "</div>";
					$out    .= "</div>";
				else :
					$out	.= "<div class='content-not-found' id='id-content-" . esc_attr( $item[ '_id' ] . $unique_id ) . "' ></div>";
				endif;

			endforeach;
		$out    .= "</div>";
	$out    .= "</div>";
$out    .= "</div>";

echo sprintf( '%s', $out );