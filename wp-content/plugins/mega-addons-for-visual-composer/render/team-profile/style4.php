<?php $some_id = rand(5, 500); ?>
<?php $hex = $member_clr; 
list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x"); ?>

<?php if ($member_visibility == 'smart') { ?>
	<div class="mega_team_case_4 mega_team_case_4<?php echo $some_id; ?> <?php echo $classname; ?>" style="width: <?php echo $pro_size; ?>px;">
		<div class="member-image">
			<?php if (isset($url) && $url != '') { ?>
				<a href="<?php echo esc_url($url['url']); ?>" target="<?php echo $url['target']; ?>" title="<?php echo esc_html($url['title']); ?>"><img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>"></a>
			<?php } ?>
			<?php if (isset($url) && $url == NULL) { ?>
				<a><img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>"></a>
			<?php } ?>
		</div>
		<div class="mega_wrap">
			<div class="member-name" style="color: <?php echo $memberproclr; ?>; font-size: <?php echo $member_txt_size; ?>px;">
				<?php echo $memb_name; ?>
				<span style="color: <?php echo $memberproclr; ?>; font-size: <?php echo $pro_txt_size; ?>px;">
					<?php echo $memb_prof; ?>
				</span>
			</div>
			<div class="member-desc" style="color: <?php echo $about_clr; ?>; font-size: <?php echo $about_txt_size; ?>px;">
				<?php echo $memb_about; ?>
			</div>
			<div class="member-social">
				<a href="<?php echo $social_url; ?>" target="_blank">
					<i class="<?php echo $social_icon; ?>"></i>
				</a>
				<a href="<?php echo $social_url2; ?>" target="_blank">
					<i class="<?php echo $social_icon2; ?>"></i>
				</a>
				<a href="<?php echo $social_url3; ?>" target="_blank">
					<i class="<?php echo $social_icon3; ?>"></i>
				</a>
				<a href="<?php echo $social_url4; ?>" target="_blank">
					<i class="<?php echo $social_icon4; ?>"></i>
				</a>
				<a href="<?php echo $social_url5; ?>" target="_blank">
					<i class="<?php echo $social_icon5; ?>"></i>
				</a>
				<?php if (!empty($social_icon6)) { ?>
				<a href="<?php echo $social_url6; ?>" target="_blank">
					<i class="<?php echo $social_icon6; ?>"></i>
				</a>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>

<style>
	.mega_team_case_4<?php echo $some_id; ?>:hover .mega_wrap {
	    <?php echo "background-color: rgba($r, $g, $b, 0.5) !important;" ?>
	}
</style>