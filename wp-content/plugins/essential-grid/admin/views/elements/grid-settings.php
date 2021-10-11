<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2020 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

//needs: $base (instance of Essential_Grid_Base), $grid (Instance of Essential_Grid::get_essential_grid_by_id() || false [creation of new])
if(!isset($base)) $base = new Essential_Grid_Base();
$eg_meta = new Essential_Grid_Meta();



// INIT LIGHTBOX SOURCE ORDERS
if(intval($isCreate) > 0) {//currently editing, so default can be empty
	$lb_source_order = $base->getVar($grid, array('params', 'lb-source-order'), '');
	$lb_button_order = $base->getVar($grid, array('params', 'lb-button-order'), array());
}
else {
	$lb_source_order = $base->getVar($grid, array('params', 'lb-source-order'), array('featured-image'));
	$lb_button_order = $base->getVar($grid, array('params', 'lb-button-order'), array('share', 'thumbs', 'close'));
}

$lb_source_list = $base->get_lb_source_order();
$lb_button_list = $base->get_lb_button_order();

// INIT AJAX SOURCE ORDERS
if(intval($isCreate) > 0) //currently editing, so default can be empty
	$aj_source_order = $base->getVar($grid, array('params', 'aj-source-order'), '');
else
	$aj_source_order = $base->getVar($grid, array('params', 'aj-source-order'), array('post-content'));

$aj_source_list = $base->get_aj_source_order();

