<?php
/**
 * Essential Grid.
 *
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2020 ThemePunch
 */

/**
 * @package Essential_Grid_Admin
 * @author  ThemePunch <info@themepunch.com>
 */

if( !defined( 'ABSPATH') ) exit();


class Essential_Grid_Admin extends Essential_Grid_Base {

	const ROLE_ADMIN = "admin";
	const ROLE_EDITOR = "editor";
	const ROLE_AUTHOR = "author";

	const VIEW_START = "grid";
	const VIEW_OVERVIEW = "grid-overview";
	const VIEW_GRID_CREATE = "grid-create";
	const VIEW_GRID = "grid-details";
	const VIEW_META_BOX = "grid-meta-box";
	const VIEW_ITEM_SKIN_EDITOR = "grid-item-skin-editor";
	const VIEW_GOOGLE_FONTS = "global-settings";
	const VIEW_IMPORT_EXPORT = "grid-import-export";

	const VIEW_WIDGET_AREAS = "grid-widget-areas";

	const VIEW_SEARCH = "global-settings";
	const VIEW_SUB_ITEM_SKIN_OVERVIEW = "grid-item-skin";
	const VIEW_SUB_CUSTOM_META = "global-settings";

	const VIEW_GLOBAL_SETTINGS = "grid-global-settings";
	const VIEW_SUB_CUSTOM_META_AJAX = "global-settings";

	const VIEW_SUB_WIDGET_AREA_AJAX = "widget-areas";

	protected static $view;

	/**
	 * Instance of this class.
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	private static $menuRole = self::ROLE_ADMIN;


	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 */
	public function __construct(){
		global $EssentialAsTheme, $esg_dev_mode;

		$library = new Essential_Grid_Library();

		/*
		 * Call $plugin_slug from public plugin class.
		 */
		$plugin = Essential_Grid::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		self::addAllSettings();

		$role = get_option('tp_eg_role', self::ROLE_ADMIN);

		self::setMenuRole($role); //set to setting that user chose

		// Add the options page and menu item.
		add_action('admin_menu', array($this, 'add_plugin_admin_menu'));

		// Load admin style sheet and JavaScript.
		add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts_language'));


        // Add the meta box to post/pages
		add_action('registered_post_type', array($this, 'prepare_add_plugin_meta_box'), 10, 2);
		add_action('save_post', array($this, 'add_plugin_meta_box_save'));
		add_action('wp_ajax_Essential_Grid_request_ajax', array($this, 'on_ajax_action'));

		//if(!$EssentialAsTheme){
			$validated = get_option('tp_eg_valid', 'false');
			$notice = get_option('tp_eg_valid-notice', 'true');


			if($validated === 'false' && $notice === 'true'){
				add_action('admin_notices', array($this, 'add_activate_notification'));
			}

			$upgrade = new Essential_Grid_Update( Essential_Grid::VERSION );

			if(isset($_GET['checkforupdates']) && $_GET['checkforupdates'] == 'true')
				$upgrade->_retrieve_version_info(true);
			else
				$upgrade->_retrieve_version_info();

			if($validated === 'true'){
				$upgrade->add_update_checks();
			}
		//}

		if(isset($_REQUEST['update_shop'])){
			$library->_get_template_list(true);
		}else{
			$library->_get_template_list();
		}

		add_action('admin_notices', array($this, 'add_notices'));

		//add calls to delete transient if needed
		add_action('save_post', array($this, 'check_for_transient_deletion'));
		add_action('future_to_publish', array($this, 'check_for_transient_deletion'));
		add_action('publish_post', array($this, 'check_for_transient_deletion'));
		add_action('publish_future_post', array($this, 'check_for_transient_deletion'));
		add_filter('essgrid_update_create_grid_update', array($this, 'check_for_transient_deletion_on_update'));

		add_action('admin_head', array($this, 'add_tinymce_editor'));
		add_action('admin_head', array($this, 'add_header_data'));

		add_action('print_media_templates', array($this, 'ess_grid_addon_media_form'));

		// Gutenberg
		add_action('enqueue_block_editor_assets', array($this, 'enqueue_block_editor_assets'));
		add_action('enqueue_block_assets', array($this, 'enqueue_assets'));
		add_filter('block_categories', array($this, 'create_block_category'), 10, 2);


		// Privacy
		add_action('admin_init', array($this, 'add_suggested_privacy_content'), 15);

        $instagram = new Essential_Grid_Instagram();
        $instagram->add_actions();
	}

