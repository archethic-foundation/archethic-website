<?php
/**
 * The style "default" of the Googlemap
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

$args = get_query_var('trx_addons_args_sc_googlemap');

?><div id="<?php echo esc_attr($args['id']); ?>_wrap" class="sc_googlemap_wrap"><?php

	trx_addons_sc_show_titles('sc_googlemap', $args);
	
	if ($args['content']) {
		?><div class="sc_googlemap_content_wrap"><?php
	}
	?><div id="<?php echo esc_attr($args['id']); ?>"
			class="sc_googlemap sc_googlemap_<?php
				echo esc_attr($args['type']);
				if (trx_addons_is_on($args['prevent_scroll'])) echo ' sc_googlemap_prevent_scroll';
				echo (!empty($args['class']) ? ' '.esc_attr($args['class']) : '');
			?>"
			<?php echo ($args['css']!='' ? ' style="'.esc_attr($args['css']).'"' : ''); ?>
			data-zoom="<?php echo esc_attr($args['zoom']); ?>"
			data-style="<?php echo esc_attr($args['style']); ?>"
			data-cluster-icon="<?php echo esc_attr($args['cluster']); ?>"
			><?php
			$cnt = 0;
			foreach ($args['markers'] as $marker) {
				$cnt++;
				?><div id="<?php echo esc_attr($args['id'].'_'.intval($cnt)); ?>" class="sc_googlemap_marker"
						data-latlng="<?php echo esc_attr(!empty($marker['latlng']) ? $marker['latlng'] : ''); ?>"
						data-address="<?php echo esc_attr(!empty($marker['address']) ? $marker['address'] : ''); ?>"
						data-description="<?php echo esc_attr(!empty($marker['description']) ? $marker['description'] : ''); ?>"
						data-title="<?php echo esc_attr(!empty($marker['title']) ? $marker['title'] : ''); ?>"
						data-icon="<?php echo esc_attr(!empty($marker['icon']) ? $marker['icon'] : ''); ?>"
						data-icon_shadow="<?php echo esc_attr(!empty($marker['icon']) && !empty($marker['icon_shadow']) 
											? $marker['icon_shadow'] 
											: ''); ?>"
						data-icon_width="<?php echo esc_attr(!empty($marker['icon']) && !empty($marker['icon_width']) 
											? $marker['icon_width'] 
											: ''); ?>"
						data-icon_height="<?php echo esc_attr(!empty($marker['icon']) && !empty($marker['icon_height']) 
											? $marker['icon_height'] 
											: ''); ?>"
						></div><?php
			}
	?></div><?php
	
	if ($args['content']) {
		?>
			<div class="sc_googlemap_content sc_googlemap_content_<?php echo esc_attr($args['type']); ?>"><?php trx_addons_show_layout($args['content']); ?></div>
		</div>
		<?php
	}

	trx_addons_sc_show_links('sc_googlemap', $args);
	
?></div><!-- /.sc_googlemap_wrap -->