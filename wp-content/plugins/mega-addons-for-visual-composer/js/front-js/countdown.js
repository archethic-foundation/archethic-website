// CountDown timer
jQuery(document).ready(function($) {
	$(function () {
		$('.countdownapply').each(function(index, el) {
			var style = $(this).data('style');
			var year = $(this).data('year');
			var month = $(this).data('month');
			var date = $(this).data('date');
			var CountDown = new Date();
			CountDown = new Date(CountDown.getFullYear() + year, month - 1, date);
			$(this).countdown({until: CountDown, format: style});
		});
	});
});