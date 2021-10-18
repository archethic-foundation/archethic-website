jQuery(document).ready(function($) {
	$(function(){
		$('.before-after-img').each(function(index, el) {
			var onhover = $(this).data('onhover');
			  	$(".twentytwenty-container").twentytwenty({
			    orientation: 'horizontal',
			    default_offset_pct: 0.3,
			    before_label: 'January 2017',
			    after_label: 'March 2017',
			    no_overlay: true,
			    move_slider_on_hover: onhover,
			    click_to_move: false
			  });
		});
	});
});