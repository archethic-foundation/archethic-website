<?php

namespace Stratum;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Admin_Page {
	private $version;
	private $prefix;
    private $we_devs_settings_api;

    public function __construct() {
        $this->we_devs_settings_api = new \WeDevs_Settings_API;
		$settings = Settings::get_instance();

		$this->version = $settings->getVersion();
        $this->prefix  = $settings->getPrefix();

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_init', array($this, 'checkInstagramQueryURL') );
		add_action( 'admin_menu', array($this, 'admin_menu') );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueueAdminAssets' ) );
    }

	/**
	 * Enqueue Admin Page js and css
	 */
	public function enqueueAdminAssets() {

		//CSS
		wp_enqueue_style(
			"{$this->prefix}-admin-page",
			stratum_get_plugin_url( 'assets/css/admin-page.min.css' ),
			[],
			$this->version
        );

		wp_enqueue_style(
			"{$this->prefix}-icons-style",
			stratum_get_plugin_url( './assets/css/stratum.min.css' ),
			apply_filters(
				'stratum/editor_css/dependencies',
				[]
			),
			$this->version
		);
	}

    public function admin_init() {
        //Fill settings
        $this->we_devs_settings_api->set_sections( $this->get_settings_sections() );
        $this->we_devs_settings_api->set_fields( $this->get_settings_fields() );

        //Init settings
        $this->we_devs_settings_api->admin_init();
    }

    public function stratum_instagram_notice_success() {
        ?>
        <div class="notice notice-success">
            <p><?php esc_html_e( 'Instagram: access token updated.', 'stratum' ); ?></p>
        </div>
        <?php
    }

    public function stratum_instagram_notice_error() {
        ?>
        <div class="notice notice-error">
            <p><?php esc_html_e('Instagram: access denied.', 'stratum'); ?></p>
        </div>
        <?php
    }

	public function checkInstagramQueryURL()
	{
		global $pagenow;

        if ($pagenow == 'admin.php' && isset($_GET['instagram-token'])) {
            $stratum_api = get_option( 'stratum_api', [] );
            $stratum_api['instagram_access_token'] = sanitize_text_field($_GET['instagram-token']);
            update_option('stratum_api', $stratum_api);
            delete_transient( 'stratum_instagram_response_data' ); //Delete cache data

            wp_redirect(add_query_arg(
                    array(
                        'stratum-instagram-success' => true,
                    ),
                    admin_url( 'admin.php?page=stratum-settings#stratum_api' )
                )
            ); //Redirect
        }

		if (isset($_GET['stratum-instagram-success'])) {
			add_action( 'admin_notices', [$this, 'stratum_instagram_notice_success'] );
		}

		if (isset($_GET['stratum-instagram-error'])) {
			add_action( 'admin_notices', [$this, 'stratum_instagram_notice_error'] );
		}
	}

    public function admin_menu() {

		add_menu_page(
			esc_html__( 'Stratum', 'stratum' ),
			esc_html__( 'Stratum', 'stratum' ),
			'manage_options',
			'stratum',
			array($this, 'about_page'),
			'data:image/svg+xml;base64,' . base64_encode(
				'<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 112 112">
					<g>
						<path fill="gray" d="M83.28,58.38L83.28,58.38L48.75,38.44l0,0c3.59-6.22,11.54-8.35,17.76-4.76l12.01,6.94
							C84.74,44.21,86.87,52.16,83.28,58.38z"/>
					</g>
					<g>
						<path fill="gray" d="M83.28,82.63L83.28,82.63l-33.78-19.5c-6.22-3.59-8.35-11.54-4.76-17.76l0,0l33.77,19.5
							C84.74,68.46,86.87,76.41,83.28,82.63z"/>
					</g>
					<g>
						<path fill="gray" d="M79.29,89.56L79.29,89.56c-3.59,6.22-11.54,8.35-17.76,4.76l-12.05-6.96
							c-6.22-3.59-8.35-11.54-4.76-17.76l0,0L79.29,89.56z"/>
					</g>
				</svg>'
			),
			90
		);

        add_submenu_page(
	        'stratum',
	        esc_html__( 'Stratum Settings', 'stratum' ),
	        esc_html__( 'Settings', 'stratum' ),
	        'manage_options',
	        'stratum-settings',
	        array( $this, 'plugin_page' )
	    );
    }

