<?php 

class VC_MEGA
{
	private $file;

	function __construct($file)
	{
		$this->file = $file;
		add_action( 'vc_before_init', array($this, 'vc_mega_addons' ));
		add_action('admin_menu', array($this, 'vc_register_admin_menu'));
		add_action('wp_ajax_vc_save_data', array($this, 'vc_saving_data' ));
		add_action( 'wp_enqueue_scripts', array($this, 'adding_front_scripts') );
		add_action('admin_enqueue_scripts', array($this, 'vc_admin_script'));
		add_action( 'init', array( $this, 'check_if_vc_is_install' ) );
		add_filter( 'plugin_action_links', array($this, 'action_links'), 10, 5 );
		// register_activation_hook( __FILE__, array( $this, 'activation' ) );
		// remove_filter( 'the_content', 'wpautop' );
	}

	/**
	 * init function.
	 *
	 * @access public
	 * @return void
	 */
	public function init () {
		// Run this on activation.
		register_activation_hook( $this->file, array( $this, 'activation' ) );
	} // End init()

	function adding_front_scripts () {
		$saved_options = get_option('vc_save_data');
		wp_enqueue_style( 'image-hover-effects-css', plugins_url( 'css/ihover.css' , __FILE__ ));
		wp_enqueue_style( 'style-css', plugins_url( 'css/style.css' , __FILE__ ));
		wp_enqueue_style( 'font-awesome-latest', plugins_url( 'css/font-awesome/css/all.css' , __FILE__ ));
	}

	function vc_admin_script($slug) {
		wp_enqueue_style( 'vc_admin_css', plugin_dir_url( __FILE__ ) . 'lib/style.css' );
		if ($slug == 'toplevel_page_mega-addons') {
			wp_enqueue_style( 'vc_admin_style', plugin_dir_url( __FILE__ ) . 'lib/admin.css' );
			wp_enqueue_script( 'vc_admin_js', plugin_dir_url( __FILE__ ) . 'lib/admin.js', array('jquery', 'jquery-ui-core'));
		}
	}


		
	function vc_mega_addons() {
		$saved_options = get_option('vc_save_data');
		if (isset($saved_options['banner'])) {include 'render/infobanners.php';}
		if (isset($saved_options['ihe'])) {include 'render/hover.php';}
		if (isset($saved_options['price_table'])) {include 'render/price.php';}
		if (isset($saved_options['advance_price'])) {include 'render/advanceprice.php';}
		if (isset($saved_options['info_box'])) {include 'render/infobox.php';}
		if (isset($saved_options['advance_btn'])) {include 'render/advanced_btn.php'; include 'render/hoverbutton.php';}
		if (isset($saved_options['team_prof'])) {include 'render/teamprofile.php';}
		if (isset($saved_options['adv_carousel'])) {include 'render/tm_carousel_father.php';}
		if (isset($saved_options['adv_carousel'])) {include 'render/tm_carousel_son.php';}
		if (isset($saved_options['counter'])) {include 'render/statcounter.php';}
		if (isset($saved_options['flip_box'])) {include 'render/flipbox.php';}
		if (isset($saved_options['timeline'])) {include 'render/timeline_father.php';}
		if (isset($saved_options['timeline'])) {include 'render/timeline_son.php';}
		if (isset($saved_options['countdown'])) {include 'render/countdown.php';}
		if (isset($saved_options['creative_link'])) {include 'render/creativelink.php';}
		if (isset($saved_options['text_typer'])) {include 'render/texttyper.php';}
		if (isset($saved_options['social_icon'])) {include 'render/social_father.php';}
		if (isset($saved_options['social_icon'])) {include 'render/social_son.php';}
		if (isset($saved_options['popup'])) {include 'render/modalPopup.php';}
		if (isset($saved_options['interactive_banner'])) {include 'render/interactivebanner.php';}
		if (isset($saved_options['info_list'])) {include 'render/info_list_father.php';}
		if (isset($saved_options['info_list'])) {include 'render/info_list_son.php';}
		if (isset($saved_options['google_trend'])) {include 'render/googletrends.php';}
		if (isset($saved_options['tooltip'])) {include 'render/tooltip_icons.php';}
		if (isset($saved_options['testimonial'])) {include 'render/testimonial.php';}
		if (isset($saved_options['heading'])) {include 'render/headings.php';}
		if (isset($saved_options['highlight_box'])) {include 'render/highlight_box.php';}
		if (isset($saved_options['img_swap'])) {include 'render/image_swap.php';}
		if (isset($saved_options['accordion'])) {include 'render/accordion_father.php';}
		if (isset($saved_options['accordion'])) {include 'render/accordion_son.php';}
		if (isset($saved_options['info_circle'])) {include 'render/info_circle.php';}
		if (isset($saved_options['filter_gallery'])) {include 'render/filterablegallery_wrap.php';}
		if (isset($saved_options['filter_gallery'])) {include 'render/filtergallery.php';}
		include 'includes/class-vc-number-param.php';
	}

