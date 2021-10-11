<?php
if (!class_exists('VC_Extensions_AvatarWithPopup')) {
    class VC_Extensions_AvatarWithPopup{
        function __construct() {
          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_map(array(
            "name" => esc_attr__("Avatar with Popup", 'vc_avatarwithpopup_cq'),
            "base" => "cq_vc_avatarwithpopup",
            "class" => "wpb_cq_vc_extension_avatarwithpopup",
            "icon" => "cq_allinone_avatarwithpopup",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Tooltip content', 'js_composer'),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_avatarwithpopup_cq",
                "heading" => esc_attr__("Display avatar in:", "vc_avatarwithpopup_cq"),
                "param_name" => "avatartype",
                "value" => array("Icon (select the icon below)" => "icon", "Image (choose the avatar image below)" => "image"),
                "std" => "no",
                "group" => "Avatar",
                "description" => esc_attr__("", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Avatar Image", "vc_avatarwithpopup_cq"),
                "param_name" => "avatarimage",
                "value" => "",
                "dependency" => Array('element' => "avatartype", 'value' => 'image'),
                "group" => "Avatar",
                "description" => esc_attr__("Select image from media library.", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "heading" => esc_attr__("Resize the avatar image?", "vc_avatarwithpopup_cq"),
                "param_name" => "resizeavatarimage",
                "value" => array("no", "yes (specify the image width below)"=>"yes"),
                "dependency" => Array('element' => "avatartype", 'value' => 'image'),
                "std" => "no",
                "group" => "Avatar",
                "description" => esc_attr__("", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width", "vc_avatarwithpopup_cq"),
                "param_name" => "avatarimagewidth",
                "value" => "",
                "dependency" => Array('element' => "resizeavatarimage", 'value' => array('yes')),
                "group" => "Avatar",
                "description" => esc_attr__("Default we will use the original image, specify a width. For example, 200 will resize the image to width 200. ", "vc_avatarwithpopup_cq")
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
                'dependency' => array('element' => 'avatartype', 'value' => 'icon',
                ),
                "group" => "Avatar",
                'description' => esc_attr__( 'Select icon library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fab fa-twitter', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                  'element' => 'avataricon',
                  'value' => 'fontawesome',
                ),
                "group" => "Avatar",
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
                "group" => "Avatar",
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
                "group" => "Avatar",
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
                "group" => "Avatar",
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
                "group" => "Avatar",
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
                "group" => "Avatar",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("font-size of the avatar icon", "vc_avatarwithpopup_cq"),
                "param_name" => "iconsize",
                "value" => "2em",
                "group" => "Avatar",
                'dependency' => array('element' => 'avatartype', 'value' => 'icon'),
                "description" => esc_attr__("The icon default is 2em, you can specify other value, like 3em or 48px.", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Icon color", 'vc_avatarwithpopup_cq'),
                "param_name" => "iconcolor",
                "value" => '',
                'dependency' => array('element' => 'avatartype', 'value' => 'icon'),
                "group" => "Avatar",
                "description" => esc_attr__("Default is white.", 'vc_avatarwithpopup_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Icon background color", 'vc_avatarwithpopup_cq'),
                "param_name" => "iconbgcolor",
                "value" => '',
                'dependency' => array('element' => 'avatartype', 'value' => 'icon'),
                "group" => "Avatar",
                "description" => esc_attr__("Default is same as the Popup background under the General tab, you can specify it here.", 'vc_avatarwithpopup_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Optional title under the avatar", "vc_avatarwithpopup_cq"),
                "param_name" => "avatartitle",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("Can be a name for the avatar, John Smith for example.", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Optional label under the title", "vc_avatarwithpopup_cq"),
                "param_name" => "avatarlabel",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("Can be a role for the avatar, Web Developer for example.", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Text color for the title and label under the avatar", 'vc_avatarwithpopup_cq'),
                "param_name" => "avatartextcolor",
                "value" => '',
                "group" => "Avatar",
                "description" => esc_attr__("", 'vc_avatarwithpopup_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_avatarwithpopup_cq",
                "heading" => esc_attr__("Avatar shape", "vc_avatarwithpopup_cq"),
                "param_name" => "avatarshape",
                "value" => array("circle" => "avatar-circle", "rounded (small)" => "avatar-roundsmall", "rounded (large)" => "avatar-roundlarge", "square" => "avatar-square"),
                "std" => "circle",
                "group" => "Avatar",
                "description" => esc_attr__("", "vc_avatarwithpopup_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for the Avatar)', 'vc_avatarwithpopup_cq' ),
                'param_name' => 'avatarlink',
                "group" => "Avatar",
                'description' => esc_attr__( '', 'vc_avatarwithpopup_cq' )
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Size of the whole avatar", "vc_avatarwithpopup_cq"),
                "param_name" => "avatarsize",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("The avatar default is 80 in pixel, you can specify other value as you like.", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Title for the popup content (optional)", "vc_avatarwithpopup_cq"),
                "param_name" => "popuptitle",
                "value" => "",
                'group' => 'Text',
                "description" => esc_attr__("", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_attr__("Card content", "vc_avatarwithpopup_cq"),
                "param_name" => "content",
                'group' => 'Text',
                "value" => esc_attr__("", "vc_avatarwithpopup_cq"), "description" => esc_attr__("", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Height of the popup content", "vc_avatarwithpopup_cq"),
                "param_name" => "elementheight",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default popup content's height is auto. You can specify a value (for example, 240px) if you want all the popup content have the same height in a row.", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Font color of the title and content", 'vc_avatarwithpopup_cq'),
                "param_name" => "popupcolor",
                "value" => '',
                'group' => 'Text',
                "description" => esc_attr__("Default is white.", 'vc_avatarwithpopup_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("font-size for the text content", "vc_avatarwithpopup_cq"),
                "param_name" => "contentsize",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default is 14px, you can specify other value here.", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_avatarwithpopup_cq",
                "heading" => esc_attr__("Display the popup when", "vc_avatarwithpopup_cq"),
                "param_name" => "triggerby",
                "value" => array("Display when page is loaded (always visible)" => "bydefault", "User hover (hiden when mouse out)" => "hover1", "User hover (keep visible when mouse out)" => "hover2", "User click (click again to hide it)" => "click", "Auto delay slideshow (display and hide with auto delay, select the time below)" => "slideshow"),
                'std' => 'slideshow',
                "description" => esc_attr__("", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_avatarwithpopup_cq",
                "heading" => esc_attr__("Select the auto delay time", "vc_avatarwithpopup_cq"),
                "param_name" => "delaytime",
                "value" => array("2", "3", "4", "5", "6", "8", "10"),
                'std' => '4',
                "dependency" => Array('element' => "triggerby", 'value' => 'slideshow'),
                "description" => esc_attr__("", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_avatarwithpopup_cq",
                "heading" => esc_attr__("Popup background color", "vc_avatarwithpopup_cq"),
                "param_name" => "popupbackground",
                "value" => array("White" => "white", "Gray" => "gray", "Orange" => "orange", "Red" => "red", "Green" => "green", "Mint" => "mint", "Aqua" => "aqua", "Blue" => "blue", "Lavender" => "lavender", "Pink" => "pink", "Yellow" => "yellow"),
                'std' => 'white',
                "description" => esc_attr__("", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_avatarwithpopup_cq",
                "heading" => esc_attr__("Display avatar and popup with shadow?", "vc_avatarwithpopup_cq"),
                "param_name" => "isshadow",
                "value" => array("Yes (tiny shadow)" => "tinyshadow", "Yes (long shadow)" => "longshadow", "No" => ""),
                "std" => "no",
                "description" => esc_attr__("", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_avatarwithpopup_cq",
                "heading" => esc_attr__("Popup shape", "vc_avatarwithpopup_cq"),
                "param_name" => "popupshape",
                "value" => array("rounded (small)" => "roundsmall", "rounded (large)" => "roundlarge", "square" => ""),
                "std" => "square",
                "description" => esc_attr__("", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "vc_avatarwithpopup_cq"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_avatarwithpopup_cq")
              )

           )
        ));

        }else{

            vc_map(array(
            "name" => esc_attr__("Avatar with Popup", 'vc_avatarwithpopup_cq'),
            "base" => "cq_vc_avatarwithpopup",
            "class" => "wpb_cq_vc_extension_avatarwithpopup",
            "icon" => "cq_allinone_avatarwithpopup",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Tooltip content', 'js_composer'),
            "params" => array(
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Size of the whole avatar", "vc_avatarwithpopup_cq"),
                "param_name" => "avatarsize",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("The avatar default is 80 in pixel, you can specify other value as you like.", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Avatar Image", "vc_avatarwithpopup_cq"),
                "param_name" => "avatarimage",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("Select image from media library.", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "heading" => esc_attr__("Resize the avatar image?", "vc_avatarwithpopup_cq"),
                "param_name" => "resizeavatarimage",
                "value" => array("no", "yes (specify the image width below)"=>"yes"),
                "dependency" => Array('element' => "avatartype", 'value' => 'image'),
                "std" => "no",
                "group" => "Avatar",
                "description" => esc_attr__("", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width", "vc_avatarwithpopup_cq"),
                "param_name" => "avatarimagewidth",
                "value" => "",
                "dependency" => Array('element' => "resizeavatarimage", 'value' => array('yes')),
                "group" => "Avatar",
                "description" => esc_attr__("Default we will use the original image, specify a width here. For example, 200 will resize the image to width 200. ", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Optional title under the avatar", "vc_avatarwithpopup_cq"),
                "param_name" => "avatartitle",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("Can be a name for the avatar, John Smith for example.", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Optional label under the title", "vc_avatarwithpopup_cq"),
                "param_name" => "avatarlabel",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("Can be a role for the avatar, Web Developer for example.", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Text color for the title and label under the avatar", 'vc_avatarwithpopup_cq'),
                "param_name" => "avatartextcolor",
                "value" => '',
                "group" => "Avatar",
                "description" => esc_attr__("", 'vc_avatarwithpopup_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_avatarwithpopup_cq",
                "heading" => esc_attr__("Avatar shape", "vc_avatarwithpopup_cq"),
                "param_name" => "avatarshape",
                "value" => array("circle" => "avatar-circle", "rounded (small)" => "avatar-roundsmall", "rounded (large)" => "avatar-roundlarge", "square" => "avatar-square"),
                "std" => "circle",
                "group" => "Avatar",
                "description" => esc_attr__("", "vc_avatarwithpopup_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for the Avatar)', 'vc_avatarwithpopup_cq' ),
                'param_name' => 'avatarlink',
                "group" => "Avatar",
                'description' => esc_attr__( '', 'vc_avatarwithpopup_cq' )
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Title for the popup content (optional)", "vc_avatarwithpopup_cq"),
                "param_name" => "popuptitle",
                "value" => "",
                'group' => 'Text',
                "description" => esc_attr__("", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_attr__("Card content", "vc_avatarwithpopup_cq"),
                "param_name" => "content",
                'group' => 'Text',
                "value" => esc_attr__("", "vc_avatarwithpopup_cq"), "description" => esc_attr__("", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Height of the popup content", "vc_avatarwithpopup_cq"),
                "param_name" => "elementheight",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default popup content's height is auto. You can specify a value (for example, 240px) if you want all the popup content have the same height in a row.", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Font color of the title and content", 'vc_avatarwithpopup_cq'),
                "param_name" => "popupcolor",
                "value" => '',
                'group' => 'Text',
                "description" => esc_attr__("Default is white.", 'vc_avatarwithpopup_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("font-size for the text content", "vc_avatarwithpopup_cq"),
                "param_name" => "contentsize",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default is 14px, you can specify other value here.", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_avatarwithpopup_cq",
                "heading" => esc_attr__("Display the popup when", "vc_avatarwithpopup_cq"),
                "param_name" => "triggerby",
                "value" => array("By default, display when page is loaded (always visible)" => "bydefault", "User hover (hiden when mouse out)" => "hover1", "User hover (keep visible when mouse out)" => "hover2", "User click (click again to hide it)" => "click", "Auto delay slideshow (display and hide with auto delay, select the time below)" => "slideshow"),
                'std' => 'bydefault',
                "description" => esc_attr__("", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_avatarwithpopup_cq",
                "heading" => esc_attr__("Select the auto delay time", "vc_avatarwithpopup_cq"),
                "param_name" => "delaytime",
                "value" => array("2", "3", "4", "5", "6", "8", "10"),
                'std' => '4',
                "dependency" => Array('element' => "triggerby", 'value' => 'slideshow'),
                "description" => esc_attr__("", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_avatarwithpopup_cq",
                "heading" => esc_attr__("Popup background color", "vc_avatarwithpopup_cq"),
                "param_name" => "popupbackground",
                "value" => array("White" => "white", "Gray" => "gray", "Orange" => "orange", "Red" => "red", "Green" => "green", "Mint" => "mint", "Aqua" => "aqua", "Blue" => "blue", "Lavender" => "lavender", "Pink" => "pink", "Yellow" => "yellow"),
                'std' => 'white',
                "description" => esc_attr__("", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_avatarwithpopup_cq",
                "heading" => esc_attr__("Display avatar and popup with shadow?", "vc_avatarwithpopup_cq"),
                "param_name" => "isshadow",
                "value" => array("Yes (tiny shadow)" => "tinyshadow", "Yes (long shadow)" => "longshadow", "No" => ""),
                "std" => "no",
                "description" => esc_attr__("", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_avatarwithpopup_cq",
                "heading" => esc_attr__("Popup shape", "vc_avatarwithpopup_cq"),
                "param_name" => "popupshape",
                "value" => array("rounded (small)" => "roundsmall", "rounded (large)" => "roundlarge", "square" => ""),
                "std" => "square",
                "description" => esc_attr__("", "vc_avatarwithpopup_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "vc_avatarwithpopup_cq"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_avatarwithpopup_cq")
              )

           )
        ));




        }


        add_shortcode('cq_vc_avatarwithpopup', array($this,'cq_vc_avatarwithpopup_func'));


      }

      function cq_vc_avatarwithpopup_func($atts, $content=null, $tag) {
          $avataricon = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_material = '';
          extract(shortcode_atts(array(
            "icon_fontawesome" => 'fab fa-twitter',
            "icon_openiconic" => 'vc-oi vc-oi-dial',
            "icon_typicons" => 'typcn typcn-adjust-brightness',
            "icon_entypo" => 'entypo-icon entypo-icon-note',
            "icon_linecons" => 'vc_li vc_li-heart',
            "icon_material" => 'vc-material vc-material-cake',
            "avatarimage" => '',
            "avatarimagewidth" => '',
            "resizeavatarimage" => 'no',
            "avataricon" => 'fontawesome',
            "iconsize" => '',
            "avatarsize" => '',
            "avatarshape" => '',
            "iconcolor" => '',
            "iconbgcolor" => '',
            "popupbackground" => '',
            "popuptitle" => '',
            "buttonlabel" => '',
            "popupcolor" => '',
            "avatartype" => 'icon',
            "triggerby" => 'bydefault',
            "delaytime" => '4',
            "avatarlink" => '',
            "isshadow" => '',
            "avatartitle" => '',
            "avatarlabel" => '',
            "avatartextcolor" => '',
            "contentsize" => '',
            "popupshape" => '',
            "elementheight" => '',
            "extraclass" => ""
          ), $atts));

          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_icon_element_fonts_enqueue($avataricon);
          }else{
          }

          $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
          $output = '';
          $avatarlink = vc_build_link($avatarlink);


          wp_register_style('perfect-scrollbar', plugins_url('../draggabletimeline/css/perfect-scrollbar.min.css', __FILE__));
          wp_enqueue_style('perfect-scrollbar');

          wp_register_script('perfect-scrollbar', plugins_url('../draggabletimeline/js/perfect-scrollbar.jquery.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('perfect-scrollbar');

          wp_register_style( 'vc-extensions-avatarwithpopup-style', plugins_url('css/style.min.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-avatarwithpopup-style' );
          wp_enqueue_script('vc-extensions-avatarwithpopup-script');
          wp_register_script('vc-extensions-avatarwithpopup-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "perfect-scrollbar"));
          wp_enqueue_script('vc-extensions-avatarwithpopup-script');


          $img = $avatarimage_org = $avatarimage_url = "";
          $avatarimage_org = wp_get_attachment_image_src($avatarimage, 'full');

          $fullimage = $avatarimage_org[0];
          $avatarimage_url = $fullimage;
          if($resizeavatarimage=="yes"&&$avatarimagewidth!=""){
              if(function_exists('wpb_resize')){
                  $img = wpb_resize($avatarimage, null, $avatarimagewidth, null);
                  $avatarimage_url = $img['url'];
                  if($avatarimage_url=="") $avatarimage_url = $fullimage;
              }
          }

          $i = -1;
          $output = '';
          $link_str = '';
          $output .= '<div class="cq-avatarwithpopup '.$isshadow.' '.$popupshape.' popup-'.$popupbackground.' '.$extraclass.'" data-avatartype="'.$avatartype.'" data-avatarimage="'.$avatarimage_url.'" data-iconcolor="'.$iconcolor.'" data-iconbgcolor="'.$iconbgcolor.'" data-avatarsize="'.$avatarsize.'" data-iconsize="'.$iconsize.'" data-popupcolor="'.$popupcolor.'" data-triggerby="'.$triggerby.'" data-delaytime="'.$delaytime.'" data-avatarshape="'.$avatarshape.'" data-elementheight="'.$elementheight.'" data-avatartextcolor="'.$avatartextcolor.'" data-contentsize="'.$contentsize.'">';

          $output .= '<div class="cq-avatarwithpopup-popup">';
          $output .= '<div class="cq-avatarwithpopup-insidecontainer">';

          if($popuptitle!=""){
              $output .= '<div class="cq-avatarwithpopup-title">';
              $output .= '<h4 class="cq-avatarwithpopup-popuptitle">';
              $output .= $popuptitle;
              $output .= '</h4>';
              $output .= '</div>';
          }

          $output .= '<div class="cq-avatarwithpopup-content">';
          $output .= do_shortcode($content);
          $output .= '</div>';

          $output .= '</div>'; // end of the popup content container
          $output .= '</div>'; // end of the popup content

          if($avatarlink["url"]!=="") $output .= '<a href="'.$avatarlink["url"].'" title="'.$avatarlink["title"].'" target="'.$avatarlink["target"].'" class="cq-avatarwithpopup-avatarlink">';
          $output .= '<div class="cq-avatarwithpopup-avatar avatar-'.$popupbackground.' '.$avatarshape.'">';
          if($avatartype=="icon"){
                $output .= '<i class="cq-avatarwithpopup-icon '.esc_attr(${'icon_' . $avataricon}).'"></i>';

          }else if($avatartype=="image"){
          }

          $output .= '</div>';
          if($avatarlink["url"]!=="") $output .= '</a>';
          if($avatartitle!=""){
              $output .= '<div class="cq-avatarwithpopup-avatartitlecontainer">';
              $output .= '<h5 class="cq-avatarwithpopup-avatartitle">';
              $output .= $avatartitle;
              $output .= '</h5>';
              $output .= '</div>';
          }

          if($avatarlabel!=""){
              $output .= '<div class="cq-avatarwithpopup-avatarlabelcontainer">';
              $output .= '<span class="cq-avatarwithpopup-avatarlabel">';
              $output .= $avatarlabel;
              $output .= '</span>';
              $output .= '</div>';
          }

          $output .= '</div>';

          return $output;

        }



  }

}

?>
