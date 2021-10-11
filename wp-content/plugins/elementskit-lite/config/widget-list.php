<?php

namespace ElementsKit_Lite\Config;

defined('ABSPATH') || exit;
class Widget_List extends \ElementsKit_Lite\Core\Config_List{

    protected $type = 'widget';
    
	protected function set_required_list(){
        $this->required_list = [];
    }

	protected function set_optional_list(){

		$this->optional_list = apply_filters('elementskit/widgets/list', [
			'image-accordion'  => [
				'slug'    => 'image-accordion',
				'title'   => 'Image Accordion',
				'package' => 'free', // free, pro, free
				//'path' => 'path to the widget directory',
				//'base_class_name' => 'main class name',
				//'title' => 'widget title',
				//'live' => 'live demo url'
				'widget-category' => 'general' // General
			],
			'accordion'        => [
				'slug'    => 'accordion',
				'title'   => 'Accordion',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'button'           => [
				'slug'    => 'button',
				'title'   => 'Button',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'heading'          => [
				'slug'    => 'heading',
				'title'   => 'Heading',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'blog-posts'       => [
				'slug'    => 'blog-posts',
				'title'   => 'Blog Posts',
				'package' => 'free',
				'widget-category' => 'wp-posts' // Post Widgets
			],
			'icon-box'         => [
				'slug'    => 'icon-box',
				'title'   => 'Icon Box',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'image-box'        => [
				'slug'    => 'image-box',
				'title'   => 'Image Box',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'countdown-timer'  => [
				'slug'    => 'countdown-timer',
				'title'   => 'Countdown Timer',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'client-logo'      => [
				'slug'    => 'client-logo',
				'title'   => 'Client Logo',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'faq'              => [
				'slug'    => 'faq',
				'title'   => 'Faq',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'funfact'          => [
				'slug'    => 'funfact',
				'title'   => 'Funfact',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'image-comparison' => [
				'slug'    => 'image-comparison',
				'title'   => 'Image Comparison',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'lottie'           => [
				'slug'    => 'lottie',
				'title'   => 'Lottie',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'testimonial'      => [
				'slug'    => 'testimonial',
				'title'   => 'Testimonial',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'pricing'          => [
				'slug'    => 'pricing',
				'title'   => 'Pricing',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'team'             => [
				'slug'    => 'team',
				'title'   => 'Team',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'social'           => [
				'slug'    => 'social',
				'title'   => 'Social',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'progressbar'      => [
				'slug'    => 'progressbar',
				'title'   => 'Progressbar',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'category-list'    => [
				'slug'    => 'category-list',
				'title'   => 'Category List',
				'package' => 'free',
				'widget-category' => 'wp-posts' // Post Widgets
			],
			'page-list'        => [
				'slug'    => 'page-list',
				'title'   => 'Page List',
				'package' => 'free',
				'widget-category' => 'header-footer' // ElementsKit Header Footer
			],
			'post-grid'        => [
				'slug'    => 'post-grid',
				'title'   => 'Post Grid',
				'package' => 'free',
				'widget-category' => 'wp-posts' // Post Widgets
			],
			'post-list'        => [
				'slug'    => 'post-list',
				'title'   => 'Post List',
				'package' => 'free',
				'widget-category' => 'wp-posts' // Post Widgets
			],
			'post-tab'         => [
				'slug'    => 'post-tab',
				'title'   => 'Post Tab',
				'package' => 'free',
				'widget-category' => 'wp-posts' // Post Widgets
			],
			'nav-menu'         => [
				'slug'    => 'nav-menu',
				'title'   => 'Nav Menu',
				'package' => 'free',
				'widget-category' => 'header-footer' // ElementsKit Header Footer
			],
			'mail-chimp'       => [
				'slug'    => 'mail-chimp',
				'title'   => 'Mail Chimp',
				'package' => 'free',
				'widget-category' => 'form-widgets' // Form Widgets
			],
			'header-info'      => [
				'slug'    => 'header-info',
				'title'   => 'Header Info',
				'package' => 'free',
				'widget-category' => 'header-footer' // ElementsKit Header Footer
			],
			'piechart'         => [
				'slug'    => 'piechart',
				'title'   => 'Piechart',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'header-search'    => [
				'slug'    => 'header-search',
				'title'   => 'Header Search',
				'package' => 'free',
				'widget-category' => 'header-footer' // ElementsKit Header Footer
			],
			'header-offcanvas' => [
				'slug'    => 'header-offcanvas',
				'title'   => 'Header Offcanvas',
				'package' => 'free',
				'widget-category' => 'header-footer' // ElementsKit Header Footer
			],
			'tab'              => [
				'slug'    => 'tab',
				'title'   => 'Tab',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'contact-form7'    => [
				'slug'    => 'contact-form7',
				'title'   => 'Contact Form7',
				'package' => 'free',
				'widget-category' => 'form-widgets' // Form Widgets
			],
			'video'            => [
				'slug'    => 'video',
				'title'   => 'Video',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'business-hours'   => [
				'slug'    => 'business-hours',
				'title'   => 'Business Hours',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'drop-caps'        => [
				'slug'    => 'drop-caps',
				'title'   => 'Drop Caps',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'social-share'     => [
				'slug'    => 'social-share',
				'title'   => 'Social Share',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'dual-button'      => [
				'slug'    => 'dual-button',
				'title'   => 'Dual Button',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'caldera-forms'    => [
				'slug'    => 'caldera-forms',
				'title'   => 'Caldera Forms',
				'package' => 'free',
				'widget-category' => 'form-widgets' // Form Widgets
			],
			'we-forms'         => [
				'slug'    => 'we-forms',
				'title'   => 'We Forms',
				'package' => 'free',
				'widget-category' => 'form-widgets' // Form Widgets
			],
			'wp-forms'         => [
				'slug'    => 'wp-forms',
				'title'   => 'Wp Forms',
				'package' => 'free',
				'widget-category' => 'form-widgets' // Form Widgets
			],
	
			'ninja-forms'        => [
				'slug'    => 'ninja-forms',
				'title'   => 'Ninja Forms',
				'package' => 'free',
				'widget-category' => 'form-widgets' // Form Widgets
			],
			'tablepress'         => [
				'slug'    => 'tablepress',
				'title'   => 'Tablepress',
				'package' => 'free',
				'widget-category' => 'general' // General
			],
			'fluent-forms'         => [
				'slug'    => 'fluent-forms',
				'title'   => 'Fluent Forms',
				'package' => 'free',
				'widget-category' => 'form-widgets' // Form Widgets
			],
			'back-to-top'    => [
				'slug'    => 'back-to-top',
				'title'   => 'Back To Top',
				'package' => 'free',
				'widget-category' => 'general' //general
			],
			'advanced-accordion' => [
				'slug'    => 'advanced-accordion',
				'title'   => 'Advanced Accordion',
				'package' => 'pro-disabled',
				'widget-category' => 'general' // General
			],
			'advanced-tab'       => [
				'slug'    => 'advanced-tab',
				'title'   => 'Advanced Tab',
				'package' => 'pro-disabled',
				'widget-category' => 'general' // General
			],
			'hotspot'            => [
				'slug'    => 'hotspot',
				'title'   => 'Hotspot',
				'package' => 'pro-disabled',
				'widget-category' => 'general' // General
			],
			'motion-text'        => [
				'slug'    => 'motion-text',
				'title'   => 'Motion Text',
				'package' => 'pro-disabled',
				'widget-category' => 'general' // General
			],
			'twitter-feed'       => [
				'slug'    => 'twitter-feed',
				'title'   => 'Twitter Feed',
				'package' => 'pro-disabled',
				'widget-category' => 'social-media-feeds' // Social Media Feeds Widgets
			],
	
			'instagram-feed'       => [
				'slug'    => 'instagram-feed',
				'title'   => 'Instagram Feed',
				'package' => 'pro-disabled',
				'widget-category' => 'social-media-feeds' // Social Media Feeds Widgets
			],
			'gallery'              => [
				'slug'    => 'gallery',
				'title'   => 'Gallery',
				'package' => 'pro-disabled',
				'widget-category' => 'general' // General
			],
			'chart'                => [
				'slug'    => 'chart',
				'title'   => 'Chart',
				'package' => 'pro-disabled',
				'widget-category' => 'general' // General
			],
			'woo-category-list'    => [
				'slug'    => 'woo-category-list',
				'title'   => 'Woo Category List',
				'package' => 'pro-disabled',
				'widget-category' => 'woocommerce' // Woocommerce Widgets
			],
			'woo-mini-cart'        => [
				'slug'    => 'woo-mini-cart',
				'title'   => 'Woo Mini Cart',
				'package' => 'pro-disabled',
				'widget-category' => 'woocommerce' // Woocommerce Widgets
			],
			'woo-product-carousel' => [
				'slug'    => 'woo-product-carousel',
				'title'   => 'Woo Product Carousel',
				'package' => 'pro-disabled',
				'widget-category' => 'woocommerce' // Woocommerce Widgets
			],
			'woo-product-list'     => [
				'slug'    => 'woo-product-list',
				'title'   => 'Woo Product List',
				'package' => 'pro-disabled',
				'widget-category' => 'woocommerce' // Woocommerce Widgets
			],
			'table'                => [
				'slug'    => 'table',
				'title'   => 'Table',
				'package' => 'pro-disabled',
				'widget-category' => 'general' // General
			],
			'timeline'             => [
				'slug'    => 'timeline',
				'title'   => 'Timeline',
				'package' => 'pro-disabled',
				'widget-category' => 'general' // General
			],
			'creative-button'      => [
				'slug'    => 'creative-button',
				'title'   => 'Creative Button',
				'package' => 'pro-disabled',
				'widget-category' => 'general' // General
			],
			'vertical-menu'        => [
				'slug'    => 'vertical-menu',
				'title'   => 'Vertical Menu',
				'package' => 'pro-disabled',
				'widget-category' => 'header-footer' // ElementsKit Header Footer
			],
			'advanced-toggle'      => [
				'slug'    => 'advanced-toggle',
				'title'   => 'Advanced Toggle',
				'package' => 'pro-disabled',
				'widget-category' => 'general' // General
			],
			'video-gallery'        => [
				'slug'    => 'video-gallery',
				'title'   => 'Video Gallery',
				'package' => 'pro-disabled',
				'widget-category' => 'general' // General
			],
			'zoom'                 => [
				'slug'    => 'zoom',
				'title'   => 'Zoom',
				'package' => 'pro-disabled',
				'widget-category' => 'meeting-widgets' // Meeting Widgets
			],
			'behance-feed'         => [
				'slug'    => 'behance-feed',
				'title'   => 'Behance Feed',
				'package' => 'pro-disabled',
				'widget-category' => 'social-media-feeds' // Social Media Feeds Widgets
			],
	
			'breadcrumb' => [
				'slug'    => 'breadcrumb',
				'title'   => 'Breadcrumb',
				'package' => 'pro-disabled',
				'widget-category' => 'general' // General
			],
	
			'dribble-feed' => [
				'slug'    => 'dribble-feed',
				'title'   => 'Dribble Feed',
				'package' => 'pro-disabled',
				'widget-category' => 'social-media-feeds' // Social Media Feeds Widgets
			],
	
			'facebook-feed' => [
				'slug'    => 'facebook-feed',
				'title'   => 'Facebook feed',
				'package' => 'pro-disabled',
				'widget-category' => 'social-media-feeds' // Social Media Feeds Widgets
			],
	
			'facebook-review' => [
				'slug'    => 'facebook-review',
				'title'   => 'Facebook review',
				'package' => 'pro-disabled',
				'widget-category' => 'review-widgets' // Review Widgets
			],
	
			// 'trustpilot' => [
			// 	'slug'    => 'trustpilot',
			// 	'title'   => 'Trustpilot',
			// 	'package' => 'pro-disabled',
			// 	'widget-category' => 'review-widgets' // Review Widgets
			// ],
	
			'yelp' => [
				'slug'    => 'yelp',
				'title'   => 'Yelp',
				'package' => 'pro-disabled',
				'widget-category' => 'review-widgets' // Review Widgets
			],
	
			'pinterest-feed' => [
				'slug'    => 'pinterest-feed',
				'title'   => 'Pinterest Feed',
				'package' => 'pro-disabled',
				'widget-category' => 'social-media-feeds' // Social Media Feeds Widgets
			],
			
			'popup-modal' => [
				'slug'    => 'popup-modal',
				'title'   => 'Popup Modal',
				'package' => 'pro-disabled',
				'widget-category' => 'general' // General
			],
	
			'google-map' => [
				'slug'    => 'google-map',
				'title'   => 'Google Map',
				'package' => 'pro-disabled',
				'widget-category' => 'general' // General
			],
			'unfold'         => [
				'slug'    => 'unfold',
				'title'   => 'Unfold',
				'package' => 'pro-disabled',
				'widget-category' => 'general' // General
			],
			'image-swap'     => [
				'slug'    => 'image-swap',
				'title'   => 'Image Swap',
				'package' => 'pro-disabled',
				'widget-category' => 'general' // General
			],
		]);
	}
}
