<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class WPBakeryShortCode_vc_woo_grid extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'style'				=>		'mega-post-carousel1',
			'settings'			=>		'',
			'catg'				=>		'visible',
			'rating'			=>		'visible',
			'imgheight'			=>		'200px',
			'txtsize'			=>		'18px',
			'descsize'			=>		'14px',
			'txtclr'			=>		'#000',
			'dateclr'			=>		'#000',
			'descclr'			=>		'#888',
			'woobtn'			=>		'',
		), $atts ) );
		if (isset($image_id) &&  $image_id != '') {
			$image_url = wp_get_attachment_url( $image_id );		
		}
		// var_dump($settings);
		$content = wpb_js_remove_wpautop($content);
		wp_enqueue_style( 'post-carousel-css', plugins_url( '../css/post-carousel.css' , __FILE__ ));
		wp_enqueue_style( 'grid-css', plugins_url( '../css/simplegrid.css' , __FILE__ ));
		wp_enqueue_script( 'custom-height', plugins_url( '../js/jquery.matchHeight-min.js' , __FILE__ ), array('jquery'));
		wp_enqueue_script( 'custom-js', plugins_url( '../js/custom-tm.js' , __FILE__ ), array('jquery'));

		$args = array(
			'posts_per_page' => -1,
		);
		$seperate_settings = explode('|', $settings);

		foreach ($seperate_settings as $setting) {
			$key_val = explode(':', $setting);
			if ($key_val[0] == 'size') {
				$args['posts_per_page'] = $key_val[1];
			} else {
				$args[$key_val[0]] = $key_val[1];
			}
		}

		// The Query
		$the_query = new WP_Query( $args );

		// The Loop
		if ( $the_query->have_posts() ) { ?>
						<div class="na-prefix">
							<div class="grid grid-pad"> 
			<?php while ( $the_query->have_posts() ) { ?>
				<?php $the_query->the_post(); ?>

					<?php if ($style == 'mega-post-carousel1') { ?>
								<div class="col-1-3 mason-item" style="padding-right: 15px;">
									<div class="mega-post-carousel1" style="margin-bottom: 40px;">
										<div class="mega-post-image">
											<?php the_post_thumbnail('large', array('class' => 'your-class-name')); ?>

											<span class="mega-comment-box" style="display: <?php echo $comment; ?>">
												<span class="mega-post-comment">
													<a href=""><?php $cu = wp_count_comments(get_the_id() ); echo $cu -> total_comments; ?> </a>
												</span>					
											</span>
										</div>

										<div class="mega-post-category" style="display: <?php echo $catg; ?>">
										<?php $categories = get_the_terms( get_the_id(), 'product_cat' );
											$separator = ' ';
											$output = '';
											if ( ! empty( $categories ) ) {
											    foreach( $categories as $category ) {
											        $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
											    }
											    echo trim( $output, $separator );
											} ?>
										</div>
										<?php $product = new WC_Product(get_the_id()); ?> 
										<div class="clearfix"></div>
										<?php if ($args['post_type'] == 'product') {
											echo wc_price(get_the_id());
										} ?>
										<span style="display: <?php echo $rating; ?>;">
											<?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
										</span>
										<div class="clearfix"></div>
										<h3 class="mega-post-title">
											<a style="font-size: <?php echo $txtsize; ?>; color: <?php echo $txtclr ?>" href="<?php the_permalink(); ?>"><?php echo get_the_title() ?></a>
										</h3>

										<div class="clearfix"></div>
										<div class="mega-post-para">
											<p style="font-size: <?php echo $descsize; ?>; color: <?php echo $descclr ?>">
												<?php $content = get_the_content(); echo mb_strimwidth($content, 0, 120, '...');?>
											</p>
										</div>
											<?php echo apply_filters( 'woocommerce_loop_add_to_cart_link',
												sprintf( '<a style="background: %s" rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
													$woobtn,
													esc_url( $product->add_to_cart_url() ),
													esc_attr( isset( $quantity ) ? $quantity : 1 ),
													esc_attr( $product->get_id() ),
													esc_attr( $product->get_sku() ),
													esc_attr( isset( $class ) ? $class : 'button product_type_simple add_to_cart_button ajax_add_to_cart' ),
													esc_html( $product->single_add_to_cart_text() )
												),
											$product );

											?>

									</div><br><br><br>
								</div>
					<?php } ?>

					<?php if ($style == 'mega-post-carousel2') { ?>
					<div class="col-1-3 mason-item" style="padding-right: 15px;">
						<div class="mega-post-carousel2" style="margin-bottom: 40px;">
							<div class="mega-post-image">
								<?php the_post_thumbnail('large', array('class' => 'your-class-name')); ?>
							</div>
							<div class="mega-post-content">
								<h3 class="mega-post-title">
									<a style="font-size: <?php echo $txtsize; ?>; color: <?php echo $txtclr ?>" href="<?php the_permalink(); ?>"><?php echo get_the_title() ?></a>
								</h3>
									<?php $product = new WC_Product(get_the_id()); ?>
									<?php if ($args['post_type'] == 'product') {
										echo wc_price(get_the_id());
									} ?>
									<br>
								<div class="mega-post-para">
									<p style="font-size: <?php echo $descsize; ?>; color: <?php echo $descclr ?>">
										<?php $content = get_the_content(); echo mb_strimwidth($content, 0, 50, '...');?>
									</p>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						</div>
					<?php } ?>

					<?php if ($style == 'mega-post-carousel3') { ?>
					<div class="col-1-3 mason-item" style="padding-right: 15px;">
						<div class="mega-post-carousel3" style="margin-bottom: 40px;">
							<div class="mega-post-image">
								<?php the_post_thumbnail('medium_large', array('class' => 'your-class-name')); ?>
							</div>

							<div class="mega-desc-box">
								<div style="display: table; margin: auto;">
									<div class="mega-post-category" style="display: <?php echo $catg; ?>">
										<?php $categories = get_the_terms( get_the_id(), 'product_cat' );
											$separator = ' , ';
											$output = '';
											if ( ! empty( $categories ) ) {
											    foreach( $categories as $category ) {
											        $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
											    }
											    echo trim( $output, $separator );
											} ?>
									</div>
								</div>
								<?php $product = new WC_Product(get_the_id()); ?> 
								<h3 class="mega-post-title">
									<a style="font-size: <?php echo $txtsize; ?>; color: <?php echo $txtclr ?>" href="<?php the_permalink(); ?>"><?php echo get_the_title() ?></a>
								</h3>

								<span style="display: <?php echo $rating; ?>;">
									<?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
								</span>
								<div class="clearfix"></div>
								<div class="mega-post-para">
									<p style="font-size: <?php echo $descsize; ?>; color: <?php echo $descclr ?>">
										<?php $content = get_the_content(); echo mb_strimwidth($content, 0, 120, '...');?>
									</p>
								</div>			
								<?php if ($args['post_type'] == 'product') {
									echo wc_price(get_the_id());
								} ?>
								
								<?php echo apply_filters( 'woocommerce_loop_add_to_cart_link',
									sprintf( '<a style="background: %s" rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
										$woobtn,
										esc_url( $product->add_to_cart_url() ),
										esc_attr( isset( $quantity ) ? $quantity : 1 ),
										esc_attr( $product->get_id() ),
										esc_attr( $product->get_sku() ),
										esc_attr( isset( $class ) ? $class : 'button product_type_simple add_to_cart_button ajax_add_to_cart' ),
										esc_html( $product->single_add_to_cart_text() )
									),
								$product );

								?>
								<div class="clearfix"></div>
							</div>
						</div>
						</div>
					<?php } ?>

			<?php } ?>

							</div>
						</div>
			<?php wp_reset_postdata();
		} else {
			// no posts found
		}
		ob_start(); ?>
			
		<?php

		return ob_get_clean();
	}
}


