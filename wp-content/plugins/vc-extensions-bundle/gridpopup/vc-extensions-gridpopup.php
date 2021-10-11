<?php
if (!class_exists('VC_Extensions_GridPopup')){
    class VC_Extensions_GridPopup{
        private $itemnum = 1;
        private $gallerynum = 1;
        private $minwidth = '';
        private $labelfontsize = '';
        private $subfontsize = '';
        private $popupimagesize = '';
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Grid Popup", 'cq_allinone_vc'),
            "base" => "cq_vc_gridpopup",
            "class" => "cq_vc_gridpopup",
            "icon" => "cq_vc_gridpopup",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            "as_parent" => array('only' => 'cq_vc_gridpopup_item'),
            "js_view" => 'VcColumnView',
            "show_settings_on_create" => true,
            'description' => esc_attr__('Grid with lightbox', 'js_composer'),
            "params" => array(
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "heading" => esc_attr__("Grid column", "cq_allinone_vc"),
                 "param_name" => "gridnumber",
                 "value" => array("1", "2", "3", "4", "5"),
                 "std" => "3",
                 "description" => esc_attr__("Customize the grid setting here first, then add the Grid Item one by one.", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "holder" => "",
                 "heading" => esc_attr__("Thumbnail height", "cq_allinone_vc"),
                 "param_name" => "itemsize",
                 "value" => array("80", "100", "120", "160", "200", "240", "280", "320", "400", "customize:" => "customized"),
                 "std" => "160",
                 "description" => esc_attr__("Select the built in item height (in pixels) or customize it below.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Customize thumbnail height", "cq_allinone_vc"),
                "param_name" => "itemheight",
                "value" => "",
                "dependency" => Array('element' => "itemsize", 'value' => array('customized')),
                "description" => esc_attr__('Enter item height in pixels, for example: 210. Leave empty to use default 160 (pixels).', "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "holder" => "",
                 "heading" => esc_attr__("Avatar image size", "cq_allinone_vc"),
                 "param_name" => "avatarsize",
                 "value" => array("40", "60", "80", "100", "120", "160", "200", "240", "320", "400"),
                 "std" => "60",
                 "description" => esc_attr__("Select the built in avatar image size (in pixels).", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("min-width for the text content", "cq_allinone_vc"),
                "param_name" => "minwidth",
                "value" => "",
                "description" => esc_attr__("Default (leave to blank) is 320 in pixel, you can use it to control the video only content's size. ", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("max-width for the text content", "cq_allinone_vc"),
                "param_name" => "maxwidth",
                "value" => "",
                "description" => esc_attr__("Default (leave to blank) is 800 in pixel, you can use it to control the video only content's size. ", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "holder" => "",
                 "heading" => esc_attr__("width of the popup image", "cq_allinone_vc"),
                 "param_name" => "popupimagesize",
                 "value" => array("20%" => "20", "30%" => "30", "40%" => "40", "50%" => "50", "60%" => "60", "70%" => "70", "80%" => "80" ),
                 "std" => "50",
                 "description" => esc_attr__("Default is 50%.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Label font-size", "cq_allinone_vc"),
                "param_name" => "labelfontsize",
                "value" => "",
                "description" => esc_attr__("Default (leave to blank) is 1em, support a value like 12px or 1.2em", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Sub title font-size", "cq_allinone_vc"),
                "param_name" => "subfontsize",
                "value" => "",
                "description" => esc_attr__("Default (leave to blank) is 0.9em", "cq_allinone_vc")
              ),
              array(
                'type' => 'checkbox',
                "edit_field_class" => "vc_col-xs-6 vc_column",
                'heading' => esc_attr__('Do not apply circular to the avatar image? ', 'cq_allinone_vc' ),
                'param_name' => 'nocircular',
                'std' => 'no',
                'description' => esc_attr__("Check this if you don't want to make the avatar image circularly.", 'cq_allinone_vc' ),
                'value' => array( esc_attr__( 'Yes, keep it in original', 'cq_allinone_vc' ) => 'nocircular' ),
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Extra class name", "cq_allinone_vc"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "cq_allinone_vc")
              ),
              array(
                "type" => "css_editor",
                "heading" => esc_attr__( "CSS", "cq_allinone_vc" ),
                "param_name" => "css",
                "description" => esc_attr__("It's recommended to use this to customize the padding/margin only.", "cq_allinone_vc"),
                "group" => esc_attr__( "Design options", "cq_allinone_vc" ),
             )
           )
        ));

        vc_map(
          array(
             "name" => esc_attr__("Grid Item","cq_allinone_vc"),
             "base" => "cq_vc_gridpopup_item",
             "class" => "cq_vc_gridpopup_item",
             "icon" => "cq_vc_gridpopup_item",
             "category" => esc_attr__('Sike Extensions', 'js_composer'),
             "description" => esc_attr__("Add image, icon and text","cq_allinone_vc"),
             "as_child" => array('only' => 'cq_vc_gridpopup'),
             "show_settings_on_create" => true,
             "content_element" => true,
             "params" => array(
                array(
                  "type" => "dropdown",
                  "holder" => "",
                  "heading" => esc_attr__("Display the avatar with", "cq_allinone_vc"),
                  "param_name" => "avatartype",
                  "value" => array("None (no avatar)"=>"none", "Image" => "image", "Icon" => "icon"),
                  "std" => "icon",
                  "group" => "Thumbnail",
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                'type' => 'dropdown',
                'heading' => esc_attr__( 'Icon library', 'js_composer' ),
                'value' => array(
                  esc_attr__( 'Entypo', 'js_composer' ) => 'entypo',
                  esc_attr__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
                  esc_attr__( 'Open Iconic', 'js_composer' ) => 'openiconic',
                  esc_attr__( 'Typicons', 'js_composer' ) => 'typicons',
                  esc_attr__( 'Linecons', 'js_composer' ) => 'linecons',
                  esc_attr__( 'Material', 'js_composer' ) => 'material',
                ),
                'admin_label' => true,
                'param_name' => 'faceicon',
                "dependency" => Array('element' => "avatartype", 'value' => array('icon')),
                "group" => "Thumbnail",
                'description' => esc_attr__( 'Select icon library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-user', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => true, // default true, display an "EMPTY" icon?
                  'type' => 'fontawesome',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                  'element' => 'faceicon',
                  'value' => 'fontawesome',
                ),
                "group" => "Thumbnail",
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
                  'element' => 'faceicon',
                  'value' => 'openiconic',
                ),
                "group" => "Thumbnail",
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
                  'element' => 'faceicon',
                  'value' => 'typicons',
                ),
                "group" => "Thumbnail",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => esc_attr__( 'Icon', 'js_composer' ),
                'param_name' => 'icon_entypo',
                'value' => 'entypo-icon entypo-icon-user', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'entypo',
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display
                ),
                "group" => "Thumbnail",
                'dependency' => array(
                  'element' => 'faceicon',
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
                  'element' => 'faceicon',
                  'value' => 'linecons',
                ),
                "group" => "Thumbnail",
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
                  'element' => 'faceicon',
                  'value' => 'material',
                ),
                "group" => "Thumbnail",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => esc_attr__("Icon size", "cq_allinone_vc"),
                "param_name" => "iconsize",
                "value" => "",
                "dependency" => Array('element' => "avatartype", 'value' => array('icon')),
                "group" => "Thumbnail",
                "description" => esc_attr__('Default is 28px (leave to blank). Support a value like 2em or 32px', "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => esc_attr__("Icon color", 'cq_allinone_vc'),
                "param_name" => "iconcolor",
                "value" => "",
                "group" => "Thumbnail",
                "dependency" => Array('element' => "avatartype", 'value' => array('icon')),
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
              ),
              array(
                "type" => "attach_image",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Avatar image:", "cq_allinone_vc"),
                "param_name" => "avatarimage",
                "value" => "",
                "group" => "Thumbnail",
                "dependency" => Array('element' => "avatartype", 'value' => array('image')),
                "description" => esc_attr__("Select from media library.", "cq_allinone_vc")
              ),
              array(
                'type' => 'checkbox',
                "edit_field_class" => "vc_col-xs-6 vc_column",
                'heading' => esc_attr__( 'Resize the avatar image?', 'cq_allinone_vc' ),
                'param_name' => 'avatarresize',
                'description' => esc_attr__( 'We will use the original image by default, you can specify a width below if the original image is too large.', 'cq_allinone_vc' ),
                'std' => 'no',
                "group" => "Thumbnail",
                "dependency" => Array('element' => "avatartype", 'value' => array('image')),
                'value' => array( esc_attr__( 'Yes', 'cq_allinone_vc' ) => 'yes' ),
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Resize image to this width.", "cq_allinone_vc"),
                "param_name" => "avatarimagesize",
                "value" => "",
                "dependency" => Array('element' => "avatarresize", 'value' => array('yes')),
                "group" => "Thumbnail",
                "description" => esc_attr__('Enter image width in pixels, for example: 400. The image then will be resized to 400. Leave empty to use original full image.', "cq_allinone_vc")
              ),

              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-8 vc_column",
                "heading" => esc_attr__("Label for the item (optional, under the avatar)", "cq_allinone_vc"),
                "param_name" => "gridlabel",
                "value" => "",
                "group" => "Thumbnail",
                "description" => esc_attr__("For example, a name, John Smith", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-4 vc_column",
                "heading" => esc_attr__("Label color", 'cq_allinone_vc'),
                "param_name" => "labelcolor",
                "value" => "",
                "group" => "Thumbnail",
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-8 vc_column",
                "heading" => esc_attr__("Sub title for the thumbnail (optional, under the label)", "cq_allinone_vc"),
                "param_name" => "gridsublabel",
                "value" => "",
                "group" => "Thumbnail",
                "description" => esc_attr__("For example, a job title, Web Developer", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-4 vc_column",
                "heading" => esc_attr__("Sub title color", 'cq_allinone_vc'),
                "param_name" => "subtitlecolor",
                "value" => "",
                "group" => "Thumbnail",
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Tooltip for the thumbnail (optional)", "cq_allinone_vc"),
                "param_name" => "tooltip",
                "value" => "",
                "group" => "Thumbnail",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),

              array(
                "type" => "dropdown",
                "holder" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Background color of the grid thumbnail:", "cq_allinone_vc"),
                "param_name" => "bgstyle",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "Transparent (content with white background)" => "cq-transparent", "Customized color:" => "customized"),
                'std' => 'aqua',
                'group' => 'Thumbnail',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                  "type" => "attach_image",
                  "edit_field_class" => "vc_col-xs-6 vc_column",
                  "heading" => esc_attr__("Thumbnail background image: (optional)", "cq_allinone_vc"),
                  "param_name" => "thumbimg",
                  "value" => "",
                  "group" => "Thumbnail",
                  "description" => esc_attr__("Select from media library.", "cq_allinone_vc")
              ),
              array(
                'type' => 'checkbox',
                "edit_field_class" => "vc_col-xs-6 vc_column",
                'heading' => esc_attr__( 'Resize the thumbnail background image?', 'cq_allinone_vc' ),
                'param_name' => 'thumbresize',
                'description' => esc_attr__( 'We will use the original image by default, you can specify a width below if the original image is too large.', 'cq_allinone_vc' ),
                'std' => 'no',
                "group" => "Thumbnail",
                'value' => array( esc_attr__( 'Yes', 'cq_allinone_vc' ) => 'yes' ),
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Resize thumbnail background image to this width.", "cq_allinone_vc"),
                "param_name" => "thumbimgsize",
                "value" => "",
                "dependency" => Array('element' => "thumbresize", 'value' => array('yes')),
                "group" => "Thumbnail",
                "description" => esc_attr__('Enter image width in pixels, for example: 400. The image then will be resized to 400. Leave empty to use original full image.', "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Background color of the grid thumbnail", 'cq_allinone_vc'),
                "param_name" => "backgroundcolor",
                "value" => "",
                'group' => 'Thumbnail',
                "dependency" => Array('element' => "bgstyle", 'value' => array('customized')),
                "description" => esc_attr__("Default is medium gray. Note, the content only support white background with customized thumbnail background.", 'cq_allinone_vc')
              ),

              array(
                  "type" => "attach_image",
                  "heading" => esc_attr__("Popup image: (optional)", "cq_allinone_vc"),
                  "param_name" => "image",
                  "value" => "",
                  "group" => "Popup Content",
                  "description" => esc_attr__("Select from media library.", "cq_allinone_vc")
              ),
              array(
                'type' => 'checkbox',
                "edit_field_class" => "vc_col-xs-6 vc_column",
                'heading' => esc_attr__( 'Resize the image?', 'cq_allinone_vc' ),
                'param_name' => 'isresize',
                'description' => esc_attr__( 'We will use the original image by default, you can specify a width below if the original image is too large.', 'cq_allinone_vc' ),
                'std' => 'no',
                "group" => "Popup Content",
                'value' => array( esc_attr__( 'Yes', 'cq_allinone_vc' ) => 'yes' ),
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Resize image to this width.", "cq_allinone_vc"),
                "param_name" => "imagesize",
                "value" => "",
                "dependency" => Array('element' => "isresize", 'value' => array('yes')),
                "group" => "Popup Content",
                "description" => esc_attr__('Enter image width in pixels, for example: 400. The image then will be resized to 400. Leave empty to use original full image.', "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "holder" => "",
                 "heading" => esc_attr__("Put the image on the:", "cq_allinone_vc"),
                 "param_name" => "imageposition",
                 "value" => array("left", "right"),
                 "std" => "left",
                 "group" => "Popup Content",
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textarea_html",
                "heading" => esc_attr__("Content", "cq_allinone_vc"),
                "param_name" => "content",
                "value" => "",
                "group" => "Popup Content",
                "description" => esc_attr__("The slide in content.", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => esc_attr__("Text color", 'cq_allinone_vc'),
                "param_name" => "contentcolor",
                "value" => "",
                "group" => "Popup Content",
                "description" => esc_attr__("", 'cq_allinone_vc')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Background color of the popup content.", 'cq_allinone_vc'),
                "param_name" => "popupbg",
                "value" => "",
                'group' => 'Popup Content',
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
              )

              ),
            )
        );

          add_shortcode('cq_vc_gridpopup', array($this,'cq_vc_gridpopup_func'));
          add_shortcode('cq_vc_gridpopup_item', array($this,'cq_vc_gridpopup_item_func'));

      }

      function cq_vc_gridpopup_func($atts, $content=null) {
        $css_class = $css =  $gridnumber = $itemsize = $itemheight = $avatarsize = $labelfontsize = $minwidth = $maxwidth = $subfontsize = $nocircular = $popupimagesize = $extraclass = '';
        extract(shortcode_atts(array(
          "gridnumber" => "3",
          "itemsize" => "",
          "itemheight" => "",
          "avatarsize" => "",
          "labelfontsize" => "",
          "subfontsize" => "",
          "nocircular" => "no",
          "minwidth" => "",
          "maxwidth" => "",
          "popupimagesize" => "50",
          "css" => "",
          "extraclass" => ""
        ),$atts));

        $output = "";
        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ''), 'cq_vc_gridpopup', $atts);
        wp_register_style( 'vc-extensions-gridpopup-style', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style( 'vc-extensions-gridpopup-style' );

        wp_register_style('tooltipster', plugins_url('../appmockup/css/tooltipster.css', __FILE__));
        wp_enqueue_style('tooltipster');

        wp_register_script('tooltipster', plugins_url('../appmockup/js/jquery.tooltipster.min.js', __FILE__), array('jquery'));
        wp_enqueue_script('tooltipster');

        wp_register_style('lity', plugins_url('../hotspot/css/lity.min.css', __FILE__));
        wp_enqueue_style('lity');
        wp_register_script('lity', plugins_url('../hotspot/js/lity.min.js', __FILE__), array('jquery'));
        wp_enqueue_script('lity');


        wp_register_script('vc-extensions-gridpopup-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "tooltipster"));
        wp_enqueue_script('vc-extensions-gridpopup-script');

        $this -> itemnum = 1;

        $gallerynum = $this -> gallerynum;
        $this -> minwidth = $minwidth;
        $this -> maxwidth = $maxwidth;
        $this -> labelfontsize = $labelfontsize;
        $this -> subfontsize = $subfontsize;
        $this -> popupimagesize = $popupimagesize;

        $output .= '<div class="cq-gridpopup cq-circular-'.$nocircular.' cq-gridpopup-'.$itemsize.' cq-gridpopup-avatar-'.$avatarsize.' cq-gridpopup-in'.$gridnumber.' '.$extraclass.' '.$css_class.'" id="cq-gridpopup-'.$gallerynum.'" data-itemsize="'.$itemsize.'" data-itemheight="'.$itemheight.'" data-nocircular="'.$nocircular.'">';
        $output .= do_shortcode($content);
        $output .= '</div>';
        $gallerynum++;
        $this -> gallerynum = $gallerynum;
        return $output;

      }


      function cq_vc_gridpopup_item_func($atts, $content=null, $tag) {
          $output = $faceicon = $image = $imagesize = $videowidth = $isresize = $tooltip =  $backgroundcolor = $popupbg = $backgroundhovercolor = $itembgcolor = $iconcolor = $iconsize =  $css = $bgstyle = $thumbimg = $thumbimgsize = $thumbresize =  $gridlabel = $gridsublabel = $contentcolor = $labelcolor = $subtitlecolor = $imageposition =  "";
          $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_pixelicons = $icon_material = $icon_monosocial = "";
            extract(shortcode_atts(array(
              "faceicon" => "entypo",
              "image" => "",
              "imagesize" => "",
              "isresize" => "no",
              "avatarimage" => "",
              "avatartype" => "icon",
              "avatarimagesize" => "",
              "avatarresize" => "no",
              "iscaption" => "",
              "tooltip" => "",
              "bgstyle" => "aqua",
              "thumbimg" => "",
              "thumbresize" => "",
              "thumbimgsize" => "",
              "backgroundcolor" => "",
              "popupbg" => "",
              "backgroundhovercolor" => "",
              "itembgcolor" => "",
              "icon_fontawesome" => "fa fa-user",
              "icon_openiconic" => "vc-oi vc-oi-dial",
              "icon_typicons" => "typcn typcn-adjust-brightness",
              "icon_entypo" => "entypo-icon entypo-icon-user",
              "icon_linecons" => "vc_li vc_li-heart",
              "icon_material" => "vc-material vc-material-cake",
              "icon_pixelicons" => "",
              "icon_monosocial" => "",
              "iconcolor" => "",
              "iconsize" => "",
              "gridlabel" => "",
              "gridsublabel" => "",
              "labelcolor" => "",
              "subtitlecolor" => "",
              "labelfontsize" => "",
              "subfontsize" => "",
              "contentcolor" => "",
              "imageposition" => "left",
              "css" => ""
            ), $atts));

          vc_icon_element_fonts_enqueue($faceicon);
          $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

          $itemnum = $this -> itemnum;
          $gallerynum = $this -> gallerynum;

          $img = $thumbnail = $image_alt = "";

          $fullimage = wp_get_attachment_image_src($image, 'full');
          $attachment = get_post($image);
          $image_alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true );
          $thumbnail = $fullimage[0];
          if($isresize=="yes"&&$imagesize!=""){
              if(function_exists('wpb_resize')){
                  $img = wpb_resize($image, null, $imagesize, null);
                  $thumbnail = $img['url'];
                  if($thumbnail=="") $thumbnail = $fullimage[0];
              }
          }

          $avatarimg = $avatarthumbnail = "";
          $avatarfullimage = wp_get_attachment_image_src($avatarimage, 'full');
          $avatarthumbnail = $avatarfullimage[0];
          if($avatarresize=="yes"&&$avatarimagesize!=""){
              if(function_exists('wpb_resize')){
                  $avatarimg = wpb_resize($avatarimage, null, $avatarimagesize, null);
                  $avatarthumbnail = $avatarimg['url'];
                  if($avatarthumbnail=="") $avatarthumbnail = $avatarfullimage[0];
              }
          }


          $thumbbgimage = $thumbbgthumbnail = "";
          $thumb_bg_img = wp_get_attachment_image_src($thumbimg, 'full');
          $thumbbgthumbnail = $thumb_bg_img[0];

          if($thumbresize=="yes"&&$thumbimgsize!=""){
              if(function_exists('wpb_resize')){
                  $thumbbgimage = wpb_resize($thumbimg, null, $thumbimgsize, null);
                  $thumbbgthumbnail = $thumbbgimage['url'];
                  if($thumbbgthumbnail=="") $thumbbgthumbnail = $thumbimg[0];
              }
          }


          $itembgstyle_str = '';
          if($bgstyle == "customized" && $backgroundcolor != ""){
          	$itembgstyle_str .= "background-color: $backgroundcolor;";
          }

          if($thumbbgthumbnail != ""){
            $itembgstyle_str .= "background-image: url($thumbbgthumbnail);";
          }

          $output = '';
          $output .= '<a href="#cq-gridpopup-content-'.$gallerynum.'-'.$itemnum.'" class="cq-gridpopup-item cq-gridpopup-initstate '.$bgstyle.'" data-bgstyle="'.$bgstyle.'" data-backgroundcolor="'.$backgroundcolor.'" data-backgroundhovercolor="'.$backgroundhovercolor.'" data-avatartype="'.$avatartype.'" data-avatar="'.$avatarthumbnail.'" data-iconcolor="'.$iconcolor.'" data-iconsize="'.$iconsize.'" data-lity title="'.esc_html($tooltip).'">';
          $output .= '<div class="cq-gridpopup-face cq-gridpopup-toggle" style="'.$itembgstyle_str.'">';
          $output .= '<div class="cq-gridpopup-facecontent">';
          if($avatarthumbnail!=""){
            $output .= '<div class="cq-gridpopup-avatar" style="background-image:url('.$avatarthumbnail.')">';
            $output .= '</div>';
          }
          if(version_compare(WPB_VC_VERSION,  "4.4")>=0&&isset(${'icon_' . $faceicon})&&esc_attr(${'icon_' . $faceicon})!=""&&$avatartype=="icon"){
              $output .= '<i class="cq-gridpopup-icon '.esc_attr(${'icon_' . $faceicon}).'"></i>';
          }
          if($gridlabel!=""){
              $output .= '<span class="cq-gridpopup-title" style="font-size:'.$this -> labelfontsize.';color:'.$labelcolor.';">'.$gridlabel.'</span> ';
          }
          if($gridsublabel!=""){
              $output .= '<span class="cq-gridpopup-subtitle" style="font-size:'.$this -> subfontsize.';color:'.$subtitlecolor.';">'.$gridsublabel.'</span> ';
          }
          $output .= '</div>';
          $minwidth_str = '';
          if(intval($this -> minwidth) > 0){
            $minwidth_str = 'min-width:'.intval($this -> minwidth).'px;';
          }
          $maxwidth_str = '';
          if(intval($this -> maxwidth) > 0){
            $maxwidth_str = 'max-width:'.intval($this -> maxwidth).'px;';
          }

          $output .= '</div>';
          $output .= '<div class="cq-gridpopup-content cq-gridpopup-image-'.$this -> popupimagesize.' lity-hide" id="cq-gridpopup-content-'.$gallerynum.'-'.$itemnum.'" style="background-color:'.$popupbg.';'.$minwidth_str.$maxwidth_str.'">';
          $is_full_text = "cq-gridpopup-fullwidth";
          if($thumbnail != "" && ($imageposition == "right" || $imageposition == "left")){
              $is_full_text = "cq-gridpopup-halfwidth";
          }

          if($thumbnail != "" && $imageposition == "left"){
              $output .= '<div class="cq-gridpopup-imagecontainer">';
              $output .= '<img src="'.$thumbnail.'" class="cq-gridpopup-image" alt="'.$image_alt.'" />';
              $output .= '</div>';
          }
          $output .= '<div class="cq-gridpopup-text '.$is_full_text.'" style="color:'.$contentcolor.';">';
          $output .= do_shortcode($content);
          $output .= '</div>';

          if($thumbnail != "" && $imageposition == "right"){
              $output .= '<div class="cq-gridpopup-imagecontainer">';
              $output .= '<img src="'.$thumbnail.'" class="cq-gridpopup-image" alt="'.get_post_meta($image->ID, '_wp_attachment_image_alt', true ).'" />';
              $output .= '</div>';
              $is_full_text = "cq-gridpopup-halfwidth";
          }


          $output .= '</div>';
          $output .= '</a>';

          $itemnum++;
          $this -> itemnum = $itemnum;
          return $output;

        }

  }
}
//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) && !class_exists('WPBakeryShortCode_cq_vc_gridpopup')) {
    class WPBakeryShortCode_cq_vc_gridpopup extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) && !class_exists('WPBakeryShortCode_cq_vc_gridpopup_item')) {
    class WPBakeryShortCode_cq_vc_gridpopup_item extends WPBakeryShortCode {
    }
}

?>
