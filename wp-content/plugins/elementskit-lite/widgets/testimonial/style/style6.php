<div  class="elementskit-testimonial-slider ekit_testimonial_style_6 slick-slider arrow_inside <?php echo !empty($settings['ekit_testimonial_show_dot']) ? 'slick-dotted' : '' ?>" <?php echo $this->get_render_attribute_string('wrapper'); ?>>
	<div class="swiper-container">
		<div class="slick-list swiper-wrapper">
			<?php foreach ($testimonials as $testimonial): ?>
				<div class="swiper-slide">
					<div class="slick-slide">
						<div class="elementskit-single-testimonial-slider elementskit-testimonial-slider-block-style elementskit-testimonial-slider-block-style-three elementor-repeater-item-<?php echo esc_attr( $testimonial[ '_id' ] ); ?>">
							<?php if(isset($ekit_testimonial_wartermark_enable) && ($ekit_testimonial_wartermark_enable == 'yes')):?>
							<div class="elementskit-watermark-icon elementskit-icon-content <?php if($ekit_testimonial_wartermark_mask_show_badge == 'yes') : ?> commentor-badge <?php endif; ?>">
								<?php
									// new icon
									$migrated = isset( $settings['__fa4_migrated']['ekit_testimonial_wartermarks'] );
									// Check if its a new widget without previously selected icon using the old Icon control
									$is_new = empty( $settings['ekit_testimonial_wartermark'] );
									if ( $is_new || $migrated ) {
										// new icon
										\Elementor\Icons_Manager::render_icon( $settings['ekit_testimonial_wartermarks'], [ 'aria-hidden' => 'true' ] );
									} else {
										?>
										<i class="<?php echo esc_attr($settings['ekit_testimonial_wartermark']); ?>" aria-hidden="true"></i>
										<?php
									}
								?>
							</div>
							<?php endif;?>
							<?php
								if (isset($testimonial['client_photo']) && !empty($testimonial['client_photo']['url']) && sizeof($testimonial['client_photo']) > 0) {
							?>
							<div class="elementskit-commentor-bio <?php echo esc_attr($ekit_testimonial_client_area_alignment); ?>">
								<div class="elementkit-commentor-details">
										<div class="elementskit-commentor-image ekit-testimonial--avatar">
											<?php echo \Elementskit_Lite\Utils::get_attachment_image_html($testimonial, 'client_photo', 'full', [
												'height'	=> esc_attr($ekit_testimonial_client_image_size['size']),
												'width'	=> esc_attr($ekit_testimonial_client_image_size['size'])
											]); ?>
										</div>
								</div>
							</div>
							<?php
								}
							?>

							<?php if (!empty($testimonial['client_name']) || !empty($testimonial['designation'])) { ?>
								<div class="elementskit-profile-info">
									<?php if (!empty($testimonial['client_name'])) { ?>
									<strong class="elementskit-author-name"><?php echo esc_html($testimonial['client_name']); ?></strong>
									<?php }; ?>
									<?php if (!empty($testimonial['designation'])) { ?>
									<span class="elementskit-author-des"><?php echo \ElementsKit_Lite\Utils::kspan($testimonial['designation']); ?></span>
									<?php }; ?>
								</div>
							<?php }; ?>

							<?php if ( isset($testimonial['review']) && !empty($testimonial['review'])) : ?>
								<div class="elementskit-commentor-content">
									<?php if ($ekit_testimonial_rating_enable == 'yes') : ?>
									<ul class="elementskit-stars">
										<?php
										$reviewData = isset($testimonial['rating']) ? $testimonial['rating'] : 0;
										for($m = 1; $m <= 5; $m++){
											$iconStart = 'eicon-star-o';
											if($reviewData >= $m){
												$iconStart = 'eicon-star active';
											}
										?>
										<li><a href="#"><i class="<?php esc_attr_e( $iconStart, 'elementskit-lite' );?>"></i></a></li>

										<?php }?>
									</ul>
									<?php endif; ?>
									<p><?php echo isset($testimonial['review']) ? \ElementsKit_Lite\Utils::kses($testimonial['review']) : ''; ?></p>
								</div>
							<?php endif;  ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<ul class="slick-dots swiper-pagination swiper-pagination-clickable swiper-pagination-bullets"></ul>
	<?php if(!empty($settings['ekit_testimonial_show_arrow'])) : ?>
		<button type="button" class="slick-prev slick-arrow"><i class="<?php echo esc_attr($prevArrowIcon); ?>"></i></button>
		<button type="button" class="slick-next slick-arrow"><i class="<?php echo esc_attr($nextArrowIcon); ?>"></i></button>
	<?php endif; ?>
</div>