	function vc_saving_data() {
		if (isset($_REQUEST)) {
			update_option( 'vc_save_data', $_REQUEST );
		}
	}


	function vc_register_admin_menu() {
		add_menu_page( 'Mega Addons', 'Mega Addons', 'manage_options', 'mega-addons', array($this, 'vc_addons'), 'dashicons-shield');
	}

	function vc_addons() {
		$saved_options = get_option('vc_save_data');
	?>
		
	<div class="addons-admin-wrap">
		<h1>Mega Addons For WPBakery Page Builder</h1>
		<h3>Welcome! You are about to begin with the most powerful addon for WPBakery Page Builder that add in many advanced features developed with love.</h3>
		<br>
		<h3 style="font-weight: 100;">Enable/Disable Element</h3>
		<div class="mega-addons-version">
			<div class="dashicons-before dashicons-shield"></div>
			<p>Version 4.2.7</p>
		</div>
		<?php include 'includes/settings.php'; ?>
	</div>


	<?php }

	function check_if_vc_is_install(){
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            // Display notice that Visual Compser is required
            add_action('admin_notices', array( $this, 'showVcVersionNotice' ));
            return;
        }			
	}

	/**
	 * activation function.
	 *
	 * @access public
	 * @return void
	 */
	public function activation () {

		if ( !get_option( 'vc_save_data' ) ) {
		$vc_default_options =  array(
			 'banner' 			=> 'on',
			 'ihe' 				=> 'on',
			 'price_table' 		=> 'on',
			 'advance_price'	=> 'on',
			 'info_box' 		=> 'on',
			 'advance_btn' 		=> 'on',
			 'team_prof' 		=> 'on',
			 'adv_carousel' 	=> 'on',
			 'counter' 			=> 'on',
			 'flip_box' 		=> 'on',
			 'timeline' 		=> 'on',
			 'countdown' 		=> 'on',
			 'creative_link' 	=> 'on',
			 'text_typer' 		=> 'on',
			 'social_icon' 		=> 'on',
			 'popup' 			=> 'on',
			 'interactive_banner' => 'on',
			 'info_list' 		=> 'on',
			 'google_trend' 	=> 'on',
			 'tooltip' 			=> 'on',
			 'testimonial' 		=> 'on',
			 'heading' 			=> 'on',
			 'highlight_box' 	=> 'on',
			 'img_swap' 		=> 'on',
			 'accordion' 		=> 'on',
			 'info_circle' 		=> 'on',
			 'filter_gallery' 	=> 'on',
			);

		update_option( 'vc_save_data', $vc_default_options);
		}
		
	} // End activation()

	function showVcVersionNotice(){
	    ?>
	    <div class="notice notice-warning is-dismissible">
	        <p>Please install <a href="https://1.envato.market/A1QAx">WPBakery Page Builder</a> to use Mega Addons.</p>
	    </div>
	    <?php
	}

	function action_links($actions, $plugin_file){
		static $plugin;

		if (!isset($plugin))
			$plugin = plugin_basename(__FILE__);
		if ('mega-addons-for-visual-composer/index.php' == $plugin_file && defined('WPB_VC_VERSION')) {

				$site_link = array('upgrade' => '<a href="https://1.envato.market/02aNL" style="font-size: 14px;color: #11967A;" target="_blank"><b>Upgrade To Premium</b></a>');
			
					$actions = array_merge($site_link, $actions);
				
			}
			
			return $actions;
    }

}

?>