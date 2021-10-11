<?php
$args = get_query_var('trx_addons_args_search');
?>
<div class="search_wrap search_style_<?php echo esc_attr($args['style']);
		if (!empty($args['ajax'])) echo ' search_ajax';
		if (!empty($args['class'])) echo ' '.esc_attr($args['class']);
	?>">
	<div class="search_form_wrap">
		<form role="search" method="get" class="search_form" action="<?php echo esc_url(home_url('/')); ?>">
			<input type="text" class="search_field" placeholder="<?php esc_attr_e('Search', 'trx_addons'); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s">
			<button type="submit" class="search_submit trx_addons_icon-search"></button>
			<?php if ($args['style'] == 'fullscreen') { ?>
				<a class="search_close trx_addons_icon-delete"></a>
			<?php } ?>
		</form>
	</div>
	<?php
	if (!empty($args['ajax'])) {
		?><div class="search_results widget_area"><a href="#" class="search_results_close trx_addons_icon-cancel"></a><div class="search_results_content"></div></div><?php
	}
	?>
</div>