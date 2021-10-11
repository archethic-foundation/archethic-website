<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2020 ThemePunch
 */
 
if( !defined( 'ABSPATH') ) exit();

class Essential_Grid_Dialogs {
	
	
	/**
	 * Insert Pages Dialog
	 * @since    1.0.0
	 */
	public static function pages_select_dialog(){
		$pages = apply_filters('essgrid_pages_select_dialog', get_pages(array('sort_column' => 'post_name')));
		?>
		<div id="pages-select-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Choose Pages', EG_TEXTDOMAIN); ?>"  style="display: none;padding:20px !important;">
			<label><?php echo _e('Choose Pages', EG_TEXTDOMAIN); ?></label><!--
			--><div style="line-height:30px; display:inline-block"><input type="checkbox" id="check-uncheck-pages"><div class="space18"></div><?php echo _e('Select All', EG_TEXTDOMAIN); ?></div><div class="div5"></div>			
			
				<?php
				foreach($pages as $page){
					?>
					<label></label><div style="line-height:30px; display:inline-block"><input type="checkbox" value="<?php echo str_replace('"', '', $page->post_title).' (ID: '.$page->ID.')'; ?>" name="selected-pages"><div class="space18"></div><?php echo str_replace('"', '', $page->post_title).' (ID: '.$page->ID.')'; ?></div><div class="div5"></div>
					<?php
				}
				?>
			
			<?php
			do_action('essgrid_pages_select_dialog_post', $pages);
			?>
		</div>
		<?php
	}
	
	
	/**
	 * Insert global CSS Dialog
	 * @since    1.0.0
	 */
	public static function global_css_edit_dialog(){
		$global_css = apply_filters('essgrid_global_css_edit_dialog', Essential_Grid_Global_Css::get_global_css_styles());
		?>
		<div id="global-css-edit-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Global Custom CSS', EG_TEXTDOMAIN); ?>"  style="display: none;">
			<textarea id="eg-global-css-editor"><?php echo $global_css; ?></textarea>
			<?php
			do_action('essgrid_global_css_edit_dialog_post', $global_css);
			?>
		</div>
		<?php
	}

	/**
	 * Insert Open Imported Grid Dialog
	 * @since    1.0.0
	 */
	public static function open_imported_grid(){
		?>
		<div id="open_imported_grid" class="essential-dialog-wrap" title="<?php _e('Open Imported Grid', EG_TEXTDOMAIN); ?>"  style="display: none;padding:20px !important;">
			<label style="width:100%"><?php _e('Do you want to edit the imported Grid ?', EG_TEXTDOMAIN); ?></label>
			<?php
			do_action('open_imported_grid_post');
			?>
		</div>
		<?php
	}
	
	
	/**
	 * Insert navigation skin CSS Dialog
	 * @since    1.0.0
	 */
	public static function navigation_skin_css_edit_dialog(){
		?>
		<div id="navigation-skin-css-edit-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Navigation Skin CSS', EG_TEXTDOMAIN); ?>"  style="display: none;">
			<textarea id="eg-navigation-skin-css-editor"></textarea>
			<?php
			do_action('essgrid_navigation_skin_css_edit_dialog_post');
			?>
		</div>
		<?php
	}

	

