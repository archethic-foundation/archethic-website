<?php
if (!class_exists('VC_Extensions_GradientBox')) {
    class VC_Extensions_GradientBox{
        function __construct() {
          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_map(array(
            "name" => esc_attr__("Gradient Box", 'vc_gradientbox_cq'),
            "base" => "cq_vc_gradientbox",
            "class" => "wpb_cq_vc_extension_gradientbox",
            "icon" => "cq_allinone_gradientbox",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Content with image or icon', 'js_composer'),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_gradientbox_cq",
                "heading" => esc_attr__("Display avatar on the top:", "vc_gradientbox_cq"),
                "param_name" => "avatartype",
                "value" => array("None (text only)" => "none", "Icon (select icon below)" => "icon", "Image" => "image"),
                "group" => "Avatar",
                "description" => esc_attr__("", "vc_gradientbox_cq")
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Image", "vc_gradientbox_cq"),
                "param_name" => "avatarimage",
                "value" => "",
                "dependency" => Array('element' => "avatartype", 'value' => array('image')),
                "group" => "Avatar",
                "description" => esc_attr__("Select image from media library.", "vc_gradientbox_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_gradientbox_cq",
                "heading" => esc_attr__("Resize the image?", "vc_gradientbox_cq"),
                "param_name" => "resizeavatarimage",
                "value" => array("no", "yes (specify the image width below)"=>"yes"),
                "std" => "no",
                "dependency" => Array('element' => "avatartype", 'value' => array('image')),
                "group" => "Avatar",
                "description" => esc_attr__("", "vc_gradientbox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width", "vc_gradientbox_cq"),
                "param_name" => "avatarimagewidth",
                "value" => "",
                "dependency" => Array('element' => "resizeavatarimage", 'value' => array('yes')),
                "group" => "Avatar",
                "description" => esc_attr__("For example, 800 will resize the image to width 800.", "vc_gradientbox_cq")
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
                'value' => 'fa fa-heart', // default value to backend editor admin_label
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
                "heading" => esc_attr__("font-size of the icon", "vc_gradientbox_cq"),
                "param_name" => "iconfontsize",
                "value" => "",
                "dependency" => Array('element' => "avatartype", 'value' => array('icon')),
                "group" => "Avatar",
                "description" => esc_attr__("The font-size of the icon, default is 56 (in pixel). You can specify other value as you like here.", "vc_gradientbox_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Icon color", 'vc_gradientbox_cq'),
                "param_name" => "iconcolor",
                "value" => '',
                "dependency" => Array('element' => "avatartype", 'value' => array('icon')),
                "group" => "Avatar",
                "description" => esc_attr__("Default is white.", 'vc_gradientbox_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Icon background color", 'vc_gradientbox_cq'),
                "param_name" => "iconbgcolor",
                "value" => '',
                "dependency" => Array('element' => "avatartype", 'value' => array('icon')),
                "group" => "Avatar",
                "description" => esc_attr__("Default is transparent.", 'vc_gradientbox_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_gradientbox_cq",
                "heading" => esc_attr__("Avatar background shape", "vc_gradientbox_cq"),
                "param_name" => "avatarshape",
                "value" => array("circle", "rounded (small)" => "roundsmall", "rounded (large)" => "roundlarge", "square"),
                "std" => "circle",
                "dependency" => Array('element' => "avatartype", 'value' => array('icon', 'image')),
                "group" => "Avatar",
                "description" => esc_attr__("", "vc_gradientbox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Size of the avatar background", "vc_gradientbox_cq"),
                "param_name" => "avatarbgsize",
                "value" => "",
                "dependency" => Array('element' => "avatartype", 'value' => array('icon', 'image')),
                "group" => "Avatar",
                "description" => esc_attr__("The avatar default is 100 (in pixel). Specify other value as you like here, like 80.", "vc_gradientbox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Box title (optional)", "vc_gradientbox_cq"),
                "param_name" => "boxtitle",
                "value" => "",
                'group' => 'Text',
                "description" => esc_attr__("", "vc_gradientbox_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_gradientbox_cq",
                "heading" => esc_attr__("Box title align", "vc_gradientbox_cq"),
                "param_name" => "titlealign",
                "value" => array("left", "center", "right"),
                "std" => "left",
                'group' => 'Text',
                "description" => esc_attr__("", "vc_gradientbox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("font-size for the Box title", "vc_gradientbox_cq"),
                "param_name" => "titlesize",
                "value" => "",
                'group' => 'Text',
                "description" => esc_attr__("Default is 1.4em. You can specify other value here.", "vc_gradientbox_cq")
              ),
              array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_attr__("Box content", "vc_gradientbox_cq"),
                "param_name" => "content",
                'group' => 'Text',
                "value" => esc_attr__("", "vc_gradientbox_cq"), "description" => esc_attr__("", "vc_gradientbox_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Content (and the title) text color", 'vc_gradientbox_cq'),
                "param_name" => "contentcolor",
                "value" => '',
                'group' => 'Text',
                "description" => esc_attr__("Default is white.", 'vc_gradientbox_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_gradientbox_cq",
                "heading" => esc_attr__("Gradient background of whole Box", "vc_gradientbox_cq"),
                "param_name" => "gradientbackground",
                "value" => array("White" => "white", "Gray" => "gray", "Orange" => "orange", "Red" => "red", "Green" => "green", "Mint" => "mint", "Aqua" => "aqua", "Blue" => "blue", "Lavender" => "lavender", "Pink" => "pink", "Yellow" => "yellow", "Teal" => "teal", "Customized (customize the color below)" => "customized"),
                'std' => 'aqua',
                "description" => esc_attr__("", "vc_gradientbox_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Start color for the box gradient background", 'vc_gradientbox_cq'),
                "param_name" => "startcolor",
                "value" => '',
                'dependency' => array('element' => 'gradientbackground', 'value' => 'customized'),
                "description" => esc_attr__("", 'vc_gradientbox_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("End color for the box gradient background", 'vc_gradientbox_cq'),
                "param_name" => "endcolor",
                "value" => '',
                'dependency' => array('element' => 'gradientbackground', 'value' => 'customized'),
                "description" => esc_attr__("", 'vc_gradientbox_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Tooltip for the whole Box(optional)", "vc_gradientbox_cq"),
                "param_name" => "tooltip",
                "value" => "",
                "description" => esc_attr__("", "vc_gradientbox_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Optional background color for the content area", 'vc_gradientbox_cq'),
                "param_name" => "contentbgcolor",
                "value" => '',
                "description" => esc_attr__("Default is transparent. You can choose a background here. Then the whole box will be displayed like a gradient border.", 'vc_gradientbox_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_gradientbox_cq",
                "heading" => esc_attr__("Align the content center vertically?", "vc_gradientbox_cq"),
                "param_name" => "verticallycenter",
                "value" => array("No" => "", "Yes" => "vertically-center"),
                "description" => esc_attr__("Content (avatar, text etc) default is with padding only. You can choose to align them vertically center.", "vc_gradientbox_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for whole Box)', 'vc_gradientbox_cq' ),
                'param_name' => 'link',
                'description' => esc_attr__( '', 'vc_gradientbox_cq' )
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Height of whole Box", "vc_gradientbox_cq"),
                "param_name" => "boxheight",
                "value" => "",
                "description" => esc_attr__("Default is 270 (in pixel). You can specify other value here, like 320.", "vc_gradientbox_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_gradientbox_cq",
                "heading" => esc_attr__("Whole box shape", "vc_gradientbox_cq"),
                "param_name" => "boxshape",
                "value" => array("rounded (small)" => "roundsmall", "rounded (large)" => "roundlarge", "square"),
                "std" => "square",
                "description" => esc_attr__("", "vc_gradientbox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "vc_gradientbox_cq"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_gradientbox_cq")
              )

           )
        ));

        }else{

          vc_map(array(
            "name" => esc_attr__("Gradient Box", 'vc_gradientbox_cq'),
            "base" => "cq_vc_gradientbox",
            "class" => "wpb_cq_vc_extension_gradientbox",
            "icon" => "cq_allinone_gradientbox",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Content with image or icon', 'js_composer'),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_gradientbox_cq",
                "heading" => esc_attr__("Display avatar on the top:", "vc_gradientbox_cq"),
                "param_name" => "avatartype",
                "value" => array("None (text only)" => "none", "Image" => "image"),
                "group" => "Avatar",
                "description" => esc_attr__("", "vc_gradientbox_cq")
              ),
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Image", "vc_gradientbox_cq"),
                "param_name" => "avatarimage",
                "value" => "",
                "dependency" => Array('element' => "avatartype", 'value' => array('image')),
                "group" => "Avatar",
                "description" => esc_attr__("Select image from media library.", "vc_gradientbox_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_gradientbox_cq",
                "heading" => esc_attr__("Resize the image?", "vc_gradientbox_cq"),
                "param_name" => "resizeavatarimage",
                "value" => array("no", "yes (specify the image width below)"=>"yes"),
                "std" => "no",
                "dependency" => Array('element' => "avatartype", 'value' => array('image')),
                "group" => "Avatar",
                "description" => esc_attr__("", "vc_gradientbox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width", "vc_gradientbox_cq"),
                "param_name" => "avatarimagewidth",
                "value" => "",
                "dependency" => Array('element' => "resizeavatarimage", 'value' => array('yes')),
                "group" => "Avatar",
                "description" => esc_attr__("For example, 800 will resize the image to width 800.", "vc_gradientbox_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_gradientbox_cq",
                "heading" => esc_attr__("Avatar background shape", "vc_gradientbox_cq"),
                "param_name" => "avatarshape",
                "value" => array("circle", "rounded (small)" => "roundsmall", "rounded (large)" => "roundlarge", "square"),
                "std" => "circle",
                "dependency" => Array('element' => "avatartype", 'value' => array('image')),
                "group" => "Avatar",
                "description" => esc_attr__("", "vc_gradientbox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Size of the avatar background", "vc_gradientbox_cq"),
                "param_name" => "avatarbgsize",
                "value" => "",
                "dependency" => Array('element' => "avatartype", 'value' => array('image')),
                "group" => "Avatar",
                "description" => esc_attr__("The avatar default is 100 (in pixel). Specify other value as you like here, like 80.", "vc_gradientbox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Box title (optional)", "vc_gradientbox_cq"),
                "param_name" => "boxtitle",
                "value" => "",
                'group' => 'Text',
                "description" => esc_attr__("", "vc_gradientbox_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_gradientbox_cq",
                "heading" => esc_attr__("Box title align", "vc_gradientbox_cq"),
                "param_name" => "titlealign",
                "value" => array("left", "center", "right"),
                "std" => "left",
                'group' => 'Text',
                "description" => esc_attr__("", "vc_gradientbox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("font-size for the Box title", "vc_gradientbox_cq"),
                "param_name" => "titlesize",
                "value" => "",
                'group' => 'Text',
                "description" => esc_attr__("Default is 1.4em. You can specify other value here.", "vc_gradientbox_cq")
              ),
              array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_attr__("Box content", "vc_gradientbox_cq"),
                "param_name" => "content",
                'group' => 'Text',
                "value" => esc_attr__("", "vc_gradientbox_cq"), "description" => esc_attr__("", "vc_gradientbox_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Content (and the title) text color", 'vc_gradientbox_cq'),
                "param_name" => "contentcolor",
                "value" => '',
                'group' => 'Text',
                "description" => esc_attr__("Default is white.", 'vc_gradientbox_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_gradientbox_cq",
                "heading" => esc_attr__("Gradient background of whole Box", "vc_gradientbox_cq"),
                "param_name" => "gradientbackground",
                "value" => array("White" => "white", "Gray" => "gray", "Orange" => "orange", "Red" => "red", "Green" => "green", "Mint" => "mint", "Aqua" => "aqua", "Blue" => "blue", "Lavender" => "lavender", "Pink" => "pink", "Yellow" => "yellow", "Teal" => "teal", "Customized (customize the color below)" => "customized"),
                'std' => 'aqua',
                "description" => esc_attr__("", "vc_gradientbox_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Start color for the box gradient background", 'vc_gradientbox_cq'),
                "param_name" => "startcolor",
                "value" => '',
                'dependency' => array('element' => 'gradientbackground', 'value' => 'customized'),
                "description" => esc_attr__("", 'vc_gradientbox_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("End color for the box gradient background", 'vc_gradientbox_cq'),
                "param_name" => "endcolor",
                "value" => '',
                'dependency' => array('element' => 'gradientbackground', 'value' => 'customized'),
                "description" => esc_attr__("", 'vc_gradientbox_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Tooltip for the whole Box(optional)", "vc_gradientbox_cq"),
                "param_name" => "tooltip",
                "value" => "",
                "description" => esc_attr__("", "vc_gradientbox_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Optional background color for the content area", 'vc_gradientbox_cq'),
                "param_name" => "contentbgcolor",
                "value" => '',
                "description" => esc_attr__("Default is transparent. You can choose a background here. Then the whole box will be displayed like a gradient border.", 'vc_gradientbox_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_gradientbox_cq",
                "heading" => esc_attr__("Align the content center vertically?", "vc_gradientbox_cq"),
                "param_name" => "verticallycenter",
                "value" => array("No" => "", "Yes" => "vertically-center"),
                "description" => esc_attr__("Content (avatar, text etc) default is with padding only. You can choose to align them vertically center.", "vc_gradientbox_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for whole Box)', 'vc_gradientbox_cq' ),
                'param_name' => 'link',
                'description' => esc_attr__( '', 'vc_gradientbox_cq' )
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Height of whole Box", "vc_gradientbox_cq"),
                "param_name" => "boxheight",
                "value" => "",
                "description" => esc_attr__("Default is 270 (in pixel). You can specify other value here, like 320.", "vc_gradientbox_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_gradientbox_cq",
                "heading" => esc_attr__("Whole box shape", "vc_gradientbox_cq"),
                "param_name" => "boxshape",
                "value" => array("rounded (small)" => "roundsmall", "rounded (large)" => "roundlarge", "square"),
                "std" => "square",
                "description" => esc_attr__("", "vc_gradientbox_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "vc_gradientbox_cq"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_gradientbox_cq")
              )

           )
        ));



        }

        add_shortcode('cq_vc_gradientbox', array($this,'cq_vc_gradientbox_func'));
      }

      function cq_vc_gradientbox_func($atts, $content=null, $tag) {
          $avataricon = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_material = '';
            extract(shortcode_atts(array(
              "avatartype" => 'none',
              "startcolor" => '',
              "endcolor" => '',
              "gradientbackground" => '',
              "verticallycenter" => '',
              "boxtitle" => '',
              "titlealign" => '',
              "iconfontsize" => '',
              "contentbgcolor" => '',
              "contentcolor" => '',
              "titlesize" => '',
              "boxshape" => '',
              "boxheight" => '',
              "icon_fontawesome" => 'fa fa-heart',
              "icon_openiconic" => 'vc-oi vc-oi-dial',
              "icon_typicons" => 'typcn typcn-adjust-brightness',
              "icon_entypo" => 'entypo-icon entypo-icon-note',
              "icon_linecons" => 'vc_li vc_li-heart',
              "icon_material" => 'vc-material vc-material-cake',
              "avatarimage" => '',
              "avatarimagewidth" => '',
              "resizeavatarimage" => 'no',
              "avataricon" => 'fontawesome',
              "avatarshape" => '',
              "iconsize" => '',
              "avatarbgsize" => '',
              "iconcolor" => '',
              "iconbgcolor" => '',
              "link" => '',
              "tooltip" => '',
              "extraclass" => ""
            ), $atts));

          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_icon_element_fonts_enqueue($avataricon);
          }else{
          }


          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $output = '';

          wp_register_style('tooltipster', plugins_url('../appmockup/css/tooltipster.css', __FILE__));
          wp_enqueue_style('tooltipster');
          wp_register_script('tooltipster', plugins_url('../appmockup/js/jquery.tooltipster.min.js', __FILE__), array('jquery'));
          wp_enqueue_script('tooltipster');

          wp_register_style( 'vc-extensions-gradientbox-style', plugins_url('css/style.min.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-gradientbox-style' );
          wp_enqueue_script('vc-extensions-gradientbox-script');
          wp_register_script('vc-extensions-gradientbox-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "tooltipster"));
          wp_enqueue_script('vc-extensions-gradientbox-script');


          $avatarimage_full = wp_get_attachment_image_src($avatarimage, 'full');
          $i = -1;
          $link = vc_build_link($link);
          $output = '';
          $avatar_temp = $avatarthumb = "";
          $fullimage = $avatarimage_full[0];
          $avatarthumb = $fullimage;
          if($avatarimagewidth!=""&&$resizeavatarimage=="yes"){
              if(function_exists('wpb_resize')){
                  $avatar_temp = wpb_resize($avatarimage, null, $avatarimagewidth, null);
                  $avatarthumb = $avatar_temp['url'];
                  if($avatarthumb=="") $avatarthumb = $fullimage;
              }
          }


          if($link["url"]!=="") $output .= '<a href="'.$link["url"].'" title="'.$link["title"].'" target="'.$link["target"].'" class="cq-gradientbox-link">';
          $output .= '<div class="cq-gradientbox '.$boxshape.' '.$extraclass.' gradient-'.$gradientbackground.'" data-startcolor="'.$startcolor.'" data-endcolor="'.$endcolor.'" data-avatartype="'.$avatartype.'" data-avatarimage="'.$avatarthumb.'" data-titlealign="'.$titlealign.'" data-gradientbackground="'.$gradientbackground.'" data-avatarbgsize="'.$avatarbgsize.'" data-iconfontsize="'.$iconfontsize.'" data-iconcolor="'.$iconcolor.'" data-iconbgcolor="'.$iconbgcolor.'" data-contentbgcolor="'.$contentbgcolor.'" data-contentcolor="'.$contentcolor.'" data-titlesize="'.$titlesize.'" data-tooltip="'.$tooltip.'" data-boxheight="'.$boxheight.'">';
          $output .= '<div class="cq-gradientbox-contentcontainer '.$boxshape.'">';
          $output .= '<div class="cq-gradientbox-content '.$verticallycenter.'">';
          if($avatartype=="icon"){
              if(version_compare(WPB_VC_VERSION,  "4.4")>=0&&isset(${'icon_' . $avataricon})){
                  $output .= '<div class="cq-gradientbox-avatarcontainer '.$avatarshape.'">';
                  $output .= '<i class="cq-gradientbox-icon '.esc_attr(${'icon_' . $avataricon}).'"></i>';
                  $output .= '</div>';
              }
          }else if($avatartype=="image"){
                  if($avatarimage[0]!=""){
                      $output .= '<div class="cq-gradientbox-avatarcontainer '.$avatarshape.'">';
                      $output .= '</div>';
                  }
          }
          if($boxtitle!=""){
              $output .= '<h3 class="cq-gradientbox-title">';
              $output .= $boxtitle;
              $output .= '</h3>';
          }
          if($content!=""){
              $output .= $content;
          }
          $output .= '</div>';
          $output .= '</div>';
          $output .= '</div>';
          if($link["url"]!=="") $output .= '</a>';
          return $output;

        }

  }

}

?>
