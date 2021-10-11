<?php
if (!class_exists('VC_Extensions_ProfileCardV2')){
    class VC_Extensions_ProfileCardV2{
        private $button_str = "";
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Profile Card V2", 'cq_allinone_vc'),
            "base" => "cq_vc_profilecardv2",
            "class" => "cq_vc_profilecardv2",
            "icon" => "cq_vc_profilecardv2",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            "as_parent" => array('only' => 'cq_vc_profilecardv2_item'),
            "js_view" => 'VcColumnView',
            "show_settings_on_create" => true,
            'description' => esc_attr__('Animate card with buttons', 'js_composer'),
            "params" => array(
              array(
                "type" => "attach_image",
                "heading" => esc_attr__("Header image", "cq_allinone_vc"),
                "param_name" => "image",
                "value" => "",
                "group" => "Header Image",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Resize image to this width?", "cq_allinone_vc"),
                "group" => "Header Image",
                "param_name" => "imagewidth",
                "value" => "",
                "description" => esc_attr__("Default we will use the original image, specify a width. For example, 200 will resize the image to width 200. ", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Header height", "cq_allinone_vc"),
                "group" => "Header Image",
                "param_name" => "headerheight",
                "value" => "",
                "description" => esc_attr__("Default is 240 (in pixel), you can specify other value here. ", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Title", "cq_allinone_vc"),
                "param_name" => "title",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("The title, can be a name or anything else.", "cq_allinone_vc")
              ),
              array(
                "type" => "textarea",
                "heading" => esc_attr__("More description under the title", "cq_allinone_vc"),
                "param_name" => "carddesc",
                "value" => "",
                "group" => "Text",
                "description" => esc_attr__("You can put more description about current card.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("width of the card content", "cq_allinone_vc"),
                "param_name" => "elementwidth",
                "value" => "",
                "description" => esc_attr__("Default is 100%, you can specify other value like 80% etc here.", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "cq_allinone_vc",
                "heading" => esc_attr__("Auto delay animation", "cq_allinone_vc"),
                "param_name" => "autodelay",
                'value' => array(2, 3, 4, 5, 7, 10, esc_attr__( 'Disable', 'cq_allinone_vc' ) => 0 ),
                'std' => 0,
                "description" => esc_attr__("Auto animate the image in each X seconds.", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "holder" => "",
                 "heading" => esc_attr__("Hover transition", "cq_allinone_vc"),
                 "param_name" => "transition",
                 "value" => array("left to right" => "transition1", "right to left" => "transition2"),
                'std' => 'transition1',
                "description" => esc_attr__("Select the animation transition style.", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "holder" => "",
                "heading" => esc_attr__("Trigger when user", "cq_allinone_vc"),
                "param_name" => "trigger",
                "value" => array("click" => "click", "mouse over" => "mouseover"),
                'std' => 'click',
                "description" => esc_attr__("Select how to display the buttons.", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "heading" => esc_attr__("Container shape", "cq_allinone_vc"),
                 "param_name" => "containershape",
                 "value" => array('Rounded' => 'rounded', 'Square' => 'square', 'Round' => 'round'),
                 'std' => 'square',
                 "description" => esc_attr__("Select the built in shape for the container.", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("max width of the button", "cq_allinone_vc"),
                "param_name" => "maxbutton",
                "value" => "",
                "description" => esc_attr__("The max width of the button, default is 160 (in pixel).", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("Minimal height of the element", "cq_allinone_vc"),
                "param_name" => "minheight",
                "value" => "",
                "description" => esc_attr__("The minimal height of whole element, default is 270 (in pixel).", "cq_allinone_vc")
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
             "name" => esc_attr__("Button","cq_allinone_vc"),
             "base" => "cq_vc_profilecardv2_item",
             "class" => "cq_vc_profilecardv2_item",
             "icon" => "cq_vc_profilecardv2_item",
             "category" => esc_attr__('Sike Extensions', 'js_composer'),
             "description" => esc_attr__("Add icon and text","cq_allinone_vc"),
             "as_child" => array('only' => 'cq_vc_profilecardv2'),
             "show_settings_on_create" => true,
             "content_element" => true,
             "params" => array(
                array(
                  "type" => "textfield",
                  "heading" => esc_attr__("Button text", "cq_allinone_vc"),
                  "param_name" => "buttontext",
                  "value" => "",
                  'group' => 'Button',
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                  "type" => "checkbox",
                  "holder" => "",
                  "heading" => esc_attr__("Add icon", "cq_allinone_vc"),
                  "param_name" => "addicon",
                  "value" => "",
                  'group' => 'Button',
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
                    esc_attr__( 'Material', 'js_composer' ) => 'material',
                    esc_attr__( 'Linecons', 'js_composer' ) => 'linecons',
                  ),
                  'admin_label' => true,
                  'param_name' => 'buttonicon',
                  "group" => "Button",
                  'dependency' => array(
                    'element' => 'addicon',
                    'value' => 'true',
                  ),
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
                    'element' => 'buttonicon',
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
                    'emptyIcon' => false, // default true, display an "EMPTY" icon?
                    'type' => 'openiconic',
                    'iconsPerPage' => 100, // default 100, how many icons per/page to display
                  ),
                  'dependency' => array(
                    'element' => 'buttonicon',
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
                    'emptyIcon' => false, // default true, display an "EMPTY" icon?
                    'type' => 'typicons',
                    'iconsPerPage' => 100, // default 100, how many icons per/page to display
                  ),
                  'dependency' => array(
                    'element' => 'buttonicon',
                    'value' => 'typicons',
                  ),
                  "group" => "Button",
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
                  "group" => "Button",
                  'dependency' => array(
                    'element' => 'buttonicon',
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
                    'element' => 'buttonicon',
                    'value' => 'linecons',
                  ),
                  "group" => "Button",
                  'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
                ),
                array(
                  'type' => 'iconpicker',
                  'heading' => esc_attr__( 'Icon', 'js_composer' ),
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
                    'element' => 'buttonicon',
                    'value' => 'material',
                  ),
                  "group" => "Button",
                  'description' => esc_attr__( 'Select icon from library.', 'js_composer' ),
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
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                   "type" => "dropdown",
                   "edit_field_class" => "vc_col-xs-6 vc_column",
                   "holder" => "",
                   "heading" => esc_attr__("Size", "cq_allinone_vc"),
                   "param_name" => "buttonsize",
                   "value" => array('Mini' => 'xs', 'Small' => 'sm',),
                  'std' => 'xs',
                  'group' => 'Button',
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
                  "description" => esc_attr__("", "cq_allinone_vc")
                ),
                array(
                  "type" => "vc_link",
                  "edit_field_class" => "vc_col-xs-6 vc_column",
                  "heading" => esc_attr__("URL (Optional link for the button)", "cq_allinone_vc"),
                  "param_name" => "buttonlink",
                  "value" => "",
                  'group' => 'Button',
                  "description" => esc_attr__("", "cq_allinone_vc")
                )

              ),
            )
        );

          add_shortcode('cq_vc_profilecardv2', array($this,'cq_vc_profilecardv2_func'));
          add_shortcode('cq_vc_profilecardv2_item', array($this,'cq_vc_profilecardv2_item_func'));

      }

      function cq_vc_profilecardv2_func($atts, $content=null) {
        $css_class = $css = $title = $image = $imagewidth = $headerheight = $isright = $transition = $containershape = $bgcolor = $minheight = $extraclass = $trigger = $autodelay = $maxbutton = $carddesc = $elementwidth = '';

        $this -> button_str = '';

        extract(shortcode_atts(array(
          "title" => "",
          "carddesc" => "",
          "image" => "",
          "imagewidth" => "",
          "headerheight" => "",
          "trigger" => "click",
          "autodelay" => "0",
          "containershape" => "square",
          "isright" => "",
          "transition" => "transition1",
          "bgcolor" => "",
          "minheight" => "",
          "maxbutton" => "",
          "elementwidth" => "",
          "css" => "",
          "extraclass" => ""
        ),$atts));

        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ''), 'cq_vc_profilecardv2', $atts);
        wp_register_style( 'vc-extensions-profilecardv2-style', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style( 'vc-extensions-profilecardv2-style' );

        wp_register_script('vc-extensions-profilecardv2-script', plugins_url('js/init.min.js', __FILE__), array("jquery"));
        wp_enqueue_script('vc-extensions-profilecardv2-script');

        $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content


        $header_attachment = get_post($image);
        $headerimagearr = wp_get_attachment_image_src(trim($image), 'full');
        $header_image_temp = $header_image_url = "";
        $header_orgi_image = $headerimagearr[0];
        $header_image_url = $header_orgi_image;
        if( $imagewidth!="" ){
            if(function_exists('wpb_resize')){
                $header_image_temp = wpb_resize($image, null, $imagewidth, null);
                $header_image_url = $header_image_temp['url'];
                if($header_image_url=="") $header_image_url = $header_orgi_image;
            }
        }


        $output = '';
        $output .= '<div class="cq-profilecardv2 cq-profilecardv2-shape-'.$containershape.'  cq-profilecardv2-'.$transition.' '.$extraclass.' '.$css_class.'" data-bgcolor="'.$bgcolor.'" data-autodelay="'.$autodelay.'" data-minheight="'.$minheight.'" data-maxbutton="'.$maxbutton.'" data-trigger="'.$trigger.'">';
        $output .= '<div class="cq-profilecardv2-container">';
        $output .= '<div class="cq-profilecardv2-panel">';
        $output .= do_shortcode($this -> button_str);
        $output .= '</div>';
        $output .= '<div class="cq-profilecardv2-content" style="width:'.$elementwidth.'">';
        if(intval($headerheight)>0){
            $output .= '<div class="cq-profilecardv2-image" style="background:url('.$header_image_url.') center center no-repeat;background-size:cover;height:'.intval($headerheight).'px;"></div>';
        }else{
            $output .= '<div class="cq-profilecardv2-image" style="background:url('.$header_image_url.') center center no-repeat;background-size:cover;"></div>';
        }
        if($title!=""){
            $output .= '<div class="cq-profilecardv2-name">';
            $output .= '<h4 class="cq-profilecardv2-title">'.$title.'</h4 class="cq-profilecardv2-title">';
            $output .= '</div>';
        }
        if($carddesc!=""){
            $output .= '<p class="cq-profilecardv2-description">';
            $output .= $carddesc;
            $output .= '</p>';
        }
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
        return $output;

      }


      function cq_vc_profilecardv2_item_func($atts, $content=null, $tag) {
          $buttoncolor = $buttontext = $buttonshape = $buttonsize = $buttonlink = $addicon = "";
           $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_pixelicons = $icon_material = '';
          $buttonicon = "entypo";
          $buttonstyle = "modern";

          extract(shortcode_atts(array(
            "buttontext" => "",
            "buttoncolor" => "blue",
            "buttonsize" => "xs",
            "buttonshape" => "rounded",
            "buttonstyle" => "modern",
            "buttonlink" => "",
            "addicon" => "",
            "buttonicon" => "entypo",
            "icon_fontawesome" => "fa fa-user",
            "icon_openiconic" => "vc-oi vc-oi-dial",
            "icon_typicons" => "typcn typcn-adjust-brightness",
            "icon_entypo" => "entypo-icon entypo-icon-user",
            "icon_linecons" => "vc_li vc_li-heart",
            "icon_material" => "vc-material vc-material-arrow_forward",
            "css" => ""
          ), $atts));

          $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

          vc_icon_element_fonts_enqueue($buttonicon);

          $button_str = $this -> button_str;

          $output = '';
          if($buttontext!=""||$addicon=="true"){
              $button_str .= '[vc_btn title="'.$buttontext.'" color="'.$buttoncolor.'" style="'.$buttonstyle.'" shape="'.$buttonshape.'" link="'.$buttonlink.'" size="'.$buttonsize.'" i_type="'.$buttonicon.'" i_icon_'.$buttonicon.'="'.esc_attr(${'icon_' . $buttonicon}).'" add_icon="'.$addicon.'" ]';
          }

          $this -> button_str = $button_str;

          return $output;

        }

  }
}
//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) && !class_exists('WPBakeryShortCode_cq_vc_profilecardv2')) {
    class WPBakeryShortCode_cq_vc_profilecardv2 extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) && !class_exists('WPBakeryShortCode_cq_vc_profilecardv2_item')) {
    class WPBakeryShortCode_cq_vc_profilecardv2_item extends WPBakeryShortCode {
    }
}

?>
