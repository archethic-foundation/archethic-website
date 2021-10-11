<?php
if (!class_exists('VC_Extensions_Separator')) {
    class VC_Extensions_Separator{
        function __construct() {
          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){

            vc_map(array(
            "name" => esc_attr__("Separator with Icon", 'vc_separator_cq'),
            "base" => "cq_vc_separator",
            "class" => "wpb_cq_vc_extension_separator",
            "icon" => "cq_allinone_separator",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Horizontal separator with icon or text', 'js_composer'),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_separator_cq",
                "heading" => esc_attr__("Display the title as:", "vc_separator_cq"),
                "param_name" => "titleas",
                "value" => array(esc_attr__("Text", "vc_separator_cq") => "text", esc_attr__("Font Awesome icon", "vc_separator_cq") => "icon"),
                "description" => esc_attr__("", "vc_separator_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Title", "vc_separator_cq"),
                "param_name" => "title",
                "value" => "Title",
                "dependency" => Array('element' => "titleas", 'value' => array('text')),
                "description" => esc_attr__("", "vc_separator_cq")
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
                'param_name' => 'icon',
                "dependency" => Array('element' => "titleas", 'value' => array('icon')),
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
                  'element' => 'icon',
                  'value' => 'fontawesome',
                ),
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
                  'element' => 'icon',
                  'value' => 'openiconic',
                ),
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
                  'element' => 'icon',
                  'value' => 'typicons',
                ),
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
                'dependency' => array(
                  'element' => 'icon',
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
                  'element' => 'icon',
                  'value' => 'linecons',
                ),
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
                  'element' => 'icon',
                  'value' => 'material',
                ),
                'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for the title/icon)', 'vc_separator_cq' ),
                'param_name' => 'link',
                'description' => esc_attr__( '', 'vc_separator_cq' )
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_separator_cq",
                "heading" => esc_attr__("Display how many icons:", "vc_separator_cq"),
                "param_name" => "iconnum",
                "value" => array("1", "2", "3", "4", "5"),
                "dependency" => Array('element' => "titleas", 'value' => array('icon')),
                "description" => esc_attr__("", "vc_separator_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_separator_cq",
                "heading" => esc_attr__("Shape of the text:", "vc_separator_cq"),
                "param_name" => "titleshape1",
                "value" => array(esc_attr__("rounded (border-radius 4px)", "vc_separator_cq") => "rounded", esc_attr__("square (border-radius 0)", "vc_separator_cq") => "square"),
                "dependency" => Array('element' => "titleas", 'value' => array('text')),
                "description" => esc_attr__("", "vc_separator_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_separator_cq",
                "heading" => esc_attr__("Shape of the icon:", "vc_separator_cq"),
                "param_name" => "titleshape2",
                "value" => array(esc_attr__("circle (border-radius 50%)", "vc_separator_cq") => "circle", esc_attr__("rounded (border-radius 4px)", "vc_separator_cq") => "rounded", esc_attr__("square (border-radius 0)", "vc_separator_cq") => "square"),
                "dependency" => Array('element' => "titleas", 'value' => array('icon')),
                "description" => esc_attr__("", "vc_separator_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Background color", 'vc_separator_cq'),
                "param_name" => "bgcolor",
                "value" => '#333',
                "description" => esc_attr__("", 'vc_separator_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Font color", 'vc_separator_cq'),
                "param_name" => "fontcolor",
                "value" => '#fff',
                "description" => esc_attr__("", 'vc_separator_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "#333",
                "heading" => esc_attr__("Border color", 'vc_separator_cq'),
                "param_name" => "bordercolor",
                "value" => '#333333',
                "description" => esc_attr__("Default is dark gray (#333333).", 'vc_separator_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Border color for the center element", 'vc_separator_cq'),
                "param_name" => "centerbordercolor",
                "value" => '',
                "description" => esc_attr__("", 'vc_separator_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_separator_cq",
                "heading" => esc_attr__("Border style", "vc_separator_cq"),
                "param_name" => "borderstyle",
                "value" => array("solid", "dashed", "dotted", "gradient-color"),
                "description" => esc_attr__("", "vc_separator_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Left color for the gradient-color", 'vc_separator_cq'),
                "param_name" => "leftcolor",
                "value" => '#4ac1ff',
                "dependency" => Array('element' => "borderstyle", 'value' => array('gradient-color')),
                "description" => esc_attr__("", 'vc_separator_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Center color for the gradient-color", 'vc_separator_cq'),
                "param_name" => "centercolor",
                "value" => '#663399',
                "dependency" => Array('element' => "borderstyle", 'value' => array('gradient-color')),
                "description" => esc_attr__("", 'vc_separator_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Right color for the gradient-color", 'vc_separator_cq'),
                "param_name" => "rightcolor",
                "value" => '#795bb0',
                "dependency" => Array('element' => "borderstyle", 'value' => array('gradient-color')),
                "description" => esc_attr__("", 'vc_separator_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_separator_cq",
                "heading" => esc_attr__("Element width", "vc_separator_cq"),
                "param_name" => "elementwidth",
                "value" => array("100%", "90%", "80%", "70%", "60%", "50%", "40%"),
                "description" => esc_attr__("", "vc_separator_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Position (CSS left here) of the text/icon:", "vc_separator_cq"),
                "param_name" => "titleposition",
                "value" => "50%",
                "description" => esc_attr__("Default is 50%, stand for center. 0 stand for left, 80% stand for right.", "vc_separator_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Width for the text/icon:", "vc_separator_cq"),
                "param_name" => "titlewidth",
                "value" => "",
                "description" => esc_attr__("", "vc_separator_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Border size", "vc_separator_cq"),
                "param_name" => "bordersize",
                "value" => "1px",
                "description" => esc_attr__("", "vc_separator_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Text/icon font size:", "vc_separator_cq"),
                "param_name" => "fontsize",
                "value" => "1em",
                "description" => esc_attr__("", "vc_separator_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("font-family for the text", "vc_separator_cq"),
                "param_name" => "fontfamily",
                "value" => "",
                "dependency" => Array('element' => "titleas", 'value' => array('text')),
                "description" => esc_attr__("You can specify the CSS font-family for the text here.", "vc_separator_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Border radius", "vc_separator_cq"),
                "param_name" => "customborderradius",
                "value" => "",
                "description" => esc_attr__("You can select the shape above or specify the border-radius for the text/icon background here.", "vc_separator_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS margin for this separator", "vc_separator_cq"),
                "param_name" => "margin",
                "value" => "",
                "description" => esc_attr__("Default is margin: 4em auto.", "vc_separator_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS padding for the text/icon", "vc_separator_cq"),
                "param_name" => "padding",
                "value" => "",
                "description" => esc_attr__("Default is 0.4em 0.6em for rounded and square.", "vc_separator_cq")
              )
           )
        ));


        }else{

          vc_map(array(
            "name" => esc_attr__("Separator with Icon", 'vc_separator_cq'),
            "base" => "cq_vc_separator",
            "class" => "wpb_cq_vc_extension_separator",
            "icon" => "cq_allinone_separator",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            'description' => esc_attr__('Horizontal separator with icon or text', 'js_composer'),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_separator_cq",
                "heading" => esc_attr__("Display the title as:", "vc_separator_cq"),
                "param_name" => "titleas",
                "value" => array(esc_attr__("Text", "vc_separator_cq") => "text", esc_attr__("Font Awesome icon", "vc_separator_cq") => "icon"),
                "description" => esc_attr__("", "vc_separator_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Title", "vc_separator_cq"),
                "param_name" => "title",
                "value" => "Title",
                "dependency" => Array('element' => "titleas", 'value' => array('text')),
                "description" => esc_attr__("", "vc_separator_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Font Awesome", "vc_separator_cq"),
                "param_name" => "icon",
                "value" => "fa-angle-double-down",
                "dependency" => Array('element' => "titleas", 'value' => array('icon')),
                "description" => esc_attr__("See all available Font Awesome icon. For example, fa-twitter will add a twitter icon.", "vc_separator_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => esc_attr__( 'URL (Optional link for the title/icon)', 'vc_separator_cq' ),
                'param_name' => 'link',
                'description' => esc_attr__( '', 'vc_separator_cq' )
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_separator_cq",
                "heading" => esc_attr__("Display how many icons:", "vc_separator_cq"),
                "param_name" => "iconnum",
                "value" => array("1", "2", "3", "4", "5"),
                "dependency" => Array('element' => "titleas", 'value' => array('icon')),
                "description" => esc_attr__("", "vc_separator_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_separator_cq",
                "heading" => esc_attr__("Shape of the text:", "vc_separator_cq"),
                "param_name" => "titleshape1",
                "value" => array(esc_attr__("rounded (border-radius 4px)", "vc_separator_cq") => "rounded", esc_attr__("square (border-radius 0)", "vc_separator_cq") => "square"),
                "dependency" => Array('element' => "titleas", 'value' => array('text')),
                "description" => esc_attr__("", "vc_separator_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_separator_cq",
                "heading" => esc_attr__("Shape of the icon:", "vc_separator_cq"),
                "param_name" => "titleshape2",
                "value" => array(esc_attr__("circle (border-radius 50%)", "vc_separator_cq") => "circle", esc_attr__("rounded (border-radius 4px)", "vc_separator_cq") => "rounded", esc_attr__("square (border-radius 0)", "vc_separator_cq") => "square"),
                "dependency" => Array('element' => "titleas", 'value' => array('icon')),
                "description" => esc_attr__("", "vc_separator_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Background color", 'vc_separator_cq'),
                "param_name" => "bgcolor",
                "value" => '#333',
                "description" => esc_attr__("", 'vc_separator_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Font color", 'vc_separator_cq'),
                "param_name" => "fontcolor",
                "value" => '#fff',
                "description" => esc_attr__("", 'vc_separator_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "#333",
                "heading" => esc_attr__("Border color", 'vc_separator_cq'),
                "param_name" => "bordercolor",
                "value" => '#333333',
                "description" => esc_attr__("Default is dark gray (#333333).", 'vc_separator_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Border color for the center element", 'vc_separator_cq'),
                "param_name" => "centerbordercolor",
                "value" => '',
                "description" => esc_attr__("", 'vc_separator_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_separator_cq",
                "heading" => esc_attr__("Border style", "vc_separator_cq"),
                "param_name" => "borderstyle",
                "value" => array("solid", "dashed", "dotted", "gradient-color"),
                "description" => esc_attr__("", "vc_separator_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Left color for the gradient-color", 'vc_separator_cq'),
                "param_name" => "leftcolor",
                "value" => '#4ac1ff',
                "dependency" => Array('element' => "borderstyle", 'value' => array('gradient-color')),
                "description" => esc_attr__("", 'vc_separator_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Center color for the gradient-color", 'vc_separator_cq'),
                "param_name" => "centercolor",
                "value" => '#663399',
                "dependency" => Array('element' => "borderstyle", 'value' => array('gradient-color')),
                "description" => esc_attr__("", 'vc_separator_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Right color for the gradient-color", 'vc_separator_cq'),
                "param_name" => "rightcolor",
                "value" => '#795bb0',
                "dependency" => Array('element' => "borderstyle", 'value' => array('gradient-color')),
                "description" => esc_attr__("", 'vc_separator_cq')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_separator_cq",
                "heading" => esc_attr__("Element width", "vc_separator_cq"),
                "param_name" => "elementwidth",
                "value" => array("100%", "90%", "80%", "70%", "60%", "50%", "40%"),
                "description" => esc_attr__("", "vc_separator_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Position (CSS left here) of the text/icon:", "vc_separator_cq"),
                "param_name" => "titleposition",
                "value" => "50%",
                "description" => esc_attr__("Default is 50%, stand for center. 0 stand for left, 80% stand for right.", "vc_separator_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Width for the text/icon:", "vc_separator_cq"),
                "param_name" => "titlewidth",
                "value" => "",
                "description" => esc_attr__("", "vc_separator_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Border size", "vc_separator_cq"),
                "param_name" => "bordersize",
                "value" => "1px",
                "description" => esc_attr__("", "vc_separator_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Text/icon font size:", "vc_separator_cq"),
                "param_name" => "fontsize",
                "value" => "1em",
                "description" => esc_attr__("", "vc_separator_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("font-family for the text", "vc_separator_cq"),
                "param_name" => "fontfamily",
                "value" => "",
                "dependency" => Array('element' => "titleas", 'value' => array('text')),
                "description" => esc_attr__("You can specify the CSS font-family for the text here.", "vc_separator_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Border radius", "vc_separator_cq"),
                "param_name" => "customborderradius",
                "value" => "",
                "description" => esc_attr__("You can select the shape above or specify the border-radius for the text/icon background here.", "vc_separator_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS margin for this separator", "vc_separator_cq"),
                "param_name" => "margin",
                "value" => "",
                "description" => esc_attr__("Default is margin: 4em auto.", "vc_separator_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("CSS padding for the text/icon", "vc_separator_cq"),
                "param_name" => "padding",
                "value" => "",
                "description" => esc_attr__("Default is 0.4em 0.6em for rounded and square.", "vc_separator_cq")
              )
           )
        ));


        }

        add_shortcode('cq_vc_separator', array($this,'cq_vc_separator_func'));
      }

      function cq_vc_separator_func($atts, $content=null, $tag) {
          $icon = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_material = '';
          extract(shortcode_atts(array(
            "icon_fontawesome" => 'fa fa-adjust',
            "icon_openiconic" => 'vc-oi vc-oi-dial',
            "icon_typicons" => 'typcn typcn-adjust-brightness',
            "icon_entypo" => 'entypo-icon entypo-icon-note',
            "icon_linecons" => 'vc_li vc_li-heart',
            "icon_material" => 'vc-material vc-material-cake',
            "titleas" => 'text',
            "title" => 'Title',
            "link" => '',
            "icon" => 'fontawesome',
            "iconnum" => '1',
            "bgcolor" => '#333',
            "fontcolor" => '#FFF',
            "bordercolor" => '#333',
            "centerbordercolor" => '',
            "borderstyle" => 'solid',
            "titleposition" => '50%',
            "titlewidth" => '',
            "titleshape1" => 'rounded',
            "titleshape2" => 'rounded',
            "leftcolor" => '',
            "centercolor" => '',
            "rightcolor" => '',
            "bordersize" => '1px',
            "fontsize" => '1em',
            "padding" => '',
            "margin" => '',
            "fontfamily" => '',
            "customborderradius" => '',
            "elementwidth" => '100%',
          ), $atts));

          $i = -1;
          $output = '';
          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_icon_element_fonts_enqueue($icon);
          }else{
            wp_register_style( 'font-awesome', plugins_url('../faanimation/css/font-awesome.min.css', __FILE__) );
            wp_enqueue_style( 'font-awesome' );
          }
          wp_register_style( 'vc-extensions-separator-style', plugins_url('css/style.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-separator-style' );
          wp_register_script('vc-extensions-separator-script', plugins_url('js/init.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('vc-extensions-separator-script');
          $borderradius = '4px';
          $link = vc_build_link($link);
          $titleshape = '';
          if($titleas=="icon"){
            $titleshape = $titleshape2;
          }else{
            $titleshape = $titleshape1;
          }
          if($titleshape=="square"){
              $borderradius = '0px';
          }else if($titleshape=="rounded"){
              $borderradius = '4px';
          }else if($titleshape=="circle"){
              $borderradius = '50%';
          }
          if($customborderradius!="") $borderradius = $customborderradius;
          $output .= '<div class="cq-hr cq-hr-'.$titleshape.'" data-bgcolor="'.$bgcolor.'" data-fontcolor="'.$fontcolor.'" data-shape="'.$titleshape.'" data-borderstyle="'.$borderstyle.'" data-bordercolor="'.$bordercolor.'" data-centerbordercolor="'.$centerbordercolor.'" data-leftcolor="'.$leftcolor.'" data-centercolor="'.$centercolor.'" data-rightcolor="'.$rightcolor.'" data-elementwidth="'.$elementwidth.'" data-bordersize="'.$bordersize.'" data-fontsize="'.$fontsize.'" data-titleposition="'.$titleposition.'" data-titlewidth="'.$titlewidth.'" data-borderradius="'.$borderradius.'" data-padding="'.$padding.'" data-fontfamily="'.$fontfamily.'" data-margin="'.$margin.'">';
          $output .= '<div class="cq-hr-icon-container">';
          if($titleas=="icon"){
              if($link['url']!=""){
                $output .= '<a href="'.$link['url'].'" title="'.$link['title'].'" target="'.$link['target'].'" class="cq-hr-link">';
              }
              for ($i=0; $i < $iconnum; $i++) {
                if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
                    if(isset(${'icon_' . $icon})){
                      $output .= '<i style="" class="cq-hr-symbol '.esc_attr(${'icon_' . $icon}).'"></i>';
                    }
                  }else{
                    $output .= '<i style="" class="cq-hr-symbol fa '.$icon.'"></i>';
                  }
              }
              if($link['url']!=""){
                $output .= '</a>';
              }
          }else{
              if($link['url']!=""){
                $output .= '<a href="'.$link['url'].'" title="'.$link['title'].'" target="'.$link['target'].'">';
              }
              $output .= '<i style="" class="cq-hr-symbol">'.$title.'</i>';
              if($link['url']!=""){
                $output .= '</a>';
              }
          }
          $output .= '</div>';
          $output .= '</div>';
          return $output;

        }

  }

}

?>