	/**
	 * Return the default suggested privacy policy content.
	 *
	 * @return string The default policy content.
	 */
	public function get_default_privacy_content(){
		return
		__('<h2>Essential Grid core itself does not collect any data from website visitors. In case you’re using things like Google Web Fonts (default) or connect to external sources in your Essential Grid please add the corresponding text phrase to your privacy police:</h2>
		<h3>Google Web Fonts</h3> <p>For uniform representation of fonts, this page uses web fonts provided by Google. When you open a page, your browser loads the required web fonts into your browser cache to display texts and fonts correctly.</p> <p>For this purpose your browser has to establish a direct connection to Google servers. Google thus becomes aware that our web page was accessed via your IP address. The use of Google Web fonts is done in the interest of a uniform and attractive presentation of our plugin. This constitutes a justified interest pursuant to Art. 6 (1) (f) DSGVO.</p> <p>If your browser does not support web fonts, a standard font is used by your computer.</p> <p>Further information about handling user data, can be found at <a href="https://developers.google.com/fonts/faq" target="_blank">https://developers.google.com/fonts/faq</a> and in Google\'s privacy policy at <a href="https://www.google.com/policies/privacy/" target="_blank">https://www.google.com/policies/privacy/</a>.</p>
		<h3>YouTube</h3> <p>Our website uses plugins from YouTube, which is operated by Google. The operator of the pages is YouTube LLC, 901 Cherry Ave., San Bruno, CA 94066, USA.</p> <p>If you visit one of our pages featuring a YouTube plugin, a connection to the YouTube servers is established. Here the YouTube server is informed about which of our pages you have visited.</p> <p>If you\'re logged in to your YouTube account, YouTube allows you to associate your browsing behavior directly with your personal profile. You can prevent this by logging out of your YouTube account.</p> <p>YouTube is used to help make our plugin appealing. This constitutes a justified interest pursuant to Art. 6 (1) (f) DSGVO.</p> <p>Further information about handling user data, can be found in the data protection declaration of YouTube under <a href="https://www.google.de/intl/de/policies/privacy" target="_blank">https://www.google.de/intl/de/policies/privacy</a>.</p>
		<h3>Vimeo</h3> <p>Our website uses features provided by the Vimeo video portal. This service is provided by Vimeo Inc., 555 West 18th Street, New York, New York 10011, USA.</p> <p>If you visit one of our pages featuring a Vimeo plugin, a connection to the Vimeo servers is established. Here the Vimeo server is informed about which of our pages you have visited. In addition, Vimeo will receive your IP address. This also applies if you are not logged in to Vimeo when you visit our plugin or do not have a Vimeo account. The information is transmitted to a Vimeo server in the US, where it is stored.</p> <p>If you are logged in to your Vimeo account, Vimeo allows you to associate your browsing behavior directly with your personal profile. You can prevent this by logging out of your Vimeo account.</p> <p>For more information on how to handle user data, please refer to the Vimeo Privacy Policy at <a href="https://vimeo.com/privacy" target="_blank">https://vimeo.com/privacy</a>.</p>
		<h3>SoundCloud</h3><p>On our pages, plugins of the SoundCloud social network (SoundCloud Limited, Berners House, 47-48 Berners Street, London W1T 3NF, UK) may be integrated. The SoundCloud plugins can be recognized by the SoundCloud logo on our site.</p>
			<p>When you visit our site, a direct connection between your browser and the SoundCloud server is established via the plugin. This enables SoundCloud to receive information that you have visited our site from your IP address. If you click on the “Like” or “Share” buttons while you are logged into your SoundCloud account, you can link the content of our pages to your SoundCloud profile. This means that SoundCloud can associate visits to our pages with your user account. We would like to point out that, as the provider of these pages, we have no knowledge of the content of the data transmitted or how it will be used by SoundCloud. For more information on SoundCloud’s privacy policy, please go to https://soundcloud.com/pages/privacy.</p><p>If you do not want SoundCloud to associate your visit to our site with your SoundCloud account, please log out of your SoundCloud account.</p>
		<h3>Facebook</h3>
			<p>Our website includes plugins for the social network Facebook, Facebook Inc., 1 Hacker Way, Menlo Park, California 94025, USA. For an overview of Facebook plugins, see <a href="https://developers.facebook.com/docs/plugins/" target="_blank" rel="noopener">https://developers.facebook.com/docs/plugins/</a>.</p><p>When you visit our site, a direct connection between your browser and the Facebook server is established via the plugin. This enables Facebook to receive information that you have visited our site from your IP address. If you click on the Facebook &#8220;Like button&#8221; while you are logged into your Facebook account, you can link the content of our site to your Facebook profile. This allows Facebook to associate visits to our site with your user account. Please note that, as the operator of this site, we have no knowledge of the content of the data transmitted to Facebook or of how Facebook uses these data. For more information, please see Facebook&#8217;s privacy policy at <a href="https://de-de.facebook.com/policy.php" target="_blank" rel="noopener">https://de-de.facebook.com/policy.php</a>.</p><p>If you do not want Facebook to associate your visit to our site with your Facebook account, please log out of your Facebook account.</p>
		<h3>Twitter</h3>
			<p>Functions of the Twitter service have been integrated into our website and app. These features are offered by Twitter Inc., 1355 Market Street, Suite 900, San Francisco, CA 94103, USA. When you use Twitter and the “Retweet” function, the websites you visit are connected to your Twitter account and made known to other users. In doing so, data will also be transferred to Twitter. We would like to point out that, as the provider of these pages, we have no knowledge of the content of the data transmitted or how it will be used by Twitter. For more information on Twitter&#8217;s privacy policy, please go to <a href="https://twitter.com/privacy" target="_blank" rel="noopener">https://twitter.com/privacy</a>.</p><p>Your privacy preferences with Twitter can be modified in your account settings at <a href="https://twitter.com/account/settings" target="_blank" rel="noopener">https://twitter.com/account/settings</a>.</p>
		<h3>Instagram</h3>
			<p>Our website contains functions of the Instagram service. These functions are offered by Instagram Inc., 1601 Willow Road, Menlo Park, CA 94025, USA.</p><p>If you are logged into your Instagram account, you can click the Instagram button to link the content of our pages with your Instagram profile. This means that Instagram can associate visits to our pages with your user account. As the provider of this website, we expressly point out that we receive no information on the content of the transmitted data or its use by Instagram.</p><p>For more information, see the Instagram Privacy Policy: <a href="https://instagram.com/about/legal/privacy/" target="_blank" rel="noopener">https://instagram.com/about/legal/privacy/</a>.</p>',EG_TEXTDOMAIN);
	}
	/**
	 * Add the suggested privacy policy text to the policy eg-pbox.
	 */
	public function add_suggested_privacy_content(){
		if(function_exists("wp_add_privacy_policy_content")){
			$content = $this->get_default_privacy_content();
			wp_add_privacy_policy_content( __( 'Essential Grid' ), $content);
		}
	}

	/**
	 * add notices from ThemePunch
	 * @since: 2.1.0
	 */
	public function add_notices(){
		//check permissions here
		if(!current_user_can('administrator')) return true;

		$enable_newschannel = apply_filters('essgrid_set_notifications', 'on');

		if($enable_newschannel == 'on'){

			$nonce = wp_create_nonce("Essential_Grid_actions");

			$notices = get_option('essential-notices', false);

			if(!empty($notices) && is_array($notices)){

				$notices_discarded = get_option('essential-notices-dc', array());

				$screen = get_current_screen();
				foreach($notices as $notice){
					if($notice->is_global !== true && !in_array($screen->id, $this->plugin_screen_hook_suffix)) continue; //check if global or just on plugin related pages

					if(!in_array($notice->code, $notices_discarded) && version_compare($notice->version, Essential_Grid::VERSION, '>=')){
						$text = '<div style="text-align:right;vertical-align:middle;display:table-cell; min-width:225px;border-left:1px solid #ddd; padding-left:15px;"><a href="javascript:void(0);"  class="esg-notices-button esg-notice-'. esc_attr($notice->code) .'">'. __('Close & don\'t show again<b>X</b>',EG_TEXTDOMAIN) .'</a></div>';
						if($notice->disable == true) $text = '';
						?>
							<style>
						.esg-notices-button			{	color:#999; text-decoration: none !important; font-size:14px;font-weight: 400;}
						.esg-notices-button:hover 	{	color:#3498DB !important;}

						.esg-notices-button b 		{	font-weight:800; vertical-align:bottom;line-height:15px;font-size:10px;margin-left:10px;margin-right:10px;border:2px solid #999; display:inline-block; width:15px;height:15px; text-align: center; border-radius: 50%; -webkit-border-radius: 50%; -moz-border-radius: 50%;}
						.esg-notices-button:hover b  { 	border-color:#3498DB;}
						</style>
						<div class="<?php echo $notice->color; ?> below-h2 esg-update-notice-wrap" id="message" style="clear:both;display: block;position:relative;margin:35px 20px 25px 0px"><div style="display:table;width:100%;"><div style="vertical-align:middle;display:table-cell;min-width:100%;padding-right:15px;"><?php echo $notice->text; ?></div><?php echo $text; ?></div></div>

						<?php
					}
				}
				?>
				<script type="text/javascript">
					jQuery('.esg-notices-button').on('click',function(){

						var notice_id = jQuery(this).attr('class').replace('esg-notices-button', '').replace('esg-notice-', '');

						var objData = {
										action:"Essential_Grid_request_ajax",
										client_action: 'dismiss_dynamic_notice',
										token:'<?php echo $nonce; ?>',
										data:{'id':notice_id}
										};

						jQuery.ajax({
							type:"post",
							url:ajaxurl,
							dataType: 'json',
							data:objData
						});

						jQuery(this).closest('.esg-update-notice-wrap').slideUp(200);
					});
				</script>
				<?php
			}
		}
	}


	/**
	 * show notification message if plugin is not activated
	 */
	public function add_activate_notification(){
		$token = wp_create_nonce('Essential_Grid_actions');
		$base = new Essential_Grid();

		$n = '';
		$n .= '<div class="updated below-h2 eg-update-notice-wrap" style="margin-left: 0;" id="message"><a href="javascript:void(0);" style="float: right;" id="eg-dismiss-notice">×</a><p>'.__('Hi! Please activate your copy of the Essential Grid to receive live updates, premium support and the template library.', EG_TEXTDOMAIN).'</p></div>'."\n";
		$n .= '<script type="text/javascript">'."\n";
		$n .= '	jQuery(\'#eg-dismiss-notice\').on(\'click\',function(){'."\n";
		$n .= '		var objData = {'."\n";
		$n .= '			action: \'Essential_Grid_request_ajax\','."\n";
		$n .= '			client_action: \'dismiss_notice\','."\n";
		$n .= '			token: \''. $token .'\','."\n";
		$n .= '			data: \'\''."\n";
		$n .= '		};'."\n";
		$n .= '		'."\n";
		$n .= '		jQuery.ajax({'."\n";
		$n .= '			type:\'post\','."\n";
		$n .= '			url:ajaxurl,'."\n";
		$n .= '			dataType:\'json\','."\n";
		$n .= '			data:objData'."\n";
		$n .= '		});'."\n";
		$n .= '		'."\n";
		$n .= '		jQuery(\'.eg-update-notice-wrap\').hide();'."\n";
		$n .= '	});'."\n";
		$n .= '</script>'."\n";

		echo apply_filters('essgrid_add_activate_notification', $n);
	}


	/**
	 * Return an instance of this class.
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance(){

		// If the single instance hasn't been set, set it now.
		if( null == self::$instance ){
			self::$instance = new self;
		}

		return apply_filters('essgrid_get_instance', self::$instance);
	}


	/**
	 * Register and enqueue admin-specific style sheet.
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles(){

		if( ! isset($this->plugin_screen_hook_suffix ) ){
			return;
		}

		$screen = get_current_screen();
		if(in_array($screen->id, $this->plugin_screen_hook_suffix)){
			wp_enqueue_style(array('wp-jquery-ui', 'wp-jquery-ui-core', 'wp-jquery-ui-dialog', 'wp-color-picker'));

			wp_enqueue_style($this->plugin_slug .'-admin-styles', EG_PLUGIN_URL . 'admin/assets/css/esg-admin.css', array(), Essential_Grid::VERSION );

			wp_enqueue_style($this->plugin_slug .'-esg-mirror-styles', EG_PLUGIN_URL . 'admin/assets/css/esg-mirror.css', array(), Essential_Grid::VERSION );

			wp_enqueue_style($this->plugin_slug .'-tooltipser-styles', EG_PLUGIN_URL . 'admin/assets/css/tooltipster.css', array(), Essential_Grid::VERSION );

			wp_register_style($this->plugin_slug . '-plugin-settings', EG_PLUGIN_URL . 'public/assets/css/settings.css', array(), Essential_Grid::VERSION);
			wp_enqueue_style($this->plugin_slug . '-plugin-settings' );

			wp_register_style('themepunchboxextcss', EG_PLUGIN_URL . 'public/assets/css/jquery.esgbox.min.css', array(), Essential_Grid::VERSION);

			$font = new ThemePunch_Fonts();
			$font->register_fonts();
			$font->register_icon_fonts("admin");
		}

		wp_enqueue_style('tp-material-icons', '//fonts.googleapis.com/icon?family=Material+Icons');

		wp_enqueue_style($this->plugin_slug .'-global-styles', EG_PLUGIN_URL . 'admin/assets/css/esg-global.css', array(), Essential_Grid::VERSION );
		wp_enqueue_style('tp-fontello', EG_PLUGIN_URL . 'public/assets/font/fontello/css/fontello.css', array(), Essential_Grid::VERSION );

		//enqueue in all pages / posts in backend
		$post_types = get_post_types( '', 'names' );
		$post_types[] = 'comment';

		foreach($post_types as $post_type){
			if($post_type == $screen->id) wp_enqueue_style('wp-jquery-ui-dialog');
			if($post_type == $screen->id) wp_enqueue_style('wp-color-picker');
		}

		do_action('essgrid_enqueue_admin_styles');
	}


	/**
	 * Register and enqueue admin-specific JavaScript.
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts(){

		if( ! isset($this->plugin_screen_hook_suffix ) ){
			return;
		}
		
		global $esg_dev_mode, $wp_version;
		
		if(strpos($wp_version, '-') !== false){
			$_wpver = explode('-', $wp_version);
			$wp_version = $_wpver[0];
		}
		
		$screen = get_current_screen();
		if(in_array($screen->id, $this->plugin_screen_hook_suffix)){

			wp_enqueue_script(array('jquery', 'jquery-ui-core', 'jquery-ui-dialog', 'jquery-ui-slider', 'jquery-ui-autocomplete', 'jquery-ui-droppable', 'jquery-ui-tabs', 'wp-color-picker'));
			
			if(version_compare($wp_version, '5.6', '<')){
				wp_enqueue_script('jquery-ui-sortable', 'jquery-ui-draggable');
			}
			
			wp_enqueue_style('esg-color-picker-css', plugins_url('assets/css/tp-color-picker.css', __FILE__ ), array(), Essential_Grid::VERSION);
			wp_enqueue_style('esg-select2-css', plugins_url('assets/css/select2ESG.css', __FILE__ ), array(), Essential_Grid::VERSION);
			
			global $wp_scripts;
			/**
			 * dequeue tp-tools to make sure that always the latest is loaded
			 **/
			/*if(isset($wp_scripts->registered) && isset($wp_scripts->registered['tp-tools']) && isset($wp_scripts->registered['tp-tools']->ver)){
				if(version_compare($wp_scripts->registered['tp-tools']->ver, ESG_TP_TOOLS, '<')){
					wp_deregister_script('tp-tools');
					wp_dequeue_script('tp-tools');
				}
			}*/
			
			wp_enqueue_script( 'tp-tools', plugins_url( '../public/assets/js/rbtools.min.js', __FILE__ ), array('jquery'), ESG_TP_TOOLS );



			if($esg_dev_mode){ // DEV VERSION
				wp_enqueue_script( 'themepunchboxext', EG_PLUGIN_URL . 'public/assets/js/dev/esgbox.js', array('jquery'), Essential_Grid::VERSION);
				wp_enqueue_script($this->plugin_slug . '-admin-script', plugins_url('assets/js/modules/admin.js', __FILE__ ), array('jquery', 'wp-color-picker'), Essential_Grid::VERSION );
				wp_enqueue_script($this->plugin_slug . '-tooltipser-script', plugins_url('assets/js/plugins/tooltipster.js', __FILE__ ), array('jquery'), Essential_Grid::VERSION );

				//UTILS
				wp_enqueue_script($this->plugin_slug . '-esgmirror-script', plugins_url('assets/js/plugins/esgmirror.js', __FILE__ ), array('jquery'), Essential_Grid::VERSION );
				wp_enqueue_script('esg-color-picker-js', plugins_url('assets/js/plugins/tp-color-picker.js', __FILE__ ), array('jquery'), Essential_Grid::VERSION);
				wp_enqueue_script('esg-select2-js', plugins_url('assets/js/plugins/select2ESG.full.js', __FILE__ ), array('jquery'), Essential_Grid::VERSION);

				//ESG GRID
				wp_enqueue_script( $this->plugin_slug . '-essential-grid-script', plugins_url( '../public/assets/js/dev/essential-grid.js', __FILE__ ), array('jquery'), Essential_Grid::VERSION );
			} else { // NONE DEV VERSION
				
				//ToolTipser + Admin.js
				wp_enqueue_script($this->plugin_slug . '-admin-script', plugins_url('assets/js/modules/admin.min.js', __FILE__ ), array('jquery', 'wp-color-picker'), Essential_Grid::VERSION );
				//ESGMirror, + ColorPicker JS
				wp_enqueue_script($this->plugin_slug . '-utils', plugins_url('assets/js/plugins/utils.min.js', __FILE__ ), array('jquery', 'jquery-ui-dialog'), Essential_Grid::VERSION );

				//ESG Box
				wp_enqueue_script( 'themepunchboxext', EG_PLUGIN_URL . 'public/assets/js/esgbox.min.js', array('jquery'), Essential_Grid::VERSION);

				//ESG GRID
				wp_enqueue_script( $this->plugin_slug . '-essential-grid-script', plugins_url( '../public/assets/js/esg.min.js', __FILE__ ), array('jquery'), Essential_Grid::VERSION );
			}

			wp_localize_script( $this->plugin_slug . '-admin-script', "tp_eg", array('valid' => get_option('tp_eg_valid', 'false')) );


			wp_enqueue_media();
		}

		//enqueue in all pages / posts in backend
		$post_types = get_post_types( '', 'names' );
		$post_types[] = 'comment';

		foreach($post_types as $post_type){
			if($post_type == $screen->id){
				wp_enqueue_script(array('wpdialogs', 'jquery', 'jquery-ui-core', 'wp-color-picker'));
				if(version_compare($wp_version, '5.6', '<')){
					wp_enqueue_script('jquery-ui-sortable');
				}
				wp_enqueue_style('esg-color-picker-css', plugins_url('assets/css/tp-color-picker.css', __FILE__ ), array(), Essential_Grid::VERSION);
				wp_enqueue_style('esg-select2-css', plugins_url('assets/css/select2ESG.css', __FILE__ ), array(), Essential_Grid::VERSION);
				if($esg_dev_mode){ // DEV VERSION
					wp_enqueue_script($this->plugin_slug . '-admin-script', plugins_url('assets/js/modules/admin.js', __FILE__ ), array('jquery', 'wp-color-picker'), Essential_Grid::VERSION );
					wp_enqueue_script($this->plugin_slug . '-tooltipser-script', plugins_url('assets/js/plugins/tooltipster.js', __FILE__ ), array('jquery'), Essential_Grid::VERSION );
					wp_enqueue_script('esg-color-picker-js', plugins_url('assets/js/plugins/tp-color-picker.js', __FILE__ ), array('jquery'), Essential_Grid::VERSION);
					wp_enqueue_script('esg-select2-js', plugins_url('assets/js/plugins/select2ESG.full.js', __FILE__ ), array('jquery'), Essential_Grid::VERSION);
					wp_enqueue_script($this->plugin_slug . '-shortcode', plugins_url('assets/js/modules/shortcode.js', __FILE__ ), array('jquery'), Essential_Grid::VERSION );
					wp_enqueue_media();
				} else { // NONE DEV VERSION
					//Admin + ToolTipser
					wp_enqueue_script($this->plugin_slug . '-admin-script', plugins_url('assets/js/modules/admin.min.js', __FILE__ ), array('jquery', 'wp-color-picker'), Essential_Grid::VERSION );
					wp_enqueue_script($this->plugin_slug . '-shortcode', plugins_url('assets/js/modules/shortcode.min.js', __FILE__ ), array('jquery'), Essential_Grid::VERSION );
					wp_enqueue_script($this->plugin_slug . '-utils', plugins_url('assets/js/plugins/utils.min.js', __FILE__ ), array('jquery', 'jquery-ui-dialog'), Essential_Grid::VERSION );
				}
			}
		}

		do_action('essgrid_enqueue_admin_scripts');
	}

	/**
	 * Register and enqueue admin-specific JavaScript Language.
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts_language(){
		if( ! isset($this->plugin_screen_hook_suffix ) ){
			return;
		}

		$screen = get_current_screen();

		if(in_array($screen->id, $this->plugin_screen_hook_suffix)){
			wp_localize_script($this->plugin_slug . '-admin-script', 'eg_lang', self::get_javascript_multilanguage()); //Load multilanguage for JavaScript
		}

		//enqueue in all pages / posts in backend
		$post_types = get_post_types( '', 'names' );
		foreach($post_types as $post_type)
			if($post_type == $screen->id) wp_localize_script($this->plugin_slug . '-admin-script', 'eg_lang', self::get_javascript_multilanguage()); //Load multilanguage for JavaScript

		do_action('essgrid_enqueue_admin_scripts_language');
	}


	public  function add_header_data(){
		global $typenow;

		$post_types = get_post_types();
		if(!is_array($post_types)) $post_types = array('post', 'page');
		// verify the post type
		if(!in_array($typenow, $post_types)) return;
		
		$esg_color_picker_presets = ESGColorpicker::get_color_presets();
		?>
		<script type="text/javascript">
			window.ESG = window.ESG === undefined ? {F:{}, C:{}, ENV:{}, LIB:{}, V:{}, S:{}, DOC:jQuery(document), WIN:jQuery(window)} : window.ESG;
			ESG.LIB.COLOR_PRESETS	= <?php echo (!empty($esg_color_picker_presets)) ? 'JSON.parse('. $this->jsonEncodeForClientSide($esg_color_picker_presets) .')' : '{}'; ?>;
		</script>
		<?php
	}
	
	/**
	 * Add interface for custom shortcodes to tinymce
	 * @since: 1.2.0
	 */
	public  function add_tinymce_editor(){
		global $typenow;

		do_action('essgrid_add_tinymce_editor');

		// check user permissions
		if(!current_user_can('edit_posts') && !current_user_can('edit_pages')) return;

		$post_types = get_post_types();
		if(!is_array($post_types)) $post_types = array( 'post', 'page' );
		// verify the post type
		if(!in_array($typenow, $post_types)) return;

		// check if WYSIWYG is enabled
		if(get_user_option('rich_editing') == 'true'){
			add_filter('mce_external_plugins', array($this, 'add_tinymce_shortcode_editor_plugin'));
			add_filter('mce_buttons', array($this, 'add_tinymce_shortcode_editor_button'));
		}

		add_action('in_admin_footer', array('Essential_Grid_Dialogs', 'add_esg_shortcode_builder'));

	}


	/**
	 * add script tinymce shortcode script
	 * @since: 1.2.0
	 */
	public static function add_tinymce_shortcode_editor_plugin($plugin_array){
		global $esg_dev_mode;
		
		if($esg_dev_mode){
			$plugin_array['essgrid_sc_button'] = plugins_url( 'assets/js/modules/shortcode.js', __FILE__ );
		} else {
			$plugin_array['essgrid_sc_button'] = plugins_url( 'assets/js/modules/shortcode.min.js', __FILE__ );
		}
		return apply_filters('essgrid_add_tinymce_shortcode_editor_plugin', $plugin_array);
	}


	/**
	 * Add button to tinymce
	 * @since: 1.2.0
	 */
	public static function add_tinymce_shortcode_editor_button($buttons){

		array_push($buttons, "essgrid_sc_button");

		return apply_filters('essgrid_add_tinymce_shortcode_editor_button', $buttons);

	}


	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 */
	public function add_plugin_admin_menu(){

		$role = self::getPluginPermission();
		switch(self::$menuRole){
			case self::ROLE_AUTHOR:
				$role = "edit_published_posts";
			break;
			case self::ROLE_EDITOR:
				$role = "edit_pages";
			break;
			default:
			case self::ROLE_ADMIN:
				$role = "manage_options";
			break;
		}

		$this->plugin_screen_hook_suffix[] = add_menu_page(__('Essential Grid', EG_TEXTDOMAIN ),__('Essential Grid', EG_TEXTDOMAIN ),$role,$this->plugin_slug,array($this, 'display_plugin_admin_page'),'dashicons-screenoptions');
		$this->plugin_screen_hook_suffix[] = add_submenu_page($this->plugin_slug, __('Item Skin Editor', EG_TEXTDOMAIN), __('Item Skin Editor', EG_TEXTDOMAIN), $role, $this->plugin_slug.'-item-skin', array($this, 'display_plugin_submenu_page_item_skin'));
		$this->plugin_screen_hook_suffix[] = add_submenu_page($this->plugin_slug, __('Global Settings', EG_TEXTDOMAIN), __('Global Settings', EG_TEXTDOMAIN), $role, $this->plugin_slug.'-global-settings', array($this, 'display_plugin_submenu_page_global_settings'));


		/* //ToDo Widget part
		$this->plugin_screen_hook_suffix[] = add_submenu_page($this->plugin_slug, __('Widget Areas', EG_TEXTDOMAIN), __('Widget Areas', EG_TEXTDOMAIN), $role, $this->plugin_slug.'-widget-areas', array($this, 'display_plugin_submenu_page_widget_areas'));
		*/


		$this->plugin_screen_hook_suffix[] = add_submenu_page($this->plugin_slug, __('Import/Export', EG_TEXTDOMAIN), __('Import/Export', EG_TEXTDOMAIN), $role, $this->plugin_slug.'-import-export', array($this, 'display_plugin_submenu_page_import_export'));

		do_action('essgrid_add_plugin_admin_menu', $role, $this->plugin_slug, $this);

	}


	/**
	 * prepare the meta box inclusion if right post_type (includes all custom post types
	 */
	public static function prepare_add_plugin_meta_box($post_type){


		if($post_type !== 'attachment' &&
		   $post_type !== 'revision' &&
		   $post_type !== 'nav_menu_item'
		   ){
			add_action('add_meta_boxes', array(self::$instance, 'add_plugin_meta_box'), $post_type, 1);
		}

		do_action('essgrid_prepare_add_plugin_meta_box', $post_type);
	}


	/**
	 * Register the meta box in post / pages
	 */
	public function add_plugin_meta_box($post_type){
		$enable_post_meta = get_option('tp_eg_enable_post_meta', 'true');
		if($enable_post_meta!="false"){
			add_meta_box('eg-meta-box', __('Essential Grid', EG_TEXTDOMAIN), array(self::$instance, 'display_plugin_meta_box'), $post_type, 'normal', 'high');
		}
		do_action('essgrid_add_plugin_meta_box', $post_type, self::$instance);
	}


	/**
	 * Display the meta box
	 */
	public static function display_plugin_meta_box($post){
		require_once('views/elements/'.self::VIEW_META_BOX.'.php');

		do_action('essgrid_add_plugin_meta_box', $post);
	}


	/**
	 * Register the meta box save in post / pages
	 */
	public function add_plugin_meta_box_save($post_id){

		// Bail if we're doing an auto save
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

		self::custom_meta_box_save($post_id, $_POST);

		do_action('essgrid_add_plugin_meta_box_save', $post_id);
	}


	/**
	 * This function deletes transient of certain grids where the Post is included in
	 * @since: 1.2.0
	 */
	public static function check_for_transient_deletion($post_id){

		$base = new Essential_Grid_Base();
		$categories = $base->get_custom_taxonomies_by_post_id($post_id);
		$tags = get_the_tags($post_id);

		$lang = array();

		if(Essential_Grid_Wpml::is_wpml_exists()){
			$lang = icl_get_languages();
		}

		$cat = array();
		if(!empty($categories) || !empty($tags)){
			if(!empty($categories)){
				foreach($categories as $c){
					$cat[$c->taxonomy][$c->term_id] = true;
				}
			}
			if(!empty($tags)){
				foreach($categories as $c){
					$cat[$c->taxonomy][$c->term_id] = true;
				}
			}

			//get all grids, then check all grids
			$grids = Essential_Grid::get_essential_grids();
			if(!empty($grids)){
				foreach($grids as $grid){
					$selected = json_decode($grid->postparams, true);
					$post_category = $base->getVar($selected, 'post_category');

					$cat_tax = $base->getCatAndTaxData($post_category);

					$cats = array();
					if(!empty($cat_tax['cats']))
						$cats = explode(',', $cat_tax['cats']);

					$taxes = array('post_tag');
					if(!empty($cat_tax['tax']))
						$taxes = explode(',', $cat_tax['tax']);

					$cont = false;
					if(!empty($cats)){
						foreach($taxes as $tax){
							foreach($cats as $c){
								if(isset($cat[$tax][$c])){ //if set, cache of grid needs to be killed
									if(!empty($lang)){
										foreach($lang as $code => $val){
											delete_transient( 'ess_grid_trans_query_'.$grid->id.$val['language_code'] );
											delete_transient( 'ess_grid_trans_full_grid_'.$grid->id.$val['language_code'] );
										}
									}else{
										delete_transient( 'ess_grid_trans_query_'.$grid->id );
										delete_transient( 'ess_grid_trans_full_grid_'.$grid->id );
									}
									$cont = true;
								}
								if($cont == true) break;
							}
							if($cont == true) break;
						}
					}
				}
			}
		}

		do_action('essgrid_check_for_transient_deletion', $post_id);

	}

    /**
     * check for transient deletion on update
     */
    public static function check_for_transient_deletion_on_update($data){
        if(empty($data['postparams'])) return $data;

        $params = json_decode($data['postparams'], JSON_OBJECT_AS_ARRAY);
        if($params['source-type'] == 'stream' && $params['stream-source-type'] == 'instagram'){
            $insta = new Essential_Grid_Instagram();
            $insta->clear_esg_transient($data['handle'], $params['instagram-api-key'], $params['instagram-count']);
        }
        return $data;
    }

	/**
	 * Adds functionality to do certain things on an upgrade
	 * @since: 1.1.0
	 */
	public static function do_update_checks(){

		$grid_ver = get_option("tp_eg_grids_version", '0.99');

		$updates = new Essential_Grid_Plugin_Update($grid_ver);

		$updates->do_update_process();

		do_action('essgrid_do_update_checks', $grid_ver);

	}


	/**
	 * Include wanted page
	 */
	public static function custom_meta_box_save($post_id, $metas, $ajax = false){

		$metas = apply_filters('essgrid_custom_meta_box_save', $metas, $post_id, $ajax);

		// if our nonce isn't there, or we can't verify it, bail
		if(!isset($metas['essential_grid_meta_box_nonce']) || !wp_verify_nonce($metas['essential_grid_meta_box_nonce'], 'eg_meta_box_nonce')) return;

		if(isset($metas['eg_sources_html5_mp4']))
			update_post_meta($post_id, 'eg_sources_html5_mp4', esc_attr($metas['eg_sources_html5_mp4']));

		if(isset($metas['eg_sources_html5_ogv']))
			update_post_meta($post_id, 'eg_sources_html5_ogv', esc_attr($metas['eg_sources_html5_ogv']));

		if(isset($metas['eg_sources_html5_webm']))
			update_post_meta($post_id, 'eg_sources_html5_webm', esc_attr($metas['eg_sources_html5_webm']));

		if(isset($metas['eg_sources_youtube']))
			update_post_meta($post_id, 'eg_sources_youtube', esc_attr($metas['eg_sources_youtube']));

		if(isset($metas['eg_sources_vimeo']))
			update_post_meta($post_id, 'eg_sources_vimeo', esc_attr($metas['eg_sources_vimeo']));

		if(isset($metas['eg_sources_wistia']))
			update_post_meta($post_id, 'eg_sources_wistia', esc_attr($metas['eg_sources_wistia']));

		if(isset($metas['eg_sources_image']))
			update_post_meta($post_id, 'eg_sources_image', esc_attr($metas['eg_sources_image']));

		if(isset($metas['eg_sources_iframe']))
			update_post_meta($post_id, 'eg_sources_iframe', esc_attr($metas['eg_sources_iframe']));

		if(isset($metas['eg_sources_soundcloud']))
			update_post_meta($post_id, 'eg_sources_soundcloud', esc_attr($metas['eg_sources_soundcloud']));

		if(isset($metas['eg_settings_type']))
			update_post_meta($post_id, 'eg_settings_type', esc_attr($metas['eg_settings_type']));

		if(isset($metas['eg_settings_custom_display']))
			update_post_meta($post_id, 'eg_settings_custom_display', esc_attr($metas['eg_settings_custom_display']));

		if(isset($metas['eg_vimeo_ratio']))
			update_post_meta($post_id, 'eg_vimeo_ratio', esc_attr($metas['eg_vimeo_ratio']));

		if(isset($metas['eg_youtube_ratio']))
			update_post_meta($post_id, 'eg_youtube_ratio', esc_attr($metas['eg_youtube_ratio']));

		if(isset($metas['eg_wistia_ratio']))
			update_post_meta($post_id, 'eg_wistia_ratio', esc_attr($metas['eg_wistia_ratio']));

		if(isset($metas['eg_html5_ratio']))
			update_post_meta($post_id, 'eg_html5_ratio', esc_attr($metas['eg_html5_ratio']));

		if(isset($metas['eg_soundcloud_ratio']))
			update_post_meta($post_id, 'eg_soundcloud_ratio', esc_attr($metas['eg_soundcloud_ratio']));

		if(isset($metas['eg_image_fit']))
			update_post_meta($post_id, 'eg_image_fit', esc_attr($metas['eg_image_fit']));

		if(isset($metas['eg_image_repeat']))
			update_post_meta($post_id, 'eg_image_repeat', esc_attr($metas['eg_image_repeat']));

		if(isset($metas['eg_image_align_h']))
			update_post_meta($post_id, 'eg_image_align_h', esc_attr($metas['eg_image_align_h']));

		if(isset($metas['eg_image_align_v']))
			update_post_meta($post_id, 'eg_image_align_v', esc_attr($metas['eg_image_align_v']));

		/* 2.2 ?? */
		if(isset($metas['eg_sources_revslider'])){
			update_post_meta($post_id, 'eg_sources_revslider', esc_attr($metas['eg_sources_revslider']));
		}

		if(isset($metas['eg_sources_essgrid']))
			update_post_meta($post_id, 'eg_sources_essgrid', esc_attr($metas['eg_sources_essgrid']));

		if(isset($metas['eg_featured_grid']))
			update_post_meta($post_id, 'eg_featured_grid', esc_attr($metas['eg_featured_grid']));


		/* 2.2.6 */
		//if($ajax === false){ //only update these if we are in post, not at ajax that comes from the plugin in preview mode
			/**
			 * Save Custom Meta Things that Modify Skins
			 **/
			if(isset($metas['eg-custom-meta-skin']))
				update_post_meta($post_id, 'eg_settings_custom_meta_skin', $metas['eg-custom-meta-skin']);
			else
				update_post_meta($post_id, 'eg_settings_custom_meta_skin', '');

			if(isset($metas['eg-custom-meta-element']))
				update_post_meta($post_id, 'eg_settings_custom_meta_element', $metas['eg-custom-meta-element']);
			else
				update_post_meta($post_id, 'eg_settings_custom_meta_element', '');

			if(isset($metas['eg-custom-meta-setting']))
				update_post_meta($post_id, 'eg_settings_custom_meta_setting', $metas['eg-custom-meta-setting']);
			else
				update_post_meta($post_id, 'eg_settings_custom_meta_setting', '');

			if(isset($metas['eg-custom-meta-style']))
				update_post_meta($post_id, 'eg_settings_custom_meta_style', $metas['eg-custom-meta-style']);
			else
				update_post_meta($post_id, 'eg_settings_custom_meta_style', '');

			if(isset($metas['eg_custom_meta_216']))
				update_post_meta($post_id, 'eg_custom_meta_216', $metas['eg_custom_meta_216']);

			if(!is_numeric(get_post_meta( $post_id, 'eg_votes_count', $single = true ))){
				update_post_meta($post_id, 'eg_votes_count',0);
			}

		//}

		/**
		 * Save Custom Meta from Custom Meta Submenu
		 */
		$m = new Essential_Grid_Meta();

		$cmetas = $m->get_all_meta(false);

		if(!empty($cmetas)){
			foreach($cmetas as $meta){
				if(isset($metas['eg-'.$meta['handle']])){
					if(is_array($metas['eg-'.$meta['handle']])) $metas['eg-'.$meta['handle']] = json_encode($metas['eg-'.$meta['handle']], JSON_UNESCAPED_UNICODE);

					update_post_meta($post_id, 'eg-'.$meta['handle'], $metas['eg-'.$meta['handle']]);
				}
			}
		}

		do_action('essgrid_custom_meta_box_save', $metas, $post_id, $ajax);

		if($ajax !== false) return true;
	}


	/**
	 * Include wanted page
	 */
	public function display_plugin_admin_page(){
		//set view
		self::$view = self::getGetVar("view");
		if(empty(self::$view))
			self::$view = self::VIEW_OVERVIEW;

        $add_folder = '';
		//require styles by view
		switch(self::$view){
			case self::VIEW_OVERVIEW:
			case self::VIEW_GRID_CREATE:
			case self::VIEW_GRID:
			break;
			case self::VIEW_ITEM_SKIN_EDITOR:
                $add_folder = 'elements/';
            break;
			default: //go back to default
				self::$view = self::VIEW_OVERVIEW;
		}

		try{
			require_once('views/header.php');
			$r = apply_filters('essgrid_display_plugin_admin_page_pre', array('add_folder' => $add_folder, 'view' => self::$view));
			require_once('views/'.$r['add_folder'].$r['view'].'.php');
			$r = apply_filters('essgrid_display_plugin_admin_page_post', array('add_folder' => $add_folder, 'view' => self::$view));
			require_once('views/footer.php');
		}catch (Exception $e){
			echo "<br><br>View ($view) Error: <b>".$e->getMessage()."</b>";
		}

	}


	/**
	 * Include wanted submenu page
	 */
	public function display_plugin_submenu_page_item_skin(){
		do_action('essgrid_display_plugin_submenu_page_item_skin_pre');
		self::display_plugin_submenu('grid-item-skin');
		do_action('essgrid_display_plugin_submenu_page_item_skin_post');
	}



	/**
	 * Include wanted submenu page
	 */
	public function display_plugin_submenu_page_import_export(){
		do_action('essgrid_display_plugin_submenu_page_import_export_pre');
		self::display_plugin_submenu('grid-import-export');
		do_action('essgrid_display_plugin_submenu_page_import_export_post');
	}


	/**
	 * Include wanted submenu page
	 * Since 1.0.6
	 */
	public function display_plugin_submenu_page_widget_areas(){
		do_action('essgrid_display_plugin_submenu_page_widget_areas_pre');
		self::display_plugin_submenu('grid-widget-areas');
		do_action('essgrid_display_plugin_submenu_page_widget_areas_post');
	}


	/**
	 * Include wanted submenu page
	 * Since 2.1.0
	 */
	public function display_plugin_submenu_page_global_settings(){
		do_action('essgrid_display_plugin_submenu_page_global_settings_pre');
		self::display_plugin_submenu('grid-global-settings');
		do_action('essgrid_display_plugin_submenu_page_global_settings_post');
	}


	/**
	 * Include wanted submenu page
	 */
	public function display_plugin_submenu($subMenu){

		if(empty($subMenu))
			$subMenu = self::VIEW_SUB_ITEM_SKIN_OVERVIEW;

		//require styles by view
		switch($subMenu){
			case self::VIEW_SUB_ITEM_SKIN_OVERVIEW:
			case self::VIEW_SUB_CUSTOM_META:
			case self::VIEW_GOOGLE_FONTS:
			case self::VIEW_IMPORT_EXPORT:
			case self::VIEW_GLOBAL_SETTINGS:
			case self::VIEW_WIDGET_AREAS:
			case self::VIEW_SEARCH:
			break;
			default: //go back to default
				$subMenu = self::VIEW_SUB_ITEM_SKIN_OVERVIEW;
		}

		try{
			require_once('views/header.php');
			$subMenu = apply_filters('essgrid_display_plugin_submenu_pre', $subMenu);
			require_once('views/'.$subMenu.'.php');
			$subMenu = apply_filters('essgrid_display_plugin_submenu_post', $subMenu);
			require_once('views/footer.php');
		}catch (Exception $e){
			echo "<br><br>View ($subMenu) Error: <b>".$e->getMessage()."</b>";
		}

	}


	/**
	 * Create Options that we need
	 */
	private function addAllSettings(){
		add_option('tp_eg_role');
		do_action('essgrid_addAllSettings');
	}


	/**
	 * Set Menu Role
	 * @param    string    $role    set the role to this string.
	 */
	private function setMenuRole($role){

		self::$menuRole = apply_filters('essgrid_setMenuRole', $role);

	}


	/**
	 * Get Menu Role
	 * @return    string    $role    the current role
	 */
	public static function getPluginPermission(){
		switch(self::$menuRole){
			case self::ROLE_AUTHOR:
				$role = "edit_published_posts";
			break;
			case self::ROLE_EDITOR:
				$role = "edit_pages";
			break;
			default:
			case self::ROLE_ADMIN:
				$role = "manage_options";
			break;
		}

		return apply_filters('essgrid_getPluginPermission', $role);
	}


	/**
	 * Get Menu Role
	 * @return    string    $role    the current role
	 */
	public static function getPluginPermissionValue(){
		$role = self::$menuRole;

		switch(self::$menuRole){
			case self::ROLE_AUTHOR:
			case self::ROLE_EDITOR:
			case self::ROLE_ADMIN:
				break;
			default:
				$role = self::ROLE_ADMIN;
				break;
		}

		return apply_filters('essgrid_getPluginPermissionValue', $role);
	}


	/**
	 * Save Menu Role
	 * @return    boolean	true
	 */
	private static function savePluginPermission($newPermission){
		$return = true;

		switch($newPermission){
			case self::ROLE_AUTHOR:
			case self::ROLE_EDITOR:
			case self::ROLE_ADMIN:
				break;
			default:
				$return = false;
				break;
		}

		$r = apply_filters('essgrid_getPluginPermissionValue', array('return' => $return, 'newPermission' => $newPermission));

		if($r['return'] === true){
			$permission = update_option('tp_eg_role', $r['newPermission']);
		}

		return $r['return'];
	}


	/**
	 * Allow for VC to use this plugin
	 */
	public static function visual_composer_include(){

		if(!function_exists('vc_map')) return false;

		add_action( 'init', array('Essential_Grid_Admin', 'add_to_VC' ));

		do_action('essgrid_visual_composer_include');
	}


	public static function add_to_VC(){
		global $esg_dev_mode, $wp_version;
		//$essential_grids_arr = Essential_Grid::get_grids_short_vc();
		
		if(strpos($wp_version, '-') !== false){
			$_wpver = explode('-', $wp_version);
			$wp_version = $_wpver[0];
		}
		if($esg_dev_mode){
			wp_enqueue_script('essential-grid-admin-script', plugins_url('assets/js/modules/admin.js', __FILE__ ), array('jquery'), Essential_Grid::VERSION );
		} else {
			wp_enqueue_script('essential-grid-admin-script', plugins_url('assets/js/modules/admin.min.js', __FILE__ ), array('jquery'), Essential_Grid::VERSION );
		}
		wp_enqueue_script('wpdialogs', 'jquery-ui-dialog');
		if(version_compare($wp_version, '5.6', '<')){
			wp_enqueue_script('jquery-ui-sortable');
		}
		wp_enqueue_style('wp-jquery-ui-dialog');

		vc_map( apply_filters('essgrid_add_to_VC', array(
			'name' => __('Essential Grid', EG_TEXTDOMAIN),
			'base' => 'ess_grid',
			'icon' => 'icon-wpb-ess-grid',
			'category' => __('Content', EG_TEXTDOMAIN),
			'show_settings_on_create' => false,
			'js_view' => 'VcEssentialGrid',

			'params' => array(
				array(
					'type' => 'ess_grid_shortcode',
					'heading' => __('Alias', EG_TEXTDOMAIN),
					'param_name' => 'alias',
					'admin_label' => true,
					'value' => ''
				),
				array(
					'type' => 'ess_grid_shortcode',
					'heading' => __('Settings', EG_TEXTDOMAIN),
					'param_name' => 'settings',
					'admin_label' => true,
					'value' => ''
				),
				array(
					'type' => 'ess_grid_shortcode',
					'heading' => __('Layers', EG_TEXTDOMAIN),
					'param_name' => 'layers',
					'admin_label' => true,
					'value' => ''
				),
				array(
					'type' => 'ess_grid_shortcode',
					'heading' => __('Special', EG_TEXTDOMAIN),
					'param_name' => 'special',
					'admin_label' => true,
					'value' => ''
				)
			)
		)) );

		if(version_compare(WPB_VC_VERSION, '4.4', '>=')){ //use if 4.4 or newer
			vc_add_shortcode_param('ess_grid_shortcode', array('Essential_Grid_Admin', 'ess_grid_shortcode_settings_field'));
		}else{ //use if older than 4.4
			add_shortcode_param('ess_grid_shortcode', array('Essential_Grid_Admin', 'ess_grid_shortcode_settings_field'));
		}

		do_action('essgrid_add_to_VC');
	}


	/**
	 * The Dialog for Visual Composer
	 * @since: 1.2.0
	 */
	public static function ess_grid_shortcode_settings_field($settings, $value){

		$dependency = vc_generate_dependencies_attributes($settings);

		return apply_filters('essgrid_ess_grid_shortcode_settings_field', '<div class="ess_grid_shortcode_block">'
			.'<input id="esg-vc-input-'.$settings['param_name'].'" name="'.$settings['param_name']
			.'" class="wpb_vc_param_value wpb-textinput '
			.$settings['param_name'].' '.$settings['type'].'_field" type="text" value="'
			.$value.'" ' . $dependency . '/>'
			.'</div>', $settings, $value);

	}


	/**
	 * Update/Create Grid
	 * @return    boolean	true
	 */
	public static function update_create_grid($data){
		global $wpdb;

		$data = apply_filters('essgrid_update_create_grid', $data);

		if(!isset($data['name']) || strlen($data['name']) < 2) return __('Title needs to have at least 2 characters', EG_TEXTDOMAIN);
		if(!isset($data['handle']) || strlen($data['handle']) < 2) return __('Alias needs to have at least 2 characters', EG_TEXTDOMAIN);
		if(!isset($data['params']) || empty($data['params'])) return __('No setting informations received!', EG_TEXTDOMAIN);

		if($data['postparams']['source-type'] == 'custom'){
			if(!isset($data['layers']) || empty($data['layers'])) return __('Please add at least one element in Custom Grid mode', EG_TEXTDOMAIN);
		}elseif($data['postparams']['source-type'] == 'post'){
			if(!isset($data['postparams']['post_types']) || empty($data['postparams']['post_types'])) return __('Please select a Post Type', EG_TEXTDOMAIN);
		}elseif(!isset($data['postparams']['source-type'])){
			return __('Invalid data received, this could be the cause of server limitations. If you use a custom grid, please lower the number of entries.', EG_TEXTDOMAIN);
		}

		if(!isset($data['layers']) || empty($data['layers'])) $data['layers'] = array(); //this is only set if we are source-type custom

		/*if($data['postparams']['source-type'] == 'post'){
			if(isset($data['postparams']['post_types'])){
				$types = explode(',', $data['postparams']['post_types']);
				if(!in_array('page', (array) $types)){
					if(!isset($data['postparams']['post_category']) || empty($data['postparams']['post_category'])) return __('Please select a Post Category', EG_TEXTDOMAIN);
				}
			}
		}*/

		$table_name = $wpdb->prefix . Essential_Grid::TABLE_GRID;

		if(isset($data['id']) && intval($data['id']) > 0){ //update
			//check if entry with handle exists, because this is unique
			$grid = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE handle = %s AND id != %s ", $data['handle'], $data['id']), ARRAY_A);
			if(!empty($grid)){
				return __('Ess. Grid with chosen alias already exists, please choose a different alias', EG_TEXTDOMAIN);
			}

			//check if exists, if yes, update
			$entry = Essential_Grid::get_essential_grid_by_id($data['id']);
			if($entry !== false){
				$response = $wpdb->update($table_name,
											apply_filters('essgrid_update_create_grid_update', array(
												'name' => $data['name'],
												'handle' => $data['handle'],
												'postparams' => json_encode($data['postparams']),
												'params' => json_encode($data['params']),
												'layers' => json_encode($data['layers']),
												'last_modified' => date('Y-m-d H:i:s')
												), $data), array('id' => $data['id']));

				if($response === false) return __('Ess. Grid could not be changed', EG_TEXTDOMAIN);

				return true;
			}
		}

		//check if entry with handle exists, because this is unique
		$grid = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE handle = %s", $data['handle']), ARRAY_A);
		if(!empty($grid)){
			return __('Ess. Grid with chosen alias already exists, please choose a different alias', EG_TEXTDOMAIN);
		}

		//insert if function did not return yet
		$response = $wpdb->insert($table_name, apply_filters('essgrid_update_create_grid_insert', array('name' => $data['name'], 'handle' => $data['handle'], 'postparams' => json_encode($data['postparams']), 'params' => json_encode($data['params']), 'layers' => json_encode($data['layers']), 'last_modified' => date('Y-m-d H:i:s')), $data));

		if($response === false) return false;

		return true;
	}


	/**
	 * Delete Grid
	 * @return    boolean	true
	 */
	private static function delete_grid_by_id($data){
		global $wpdb;

		$data = apply_filters('essgrid_delete_grid_by_id', $data);

		if(!isset($data['id']) || intval($data['id']) == 0) return __('Invalid ID', EG_TEXTDOMAIN);

		$table_name = $wpdb->prefix . Essential_Grid::TABLE_GRID;

		$response = $wpdb->delete($table_name, array('id' => $data['id']));

		do_action('essgrid_delete_grid_by_id', $response, $data);

		if($response === false) return __('Ess. Grid could not be deleted', EG_TEXTDOMAIN);

		return true;
	}


	/**
	 * Duplicate Grid
	 * @return    boolean	true
	 */
	private static function duplicate_grid_by_id($data){
		global $wpdb;

		$data = apply_filters('essgrid_duplicate_grid_by_id', $data);

		if(!isset($data['id']) || intval($data['id']) == 0) return __('Invalid ID', EG_TEXTDOMAIN);

		$table_name = $wpdb->prefix . Essential_Grid::TABLE_GRID;

		//check if ID exists
		$duplicate = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %s", $data['id']), ARRAY_A);

		if(empty($duplicate))
			return __('Ess. Grid could not be duplicated', EG_TEXTDOMAIN);

		//get handle that does not exist by latest ID in table and search until handle does not exist
		$result = $wpdb->get_row("SELECT * FROM $table_name ORDER BY id", ARRAY_A);

		if(empty($result))
			return __('Ess. Grid could not be duplicated', EG_TEXTDOMAIN);

		//check if handle Grid ID + n does exist and get until it does not
		$i = $result['id'] - 1;

		do {
			$i++;
			$result = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE handle = %s", 'grid-'.$i), ARRAY_A);

		} while(!empty($result));

		//now add new Entry
		unset($duplicate['id']);
		$duplicate['name'] = 'Copy of '.$duplicate['name'].' '.$i;
		$duplicate['handle'] = 'grid-'.$i;

		$response = $wpdb->insert($table_name, $duplicate);

		if($response === false) return __('Ess. Grid could not be duplicated', EG_TEXTDOMAIN);

		do_action('essgrid_duplicate_grid_by_id', $data, $duplicate, $response);

		return true;
	}


	/**
	 * Toggle Favorite State of Grid
	 */
	public static function toggle_favorite_by_id($id){
		$id = apply_filters('essgrid_toggle_favorite_by_id', $id);

		$id = intval($id);
		if($id === 0) return false;

		global $wpdb;

		$table_name = $wpdb->prefix . Essential_Grid::TABLE_GRID;

		//check if ID exists
		$grid = $wpdb->get_row($wpdb->prepare("SELECT settings FROM $table_name WHERE id = %s", $id), ARRAY_A);

		if(empty($grid))
			return __('Grid not found', EG_TEXTDOMAIN);

		$settings = json_decode($grid['settings'], true);

		if(!isset($settings['favorite']) || $settings['favorite'] == 'false'){
			$settings['favorite'] = 'true';
		}else{
			$settings['favorite'] = 'false';
		}

		$response = $wpdb->update($table_name,
								apply_filters('essgrid_toggle_favorite_by_id_update', array(
									'settings' => json_encode($settings)
									), $id), array('id' => $id));

		if($response === false) return __('Ess. Grid could not be changed', EG_TEXTDOMAIN);

		do_action('essgrid_toggle_favorite_by_id', $id, $response);

		return true;
	}


	/**
	 * Validate Purchase
	 */
	public static function check_purchase_verification($data){
		global $wp_version;

		$esglb = new Essential_Grid_LoadBalancer();
		$url = $esglb->get_url('updates');

		$response = wp_remote_post($url.'/activate.php', array(
			'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
			'body' => array(
				'code' => urlencode($data['code']),
				'product' => urlencode('essential-grid')
			)
		));

		$response_code = wp_remote_retrieve_response_code( $response );
		$version_info = wp_remote_retrieve_body( $response );

		if($response_code != 200 || is_wp_error($version_info)){
			return false;
		}

		if($version_info == 'valid'){
			update_option('tp_eg_valid', 'true');
			update_option('tp_eg_code', $data['code']);

			return true;
		}elseif($version_info == 'exist'){
			return __('Purchase Code already registered!', EG_TEXTDOMAIN);
		}else{
			return __('Purchase Code is not valid!', EG_TEXTDOMAIN);
		}

	}


	/**
	 * Handle Ajax Requests
	 */
	public static function do_purchase_deactivation($data){
		global $wp_version;

		$esglb = new Essential_Grid_LoadBalancer();
		$url = $esglb->get_url('updates');

		$code = get_option('tp_eg_code', '');

		$response = wp_remote_post($url.'/deactivate.php', array(
			'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
			'body' => array(
				'code' => urlencode($code),
				'product' => urlencode('essential-grid')
			)
		));

		$response_code = wp_remote_retrieve_response_code( $response );
		$version_info = wp_remote_retrieve_body( $response );

		if( $response_code != 200 || is_wp_error( $version_info ) ){
			return false;
		}

		if($version_info == 'valid'){
			update_option('tp_eg_valid', 'false');
			update_option('tp_eg_code', '');

			return true;
		}else{
			return false;
		}

	}


	/**
	 * Handle Ajax Requests
	 */
	public static function on_ajax_action(){
		try{
			$token = self::getPostVar('token', false);

			//verify the token
			$isVerified = wp_verify_nonce($token, 'Essential_Grid_actions');

			$error = false;
			if($isVerified){
				$data = self::getPostVar("data", false);
				switch(self::getPostVar("client_action", false)){
					case 'save_google_fonts':
						$f = new ThemePunch_Fonts();

						$result = $f->save_fonts($data);

						if($result === true){
							Essential_Grid::ajaxResponseSuccess(__("Font successfully saved!", EG_TEXTDOMAIN), array('data' => $result));
						}else{
							Essential_Grid::ajaxResponseError($result, false);
						}
					break;
					case 'add_google_fonts':
						$f = new ThemePunch_Fonts();

						$result = $f->add_new_font($data);

						if($result === true){
							Essential_Grid::ajaxResponseSuccess(__("Font successfully created!", EG_TEXTDOMAIN), array('data' => $result));
						}else{
							Essential_Grid::ajaxResponseError($result, false);
						}
					break;
					case 'remove_google_fonts':
						if(!isset($data['handle'])) Essential_Grid::ajaxResponseError(__('Font not found', EG_TEXTDOMAIN), false);

						$f = new ThemePunch_Fonts();

						$result = $f->remove_font_by_handle($data['handle']);

						if($result === true){
							Essential_Grid::ajaxResponseSuccess(__("Font successfully removed!", EG_TEXTDOMAIN), array('data' => $result));
						}else{
							Essential_Grid::ajaxResponseError($result, false);
						}
					break;
					case 'edit_google_fonts':
						if(!isset($data['handle'])) Essential_Grid::ajaxResponseError(__('No handle given', EG_TEXTDOMAIN), false);
						if(!isset($data['url'])) Essential_Grid::ajaxResponseError(__('No parameters given', EG_TEXTDOMAIN), false);

						$f = new ThemePunch_Fonts();

						$result = $f->edit_font_by_handle($data);

						if($result === true){
							Essential_Grid::ajaxResponseSuccess(__("Font successfully changed!", EG_TEXTDOMAIN), array('data' => $result));
						}else{
							Essential_Grid::ajaxResponseError($result, false);
						}
					break;
					case 'add_widget_area':

						$wa = new Essential_Grid_Widget_Areas();

						$result = $wa->add_new_sidebar($data);

						if($result === true){
							Essential_Grid::ajaxResponseSuccess(__("Widget Area successfully created!", EG_TEXTDOMAIN), array('data' => $result, 'is_redirect' => true, 'redirect_url' => self::getSubViewUrl(Essential_Grid_Admin::VIEW_SUB_WIDGET_AREA_AJAX)));
						}else{
							Essential_Grid::ajaxResponseError($result, false);
						}
					break;
					case 'edit_widget_area':
						if(!isset($data['handle'])) Essential_Grid::ajaxResponseError(__('No handle given', EG_TEXTDOMAIN), false);
						if(!isset($data['name'])) Essential_Grid::ajaxResponseError(__('No name given', EG_TEXTDOMAIN), false);

						$wa = new Essential_Grid_Widget_Areas();

						$result = $wa->edit_widget_area_by_handle($data);

						if($result === true){
							Essential_Grid::ajaxResponseSuccess(__("Widget Area successfully changed!", EG_TEXTDOMAIN), array('data' => $result));
						}else{
							Essential_Grid::ajaxResponseError($result, false);
						}
					break;
					case 'remove_widget_area':
						if(!isset($data['handle'])) Essential_Grid::ajaxResponseError(__('Widget Area not found', EG_TEXTDOMAIN), false);

						$wa = new Essential_Grid_Widget_Areas();

						$result = $wa->remove_widget_area_by_handle($data['handle']);

						if($result === true){
							Essential_Grid::ajaxResponseSuccess(__("Widget Area successfully removed!", EG_TEXTDOMAIN), array('data' => $result));
						}else{
							Essential_Grid::ajaxResponseError($result, false);
						}
					break;
					case 'get_preview_html_markup':

						//add wpml transient
						$lang_code = '';
						if(Essential_Grid_Wpml::is_wpml_exists()){
							$lang_code = Essential_Grid_Wpml::get_current_lang_code();
						}

						if(isset($data['id'])){
							delete_transient( 'ess_grid_trans_query_'.$data['id'].$lang_code ); //delete cache
						}

						$result = Essential_Grid_Base::output_demo_skin_html($data);

						if(isset($result['error'])){
							Essential_Grid::ajaxResponseData($result);
						}else{
							Essential_Grid::ajaxResponseData(array("data"=>array('html' => $result['html'], 'preview' => @$result['preview'])));
						}

					break;
					case 'save_color_preset':
						$presets = (isset($data['presets'])) ? $data['presets'] : array();
						$color_presets = ESGColorpicker::save_color_presets($presets);
						Essential_Grid::ajaxResponseData(array('presets' => $color_presets));
					break;
					/* //TP: CHUNK
					case 'get_preview_html_markup_chunk': //only for custom grid
						$grid = new Essential_Grid();
						$grid->init_by_data($data);

						$html = '';

						if($grid->is_custom_grid()){
							ob_start();
							$grid->output_by_custom('custom', true);
							$html = ob_get_contents();
							ob_clean();
							ob_end_clean();
						}
						$order_id = self::getPostVar("order_id", false);

						Essential_Grid::ajaxResponseData(array("data"=>array('preview' => $html, 'order_id' => $order_id)));

					break; */
					case 'save_search_settings':

						if(!empty($data)){
							update_option('esg-search-settings', $data);
						}

						Essential_Grid::ajaxResponseSuccess(__("Search Settings succesfully saved!", EG_TEXTDOMAIN));

					break;
					case 'update_general_settings':
						$result = self::savePluginPermission($data['permission']);

						$cur_query = get_option('tp_eg_query_type', 'wp_query');

						update_option('tp_eg_output_protection', @$data['protection']);
						update_option('tp_eg_tooltips', @$data['tooltips']);
						update_option('tp_eg_wait_for_fonts', @$data['wait_for_fonts']);
						update_option('tp_eg_js_to_footer', @$data['js_to_footer']);
						update_option('tp_eg_use_cache', @$data['use_cache']);
						update_option('tp_eg_overwrite_gallery', @$data['overwrite_gallery']);
						update_option('tp_eg_query_type', @$data['query_type']);
						update_option('tp_eg_use_lightbox', @$data['use_lightbox']);
						update_option('tp_eg_enable_log', @$data['enable_log']);
						update_option('tp_eg_enable_post_meta', @$data['enable_post_meta']);
						update_option('tp_eg_enable_custom_post_type', @$data['enable_custom_post_type']);
						update_option('tp_eg_enable_media_filter', @$data['enable_media_filter']);
						update_option('tp_eg_global_default_img', @$data['global_default_img']);
						update_option('tp_eg_no_filter_match_message', @$data['no_filter_match_message']);
						update_option('tp_eg_global_enable_pe7',@$data['enable_pe7']);
						update_option('tp_eg_global_enable_fontello', @$data['enable_fontello']);
						update_option('tp_eg_global_enable_font_awesome', @$data['enable_font_awesome']);

						update_option('tp_eg_enable_youtube_nocookie', @$data['enable_youtube_nocookie']);


						if($cur_query !== $data['query_type']){ //delete cache
							$lang = array();

							if(Essential_Grid_Wpml::is_wpml_exists()){
								$lang = icl_get_languages();
							}

							$grids = Essential_Grid::get_essential_grids();
							if(!empty($grids)){
								foreach($grids as $grid){
									if(!empty($lang)){
										foreach($lang as $code => $val){
											delete_transient( 'ess_grid_trans_query_'.$grid->id.$val['language_code'] );
											delete_transient( 'ess_grid_trans_full_grid_'.$grid->id.$val['language_code'] );
										}
									}else{
										delete_transient( 'ess_grid_trans_query_'.$grid->id );
										delete_transient( 'ess_grid_trans_full_grid_'.$grid->id );
									}
								}
							}
						}

						if($result !== true)
							$error = __("Global Settings did not change!", EG_TEXTDOMAIN);
						else
							Essential_Grid::ajaxResponseSuccess(__("Global Settings succesfully saved!", EG_TEXTDOMAIN), $result);

					break;
					case 'dismiss_dynamic_notice':
						if(trim($data['id']) !== 'DISCARD'){
							$notices_discarded = get_option('essential-notices-dc', array());
							$notices_discarded[] = esc_attr(trim($data['id']));
							update_option('essential-notices-dc', $notices_discarded);
						}else{
							update_option('essential-deact-notice', false);
						}

						Essential_Grid::ajaxResponseSuccess(__(".",EG_TEXTDOMAIN));
					break;
					case 'update_create_grid':
						$result = self::update_create_grid($data);

						if($result !== true){
							$error = $result;
						}else{
							$lang = array();

							if(Essential_Grid_Wpml::is_wpml_exists()){
								$lang = icl_get_languages();
							}

							if(isset($data['id']) && intval($data['id']) > 0){
								if(!empty($lang)){
									foreach($lang as $code => $val){
										delete_transient( 'ess_grid_trans_query_'.$data['id'].$val['language_code'] ); //delete cache
										delete_transient( 'ess_grid_trans_full_grid_'.$data['id'].$val['language_code'] ); //delete cache
									}
								}else{
									delete_transient( 'ess_grid_trans_query_'.$data['id'] ); //delete cache
									delete_transient( 'ess_grid_trans_full_grid_'.$data['id'] ); //delete cache
								}
								Essential_Grid::ajaxResponseSuccess(__("Grid successfully saved/changed!", EG_TEXTDOMAIN), $result);
							}else{
								$grid_id = false;
								$esg_alias = $data['handle'];
								$grids = Essential_Grid::get_essential_grids();

								foreach($grids as $grid){

									$alias = $grid -> handle;
									if($alias === $esg_alias){
										$grid_id = $grid -> id;
										break;
									}
								}

								Essential_Grid::ajaxResponseSuccess(__("Grid successfully saved/changed!", EG_TEXTDOMAIN), array('data' => $result, 'is_redirect' => false, 'redirect_url' => self::getViewUrl(Essential_Grid_Admin::VIEW_OVERVIEW), 'grid_id' => $grid_id));
							}
						}
					break;
					case 'delete_grid':
						$result = self::delete_grid_by_id($data);
						if($result !== true)
							$error = $result;
						else
							Essential_Grid::ajaxResponseSuccess(__("Grid deleted", EG_TEXTDOMAIN), array('data' => $result,'redirect_url' => self::getViewUrl(Essential_Grid_Admin::VIEW_OVERVIEW) ));

					break;
					case 'duplicate_grid':
						$result = self::duplicate_grid_by_id($data);
						if($result !== true)
							$error = $result;
						else
							Essential_Grid::ajaxResponseSuccess(__("Grid duplicated", EG_TEXTDOMAIN), array('data' => $result, 'is_redirect' => true, 'redirect_url' => self::getViewUrl(Essential_Grid_Admin::VIEW_OVERVIEW)));

					break;
					case 'update_create_item_skin':
						$result = Essential_Grid_Item_Skin::update_save_item_skin($data);

						if($result !== true){
							$error = $result;
						}else{
							if(isset($data['id']) && intval($data['id']) > 0)
							  Essential_Grid::ajaxResponseSuccess(__("Item Skin changed", EG_TEXTDOMAIN), array('data' => $result));
							else
							  Essential_Grid::ajaxResponseSuccess(__("Item Skin created/changed", EG_TEXTDOMAIN), array('data' => $result, 'is_redirect' => true, 'redirect_url' => self::getViewUrl("","",'essential-'.Essential_Grid_Admin::VIEW_SUB_ITEM_SKIN_OVERVIEW)));

						}
					break;
					case 'update_custom_css':

						if(isset($data['global_css'])){

							Essential_Grid_Global_Css::set_global_css_styles($data['global_css']);
							Essential_Grid::ajaxResponseSuccess(__("CSS saved!", EG_TEXTDOMAIN), '');

						}else{
							$error = __("No CSS Received", EG_TEXTDOMAIN);
						}
					break;
					case 'delete_item_skin':
						$result = Essential_Grid_Item_Skin::delete_item_skin_by_id($data);
						if($result !== true)
							$error = $result;
						else
							Essential_Grid::ajaxResponseSuccess(__("Item Skin deleted", EG_TEXTDOMAIN), array('data' => $result));

					break;
					case 'duplicate_item_skin':
						$result = Essential_Grid_Item_Skin::duplicate_item_skin_by_id($data);
						if($result !== true)
							$error = $result;
						else
							Essential_Grid::ajaxResponseSuccess(__("Item Skin duplicated", EG_TEXTDOMAIN), array('data' => $result, 'is_redirect' => true, 'redirect_url' => self::getViewUrl("","",'essential-'.Essential_Grid_Admin::VIEW_SUB_ITEM_SKIN_OVERVIEW)));

					break;
					case 'star_item_skin':
						$result = Essential_Grid_Item_Skin::star_item_skin_by_id($data);
						if($result !== true){
							$error = $result;
						}else{
							Essential_Grid::ajaxResponseSuccess(__("Favorite Changed", EG_TEXTDOMAIN), array('data' => $result));
						}
					break;
					case 'update_create_item_element':
						$result = Essential_Grid_Item_Element::update_create_essential_item_element($data);
						if($result !== true){
							$error = $result;
						}else{
							Essential_Grid::ajaxResponseSuccess(__("Item Element created/changed", EG_TEXTDOMAIN), array('data' => $result));
						}
					break;
					case 'check_item_element_existence':
						$result = Essential_Grid_Item_Element::check_existence_by_handle(@$data['name']);
						if($result === false){
							Essential_Grid::ajaxResponseData(array("data"=>array('existence'=>'false')));
						}elseif($result === true){
							Essential_Grid::ajaxResponseData(array("data"=>array('existence'=>'true')));
						}else{
							Essential_Grid::ajaxResponseData(array("data"=>array('existence'=>$result)));
						}

					break;
					case 'get_predefined_elements':
						$elements = Essential_Grid_Item_Element::getElementsForJavascript();

						$html_elements = Essential_Grid_Item_Element::prepareDefaultElementsForEditor();
						$html_elements.= Essential_Grid_Item_Element::prepareTextElementsForEditor();

						Essential_Grid::ajaxResponseData(array("data"=>array('elements'=>$elements,'html'=>$html_elements)));

					break;
					case 'delete_predefined_elements':
						$result = Essential_Grid_Item_Element::delete_element_by_handle($data);

						if($result !== true){
							$error = $result;
						}else{
							Essential_Grid::ajaxResponseSuccess(__("Item Element successfully deleted", EG_TEXTDOMAIN), array('data' => $result));
						}
					break;
					case 'update_create_navigation_skin_css':
						$nav = new Essential_Grid_Navigation();

						$result = $nav->update_create_navigation_skin_css($data);

						if($result !== true){
							$error = $result;
						}else{
							$base = new Essential_Grid_Base();
							$skin_css = Essential_Grid_Navigation::output_navigation_skins();
							$skins = Essential_Grid_Navigation::get_essential_navigation_skins();
							$select = '';
							foreach($skins as $skin){
								$select .= '<option value="'. $skin['handle'] .'">'. $skin['name'].'</option>'."\n";
							}

							if(isset($data['sid']) && intval($data['sid']) > 0)
								Essential_Grid::ajaxResponseSuccess(__("Navigation Skin successfully changed!", EG_TEXTDOMAIN), array('css' => $skin_css, 'select' => $select, 'default_skins' => $skins));
							else
								Essential_Grid::ajaxResponseSuccess(__("Navigation Skin successfully created", EG_TEXTDOMAIN), array('css' => $skin_css, 'select' => $select, 'default_skins' => $skins));

						}
					break;
					case 'delete_navigation_skin_css':
						$nav = new Essential_Grid_Navigation();

						$result = $nav->delete_navigation_skin_css($data);

						if($result !== true){
							$error = $result;
						}else{
							$base = new Essential_Grid_Base();
							$skin_css = Essential_Grid_Navigation::output_navigation_skins();
							$skins = Essential_Grid_Navigation::get_essential_navigation_skins();
							$select = '';
							foreach($skins as $skin){
								$select .= '<option value="'. $skin['handle'] .'">'. $skin['name'].'</option>'."\n";
							}

							Essential_Grid::ajaxResponseSuccess(__("Navigation Skin successfully deleted!", EG_TEXTDOMAIN), array('css' => $skin_css, 'select' => $select, 'default_skins' => $skins));
						}
					break;
					case 'get_post_meta_html_for_editor':
						if(!isset($data['post_id']) || intval($data['post_id']) == 0){
							Essential_Grid::ajaxResponseError(__('No Post ID/Wrong Post ID!', EG_TEXTDOMAIN), false);
							exit();
						}
						if(!isset($data['grid_id']) || intval($data['grid_id']) == 0){
							Essential_Grid::ajaxResponseError(__('Please save the grid first to use this feature!', EG_TEXTDOMAIN), false);
							exit();
						}

						$post = get_post($data['post_id']);
						$disable_advanced = true; //nessecary, so that only normal things can be changed in preview mode
						if(!empty($post)){
							$grid_id = $data['grid_id'];
							ob_start();
							require('views/elements/grid-meta-box.php');
							$content = ob_get_contents();
							ob_clean();
							ob_end_clean();

							Essential_Grid::ajaxResponseData(array("data"=>array('html'=>$content)));
						}else{
							Essential_Grid::ajaxResponseError(__('Post not found!', EG_TEXTDOMAIN), false);
							exit();
						}

					break;
					case 'update_post_meta_through_editor':
						$result = false;
						
						if(!empty($data['metas'])){
							foreach($data['metas'] as $meta){
								if(!isset($meta['post_id']) || intval($meta['post_id']) == 0){
									continue;
									Essential_Grid::ajaxResponseError(__('No Post ID/Wrong Post ID!', EG_TEXTDOMAIN), false);
									exit();
								}

								if(!isset($meta['grid_id']) || intval($meta['grid_id']) == 0){
									continue;
									Essential_Grid::ajaxResponseError(__('Please save the grid first to use this feature!', EG_TEXTDOMAIN), false);
									exit();
								}

								//set the cobbles setting to the post
								$cobbles = json_decode(get_post_meta($meta['post_id'], 'eg_cobbles', true), true);
								$cobbles[$meta['grid_id']]['cobbles'] = $meta['eg_cobbles_size'];
								$cobbles = json_encode($cobbles);
								update_post_meta($meta['post_id'], 'eg_cobbles', $cobbles);


								//set the use_skin setting to the post
								$use_skin = json_decode(get_post_meta($meta['post_id'], 'eg_use_skin', true), true);
								$use_skin[$meta['grid_id']]['use-skin'] = $meta['eg_use_skin'];
								$use_skin = json_encode($use_skin);
								update_post_meta($meta['post_id'], 'eg_use_skin', $use_skin);


								$result = self::custom_meta_box_save($meta['post_id'], $meta, true);

								self::check_for_transient_deletion($meta['post_id']);
							}
						}
						
						if($result === true){
							Essential_Grid::ajaxResponseSuccess(__("Post Meta saved!", EG_TEXTDOMAIN), array());
						}else{
							Essential_Grid::ajaxResponseError(__('Post not found!', EG_TEXTDOMAIN), false);
							exit();
						}

					break;
					case 'trigger_post_meta_visibility':
						if(!isset($data['post_id']) || intval($data['post_id']) == 0){
							Essential_Grid::ajaxResponseError(__('No Post ID/Wrong Post ID!', EG_TEXTDOMAIN), false);
							exit();
						}
						if(!isset($data['grid_id']) || intval($data['grid_id']) == 0){
							Essential_Grid::ajaxResponseError(__('Please save the grid first to use this feature!', EG_TEXTDOMAIN), false);
							exit();
						}

						$visibility = json_decode(get_post_meta($data['post_id'], 'eg_visibility', true), true);

						$found = false;

						if(!empty($visibility) && is_array($visibility)){
							foreach($visibility as $grid => $setting){
								if($grid == $data['grid_id']){
									if($setting == false)
										$visibility[$grid] = true;
									else
										$visibility[$grid] = false;

									$found = true;
									break;
								}
							}
						}

						if(!$found){
							$visibility[$data['grid_id']] = false;
						}

						$visibility = json_encode($visibility);

						update_post_meta($data['post_id'], 'eg_visibility', $visibility);

						self::check_for_transient_deletion($data['post_id']);

						Essential_Grid::ajaxResponseSuccess(__("Visibility of Post for this Grid changed!", EG_TEXTDOMAIN), array());

					break;
					case 'get_image_by_id':
						if(!isset($data['img_id']) || intval($data['img_id']) == 0){
							$error = __('Wrong Image ID given', EG_TEXTDOMAIN);
						}else{
							$img = wp_get_attachment_image_src($data['img_id'], 'full');
							if($img !== false){
								Essential_Grid::ajaxResponseSuccess('', array('url' => $img[0]));
							}else{
								$error = __('Image with given ID does not exist', EG_TEXTDOMAIN);
							}
						}
					break;
					case 'activate_purchase_code':
						$result = false;

						if(!empty($data['code'])){
							$result = Essential_Grid_Admin::check_purchase_verification($data);
						}else{
							$error = __('The API key, the Purchase Code and the Username need to be set!', EG_TEXTDOMAIN);
						}

						if($result === true){
							Essential_Grid::ajaxResponseSuccess(__('Purchase Code Successfully Activated', EG_TEXTDOMAIN), array('data' => $result, 'is_redirect' => true, 'redirect_url' => self::getViewUrl("","",'essential-'.Essential_Grid_Admin::VIEW_START)));
						}else{
							if($result !== false)
								$error = $result;
							else
								$error = __('Purchase Code is invalid', EG_TEXTDOMAIN);

							Essential_Grid::ajaxResponseError($error, false);
							exit();
						}
					break;
					case 'deactivate_purchase_code':
						$result = Essential_Grid_Admin::do_purchase_deactivation($data);

						if($result === true){
							Essential_Grid::ajaxResponseSuccess(__('Successfully removed validation', EG_TEXTDOMAIN), array('data' => $result, 'is_redirect' => true, 'redirect_url' => self::getViewUrl("","",'essential-'.Essential_Grid_Admin::VIEW_START)));
						}else{
							if($result !== false)
								$error = $result;
							else
								$error = __('Could not remove Validation!', EG_TEXTDOMAIN);

							Essential_Grid::ajaxResponseError($error, false);
							exit();
						}
					break;
					case 'dismiss_notice':
						update_option('tp_eg_valid-notice', 'false');
						Essential_Grid::ajaxResponseSuccess('.');
					break;
					case 'import_default_post_data':
						try{
							require(EG_PLUGIN_PATH.'includes/assets/default-posts.php');
							require(EG_PLUGIN_PATH.'includes/assets/default-grids-meta-fonts.php');

							if(isset($json_tax)){
								$import_tax = new PunchPost;
								$import_tax->import_taxonomies($json_tax);
							}

							//insert meta, grids & punchfonts
							$im = new Essential_Grid_Import();
							if(isset($tp_grid_meta_fonts)){
								$tp_grid_meta_fonts = json_decode($tp_grid_meta_fonts, true);

								/*
								$grids = @$tp_grid_meta_fonts['grids'];
								if(!empty($grids) && is_array($grids)){
									$grids_imported = $im->import_grids($grids);
								}
								*/

								$custom_metas = @$tp_grid_meta_fonts['custom-meta'];
								if(!empty($custom_metas) && is_array($custom_metas)){
									$custom_metas_imported = $im->import_custom_meta($custom_metas);
								}

								$custom_fonts = @$tp_grid_meta_fonts['punch-fonts'];
								if(!empty($custom_fonts) && is_array($custom_fonts)){
									$custom_fonts_imported = $im->import_punch_fonts($custom_fonts);
								}
							}

							if(isset($json_posts)){
								$import = new PunchPort;
								$import->set_tp_import_posts($json_posts);
								$import->import_custom_posts();
							}

							Essential_Grid::ajaxResponseSuccess(__('Demo data successfully imported', EG_TEXTDOMAIN), array());

						}catch(Exception $d){
							$error = __('Something was wrong, please contact the developer', EG_TEXTDOMAIN);
						}
					break;
					case 'import_default_grid_data_210':
						try{
							require(EG_PLUGIN_PATH.'includes/assets/default-grids-210.php');

							$im = new Essential_Grid_Import();

							if(!empty($grids_210) && is_array($grids_210)){
								$grids_imported = $im->import_grids($grids_210);
							}

							Essential_Grid::ajaxResponseSuccess(__('Demo data successfully imported', EG_TEXTDOMAIN), array());

						}catch(Exception $d){
							$error = __('Something was wrong, please contact the developer', EG_TEXTDOMAIN);
						}
					break;
					case 'export_data':
						$export_grids = self::getPostVar('export-grids-id', false);
						$export_skins = self::getPostVar('export-skins-id', false);
						$export_elements = self::getPostVar('export-elements-id', false);
						$export_navigation_skins = self::getPostVar('export-navigation-skins-id', false);
						$export_global_styles = self::getPostVar('export-global-styles', false);
						$export_custom_meta = self::getPostVar('export-custom-meta-handle', false);
						$export_punch_fonts = self::getPostVar('export-punch-fonts-handle', false);

						header( 'Content-Type: text/json' );
						header( 'Content-Disposition: attachment;filename=ess_grid.json');
						ob_start();

						$export = array();

						$ex = new Essential_Grid_Export();

						//export Grids
						if(!empty($export_grids))
							$export['grids'] = $ex->export_grids($export_grids);

						//export Skins
						if(!empty($export_skins))
							$export['skins'] = $ex->export_skins($export_skins);

						//export Elements
						if(!empty($export_elements))
							$export['elements'] = $ex->export_elements($export_elements);

						//export Navigation Skins
						if(!empty($export_navigation_skins))
							$export['navigation-skins'] = $ex->export_navigation_skins($export_navigation_skins);

						//export Custom Meta
						if(!empty($export_custom_meta))
							$export['custom-meta'] = $ex->export_custom_meta($export_custom_meta);

						//export Punch Fonts
						if(!empty($export_punch_fonts))
							$export['punch-fonts'] = $ex->export_punch_fonts($export_punch_fonts);

						//export Global Styles
						if($export_global_styles == 'on')
							$export['global-css'] = $ex->export_global_styles($export_global_styles);


						echo json_encode($export);

						$content = ob_get_contents();
						ob_clean();
						ob_end_clean();

						echo $content;

						exit();
					break;
					case 'import_data':
						if(!isset($data['imports']) || empty($data['imports'])){
							Essential_Grid::ajaxResponseError(__('No data for import selected', EG_TEXTDOMAIN), false);
							exit();
						}
						try{
							$im = new Essential_Grid_Import();

							$temp_d = @$data['imports'];
							unset($temp_d['data-grids']);
							unset($temp_d['data-skins']);
							unset($temp_d['data-elements']);
							unset($temp_d['data-navigation-skins']);
							unset($temp_d['data-global-css']);

							$im->set_overwrite_data($temp_d); //set overwrite data global to class

							$skins = @$data['imports']['data-skins'];
							if(!empty($skins) && is_array($skins)){
								foreach($skins as $key => $skin){
									$tskin = json_decode(stripslashes($skin), true);
									if(empty($tskin)) $tskin = json_decode($skin, true);

									if(class_exists('Essential_Grid_Plugin_Update')){
										$tskin = Essential_Grid_Plugin_Update::process_update_216($tskin, true);
									}

									$skins[$key] = $tskin;
								}
								if(!empty($skins)){
									$skins_ids = @$data['imports']['import-skins-id'];
									$skins_imported = $im->import_skins($skins, $skins_ids);
								}
							}

							$navigation_skins = @$data['imports']['data-navigation-skins'];
							if(!empty($navigation_skins) && is_array($navigation_skins)){
								foreach($navigation_skins as $key => $navigation_skin){
									$tnavigation_skin = json_decode($navigation_skin, true);
									if(empty($tnavigation_skin)) $tnavigation_skin = json_decode($navigation_skin, true);

									$navigation_skins[$key] = $tnavigation_skin;
								}
								if(!empty($navigation_skins)){
									$navigation_skins_ids = @$data['imports']['import-navigation-skins-id'];
									$navigation_skins_imported = $im->import_navigation_skins(@$navigation_skins, $navigation_skins_ids);
								}
							}

							$grids = @$data['imports']['data-grids'];
							if(!empty($grids) && is_array($grids)){
								foreach($grids as $key => $grid){
									$tgrid = json_decode(stripslashes($grid), true);
									if(empty($tgrid)) $tgrid = json_decode($grid, true);

									$grids[$key] = $tgrid;
								}
								if(!empty($grids)){
									$grids_ids = @$data['imports']['import-grids-id'];
									$grids_imported = $im->import_grids($grids, $grids_ids);
								}
							}

							$elements = @$data['imports']['data-elements'];
							if(!empty($elements) && is_array($elements)){
								foreach($elements as $key => $element){
									$telement = json_decode(stripslashes($element), true);
									if(empty($telement)) $telement = json_decode($element, true);

									$elements[$key] = $telement;
								}
								if(!empty($elements)){
									$elements_ids = @$data['imports']['import-elements-id'];
									$elements_imported = $im->import_elements(@$elements, $elements_ids);
								}
							}

							$custom_metas = @$data['imports']['data-custom-meta'];
							if(!empty($custom_metas) && is_array($custom_metas)){
								foreach($custom_metas as $key => $custom_meta){
									$tcustom_meta = json_decode(stripslashes($custom_meta), true);
									if(empty($tcustom_meta)) $tcustom_meta = json_decode($custom_meta, true);

									$custom_metas[$key] = $tcustom_meta;
								}
								if(!empty($custom_metas)){
									$custom_metas_handle = @$data['imports']['import-custom-meta-handle'];
									$custom_metas_imported = $im->import_custom_meta($custom_metas, $custom_metas_handle);
								}
							}

							$custom_fonts = @$data['imports']['data-punch-fonts'];
							if(!empty($custom_fonts) && is_array($custom_fonts)){
								foreach($custom_fonts as $key => $custom_font){
									$tcustom_font = json_decode(stripslashes($custom_font), true);
									if(empty($tcustom_font)) $tcustom_font = json_decode($custom_font, true);

									$custom_fonts[$key] = $tcustom_font;
								}
								if(!empty($custom_fonts)){
									$custom_fonts_handle = @$data['imports']['import-punch-fonts-handle'];
									$custom_fonts_imported = $im->import_punch_fonts($custom_fonts, $custom_fonts_handle);
								}
							}

							if(@$data['imports']['import-global-styles'] == 'on'){
								$global_css = @$data['imports']['data-global-css'];

								$global_styles_imported = $im->import_global_styles($global_css);

							}

							Essential_Grid::ajaxResponseSuccess(__('Successfully imported data', EG_TEXTDOMAIN), array('is_redirect' => true, 'redirect_url' => self::getViewUrl("","",'essential-'.Essential_Grid_Admin::VIEW_START)));

						}catch(Exception $d){
							$error = __('Something went wrong, please contact the developer', EG_TEXTDOMAIN);
						}

					break;
					case 'delete_full_cache':
						$lang = array();

						if(Essential_Grid_Wpml::is_wpml_exists()){
							$lang = icl_get_languages();
						}

						$grids = Essential_Grid::get_essential_grids();
						if(!empty($grids)){
							foreach($grids as $grid){
								if(!empty($lang)){
									foreach($lang as $code => $val){
										delete_transient( 'ess_grid_trans_query_'.$grid->id.$val['language_code'] );
										delete_transient( 'ess_grid_trans_full_grid_'.$grid->id.$val['language_code'] );
									}
								}else{
									delete_transient( 'ess_grid_trans_query_'.$grid->id );
									delete_transient( 'ess_grid_trans_full_grid_'.$grid->id );
								}
							}
						}

						Essential_Grid::ajaxResponseSuccess(__('Successfully deleted all cache', EG_TEXTDOMAIN), array());

					break;
					case "get_image_url":
						if(isset($data['imageid']) && intval($data['imageid']) > 0){
							$img_atts = wp_get_attachment_image_src($data['imageid']);
							if($img_atts !== false){
								$img_src = $img_atts[0];

								Essential_Grid::ajaxResponseSuccess(__("Image URL found", EG_TEXTDOMAIN), array('url' => $img_src, 'imageid' => $data['imageid']));
							}
						}

						$error = __('No correct image ID given', EG_TEXTDOMAIN);
					break;
					case "toggle_grid_favorite":
						if(isset($data['id']) && intval($data['id']) > 0){
							$return = self::toggle_favorite_by_id($data['id']);
							if($return === true){
								Essential_Grid::ajaxResponseSuccess(__("Favorite Set", EG_TEXTDOMAIN));
							}else{
								$error = $return;
							}
						}else{
							$error = __('No ID given', EG_TEXTDOMAIN);
						}
					break;
					case "subscribe_to_newsletter":
						if(isset($data['email']) && !empty($data['email'])){
							$return = ThemePunch_Newsletter::subscribe($data['email']);

							if($return !== false){
								if(!isset($return['status']) || $return['status'] === 'error'){
									$error = (isset($return['message']) && !empty($return['message'])) ? $return['message'] : __('Invalid Email', EG_TEXTDOMAIN);
								}else{
									Essential_Grid::ajaxResponseSuccess(__("Success! Please check your Emails to finish the subscribtion", EG_TEXTDOMAIN), $return);
								}
							}else{
								$error = __('Invalid Email/Could not connect to the Newsletter server', EG_TEXTDOMAIN);
							}
						}else{
							$error = __('No Email given', EG_TEXTDOMAIN);
						}
					break;
					case "unsubscribe_to_newsletter":
						if(isset($data['email']) && !empty($data['email'])){
							$return = ThemePunch_Newsletter::unsubscribe($data['email']);

							if($return !== false){
								if(!isset($return['status']) || $return['status'] === 'error'){
									$error = (isset($return['message']) && !empty($return['message'])) ? $return['message'] : __('Invalid Email', EG_TEXTDOMAIN);
								}else{
									Essential_Grid::ajaxResponseSuccess(__("Success! Please check your Emails to finish the process", EG_TEXTDOMAIN), $return);
								}
							}else{
								$error = __('Invalid Email/Could not connect to the Newsletter server', EG_TEXTDOMAIN);
							}
						}else{
							$error = __('No Email given', EG_TEXTDOMAIN);
						}
					break;
					case "get_facebook_photosets":
						if(!empty($data['url'])){
							$facebook = new Essential_Grid_Facebook();
							$return = $facebook->get_photo_set_photos_options($data['url'],$data['album'],$data['access_token']);
							if( empty($return)){
								$error = __('Could not fetch Facebook albums', EG_TEXTDOMAIN);
							}
							else {
								Essential_Grid::ajaxResponseSuccess(__('Successfully fetched Facebook albums', EG_TEXTDOMAIN), array("data"=>array('html'=>implode(' ', $return))));
							}
						}
						else {
							$error = __('Could not fetch Facebook albums', EG_TEXTDOMAIN);
						}
					break;
					case "get_nextgen_albums":
						$nextgen = new Essential_Grid_Nextgen();
						$return = $nextgen->get_album_list($data['album']);
						Essential_Grid::ajaxResponseSuccess(__('Successfully fetched NextGen albums', EG_TEXTDOMAIN), array("data"=>array('html'=>implode(' ', $return))));
					break;
					case "get_nextgen_galleries":
						$nextgen = new Essential_Grid_Nextgen();
						$return = $nextgen->get_gallery_list($data['gallery']);
						Essential_Grid::ajaxResponseSuccess(__('Successfully fetched NextGen galleries', EG_TEXTDOMAIN), array("data"=>array('html'=>implode(' ', $return))));
					break;
					case "get_youtube_playlists":
						if(!empty($data['api'])){
							$youtube = new Essential_Grid_Youtube(trim($data['api']),trim($data['id']));
							$return = $youtube->get_playlist_options($data['playlist']);
							if(!empty($return)){
								Essential_Grid::ajaxResponseSuccess(__('Successfully fetched YouTube playlists', EG_TEXTDOMAIN), array("data"=>array('html'=>implode(' ', $return))));
							}
							else {
								$error = __('Could not fetch YouTube playlists', EG_TEXTDOMAIN);
							}
						}
						else {
							$error = __('Could not fetch YouTube playlists', EG_TEXTDOMAIN);
						}
					break;
					case "get_flickr_photosets":
						if(!empty($data['url'])){
							$flickr = new Essential_Grid_Flickr($data['key']);
							$user_id = $flickr->get_user_from_url($data['url']);
							$return = $flickr->get_photo_sets($user_id,$data['count'],$data['set']);
							Essential_Grid::ajaxResponseSuccess(__('Successfully fetched flickr photosets', EG_TEXTDOMAIN), array("data"=>array('html'=>implode(' ', $return))));
						}
						else {
							$error = __('Could not fetch flickr photosets', EG_TEXTDOMAIN);
						}
					break;
					case "get_behance_projects":
						if( !empty($data['userid']) ){
							$behance = new Essential_Grid_Behance( $data['api'],$data['userid'],0);
							$return = $behance->get_behance_projects_options($data['project']);
							Essential_Grid::ajaxResponseSuccess( __( 'Successfully fetched Behance projects', EG_TEXTDOMAIN ), array( "data"=>array( 'html'=>implode(' ', $return) ) ) );
						}
						else {
							$error = __('Could not fetch Behance projects', EG_TEXTDOMAIN);
						}
					break;


					case "get_ids_by_data":
						if(!empty($data)){
							$base = new Essential_Grid_Base();

							$types = $base->getPostVar('data', array());

							$ret_ids = array();

							foreach($types as $type => $values){
								switch($type){
									case 'posts':
										//get ids for posts/pages by selected posttype + categories/tags

										$cat_tax = Essential_Grid_Base::getCatAndTaxData($values['post_category']);
										$page_ids = explode(',', @$values['selected_pages']);
										$additional_query = wp_parse_args($values['additional_query']);

										$ids = Essential_Grid_Base::getPostIdByCategory($cat_tax['cats'], $values['post_types'], $cat_tax['tax'], $page_ids, $sortBy = 'ID', $direction = 'DESC', $values['max_entries'], $additional_query, false, $values['post_relation']);

										$ret_ids['posts'] = $ids;
									break;
									default:

									break;
								}
							}

							Essential_Grid::ajaxResponseSuccess(__("ID's fetched!", EG_TEXTDOMAIN), array('data' => $ret_ids));
						}else{
							$error = __('No data found', EG_TEXTDOMAIN);
						}
					break;
					case "load_specific_items_markup":
						$gridid = $base->getPostVar('gridid', 0, 'i');
						if(!empty($data) && $gridid > 0){
							$grid = new Essential_Grid();

							$result = $grid->init_by_id($gridid);
							if(!$result){
								$error = __('Grid not found', EG_TEXTDOMAIN);
							}else{
								$grid->set_loading_ids($data); //set to only load choosen items
								$html = false;
								//check if we are custom grid
								if($grid->is_custom_grid()){
									//$html = $grid->output_by_specific_ids();
								}else{
									//$html = $grid->output_by_specific_posts();
								}

								if($html !== false){
									self::ajaxResponseData($html);
								}else{
									$error = __('Items Not Found', EG_TEXTDOMAIN);
								}
							}
						}else{
							$error = __('No Data Received', EG_TEXTDOMAIN);
						}
					break;
					case "load_library":
						$library = new Essential_Grid_Library();
						$grids	 = $library->get_tp_template_grids();
						ob_start();
						$library->get_library_grids_html($grids);
						$html = ob_get_contents();
						ob_clean();
						ob_end_clean();

						if($html !== false){
							Essential_Grid::ajaxResponseData($html);
						}else{
							$error = __('Library could not be loaded', EG_TEXTDOMAIN);
						}
					break;
					case 'download_library_template':
						$uid		= $base->getPostVar('uid', false);
						$uid		= esc_attr($uid);

						if($uid == ''){
							$error = __('ID missing, something went wrong. Please try again!', EG_TEXTDOMAIN);
						}else{
							if(!is_array($uid)){
								$uid = (array)$uid;
							}
							$library	= new Essential_Grid_Library();
							$filepath	= $library->_download_template($uid); //can be single or multiple, depending on $package beeing false or true

							if($filepath !== false){

							}
							var_dump($filepath);

						}
					break;
					case 'import_grid_online':
						$base	 = new Essential_Grid_Base();
						$library = new Essential_Grid_Library();
						$uid	 = (isset($data['uid'])) ? $data['uid'] : '';
						$zip	 = (isset($data['zip'])) ? $data['zip'] : '';

						$return	 = $library->import_grid($uid, $zip, true);

						if(is_array($return) && !empty($return)){
							$id = (isset($return['grids_imported'])) ? current($return['grids_imported']) : 1;
							Essential_Grid::ajaxResponseSuccess(__('Successfully imported Grid', EG_TEXTDOMAIN), array('is_redirect' => false, 'opengrid' => self::getViewUrl(self::VIEW_GRID_CREATE, 'create='.$id), 'grid_id' => $uid, 'overview' => self::getViewUrl('','','essential-'.Essential_Grid_Admin::VIEW_START)));
						}else{
							$error = __('Failed to import Grid', EG_TEXTDOMAIN);
						}

					break;
					case 'save_metas':
						$base	= new Essential_Grid_Base();
						$m		= new Essential_Grid_Meta();
						$lm		= new Essential_Grid_Meta_Linking();
						$metas	= $base->getVar($data, 'CustomMetas');
						$link_meta = $base->getVar($data, 'LinkMetas');

						$result = $m->save_all_metas($metas);
						if($result !== true){
							Essential_Grid::ajaxResponseError($result, false);
						}
						$result = $lm->save_all_link_metas($link_meta);
						if($result !== true){
							Essential_Grid::ajaxResponseError($result, false);
						}

						if($result === true){
							Essential_Grid::ajaxResponseSuccess(__("Meta successfully saved!", EG_TEXTDOMAIN));
						}
					break;
					case 'add_custom_meta':
						$m = new Essential_Grid_Meta();

						$result = $m->add_new_meta($data);

						if($result === true){
							Essential_Grid::ajaxResponseSuccess(__("Meta successfully created!", EG_TEXTDOMAIN), array('data' => $result));
						}else{
							Essential_Grid::ajaxResponseError($result, false);
						}
					break;
					case 'remove_custom_meta':
						if(!isset($data['handle'])) Essential_Grid::ajaxResponseError(__('Meta not found', EG_TEXTDOMAIN), false);

						$m = new Essential_Grid_Meta();

						$result = $m->remove_meta_by_handle($data['handle']);

						if($result === true){
							Essential_Grid::ajaxResponseSuccess(__("Meta successfully removed!", EG_TEXTDOMAIN), array('data' => $result));
						}else{
							Essential_Grid::ajaxResponseError($result, false);
						}
					break;
					case 'edit_custom_meta':
						if(!isset($data['handle'])) Essential_Grid::ajaxResponseError(__('No handle given', EG_TEXTDOMAIN), false);
						if(!isset($data['name'])) Essential_Grid::ajaxResponseError(__('No name given', EG_TEXTDOMAIN), false);

						$m = new Essential_Grid_Meta();

						$result = $m->edit_meta_by_handle($data);

						if($result === true){
							Essential_Grid::ajaxResponseSuccess(__("Meta successfully changed!", EG_TEXTDOMAIN), array('data' => $result));
						}else{
							Essential_Grid::ajaxResponseError($result, false);
						}
					break;
					case 'add_link_meta':
						$m = new Essential_Grid_Meta_Linking();

						$result = $m->add_new_link_meta($data);

						if($result === true){
							Essential_Grid::ajaxResponseSuccess(__("Meta successfully created!", EG_TEXTDOMAIN), array('data' => $result));
						}else{
							Essential_Grid::ajaxResponseError($result, false);
						}
					break;
					case 'remove_link_meta':
						if(!isset($data['handle'])) Essential_Grid::ajaxResponseError(__('Meta not found', EG_TEXTDOMAIN), false);

						$m = new Essential_Grid_Meta_Linking();

						$result = $m->remove_link_meta_by_handle($data['handle']);

						if($result === true){
							Essential_Grid::ajaxResponseSuccess(__("Meta successfully removed!", EG_TEXTDOMAIN), array('data' => $result));
						}else{
							Essential_Grid::ajaxResponseError($result, false);
						}
					break;
					case 'edit_link_meta':
						if(!isset($data['handle'])) Essential_Grid::ajaxResponseError(__('No handle given', EG_TEXTDOMAIN), false);
						if(!isset($data['name'])) Essential_Grid::ajaxResponseError(__('No name given', EG_TEXTDOMAIN), false);
						if(!isset($data['original'])) Essential_Grid::ajaxResponseError(__('No original given', EG_TEXTDOMAIN), false);

						$m = new Essential_Grid_Meta_Linking();

						$result = $m->edit_link_meta_by_handle($data);

						if($result === true){
							Essential_Grid::ajaxResponseSuccess(__("Meta successfully changed!", EG_TEXTDOMAIN), array('data' => $result));
						}else{
							Essential_Grid::ajaxResponseError($result, false);
						}
					break;



					default:
						$error = true;
					break;
				}
			}else{
				$error = true;
			}
			if($error !== false){
				$showError = __("Wrong Request!", EG_TEXTDOMAIN);
				if($error !== true)
					$showError = __("Ajax Error: ", EG_TEXTDOMAIN).$error;

				Essential_Grid::ajaxResponseError($showError, false);
			}
			exit();
		}catch (Exception $e){exit();}
	}

	/**
	 * Shortcode to wrap around the original gallery shortcode
	 *
	 * @since    1.0.0
	 */
	public function ess_grid_addon_media_form(){
		$grids = new Essential_Grid();
		$arrGrids = $grids->get_essential_grids();
		$defGrid = get_option('tp_eg_overwrite_gallery','');
	?>
		<script type="text/html" id="tmpl-ess-grid-gallery-setting">
		    <h3 style="z-index: -1;">___________________________________________________________________________________________</h3>
		    <h3><?php _e("Extra Essential Grid Settings",EG_TEXTDOMAIN); ?></h3>

		    <label class="setting">
		      <span><?php _e('Essential Grid',EG_TEXTDOMAIN); ?></span>
		      <select class="specific_post_select" data-setting="ess_grid_gal">
		      	<?php
		      		if(empty($defGrid) || $defGrid == "off") echo '<option value="">'. __('Don\'t use EssGrid',EG_TEXTDOMAIN) .'</option>';
		        	foreach($arrGrids as $grid){
		        		echo '<option value="'.$grid->handle.'">'. $grid->name . '</option>';
					}
		        ?>
		      </select>
		    </label>
		    <label class="setting">
		      <span><?php _e('Custom Settings',EG_TEXTDOMAIN); ?></span>
		      <select id="ess_grid_custom_setting" data-setting="ess_grid_custom_setting" onchange="ess_grid_check_gallery_quick()">
		      	<option value="off"> <?php _e('Disable', EG_TEXTDOMAIN);?> </option>
				<option value="on"> <?php _e('Enable', EG_TEXTDOMAIN); ?> </option>
		      </select>
		    </label>
		    <label class="setting quick_grid">
		    	<span><?php _e('Grid Skin',EG_TEXTDOMAIN); ?></span>
		    	<select name="ess-grid-tiny-entry-skin" data-setting="entryskin">
		    	<?php
		    		$skins = Essential_Grid_Item_Skin::get_essential_item_skins('all', false);
					if(!empty($skins)){
						foreach($skins as $skin){
							echo '<option value="'.$skin['id'].'">'.$skin['name'].'</option>'."\n";
						}
					}
				?>
				</select>
		    </label>
		    <label class="setting quick_grid">
				<span><?php _e('Layout', EG_TEXTDOMAIN); ?></span>
				<select name="ess-grid-tiny-layout-sizing" data-setting="layoutsizing">
					<option value="boxed"><?php _e('Boxed', EG_TEXTDOMAIN); ?></option>
					<option value="fullwidth"><?php _e('Fullwidth', EG_TEXTDOMAIN); ?></option>
				</select>
			</label>
			<label class="setting quick_grid">
				<span><?php _e('Grid Layout', EG_TEXTDOMAIN); ?></span>
				<select name="ess-grid-tiny-grid-layout" data-setting="gridlayout">
					<option value="even"><?php _e('Even', EG_TEXTDOMAIN); ?></option>
					<option value="masonry"><?php _e('Masonry', EG_TEXTDOMAIN); ?></option>
					<option value="cobbles"><?php _e('Cobbles', EG_TEXTDOMAIN); ?></option>
				</select>
			</label>
			<label class="setting quick_grid">
				<span><?php _e('Item Spacing', EG_TEXTDOMAIN); ?></span>
				<input type="text" name="ess-grid-tiny-spacings" value="0" data-setting="tinyspacings" />
			</label>
			<label class="setting quick_grid">
				<span><?php _e('Pagination', EG_TEXTDOMAIN); ?></span>
				<select name="ess-grid-tiny-rows-unlimited" data-setting="rowsunlimited">
					<option value="off"> <?php _e('Disable', EG_TEXTDOMAIN);?> </option>
					<option value="on"> <?php _e('Enable', EG_TEXTDOMAIN); ?> </option>
				</select>
			</label>
			<label class="setting quick_grid">
				<span><?php _e('Max. Visible Rows', EG_TEXTDOMAIN); ?></span>
				<input type="text" name="ess-grid-tiny-rows" value="3" data-setting="tinyrows" />
			</label>
			<label class="setting quick_grid">
				<span><?php _e('Start + Filter Anim', EG_TEXTDOMAIN); ?></span>
				<?php
				$anims = Essential_Grid_Base::get_grid_animations();
				?>
				<select class="eg-tooltip-wrap tooltipstered" name="ess-grid-tiny-grid-animation" id="grid-animation-select" data-setting="gridanimation">
					<?php
					foreach($anims as $value => $name){
						echo '<option value="'.$value.'">'.$name.'</option>'."\n";
					}
					?>
				</select>
			</label>
			<label class="setting quick_grid">
				<span><?php _e('Choose Spinner', EG_TEXTDOMAIN); ?></span>
				<select class="eg-tooltip-wrap tooltipstered" name="ess-grid-tiny-use-spinner" id="use_spinner" data-setting="usespinner">
					<option value="-1"><?php _e('off', EG_TEXTDOMAIN); ?></option>
					<option value="0" selected="selected">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</label>
		</script>
		<style>
			.media-sidebar .setting input[type=text],
			.media-sidebar .setting select 				{width:55%;}
			.collection-settings .setting span 			{min-width: 105px}
		</style>
		<script>
			function esg_admin_ready_function(){
				// Extend Defaults
		        _.extend(wp.media.gallery.defaults, {
		        	ess_grid_gal: '<?php echo $defGrid; ?>'
		        });

		        // Extend Standard Gallery
		        wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
			        template: function(view){
			          return wp.media.template('gallery-settings')(view)
			               + wp.media.template('ess-grid-gallery-setting')(view);
			        },
			        render: function(){
						wp.media.view.Settings.prototype.render.apply( this, arguments );
						if(this.$('#ess_grid_custom_setting').val()=='on'){
			        		this.$('label.setting.quick_grid').show();
			        	}
			        	else{
			        		this.$('label.setting.quick_grid').hide();
			        	}

			        	//if(typeof jQuery('#ess_grid_gal').val() == 'undefined') jQuery('#ess_grid_gal').val('<?php echo $defGrid; ?>');
						return this;
					}
		        });
			}
			var esg_admin_ready_once = false
			if(document.readyState === "loading") 
				document.addEventListener('readystatechange',function(){
					if((document.readyState === "interactive" || document.readyState === "complete") && !esg_admin_ready_once){
						esg_admin_ready_once = true;
						esg_admin_ready_function();
					}
				});
			else {
				esg_admin_ready_once = true;
				esg_admin_ready_function();
			}

			

		    // Function to show/hide Quick settings
			function ess_grid_check_gallery_quick(selectvalue){
		    	if(jQuery('#ess_grid_custom_setting').val()=='on'){
	        		jQuery('label.setting.quick_grid').show();
	        	}
	        	else{
	        		jQuery('label.setting.quick_grid').hide();
	        	}
	        }

		</script>
		<?php

		}

	/**
	 * Enqueue Gutenberg editor blocks styles and scripts
	 */
	public function enqueue_block_editor_assets(){
		//$block_path = '/admin/includes/gutenberg-blocks/assets/js/editor.blocks.js';
		//$style_path = '/admin/includes/gutenberg-blocks/assets/css/blocks.style.css';
		$block_path = '/admin/includes/gutenberg-blocks/dist/blocks.build.js';
		$style_path = '/admin/includes/gutenberg-blocks/dist/blocks.editor.build.css';

		// Grids List
		$grids = new Essential_Grid();
		$grids = $grids->get_essential_grids();
		if(!empty($grids)){
			$arrGrids[] = array(
				'value' => '' ,
				'label' => 'No Grid'
			);
			foreach($grids as $grid){
				$arrGrids[] = array(
					'value' => $grid->handle ,
					'label' => $grid->name
				);
			}
		}
		else {
			$arrGrids[] = array(
				'value' => '' ,
				'label' => 'No Grids'
			);
		}

		// Skins List
		$skins = Essential_Grid_Item_Skin::get_essential_item_skins('all', false);
		if(!empty($skins)){
			foreach($skins as $skin){
				$arrSkins[] = array(
					'value' => $skin['id'] ,
					'label' => $skin['name']
				);
			}
		}
		else {
			$arrSkins[] = array(
				'value' => '' ,
				'label' => 'No Skins'
			);
		}

		// Animations
		$anims = Essential_Grid_Base::get_grid_animations();
		if(!empty($anims)){
			foreach($anims as $value => $name){
				$arrAnims[] = array(
					'value' => $value,
					'label' => $name
				);
			}
		}else {
			$arrSkins[] = array(
				'value' => '' ,
				'label' => 'No Animations'
			);
		}

		// Default Grid from Global Options
		$defGrid = get_option('tp_eg_overwrite_gallery','');

		// Enqueue the bundled block JS file
		wp_enqueue_script(
			'essgrid-blocks-js',
			EG_PLUGIN_URL . $block_path,
			array( 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor' ),
			filemtime( EG_PLUGIN_PATH . $block_path )
		);

		wp_localize_script(
			'essgrid-blocks-js',
			'EssGridOptions',
			array(
				'arrGrids'		=> $arrGrids,
				'defGrid'		=> $defGrid,
				'arrSkins'		=> $arrSkins,
				'arrAnims'		=> $arrAnims
			)
		);

		// Enqueue optional editor only styles
		wp_enqueue_style(
			'essgrid-blocks-editor-css',
			EG_PLUGIN_URL . $style_path,
			//array('wp-blocks' ),
			'',
			filemtime( EG_PLUGIN_PATH . $style_path )
		);
	}

	/**
	 * Enqueue Gutenberg editor blocks assets
	 */
	public function enqueue_assets(){
		$style_path = '/admin/includes/gutenberg-blocks/dist/blocks.style.build.css';
		/*wp_enqueue_style(
			'essgrid-blocks',
			EG_PLUGIN_URL . $style_path,
			[ 'wp-blocks' ],
			filemtime( EG_PLUGIN_PATH . $style_path )
		);*/
	}

	/**
	 * Add ThemePunch Gutenberg Block Category
	 */
	public function create_block_category( $categories, $post ){
		if($this->in_array_r('themepunch',$categories)) return $categories;
		return array_merge(
			$categories,
			array(
				array(
					'slug' => 'themepunch',
					'title' => __( 'ThemePunch', 'essgrid' ),
				),
			)
		);
	}


	/**
	 * Check Array for Value
	 */
	public function in_array_r($needle, $haystack, $strict = false){
		foreach ($haystack as $item){
			if(($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $strict))){
				return true;
			}
		}

		return false;
	}

}
