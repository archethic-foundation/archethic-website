<?php

$settings_sections = [
    'dashboard' => [
        'title' => esc_html__('Dashboard', 'elementskit-lite'),
        'sub-title' => esc_html__('General info', 'elementskit-lite'),
        'icon' => 'icon icon-home',
        // 'view_path' => 'some path to the view file'
    ],
    'widgets' => [
        'title' => esc_html__('Widgets', 'elementskit-lite'),
        'sub-title' => esc_html__('Enable disable widgets', 'elementskit-lite'),
        'icon' => 'icon icon-magic-wand',
    ],
    'modules' => [
        'title' => esc_html__('Modules', 'elementskit-lite'),
        'sub-title' => esc_html__('Enable disable modules', 'elementskit-lite'),
        'icon' => 'icon icon-settings-2',
    ],
    'usersettings' => [
        'title' => esc_html__('User Settings', 'elementskit-lite'),
        'sub-title' => esc_html__('Settings for fb, mailchimp etc', 'elementskit-lite'),
        'icon' => 'icon icon-settings1',
    ],
];

$settings_sections = apply_filters('elementskit/admin/settings_sections/list', $settings_sections);


$onboard_steps = [
    'step-01' => [
        'title' => esc_html__('Configuration', 'elementskit-lite'),
        'sub-title' => esc_html__('Configuration info', 'elementskit-lite'),
        'icon' => 'icon icon-ekit',
        // 'view_path' => 'some path to the view file'
    ],
    'step-02' => [
        'title' => esc_html__('Sign Up', 'elementskit-lite'),
        'sub-title' => esc_html__('Sign Up info', 'elementskit-lite'),
        'icon' => 'icon icon-user'
    ],
    'step-03' => [
        'title' => esc_html__('Website Powerup', 'elementskit-lite'),
        'sub-title' => esc_html__('Website Powerup info', 'elementskit-lite'),
        'icon' => 'icon icon-cog'
    ],
    'step-04' => [
        'title' => esc_html__('Tutorial', 'elementskit-lite'),
        'sub-title' => esc_html__('Tutorial info', 'elementskit-lite'),
        'icon' => 'icon icon-youtube-1'
    ],
    'step-05' => [
        'title' => esc_html__('Surprise', 'elementskit-lite'),
        'sub-title' => esc_html__('Surprise info', 'elementskit-lite'),
        'icon' => 'icon icon-gift1'
    ],
    'step-06' => [
        'title' => esc_html__('Finalizing', 'elementskit-lite'),
        'sub-title' => esc_html__('Finalizing info', 'elementskit-lite'),
        'icon' => 'icon icon-smile'
    ]
];

$installed_date = strtotime( get_option('elementskit-lite_install_date') );
if((3600 * 24) < (time() - $installed_date)){
    unset($onboard_steps['step-01']);
}

if(\ElementsKit_Lite::package_type() != 'free'){
    unset($onboard_steps['step-05']);
}

$onboard_steps = apply_filters('elementskit/admin/onboard_steps/list', $onboard_steps);

?>
<div class="ekit-wid-con <?php echo isset($_GET['ekit-onboard-steps']) && $_GET['ekit-onboard-steps'] == 'loaded' ? 'ekit-onboard-dashboard' : ''; ?>">
    <div class="ekit_container">
        <form action="" method="POST" id="ekit-admin-settings-form">
            <?php 
                if(isset($_GET['ekit-onboard-steps']) && $_GET['ekit-onboard-steps'] == 'loaded'){
                    include 'layout-onboard.php'; 
                }else{
                    include 'layout-settings.php';
                }
            ?>
        </form>
    </div>
</div>