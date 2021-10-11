<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2020 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

global $EssentialAsTheme;

$dir = plugin_dir_path(__FILE__).'../../../';

$validated = get_option('tp_eg_valid', 'false');
$code = get_option('tp_eg_code', '');
$latest_version = get_option('tp_eg_latest-version', Essential_Grid::VERSION);
if(version_compare($latest_version, Essential_Grid::VERSION, '>')){
	//new version exists
}else{
	//up to date
}
?>

<div class="div20"></div>
<div class="view_title"><?php _e("How To Use Essential Grid", EG_TEXTDOMAIN); ?></div>
<div class="esg_info_box">
	<div class="esg-purple esg_info_box_decor"><i class="eg-icon-arrows-ccw"></i></div>
  <div><?php _e('From the <b>page and/or post editor</b> insert the Essential Grid block or insert the shortcode from the grid table above.', EG_TEXTDOMAIN); ?></div>
	<div><?php _e('From the <b>widgets panel</b> drag the "Essential Grid" widget to the desired sidebar or other widget area.', EG_TEXTDOMAIN); ?></div>
</div>


<div class="div50"></div>
<div class="view_title"><?php _e("Version Information", EG_TEXTDOMAIN); ?></div>
<div class="esg_info_box">
	<div class="esg-blue esg_info_box_decor"><i class="eg-icon-info-circled"></i></div>
	<div><?php _e("Installed Version", EG_TEXTDOMAIN); ?>: <span  class="slidercurrentversion"><?php echo Essential_Grid::VERSION; ?></span></div>
	<div><?php _e("Available Version", EG_TEXTDOMAIN); ?>: <span class="slideravailableversion"><?php echo $latest_version; ?></span> <a class="esg-btn esg-purple" style="margin-left:15px" href="?page=essential-grid&checkforupdates=true"><?php _e('Check Version', EG_TEXTDOMAIN); ?></a></div>
</div>


<!--
ACTIVATE THIS PRODUCT
-->
<div class="div50"></div>
<a name="activateplugin"></a>
<div class="view_title"><?php _e("Purchase Code Registration", EG_TEXTDOMAIN); ?></div>
<?php $displs = $validated !== 'true' ? 'block' : 'none'; ?>
<div id="benefitscontent" class="esg_info_box" style="display:<?php echo $displs; ?>">
	<div class="esg-blue esg_info_box_decor" ><i class="eg-icon-doc"></i></div>
	<div class="validation-label"><?php _e("Benefits", EG_TEXTDOMAIN); ?>:</div>
	<div><strong><?php _e("Get Premium Support", EG_TEXTDOMAIN); ?></strong><?php _e(" - We help you in case of Bugs, installation problems, and Conflicts with other plugins and Themes ", EG_TEXTDOMAIN); ?></div>
	<div><strong><?php _e("Auto Updates", EG_TEXTDOMAIN); ?></strong><?php _e(" - Get the latest version of our Plugin.  New Features and Bug Fixes are available regularly !", EG_TEXTDOMAIN); ?></div>
</div>

<div class="div50" style="display:<?php echo $displs; ?>"></div>


<div id="tp-validation-box" class="esg_info_box">
	<?php if($validated === 'true') { ?>
		<div class="esg-green esg_info_box_decor"><i class="eg-icon-check"></i></div>
	<?php
	} else {
	?>
		<div class="esg-red esg_info_box_decor"><i class="eg-icon-cancel"></i></div>
	<?php
	}
	?>

	<div id="rs-validation-wrapper">
		<div class="validation-label"><?php _e('Purchase code:', EG_TEXTDOMAIN); ?></div>
		<div class="validation-input"><!--
		--><input type="text" name="eg-validation-token" value="<?php echo $code; ?>" <?php echo ($validated === 'true') ? ' readonly="readonly"' : ''; ?> style="width: 350px; margin-right:10px;" /><!--
		--><a href="javascript:void(0);" <?php echo ($validated !== 'true') ? '' : 'style="display: none;"'; ?> id="eg-validation-activate" class="esg-btn esg-green" style="margin-right:10px"><?php _e('Activate', EG_TEXTDOMAIN); ?></a><a href="javascript:void(0);" <?php echo ($validated === 'true') ? '' : 'style="display: none;"'; ?> id="eg-validation-deactivate" class="esg-btn esg-red"><?php _e('Deactivate', EG_TEXTDOMAIN); ?></a>
		<?php if($validated === 'true')
			{
		?>
			<a href="update-core.php?checkforupdates=true" id="eg-check-updates" class="esg-btn esg-purple"><?php _e('Search for Updates', EG_TEXTDOMAIN); ?></a>
		<?php
			}
		?>
			<div class="validation-description"><?php _e('Please enter your ', EG_TEXTDOMAIN); ?><strong style="color:#000"><?php _e('Essential Grid purchase code / license key.', EG_TEXTDOMAIN); ?></strong><br/><?php _e('You can find your key by following the instructions on', EG_TEXTDOMAIN); ?><a target="_blank" href="https://www.themepunch.com/essgrid-doc/installing-essential-grid/"><?php _e(' this page.', EG_TEXTDOMAIN); ?></a><br><?php _e('Have no regular license for this installation? <a target="_blank" href="https://account.essential-grid.com/licenses/pricing/">Grab a fresh one</a>!', EG_TEXTDOMAIN); ?></div>
		</div>
		<div class="clear"></div>

		<span style="display:none" id="rs_purchase_validation" class="loader_round"><?php _e('Please Wait...', EG_TEXTDOMAIN); ?></span>
	</div>


	<?php if($validated === 'true') {
		?>
		<div class="validation-label"> <?php _e("How to get Support ?", EG_TEXTDOMAIN); ?></div>
		<div><?php _e("Visit our ", EG_TEXTDOMAIN); ?><a href='https://www.themepunch.com/support-center/essential-grid' target="_blank"><?php _e("Support Center ", EG_TEXTDOMAIN); ?></a><?php _e("for the latest FAQs, Documentation and Ticket Support.", EG_TEXTDOMAIN); ?></div>
		<?php
	} else {
		?>
		<div id="tp-before-validation"><?php _e("Click Here to get ", EG_TEXTDOMAIN); ?><strong><?php _e("Premium Support and Auto Updates", EG_TEXTDOMAIN); ?></strong></div>
		<?php
	}
	?>
