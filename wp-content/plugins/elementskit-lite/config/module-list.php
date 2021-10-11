<?php

namespace ElementsKit_Lite\Config;

defined('ABSPATH') || exit;
class Module_List extends \ElementsKit_Lite\Core\Config_List{

    protected $type = 'module';
    
	protected function set_required_list(){

        $this->required_list = [
            'dynamic-content' => [
                'slug' => 'dynamic-content',
                'package' => 'free',
            ],
            'layout-manager' => [
                'slug' => 'layout-manager',
                'package' => 'free',
            ],
            'controls' => [
                'slug' => 'controls',
                'package' => 'free',
            ],
        ];
    }

	protected function set_optional_list(){

		$this->optional_list = apply_filters('elementskit/modules/list', [
            'elementskit-icon-pack' => [
                'slug' => 'elementskit-icon-pack',
                'title' => 'ElementsKit Icon Pack',
                'package' => 'free', // free, pro, pro-disabled
                //'path' => null,
                //'base_class_name' => null,
                //'live' => null
                'attributes' => ['new'],
            ],
            'header-footer' => [
                'slug' => 'header-footer',
                'title' => 'Header Footer',
                'package' => 'free',
            ],
            'megamenu' => [
                'slug' => 'megamenu',
                'package' => 'free',
                'title' => 'Mega Menu'
            ],
            'onepage-scroll' => [
                'slug' => 'onepage-scroll',
                'package' => 'free',
                'title' => 'Onepage Scroll'
            ],
            'widget-builder' => [
                'slug' => 'widget-builder',
                'package' => 'free',
                'title' => 'Widget Builder'
            ],
            'parallax' => [
                'slug' => 'parallax',
                'package' => 'pro-disabled',
                'title' => 'Parallax Effects'
            ],
            'sticky-content' => [
                'slug' => 'sticky-content',
                'package' => 'pro-disabled',
                'title' => 'Sticky Content'
            ],
            'facebook-messenger' => [
                'slug'    => 'facebook-messenger',
                'package' => 'pro-disabled',
                'title'   => 'Facebook Messenger',
            ],
            'conditional-content' => [
                'slug'    => 'conditional-content',
                'package' => 'pro-disabled',
                'title'   => 'Conditional Content',
            ],
            'copy-paste-cross-domain' => [
                'slug' => 'copy-paste-cross-domain',
                'package' => 'pro-disabled',
                'title' => 'Cross-Domain Copy Paste'
            ],
            'advanced-tooltip'  => [
                'slug'      => 'advanced-tooltip',
                'package'   => 'pro-disabled',
                'title'     => 'Advanced Tooltip',
            ]
        ]);
	}

}