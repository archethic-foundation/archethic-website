<?php
if (!class_exists('VC_Extensions_ExpandGrid')){
    class VC_Extensions_ExpandGrid{
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Expand Grid", 'cq_allinone_vc'),
            "base" => "cq_vc_expandgrid",
            "class" => "cq_vc_expandgrid",
            "icon" => "cq_vc_expandgrid",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            "as_parent" => array('only' => 'cq_vc_expandgrid_item'),
            "js_view" => 'VcColumnView',
            "show_settings_on_create" => true,
            'description' => esc_attr__('Expandable and responsive grid', 'js_composer'),
            "params" => array(
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "edit_field_class" => "vc_col-xs-6 cqadmin-firstcol-offset",
                 "heading" => esc_attr__("Grid column", "cq_allinone_vc"),
                 "param_name" => "gridnumber",
                 "value" => array("1", "2", "3", "4", "5"),
                 "std" => "3",
                 "description" => esc_attr__("Customize the grid setting here first, then <a href='".plugins_url('img/griditem.png', __FILE__)."' target='_blank'>add the Grid Item</a> one by one.", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "edit_field_class" => "vc_col-xs-6 cqadmin-firstcol-offset",
                 "heading" => esc_attr__("Auto delay slideshow", "cq_allinone_vc"),
                 "param_name" => "autoslide",
                 "value" => array("no", "2", "3", "4", "5", "6", "7", "8"),
                 "std" => "no",
                 "description" => esc_attr__("In seconds, default is no, which is disabled.", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "heading" => esc_attr__("Item height", "cq_allinone_vc"),
                 "param_name" => "itemsize",
                 "value" => array("80", "100", "120", "160", "200", "240", "280", "320", "400", "customize below" => "customized"),
                 "std" => "160",
                 "description" => esc_attr__("Select the built in item height (in pixels) or customize it below.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Customize item height", "cq_allinone_vc"),
                "param_name" => "itemheight",
                "value" => "",
                "dependency" => Array('element' => "itemsize", 'value' => array('customized')),
                "description" => esc_attr__('Enter item height in pixels, for example: 400. Leave empty to use default 160 (pixels).', "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "heading" => esc_attr__("Avatar image size", "cq_allinone_vc"),
                 "param_name" => "avatarsize",
                 "value" => array("40", "60", "80", "100", "120", "160", "200", "240", "320", "400"),
                 "std" => "60",
                 "description" => esc_attr__("Select the built in avatar image size (in pixels).", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 cqadmin-col-offset",
                "heading" => esc_attr__("Label font-size", "cq_allinone_vc"),
                "param_name" => "labelfontsize",
                "value" => "",
                "description" => esc_attr__("Default (leave to blank) is 1em, support a value like 12px or 1.2em", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 cqadmin-col-offset",
                "heading" => esc_attr__("Sub title font-size", "cq_allinone_vc"),
                "param_name" => "subfontsize",
                "value" => "",
                "description" => esc_attr__("Default (leave to blank) is 0.9em", "cq_allinone_vc")
              ),
              array(
                'type' => 'checkbox',
                'heading' => esc_attr__('Do not open first grid by default? ', 'cq_allinone_vc' ),
                'param_name' => 'openfirst',
                'std' => 'no',
                'description' => esc_attr__("Check this if you don't want to open the first grid by default.", 'cq_allinone_vc' ),
                'value' => array( esc_attr__( 'Yes, hide them all by default', 'cq_allinone_vc' ) => 'yes' ),
              ),
              array(
                'type' => 'checkbox',
                'heading' => esc_attr__('Make the items a little transparent while not selected', 'cq_allinone_vc' ),
                'param_name' => 'transparentitem',
                'std' => 'yes',
                'description' => esc_attr__("un-check this if you don't want to apply the transparent effect to the items not selected.", 'cq_allinone_vc' ),
                'value' => array( esc_attr__( 'Yes, apply the focus effect', 'cq_allinone_vc' ) => 'yes' ),
              ),
              array(
                'type' => 'checkbox',
                'heading' => esc_attr__('Append the close button to the popup content?', 'cq_allinone_vc' ),
                'param_name' => 'closebutton',
                'std' => 'yes',
                'description' => esc_attr__("un-check this if you don't want to add the close button to the popup content.", 'cq_allinone_vc' ),
                'value' => array( esc_attr__( 'Yes, I like the close button', 'cq_allinone_vc' ) => 'yes' ),
              ),
              array(
                'type' => 'checkbox',
                'heading' => esc_attr__('Do not apply circular to the avatar image? ', 'cq_allinone_vc' ),
                'param_name' => 'nocircular',
                'std' => 'no',
                'description' => esc_attr__("Check this if you don't want to make the avatar image circularly.", 'cq_allinone_vc' ),
                'value' => array( esc_attr__( 'Yes, keep it in original', 'cq_allinone_vc' ) => 'nocircular' ),
              ),
              array(
                'type' => 'checkbox',
                'heading' => esc_attr__('Scroll to the opened item? ', 'cq_allinone_vc' ),
                "edit_field_class" => "vc_col-xs-6 vc_column",
                'param_name' => 'scrollto',
                'std' => 'no',
                'description' => esc_attr__("Check this if you want to the browser scroll to the current opend item.", 'cq_allinone_vc' ),
                'value' => array( esc_attr__( 'Yes, scroll to', 'cq_allinone_vc' ) => 'yes' ),
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Scroll to offset", "cq_allinone_vc"),
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "param_name" => "scrolloffset",
                "value" => "",
                "dependency" => Array('element' => "scrollto", 'value' => array('yes')),
                "description" => esc_attr__("You can customize the scroll offset too. For example 100 will move it 100px lower, -100 will be 100px upper.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
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
             "base" => "cq_vc_expandgrid_item",
             "class" => "cq_vc_expandgrid_item",
             "icon" => "cq_vc_expandgrid_item",
             "category" => esc_attr__('Sike Extensions', 'js_composer'),
             "description" => esc_attr__("Add image, icon and text","cq_allinone_vc"),
             "as_child" => array('only' => 'cq_vc_expandgrid'),
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
                  "group" => "Avatar",
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
                "group" => "Avatar",
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
                  'element' => 'faceicon',
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
                  'element' => 'faceicon',
                  'value' => 'typicons',
                ),
                "group" => "Avatar",
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
                "group" => "Avatar",
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
                  'element' => 'faceicon',
                  'value' => 'material',
                ),
                "group" => "Avatar",
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column cqadmin-col-offset",
                "class" => "",
                "heading" => esc_attr__("Icon size", "cq_allinone_vc"),
                "param_name" => "iconsize",
                "value" => "",
                "dependency" => Array('element' => "avatartype", 'value' => array('icon')),
                "group" => "Avatar",
                "description" => esc_attr__('Default is 28px (leave to blank). Support a value like 2em or 32px', "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column cqadmin-col-offset",
                "class" => "",
                "heading" => esc_attr__("Icon color", 'cq_allinone_vc'),
                "param_name" => "iconcolor",
                "value" => "",
                "group" => "Avatar",
                "dependency" => Array('element' => "avatartype", 'value' => array('icon')),
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
              ),

              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Avatar image:", "cq_allinone_vc"),
                "param_name" => "avatarimage",
                "value" => "",
                "group" => "Avatar",
                "dependency" => Array('element' => "avatartype", 'value' => array('image')),
                "description" => esc_attr__("Select from media library.", "cq_allinone_vc")
              ),
              array(
                'type' => 'checkbox',
                'heading' => esc_attr__( 'Resize the avatar image?', 'cq_allinone_vc' ),
                'param_name' => 'avatarresize',
                'description' => esc_attr__( 'We will use the original image by default, you can specify a width below if the original image is too large.', 'cq_allinone_vc' ),
                'std' => 'no',
                "group" => "Avatar",
                "dependency" => Array('element' => "avatartype", 'value' => array('image')),
                'value' => array( esc_attr__( 'Yes', 'cq_allinone_vc' ) => 'yes' ),
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width.", "cq_allinone_vc"),
                "param_name" => "avatarimagesize",
                "value" => "",
                "dependency" => Array('element' => "avatarresize", 'value' => array('yes')),
                "group" => "Avatar",
                "description" => esc_attr__('Enter image width in pixels, for example: 400. The image then will be resized to 400. Leave empty to use original full image.', "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-8 cqadmin-col-offset",
                "heading" => esc_attr__("Label for the item (optional, under the avatar)", "cq_allinone_vc"),
                "param_name" => "gridlabel",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("For example, a name, John Smith", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-4 cqadmin-col-offset",
                "heading" => esc_attr__("Label color", 'cq_allinone_vc'),
                "param_name" => "labelcolor",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-8 cqadmin-col-offset",
                "heading" => esc_attr__("Sub title for the item (optional, under the label)", "cq_allinone_vc"),
                "param_name" => "gridsublabel",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("For example, a job title, Web Developer", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-4 cqadmin-col-offset",
                "heading" => esc_attr__("Sub title color", 'cq_allinone_vc'),
                "param_name" => "subtitlecolor",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Tooltip for the item (optional)", "cq_allinone_vc"),
                "param_name" => "tooltip",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textarea_html",
                "heading" => esc_attr__("Content", "cq_allinone_vc"),
                "param_name" => "content",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("The slide in content.", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_attr__("Text color", 'cq_allinone_vc'),
                "param_name" => "contentcolor",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("", 'cq_allinone_vc')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "",
                "heading" => esc_attr__("Background color of the grid item:", "cq_allinone_vc"),
                "param_name" => "bgstyle",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "Transparent (content with white background)" => "cq-transparent", "Customized color:" => "customized"),
                'std' => 'aqua',
                'group' => 'Background',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_attr__("Background color of the grid item", 'cq_allinone_vc'),
                "param_name" => "backgroundcolor",
                "value" => "",
                'group' => 'Background',
                "dependency" => Array('element' => "bgstyle", 'value' => array('customized')),
                "description" => esc_attr__("Default is medium gray. Note, the content only support white background with customized gird item background.", 'cq_allinone_vc')
              ),
              array(
                  "type" => "attach_image",
                  "heading" => esc_attr__("Background image:", "cq_allinone_vc"),
                  "param_name" => "image",
                  "value" => "",
                  "group" => "Background",
                  "description" => esc_attr__("Select from media library.", "cq_allinone_vc")
              ),
              array(
                'type' => 'checkbox',
                'heading' => esc_attr__( 'Resize the image?', 'cq_allinone_vc' ),
                'param_name' => 'isresize',
                'description' => esc_attr__( 'We will use the original image by default, you can specify a width below if the original image is too large.', 'cq_allinone_vc' ),
                'std' => 'no',
                "group" => "Background",
                'value' => array( esc_attr__( 'Yes', 'cq_allinone_vc' ) => 'yes' ),
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width.", "cq_allinone_vc"),
                "param_name" => "imagesize",
                "value" => "",
                "dependency" => Array('element' => "isresize", 'value' => array('yes')),
                "group" => "Background",
                "description" => esc_attr__('Enter image width in pixels, for example: 400. The image then will be resized to 400. Leave empty to use original full image.', "cq_allinone_vc")
              )

              ),
            )
        );

          add_shortcode('cq_vc_expandgrid', array($this,'cq_vc_expandgrid_func'));
          add_shortcode('cq_vc_expandgrid_item', array($this,'cq_vc_expandgrid_item_func'));

      }

      function cq_vc_expandgrid_func($atts, $content=null) {
        $css_class = $css =  $gridnumber = $transparentitem = $autoslide = $itemsize = $itemheight = $avatarsize = $openfirst = $closebutton = $labelfontsize = $subfontsize = $nocircular = $scrollto = $scrolloffset = $extraclass = '';
        extract(shortcode_atts(array(
          "gridnumber" => "3",
          "autoslide" => "no",
          "closebutton" => "yes",
          "transparentitem" => "yes",
          "itemsize" => "",
          "avatarsize" => "",
          "itemheight" => "",
          "openfirst" => "no",
          "labelfontsize" => "",
          "subfontsize" => "",
          "nocircular" => "",
          "scrollto" => "no",
          "scrolloffset" => "0",
          "css" => "",
          "extraclass" => ""
        ),$atts));

        $output = "";
        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ''), 'cq_vc_expandgrid', $atts);
        wp_register_style( 'vc-extensions-expandgrid-style', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style( 'vc-extensions-expandgrid-style' );

        wp_register_style('tooltipster', plugins_url('../appmockup/css/tooltipster.css', __FILE__));
        wp_enqueue_style('tooltipster');

        wp_register_script('tooltipster', plugins_url('../appmockup/js/jquery.tooltipster.min.js', __FILE__), array('jquery'));
        wp_enqueue_script('tooltipster');


        wp_register_script('vc-extensions-expandgrid-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "tooltipster"));
        wp_enqueue_script('vc-extensions-expandgrid-script');
        if($closebutton=="") {
          $closebutton = 'no';
        }else{
          vc_icon_element_fonts_enqueue('fontawesome');
        }
        $output .= '<div class="cq-expandgrid cq-circular-'.$nocircular.' cq-expandgrid-'.$itemsize.' cq-expandgrid-avatar-'.$avatarsize.' cq-expandgrid-close-'.$closebutton.' cq-expandgrid-in'.$gridnumber.' '.$extraclass.' '.$css_class.'" data-itemheight="'.$itemheight.'" data-autoslide="'.$autoslide.'" data-itemsize="'.$itemsize.'" data-transparentitem="'.$transparentitem.'" data-openfirst="'.$openfirst.'" data-labelfontsize="'.$labelfontsize.'" data-nocircular="'.$nocircular.'" data-subfontsize="'.$subfontsize.'" data-scrollto="'.$scrollto.'" data-scrolloffset="'.$scrolloffset.'">';
        $output .= do_shortcode($content);
        $output .= '</div>';
        return $output;

      }


      function cq_vc_expandgrid_item_func($atts, $content=null, $tag) {
          $output = $faceicon = $image = $imagesize = $videowidth = $isresize = $tooltip =  $backgroundcolor = $backgroundhovercolor = $itembgcolor = $iconcolor = $iconsize =  $css = $bgstyle =  $gridlabel = $gridsublabel = $contentcolor = $labelcolor = $subtitlecolor =  "";
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
              "backgroundcolor" => "",
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
              "css" => ""
            ), $atts));

          vc_icon_element_fonts_enqueue($faceicon);
          $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

          $img = $thumbnail = "";

          $fullimage = wp_get_attachment_image_src($image, 'full');
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

          $arrowstyle_str = '';
          if($bgstyle == "customized" && $backgroundcolor != ""){
          	$arrowstyle_str = "border-bottom:15px solid $backgroundcolor";
          }
          $itembgstyle_str = '';
          if($bgstyle == "customized" && $backgroundcolor != ""){
          	$itembgstyle_str = "background-color: $backgroundcolor";
          }



          $output = '';
          $output .= '<div class="cq-expandgrid-item cq-expandgrid-initstate '.$bgstyle.'" data-image="'.$thumbnail.'" data-bgstyle="'.$bgstyle.'" data-backgroundcolor="'.$backgroundcolor.'" data-backgroundhovercolor="'.$backgroundhovercolor.'" data-avatartype="'.$avatartype.'" data-avatar="'.$avatarthumbnail.'" data-contentcolor="'.$contentcolor.'" data-iconcolor="'.$iconcolor.'" data-iconsize="'.$iconsize.'" data-labelcolor="'.$labelcolor.'" data-subtitlecolor="'.$subtitlecolor.'" title="'.esc_html($tooltip).'">';
          $output .= '<div class="cq-expandgrid-face cq-expandgrid-toggle" style="'.$itembgstyle_str.'">';
          $output .= '<div class="cq-expandgrid-facecontent">';
          if($avatarthumbnail!=""){
            $output .= '<div class="cq-expandgrid-avatar">';
            $output .= '</div>';
          }
          if(version_compare(WPB_VC_VERSION,  "4.4")>=0&&isset(${'icon_' . $faceicon})&&esc_attr(${'icon_' . $faceicon})!=""&&$avatartype=="icon"){
              $output .= '<i class="cq-expandgrid-icon '.esc_attr(${'icon_' . $faceicon}).'"></i>';
          }
          if($gridlabel!=""){
              $output .= '<span class="cq-expandgrid-title">'.$gridlabel.'</span> ';
          }
          if($gridsublabel!=""){
              $output .= '<span class="cq-expandgrid-subtitle">'.$gridsublabel.'</span> ';
          }
          $output .= '</div>';
          $output .= '<div class="cq-expandgrid-arrow" style="'.$arrowstyle_str.'"></div>';
          $output .= '</div>';
          $output .= '<div class="cq-expandgrid-content" style="'.$itembgstyle_str.'">';
          $output .= '<div class="cq-expandgrid-text">';
          $output .= do_shortcode($content);
          $output .= '</div>';
          $output .= '<i class="fa fa-close cq-expandgrid-close"></i>';
          $output .= '</div>';
          $output .= '</div>';
          return $output;

        }

  }
}
//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) && !class_exists('WPBakeryShortCode_cq_vc_expandgrid')) {
    class WPBakeryShortCode_cq_vc_expandgrid extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) && !class_exists('WPBakeryShortCode_cq_vc_expandgrid_item')) {
    class WPBakeryShortCode_cq_vc_expandgrid_item extends WPBakeryShortCode {
    }
}

?>
