<?php

use \Elementor\Frontend;
use \Elementor\Icons_Manager;

extract( shortcode_atts( array(
	'table_head_items' 	   		      => array(),
	'table_body_items' 	   		  	  => array(),
	'table_head_alignment_horizontal' => '',
	'table_body_alignment_horizontal' => '',
), $settings ) );

$class    = 'stratum-table';

$table_tr = [];
$table_td = [];

$frontend = new Frontend;

$out      = "";

$out   .= "<div class='" . esc_attr( $class ) . "'>";
	$out   .= "<table class='" . esc_attr( $class . '__table' ) . "' >";
		$out   .= "<thead>";
			$out   .= "<tr>";
				foreach ( $table_head_items as $key => $table_head ) :
					$current_text_align  = ! empty( $table_head[ 'table_content_alignment' ] ) ? $table_head[ 'table_content_alignment' ]  : null;
					$current_bg          = ! empty( $table_head[ 'table_head_unique_bgcolor' ] ) ? "style='background: " . $table_head[ 'table_head_unique_bgcolor' ] . ";'" : null;
					$current_text_color  = ! empty( $table_head[ 'table_head_unique_text_color' ] ) ? "style='color: " . $table_head[ 'table_head_unique_text_color' ] . ";'" : null;
					$current_icon_color  = ! empty( $table_head[ 'table_head_unique_icon_color' ] ) ? "color: " . $table_head[ 'table_head_unique_icon_color' ] . ";" : null;
					$current_media_space = ! empty( $table_head[ 'table_head_icon_margin' ][ 'top' ] ) || ! empty( $table_head[ 'table_head_icon_margin' ][ 'right' ] ) || ! empty( $table_head[ 'table_head_icon_margin' ][ 'bottom' ] ) || ! empty( $table_head[ 'table_head_icon_margin' ][ 'left' ] ) ? "margin: " . $table_head[ 'table_head_icon_margin' ][ 'top' ] . $table_head[ 'table_head_icon_margin' ][ 'unit' ] . ' ' . $table_head[ 'table_head_icon_margin' ][ 'right' ] . $table_head[ 'table_head_icon_margin' ][ 'unit' ] . ' ' . $table_head[ 'table_head_icon_margin' ][ 'bottom' ] . $table_head[ 'table_head_icon_margin' ][ 'unit' ] . ' ' . $table_head[ 'table_head_icon_margin' ][ 'left' ] . $table_head[ 'table_head_icon_margin' ][ 'unit' ] . ";" : null;
					$icon_style 	     = ! empty( $current_media_space ) || ! empty( $current_icon_color ) ? sprintf( 'style="%1$s %2$s"', $current_media_space, $current_icon_color ) : null;

					$out   .= "<th colspan='" . esc_attr( $table_head[ 'table_colspan_head' ] ) . "' " . $current_bg . " >";
						$out   .= "<div class='" . esc_attr( $class . '__header-cell' ) . ' ' . esc_attr( 'align-content-' . ( ! empty( $current_text_align ) ? $current_text_align : $table_head_alignment_horizontal ) ) . "'>";

							$out	.= "<span class='" . esc_attr( $class . '__cell-title' ) . ' ' . esc_attr( 'has-media-' . $table_head[ 'table_head_pos' ] ) . "' " . $current_text_color . ">";
							$out	.= esc_html__( $table_head[ 'table_head_title' ] );

								if ( $table_head[ 'table_head_icon_type' ] != 'none' ) :

									$out	.= "<span class='" . esc_attr( $class . '__cell-icon' ) . "' " . $icon_style . ">";

										if ( $table_head[ 'table_head_icon_type' ] == 'icon' ) :
											$migrated = isset( $table_head[ '__fa4_migrated' ][ 'table_head_icons' ] );
											$is_new   = empty( $table_head[ 'table_head_icon' ] );

											if ( $is_new || $migrated ) :

												ob_start();
													Icons_Manager::render_icon( $table_head[ 'table_head_icons' ], [ 'aria-hidden' => 'true' ] );
												$title_icon_html = ob_get_clean();

												$out	.= $title_icon_html;
											else:
												$out	.= "<i class='" . esc_attr( $table_head[ 'table_head_icon' ] ) . "'></i>";
											endif;

										elseif ( $table_head[ 'table_head_icon_type' ] == 'image' ) :

											$out	.= "<img src='" . esc_url( $table_head[ 'table_head_image' ][ 'url' ] ) . "' alt='" . esc_attr( get_post_meta( $table_head[ 'table_head_image' ][ 'id' ], '_wp_attachment_image_alt', true ) ) . "' style='width: " . $table_head[ 'table_head_image_size' ] . "px;'></img>";
										endif;

									$out	.= "</span>";

								endif;
							$out	.= "</span>";
						$out   .= "</div>";
					$out   .= "</th>";
				endforeach;
			$out   .= "</tr>";
		$out   .= "</thead>";

		$out   .= "<tbody>";
			foreach ( $table_body_items as $key => $table_body ) :
				$row_id = uniqid();

				if ( $table_body[ 'table_col_select' ] == 'Row' ) :
					$table_tr[] = [
						'id'    => $row_id,
						'type'  => $table_body[ 'table_col_select' ]
					];
				endif;

				if ( $table_body[ 'table_col_select' ] == 'Col' ) :
					$table_tr_keys = array_keys( $table_tr );
				    $last_key 	   = end( $table_tr_keys );

					$table_td[]    = [
						'row_id'    	=> $table_tr[ $last_key ][ 'id' ],
						'type'      	=> $table_body[ 'table_col_select' ],
						'title'     	=> esc_html__( $table_body[ 'table_col_title' ] ),
						'content_type'  => $table_body[ 'table_col_content_type' ],
						'table_colspan' => $table_body[ 'table_colspan_body' ],
						'template'  	=> $table_body[ 'table_col_template' ],
						'editor'    	=> $table_body[ 'table_col_editor' ],
						'icon_type' 	=> $table_body[ 'table_col_icon_type' ],
						'f4_comp'   	=> isset( $table_body[ '__fa4_migrated' ][ 'table_col_icons' ] ),
						'icon'      	=> empty( $table_body[ 'table_col_icon' ] ),
						'icons'     	=> $table_body[ 'table_col_icons' ],
						'image'     	=> $table_body[ 'table_col_image' ],
						'image_size'	=> $table_body[ 'table_col_image_size' ],
						'icon_pos'  	=> $table_body[ 'table_col_pos' ],
						'content_align' => $table_body[ 'table_col_content_alignment' ],
						'icon_color'    => $table_body[ 'table_body_unique_icon_color' ],
						'media_space'   => $table_body[ 'table_col_margin' ],
						'text_color'    => $table_body[ 'table_body_unique_text_color' ],
						'bg_color'      => $table_body[ 'table_body_unique_bgcolor' ],
					];
				endif;
			endforeach;

			for ( $i = 0; $i < count( $table_tr ); $i++ ) :
				$out   .= "<tr>";

					for ( $j = 0; $j < count( $table_td ); $j++ ) :
						if ( $table_tr[ $i ][ 'id' ] === $table_td[ $j ][ 'row_id' ] ) :
							$body_text_align 	= ! empty( $table_td[ $j ][ 'content_align' ] ) ? $table_td[ $j ][ 'content_align' ] : null;
							$body_bg         	= ! empty( $table_td[ $j ][ 'bg_color' ] ) ? "style='background: " . $table_td[ $j ][ 'bg_color' ] . ";'" : null;
							$body_text_color 	= ! empty( $table_td[ $j ][ 'text_color' ] ) ? "style='color: " . $table_td[ $j ][ 'text_color' ] . ";'" : null;
							$body_icon_color 	= ! empty( $table_td[ $j ][ 'icon_color' ] ) ? "color: " . $table_td[ $j ][ 'icon_color' ] . ";" : null;
							$body_media_space   = ! empty( $table_td[ $j ][ 'media_space' ][ 'top' ] ) || ! empty( $table_td[ $j ][ 'media_space' ][ 'right' ] ) || ! empty( $table_td[ $j ][ 'media_space' ][ 'bottom' ] ) || ! empty( $table_td[ $j ][ 'media_space' ][ 'left' ] ) ? "margin: " . $table_td[ $j ][ 'media_space' ][ 'top' ] . $table_td[ $j ][ 'media_space' ][ 'unit' ] . ' ' . $table_td[ $j ][ 'media_space' ][ 'right' ] . $table_td[ $j ][ 'media_space' ][ 'unit' ] . ' ' . $table_td[ $j ][ 'media_space' ][ 'bottom' ] . $table_td[ $j ][ 'media_space' ][ 'unit' ] . ' ' . $table_td[ $j ][ 'media_space' ][ 'left' ] . $table_td[ $j ][ 'media_space' ][ 'unit' ] . ";" : null;
							$body_icon_style 	= ! empty( $body_media_space ) || ! empty( $body_icon_color ) ? sprintf( 'style="%1$s %2$s"', $body_media_space, $body_icon_color ) : null;

							$out   .= "<td " . $body_bg . " colspan='" . $table_td[ $j ][ 'table_colspan' ] . "'>";
								$out   .= "<div class='" . esc_attr( $class . '__body-cell' ) . ' ' . esc_attr( 'align-content-' . ( ! empty( $body_text_align ) ? $body_text_align : $table_body_alignment_horizontal ) ) . "'>";

									if ( $table_td[ $j ][ 'content_type' ]  === 'default' ) :

										$out	.= "<span class='" . esc_attr( $class . '__cell-title' ) . ' ' . esc_attr( 'has-media-' . $table_td[ $j ][ 'icon_pos' ] ) . "' " . $body_text_color . ">";
											$out	.= $table_td[ $j ][ 'title' ];

											if ( $table_td[ $j ][ 'icon_type' ] != 'none' ) :

												$out	.= "<span class='" . esc_attr( $class . '__cell-icon' ) . "' " . $body_icon_style . ">";

													if ( $table_td[ $j ][ 'icon_type' ] == 'icon' ) :
														$migrated = isset( $table_td[ $j ][ 'f4_comp' ] );
														$is_new   = empty( $table_td[ $j ][ 'icon' ] );

														if ( $is_new || $migrated ) :

															ob_start();
																Icons_Manager::render_icon( $table_td[ $j ][ 'icons' ], [ 'aria-hidden' => 'true' ] );
															$body_icon_html = ob_get_clean();

															$out	.= $body_icon_html;
														else:
															$out	.= "<i class='" . esc_attr( $table_td[ $j ][ 'icon' ] ) . "'></i>";
														endif;

													elseif ( $table_td[ $j ][ 'icon_type' ] == 'image' ) :

														$out	.= "<img src='" . esc_url( $table_td[ $j ][ 'image' ][ 'url' ] ) . "' alt='" . esc_attr( get_post_meta( $table_td[ $j ][ 'image' ][ 'id' ], '_wp_attachment_image_alt', true ) ) . "' style='width: " . $table_td[ $j ][ 'image_size' ] . "px;'></img>";
													endif;

												$out	.= "</span>";

											endif;
										$out	.= "</span>";

									elseif ( $table_td[ $j ][ 'content_type' ]  === 'template' ) :
										$get_template = $frontend->get_builder_content( $table_td[ $j ][ 'template' ], true );

										if ( ! empty( $get_template ) ) :
											$out	.= $get_template;
										else :
											$out	.= "<span>" . esc_html__( 'Template is not found', 'stratum' ) . "</span>";
										endif;
									else :
										$out    .= "<div class='" . esc_attr( $class . '__editor-content' ) . "'>" . $table_td[ $j ][ 'editor' ] . "</div>";
									endif;

								$out   .= "</div>";
							$out   .= "</td>";
						endif;
					endfor;

				$out   .= "</tr>";
			endfor;

		$out   .= "</tbody>";
	$out   .= "</table>";
$out   .= "</div>";

echo sprintf( '%s', $out );