	public function about_page(){

		$settings = \Stratum\Settings::get_instance();
		$pluginData = $settings->getPluginData();
		$storeUrl = isset( $pluginData['PluginURI'] ) ? $pluginData['PluginURI'] : 'https://motopress.com/';

		?>
		<div class="wrap stratum-wrap about-wrap">
			<img class="stratum-logo" src="<?php echo esc_url(stratum_get_plugin_url( 'assets/img/logo.svg' )); ?>">
			<h1 class="stratum-heading">
				<?php echo esc_html__( 'Stratum', 'stratum' ); ?> <?php echo esc_html($this->version); ?>
				<a class="button button-primary" target="_blank" href="<?php echo esc_url( $storeUrl ); ?>"><?php echo esc_html__( 'Home Page', 'stratum' ); ?></a>
			</h1>
			<p><?php echo esc_html__( 'Advanced Elementor addon to extend the page builder capabilities and add more widgets.', 'stratum' ); ?></p>
			<hr>
			<h3><?php echo esc_html__( 'Changelog', 'stratum' ); ?></h3>
			<div class="stratum-about-list">

<!-- start markdowntohtml.com -->

<p>= 1.3.10, Aug 17 2021 =</p>
<ul>
<li>Fixed an issue with links in Horizontal Timeline and Accordion widgets.</li>
</ul>

<p>= 1.3.9, Jul 21 2021 =</p>
<ul>
<li>Minor bugfixes and improvements.</li>
</ul>

<p>= 1.3.8, May 5 2021 =</p>
<ul>
<li>Minor bugfixes and improvements.</li>
</ul>

<p>= 1.3.7, Apr 1 2021 =</p>
<ul>
<li>Added Table widget.</li>
<li>Added Content Switcher widget.</li>
<li>Added the ability to automatically refresh Instagram access token.</li>
<li>Minor bugfixes and improvements.</li>
</ul>

<p>= 1.3.6, Feb 17 2021 =</p>
<ul>
<li>Minor bugfixes and improvements.</li>
</ul>

<p>= 1.3.5, Dec 23 2020 =</p>
<ul>
<li>Improved compatibility with WordPress 5.6 and Elementor Pro.</li>
<li>Minor bugfixes and improvements.</li>
</ul>

<p>= 1.3.4, Sep 8 2020 =</p>
<ul>
<li>Minor bugfixes and improvements.</li>
</ul>

<p>= 1.3.3, Aug 28 2020 =</p>
<ul>
<li>Added Vertical Timeline widget.</li>
<li>Added Horizontal Timeline widget.</li>
<li>Added Lottie Animations widget.</li>
<li>Added Countdown widget.</li>
</ul>
<p>= 1.3.2, Aug 12 2020 =</p>
<ul>
<li>Improved compatibility with WordPress 5.5.</li>
</ul>
<p>= 1.3.1, Jul 31 2020 =</p>
<ul>
<li>Fixed an issue with Instagram widget.</li>
</ul>
<p>= 1.3.0, Jun 10 2020 =</p>
<ul>
<li>Added Advanced Accordion widget.</li>
<li>Added Advanced Tabs widget.</li>
<li>Added Image Accordion widget.</li>
<li>Improved the plugin color palette.</li>
<li>Added the Templates Library control.</li>
<li>Fixed an issue with &quot;Instagram getToken&quot; in the Instagram widget.</li>
<li>Fixed an issue with controls in the Advanced Google Maps widget.</li>
<li>Minor bugfixes and improvements.</li>
</ul>
<p>= 1.2.0, Apr 29 2020 =</p>
<ul>
<li>Added Advanced Google Map widget.</li>
<li>Added Advanced Posts widget.</li>
<li>Added Advanced Slider widget.</li>
<li>Added Testimonial Carousel widget.</li>
<li>Added Flip Box widget.</li>
<li>Minor bugfixes and improvements.</li>
</ul>
<p>= 1.1.0, Mar 30 2020 =</p>
<ul>
<li>Added Image Hotspot widget.</li>
<li>Added Masonry Gallery widget.</li>
<li>Added Circular Progress Bar widget.</li>
<li>Minor bugfixes and improvements.</li>
</ul>
<p>= 1.0.0, Mar 6 2020 =</p>
<ul>
<li>Initial commit.</li>
</ul>

<!-- end -->
			</div>
		</div>
		<?php
	}

