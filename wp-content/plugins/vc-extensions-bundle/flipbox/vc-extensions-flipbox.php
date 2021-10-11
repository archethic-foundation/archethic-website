<?php
if (!class_exists('VC_Extensions_FlipBox')) {
    class VC_Extensions_FlipBox{
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Flip Box", 'vc_flipbox_cq'),
            "base" => "cq_vc_flipbox",
            "class" => "wpb_cq_vc_extension_flipbox",
            "icon" => "cq_allinone_flipbox",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Flip on hover', 'js_composer'),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_flipbox_cq",
                "heading" => esc_attr__("Image (or icon) style for whole element:", "vc_flipbox_cq"),
                "param_name" => "avatarstyle",
                "value" => array("A circle image (or icon), fixed on the top" => "fixed", "Image (or icon) on both cards" => "both"),
                "std" => 'both',
                "group" => "Front Card",
                "description" => esc_attr__("", "vc_flipbox_cq")
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Background image for current card (optional)", "vc_flipbox_cq"),
                "param_name" => "frontfullimage",
                "value" => "",
                "group" => "Front Card",
                "description" => esc_attr__("Select image from media library.", "vc_flipbox_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_flipbox_cq",
                "heading" => esc_attr__("Display current card with:", "vc_flipbox_cq"),
                "param_name" => "avatartype",
                "value" => array("None, text only" => "none", "Small circle image" => "image", "Icon" => "icon"),
                "group" => "Front Card",
                "dependency" => Array('element' => "avatarstyle", 'value' => array('fixed', 'both')),
                "description" => esc_attr__("", "vc_flipbox_cq")
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Header avatar image (will be displayed in circle)", "vc_flipbox_cq"),
                "param_name" => "avatarimage",
                "value" => "",
                "dependency" => Array('element' => "avatartype", 'value' => array('image')),
                "group" => "Front Card",
                "description" => esc_attr__("Select image from media library.", "vc_flipbox_cq")
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
                'param_name' => 'avataricon',
                "dependency" => Array('element' => "avatartype", 'value' => array('icon')),
                "group" => "Front Card",
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
                  'element' => 'avataricon',
                  'value' => 'fontawesome',
                ),
                "group" => "Front Card",
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
                  'element' => 'avataricon',
                  'value' => 'openiconic',
                ),
                "group" => "Front Card",
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
                  'element' => 'avataricon',
                  'value' => 'typicons',
                ),
                "group" => "Front Card",
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
                "group" => "Front Card",
                'dependency' => array(
                  'element' => 'avataricon',
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
                  'element' => 'avataricon',
                  'value' => 'linecons',
                ),
                "group" => "Front Card",
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
                  'element' => 'avataricon',
                  'value' => 'material',
                ),
                "group" => "Front Card",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Front Card title (optional):", "vc_flipbox_cq"),
                "param_name" => "fronttitle",
                "value" => "",
                "group" => "Front Card",
                "description" => esc_attr__("", "vc_flipbox_cq")
              ),
              array(
                "type" => "textarea",
                "heading" => esc_attr__("Front Card content (optional):", "vc_flipbox_cq"),
                "param_name" => "frontcontent",
                "value" => "",
                "group" => "Front Card",
                "description" => esc_attr__("", "vc_flipbox_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Color of the title and content:", 'vc_flipbox_cq'),
                "param_name" => "frontcontentcolor",
                "value" => '',
                "group" => "Front Card",
                "description" => esc_attr__("", 'vc_flipbox_cq')
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Background image for current card (optional)", "vc_flipbox_cq"),
                "param_name" => "backfullimage",
                "value" => "",
                "group" => "Back Card",
                "description" => esc_attr__("Select image from media library.", "vc_flipbox_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_flipbox_cq",
                "heading" => esc_attr__("Display current card with:", "vc_flipbox_cq"),
                "param_name" => "backavatar",
                "value" => array("None, text only" => "none", "Small circle image" => "image", "Icon (select icon below)" => "icon"),
                "dependency" => Array('element' => "avatarstyle", 'value' => array('both')),
                "group" => "Back Card",
                "description" => esc_attr__("", "vc_flipbox_cq")
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Header avatar image", "vc_flipbox_cq"),
                "param_name" => "backimage",
                "value" => "",
                "dependency" => Array('element' => "backavatar", 'value' => array('image')),
                "group" => "Back Card",
                "description" => esc_attr__("Select image from media library.", "vc_flipbox_cq")
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
                'param_name' => 'backicon',
                "dependency" => Array('element' => "backavatar", 'value' => array('icon')),
                "group" => "Back Card",
                'description' => esc_attr__( 'Select icon library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'back_icon_fontawesome',
                'value' => 'fa fa-adjust', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                  'element' => 'backicon',
                  'value' => 'fontawesome',
                ),
                "group" => "Back Card",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'back_icon_openiconic',
                'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'openiconic',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'backicon',
                  'value' => 'openiconic',
                ),
                "group" => "Back Card",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'back_icon_typicons',
                'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'typicons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'backicon',
                  'value' => 'typicons',
                ),
                "group" => "Back Card",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'back_icon_entypo',
                'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'entypo',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                "group" => "Back Card",
                'dependency' => array(
                  'element' => 'backicon',
                  'value' => 'entypo',
                ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'back_icon_linecons',
                'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'linecons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'backicon',
                  'value' => 'linecons',
                ),
                "group" => "Back Card",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'back_icon_material',
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
                  'element' => 'backicon',
                  'value' => 'material',
                ),
                "group" => "Back Card",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Back Card title (optional):", "vc_flipbox_cq"),
                "param_name" => "backtitle",
                "value" => "",
                "group" => "Back Card",
                "description" => esc_attr__("", "vc_flipbox_cq")
              ),
              array(
                "type" => "textarea_html",
                "heading" => esc_attr__("Back Card content (optional):", "vc_flipbox_cq"),
                "param_name" => "content",
                "value" => "",
                "group" => "Back Card",
                "description" => esc_attr__("", "vc_flipbox_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Color of the title and content:", 'vc_flipbox_cq'),
                "param_name" => "backcontentcolor",
                "value" => '',
                "group" => "Back Card",
                "description" => esc_attr__("", 'vc_flipbox_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Back Card button (optional):", "vc_flipbox_cq"),
                "param_name" => "backbutton",
                "value" => "",
                "group" => "Back Card",
                "description" => esc_attr__("", "vc_flipbox_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for the button)', 'vc_flipbox_cq' ),
                'param_name' => 'backbuttonlink',
                "group" => "Back Card",
                'description' => esc_attr__( '', 'vc_flipbox_cq' )
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Button background color:", 'vc_flipbox_cq'),
                "param_name" => "backbuttonbg",
                "value" => '',
                "group" => "Back Card",
                "description" => esc_attr__("", 'vc_flipbox_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Button hover background color:", 'vc_flipbox_cq'),
                "param_name" => "backbuttonhoverbg",
                "value" => '',
                "group" => "Back Card",
                "description" => esc_attr__("", 'vc_flipbox_cq')
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for the whole element)', 'vc_flipbox_cq' ),
                'param_name' => 'link',
                'group' => 'Link',
                'description' => esc_attr__( '', 'vc_flipbox_cq' )
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_flipbox_cq",
                "heading" => esc_attr__("Card transition direction", "vc_flipbox_cq"),
                "param_name" => "flipdirection",
                "value" => array("Vertical" => "bottomtop", "Horizontal" => "rightleft"),
                "description" => esc_attr__("", "vc_flipbox_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_flipbox_cq",
                "heading" => esc_attr__("Card shape", "vc_flipbox_cq"),
                "param_name" => "cardshape",
                "value" => array("rounded" => "", "square" => "square"),
                "description" => esc_attr__("", "vc_flipbox_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_flipbox_cq",
                "heading" => esc_attr__("Card Color style:", "vc_flipbox_cq"),
                "param_name" => "cardstyle",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "Customized color:" => "customized"),
                'std' => 'mediumgray',
                "description" => esc_attr__("", "vc_flipbox_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Front Card background", 'vc_flipbox_cq'),
                "param_name" => "frontbg",
                "value" => '',
                "dependency" => Array('element' => "cardstyle", 'value' => array('customized')),
                "description" => esc_attr__("", 'vc_flipbox_cq')
              ),

              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Back Card background", 'vc_flipbox_cq'),
                "param_name" => "backbg",
                "value" => '',
                "dependency" => Array('element' => "cardstyle", 'value' => array('customized')),
                "description" => esc_attr__("", 'vc_flipbox_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_flipbox_cq",
                "heading" => esc_attr__("Card border (optional):", "vc_flipbox_cq"),
                "param_name" => "cardborder",
                "value" => array("none" => "", "solid" => "solid", "dashed" => "dashed", "dotted" => "dotted"),
                "description" => esc_attr__("", "vc_flipbox_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_flipbox_cq",
                "heading" => esc_attr__("Card border size:", "vc_flipbox_cq"),
                "dependency" => Array('element' => "cardborder", 'value' => array('solid', 'dashed')),
                "param_name" => "cardbordersize",
                "value" => array("1px" => "1px", "2px" => "2px", "3px" => "3px", "4px" => "4px"),
                "description" => esc_attr__("", "vc_flipbox_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Card border color:", 'vc_flipbox_cq'),
                "param_name" => "bordercolor",
                "value" => '',
                "dependency" => Array('element' => "cardborder", 'value' => array('solid', 'dashed')),
                "description" => esc_attr__("Default is #999.", 'vc_flipbox_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_flipbox_cq",
                "heading" => esc_attr__("Apply white border to the avatar?", "vc_flipbox_cq"),
                "param_name" => "isshadow",
                "value" => array("yes" => "cq-shadow", "no" => "cq-noshadow"),
                "description" => esc_attr__("", "vc_flipbox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Size of the Avatar (image or icon):", "vc_flipbox_cq"),
                "param_name" => "avatarsize",
                "value" => "80",
                "description" => esc_attr__("Default is 80(px). You can specify other value here (without the px). Note, font-size will half of it.", "vc_flipbox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("font-size of the title:", "vc_flipbox_cq"),
                "param_name" => "titlesize",
                "value" => "",
                "description" => esc_attr__("Default is 1.4em. You can specify other value here.", "vc_flipbox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("font-size of the content:", "vc_flipbox_cq"),
                "param_name" => "contentsize",
                "value" => "",
                "description" => esc_attr__("Default is 1.1em. You can specify other value here.", "vc_flipbox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Width of the title and content:", "vc_flipbox_cq"),
                "param_name" => "contentwidth",
                "value" => "",
                "description" => esc_attr__("Default is 90%. You can specify other value here.", "vc_flipbox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS margin-top of the card content:", "vc_flipbox_cq"),
                "param_name" => "contentmargintop",
                "value" => "",
                "description" => esc_attr__("The card content is in the middle by default, you can specify the margin-top to control it's position. For example, 12px will move it 12px lower.", "vc_flipbox_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Avatar icon color:", 'vc_flipbox_cq'),
                "param_name" => "iconcolor",
                "value" => '',
                "description" => esc_attr__("You can specify the color for the icon here, default is #666.", 'vc_flipbox_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Avatar background color:", 'vc_flipbox_cq'),
                "param_name" => "iconbg",
                "value" => '',
                "description" => esc_attr__("You can specify the background for the icon here, default is light gray.", 'vc_flipbox_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Width of the whole element:", "vc_flipbox_cq"),
                "param_name" => "elementwidth",
                "value" => "",
                "description" => esc_attr__("Default is 100%.", "vc_flipbox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Height of the whole element:", "vc_flipbox_cq"),
                "param_name" => "elementheight",
                "value" => "",
                "description" => esc_attr__("Default is 200px. You can specify other value here.", "vc_flipbox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS margin of the whole element:", "vc_flipbox_cq"),
                "param_name" => "elementmargin",
                "value" => "",
                "description" => esc_attr__("Default is margin-top of the half size of the avatar. You can specify other value here. For example, 60px 0 0 0 will margin-top for 60px.", "vc_flipbox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "vc_flipbox_cq"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_flipbox_cq")
              )

           )
        ));

        add_shortcode('cq_vc_flipbox', array($this,'cq_vc_flipbox_func'));

      }

      function cq_vc_flipbox_func($atts, $content=null, $tag) {
          $avataricon = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_material = $backicon = $back_icon_fontawesome = $back_icon_openiconic = $back_icon_typicons = $back_icon_entypo = $back_icon_linecons = $back_icon_material = $avatarstyle = '';
          extract(shortcode_atts(array(
            "avatarstyle" => 'both',
            "icon_fontawesome" => 'fa fa-adjust',
            "icon_openiconic" => 'vc-oi vc-oi-dial',
            "icon_typicons" => 'typcn typcn-adjust-brightness',
            "icon_entypo" => 'entypo-icon entypo-icon-note',
            "icon_linecons" => 'vc_li vc_li-heart',
            "icon_material" => 'vc-material vc-material-cake',
            "back_icon_fontawesome" => 'fa fa-adjust',
            "back_icon_openiconic" => 'vc-oi vc-oi-dial',
            "back_icon_typicons" => 'typcn typcn-adjust-brightness',
            "back_icon_entypo" => 'entypo-icon entypo-icon-note',
            "back_icon_linecons" => 'vc_li vc_li-heart',
            "back_icon_material" => 'vc-material vc-material-cake',
            "fronttitle" => '',
            "frontcontent" => '',
            "backcontent" => '',
            "avatartype" => 'none',
            "avatarimage" => '',
            "frontfullimage" => '',
            "backfullimage" => '',
            "avataricon" => 'fontawesome',
            "basic_avataricon" => '',
            "basic_backicon" => '',
            "backavatar" => 'none',
            "backimage" => '',
            "backicon" => 'fontawesome',
            "backtitle" => '',
            "backbutton" => '',
            "backbuttonbg" => '',
            "backbuttonhoverbg" => '',
            "frontbg" => '',
            "backbg" => '',
            "flipdirection" => 'bottomtop',
            "cardstyle" => 'mediumgray',
            "avatarsize" => '80',
            "frontcontentcolor" => '',
            "backcontentcolor" => '',
            "contentsize" => '',
            "contentwidth" => '',
            "iconcolor" => '',
            "iconbg" => '',
            "cardborder" => '',
            "bordercolor" => '#999',
            "isshadow" => '',
            "elementmargin" => '',
            "elementheight" => '',
            "elementwidth" => '',
            "backbuttonlink" => '',
            "titlesize" => '',
            "cardbordersize" => '',
            "contentmargintop" => '',
            "cardshape" => '',
            "extraclass" => '',
            "link" => ''
          ), $atts));

          $color_style_arr = array("grapefruit" => array("#ED5565", "#DA4453"), "bittersweet" => array("#FC6E51", "#E9573F"), "sunflower" => array("#FFCE54", "#F6BB42"), "grass" => array("#A0D468", "#8CC152"), "mint" => array("#48CFAD", "#37BC9B"), "aqua" => array("#4FC1E9", "#3BAFDA"), "bluejeans" => array("#5D9CEC", "#4A89DC"), "lavender" => array("#AC92EC", "#967ADC"), "pinkrose" => array("#EC87C0", "#D770AD"), "lightgray" => array("#F5F7FA", "#E6E9ED"), "mediumgray" => array("#CCD1D9", "#AAB2BD"), "darkgray" => array("#656D78", "#434A54"), "customized" => array("$frontbg", "$backbg") );
          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $output = '';

          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_icon_element_fonts_enqueue($avataricon);
            vc_icon_element_fonts_enqueue($backicon);
          }else{
            wp_register_style( 'font-awesome', plugins_url('../faanimation/css/font-awesome.min.css', __FILE__) );
            wp_enqueue_style( 'font-awesome' );
          }


          wp_register_style( 'vc-extensions-flipbox-style', plugins_url('css/style.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-flipbox-style' );
          wp_register_script('vc-extensions-flipbox-script', plugins_url('js/init.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('vc-extensions-flipbox-script');
          $link = vc_build_link($link);
          $backbuttonlink = vc_build_link($backbuttonlink);
          $avatarattachment = get_post($avatarimage);
          $avatarimage_full = wp_get_attachment_image_src($avatarimage, 'full');
          $backattachment = get_post($backimage);
          $backimage_full = wp_get_attachment_image_src($backimage, 'full');
          $frontfullimage = wp_get_attachment_image_src($frontfullimage, 'full');
          $backfullimage = wp_get_attachment_image_src($backfullimage, 'full');
          $cardstyle_arr = $color_style_arr[$cardstyle];
          $fontcolor = '';
          if($cardstyle=="lightgray"){
            $fontcolor = "#666";
          }
          $cq_card_face_1 = $cq_card_face2 = '';
          if($flipdirection=="bottomtop"){
            $cq_card_face_1 = 'cq-flipbox-left';
            $cq_card_face_2 = 'cq-flipbox-right';
          }else{
            $cq_card_face_1 = 'cq-flipbox-front';
            $cq_card_face_2 = 'cq-flipbox-back';
          }
          $output .= '<div class="'.$extraclass.' cq-flipbox-container cq-'.$flipdirection.'" data-frontbg="'.$cardstyle_arr[0].'" data-backbg="'.$cardstyle_arr[1].'" data-fontcolor="'.$fontcolor.'" data-face1="'.$cq_card_face_1.'" data-face2="'.$cq_card_face_2.'" data-flipdirection="'.$flipdirection.'" data-elementheight="'.$elementheight.'" data-avatarsize="'.$avatarsize.'" data-frontcontentcolor="'.$frontcontentcolor.'" data-backcontentcolor="'.$backcontentcolor.'" data-titlesize="'.$titlesize.'" data-contentsize="'.$contentsize.'" data-contentwidth="'.$contentwidth.'" data-iconcolor="'.$iconcolor.'" data-iconbg="'.$iconbg.'" data-elementmargin="'.$elementmargin.'" data-elementwidth="'.$elementwidth.'" data-cardborder="'.$cardborder.'" data-cardbordersize="'.$cardbordersize.'" data-bordercolor="'.$bordercolor.'" data-backbuttonbg="'.$backbuttonbg.'" data-backbuttonhoverbg="'.$backbuttonhoverbg.'" data-contentmargintop="'.$contentmargintop.'" data-cardshape="'.$cardshape.'" data-frontfullimage="'.$frontfullimage[0].'" data-avatartype="'.$avatartype.'" data-backfullimage="'.$backfullimage[0].'" data-backavatar="'.$backavatar.'">';

          if($link["url"]!=="") $output .= '<a href="'.$link["url"].'" title="'.$link["title"].'" target="'.$link["target"].'" class="cq-flipbox-link">';

          $avatar_temp = $avatarthumb = "";
          $fullimage = $avatarimage_full[0];
          $avatarthumb = $fullimage;
          if($avatarsize!=""){
              if(function_exists('wpb_resize')){
                  $avatar_temp = wpb_resize($avatarimage, null, $avatarsize*2, $avatarsize*2, true);
                  $avatarthumb = $avatar_temp['url'];
                  if($avatarthumb=="") $avatarthumb = $fullimage;
              }
          }
          if($avatarstyle=="fixed"){
              if($avatartype=="image"){

                if($avatarimage[0]!="")$output .= '<img src="'.$avatarthumb.'" width="'.$avatarsize.'" height="'.$avatarsize.'" class="cq-flipbox-avatar '.$isshadow.'" alt="'.get_post_meta($avatarattachment->ID, '_wp_attachment_image_alt', true ).'" />';
              }elseif ($avatartype=="icon") {
                if(version_compare(WPB_VC_VERSION,  "4.4")>=0&&isset(${'icon_' . $avataricon})){
                  $output .= '<i class="cq-flipbox-avatar '.$isshadow.' '.esc_attr(${'icon_' . $avataricon}).'"></i>';
                }else{
                  if($basic_avataricon!=""){
                    $output .= '<i class="fa cq-flipbox-avatar '.$isshadow.' '.$basic_avataricon.'"></i>';
                  }
                }
              }

          }

          $output .= '<div class="cq-flipbox-flipper">';
          $output .= '<div class="cq-flipbox-item '.$cq_card_face_1.'" onclick="">';
          $output .= '<div class="cq-flipbox-content">';
          if($avatarstyle=="both"){
              if($avatartype=="image"){
                if($avatarimage[0]!="")$output .= '<img src="'.$avatarthumb.'" width="'.$avatarsize.'" height="'.$avatarsize.'" class="cq-flipbox-cardavatar '.$isshadow.'" alt="'.get_post_meta($avatarattachment->ID, '_wp_attachment_image_alt', true ).'" />';
              }elseif ($avatartype=="icon") {
                  if(version_compare(WPB_VC_VERSION,  "4.4")>=0&&isset(${'icon_' . $avataricon})){
                      $output .= '<i class="cq-flipbox-cardavatar '.$isshadow.' '.esc_attr(${'icon_' . $avataricon}).'"></i>';
                    }else{
                      if($basic_avataricon!="") $output .= '<i class="fa cq-flipbox-cardavatar '.$isshadow.' '.$basic_avataricon.'"></i>';
                  }
              }
          }
          if($fronttitle!=""){
              $output .= '<h4 class="cq-flipbox-title">';
              $output .= $fronttitle;
              $output .= '</h4>';
          }
          $output .= $frontcontent;
          $output .= '</div>';
          $output .= '</div>';
          $output .= '<div class="cq-flipbox-item '.$cq_card_face_2.'" onclick="">';
          $output .= '<div class="cq-flipbox-content">';
          if($backavatar=="image"){

                $back_avatar_temp = $backthumb = "";
                $back_full_image = $backimage_full[0];
                $backthumb = $back_full_image;
                if($avatarsize!=""){
                    if(function_exists('wpb_resize')){
                        $back_avatar_temp = wpb_resize($backimage, null, $avatarsize*2, $avatarsize*2, true);
                        $backthumb = $back_avatar_temp['url'];
                        if($backthumb=="") $backthumb = $back_full_image;
                    }
                }


              if($backimage[0]!="") $output .= '<img src="'.$backthumb.'" width="'.$avatarsize.'" height="'.$avatarsize.'" class="cq-flipbox-cardavatar '.$isshadow.'" alt="'.get_post_meta($backattachment->ID, '_wp_attachment_image_alt', true ).'" />';
          }elseif ($backavatar=="icon") {
            if(version_compare(WPB_VC_VERSION,  "4.4")>=0&&isset(${'back_icon_' . $backicon})){
                  $output .= '<i class="cq-flipbox-cardavatar '.$isshadow.' '.esc_attr(${'back_icon_' . $backicon}).'"></i>';
              }else{
                  if($basic_backicon!="") $output .= '<i class="fa cq-flipbox-cardavatar '.$isshadow.' '.$basic_backicon.'"></i>';
              }
          }

          if($backtitle!=""){
              $output .= '<h4 class="cq-flipbox-title">';
              $output .= $backtitle;
              $output .= '</h4>';
          }
          $output .= $content;
          if($backbutton!=""){
              $output .= '<div class="cq-flipbox-button-container">';
              if($backbuttonlink["url"]!=="") $output .= '<a href="'.$backbuttonlink["url"].'" title="'.$backbuttonlink["title"].'" target="'.$backbuttonlink["target"].'" class="cq-flipbox-buttonlink">';
              $output .= '<span class="cq-flipbox-button">';
              $output .= $backbutton;
              $output .= '</span>';
              if($backbuttonlink["url"]!=="") $output .= '</a>';
              $output .= '</div>';
          }
          $output .= '</div>';
          $output .= '</div>';
          $output .= '</div>';
          if($link["url"]!=="") $output .= '</a>';
          $output .= '</div>';
          return $output;

        }

  }

}

?>
