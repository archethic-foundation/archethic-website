<?php
if (!class_exists('VC_Extensions_CubeBox')) {
    class VC_Extensions_CubeBox{
        function __construct() {
          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_map(array(
            "name" => esc_attr__("Cube Box", 'vc_cubebox_cq'),
            "base" => "cq_vc_cubebox",
            "class" => "wpb_cq_vc_extension_cubebox",
            "icon" => "cq_allinone_cubebox",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Rotate on hover', 'js_composer'),
            "params" => array(
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Background image for current card (optional)", "vc_cubebox_cq"),
                "param_name" => "frontfullimage",
                "value" => "",
                "group" => "Front Card",
                "description" => esc_attr__("Select image from media library.", "vc_cubebox_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_cubebox_cq",
                "heading" => esc_attr__("Display with:", "vc_cubebox_cq"),
                "param_name" => "frontavatar",
                "value" => array("Text only" => "none", "Icon (select icon below)" => "icon", "Small (circle) Image" => "image"),
                "group" => "Front Card",
                "description" => esc_attr__("", "vc_cubebox_cq")
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Image", "vc_cubebox_cq"),
                "param_name" => "frontimage",
                "value" => "",
                "dependency" => Array('element' => "frontavatar", 'value' => array('image')),
                "group" => "Front Card",
                "description" => esc_attr__("Select image from media library.", "vc_cubebox_cq")
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
                'param_name' => 'fronticon',
                "dependency" => Array('element' => "frontavatar", 'value' => array('icon')),
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
                  'element' => 'fronticon',
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
                  'element' => 'fronticon',
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
                  'element' => 'fronticon',
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
                  'element' => 'fronticon',
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
                  'element' => 'fronticon',
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
                  'element' => 'fronticon',
                  'value' => 'material',
                ),
                "group" => "Front Card",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Front Card title (optional):", "vc_cubebox_cq"),
                "param_name" => "fronttitle",
                "value" => "",
                "group" => "Front Card",
                "description" => esc_attr__("", "vc_cubebox_cq")
              ),
              array(
                "type" => "textarea",
                "heading" => esc_attr__("Front Card content (optional):", "vc_cubebox_cq"),
                "param_name" => "frontcontent",
                "value" => "",
                "group" => "Front Card",
                "description" => esc_attr__("", "vc_cubebox_cq")
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Background image for current card (optional)", "vc_cubebox_cq"),
                "param_name" => "backfullimage",
                "value" => "",
                "group" => "Back Card",
                "description" => esc_attr__("Select image from media library.", "vc_cubebox_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_cubebox_cq",
                "heading" => esc_attr__("Display with:", "vc_cubebox_cq"),
                "param_name" => "backavatar",
                "value" => array("Text only" => "none", "Icon (select icon below)" => "icon", "Small (circle) Image" => "image"),
                "group" => "Back Card",
                "description" => esc_attr__("", "vc_cubebox_cq")
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Image", "vc_cubebox_cq"),
                "param_name" => "backimage",
                "value" => "",
                "dependency" => Array('element' => "backavatar", 'value' => array('image')),
                "group" => "Back Card",
                "description" => esc_attr__("Select image from media library.", "vc_cubebox_cq")
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
                "heading" => esc_attr__("Back Card title (optional):", "vc_cubebox_cq"),
                "param_name" => "backtitle",
                "value" => "",
                "group" => "Back Card",
                "description" => esc_attr__("", "vc_cubebox_cq")
              ),
              array(
                "type" => "textarea",
                "heading" => esc_attr__("Back Card content (optional):", "vc_cubebox_cq"),
                "param_name" => "backcontent",
                "value" => "",
                "group" => "Back Card",
                "description" => esc_attr__("", "vc_cubebox_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for the whole Cube)', 'vc_cubebox_cq' ),
                'param_name' => 'link',
                'group' => 'Link',
                'description' => esc_attr__( '', 'vc_cubebox_cq' )
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_cubebox_cq",
                "heading" => esc_attr__("Auto rotate Cube", "vc_cubebox_cq"),
                "param_name" => "rotatecube",
                'value' => array(2, 3, 4, 5, 7, 10, esc_attr__( 'Disable', 'vc_cubebox_cq' ) => 0 ),
                'std' => 0,
                'group' => 'Auto rotate?',
                "description" => esc_attr__("Auto rotate Cube in each X seconds.", "vc_cubebox_cq")
              ),

              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_cubebox_cq",
                "heading" => esc_attr__("Cube Color style:", "vc_cubebox_cq"),
                "param_name" => "cardstyle",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "Customized color:" => "customized"),
                'std' => 'mediumgray',
                "description" => esc_attr__("", "vc_cubebox_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Front Card background", 'vc_cubebox_cq'),
                "param_name" => "frontbg",
                "value" => '',
                "dependency" => Array('element' => "cardstyle", 'value' => array('customized')),
                "description" => esc_attr__("", 'vc_cubebox_cq')
              ),

              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Back Card background", 'vc_cubebox_cq'),
                "param_name" => "backbg",
                "value" => '',
                "dependency" => Array('element' => "cardstyle", 'value' => array('customized')),
                "description" => esc_attr__("", 'vc_cubebox_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_cubebox_cq",
                "heading" => esc_attr__("Cube transition direction", "vc_cubebox_cq"),
                "param_name" => "cubedirection",
                "value" => array("Bottom to top" => "bottomtop", "Right to left" => "rightleft"),
                "description" => esc_attr__("", "vc_cubebox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Width of the whole Cube:", "vc_cubebox_cq"),
                "param_name" => "cubewidth",
                "value" => "",
                "description" => esc_attr__("Default is 90%.", "vc_cubebox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Height of the whole Cube:", "vc_cubebox_cq"),
                "param_name" => "cubeheight",
                "value" => "",
                "description" => esc_attr__("Default is 200px. You can specify other value here.", "vc_cubebox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Size of the Avatar (image or icon):", "vc_cubebox_cq"),
                "param_name" => "avatarsize",
                "value" => "80",
                "description" => esc_attr__("Default is 80(px). You can specify other value here (without the px).", "vc_cubebox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("font-size of the title:", "vc_cubebox_cq"),
                "param_name" => "titlesize",
                "value" => "",
                "description" => esc_attr__("Default is 1.8em. You can specify other value here.", "vc_cubebox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("font-size of the content:", "vc_cubebox_cq"),
                "param_name" => "contentsize",
                "value" => "",
                "description" => esc_attr__("Default is 1em. You can specify other value here.", "vc_cubebox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Width of the title and content:", "vc_cubebox_cq"),
                "param_name" => "contentwidth",
                "value" => "",
                "description" => esc_attr__("Default is 90%. You can specify other value here.", "vc_cubebox_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Avatar icon color:", 'vc_cubebox_cq'),
                "param_name" => "iconcolor",
                "value" => '',
                "description" => esc_attr__("You can specify the color for the icon here, default is same as the title and content color.", 'vc_cubebox_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Color of the title and content:", 'vc_cubebox_cq'),
                "param_name" => "contentcolor",
                "value" => '',
                "description" => esc_attr__("", 'vc_cubebox_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS margin of the whole Cube:", "vc_cubebox_cq"),
                "param_name" => "cubemargin",
                "value" => "",
                "description" => esc_attr__("Default is 12px 0 0 0, which stand for margin-top 12px. You can specify other value here.", "vc_cubebox_cq")
              )

           )
        ));


          }else{
            vc_map(array(
            "name" => esc_attr__("Cube Box", 'vc_cubebox_cq'),
            "base" => "cq_vc_cubebox",
            "class" => "wpb_cq_vc_extension_cubebox",
            "icon" => "cq_allinone_cubebox",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Rotate on hover', 'js_composer'),
            "params" => array(
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Background image for current card (optional)", "vc_cubebox_cq"),
                "param_name" => "frontfullimage",
                "value" => "",
                "group" => "Front Card",
                "description" => esc_attr__("Select image from media library.", "vc_cubebox_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_cubebox_cq",
                "heading" => esc_attr__("Display with:", "vc_cubebox_cq"),
                "param_name" => "frontavatar",
                "value" => array("Text only" => "none", "Icon (select icon below)" => "icon", "Small (circle) Image" => "image"),
                "group" => "Front Card",
                "description" => esc_attr__("", "vc_cubebox_cq")
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Image", "vc_cubebox_cq"),
                "param_name" => "frontimage",
                "value" => "",
                "dependency" => Array('element' => "frontavatar", 'value' => array('image')),
                "group" => "Front Card",
                "description" => esc_attr__("Select image from media library.", "vc_cubebox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Header icon:", "vc_cubebox_cq"),
                "param_name" => "fronticon",
                "value" => "",
                "group" => "Front Card",
                "dependency" => Array('element' => "frontavatar", 'value' => array('icon')),
                "description" => esc_attr__("For example fa-twitter will insert a Twitter <a href='http://fortawesome.github.io/Font-Awesome/icons/' target='_blank'>Font Awesome icon</a>", "vc_cubebox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Front Card title (optional):", "vc_cubebox_cq"),
                "param_name" => "fronttitle",
                "value" => "",
                "group" => "Front Card",
                "description" => esc_attr__("", "vc_cubebox_cq")
              ),
              array(
                "type" => "textarea",
                "heading" => esc_attr__("Front Card content (optional):", "vc_cubebox_cq"),
                "param_name" => "frontcontent",
                "value" => "",
                "group" => "Front Card",
                "description" => esc_attr__("", "vc_cubebox_cq")
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Background image for current card (optional)", "vc_cubebox_cq"),
                "param_name" => "backfullimage",
                "value" => "",
                "group" => "Back Card",
                "description" => esc_attr__("Select image from media library.", "vc_cubebox_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_cubebox_cq",
                "heading" => esc_attr__("Display with:", "vc_cubebox_cq"),
                "param_name" => "backavatar",
                "value" => array("Text only" => "none", "Icon (select icon below)" => "icon", "Small (circle) Image" => "image"),
                "group" => "Back Card",
                "description" => esc_attr__("", "vc_cubebox_cq")
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Image", "vc_cubebox_cq"),
                "param_name" => "backimage",
                "value" => "",
                "dependency" => Array('element' => "backavatar", 'value' => array('image')),
                "group" => "Back Card",
                "description" => esc_attr__("Select image from media library.", "vc_cubebox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Header icon:", "vc_cubebox_cq"),
                "param_name" => "backicon",
                "value" => "",
                "group" => "Back Card",
                "dependency" => Array('element' => "backavatar", 'value' => array('icon')),
                "description" => esc_attr__("For example fa-twitter will insert a Twitter <a href='http://fortawesome.github.io/Font-Awesome/icons/' target='_blank'>Font Awesome icon</a>", "vc_cubebox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Back Card title (optional):", "vc_cubebox_cq"),
                "param_name" => "backtitle",
                "value" => "",
                "group" => "Back Card",
                "description" => esc_attr__("", "vc_cubebox_cq")
              ),
              array(
                "type" => "textarea",
                "heading" => esc_attr__("Back Card content (optional):", "vc_cubebox_cq"),
                "param_name" => "backcontent",
                "value" => "",
                "group" => "Back Card",
                "description" => esc_attr__("", "vc_cubebox_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for the whole Cube)', 'vc_cubebox_cq' ),
                'param_name' => 'link',
                'group' => 'Link',
                'description' => esc_attr__( '', 'vc_cubebox_cq' )
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_cubebox_cq",
                "heading" => esc_attr__("Auto rotate Cube", "vc_cubebox_cq"),
                "param_name" => "rotatecube",
                'value' => array(2, 3, 4, 5, 7, 10, esc_attr__( 'Disable', 'vc_cubebox_cq' ) => 0 ),
                'std' => 0,
                'group' => 'Auto rotate?',
                "description" => esc_attr__("Auto rotate Cube in each X seconds.", "vc_cubebox_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_cubebox_cq",
                "heading" => esc_attr__("Cube Color style:", "vc_cubebox_cq"),
                "param_name" => "cardstyle",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "Customized color:" => "customized"),
                'std' => 'mediumgray',
                "description" => esc_attr__("", "vc_cubebox_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Front Card background", 'vc_cubebox_cq'),
                "param_name" => "frontbg",
                "value" => '',
                "dependency" => Array('element' => "cardstyle", 'value' => array('customized')),
                "description" => esc_attr__("", 'vc_cubebox_cq')
              ),

              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Back Card background", 'vc_cubebox_cq'),
                "param_name" => "backbg",
                "value" => '',
                "dependency" => Array('element' => "cardstyle", 'value' => array('customized')),
                "description" => esc_attr__("", 'vc_cubebox_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_cubebox_cq",
                "heading" => esc_attr__("Cube transition direction", "vc_cubebox_cq"),
                "param_name" => "cubedirection",
                "value" => array("Bottom to top" => "bottomtop", "Right to left" => "rightleft"),
                "description" => esc_attr__("", "vc_cubebox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Width of the whole Cube:", "vc_cubebox_cq"),
                "param_name" => "cubewidth",
                "value" => "",
                "description" => esc_attr__("Default is 90%.", "vc_cubebox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Height of the whole Cube:", "vc_cubebox_cq"),
                "param_name" => "cubeheight",
                "value" => "",
                "description" => esc_attr__("Default is 200px. You can specify other value here.", "vc_cubebox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Size of the Avatar (image or icon):", "vc_cubebox_cq"),
                "param_name" => "avatarsize",
                "value" => "80",
                "description" => esc_attr__("Default is 80(px). You can specify other value here (without the px).", "vc_cubebox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("font-size of the title:", "vc_cubebox_cq"),
                "param_name" => "titlesize",
                "value" => "",
                "description" => esc_attr__("Default is 1.8em. You can specify other value here.", "vc_cubebox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("font-size of the content:", "vc_cubebox_cq"),
                "param_name" => "contentsize",
                "value" => "",
                "description" => esc_attr__("Default is 1em. You can specify other value here.", "vc_cubebox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Width of the title and content:", "vc_cubebox_cq"),
                "param_name" => "contentwidth",
                "value" => "",
                "description" => esc_attr__("Default is 90%. You can specify other value here.", "vc_cubebox_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Avatar Font Awesome icon color:", 'vc_cubebox_cq'),
                "param_name" => "iconcolor",
                "value" => '',
                "description" => esc_attr__("You can specify the color for the icon here, default is same as the title and content color.", 'vc_cubebox_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Color of the title and content:", 'vc_cubebox_cq'),
                "param_name" => "contentcolor",
                "value" => '',
                "description" => esc_attr__("", 'vc_cubebox_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS margin of the whole Cube:", "vc_cubebox_cq"),
                "param_name" => "cubemargin",
                "value" => "",
                "description" => esc_attr__("Default is 12px 0 0 0, which stand for margin-top 12px. You can specify other value here.", "vc_cubebox_cq")
              )

           )
        ));


        }


        add_shortcode('cq_vc_cubebox', array($this,'cq_vc_cubebox_func'));

      }

      function cq_vc_cubebox_func($atts, $content=null, $tag) {
          $fronticon = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_material = $backicon = $back_icon_fontawesome = $back_icon_openiconic = $back_icon_typicons = $back_icon_entypo = $back_icon_linecons = $back_icon_material = '';
            extract(shortcode_atts(array(
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
              "cubeheight" => '',
              "fronttitle" => '',
              "frontcontent" => '',
              "backcontent" => '',
              "frontavatar" => 'none',
              "frontimage" => '',
              "fronticon" => 'fontawesome',
              "backavatar" => 'none',
              "backimage" => '',
              "backicon" => 'fontawesome',
              "backtitle" => '',
              "frontbg" => '',
              "backbg" => '',
              "cubedirection" => 'bottomtop',
              "cardstyle" => 'mediumgray',
              "avatarsize" => '80',
              "contentcolor" => '',
              "contentsize" => '',
              "titlesize" => '',
              "contentwidth" => '',
              "rotatecube" => '',
              "iconcolor" => '',
              "cubemargin" => '',
              "cubewidth" => '',
              "frontfullimage" => '',
              "backfullimage" => '',
              "link" => ''
            ), $atts));
          $color_style_arr = array("grapefruit" => array("#ED5565", "#DA4453"), "bittersweet" => array("#FC6E51", "#E9573F"), "sunflower" => array("#FFCE54", "#F6BB42"), "grass" => array("#A0D468", "#8CC152"), "mint" => array("#48CFAD", "#37BC9B"), "aqua" => array("#4FC1E9", "#3BAFDA"), "bluejeans" => array("#5D9CEC", "#4A89DC"), "lavender" => array("#AC92EC", "#967ADC"), "pinkrose" => array("#EC87C0", "#D770AD"), "lightgray" => array("#F5F7FA", "#E6E9ED"), "mediumgray" => array("#CCD1D9", "#AAB2BD"), "darkgray" => array("#656D78", "#434A54"), "customized" => array("$frontbg", "$backbg") );
          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $output = '';

          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_icon_element_fonts_enqueue($fronticon);
            vc_icon_element_fonts_enqueue($backicon);
          }else{
            wp_register_style( 'font-awesome', plugins_url('../faanimation/css/font-awesome.min.css', __FILE__) );
            wp_enqueue_style( 'font-awesome' );
          }

          wp_register_style( 'vc-extensions-cubebox-style', plugins_url('css/style.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-cubebox-style' );
          wp_register_script('vc-extensions-cubebox-script', plugins_url('js/init.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('vc-extensions-cubebox-script');
          $link = vc_build_link($link);
          $frontimage_avatar = wp_get_attachment_image_src($frontimage, 'full');
          $backimage_avatar = wp_get_attachment_image_src($backimage, 'full');
          $frontfullimage = wp_get_attachment_image_src($frontfullimage, 'full');
          $backfullimage = wp_get_attachment_image_src($backfullimage, 'full');
          $cardstyle_arr = $color_style_arr[$cardstyle];
          $fontcolor = '';
          if($cardstyle=="lightgray"){
            $fontcolor = "#666";
          }
          $cq_card_face_1 = $cq_card_face2 = '';
          if($cubedirection=="bottomtop"){
            $cq_card_face_1 = 'cq-face-front';
            $cq_card_face_2 = 'cq-face-back';
          }else{
            $cq_card_face_1 = 'cq-face-left';
            $cq_card_face_2 = 'cq-face-right';
          }
          $output .= '<div class="cq-twoface-box-container" data-frontbg="'.$cardstyle_arr[0].'" data-backbg="'.$cardstyle_arr[1].'" data-fontcolor="'.$fontcolor.'" data-face1="'.$cq_card_face_1.'" data-face2="'.$cq_card_face_2.'" data-cubedirection="'.$cubedirection.'" data-cubeheight="'.$cubeheight.'" data-avatarsize="'.$avatarsize.'" data-contentcolor="'.$contentcolor.'" data-contentsize="'.$contentsize.'" data-titlesize="'.$titlesize.'" data-contentwidth="'.$contentwidth.'" data-rotatecube="'.$rotatecube.'" data-iconcolor="'.$iconcolor.'" data-cubemargin="'.$cubemargin.'" data-cubewidth="'.$cubewidth.'" data-frontavatar="'.$frontavatar.'" data-frontfullimage="'.$frontfullimage[0].'" data-backavatar="'.$backavatar.'" data-backfullimage="'.$backfullimage[0].'">';

          if($link["url"]!=="") $output .= '<a href="'.$link["url"].'" title="'.$link["title"].'" target="'.$link["target"].'" class="cq-twoface-link">';
          $output .= '<div class="cq-twoface-box">';
          $output .= '<div class="cq-face-item '.$cq_card_face_1.'">';
          $output .= '<div class="cq-face-content">';
          if($frontavatar=="image"){
              $img1 = $thumbnail1 = "";
              $fullimage1 = $frontimage_avatar[0];
              $thumbnail1 = $fullimage1;
              if($avatarsize!=""){
                  if(function_exists('wpb_resize')){
                      $img1 = wpb_resize($frontimage, null, $avatarsize*2, $avatarsize*2, true);
                      $thumbnail1 = $img1['url'];
                      if($thumbnail1=="") $thumbnail1 = $fullimage1;
                  }
              }

              if($frontimage_avatar[0]!="") $output .= '<img src="'.$thumbnail1.'" width="'.$avatarsize.'" height="'.$avatarsize.'" class="cq-face-avatar" />';
          }elseif ($frontavatar=="icon") {
              if(version_compare(WPB_VC_VERSION,  "4.4")>=0&&isset(${'icon_' . $fronticon})){
                  $output .= '<i class="cq-face-avatar '.esc_attr(${'icon_' . $fronticon}).'"></i>';
              }else{
                  $output .= '<i class="fa cq-face-avatar '.$fronticon.'"></i>';
              }
          }else if($frontavatar=="fullimage"){
          }
          if($fronttitle!=""){
              $output .= '<h4 class="cq-face-title">';
              $output .= $fronttitle;
              $output .= '</h4>';
          }
          $output .= $frontcontent;
          $output .= '</div>';
          $output .= '</div>';
          $output .= '<div class="cq-face-item '.$cq_card_face_2.'">';
          $output .= '<div class="cq-face-content">';

          $img2 = $thumbnail2 = "";
          $fullimage2 = $backimage_avatar[0];
          $thumbnail2 = $fullimage2;
          if($avatarsize!=""){
              if(function_exists('wpb_resize')){
                  $img2 = wpb_resize($backimage, null, $avatarsize*2, $avatarsize*2, true);
                  $thumbnail2 = $img2['url'];
                  if($thumbnail2=="") $thumbnail2 = $fullimage2;
              }
          }
          if($backavatar=="image"){
              if($backimage_avatar[0]!="")$output .= '<img src="'.$thumbnail2.'" width="'.$avatarsize.'" height="'.$avatarsize.'" class="cq-face-avatar" />';
          }elseif ($backavatar=="icon") {
            if(version_compare(WPB_VC_VERSION,  "4.4")>=0&&isset(${'back_icon_' . $backicon})){
                  $output .= '<i class="cq-face-avatar '.esc_attr(${'back_icon_' . $backicon}).'"></i>';
              }else{
                  $output .= '<i class="fa cq-face-avatar '.$backicon.'"></i>';
              }
          }

          if($backtitle!=""){
              $output .= '<h4 class="cq-face-title">';
              $output .= $backtitle;
              $output .= '</h4>';
          }
          $output .= $backcontent;
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