vc_map( array(
	"base" 			=> "vc_woo_grid",
	"name" 			=> __( 'Woo Grid', 'postslider' ),
	"category" 		=> __('Mega Addons'),
	"description" 	=> __('show woo posts as grid layout', ''),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/post-carousel.png',
	'params' => array(
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Choose Style', 'postslider' ),
			"param_name" 	=> 	"style",
			"group" 		=> 'General',
			"value" 		=> 	array(
				"Style 1" 		=> 		"mega-post-carousel1",
				"Style 2" 		=> 		"mega-post-carousel2",
				"Style 3" 		=> 		"mega-post-carousel3",
			)
		),

		array(
			"type" 			=> 	"loop",
			"heading" 		=> 	__( 'Link To', 'postslider' ),
			"param_name" 	=> 	"settings",
			"description"	=>	"Add Slide Url or leave blank, use it if you select theme [top image bottom content]",
			"group" 		=> 'General',
		),
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Category', 'postslider' ),
			"param_name" 	=> 	"catg",
			"description"	=>	__('show/hide category name', 'postslider'),
			"group" 		=> 'Settings',
			"value" 		=> 	array(
				"Show" 		=> 		"visible",
				"Hide" 	=> 		"none",
			)
		),

		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Rating', 'postslider' ),
			"param_name" 	=> 	"rating",
			"description"	=>	__('show/hide rating', 'postslider'),
			"group" 		=> 'Settings',
			"value" 		=> 	array(
				"Show" 		=> 		"visible",
				"Hide" 	=> 		"none",
			)
		),

		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Title (Font Size)', 'postslider' ),
			"param_name" 	=> 	"txtsize",
			"description"	=>	"font size of post title, default 18px",
			"value"			=>	"18px",
			"group" 		=> 'Design',
		),

		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Description (Font Size)', 'postslider' ),
			"param_name" 	=> 	"descsize",
			"description"	=>	"font size of post content, default 14px",
			"value"			=>	"14px",
			"group" 		=> 'Design',
		),

		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Title Color', 'postslider' ),
			"param_name" 	=> 	"txtclr",
			"description"	=>	"color of post title",
			"value"			=>	"#000",
			"group" 		=> 'Color',
		),

		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Description Color', 'postslider' ),
			"param_name" 	=> 	"descclr",
			"description"	=>	"color of post content",
			"value"			=>	"#888",
			"group" 		=>  'Color',
		),

		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Woo Background', 'postslider' ),
			"param_name" 	=> 	"woobtn",
			"description"	=>	"woo button background color",
			"value"			=>	"#0081cc",
			"group" 		=>  'Color',
		),
	),
) );