    public function get_settings_sections() {

        $sections = apply_filters( 'stratum_settings_sections', array(
            array(
                'id'        => 'stratum_widgets',
                'title'     => esc_html__( 'Elements', 'stratum' ),
                'addons'    => true,
                'icon'      => 'dashicons dashicons-admin-tools',
            ),
            array(
                'id'        => 'stratum_style',
                'title'     => esc_html__( 'Style', 'stratum' ),
                'icon'      => 'dashicons dashicons-admin-site-alt3',
			),
            array(
                'id'        => 'stratum_api',
                'title'     => esc_html__( 'API', 'stratum' ),
                'icon'      => 'dashicons dashicons-admin-network',
            ),
        ) );

        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    public function get_settings_fields() {

		$stratum_api = get_option( 'stratum_api', [] );
		$instagram_access_token = isset($stratum_api['instagram_access_token']) ? $stratum_api['instagram_access_token'] : '';

        $settings_fields = apply_filters( 'stratum_settings_fields', array(
            'stratum_widgets' => apply_filters( 'stratum_required_widgets', array(
                array(
                    'name'      => 'instagram',
                    'label'     => esc_html__( 'Instagram', 'stratum' ),
                    'desc'      => esc_html__( 'Real-life Instagram feed in your WordPress.', 'stratum' ),
                    'icon'      => 'stratum-icon-instagram',
                    'type'      => 'toggle',
                    'default'   => 'on'
                ),
                array(
                    'name'      => 'banner',
                    'label'     => esc_html__( 'Banner', 'stratum' ),
                    'desc'      => esc_html__( 'Creative animated banners for promos and announcements.', 'stratum' ),
                    'icon'      => 'stratum-icon-banner',
                    'type'      => 'toggle',
                    'default'   => 'on'
                ),
                array(
                    'name'      => 'counter',
                    'label'     => esc_html__( 'Counter', 'stratum' ),
                    'desc'      => esc_html__( 'Animated counters to visualize data.', 'stratum' ),
                    'icon'      => 'stratum-icon-counter',
                    'type'      => 'toggle',
                    'default'   => 'on'
                ),
                array(
                    'name'      => 'price-menu',
                    'label'     => esc_html__( 'Price Menu', 'stratum' ),
                    'desc'      => esc_html__( 'Food menus or other listings with prices.', 'stratum' ),
                    'icon'      => 'stratum-icon-price-menu',
                    'type'      => 'toggle',
                    'default'   => 'on'
                ),
                array(
                    'name'      => 'price-list',
                    'label'     => esc_html__( 'Price List', 'stratum' ),
                    'desc'      => esc_html__( 'Price variables or categorized lists of individual menu items.', 'stratum' ),
                    'icon'      => 'stratum-icon-price-list',
                    'type'      => 'toggle',
                    'default'   => 'on'
                ),
                array(
                    'name'      => 'price-table',
                    'label'     => esc_html__( 'Price Table', 'stratum' ),
                    'desc'      => esc_html__( 'Pricing and comparison tables.', 'stratum' ),
                    'icon'      => 'stratum-icon-price-table',
                    'type'      => 'toggle',
                    'default'   => 'on'
                ),
                array(
                    'name'      => 'table',
                    'label'     => esc_html__( 'Table', 'stratum' ),
                    'desc'      => esc_html__( 'Build responsive tables and customize their content and styling.', 'stratum' ),
                    'icon'      => 'eicon-table',
                    'type'      => 'toggle',
                    'default'   => 'on'
                ),
                array(
                    'name'      => 'content-switcher',
                    'label'     => esc_html__( 'Content Switcher', 'stratum' ),
                    'desc'      => esc_html__( 'Add a toggle or structure your content into switchable tabs - perfect for pricing plans and data organization.', 'stratum' ),
                    'icon'      => 'eicon-dual-button',
                    'type'      => 'toggle',
                    'default'   => 'on'
                ),
                array(
                    'name'      => 'image-hotspot',
                    'label'     => esc_html__( 'Image Hotspot', 'stratum' ),
                    'desc'      => esc_html__( 'Animated pointers with tooltips to place over images.', 'stratum' ),
					'icon'      => 'stratum-icon-image-hotspot',
                    'type'      => 'toggle',
                    'default'   => 'on'
                ),
				array(
                    'name'      => 'circle-progress-bar',
                    'label'     => esc_html__( 'Circle Progress Bar', 'stratum' ),
                    'desc'      => esc_html__( 'A circle-shaped bar with an animated activity progress indicator.', 'stratum' ),
                    'icon'      => 'stratum-icon-circle-progress-bar',
                    'type'      => 'toggle',
                    'default'   => 'on'
                ),
				array(
                    'name'      => 'masonry-gallery',
                    'label'     => esc_html__( 'Masonry Gallery', 'stratum' ),
                    'desc'      => esc_html__( 'A masonry-styled responsive image gallery.', 'stratum' ),
                    'icon'      => 'stratum-icon-masonry-gallery',
                    'type'      => 'toggle',
                    'default'   => 'on'
				),
				array(
                    'name'      => 'advanced-slider',
                    'label'     => esc_html__( 'Advanced Slider', 'stratum' ),
                    'desc'      => esc_html__( 'A fully customizable slider, including the number of columns, horizontal and vertical scrolling, navigation, etc.', 'stratum' ),
                    'icon'      => 'stratum-icon-advanced-slider',
                    'type'      => 'toggle',
                    'default'   => 'on'
				),
                array(
                    'name'      => 'advanced-posts',
                    'label'     => esc_html__( 'Advanced Posts', 'stratum' ),
                    'desc'      => esc_html__( 'Showcase your automatically sourced posts and pages in different grid or list layouts.', 'stratum' ),
                    'icon'      => 'stratum-icon-advanced-posts',
                    'type'      => 'toggle',
                    'default'   => 'on'
				),
                array(
                    'name'      => 'advanced-accordion',
                    'label'     => esc_html__( 'Advanced Accordion', 'stratum' ),
                    'desc'      => esc_html__( 'Horizontal accordion tabs with support for custom Library templates.', 'stratum' ),
                    'icon'      => 'stratum-icon-advanced-accordion',
                    'type'      => 'toggle',
                    'default'   => 'on'
				),
                array(
                    'name'      => 'advanced-tabs',
                    'label'     => esc_html__( 'Advanced Tabs', 'stratum' ),
                    'desc'      => esc_html__( 'Fully customizable horizontal or vertical-oriented tabs with support for custom Library templates.', 'stratum' ),
                    'icon'      => 'stratum-icon-advanced-tabs',
                    'type'      => 'toggle',
                    'default'   => 'on'
                ),
                array(
                    'name'      => 'countdown',
                    'label'     => esc_html__( 'Countdown', 'stratum' ),
                    'desc'      => esc_html__( 'Dynamic countdown timer with deeply customizable numeric values and time labels.', 'stratum' ),
                    'icon'      => 'stratum-icon-countdown',
                    'type'      => 'toggle',
                    'default'   => 'on'
                ),
                [
                    'name'      => 'testimonial-carousel',
                    'label'     => esc_html__( 'Testimonial Carousel', 'stratum' ),
                    'desc'      => esc_html__( 'A ready-made template for admin-added testimonials.', 'stratum' ),
                    'icon'      => 'stratum-icon-testimonial-carousel',
                    'type'      => 'toggle',
                    'default'   => 'on'
                ],
                [
                    'name'      => 'advanced-google-map',
                    'label'     => esc_html__( 'Advanced Google Map', 'stratum' ),
                    'desc'      => esc_html__( 'Google Maps with customizable location markets and map styles.', 'stratum' ),
                    'icon'      => 'stratum-icon-advanced-google-map',
                    'type'      => 'toggle',
                    'default'   => 'on'
                ],
                [
                    'name'      => 'flip-box',
                    'label'     => esc_html__( 'Flip Box', 'stratum' ),
                    'desc'      => esc_html__( 'Flip Box with animation that is triggered on hover and fully customizable front & back sections.', 'stratum' ),
                    'icon'      => 'stratum-icon-flip-box',
                    'type'      => 'toggle',
                    'default'   => 'on'
                ],
                [
                    'name'      => 'image-accordion',
                    'label'     => esc_html__( 'Image Accordion', 'stratum' ),
                    'desc'      => esc_html__( 'Highlight your images with amazing hover and click effects using Image Accordion', 'stratum' ),
                    'icon'      => 'stratum-icon-image-accordion',
                    'type'      => 'toggle',
                    'default'   => 'on'
                ],
                [
                    'name'      => 'vertical-timeline',
                    'label'     => esc_html__( 'Vertical Timeline', 'stratum' ),
                    'desc'      => esc_html__( 'Display events on your pages using Vertical Timeline widget, that allows adding content, including icons, imagery, and descriptions', 'stratum' ),
                    'icon'      => 'stratum-icon-vertical-timeline',
                    'type'      => 'toggle',
                    'default'   => 'on'
                ],
                [
                    'name'      => 'horizontal-timeline',
                    'label'     => esc_html__( 'Horizontal Timeline', 'stratum' ),
                    'desc'      => esc_html__( 'Let the visitors know about the events and projects on your website using the Horizontal Timeline widget', 'stratum' ),
                    'icon'      => 'stratum-icon-horizontal-timeline',
                    'type'      => 'toggle',
                    'default'   => 'on'
                ],
                [
                    'name'      => 'lottie-animations',
                    'label'     => esc_html__( 'Lottie Animations', 'stratum' ),
                    'desc'      => esc_html__( 'Lottie Animations widget give you the ability to easily add Lottie Animations to your Elementor pages with no need to add custom code', 'stratum' ),
                    'icon'      => 'stratum-icon-lottie-animations',
                    'type'      => 'toggle',
                    'default'   => 'on'
                ]
            ) ),
            'stratum_style' => array(
                array(
                    'name'      => 'primary_color',
                    'label'     => esc_html__( 'Primary color', 'stratum' ),
                    'desc'      => esc_html__( 'Select your primary color. Default: #3878ff', 'stratum' ),
                    'type'      => 'color',
                    'default'   => '#3878ff'
                ),
                array(
                    'name'      => 'secondary_color',
                    'label'     => esc_html__( 'Secondary color (Hover)', 'stratum' ),
                    'desc'      => esc_html__( 'Select your secondary color. Default: #565656', 'stratum' ),
                    'type'      => 'color',
                    'default'   => '#565656'
				),
                array(
                    'name'      => 'background_color',
                    'label'     => esc_html__( 'Background color', 'stratum' ),
                    'desc'      => esc_html__( 'Select your secondary color. Default: #71d7f7', 'stratum' ),
                    'type'      => 'color',
                    'default'   => '#71d7f7'
				),
                array(
                    'name'      => 'background_color_active',
                    'label'     => esc_html__( 'Background color (Active)', 'stratum' ),
                    'desc'      => esc_html__( 'Select your secondary color. Default: #0097c6', 'stratum' ),
                    'type'      => 'color',
                    'default'   => '#0097c6'
				),
				array(
                    'name'      => 'background_color_hover',
                    'label'     => esc_html__( 'Background color (Hover)', 'stratum' ),
                    'desc'      => esc_html__( 'Select your secondary color. Default: #008fbc', 'stratum' ),
                    'type'      => 'color',
                    'default'   => '#008fbc'
                ),
			),

            'stratum_api' => [
				[
					'name'       => 'instagram_access_token',
					'label'      => esc_html__( 'Instagram Access Token', 'stratum' ),
					'desc_btn'   => esc_html__( 'Connect Instagram Account', 'stratum' ),
					'desc_class' => 'large',
					'desc_link'  => esc_url(
						'https://api.instagram.com/oauth/authorize?client_id=910186402812397&redirect_uri=' .
						'https://api.getmotopress.com/get_instagram_token.php&scope=user_profile,user_media&response_type=code&state=' .
						admin_url( 'admin.php' )
					),
					'type' => 'text',
				],
                [

                    'name'  => 'google_api_key',
					'label' => esc_html__( 'Google Maps API Key', 'stratum' ),
					'desc' => sprintf( '<a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">%s</a>', esc_html__( 'Get the API key', 'stratum' ) ),
                    'type'  => 'text'
                ]
            ]
		) );

		if (!empty($instagram_access_token)){
			$settings_fields['stratum_api'][0]['desc_extra_btn'] = esc_html__( 'Refresh Access Token', 'stratum' );
			$settings_fields['stratum_api'][0]['desc_extra_class'] = 'large';
			$settings_fields['stratum_api'][0]['desc_extra_link'] = esc_url(
				'https://api.getmotopress.com/refresh_instagram_token.php?access_token='.$instagram_access_token.'&state=' .
				admin_url( 'admin.php?page=stratum-settings#stratum_api' )
			);

			stratum()->get_token_manager()->schedule_token_refresh_event();
		}

        return $settings_fields;
    }

    public function plugin_page() {
        if ( isset( $_GET['settings-updated'] ) ) {
            printf( '<div class="updated"><p>%s</p></div>', esc_html__( 'Plugin settings updated successfully', 'stratum' ) );
        }

        $count = count( $this->get_settings_sections() );
        if ( $count <= 1 ) {
            $class = 'stratum-settings-sections-no';
        } else {
            $class = 'stratum-settings-sections-yes';
        }

        echo '<div class="stratum-wrap about-wrap stratum-settings-wrap '. esc_attr( $class ) .'">';

        $this->we_devs_settings_api->show_navigation();
        $this->we_devs_settings_api->show_forms();

        echo '</div>';
    }
}