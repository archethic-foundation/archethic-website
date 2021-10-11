<?php
if (!class_exists('VC_Extensions_SideBySide')) {
    class VC_Extensions_SideBySide{
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Side by Side", 'vc_sidebyside_cq'),
            "base" => "cq_vc_sidebyside",
            "class" => "wpb_cq_vc_extension_sidebyside",
            "icon" => "cq_allinone_sidebyside",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Card with image, icon and text', 'js_composer'),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_sidebyside_cq",
                "heading" => esc_attr__("Choose the mode, display the card with:", "vc_sidebyside_cq"),
                "param_name" => "card1avatar",
                "value" => array("Text Only" => "none", "Image (with tooltip)" => "image", "Icon (Select icon below)" => "icon"),
                "group" => "Card 1",
                "description" => esc_attr__("", "vc_sidebyside_cq")
              ),
              array(
                "type" => "attach_image",
                    "heading" => esc_attr__("Card image:", "vc_sidebyside_cq"),
                    "param_name" => "card1image",
                    "value" => "",
                    "dependency" => Array('element' => "card1avatar", 'value' => array('image')),
                    "group" => "Card 1",
                    "description" => esc_attr__("Select image from media library.", "vc_sidebyside_cq")
              ),
              array(
                'type' => 'dropdown',
                'heading' => esc_attr__( 'Icon library', 'js_composer' ),
                'value' => array(
                  esc_attr__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                  esc_attr__( 'Open Iconic', 'js_composer' ) => 'openiconic',
                  esc_attr__( 'Typicons', 'js_composer' ) => 'typicons',
                  esc_attr__( 'Entypo', 'js_composer' ) => 'entypo',
                  esc_attr__( 'Linecons', 'js_composer' ) => 'linecons',
                  esc_attr__( 'Material', 'js_composer' ) => 'material',
                ),
                'admin_label' => true,
                'param_name' => 'new_card1icon',
                "group" => "Card 1",
                "dependency" => Array('element' => "card1avatar", 'value' => array('icon')),
                'description' => esc_attr__( 'Select icon library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-adjust', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                  'element' => 'new_card1icon',
                  'value' => 'fontawesome',
                ),
                "group" => "Card 1",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_openiconic',
                'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'openiconic',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'new_card1icon',
                  'value' => 'openiconic',
                ),
                "group" => "Card 1",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_typicons',
                'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'typicons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'new_card1icon',
                  'value' => 'typicons',
                ),
                "group" => "Card 1",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_entypo',
                'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'entypo',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                "group" => "Card 1",
                'dependency' => array(
                  'element' => 'new_card1icon',
                  'value' => 'entypo',
                ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_linecons',
                'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'linecons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'new_card1icon',
                  'value' => 'linecons',
                ),
                "group" => "Card 1",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_material',
                'value' => 'vc-material vc-material-cake',
                // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false,
                  // default true, display an "EMPTY" icon?
                  'type' => 'material',
                  'iconsPerPage' => 100,
                  // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'new_card1icon',
                  'value' => 'material',
                ),
                "group" => "Card 1",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Icon color", 'vc_sidebyside_cq'),
                "param_name" => "card1iconcolor",
                "value" => '',
                "group" => "Card 1",
                "description" => esc_attr__("", 'vc_sidebyside_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Text follow the icon (optional):", "vc_sidebyside_cq"),
                "param_name" => "card1icontext",
                "value" => "",
                "group" => "Card 1",
                "dependency" => Array('element' => "card1avatar", 'value' => array('icon')),
                "description" => esc_attr__("", "vc_sidebyside_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Size of the icon (and optional follow text):", "vc_sidebyside_cq"),
                "param_name" => "card1iconsize",
                "value" => "",
                "group" => "Card 1",
                "dependency" => Array('element' => "card1avatar", 'value' => array('icon')),
                "description" => esc_attr__("Default is 1.2em.", "vc_sidebyside_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Card 1 title (optional):", "vc_sidebyside_cq"),
                "param_name" => "card1title",
                "value" => "",
                "group" => "Card 1",
                "description" => esc_attr__("Will be displayed as tooltip in the image mode.", "vc_sidebyside_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Title color", 'vc_sidebyside_cq'),
                "param_name" => "card1titlecolor",
                "value" => '',
                "group" => "Card 1",
                "description" => esc_attr__("", 'vc_sidebyside_cq')
              ),
              array(
                "type" => "textarea",
                "heading" => esc_attr__("Card 1 content (optional):", "vc_sidebyside_cq"),
                "param_name" => "card1content",
                "value" => "",
                "group" => "Card 1",
                "description" => esc_attr__("", "vc_sidebyside_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Content color", 'vc_sidebyside_cq'),
                "param_name" => "card1contentcolor",
                "value" => '',
                "group" => "Card 1",
                "description" => esc_attr__("", 'vc_sidebyside_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_sidebyside_cq",
                "heading" => esc_attr__("Display the divider with:", "vc_sidebyside_cq"),
                "param_name" => "dividertype",
                "value" => array("Text" => "text", "Icon only (select icon below)" => "icon"),
                "group" => "Divider",
                "description" => esc_attr__("", "vc_sidebyside_cq")
              ),
              array(
                "type" => "textarea_raw_html",
                "heading" => esc_attr__("Divider text", "vc_sidebyside_cq"),
                "param_name" => "divider",
                "value" => "",
                "group" => "Divider",
                "dependency" => Array('element' => "dividertype", 'value' => array('text')),
                "description" => esc_attr__("The divider in the center of the 2 cards. Support HTML here, for example &lt;i class=&#039;fa fa-twitter&#039;&gt;&lt;/i&gt; will insert a Twitter Font Awesome icon", "vc_sidebyside_cq")
              ),
              array(
                'type' => 'dropdown',
                'heading' => esc_attr__( 'Icon library', 'js_composer' ),
                'value' => array(
                  esc_attr__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                  esc_attr__( 'Open Iconic', 'js_composer' ) => 'openiconic',
                  esc_attr__( 'Typicons', 'js_composer' ) => 'typicons',
                  esc_attr__( 'Entypo', 'js_composer' ) => 'entypo',
                  esc_attr__( 'Linecons', 'js_composer' ) => 'linecons',
                  esc_attr__( 'Material', 'js_composer' ) => 'material',
                ),
                'admin_label' => true,
                'param_name' => 'dividericon',
                "group" => "Divider",
                "dependency" => Array('element' => "dividertype", 'value' => array('icon')),
                'description' => esc_attr__( 'Select icon library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'divider_icon_fontawesome',
                'value' => 'fa fa-adjust', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                  'element' => 'dividericon',
                  'value' => 'fontawesome',
                ),
                "group" => "Divider",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'divider_icon_openiconic',
                'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'openiconic',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'dividericon',
                  'value' => 'openiconic',
                ),
                "group" => "Divider",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'divider_icon_typicons',
                'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'typicons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'dividericon',
                  'value' => 'typicons',
                ),
                "group" => "Divider",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'divider_icon_entypo',
                'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'entypo',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                "group" => "Divider",
                'dependency' => array(
                  'element' => 'dividericon',
                  'value' => 'entypo',
                ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'divider_icon_linecons',
                'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'linecons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'dividericon',
                  'value' => 'linecons',
                ),
                "group" => "Divider",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'divider_icon_material',
                'value' => 'vc-material vc-material-cake',
                // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false,
                  // default true, display an "EMPTY" icon?
                  'type' => 'material',
                  'iconsPerPage' => 100,
                  // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'dividericon',
                  'value' => 'material',
                ),
                "group" => "Divider",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_sidebyside_cq",
                "heading" => esc_attr__("Divider background shape:", "vc_sidebyside_cq"),
                "param_name" => "dividerborder",
                "value" => array("circle" => "50%", "rounded" => "4px", "square" => "0"),
                "group" => "Divider",
                "description" => esc_attr__("", "vc_sidebyside_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("font-size of the divider:", "vc_sidebyside_cq"),
                "param_name" => "dividerfontsize",
                "value" => "",
                "group" => "Divider",
                "description" => esc_attr__("Default is 1em.", "vc_sidebyside_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("width of the divider:", "vc_sidebyside_cq"),
                "param_name" => "dividerwidth",
                "value" => "",
                "group" => "Divider",
                "description" => esc_attr__("Default is 36px.", "vc_sidebyside_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("height of the divider:", "vc_sidebyside_cq"),
                "param_name" => "dividerheight",
                "value" => "",
                "group" => "Divider",
                "description" => esc_attr__("Default is 36px.", "vc_sidebyside_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Divider background", 'vc_sidebyside_cq'),
                "param_name" => "dividerbg",
                "value" => '#fff',
                "group" => "Divider",
                "description" => esc_attr__("", 'vc_sidebyside_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Divider text color", 'vc_sidebyside_cq'),
                "param_name" => "dividercolor",
                "value" => '#333',
                "group" => "Divider",
                "description" => esc_attr__("", 'vc_sidebyside_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_sidebyside_cq",
                "heading" => esc_attr__("Apply border in the divider?", "vc_sidebyside_cq"),
                "param_name" => "isgap",
                "value" => array("No" => "", "Yes" => "cq-isgap"),
                "group" => "Divider",
                "description" => esc_attr__("", "vc_sidebyside_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Color of the divider border:", 'vc_sidebyside_cq'),
                "param_name" => "gapcolor",
                "value" => '',
                "group" => "Divider",
                "dependency" => Array('element' => "isgap", 'value' => array('cq-isgap')),
                "description" => esc_attr__("The color of the gap between 2 cards, default is white.", 'vc_sidebyside_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_sidebyside_cq",
                "heading" => esc_attr__("Choose the mode, display the card with:", "vc_sidebyside_cq"),
                "param_name" => "card2avatar",
                "value" => array("Text Only" => "none", "Image (with tooltip)" => "image", "Icon (Select icon below)" => "icon"),
                "group" => "Card 2",
                "description" => esc_attr__("", "vc_sidebyside_cq")
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Card image:", "vc_sidebyside_cq"),
                "param_name" => "card2image",
                "value" => "",
                "dependency" => Array('element' => "card2avatar", 'value' => array('image')),
                "group" => "Card 2",
                "description" => esc_attr__("Select image from media library.", "vc_sidebyside_cq")
              ),

              array(
                'type' => 'dropdown',
                'heading' => esc_attr__( 'Icon library', 'js_composer' ),
                'value' => array(
                  esc_attr__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                  esc_attr__( 'Open Iconic', 'js_composer' ) => 'openiconic',
                  esc_attr__( 'Typicons', 'js_composer' ) => 'typicons',
                  esc_attr__( 'Entypo', 'js_composer' ) => 'entypo',
                  esc_attr__( 'Linecons', 'js_composer' ) => 'linecons',
                  esc_attr__( 'Material', 'js_composer' ) => 'material',
                ),
                'admin_label' => true,
                'param_name' => 'new_card2icon',
                "group" => "Card 2",
                "dependency" => Array('element' => "card2avatar", 'value' => array('icon')),
                'description' => esc_attr__( 'Select icon library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'card2_icon_fontawesome',
                'value' => 'fa fa-adjust', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                  'element' => 'new_card2icon',
                  'value' => 'fontawesome',
                ),
                "group" => "Card 2",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'card2_icon_openiconic',
                'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'openiconic',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'new_card2icon',
                  'value' => 'openiconic',
                ),
                "group" => "Card 2",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'card2_icon_typicons',
                'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'typicons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'new_card2icon',
                  'value' => 'typicons',
                ),
                "group" => "Card 2",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'card2_icon_entypo',
                'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'entypo',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                "group" => "Card 2",
                'dependency' => array(
                  'element' => 'new_card2icon',
                  'value' => 'entypo',
                ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'card2_icon_linecons',
                'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'linecons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'new_card2icon',
                  'value' => 'linecons',
                ),
                "group" => "Card 2",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'card2_icon_material',
                'value' => 'vc-material vc-material-cake',
                // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false,
                  // default true, display an "EMPTY" icon?
                  'type' => 'material',
                  'iconsPerPage' => 100,
                  // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'new_card2icon',
                  'value' => 'material',
                ),
                "group" => "Card 2",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Icon color", 'vc_sidebyside_cq'),
                "param_name" => "card2iconcolor",
                "value" => '',
                "group" => "Card 2",
                "description" => esc_attr__("", 'vc_sidebyside_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Text follow the icon (optional):", "vc_sidebyside_cq"),
                "param_name" => "card2icontext",
                "value" => "",
                "group" => "Card 2",
                "dependency" => Array('element' => "card2avatar", 'value' => array('icon')),
                "description" => esc_attr__("", "vc_sidebyside_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Size of the icon (and optional follow text):", "vc_sidebyside_cq"),
                "param_name" => "card2iconsize",
                "value" => "",
                "group" => "Card 2",
                "dependency" => Array('element' => "card2avatar", 'value' => array('icon')),
                "description" => esc_attr__("Default is 1.2em.", "vc_sidebyside_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Card 2 title (optional):", "vc_sidebyside_cq"),
                "param_name" => "card2title",
                "value" => "",
                "group" => "Card 2",
                "description" => esc_attr__("Will be displayed as tooltip in the image mode.", "vc_sidebyside_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Title color", 'vc_sidebyside_cq'),
                "param_name" => "card2titlecolor",
                "value" => '',
                "group" => "Card 2",
                "description" => esc_attr__("", 'vc_sidebyside_cq')
              ),
              array(
                "type" => "textarea",
                "heading" => esc_attr__("Card 2 content (optional):", "vc_sidebyside_cq"),
                "param_name" => "card2content",
                "value" => "",
                "group" => "Card 2",
                "description" => esc_attr__("", "vc_sidebyside_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Content color", 'vc_sidebyside_cq'),
                "param_name" => "card2contentcolor",
                "value" => '',
                "group" => "Card 2",
                "description" => esc_attr__("", 'vc_sidebyside_cq')
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for this Card)', 'vc_sidebyside_cq' ),
                'param_name' => 'card1link',
                'group' => 'Card 1',
                'description' => esc_attr__( '', 'vc_sidebyside_cq' )
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for this Card)', 'vc_sidebyside_cq' ),
                'param_name' => 'card2link',
                'group' => 'Card 2',
                'description' => esc_attr__( '', 'vc_sidebyside_cq' )
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_sidebyside_cq",
                "heading" => esc_attr__("Display the card, side by side from:", "vc_sidebyside_cq"),
                "param_name" => "carddirection",
                "value" => array("left to right" => "leftright", "top to bottom" => "topbottom"),
                "description" => esc_attr__("", "vc_sidebyside_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_sidebyside_cq",
                "heading" => esc_attr__("Display the card in shape:", "vc_sidebyside_cq"),
                "param_name" => "cardshape",
                "value" => array("Square" => "", "Rounded" => "cq-rounded"),
                "description" => esc_attr__("", "vc_sidebyside_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_sidebyside_cq",
                "heading" => esc_attr__("Card color style:", "vc_sidebyside_cq"),
                "param_name" => "cardstyle",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "Customized color:" => "customized"),
                'std' => 'mediumgray',
                "description" => esc_attr__("", "vc_sidebyside_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_sidebyside_cq",
                "heading" => esc_attr__("Tooltip position:", "vc_sidebyside_cq"),
                "param_name" => "tooltipposition",
                "value" => array("top" => "top", "bottom" => "bottom", "left" => "left", "right" => "right"),
                "description" => esc_attr__("Tooltip only available with the image mode.", "vc_sidebyside_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Card 1 background", 'vc_sidebyside_cq'),
                "param_name" => "card1bg",
                "value" => '',
                "dependency" => Array('element' => "cardstyle", 'value' => array('customized')),
                "description" => esc_attr__("", 'vc_sidebyside_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Card 2 background", 'vc_sidebyside_cq'),
                "param_name" => "card2bg",
                "value" => '',
                "dependency" => Array('element' => "cardstyle", 'value' => array('customized')),
                "description" => esc_attr__("", 'vc_sidebyside_cq')
              ),

              array(
                "type" => "textfield",
                "heading" => esc_attr__("height of the whole element:", "vc_sidebyside_cq"),
                "param_name" => "cardheight",
                "value" => "",
                "description" => esc_attr__("Default is 200px. You can specify other value here.", "vc_sidebyside_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("width of the whole element:", "vc_sidebyside_cq"),
                "param_name" => "elementwidth",
                "value" => "",
                "description" => esc_attr__("Default is 100%. You can specify other value here.", "vc_sidebyside_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize the images to this width:", "vc_sidebyside_cq"),
                "param_name" => "imagewidth",
                "value" => "",
                "description" => esc_attr__("Specify a width here (for example 480), otherwise we will use the original image.", "vc_sidebyside_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("font-size of the title (in card 1 and card 2):", "vc_sidebyside_cq"),
                "param_name" => "titlesize",
                "value" => "",
                "description" => esc_attr__("Default is 1.2em. You can specify other value here.", "vc_sidebyside_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("font-size of the content: (in card 1 and card 2)", "vc_sidebyside_cq"),
                "param_name" => "contentsize",
                "value" => "",
                "description" => esc_attr__("Default is 1em. You can specify other value here.", "vc_sidebyside_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("width of the title and content (in card 1 and card 2):", "vc_sidebyside_cq"),
                "param_name" => "contentwidth",
                "value" => "",
                "description" => esc_attr__("Default is 90%. You can specify other value here.", "vc_sidebyside_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("y offset for the Text follow the icon:", "vc_sidebyside_cq"),
                "param_name" => "followyoffset",
                "value" => "",
                "description" => esc_attr__("You may want to move the Text follow the icon above with some pixels to align the text with the icon. For example -5 will move it 5px above. Default is 0. You can specify a value here (without the px).", "vc_sidebyside_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS margin of the whole element:", "vc_sidebyside_cq"),
                "param_name" => "cardmargin",
                "value" => "",
                "description" => esc_attr__("Default is margin: 12px auto 0 auto. You can specify other value here.", "vc_sidebyside_cq")
              )

             )
          ));

        add_shortcode('cq_vc_sidebyside', array($this,'cq_vc_sidebyside_func'));

      }

      function cq_vc_sidebyside_func($atts, $content=null, $tag) {
          $icon = $dividericon = $new_card1icon = $new_card2icon = $card1icon = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypoicons = $icon_linecons = $icon_material = $divider_icon_fontawesome = $divider_icon_openiconic = $divider_icon_typicons = $divider_icon_entypoicons = $divider_icon_linecons = $divider_icon_material = $card2_icon_fontawesome = $card2_icon_openiconic = $card2_icon_typicons = $card2_icon_entypoicons = $card2_icon_linecons = $card2_icon_material = '';
          extract(shortcode_atts(array(
            'new_card1icon' => 'fontawesome',
            'new_card2icon' => 'fontawesome',
            'icon_fontawesome' => 'fa fa-adjust',
            'icon_openiconic' => 'vc-oi vc-oi-dial',
            'icon_typicons' => 'typcn typcn-adjust-brightness',
            'icon_entypoicons' => 'entypo-icon entypo-icon-note',
            'icon_linecons' => 'vc_li vc_li-heart',
            'icon_entypo' => 'entypo-icon entypo-icon-note',
            "icon_material" => 'vc-material vc-material-cake',
            'divider_icon_fontawesome' => 'fa fa-adjust',
            'divider_icon_openiconic' => 'vc-oi vc-oi-dial',
            'divider_icon_typicons' => 'typcn typcn-adjust-brightness',
            'divider_icon_entypoicons' => 'entypo-icon entypo-icon-note',
            'divider_icon_linecons' => 'vc_li vc_li-heart',
            'divider_icon_entypo' => 'entypo-icon entypo-icon-note',
            "divider_icon_material" => 'vc-material vc-material-cake',
            'card2_icon_fontawesome' => 'fa fa-adjust',
            'card2_icon_openiconic' => 'vc-oi vc-oi-dial',
            'card2_icon_typicons' => 'typcn typcn-adjust-brightness',
            'card2_icon_entypoicons' => 'entypo-icon entypo-icon-note',
            'card2_icon_linecons' => 'vc_li vc_li-heart',
            'card2_icon_entypo' => 'entypo-icon entypo-icon-note',
            'card2_icon_material' => 'vc-material vc-material-cake',
            "divider" => '',
            "dividericon" => '',
            "dividertype" => 'text',
            "dividerbg" => '#FFF',
            "dividercolor" => '#333',
            "dividerborder" => '50%',
            "dividerfontsize" => '',
            "dividerwidth" => '',
            "dividerheight" => '',
            "card1avatar" => '',
            "card1image" => '',
            "card1icon" => '',
            "card1icontext" => '',
            "card1iconsize" => '',
            "card1title" => '',
            "card1titlecolor" => '',
            "card1contentcolor" => '',
            "card1iconcolor" => '',
            "card1bg" => '',
            "card2bg" => '',
            "card1content" => '',
            "card2avatar" => '',
            "card2image" => '',
            "card2icon" => '',
            "card2icontext" => '',
            "card2iconsize" => '',
            "card2title" => '',
            "card2titlecolor" => '',
            "card2contentcolor" => '',
            "card2iconcolor" => '',
            "card2content" => '',
            "card1link" => '',
            "card2link" => '',
            "cardstyle" => 'mediumgray',
            "cardheight" => '',
            "titlesize" => '',
            "contentwidth" => '',
            "contentsize" => '',
            "carddirection" => 'leftright',
            "elementwidth" => '',
            "cardmargin" => '',
            "tooltipposition" => 'top',
            "imagewidth" => '',
            "cardshape" => '',
            "isgap" => '',
            "gapcolor" => '',
            "followyoffset" => '',
            "link" => ''
          ), $atts));

          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_icon_element_fonts_enqueue($new_card1icon);
            vc_icon_element_fonts_enqueue($new_card2icon);
            vc_icon_element_fonts_enqueue($dividericon);
          }else{
            wp_register_style( 'font-awesome', plugins_url('../faanimation/css/font-awesome.min.css', __FILE__) );
            wp_enqueue_style( 'font-awesome' );
          }
          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $output = '';

          wp_register_style('tooltipster', plugins_url('../appmockup/css/tooltipster.css', __FILE__));
          wp_enqueue_style('tooltipster');
          wp_register_script('tooltipster', plugins_url('../appmockup/js/jquery.tooltipster.min.js', __FILE__), array('jquery'));
          wp_enqueue_script('tooltipster');

          wp_register_style( 'vc-extensions-sidebyside-style', plugins_url('css/style.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-sidebyside-style' );

          wp_register_script('vc-extensions-sidebyside-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "tooltipster"));
          wp_enqueue_script('vc-extensions-sidebyside-script');


          $card1link = vc_build_link($card1link);
          $card2link = vc_build_link($card2link);

          $color_style_arr = array("grapefruit" => array("#ED5565", "#DA4453"), "bittersweet" => array("#FC6E51", "#E9573F"), "sunflower" => array("#FFCE54", "#F6BB42"), "grass" => array("#A0D468", "#8CC152"), "mint" => array("#48CFAD", "#37BC9B"), "aqua" => array("#4FC1E9", "#3BAFDA"), "bluejeans" => array("#5D9CEC", "#4A89DC"), "lavender" => array("#AC92EC", "#967ADC"), "pinkrose" => array("#EC87C0", "#D770AD"), "lightgray" => array("#F5F7FA", "#E6E9ED"), "mediumgray" => array("#CCD1D9", "#AAB2BD"), "darkgray" => array("#656D78", "#434A54"), "customized" => array("$card1bg", "$card2bg") );

          $cardstyle_arr = $color_style_arr[$cardstyle];
          $card1image_full = wp_get_attachment_image_src($card1image, 'full');
          $card2image_full = wp_get_attachment_image_src($card2image, 'full');

          $output .= '<div class="cq-sidebyside-container '.$cardshape.' cq-sidebyside-'.$carddirection.'" data-card1titlecolor="'.$card1titlecolor.'" data-card1contentcolor="'.$card1contentcolor.'" data-card1bg="'.$cardstyle_arr[0].'" data-card2titlecolor="'.$card2titlecolor.'" data-card2contentcolor="'.$card2contentcolor.'" data-card2bg="'.$cardstyle_arr[1].'" data-dividerbg="'.$dividerbg.'" data-dividercolor="'.$dividercolor.'" data-card1iconsize="'.$card1iconsize.'" data-cardheight="'.$cardheight.'" data-dividerborder="'.$dividerborder.'" data-dividerfontsize="'.$dividerfontsize.'" data-dividerwidth="'.$dividerwidth.'" data-dividerheight="'.$dividerheight.'" data-contentsize="'.$contentsize.'" data-titlesize="'.$titlesize.'" data-contentwidth="'.$contentwidth.'" data-card2iconsize="'.$card2iconsize.'" data-elementwidth="'.$elementwidth.'" data-cardmargin="'.$cardmargin.'" data-card1avatar="'.$card1avatar.'" data-card2avatar="'.$card2avatar.'" data-tooltipposition="'.$tooltipposition.'" data-cardshape="'.$cardshape.'" data-isgap="'.$isgap.'" data-gapcolor="'.$gapcolor.'" data-carddirection="'.$carddirection.'" data-followyoffset="'.$followyoffset.'">';
          $output .= '<div class="cq-sidebyside-content '.$isgap.' cq-sidecontent-1" data-cardtitle="'.$card1title.'" data-cardavatar="'.$card1avatar.'" data-iconcolor="'.$card1iconcolor.'">';

          $card_image_temp1 = "";
          $card1image_url = $card1image_full[0];
          if($imagewidth!=""){
              if(function_exists('wpb_resize')){
                  $card_image_temp1 = wpb_resize($card1image, null, $imagewidth, null);
                  $card1image_url = $card_image_temp1['url'];
                  if($card1image_url=="") $card1image_url = $card1image_full[0];
              }
          }

          $output .= '<div class="cq-sidebyside-paragraphy"  data-image="'.$card1image_url.'">';
          if($card1link["url"]!=="") $output .= '<a href="'.$card1link["url"].'" title="'.$card1link["title"].'" target="'.$card1link["target"].'" class="cq-sidebyside-link">';
          if($card1avatar=="image"){
                if($card1image_full[0]!=""){
                      $output .= '<div class="cq-sidebyside-imgcontainer">';
                      $output .= '</div>';
                }
          }else if($card1avatar=="icon"){
              $output .= '<div class="cq-sidebyside-iconcontainer">';
              if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
                if(isset(${'icon_' . $new_card1icon})) $output .= '<i class="cq-sidebyside-cardicon '.esc_attr(${'icon_' . $new_card1icon}).'"></i>';
              }else{
                $output .= '<i class="fa '.$card1icon.' cq-sidebyside-cardicon"></i>';
              }
              if($card1icontext!=""){
                $output .= ' <span class="cq-sidebyside-icontext">';
                $output .= $card1icontext;
                $output .= '</span>';
              }
              $output .= '</div>';
          }
          if($card1title!=""&&$card1avatar!="image"){
              $output .= '<h4 class="cq-sidebyside-title">';
              $output .= $card1title;
              $output .= '</h4>';
          }
          if($card1content!=""){
              $output .= '<span class="cq-sidebyside-text">'.$card1content.'</span>';
          }
          if($card1link["url"]!=="") $output .= '</a>';
          $output .= '</div>';
          $output .= '</div>';
          if($dividertype=="text"){
              if($divider!="") $output .= '<span class="cq-sidebyside-divider">'.rawurldecode(base64_decode($divider)).'</span>';
          }else{
              if (isset(${'divider_icon_' . $dividericon})) {
                $output .= '<span class="cq-sidebyside-divider">';
                $output .= '<i class="'.esc_attr(${'divider_icon_' . $dividericon}).'"></i>';
                $output .= '</span>';
              }
          }
          $output .= '<div class="cq-sidebyside-content '.$isgap.' cq-sidecontent-2" data-cardtitle="'.$card2title.'" data-cardavatar="'.$card2avatar.'" data-iconcolor="'.$card2iconcolor.'">';
          $card_image_temp2 = "";
          $card2image_url = $card2image_full[0];
          if($imagewidth!=""){
              if(function_exists('wpb_resize')){
                  $card_image_temp2 = wpb_resize($card2image, null, $imagewidth, null);
                  $card2image_url = $card_image_temp2['url'];
                  if($card2image_url=="") $card2image_url = $card1image_full[0];
              }
          }

          if($imagewidth!=""){
              $output .= '<div class="cq-sidebyside-paragraphy" data-image="'.$card2image_url.'">';
          }else{
              $output .= '<div class="cq-sidebyside-paragraphy" data-image="'.$card2image_full[0].'">';
          }
          if($card2link["url"]!=="") $output .= '<a href="'.$card2link["url"].'" title="'.$card2link["title"].'" target="'.$card2link["target"].'" class="cq-sidebyside-link">';
          if($card2avatar=="image"){
                if($card2image_full[0]!=""){
                      $output .= '<div class="cq-sidebyside-imgcontainer">';
                      $output .= '</div>';
                }
          }else if($card2avatar=="icon"){
              $output .= '<div class="cq-sidebyside-iconcontainer">';
              if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
                if(isset(${'card2_icon_' . $new_card2icon})) $output .= '<i class="cq-sidebyside-cardicon '.esc_attr(${'card2_icon_' . $new_card2icon}).'"></i>';
              }else{
                $output .= '<i class="fa '.$card2icon.' cq-sidebyside-cardicon"></i>';
              }

              $output .= ' <span class="cq-sidebyside-icontext">';
              $output .= $card2icontext;
              $output .= '</span>';
              $output .= '</div>';
          }
          if($card2title!=""&&$card2avatar!="image"){
              $output .= '<h4 class="cq-sidebyside-title">';
              $output .= $card2title;
              $output .= '</h4>';
          }
          if($card2content!=""){
              $output .= '<span class="cq-sidebyside-text">'.$card2content.'</span>';
          }
          if($card2link["url"]!=="") $output .= '</a>';
          $output .= '</div>';
          $output .= '</div>';
          $output .= '</div>';

          return $output;

        }

  }

}

?>
