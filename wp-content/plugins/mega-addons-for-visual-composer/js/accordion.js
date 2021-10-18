jQuery(document).ready(function($) {
    jQuery( ".mega-accordion" ).each(function(index, el) {
        var active  = $(this).data('active');
        var anim    = $(this).data('anim');
        var event   = $(this).data('event');
        var icon    = $(this).data('closeicons');
        var activeicon    = $(this).data('activeicons');
        var icons = {
            "header": icon,
            "activeHeader": activeicon,
        }
        $(this).accordion({
            animate: anim,
            event: event,
            icons: icons,
            active: active,
            collapsible: true,
            heightStyle: "content",
        });
    });

});