<?php
/**
 * Represents the view for the metabox in post / pages
 *
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2020 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

if(!isset($post)) return false; //not called as it should be

$base = new Essential_Grid_Base();
$item_skin = new Essential_Grid_Item_Skin();
$item_elements = new Essential_Grid_Item_Element();
$meta = new Essential_Grid_Meta();

$values = get_post_custom($post->ID);

$eg_sources_html5_mp4 = isset($values['eg_sources_html5_mp4']) ? esc_attr($values['eg_sources_html5_mp4'][0]) : "";
$eg_sources_html5_ogv = isset($values['eg_sources_html5_ogv']) ? esc_attr($values['eg_sources_html5_ogv'][0]) : "";
$eg_sources_html5_webm = isset($values['eg_sources_html5_webm']) ? esc_attr($values['eg_sources_html5_webm'][0]) : "";
$eg_vimeo_ratio = isset($values['eg_vimeo_ratio']) ? esc_attr($values['eg_vimeo_ratio'][0]) : "1";
$eg_youtube_ratio = isset($values['eg_youtube_ratio']) ? esc_attr($values['eg_youtube_ratio'][0]) : "1";
$eg_wistia_ratio = isset($values['eg_wistia_ratio']) ? esc_attr($values['eg_wistia_ratio'][0]) : "1";
$eg_html5_ratio = isset($values['eg_html5_ratio']) ? esc_attr($values['eg_html5_ratio'][0]) : "1";
$eg_soundcloud_ratio = isset($values['eg_soundcloud_ratio']) ? esc_attr($values['eg_soundcloud_ratio'][0]) : "1";
$eg_sources_youtube = isset($values['eg_sources_youtube']) ? esc_attr($values['eg_sources_youtube'][0]) : "";
$eg_sources_wistia = isset($values['eg_sources_wistia']) ? esc_attr($values['eg_sources_wistia'][0]) : "";
$eg_sources_vimeo = isset($values['eg_sources_vimeo']) ? esc_attr($values['eg_sources_vimeo'][0]) : "";
$eg_sources_image = isset($values['eg_sources_image']) ? esc_attr($values['eg_sources_image'][0]) : "";
$eg_sources_iframe = isset($values['eg_sources_iframe']) ? esc_attr($values['eg_sources_iframe'][0]) : "";
$eg_sources_soundcloud = isset($values['eg_sources_soundcloud']) ? esc_attr($values['eg_sources_soundcloud'][0]) : "";
$eg_sources_essgrid = isset($values['eg_sources_essgrid']) ? esc_attr($values['eg_sources_essgrid'][0]) : "";

$eg_featured_grid = isset($values['eg_featured_grid']) ? esc_attr($values['eg_featured_grid'][0]) : "";

$eg_image_fit = isset($values['eg_image_fit']) ? esc_attr($values['eg_image_fit'][0]) : "";
$eg_image_align_h = isset($values['eg_image_align_h']) ? esc_attr($values['eg_image_align_h'][0]) : "";
$eg_image_align_v = isset($values['eg_image_align_v']) ? esc_attr($values['eg_image_align_v'][0]) : "";
$eg_image_repeat = isset($values['eg_image_repeat']) ? esc_attr($values['eg_image_repeat'][0]) : "";

$eg_sources_image_url = '';
if(intval($eg_sources_image) > 0){
	//get URL to Image
	$img = wp_get_attachment_image_src($eg_sources_image, 'full');
	if($img !== false){
		$eg_sources_image_url = $img[0];
	}else{
		$eg_sources_image = '';
	}
}

$eg_settings_custom_meta_skin = isset($values['eg_settings_custom_meta_skin']) ? unserialize($values['eg_settings_custom_meta_skin'][0]) : "";
$eg_settings_custom_meta_element = isset($values['eg_settings_custom_meta_element']) ? unserialize($values['eg_settings_custom_meta_element'][0]) : "";
$eg_settings_custom_meta_setting = isset($values['eg_settings_custom_meta_setting']) ? unserialize($values['eg_settings_custom_meta_setting'][0]) : "";
$eg_settings_custom_meta_style = isset($values['eg_settings_custom_meta_style']) ? unserialize($values['eg_settings_custom_meta_style'][0]) : "";

//if(!isset($disable_advanced) || $disable_advanced == false){
	$eg_meta = array();
	
	if(!empty($eg_settings_custom_meta_skin)){
		foreach($eg_settings_custom_meta_skin as $key => $val){
			$eg_meta[$key]['skin'] = @$val;
			$eg_meta[$key]['element'] = @$eg_settings_custom_meta_element[$key];
			$eg_meta[$key]['setting'] = @$eg_settings_custom_meta_setting[$key];
			$eg_meta[$key]['style'] = @$eg_settings_custom_meta_style[$key];
		}
	}
	
	$advanced = array();
	
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
	
//}

$custom_meta = $meta->get_all_meta(false);

if(isset($disable_advanced) && $disable_advanced == true){ //only show if we are in preview mode
	?>
	<form id="eg-form-post-meta-settings">
		<input type="hidden" name="post_id" value="<?php echo $post->ID; ?>" />
	<?php
}

wp_nonce_field('eg_meta_box_nonce', 'essential_grid_meta_box_nonce');

?>



<ul id="eg-option-tabber-post-meta" class="eg-option-tabber-wrapper"><!--
	--><?php 
	$selectedtab = "selected";
	if(isset($disable_advanced) && $disable_advanced == true){ //only show if we are in preview mode
		?><li class="eg-option-tabber selected" data-target="#eg-my-cobbles-options"><span class="dashicons dashicons-align-center"></span><?php _e('Item Settings', EG_TEXTDOMAIN); ?></li><!--
		--><?php
		$selectedtab = "";
	} 
	?><li class="eg-option-tabber <?php echo $selectedtab; ?>" data-target="#eg-custommeta-options"><span class="dashicons dashicons-list-view"></span><?php _e('Custom Meta', EG_TEXTDOMAIN); ?></li><!--
	--><li class="eg-option-tabber" data-target="#eg-source-options"><span class="dashicons dashicons-admin-media"></span><?php _e('Alternative Sources', EG_TEXTDOMAIN); ?></li><!--
	--><?php
	//if(!isset($disable_advanced) || $disable_advanced == false){
	?><li class="eg-option-tabber" data-target="#eg-skin-options"><span class="dashicons dashicons-admin-appearance"></span><?php _e('Skin Modifications', EG_TEXTDOMAIN); ?></li><!--
	--><?php
	//}
	?><li class="eg-option-tabber" data-target="#eg-featured-grid-options" style="margin-right: 0"><span class="dashicons dashicons-screenoptions"></span><?php _e('Featured Grid', EG_TEXTDOMAIN); ?></li>
</ul>
<?php
$selectedtab = "selected";
$displaytab = "display:block";
if(isset($disable_advanced) && $disable_advanced == true){ //only show if we are in preview mode
	$cobbles = '1:1';
	$raw_cobbles = isset($values['eg_cobbles']) ? json_decode($values['eg_cobbles'][0], true) : '';
	if(isset($grid_id) && isset($raw_cobbles[$grid_id]) && isset($raw_cobbles[$grid_id]['cobbles']))
		$cobbles = $raw_cobbles[$grid_id]['cobbles'];
		
	?>
	<div id="eg-my-cobbles-options" class="eg-options-tab <?php echo $selectedtab; ?>" style="<?php echo $displaytab; ?>">
		<div>
			<label><?php _e('Cobbles Element Size', EG_TEXTDOMAIN); ?></label><!--
			--><select name="eg_cobbles_size" id="eg_cobbles_size">
				<option value="1:1"<?php selected($cobbles, '1:1'); ?>><?php _e('width 1, height 1', EG_TEXTDOMAIN); ?></option>
				<option value="1:2"<?php selected($cobbles, '1:2'); ?>><?php _e('width 1, height 2', EG_TEXTDOMAIN); ?></option>
				<option value="1:3"<?php selected($cobbles, '1:3'); ?>><?php _e('width 1, height 3', EG_TEXTDOMAIN); ?></option>
				<option value="1:4"<?php selected($cobbles, '1:4'); ?>><?php _e('width 1, height 4', EG_TEXTDOMAIN); ?></option>
				<option value="2:1"<?php selected($cobbles, '2:1'); ?>><?php _e('width 2, height 1', EG_TEXTDOMAIN); ?></option>
				<option value="2:2"<?php selected($cobbles, '2:2'); ?>><?php _e('width 2, height 2', EG_TEXTDOMAIN); ?></option>
				<option value="2:3"<?php selected($cobbles, '2:3'); ?>><?php _e('width 2, height 3', EG_TEXTDOMAIN); ?></option>
				<option value="2:4"<?php selected($cobbles, '2:4'); ?>><?php _e('width 2, height 4', EG_TEXTDOMAIN); ?></option>
				<option value="3:1"<?php selected($cobbles, '3:1'); ?>><?php _e('width 3, height 1', EG_TEXTDOMAIN); ?></option>
				<option value="3:2"<?php selected($cobbles, '3:2'); ?>><?php _e('width 3, height 2', EG_TEXTDOMAIN); ?></option>
				<option value="3:3"<?php selected($cobbles, '3:3'); ?>><?php _e('width 3, height 3', EG_TEXTDOMAIN); ?></option>
				<option value="3:4"<?php selected($cobbles, '3:4'); ?>><?php _e('width 3, height 4', EG_TEXTDOMAIN); ?></option>
				<option value="4:1"<?php selected($cobbles, '4:1'); ?>><?php _e('width 4, height 1', EG_TEXTDOMAIN); ?></option>
				<option value="4:2"<?php selected($cobbles, '4:2'); ?>><?php _e('width 4, height 2', EG_TEXTDOMAIN); ?></option>
				<option value="4:3"<?php selected($cobbles, '4:3'); ?>><?php _e('width 4, height 3', EG_TEXTDOMAIN); ?></option>
				<option value="4:4"<?php selected($cobbles, '4:4'); ?>><?php _e('width 4, height 4', EG_TEXTDOMAIN); ?></option>
			</select>			
			<div class="div13"></div>
			<?php
			$skins = Essential_Grid_Item_Skin::get_essential_item_skins('all', false);
			$use_skin = -1;
			$raw_skin = isset($values['eg_use_skin']) ? json_decode($values['eg_use_skin'][0], true) : '';
			if(isset($grid_id) && isset($raw_skin[$grid_id]) && isset($raw_skin[$grid_id]['use-skin']))
				$use_skin = $raw_skin[$grid_id]['use-skin'];
			?>			
			<label><?php _e('Choose Specific Skin', EG_TEXTDOMAIN); ?></label><!--			
			--><select name="eg_use_skin">
				<option value="-1"><?php _e('-- Default Skin --', EG_TEXTDOMAIN); ?></option>
				<?php
				if(!empty($skins)){
					foreach($skins as $skin){
						echo '<option value="'.$skin['id'].'"'.selected($use_skin, $skin['id']).'>'.$skin['name'].'</option>'."\n";
					}
				}
				?>
			</select>
			<div class="div13"></div>
			<label><?php _e('Media Fit', EG_TEXTDOMAIN); ?></label><!--			
			--><select name="eg_image_fit">
				<option value="-1"><?php _e('-- Default Fit --', EG_TEXTDOMAIN); ?></option>
				<option value="contain" <?php selected($eg_image_fit, 'contain'); ?>><?php _e('Contain', EG_TEXTDOMAIN); ?></option>
				<option value="cover" <?php selected($eg_image_fit, 'cover'); ?>><?php _e('Cover', EG_TEXTDOMAIN); ?></option>
			</select>			
			<div class="div13"></div>						
			<label><?php _e('Media Repeat', EG_TEXTDOMAIN); ?></label><!--			
			--><select name="eg_image_repeat">
				<option value="-1"><?php _e('-- Default Repeat --', EG_TEXTDOMAIN); ?></option>
				<option value="no-repeat" <?php selected($eg_image_repeat, 'no-repeat'); ?>><?php _e('no-repeat', EG_TEXTDOMAIN); ?></option>
				<option value="repeat" <?php selected($eg_image_repeat, 'repeat'); ?>><?php _e('repeat', EG_TEXTDOMAIN); ?></option>
				<option value="repeat-x" <?php selected($eg_image_repeat, 'repeat-x'); ?>><?php _e('repeat-x', EG_TEXTDOMAIN); ?></option>
				<option value="repeat-y" <?php selected($eg_image_repeat, 'repeat-y'); ?>><?php _e('repeat-y', EG_TEXTDOMAIN); ?></option>
			</select>			
			<div class="div13"></div>			
			<label><?php _e('Media Align', EG_TEXTDOMAIN); ?></label><!--			
			--><select name="eg_image_align_h">
				<option value="-1"><?php _e('-- Horizontal Align --', EG_TEXTDOMAIN); ?></option>
				<option value="left" <?php selected($eg_image_align_h, 'left'); ?>><?php _e('Left', EG_TEXTDOMAIN); ?></option>
				<option value="center" <?php selected($eg_image_align_h, 'center'); ?>><?php _e('Center', EG_TEXTDOMAIN); ?></option>
				<option value="right" <?php selected($eg_image_align_h, 'right'); ?>><?php _e('Right', EG_TEXTDOMAIN); ?></option>
			</select><div class="space18"></div><!--
			--><select name="eg_image_align_v">
				<option value="-1"><?php _e('-- Vertical Align --', EG_TEXTDOMAIN); ?></option>
				<option value="top" <?php selected($eg_image_align_v, 'top'); ?>><?php _e('Top', EG_TEXTDOMAIN); ?></option>
				<option value="center" <?php selected($eg_image_align_v, 'center'); ?>><?php _e('Center', EG_TEXTDOMAIN); ?></option>
				<option value="bottom" <?php selected($eg_image_align_v, 'bottom'); ?>><?php _e('Bottom', EG_TEXTDOMAIN); ?></option>
			</select>			
		</div>
	</div>
	<?php
	$selectedtab ="";
	$displaytab = "";
}
?>

<div id="eg-custommeta-options" class="eg-options-tab <?php echo $selectedtab; ?>" style="<?php echo $displaytab; ?>">
	<div>
		<?php
		if(!empty($custom_meta)){
			foreach($custom_meta as $cmeta){
				//check if post already has a value set
				$val = isset($values['eg-'.$cmeta['handle']]) ? esc_attr($values['eg-'.$cmeta['handle']][0]) : @$cmeta['default'];
				?>
					<label><?php echo $cmeta['name']; ?></label><!--
					--><?php
					switch($cmeta['type']){
						case 'text':
							echo '<input type="text" name="eg-'.$cmeta['handle'].'" value="'.$val.'" /><div class="div13"></div>';
							break;
						case 'select':
						case 'multi-select':
							$do_array = ($cmeta['type'] == 'multi-select') ? '[]' : '';
							$el = $meta->prepare_select_by_string($cmeta['select']);
							echo '<select name="eg-'.$cmeta['handle'].$do_array.'"';
							if($cmeta['type'] == 'multi-select') echo ' multiple="multiple" size="5"';
							echo '>';
							if(!empty($el) && is_array($el)){
								if($cmeta['type'] != 'multi-select'){
									echo '<option value="">'.__('---', EG_TEXTDOMAIN).'</option>';
								}else{
									$val = json_decode(str_replace('&quot;', '"', $val), true);
								}
								foreach($el as $ele){
									if(is_array($val)){
										$sel = (in_array($ele, $val)) ? ' selected="selected"' : '';
									}else{
										$sel = ($ele == $val) ? ' selected="selected"' : '';
									}
									echo '<option value="'.$ele.'"'.$sel.'>'.$ele.'</option>';
								}
							}
							echo '</select><div class="div13"></div>';
							break;
						case 'image':
							$var_src = '';
							if(intval($val) > 0){
								//get URL to Image
								$img = wp_get_attachment_image_src($val, 'full');
								if($img !== false){
									$var_src = $img[0];
								}else{
									$val = '';
								}
							}else{
								$val = '';
							}
						?><input type="hidden" value="<?php echo $val; ?>" name="eg-<?php echo $cmeta['handle']; ?>" id="eg-<?php echo $cmeta['handle']; ?>" />							
							<div class="esg-btn esg-purple eg-cm-image-add" style="margin-bottom:0px" data-setto="eg-<?php echo $cmeta['handle']; ?>"><?php _e('Choose Image', EG_TEXTDOMAIN); ?></div><div class="space18"></div><!--
							--><div class="esg-btn  esg-red eg-cm-image-clear" style="margin-bottom:0px" data-setto="eg-<?php echo $cmeta['handle']; ?>"><?php _e('Remove Image', EG_TEXTDOMAIN); ?></div>
							<div style="line-height: 0px">							
								<img style="width: 50%;padding-left: 170px;" id="eg-<?php echo $cmeta['handle']; ?>-img" class="image-holder-wrap-div" src="<?php echo $var_src; ?>" <?php echo ($var_src == '') ? 'style="display: none;"' : ''; ?>>
							</div>
							<div class="div13"></div>
							<?php
							break;
					}
					?>					
				<?php
			}
		}else{
			_e('No metas available yet. Add some through the Custom Meta menu of Essential Grid.', EG_TEXTDOMAIN);
			?><div class="div13"></div><?php 			
		}
		?>

		<a href="<?php echo Essential_Grid_Admin::getSubViewUrl(Essential_Grid_Admin::VIEW_SUB_CUSTOM_META_AJAX); ?>" class="esg-btn esg-purple" style="margin-top:20px !important; margin-bottom:20px !important;" target="_blank"><?php _e('Create New Meta Keys', EG_TEXTDOMAIN); ?></a>
	</div>
</div> <!-- END OF EG OPTION TAB -->

<div id="eg-featured-grid-options" class="eg-options-tab">			
	<label class="eg-mb-label eg-tooltip-wrap" title="<?php _e('Choose the grid to display', EG_TEXTDOMAIN); ?>"><?php _e('Essential Grid to Feature', EG_TEXTDOMAIN); ?></label><!--
	--><select id="eg-featured-grid" name="eg_featured_grid">
		<option value=""><?php _e("No Featured Essential Grid",EG_TEXTDOMAIN); ?></option>
		<?php 

				$grids = new Essential_Grid(); 
				$arrGrids = $grids->get_essential_grids(); 
				foreach($arrGrids as $grid){
					echo '<option value="'.$grid->handle.'" '. selected( $eg_featured_grid, $grid->handle, false ) .'>'. $grid->name . '</option>';
				}
			?>
	</select>
	<div class="div13"></div>
	<div class="esg-note-b">
		<div class="dashicons dashicons-lightbulb"></div>
		<?php _e('The selected grid will be displayed instead of the featured image on the single post and in the blog overviews.<br>If this feature does not work in your theme please check out this <a href="https://www.themepunch.com/revslider-doc/add-on-featured-slider/#theme_not_support">short tutorial</a> to code in manually.', EG_TEXTDOMAIN); ?>		
	</div>
</div> <!-- END OF EG FEATURED TAB -->


<div id="eg-source-options" class="eg-options-tab">	
	<strong style="font-size:14px"><?php _e('HTML5 Video & Audio Source`s', EG_TEXTDOMAIN); ?></strong>
	<div class="div13"></div>
	<label><?php _e('MP4 / Audio', EG_TEXTDOMAIN); ?></label><input type="text" name="eg_sources_html5_mp4" id="eg_sources_html5_mp4"  value="<?php echo $eg_sources_html5_mp4; ?>" />
	<div class="div13"></div>
	<label class="eg-mb-label eg-tooltip-wrap" title="<?php _e('Choose the Video Ratio', EG_TEXTDOMAIN); ?>"><?php _e('Video Ratio', EG_TEXTDOMAIN); ?></label><!--
	--><select id="eg-html5-ratio" name="eg_html5_ratio">
		<option value="1"<?php selected($eg_html5_ratio, '1'); ?>>16:9</option>	
		<option value="0"<?php selected($eg_html5_ratio, '0'); ?>>4:3</option>
	</select>
	<!--<div class="div13"></div>
	<label><?php _e('OGV', EG_TEXTDOMAIN); ?></label><input type="text" name="eg_sources_html5_ogv" id="eg_sources_html5_ogv"  value="<?php echo $eg_sources_html5_ogv; ?>" />
	<div class="div13"></div>
	<label><?php _e('WEBM', EG_TEXTDOMAIN); ?></label><input type="text" name="eg_sources_html5_webm" id="eg_sources_html5_webm"  value="<?php echo $eg_sources_html5_webm; ?>" />
	-->
		
	<div class="div30"></div>	
	<div class="esg-custom-iblock-src-wrapper" >
		<strong style="font-size:14px"><?php _e('YouTube Video Source`s', EG_TEXTDOMAIN); ?></strong>
		<div class="div13"></div>
		<label for="eg_sources_youtube"><?php _e('YouTube ID', EG_TEXTDOMAIN); ?></label><input type="text" name="eg_sources_youtube" id="eg_sources_youtube"   value="<?php echo $eg_sources_youtube; ?>" />			
		<div class="div13"></div>
		<label  class="eg-tooltip-wrap" title="<?php _e('Choose the Video Ratio', EG_TEXTDOMAIN); ?>"><?php _e('Video Ratio', EG_TEXTDOMAIN); ?></label><!--
		--><select id="eg-youtube-ratio" name="eg_youtube_ratio">
			<option value="1"<?php selected($eg_youtube_ratio, '1'); ?>>16:9</option>
			<option value="0"<?php selected($eg_youtube_ratio, '0'); ?>>4:3</option>
								
		</select>
		<div class="div30"></div>	
	</div>
	<div class="esg-custom-iblock-src-wrapper">
		<strong style="font-size:14px"><?php _e('Vimeo Video Source`s', EG_TEXTDOMAIN); ?></strong>
		<div class="div13"></div>
		<label  for="eg_sources_vimeo"><?php _e('Vimeo ID', EG_TEXTDOMAIN); ?></label><input type="text" name="eg_sources_vimeo" id="eg_sources_vimeo"  value="<?php echo $eg_sources_vimeo; ?>" />
		<div class="div13"></div>
		<label class="eg-mb-label eg-tooltip-wrap" title="<?php _e('Choose the Video Ratio', EG_TEXTDOMAIN); ?>"><?php _e('Video Ratio', EG_TEXTDOMAIN); ?></label><!--
		--><select id="eg-vimeo-ratio" name="eg_vimeo_ratio">
			<option value="1"<?php selected($eg_vimeo_ratio, '1'); ?>>16:9</option>	
			<option value="0"<?php selected($eg_vimeo_ratio, '0'); ?>>4:3</option>
		</select>
		<div class="div30"></div>
	</div>
	<div class="esg-custom-iblock-src-wrapper">
		<strong style="font-size:14px"><?php _e('Wistia Video Source`s', EG_TEXTDOMAIN); ?></strong>
		<div class="div13"></div>
		<label  for="eg_sources_wistia"><?php _e('Wistia ID', EG_TEXTDOMAIN); ?></label><input type="text" name="eg_sources_wistia" id="eg_sources_wistia"  value="<?php echo $eg_sources_wistia; ?>" />
		<div class="div13"></div>
		<label class="eg-mb-label eg-tooltip-wrap" title="<?php _e('Choose the Video Ratio', EG_TEXTDOMAIN); ?>"><?php _e('Video Ratio', EG_TEXTDOMAIN); ?></label><!--
		--><select id="eg-wistia-ratio" name="eg_wistia_ratio" >
			
			<option value="1"<?php selected($eg_wistia_ratio, '1'); ?>>16:9</option>
			<option value="0"<?php selected($eg_wistia_ratio, '0'); ?>>4:3</option>
		</select>		
		<div class="div30"></div>
	</div>
	<div class="esg-custom-iblock-src-wrapper">
		<strong style="font-size:14px"><?php _e('Sound Cloud Source`s', EG_TEXTDOMAIN); ?></strong>	
		<div class="div13"></div>
		<label for="eg_sources_soundcloud"><?php _e('SoundCloud Track ID', EG_TEXTDOMAIN); ?></label><input type="text" name="eg_sources_soundcloud" id="eg_sources_soundcloud"   value="<?php echo $eg_sources_soundcloud; ?>" />
		<div class="div13"></div>
		<label class="eg-mb-label eg-tooltip-wrap" title="<?php _e('Choose the SoundCloud iFrame Ratio', EG_TEXTDOMAIN); ?>"><?php _e('Frame Ratio', EG_TEXTDOMAIN); ?></label><!--
		--><select id="eg-soundcloud-ratio" name="eg_soundcloud_ratio">
			<option value="1"<?php selected($eg_soundcloud_ratio, '1'); ?>>16:9</option>
			<option value="0"<?php selected($eg_soundcloud_ratio, '0'); ?>>4:3</option>							
		</select>
		
		<div class="div30"></div>
	</div>
	<div style="width:100%;height:1px;display:block"></div>	
	<strong style="font-size:14px"><?php _e('Image Source`s', EG_TEXTDOMAIN); ?></strong>
	<div class="div13"></div>
	<label  for="eg_sources_image"><?php _e('Alt. Image', EG_TEXTDOMAIN); ?></label><input type="text" name="eg_sources_image" id="eg_sources_image" style="display: none;" value="<?php echo $eg_sources_image; ?>" /><!--	
	--><div id="eg-choose-from-image-library" class="esg-btn esg-purple" data-setto="eg_sources_image"><?php _e('Choose Image', EG_TEXTDOMAIN); ?></div><div class="space18"></div><!--
	--><div id="eg-clear-from-image-library" class="esg-btn esg-red eg-remove-custom-meta-field"><?php _e('Remove Image', EG_TEXTDOMAIN); ?></div>			
	<div id="eg_sources_image-wrapper">
		<div class="div13"></div>
		<img id="eg_sources_image-img" src="<?php echo $eg_sources_image_url; ?>">
	</div>
	
	<div class="div30"></div>
	<strong style="font-size:14px"><?php _e('iFrame HTML Markup', EG_TEXTDOMAIN); ?></strong>
	<div class="div13"></div>
	<textarea type="text" style="width:100%;background:#E2E1E5;min-height:150px;" name="eg_sources_iframe" id="eg_sources_iframe"><?php echo $eg_sources_iframe; ?></textarea>
	<div class="div30"></div>
	<div class="esg-custom-iblock-src-wrapper">
		<strong style="font-size:14px"><?php _e('Choose Essential Grid', EG_TEXTDOMAIN); ?></strong>
		<div class="div13"></div>	
		<select id="eg_sources_essgrid" name="eg_sources_essgrid">		
			<option value="">--- Choose Grid ---</option>
			<?php 
							
				$_grids = Essential_Grid::get_essential_grids();
				foreach($_grids as $_grid) {
					
					$_alias = $_grid -> handle;
					$_shortcode = '[ess_grid alias="' . $_alias . '"]';
					$_shortcode = str_replace('"', '', $_shortcode)
					
					?><option <?php selected($eg_sources_essgrid, $_alias); ?> value="<?php echo $_alias; ?>"><?php echo $_shortcode; ?></option>
					
				<?php }
		
			?>			
		</select><div class="div13"></div>
	</div>
	<div class="esg-custom-iblock-src-wrapper">
		<?php
		do_action('essgrid_add_meta_options', $values);
		?>
	</div>
	<div class="div13"></div>
</div>
			
<div id="eg-skin-options" class="eg-options-tab">
	<!--<h2><span style="margin:5px 10px 0px 10px"class="dashicons dashicons-admin-generic"></span><?php _e('Custom Post Based Skin Modifications', EG_TEXTDOMAIN); ?></h2>-->
	<div id="eg-advanced-param-wrap">
		<div class="eg-advanced-param" id="eg-advanced-param-post"></div>
		<div class="esg-btn esg-purple eg-add-custom-meta-field" style="margin-bottom:0px" id="eg-add-custom-meta-field-post" style="margin-top:10px !important"><?php _e('Add New Custom Skin Rule', EG_TEXTDOMAIN); ?></div>
		<div class="div13"></div>
		<div class="esg-note-b">
			<div class="dashicons dashicons-lightbulb"></div>
			<?php _e("For default Skin Settings please use the Essential Grid Skin Editor.<br> Only add Rules here to change the Skin Element Styles only for this Post !<br>Every rule defined here will overwrite the Global Skin settings explicit for this Post in the Grid where the Skin is used. ", EG_TEXTDOMAIN); ?>
		</div>			
	</div>
</div>
		
<?php

if(isset($disable_advanced) && $disable_advanced == true){ //only show if we are in preview mode
?>
</form>
<?php
}
?>


<!-- ESG 2.1.6 -->
<?php
	$eg_custom_meta_216 = isset($values['eg_custom_meta_216']) ? esc_attr($values['eg_custom_meta_216'][0]) : 'false';
	if($eg_custom_meta_216 != 'true') { ?>
	<script type="text/javascript">
		var eg_skin_color_values = {
		<?php
			$skins = Essential_Grid_Item_Skin::get_essential_item_skins('all', false);
			foreach($skins as $skin) {
				if(isset($skin['params']) && !empty($skin['params']) && is_string($skin['params'])) {
					$params = json_decode($skin['params'], true);
					if(!empty($params) && isset($params['container-background-color']) && !empty($params['container-background-color'])) {
						echo '"' . $skin['id'] . '": "' . $params['container-background-color'] . '",';
					}
				}	
			}
		?>
};
	</script>
	<?php } ?>
<input type="hidden" name="eg_custom_meta_216" value="true" />

<script type="text/javascript">	
	jQuery(function(){		
		jQuery(document).on('click','#eg-option-tabber-post-meta .eg-option-tabber',function() {

			var t = jQuery(this),
				mbox =t.closest('#eg-meta-box'), 				
				s = mbox.find('.eg-option-tabber.selected');


			
			s.removeClass("selected");
			t.addClass("selected");			
			jQuery(s.data('target')).hide();
			jQuery(t.data('target')).show();
		});
		
		jQuery('#eg-choose-from-image-library').on('click',function(e) {
			e.preventDefault();
			AdminEssentials.upload_image_img(jQuery(this).data('setto'));
			
			return false; 
		});
		
		jQuery('#eg-clear-from-image-library').on('click',function(e) {
			e.preventDefault();
			jQuery('#eg_sources_image').val('');
			jQuery('#eg_sources_image-img').attr("src","");
			jQuery('#eg_sources_image-img').hide();
			return false; 
		});
		
		
		jQuery('.eg-cm-image-add').on('click',function(e) {
			e.preventDefault();
			AdminEssentials.upload_image_img(jQuery(this).data('setto'));
			
			return false; 
		});
		
		jQuery('.eg-cm-image-clear').on('click',function(e) {
			e.preventDefault();
			var setto = jQuery(this).data('setto');
			jQuery('#'+setto).val('');
			jQuery('#'+setto+'-img').attr("src","");
			jQuery('#'+setto+'-img').hide();
			return false; 
		});
		
		
		<?php
		//if(!isset($disable_advanced) || $disable_advanced == false){
		?>
		
		AdminEssentials.setInitSkinsJson(<?php echo $base->jsonEncodeForClientSide($advanced); ?>);
		AdminEssentials.setInitElementsJson(<?php echo $base->jsonEncodeForClientSide($eg_meta); ?>);
		AdminEssentials.setInitStylingJson(<?php echo $base->jsonEncodeForClientSide($eg_elements); ?>);
		AdminEssentials.initMetaBox('post');
		
		<?php
		//}
		?>
		if(jQuery('#eg_sources_image-img').attr('src') !== '')
			jQuery('#eg_sources_image-img').show();
		else
			jQuery('#eg_sources_image-img').hide();
			
	});
	
	
</script>