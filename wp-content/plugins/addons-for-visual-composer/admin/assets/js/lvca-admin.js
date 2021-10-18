
/*global jQuery:false*/

jQuery(document).ready(function () {
    LVCA_JS.init();
    // Run tab open/close event
    LVCA_Tab.event();
});

// Init all fields functions (invoked from ajax)
var LVCA_JS = {
    init: function () {
        // Run tab open/close
        LVCA_Tab.init();
        // Load colorpicker if field exists
        LVCA_ColorPicker.init();
    }
};


var LVCA_ColorPicker = {
    init: function () {
        var $colorPicker = jQuery('.lvca-colorpicker');
        if ($colorPicker.length > 0) {

            $colorPicker.wpColorPicker();

        }
    }
};

var LVCA_Tab = {
    init: function () {
        // display the tab chosen for initial display in content
        jQuery('.lvca-tab.selected').each(function () {
            LVCA_Tab.check(jQuery(this));
        });
    },
    event: function () {
        jQuery(document).on('click', '.lvca-tab', function () {
            LVCA_Tab.check(jQuery(this));
        });
    },
    check: function (elem) {
        var chosen_tab_name = elem.data('target');
        elem.siblings().removeClass('selected');
        elem.addClass('selected');
        elem.closest('.lvca-inner').find('.lvca-tab-content').removeClass('lvca-tab-show').hide();
        elem.closest('.lvca-inner').find('.lvca-tab-content.' + chosen_tab_name + '').addClass('lvca-tab-show').show();
    }
};