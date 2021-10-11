<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/essential/
 * @copyright 2018 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

?>

<div id="esg-libary-wrapper">
	<div id="eg_library_header_part">
		<h2 class="topheader"><?php _e('Template Library', EG_TEXTDOMAIN); ?></h2>

		<div id="esg-close-template"></div>

		<div class="esg-library-switcher">
			<div id="esg-library-filter-buttons-wrapper" style="display:inline-block">
				<span class="esg-btn esg_library_filter_button selected" data-type="temp_all"><?php _e('All Grids', EG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_even"><?php _e('Even', EG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_masonry"><?php _e('Masonry', EG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_fullscreen"><?php _e('Full Screen', EG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_fullwidth"><?php _e('Full Width', EG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_loadmore"><?php _e('Load More', EG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_clients"><?php _e('Clients', EG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_pricetables"><?php _e('Price Tables', EG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_variablecolumns"><?php _e('Variable Columns', EG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_woocommerce"><?php _e('Woo Commerce', EG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_filterdropdown"><?php _e('Filter Dropdown', EG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_streams"><?php _e('Streams', EG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg-purple esg_library_filter_button esg_libr_new_udpated" data-type="temp_newupdate"><?php _e('New / Updated', EG_TEXTDOMAIN); ?></span>
			</div>

			<div style="display:inline-block; float:right" class="esg-btn esg-red esg-reload-shop"><i class="eg-icon-arrows-ccw"></i><?php _e('Update Library', EG_TEXTDOMAIN); ?></div>

		</div>
	</div>

	<!-- THE GRID BASE TEMPLATES -->
	<div id="esg-library-grids" class="esg-library-groups">
		<!-- TEMPLATES WILL BE ADDED OVER AJAX -->
	</div>
</div>


<div id="dialog_import_library_grid_from" title="<?php _e('Import Library Grid', EG_TEXTDOMAIN); ?>" class="dialog_import_library_grid_from" style="display:none">
	<form action="<?php //echo RevSliderBase::$url_ajax; ?>" enctype="multipart/form-data" method="post" name="esg-import-template-from-server" id="esg-import-template-from-server">
		<input type="hidden" name="action" value="revslider_ajax_action">
		<input type="hidden" name="client_action" value="import_slider_online_template_slidersview">
		<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("Essential_Grid_actions"); ?>">
		<input type="hidden" name="uid" class="esg-uid" value="">
		<input type="hidden" name="page-creation" class="esg-page-creation" value="false">
	</form>
</div>

<div id="dialog_import_library_grid_info" title="<?php _e('Importing Status', EG_TEXTDOMAIN); ?>" class="dialog_import_library_grid_info" style="display:none">
	<!-- ADD INFOS HERE ON DEMAND -->
	<div class="esg_logo_rotating">
		<div class="import-spinner">
			<div>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
		</div>
	</div>
	<div id="install-grid-counter-wrapper"><span id="install-grid-counter"></span></div>
	<div id="nowinstalling_label"><?php _e('Now Installing', EG_TEXTDOMAIN); ?></div>
	<div id="import_dialog_box_action"></div>
	<div id="import_dialog_box"></div>
</div>



<div id="esg-premium-benefits-dialog" style="display: none;">
	<div class="esg-premium-benefits-dialogtitles" id="esg-wrong-purchase-code-title">
		<span class="oppps-icon"></span>
		<span class="benefits-title-right">
			<span class="esg-premium-benefits-dialogtitle"><?php _e('Ooops... Wrong Purchase Code!', EG_TEXTDOMAIN); ?></span>
			<span class="esg-premium-benefits-dialogsubtitle"><?php _e('Maybe just a typo? (Click <a target="_blank" href="https://revolution.themepunch.com/direct-customer-benefits/#productactivation">here</a> to find out how to locate your Essential Grid purchase code.)', EG_TEXTDOMAIN); ?></span>
		</span>
	</div>
	<div style="display:none" class="esg-premium-benefits-dialogtitles" id="esg-plugin-update-feedback-title">
		<span class="oppps-icon-red"></span>
		<span class="benefits-title-right">
			<span class="esg-premium-benefits-dialogtitle"><?php _e('Plugin Activation Required'); ?></span>
			<span class="esg-premium-benefits-dialogsubtitle"><?php _e('In order to download the <a target="_blank" href="https://account.essential-grid.com/licenses/pricing/">latest update</a> instantly', EG_TEXTDOMAIN); ?></span>
		</span>
	</div>
	<div style="display:none" class="esg-premium-benefits-dialogtitles" id="esg-plugin-download-template-feedback-title">
		<span class="oppps-icon"></span>
		<span class="benefits-title-right">
			<span class="esg-premium-benefits-dialogtitle"><?php _e('Plugin Activation Required'); ?></span>
			<span class="esg-premium-benefits-dialogsubtitle"><?php _e('In order to gain instant access to the entire <a target="_blank" href="https://www.essential-grid.com">Grid Library</a>', EG_TEXTDOMAIN); ?></span>
		</span>
	</div>

	<div id="basic_premium_benefits_block">
		<div class="esg-premium-benefits-block rspb-withborder">
			<h3><i class="big_present"></i><?php _e('If you purchased a theme that bundled Essential Grid', EG_TEXTDOMAIN); ?></h3>
			<ul>
				<li><?php _e('No activation needed to use / create grids with Essential Grid', EG_TEXTDOMAIN); ?></li>
				<li><?php _e('Update manually through your theme', EG_TEXTDOMAIN); ?></li>
				<li><?php _e('Access our <a target="_blank" class="rspb_darklink" href="https://www.themepunch.com/support-center/#support">FAQ database</a> and <a target="_blank" class="rspb_darklink" href="https://www.youtube.com/playlist?list=PLSCdqDWVMJPNjFD1dYYw7GiclPyCfY-z7">video tutorials</a> for help', EG_TEXTDOMAIN); ?></li>
			</ul>
		</div>
		<div class="esg-premium-benefits-block">
			<h3><i class="big_diamond"></i><?php _e('Activate Essential Grid for', EG_TEXTDOMAIN); ?> <span class="instant_access"></span> <?php _e('to ...', EG_TEXTDOMAIN); ?></h3>
			<ul>
				<li><?php _e('<a target="_blank" href="https://www.themepunch.com/faq/how-to-update-essential-grid/">Update</a> to the latest version directly from your dashboard', EG_TEXTDOMAIN); ?></li>
				<li><?php _e('<a target="_blank" href="https://themepunch.support/">Support</a> ThemePunch ticket desk', EG_TEXTDOMAIN); ?></li>
				<li><?php _e('<a target="_blank" href="https://www.essential-grid.com">Library</a> with tons of free premium grids', EG_TEXTDOMAIN); ?></li>
			</ul>
		</div>
		<a target="_blank" class="get_purchase_code" href="https://account.essential-grid.com/licenses/pricing/"><?php _e('GET A PURCHASE CODE', EG_TEXTDOMAIN); ?></a>
	</div>
</div>



<script type="text/javascript">
	var initGridLibraryRoutine_once = false
	if (document.readyState === "loading") 
		document.addEventListener('readystatechange',function(){
			if ((document.readyState === "interactive" || document.readyState === "complete") && !initGridLibraryRoutine_once) {
				initGridLibraryRoutine_once = true;
				AdminEssentials.initGridLibraryRoutine();
			}
		});
	else {
		initGridLibraryRoutine_once = true;
		AdminEssentials.initGridLibraryRoutine();
	}
	

</script>
