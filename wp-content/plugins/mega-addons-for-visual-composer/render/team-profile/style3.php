<!-- Outset Style -->
<?php if ($member_visibility == 'outset') { ?>
	<div class="mega_team_case_3 <?php echo $classname; ?>" style="width: <?php echo $pro_size; ?>px;">
		<div class="mega_team_wrap">
			<div class="member-image">
				<?php if (isset($url) && $url != '') { ?>
					<a href="<?php echo esc_url($url['url']); ?>" target="<?php echo $url['target']; ?>" title="<?php echo esc_html($url['title']); ?>"><img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>"></a>
				<?php } ?>
				<?php if (isset($url) && $url == NULL) { ?>
					<a><img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>"></a>
				<?php } ?>
			</div>
			<div class="member-name" style="color: <?php echo $memberproclr; ?>; font-size: <?php echo $member_txt_size; ?>px;">
				<?php echo $memb_name; ?>
				<span style="color: <?php echo $memberproclr; ?>; font-size: <?php echo $pro_txt_size; ?>px;">
					<?php echo $memb_prof; ?>
				</span>
			</div>
		</div>
		<div class="member-desc" style="color: <?php echo $about_clr; ?>; font-size: <?php echo $about_txt_size; ?>px;">
			<?php echo $memb_about; ?>
		</div>
		<div class="member-info" style="font-size: <?php echo $info_size; ?>px; color: <?php echo $info_clr; ?>">
			<?php if (!empty($memb_email)) { ?>
				<p><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo $memb_email; ?></p>
			<?php } ?>
			<?php if (!empty($memb_url)) { ?>
				<p><i class="fa fa-globe" aria-hidden="true"></i> <?php echo $memb_url; ?></p>
			<?php } ?>
			<?php if (!empty($memb_addr)) { ?>
				<p><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $memb_addr; ?></p>
			<?php } ?>
			<?php if (!empty($memb_numb)) { ?>
				<p><i class="fa fa-phone-square" aria-hidden="true"></i> <?php echo $memb_numb; ?></p>
			<?php } ?>
		</div>
		<div class="member-skills">
				<?php if (!empty($memb_skill)) { ?>
				<div class="skill-label"><?php echo $memb_skill; ?></div>
				<div class="skill-prog">
					<div class="fill" data-progress-animation="90%" data-appear-animation-delay="400" style="width: <?php echo $memb_perl; ?>%; background-color: <?php echo $member_clr; ?>;">
					</div>
				</div>
				<?php } ?>

				<?php if (!empty($memb_skill2)) { ?>
				<div class="skill-label"><?php echo $memb_skill2; ?></div>
				<div class="skill-prog">
					<div class="fill" data-progress-animation="90%" data-appear-animation-delay="400" style="width: <?php echo $memb_per2; ?>%; background-color: <?php echo $member_clr; ?>;">
					</div>
				</div>
				<?php } ?>
				
				<?php if (!empty($memb_skill3)) { ?>
				<div class="skill-label"><?php echo $memb_skill3; ?></div>
				<div class="skill-prog">
					<div class="fill" data-progress-animation="90%" data-appear-animation-delay="400" style="width: <?php echo $memb_per3; ?>%; background-color: <?php echo $member_clr; ?>;">
					</div>
				</div>
				<?php } ?>
				
				<?php if (!empty($memb_skill4)) { ?>
				<div class="skill-label"><?php echo $memb_skill4; ?></div>
				<div class="skill-prog">
					<div class="fill" data-progress-animation="90%" data-appear-animation-delay="400" style="width: <?php echo $memb_per4; ?>%; background-color: <?php echo $member_clr; ?>;">
					</div>
				</div>
				<?php } ?>
				
				<?php if (!empty($memb_skill5)) { ?>
				<div class="skill-label"><?php echo $memb_skill5; ?></div>
				<div class="skill-prog">
					<div class="fill" data-progress-animation="90%" data-appear-animation-delay="400" style="width: <?php echo $memb_per5; ?>%; background-color: <?php echo $member_clr; ?>;">
					</div>
				</div>
				<?php } ?>
			</div>
		<div class="member-social">
			<a href="<?php echo $social_url; ?>" style="background-color: <?php echo $social_clr; ?>" target="_blank">
				<i class="<?php echo $social_icon; ?>"></i>
			</a>
			<a href="<?php echo $social_url2; ?>" style="background-color: <?php echo $social_clr2; ?>" target="_blank">
				<i class="<?php echo $social_icon2; ?>"></i>
			</a>
			<a href="<?php echo $social_url3; ?>" style="background-color: <?php echo $social_clr3; ?>" target="_blank">
				<i class="<?php echo $social_icon3; ?>"></i>
			</a>
			<a href="<?php echo $social_url4; ?>" style="background-color: <?php echo $social_clr4; ?>" target="_blank">
				<i class="<?php echo $social_icon4; ?>"></i>
			</a>
			<a href="<?php echo $social_url5; ?>" style="background-color: <?php echo $social_clr5; ?>" target="_blank">
				<i class="<?php echo $social_icon5; ?>"></i>
			</a>
			<?php if (!empty($social_icon6)) { ?>
			<a href="<?php echo $social_url6; ?>" style="background-color: <?php echo $social_clr6; ?>" target="_blank">
				<i class="<?php echo $social_icon6; ?>"></i>
			</a>
			<?php } ?>
		</div>
	</div>
<?php } ?>