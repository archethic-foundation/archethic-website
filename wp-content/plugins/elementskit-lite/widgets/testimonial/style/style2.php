<div class="elementskit-testimonial-slider slick-slider arrow_inside <?php echo !empty($settings['ekit_testimonial_show_dot']) ? 'slick-dotted' : '' ?>" <?php echo $this->get_render_attribute_string('wrapper'); ?>>
	<div class="swiper-container">
        <div class="slick-list swiper-wrapper">
			<?php foreach ($testimonials as $testimonial): ?>
				<div class="swiper-slide">
					<div class="slick-slide">
						<div class="elementskit-testimonial-inner">
							<div class="elementskit-single-testimonial-slider ekit_testimonial_style_2">
								<div class="elementskit-commentor-content">
									<?php
										if (isset($testimonial['client_logo']) && !empty($testimonial['client_logo']['url']) && sizeof($testimonial['client_logo']) > 0) {	?>
										<div class="elementskit-client_logo">
											<?php if (isset($testimonial['client_logo_active']) && sizeof($testimonial['client_logo_active']) > 0 && $testimonial['use_hover_logo'] == 'yes') : ?>
												<?php echo \Elementskit_Lite\Utils::get_attachment_image_html($testimonial, 'client_logo_active', 'full', [
													'class'	=> 'elementskit-testimonial-client-active-logo'
												]); ?>
											<?php endif; ?>
											<?php echo \Elementskit_Lite\Utils::get_attachment_image_html($testimonial, 'client_logo', 'full', [
												'class'	=> 'elementskit-testimonial-client-logo'
											]); ?>
										</div>
									<?php
										}
										if ( isset($testimonial['review']) && !empty($testimonial['review'])) : ?>
										<p><?php echo isset($testimonial['review']) ? \ElementsKit_Lite\Utils::kses($testimonial['review']) : ''; ?></p>
									<?php endif;  ?>
									<?php if ( 'yes' == $ekit_testimonial_title_separetor ): ?>
										<span class="elementskit-border-hr"></span>
									<?php endif; ?>
									<span class="elementskit-profile-info">
										<strong class="elementskit-author-name"><?php echo isset($testimonial['client_name']) ? esc_html($testimonial['client_name']) : ''; ?></strong>
										<span class="elementskit-author-des"><?php echo isset($testimonial['designation']) ? \ElementsKit_Lite\Utils::kspan($testimonial['designation']) : ''; ?></span>
									</span>
								</div>
								<?php if(isset($ekit_testimonial_wartermark_enable) && $ekit_testimonial_wartermark_enable == 'yes'):?>
									<div class="elementskit-watermark-icon <?php if ($ekit_testimonial_wartermark_custom_position == 'yes') : ?> ekit_watermark_icon_custom_position <?php endif; ?>">
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
							</div>
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
