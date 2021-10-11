<?php
if (!class_exists('VC_Extensions_CompareCard')){
    class VC_Extensions_CompareCard{
        private $imgnum = 1;
        private $labelfontsize = "";
        private $subfontsize = "";
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Compare Card", 'js_composer'),
            "base" => "cq_vc_comparecard",
            "class" => "cq_vc_comparecard",
            "icon" => "cq_vc_comparecard",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            "as_parent" => array('only' => 'cq_vc_comparecard_item'),
            "js_view" => 'VcColumnView',
            "show_settings_on_create" => true,
            'description' => esc_attr__('Compare 2 cards', 'js_composer'),
            "params" => array(
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "edit_field_class" => "vc_col-xs-6 cqadmin-firstcol-offset",
                 "heading" => esc_attr__("Auto delay slideshow", "js_composer"),
                 "param_name" => "autoslide",
                 "value" => array("no", "2", "3", "4", "5", "6", "7", "8"),
                 "std" => "no",
                 "description" => esc_attr__("In seconds, default is no, which is disabled.", "js_composer")
              ),
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "heading" => esc_attr__("Avatar image size", "js_composer"),
                 "param_name" => "avatarsize",
                 "value" => array("40", "60", "80", "100", "120", "160", "200", "240", "320"),
                 "std" => "80",
                 "description" => esc_attr__("Select the built in avatar image size (in pixels).", "js_composer")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 cqadmin-col-offset",
                "heading" => esc_attr__("Label font-size", "js_composer"),
                "param_name" => "labelfontsize",
                "value" => "",
                "description" => esc_attr__("Default (leave to blank) is 1em, support a value like 12px or 1.2em", "js_composer")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 cqadmin-col-offset",
                "heading" => esc_attr__("Sub title font-size", "js_composer"),
                "param_name" => "subfontsize",
                "value" => "",
                "description" => esc_attr__("Default (leave to blank) is 0.9em", "js_composer")
              ),
              array(
                'type' => 'checkbox',
                'heading' => esc_attr__('Make the items a little transparent while not selected', 'js_composer' ),
                'param_name' => 'transparentitem',
                'std' => 'yes',
                'description' => esc_attr__("un-check this if you don't want to apply the transparent effect to the items not selected.", 'js_composer' ),
                'value' => array( esc_attr__( 'Yes, apply the focus effect', 'js_composer' ) => 'yes' ),
              ),
              array(
                'type' => 'checkbox',
                'heading' => esc_attr__('Display the arrow navigation or not?', 'js_composer' ),
                'param_name' => 'isarrow',
                'std' => 'yes',
                'description' => esc_attr__("un-check this if you don't want to display the arrow navigation under the cards.", 'js_composer' ),
                'value' => array( esc_attr__( 'Yes, display the arrow navigation', 'js_composer' ) => 'yes' ),
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "js_composer"),
                "param_name" => "extraclass",
                "value" => "",
                "description" => esc_attr__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
              ),
              array(
                "type" => "css_editor",
                "heading" => esc_attr__( "CSS", "js_composer" ),
                "param_name" => "css",
                "description" => esc_attr__("It's recommended to use this to customize the padding/margin only.", "js_composer"),
                "group" => esc_attr__( "Design options", "js_composer" ),
             )
           )
        ));

        vc_map(
          array(
             "name" => esc_attr__("Compare Item","js_composer"),
             "base" => "cq_vc_comparecard_item",
             "class" => "cq_vc_comparecard_item",
             "icon" => "cq_vc_comparecard_item",
             "category" => esc_attr__('Sike Extensions', 'js_composer'),
             "description" => esc_attr__("Add image, icon and text","js_composer"),
             "as_child" => array('only' => 'cq_vc_comparecard'),
             "show_settings_on_create" => true,
             "content_element" => true,
             "params" => array(
                array(
                  "type" => "dropdown",
                  "holder" => "",
                  "heading" => esc_attr__("Display the avatar with", "js_composer"),
                  "param_name" => "avatartype",
                  "value" => array("None (no avatar)"=>"none", "Image" => "image", "Icon" => "icon"),
                  "std" => "icon",
                  "group" => "Avatar",
                  "description" => esc_attr__("", "js_composer")
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
                "heading" => esc_attr__("Icon size", "js_composer"),
                "param_name" => "iconsize",
                "value" => "",
                "dependency" => Array('element' => "avatartype", 'value' => array('icon')),
                "group" => "Avatar",
                "description" => esc_attr__('Default is 28px (leave to blank). Support a value like 2em or 32px', "js_composer")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column cqadmin-col-offset",
                "class" => "",
                "heading" => esc_attr__("Icon color", 'js_composer'),
                "param_name" => "iconcolor",
                "value" => "",
                "group" => "Avatar",
                "dependency" => Array('element' => "avatartype", 'value' => array('icon')),
                "description" => esc_attr__("Default is gray.", 'js_composer')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => esc_attr__("Avatar background color", 'js_composer'),
                "param_name" => "avatarbg",
                "value" => "",
                "group" => "Avatar",
                "dependency" => Array('element' => "avatartype", 'value' => array('icon')),
                "description" => esc_attr__("Default is white.", 'js_composer')
              ),

              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Avatar image:", "js_composer"),
                "param_name" => "avatarimage",
                "value" => "",
                "group" => "Avatar",
                "dependency" => Array('element' => "avatartype", 'value' => array('image')),
                "description" => esc_attr__("Select from media library.", "js_composer")
              ),
              array(
                "type" => "checkbox",
                "heading" => esc_attr__( "Resize the avatar image?", "js_composer" ),
                "param_name" => "avatarresize",
                "description" => esc_attr__( "We will use the original image by default, you can specify a width below if the original image is too large.", "js_composer" ),
                "std" => "no",
                "group" => "Avatar",
                "dependency" => Array("element" => "avatartype", "value" => array("image")),
                "value" => array( esc_attr__( "Yes", "js_composer" ) => "yes" ),
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width.", "js_composer"),
                "param_name" => "avatarimagesize",
                "value" => "",
                "dependency" => Array('element' => "avatarresize", 'value' => array('yes')),
                "group" => "Avatar",
                "description" => esc_attr__('Enter image width in pixels, for example: 400. The image then will be resized to 400. Leave empty to use original full image.', "js_composer")
              ),
              array(
                "type" => "vc_link",
                "heading" => esc_attr__( "Link for the avatar (optional)", "js_composer" ),
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "param_name" => "avatarlink",
                "group" => "Avatar",
                "description" => esc_attr__( "", "js_composer" )
              ),
              array(
                "type" => "checkbox",
                "heading" => esc_attr__("Display the link as lightbox?", "js_composer" ),
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "param_name" => "islightbox",
                "std" => "no",
                "group" => "Avatar",
                "description" => esc_attr__("Support YouTube, Vimeo video, image, Google Map etc.", "js_composer" ),
                "value" => array( esc_attr__( "Yes, apply lightbox effect", "js_composer" ) => "yes" ),
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Tooltip for the avatar (optional)", "js_composer"),
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "param_name" => "tooltip",
                "value" => "",
                "group" => "Avatar",
                "description" => esc_attr__("", "js_composer")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-8 cqadmin-col-offset",
                "heading" => esc_attr__("Title for the item (optional, under the avatar)", "js_composer"),
                "param_name" => "avatarlabel",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("For example, a name, John Smith", "js_composer")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-4 cqadmin-col-offset",
                "heading" => esc_attr__("Label color", 'js_composer'),
                "param_name" => "labelcolor",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default is white.", 'js_composer')
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-8 cqadmin-col-offset",
                "heading" => esc_attr__("Sub title for the item (optional, under the label)", "js_composer"),
                "param_name" => "avatarsublabel",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("For example, a job title, Web Developer", "js_composer")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_col-xs-4 cqadmin-col-offset",
                "heading" => esc_attr__("Sub title color", 'js_composer'),
                "param_name" => "subtitlecolor",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("Default is white.", 'js_composer')
              ),
              array(
                "type" => "textarea_html",
                "heading" => esc_attr__("Content", "js_composer"),
                "param_name" => "content",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("", "js_composer")
              ),
              array(
                  "type" => "textfield",
                  "heading" => esc_attr__("Button text", "cq_allinone_vc"),
                  "param_name" => "buttontext",
                  "value" => "",
                  'group' => 'Button',
                  'dependency' => array('element' => 'isbutton', 'value' => 'yes'),
                  "description" => esc_attr__("Optional button under the text.", "cq_allinone_vc")
            ),
            array(
               "type" => "dropdown",
               "edit_field_class" => "vc_col-xs-6 vc_column",
               "holder" => "",
               "heading" => esc_attr__("Color", "cq_allinone_vc"),
               "param_name" => "buttoncolor",
               "value" => array('Blue' => 'blue', 'Turquoise' => 'turquoise', 'Pink' => 'pink', 'Violet' => 'violet', 'Peacoc' => 'peacoc', 'Chino' => 'chino', 'Vista Blue' => 'vista_blue', 'Black' => 'black', 'Grey' => 'grey', 'Orange' => 'orange', 'Sky' => 'sky', 'Green' => 'green', 'Juicy pink' => 'juicy_pink', 'Sandy brown' => 'sandy_brown', 'Purple' => 'purple', 'White' => 'white'),
              'std' => 'blue',
              'group' => 'Button',
              'dependency' => array('element' => 'isbutton', 'value' => 'yes'),
              "description" => esc_attr__("", "cq_allinone_vc")
            ),
            array(
               "type" => "dropdown",
               "edit_field_class" => "vc_col-xs-6 vc_column",
               "holder" => "",
               "heading" => esc_attr__("Size", "cq_allinone_vc"),
               "param_name" => "buttonsize",
               "value" => array('Mini' => 'xs', 'Small' => 'sm', 'Normal' => '', 'Large' => 'lg' ),
              'std' => 'sm',
              'group' => 'Button',
              'dependency' => array('element' => 'isbutton', 'value' => 'yes'),
              "description" => esc_attr__("", "cq_allinone_vc")
            ),
            array(
               "type" => "dropdown",
               "edit_field_class" => "vc_col-xs-6 vc_column",
               "holder" => "",
               "heading" => esc_attr__("Style", "cq_allinone_vc"),
               "param_name" => "buttonstyle",
               "value" => array("Modern" => "", "Classic" => "classic", "Flat" => "flat", "Outline" => "outline", "3D" => "3d" ),
              'std' => '',
              'group' => 'Button',
              'dependency' => array('element' => 'isbutton', 'value' => 'yes'),
              "description" => esc_attr__("", "cq_allinone_vc")
            ),
            array(
              "type" => "dropdown",
              "edit_field_class" => "vc_col-xs-6 vc_column",
              "holder" => "",
              "heading" => esc_attr__("Shape", "cq_allinone_vc"),
              "param_name" => "buttonshape",
              "value" => array('Rounded' => 'rounded', 'Square' => 'square', 'Round' => 'round'),
              'std' => 'rounded',
              'group' => 'Button',
              'dependency' => array('element' => 'isbutton', 'value' => 'yes'),
              "description" => esc_attr__("", "cq_allinone_vc")
            ),
            array(
              "type" => "vc_link",
              "edit_field_class" => "vc_col-xs-6 vc_column",
              "heading" => esc_attr__("URL (Optional link for the button)", "cq_allinone_vc"),
              "param_name" => "buttonlink",
              "value" => "",
              'group' => 'Button',
              'dependency' => array('element' => 'isbutton', 'value' => 'yes'),
              "description" => esc_attr__("", "cq_allinone_vc")
           	 ),
         	 array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_attr__("Background color of the item", "js_composer"),
                "param_name" => "backgroundcolor",
                "value" => "",
                "group" => "Background",
                "description" => esc_attr__("Default is light gray.", "js_composer")
              ),
              array(
                  "type" => "attach_image",
                  "heading" => esc_attr__("Background image:", "js_composer"),
                  "param_name" => "image",
                  "value" => "",
                  "group" => "Background",
                  "description" => esc_attr__("Select from media library.", "js_composer")
              ),
              array(
                "type" => "checkbox",
                "heading" => esc_attr__( "Resize the image?", "js_composer" ),
                "param_name" => "isresize",
                "description" => esc_attr__( "We will use the original image by default, you can specify a width below if the original image is too large.", "js_composer" ),
                "std" => "no",
                "group" => "Background",
                "value" => array( esc_attr__( "Yes", "js_composer" ) => "yes" ),
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width.", "js_composer"),
                "param_name" => "imagesize",
                "value" => "",
                "dependency" => Array('element' => "isresize", 'value' => array('yes')),
                "group" => "Background",
                "description" => esc_attr__('Enter image width in pixels, for example: 400. The image then will be resized to 400. Leave empty to use original full image.', "js_composer")
              )

              ),
            )
        );

          add_shortcode('cq_vc_comparecard', array($this,'cq_vc_comparecard_func'));
          add_shortcode('cq_vc_comparecard_item', array($this,'cq_vc_comparecard_item_func'));

      }

      function cq_vc_comparecard_func($atts, $content=null) {
        $css_class = $css = $transparentitem = $isarrow = $autoslide = $avatarsize = $labelfontsize = $subfontsize = $extraclass = '';
        extract(shortcode_atts(array(
          "autoslide" => "no",
          "transparentitem" => "yes",
          "isarrow" => "yes",
          "avatarsize" => "80",
          "labelfontsize" => "",
          "subfontsize" => "",
          "css" => "",
          "extraclass" => ""
        ),$atts));

        $this -> imgnum = 1;
        $this -> labelfontsize = $labelfontsize;
        $this -> subfontsize = $subfontsize;

        $output = "";
        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ''), 'cq_vc_comparecard', $atts);
        wp_register_style( 'vc-extensions-comparecard-style', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style( 'vc-extensions-comparecard-style' );

        wp_register_style('tooltipster', plugins_url('../appmockup/css/tooltipster.css', __FILE__));
        wp_enqueue_style('tooltipster');

        wp_register_script('tooltipster', plugins_url('../appmockup/js/jquery.tooltipster.min.js', __FILE__), array('jquery'));
        wp_enqueue_script('tooltipster');


    		wp_register_style('lity', plugins_url('../hotspot/css/lity.min.css', __FILE__));
    		wp_enqueue_style('lity');
    		wp_register_script('lity', plugins_url('../hotspot/js/lity.min.js', __FILE__), array('jquery'));
    		wp_enqueue_script('lity');




        wp_register_script('vc-extensions-comparecard-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "tooltipster"));
        wp_enqueue_script('vc-extensions-comparecard-script');

        $output .= '<div class="cq-comparecard cq-comparecard-transparent-'.$transparentitem.' cq-comparecard-arrow-'.$isarrow.' cq-comparecard-avatar-'.$avatarsize.' '.$extraclass.' '.$css_class.'" data-autoslide="'.$autoslide.'">';
		$output .= '<div class="cq-comparecard-container">';
        $output .= do_shortcode($content);

		$output .= '</div>';
		if($isarrow == "yes"){
			$output .= '<div class="cq-comparecard-buttoncontainer">';
			$output .= '<div class="cq-comparecard-button">';
			$output .= '<input type="checkbox" class="cq-comparecard-checkbox">';
			$output .= '<div class="cq-comparecard-arrow">';
			$output .= '<i class="entypo-icon entypo-icon-right-open-big"></i>';
			$output .= '<i class="entypo-icon entypo-icon-left-open-big"></i>';
			$output .= '</div>';
			$output .= '<div class="cq-comparecard-bar"></div>';
			$output .= '</div>';
			$output .= '</div>';
		}

        $output .= '</div>';
        return $output;

      }


      function cq_vc_comparecard_item_func($atts, $content=null, $tag) {
          $output = $faceicon = $image = $imagesize = $videowidth = $isresize = $tooltip =  $backgroundcolor = $backgroundhovercolor = $itembgcolor = $iconcolor = $avatarbg = $iconsize =  $css = $avatarlabel = $avatarlink = $islightbox = $avatarsublabel = $labelcolor = $subtitlecolor = $buttoncolor = $buttontext = $buttonshape = $buttonsize = $buttonstyle = $buttonlink =  "";
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
    				"avatarbg" => "",
    				"iconsize" => "",
    				"avatarlabel" => "",
    				"avatarlink" => "",
    				"islightbox" => "",
    				"avatarsublabel" => "",
    				"labelcolor" => "",
    				"subtitlecolor" => "",
    				"buttontext" => "",
    				"buttoncolor" => "blue",
    				"buttonsize" => "xs",
    				"buttonshape" => "rounded",
    				"buttonstyle" => "",
    				"buttonlink" => "",
                  	"css" => ""
            ), $atts));

          vc_icon_element_fonts_enqueue($faceicon);
          $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

          $imgnum = $this -> imgnum;
          $labelfontsize = $this -> labelfontsize;
          $subfontsize = $this -> subfontsize;

          $avatarlink = vc_build_link($avatarlink);

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


          $output = '';
          $cq_init_class = '';

          $is_lity = $islightbox == "yes" ? "data-lity" : "";

        if($imgnum<=2){
				if($imgnum==1){
					$cq_init_class = "cq-comparecard-in";
				}else{
					$cq_init_class = "cq-comparecard-out";
				}
				$output .= '<div class="cq-comparecard-item '.$cq_init_class.'" data-image="'.$thumbnail.'" data-backgroundhovercolor="'.$backgroundhovercolor.'" data-avatartype="'.$avatartype.'" style="background-color:'.$backgroundcolor.';background-image:url('.$thumbnail.')" title="'.esc_html($tooltip).'">';

				if(isset($avatarlink['url'])&&$avatarlink['url']!=""){
	              $output .= '<a href="'.$avatarlink['url'].'" class="cq-comparecard-link" title="'.$avatarlink["title"].'" '.$is_lity.' target="'.$avatarlink["target"].'">';
	          	}


				$output .= '<div class="cq-comparecard-avatar" style="background-image:url('.$avatarthumbnail.');background-color:'.$avatarbg.';">';

				if(version_compare(WPB_VC_VERSION,  "4.4")>=0&&isset(${'icon_' . $faceicon})&&esc_attr(${'icon_' . $faceicon})!=""&&$avatartype=="icon"){
				  $output .= '<i class="cq-comparecard-icon '.esc_attr(${'icon_' . $faceicon}).'" style="color:'.$iconcolor.';font-size:'.$iconsize.';"></i>';
				}
				$output .= '</div>';
				if(isset($avatarlink['url'])&&$avatarlink['url']!=""){
					$output .= '</a>';
				}
				if($avatarlabel!=""){
				  $output .= '<h4 class="cq-comparecard-title" style="font-size:'.$labelfontsize.';color:'.$labelcolor.'">'.$avatarlabel.'</h4> ';
				}
				if($avatarsublabel!=""){
				  $output .= '<span class="cq-comparecard-subtitle" style="font-size:'.$subfontsize.';color:'.$subtitlecolor.'">'.$avatarsublabel.'</span> ';
				}
				$output .= '<div class="cq-comparecard-text">';
				$output .= do_shortcode($content);
				$output .= '</div>';

				if($buttontext!="")$output .= do_shortcode('[vc_btn title="'.$buttontext.'" color="'.$buttoncolor.'" align="center" style="'.$buttonstyle.'" shape="'.$buttonshape.'" link="'.$buttonlink.'" style="'.$buttonstyle.'" size="'.$buttonsize.'"]');


				$output .= '</div>';
			}

			$imgnum++;
	    $this -> imgnum = $imgnum;
	    return $output;

    }

  }
}
//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) && !class_exists('WPBakeryShortCode_cq_vc_comparecard')) {
    class WPBakeryShortCode_cq_vc_comparecard extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) && !class_exists('WPBakeryShortCode_cq_vc_comparecard_item')) {
    class WPBakeryShortCode_cq_vc_comparecard_item extends WPBakeryShortCode {
    }
}

?>
