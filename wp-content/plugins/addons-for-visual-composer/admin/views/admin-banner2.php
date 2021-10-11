<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

?>

<div id="lvca-banner-wrap">

    <div id="lvca-banner" class="lvca-banner-sticky">
        <h2><span><?php echo __('WPBakery Page Builder Addons', 'livemesh-vc-addons'); ?></span><?php echo __('Plugin Settings', 'livemesh-vc-addons') ?></h2>
        <div id="lvca-buttons-wrap">
            <a class="lvca-button" data-action="lvca_save_settings" id="lvca_settings_save"><i
                    class="dashicons dashicons-yes"></i><?php echo __('Save Settings', 'livemesh-vc-addons') ?></a>
            <a class="lvca-button reset" data-action="lvca_reset_settings" id="lvca_settings_reset"><i
                    class="dashicons dashicons-update"></i><?php echo __('Reset', 'livemesh-vc-addons') ?></a>
        </div>
    </div>

</div>