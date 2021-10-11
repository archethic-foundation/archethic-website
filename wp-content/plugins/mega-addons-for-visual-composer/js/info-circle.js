jQuery(document).ready(function($) {

	$('.mega-info-circle').find('.icon-wrapper').each(function(index, el) {
		var inner_section = $(this).closest('.mega-info-circle').find('.mega-inner-section > div > div');
		var content = $(this).find('div').clone();
		
		$(this).hover(function() {
			setTimeout(function(){
				$(inner_section).html(content).css({opacity: 0.0, visibility: "visible"}).animate({opacity: 1.0});
			}, 400);
		}, function() {
			
		});

		if (index % 5 == 0) {
			$(this).trigger('mouseenter');
		}
	});

});