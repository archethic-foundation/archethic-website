<?php
/**
 * The template to display the download's features on the single page
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.29
 */

$trx_addons_args = get_query_var('trx_addons_args_sc_edd_details');

$trx_addons_meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);

?><div<?php
		if (!empty($trx_addons_args['id'])) echo ' id="'.esc_attr($trx_addons_args['id']).'"';
		if (!empty($trx_addons_args['class'])) echo ' class="'.esc_attr($trx_addons_args['class']).'"';
		if (!empty($trx_addons_args['css'])) echo ' style="'.esc_attr($trx_addons_args['css']).'"';
?>><?php

// Details
?><section class="downloads_page_section downloads_page_details"><?php
	// Title
	?><h4 class="downloads_page_section_title"><?php esc_html_e('Details', 'trx_addons'); ?></h4><?php
	// Data
	?><div class="downloads_page_features_list"><?php
		// Price
		if (false && !empty($trx_addons_args['type'])) {
			$variable = edd_has_variable_prices(get_the_ID());
			?><span class="downloads_page_section_item downloads_page_section_item_price"><?php
				?><span class="downloads_page_label"><?php esc_html_e('Price:', 'trx_addons'); ?></span><?php
				?><span class="downloads_page_data downloads_page_price<?php if ($variable) echo ' downloads_page_price_variable'; ?>"><?php
					if ($variable) echo '<span>'.esc_html__('from', 'trx_addons').'</span>';
					edd_price(get_the_ID());
				?></span>
			</span><?php
		}
		// Date created
		if (!empty($trx_addons_meta['date_created'])) {
			?><span class="downloads_page_section_item downloads_page_section_item_created"><?php
				?><span class="downloads_page_label"><?php esc_html_e('Created:', 'trx_addons'); ?></span><?php
				?><span class="downloads_page_data"><?php echo date_i18n(get_option('date_format'), strtotime($trx_addons_meta['date_created'])); ?></span>
			</span><?php
		}
		// Date updated
		if (!empty($trx_addons_meta['date_updated'])) {
			?><span class="downloads_page_section_item downloads_page_section_item_updated"><?php
				?><span class="downloads_page_label"><?php esc_html_e('Updated:', 'trx_addons'); ?></span><?php
				?><span class="downloads_page_data"><?php echo date_i18n(get_option('date_format'), strtotime($trx_addons_meta['date_updated'])); ?></span>
			</span><?php
		}
		// Version
		if (!empty($trx_addons_meta['version'])) {
			?><span class="downloads_page_section_item downloads_page_section_item_version"><?php
				?><span class="downloads_page_label"><?php esc_html_e('Version:', 'trx_addons'); ?></span><?php
				?><span class="downloads_page_data"><?php echo esc_html($trx_addons_meta['version']); ?></span>
			</span><?php
		}
		// Widgets
		if (!empty($trx_addons_meta['widgets'])) {
			?><span class="downloads_page_section_item downloads_page_section_item_widgets"><?php
				?><span class="downloads_page_label"><?php esc_html_e('Widgets:', 'trx_addons'); ?></span><?php
				?><span class="downloads_page_data"><?php
					trx_addons_show_layout(trx_addons_get_option_title(TRX_ADDONS_EDD_PT, 'widgets', $trx_addons_meta['widgets']));
				?></span>
			</span><?php
		}
		// Shortcodes
		if (!empty($trx_addons_meta['shortcodes'])) {
			?><span class="downloads_page_section_item downloads_page_section_item_shortcodes"><?php
				?><span class="downloads_page_label"><?php esc_html_e('Shortcodes:', 'trx_addons'); ?></span><?php
				?><span class="downloads_page_data"><?php
					trx_addons_show_layout(trx_addons_get_option_title(TRX_ADDONS_EDD_PT, 'shortcodes', $trx_addons_meta['shortcodes']));
				?></span>
			</span><?php
		}
		// Columns
		if (!empty($trx_addons_meta['columns'])) {
			?><span class="downloads_page_section_item downloads_page_section_item_columns"><?php
				?><span class="downloads_page_label"><?php esc_html_e('Columns:', 'trx_addons'); ?></span><?php
				?><span class="downloads_page_data"><?php
					trx_addons_show_layout(trx_addons_get_option_title(TRX_ADDONS_EDD_PT, 'columns', $trx_addons_meta['columns']));
				?></span>
			</span><?php
		}
		// Documentation
		if (!empty($trx_addons_meta['documentation'])) {
			?><span class="downloads_page_section_item downloads_page_section_item_documentation"><?php
				?><span class="downloads_page_label"><?php esc_html_e('Documentation:', 'trx_addons'); ?></span><?php
				?><span class="downloads_page_data"><?php
					trx_addons_show_layout(trx_addons_get_option_title(TRX_ADDONS_EDD_PT, 'documentation', $trx_addons_meta['documentation']));
				?></span>
			</span><?php
		}
		// Support
		if (!empty($trx_addons_meta['support'])) {
			?><span class="downloads_page_section_item downloads_page_section_item_support"><?php
				?><span class="downloads_page_label"><?php esc_html_e('Support:', 'trx_addons'); ?></span><?php
				?><span class="downloads_page_data"><?php
					trx_addons_show_layout(trx_addons_get_option_title(TRX_ADDONS_EDD_PT, 'support', $trx_addons_meta['support']));
				?></span>
			</span><?php
		}
		// Retina
		if (!empty($trx_addons_meta['retina'])) {
			?><span class="downloads_page_section_item downloads_page_section_item_retina"><?php
				?><span class="downloads_page_label"><?php esc_html_e('High resolution:', 'trx_addons'); ?></span><?php
				?><span class="downloads_page_data"><?php echo (int) $trx_addons_meta['retina'] > 0 ? esc_html__('Yes', 'trx_addons') : esc_html__('No', 'trx_addons'); ?></span>
			</span><?php
		}
		// Responsive
		if (!empty($trx_addons_meta['responsive'])) {
			?><span class="downloads_page_section_item downloads_page_section_item_responsive"><?php
				?><span class="downloads_page_label"><?php esc_html_e('Responsive:', 'trx_addons'); ?></span><?php
				?><span class="downloads_page_data"><?php echo (int) $trx_addons_meta['responsive'] > 0 ? esc_html__('Yes', 'trx_addons') : esc_html__('No', 'trx_addons'); ?></span>
			</span><?php
		}
		// Additional details
		if (!empty($trx_addons_meta['details']) && is_array($trx_addons_meta['details'])) {
			foreach ($trx_addons_meta['details'] as $detail) {
				if (!empty($detail['title'])) {
					?><span class="downloads_page_section_item"><?php
						?><span class="downloads_page_label"><?php
							trx_addons_show_layout(trx_addons_prepare_macros($detail['title'])); 
						?>:</span><?php
						?><span class="downloads_page_data"><?php 
							trx_addons_show_layout(trx_addons_prepare_macros($detail['value'])); 
						?></span>
					</span><?php
				}
			}
		}
	?></div>
