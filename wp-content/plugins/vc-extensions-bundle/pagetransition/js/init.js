_cq_pagetransition_firstdiv = jQuery('div:first');
if(jQuery('.cq-animsition').data('sitewrapper')!=""&&jQuery(jQuery('.cq-animsition').data('sitewrapper'))[0]){
	_cq_pagetransition_firstdiv = jQuery(jQuery('.cq-animsition').data('sitewrapper'));
}
_cq_pagetransition_firstdiv.css('opacity', 0);
var _cq_pagetransition_pagein = '';
var _cq_pagetransition_pageout = '';
var _cq_pagetransition_pageinspeed = '';
var _cq_pagetransition_pageoutspeed = '';
var _cq_pagetransition_animationmode = '';
var _cq_pagetransition_linkelement = '';
var _cq_pagetransition_overlaycolor = '';
_cq_pagetransition_animationmode = jQuery('.cq-animsition').data('animationmode') || 'normal';
_cq_pagetransition_overlayin = jQuery('.cq-animsition').data('overlayin') || 'overlay-slide-in-top';
_cq_pagetransition_overlayout = jQuery('.cq-animsition').data('overlayout') || 'overlay-slide-out-top';
_cq_pagetransition_pagein = jQuery('.cq-animsition').data('pagein') || 'fade-in';
_cq_pagetransition_pageout = jQuery('.cq-animsition').data('pageout') || 'fade-out';
_cq_pagetransition_pageinspeed = jQuery('.cq-animsition').data('pageinspeed') || 1500;
_cq_pagetransition_pageoutspeed = jQuery('.cq-animsition').data('pageoutspeed') || 800;
_cq_pagetransition_linkelement = jQuery('.cq-animsition').data('linkelement') || 'a:not([target="_blank"]):not([href^=#]):not(.fluidbox-image):not(.lightbox-link):not(.normal):not(.cq-thumb-lightbox):not(.carousel-item):not(.controls):not(.cqcarousel-item):not(.cq-lightbox):not(.productcover-link):not(.appmockup-lightbox):not(.ribbon-image):not(.fluidbox)';
_cq_pagetransition_overlaycolor = jQuery('.cq-animsition').data('overlaycolor');
if(_cq_pagetransition_animationmode=="normal"){
	_cq_pagetransition_firstdiv.addClass('animsition').animsition({
		inClass : _cq_pagetransition_pagein,
		outClass : _cq_pagetransition_pageout,
		loading               :    true,
	    loadingParentElement  :   'body', //animsition wrapper element
	    loadingClass          :   'animsition-loading',
	    linkElement   :   _cq_pagetransition_linkelement,
		inDuration : _cq_pagetransition_pageinspeed,
		outDuration : _cq_pagetransition_pageoutspeed
	    // overlay               :   true
	});
}else{
	_cq_pagetransition_firstdiv.addClass('animsition-overlay').animsition({
		inClass               :   _cq_pagetransition_overlayin,
	    outClass              :   _cq_pagetransition_overlayout,
	    loading               :    true,
	    loadingParentElement  :   'body', //animsition wrapper element
	    loadingClass          :   'animsition-loading',
		inDuration : _cq_pagetransition_pageinspeed,
		outDuration : _cq_pagetransition_pageoutspeed,
	    linkElement   :   _cq_pagetransition_linkelement,
	    overlay               :   true,
	    overlayClass          :   'animsition-overlay-slide',
	    overlayParentElement  :   'body'
	});
	jQuery('.animsition-overlay-slide').css('background-color', _cq_pagetransition_overlaycolor);

}

