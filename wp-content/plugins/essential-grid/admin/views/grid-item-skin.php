<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2020 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

//force the js file to be included

if(file_exists(EG_PLUGIN_PATH . 'public/assets/js/dev/essential-grid.js')) {
	wp_enqueue_script('essential-grid-item-editor-script', EG_PLUGIN_URL.'admin/assets/js/modules/grid-editor.js', array('jquery'), Essential_Grid::VERSION );
} else {
	wp_enqueue_script('essential-grid-item-editor-script', EG_PLUGIN_URL.'admin/assets/js/modules/grid-editor.min.js', array('jquery'), Essential_Grid::VERSION );
}

?>
<h2 class="topheader"><?php _e('Skin Overview', EG_TEXTDOMAIN); ?></h2>

<div id="eg-grid-even-item-skin-wrapper">

	<?php
	$skins_c = new Essential_Grid_Item_Skin();
	$navigation_c = new Essential_Grid_Navigation();
	$grid_c = new Essential_Grid();

			Essential_Grid_Item_Skin::propagate_default_item_skins();


	$grid['id'] = '1';
	$grid['name'] = __('Overview', EG_TEXTDOMAIN);
	$grid['handle'] = 'overview';
	$grid['postparams'] = array();
	$grid['layers'] = array();
	$grid['params'] = array('layout' => 'masonry',
							'navigation-skin' => 'backend-flat',
							'filter-arrows' => 'single',
							'navigation-padding' => '0 0 0 0',
							'force_full_width' => 'off',
							'rows-unlimited' => 'off',
							'rows' => 3,
							'columns' => array(3,3,3,2,2,2,1),
							'columns-width' => array(1400,1170,1024,960,778,640,480),
							'spacings' => 15,
							'grid-animation' => 'fade',
							'grid-animation-speed' => 800,
							'grid-animation-delay' => 5,
							'grid-start-animation' => 'reveal',
							'grid-start-animation-speed' => '800',
							'grid-start-animation-delay' => 0,
							'grid-start-animation-type' => 'item',
							'grid-animation-type' => 'item',
							'x-ratio' => 4,
							'y-ratio' => 4,
						   );

	$skins_html = '';
	$skins_css = '';
	$filters = array();


	$skins = $skins_c->get_essential_item_skins();

	$demo_img = array();
	for($i=1; $i<=10; $i++){
		$demo_img[] = 'demoimage'.$i.'.jpg';
	}

	if(!empty($skins) && is_array($skins)){
		$src = array();

		foreach($skins as $skin){

			// 2.2.6
			if(is_array($skin) && array_key_exists('handle', $skin) && $skin['handle'] === 'esgblankskin') continue;

			if(empty($src)) $src = $demo_img;

			$item_skin = new Essential_Grid_Item_Skin();
			$item_skin->init_by_data($skin);

			//set filters
			$item_skin->set_demo_filter();

			//add skin specific css
			$item_skin->register_skin_css();

			//set demo image
			$img_key = array_rand($src);
			$item_skin->set_image($src[$img_key]);
			unset($src[$img_key]);

			$item_filter = $item_skin->get_filter_array();

			$filters = array_merge($item_filter, $filters);

			ob_start();
			$item_skin->output_item_skin('overview');
      $current_skin_html = ob_get_contents();
      ob_clean();
      ob_end_clean();

      //2.3.7 display html of item skin preview
      $skins_html .= htmlspecialchars_decode($current_skin_html);
      //2.3.7 replace placeholders with demo data
      $skins_html = str_replace(
        array( '%favorites%' , '%author_name%' , '%likes_short%' , '%date%' , '%retweets%' , '%likes%' , '%views_short%' , '%dislikes_short%' , '%duration%' , '%num_comments%','Likes (Facebook,Twitter,YouTube,Vimeo,Instagram)','Likes Short (Facebook,Twitter,YouTube,Vimeo,Instagram)' , 'Date Modified', 'Views (flickr,YouTube, Vimeo)' , 'Views Short (flickr,YouTube, Vimeo)', 'Cat. List' , 'Excerpt'),
        array( '314' , 'Author' , '1.2K' , '2020-06-28' , '35' , '123' , '54' , '13' , '9:32' , '12' , '231' , '1.2K' , '2020-06-28', '231' , '1.2K' , 'News, Journey, Company', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.'),
        $skins_html
      );

			ob_start();
			$item_skin->generate_element_css('overview');
			$skins_css.= ob_get_contents();
			ob_clean();
			ob_end_clean();
		}
	}

	$grid_c->init_by_data($grid);
	?>
	<div class="eg-pbox esg-box eg-transbackground" style="margin-bottom:0px">				
			<?php

			$grid_c->output_wrapper_pre();

			$filters = array_map("unserialize", array_unique(array_map("serialize", $filters))); //filter to unique elements

			$navigation_c->set_special_class('esg-fgc-'.$grid['id']);
			$navigation_c->set_filter($filters);
			$navigation_c->set_style('padding', $grid['params']['navigation-padding']);
			echo $navigation_c->output_filter(true);

			$grid_c->output_grid_pre();

			//output elements
			echo $skins_html;

			$grid_c->output_grid_post();
			echo '<div style="text-align: center;">';
			echo $navigation_c->output_pagination(true);
			echo '</div>';

			$grid_c->output_wrapper_post();

			?>		
	</div>

	<?php
	$grid_c->output_grid_javascript(false, true);

	echo $skins_css;

	Essential_Grid_Global_Css::output_global_css_styles_wrapped();

	if(empty($skins)){
		_e('No Item Skins found!', EG_TEXTDOMAIN);
	}
	?>
</div><!--
--><div id="create_import_grid_wrap">
	<a class="esg-btn-big esg-purple" href="<?php echo $this->getViewUrl(Essential_Grid_Admin::VIEW_ITEM_SKIN_EDITOR, 'create=true'); ?>"><i class="material-icons">style</i><?php _e('Create New Item Skin', EG_TEXTDOMAIN); ?></a>
	<a class="esg-btn-big esg-red"  href="<?php echo $this->getViewUrl(Essential_Grid_Admin::VIEW_OVERVIEW, 'update_shop'); ?>"><i class="material-icons">get_app</i><?php _e('Import from Grid Templates', EG_TEXTDOMAIN); ?></a>
</div>

<script type="text/javascript">
	try{
		jQuery('.mce-notification-error').remove();
		jQuery('#wpbody-content >.notice').remove();
	} catch(e) {

	}
	jQuery(function(){
		GridEditorEssentials.initOverviewItemSkin();
	});
</script>