</section><?php

// Marketplace
?><section class="downloads_page_section downloads_page_marketplaces"><?php
	// Title
	?><h4 class="downloads_page_section_title"><?php esc_html_e('Marketplace', 'trx_addons'); ?></h4><?php
	// Data
	?><div class="downloads_page_features_list">
		<?php trx_addons_show_layout(trx_addons_get_post_terms('<span class="downloads_page_data_separator"></span>', get_the_ID(), TRX_ADDONS_EDD_TAXONOMY_MARKET)); ?>
	</div>
</section><?php

// Compatibilities
?><section class="downloads_page_section downloads_page_compatibilities"><?php
	// Title
	?><h4 class="downloads_page_section_title"><?php esc_html_e('Compatible with', 'trx_addons'); ?></h4><?php
	// Data
	?><div class="downloads_page_features_list">
		<?php trx_addons_show_layout(trx_addons_get_post_terms('<span class="downloads_page_data_separator"></span>', get_the_ID(), TRX_ADDONS_EDD_TAXONOMY_COMPATIBILITY)); ?>
	</div>
</section><?php

// Browsers support
?><section class="downloads_page_section downloads_page_browsers"><?php
	// Title
	?><h4 class="downloads_page_section_title"><?php esc_html_e('Browsers support', 'trx_addons'); ?></h4><?php
	// Data
	?><div class="downloads_page_features_list">
		<?php trx_addons_show_layout(trx_addons_get_post_terms('<span class="downloads_page_data_separator"></span>', get_the_ID(), TRX_ADDONS_EDD_TAXONOMY_BROWSERS)); ?>
	</div>
</section><?php

// Package items
?><section class="downloads_page_section downloads_page_packages"><?php
	// Title
	?><h4 class="downloads_page_section_title"><?php esc_html_e('Package parts', 'trx_addons'); ?></h4><?php
	// Data
	?><div class="downloads_page_features_list">
		<?php trx_addons_show_layout(trx_addons_get_post_terms('<span class="downloads_page_data_separator"></span>', get_the_ID(), TRX_ADDONS_EDD_TAXONOMY_PACKAGE)); ?>
	</div>
</section><?php

// Plugins included
?><section class="downloads_page_section downloads_page_plugins"><?php
	// Title
	?><h4 class="downloads_page_section_title"><?php esc_html_e('Plugins included', 'trx_addons'); ?></h4><?php
	// Data
	?><div class="downloads_page_features_list">
		<?php trx_addons_show_layout(trx_addons_get_post_terms('<span class="downloads_page_data_separator"></span>', get_the_ID(), TRX_ADDONS_EDD_TAXONOMY_PLUGINS)); ?>
	</div>
</section><?php

// Tags
?><section class="downloads_page_section downloads_page_tags"><?php
	// Title
	?><h4 class="downloads_page_section_title"><?php esc_html_e('Tags', 'trx_addons'); ?></h4><?php
	// Data
	?><div class="downloads_page_data">
		<?php trx_addons_show_layout(trx_addons_get_post_terms('<span class="downloads_page_data_separator"></span>', get_the_ID(), TRX_ADDONS_EDD_TAXONOMY_TAG)); ?>
	</div>
</section><?php

?></div>