</div>

<div class="div50"></div>
<!-- NEWSLETTER PART -->
<div class="view_title"><?php _e('Newsletter', EG_TEXTDOMAIN); ?></div>
<div id="eg-newsletter-wrapper" class="esg_info_box">
	<div class="esg-red esg_info_box_decor" ><i class="eg-icon-mail"></i></div>
	<div class="validation-label"><?php _e("Join 15.000 other on the ThemePunch mailing list", EG_TEXTDOMAIN); ?></div>
	<input type="text" value="" placeholder="<?php _e('Enter your E-Mail here', EG_TEXTDOMAIN); ?>" name="eg-email" style="width: 350px; margin-right:10px;"/>
	<span class="subscribe-newsletter-wrap"><a href="javascript:void(0);" class="esg-btn esg-purple" id="subscribe-to-newsletter"><?php _e('Subscribe', EG_TEXTDOMAIN); ?></a></span>
	<span class="unsubscribe-newsletter-wrap" style="display: none;">
		<a href="javascript:void(0);" class="esg-btn esg-red" id="unsubscribe-to-newsletter"><?php _e('Unsubscribe', EG_TEXTDOMAIN); ?></a>
		<a href="javascript:void(0);" class="esg-btn esg-green" id="cancel-unsubscribe"><?php _e('Cancel', EG_TEXTDOMAIN); ?></a>
	</span>

	<div><a href="javascript:void(0);" id="activate-unsubscribe" style="font-size: 12px; color: #999;"><?php _e('unsubscibe from newsletter', EG_TEXTDOMAIN); ?></a></div>
	<div id="why-subscribe-wrapper">
		<div class="star_red"><strong style="font-weight:700"><?php _e('Perks of subscribing to our Newsletter', EG_TEXTDOMAIN); ?></strong></div>
		<ul>
			<li><?php _e('Receive info on the latest ThemePunch product updates', EG_TEXTDOMAIN); ?></li>
			<li><?php _e('Be the first to know about new products by ThemePunch and their partners', EG_TEXTDOMAIN); ?></li>
			<li><?php _e('Participate in polls and customer surveys that help us increase the quality of our products and services', EG_TEXTDOMAIN); ?></li>
		</ul>
	</div>
</div>

<div class="div50"></div>
<div class="view_title"><span style="margin-right:10px"><?php _e("Update History", EG_TEXTDOMAIN); ?></span></div>
<div class="esg_info_box">
	<div class="esg-purple esg_info_box_decor" ><i class="eg-icon-back-in-time"></i></div>
	<div style="height:485px;overflow:scroll;width:100%;"><?php echo file_get_contents($dir."release_log.html"); ?></div>
</div>


<script type="text/javascript">
function esg_grid_info_ready_function() {
	jQuery('#tp-validation-box').on('click',function() {
		jQuery(this).css({cursor:"default"});
		if (jQuery('#rs-validation-wrapper').css('display')=="none") {
			jQuery('#tp-before-validation').hide();
			jQuery('#rs-validation-wrapper').slideDown(200);
		}
	});
	AdminEssentials.initUpdateRoutine();
	AdminEssentials.initNewsletterRoutine();
}

var esg_grid_info_ready_once = false
if (document.readyState === "loading") 
	document.addEventListener('readystatechange',function(){
		if ((document.readyState === "interactive" || document.readyState === "complete") && !esg_grid_info_ready_once) {
			esg_grid_info_ready_once = true;
			esg_grid_info_ready_function() ;
		}
	});
else {
	esg_grid_info_ready_once = true;
	esg_grid_info_ready_function() ;
}


</script>
