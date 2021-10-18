jQuery(document).ready(function($) {
	// alert('works');
	

	$('.tooltip').each(function(index, el) {
		$(this).tooltipster({
			theme: $(this).data('theme'),
			animation: $(this).data('anim'),
			animationDuration: $(this).data('speed'),
			side: $(this).data('position'),
			interactive: $(this).data('interactive'),
		});
	});
});