	/**
	 * Insert navigation skin CSS Dialog
	 * @since    1.0.0
	 */
	public static function navigation_skin_css_selector_dialog(){
		?>
		<div id="navigation-skin-css-selector-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Navigation Skin CSS Selector', EG_TEXTDOMAIN); ?>"  style="display: none;">			
			<div class="esg-simp-row"><label class="eg-tooltip-wrap tooltipstered"><?php _e('Navigation Template', EG_TEXTDOMAIN); ?></label><select id="navigation-skin-css-selector"></select></div>
			<div class="esg-simp-row"><label class="eg-tooltip-wrap tooltipstered"><?php _e('Skin Name', EG_TEXTDOMAIN); ?></label><input type="text" id="navigation-skin-css-name"></div>
			<div class="esg-simp-row"><label class="eg-tooltip-wrap tooltipstered"><?php _e('Class Name', EG_TEXTDOMAIN); ?></label><span id="navigation-skin-css-class-name"></span></div>
			<?php
			do_action('essgrid_navigation_skin_css_selector_dialog_post');
			?>
		</div>
		<?php
	}
    
	
	/**
	 * Fontello Icons
	 * @since    1.0.0
	 */
	public static function fontello_icons_dialog(){
		?>
		<div id="eg-fontello-icons-dialog-wrap" style="width:602px; height:405px; margin-left:15px;overflow:scroll;display:none">
			<div class="font_headline">Fontello Icons</div>
			<!--<div id="dialog-eg-fakeicon-in"></div>
			<div id="dialog-eg-fakeicon-out"></div>	-->
			<div class="eg-icon-chooser eg-icon-soundcloud"></div><!--
			--><div class="eg-icon-chooser eg-icon-music"></div><!--
			--><div class="eg-icon-chooser eg-icon-color-adjust"></div><!--
			--><div class="eg-icon-chooser eg-icon-mail"></div><!--
			--><div class="eg-icon-chooser eg-icon-mail-alt"></div><!--
			--><div class="eg-icon-chooser eg-icon-heart"></div><!--
			--><div class="eg-icon-chooser eg-icon-heart-empty"></div><!--
			--><div class="eg-icon-chooser eg-icon-star"></div><!--
			--><div class="eg-icon-chooser eg-icon-star-empty"></div><!--
			--><div class="eg-icon-chooser eg-icon-user"></div><!--
			--><div class="eg-icon-chooser eg-icon-male"></div><!--
			--><div class="eg-icon-chooser eg-icon-female"></div><!--
			--><div class="eg-icon-chooser eg-icon-video"></div><!--
			--><div class="eg-icon-chooser eg-icon-videocam"></div><!--
			--><div class="eg-icon-chooser eg-icon-picture-1"></div><!--
			--><div class="eg-icon-chooser eg-icon-camera"></div><!--
			--><div class="eg-icon-chooser eg-icon-camera-alt"></div><!--
			--><div class="eg-icon-chooser eg-icon-th-large"></div><!--
			--><div class="eg-icon-chooser eg-icon-th"></div><!--
			--><div class="eg-icon-chooser eg-icon-ok"></div><!--
			--><div class="eg-icon-chooser eg-icon-ok-circled2"></div><!--
			--><div class="eg-icon-chooser eg-icon-ok-squared"></div><!--
			--><div class="eg-icon-chooser eg-icon-cancel"></div><!--
			--><div class="eg-icon-chooser eg-icon-plus"></div><!--
			--><div class="eg-icon-chooser eg-icon-plus-circled"></div><!--
			--><div class="eg-icon-chooser eg-icon-plus-squared"></div><!--
			--><div class="eg-icon-chooser eg-icon-minus"></div><!--
			--><div class="eg-icon-chooser eg-icon-minus-circled"></div><!--
			--><div class="eg-icon-chooser eg-icon-minus-squared"></div><!--
			--><div class="eg-icon-chooser eg-icon-minus-squared-alt"></div><!--
			--><div class="eg-icon-chooser eg-icon-info-circled"></div><!--
			--><div class="eg-icon-chooser eg-icon-info"></div><!--
			--><div class="eg-icon-chooser eg-icon-home"></div><!--
			--><div class="eg-icon-chooser eg-icon-link"></div><!--
			--><div class="eg-icon-chooser eg-icon-unlink"></div><!--
			--><div class="eg-icon-chooser eg-icon-link-ext"></div><!--
			--><div class="eg-icon-chooser eg-icon-lock"></div><!--
			--><div class="eg-icon-chooser eg-icon-lock-open"></div><!--
			--><div class="eg-icon-chooser eg-icon-eye"></div><!--
			--><div class="eg-icon-chooser eg-icon-eye-off"></div><!--
			--><div class="eg-icon-chooser eg-icon-tag"></div><!--
			--><div class="eg-icon-chooser eg-icon-thumbs-up"></div><!--
			--><div class="eg-icon-chooser eg-icon-thumbs-up-alt"></div><!--
			--><div class="eg-icon-chooser eg-icon-download"></div><!--
			--><div class="eg-icon-chooser eg-icon-upload"></div><!--
			--><div class="eg-icon-chooser eg-icon-reply"></div><!--
			--><div class="eg-icon-chooser eg-icon-forward"></div><!--
			--><div class="eg-icon-chooser eg-icon-export-1"></div><!--
			--><div class="eg-icon-chooser eg-icon-print"></div><!--
			--><div class="eg-icon-chooser eg-icon-gamepad"></div><!--
			--><div class="eg-icon-chooser eg-icon-trash"></div><!--
			--><div class="eg-icon-chooser eg-icon-doc-text"></div><!--
			--><div class="eg-icon-chooser eg-icon-doc-inv"></div><!--
			--><div class="eg-icon-chooser eg-icon-folder-1"></div><!--
			--><div class="eg-icon-chooser eg-icon-folder-open"></div><!--
			--><div class="eg-icon-chooser eg-icon-folder-open-empty"></div><!--
			--><div class="eg-icon-chooser eg-icon-rss"></div><!--
			--><div class="eg-icon-chooser eg-icon-rss-squared"></div><!--
			--><div class="eg-icon-chooser eg-icon-phone"></div><!--
			--><div class="eg-icon-chooser eg-icon-menu"></div><!--
			--><div class="eg-icon-chooser eg-icon-cog-alt"></div><!--
			--><div class="eg-icon-chooser eg-icon-wrench"></div><!--
			--><div class="eg-icon-chooser eg-icon-basket-1"></div><!--
			--><div class="eg-icon-chooser eg-icon-calendar"></div><!--
			--><div class="eg-icon-chooser eg-icon-calendar-empty"></div><!--
			--><div class="eg-icon-chooser eg-icon-lightbulb"></div><!--
			--><div class="eg-icon-chooser eg-icon-resize-full-alt"></div><!--
			--><div class="eg-icon-chooser eg-icon-move"></div><!--
			--><div class="eg-icon-chooser eg-icon-down-dir"></div><!--
			--><div class="eg-icon-chooser eg-icon-up-dir"></div><!--
			--><div class="eg-icon-chooser eg-icon-left-dir"></div><!--
			--><div class="eg-icon-chooser eg-icon-right-dir"></div><!--
			--><div class="eg-icon-chooser eg-icon-down-open"></div><!--
			--><div class="eg-icon-chooser eg-icon-left-open"></div><!--
			--><div class="eg-icon-chooser eg-icon-right-open"></div><!--
			--><div class="eg-icon-chooser eg-icon-angle-left"></div><!--
			--><div class="eg-icon-chooser eg-icon-angle-right"></div><!--
			--><div class="eg-icon-chooser eg-icon-angle-double-left"></div><!--
			--><div class="eg-icon-chooser eg-icon-angle-double-right"></div><!--
			--><div class="eg-icon-chooser eg-icon-left-big"></div><!--
			--><div class="eg-icon-chooser eg-icon-right-big"></div><!--
			--><div class="eg-icon-chooser eg-icon-up-hand"></div><!--
			--><div class="eg-icon-chooser eg-icon-ccw-1"></div><!--
			--><div class="eg-icon-chooser eg-icon-shuffle-1"></div><!--
			--><div class="eg-icon-chooser eg-icon-play"></div><!--
			--><div class="eg-icon-chooser eg-icon-play-circled"></div><!--
			--><div class="eg-icon-chooser eg-icon-stop"></div><!--
			--><div class="eg-icon-chooser eg-icon-pause"></div><!--
			--><div class="eg-icon-chooser eg-icon-fast-fw"></div><!--
			--><div class="eg-icon-chooser eg-icon-desktop"></div><!--
			--><div class="eg-icon-chooser eg-icon-laptop"></div><!--
			--><div class="eg-icon-chooser eg-icon-tablet"></div><!--
			--><div class="eg-icon-chooser eg-icon-mobile"></div><!--
			--><div class="eg-icon-chooser eg-icon-flight"></div><!--
			--><div class="eg-icon-chooser eg-icon-font"></div><!--
			--><div class="eg-icon-chooser eg-icon-bold"></div><!--
			--><div class="eg-icon-chooser eg-icon-italic"></div><!--
			--><div class="eg-icon-chooser eg-icon-text-height"></div><!--
			--><div class="eg-icon-chooser eg-icon-text-width"></div><!--
			--><div class="eg-icon-chooser eg-icon-align-left"></div><!--
			--><div class="eg-icon-chooser eg-icon-align-center"></div><!--
			--><div class="eg-icon-chooser eg-icon-align-right"></div><!--
			--><div class="eg-icon-chooser eg-icon-search"></div><!--
			--><div class="eg-icon-chooser eg-icon-indent-left"></div><!--
			--><div class="eg-icon-chooser eg-icon-indent-right"></div><!--
			--><div class="eg-icon-chooser eg-icon-ajust"></div><!--
			--><div class="eg-icon-chooser eg-icon-tint"></div><!--
			--><div class="eg-icon-chooser eg-icon-chart-bar"></div><!--
			--><div class="eg-icon-chooser eg-icon-magic"></div><!--
			--><div class="eg-icon-chooser eg-icon-sort"></div><!--
			--><div class="eg-icon-chooser eg-icon-sort-alt-up"></div><!--
			--><div class="eg-icon-chooser eg-icon-sort-alt-down"></div><!--
			--><div class="eg-icon-chooser eg-icon-sort-name-up"></div><!--
			--><div class="eg-icon-chooser eg-icon-sort-name-down"></div><!--
			--><div class="eg-icon-chooser eg-icon-coffee"></div><!--
			--><div class="eg-icon-chooser eg-icon-food"></div><!--
			--><div class="eg-icon-chooser eg-icon-medkit"></div><!--
			--><div class="eg-icon-chooser eg-icon-puzzle"></div><!--
			--><div class="eg-icon-chooser eg-icon-apple"></div><!--
			--><div class="eg-icon-chooser eg-icon-facebook"></div><!--
			--><div class="eg-icon-chooser eg-icon-gplus"></div><!--
			--><div class="eg-icon-chooser eg-icon-tumblr"></div><!--
			--><div class="eg-icon-chooser eg-icon-twitter-squared"></div><!--
			--><div class="eg-icon-chooser eg-icon-twitter"></div><!--
			--><div class="eg-icon-chooser eg-icon-vimeo-squared"></div><!--
			--><div class="eg-icon-chooser eg-icon-youtube"></div><!--
			--><div class="eg-icon-chooser eg-icon-youtube-squared"></div><!--
			--><div class="eg-icon-chooser eg-icon-picture"></div><!--
			--><div class="eg-icon-chooser eg-icon-check"></div><!--
			--><div class="eg-icon-chooser eg-icon-back"></div><!--
			--><div class="eg-icon-chooser eg-icon-thumbs-up-1"></div><!--
			--><div class="eg-icon-chooser eg-icon-thumbs-down"></div><!--
			--><div class="eg-icon-chooser eg-icon-download-1"></div><!--
			--><div class="eg-icon-chooser eg-icon-upload-1"></div><!--
			--><div class="eg-icon-chooser eg-icon-reply-1"></div><!--
			--><div class="eg-icon-chooser eg-icon-forward-1"></div><!--
			--><div class="eg-icon-chooser eg-icon-export"></div><!--
			--><div class="eg-icon-chooser eg-icon-folder"></div><!--
			--><div class="eg-icon-chooser eg-icon-rss-1"></div><!--
			--><div class="eg-icon-chooser eg-icon-cog"></div><!--
			--><div class="eg-icon-chooser eg-icon-tools"></div><!--
			--><div class="eg-icon-chooser eg-icon-basket"></div><!--
			--><div class="eg-icon-chooser eg-icon-login"></div><!--
			--><div class="eg-icon-chooser eg-icon-logout"></div><!--
			--><div class="eg-icon-chooser eg-icon-resize-full"></div><!--
			--><div class="eg-icon-chooser eg-icon-popup"></div><!--
			--><div class="eg-icon-chooser eg-icon-arrow-combo"></div><!--
			--><div class="eg-icon-chooser eg-icon-left-open-1"></div><!--
			--><div class="eg-icon-chooser eg-icon-right-open-1"></div><!--
			--><div class="eg-icon-chooser eg-icon-left-open-mini"></div><!--
			--><div class="eg-icon-chooser eg-icon-right-open-mini"></div><!--
			--><div class="eg-icon-chooser eg-icon-left-open-big"></div><!--
			--><div class="eg-icon-chooser eg-icon-right-open-big"></div><!--
			--><div class="eg-icon-chooser eg-icon-left"></div><!--
			--><div class="eg-icon-chooser eg-icon-right"></div><!--
			--><div class="eg-icon-chooser eg-icon-ccw"></div><!--
			--><div class="eg-icon-chooser eg-icon-cw"></div><!--
			--><div class="eg-icon-chooser eg-icon-arrows-ccw"></div><!--
			--><div class="eg-icon-chooser eg-icon-level-down"></div><!--
			--><div class="eg-icon-chooser eg-icon-level-up"></div><!--
			--><div class="eg-icon-chooser eg-icon-shuffle"></div><!--
			--><div class="eg-icon-chooser eg-icon-palette"></div><!--
			--><div class="eg-icon-chooser eg-icon-list-add"></div><!--
			--><div class="eg-icon-chooser eg-icon-back-in-time"></div><!--
			--><div class="eg-icon-chooser eg-icon-monitor"></div><!--
			--><div class="eg-icon-chooser eg-icon-paper-plane"></div><!--
			--><div class="eg-icon-chooser eg-icon-brush"></div><!--
			--><div class="eg-icon-chooser eg-icon-droplet"></div><!--
			--><div class="eg-icon-chooser eg-icon-clipboard"></div><!--
			--><div class="eg-icon-chooser eg-icon-megaphone"></div><!--
			--><div class="eg-icon-chooser eg-icon-key"></div><!--
			--><div class="eg-icon-chooser eg-icon-github"></div><!--
			--><div class="eg-icon-chooser eg-icon-github-circled"></div><!--
			--><div class="eg-icon-chooser eg-icon-flickr"></div><!--
			--><div class="eg-icon-chooser eg-icon-flickr-circled"></div><!--
			--><div class="eg-icon-chooser eg-icon-vimeo"></div><!--
			--><div class="eg-icon-chooser eg-icon-vimeo-circled"></div><!--
			--><div class="eg-icon-chooser eg-icon-twitter-1"></div><!--
			--><div class="eg-icon-chooser eg-icon-twitter-circled"></div><!--
			--><div class="eg-icon-chooser eg-icon-facebook-1"></div><!--
			--><div class="eg-icon-chooser eg-icon-facebook-circled"></div><!--
			--><div class="eg-icon-chooser eg-icon-facebook-squared"></div><!--
			--><div class="eg-icon-chooser eg-icon-gplus-1"></div><!--
			--><div class="eg-icon-chooser eg-icon-gplus-circled"></div><!--
			--><div class="eg-icon-chooser eg-icon-pinterest"></div><!--
			--><div class="eg-icon-chooser eg-icon-pinterest-circled"></div><!--
			--><div class="eg-icon-chooser eg-icon-tumblr-1"></div><!--
			--><div class="eg-icon-chooser eg-icon-tumblr-circled"></div><!--
			--><div class="eg-icon-chooser eg-icon-linkedin"></div><!--
			--><div class="eg-icon-chooser eg-icon-linkedin-circled"></div><!--
			--><div class="eg-icon-chooser eg-icon-dribbble"></div><!--
			--><div class="eg-icon-chooser eg-icon-dribbble-circled"></div><!--
			--><div class="eg-icon-chooser eg-icon-picasa"></div><!--
			--><div class="eg-icon-chooser eg-icon-ok-1"></div><!--
			--><div class="eg-icon-chooser eg-icon-doc"></div><!--
			--><div class="eg-icon-chooser eg-icon-left-open-outline"></div><!--
			--><div class="eg-icon-chooser eg-icon-left-open-2"></div><!--
			--><div class="eg-icon-chooser eg-icon-right-open-outline"></div><!--
			--><div class="eg-icon-chooser eg-icon-right-open-2"></div><!--
			--><div class="eg-icon-chooser eg-icon-equalizer"></div><!--
			--><div class="eg-icon-chooser eg-icon-layers-alt"></div><!--
			--><div class="eg-icon-chooser eg-icon-pencil-1"></div><!--
			--><div class="eg-icon-chooser eg-icon-align-justify"></div>
			<?php
				$enable_fontello = get_option('tp_eg_global_enable_fontello', 'backfront');
				$enable_font_awesome = get_option('tp_eg_global_enable_font_awesome', 'false');
				$enable_pe7 = get_option('tp_eg_global_enable_pe7', 'false');	
				if($enable_font_awesome!="false") include(EG_PLUGIN_PATH."admin/views/skin-font-awesome-list.php");
				if($enable_pe7!="false") include(EG_PLUGIN_PATH."admin/views/skin-pe-icon-7-stroke-list.php");
			
			do_action('essgrid_fontello_icons_dialog_post');
			?>
		</div>
        <?php
	}
	
	
	/**
	 * Insert custom meta Dialog
	 * @since    1.0.0
	 */
	public static function custom_meta_dialog(){
		?>
		<div id="custom-meta-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Custom Meta', EG_TEXTDOMAIN); ?>"  style="display: none; padding:20px !important;">
			<label><?php _e('Name', EG_TEXTDOMAIN); ?></label><input type="text" name="eg-custom-meta-name" value="" />			
			<div class="div13"></div>
			<label><?php _e('Handle', EG_TEXTDOMAIN); ?></label><strong style="margin-left:-21px;line-height: 30px">eg-</strong><input type="text" name="eg-custom-meta-handle" value="" />
			<div class="div20"></div>
			<strong style="font-size:14px"><?php _e('SETTINGS', EG_TEXTDOMAIN); ?></strong>
			<div class="div13"></div>
			<label><?php _e('Default', EG_TEXTDOMAIN); ?></label><input type="text" name="eg-custom-meta-default" value="" />
			<div class="div13"></div>
			<label><?php _e('Type', EG_TEXTDOMAIN); ?></label><select name="eg-custom-meta-type"><option value="text"><?php _e('Text', EG_TEXTDOMAIN); ?></option><option value="multi-select"><?php _e('Multi Select', EG_TEXTDOMAIN); ?></option><option value="select"><?php _e('Select', EG_TEXTDOMAIN); ?></option><option value="image"><?php _e('Image', EG_TEXTDOMAIN); ?></option></select>
			<div id="eg-custom-meta-select-wrap" style="display: none;">
				<div class="div13"></div>
				<?php _e('Comma Seperated List of Elements', EG_TEXTDOMAIN); ?>
				<textarea name="eg-custom-meta-select" style="width: 100%;height: 70px;"></textarea>
			</div>			
			<div class="div13"></div>
			<label><?php _e('Sort Type', EG_TEXTDOMAIN); ?></label><select name="eg-custom-meta-sort-type"><option value="alphabetic"><?php _e('Alphabetic', EG_TEXTDOMAIN); ?></option><option value="numeric"><?php _e('Numeric', EG_TEXTDOMAIN); ?></option></select>
			<?php
			do_action('essgrid_custom_meta_dialog_post');
			?>
		</div>
		<?php
	}
	
	
	/**
	 * Insert link meta Dialog
	 * @since    1.5.0
	 */
	public static function custom_meta_linking_dialog(){
		?>
		<div id="link-meta-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Meta References', EG_TEXTDOMAIN); ?>"  style="display: none; padding:15px !important;">
			
			<label><?php _e('Name:', EG_TEXTDOMAIN); ?></label><input type="text" name="eg-link-meta-name" value="" />
			<div class="div20"></div>
			<strong style="font-size:14px"><?php _e('HANDLES', EG_TEXTDOMAIN); ?></strong>
			<div class="div13"></div>
			<label><?php _e('Internal:', EG_TEXTDOMAIN); ?></label><strong style="margin-left:-25px;line-height: 30px">egl-</strong><input type="text" name="eg-link-meta-handle" value="" />
			<div class="div13"></div>
			<label><?php _e('Original:', EG_TEXTDOMAIN); ?></label><input type="text" name="eg-link-meta-original" value="" />
			<div class="div20"></div>
			<strong style="font-size:14px"><?php _e('SORTING', EG_TEXTDOMAIN); ?></strong>		
			<div class="div13"></div>
			<label><?php _e('Sort Type:', EG_TEXTDOMAIN); ?></label><select name="eg-link-meta-sort-type"><option value="alphabetic"><?php _e('Alphabetic', EG_TEXTDOMAIN); ?></option><option value="numeric"><?php _e('Numeric', EG_TEXTDOMAIN); ?></option></select>
			
			<?php
			do_action('essgrid_custom_meta_linking_dialog_post');
			?>
		</div>
		<?php
	}
	
	
	/**
	 * Insert Widget Areas Dialog
	 * @since    1.0.0
	 */
	public static function widget_areas_dialog(){
		?>
		<div id="widget-areas-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('New Widget Area', EG_TEXTDOMAIN); ?>"  style="display: none; padding:20px !important;">
			
			<div class="eg-cus-row-l"><label><?php _e('Handle:', EG_TEXTDOMAIN); ?></label><span style="margin-right:2px;"><strong>eg-</strong></span><input type="text" name="eg-widget-area-handle" value="" /></div>
			<div class="eg-cus-row-l"><label><?php _e('Name:', EG_TEXTDOMAIN); ?></label><input type="text" name="eg-widget-area-name" style="margin-left:29px;" value="" /></div>
			<?php
			do_action('essgrid_widget_areas_dialog_post');
			?>
		</div>
		<?php
	}
	
	
	/**
	 * Insert font Dialog
	 * @since    1.0.0
	 */
	public static function fonts_dialog(){
		?>
		<div id="font-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Add Font', EG_TEXTDOMAIN); ?>"  style="display: none; padding:20px !important;">
			
			<label><?php _e('Handle:', EG_TEXTDOMAIN); ?></label><span style="margin-left:-20px;line-height:30px"><strong>tp-</strong></span><input type="text" name="eg-font-handle" value="" />
			<div style="margin-top:0px; padding-left:100px; margin-bottom:20px;">
				<i style="font-size:12px;color:#777; line-height:20px;"><?php _e('Unique WordPress handle (Internal use only)', EG_TEXTDOMAIN); ?></i>
			</div>
			<div class="div13"></div>
			<label><?php _e('Parameter:', EG_TEXTDOMAIN); ?></label><input type="text" name="eg-font-url" value="" />
			<div style="padding-left:100px;">
				<i style="font-size:12px;color:#777; line-height:20px;"><?php _e('Copy the Google Font Family from <a href="http://www.google.com/fonts" target="_blank">http://www.google.com/fonts</a><br/>i.e.:<strong>Open+Sans:400,600,700</strong>', EG_TEXTDOMAIN); ?></i>
			</div>
			<?php
			do_action('essgrid_fonts_dialog_post');
			?>
		</div>
		
		
		<?php
	}
	
	
	/**
	 * Meta Dialog
	 * @since    1.0.0
	 */
	public static function meta_dialog(){
	
		$m = new Essential_Grid_Meta();
		$item_ele = new Essential_Grid_Item_Element();
		
		$post_items = $item_ele->getPostElementsArray();
		$metas = $m->get_all_meta();
		//$custom_meta = $m->get_all_meta(false);
		?>
		<div id="meta-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Meta Key Picker', EG_TEXTDOMAIN); ?>"  style="display: none; padding:0px !important;">
			<table>
				<tr class="eg-table-title"><td><?php _e('Meta Handle', EG_TEXTDOMAIN); ?></td><td><?php _e('Description', EG_TEXTDOMAIN); ?>
			<?php
			if(!empty($post_items)){
				foreach($post_items as $phandle => $pitem){
					echo '<tr class="eg-add-meta-to-textarea"><td>%'.$phandle.'%</td><td>'.$pitem['name'].'</td></tr>';
				}
			}
				
			if(!empty($metas)){
				foreach($metas as $meta){
					if($meta['m_type'] == 'link'){
						echo '<tr class="eg-add-meta-to-textarea"><td>%egl-'.$meta['handle'].'%</td><td>'.$meta['name'].'</td></tr>';
					}else{
						echo '<tr class="eg-add-meta-to-textarea"><td>%eg-'.$meta['handle'].'%</td><td>'.$meta['name'].'</td></tr>';
					}
				}
			}

			/*if(!empty($custom_meta)){
				foreach($custom_meta as $meta){
					if($meta['type'] == 'link'){
						echo '<tr class="eg-add-meta-to-textarea"><td>%egl-'.$meta['handle'].'%</td><td>'.$meta['name'].'</td></tr>';
					}else{
						echo '<tr class="eg-add-meta-to-textarea"><td>%eg-'.$meta['handle'].'%</td><td>'.$meta['name'].'</td></tr>';
					}
				}
			}*/
			
			if(Essential_Grid_Woocommerce::is_woo_exists()){
				$metas = Essential_Grid_Woocommerce::get_meta_array();
				
				foreach($metas as $meta => $name){
					echo '<tr><td>%'.$meta.'%</td><td>'.$name.'</td></tr>';
				}
				
			}
			
			do_action('essgrid_meta_dialog_post');
			?>
			</table>
		</div>
		<?php
	}
	
	
	/**
	 * Post Meta Dialog
	 * @since    1.0.0
	 */
	public static function post_meta_dialog(){
		?>
		<div id="post-meta-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Post Meta Editor', EG_TEXTDOMAIN); ?>"  style="display: none; ">
			<div id="eg-meta-box">
			
			</div>
			<?php
			do_action('essgrid_post_meta_dialog_post');
			?>
		</div>
		<?php
	}
	
	
	/**
	 * Custom Element Image Dialog
	 * @since    1.0.1
	 */
	public static function custom_element_image_dialog(){
		?>
		<div id="custom-element-image-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Add Images to Grid', EG_TEXTDOMAIN); ?>"  style="display: none; ">
			<?php
			_e('Please choose how you would like to add image(s) to the grid.<br>Single or bulk upload is possible', EG_TEXTDOMAIN);
			?>
			<div class="div13"></div><!--
			--><label style="width:120px"><?php _e('Add Filter(s)', EG_TEXTDOMAIN); ?></label><input  style="display:none" class="custom-filter-hiddeninput-bulk" type="text" name="custom-filter" value="" /><!--
			--><select style="min-width:260px;max-width:260px" class="custom-filter-list-bulk" multiple="true"></select>
			<div class="div13"></div>
			<label style="width:120px"></label><div class="esg-btn esg-purple add_new_custom_category_quick" style="font-size:12px"><i class="material-icons">add</i><?php _e('New Filter', EG_TEXTDOMAIN); ?></div>
			<?php
			do_action('essgrid_custom_element_image_dialog_post');
			?>
		</div>
		<?php
	}
	
	
	/**
	 * Advanced Rules Dialog for Item Skin Editor
	 * @since    1.5.0
	 */
	public static function edit_advanced_rules_dialog(){
		$base = new Essential_Grid_Base();
		$types = $base->get_media_source_order();
		?>
		<div id="advanced-rules-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Advanced Rules', EG_TEXTDOMAIN); ?>"  style="display: none; ">
			<form id="ar-form-wrap">
				<div class="ad-rules-main">
					<label><?php _e('Show/Hide if rules are true:', EG_TEXTDOMAIN); ?></label><div class="space18"></div><!--
					--><input class="ar-show-field" type="radio" value="show" name="ar-show" checked="checked" /> <?php _e('Show', EG_TEXTDOMAIN); ?><div class="space18"></div><input class="ar-show-field" type="radio" value="hide" name="ar-show" /> <?php _e('Hide', EG_TEXTDOMAIN); ?>
				</div>
				<div class="ar-form-table-wrapper">
					<table style="text-align:center;width: 100%;z-index: 200;">
						<tr style="text-align:center;background:#5d34af; color:#fff">
							<td style="padding:15px 0px;width:145px;"><?php _e('Type', EG_TEXTDOMAIN); ?></td>
							<td style="padding:15px 0px;width:140px;"><?php _e('Meta', EG_TEXTDOMAIN); ?></td>
							<td style="padding:15px 0px;width:85px;"><?php _e('Operator', EG_TEXTDOMAIN); ?></td>
							<td style="padding:15px 0px;width:105px;"><?php _e('Value', EG_TEXTDOMAIN); ?></td>
							<td style="padding:15px 0px;width:105px;"><?php _e('Value', EG_TEXTDOMAIN); ?></td>								
						</tr>
					</table>
				</div>
				<div class="ar-form-table-wrapper" style="height: 345px;width: 100%;overflow: scroll;">
				<?php
				$num = 0;
				for($i=0;$i<=2;$i++){
					?>
					
						<table>							
							<?php 
							for($g=0;$g<=2;$g++){
								?>
								<tr>
									<td style="text-align:center">
										<select class="ar-type-field" id="ar-field-<?php echo $num - 1; ?>" name="ar-type[]" style="width: 150px;">
											<option value="off"><?php _e('--- Choose ---', EG_TEXTDOMAIN); ?></option>
											<?php
											if(!empty($types)){
												foreach($types as $handle => $val){
													?>
													<option value="<?php echo $handle; ?>"><?php echo $val['name']; ?></option>
													<?php
												}
											}
											?>
											<option value="meta"><?php _e('Meta', EG_TEXTDOMAIN); ?></option>
										</select>
									</td>
									<td style="padding-right:0px;">
										<input class="ar-meta-field" style="width: 150px;" type="text" name="ar-meta[]" value="" disabled="disabled" /><div class="ar-open-meta"><i class="material-icons">get_app</i></div>
									</td>
									<td style="text-align:center">
										<select class="ar-operator-field" name="ar-operator[]" style="width: 78px;">
											<option value="isset"><?php _e('isset', EG_TEXTDOMAIN); ?></option>
											<option value="empty"><?php _e('empty', EG_TEXTDOMAIN); ?></option>
											<option class="ar-opt-meta" value="lt"><</option>
											<option class="ar-opt-meta" value="gt">></option>
											<option class="ar-opt-meta" value="equal">==</option>
											<option class="ar-opt-meta" value="notequal">!=</option>
											<option class="ar-opt-meta" value="lte"><=</option>
											<option class="ar-opt-meta" value="gte">>=</option>
											<option class="ar-opt-meta" value="between"><?php _e('between', EG_TEXTDOMAIN); ?></option>
										</select>
									</td>
									<td>
										<input class="ar-value-field" type="text"  style="width: 100px;" name="ar-value[]" value="" />
									</td>
									<td style="padding-right:15px">
										<input style="width: 110px;" type="text"  name="ar-value-2[]" value="" disabled="disabled" />
									</td>
									
								</tr>
								<?php
								if($g !== 2){
									?>
									<tr>
										<td colspan="5" style="text-align:center;">
											<select style="width:100px" class="ar-logic-field" id="ar-field-<?php echo $num; ?>-logic" name="ar-logic[]">
												<option value="and"><?php _e('and', EG_TEXTDOMAIN); ?></option>
												<option value="or"><?php _e('or', EG_TEXTDOMAIN); ?></option>
											</select>
										</td>
									</tr>
									<?php
								}
								$num++;
							}
							?>
						</table>
					
					<?php
					if($i !== 2){
						?>
						<div style="text-align:center;">
							<select style="width:100px" class="ar-logic-glob-field" name="ar-logic-glob[]">
								<option value="and"><?php _e('and', EG_TEXTDOMAIN); ?></option>
								<option value="or"><?php _e('or', EG_TEXTDOMAIN); ?></option>
							</select>							
						</div>
						<?php
					}
				}
				?></div><?php 
				do_action('essgrid_edit_advanced_rules_dialog_post');
				?>
			</form>
		</div>
		<?php
	}
	
