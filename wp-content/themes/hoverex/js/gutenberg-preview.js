
/* global jQuery:false */
/* global HOVEREX_STORAGE:false */

jQuery( document ).ready(
    function() {
        "use strict";

        setTimeout( function() {
            jQuery('.editor-block-list__layout [class^="wp-block-"]').addClass('scheme_' + HOVEREX_STORAGE['color_scheme']);

            hoverex_init_media_elements(jQuery('body'));
        }, 100 );
    }
);

function hoverex_init_media_elements(cont) {
    if (HOVEREX_STORAGE['use_mediaelements'] && cont.find('audio:not(.inited),video:not(.inited)').length > 0) {
        if (window.mejs) {
            if (window.mejs.MepDefaults) window.mejs.MepDefaults.enableAutosize = true;
            if (window.mejs.MediaElementDefaults) window.mejs.MediaElementDefaults.enableAutosize = true;
            cont.find('audio:not(.inited),video:not(.inited)').each(function() {
                // If item now invisible
                if (jQuery(this).parents('div:hidden,section:hidden,article:hidden').length > 0) {
                    return;
                }
                if (jQuery(this).addClass('inited').parents('.mejs-mediaelement').length == 0
                    && jQuery( this ).parents( '.wp-block-video' ).length == 0
                    && ! jQuery( this ).hasClass( 'wp-block-cover__video-background' )
                    && jQuery(this).parents('.elementor-background-video-container').length == 0
                    && (HOVEREX_STORAGE['init_all_mediaelements']
                        || (!jQuery(this).hasClass('wp-audio-shortcode')
                            && !jQuery(this).hasClass('wp-video-shortcode')
                            && !jQuery(this).parent().hasClass('wp-playlist')
                        )
                    )
                ) {
                    var media_tag = jQuery(this);
                    var settings = {
                        enableAutosize: true,
                        videoWidth: -1,		// if set, overrides <video width>
                        videoHeight: -1,	// if set, overrides <video height>
                        audioWidth: '100%',	// width of audio player
                        audioHeight: 30,	// height of audio player
                        success: function(mejs) {
                            if ( mejs.pluginType && 'flash' === mejs.pluginType && mejs.attributes ) {
                                mejs.attributes.autoplay
                                && 'false' !== mejs.attributes.autoplay
                                && mejs.addEventListener( 'canplay', function () {	mejs.play(); }, false );
                                mejs.attributes.loop
                                && 'false' !== mejs.attributes.loop
                                && mejs.addEventListener( 'ended', function () {	mejs.play(); }, false );
                            }
                        }
                    };
                    jQuery(this).mediaelementplayer(settings);
                }
            });
        } else
            setTimeout(function() { hoverex_init_media_elements(cont); }, 400);
    }
    // Init all media elements after first run
    setTimeout(function() { HOVEREX_STORAGE['init_all_mediaelements'] = true; }, 1000);
}
