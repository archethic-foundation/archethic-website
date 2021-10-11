<?php
if (!class_exists('VC_Extensions_FlipBoxV2')){
    class VC_Extensions_FlipBoxV2{
        function __construct() {
            vc_map(array(
            "name" => __("Flip Box V2", 'cq_allinone_vc'),
            "base" => "cq_vc_flipboxv2",
            "class" => "cq_vc_flipboxv2",
            "icon" => "cq_vc_flipboxv2",
            "category" => __('Sike Extensions', 'js_composer'),
            "as_parent" => array('only' => 'cq_vc_flipboxv2_item'),
            "js_view" => 'VcColumnView',
            "show_settings_on_create" => true,
            'description' => __('Flip Box with list item', 'js_composer'),
            "params" => array(
              array(
                "type" => "textfield",
                "heading" => __("Name in the Front Box", "cq_allinone_vc"),
                "param_name" => "name",
                "value" => "",
                "group" => "Text",
                "description" => __('', "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => __("name font-size", "cq_allinone_vc"),
                "param_name" => "namefontsize",
                "value" => "",
                "group" => "Text",
                "description" => __("Default (leave to blank) is 1.5em, support a value like <strong>12px</strong> or <strong>1.2em</strong>", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => __("Name color", 'cq_allinone_vc'),
                "param_name" => "namecolor",
                "value" => "",
                "group" => "Text",
                "description" => __("Default is gray.", 'cq_allinone_vc')
              ),
              array(
                "type" => "textfield",
                "heading" => __("Label under the name", "cq_allinone_vc"),
                "param_name" => "label",
                "value" => "",
                "group" => "Text",
                "description" => __('Label under the name, can be a role, like Web Developer or any other thing as you like.', "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => __("Label font-size", "cq_allinone_vc"),
                "param_name" => "labelfontsize",
                "value" => "",
                "group" => "Text",
                "description" => __("Default (leave to blank) is 1em, support a value like <strong>12px</strong> or <strong>1.2em</strong>", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => __("Label color", 'cq_allinone_vc'),
                "param_name" => "labelcolor",
                "value" => "",
                "group" => "Text",
                "description" => __("Default is gray.", 'cq_allinone_vc')
              ),
              array(
                "type" => "textarea",
                "heading" => __("More information for the Front Box", "cq_allinone_vc"),
                "param_name" => "description",
                "value" => "",
                "group" => "Text",
                "description" => __("It's under the label, you can put more details about the Front Box.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => __("Description font-size", "cq_allinone_vc"),
                "param_name" => "desfontsize",
                "value" => "",
                "group" => "Text",
                "description" => __("Default (leave to blank) is 1em, support a value like <strong>12px</strong> or <strong>1.2em</strong>", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => __("Description color", 'cq_allinone_vc'),
                "param_name" => "descolor",
                "value" => "",
                "group" => "Text",
                "description" => __("Default is gray.", 'cq_allinone_vc')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "heading" => __("Avatar type", "cq_allinone_vc"),
                "param_name" => "avatartype",
                "value" => array("image", "icon", "none"),
                "std" => "icon",
                "group" => "Avatar",
                "description" => __("Select avatar type.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => __("Size of the whole avatar", "cq_allinone_vc"),
                "param_name" => "avatarwidth",
                "value" => "",
                "group" => "Avatar",
                'dependency' => array('element' => 'avatartype', 'value' => array("image", "icon"),
                ),
                "description" => __('The avatar will be displayed in circle. Default is 80 (in pixel).', "cq_allinone_vc")
              ),
              array(
                "type" => "attach_image",
                "heading" => __("Avatar image", "cq_allinone_vc"),
                "param_name" => "avatarimage",
                "value" => "",
                'dependency' => array('element' => 'avatartype', 'value' => 'image',
                 ),
                "group" => "Avatar",
                "description" => __("Select image from media library.", "cq_allinone_vc")
              ),
              array(
                'type' => 'dropdown',
                'heading' => __( 'Icon library', 'js_composer' ),
                'value' => array(
                  __( 'Entypo', 'js_composer' ) => 'entypo',
                  __( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                  __( 'Open Iconic', 'js_composer' ) => 'openiconic',
                  __( 'Typicons', 'js_composer' ) => 'typicons',
                  __( 'Material', 'js_composer' ) => 'material',
                  __( 'Linecons', 'js_composer' ) => 'linecons',
                ),
                'admin_label' => true,
                'param_name' => 'avataricon',
                'dependency' => array('element' => 'avatartype', 'value' => 'icon',
                 ),
                "group" => "Avatar",
                'description' => __( 'Select icon library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => __( 'Icon', 'js_composer' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-user', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => true, // default true, display an "EMPTY" icon?
                  'type' => 'fontawesome',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                  'element' => 'avataricon',
                  'value' => 'fontawesome',
                ),
                "group" => "Avatar",
                'description' => __( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => __( 'Icon', 'js_composer' ),
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
                'description' => __( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => __( 'Icon', 'js_composer' ),
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
                'description' => __( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => __( 'Icon', 'js_composer' ),
                'param_name' => 'icon_entypo',
                'value' => 'entypo-icon entypo-icon-user', // default value to backend editor admin_label
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
                'heading' => __( 'Icon', 'js_composer' ),
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
                'description' => __( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => __( 'Icon', 'js_composer' ),
                'param_name' => 'icon_material',
                'value' => 'vc-material vc-material-arrow_forward',
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
                'description' => __( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "dropdown",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "",
                "heading" => __("icon size of the Avatar", "cq_allinone_vc"),
                "param_name" => "iconsize",
                "value" => array("small (24px)" => "small", "medium (36px)" => "medium", "large (48px)" => "large"),
                'std' => 'small',
                "group" => "Avatar",
                'dependency' => array('element' => 'avatartype', 'value' => array("icon"),
                ),
                "description" => __("Select the icon size of the Avatar.", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => __("icon color", 'cq_allinone_vc'),
                "param_name" => "iconcolor",
                "value" => "",
                "group" => "Avatar",
                'dependency' => array('element' => 'avatartype', 'value' => array("icon"),
                ),
                "description" => __("Color of the avatar icon, default is white.", 'cq_allinone_vc')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => __("icon background color", 'cq_allinone_vc'),
                "param_name" => "iconbgcolor",
                "value" => "",
                "group" => "Avatar",
                'dependency' => array('element' => 'avatartype', 'value' => array("icon"),
                ),
                "description" => __("Background color of the avatar icon, default is gray.", 'cq_allinone_vc')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "heading" => __("Add header in the Front Box", "cq_allinone_vc"),
                "param_name" => "isheader",
                "value" => array("Yes" => "yes", "No" => "no"),
                'std' => 'no',
                "group" => "Header",
                "description" => __("You can choose to add a header image to the Front Box.", "cq_allinone_vc")
              ),
              array(
                "type" => "attach_image",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => __("Background image for the header (optional)", "cq_allinone_vc"),
                "param_name" => "headerimage",
                "value" => "",
                "group" => "Header",
                "dependency" => array("element" => "isheader", "value" => "yes" ),
                "description" => __("Select image from media library.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => __("Resize the header background to this width", "cq_allinone_vc"),
                "param_name" => "headerwidth",
                "value" => "",
                "group" => "Header",
                "dependency" => array("element" => "isheader", "value" => "yes"),
                "description" => __("Specify a value like 400, if you want to resize the image to this width. Default (blank value) is the original image.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => __("Header height", "cq_allinone_vc"),
                "param_name" => "headerheight",
                "value" => "",
                "group" => "Header",
                "dependency" => array("element" => "isheader", "value" => "yes"),
                "description" => __("The height of the header. Default is 150 (in pixel)", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => __("background color for the header", 'cq_allinone_vc'),
                "param_name" => "overlaycolor",
                "value" => "",
                "group" => "Header",
                "dependency" => array("element" => "isheader", "value" => "yes"),
                "description" => __("", 'cq_allinone_vc')
              ),
              array(
                "type" => "textfield",
                "heading" => __("Element height", "cq_allinone_vc"),
                "param_name" => "elementheight",
                "value" => "",
                "description" => __("The height of the whole Flip Box. Default is 360 (in pixel)", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "heading" => __("Front Box style (background color)", "cq_allinone_vc"),
                 "param_name" => "frontbgstyle",
                 "value" => array("White" => "white", "Aqua" => "aqua", "Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "Transparent" => "transparent", "or customize :" => "customized"),
                'std' => 'white',
                "description" => __("Select the built in Front Box background color.", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => __("customize background color for the Front Box", 'cq_allinone_vc'),
                "param_name" => "frontboxbg",
                "value" => "",
                'dependency' => array('element' => 'frontbgstyle', 'value' => 'customized',
                ),
                "description" => __("", 'cq_allinone_vc')
              ),
              array(
                 "type" => "dropdown",
                 "heading" => __("Back Box style (background color)", "cq_allinone_vc"),
                 "holder" => "",
                 "param_name" => "backboxstyle",
                 "value" => array("Aqua" => "aqua", "Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "Transparent" => "transparent", "or customize :" => "customized"),
                'std' => 'aqua',
                "description" => __("Select the built in Back Box background color.", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => __("customize background color for the Back Box", 'cq_allinone_vc'),
                "param_name" => "backboxbg",
                "value" => "",
                'dependency' => array('element' => 'backboxstyle', 'value' => 'customized',
                ),
                "description" => __("", 'cq_allinone_vc')
              ),
              array(
                "type" => "dropdown",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "",
                "heading" => __("shadow for the whole element", "cq_allinone_vc"),
                "param_name" => "shadowsize",
                "value" => array("large", "small", "none"),
                'std' => 'small',
                "description" => __("Select element shadow.", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "",
                "class" => "cq_allinone_vc",
                "heading" => __("Auto delay flip", "cq_allinone_vc"),
                "param_name" => "autodelay",
                'value' => array(2, 3, 4, 5, 7, 10, __( 'Disable', 'cq_allinone_vc' ) => 0 ),
                'std' => 0,
                "description" => __("Auto flip the box in each X seconds.", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "",
                "heading" => __("transition direction for the flip", "cq_allinone_vc"),
                "param_name" => "direction",
                "value" => array("horizontal 1" => "horizontal1", "horizontal 2" => "horizontal2", "vertical 1" => "vertical1", "vertical 2" => "vertical2"),
                'std' => 'horizontal1',
                "description" => __("Select transition.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => __("Extra class name", "cq_allinone_vc"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "cq_allinone_vc")
              ),
              array(
                "type" => "css_editor",
                "heading" => __( "CSS", "cq_allinone_vc" ),
                "param_name" => "css",
                "description" => __("It's recommended to use this to customize the padding/margin only.", "cq_allinone_vc"),
                "group" => __( "Design options", "cq_allinone_vc" ),
             )
           )
        ));

        vc_map(
          array(
             "name" => __("Back Box Item","cq_allinone_vc"),
             "base" => "cq_vc_flipboxv2_item",
             "class" => "cq_vc_flipboxv2_item",
             "icon" => "cq_vc_flipboxv2_item",
             "category" => __('Sike Extensions', 'js_composer'),
             "description" => __("Add icon, text etc","cq_allinone_vc"),
             "as_child" => array('only' => 'cq_vc_flipboxv2'),
             "show_settings_on_create" => true,
             "content_element" => true,
             "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "heading" => __("Display Icon for this item?", "cq_allinone_vc"),
                "param_name" => "isicon",
                "value" => array("Yes" => "yes", "No" => "no"),
                'std' => 'yes',
                "description" => __("", "cq_allinone_vc")
              ),
              array(
                'type' => 'dropdown',
                'heading' => __( 'Icon library', 'js_composer' ),
                'value' => array(
                  __( 'Entypo', 'js_composer' ) => 'entypo',
                  __( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                  __( 'Open Iconic', 'js_composer' ) => 'openiconic',
                  __( 'Typicons', 'js_composer' ) => 'typicons',
                  __( 'Material', 'js_composer' ) => 'material',
                  __( 'Linecons', 'js_composer' ) => 'linecons',
                  // __( 'Mono Social', 'js_composer' ) => 'monosocial',
                ),
                'admin_label' => true,
                'param_name' => 'listicon',
                'dependency' => array('element' => 'isicon', 'value' => 'yes'),
                'description' => __( 'Select icon library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => __( 'Icon', 'js_composer' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-user', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => true, // default true, display an "EMPTY" icon?
                  'type' => 'fontawesome',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                  'element' => 'listicon',
                  'value' => 'fontawesome',
                ),
                'description' => __( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => __( 'Icon', 'js_composer' ),
                'param_name' => 'icon_openiconic',
                'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'openiconic',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'listicon',
                  'value' => 'openiconic',
                ),
                'description' => __( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => __( 'Icon', 'js_composer' ),
                'param_name' => 'icon_typicons',
                'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'typicons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'listicon',
                  'value' => 'typicons',
                ),
                'description' => __( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => __( 'Icon', 'js_composer' ),
                'param_name' => 'icon_entypo',
                'value' => 'entypo-icon entypo-icon-check', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'entypo',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'listicon',
                  'value' => 'entypo',
                ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => __( 'Icon', 'js_composer' ),
                'param_name' => 'icon_linecons',
                'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'linecons',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'listicon',
                  'value' => 'linecons',
                ),
                'description' => __( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => __( 'Icon', 'js_composer' ),
                'param_name' => 'icon_material',
                'value' => 'vc-material vc-material-arrow_forward',
                // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false,
                  // default true, display an "EMPTY" icon?
                  'type' => 'material',
                  'iconsPerPage' => 100,
                  // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                  'element' => 'listicon',
                  'value' => 'material',
                ),
                'description' => __( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "textfield",
                "heading" => __("Title", "cq_allinone_vc"),
                "param_name" => "title",
                "value" => "",
                "description" => __("Title for the item, append to the icon.", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column cqadmin-col-offset",
                "class" => "",
                "heading" => __("Icon color", 'cq_allinone_vc'),
                "param_name" => "iconcolor",
                "value" => "",
                'dependency' => array('element' => 'isicon', 'value' => 'yes'),
                "description" => __("Default is white.", 'cq_allinone_vc')
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => __("font-size of the icon and title", "cq_allinone_vc"),
                "param_name" => "iconsize",
                "value" => "",
                "description" => __("Default is 1.1em. You can specify it with other value like <strong>24px</strong> or <strong>1.5em</strong> etc.", "cq_allinone_vc")
              ),
              array(
                "type" => "vc_link",
                "heading" => __("URL (Optional link for the current icon and title)", "vc_colorblock_cq"),
                "param_name" => "itemlink",
                "value" => "",
                "description" => __("", "vc_colorblock_cq")
              ),
              array(
                "type" => "textarea_html",
                "heading" => __("Description under the icon and title", "cq_allinone_vc"),
                "param_name" => "content",
                "value" => "",
                "description" => __("You can put more details about the title.", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-4 vc_column",
                "class" => "",
                "heading" => __("description color", 'cq_allinone_vc'),
                "param_name" => "contentcolor",
                "value" => "",
                "description" => __("Default is gray.", 'cq_allinone_vc')
              )
              ),
            )
        );

          add_shortcode('cq_vc_flipboxv2', array($this,'cq_vc_flipboxv2_func'));
          add_shortcode('cq_vc_flipboxv2_item', array($this,'cq_vc_flipboxv2_item_func'));

      }

      function cq_vc_flipboxv2_func($atts, $content=null) {
        $css_class = $css = $frontbgstyle = $frontboxbg = $backboxstyle = $namecolor = $namefontsize = $labelfontsize = $labelcolor = $desfontsize = $descolor = $nextbtncolor = $listicon = $title = $headerimage = $headerwidth = $overlaycolor = $iconsize = $shadowsize = $name = $label = $description = $avatartype = $avatarimage = $avataricon = $avatarwidth = $backboxbg = $direction = $elementheight = $headerheight = $autodelay = $elementlink = $isheader = $iconcolor = $iconbgcolor = $extraclass = '';
        $iconcolor = $iconbgcolor = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_pixelicons = $icon_material = '';
        extract(shortcode_atts(array(
          "headerimage" => "",
          "headerwidth" => "",
          "name" => "",
          "label" => "",
          "description" => "",
          "backboxstyle" => "aqua",
          "frontbgstyle" => "white",
          "frontboxbg" => "",
          "namefontsize" => "",
          "css" => "",
          "namecolor" => "",
          "labelfontsize" => "",
          "labelcolor" => "",
          "desfontsize" => "",
          "descolor" => "",
          "nextbtncolor" => "",
          "iconsize" => "small",
          "overlaycolor" => "",
          "shadowsize" => "small",
          "avatartype" => "icon",
          "avatarimage" => "",
          "avataricon" => "",
          "avatarwidth" => "80",
          "avataricon" => "entypo",
          "iconcolor" => "",
          "iconbgcolor" => "",
          "icon_fontawesome" => "fa fa-user",
          "icon_openiconic" => "vc-oi vc-oi-dial",
          "icon_typicons" => "typcn typcn-adjust-brightness",
          "icon_entypo" => "entypo-icon entypo-icon-user",
          "icon_linecons" => "vc_li vc_li-heart",
          "icon_material" => "vc-material vc-material-arrow_forward",
          "direction" => "horizontal1",
          "elementlink" => "",
          "backboxbg" => "",
          "autodelay" => "",
          "elementheight" => "",
          "headerheight" => "",
          "isheader" => "no",
          "iconcolor" => "",
          "iconbgcolor" => "",
          "extraclass" => ""
        ),$atts));

        $output = "";
        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ''), 'cq_vc_flipboxv2', $atts);
        wp_register_style( 'vc-extensions-flipboxv2-style', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style( 'vc-extensions-flipboxv2-style' );

        wp_register_script('vc-extensions-flipboxv2-script', plugins_url('js/init.min.js', __FILE__), array("jquery"));
        wp_enqueue_script('vc-extensions-flipboxv2-script');


        $elementlink = vc_build_link($elementlink);

        $headerimagearr = wp_get_attachment_image_src(trim($headerimage), 'full');
        $header_image_temp = "";
        $header_full_image = $headerimagearr[0];
        $header_attachment = get_post($headerimage);
        if($headerwidth!=""){
            if(function_exists('wpb_resize')){
                $header_image_temp = wpb_resize($headerimage, null, $headerwidth, null);
                if($header_image_temp['url']!="") $header_full_image = $header_image_temp['url'];
            }
        }

        vc_icon_element_fonts_enqueue($avataricon);

        $attachment = get_post($avatarimage);
        $avatarimagearr = wp_get_attachment_image_src(trim($avatarimage), 'full');
        $avatar_image_temp = $avatarimage_url = "";
        $avatar_full_image = $avatarimagearr[0];
        $avatarimage_url = $avatar_full_image;
        if($avatarwidth!=""){
            if(function_exists('wpb_resize')){
                $avatar_image_temp = wpb_resize($avatarimage, null, $avatarwidth*2, $avatarwidth*2, true);
                $avatarimage_url = $avatar_image_temp['url'];
                if($avatarimage_url=="") $avatarimage_url = $avatar_full_image;
            }
        }
        if($elementheight!="")$elementheight = (int) preg_replace('/[^0-9]/', '', $elementheight);
        if($headerheight!="")$headerheight = (int) preg_replace('/[^0-9]/', '', $headerheight);
        if($header_full_image==""&&$overlaycolor=="") $isheader = "no";
        $output .= '<div class="cq-flipboxv2 cq-flipboxv2-'.$backboxstyle.' cq-flipboxv2-front'.$frontbgstyle.' cq-flipboxv2-shadow'.$shadowsize.' cq-flipboxv2-icon'.$iconsize.' cq-flipboxv2-isheader'.$isheader.' cq-flipboxv2-'.$direction.' '.$extraclass.' '.$css_class.'" data-avatarwidth="'.$avatarwidth.'" data-namecolor="'.$namecolor.'" data-namefontsize="'.$namefontsize.'" data-labelcolor="'.$labelcolor.'" data-labelfontsize="'.$labelfontsize.'" data-desfontsize="'.$desfontsize.'" data-descolor="'.$descolor.'" data-direction="'.$direction.'" data-autodelay="'.$autodelay.'" data-isheader="'.$isheader.'" style="height:'.$elementheight.'px">';
        $output .= '<div class="cq-flipboxv2-card" onclick="">';
        $output .= '<div class="cq-flipboxv2-front" style="background-color:'.$frontboxbg.'">';
        if($isheader=="yes"){
          $output .= '<div class="cq-flipboxv2-header" style="background-image:url('.$header_full_image.');background-color:'.$overlaycolor.';height:'.$headerheight.'px"></div>';
        }
        if($avatartype=="image" && $avatarimage_url!=""){
           $output .= '<div class="cq-flipboxv2-avatar">
                          <img src="'.$avatarimage_url.'" class="cq-flipboxv2-avatarimage" alt="'.get_post_meta($attachment->ID, '_wp_attachment_image_alt', true ).'" />
                       </div>';
        }else if($avatartype=="icon" && isset(${'icon_' . $avataricon})){
            $output .= '<div class="cq-flipboxv2-avatar">';
            $output .= '<i class="cq-flipboxv2-avataricon '.esc_attr(${'icon_' . $avataricon}).'" style="color:'.$iconcolor.';background-color:'.$iconbgcolor.';"></i>';
            $output .= '</div>';
        }
        if($name!=""){
            $output .= '<h3 class="cq-flipboxv2-name">'.$name.'</h3>';
        }
        if($label!=""){
            $output .= '<p class="cq-flipboxv2-label">'.$label.'</p>';
        }
        if($description!=""){
            $output .= '<div class="cq-flipboxv2-description">'.$description.'</div>';
        }
        $output .= '</div>'; // end of front
        $output .= '<div class="cq-flipboxv2-back" style="background-color:'.$backboxbg.'">';

        $output .= '<ul class="cq-flipboxv2-backcontent">';
        $output .= do_shortcode($content);
        $output .= '</ul>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
        return $output;

      }


      function cq_vc_flipboxv2_item_func($atts, $content=null, $tag) {
          $iconcolor = $iconbgcolor = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_pixelicons = $icon_material = $title = $contentcolor = $itemlink = $iconcolor = $iconsize = $isicon = "";
          extract(shortcode_atts(array(
            "listicon" => "entypo",
            "iconcolor" => "",
            "iconbgcolor" => "",
            "icon_fontawesome" => "fa fa-user",
            "icon_openiconic" => "vc-oi vc-oi-dial",
            "icon_typicons" => "typcn typcn-adjust-brightness",
            "icon_entypo" => "entypo-icon entypo-icon-check",
            "icon_linecons" => "vc_li vc_li-heart",
            "icon_material" => "vc-material vc-material-arrow_forward",
            "title" => "",
            "contentcolor" => "",
            "itemlink" => "",
            "iconsize" => "",
            "isicon" => "yes",
            "css" => ""
          ), $atts));

          $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

          vc_icon_element_fonts_enqueue($listicon);
          $itemlink = vc_build_link($itemlink);

          $output = '';
          $output .= '<li class="cq-flipboxv2-listitem" data-iconcolor="'.$iconcolor.'" data-iconbgcolor="'.$iconbgcolor.'" data-contentcolor="'.$contentcolor.'">';
          if($itemlink["url"]!=="") $output .= '<a href="'.$itemlink["url"].'" title="'.$itemlink["title"].'" target="'.$itemlink["target"].'" rel="'.$itemlink["rel"].'" class="cq-flipboxv2-itemlink" onclick="">';
          $output .='<div class="cq-flipboxv2-iconcontainer">';
          if($isicon=="yes"){
            $output .= '<i class="cq-flipboxv2-icon '.esc_attr(${'icon_' . $listicon}).'" style="color:'.$iconcolor.';font-size:'.$iconsize.';line-height:'.$iconsize.'"></i> ';
          }
          $output .= '<span class="cq-flipboxv2-itemtitle" style="color:'.$iconcolor.';font-size:'.$iconsize.';line-height:'.$iconsize.'">'.$title.'</span>';
          $output .= "</div>";
          if($itemlink["url"]!=="") $output .= '</a>';
          if($content!=""){
            $output .= '<div class="cq-flipboxv2-itemdesc" style="color:'.$contentcolor.'">';
            $output .= $content;
            $output .= '</div>';
          }
          $output .= '</li>';
          return $output;

        }

  }
}
//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) && !class_exists('WPBakeryShortCode_cq_vc_flipboxv2')) {
    class WPBakeryShortCode_cq_vc_flipboxv2 extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) && !class_exists('WPBakeryShortCode_cq_vc_flipboxv2_item')) {
    class WPBakeryShortCode_cq_vc_flipboxv2_item extends WPBakeryShortCode {
    }
}

?>