	/**
	 * Edit ShortCode Dialog V3.0.0
	 * @since 3.0.0
	 */
	public static function add_esg_shortcode_builder() {  
		$base = new Essential_Grid_Base();
		$grid_c = new Essential_Grid();
		$skins_c = new Essential_Grid_Item_Skin();		
		$grids = Essential_Grid::get_grids_short_vc();
		?>
		<script type="text/javascript">
			var token = '<?php echo wp_create_nonce("Essential_Grid_actions"); ?>';
		</script>
		<div id="eesgShortCodeBuilder" class="essential-dialog-wrap" title="<?php _e('Shortcode Builder', EG_TEXTDOMAIN); ?>" style="display:none">
			<div class="esg-box">
				<div id="esg-shortcode-settings" class="esg-settings-container active-esc">
					<div> <!-- BASIC SETTINGS -->
						<div class="eg-cs-tbc-left"><esg-llabel><span><?php echo _e('Grid Source', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
						<div class="eg-cs-tbc" style="border-bottom:none">																					
							<div class="esg-settings-grid-wrap">
								<label for="shortcode" class="eg-tooltip-wrap tooltipstered"><?php echo _e('Grid Base', EG_TEXTDOMAIN); ?></label><!--
								--><select class="esg-sc-pregrid" name="esg-sc-pregrid">
									<option value="-1"><?php _e('Select Grid', EG_TEXTDOMAIN); ?></option>
									<?php
									if(!empty($grids)){
										foreach($grids as $title => $alias){
											echo '<option value="'.$alias.'">'.$title.'</option>'."\n";
										}
									}
									?>
								</select>								
							</div>							
							<div class="esg-settings-exset-wrap">								
								<label><?php _e('Grid Base', EG_TEXTDOMAIN); ?></label><!--
								--><select class="esg-sc-existing-settings" name="esg-sc-existing-settings">
									<option value="-1"><?php _e('Custom Settings', EG_TEXTDOMAIN); ?></option>
									<?php
									if(!empty($grids)){
										foreach($grids as $title => $alias){
											echo '<option value="'.$alias.'">'.$title.'</option>'."\n";
										}
									}
									?>
								</select>																						
							</div>	
							<div class="div13"></div>
							<label for="shortcode" class="eg-tooltip-wrap tooltipstered"><?php echo _e('Content From', EG_TEXTDOMAIN); ?></label><!--
							--><select name="esg-sc-source" class="esg-sc-source">
								<option value="pre"><?php echo _e('Predefined', EG_TEXTDOMAIN); ?></option>
								<option value="custom"><?php echo _e('Custom Grid', EG_TEXTDOMAIN); ?></option>
								<!--<option value="wpgallery"><?php echo _e('WP Gallery', EG_TEXTDOMAIN); ?></option>-->
								<option value="popular"><?php echo _e('Popular Post', EG_TEXTDOMAIN); ?></option>
								<option value="recent"><?php echo _e('Recent Post', EG_TEXTDOMAIN); ?></option>
								<option value="related"><?php echo _e('Related Post', EG_TEXTDOMAIN); ?></option>
							</select>
							<div id="eg-related-post-based-details">
								<div class="div13"></div>
								<label for="postbasedtpyes" class="eg-tooltip-wrap tooltipstered"><?php echo _e('Related Post based on', EG_TEXTDOMAIN); ?></label><!--
								--><select name="esg-sc-relatedbased" class="esg-sc-relatedbased">
									<option value="both"><?php echo _e('Tags & Categories', EG_TEXTDOMAIN); ?></option>
									<option value="tags"><?php echo _e('Tags', EG_TEXTDOMAIN); ?></option>									
									<option value="categories"><?php echo _e('Categories', EG_TEXTDOMAIN); ?></option>									
								</select>
							</div>
							<div class="esg-settings-exset-wrap">
								<div class="div13"></div>
								<label><?php _e('Maximum Entries', EG_TEXTDOMAIN); ?></label><!--
								--><input type="text" name="esg-sc-max-entries" value="20" />								
							</div>	
						</div>
					</div>
					<div id="esg_shortcode_custom_settings_bottom">
						<div class="eg-cs-tbc-left"><esg-llabel><span><?php echo _e('Custom Settings', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
						<div class="eg-cs-tbc" style="border-top:2px solid #f3f2f6;border-bottom:none">

							
							<label><?php _e('Grid Skin', EG_TEXTDOMAIN); ?></label><!--
							--><select name="esg-sc-entry-skin">
								<?php
								$skins = Essential_Grid_Item_Skin::get_essential_item_skins('all', false);
								
								if(!empty($skins)){
									foreach($skins as $skin){
										echo '<option value="'.$skin['id'].'">'.$skin['name'].'</option>'."\n";
									}
								}
								?>
							</select>
							<div class="div13"></div>
							<label><?php _e('Layout', EG_TEXTDOMAIN); ?></label><!--
							--><select name="esg-sc-layout-sizing">
								<option value="boxed"><?php _e('Boxed', EG_TEXTDOMAIN); ?></option>
								<option value="fullwidth"><?php _e('Fullwidth', EG_TEXTDOMAIN); ?></option>
							</select>
							<div class="div13"></div>
							<label><?php _e('Grid Layout', EG_TEXTDOMAIN); ?></label><!--
							--><select name="esg-sc-grid-layout">
								<option value="even"><?php _e('Even', EG_TEXTDOMAIN); ?></option>
								<option value="masonry"><?php _e('Masonry', EG_TEXTDOMAIN); ?></option>
								<option value="cobbles"><?php _e('Cobbles', EG_TEXTDOMAIN); ?></option>
							</select>
							<div class="div13"></div>
							<label><?php _e('Item Spacing', EG_TEXTDOMAIN); ?></label><!--
							--><input type="text" name="esg-sc-spacings" value="0" />
							<div class="div13"></div>
							<label><?php _e('Pagination', EG_TEXTDOMAIN); ?></label><!--
							--><input type="radio" style="margin-left:0px !important;" name="esg-sc-rows-unlimited" value="on" /><?php _e('Disable', EG_TEXTDOMAIN); ?><div class="space18"></div><!--
							--><input type="radio" name="esg-sc-rows-unlimited" checked="checked" value="off" /><?php _e('Enable', EG_TEXTDOMAIN); ?> 
							<div class="div13"></div>
							<label><?php _e('Columns', EG_TEXTDOMAIN); ?></label><!--
							--><input type="text" name="esg-sc-columns" value="5" />
							<div class="div13"></div>
							<label><?php _e('Max. Visible Rows', EG_TEXTDOMAIN); ?></label><!--
							--><input type="text" name="esg-sc-rows" value="3" />
							<div class="div13"></div>
							<label><?php _e('Start and Filter Animations', EG_TEXTDOMAIN); ?></label><!--
							<?php
							$anims = Essential_Grid_Base::get_grid_animations();
							?>
							--><select class="eg-tooltip-wrap tooltipstered" name="esg-sc-grid-animation" id="grid-animation-select">
								<?php
								foreach($anims as $value => $name){
									echo '<option value="'.$value.'">'.$name.'</option>'."\n";
								}
								?>
							</select>
							<div class="div13"></div>
							<label><?php _e('Choose Spinner', EG_TEXTDOMAIN); ?></label><!--
							--><select class="eg-tooltip-wrap tooltipstered" name="esg-sc-use-spinner" id="use_spinner">
								<option value="-1"><?php _e('off', EG_TEXTDOMAIN); ?></option>
								<option value="0" selected="selected">0</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>								
						</div>
					</div><!-- END PF SHORTCODE CUSTOM SETTINGS BOTTOM -->
					<div id="esg_shortcode_custom_settings_add_elements">						
						<div class="">
							<div class="eg-cs-tbc-left">
								<esg-llabel><span><?php _e('Items', EG_TEXTDOMAIN); ?></span></esg-llabel>
							</div>
							<div class="eg-cs-tbc" id="esg_shortcode_custom_items" style="border-top:2px solid #f3f2f6;border-bottom:none;padding-left:20px;"></div>								
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- SHORTCODE READER -->
		<div id="esg_read_old_shortcode_dialog" class="essential-dialog-wrap" title="<?php _e('Read Shortcode', EG_TEXTDOMAIN); ?>"  style="display: none;padding:20px">
			<label><?php _e('Insert Shortcode', EG_TEXTDOMAIN); ?></label><textarea style="width:490px;height:162px" id="esg_import_shortcode_text"></textarea>			
		</div>
		
		<!-- CUSTOM SHORTCODE ITEM EDITOR -->
		<div id="edit-custom-element-quick-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Custom Element Settings', EG_TEXTDOMAIN); ?>"  style="display: none; padding:20px">			
			<input type="hidden" name="custom-type" value="" />
			<div class="esg-item-skin-elements">
				<label><?php _e('Title', EG_TEXTDOMAIN); ?></label><input type="text" id="esg-csi-title"  value="" />	
				<div class="esg-csi-itemtype-image">
					<div class="div13"></div>
					<label><?php _e('Image/Poster', EG_TEXTDOMAIN); ?></label><!--				
					--><input type="hidden" value="" id="esg-csi-image" name="esg-csi-image"><!--
					--><div class="esg-btn esg-purple ess-grid-select-image"  data-setto="esg-custom-image"><?php _e('Choose Image', EG_TEXTDOMAIN); ?></div><!--
					--><div id="custom-image-wrapper" style="width:100%;line-height: 0px"><img id="esg-custom-image-img" src="" style="max-width:165px; max-height:103px;display: none;padding-left: 170px;margin-top:13px"></div>
				</div>
				<div class="esg-csi-itemtype-html5">
					<div class="div13"></div>
					<label><?php _e('MP4 URL', EG_TEXTDOMAIN); ?></label><input type="text" id="esg-csi-mp4"  value="" />	
				</div>				
				<div class="esg-csi-itemtype-vimeo">
					<div class="div13"></div>
					<label><?php _e('Vimeo ID', EG_TEXTDOMAIN); ?></label><input type="text" id="esg-csi-vimeo"  value="" />	
				</div>
				<div class="esg-csi-itemtype-youtube">
					<div class="div13"></div>
					<label><?php _e('YouTube ID', EG_TEXTDOMAIN); ?></label><input type="text" id="esg-csi-youtube"  value="" />	
				</div>
				<div class="esg-csi-itemtype-soundcloud">
					<div class="div13"></div>
					<label><?php _e('SoundCloud ID', EG_TEXTDOMAIN); ?></label><input type="text" id="esg-csi-soundcloud"  value="" />	
				</div>
				<div class="esg-csi-itemtype-video">
					<div class="div13"></div>
					<label ><?php _e('Video Ratio', EG_TEXTDOMAIN); ?></label><!--
					--><select id="esg-csi-ratio">
						<option value="1"><?php _e('16:9', EG_TEXTDOMAIN); ?></option>
						<option value="0"><?php _e('4:3', EG_TEXTDOMAIN); ?></option>
					</select>
				</div>
				<div class="esg-csi-itemtype-cobbles">
					<div class="div13"></div>
					<label><?php _e('Cobbles Element Size', EG_TEXTDOMAIN); ?></label><!--						
					--><select id="esg-csi-cobbles-size" class="esg-csi-cobbles-size">
							<option value="1:1"><?php _e('width 1, height 1', EG_TEXTDOMAIN); ?></option>
							<option value="1:2"><?php _e('width 1, height 2', EG_TEXTDOMAIN); ?></option>
							<option value="1:3"><?php _e('width 1, height 3', EG_TEXTDOMAIN); ?></option>
							<option value="2:1"><?php _e('width 2, height 1', EG_TEXTDOMAIN); ?></option>
							<option value="2:2"><?php _e('width 2, height 2', EG_TEXTDOMAIN); ?></option>
							<option value="2:3"><?php _e('width 2, height 3', EG_TEXTDOMAIN); ?></option>
							<option value="3:1"><?php _e('width 3, height 1', EG_TEXTDOMAIN); ?></option>
							<option value="3:2"><?php _e('width 3, height 2', EG_TEXTDOMAIN); ?></option>
							<option value="3:3"><?php _e('width 3, height 3', EG_TEXTDOMAIN); ?></option>
						</select>					
				</div>				
				<div class="div13"></div>
				<label><?php _e('Specific Skin', EG_TEXTDOMAIN); ?></label><!--
				--><select id="esg-csi-skin" name="esg-csi-skin">
					<option value="-1"><?php _e('-- Default Skin --', EG_TEXTDOMAIN); ?></option>
					<?php
					$skins = Essential_Grid_Item_Skin::get_essential_item_skins('all', false);
					
					if(!empty($skins)){
						foreach($skins as $skin){
							echo '<option value="'.$skin['id'].'">'.$skin['name'].'</option>'."\n";
						}
					}
					?>
				</select>
				<div class="div13"></div>
			</div>
		</div>

		<script type="text/javascript">
				<?php
				$skin_layers = array();
				
				$all_skins = $skins_c->get_essential_item_skins();
				
				if(!empty($all_skins)){
					foreach($all_skins as $cskin){
						$custom_layer_elements = array();
						if(isset($cskin['layers'])){
							foreach($cskin['layers'] as $layer){
								if(@isset($layer['settings']['source'])){
							
									switch($layer['settings']['source']){
										case 'post':
											$custom_layer_elements[@$layer['settings']['source-post']] = '';
											break;
										case 'woocommerce':
											$custom_layer_elements[@$layer['settings']['source-woocommerce']] = '';
											break;
									}
									
								}
							}
						}
						$skin_layers[$cskin['id']] = $custom_layer_elements;
					}
				}
				
				?>
				
				var esg_tiny_skin_layers = JSON.parse(<?php echo $base->jsonEncodeForClientSide($skin_layers); ?>);
															
				<?php
				do_action('essgrid_edit_custom_element_dialog_script');
				?>
			</script>
		<?php
				do_action('add_esg_shortcode_builder');
		?>
		<?php
	}
	
	/**
	 * Edit Custom Element Dialog
	 * @since    1.0.0
	 */
	public static function edit_custom_element_dialog(){
		$meta = new Essential_Grid_Meta();
		$item_elements = new Essential_Grid_Item_Element();
		
		?>
		<div id="edit-custom-element-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Element Settings', EG_TEXTDOMAIN); ?>"  style="display: none; padding:15px 0px;">
			<ul class="eg-option-tabber-wrapper">
				<li id="custom_media_settings_menu_media" class="eg-option-tabber selected" data-target="#esg-item-skin-elements-media"><span class="dashicons dashicons-admin-media"></span><?php _e('Media', EG_TEXTDOMAIN); ?></li><!--
				--><li id="custom_media_settings_menu_itemsettings" class="eg-option-tabber" data-target="#esg-item-skin-elements-settings"><span class="dashicons dashicons-list-view"></span><?php _e('Item Settings', EG_TEXTDOMAIN); ?></li><!--
				--><li class="eg-option-tabber" data-target="#esg-item-skin-elements-datas"><span class="dashicons dashicons-align-center"></span><?php _e('Item Datas', EG_TEXTDOMAIN); ?></li><!--				
				--><li class="eg-option-tabber" data-target="#esg-item-skin-elements-other"><span class="dashicons dashicons-admin-appearance"></span><?php _e('Other', EG_TEXTDOMAIN); ?></li>				
			</ul>
			<form id="edit-custom-element-form">
				<div id="esg-item-skin-elements-media" class="eg-options-tab" style="display:block">
					<input type="hidden" name="custom-type" value="" />
					<div class="esg-item-skin-elements" id="esg-item-skin-elements-media-image">
						<label for="custom-image"><?php _e('Main Image', EG_TEXTDOMAIN); ?></label><!--
						--><input type="hidden" value="" id="esg-custom-image" name="custom-image"><!--
						--><div id="eg-custom-choose-from-image-library" class="esg-btn esg-purple"  data-setto="esg-custom-image"><?php _e('Choose Image', EG_TEXTDOMAIN); ?></div><!--
						--><div id="eg-custom-clear-from-image-library" class="esg-btn esg-red eg-custom-remove-custom-meta-field" ><?php _e('Remove Image', EG_TEXTDOMAIN); ?></div>						
						<div id="custom-image-wrapper" style="width:100%;line-height: 0px"><img id="esg-custom-image-img" src="" style="max-width:50%; display: none;padding-left: 250px;margin-top:13px"></div>
					</div>			
					<div class="esg-item-skin-elements" id="esg-item-skin-elements-media-sound">
						<div class="div13"></div>
						<label  for="custom-soundcloud"><?php _e('SoundCloud Track ID', EG_TEXTDOMAIN); ?></label><input name="custom-soundcloud" type="text" value="" />						
					</div>
					<div class="esg-item-skin-elements" id="esg-item-skin-elements-media-youtube">
						<div class="div13"></div>
						<label  for="custom-soundcloud"><?php _e('YouTube ID', EG_TEXTDOMAIN); ?></label><input name="custom-youtube" type="text" value="" />						
					</div>
					<div class="esg-item-skin-elements" id="esg-item-skin-elements-media-vimeo">
						<div class="div13"></div>
						<label  for="custom-soundcloud"><?php _e('Vimeo ID', EG_TEXTDOMAIN); ?></label><input name="custom-vimeo" type="text" value="" />						
					</div>
					<div class="esg-item-skin-elements" id="esg-item-skin-elements-media-html5">
						<div class="div13"></div>
						<label  for="custom-html5-mp4"><?php _e('MP4', EG_TEXTDOMAIN); ?></label><input name="custom-html5-mp4" type="text" value="" />
						<div class="div13"></div>
						<label  for="custom-html5-ogv"><?php _e('OGV', EG_TEXTDOMAIN); ?></label><input name="custom-html5-ogv" type="text" value="" />
						<div class="div13"></div>
						<label  for="custom-html5-webm"><?php _e('WEBM', EG_TEXTDOMAIN); ?></label><input name="custom-html5-webm" type="text" value="" />
						
					</div>
					
					<div class="esg-item-skin-elements" id="esg-item-skin-elements-media-ratio">
						<div class="div13"></div>
						<label  for="custom-ratio"><?php _e('Video Ratio', EG_TEXTDOMAIN); ?></label><!--
						--><select name="custom-ratio">
							<option value="1"><?php _e('16:9', EG_TEXTDOMAIN); ?></option>
							<option value="0"><?php _e('4:3', EG_TEXTDOMAIN); ?></option>
						</select>
					</div>
				</div>
				<div id="eg-custom-item-options">
					<div id="esg-item-skin-elements-settings" class="eg-options-tab for-blank">
						<label for="post-link"><?php _e('Link To', EG_TEXTDOMAIN); ?></label><input type="text" name="post-link" value="" />						
						<div id="eg-custom-for-blank-wrap">
							<div class="div13"></div>
							<label><?php _e('Filter(s)', EG_TEXTDOMAIN); ?></label><!--
							--><input style="display:none" class="custom-filter-hiddeninput" type="text" name="custom-filter" value="" /><!--
							--><select name="custom-filter-list" class="custom-filter-list" multiple="true"></select><!--
							--><div class="div13"></div><!--
							--><label></label><div class="esg-btn esg-purple add_new_custom_category_quick"><i class="material-icons">add</i><?php _e('Add New Filter', EG_TEXTDOMAIN); ?></div>

						</div>

						<div class="for-blank">
							<div class="div13"></div>
							<label><?php _e('Cobbles Element Size', EG_TEXTDOMAIN); ?></label><!--						
							--><select name="cobbles-size">
									<option value="1:1"><?php _e('width 1, height 1', EG_TEXTDOMAIN); ?></option>
									<option value="1:2"><?php _e('width 1, height 2', EG_TEXTDOMAIN); ?></option>
									<option value="1:3"><?php _e('width 1, height 3', EG_TEXTDOMAIN); ?></option>
									<option value="2:1"><?php _e('width 2, height 1', EG_TEXTDOMAIN); ?></option>
									<option value="2:2"><?php _e('width 2, height 2', EG_TEXTDOMAIN); ?></option>
									<option value="2:3"><?php _e('width 2, height 3', EG_TEXTDOMAIN); ?></option>
									<option value="3:1"><?php _e('width 3, height 1', EG_TEXTDOMAIN); ?></option>
									<option value="3:2"><?php _e('width 3, height 2', EG_TEXTDOMAIN); ?></option>
									<option value="3:3"><?php _e('width 3, height 3', EG_TEXTDOMAIN); ?></option>
								</select>
							<div class="div13"></div>
						</div>
						<?php $skins = Essential_Grid_Item_Skin::get_essential_item_skins('all', false);?>
						<label><?php _e('Alternate Item Skin', EG_TEXTDOMAIN); ?></label><!--						
						--><select name="use-skin">
								<option value="-1"><?php _e('-- Default Skin --', EG_TEXTDOMAIN); ?></option>
								<?php
								if(!empty($skins)){
									foreach($skins as $skin){
										echo '<option value="'.$skin['id'].'">'.$skin['name'].'</option>'."\n";
									}
								}
								?>
						</select>
						<div class="div13"></div>
						<div>									
						<label><?php _e('Item Skin Modifications', EG_TEXTDOMAIN); ?></label><!--						
						--><div class="esg-btn esg-purple eg-add-custom-meta-field" id="eg-add-custom-meta-field-custom"><?php _e('Add New Custom Skin Rule', EG_TEXTDOMAIN); ?></div>
						</div>
						<div class="eg-advanced-param" id="eg-advanced-param-custom" style="margin: 20px 0"></div>										
					</div>
					<div id="esg-item-skin-elements-datas" class="eg-options-tab">
						<?php 
						
						$elements = $item_elements->getElementsForDropdown();
						$p_lang = array('post' => __('Item Data', EG_TEXTDOMAIN), 'woocommerce' => __('WooCommerce', EG_TEXTDOMAIN));
						
						foreach($elements as $type => $element){
							?>
							<strong style="font-size:14px"><?php echo $p_lang[$type]; ?></strong>							
							<div id="esg-item-skin-elements-<?php echo $type; ?>">
							<?php
							foreach($element as $handle => $itm){

								if(!isset($itm['type'])) $itm['type'] = "empty";
								
								switch($itm['type']) {
										
									case 'image';
										echo '<div>';
										echo '<label for="'.$handle.'">'.$itm['name'].'</label>';
										echo '<input type="hidden" value="" name="eg-' . $handle . '" id="eg-' . $handle . '-cm" />';
										echo '<div class="esg-btn esg-purple eg-image-add" data-setto="eg-' . $handle . '-cm">' . __('Choose Image', EG_TEXTDOMAIN) . '</div> ';
										echo '<div class="esg-btn esg-red eg-image-clear" data-setto="eg-' . $handle . '-cm">' . __('Remove Image', EG_TEXTDOMAIN) . '</div>';
										echo '<div style="line-height:0px;width:100%;"><img id="eg-' . $handle . '-cm-img" src="" style="max-width:50%; display: none;padding-left: 250px;margin-top:13px"></div>';										
										echo '</div><div class="div13"></div>';
									break;
									
									case 'revslider';

										if(class_exists('RevSliderSlider')) {
											
											$rev_slider = new RevSliderSlider();
											if(method_exists($rev_slider, 'get_slider_for_admin_menu')) {
											
												$sliders = $rev_slider->get_slider_for_admin_menu();
												if(!empty($sliders)) {
													echo '<div>';	
													echo '<label for="'.$handle.'">'.$itm['name'].'</label>';
													echo '<select name="' . $handle . '">';
													echo '<option value="">--- Choose Slider ---</option>';
													
													foreach($sliders as $id => $val) {
														
														if(isset($val['title']) && !empty($val['title'])) {
															echo '<option value="' . $id . '">' . $val['title'] . '</option>';
														}
														
													}
													echo '</select></div><div class="div13"></div>';													
												}
											}	
										}
									
									break;
									
									case 'essgrid':										
										$grids = Essential_Grid::get_essential_grids();
										if(!empty($grids)) {
											echo '<div>';											
											echo '<label  for="'.$handle.'">'.$itm['name'].'</label>';
											echo '<select name="' . $handle . '">';
											echo '<option value="">--- Choose Grid ---</option>';									
											foreach($grids as $grid) {				
												echo '<option value="' . $grid->handle . '">' . $grid->name . '</option>';
											}											
											echo '</select></div><div class="div13"></div>';											
										}
									
									break;
									
									default:
									
										echo '<div><label for="'.$handle.'">'.$itm['name'].'</label><input type="text" name="'.$handle.'" value="" /></div><div class="div13"></div>';
									
								}
								
							}
							?>								
							</div>
							<?php
						}				

						$custom_meta = $meta->get_all_meta(false);
						if(!empty($custom_meta)){
							
							foreach($custom_meta as $cmeta){
								?>
								<label ><?php echo $cmeta['name']; ?></label>
								<?php
									switch($cmeta['type']){
										case 'text':
											echo '<input type="text" name="eg-'.$cmeta['handle'].'" value="" />';
										break;
										case 'select':
										case 'multi-select':
											$do_array = ($cmeta['type'] == 'multi-select') ? '[]' : '';
											$el = $meta->prepare_select_by_string($cmeta['select']);
											echo '<select name="eg-'.$cmeta['handle'].$do_array.'"';
											if($cmeta['type'] == 'multi-select') echo ' multiple="multiple" size="5"';
											echo '>';
											if(!empty($el) && is_array($el)){
												if($cmeta['type'] == 'multi-select'){
													echo '<option value="">'.__('---', EG_TEXTDOMAIN).'</option>';
												}
												foreach($el as $ele){
													echo '<option value="'.$ele.'">'.$ele.'</option>';
												}
											}
											echo '</select>';
										break;
										case 'image':
											$var_src = '';
											?>
											<input type="hidden" value="" name="eg-<?php echo $cmeta['handle']; ?>" id="eg-<?php echo $cmeta['handle'].'-cm'; ?>" />
											<div class="esg-btn esg-purple eg-image-add" data-setto="eg-<?php echo $cmeta['handle'].'-cm'; ?>"><?php _e('Choose Image', EG_TEXTDOMAIN); ?></div>
											<div class="esg-btn esg-red eg-image-clear" data-setto="eg-<?php echo $cmeta['handle'].'-cm'; ?>"><?php _e('Remove Image', EG_TEXTDOMAIN); ?></div>
											<div style="width:100%; line-height: 0px"><img id="eg-<?php echo $cmeta['handle'].'-cm'; ?>-img" src="<?php echo $var_src; ?>" <?php echo ($var_src == '') ? 'style="max-width:50%; display: none;padding-left: 250px;margin-top:13px;"' : ''; ?>></div>
											<?php
										break;
									}
									?>
								<div class="div13"></div>
								<?php
							}
						}																					
					?>
					</div>
					<div id="esg-item-skin-elements-other" class="eg-options-tab">						
						<label for="image-fit"><?php _e('Image Fit', EG_TEXTDOMAIN); ?></label><!--
						--><select name="image-fit">
							<option value="-1"><?php _e('-- Default Fit --', EG_TEXTDOMAIN); ?></option>
							<option value="contain"><?php _e('Contain', EG_TEXTDOMAIN); ?></option>
							<option value="cover"><?php _e('Cover', EG_TEXTDOMAIN); ?></option>
						</select>
						<div class="div13"></div>
						
						<label for="image-repeat"><?php _e('Image Repeat', EG_TEXTDOMAIN); ?></label><!--
						--><select name="image-repeat">
							<option value="-1"><?php _e('-- Default Repeat --', EG_TEXTDOMAIN); ?></option>
							<option value="no-repeat"><?php _e('no-repeat', EG_TEXTDOMAIN); ?></option>
							<option value="repeat"><?php _e('repeat', EG_TEXTDOMAIN); ?></option>
							<option value="repeat-x"><?php _e('repeat-x', EG_TEXTDOMAIN); ?></option>
							<option value="repeat-y"><?php _e('repeat-y', EG_TEXTDOMAIN); ?></option>
						</select>
						<div class="div13"></div>
						<label for="image-align-horizontal"><?php _e('Horizontal Align', EG_TEXTDOMAIN); ?></label><!--
						--><select name="image-align-horizontal">
							<option value="-1"><?php _e('-- Horizontal Align --', EG_TEXTDOMAIN); ?></option>
							<option value="left"><?php _e('Left', EG_TEXTDOMAIN); ?></option>
							<option value="center"><?php _e('Center', EG_TEXTDOMAIN); ?></option>
							<option value="right"><?php _e('Right', EG_TEXTDOMAIN); ?></option>
						</select>
						<div class="div13"></div>
						<label for="image-align-vertical"><?php _e('Vertical Align', EG_TEXTDOMAIN); ?></label><!--
						--><select name="image-align-vertical">
							<option value="-1"><?php _e('-- Vertical Align --', EG_TEXTDOMAIN); ?></option>
							<option value="top"><?php _e('Top', EG_TEXTDOMAIN); ?></option>
							<option value="center"><?php _e('Center', EG_TEXTDOMAIN); ?></option>
							<option value="bottom"><?php _e('Bottom', EG_TEXTDOMAIN); ?></option>
						</select>						
					</div>
				</div>
				<?php
				do_action('essgrid_edit_custom_element_dialog_post');
				?>
			</form>
			<script type="text/javascript">
				
				<?php 
				
					$advanced = array();
					$base = new Essential_Grid_Base();
					$item_skin = new Essential_Grid_Item_Skin();
					$item_elements = new Essential_Grid_Item_Element();
					$eg_skins = $item_skin->get_essential_item_skins();

					foreach($eg_skins as $skin){
						if(!empty($skin['layers'])){
							$advanced[$skin['id']]['name'] = $skin['name'];
							$advanced[$skin['id']]['handle'] = $skin['handle'];
							foreach($skin['layers'] as $layer){
								if(empty($layer)) continue; //some layers may be NULL...
								
								//check if special, ignore special elements
								$settings = $layer['settings'];
								if(!empty($settings) && isset($settings['special']) && $settings['special'] == 'true') continue;
								
								/* 2.1.6 */
								if(isset($layer['id'])) $advanced[$skin['id']]['layers'][] = $layer['id'];
							}
						}
					}
					
					$eg_elements = $item_elements->get_allowed_meta();
					
				?>
				
				AdminEssentials.setInitSkinsJson(<?php echo $base->jsonEncodeForClientSide($advanced); ?>);
				AdminEssentials.setInitStylingJson(<?php echo $base->jsonEncodeForClientSide($eg_elements); ?>);
			
				jQuery('.eg-image-add').on('click',function(e) {
					e.preventDefault();
					AdminEssentials.upload_image_img(jQuery(this).data('setto'));
					
					return false; 
				});
				
				jQuery('.eg-image-clear').on('click',function(e) {
					e.preventDefault();
					var setto = jQuery(this).data('setto');
					jQuery('#'+setto).val('');
					jQuery('#'+setto+'-img').attr("src","");
					jQuery('#'+setto+'-img').hide();
					return false; 
				});
				
				jQuery('#eg-custom-choose-from-image-library').on('click',function(e) {
					e.preventDefault();
					AdminEssentials.upload_image_img(jQuery(this).data('setto'));

					return false; 
				});
				
				jQuery('#eg-custom-clear-from-image-library').on('click',function(e) {
					e.preventDefault();
					
					jQuery('#esg-custom-image-src').val('');
					jQuery('#esg-custom-image').val('');
					jQuery('#esg-custom-image-img').attr("src","");
					jQuery('#esg-custom-image-img').hide();
					return false; 
				});
								
				
				<?php
				do_action('essgrid_edit_custom_element_dialog_script');
				?>
			</script>
		</div>
		<?php
	}
			
	/**
	 * Filter Dialog Box
	 * @since    2.1.0
	 */
	public static function filter_select_dialog(){
		?>
		<div id="filter-select-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Select Filter', EG_TEXTDOMAIN); ?>"  style="display: none; padding:20px !important;">
			<select id="eg-filter-select-box" name="custom-filter-select" multiple="true" size="10" style="width: 100%">				
			</select>
			<?php
			do_action('essgrid_filter_select_dialog');
			?>
		</div>
		<?php
	}

	/**
	 * CUSTOM Filter Dialog Box
	 * @since    2.1.0
	 */
	public static function filter_custom_dialog(){
		?>
		<div id="filter-custom-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Custom Filter', EG_TEXTDOMAIN); ?>"  style="display: none; padding:20px !important;">
			<label><?php _e('Custom category', EG_TEXTDOMAIN); ?></label><!--
			--><input type="text" class="esg-custom-category-name-editor" name="esg-custom-category-name-editor" value="New Category" />
			<?php
			do_action('essgrid_filter_custom_dialog');
			?>
		</div>
		<?php
	}

	/**
	 * CUSTOM Filter Dialog Box
	 * @since    2.1.0
	 */
	public static function filter_delete_dialog(){
		?>
		<div id="filter-delete-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('DeleteCustom Filter', EG_TEXTDOMAIN); ?>"  style="display: none; padding:20px !important;">
			<?php _e('Are you sure to delete the', EG_TEXTDOMAIN); ?><!--			
			--><div class="esg-custom-category-todelete" style="margin:0px 10px;font-weight:800;display:inline-block"></div><!--
			--><?php _e('Custom Category?', EG_TEXTDOMAIN); ?>
			<div class="div13"></div>
			<?php _e('This will remove this Category from all Items !', EG_TEXTDOMAIN); ?></label>
			<?php
			do_action('essgrid_filter_delete_dialog');
			?>
		</div>
		<?php
	}
}
?>