jQuery(document).ready(function($) {
    "use strict";
    $('.cq-videocard').each(function(index) {
        var _this = $(this);
        var _elementheight = parseInt($(this).data('elementheight'), 10);
        var _videoURL = $(this).data('videourl');
        var _autoplay = $(this).data('autoplay');
        var _showbar = $(this).data('showbar');
        var _ismute = $(this).data('mute');
        var _isloop = $(this).data('isloop');
        var _startat = $(this).data('startat') || 0;
        var _stopat = $(this).data('stopat');
        var _videoquality = $(this).data('videoquality');
        var _videovolume = $(this).data('videovolume') || 50;
        var _opacity = $(this).data('opacity');
        var _avatarsize = parseInt($(this).data('avatarsize'), 10);
        var _namecolor = $(this).data('namecolor');
        var _namesize = $(this).data('namesize');
        var _iconcolor = $(this).data('iconcolor');
        var _iconbgcolor = $(this).data('iconbgcolor');
        var _labelsize = $(this).data('labelsize');
        var _labelcolor = $(this).data('labelcolor');
        var _extrainfosize = $(this).data('extrainfosize');
        var _extrainfocolor = $(this).data('extrainfocolor');
        if(_extrainfocolor!=""){
            $('.cq-videocard-extra', _this).css('color', _extrainfocolor);
        }
        if(_extrainfosize!=""){
            $('.cq-videocard-extra', _this).css('font-size', _extrainfosize);
        }
        if(_namecolor!=""){
            $('.cq-videocard-avatarname', _this).css('color', _namecolor);
        }
        if(_labelsize!=""){
            $('.cq-videocard-avatarlabel', _this).css('font-size', _labelsize);
        }
        if(_labelcolor!=""){
            $('.cq-videocard-avatarlabel', _this).css('color', _labelcolor);
        }
        if(_iconcolor!=""){
            $('.cq-videocard-icon', _this).css('color', _iconcolor);
        }
        if(_iconbgcolor!=""){
            $('.cq-videocard-icon', _this).css('background-color', _iconbgcolor);
        }
        if(_namesize!=""){
            $('.cq-videocard-avatarname', _this).css('font-size', _namesize);
        }
        if(_elementheight!=""&&_elementheight>0){
            _this.css('height', _elementheight);
        }
        if(_avatarsize!=""&&_avatarsize>0){
            $('.cq-videocard-avatar', _this).css({
                width: _avatarsize,
                height: _avatarsize,
                'border-radius': _avatarsize
            });
            $('.cq-videocard-icon', _this).css({
                width: _avatarsize,
                height: _avatarsize,
                'font-size': _avatarsize*0.5 + 'px',
                'line-height': _avatarsize + 'px'
            });
        }
        var _player = jQuery(".cq-videocard-video", _this).YTPlayer({
            videoURL: _videoURL,
            vol: _videovolume,
            containment: 'self',
            showControls: _showbar,
            autoPlay: _autoplay,
            mute: _ismute,
            loop: _isloop,
            startAt: _startat,
            stopAt: _stopat,
            quality: _videoquality,
            opacity: _opacity,
            stopMovieOnBlur: false

        });

    });

});
