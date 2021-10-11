<div class="mega_team_case_8 <?php echo $classname; ?>">
    <div class="maw_team_wrap" style="background: <?php echo $member_clr; ?>; max-width: <?php echo $pro_size; ?>px; width: 100%;">
        <div class="maw_team_photo_wrapper">
            <div class="maw_team_photo">
                <div class="">
                    <img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>">
                </div>
            </div>
        </div>
        
        <div class="maw_team_description">
            <span class="maw_team_name" style="color: <?php echo $memberproclr; ?>; font-size: <?php echo $member_txt_size; ?>px;">
                <?php echo $memb_name; ?>
            </span>
            <span class="maw_team_role" style="color: <?php echo $memberproclr; ?>; font-size: <?php echo $pro_txt_size; ?>px;">
                <?php echo $memb_prof; ?>
            </span>
            <div class="maw_team_text" style="color: <?php echo $about_clr; ?>; font-size: <?php echo $about_txt_size; ?>px;">
                <?php echo $memb_about; ?>
            </div>
        </div>

        <div class="maw_team_icons">
            <?php if (!empty($social_icon)) { ?>
                <a class="maw_team_icon" href="<?php echo $social_url; ?>" style="color: <?php echo $social_clr; ?>;" target="_blank">
                    <i aria-hidden="true" class="<?php echo $social_icon; ?>" style="font-size: <?php echo $social_size; ?>px;"></i>
                </a>
            <?php } ?>
            <?php if (!empty($social_icon2)) { ?>
                <a class="maw_team_icon" href="<?php echo $social_url2; ?>" style="color: <?php echo $social_clr2; ?>;" target="_blank">
                    <i aria-hidden="true" class="<?php echo $social_icon2; ?>" style="font-size: <?php echo $social_size; ?>px;"></i>
                </a>
            <?php } ?>
            <?php if (!empty($social_icon3)) { ?>
                <a class="maw_team_icon" href="<?php echo $social_url3; ?>" style="color: <?php echo $social_clr3; ?>;" target="_blank">
                    <i aria-hidden="true" class="<?php echo $social_icon3; ?>" style="font-size: <?php echo $social_size; ?>px;"></i>
                </a>
            <?php } ?>
            <?php if (!empty($social_icon4)) { ?>
                <a class="maw_team_icon" href="<?php echo $social_url4; ?>" style="color: <?php echo $social_clr4; ?>;" target="_blank">
                    <i aria-hidden="true" class="<?php echo $social_icon4; ?>" style="font-size: <?php echo $social_size; ?>px;"></i>
                </a>
            <?php } ?>
            <?php if (!empty($social_icon5)) { ?>
                <a class="maw_team_icon" href="<?php echo $social_url5; ?>" style="color: <?php echo $social_clr5; ?>;" target="_blank">
                    <i aria-hidden="true" class="<?php echo $social_icon5; ?>" style="font-size: <?php echo $social_size; ?>px;"></i>
                </a>
            <?php } ?>
        </div>
    </div>
</div>