/*global jQuery:false*/
/*global ajaxurl:false*/
/*global lvca_admin_global_var*/

jQuery.noConflict();

(function ($) {

    "use strict";

// ==================================================================
// Ajax Helper
// ==================================================================

    var xhr,
        msg_strings = lvca_admin_global_var.box_messages,
        msg_icons = lvca_admin_global_var.box_icons;

    function Ajax_Helper(ajax_data) {

        // check if ajax request not proceeded and finish before running another one
        if (xhr && (xhr.readyState == 3 || xhr.readyState == 2 || xhr.readyState == 1)) {
            return false;
        }

        // prepare message icon
        var msg_state = msg_strings[ajax_data.func];

        // retrieve callbacks 
        var ajax_callbacks = ajax_data.callbacks;
        // delete callbacks to prevent fire function from $.ajax->data
        delete ajax_data.callbacks;

        // start ajax request
        xhr = $.ajax({
            url: ajaxurl, // global defined by WordPress pointing to admin-ajax.php
            type: 'POST',
            dataType: 'json',
            data: ajax_data, // utilize the action key value 'lvca_admin_ajax' to decide on the server side function should be fired
            beforeSend: function () {
                var msg_before = msg_icons.before + msg_state.before;
                if (ajax_callbacks.before) {
                    // call show_message_load() function
                    ajax_callbacks.before(ajax_data, msg_before);
                }
            },
            error: function (response) {
                console.error(response);
                if (ajax_callbacks.error) {
                    // call show_message_error() function
                    ajax_callbacks.error(ajax_data, response);
                }
            },
            success: function (response) {
                // if a php script error occurs
                if (!response.success) {
                    if (ajax_callbacks.error) {
                        // call show_message_error() function
                        ajax_callbacks.error(ajax_data, response);
                    }
                    return false;
                } else {
                    var msg_success = msg_icons.success + msg_state.success;
                    if (ajax_callbacks.success) {
                        // call show_save_settings_success() function
                        ajax_callbacks.success(ajax_data, response, msg_success);
                    }
                }
            }
        });
    }


// ==================================================================
// Close info Box Helper
// ===================================================================

    var infobox = '#lvca-infobox',
        infobox_msg = '.lvca-infobox-msg',
        infobox_loading = 'lvca-infobox-loading';

    $(document).on('click', infobox, function (e) {
        if ($(infobox).is(':visible') && ($(e.target).is('.lvca-info-inner') || $(e.target).is('.lvca-close-infobox'))) {
            $(infobox).removeClass(infobox_loading);
            setTimeout(function () {
                $(infobox).removeClass(infobox_loading);
            }, 300);
        }
    });


    // show box message
    function show_message_load(ajax_data, msg) {
        $(infobox_msg).html(msg);
        $(infobox).addClass(infobox_loading);
    }

    // show error message
    function show_message_error(ajax_data, response) {
        $(infobox_msg).html(lvca_admin_global_var.box_icons.error + response.message);
        setTimeout(function () {
            $(infobox).removeClass(infobox_loading);
        }, 1500);
    }


// ==================================================================
// GRID Global Settings - Save/reset settings
// ==================================================================

    $(document).on('click', '#lvca_settings_save, #lvca_settings_reset', function () {

        var func = $(this).data('action'),
            reset = (func === 'lvca_reset_settings') ? true : null,
            setting_data = get_settings_data(reset);

        Ajax_Helper({
            nonce: lvca_admin_global_var.nonce,
            action: 'lvca_admin_ajax',
            func: func,
            reset: reset,
            setting_data: setting_data,
            callbacks: {
                before: show_message_load,
                success: show_save_settings_success,
                error: show_message_error
            }
        });

    });

    function get_settings_data(reset) {

        var setting_data = {},
            setting_val;

        $('.lvca-row').each(function () {
            var $setting = $(this).find('[name]');
            if ($setting.length) {
                var setting_name = $setting.attr('name');
                if (reset) {
                    setting_val = $setting.data('default');
                } else {
                    setting_val = $setting.val();
                    if ($setting.is('.lvca-checkbox')) {
                        setting_val = $setting.is(':checked');
                        setting_val = (setting_val) ? setting_val : null;
                    }
                }
                setting_data[setting_name] = setting_val;
            }
        });

        return setting_data;

    }

    function show_save_settings_success(ajax_data, response, msg) {
        $(infobox_msg).html(msg);
        setTimeout(function () {
            $(infobox).removeClass(infobox_loading);
            if (response.content) {
                $('.lvca-settings').html($(response.content).html());
                LVCA_JS.init();
            }
        }, 800);
    }

})(jQuery);