$all_metas = $eg_meta->get_all_meta();
?>
	<!-- SETTINGS -->
	<form id="eg-form-create-settings">
		<!--
		GRID SETTINGS
		-->
		<div id="esg-settings-grid-settings" class="esg-settings-container">
			<div>
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php _e('Layout', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc">						
					<label for="navigation-container" class="eg-tooltip-wrap" title="<?php _e('Choose layout type of the grid', EG_TEXTDOMAIN); ?>"><?php _e("Layout", EG_TEXTDOMAIN); ?></label><!--
					--><input type="radio" name="layout-sizing" value="boxed" <?php checked($base->getVar($grid, array('params', 'layout-sizing'), 'boxed'), 'boxed'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Grid always stays within the wrapping container', EG_TEXTDOMAIN); ?>"><?php _e("Boxed", EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
					--><input type="radio" name="layout-sizing" value="fullwidth" <?php checked($base->getVar($grid, array('params', 'layout-sizing'), 'boxed'), 'fullwidth'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Force Fullwidth. Grid will fill complete width of the window', EG_TEXTDOMAIN); ?>"><?php _e("Fullwidth", EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
					--><input type="radio" name="layout-sizing" value="fullscreen" <?php checked($base->getVar($grid, array('params', 'layout-sizing'), 'boxed'), 'fullscreen'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Fullscreen Layout. !! Hides not needed options !! Grid Width = Window Width, Grid Height = Window Height - Offset Containers.', EG_TEXTDOMAIN); ?>"><?php _e("Fullscreen", EG_TEXTDOMAIN); ?></span>
					
					<div id="eg-fullscreen-container-wrap" style="display: none;">
						<div class="div13"></div>
						<label for="fullscreen-offset-container"><?php _e('Offset Container', EG_TEXTDOMAIN); ?></label><!--
						--><input type="text" name="fullscreen-offset-container" value="<?php echo $base->getVar($grid, array('params', 'fullscreen-offset-container'), ''); ?>" />
					</div>
					<div id="eg-even-masonry-wrap">
						<div class="div13"></div>
						<label for="layout" class="eg-tooltip-wrap" title="<?php _e('Select Grid Layout', EG_TEXTDOMAIN); ?>"><?php _e('Grid Layout', EG_TEXTDOMAIN); ?></label><!--
						--><div id="eg-grid-layout-wrapper" style="display:inline-block"><!--
							--><input type="radio" name="layout" value="even" <?php checked($base->getVar($grid, array('params', 'layout'), 'even'), 'even'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Even - Each item has same height. Width and height are item ratio dependent', EG_TEXTDOMAIN); ?>"><?php _e('Even', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input type="radio" name="layout" value="masonry" <?php checked($base->getVar($grid, array('params', 'layout'), 'even'), 'masonry'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Individual item height depends on media height and content height', EG_TEXTDOMAIN); ?>"><?php _e('Masonry', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input type="radio" name="layout" value="cobbles" <?php checked($base->getVar($grid, array('params', 'layout'), 'even'), 'cobbles'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Even Grid with Width / Height Multiplications', EG_TEXTDOMAIN); ?>"><?php _e('Cobbles', EG_TEXTDOMAIN); ?></span>						
						</div>
					</div>

					<div id="eg-content-push-wrap">
						<div class="div13"></div>
						<label for="columns" class="eg-tooltip-wrap" title="<?php _e('Content Push', EG_TEXTDOMAIN); ?>"><?php _e('Content Push', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="content-push" value="on" <?php checked($base->getVar($grid, array('params', 'content-push'), 'off'), 'on'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('Content will push the website down on Even Grids with content in the Masonry Content area for the last row', EG_TEXTDOMAIN); ?>"><?php _e('On', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio" name="content-push" value="off" <?php checked($base->getVar($grid, array('params', 'content-push'), 'off'), 'off'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('Content will overflow elements on Even Grids with content in the Masonry Content area for the last row', EG_TEXTDOMAIN); ?>"><?php _e('Off', EG_TEXTDOMAIN); ?></span>
					</div>
					<div id="eg-items-ratio-wrap">
						<div class="div13"></div>
						<label for="x-ratio" class="eg-tooltip-wrap" title="<?php _e('Media width/height ratio, Width ratio of Media:Height ratio of Media', EG_TEXTDOMAIN); ?>"><?php _e('Media Ratio X:Y', EG_TEXTDOMAIN); ?></label><!--
						--><div style="display:inline-block" id="eg-ratio-wrapper" <?php echo ($base->getVar($grid, array('params', 'auto-ratio'), 'true') === 'true' && $base->getVar($grid, array('params', 'layout'), 'even') === 'masonry') ? 'style="display: none;"' : ''; ?>><input class="input-settings-small " type="text" name="x-ratio" style="width:50px" value="<?php echo $base->getVar($grid, array('params', 'x-ratio'), '4', 'i'); ?>" />&nbsp;:&nbsp;<input class="input-settings-small " style="width:50px"  type="text" name="y-ratio" value="<?php echo $base->getVar($grid, array('params', 'y-ratio'), '3', 'i'); ?>" /><div class="space18"></div></div><!--
						--><span id="eg-masonry-options"><input type="checkbox" name="auto-ratio" <?php checked($base->getVar($grid, array('params', 'auto-ratio'), 'true'), 'true'); ?> /> <?php _e('Auto', EG_TEXTDOMAIN); ?></span>
					</div>
					<div class="div13"></div>
					<div>
						<label for="rtl" class="eg-tooltip-wrap" title="<?php _e('Right To Left option. This will change the direction of the Grid Items from right to left instead of left to right', EG_TEXTDOMAIN); ?>"><?php _e('RTL', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="rtl" value="on" <?php checked($base->getVar($grid, array('params', 'rtl'), 'off'), 'on'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('Grid Items will be sorted and ordered from right to left', EG_TEXTDOMAIN); ?>"><?php _e('On', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio" name="rtl" value="off" <?php checked($base->getVar($grid, array('params', 'rtl'), 'off'), 'off'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('Grid Items will be sorted and ordered from left to right', EG_TEXTDOMAIN); ?>"><?php _e('Off', EG_TEXTDOMAIN); ?></span>
					</div>						
				</div>
			</div>

			<div id="media-playbackingrid-wrap">
				<div>
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php _e('Media Playback', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc">							
						<label for="videoplaybackingrid" class="eg-tooltip-wrap" title="<?php _e('Video Playback direct in Grid', EG_TEXTDOMAIN); ?>"><?php _e('Video Playback in Grid', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="videoplaybackingrid" value="on" <?php checked($base->getVar($grid, array('params', 'videoplaybackingrid'), 'on'), 'on'); ?>><!--
						--><span class="eg-tooltip-wrap" title="<?php _e('Allow Video Playback direct in Grid', EG_TEXTDOMAIN); ?>"><?php _e('Enable', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio"  name="videoplaybackingrid" value="off" <?php checked($base->getVar($grid, array('params', 'videoplaybackingrid'), 'on'), 'off'); ?>><!--
						--><span class="eg-tooltip-wrap" title="<?php _e('Disable Video Playback direct in Grid', EG_TEXTDOMAIN); ?>"><?php _e('Disable', EG_TEXTDOMAIN); ?></span>
						<div class="div13"></div>
						<label for="videoplaybackonhover" class="eg-tooltip-wrap" title="<?php _e('Video Playback direct in Grid on Hover', EG_TEXTDOMAIN); ?>"><?php _e('Video Playback on Hover', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="videoplaybackonhover" value="on" <?php checked($base->getVar($grid, array('params', 'videoplaybackonhover'), 'off'), 'on'); ?>><!--
						--><span class="eg-tooltip-wrap" title="<?php _e('Allow Video Playback on hover', EG_TEXTDOMAIN); ?>"><?php _e('Enable', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio"  name="videoplaybackonhover" value="off" <?php checked($base->getVar($grid, array('params', 'videoplaybackonhover'), 'off'), 'off'); ?>><!--
						--><span class="eg-tooltip-wrap" title="<?php _e('Disable Video Playback on Hover', EG_TEXTDOMAIN); ?>"><?php _e('Disable', EG_TEXTDOMAIN); ?></span>	

						<div class="div13"></div>
						<label for="videocontrolsinline" class="eg-tooltip-wrap" title="<?php _e('Use / Hide Controls if possible', EG_TEXTDOMAIN); ?>"><?php _e('Use Controls Inline', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="videocontrolsinline" value="on" <?php checked($base->getVar($grid, array('params', 'videocontrolsinline'), 'off'), 'on'); ?>><!--
						--><span class="eg-tooltip-wrap" title="<?php _e('Allow Video Playback on hover', EG_TEXTDOMAIN); ?>"><?php _e('Enable', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio"  name="videocontrolsinline" value="off" <?php checked($base->getVar($grid, array('params', 'videocontrolsinline'), 'off'), 'off'); ?>><!--
						--><span class="eg-tooltip-wrap" title="<?php _e('Disable Video Playback on Hover', EG_TEXTDOMAIN); ?>"><?php _e('Disable', EG_TEXTDOMAIN); ?></span>	

						<div class="div13"></div>
						<label for="videomuteinline" class="eg-tooltip-wrap" title="<?php _e('Mute / Unmute Video Inline', EG_TEXTDOMAIN); ?>"><?php _e('Mute Inline Video', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="videomuteinline" value="on" <?php checked($base->getVar($grid, array('params', 'videomuteinline'), 'on'), 'on'); ?>><!--
						--><span class="eg-tooltip-wrap" title="<?php _e('Mute Video Inline', EG_TEXTDOMAIN); ?>"><?php _e('Enable', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio"  name="videomuteinline" value="off" <?php checked($base->getVar($grid, array('params', 'videomuteinline'), 'on'), 'off'); ?>><!--
						--><span class="eg-tooltip-wrap" title="<?php _e('Unmute Video inline', EG_TEXTDOMAIN); ?>"><?php _e('Disable', EG_TEXTDOMAIN); ?></span>	


						<div class="div13"></div>
						<label for="keeplayersovermedia" class="eg-tooltip-wrap" title="<?php _e('Keep the Layers over the Video', EG_TEXTDOMAIN); ?>"><?php _e('Keep Layers on Playback', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="keeplayersovermedia" value="on" <?php checked($base->getVar($grid, array('params', 'keeplayersovermedia'), 'off'), 'on'); ?>><!--
						--><span class="eg-tooltip-wrap" title="<?php _e('Allow Video Playback on hover', EG_TEXTDOMAIN); ?>"><?php _e('Enable', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio"  name="keeplayersovermedia" value="off" <?php checked($base->getVar($grid, array('params', 'keeplayersovermedia'), 'off'), 'off'); ?>><!--
						--><span class="eg-tooltip-wrap" title="<?php _e('Disable Video Playback on Hover', EG_TEXTDOMAIN); ?>"><?php _e('Disable', EG_TEXTDOMAIN); ?></span>	
						<div><label></label><?php _e('Layers and/or the cover element may overlay the full video. In that case you need to adjust the skin to make sure the video is visible under the overlaying layers/cover.', EG_TEXTDOMAIN); ?></div>
					</div>
				</div>
			</div>
				
			<div id="eg-cobbles-options">
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php _e('Cobbles', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc">		
					<div class="cobbles-mobile-wrap">						
						<label for="load-more" class="eg-tooltip-wrap" title="<?php _e('Show Even under Device Size', EG_TEXTDOMAIN); ?>"><?php _e('Even Layout on Device', EG_TEXTDOMAIN); ?></label><!--
						--><select name="show-even-on-device" >
							<option value="0"<?php selected($base->getVar($grid, array('params', 'show-even-on-device'), '0'), '0'); ?>><?php _e('Keep Cobbles Always', EG_TEXTDOMAIN); ?></option>
							<option value="2"<?php selected($base->getVar($grid, array('params', 'show-even-on-device'), '0'), '2'); ?>><?php _e('Desktop Small and smaller', EG_TEXTDOMAIN); ?></option>
							<option value="3"<?php selected($base->getVar($grid, array('params', 'show-even-on-device'), '0'), '3'); ?>><?php _e('Tablet Landscape and smaller', EG_TEXTDOMAIN); ?></option>
							<option value="4"<?php selected($base->getVar($grid, array('params', 'show-even-on-device'), '0'), '4'); ?>><?php _e('Tablet and smaller', EG_TEXTDOMAIN); ?></option>
							<option value="5"<?php selected($base->getVar($grid, array('params', 'show-even-on-device'), '0'), '5'); ?>><?php _e('Mobile Landscape and smaller', EG_TEXTDOMAIN); ?></option>
							<option value="6"<?php selected($base->getVar($grid, array('params', 'show-even-on-device'), '0'), '6'); ?>><?php _e('Mobile', EG_TEXTDOMAIN); ?></option>
						</select>
					</div>
					<div class="div13"></div>
					<label for="use-cobbles-pattern" class="eg-tooltip-wrap" title="<?php _e('Use cobbles pattern and overwrite the cobbles that is set sepcifically in the entries', EG_TEXTDOMAIN); ?>"><?php _e('Use Cobbles Pattern', EG_TEXTDOMAIN); ?></label><!--
					--><input type="radio" name="use-cobbles-pattern" value="on" <?php checked($base->getVar($grid, array('params', 'use-cobbles-pattern'), 'off'), 'on'); ?>><span class="eg-tooltip-wrap" title="<?php _e('User cobbles pattern', EG_TEXTDOMAIN); ?>"><?php _e('On', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
					--><input type="radio" name="use-cobbles-pattern" value="off" <?php checked($base->getVar($grid, array('params', 'use-cobbles-pattern'), 'off'), 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('User specific set cobbles setting from entries', EG_TEXTDOMAIN); ?>"><?php _e('Off', EG_TEXTDOMAIN); ?></span>						
					<div class="eg-cobbles-pattern-wrap" style="margin:15px 0px; <?php echo ($base->getVar($grid, array('params', 'use-cobbles-pattern'), 'off') == 'off') ? ' display: none;' : ''; ?>">							
						<?php
						$cobbles_pattern = $base->getVar($grid, array('params', 'cobbles-pattern'), array());
						if(!empty($cobbles_pattern)){
							$cob_sort_count = 0;
							foreach($cobbles_pattern as $pattern){
								$cob_sort_count++;
								?>
								<div class="eg-cobbles-drop-wrap">
									<span class="cob-sort-order"><?php echo $cob_sort_count; ?>.</span>
									<select name="cobbles-pattern[]">
										<option <?php selected($pattern, '1x1'); ?> value="1x1">1:1</option>
										<option <?php selected($pattern, '1x2'); ?> value="1x2">1:2</option>
										<option <?php selected($pattern, '1x3'); ?> value="1x3">1:3</option>
										<option <?php selected($pattern, '1x4'); ?> value="1x4">1:4</option>
										<option <?php selected($pattern, '2x1'); ?> value="2x1">2:1</option>
										<option <?php selected($pattern, '2x2'); ?> value="2x2">2:2</option>
										<option <?php selected($pattern, '2x3'); ?> value="2x3">2:3</option>
										<option <?php selected($pattern, '2x4'); ?> value="2x4">2:4</option>
										<option <?php selected($pattern, '3x1'); ?> value="3x1">3:1</option>
										<option <?php selected($pattern, '3x2'); ?> value="3x2">3:2</option>
										<option <?php selected($pattern, '3x3'); ?> value="3x3">3:3</option>
										<option <?php selected($pattern, '3x4'); ?> value="3x4">3:4</option>
										<option <?php selected($pattern, '4x1'); ?> value="4x1">4:1</option>
										<option <?php selected($pattern, '4x2'); ?> value="4x2">4:2</option>
										<option <?php selected($pattern, '4x3'); ?> value="4x3">4:3</option>
										<option <?php selected($pattern, '4x4'); ?> value="4x4">4:4</option>
									</select><a class="esg-btn  eg-delete-cobbles" href="javascript:void(0);"><i class="eg-icon-trash"></i></a>
								</div>
								<?php
							}
						}
						?>							
					</div>
					<div>				
						<a <?php echo ($base->getVar($grid, array('params', 'use-cobbles-pattern'), 'off') == 'off') ? ' style="display: none;"' : ''; ?> class="esg-btn esg-purple eg-add-new-cobbles-pattern eg-tooltip-wrap" title="<?php _e('Add your custom cobbles pattern here', EG_TEXTDOMAIN); ?>" href="javascript:void(0);"><i class="eg-icon-plus"></i><?php _e("Cobbles Pattern", EG_TEXTDOMAIN); ?></a>
						<a <?php echo ($base->getVar($grid, array('params', 'use-cobbles-pattern'), 'off') == 'off') ? ' style="display: none;"' : ''; ?> class="esg-refresh-preview-button eg-refresh-cobbles-pattern esg-btn esg-blue" style="display: inline-block;"><i class="eg-icon-arrows-ccw"></i><?php _e('Refresh Preview', EG_TEXTDOMAIN); ?></a>
					</div>
				</div>
			</div>

				

			<div>
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php _e('Columns', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc">
					<table id="grid-columns-table"><!--
						--><tr id="eg-col-0"><!--
							--><td class="eg-tooltip-wrap" title="<?php _e('Display normal settings or get advanced', EG_TEXTDOMAIN); ?>"><label for="columns"><?php _e('Setting Mode', EG_TEXTDOMAIN); ?></label></td>
							<td><input type="radio" name="columns-advanced" value="on" <?php checked($base->getVar($grid, array('params', 'columns-advanced'), 'off'), 'on'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('Advanced min heights, columns, custom media queries and custom columns (in rows pattern)', EG_TEXTDOMAIN); ?>"><?php _e('Advanced', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
								--><input type="radio" name="columns-advanced" value="off" <?php checked($base->getVar($grid, array('params', 'columns-advanced'), 'off'), 'off'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('Simple columns. Each row with same column, default media query levels.', EG_TEXTDOMAIN); ?>"><?php _e('Simple', EG_TEXTDOMAIN); ?></span>
							</td>
							<td></td>
						</tr>

						<tr id="eg-col-00" style="height: 20px;" class="columns-height columns-width">
							<td></td>							
							<td class="esg-adv-row-title"><span class="esg-adv-row-title-span"><?php _e('Min Height of<br>Grid at Start', EG_TEXTDOMAIN); ?></span><span class="esg-adv-row-title-span" style="margin-left:5px;"><?php _e('Breakpoint at<br>Grid Width', EG_TEXTDOMAIN); ?></span><span class="esg-adv-row-title-span" style="margin-left:5px;"><?php _e('Min Masonry<br>Content Height', EG_TEXTDOMAIN); ?></span></td>
							<?php
							$ca_steps = 0;
							if(!empty($columns_advanced[0])){
								foreach($columns_advanced[0] as $col)
									if(!empty($col)) $ca_steps = count($columns_advanced) + 1;
							}
							?>
							<td class="columns-adv-first esg-adv-row-title-span-small">
								<?php _e('Rows:', EG_TEXTDOMAIN); ?><br><?php
								if($ca_steps > 0) {
									echo 1; echo ',';
									echo 1 + 1 * $ca_steps; echo ',';
									echo 1 + 2 * $ca_steps;
								}else{
									?>
									<div style="position: absolute;top: 11px;white-space: nowrap;left: 100%;">
										<a class="esg-btn esg-purple" href="javascript:void(0);" id="eg-add-column-advanced"><i class="material-icons">add</i></a>
									</div>
									<?php
								}
								?>
							</td>
							<?php
							if(!empty($columns_advanced)){
								foreach($columns_advanced as $adv_key => $adv){
									if(empty($adv)) continue;
									?>
									<td class="columns-adv-<?php echo $adv_key; ?> columns-adv-rows columns-adv-head esg-adv-row-title-span-small">
										<?php _e('Rows:', EG_TEXTDOMAIN); ?><br><?php
										$at = $adv_key + 2;
										echo $at; echo ',';
										echo $at + 1 * $ca_steps; echo ',';
										echo $at + 2 * $ca_steps;
										if($ca_steps == $adv_key + 1){
											?>
											<div style="position: absolute;top: 11px;white-space: nowrap;left: 100%;">
												<a class="esg-btn esg-purple" href="javascript:void(0);" id="eg-add-column-advanced"><i class="material-icons">add</i></a>
												<a class="esg-btn esg-red" href="javascript:void(0);" id="eg-remove-column-advanced"><i class="material-icons">remove</i></a>
											</div>
											<?php
										}
										?>
									</td>
									<?php
								}
							}
							?>
						</td>
						<tr id="eg-col-1">
							<td class="eg-tooltip-wrap" title="<?php _e('Items per Row (+ Min. Window Width (advanced)) for large desktop screens', EG_TEXTDOMAIN); ?>"><label><?php _e('Desktop Large', EG_TEXTDOMAIN); ?></label></td>
							<td class="eg-tooltip-wrap" title="<?php _e('Start height for Grid on large desktop screens', EG_TEXTDOMAIN); ?>, <?php _e('Min. browser width for large desktop screens', EG_TEXTDOMAIN); ?>"><!--
								--><input class="input-settings-small columns-height " style="margin-right:5px; width:100px" type="text" name="columns-height[]" value="<?php echo $columns_height[0]; ?>"><!--
								--><input class="input-settings-small columns-width "  style="margin-right:5px;width:100px" type="text" name="columns-width[]" value="<?php echo $columns_width[0]; ?>"><!--
								--><input class="input-settings-small columns-width "  style="margin-right:5px;width:100px" type="text" name="mascontent-height[]" value="<?php echo $mascontent_height[0]; ?>"><!--
								--><span id="slider-columns-1" data-num="1" class="slider-settings columns-sliding"></span>
							</td>
							<td class="eg-tooltip-wrap esg-adv-row-title-span-small" title="<?php _e('Number of items in rows on large desktop screens', EG_TEXTDOMAIN); ?>"><input class="input-settings-small" type="text" id="columns-1" name="columns[]" value="<?php echo $columns[0]; ?>" /></td>
							<?php
							if(!empty($columns_advanced)){
								foreach($columns_advanced as $adv_key => $adv){
									if(empty($adv)) continue;
									?>
									<td class="esg-adv-row-title-span-small columns-adv-<?php echo $adv_key; ?> columns-adv-rows eg-tooltip-wrap" title="<?php _e('Number of items in rows on large desktop screens', EG_TEXTDOMAIN); ?>"><input class="input-settings-small" type="text" name="columns-advanced-rows-<?php echo $adv_key; ?>[]" value="<?php echo $adv[0]; ?>" /></td>
									<?php
								}
							}
							?>
						</tr>
						<tr id="eg-col-2">
							<td class="eg-tooltip-wrap" title="<?php _e('Items per Row (+ Min. Window Width (advanced)) for medium sized desktop screens', EG_TEXTDOMAIN); ?>"><label><?php _e('Desktop Medium', EG_TEXTDOMAIN); ?></label></td>
							<td class="eg-tooltip-wrap" title="<?php _e('Start height for Grid on medium sized desktop screens', EG_TEXTDOMAIN); ?>, <?php _e('Min. browser width for medium sized desktop screens', EG_TEXTDOMAIN); ?>"><!--
								--><input class="input-settings-small columns-height " style="margin-right:5px;width:100px" type="text" name="columns-height[]" value="<?php echo $columns_height[1]; ?>"><!--
								--><input class="input-settings-small columns-width " style="margin-right:5px;width:100px" type="text" name="columns-width[]" value="<?php echo $columns_width[1]; ?>"><!--
								--><input class="input-settings-small columns-width "  style="margin-right:5px;width:100px" type="text" name="mascontent-height[]" value="<?php echo $mascontent_height[1]; ?>"><!--
								--><span id="slider-columns-2" data-num="2" class="slider-settings columns-sliding"></span>
							</td>
							<td class="eg-tooltip-wrap esg-adv-row-title-span-small" title="<?php _e('Number of items in rows on medium sized desktops', EG_TEXTDOMAIN); ?>"><input class="input-settings-small" type="text" id="columns-2" name="columns[]" value="<?php echo $columns[1]; ?>" /></td>
							<?php
							if(!empty($columns_advanced)){
								foreach($columns_advanced as $adv_key => $adv){
									if(empty($adv)) continue;
									?>
									<td class="esg-adv-row-title-span-small columns-adv-<?php echo $adv_key; ?> columns-adv-rows eg-tooltip-wrap" title="<?php _e('Number of items in rows on medium sized desktops', EG_TEXTDOMAIN); ?>"><input class="input-settings-small"  type="text" name="columns-advanced-rows-<?php echo $adv_key; ?>[]" value="<?php echo $adv[1]; ?>" /></td>
									<?php
								}
							}
							?>
						</tr>
						<tr id="eg-col-3">
							<td class="eg-tooltip-wrap" title="<?php _e('Items per Row (+ Min. Window Width (advanced)) for small sized desktops', EG_TEXTDOMAIN); ?>"><label><?php _e('Desktop Small', EG_TEXTDOMAIN); ?></label></td>
							<td class="eg-tooltip-wrap" title="<?php _e('Start height for Grid on small sized desktop screens', EG_TEXTDOMAIN); ?>, <?php _e('Min. browser width for small sized desktop screens', EG_TEXTDOMAIN); ?>"><!--
								--><input class="input-settings-small columns-height " style="margin-right:5px;width:100px" type="text" name="columns-height[]" value="<?php echo $columns_height[2]; ?>"><!--
								--><input class="input-settings-small columns-width "  style="margin-right:5px;width:100px" type="text" name="columns-width[]" value="<?php echo $columns_width[2]; ?>"><!--
								--><input class="input-settings-small columns-width "  style="margin-right:5px;width:100px" type="text" name="mascontent-height[]" value="<?php echo $mascontent_height[2]; ?>"><!--
								--><span id="slider-columns-3" data-num="3" class="slider-settings columns-sliding"></span>
							</td>
							<td class="esg-adv-row-title-span-small eg-tooltip-wrap" title="<?php _e('Number of items in rows on small sized desktop screens', EG_TEXTDOMAIN); ?>"><input class="input-settings-small" type="text" id="columns-3" name="columns[]" value="<?php echo $columns[2]; ?>" /></td>
							<?php
							if(!empty($columns_advanced)){
								foreach($columns_advanced as $adv_key => $adv){
									if(empty($adv)) continue;
									?>
									<td class="esg-adv-row-title-span-small columns-adv-<?php echo $adv_key; ?> columns-adv-rows eg-tooltip-wrap" title="<?php _e('Amount of items in the rows shown above on small sized desktop screens', EG_TEXTDOMAIN); ?>"><input class="input-settings-small" type="text" name="columns-advanced-rows-<?php echo $adv_key; ?>[]" value="<?php echo $adv[2]; ?>" /></td>
									<?php
								}
							}
							?>
						</tr>
						<tr id="eg-col-4">
							<td class="eg-tooltip-wrap" title="<?php _e('Items per Row (+ Min. Window Width (advanced)) for tablets in landscape view', EG_TEXTDOMAIN); ?>"><label><?php _e('Tablet Landscape', EG_TEXTDOMAIN); ?></label></td>
							<td class="eg-tooltip-wrap" title="<?php _e('Start height for Grid on tablets in landscape view', EG_TEXTDOMAIN); ?>, <?php _e('Min. browser width for tablets in landscape view', EG_TEXTDOMAIN); ?>"><!--
								--><input class="input-settings-small columns-height " style="margin-right:5px;width:100px" type="text" name="columns-height[]" value="<?php echo $columns_height[3]; ?>"><!--
								--><input class="input-settings-small columns-width " style="margin-right:5px;width:100px" type="text" name="columns-width[]" value="<?php echo $columns_width[3]; ?>"><!--
								--><input class="input-settings-small columns-width "  style="margin-right:5px;width:100px" type="text" name="mascontent-height[]" value="<?php echo $mascontent_height[3]; ?>"><!--
								--><span id="slider-columns-4" data-num="4" class="slider-settings columns-sliding"></span>
							</td>
							<td class="esg-adv-row-title-span-small eg-tooltip-wrap" title="<?php _e('Number of items in rows on tablets in landscape view', EG_TEXTDOMAIN); ?>"><input class="input-settings-small" type="text" id="columns-4" name="columns[]" value="<?php echo $columns[3]; ?>" /></td>
							<?php
							if(!empty($columns_advanced)){
								foreach($columns_advanced as $adv_key => $adv){
									if(empty($adv)) continue;
									?>
									<td class="esg-adv-row-title-span-small columns-adv-<?php echo $adv_key; ?> columns-adv-rows eg-tooltip-wrap" title="<?php _e('Amount of items in the rows shown above on tablet in landscape view', EG_TEXTDOMAIN); ?>"><input class="input-settings-small" type="text" name="columns-advanced-rows-<?php echo $adv_key; ?>[]" value="<?php echo $adv[3]; ?>" /></td>
									<?php
								}
							}
							?>
						</tr>
						<tr id="eg-col-5">
							<td class="eg-tooltip-wrap" title="<?php _e('Items per Row (+ Min. Window Width (advanced)) for tablets in portrait view', EG_TEXTDOMAIN); ?>"><label><?php _e('Tablet', EG_TEXTDOMAIN); ?></label></td>
							<td class="eg-tooltip-wrap"  title="<?php _e('Start height for Grid on tablets in portrait view', EG_TEXTDOMAIN); ?>, <?php _e('Min. browser width for tablets in portrait view', EG_TEXTDOMAIN); ?>"><!--
								--><input class="input-settings-small columns-height " style="margin-right:5px;width:100px" type="text" name="columns-height[]" value="<?php echo $columns_height[4]; ?>"><!--
								--><input class="input-settings-small columns-width " style="margin-right:5px;width:100px" type="text" name="columns-width[]" value="<?php echo $columns_width[4]; ?>"><!--
								--><input class="input-settings-small columns-width "  style="margin-right:5px;width:100px" type="text" name="mascontent-height[]" value="<?php echo $mascontent_height[4]; ?>"><!--
								--><span id="slider-columns-5" data-num="5" class="slider-settings columns-sliding"></span>
							</td>
							<td class="esg-adv-row-title-span-small eg-tooltip-wrap" title="<?php _e('Number of items in rows on tablets', EG_TEXTDOMAIN); ?>"><input class="input-settings-small" type="text" id="columns-5" name="columns[]" value="<?php echo $columns[4]; ?>" /></td>
							<?php
							if(!empty($columns_advanced)){
								foreach($columns_advanced as $adv_key => $adv){
									if(empty($adv)) continue;
									?>
									<td class="esg-adv-row-title-span-small columns-adv-<?php echo $adv_key; ?> columns-adv-rows eg-tooltip-wrap" title="<?php _e('Number of items in the rows shown above on tablets', EG_TEXTDOMAIN); ?>"><input class="input-settings-small"type="text" name="columns-advanced-rows-<?php echo $adv_key; ?>[]" value="<?php echo $adv[4]; ?>" /></td>
									<?php
								}
							}
							?>
						</tr>
						<tr id="eg-col-6">
							<td class="eg-tooltip-wrap" title="<?php _e('Items per Row (+ Min. Window Width (advanced)) for mobiles in landscape view', EG_TEXTDOMAIN); ?>"><label><?php _e('Mobile Landscape', EG_TEXTDOMAIN); ?></label></td>
							<td class="eg-tooltip-wrap" title="<?php _e('Start height for Grid on mobiles in landscape view', EG_TEXTDOMAIN); ?>, <?php _e('Min. browser width for mobiles in landscape view', EG_TEXTDOMAIN); ?>"><!--
								--><input class="input-settings-small columns-height " style="margin-right:5px;width:100px" type="text" name="columns-height[]" value="<?php echo $columns_height[5]; ?>"><!--
								--><input class="input-settings-small columns-width "  style="margin-right:5px;width:100px" type="text" name="columns-width[]" value="<?php echo $columns_width[5]; ?>"><!--
								--><input class="input-settings-small columns-width "  style="margin-right:5px;width:100px" type="text" name="mascontent-height[]" value="<?php echo $mascontent_height[5]; ?>"><!--
								--><span id="slider-columns-6" data-num="6" class="slider-settings columns-sliding"></span>
							</td>
							<td class="esg-adv-row-title-span-small eg-tooltip-wrap" title="<?php _e('Number of items in the rows for mobiles in landscape view', EG_TEXTDOMAIN); ?>"><input class="input-settings-small" type="text" id="columns-6" name="columns[]" value="<?php echo $columns[5]; ?>" /></td>
							<?php
							if(!empty($columns_advanced)){
								foreach($columns_advanced as $adv_key => $adv){
									if(empty($adv)) continue;
									?>
									<td class="esg-adv-row-title-span-small columns-adv-<?php echo $adv_key; ?> columns-adv-rows eg-tooltip-wrap" title="<?php _e('Number of items in the rows shown above for mobiles in landscape view', EG_TEXTDOMAIN); ?>"><input class="input-settings-small" type="text" name="columns-advanced-rows-<?php echo $adv_key; ?>[]" value="<?php echo $adv[5]; ?>" /></td>
									<?php
								}
							}
							?>
						</tr>
						<tr id="eg-col-7">
							<td class="eg-tooltip-wrap" title="<?php _e('Items per Row (+ Min. Window Width (advanced)) for mobiles in portrait view', EG_TEXTDOMAIN); ?>"><label><?php _e('Mobile', EG_TEXTDOMAIN); ?></label></td>
							<td class="eg-tooltip-wrap" title="<?php _e('Start height for Grid on mobiles in portrait view', EG_TEXTDOMAIN); ?>, <?php _e('Min. browser width for mobiles in portrait view', EG_TEXTDOMAIN); ?>"><!--
								--><input class="input-settings-small columns-height " style="margin-right:5px;width:100px" type="text" name="columns-height[]" value="<?php echo $columns_height[6]; ?>"><!--
								--><input class="input-settings-small columns-width " style="margin-right:5px;width:100px" type="text"  name="columns-width[]" value="<?php echo $columns_width[6]; ?>"><!--
								--><input class="input-settings-small columns-width "  style="margin-right:5px;width:100px" type="text" name="mascontent-height[]" value="<?php echo $mascontent_height[6]; ?>"><!--
								--><span id="slider-columns-7" data-num="7" class="slider-settings columns-sliding"></span>
							</td>
							<td class="esg-adv-row-title-span-small eg-tooltip-wrap" title="<?php _e('Number of items in rows on mobiles', EG_TEXTDOMAIN); ?>"><input class="input-settings-small" type="text" id="columns-7" name="columns[]" value="<?php echo $columns[6]; ?>" /></td>
							<?php
							if(!empty($columns_advanced)){
								foreach($columns_advanced as $adv_key => $adv){
									if(empty($adv)) continue;
									?>
									<td class="esg-adv-row-title-span-small columns-adv-<?php echo $adv_key; ?> columns-adv-rows eg-tooltip-wrap" title="<?php _e('Number of items in the rows shown above on mobiles', EG_TEXTDOMAIN); ?>"><input class="input-settings-small" type="text" name="columns-advanced-rows-<?php echo $adv_key; ?>[]" value="<?php echo $adv[6]; ?>" /></td>
									<?php
								}
							}
							?>
						</tr>
					</table>
				</div>
			</div>
				
			<div class=" eg-blankitem-hideable">
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php _e('Blank Items', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc">					
					<label for="sorting-order-type" class="eg-tooltip-wrap" title="<?php _e('Hide Blank Items at a certain break-point', EG_TEXTDOMAIN); ?>"><?php _e('Hide Blank Items At', EG_TEXTDOMAIN); ?></label><!--
					--><?php $blank_breakpoint = $base->getVar($grid, array('params', 'blank-item-breakpoint'), 'desktop-medium'); ?><select class="eg-tooltip-wrap" name="blank-item-breakpoint" title="<?php _e('Hide Blank Items at a certain break-point', EG_TEXTDOMAIN); ?>">
						<option value="1"<?php selected($blank_breakpoint, '1'); ?>><?php _e('Desktop Medium', EG_TEXTDOMAIN); ?></option>
						<option value="2"<?php selected($blank_breakpoint, '2'); ?>><?php _e('Desktop Small', EG_TEXTDOMAIN); ?></option>
						<option value="3"<?php selected($blank_breakpoint, '3'); ?>><?php _e('Tablet Landscape', EG_TEXTDOMAIN); ?></option>
						<option value="4"<?php selected($blank_breakpoint, '4'); ?>><?php _e('Tablet', EG_TEXTDOMAIN); ?></option>
						<option value="5"<?php selected($blank_breakpoint, '5'); ?>><?php _e('Mobile Landscape', EG_TEXTDOMAIN); ?></option>
						<option value="6"<?php selected($blank_breakpoint, '6'); ?>><?php _e('Mobile', EG_TEXTDOMAIN); ?></option>
						<option value="none"<?php selected($blank_breakpoint, 'none'); ?>><?php _e('Always Show Blank Items', EG_TEXTDOMAIN); ?></option>
					</select>					
				</div>
			</div>
			
			<div>
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php _e('Pagination', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc">
					<div id="eg-pagination-wrap">
						<label for="rows-unlimited"><?php _e('Pagination', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="rows-unlimited" value="on" <?php checked($base->getVar($grid, array('params', 'rows-unlimited'), 'off'), 'on'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Pagination deactivated. Load More Option is available.', EG_TEXTDOMAIN); ?>"><?php _e('Disable (Load More Available)', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio" name="rows-unlimited" value="off" <?php checked($base->getVar($grid, array('params', 'rows-unlimited'), 'off'), 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Pagination Activated. Load More Option is disabled. Dont Forget to add The Navigation Module "Pagination" to your Grid !', EG_TEXTDOMAIN); ?>"><?php _e('Enable', EG_TEXTDOMAIN); ?></span>
					</div>					
					<div class="rows-num-wrap"<?php echo ($base->getVar($grid, array('params', 'rows-unlimited'), 'off') == 'on') ? ' style="display: none;"' : ''; ?>>						
						<div class="div13"></div>
						<label for="rows" class="eg-tooltip-wrap" title="<?php _e('Amount of Rows shown (max) when Pagination Activated.', EG_TEXTDOMAIN); ?>"><?php _e('Max Visible Rows', EG_TEXTDOMAIN); ?></label><!--
						--><span id="slider-rows" class="slider-settings"></span><div class="space18"></div><input class="input-settings-small" type="text" name="rows" value="<?php echo $base->getVar($grid, array('params', 'rows'), '3', 'i'); ?>" />
						<div class="div13"></div>						
						<label for="enable-rows-mobile" class="eg-tooltip-wrap" title="<?php _e('Set a custom rows amount for mobile devices', EG_TEXTDOMAIN); ?>"><?php _e('Max Rows Mobile', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" class=" enable-mobile-rows" name="enable-rows-mobile" value="on" <?php checked($base->getVar($grid, array('params', 'enable-rows-mobile'), 'off'), 'on'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Enable custom rows amount for mobile devices', EG_TEXTDOMAIN); ?>"><?php _e('Enable', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio" class="enable-mobile-rows" name="enable-rows-mobile" value="off" <?php checked($base->getVar($grid, array('params', 'enable-rows-mobile'), 'off'), 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Disable custom rows amount for mobile devices', EG_TEXTDOMAIN); ?>"><?php _e('Disable', EG_TEXTDOMAIN); ?></span>						
						<?php $enable_mobile_rows = $base->getVar($grid, array('params', 'enable-rows-mobile'), 'off') === 'off' ? 'none' : 'block'; ?>
						<div id="rows-mobile-wrap" style="display: <?php echo $enable_mobile_rows; ?>">
							<div class="div13"></div>
							<label for="rows-mobile" class="eg-tooltip-wrap" title="<?php _e('Set a custom rows amount for mobile devices.', EG_TEXTDOMAIN); ?>"><?php _e('Max Visible Rows Mobile', EG_TEXTDOMAIN); ?></label><span id="slider-rows-mobile" class="slider-settings"></span><div class="space18"></div><!--
							--><input class="input-settings-small" type="text" name="rows-mobile" value="<?php echo $base->getVar($grid, array('params', 'rows-mobile'), '3', 'i'); ?>" />
						</div>
						<div class="div13"></div>
						<label for="pagination-autoplay" class="eg-tooltip-wrap" title="<?php _e('Enable/Disable Autoplay for Pagination', EG_TEXTDOMAIN); ?>"><?php _e('Autoplay', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" class="pagination-autoplay " name="pagination-autoplay" value="on" <?php checked($base->getVar($grid, array('params', 'pagination-autoplay'), 'off'), 'on'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Enable Autoplay for Pagination', EG_TEXTDOMAIN); ?>"><?php _e('Enable', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio" class="pagination-autoplay" name="pagination-autoplay" value="off" <?php checked($base->getVar($grid, array('params', 'pagination-autoplay'), 'off'), 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Disable Autoplay for Pagination', EG_TEXTDOMAIN); ?>"><?php _e('Disable', EG_TEXTDOMAIN); ?></span>

						<div id="pagination-autoplay-speed"<?php echo ($base->getVar($grid, array('params', 'pagination-autoplay'), 'off') == 'off') ? ' style="display: none;"' : ''; ?>>
							<div class="div13"></div>
							<label for="pagination-autoplay-speed" class="eg-tooltip-wrap" title="<?php _e('Timing in milliseconds for the Pagination autoplay', EG_TEXTDOMAIN); ?>"><?php _e('Timing', EG_TEXTDOMAIN); ?></label><!--
							--><input class="input-settings-small " type="text" name="pagination-autoplay-speed" value="<?php echo $base->getVar($grid, array('params', 'pagination-autoplay-speed'), '5000', 'i'); ?>" /> ms
						</div>
						<div class="div13"></div>						
						<label for="pagination-touchswipe" class="eg-tooltip-wrap" title="<?php _e('Allow pagination swipe on mobile', EG_TEXTDOMAIN); ?>"><?php _e('Touch Swipe', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" class="pagination-touchswipe " name="pagination-touchswipe" value="on" <?php checked($base->getVar($grid, array('params', 'pagination-touchswipe'), 'off'), 'on'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Enable TouchSwipe for Pagination', EG_TEXTDOMAIN); ?>"><?php _e('Enable', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio" class="pagination-touchswipe" name="pagination-touchswipe" value="off" <?php checked($base->getVar($grid, array('params', 'pagination-touchswipe'), 'off'), 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Disable TouchSwipe for Pagination', EG_TEXTDOMAIN); ?>"><?php _e('Disable', EG_TEXTDOMAIN); ?></span>											
						<div id="pagination-touchswipe-settings"<?php echo ($base->getVar($grid, array('params', 'pagination-touchswipe'), 'off') == 'off') ? ' style="display: none;"' : ''; ?>>
							<div class="div13"></div>
							<label for="pagination-dragvertical" class="eg-tooltip-wrap" title="<?php _e('Allows the page to be scrolled vertically', EG_TEXTDOMAIN); ?>"><?php _e('Allow Vertical Dragging', EG_TEXTDOMAIN); ?></label><!--
							--><input type="radio" class="pagination-dragvertical " name="pagination-dragvertical" value="on" <?php checked($base->getVar($grid, array('params', 'pagination-dragvertical'), 'on'), 'on'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Allow Vertical Dragging', EG_TEXTDOMAIN); ?>"><?php _e('Enable', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input type="radio" class="pagination-dragvertical" name="pagination-dragvertical" value="off" <?php checked($base->getVar($grid, array('params', 'pagination-dragvertical'), 'on'), 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Prevent Vertical Dragging', EG_TEXTDOMAIN); ?>"><?php _e('Disable', EG_TEXTDOMAIN); ?></span>								
							<div class="div13"></div>							
							<label for="pagination-swipebuffer" class="eg-tooltip-wrap" title="<?php _e('Amount the finger moves before a swipe is honored', EG_TEXTDOMAIN); ?>"><?php _e('Swipe Threshold', EG_TEXTDOMAIN); ?></label><!--
							--><input class="input-settings-small " type="text" name="pagination-swipebuffer" value="<?php echo $base->getVar($grid, array('params', 'pagination-swipebuffer'), '30', 'i'); ?>" /> px							
						</div>
					</div>
				</div>
			</div>

				
			<div>
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php _e('Smart Loading', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc">
					<div class="load-more-wrap"<?php echo ($base->getVar($grid, array('params', 'rows-unlimited'), 'off') == 'off') ? ' style="display: none;"' : ''; ?>>
						<label for="load-more" class="eg-tooltip-wrap" title="<?php _e('Choose the Load More type', EG_TEXTDOMAIN); ?>"><?php _e('Load More', EG_TEXTDOMAIN); ?></label><!--
						--><select name="load-more" >
							<option value="none"<?php selected($base->getVar($grid, array('params', 'load-more'), 'none'), 'none'); ?>><?php _e('None', EG_TEXTDOMAIN); ?></option>
							<option value="button"<?php selected($base->getVar($grid, array('params', 'load-more'), 'none'), 'button'); ?>><?php _e('More Button', EG_TEXTDOMAIN); ?></option>
							<option value="scroll"<?php selected($base->getVar($grid, array('params', 'load-more'), 'none'), 'scroll'); ?>><?php _e('Infinite Scroll', EG_TEXTDOMAIN); ?></option>
						</select>
					</div>
					<div class="load-more-wrap load-more-hide-wrap"<?php echo ($base->getVar($grid, array('params', 'rows-unlimited'), 'off') == 'off' || $base->getVar($grid, array('params', 'load-more'), 'none') !== 'scroll') ? ' style="display: none;"' : ''; ?>>
						<div class="div13"></div>
						<label for="load-more-hide"><?php _e('Hide Load More Button', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="load-more-hide" value="on" <?php checked($base->getVar($grid, array('params', 'load-more-hide'), 'off'), 'on'); ?>><?php _e('On', EG_TEXTDOMAIN); ?><div class="space18"></div><!--
						--><input type="radio" name="load-more-hide" value="off" <?php checked($base->getVar($grid, array('params', 'load-more-hide'), 'off'), 'off'); ?>><?php _e('Off', EG_TEXTDOMAIN); ?>
					</div>
					<div class="load-more-wrap"<?php echo ($base->getVar($grid, array('params', 'rows-unlimited'), 'off') == 'off') ? ' style="display: none;"' : ''; ?>>
						<div class="div13"></div>
						<label class="eg-tooltip-wrap" title="<?php _e('Set the Load More text here', EG_TEXTDOMAIN); ?>" for="load-more-text" ><?php _e('Load More Text', EG_TEXTDOMAIN); ?></label><!--
						--><input type="text" name="load-more-text" value="<?php echo $base->getVar($grid, array('params', 'load-more-text'), __('Load More', EG_TEXTDOMAIN)); ?>" />
					</div>
					<div class="load-more-wrap"<?php echo ($base->getVar($grid, array('params', 'rows-unlimited'), 'off') == 'off') ? ' style="display: none;"' : ''; ?>>
						<div class="div13"></div>
						<label for="load-more-show-number"><?php _e('Item No. Remaining', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="load-more-show-number" value="on" <?php checked($base->getVar($grid, array('params', 'load-more-show-number'), 'on'), 'on'); ?>><?php _e('On', EG_TEXTDOMAIN); ?><div class="space18"></div><!--
						--><input type="radio" name="load-more-show-number" value="off" <?php checked($base->getVar($grid, array('params', 'load-more-show-number'), 'on'), 'off'); ?>><?php _e('Off', EG_TEXTDOMAIN); ?>
					</div>
					<div class="load-more-wrap"<?php echo ($base->getVar($grid, array('params', 'rows-unlimited'), 'off') == 'off') ? ' style="display: none;"' : ''; ?>>
						<div class="div13"></div>
						<label  class="eg-tooltip-wrap" title="<?php _e('Display how many items at start?', EG_TEXTDOMAIN); ?>" for="load-more-start" ><?php _e('Item No. at Start', EG_TEXTDOMAIN); ?></label><!--
						--><span id="slider-load-more-start" class="slider-settings"></span><div class="space18"></div><!--
						--><input class="input-settings-small" type="text" name="load-more-start" value="<?php echo $base->getVar($grid, array('params', 'load-more-start'), '3', 'i'); ?>" />
					</div>
					<div class="load-more-wrap"<?php echo ($base->getVar($grid, array('params', 'rows-unlimited'), 'off') == 'off') ? ' style="display: none;"' : ''; ?>>
						<div class="div13"></div>
						<label class="eg-tooltip-wrap" title="<?php _e('Display how many items after loading?', EG_TEXTDOMAIN); ?>" for="load-more-amount"><?php _e('Item No. Added', EG_TEXTDOMAIN); ?></label><!--
						--><span id="slider-load-more-amount" class="slider-settings"></span><div class="space18"></div><!--
						--><input class="input-settings-small" type="text" name="load-more-amount" value="<?php echo $base->getVar($grid, array('params', 'load-more-amount'), '3', 'i'); ?>" />
					</div>
					<div class="div13"></div>
					<label for="lazy-loading"><?php _e('Lazy Load', EG_TEXTDOMAIN); ?></label><!--
					--><input type="radio" name="lazy-loading" value="on" <?php checked($base->getVar($grid, array('params', 'lazy-loading'), 'off'), 'on'); ?>><span class=" eg-tooltip-wrap" title="<?php _e('Enable Lazy Load of Items', EG_TEXTDOMAIN); ?>"><?php _e('On', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
					--><input type="radio" name="lazy-loading" value="off" <?php checked($base->getVar($grid, array('params', 'lazy-loading'), 'off'), 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Disable Lazy Loading (All Item except the - Load more items -  on first page will be preloaded once)', EG_TEXTDOMAIN); ?>"><?php _e('Off', EG_TEXTDOMAIN); ?></span>
					<div class="div13"></div>
					<label for="lazy-loading"><?php _e('Lazy Load Blurred Image', EG_TEXTDOMAIN); ?></label><!--
					--><input type="radio" name="lazy-loading-blur" value="on" <?php checked($base->getVar($grid, array('params', 'lazy-loading-blur'), 'on'), 'on'); ?>><span class=" eg-tooltip-wrap" title="<?php _e('Enable Lazy Load Blurred Images, that will be shown before the selected image is loaded', EG_TEXTDOMAIN); ?>"><?php _e('On', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
					--><input type="radio" name="lazy-loading-blur" value="off" <?php checked($base->getVar($grid, array('params', 'lazy-loading-blur'), 'on'), 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Disabled Lazy Load Blurred Images, that will be shown before the selected image is loaded', EG_TEXTDOMAIN); ?>"><?php _e('Off', EG_TEXTDOMAIN); ?></span>					
					<div class="lazy-load-wrap">
						<div class="div13"></div>
						<label for="lazy-loading" class="eg-tooltip-wrap" title="<?php _e('Background color of media during the lazy loading progress', EG_TEXTDOMAIN); ?>"><?php _e('Lazy Load Color', EG_TEXTDOMAIN); ?></label><!--
						--><input name="lazy-load-color" type="text" id="lazy-load-color" value="<?php echo $base->getVar($grid, array('params', 'lazy-load-color'), '#FFFFFF'); ?>">
					</div>
				</div>
			</div>

				

			<div>
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php _e('Spacings', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc">					
					<label class="eg-tooltip-wrap" for="spacings" title="<?php _e('Spaces between items vertical and horizontal', EG_TEXTDOMAIN); ?>"><?php _e('Item Spacing', EG_TEXTDOMAIN); ?></label><!--
					--><input class="input-settings-small " type="text" name="spacings" value="<?php echo $base->getVar($grid, array('params', 'spacings'), '0', 'i'); ?>" /> px					
					<div class="div13"></div>
					<?php
					$grid_padding = $base->getVar($grid, array('params', 'grid-padding'), '0');
					if(!is_array($grid_padding)) $grid_padding = array('0', '0', '0', '0');
					?>
					<label for="grid-padding"><?php _e('Grid Padding', EG_TEXTDOMAIN); ?></label><!--
					--><input class="eg-tooltip-wrap input-settings-small" title="<?php _e('Grid Padding Top', EG_TEXTDOMAIN); ?>" type="text" name="grid-padding[]" value="<?php echo @$grid_padding[0]; ?>" /> px<div class="space18"></div><!--					
					--><input class="eg-tooltip-wrap input-settings-small" title="<?php _e('Grid Padding Right', EG_TEXTDOMAIN); ?>" type="text" name="grid-padding[]" value="<?php echo @$grid_padding[1]; ?>" /> px<div class="space18"></div><!--			
					--><input class="eg-tooltip-wrap input-settings-small" title="<?php _e('Grid Padding Bottom', EG_TEXTDOMAIN); ?>" type="text" name="grid-padding[]" value="<?php echo @$grid_padding[2]; ?>" /> px<div class="space18"></div><!--
					--><input class="eg-tooltip-wrap input-settings-small" title="<?php _e('Grid Padding Left', EG_TEXTDOMAIN); ?>" type="text" name="grid-padding[]" value="<?php echo @$grid_padding[3]; ?>" /> px<div class="space18"></div>
					
				</div>
			</div>
		</div>
	

		<!--
		SKIN SETTINGS
		-->
		<div id="esg-settings-skins-settings" class="esg-settings-container">
			<div>
				<div>
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php _e('Background', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc">						
						<label for="main-background-color" class="eg-tooltip-wrap" title="<?php _e('Background Color of the Grid. Type', EG_TEXTDOMAIN); ?>"><?php _e('Main Background Color', EG_TEXTDOMAIN); ?></label><!--
						--><input data-visible="true" name="main-background-color" type="text" data-editing="Background Color" id="main-background-color" value="<?php echo $base->getVar($grid, array('params', 'main-background-color'), 'transparent'); ?>">						
					</div>
				</div>

				<div>
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php _e('Navigation', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc">
						<label for="navigation-skin" class="eg-tooltip-wrap" title="<?php _e('Select the skin/color of the Navigation', EG_TEXTDOMAIN); ?>"><?php _e('Choose Skin', EG_TEXTDOMAIN); ?></label><!--
						--><select id="navigation-skin-select" name="navigation-skin">
							<?php
							foreach($navigation_skins as $skin){
								?>
								<option value="<?php echo $skin['handle']; ?>"<?php selected($nav_skin_choosen, $skin['handle']); ?>><?php echo $skin['name']; ?></option>
								<?php
							}
							?>
						</select><div class="space18"></div><!--
						--><div id="eg-edit-navigation-skin" class="esg-btn esg-purple eg-tooltip-wrap" title="<?php _e('Edit the selected Navigation Skin Style', EG_TEXTDOMAIN); ?>" ><?php _e('Edit Skin', EG_TEXTDOMAIN); ?></div><!--
						--><div id="eg-create-navigation-skin" class="esg-btn esg-blue eg-tooltip-wrap" title="<?php _e('Create a new Navigation Skin Style', EG_TEXTDOMAIN); ?>"><?php _e('Create Skin', EG_TEXTDOMAIN); ?></div><!--
						--><div id="eg-delete-navigation-skin" class="esg-btn  esg-red eg-tooltip-wrap" title="<?php _e('Delete the selected Navigation Skin', EG_TEXTDOMAIN); ?>"><?php _e('Delete Skin', EG_TEXTDOMAIN); ?></div>

						<div>
							<div class="div10"></div>
							<label class="eg-tooltip-wrap" title="<?php _e('Preview Background for better Visibility', EG_TEXTDOMAIN); ?>"><?php _e('Preview BG', EG_TEXTDOMAIN); ?></label><!--
							--><select id="navigation-preview-bg-select" name="navigation-preview-bg">
								<option value="dark"><?php _e('Dark', EG_TEXTDOMAIN); ?></option>
								<option value="light"><?php _e('Light', EG_TEXTDOMAIN); ?></option>
								<option value="transparent"><?php _e('Transparent', EG_TEXTDOMAIN); ?></option>
								<option value="mainbg"><?php _e('Main BG Color', EG_TEXTDOMAIN); ?></option>
							</select>
						</div>
						<div id="nav_skin_preview_wrap"><div id="nav_skin_preview"><div id="nav_skin_preview_content"></div><div id="nav_skin_preview_colored"></div></div></div>
					</div>
				</div>

				

				<div>
					<div class="eg-cs-tbc-left">
						<esg-llabel><span><?php _e('Item Skins', EG_TEXTDOMAIN); ?></span></esg-llabel>
					</div>
					<div class="eg-cs-tbc eg-photoshop-bg" style="padding:13px 20px">
						<div id="eg-selected-skins-wrapper">
							<div id="eg-selected-skins-default">
								<?php
								$skins_c = new Essential_Grid_Item_Skin();
								$navigation_c = new Essential_Grid_Navigation();
								$grid_c = new Essential_Grid();

								$grid_skin_sel['id'] = 'even';
								$grid_skin_sel['name'] = __('Skin Selector', EG_TEXTDOMAIN);
								$grid_skin_sel['handle'] = 'skin-selector';
								$grid_skin_sel['postparams'] = array();
								$grid_skin_sel['layers'] = array();
								$grid_skin_sel['params'] = array('navigation-skin' => ''); //leave empty, we use no skin

								$skins_html = '';
								$skins_css = '';
								$filters = array();

								$skins = $skins_c->get_essential_item_skins();

								$demo_img = array();								
								for($i=1; $i<11; $i++){																		
									$demo_img[] = 'demoimage'.$i.'.jpg';
								}
								shuffle($demo_img);
								
								if(!empty($skins) && is_array($skins)){
									

									$do_only_first = false;

									if($entry_skin_choosen == '0') $do_only_first = true; //only add the selected on the first element if we create a new grid, so we select the firs skin
									$counter = 0;
									foreach($skins as $skin){
										$counter++;
										if ($counter===10) $counter = 0;
										// 2.2.6
										if(is_array($skin) && array_key_exists('handle', $skin) && $skin['handle'] === 'esgblankskin') continue;
										
										

										$item_skin = new Essential_Grid_Item_Skin();
										$item_skin->init_by_data($skin);

										//set filters
										$item_skin->set_skin_choose_filter();										
										
										$item_skin->set_image($demo_img[$counter]);
										
										$item_filter = $item_skin->get_filter_array();

										$filters = array_merge($item_filter, $filters);

										//add skin specific css
										$item_skin->register_skin_css();

										ob_start();
										if($do_only_first){
											$item_skin->output_item_skin('skinchoose', '-1'); //-1 = will do select
											$do_only_first = false;
										}else{
											$item_skin->output_item_skin('skinchoose', $entry_skin_choosen);
										}

										$current_skin_html = ob_get_contents();
										ob_clean();
										ob_end_clean();
										
										//2.3.7 display html of item skin preview
                    					$skins_html .= htmlspecialchars_decode($current_skin_html);
										$skins_html = str_replace(
											array( '%favorites%' , '%eg-clients-icon%', '%eg-clients-icon-dark%', '%author_name%' , '%likes_short%' , '%date%' , '%retweets%' , '%likes%' , '%views_short%' , '%dislikes_short%' , '%duration%' , '%num_comments%','Likes (Facebook,Twitter,YouTube,Vimeo,Instagram)','Likes Short (Facebook,Twitter,YouTube,Vimeo,Instagram)' , 'Date Modified', 'Views (flickr,YouTube, Vimeo)' , 'Views Short (flickr,YouTube, Vimeo)', 'Cat. List' , 'Excerpt'),
											array( '314' , EG_PLUGIN_URL . '/admin/assets/images/client.png' , EG_PLUGIN_URL . '/admin/assets/images/client_dark.png' , 'Author' , '1.2K' , '2020-06-28' , '35' , '123' , '54' , '13' , '9:32' , '12' , '231' , '1.2K' , '2020-06-28', '231' , '1.2K' , 'News, Journey, Company', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
											$skins_html
										);

										ob_start();
										$item_skin->generate_element_css('skinchoose');
										$skins_css.= ob_get_contents();
										ob_clean();
										ob_end_clean();
									}
								}

								$grid_c->init_by_data($grid_skin_sel);

								echo '<div id="esg-grid-'.$handle.'-1-wrapper">';

								$grid_c->output_wrapper_pre();

								$filters = array_map("unserialize", array_unique(array_map("serialize", $filters))); //filter to unique elements

								$navigation_c->set_filter($filters);
								$navigation_c->set_style('padding', '10px 0 0 0');

								echo '<div id="main_skin_selector_nav_area" style="text-align: center;">';
								echo $navigation_c->output_filter('skinchoose');
								echo $navigation_c->output_pagination();
								echo '</div>';

								$grid_c->output_grid_pre();

								//output elements
								echo $skins_html;

								$grid_c->output_grid_post();
								$grid_c->output_wrapper_post();

								echo '</div>';

								echo $skins_css;
							?>
							</div>
							<script type="text/javascript">

								jQuery('#esg-grid-even-1').tpessential({
									layout:"masonry",
									forceFullWidth:"off",
									row:3,
									space:20,
									responsiveEntries: [
														{ width:1400,amount:3},
														{ width:1170,amount:3},
														{ width:1024,amount:3},
														{ width:960,amount:3},
														{ width:778,amount:2},
														{ width:640,amount:2},
														{ width:480,amount:2}
														],
									pageAnimation:"scale",
									startAnimation:"none",
									startAnimationSpeed: 0,
									startAnimationDelay: 0,
									animSpeed:800,
									animDelay:"on",
									delayBasic:0.4,
									aspectratio:"4:3",
									rowItemMultiplier : "",
								});
							</script>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--
		ANIMATION SETTINGS
		-->
		<div id="esg-settings-animations-settings" class="esg-settings-container">
			<div>
				<div>
					<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Start Animation', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc">
						
						<label for="grid-start-animation" class="eg-tooltip-wrap" title="<?php _e('Select the Animation for the Start Effect', EG_TEXTDOMAIN); ?>"><?php _e('Animation Type', EG_TEXTDOMAIN); ?></label><!--
						--><select id="grid-start-animation" name="grid-start-animation" style="width: 152px">
							<?php
							foreach($start_animations as $handle => $name){
								?>
								<option value="<?php echo $handle; ?>"<?php selected($grid_start_animation_choosen, $handle); ?>><?php echo $name; ?></option>
								<?php
							}
							?>
						</select><input type="hidden" id="hide-markup-before-load" name="hide-markup-before-load" value="<?php echo $base->getVar($grid, array('params', 'hide-markup-before-load'), 'off'); ?>">
						
						<div id="start-animation-speed-wrap">
							<div class="div13"></div>
							<label for="grid-start-animation-speed" class="eg-tooltip-wrap" title="<?php _e('Animation Speed (per item)', EG_TEXTDOMAIN); ?>"><?php _e('Transition Speed', EG_TEXTDOMAIN); ?></label><!--
							--><span id="slider-grid-start-animation-speed" class="slider-settings"></span><div class="space18"></div><input class="input-settings-small" type="text" id="grid-start-animation-speed" name="grid-start-animation-speed" value="<?php echo $base->getVar($grid, array('params', 'grid-start-animation-speed'), '1000', 'i'); ?>" readonly="true" /> ms
						</div>
						<div id="start-animation-delay-wrap">
							<div class="div13"></div>						
							<label for="grid-start-animation-delay" class="eg-tooltip-wrap" title="<?php _e('Create staggered animations by adding a delay value', EG_TEXTDOMAIN); ?>"><?php _e('Transition Delay', EG_TEXTDOMAIN); ?></label><!--
							--><span id="slider-grid-start-animation-delay" class="slider-settings"></span><div class="space18"></div><input class="input-settings-small" type="text" id="grid-start-animation-delay" name="grid-start-animation-delay" value="<?php echo $base->getVar($grid, array('params', 'grid-start-animation-delay'), '100', 'i'); ?>" readonly="true" />
							<div class="div13"></div>							
							<label for="grid-start-animation-type" class="eg-tooltip-wrap" title="<?php _e('Animate columns, rows or items individually', EG_TEXTDOMAIN); ?>"><?php _e('Apply Delay to', EG_TEXTDOMAIN); ?></label><!--
							--><?php $start_animation_type = $base->getVar($grid, array('params', 'grid-start-animation-type'), 'item'); ?><input type="radio" name="grid-start-animation-type" value="item" <?php checked($start_animation_type, 'item'); ?>><span class="eg-tooltip-wrap tooltipstered">Items</span><div class="space18"></div><!--
							--><input type="radio" name="grid-start-animation-type" value="col" <?php checked($start_animation_type, 'col'); ?>><span class="eg-tooltip-wrap tooltipstered">Columns</span><div class="space18"></div><!--
							--><input type="radio" name="grid-start-animation-type" value="row" <?php checked($start_animation_type, 'row'); ?>><span class="eg-tooltip-wrap tooltipstered">Rows</span>							
						</div>
						<div id="start-animation-viewport-wrap">
							<div class="div13"></div>							
							<label for="grid-start-animation-type" class="eg-tooltip-wrap" title="<?php _e('Animate when the grid is scrolled into view', EG_TEXTDOMAIN); ?>"><?php _e('Wait for viewport', EG_TEXTDOMAIN); ?></label><!--
							--><?php $start_anime_viewport = $base->getVar($grid, array('params', 'start-anime-in-viewport'), 'off'); ?><input type="radio" name="start-anime-in-viewport" value="on" class=" start-anime-viewport" <?php checked($start_anime_viewport, 'on'); ?>><span class="eg-tooltip-wrap tooltipstered">On</span><div class="space18"></div><!--
							--><input type="radio" name="start-anime-in-viewport" value="off" class="start-anime-viewport" <?php checked($start_anime_viewport, 'off'); ?>><span class="eg-tooltip-wrap tooltipstered">Off</span>
							<div id="start-animation-viewport-buffer">
								<div class="div13"></div>
								<label for="start-anime-viewport-buffer" class="eg-tooltip-wrap" title="<?php _e('Wait for grid to be (x)% in view', EG_TEXTDOMAIN); ?>"><?php _e('Viewport buffer', EG_TEXTDOMAIN); ?></label><!--
								--><input style="display: inline-block; vertical-align: middle; margin-left: 0" id="start-anime-viewport-buffer" class="input-settings-small eg-tooltip-wrap" type="text" name="start-anime-viewport-buffer" value="<?php echo $base->getVar($grid, array('params', 'start-anime-viewport-buffer'), '20'); ?>" title="<?php _e('Zoom Out Percentage (0-100)', EG_TEXTDOMAIN); ?>" /> %							</div>
						</div>
					</div>
				</div>

				

				<div>
					<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Filter/Pagination Animation', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc">	
						
						<label for="grid-animation" class="eg-tooltip-wrap" title="<?php _e('Select the Animation for the Filter Page Change Effects', EG_TEXTDOMAIN); ?>"><?php _e('Animation Type', EG_TEXTDOMAIN); ?></label><!--
						--><select id="grid-animation-select" name="grid-animation" style="width: 152px">
							<?php
							foreach($grid_animations as $handle => $name){
								?>
								<option value="<?php echo $handle; ?>"<?php selected($grid_animation_choosen, $handle); ?>><?php echo $name; ?></option>
								<?php
							}
							?>
						</select>
						<div class="div13"></div>
						<label for="grid-animation-speed" class="eg-tooltip-wrap" title="<?php _e('Filter Animation Speed (per item)', EG_TEXTDOMAIN); ?>"><?php _e('Transition Speed', EG_TEXTDOMAIN); ?></label><!--
						--><span id="slider-grid-animation-speed" class="slider-settings"></span><div class="space18"></div><input class="input-settings-small" type="text" name="grid-animation-speed" value="<?php echo $base->getVar($grid, array('params', 'grid-animation-speed'), '1000', 'i'); ?>" readonly="true" /> ms
						<div class="div13"></div>
						<label for="grid-animation-delay" class="eg-tooltip-wrap" title="<?php _e('Create staggered animations by adding a delay value', EG_TEXTDOMAIN); ?>"><?php _e('Transition Delay', EG_TEXTDOMAIN); ?></label><!--
						--><span id="slider-grid-animation-delay" class="slider-settings"></span><div class="space18"></div><input class="input-settings-small" type="text" name="grid-animation-delay" value="<?php echo $base->getVar($grid, array('params', 'grid-animation-delay'), '1', 'i'); ?>" readonly="true" />
						<div id="animation-delay-type-wrap">
							<div class="div13"></div>
							<label for="grid-animation-type" class="eg-tooltip-wrap" title="<?php _e('Animate columns, rows or items individually', EG_TEXTDOMAIN); ?>"><?php _e('Apply Delay to', EG_TEXTDOMAIN); ?></label><!--
							--><?php $animation_type = $base->getVar($grid, array('params', 'grid-animation-type'), 'item'); ?><input type="radio" name="grid-animation-type" value="item" <?php checked($animation_type, 'item'); ?>><span class="eg-tooltip-wrap tooltipstered">Items</span><div class="space18"></div><!--
							--><input type="radio" name="grid-animation-type" value="col" <?php checked($animation_type, 'col'); ?>><span class="eg-tooltip-wrap tooltipstered">Columns</span><div class="space18"></div><!--
							--><input type="radio" name="grid-animation-type" value="row" <?php checked($animation_type, 'row'); ?>><span class="eg-tooltip-wrap tooltipstered">Rows</span>
						</div>
						
					</div>
				</div>

				<div>
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php _e('Hover Animations', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc">	
						<div class="esg-showhidegroup">					
							<label for="grid-item-animation" class="eg-tooltip-wrap" title="<?php _e('Animate the entire Grid Item on Hover', EG_TEXTDOMAIN); ?>"><?php _e('Grid Item Hover Animation', EG_TEXTDOMAIN); ?></label><!--
							--><select id="grid-item-animation" class="grid-item-anime-select" name="grid-item-animation" >
								<?php
								foreach($grid_item_animations as $handle => $name){
									?>
									<option value="<?php echo $handle; ?>"<?php selected($grid_item_animation_choosen, $handle); ?>><?php echo $name; ?></option>
									<?php
								}
								?>
							</select><div class="space18"></div><!--
							--><span class="grid-item-anime-wrap-zoomin grid-item-anime-option"><input  id="grid-item-animation-zoomin" class="input-settings-small eg-tooltip-wrap" type="text" name="grid-item-animation-zoomin" value="<?php echo $base->getVar($grid, array('params', 'grid-item-animation-zoomin'), '125'); ?>" title="<?php _e('Zoom In Percentage (100-200)', EG_TEXTDOMAIN); ?>" /> %</span><!--
							--><span class="grid-item-anime-wrap-zoomout grid-item-anime-option"><input  id="grid-item-animation-zoomout" class="input-settings-small eg-tooltip-wrap" type="text" name="grid-item-animation-zoomout" value="<?php echo $base->getVar($grid, array('params', 'grid-item-animation-zoomout'), '75'); ?>" title="<?php _e('Zoom Out Percentage (0-100)', EG_TEXTDOMAIN); ?>" /> %</span><!--
							--><span class="grid-item-anime-wrap-fade grid-item-anime-option"><input  id="grid-item-animation-fade" class="input-settings-small eg-tooltip-wrap" type="text" name="grid-item-animation-fade" value="<?php echo $base->getVar($grid, array('params', 'grid-item-animation-fade'), '75'); ?>" title="<?php _e('Fade Percentage (0-100)', EG_TEXTDOMAIN); ?>" /> %</span><!--
							--><span class="grid-item-anime-wrap-blur grid-item-anime-option"><input  id="grid-item-animation-blur" class="input-settings-small eg-tooltip-wrap" type="text" name="grid-item-animation-blur" value="<?php echo $base->getVar($grid, array('params', 'grid-item-animation-blur'), '5'); ?>" title="<?php _e('Blur Amount (0-20)', EG_TEXTDOMAIN); ?>" /> px</span><!--
							--><span class="grid-item-anime-wrap-rotate grid-item-anime-option"><input  id="grid-item-animation-rotate" class="input-settings-small eg-tooltip-wrap" type="text" name="grid-item-animation-rotate" value="<?php echo $base->getVar($grid, array('params', 'grid-item-animation-rotate'), '30'); ?>" title="<?php _e('Blur Amount (0-360)', EG_TEXTDOMAIN); ?>" /> deg</span><!--
							--><span class="grid-item-anime-wrap-shift grid-item-anime-option"><select name="grid-item-animation-shift" >
									<?php
									$grid_item_anime_shift = $base->getVar($grid, array('params', 'grid-item-animation-shift'), 'up');
									?>
									<option value="up"<?php selected($grid_item_anime_shift, 'up'); ?>><?php _e('Up', EG_TEXTDOMAIN); ?></option>
									<option value="down"<?php selected($grid_item_anime_shift, 'down'); ?>><?php _e('Down', EG_TEXTDOMAIN); ?></option>
									<option value="left"<?php selected($grid_item_anime_shift, 'left'); ?>><?php _e('Left', EG_TEXTDOMAIN); ?></option>
									<option value="right"<?php selected($grid_item_anime_shift, 'right'); ?>><?php _e('Right', EG_TEXTDOMAIN); ?></option>
								</select><div class="space18"></div><input  id="grid-item-animation-shift-amount" class="input-settings-small eg-tooltip-wrap" type="text" name="grid-item-animation-shift-amount" value="<?php echo $base->getVar($grid, array('params', 'grid-item-animation-shift-amount'), '10'); ?>" title="<?php _e('Shift Amount in pixels', EG_TEXTDOMAIN); ?>" /> px
							</span>
						</div>
						<div class="div13"></div>
						<div class="esg-showhidegroup">						
							<label for="grid-item-animation-other" class="eg-tooltip-wrap" title="<?php _e('Animate other Grid Items on Hover', EG_TEXTDOMAIN); ?>"><?php _e('Grid Item Other Animation', EG_TEXTDOMAIN); ?></label><!--
							--><select id="grid-item-animation-other" class="grid-item-anime-select" name="grid-item-animation-other" >
								<?php
								foreach($grid_item_animations as $handle => $name){
									?>
									<option value="<?php echo $handle; ?>"<?php selected($grid_item_animation_other, $handle); ?>><?php echo $name; ?></option>
									<?php
								}
								?>
							</select><div class="space18"></div><!--
							--><span class="grid-item-anime-wrap-zoomin grid-item-anime-option"><input  id="grid-item-other-zoomin" class="input-settings-small eg-tooltip-wrap" type="text" name="grid-item-other-zoomin" value="<?php echo $base->getVar($grid, array('params', 'grid-item-other-zoomin'), '125'); ?>" title="<?php _e('Zoom In Percentage (100-200)', EG_TEXTDOMAIN); ?>" /> %</span><!--
							--><span class="grid-item-anime-wrap-zoomout grid-item-anime-option"><input  id="grid-item-other-zoomout" class="input-settings-small eg-tooltip-wrap" type="text" name="grid-item-other-zoomout" value="<?php echo $base->getVar($grid, array('params', 'grid-item-other-zoomout'), '75'); ?>" title="<?php _e('Zoom Out Percentage (0-100)', EG_TEXTDOMAIN); ?>" /> %</span><!--
							--><span class="grid-item-anime-wrap-fade grid-item-anime-option"><input  id="grid-item-other-fade" class="input-settings-small eg-tooltip-wrap" type="text" name="grid-item-other-fade" value="<?php echo $base->getVar($grid, array('params', 'grid-item-other-fade'), '75'); ?>" title="<?php _e('Fade Percentage (0-100)', EG_TEXTDOMAIN); ?>" /> %</span><!--
							--><span class="grid-item-anime-wrap-blur grid-item-anime-option"><input  id="grid-item-other-blur" class="input-settings-small eg-tooltip-wrap" type="text" name="grid-item-other-blur" value="<?php echo $base->getVar($grid, array('params', 'grid-item-other-blur'), '5'); ?>" title="<?php _e('Blur Amount (0-20)', EG_TEXTDOMAIN); ?>" /> px</span><!--
							--><span class="grid-item-anime-wrap-rotate grid-item-anime-option"><input  id="grid-item-other-rotate" class="input-settings-small eg-tooltip-wrap" type="text" name="grid-item-other-rotate" value="<?php echo $base->getVar($grid, array('params', 'grid-item-other-rotate'), '30'); ?>" title="<?php _e('Blur Amount (0-360)', EG_TEXTDOMAIN); ?>" /> deg</span><!--
							--><span class="grid-item-anime-wrap-shift grid-item-anime-option"><select name="grid-item-other-shift" >
									<?php
									$grid_item_other_shift = $base->getVar($grid, array('params', 'grid-item-other-shift'), 'up');
									?>
									<option value="up"<?php selected($grid_item_other_shift, 'up'); ?>><?php _e('Up', EG_TEXTDOMAIN); ?></option>
									<option value="down"<?php selected($grid_item_other_shift, 'down'); ?>><?php _e('Down', EG_TEXTDOMAIN); ?></option>
									<option value="left"<?php selected($grid_item_other_shift, 'left'); ?>><?php _e('Left', EG_TEXTDOMAIN); ?></option>
									<option value="right"<?php selected($grid_item_other_shift, 'right'); ?>><?php _e('Right', EG_TEXTDOMAIN); ?></option>
								</select><div class="space18"></div><input  id="grid-item-other-shift-amount" class="input-settings-small eg-tooltip-wrap" type="text" name="grid-item-other-shift-amount" value="<?php echo $base->getVar($grid, array('params', 'grid-item-other-shift-amount'), '10'); ?>" title="<?php _e('Shift Amount in pixels', EG_TEXTDOMAIN); ?>" /> px
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--
		NAVIGATION SETTINGS
		-->
		<div id="esg-settings-filterandco-settings" class="esg-settings-container">
			<div>
				<?php
				/*
				<div>
					<div class="eg-cs-tbc-left">
						<esg-llabel class="box-closed"><span><?php _e('Navigation Settings', EG_TEXTDOMAIN); ?></span></esg-llabel>
					</div>
					<div class="eg-cs-tbc" style="min-width:710px">
						<p>
							<label for="navigation-container"><?php _e("Type", EG_TEXTDOMAIN); ?></label>
							<input type="radio" name="nagivation-type" <?php checked($base->getVar($grid, array('params', 'nagivation-type'), 'internal'), 'internal'); ?> class=" eg-tooltip-wrap" title="<?php _e('Decide in Grid Settings how the navigation will look like', EG_TEXTDOMAIN); ?>" value="internal"><?php _e('Internal', EG_TEXTDOMAIN); ?>
							<input type="radio" name="nagivation-type" <?php checked($base->getVar($grid, array('params', 'nagivation-type'), 'internal'), 'external'); ?> class="eg-tooltip-wrap" title="<?php _e('User the API to generate your navigation to your likings', EG_TEXTDOMAIN); ?>" value="external"><?php _e('External', EG_TEXTDOMAIN); ?>
							<input type="radio" name="nagivation-type" <?php checked($base->getVar($grid, array('params', 'nagivation-type'), 'internal'), 'widget'); ?> class="eg-tooltip-wrap" title="<?php _e('Create/Choose a widget area for the navigation', EG_TEXTDOMAIN); ?>" value="widget"><?php _e('Widget Area', EG_TEXTDOMAIN); ?>
						</p>
					</div>
					<div class="clear"></div>
				</div>
				*/ ?>

				<div id="es-ng-layout-wrapper">
					<div>
						<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Navigation Positions', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
						<!-- 2.1.5 added overflow: auto -->
						<div class="eg-cs-tbc" style="min-width:710px; overflow: auto">
							<?php
							$layout = $base->getVar($grid, array('params', 'navigation-layout'), array());
							$navig_special_class = $base->getVar($grid, array('params', 'navigation-special-class'), array());
							$navig_special_skin = $base->getVar($grid, array('params', 'navigation-special-skin'), array());
							?>
							<script type="text/javascript">
								var eg_nav_special_class = <?php echo json_encode($navig_special_class); ?>;
								var eg_nav_special_skin = <?php echo json_encode($navig_special_skin); ?>;
							</script>
							<div class="esg-msow-inner">
								<div>
									<div><?php _e('Available Modules:', EG_TEXTDOMAIN); ?></div>
									<div class="div13"></div>
									<div class="eg-navigation-cons-wrapper eg-tooltip-wrap eg-navigation-default-wrap" title="<?php _e('Drag and Drop Navigation Modules into the Available Drop Zones', EG_TEXTDOMAIN); ?>">
										<div data-navtype="left" class="eg-navigation-cons-left eg-navigation-cons"<?php echo (isset($layout['left']) && $layout['left'] !== '') ? ' data-putin="'.current(array_keys($layout['left'])).'" data-sort="'.$layout['left'][current(array_keys($layout['left']))].'"' : ''; ?>><i class="eg-icon-left-open"></i></div>
										<div data-navtype="right" class="eg-navigation-cons-right eg-navigation-cons"<?php echo (isset($layout['right']) && $layout['right'] !== '') ? ' data-putin="'.current(array_keys($layout['right'])).'" data-sort="'.$layout['right'][current(array_keys($layout['right']))].'"' : ''; ?>><i class="eg-icon-right-open"></i></div>
										<div data-navtype="pagination" class="eg-navigation-cons-pagination eg-navigation-cons"<?php echo (isset($layout['pagination']) && $layout['pagination'] !== '') ? ' data-putin="'.current(array_keys($layout['pagination'])).'" data-sort="'.$layout['pagination'][current(array_keys($layout['pagination']))].'"' : ''; ?>><i class="eg-icon-doc-inv"></i><?php _e("Pagination", EG_TEXTDOMAIN); ?></div>
										<div data-navtype="filter" class="eg-navigation-cons-filter eg-navigation-cons"<?php echo (isset($layout['filter']) && $layout['filter'] !== '') ? ' data-putin="'.current(array_keys($layout['filter'])).'" data-sort="'.$layout['filter'][current(array_keys($layout['filter']))].'"' : ''; ?>><i class="eg-icon-megaphone"></i><?php _e("Filter 1", EG_TEXTDOMAIN); ?></div>
										<?php
										if(Essential_Grid_Woocommerce::is_woo_exists()){
											?>
											<div data-navtype="cart" class="eg-navigation-cons-cart eg-navigation-cons"<?php echo (isset($layout['cart']) && $layout['cart'] !== '') ? ' data-putin="'.current(array_keys($layout['cart'])).'" data-sort="'.$layout['cart'][current(array_keys($layout['cart']))].'"' : ''; ?>><i class="eg-icon-basket"></i><?php _e("Cart", EG_TEXTDOMAIN); ?></div>
											<?php
										}

										//add extra filters
										if(!empty($layout)){
											foreach($layout as $key => $val){
												if(strpos($key, 'filter-') !== false){
													$nr = str_replace('filter-', '', $key);
													?>
													<div data-navtype="filter-<?php echo $nr; ?>" class="eg-navigation-cons-filter-<?php echo $nr; ?> eg-nav-cons-filter eg-navigation-cons"<?php echo ' data-putin="'.current(array_keys($layout[$key])).'" data-sort="'.$layout[$key][current(array_keys($layout[$key]))].'"'; ?>><i class="eg-icon-megaphone"></i><?php _e("Filter", EG_TEXTDOMAIN); echo ' '.$nr; ?></div>
													<?php
												}
											}
										}
										?>
										<div data-navtype="sort" class="eg-navigation-cons-sort eg-navigation-cons"<?php echo (isset($layout['sorting']) && $layout['sorting'] !== '') ? ' data-putin="'.current(array_keys($layout['sorting'])).'" data-sort="'.$layout['sorting'][current(array_keys($layout['sorting']))].'"' : ''; ?>><i class="eg-icon-sort-name-up"></i><?php _e("Sort", EG_TEXTDOMAIN); ?></div>
										<div data-navtype="search-input" class="eg-navigation-cons-search-input eg-navigation-cons"<?php echo (isset($layout['search-input']) && $layout['search-input'] !== '') ? ' data-putin="'.current(array_keys($layout['search-input'])).'" data-sort="'.$layout['search-input'][current(array_keys($layout['search-input']))].'"' : ''; ?>><i class="eg-icon-search"></i><?php _e("Search", EG_TEXTDOMAIN); ?></div>

										<div class="eg-stay-last-element" style="clear:both"></div>
									</div>
								</div>

								<div id="eg-navigations-drag-wrap">
									<div class="div13"></div>
									<div><?php _e('Controls inside Grid:', EG_TEXTDOMAIN); ?></div>
									<div class="div5"></div>
									<div id="eg-navigations-sort-top-1" class="eg-navigation-drop-wrapper eg-tooltip-wrap" title="<?php _e('Move the Navigation Modules to define the Order of Buttons', EG_TEXTDOMAIN); ?>"><?php _e('DROPZONE - TOP - 1', EG_TEXTDOMAIN); ?><div class="eg-navigation-drop-inner"></div></div>
									<div id="eg-navigations-sort-top-2" class="eg-navigation-drop-wrapper eg-tooltip-wrap" title="<?php _e('Move the Navigation Modules to define the Order of Buttons', EG_TEXTDOMAIN); ?>"><?php _e('DROPZONE - TOP - 2', EG_TEXTDOMAIN); ?><div class="eg-navigation-drop-inner"></div></div>
									<div id="eg-navigations-items-bg" >
										<div class="eg-navconstrctor-pi1"></div>
										<div class="eg-navconstrctor-pi2"></div>
										<div class="eg-navconstrctor-pi3"></div>
										<div class="eg-navconstrctor-pi4"></div>
										<div class="eg-navconstrctor-pi5"></div>
										<div class="eg-navconstrctor-pi6"></div>
										<div id="eg-navigations-sort-left" class="eg-navigation-drop-wrapper"><?php _e('DROPZONE <br> LEFT', EG_TEXTDOMAIN); ?><div class="eg-navigation-drop-inner"></div></div>
										<div id="eg-navigations-sort-right" class="eg-navigation-drop-wrapper"><?php _e('DROPZONE <br> RIGHT', EG_TEXTDOMAIN); ?><div class="eg-navigation-drop-inner"></div></div>
									</div>
									<div id="eg-navigations-sort-bottom-1" class="eg-navigation-drop-wrapper eg-tooltip-wrap" title="<?php _e('Move the Navigation Modules to define the Order of Buttons', EG_TEXTDOMAIN); ?>"><?php _e('DROPZONE - BOTTOM - 1', EG_TEXTDOMAIN); ?><div class="eg-navigation-drop-inner"></div></div>
									<div id="eg-navigations-sort-bottom-2" class="eg-navigation-drop-wrapper eg-tooltip-wrap" title="<?php _e('Move the Navigation Modules to define the Order of Buttons', EG_TEXTDOMAIN); ?>"><?php _e('DROPZONE - BOTTOM - 2', EG_TEXTDOMAIN); ?><div class="eg-navigation-drop-inner"></div></div>
								</div>
								<div id="eg-external-drag-wrap">
									<div class="div13"></div>
									<div><?php _e('Controls anywhere on Page (through ShortCode):', EG_TEXTDOMAIN); ?></div>
									<div class="div5"></div>
									<div id="eg-navigation-external-description">
											<div style="width:132px" class="eg-ext-nav-desc"><?php _e('Button', EG_TEXTDOMAIN); ?></div>
											<div style="width:164px" class="eg-ext-nav-desc"><?php _e('ShortCode', EG_TEXTDOMAIN); ?></div>
											<div style="width:164px" class="eg-ext-nav-desc"><?php _e('Additional Class', EG_TEXTDOMAIN); ?></div>
											<div style="width:164px"class="eg-ext-nav-desc"><?php _e('Skin', EG_TEXTDOMAIN); ?></div>
										</div>
									<div id="eg-navigations-sort-external" class="eg-navigation-drop-wrapper" style="width: 600px; height:316px;">

										<?php _e('DROPZONE - EXTERNAL', EG_TEXTDOMAIN); ?><div class="eg-navigation-drop-inner"></div>
									</div>
								</div>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
							<div style="width:100%;height:25px;clear:both"></div>
						</div>
					</div>

					

					<div>
						<div class="eg-cs-tbc-left">
							<esg-llabel class="box-closed"><span><?php _e('Grid Internal Controls Layout', EG_TEXTDOMAIN); ?></span></esg-llabel>
						</div>
						<div class="eg-cs-tbc">

							<!--  DROPZONE 1 ALIGN -->
							
							<label for="navigation-container"><?php _e("Dropzone Top 1", EG_TEXTDOMAIN); ?></label><!--
							--><input type="radio" name="top-1-align" value="left" <?php checked($base->getVar($grid, array('params', 'top-1-align'), 'center'), 'left'); ?>><span class="eg-tooltip-wrap" title="<?php _e('All Buttons in this Zone Align to the left', EG_TEXTDOMAIN); ?>" ><?php _e("Left", EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input type="radio" name="top-1-align" value="center" <?php checked($base->getVar($grid, array('params', 'top-1-align'), 'center'), 'center'); ?>><span class="eg-tooltip-wrap" title="<?php _e('All Buttons in this Zone Align to Center', EG_TEXTDOMAIN); ?>" ><?php _e("Center", EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input type="radio" name="top-1-align" value="right" <?php checked($base->getVar($grid, array('params', 'top-1-align'), 'center'), 'right'); ?>><span class="eg-tooltip-wrap" title="<?php _e('All Buttons in this Zone Align to the Right', EG_TEXTDOMAIN); ?>"><?php _e("Right", EG_TEXTDOMAIN); ?></span><div class="space36"></div><!--
							--><span class="eg-tooltip-wrap" style="display:inline-block;min-width:90px;text-align: right" title="<?php _e('Space under the Zone', EG_TEXTDOMAIN); ?>"><?php _e('Margin Bottom', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input class="input-settings-small " type="text" name="top-1-margin-bottom" value="<?php echo $base->getVar($grid, array('params', 'top-1-margin-bottom'), '0', 'i'); ?>"> px
							<div class="div13"></div>
							
							<!--  DROPZONE 2 ALIGN -->						
							<label for="navigation-container"><?php _e("Dropzone Top 2", EG_TEXTDOMAIN); ?></label><!--
							--><input type="radio" name="top-2-align" value="left" <?php checked($base->getVar($grid, array('params', 'top-2-align'), 'center'), 'left'); ?>><span class="eg-tooltip-wrap" title="<?php _e('All Buttons in this Zone Align to the left', EG_TEXTDOMAIN); ?>"><?php _e("Left", EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input type="radio" name="top-2-align" value="center" <?php checked($base->getVar($grid, array('params', 'top-2-align'), 'center'), 'center'); ?>><span class="eg-tooltip-wrap" title="<?php _e('All Buttons in this Zone Align to Center', EG_TEXTDOMAIN); ?>"><?php _e("Center", EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input type="radio" name="top-2-align" value="right" <?php checked($base->getVar($grid, array('params', 'top-2-align'), 'center'), 'right'); ?>><span class="eg-tooltip-wrap" title="<?php _e('All Buttons in this Zone Align to the Right', EG_TEXTDOMAIN); ?>"><?php _e("Right", EG_TEXTDOMAIN); ?></span><div class="space36"></div><!--
							--><span class="eg-tooltip-wrap" style="display:inline-block;min-width:90px;text-align: right" title="<?php _e('Space under the Zone', EG_TEXTDOMAIN); ?>"><?php _e('Margin Bottom', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input class="input-settings-small " type="text" name="top-2-margin-bottom" value="<?php echo $base->getVar($grid, array('params', 'top-2-margin-bottom'), '0', 'i'); ?>"> px
							<div class="div13"></div>
							<!--  DROPZONE 3 ALIGN -->
						
							<label for="navigation-container"><?php _e("Dropzone Bottom 1", EG_TEXTDOMAIN); ?></label><!--
							--><input type="radio" name="bottom-1-align" value="left" <?php checked($base->getVar($grid, array('params', 'bottom-1-align'), 'center'), 'left'); ?>><span class="eg-tooltip-wrap" title="<?php _e('All Buttons in this Zone Align to the left', EG_TEXTDOMAIN); ?>"><?php _e("Left", EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input type="radio" name="bottom-1-align" value="center" <?php checked($base->getVar($grid, array('params', 'bottom-1-align'), 'center'), 'center'); ?>><span class="eg-tooltip-wrap" title="<?php _e('All Buttons in this Zone Align to Center', EG_TEXTDOMAIN); ?>"><?php _e("Center", EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input type="radio" name="bottom-1-align" value="right" <?php checked($base->getVar($grid, array('params', 'bottom-1-align'), 'center'), 'right'); ?>><span class="eg-tooltip-wrap" title="<?php _e('All Buttons in this Zone Align to the Right', EG_TEXTDOMAIN); ?>"><?php _e("Right", EG_TEXTDOMAIN); ?></span><div class="space36"></div><!--
							--><span class="eg-tooltip-wrap" style="display:inline-block;min-width:90px;text-align: right" title="<?php _e('Space above the Zone', EG_TEXTDOMAIN); ?>"><?php _e('Margin Top', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input class="input-settings-small " type="text" name="bottom-1-margin-top" value="<?php echo $base->getVar($grid, array('params', 'bottom-1-margin-top'), '0', 'i'); ?>"> px
							<div class="div13"></div>

							<!--  DROPZONE 4 ALIGN -->
							
							<label for="navigation-container"><?php _e("Dropzone Bottom 2", EG_TEXTDOMAIN); ?></label><!--
							--><input type="radio" name="bottom-2-align" value="left" <?php checked($base->getVar($grid, array('params', 'bottom-2-align'), 'center'), 'left'); ?>><span class="eg-tooltip-wrap" title="<?php _e('All Buttons in this Zone Align to the left', EG_TEXTDOMAIN); ?>"><?php _e("Left", EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input type="radio" name="bottom-2-align" value="center" <?php checked($base->getVar($grid, array('params', 'bottom-2-align'), 'center'), 'center'); ?>><span class="eg-tooltip-wrap" title="<?php _e('All Buttons in this Zone Align to Center', EG_TEXTDOMAIN); ?>"><?php _e("Center", EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input type="radio" name="bottom-2-align" value="right" <?php checked($base->getVar($grid, array('params', 'bottom-2-align'), 'center'), 'right'); ?>><span class="eg-tooltip-wrap" title="<?php _e('All Buttons in this Zone Align to the Right', EG_TEXTDOMAIN); ?>"><?php _e("Right", EG_TEXTDOMAIN); ?></span><div class="space36"></div><!--
							--><span class="eg-tooltip-wrap" style="display:inline-block;min-width:90px;text-align: right" title="<?php _e('Space above the Zone', EG_TEXTDOMAIN); ?>"><?php _e('Margin Top', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input class="input-settings-small " type="text" name="bottom-2-margin-top" value="<?php echo $base->getVar($grid, array('params', 'bottom-2-margin-top'), '0', 'i'); ?>"> px
							<div class="div13"></div>

							<!--  DROPZONE LEFT  -->
							
							<label for="navigation-container"><?php _e("Dropzone Left", EG_TEXTDOMAIN); ?></label><!--							
							--><input class="input-settings-small " type="text" name="left-margin-left" value="<?php echo $base->getVar($grid, array('params', 'left-margin-left'), '0', 'i'); ?>"> px
							<div class="div13"></div>

							<!--  DROPZONE RIGHT -->
							<label for="navigation-container"><?php _e("Dropzone Right", EG_TEXTDOMAIN); ?></label><!--							
							--><input class="input-settings-small " type="text" name="right-margin-right" value="<?php echo $base->getVar($grid, array('params', 'right-margin-right'), '0', 'i'); ?>"> px
							<div class="div13"></div>

						</div>
					</div>
					
				</div>

				<!--div id="es-ng-external-wrapper">
					<div>
						<div class="eg-cs-tbc-left">
							<esg-llabel class="box-closed"><span><?php _e('Navigation API', EG_TEXTDOMAIN); ?></span></esg-llabel>
						</div>
						<div class="eg-cs-tbc" style="min-width:710px">
							<pre>

							</pre>
						</div>
					</div>
				</div>
				<div id="es-ng-widget-wrapper">
					<div>
						<div class="eg-cs-tbc-left">
							<esg-llabel class="box-closed"><span><?php _e('Widget Settings', EG_TEXTDOMAIN); ?></span></esg-llabel>
						</div>
						<div class="eg-cs-tbc" style="min-width:710px">
							<p><?php _e('Please add the Essential Grid Navigation Widgets in the Widget Area you want to use.', EG_TEXTDOMAIN); ?></p>

							<?php
							//for later usage
							//$wa->get_all_registered_sidebars();
							?>
						</div>
					</div>
				</div---->

				<div>
					<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Module Spaces', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc">
						<!--  MODULE SPACINGS -->						
						<label for="navigation-container" class="eg-tooltip-wrap" title="<?php _e('Spaces horizontal between the Navigation Modules', EG_TEXTDOMAIN); ?>"><?php _e("Module Spacing", EG_TEXTDOMAIN); ?></label><!--
						--><input class="input-settings-small " type="text" name="module-spacings" value="<?php echo $base->getVar($grid, array('params', 'module-spacings'), '5', 'i'); ?>"> px						
					</div>
				</div>

				

				<div>
					<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Pagination Settings', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc">					
						<label for="pagination-numbers"><?php _e('Page Number Option', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="pagination-numbers" value="smart" <?php checked($base->getVar($grid, array('params', 'pagination-numbers'), 'smart'), 'smart'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('Will show pagination like: 1 2 ... 5 6', EG_TEXTDOMAIN); ?>"><?php _e('Smart', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio" name="pagination-numbers" value="full" <?php checked($base->getVar($grid, array('params', 'pagination-numbers'), 'smart'), 'full'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('Will show full pagination like: 1 2 3 4 5 6', EG_TEXTDOMAIN); ?>"><?php _e('Full', EG_TEXTDOMAIN); ?></span>
						<div class="div13"></div>
						<label for="pagination-scroll"><?php _e('Scroll To Top', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="pagination-scroll" value="on" <?php checked($base->getVar($grid, array('params', 'pagination-scroll'), 'off'), 'on'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('Scroll to top if pagination is clicked', EG_TEXTDOMAIN); ?>"><?php _e('On', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio" name="pagination-scroll" value="off" <?php checked($base->getVar($grid, array('params', 'pagination-scroll'), 'off'), 'off'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('Do nothing if pagination is clicked', EG_TEXTDOMAIN); ?>"><?php _e('Off', EG_TEXTDOMAIN); ?></span>
						<div class="div13"></div>
						<label for="pagination-scroll-offset" class="eg-tooltip-wrap" title="<?php _e('Define an offset for the scrolling position', EG_TEXTDOMAIN); ?>"><?php _e('Scroll To Offset', EG_TEXTDOMAIN); ?></label><!--
						--><input class="input-settings-small " type="text" name="pagination-scroll-offset" value="<?php echo $base->getVar($grid, array('params', 'pagination-scroll-offset'), '0', 'i'); ?>"> px
						
					</div>
				</div>

				

				<div class="filter_groups">
					<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Filter Groups', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc">						
						<label for="filter-arrows"><?php _e('Filter Type', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="filter-arrows" value="single" <?php checked($base->getVar($grid, array('params', 'filter-arrows'), 'single'), 'single'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('Filter is based on 1 Selected Filter in same time.', EG_TEXTDOMAIN); ?>"><?php _e('Single', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio" name="filter-arrows" value="multi" <?php checked($base->getVar($grid, array('params', 'filter-arrows'), 'single'), 'multi'); ?>> <span  class="eg-tooltip-wrap" title="<?php _e('Filter is based on 1 or more Filters in same time.', EG_TEXTDOMAIN); ?>"><?php _e('Multiple', EG_TEXTDOMAIN); ?></span>						
						<div class="eg-filter-logic" style="display: none;">
							<div class="div13"></div>
							<label for="filter-logic"><?php _e('Filter Logic', EG_TEXTDOMAIN); ?></label><!--
							--><input type="radio" name="filter-logic" value="and" <?php checked($base->getVar($grid, array('params', 'filter-logic'), 'or'), 'and'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('Shows all elements that meet ONE OR MORE of the selected filters', EG_TEXTDOMAIN); ?>"><?php _e('AND', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input type="radio" name="filter-logic" value="or" <?php checked($base->getVar($grid, array('params', 'filter-logic'), 'or'), 'or'); ?>> <span  class="eg-tooltip-wrap" title="<?php _e('Shows all elements that meet ALL of the selected filters', EG_TEXTDOMAIN); ?>"><?php _e('OR', EG_TEXTDOMAIN); ?></span>
						</div>
						<div id="convert_mobile_filters">
							<div class="div13"></div>
							<label for="add-filters-by"><?php _e('Add Filters By', EG_TEXTDOMAIN); ?></label><!--
							--><input type="radio" name="add-filters-by" value="default" <?php checked($base->getVar($grid, array('params', 'add-filters-by'), 'default'), 'default'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Combine tags and categories', EG_TEXTDOMAIN); ?>"><?php _e('Default', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input type="radio" name="add-filters-by" value="categories" <?php checked($base->getVar($grid, array('params', 'add-filters-by'), 'default'), 'categories'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Only categories', EG_TEXTDOMAIN); ?>"><?php _e('Categories', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input type="radio" name="add-filters-by" value="tags" <?php checked($base->getVar($grid, array('params', 'add-filters-by'), 'default'), 'tags'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Only tags', EG_TEXTDOMAIN); ?>"><?php _e('Tags', EG_TEXTDOMAIN); ?></span>
						</div>

						<div class="eg-filter-start">
							<div class="div13"></div>
							<label for="filter-start" class="eg-tooltip-wrap" title="<?php _e('Grid starts with this filter(filters comma separated) active. Take slug from below or leave empty to disable.', EG_TEXTDOMAIN); ?>"><?php _e('Start with Filter', EG_TEXTDOMAIN); ?></label><!--
							--><input type="text" name="filter-start" value="<?php echo $base->getVar($grid, array('params', 'filter-start'), ''); ?>" >
						</div>
						<div class="div13"></div>
						<label for="filter-deep-link" class="eg-tooltip-wrap" title="<?php _e('Deep Link to select filter by adding # plus the slug to the loading URL', EG_TEXTDOMAIN); ?>"><?php _e('Deep Linking', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="filter-deep-link" value="on" <?php checked($base->getVar($grid, array('params', 'filter-deep-link'), 'off'), 'on'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('Deep Linking with #slug possible', EG_TEXTDOMAIN); ?>"><?php _e('On', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio" name="filter-deep-link" value="off" <?php checked($base->getVar($grid, array('params', 'filter-deep-link'), 'off'), 'off'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('No Deep Linking with #slug', EG_TEXTDOMAIN); ?>"><?php _e('Off', EG_TEXTDOMAIN); ?></span>
						<div class="div13"></div>
						<label for="filter-show-on"><?php _e('Dropdown Elements on', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="filter-show-on" value="click" <?php checked($base->getVar($grid, array('params', 'filter-show-on'), 'hover'), 'click'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('Filter in Dropdown will be shown on click', EG_TEXTDOMAIN); ?>"><?php _e('Click', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio" name="filter-show-on" value="hover" <?php checked($base->getVar($grid, array('params', 'filter-show-on'), 'hover'), 'hover'); ?>> <span class="eg-tooltip-wrap" title="<?php _e('Filter in Dropdown will be shown on hover', EG_TEXTDOMAIN); ?>"><?php _e('Hover', EG_TEXTDOMAIN); ?></span>
						
						<div id="convert_mobile_filters">
							<div class="div13"></div>
							<label for="convert-mobile-filters"><?php _e('Mobile Filter Conversion', EG_TEXTDOMAIN); ?></label><!--
							--><input type="radio" name="convert-mobile-filters" value="on" <?php checked($base->getVar($grid, array('params', 'convert-mobile-filters'), 'off'), 'on'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Choose to convert "Inline" filter layouts to "Dropdown" on mobile', EG_TEXTDOMAIN); ?>"><?php _e('On', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input type="radio" name="convert-mobile-filters" value="off" <?php checked($base->getVar($grid, array('params', 'convert-mobile-filters'), 'off'), 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Choose to convert "Inline" filter layouts to "Dropdown" on mobile', EG_TEXTDOMAIN); ?>"><?php _e('Off', EG_TEXTDOMAIN); ?></span>
						</div>
						
						<!--<div style="float: left; width: 170px;">
							<p><?php _e('Filter All Text', EG_TEXTDOMAIN); ?></p>
							<p><?php _e('Layout Option', EG_TEXTDOMAIN); ?></p>
							<p class="filter-only-if-dropdown"><?php _e('Dropdown Start Text', EG_TEXTDOMAIN); ?></p>
							<div class="filter-only-for-post" style="margin-bottom: 15px;">
								<p><?php _e('Use Filter Buttons', EG_TEXTDOMAIN); ?></p>
							</div>
						</div>-->
						<div class="eg-original-filter-options-holder">

							<div class="eg-original-filter-options-wrap eg-filter-options-wrap">
								<div class="eg-filter-header-block"><i class="eg-icon-megaphone"></i><?php _e('Filter -', EG_TEXTDOMAIN); ?> <span class="filter-header-id">1</span></div>

								<?php $filterallon = $base->getVar($grid, array('params', 'filter-all-visible'), 'on'); ?>
								<div class="eg-filter-label"><?php _e('Show/Hide Filter "All" Button', EG_TEXTDOMAIN); ?></div>
								<div class="eg-filter-option-field">
									<input type="radio" name="filter-all-visible" data-origname="filter-all-visible-#NR" value="on" class=" filtervisible" style="margin-left: 5px" <?php checked($filterallon, 'on'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Show the Filter All button', EG_TEXTDOMAIN); ?>"><?php _e('Show', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
									--><input type="radio" name="filter-all-visible" data-origname="filter-all-visible-#NR" value="off" class="filtervisible" <?php checked($filterallon, 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Hide the Filter All button', EG_TEXTDOMAIN); ?>"><?php _e('Hide', EG_TEXTDOMAIN); ?></span>
								</div>

								<?php $filtervisible = $base->getVar($grid, array('params', 'filter-all-visible'), 'on') === 'on' ? 'block' : 'none'; ?>
								<div class="eg-filter-visible">
									<div class="eg-filter-label"><?php _e('Filter "All" Text', EG_TEXTDOMAIN); ?></div>
									<div class="eg-filter-option-field eg-tooltip-wrap" title="<?php _e('Visible Title for the ALL Filter Button', EG_TEXTDOMAIN); ?>">
										<input type="text" name="filter-all-text" data-origname="filter-all-text-#NR" value="<?php echo $base->getVar($grid, array('params', 'filter-all-text'), __('Filter - All', EG_TEXTDOMAIN)); ?>" ><!--
										--><span class="eg-remove-filter-tab" style="display: none;"><i class="eg-icon-cancel"></i></span>
									</div>
								</div>

								<div class="eg-filter-label"><?php _e('Layout Option', EG_TEXTDOMAIN); ?></div>
								<div class="eg-filter-option-field">
									<?php
									$filter_listing = $base->getVar($grid, array('params', 'filter-listing'), 'list');
									?>
									<select name="filter-listing" data-origname="filter-listing-#NR">
										<option value="list" <?php selected($filter_listing, 'list'); ?>><?php _e('In Line', EG_TEXTDOMAIN); ?></option>
										<option value="dropdown" <?php selected($filter_listing, 'dropdown'); ?>><?php _e('Dropdown', EG_TEXTDOMAIN); ?></option>
									</select>
								</div>
								<div class="eg-filter-label"><?php _e('Dropdown Start Text', EG_TEXTDOMAIN); ?></div>
								<div class="filter-only-if-dropdown eg-filter-option-field eg-tooltip-wrap"  title="<?php _e('Default Text on the Filter Dropdown List.', EG_TEXTDOMAIN); ?>">
									<?php
									$filter_dropdown_text = $base->getVar($grid, array('params', 'filter-dropdown-text'), __('Filter Categories', EG_TEXTDOMAIN));
									?>
									<input type="text" data-origname="filter-dropdown-text-#NR" name="filter-dropdown-text" value="<?php echo $filter_dropdown_text; ?>" />
								</div>
								<div class="eg-filter-label"><?php _e('Show Number of Elements', EG_TEXTDOMAIN); ?></div>
								<div class="eg-filter-option-field">
									<?php
									$f_counter = $base->getVar($grid, array('params', 'filter-counter'), 'off');
									?>
									<select name="filter-counter" data-origname="filter-counter-#NR">
										<option value="on" <?php selected($f_counter, 'on'); ?>><?php _e('On', EG_TEXTDOMAIN); ?></option>
										<option value="off" <?php selected($f_counter, 'off'); ?>><?php _e('Off', EG_TEXTDOMAIN); ?></option>
									</select>
								</div>
								<div class="eg-filter-label available-filters-in-group"><?php _e('Available Filters in Group', EG_TEXTDOMAIN); ?></div>
								<div style="margin-top: 10px">
									<?php
									$filter_selected = $base->getVar($grid, array('params', 'filter-selected'), '');
									$filter_startup = false;									
									?>
									<div class="eg-media-source-order-wrap eg-filter-selected-order-wrap">
										<?php

										if(!empty($filter_selected)){

											if(!isset($grid['params']['filter-selected'])){ //we are either a new Grid or old Grid that had not this option (since 1.1.0)

												if($grid !== false){ //set the values
													$use_cat = @$categories;
												}else{
													$use_cat = @$postTypesWithCats['post'];
												}

												if(!empty($use_cat)){
													foreach($use_cat as $handle => $cat){
														if(strpos($handle, 'option_disabled_') !== false) continue;
														?>
														<div class="eg-media-source-order esg-blue esg-btn">
															<span><?php echo $cat; ?></span><input class="eg-get-val eg-filter-input eg-filter-selected" type="checkbox" name="filter-selected[]" data-origname="filter-selected-#NR[]" checked="checked" value="<?php echo $handle; ?>" />															
														</div>
														<?php
													}
												}
												$filter_startup = false;
											}else{
												foreach($filter_selected as $fs){
													?>
													<div class="eg-media-source-order esg-blue esg-btn">
														<span><?php echo $fs; ?></span><input class="eg-get-val eg-filter-input eg-filter-selected" type="checkbox" name="filter-selected[]" data-origname="filter-selected-#NR[]" checked="checked" value="<?php echo $fs; ?>" />														
													</div>
													<?php
												}
												$filter_startup = true;
											}

										}else{
											$filter_startup = false;
										}
										?>
									</div>
								</div>
								<div class="eg-filter-option-field eg-filter-option-top-m">
									<div class="eg-filter-add-custom-filter"><i class="eg-icon-plus"></i></div>
								</div>
							</div>
							<?php

							$filter_counter = 1;
							//check if we have more than one filter area
							if(isset($grid['params']) && !empty($grid['params'])){
								foreach($grid['params'] as $key => $params){
									if(strpos($key, 'filter-selected-') !== false){
										$n = str_replace('filter-selected-', '', $key);
										eg_filter_tab_function($n, $grid['params']);
										if($filter_counter < $n) $filter_counter = $n;
									}
								}
								//if($filter_counter > 1) $filter_counter++;
							}

							function eg_filter_tab_function($id, $params){
								global $grid;
								global $categories;
								global $postTypesWithCats;

								$base = new Essential_Grid_Base();
								?>
								<div class="eg-filter-options-wrap" style="display:inline-block">
									<div class="eg-filter-header-block"><i class="eg-icon-megaphone"></i><?php _e('Filter -', EG_TEXTDOMAIN); ?> <span class="filter-header-id"><?php echo $id;?></span></div>

									<?php $filterallon = $base->getVar($params, 'filter-all-visible-'.$id, 'on'); ?>
									<div class="eg-filter-label"><?php _e('Show/Hide Filter "All" Button', EG_TEXTDOMAIN); ?></div>
									<div class="eg-filter-option-field">
										<input type="radio" name="filter-all-visible-<?php echo $id; ?>" data-origname="filter-all-visible-#NR" value="on" class=" filtervisible" style="margin-left: 5px" <?php checked($filterallon, 'on'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Show the Filter All button', EG_TEXTDOMAIN); ?>"><?php _e('Show', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
										--><input type="radio" name="filter-all-visible-<?php echo $id; ?>" data-origname="filter-all-visible-#NR" value="off" class="filtervisible" <?php checked($filterallon, 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Hide the Filter All button', EG_TEXTDOMAIN); ?>"><?php _e('Hide', EG_TEXTDOMAIN); ?></span>
									</div>

									<?php $filtervisible = $base->getVar($params, 'filter-all-visible-'.$id, 'on') === 'on' ? 'block' : 'none'; ?>
									<div class="eg-filter-visible" style="display: <?php echo $filtervisible; ?>">
										<div class="eg-filter-label"><?php _e('Filter "All" Text', EG_TEXTDOMAIN); ?></div>
										<div class="eg-filter-option-field eg-tooltip-wrap" title="<?php _e('Visible Title for the ALL Filter Button', EG_TEXTDOMAIN); ?>">
											<input type="text" name="filter-all-text-<?php echo $id; ?>" data-origname="filter-all-text-#NR" value="<?php echo $base->getVar($params, 'filter-all-text-'.$id, __('Filter - All', EG_TEXTDOMAIN)); ?>" >
											<span class="eg-remove-filter-tab" style="display: none;"><i class="eg-icon-cancel"></i></span>
										</div>
									</div>

									<div class="eg-filter-label"><?php _e('Layout Option', EG_TEXTDOMAIN); ?></div>
									<div class="eg-filter-option-field">
										<?php
										$filter_listing = $base->getVar($params, 'filter-listing-'.$id, 'list');
										?>
										<select name="filter-listing-<?php echo $id; ?>" data-origname="filter-listing-#NR">
											<option value="list" <?php selected($filter_listing, 'list'); ?>><?php _e('In Line', EG_TEXTDOMAIN); ?></option>
											<option value="dropdown" <?php selected($filter_listing, 'dropdown'); ?>><?php _e('Dropdown', EG_TEXTDOMAIN); ?></option>
										</select>
									</div>
									<div class="eg-filter-label"><?php _e('Dropdown Start Text', EG_TEXTDOMAIN); ?></div>
									<div class="filter-only-if-dropdown eg-filter-option-field eg-tooltip-wrap" title="<?php _e('Default Text on the Filter Dropdown List.', EG_TEXTDOMAIN); ?>">
										<?php
										$filter_dropdown_text = $base->getVar($params, 'filter-dropdown-text-'.$id, __('Filter Categories', EG_TEXTDOMAIN));
										?>
										<input type="text" data-origname="filter-dropdown-text-#NR" name="filter-dropdown-text-<?php echo $id; ?>" value="<?php echo $filter_dropdown_text; ?>" />
									</div>
									<div class="eg-filter-label"><?php _e('Show Number of Elements', EG_TEXTDOMAIN); ?></div>
									<div class="eg-filter-option-field">
										<?php
										$f_counter = $base->getVar($params, 'filter-counter-'.$id, 'off');
										?>
										<select name="filter-counter-<?php echo $id; ?>" data-origname="filter-counter-#NR">
											<option value="on" <?php selected($f_counter, 'on'); ?>><?php _e('On', EG_TEXTDOMAIN); ?></option>
											<option value="off" <?php selected($f_counter, 'off'); ?>><?php _e('Off', EG_TEXTDOMAIN); ?></option>
										</select>
									</div>
									<div class="eg-filter-label available-filters-in-group"><?php _e('Available Filters in Group', EG_TEXTDOMAIN); ?></div>
									<div style="margin-top: 10px">
										<?php
										$filter_selected = $base->getVar($params, 'filter-selected-'.$id, '');
										?>
										<div class="eg-media-source-order-wrap eg-filter-selected-order-wrap-<?php echo $id; ?>">
											<?php
											if(!empty($filter_selected)){

												if(!isset($params['filter-selected-'.$id])){ //we are either a new Grid or old Grid that had not this option (since 1.1.0)

													if($grid !== false){ //set the values
														$use_cat = @$categories;
													}else{
														$use_cat = @$postTypesWithCats['post'];
													}

													if(!empty($use_cat)){
														foreach($use_cat as $handle => $cat){
															if(strpos($handle, 'option_disabled_') !== false) continue;
															?>
															<div class="eg-media-source-order esg-blue esg-btn">
																<span><?php echo $cat; ?></span><input class="eg-get-val eg-filter-input eg-filter-selected-<?php echo $id; ?>" type="checkbox" name="filter-selected-<?php echo $id; ?>[]" data-origname="filter-selected-#NR[]" checked="checked" value="<?php echo $handle; ?>" />																
															</div>
															<?php
														}
													}

												}else{
													foreach($filter_selected as $fs){
														?>
														<div class="eg-media-source-order esg-blue esg-btn">
															<span><?php echo $fs; ?></span><input class="eg-get-val eg-filter-input eg-filter-selected-<?php echo $id; ?>" type="checkbox" name="filter-selected-<?php echo $id; ?>[]" data-origname="filter-selected-#NR[]" checked="checked" value="<?php echo $fs; ?>" />															
														</div>
														<?php
													}
												}

											}
											?>
										</div>
									</div>
									<div class="eg-filter-option-field eg-filter-option-top-m">
										<div class="eg-filter-add-custom-filter"><i class="eg-icon-plus"></i></div>
									</div>
								</div>
								<?php
							}

							?>
						</div>
						<div class="eg-add-filter-box"><i class="eg-icon-plus"></i></div>
						<script type="text/javascript">
							var filter_startup = <?php echo ($filter_startup) ? 'true' : 'false'; ?>,
								eg_meta_handles = {},
								eg_filter_handles = {},
								eg_filter_handles_selected = {},
								eg_custom_filter_handles = {};
							<?php
							$f_meta = $eg_meta->get_all_meta(false);

							if(!empty($f_meta) && is_array($f_meta)){
								foreach($f_meta as $fmeta){
									// 2.2.5
									// if($fmeta['type'] == 'multi-select'){
										?>eg_meta_handles['meta-<?php echo $fmeta['handle']; ?>'] = '<?php echo $fmeta['name']; ?>';
										<?php
									// }
								}
							}
							?>

							<?php
							$custom_filter = $base->getVar($grid, array('params', 'custom-filter'), array());
							if(!is_array($custom_filter) && !is_object($custom_filter)) $custom_filter = explode(',', $custom_filter);
							
							if(!empty($custom_filter) && is_array($custom_filter)){
								foreach($custom_filter as $chandle => $cfilter){
									?>eg_filter_handles_selected['<?php echo addslashes($chandle); ?>'] = '<?php echo addslashes($cfilter); ?>';
									<?php
								}
							}
							?>

							var eg_filter_counter = <?php echo $filter_counter; ?>;

							//fill up custom filter dialog with entries
							jQuery('select[name="post_category"] option').each(function(){
								eg_filter_handles[jQuery(this).val()] = jQuery(this).text();
							});

							//eg_filter_handles['option_disabled_999'] = eg_lang.custom_filter;

						</script>
						<div style="clear: both;"></div>
					</div>
				</div>

				

				<div>
					<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Sorting', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc">						
						<label for="sort-by-text" class="eg-tooltip-wrap" title="<?php _e('Visible Sort By text on the sort dropdown.', EG_TEXTDOMAIN); ?>"><?php _e('Sort By Text', EG_TEXTDOMAIN); ?></label><!---
						--><input type="text" name="sort-by-text" style="width:305px" value="<?php echo $base->getVar($grid, array('params', 'sort-by-text'), __('Sort By ', EG_TEXTDOMAIN)); ?>" >						
						<div class="div13"></div>
						<label for="sorting-order-by" class="eg-tooltip-wrap" title="<?php _e('Select Sorting Definitions (multiple available)', EG_TEXTDOMAIN); ?>"><?php _e('Available Sortings', EG_TEXTDOMAIN); ?></label><!--
						--><?php $order_by = explode(',', $base->getVar($grid, array('params', 'sorting-order-by'), 'date')); ?><select name="sorting-order-by" multiple="true" size="9" >
							<?php
							if(Essential_Grid_Woocommerce::is_woo_exists()){
								$wc_sorts = Essential_Grid_Woocommerce::get_arr_sort_by();
								if(!empty($wc_sorts)){
									foreach($wc_sorts as $wc_handle => $wc_name){
										?>
										<option value="<?php echo $wc_handle; ?>"<?php selected(in_array($wc_handle, $order_by), true); ?><?php if(strpos($wc_handle, 'opt_disabled_') !== false) echo ' disabled="disabled"'; ?>><?php echo $wc_name; ?></option>
										<?php
									}
								}
							}
							?>
							<option value="date"<?php selected(in_array('date', $order_by), true); ?>><?php _e('Date', EG_TEXTDOMAIN); ?></option>
							<option value="title"<?php selected(in_array('title', $order_by), true); ?>><?php _e('Title', EG_TEXTDOMAIN); ?></option>
							<option value="excerpt"<?php selected(in_array('excerpt', $order_by), true); ?>><?php _e('Excerpt', EG_TEXTDOMAIN); ?></option>
							<option value="id"<?php selected(in_array('id', $order_by), true); ?>><?php _e('ID', EG_TEXTDOMAIN); ?></option>
							<option value="slug"<?php selected(in_array('slug', $order_by), true); ?>><?php _e('Slug', EG_TEXTDOMAIN); ?></option>
							<option value="author"<?php selected(in_array('author', $order_by), true); ?>><?php _e('Author', EG_TEXTDOMAIN); ?></option>
							<option value="last-modified"<?php selected(in_array('last-modified', $order_by), true); ?>><?php _e('Last modified', EG_TEXTDOMAIN); ?></option>
							<option value="number-of-comments"<?php selected(in_array('number-of-comments', $order_by), true); ?>><?php _e('Number of comments', EG_TEXTDOMAIN); ?></option>
							<option value="views"<?php selected(in_array('views', $order_by), true); ?>><?php _e('Views', EG_TEXTDOMAIN); ?></option>
							<option value="likespost"<?php selected(in_array('likespost', $order_by), true); ?>><?php _e('Post Likes', EG_TEXTDOMAIN); ?></option>
							<option value="likes"<?php selected(in_array('likes', $order_by), true); ?>><?php _e('Likes', EG_TEXTDOMAIN); ?></option>
							<option value="dislikes"<?php selected(in_array('dislikes', $order_by), true); ?>><?php _e('Dislikes', EG_TEXTDOMAIN); ?></option>
							<option value="retweets"<?php selected(in_array('retweets', $order_by), true); ?>><?php _e('Retweets', EG_TEXTDOMAIN); ?></option>
							<option value="favorites"<?php selected(in_array('favorites', $order_by), true); ?>><?php _e('Favorites', EG_TEXTDOMAIN); ?></option>
							<option value="duration"<?php selected(in_array('duration', $order_by), true); ?>><?php _e('Duration', EG_TEXTDOMAIN); ?></option>
							<option value="itemCount"<?php selected(in_array('itemCount', $order_by), true); ?>><?php _e('Item Count', EG_TEXTDOMAIN); ?></option>
							<?php
							if(!empty($all_metas)){
								?>
								<option value="opt_disabled_99" disabled="disabled"><?php _e('---- Custom Metas ----', EG_TEXTDOMAIN); ?></option>
								<?php
								foreach($all_metas as $c_meta){
									$type = ($c_meta['m_type'] == 'link') ? 'egl-' : 'eg-';
									?>
									<option value="<?php echo $type.$c_meta['handle']; ?>"<?php selected(in_array($type.$c_meta['handle'], $order_by), true); ?>><?php echo $c_meta['name'];
									echo ($c_meta['m_type'] == 'link') ? ' (' .__('Link', EG_TEXTDOMAIN).')' : ''; ?></option>
									<?php
								}
							}
							?>
						</select>						
						<div class="div13"></div>
						<label for="sorting-order-by-start" class="eg-tooltip-wrap" title="<?php _e('Sorting at Loading', EG_TEXTDOMAIN); ?>"><?php _e('Start Sorting By', EG_TEXTDOMAIN); ?></label><!--
						--><?php $order_by_start = $base->getVar($grid, array('params', 'sorting-order-by-start'), 'none'); ?><select style="width:305px" name="sorting-order-by-start" >
							<option value="none"<?php selected('none' == $order_by_start, true); ?>><?php _e('None', EG_TEXTDOMAIN); ?></option>
							<?php
							if(Essential_Grid_Woocommerce::is_woo_exists()){
								$wc_sorts = Essential_Grid_Woocommerce::get_arr_sort_by();
								if(!empty($wc_sorts)){
									foreach($wc_sorts as $wc_handle => $wc_name){
										?>
										<option value="<?php echo $wc_handle; ?>"<?php selected(in_array($wc_handle, $order_by), true); ?><?php if(strpos($wc_handle, 'opt_disabled_') !== false) echo ' disabled="disabled"'; ?>><?php echo $wc_name; ?></option>
										<?php
									}
								}
							}
							?>
							<option value="date"<?php selected('date' == $order_by_start, true); ?>><?php _e('Date', EG_TEXTDOMAIN); ?></option>
							<option value="title"<?php selected('title' == $order_by_start, true); ?>><?php _e('Title', EG_TEXTDOMAIN); ?></option>
							<option value="ID"<?php selected('ID' == $order_by_start, true); ?>><?php _e('ID', EG_TEXTDOMAIN); ?></option>
							<option value="name"<?php selected('name' == $order_by_start, true); ?>><?php _e('Slug', EG_TEXTDOMAIN); ?></option>
							<option value="author"<?php selected('author' == $order_by_start, true); ?>><?php _e('Author', EG_TEXTDOMAIN); ?></option>
							<option value="modified"<?php selected('modified' == $order_by_start, true); ?>><?php _e('Last modified', EG_TEXTDOMAIN); ?></option>
							<option value="comment_count"<?php selected('comment_count' == $order_by_start, true); ?>><?php _e('Number of comments', EG_TEXTDOMAIN); ?></option>
							<option value="rand"<?php selected('rand' == $order_by_start, true); ?>><?php _e('Random', EG_TEXTDOMAIN); ?></option>
							<option value="menu_order"<?php selected('menu_order' == $order_by_start, true); ?>><?php _e('Menu Order', EG_TEXTDOMAIN); ?></option>
							<!--option value="meta_num_"<?php selected('meta_num_' == $order_by_start, true); ?>><?php _e('Meta Numeric', EG_TEXTDOMAIN); ?></option>
							<option value="meta_"<?php selected('meta_' == $order_by_start, true); ?>><?php _e('Meta String', EG_TEXTDOMAIN); ?></option-->
							<option value="views"<?php selected('views' == $order_by_start, true); ?>><?php _e('Views', EG_TEXTDOMAIN); ?></option>
							<option value="likespost"<?php selected('likespost' == $order_by_start, true); ?>><?php _e('Post Likes', EG_TEXTDOMAIN); ?></option>
							<option value="likes"<?php selected('likes' == $order_by_start, true); ?>><?php _e('Likes', EG_TEXTDOMAIN); ?></option>
							<option value="dislikes"<?php selected('dislikes' == $order_by_start, true); ?>><?php _e('Dislikes', EG_TEXTDOMAIN); ?></option>
							<option value="retweets"<?php selected('retweets' == $order_by_start, true); ?>><?php _e('Retweets', EG_TEXTDOMAIN); ?></option>
							<option value="favorites"<?php selected('favorites' == $order_by_start, true); ?>><?php _e('Favorites', EG_TEXTDOMAIN); ?></option>
							<option value="duration"<?php selected('duration' == $order_by_start, true); ?>><?php _e('Duration', EG_TEXTDOMAIN); ?></option>
							<option value="itemCount"<?php selected('itemCount' == $order_by_start, true); ?>><?php _e('Item Count', EG_TEXTDOMAIN); ?></option>
							<?php
							if(!empty($all_metas)){
								?>
								<option value="opt_disabled_99" disabled="disabled"><?php _e('---- Custom Metas ----', EG_TEXTDOMAIN); ?></option>
								<?php
								foreach($all_metas as $c_meta){
									$type = ($c_meta['m_type'] == 'link') ? 'egl-' : 'eg-';
									?>
									<option value="<?php echo $type.$c_meta['handle']; ?>"<?php selected($type.$c_meta['handle'] == $order_by_start, true); ?>><?php echo $c_meta['name'];
									echo ($c_meta['m_type'] == 'link') ? ' (' .__('Link', EG_TEXTDOMAIN).')' : ''; ?></option>
									<?php
								}
							}
							?>
						</select>						
						<div class="eg-sorting-order-meta-wrap" style="display: none;">
							<div class="div13"></div>
							<label for="sorting-order-by-start-meta" class="eg-tooltip-wrap" title="<?php _e('Set meta handle here that will be used as start sorting', EG_TEXTDOMAIN); ?>"><?php _e('Start Sorting By Meta', EG_TEXTDOMAIN); ?></label><!--
							--><input type="text" style="width:305px"  name="sorting-order-by-start-meta" value="<?php echo $base->getVar($grid, array('params', 'sorting-order-by-start-meta'), ''); ?>" ><a class=" sort-meta-selector" href="javascript:void(0);"><i class="eg-icon-down-open"></i></a>
						</div>
						<div class="div13"></div>
						<label for="sorting-order-type" class="eg-tooltip-wrap" title="<?php _e('Sorting Order at Loading', EG_TEXTDOMAIN); ?>"><?php _e('Sorting Order', EG_TEXTDOMAIN); ?></label><!--
						--><?php $order_by_type = $base->getVar($grid, array('params', 'sorting-order-type'), 'ASC'); ?><select name="sorting-order-type" style="width:305px">
							<option value="DESC"<?php selected('DESC' == $order_by_type, true); ?>><?php _e('Descending', EG_TEXTDOMAIN); ?></option>
							<option value="ASC"<?php selected('ASC' == $order_by_type, true); ?>><?php _e('Ascending', EG_TEXTDOMAIN); ?></option>
						</select>						
					</div>
				</div>

				

				<div class=" search_settings">
					<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Search Settings', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc">						
						<label for="search-text" class="eg-tooltip-wrap" title="<?php _e('Placeholder text of input field', EG_TEXTDOMAIN); ?>"><?php _e('Search Default Text', EG_TEXTDOMAIN); ?></label><!--
						--><input type="text" style="width:305px"  name="search-text"  value="<?php echo $base->getVar($grid, array('params', 'search-text'), __('Search...', EG_TEXTDOMAIN)); ?>" >						
					</div>
				</div>

			</div>
		</div>



		<!--
		LIGHTBOX SETTINGS
		-->
		<div id="esg-settings-lightbox-settings" class="esg-settings-container">							
			<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Shown Media Orders', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
			<div class="eg-cs-tbc">						
				<label class="eg-tooltip-wrap" title="<?php _e('Set the default order of Shown Content Source', EG_TEXTDOMAIN); ?>"><?php _e('Set Source Order', EG_TEXTDOMAIN); ?></label>												
				<div id="lbo-list" class="eg-media-source-order-wrap" style="margin-bottom:15px">
					<?php
					if(!empty($lb_source_order)){
						foreach($lb_source_order as $lb_handle){
							if(!isset($lb_source_list[$lb_handle])) continue;
							?>
							<div id="lbo-<?php echo $lb_handle; ?>" class="eg-media-source-order esg-blue esg-btn"><i class="eg-icon-<?php echo $lb_source_list[$lb_handle]['type']; ?>"></i><span><?php echo $lb_source_list[$lb_handle]['name']; ?></span><input class="eg-get-val eg-lb-source-list" type="checkbox" name="lb-source-order[]" checked="checked" value="<?php echo $lb_handle; ?>" /></div>
							<?php
							unset($lb_source_list[$lb_handle]);
						}
					}

					if(!empty($lb_source_list)){
						foreach($lb_source_list as $lb_handle => $lb_set){
							?>
							<div id="lbo-<?php echo $lb_handle; ?>" class="eg-media-source-order esg-purple esg-btn"><i class="eg-icon-<?php echo $lb_set['type']; ?>"></i><span><?php echo $lb_set['name']; ?></span><input class="eg-get-val eg-lb-source-list" type="checkbox" name="lb-source-order[]" value="<?php echo $lb_handle; ?>" /></div>
							<?php
						}
					}
					?>
				</div>							
				<div><label></label><?php _e('First Ordered Poster Source will be loaded as default. If source not exist, next available Poster source in order will be taken', EG_TEXTDOMAIN); ?></div>												
			</div>
			<?php
			
			
			?>
			<div>				
				<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Lightbox Gallery', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc">						
					<?php
					$lighbox_mode = $base->getVar($grid, array('params', 'lightbox-mode'), 'single');
					?>
					<label for="lightbox-mode" class="eg-tooltip-wrap" title="<?php _e('Choose the Lightbox Mode', EG_TEXTDOMAIN); ?>"><?php _e('Gallery Mode', EG_TEXTDOMAIN); ?></label><!--
					--><select name="lightbox-mode" style="width:305px">
						<option value="single"<?php selected($lighbox_mode, 'single'); ?>><?php _e('Single Mode', EG_TEXTDOMAIN); ?></option>
						<option value="all"<?php selected($lighbox_mode, 'all'); ?>><?php _e('All Items', EG_TEXTDOMAIN); ?></option>
						<option value="filterall"<?php selected($lighbox_mode, 'filterall'); ?>><?php _e('Filter based all Pages', EG_TEXTDOMAIN); ?></option>
						<option value="filterpage"<?php selected($lighbox_mode, 'filterpage'); ?>><?php _e('Filter based current Page', EG_TEXTDOMAIN); ?></option>
						<option value="content"<?php selected($lighbox_mode, 'content'); ?>><?php _e('Content based', EG_TEXTDOMAIN); ?></option>
						<option value="content-gallery"<?php selected($lighbox_mode, 'content-gallery'); ?>><?php _e('Content Gallery based', EG_TEXTDOMAIN); ?></option>
						<?php
							if(Essential_Grid_Woocommerce::is_woo_exists()){
							?>
							<option value="woocommerce-gallery"<?php selected($lighbox_mode, 'woocommerce-gallery'); ?>><?php _e('WooCommerce Gallery', EG_TEXTDOMAIN); ?></option>
							<?php
							}
						?>
					</select>
					<div class="lightbox-mode-addition-wrapper"<?php echo ($lighbox_mode == 'content' || $lighbox_mode == 'content-gallery' || $lighbox_mode == 'woocommerce-gallery') ? '' : ' style="display: none;"'; ?>>
						<div class="div13"></div>
						<label for="lightbox-exclude-media"><?php _e('Exclude Original Media', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="lightbox-exclude-media" value="on" <?php checked($base->getVar($grid, array('params', 'lightbox-exclude-media'), 'off'), 'on'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Exclude original media from Source Order', EG_TEXTDOMAIN); ?>"><?php _e('On', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio" name="lightbox-exclude-media" value="off" <?php checked($base->getVar($grid, array('params', 'lightbox-exclude-media'), 'off'), 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Include original media from Source Order', EG_TEXTDOMAIN); ?>"><?php _e('Off', EG_TEXTDOMAIN); ?></span>
					</div>
					<div class="div13"></div>
					<label><?php _e('Group Name', EG_TEXTDOMAIN); ?></label><?php $lightbox_deep_link = $base->getVar($grid, array('params', 'lightbox-deep-link'), 'group'); ?><input type="text" name="lightbox-deep-link" style="width:305px" value="<?php echo $lightbox_deep_link; ?>" />
					<div class="div13"></div>
					<label class="eg-tooltip-wrap" title="<?php _e('AutoPlay Media', EG_TEXTDOMAIN); ?>"><?php _e('Play Videos Auto', EG_TEXTDOMAIN); ?></label><!--
					--><input type="radio" name="lightbox-videoautoplay" value="on" <?php checked($base->getVar($grid, array('params', 'lightbox-videoautoplay'), 'on'), 'on'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Play videos automatically', EG_TEXTDOMAIN); ?>"><?php _e('On', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
					--><input type="radio" name="lightbox-videoautoplay" value="off" <?php checked($base->getVar($grid, array('params', 'lightbox-videoautoplay'), 'on'), 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Do not play videos automatically', EG_TEXTDOMAIN); ?>"><?php _e('Off', EG_TEXTDOMAIN); ?></span>							
							
				</div>

				<div>					
					<div>
						<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Title / Spacings', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
						<div class="eg-cs-tbc">							
							<label class="eg-tooltip-wrap" title="<?php _e('Show Item Title', EG_TEXTDOMAIN); ?>"><?php _e('Show Title', EG_TEXTDOMAIN); ?></label><!--
							--><input type="radio" name="lightbox-title" value="on" <?php checked($base->getVar($grid, array('params', 'lightbox-title'), 'off'), 'on'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Display Item Title', EG_TEXTDOMAIN); ?>"><?php _e('On', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input type="radio" name="lightbox-title" value="off" <?php checked($base->getVar($grid, array('params', 'lightbox-title'), 'off'), 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Do not display Item Title', EG_TEXTDOMAIN); ?>"><?php _e('Off', EG_TEXTDOMAIN); ?></span>							
							<div class="div13"></div>
							<?php
							$lbox_padding = $base->getVar($grid, array('params', 'lbox-padding'), '0');
							if(!is_array($lbox_padding)) $lbox_padding = array('0', '0', '0', '0');
							?>
							<label for="lbox-padding"><?php _e('Item Margin', EG_TEXTDOMAIN); ?></label><!--
							--><input class="input-settings-small eg-tooltip-wrap" title="<?php _e('Padding Top of the LightBox', EG_TEXTDOMAIN); ?>" type="text" name="lbox-padding[]" value="<?php echo @$lbox_padding[0]; ?>" /> px<div class="space18"></div><!--
							--><input class="input-settings-small eg-tooltip-wrap" title="<?php _e('Padding Right of the LightBox', EG_TEXTDOMAIN); ?>" type="text" name="lbox-padding[]" value="<?php echo @$lbox_padding[1]; ?>" /> px<div class="space18"></div><!--
							--><input class="input-settings-small eg-tooltip-wrap" title="<?php _e('Padding Bottom of the LightBox', EG_TEXTDOMAIN); ?>" type="text" name="lbox-padding[]" value="<?php echo @$lbox_padding[2]; ?>" /> px<div class="space18"></div><!--
							--><input class="input-settings-small eg-tooltip-wrap" title="<?php _e('Padding Left of the LightBox', EG_TEXTDOMAIN); ?>" type="text" name="lbox-padding[]" value="<?php echo @$lbox_padding[3]; ?>" /> px
						</div>
						</div>
					<div>
						<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Effects', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
						<div class="eg-cs-tbc">							
							<label for="" class="eg-tooltip-wrap" title="<?php _e('Animation Type', EG_TEXTDOMAIN); ?>,<?php _e('Animation Speed', EG_TEXTDOMAIN); ?>"><?php _e('Open / Close Animation', EG_TEXTDOMAIN); ?></label><!--
							--><select name="lightbox-effect-open-close" style="width: 120px; margin-right: 20px">
								<option value="false"<?php selected($base->getVar($grid, array('params', 'lightbox-effect-open-close'), 'fade'), 'false'); ?>><?php _e('None', EG_TEXTDOMAIN); ?></option>
								<option value="fade"<?php selected($base->getVar($grid, array('params', 'lightbox-effect-open-close'), 'fade'), 'fade'); ?>><?php _e('Fade', EG_TEXTDOMAIN); ?></option>
								<option value="zoom-in-out"<?php selected($base->getVar($grid, array('params', 'lightbox-effect-open-close'), 'fade'), 'zoom-in-out'); ?>><?php _e('Zoom In Out', EG_TEXTDOMAIN); ?></option>
							</select><!--
							--><?php
								$lightbox_effect_open_close_speed = $base->getVar($grid, array('params', 'lightbox-effect-open-close-speed'), '500');
								if(!is_numeric($lightbox_effect_open_close_speed)) $lightbox_effect_open_close_speed = '500';
							?><span class="eg-tooltip-wrap" title="<?php _e('Animation Speed', EG_TEXTDOMAIN); ?>">Speed</span><div class="space18"></div><input class="input-settings-small" type="text" name="lightbox-effect-open-close-speed" value="<?php echo $lightbox_effect_open_close_speed; ?>" /> ms
							<div class="div13"></div>
							<label for="" class="eg-tooltip-wrap" title="<?php _e('Transition Type', EG_TEXTDOMAIN); ?>,<?php _e('Transition Speed', EG_TEXTDOMAIN); ?>"><?php _e('Next / Prev Animation', EG_TEXTDOMAIN); ?></label><!--
							--><select name="lightbox-effect-next-prev" style="width: 120px; margin-right: 20px">
								<option value="none"<?php selected($base->getVar($grid, array('params', 'lightbox-effect-next-prev'), 'fade'), 'false'); ?>><?php _e('None', EG_TEXTDOMAIN); ?></option>
								<option value="fade"<?php selected($base->getVar($grid, array('params', 'lightbox-effect-next-prev'), 'fade'), 'fade'); ?>><?php _e('Fade', EG_TEXTDOMAIN); ?></option>
								<option value="slide"<?php selected($base->getVar($grid, array('params', 'lightbox-effect-next-prev'), 'fade'), 'slide'); ?>><?php _e('Slide', EG_TEXTDOMAIN); ?></option>
								<option value="circular"<?php selected($base->getVar($grid, array('params', 'lightbox-effect-next-prev'), 'fade'), 'circular'); ?>><?php _e('Circular', EG_TEXTDOMAIN); ?></option>
								<option value="tube"<?php selected($base->getVar($grid, array('params', 'lightbox-effect-next-prev'), 'fade'), 'tube'); ?>><?php _e('Tube', EG_TEXTDOMAIN); ?></option>
								<option value="zoom-in-out"<?php selected($base->getVar($grid, array('params', 'lightbox-effect-next-prev'), 'fade'), 'zoom-in-out'); ?>><?php _e('Zoom In Out', EG_TEXTDOMAIN); ?></option>
								<option value="rotate"<?php selected($base->getVar($grid, array('params', 'lightbox-effect-next-prev'), 'fade'), 'rotate'); ?>><?php _e('Rotate', EG_TEXTDOMAIN); ?></option>
							</select><!--
							--><?php
								$lightbox_effect_next_prev_speed = $base->getVar($grid, array('params', 'lightbox-effect-next-prev-speed'), '500');
								if(!is_numeric($lightbox_effect_next_prev_speed)) $lightbox_effect_next_prev_speed = '500';
							?><span class="eg-tooltip-wrap" title="<?php _e('Transition Speed', EG_TEXTDOMAIN); ?>">Speed</span><div class="space18"></div><input class="input-settings-small" type="text" name="lightbox-effect-next-prev-speed" value="<?php echo $lightbox_effect_next_prev_speed; ?>" /> ms							
						</div>
					</div>
				</div>
				<div>
					<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Auto Rotate', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc">					
						<label><?php _e('Auto Rotate Mode', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="lightbox-autoplay" value="on" <?php checked($base->getVar($grid, array('params', 'lightbox-autoplay'), 'off'), 'on'); ?>><span class="eg-tooltip-wrap" title="<?php _e('AutoPlay Elements in Lightbox.', EG_TEXTDOMAIN); ?>"><?php _e('On', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio" name="lightbox-autoplay" value="off" <?php checked($base->getVar($grid, array('params', 'lightbox-autoplay'), 'off'), 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Dont AutoPlay Elements in LightBox.', EG_TEXTDOMAIN); ?>"><?php _e('Off', EG_TEXTDOMAIN); ?></span>
						<div class="div13"></div>
						<label><?php _e('Auto Rotate Delays:', EG_TEXTDOMAIN); ?></label><!--
						--><input type="text" name="lbox-playspeed" value="<?php echo $base->getVar($grid, array('params', 'lbox-playspeed'), '3000'); ?>">
					</div>
				</div>
				<div>								
					<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Slideshow', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc">						
						<label class="eg-tooltip-wrap" title="<?php _e('Show Navigation Arrows.', EG_TEXTDOMAIN); ?>"><?php _e('Navigation Arrows', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="lightbox-arrows" value="on" <?php checked($base->getVar($grid, array('params', 'lightbox-arrows'), 'on'), 'on'); ?>><?php _e('On', EG_TEXTDOMAIN); ?><div class="space18"></div><!--
						--><input type="radio" name="lightbox-arrows" value="off" <?php checked($base->getVar($grid, array('params', 'lightbox-arrows'), 'on'), 'off'); ?>><?php _e('Off', EG_TEXTDOMAIN); ?>
						<div class="div13"></div>
						<label><?php _e('Loop Items', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="lightbox-loop" value="on" <?php checked($base->getVar($grid, array('params', 'lightbox-loop'), 'on'), 'on'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Loop items after last is shown.', EG_TEXTDOMAIN); ?>"><?php _e('On', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio" name="lightbox-loop" value="off" <?php checked($base->getVar($grid, array('params', 'lightbox-loop'), 'on'), 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Do not loop items.', EG_TEXTDOMAIN); ?>"><?php _e('Off', EG_TEXTDOMAIN); ?></span>
						<div class="div13"></div>
						<label><?php _e('Item Numbers', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="lightbox-numbers" value="on" <?php checked($base->getVar($grid, array('params', 'lightbox-numbers'), 'on'), 'on'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Show numbers such as 1-8, etc.', EG_TEXTDOMAIN); ?>"><?php _e('On', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio" name="lightbox-numbers" value="off" <?php checked($base->getVar($grid, array('params', 'lightbox-numbers'), 'on'), 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Do not display numbers', EG_TEXTDOMAIN); ?>"><?php _e('Off', EG_TEXTDOMAIN); ?></span>
						<div class="div13"></div>
						<label><?php _e('Mouse Wheel', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="lightbox-mousewheel" value="on" <?php checked($base->getVar($grid, array('params', 'lightbox-mousewheel'), 'off'), 'on'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Enable mouse wheel to change items when lightbox is open', EG_TEXTDOMAIN); ?>"><?php _e('On', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio" name="lightbox-mousewheel" value="off" <?php checked($base->getVar($grid, array('params', 'lightbox-mousewheel'), 'off'), 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Do not use mouse wheel', EG_TEXTDOMAIN); ?>"><?php _e('Off', EG_TEXTDOMAIN); ?></span>						
					</div>
				</div>
					

				<!-- begin buttons -->				
				<div>
					<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Toolbar Buttons', EG_TEXTDOMAIN); ?></span></esg-llabel></div>					
					<div class="eg-cs-tbc">					
						<label class="eg-tooltip-wrap" title="<?php _e('Choose which buttons to display and set their order', EG_TEXTDOMAIN); ?>"><?php _e('Set Button Order', EG_TEXTDOMAIN); ?></label>					
						<div id="lbo-btn-list" class="eg-media-source-order-wrap">
							<?php
							if(!empty($lb_button_order)){
								foreach($lb_button_order as $lb_handle){
									if(!isset($lb_button_list[$lb_handle])) continue;
									?>
									<div id="lbo-<?php echo $lb_handle; ?>" class="eg-media-source-order esg-blue esg-btn"><i class="eg-icon-<?php echo $lb_button_list[$lb_handle]['type']; ?>"></i><span><?php echo $lb_button_list[$lb_handle]['name']; ?></span><input class="eg-get-val" type="checkbox" name="lb-button-order[]" checked="checked" value="<?php echo $lb_handle; ?>" /></div>
									<?php
									unset($lb_button_list[$lb_handle]);
								}
							}

							if(!empty($lb_button_list)){
								foreach($lb_button_list as $lb_handle => $lb_set){
									?>
									<div id="lbo-button-<?php echo $lb_handle; ?>" class="eg-media-source-order esg-purple esg-btn"><i class="eg-icon-<?php echo $lb_set['type']; ?>"></i><span ><?php echo $lb_set['name']; ?></span><input class="eg-get-val" type="checkbox" name="lb-button-order[]" value="<?php echo $lb_handle; ?>" /></div>
									<?php
								}
							}
							?>
						</div>																	
					</div>
				</div><!-- end buttons -->

				<div id="eg-post-content-options">
					<!-- 2.1.6 -->
					<div class="eg-creative-settings">
						<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Post Content', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
						<div class="eg-cs-tbc">							
							<label for="lightbox-post-content-min-width" class="eg-tooltip-wrap" title="<?php _e('percentage or pixel based', EG_TEXTDOMAIN); ?>"><?php _e('Content Min Width', EG_TEXTDOMAIN); ?></label>
							<input class="input-settings-small " type="text" name="lightbox-post-content-min-width" value="<?php echo $base->getVar($grid, array('params', 'lightbox-post-content-min-width'), '75'); ?>" />
							<input type="radio" name="lightbox-post-content-min-perc" value="on" <?php checked($base->getVar($grid, array('params', 'lightbox-post-content-min-perc'), 'on'), 'on'); ?>> <?php _e('%', EG_TEXTDOMAIN); ?>
							<input type="radio" name="lightbox-post-content-min-perc" value="off" <?php checked($base->getVar($grid, array('params', 'lightbox-post-content-min-perc'), 'on'), 'off'); ?>> <?php _e('px', EG_TEXTDOMAIN); ?>
							<div class="div13"></div>
							<label for="lightbox-post-content-max-width" class="eg-tooltip-wrap" title="<?php _e('percentage or pixel based', EG_TEXTDOMAIN); ?>"><?php _e('Content Max Width', EG_TEXTDOMAIN); ?></label>
							<input class="input-settings-small " type="text" name="lightbox-post-content-max-width" value="<?php echo $base->getVar($grid, array('params', 'lightbox-post-content-max-width'), '75'); ?>" />
							<input type="radio" name="lightbox-post-content-max-perc" value="on" <?php checked($base->getVar($grid, array('params', 'lightbox-post-content-max-perc'), 'on'), 'on'); ?>> <?php _e('%', EG_TEXTDOMAIN); ?>
							<input type="radio" name="lightbox-post-content-max-perc" value="off" <?php checked($base->getVar($grid, array('params', 'lightbox-post-content-max-perc'), 'on'), 'off'); ?>> <?php _e('px', EG_TEXTDOMAIN); ?>
							<div class="div13"></div>
							<label for="lightbox-post-content-overflow" class="eg-tooltip-wrap" title="<?php _e('allow content scrolling', EG_TEXTDOMAIN); ?>"><?php _e('Content Overflow', EG_TEXTDOMAIN); ?></label>
							<input type="radio" name="lightbox-post-content-overflow" value="on" <?php checked($base->getVar($grid, array('params', 'lightbox-post-content-overflow'), 'on'), 'on'); ?>> <?php _e('On', EG_TEXTDOMAIN); ?>
							<input type="radio" name="lightbox-post-content-overflow" value="off" <?php checked($base->getVar($grid, array('params', 'lightbox-post-content-overflow'), 'on'), 'off'); ?>> <?php _e('Off', EG_TEXTDOMAIN); ?>
							<div class="div13"></div>
							<?php
							$lbox_post_img_padding = $base->getVar($grid, array('params', 'lbox-content_padding'), '0');
							if(!is_array($lbox_post_img_padding)) $lbox_post_img_padding = array('0', '0', '0', '0');
							?>
							<label><?php _e('Post Content Padding', EG_TEXTDOMAIN); ?></label>
							<span class="eg-tooltip-wrap" title="<?php _e('Padding Top (px)', EG_TEXTDOMAIN); ?>">Top</span> <input class="input-settings-small " type="text" style="margin-right:10px" name="lbox-content_padding[]" value="<?php echo @$lbox_post_img_padding[0]; ?>" />
							<span class="eg-tooltip-wrap" title="<?php _e('Padding Right (px)', EG_TEXTDOMAIN); ?>">Right</span> <input class="input-settings-small " type="text" style="margin-right:10px" name="lbox-content_padding[]" value="<?php echo @$lbox_post_img_padding[1]; ?>" />
							<span class="eg-tooltip-wrap" title="<?php _e('Padding Bottom (px)', EG_TEXTDOMAIN); ?>">Bottom</span> <input class="input-settings-small " type="text" style="margin-right:10px" name="lbox-content_padding[]" value="<?php echo @$lbox_post_img_padding[2]; ?>" />
							<span class="eg-tooltip-wrap" title="<?php _e('Padding Left (px)', EG_TEXTDOMAIN); ?>">Left</span> <input class="input-settings-small " type="text" style="margin-right:10px" name="lbox-content_padding[]" value="<?php echo @$lbox_post_img_padding[3]; ?>" />
							<div class="div13"></div>
							<label class="eg-tooltip-wrap" title="<?php _e('Show spinner preloader on item while content loads', EG_TEXTDOMAIN); ?>"><?php _e('Show Preloader', EG_TEXTDOMAIN); ?></label>
							<input type="radio" name="lightbox-post-spinner" value="on" <?php checked($base->getVar($grid, array('params', 'lightbox-post-spinner'), 'off'), 'on'); ?>> <?php _e('On', EG_TEXTDOMAIN); ?>
							<input type="radio" name="lightbox-post-spinner" value="off" <?php checked($base->getVar($grid, array('params', 'lightbox-post-spinner'), 'off'), 'off'); ?>> <?php _e('Off', EG_TEXTDOMAIN); ?>
							<div class="div13"></div>
							<label class="eg-tooltip-wrap" title="<?php _e('Include Featured Image from Post', EG_TEXTDOMAIN); ?>"><?php _e('Include Featured Image', EG_TEXTDOMAIN); ?></label>
							<input type="radio" class="lightbox-post-content-img " name="lightbox-post-content-img" value="on" <?php checked($base->getVar($grid, array('params', 'lightbox-post-content-img'), 'off'), 'on'); ?>> <?php _e('On', EG_TEXTDOMAIN); ?>
							<input type="radio" class="lightbox-post-content-img" name="lightbox-post-content-img" value="off" <?php checked($base->getVar($grid, array('params', 'lightbox-post-content-img'), 'off'), 'off'); ?>> <?php _e('Off', EG_TEXTDOMAIN); ?>							
							<div class="featured-img-hideable">
								<div class="div13"></div>
								<label class="eg-tooltip-wrap" title="<?php _e('Featured Image position in relation to the content', EG_TEXTDOMAIN); ?>"><?php _e('Featured Image Position', EG_TEXTDOMAIN); ?></label>
								<select id="lightbox-post-content-img-position" name="lightbox-post-content-img-position">
									<option value="top"<?php selected($base->getVar($grid, array('params', 'lightbox-post-content-img-position'), 'top'), 'top'); ?>><?php _e('Top', EG_TEXTDOMAIN); ?></option>
									<option value="right"<?php selected($base->getVar($grid, array('params', 'lightbox-post-content-img-position'), 'top'), 'right'); ?>><?php _e('Right', EG_TEXTDOMAIN); ?></option>
									<option value="bottom"<?php selected($base->getVar($grid, array('params', 'lightbox-post-content-img-position'), 'top'), 'bottom'); ?>><?php _e('Bottom', EG_TEXTDOMAIN); ?></option>
									<option value="left"<?php selected($base->getVar($grid, array('params', 'lightbox-post-content-img-position'), 'top'), 'left'); ?>><?php _e('Left', EG_TEXTDOMAIN); ?></option>
								</select>
							</div>
							<?php
								$lbMaxWidthDisplay = $base->getVar($grid, array('params', 'lightbox-post-content-img-position'), 'top');
								$lbMaxWidthDisplay = $lbMaxWidthDisplay === 'left' || $lbMaxWidthDisplay === 'right' ? 'block' : 'none';
							?>
							<div class="featured-img-hideable">
								<div id="lightbox-post-content-img-width" style="display: <?php echo $lbMaxWidthDisplay; ?>">
									<div class="div13"></div>
									<label for="lightbox-post-content-img-width" class="eg-tooltip-wrap" title="<?php _e('Percentage based on Lightbox Default Width above', EG_TEXTDOMAIN); ?>"><?php _e('Featured Image Max Width', EG_TEXTDOMAIN); ?></label>
									<input class="input-settings-small " type="text" name="lightbox-post-content-img-width" value="<?php echo $base->getVar($grid, array('params', 'lightbox-post-content-img-width'), '50'); ?>" /> %
								</div>
							</div>
							<div class="featured-img-hideable">
								<div class="div13"></div>
								<?php
								$lbox_post_img_margin = $base->getVar($grid, array('params', 'lightbox-post-content-img-margin'), '0');
								if(!is_array($lbox_post_img_margin)) $lbox_post_img_margin = array('0', '0', '0', '0');
								?>
								<label for="lightbox-post-content-img-margin"><?php _e('Featured Image Margin', EG_TEXTDOMAIN); ?></label>
								<span class="eg-tooltip-wrap" title="<?php _e('Margin Top of the Featured Image (px)', EG_TEXTDOMAIN); ?>">Top</span> <input class="input-settings-small " type="text" style="margin-right:10px" name="lightbox-post-content-img-margin[]" value="<?php echo @$lbox_post_img_margin[0]; ?>" />
								<span class="eg-tooltip-wrap" title="<?php _e('Margin Right of the Featured Image (px)', EG_TEXTDOMAIN); ?>">Right</span> <input class="input-settings-small " type="text" style="margin-right:10px" name="lightbox-post-content-img-margin[]" value="<?php echo @$lbox_post_img_margin[1]; ?>" />
								<span class="eg-tooltip-wrap" title="<?php _e('Margin Bottom of the Featured Image (px)', EG_TEXTDOMAIN); ?>">Bottom</span> <input class="input-settings-small " type="text" style="margin-right:10px" name="lightbox-post-content-img-margin[]" value="<?php echo @$lbox_post_img_margin[2]; ?>" />
								<span class="eg-tooltip-wrap" title="<?php _e('Margin Left of the Featured Image (px)', EG_TEXTDOMAIN); ?>">Left</span> <input class="input-settings-small " type="text" style="margin-right:10px" name="lightbox-post-content-img-margin[]" value="<?php echo @$lbox_post_img_margin[3]; ?>" />
							</div>
							<div class="div13"></div>
							<label class="eg-tooltip-wrap" title="<?php _e('Include Post Title Before Content', EG_TEXTDOMAIN); ?>"><?php _e('Prepend Post Title', EG_TEXTDOMAIN); ?></label>
							<input type="radio" name="lightbox-post-content-title" value="on" <?php checked($base->getVar($grid, array('params', 'lightbox-post-content-title'), 'off'), 'on'); ?>> <?php _e('On', EG_TEXTDOMAIN); ?>
							<input type="radio" name="lightbox-post-content-title" value="off" <?php checked($base->getVar($grid, array('params', 'lightbox-post-content-title'), 'off'), 'off'); ?>> <?php _e('Off', EG_TEXTDOMAIN); ?>
							<div class="div13"></div>
							<label class="eg-tooltip-wrap" title="<?php _e('The tag for the Post Title', EG_TEXTDOMAIN); ?>"><?php _e('Post Title HTML Tag', EG_TEXTDOMAIN); ?></label>
							<select name="lightbox-post-content-title-tag">
								<option value="h1"<?php selected($base->getVar($grid, array('params', 'lightbox-post-content-title-tag'), 'h2'), 'h1'); ?>><?php _e('h1', EG_TEXTDOMAIN); ?></option>
								<option value="h2"<?php selected($base->getVar($grid, array('params', 'lightbox-post-content-title-tag'), 'h2'), 'h2'); ?>><?php _e('h2', EG_TEXTDOMAIN); ?></option>
								<option value="h3"<?php selected($base->getVar($grid, array('params', 'lightbox-post-content-title-tag'), 'h2'), 'h3'); ?>><?php _e('h3', EG_TEXTDOMAIN); ?></option>
								<option value="h4"<?php selected($base->getVar($grid, array('params', 'lightbox-post-content-title-tag'), 'h2'), 'h4'); ?>><?php _e('h4', EG_TEXTDOMAIN); ?></option>
								<option value="p"<?php selected($base->getVar($grid, array('params', 'lightbox-post-content-title-tag'), 'h2'), 'p'); ?>><?php _e('p', EG_TEXTDOMAIN); ?></option>
							</select>							
						</div><!-- END of esg-cs-tbc -->
					</div><!-- END of eg-creative-settings -->
				</div><!-- END of eg-post-content-options -->		
			</div><!-- END of eg-hide-if-social-gallery-is-enabled -->
		</div><!-- END esg-settings-lightbox-settings -->		
		
	

		<!--
		AJAX SETTINGS
		-->
		<div id="esg-settings-ajax-settings" class="esg-settings-container">
			<div>
				<div>
					<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Shown Ajax Orders', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc" style="padding-top:15px">						
						<label class="eg-tooltip-wrap" title="<?php _e('Set the default order of Shown Content at ajax loading', EG_TEXTDOMAIN); ?>"><?php _e('Set Source Order', EG_TEXTDOMAIN); ?></label>												
						<div id="ajo-list" class="eg-media-source-order-wrap">
							<?php
							if(!empty($aj_source_order)){
								foreach($aj_source_order as $aj_handle){
									if(!isset($aj_source_list[$aj_handle])) continue;
									?>
									<div id="ajo-<?php echo $aj_handle; ?>" class="eg-media-source-order esg-blue esg-btn"><i class="eg-icon-<?php echo $aj_source_list[$aj_handle]['type']; ?>"></i><span><?php echo $aj_source_list[$aj_handle]['name']; ?></span><input class="eg-get-val" type="checkbox" name="aj-source-order[]" checked="checked" value="<?php echo $aj_handle; ?>" /></div>
									<?php
									unset($aj_source_list[$aj_handle]);
								}
							}

							if(!empty($aj_source_list)){
								foreach($aj_source_list as $aj_handle => $aj_set){
									?>
									<div id="ajo-<?php echo $aj_handle; ?>" class="eg-media-source-order esg-purple esg-btn"><i class="eg-icon-<?php echo $aj_set['type']; ?>"></i><span><?php echo $aj_set['name']; ?></span><input class="eg-get-val" type="checkbox" name="aj-source-order[]" value="<?php echo $aj_handle; ?>" /></div>
									<?php
								}
							}
							?>
						</div>
						<div><?php _e('First Ordered Source will be loaded as default. If source not exist, next available source in order will be taken', EG_TEXTDOMAIN); ?></div>												
					</div>
				</div>
				<div>
					<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Ajax Container', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc">						
						<label class="eg-tooltip-wrap" title="<?php _e('Define ID of the container (without #)', EG_TEXTDOMAIN); ?>, <?php _e('Insert a valid CSS ID here', EG_TEXTDOMAIN); ?>"><?php _e('Container ID', EG_TEXTDOMAIN); ?></label><!--
						--><input type="text" name="ajax-container-id" style="width:305px" value="<?php echo $base->getVar($grid, array('params', 'ajax-container-id'), 'ess-grid-ajax-container-'); ?>" >
						<div class="div13"></div>
							<label class="eg-tooltip-wrap" title="<?php _e('Define the position of the ajax content container', EG_TEXTDOMAIN); ?>"><?php _e('Container Position', EG_TEXTDOMAIN); ?></label><!--
							--><input type="radio" name="ajax-container-position" value="top" <?php checked($base->getVar($grid, array('params', 'ajax-container-position'), 'top'), 'top'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Visible above the Grid', EG_TEXTDOMAIN); ?>"><?php _e('Top', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input type="radio" name="ajax-container-position" value="bottom" <?php checked($base->getVar($grid, array('params', 'ajax-container-position'), 'top'), 'bottom'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Visible under the Grid', EG_TEXTDOMAIN); ?>"><?php _e('Bottom', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
							--><input type="radio" name="ajax-container-position" value="shortcode" <?php checked($base->getVar($grid, array('params', 'ajax-container-position'), 'top'), 'shortcode'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Insert somewhere as ShortCode', EG_TEXTDOMAIN); ?>"><?php _e('As ShortCode', EG_TEXTDOMAIN); ?></span>						
						<div id="eg-ajax-shortcode-wrapper">
							<div class="div13"></div>
							<label class="eg-tooltip-wrap" title="<?php _e('Use this ShortCode somewhere on the page to insert the ajax content container', EG_TEXTDOMAIN); ?>"><?php _e('Container ShortCode', EG_TEXTDOMAIN); ?></label><!--
							--><input type="text" readonly="readonly" value="" name="ajax-container-shortcode" style="width: 305px;">
						</div>
						<div class="div13"></div>
						<label class="eg-tooltip-wrap" title="<?php _e('Define if browser should scroll to content after it is loaded via ajax', EG_TEXTDOMAIN); ?>"><?php _e('Scroll on load', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="ajax-scroll-onload" value="on" <?php checked($base->getVar($grid, array('params', 'ajax-scroll-onload'), 'on'), 'on'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Scroll to content.', EG_TEXTDOMAIN); ?>"><?php _e('On', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio" name="ajax-scroll-onload" value="off" <?php checked($base->getVar($grid, array('params', 'ajax-scroll-onload'), 'on'), 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Do not scroll to content.', EG_TEXTDOMAIN); ?>"><?php _e('Off', EG_TEXTDOMAIN); ?></span>
						<div class="div13"></div>
						<label class="eg-tooltip-wrap" title="<?php _e('Define offset of scrolling in px (-500 - 500)', EG_TEXTDOMAIN); ?>"><?php _e('Scroll Offset', EG_TEXTDOMAIN); ?></label><!--
						--><input type="text" name="ajax-scrollto-offset" value="<?php echo $base->getVar($grid, array('params', 'ajax-scrollto-offset'), '0'); ?>" >						
					</div>
				</div>

				

				<div>
					<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Ajax Navigation', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc">
						<label class="eg-tooltip-wrap" title="<?php _e('Define the content container should have a close button', EG_TEXTDOMAIN); ?>"><?php _e('Show Close Button', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="ajax-close-button" value="on" class=" eg-tooltip-wrap" <?php checked($base->getVar($grid, array('params', 'ajax-close-button'), 'off'), 'on'); ?>><?php _e('On', EG_TEXTDOMAIN); ?><div class="space18"></div><!--
						--><input type="radio" name="ajax-close-button" value="off" class="eg-tooltip-wrap" <?php checked($base->getVar($grid, array('params', 'ajax-close-button'), 'off'), 'off'); ?>><?php _e('Off', EG_TEXTDOMAIN); ?>
						
						<div class="eg-close-button-settings-wrap">							
							<div class="eg-button-text-wrap">
								<div class="div13"></div>
								<label class="eg-tooltip-wrap" title="<?php _e('Define the button text here', EG_TEXTDOMAIN); ?>"><?php _e('Close Button Text', EG_TEXTDOMAIN); ?></label><!--
								--><input type="text" name="ajax-button-text" value="<?php echo $base->getVar($grid, array('params', 'ajax-button-text'), __('Close', EG_TEXTDOMAIN)); ?>">
							</div>
						</div>

						<div class="div13"></div>
						<label class="eg-tooltip-wrap" title="<?php _e('Define the content container should have navigation buttons', EG_TEXTDOMAIN); ?>"><?php _e('Show Navigation Button', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="ajax-nav-button" value="on" class=" eg-tooltip-wrap" <?php checked($base->getVar($grid, array('params', 'ajax-nav-button'), 'off'), 'on'); ?>><?php _e('On', EG_TEXTDOMAIN); ?><div class="space18"></div><!--
						--><input type="radio" name="ajax-nav-button" value="off" <?php checked($base->getVar($grid, array('params', 'ajax-nav-button'), 'off'), 'off'); ?>><?php _e('Off', EG_TEXTDOMAIN); ?>
						
						<div class="eg-close-nav-button-settings-wrap">
							<div class="div13"></div>
							<label class="eg-tooltip-wrap" title="<?php _e('Define the Skin of the buttons', EG_TEXTDOMAIN); ?>"><?php _e('Button Skin', EG_TEXTDOMAIN); ?></label><!--
							--><select name="ajax-button-skin" class="eg-tooltip-wrap" title="<?php _e('Define the Skin of the buttons', EG_TEXTDOMAIN); ?>">
								<option value="light"<?php selected($base->getVar($grid, array('params', 'ajax-button-skin'), 'light'), 'light'); ?>><?php _e('Light', EG_TEXTDOMAIN); ?></option>
								<option value="dark"<?php selected($base->getVar($grid, array('params', 'ajax-button-skin'), 'light'), 'dark'); ?>><?php _e('Dark', EG_TEXTDOMAIN); ?></option>
							</select>
							<div class="div13"></div>
							<label class="eg-tooltip-wrap" title="<?php _e('Switch between button or text', EG_TEXTDOMAIN); ?>"><?php _e('Button Type', EG_TEXTDOMAIN); ?></label><!--
							--><input type="radio" name="ajax-button-type" value="type1" class=" eg-tooltip-wrap" <?php checked($base->getVar($grid, array('params', 'ajax-button-type'), 'type1'), 'type1'); ?>><?php _e('Type 1', EG_TEXTDOMAIN); ?><div class="space18"></div><!--
							--><input type="radio" name="ajax-button-type" value="type2" <?php checked($base->getVar($grid, array('params', 'ajax-button-type'), 'type1'), 'type2'); ?>><?php _e('Type 2', EG_TEXTDOMAIN); ?>
							<div class="div13"></div>
							<label class="eg-tooltip-wrap" title="<?php _e('Define if the button should be visible inside of the ajax container or outside of it', EG_TEXTDOMAIN); ?>"><?php _e('Button Container Pos.', EG_TEXTDOMAIN); ?></label><!--
							--><input type="radio" name="ajax-button-inner" value="true" class=" eg-tooltip-wrap" <?php checked($base->getVar($grid, array('params', 'ajax-button-inner'), 'false'), 'true'); ?>> <?php _e('Inner', EG_TEXTDOMAIN); ?><div class="space18"></div><!--
							--><input type="radio" name="ajax-button-inner" value="false" <?php checked($base->getVar($grid, array('params', 'ajax-button-inner'), 'false'), 'false'); ?>><?php _e('Outer', EG_TEXTDOMAIN); ?>
							<div class="div13"></div>
							<label class="eg-tooltip-wrap" title="<?php _e('Define the horizontal positioning of the buttons', EG_TEXTDOMAIN); ?>"><?php _e('Horizontal Pos.', EG_TEXTDOMAIN); ?></label><!--
							--><input type="radio" name="ajax-button-h-pos" value="l" <?php checked($base->getVar($grid, array('params', 'ajax-button-h-pos'), 'r'), 'l'); ?>><?php _e('Left', EG_TEXTDOMAIN); ?><div class="space18"></div><!--
							--><input type="radio" name="ajax-button-h-pos" value="c" <?php checked($base->getVar($grid, array('params', 'ajax-button-h-pos'), 'r'), 'c'); ?>><?php _e('Center', EG_TEXTDOMAIN); ?><div class="space18"></div><!--
							--><input type="radio" name="ajax-button-h-pos" value="r" <?php checked($base->getVar($grid, array('params', 'ajax-button-h-pos'), 'r'), 'r'); ?>><?php _e('Right', EG_TEXTDOMAIN); ?>							
							<div class="div13"></div>
							<label class="eg-tooltip-wrap" title="<?php _e('Define the vertical positioning of the buttons', EG_TEXTDOMAIN); ?>"><?php _e('Vertical Pos.', EG_TEXTDOMAIN); ?></label><!--
							--><input type="radio" name="ajax-button-v-pos" value="t" <?php checked($base->getVar($grid, array('params', 'ajax-button-v-pos'), 't'), 't'); ?>><?php _e('Top', EG_TEXTDOMAIN); ?><div class="space18"></div><!--
							--><input type="radio" name="ajax-button-v-pos" value="b" <?php checked($base->getVar($grid, array('params', 'ajax-button-v-pos'), 't'), 'b'); ?>><?php _e('Bottom', EG_TEXTDOMAIN); ?>							
						</div>
					</div>
				</div>

				

				<div>
					<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Prepend Content', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc" style="padding-left:15px;border-bottom:none">						
						<?php
						$settings = array('textarea_name' => 'ajax-container-pre');
						wp_editor($base->getVar($grid, array('params', 'ajax-container-pre'), ''), 'ajax-container-pre', $settings);
						?>						
					</div>
				</div>

				

				<div>
					<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Append Content', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc" style="padding-left:15px;border-bottom:none">						
						<?php
						$settings = array('textarea_name' => 'ajax-container-post');
						wp_editor($base->getVar($grid, array('params', 'ajax-container-post'), ''), 'ajax-container-post', $settings);
						?>						
					</div>
				</div>

				

				<div>
					<div class="eg-cs-tbc-left">
						<esg-llabel class="box-closed"><span><?php _e('Ajax Container Custom CSS', EG_TEXTDOMAIN); ?></span></esg-llabel>
					</div>
					<div class="eg-cs-tbc" style="padding-left:15px">						
						<textarea name="ajax-container-css" id="eg-ajax-custom-css"><?php echo stripslashes($base->getVar($grid, array('params', 'ajax-container-css'), '')); ?></textarea>
						<div style="font-size: 12px; color: #999;"><?php _e('Please only add styles directly here without any class/id declaration.', EG_TEXTDOMAIN); ?></div>
					</div>
				</div>
				<div>
					<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Advanced', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc">						
						<label class="eg-tooltip-wrap" title="<?php _e('Define a JavaScript callback here. This will be called every time when Content is loaded ! You can also define arguments by using callbackname(arg1, arg2, ...., esg99)', EG_TEXTDOMAIN); ?>"><?php _e('JavaScript Callback', EG_TEXTDOMAIN); ?></label><!--
						--><input type="text" name="ajax-callback" value="<?php echo stripslashes($base->getVar($grid, array('params', 'ajax-callback'), '')); ?>">
						<div class="div13"></div>
						<label class="eg-tooltip-wrap" title="<?php _e('Append Essential Grid argument to the callback to the end', EG_TEXTDOMAIN); ?>, <?php _e('Append return argument from Essential Grid with object containing posttype, postsource and ajaxcontainterid', EG_TEXTDOMAIN); ?>"><?php _e('Append Argument', EG_TEXTDOMAIN); ?></label><!--
						--><input type="checkbox" name="ajax-callback-arg" value="on" <?php checked($base->getVar($grid, array('params', 'ajax-callback-arg'), 'on'), 'on'); ?>>
						<div class="div13"></div>
						<label class="eg-tooltip-wrap" title="<?php _e('Define a CSS URL to load when First time Ajax Container has beed created. ', EG_TEXTDOMAIN); ?>"><?php _e('Extend CSS URL', EG_TEXTDOMAIN); ?></label><!--
						--><input type="text" name="ajax-css-url" value="<?php echo $base->getVar($grid, array('params', 'ajax-css-url'), ''); ?>" >
						<div class="div13"></div>
						<label class="eg-tooltip-wrap" title="<?php _e('Define a JavaScript File URL to load which is run 1 time at first Ajax Content loading', EG_TEXTDOMAIN); ?>"><?php _e('Extend JavaScript URL', EG_TEXTDOMAIN); ?></label><!--
						--><input type="text" name="ajax-js-url" value="<?php echo $base->getVar($grid, array('params', 'ajax-js-url'), ''); ?>" >						
					</div>
				</div>
			</div>
		</div>


		<!--
		SPINNER SETTINGS
		-->
		<div id="esg-settings-spinner-settings" class="esg-settings-container">
			<div>
				<div>
					<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Spinner Settings', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc">						
						<div id="use_spinner_row">	
							<div class="div13"></div>					
							<label for="cart-arrows" class="eg-tooltip-wrap" title="<?php _e('Choose Loading Spinner', EG_TEXTDOMAIN); ?>"><?php _e('Choose Spinner', EG_TEXTDOMAIN); ?></label><!--
							--><?php
							$use_spinner = $base->getVar($grid, array('params', 'use-spinner'), '0');
							?><select id="use_spinner" name="use-spinner">
								<option value="-1"<?php selected($use_spinner, '-1'); ?>><?php _e('off', EG_TEXTDOMAIN); ?></option>
								<option value="0"<?php selected($use_spinner, '0'); ?>>0</option>
								<option value="1"<?php selected($use_spinner, '1'); ?>>1</option>
								<option value="2"<?php selected($use_spinner, '2'); ?>>2</option>
								<option value="3"<?php selected($use_spinner, '3'); ?>>3</option>
								<option value="4"<?php selected($use_spinner, '4'); ?>>4</option>
								<option value="5"<?php selected($use_spinner, '5'); ?>>5</option>
							</select>							
						</div>

						<div id="spinner_color_row">
							<div class="div13"></div>						
							<label for="cart-arrows" class="eg-tooltip-wrap" title="<?php _e('Sorting at Loading', EG_TEXTDOMAIN); ?>"><?php _e('Choose Spinner Color', EG_TEXTDOMAIN); ?></label><!--
							--><input type="text" class="inputColorPicker" id="spinner_color" name="spinner-color" value="<?php echo $base->getVar($grid, array('params', 'spinner-color'), '#FFFFFF'); ?>" />							
						</div>						
					</div>
				</div>
			</div>
		</div>

		<!--
		API / CUSTOM JAVASCRIPT SETTINGS
		-->
		<div id="esg-settings-api-settings" class="esg-settings-container">
			<div>
				<div>
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php _e('Custom Javascript', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc" style="padding-left: 15px">															
						<textarea name="custom-javascript" id="eg-api-custom-javascript"><?php echo stripslashes($base->getVar($grid, array('params', 'custom-javascript'), '')); ?></textarea>								
					</div>									
				</div>

				<div>
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php _e('API Methods', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc">						
						<?php
						if($grid !== false){
							?>
							<label><?php _e('Redraw Grid:', EG_TEXTDOMAIN); ?></label><input class="eg-api-inputs" type="text" name="do-not-save" value="essapi_<?php echo $grid['id']; ?>.esredraw();" readonly="true" />							
							<div class="div13"></div>
							<label><?php _e('Quick Redraw Grid:', EG_TEXTDOMAIN); ?></label><input class="eg-api-inputs" type="text" name="do-not-save" value="essapi_<?php echo $grid['id']; ?>.esquickdraw();" readonly="true" />
							<?php
						}else{
							?>
							<p>
							<?php _e('API Methods will be available after this Grid is saved for the first time.', EG_TEXTDOMAIN); ?>
							</p>
							<?php
						}
						?>						
					</div>
				</div>

				<div>
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php _e('Code Examples', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc">						
						<label><?php _e('Visual Composer Tab fix:', EG_TEXTDOMAIN); ?></label><!--
						--><div class="esg-prewrap">
<pre><code>jQuery('body').on('click', '.wpb_tabs_nav a', function() {
	setTimeout(function(){
		jQuery(window).trigger('resize');
	}, 500); //change 500 to your needs
});</code></pre>
							</div>
						
						<div class="div13"></div>
						<label><?php _e('Lightbox Custom Options:', EG_TEXTDOMAIN); ?></label><!--
						--><div class="esg-prewrap">
<pre><code>
// http://fancyapps.com/fancybox/3/docs/
lightboxOptions.hideScrollbar = true;
lightboxOptions.hash = false;
</code></pre>
							</div>						
					</div>
				</div>

			</div>
		</div>

		<!--
		COOKIE SETTINGS
		-->

		<div id="esg-settings-cookie-settings" class="esg-settings-container">
			<div>
				<div>
					<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Timing', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc">						
						<label for="filter-arrows" class="eg-tooltip-wrap" title="<?php _e('The amount of time before the cookies expire (in minutes).', EG_TEXTDOMAIN); ?>" ><?php _e('Save for', EG_TEXTDOMAIN); ?></label><!--
						--><input type="text" name="cookie-save-time" class="input-settings-small " value="<?php echo intval($base->getVar($grid, array('params', 'cookie-save-time'), '30')); ?>"><div class="space18"></div><?php _e('Minutes', EG_TEXTDOMAIN); ?>
					</div>
				</div>
				<div>					
					<div class="eg-cs-tbc-left"><esg-llabel class="box-closed"><span><?php _e('Settings', EG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc">
						<label for="filter-arrows" ><?php _e('Search', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="cookie-save-search" value="on" <?php checked($base->getVar($grid, array('params', 'cookie-save-search'), 'off'), 'on'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Remember user\'s last search.', EG_TEXTDOMAIN); ?>"><?php _e('On', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio" name="cookie-save-search" value="off" <?php checked($base->getVar($grid, array('params', 'cookie-save-search'), 'off'), 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Do not apply cookie for search.', EG_TEXTDOMAIN); ?>"><?php _e('Off', EG_TEXTDOMAIN); ?></span>
						<div class="div13"></div>
						<label for="filter-arrows" ><?php _e('Filter', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="cookie-save-filter" value="on" <?php checked($base->getVar($grid, array('params', 'cookie-save-filter'), 'off'), 'on'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Remember Grid\'s last filter state.', EG_TEXTDOMAIN); ?>"><?php _e('On', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio" name="cookie-save-filter" value="off" <?php checked($base->getVar($grid, array('params', 'cookie-save-filter'), 'off'), 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Do not apply cookie for filter.', EG_TEXTDOMAIN); ?>"><?php _e('Off', EG_TEXTDOMAIN); ?></span>
						<div class="div13"></div>
						<label for="filter-arrows" ><?php _e('Pagination', EG_TEXTDOMAIN); ?></label><!--
						--><input type="radio" name="cookie-save-pagination" value="on" <?php checked($base->getVar($grid, array('params', 'cookie-save-pagination'), 'off'), 'on'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Remember Grid\'s last pagination state.', EG_TEXTDOMAIN); ?>"><?php _e('On', EG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
						--><input type="radio" name="cookie-save-pagination" value="off" <?php checked($base->getVar($grid, array('params', 'cookie-save-pagination'), 'off'), 'off'); ?>><span class="eg-tooltip-wrap" title="<?php _e('Do not apply cookie for pagination.', EG_TEXTDOMAIN); ?>"><?php _e('Off', EG_TEXTDOMAIN); ?></span>
						<div class="div13"></div>						
						<div class="esg-note"><?php _e('<b>Special Note:</b> <a href="//www.cookielaw.org/the-cookie-law/" target="_blank">EU Law</a> requires that a notification be shown to the user when cookies are being used.', EG_TEXTDOMAIN); ?></div>						
					</div>
				</div>
			</div>
		</div>

	</form>
	<?php
	Essential_Grid_Dialogs::pages_select_dialog();
	Essential_Grid_Dialogs::navigation_skin_css_edit_dialog();
	Essential_Grid_Dialogs::navigation_skin_css_selector_dialog();
	Essential_Grid_Dialogs::filter_select_dialog();
	Essential_Grid_Dialogs::filter_custom_dialog();
	Essential_Grid_Dialogs::filter_delete_dialog();
	?>
