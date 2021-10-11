<?php

$social_links = '<div class="lvca-social-wrap">';

$social_links .= '<div class="lvca-social-list">';

if ($member_email)
    $social_links .= '<div class="lvca-social-list-item"><a class="lvca-email" href="mailto:' . $member_email . '" title="' . __("Contact Us", 'livemesh-vc-addons') . '"><i class="lvca-icon-email"></i></a></div>';

if ($facebook_url)
    $social_links .= '<div class="lvca-social-list-item"><a class="lvca-facebook" href="' . $facebook_url . '" target="_blank" title="' . __("Follow on Facebook", 'livemesh-vc-addons') . '"><i class="lvca-icon-facebook"></i></a></div>';

if ($twitter_url)
    $social_links .= '<div class="lvca-social-list-item"><a class="lvca-twitter" href="' . $twitter_url . '" target="_blank" title="' . __("Subscribe to Twitter Feed", 'livemesh-vc-addons') . '"><i class="lvca-icon-twitter"></i></a></div>';

if ($linkedin_url)
    $social_links .= '<div class="lvca-social-list-item"><a class="lvca-linkedin" href="' . $linkedin_url . '" target="_blank" title="' . __("View LinkedIn Profile", 'livemesh-vc-addons') . '"><i class="lvca-icon-linkedin"></i></a></div>';

if ($googleplus_url)
    $social_links .= '<div class="lvca-social-list-item"><a class="lvca-googleplus" href="' . $googleplus_url . '" target="_blank" title="' . __("Follow on Google Plus", 'livemesh-vc-addons') . '"><i class="lvca-icon-googleplus"></i></a></div>';

if ($instagram_url)
    $social_links .= '<div class="lvca-social-list-item"><a class="lvca-instagram" href="' . $instagram_url . '" target="_blank" title="' . __("View Instagram Feed", 'livemesh-vc-addons') . '"><i class="lvca-icon-instagram"></i></a></div>';

if ($pinterest_url)
    $social_links .= '<div class="lvca-social-list-item"><a class="lvca-pinterest" href="' . $pinterest_url . '" target="_blank" title="' . __("Subscribe to Pinterest Feed", 'livemesh-vc-addons') . '"><i class="lvca-icon-pinterest"></i></a></div>';

if ($dribbble_url)
    $social_links .= '<div class="lvca-social-list-item"><a class="lvca-dribbble" href="' . $dribbble_url . '" target="_blank" title="' . __("View Dribbble Portfolio", 'livemesh-vc-addons') . '"><i class="lvca-icon-dribbble"></i></a></div>';

$social_links .= '</div>';

$social_links .= '</div>';

echo apply_filters('lvca_team_member_social_links', $social_links, $settings);