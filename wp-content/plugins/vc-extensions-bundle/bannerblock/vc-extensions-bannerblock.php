<?php
if (!class_exists('VC_Extensions_BannerBlock')) {
    class VC_Extensions_BannerBlock{
        function __construct() {
          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_map(array(
            "name" => esc_attr__("Banner Block", 'vc_bannerblock_cq'),
            "base" => "cq_vc_bannerblock",
            "class" => "wpb_cq_vc_extension_bannerblock",
            "icon" => "cq_allinone_bannerblock",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Text and button for banner', 'js_composer'),
            "params" => array(
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Banner title", "vc_bannerblock_cq"),
                "param_name" => "bannertitle",
                "value" => "",
                "group" => "Title",
                "description" => esc_attr__("Note, you may have to customize the Row Settings first. Take setup a full width banner for example, you have to add background color or image, make it Stretch row in the parent row first.", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_attr__("font-size of the banner title", "vc_bannerblock_cq"),
                "param_name" => "bannertitlesize",
                "value" => "",
                "group" => "Title",
                "description" => esc_attr__("Default is 2.4em", "vc_bannerblock_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_bannerblock_cq",
                "heading" => esc_attr__("Display a separator border under the title and description?", "vc_bannerblock_cq"),
                "param_name" => "titleborder",
                "value" => array("none" => "none", "solid" => "solid", "dotted" => "dotted", "dashed" => "dashed"),
                "group" => "Title",
                "description" => esc_attr__("", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_attr__("Separator border size", "vc_bannerblock_cq"),
                "param_name" => "titlebordersize",
                "value" => "1px",
                "group" => "Title",
                "dependency" => Array('element' => "titleborder", 'value' => array('solid', 'dotted', 'dashed'))
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Separator border color", 'vc_bannerblock_cq'),
                "param_name" => "titlebordercolor",
                "value" => '#fff',
                "dependency" => Array('element' => "titleborder", 'value' => array('solid', 'dotted', 'dashed')),
                "group" => "Title",
                "description" => esc_attr__("", 'vc_bannerblock_cq')
              ),
              array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_attr__("width of the separator border", "vc_bannerblock_cq"),
                "param_name" => "titleborderwidth",
                "value" => "",
                "group" => "Title",
                "dependency" => Array('element' => "titleborder", 'value' => array('solid', 'dotted', 'dashed')),
                "description" => esc_attr__("Default is 80px", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textarea",
                "heading" => esc_attr__("Banner description (under the title)", "vc_bannerblock_cq"),
                "param_name" => "bannercontent",
                "value" => "",
                "group" => "Description",
                "description" => esc_attr__("", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_attr__("font-size of the banner description", "vc_bannerblock_cq"),
                "param_name" => "bannercontentsize",
                "value" => "",
                "group" => "Description",
                "description" => esc_attr__("Default is 1.2em", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Button label", "vc_bannerblock_cq"),
                "param_name" => "bannerbutton",
                "value" => "",
                "group" => "Button",
                "description" => esc_attr__("", "vc_bannerblock_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_bannerblock_cq",
                "heading" => esc_attr__("Button shape", "vc_bannerblock_cq"),
                "param_name" => "buttonshape",
                "value" => array("square" => "", "rounded (4px)" => "4px", "rounded (8px)" => "8px"),
                "group" => "Button",
                "description" => esc_attr__("", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_attr__("Button font size", "vc_bannerblock_cq"),
                "param_name" => "buttonfontsize",
                "value" => "",
                "group" => "Button",
                "description" => esc_attr__("Default is 1.6em", "vc_bannerblock_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_bannerblock_cq",
                "heading" => esc_attr__("Border for the button", "vc_bannerblock_cq"),
                "param_name" => "buttonborder",
                "value" => array("none" => "none", "solid" => "solid", "dotted" => "dotted", "dashed" => "dashed"),
                "group" => "Button",
                "description" => esc_attr__("", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_attr__("Button border size", "vc_bannerblock_cq"),
                "param_name" => "buttonbordersize",
                "value" => "1px",
                "dependency" => Array('element' => "buttonborder", 'value' => array('solid', 'dotted', 'dashed')),
                "group" => "Button",
                "description" => esc_attr__("Default is 1px", "vc_bannerblock_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Button border color", 'vc_bannerblock_cq'),
                "param_name" => "buttonbordercolor",
                "value" => '#fff',
                "dependency" => Array('element' => "buttonborder", 'value' => array('solid', 'dotted', 'dashed')),
                "group" => "Button",
                "description" => esc_attr__("", 'vc_bannerblock_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_bannerblock_cq",
                "heading" => esc_attr__("Add icon to the button?", "vc_bannerblock_cq"),
                "param_name" => "isicon",
                "value" => array("no" => "no", "yes (append it to the end)" => "yes_end", "yes (add it in the beginning)" => "yes_start"),
                "group" => "Button",
                "description" => esc_attr__("", "vc_bannerblock_cq")
              ),
              array(
                'type' => 'dropdown',
                'heading' => esc_attr__( 'Add icon to the button? Icon library', 'js_composer' ),
                'value' => array(
                  esc_attr__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                  esc_attr__( 'Open Iconic', 'js_composer' ) => 'openiconic',
                  esc_attr__( 'Typicons', 'js_composer' ) => 'typicons',
                  esc_attr__( 'Entypo', 'js_composer' ) => 'entypo',
                  esc_attr__( 'Linecons', 'js_composer' ) => 'linecons',
                  esc_attr__( 'Material', 'js_composer' ) => 'material',
                ),
                'admin_label' => true,
                'param_name' => 'bannericon',
                'dependency' => Array('element' => "isicon", 'value' => array('yes_start', 'yes_end')),
                "group" => "Button",
                'description' => esc_attr__( 'Select icon library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-adjust', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => true, // default true, display an "EMPTY" icon?
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                  'element' => 'bannericon',
                  'value' => 'fontawesome',
                ),
                "group" => "Button",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_openiconic',
                'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => true, // default true, display an "EMPTY" icon?
                  'type' => 'openiconic',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'bannericon',
                  'value' => 'openiconic',
                ),
                "group" => "Button",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_typicons',
                'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => true, // default true, display an "EMPTY" icon?
                  'type' => 'typicons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'bannericon',
                  'value' => 'typicons',
                ),
                "group" => "Button",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_entypo',
                'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => true, // default true, display an "EMPTY" icon?
                  'type' => 'entypo',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                "group" => "Button",
                'dependency' => array(
                  'element' => 'bannericon',
                  'value' => 'entypo',
                ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_linecons',
                'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => true, // default true, display an "EMPTY" icon?
                  'type' => 'linecons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'bannericon',
                  'value' => 'linecons',
                ),
                "group" => "Button",
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
                  'element' => 'bannericon',
                  'value' => 'material',
                ),
                "group" => "Button",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_bannerblock_cq",
                "heading" => esc_attr__("Apply animation to the icon?", "vc_bannerblock_cq"),
                "param_name" => "iconanimation",
                "value" => array("none" => "", "bounce", "flash", "rubberBand", "shake", "swing", "tada", "wobble", "bounceIn", "bounceInDown", "bounceInLeft", "bounceInRight", "bounceInUp", "fadeIn", "fadeInDown", "fadeInDownBig", "fadeInLeft", "fadeInLeftBig", "fadeInRight", "fadeInRightBig", "fadeInUp", "fadeInUpBig", "flip", "flipInX", "flipInY", "lightSpeedIn", "rotateIn", "rotateInDownLeft", "rotateInDownRight", "rotateInUpLeft", "rotateInUpRight", "hinge", "rollIn", "zoomIn", "zoomInDown", "zoomInLeft", "zoomInRight", "zoomInUp"),
                "group" => "Button",
                "dependency" => Array('element' => "isicon", 'value' => array('yes_end', 'yes_start')),
                "description" => esc_attr__("", "vc_bannerblock_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for the button)', 'vc_bannerblock_cq' ),
                'param_name' => 'link',
                "group" => "Button",
                'description' => esc_attr__( '', 'vc_bannerblock_cq' )
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Button background color:", 'vc_bannerblock_cq'),
                "param_name" => "backbuttonbg",
                "value" => '',
                "group" => "Button",
                "description" => esc_attr__("", 'vc_bannerblock_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Button font color:", 'vc_bannerblock_cq'),
                "param_name" => "backbuttoncolor",
                "value" => '',
                "group" => "Button",
                "description" => esc_attr__("Default is #333.", 'vc_bannerblock_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Button hover background color:", 'vc_bannerblock_cq'),
                "param_name" => "backbuttonhoverbg",
                "value" => '',
                "group" => "Button",
                "description" => esc_attr__("", 'vc_bannerblock_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Button hover font color:", 'vc_bannerblock_cq'),
                "param_name" => "backbuttonhovercolor",
                "value" => '',
                "group" => "Button",
                "description" => esc_attr__("", 'vc_bannerblock_cq')
              ),
              array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_attr__("CSS padding of the button", "vc_bannerblock_cq"),
                "param_name" => "buttonpadding",
                "value" => "",
                "group" => "Button",
                "description" => esc_attr__("Default is 0.6em 1em 0.6em 1em, change to other value as you like.", "vc_bannerblock_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Text color (include the title and description)", 'vc_bannerblock_cq'),
                "param_name" => "textcolor",
                "value" => '',
                "description" => esc_attr__("Default is white, #333", 'vc_bannerblock_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Height of the whole element:", "vc_bannerblock_cq"),
                "param_name" => "elementheight",
                "value" => "",
                "description" => esc_attr__("Default is 480px", "vc_bannerblock_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_bannerblock_cq",
                "heading" => esc_attr__("Add arrow (or circle) to the banner background?", "vc_bannerblock_cq"),
                "param_name" => "isarrow",
                "value" => array("no" => "", "arrow (put it on the top)" => "arrowtop", "arrow (put it on the bottom)" => "arrowbottom", "circle (put it on the top)" => "circletop", "circle (put it on the bottom)" => "circlebottom"),
                "description" => esc_attr__("", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Arrow (or circle) offset", "vc_bannerblock_cq"),
                "param_name" => "arrowoffset",
                "value" => "",
                "dependency" => Array('element' => "isarrow", 'value' => array('arrowtop', 'arrowbottom', 'circletop', 'circlebottom')),
                "description" => esc_attr__("Default is 0. You can specify a value to move the arrow (or circle) upper or lower. For example, in top position, 24px will move it lower 24px, -24px will move it 24px upper.", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Arrow (or circle) size", "vc_bannerblock_cq"),
                "param_name" => "arrowsize",
                "value" => "",
                "dependency" => Array('element' => "isarrow", 'value' => array('arrowtop', 'arrowbottom', 'circletop', 'circlebottom')),
                "description" => esc_attr__("Default is 32px.", "vc_bannerblock_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Arrow (or circle) color", 'vc_bannerblock_cq'),
                "param_name" => "arrowcolor",
                "value" => '',
                "dependency" => Array('element' => "isarrow", 'value' => array('arrowtop', 'arrowbottom', 'circletop', 'circlebottom')),
                "description" => esc_attr__("", 'vc_bannerblock_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_bannerblock_cq",
                "heading" => esc_attr__("Apply smooth scroll to the page.", "vc_bannerblock_cq"),
                "param_name" => "issmoothscroll",
                "value" => array("no" => "no", "yes" => "yes"),
                "description" => esc_attr__("We will make the in page link like http://yoursite.com/about#footer scroll smoothly when choose yes.", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS margin of the content:", "vc_bannerblock_cq"),
                "param_name" => "elementmargin",
                "value" => "",
                "description" => esc_attr__("Default the content will stay in the middle. You can specify the margin value of it to control it's position. For example, 60px 0 0 0 will stand for margin-top 60px.", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "vc_bannerblock_cq"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_bannerblock_cq")
              )

           )
        ));


        }else{
          vc_map(array(
            "name" => esc_attr__("Banner Block", 'vc_bannerblock_cq'),
            "base" => "cq_vc_bannerblock",
            "class" => "wpb_cq_vc_extension_bannerblock",
            "icon" => "cq_allinone_bannerblock",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Text and button for banner', 'js_composer'),
            "params" => array(
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Banner title", "vc_bannerblock_cq"),
                "param_name" => "bannertitle",
                "value" => "",
                "group" => "Title",
                "description" => esc_attr__("Note, you may have to customize the Row Settings first. Take setup a full width banner for example, you have to add background color or image, make it Stretch row in the parent row first.", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_attr__("font-size of the banner title", "vc_bannerblock_cq"),
                "param_name" => "bannertitlesize",
                "value" => "",
                "group" => "Title",
                "description" => esc_attr__("Default is 2.4em", "vc_bannerblock_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_bannerblock_cq",
                "heading" => esc_attr__("Display a separator border under the title and description?", "vc_bannerblock_cq"),
                "param_name" => "titleborder",
                "value" => array("none" => "none", "solid" => "solid", "dotted" => "dotted", "dashed" => "dashed"),
                "group" => "Title",
                "description" => esc_attr__("", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_attr__("Separator border size", "vc_bannerblock_cq"),
                "param_name" => "titlebordersize",
                "value" => "1px",
                "group" => "Title",
                "dependency" => Array('element' => "titleborder", 'value' => array('solid', 'dotted', 'dashed'))
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Separator border color", 'vc_bannerblock_cq'),
                "param_name" => "titlebordercolor",
                "value" => '#fff',
                "dependency" => Array('element' => "titleborder", 'value' => array('solid', 'dotted', 'dashed')),
                "group" => "Title",
                "description" => esc_attr__("", 'vc_bannerblock_cq')
              ),
              array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_attr__("width of the separator border", "vc_bannerblock_cq"),
                "param_name" => "titleborderwidth",
                "value" => "",
                "group" => "Title",
                "dependency" => Array('element' => "titleborder", 'value' => array('solid', 'dotted', 'dashed')),
                "description" => esc_attr__("Default is 80px", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textarea",
                "heading" => esc_attr__("Banner description (under the title)", "vc_bannerblock_cq"),
                "param_name" => "bannercontent",
                "value" => "",
                "group" => "Description",
                "description" => esc_attr__("", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_attr__("font-size of the banner description", "vc_bannerblock_cq"),
                "param_name" => "bannercontentsize",
                "value" => "",
                "group" => "Description",
                "description" => esc_attr__("Default is 1.2em", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Button label", "vc_bannerblock_cq"),
                "param_name" => "bannerbutton",
                "value" => "",
                "group" => "Button",
                "description" => esc_attr__("", "vc_bannerblock_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_bannerblock_cq",
                "heading" => esc_attr__("Button shape", "vc_bannerblock_cq"),
                "param_name" => "buttonshape",
                "value" => array("square" => "", "rounded (4px)" => "4px", "rounded (8px)" => "8px"),
                "group" => "Button",
                "description" => esc_attr__("", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_attr__("Button font size", "vc_bannerblock_cq"),
                "param_name" => "buttonfontsize",
                "value" => "",
                "group" => "Button",
                "description" => esc_attr__("Default is 1.6em", "vc_bannerblock_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_bannerblock_cq",
                "heading" => esc_attr__("Border for the button", "vc_bannerblock_cq"),
                "param_name" => "buttonborder",
                "value" => array("none" => "none", "solid" => "solid", "dotted" => "dotted", "dashed" => "dashed"),
                "group" => "Button",
                "description" => esc_attr__("", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_attr__("Button border size", "vc_bannerblock_cq"),
                "param_name" => "buttonbordersize",
                "value" => "1px",
                "dependency" => Array('element' => "buttonborder", 'value' => array('solid', 'dotted', 'dashed')),
                "group" => "Button",
                "description" => esc_attr__("Default is 1px", "vc_bannerblock_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Button border color", 'vc_bannerblock_cq'),
                "param_name" => "buttonbordercolor",
                "value" => '#fff',
                "dependency" => Array('element' => "buttonborder", 'value' => array('solid', 'dotted', 'dashed')),
                "group" => "Button",
                "description" => esc_attr__("", 'vc_bannerblock_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_bannerblock_cq",
                "heading" => esc_attr__("Add icon to the button?", "vc_bannerblock_cq"),
                "param_name" => "isicon",
                "value" => array("no" => "no", "yes (append it to the end)" => "yes_end", "yes (add it in the beginning)" => "yes_start"),
                "std" => "no",
                "group" => "Button",
                "description" => esc_attr__("", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_attr__("Icon in the button:", "vc_bannerblock_cq"),
                "param_name" => "bannericon",
                "value" => "",
                "group" => "Button",
                "dependency" => Array('element' => "isicon", 'value' => array('yes_end', 'yes_start')),
                "description" => esc_attr__("Support <a href='http://fortawesome.github.io/Font-Awesome/icons/'>Font Awesome icon</a> here, for example, fa-twitter will insert a twitter icon.", "vc_bannerblock_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_bannerblock_cq",
                "heading" => esc_attr__("Apply animation to the icon?", "vc_bannerblock_cq"),
                "param_name" => "iconanimation",
                "value" => array("none" => "", "bounce", "flash", "pulse", "rubberBand", "shake", "swing", "tada", "wobble", "bounceIn", "bounceInDown", "bounceInLeft", "bounceInRight", "bounceInUp", "fadeIn", "fadeInDown", "fadeInDownBig", "fadeInLeft", "fadeInLeftBig", "fadeInRight", "fadeInRightBig", "fadeInUp", "fadeInUpBig", "flip", "flipInX", "flipInY", "lightSpeedIn", "rotateIn", "rotateInDownLeft", "rotateInDownRight", "rotateInUpLeft", "rotateInUpRight", "hinge", "rollIn", "zoomIn", "zoomInDown", "zoomInLeft", "zoomInRight", "zoomInUp"),
                "group" => "Button",
                "dependency" => Array('element' => "isicon", 'value' => array('yes_end', 'yes_start')),
                "description" => esc_attr__("", "vc_bannerblock_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for the button)', 'vc_bannerblock_cq' ),
                'param_name' => 'link',
                "group" => "Button",
                'description' => esc_attr__( '', 'vc_bannerblock_cq' )
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Button background color:", 'vc_bannerblock_cq'),
                "param_name" => "backbuttonbg",
                "value" => '',
                "group" => "Button",
                "description" => esc_attr__("", 'vc_bannerblock_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Button font color:", 'vc_bannerblock_cq'),
                "param_name" => "backbuttoncolor",
                "value" => '',
                "group" => "Button",
                "description" => esc_attr__("Default is #333.", 'vc_bannerblock_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Button hover background color:", 'vc_bannerblock_cq'),
                "param_name" => "backbuttonhoverbg",
                "value" => '',
                "group" => "Button",
                "description" => esc_attr__("", 'vc_bannerblock_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Button hover font color:", 'vc_bannerblock_cq'),
                "param_name" => "backbuttonhovercolor",
                "value" => '',
                "group" => "Button",
                "description" => esc_attr__("", 'vc_bannerblock_cq')
              ),
              array(
                "type" => "textfield",
                "class" => "",
                "heading" => esc_attr__("CSS padding of the button", "vc_bannerblock_cq"),
                "param_name" => "buttonpadding",
                "value" => "",
                "group" => "Button",
                "description" => esc_attr__("Default is 0.6em 1em 0.6em 1em, change to other value as you like.", "vc_bannerblock_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Text color (include the title and description)", 'vc_bannerblock_cq'),
                "param_name" => "textcolor",
                "value" => '',
                "description" => esc_attr__("Default is white, #333", 'vc_bannerblock_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Height of the whole element:", "vc_bannerblock_cq"),
                "param_name" => "elementheight",
                "value" => "",
                "description" => esc_attr__("Default is 480px", "vc_bannerblock_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_bannerblock_cq",
                "heading" => esc_attr__("Add arrow (or circle) to the banner background?", "vc_bannerblock_cq"),
                "param_name" => "isarrow",
                "value" => array("no" => "", "arrow (put it on the top)" => "arrowtop", "arrow (put it on the bottom)" => "arrowbottom", "circle (put it on the top)" => "circletop", "circle (put it on the bottom)" => "circlebottom"),
                "description" => esc_attr__("", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Arrow (or circle) size", "vc_bannerblock_cq"),
                "param_name" => "arrowsize",
                "value" => "",
                "dependency" => Array('element' => "isarrow", 'value' => array('arrowtop', 'arrowbottom', 'circletop', 'circlebottom')),
                "description" => esc_attr__("Default is 32px.", "vc_bannerblock_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Arrow (or circle) color", 'vc_bannerblock_cq'),
                "param_name" => "arrowcolor",
                "value" => '',
                "dependency" => Array('element' => "isarrow", 'value' => array('arrowtop', 'arrowbottom', 'circletop', 'circlebottom')),
                "description" => esc_attr__("", 'vc_bannerblock_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_bannerblock_cq",
                "heading" => esc_attr__("Apply smooth scroll to the page.", "vc_bannerblock_cq"),
                "param_name" => "issmoothscroll",
                "value" => array("no" => "no", "yes" => "yes"),
                "description" => esc_attr__("We will make the in page link like http://yoursite.com/about#footer scroll smoothly when choose yes.", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS margin of the content:", "vc_bannerblock_cq"),
                "param_name" => "elementmargin",
                "value" => "",
                "description" => esc_attr__("Default the content will stay in the middle. You can specify the margin value of it to control it's position. For example, 60px 0 0 0 will stand for margin-top 60px.", "vc_bannerblock_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "vc_bannerblock_cq"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "vc_bannerblock_cq")
              )


           )
        ));


        }

        add_shortcode('cq_vc_bannerblock', array($this,'cq_vc_bannerblock_func'));

      }

      function cq_vc_bannerblock_func($atts, $content=null, $tag) {
          $bannericon = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_material = '';
            extract(shortcode_atts(array(
              "icon_fontawesome" => 'fa fa-bullhorn',
              "icon_openiconic" => 'vc-oi vc-oi-dial',
              "icon_typicons" => 'typcn typcn-adjust-brightness',
              "icon_entypo" => 'entypo-icon entypo-icon-note',
              "icon_linecons" => 'vc_li vc_li-heart',
              "icon_material" => 'vc-material vc-material-cake',
              "avataricon" => 'fontawesome',
              "bannertype" => "",
              // "bannerimage" => "",
              "bannertitle" => "",
              "bannertitlesize" => "",
              "titleborder" => "none",
              "titlebordercolor" => "#fff",
              "titlebordersize" => "1px",
              "bannercontent" => "",
              "bannercontentsize" => "",
              "bannerbutton" => "",
              "buttonborder" => "",
              "backbuttonbg" => "",
              "backbuttoncolor" => "",
              "backbuttonhoverbg" => "",
              "backbuttonhovercolor" => "",
              "buttonbordersize" => "1px",
              "buttonbordercolor" => "#FFF",
              "bannericon" => "fontawesome",
              "bannerbg" => "",
              "isicon" => "no",
              "isarrow" => "",
              "arrowsize" => "",
              "arrowcolor" => "",
              "link" => "",
              "titleborderwidth" => "",
              "buttonshape" => "",
              "buttonpadding" => "",
              "iconanimation" => "",
              "textcolor" => "",
              "issmoothscroll" => "",
              // "scrolltime" => "",
              "buttonfontsize" => "",
              "elementheight" => "",
              "elementmargin" => "",
              "arrowoffset" => "",
              "extraclass" => ""
            ), $atts));

          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $output = '';

          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_icon_element_fonts_enqueue($bannericon);
          }else{
            wp_register_style( 'font-awesome', plugins_url('../faanimation/css/font-awesome.min.css', __FILE__) );
            wp_enqueue_style( 'font-awesome' );
          }

          $link = vc_build_link($link);

          wp_register_style( 'animate.css', plugins_url('css/animate.min.css', __FILE__) );
          wp_enqueue_style( 'animate.css' );
          wp_register_style( 'vc-extensions-bannerblock-style', plugins_url('css/style.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-bannerblock-style' );
          wp_register_script('smooth-scroll', plugins_url('js/jquery.smooth-scroll.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('smooth-scroll');
          wp_register_script('vc-extensions-bannerblock-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "smooth-scroll"));
          wp_enqueue_script('vc-extensions-bannerblock-script');
          $output_buttontext_start = $output_buttontext_icon = $output_buttontext_text = $output_buttontext_end = '';
          $output = '';
          $output .= '<div class="cq-bannerblock '.$extraclass.'" data-titleborder="'.$titleborder.'" data-titlebordercolor="'.$titlebordercolor.'" data-titlebordersize="'.$titlebordersize.'" data-bannertitlesize="'.$bannertitlesize.'" data-bannercontentsize="'.$bannercontentsize.'" data-buttonborder="'.$buttonborder.'" data-buttonbordersize="'.$buttonbordersize.'" data-buttonbordercolor="'.$buttonbordercolor.'" data-titleborderwidth="'.$titleborderwidth.'" data-elementmargin="'.$elementmargin.'" data-elementheight="'.$elementheight.'" data-backbuttoncolor="'.$backbuttoncolor.'" data-backbuttonbg="'.$backbuttonbg.'" data-backbuttonhoverbg="'.$backbuttonhoverbg.'" data-backbuttonhovercolor="'.$backbuttonhovercolor.'" data-buttonshape="'.$buttonshape.'" data-issmoothscroll="'.$issmoothscroll.'"  data-isarrow="'.$isarrow.'" data-arrowsize="'.$arrowsize.'" data-arrowcolor="'.$arrowcolor.'" data-buttonfontsize="'.$buttonfontsize.'" data-buttonpadding="'.$buttonpadding.'" data-textcolor="'.$textcolor.'" data-arrowoffset="'.$arrowoffset.'">';
          if($isarrow=="arrowtop"||$isarrow=="arrowbottom") $output .= '<div class="cq-bannerblock-arrow '.$isarrow.'"></div>';
          if($isarrow=="circletop"||$isarrow=="circlebottom") $output .= '<div class="cq-bannerblock-circle '.$isarrow.'"></div>';
          $output .= '<div class="cq-bannerblock-content">';
          if($bannertitle!=""){
              $output .= '<h4 class="cq-bannerblock-title">';
              $output .= $bannertitle;
              $output .= '</h4>';
          }
          if($bannercontent!=""){
              $output .= '<span class="cq-bannerblock-desc">';
              $output .= $bannercontent;
              $output .= '</span>';
          }
          if($titleborder!="none"){
              $output .= '<span class="cq-bannerblock-line"></span>';
          }
          if($bannerbutton!=""||$isicon!="no"){
              $output_buttontext_start .= '<div class="cq-bannerblock-buttonarea">';
              if($link["url"]!=="") $output_buttontext_start .= '<a href="'.$link["url"].'" title="'.$link["title"].'" class="cq-bannerblock-link" target="'.$link["target"].'">';
              $output_buttontext_start .= '<div class="cq-bannerblock-buttonlink">';
              if($bannerbutton!=""){
                  $output_buttontext_text .= '<span class="cq-bannerblock-button">';
                  $output_buttontext_text .= $bannerbutton;
                  $output_buttontext_text .= '</span>';
              }
              if(version_compare(WPB_VC_VERSION,  "4.4")>=0&&isset(${'icon_' . $bannericon})&&$isicon!="no"){
                  if($bannerbutton!=""){
                    if($isicon=="yes_start"){
                        $output_buttontext_icon .= '<i class="cq-bannerblock-icon animated cq-infinite '.$iconanimation.' '.esc_attr(${'icon_' . $bannericon}).'"></i> ';
                    }else if($isicon=="yes_end"){
                        $output_buttontext_icon .= ' <i class="cq-bannerblock-icon animated cq-infinite '.$iconanimation.' '.esc_attr(${'icon_' . $bannericon}).'"></i>';
                    }
                  }else{
                    $output_buttontext_icon .= '<i class="cq-bannerblock-icon animated cq-infinite '.$iconanimation.' '.esc_attr(${'icon_' . $bannericon}).'"></i>';
                  }
              }else{
                if($bannerbutton!=""){
                    if($isicon=="yes_start"){
                        $output_buttontext_icon .= '<i class="fa animated cq-infinite '.$iconanimation.' '.$bannericon.'"></i> ';
                    }else if($isicon=="yes_end"){
                        $output_buttontext_icon .= ' <i class="fa animated cq-infinite '.$iconanimation.' '.$bannericon.'"></i>';
                    }
                  }else{
                    $output_buttontext_icon .= '<i class="fa animated cq-infinite '.$iconanimation.' '.$bannericon.'"></i>';
                  }

              }
              $output_buttontext_end .= '</div>';
              if($link["url"]!=="") $output_buttontext_end .= '</a>';
              $output_buttontext_end .= '</div>';
          }else if($bannerbutton==""&&$isicon=="no"){
            $output_buttontext_start = $output_buttontext_icon = $output_buttontext_text = $output_buttontext_end = "";
          }

          if($isicon=="yes_start"){
              $output .= $output_buttontext_start.$output_buttontext_icon.$output_buttontext_text.$output_buttontext_end;
          }else{
              $output .= $output_buttontext_start.$output_buttontext_text.$output_buttontext_icon.$output_buttontext_end;
          }


          $output .= '</div>';
          $output .= '</div>';

          return $output;

        }

  }

}

?>
