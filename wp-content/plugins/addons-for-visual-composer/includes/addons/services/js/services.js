jQuery(function ($) {

    var custom_css = '';

    $('.lvca-services').each(function () {

        var services = $(this);

        var settings = services.data('settings'); // parses the json automatically

        /* --------------- Custom CSS ------------------ */

        var id_selector = '#' + services.attr('id');

        if (settings.icon_size !== '')
            custom_css += id_selector + '.lvca-services .lvca-service .lvca-icon-wrapper span { font-size:' + settings.icon_size + 'px; }';

        if (settings.icon_color !== '')
            custom_css += id_selector + '.lvca-services .lvca-service .lvca-icon-wrapper span { color:' + settings.icon_color + '; }';

        if (settings.hover_color !== '')
            custom_css += id_selector + '.lvca-services .lvca-service .lvca-icon-wrapper span:hover { color:' + settings.hover_color + '; }';

    });

    if (custom_css !== '') {
        var inline_css = '<style type="text/css">' + custom_css + '</style>';
        $('head').append(inline_css);
    }


});