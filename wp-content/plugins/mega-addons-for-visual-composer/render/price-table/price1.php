<div class="price_table_1" style="background-color: <?php echo $price_bg; ?>; box-shadow: 0 0 9px rgba(0,0,0,0.5), 0 -3px 0px <?php echo $top_bg; ?> inset;">
	<div class="type" style="background-color: <?php echo $top_bg; ?>;">
		<div class="ribbon-right" style="display: <?php echo $offer_visibility; ?>;">
			<span style="background: <?php echo $offer_bg; ?>;"><?php echo $offer_text; ?></span>
		</div>
		<p style="font-size: <?php echo $titlesize; ?>px; color: <?php echo $title_clr; ?>;">
			<?php echo $price_title; ?>
		</p>
	</div>

	<div class="plan">
		<div class="header" style="display: <?php echo $price_visibility; ?>;">
			<span class="price_curr" style="color: <?php echo $top_bg; ?>">
				<?php echo $price_currency; ?>
			</span>
			<span class="amount" style="color: <?php echo $top_bg; ?>; font-size: <?php echo $amountsize; ?>px;">
				<?php echo $price_amount; ?>
			</span>
			<p class="month" style="font-size: <?php echo $planesize; ?>px;"><?php echo $price_plan; ?></p>
		</div>
		<div class="content">
			<?php echo $content; ?>
		</div>			
		<div class="price">
      		<a href="<?php echo esc_url($btn_url['url']); ?>" target="<?php echo $btn_url['target']; ?>" title="<?php echo esc_html($btn_url['title']); ?>" class="price-btn" style="font-size: <?php echo $btnsize; ?>px; background-color: <?php echo $top_bg; ?>; box-shadow: inset 0 -2px <?php echo $top_bg; ?>;-webkit-box-shadow: inset 0 -2px <?php echo $top_bg; ?>;">
      			<?php echo $btn_text; ?>
      		</a>
		</div>
	</div>
</div>