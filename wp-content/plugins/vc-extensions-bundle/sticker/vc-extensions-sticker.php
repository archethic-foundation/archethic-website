<?php
if (!class_exists('VC_Extensions_Sticker')) {
    class VC_Extensions_Sticker{
        function __construct() {
          if(version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            vc_map(array(
            "name" => __("Sticker", 'vc_sticker_cq'),
            "base" => "cq_vc_sticker",
            "class" => "wpb_cq_vc_extension_sticker",
            "icon" => "cq_allinone_sticker",
            "category" => __('Sike Extensions', 'js_composer'),
            'description' => __('With icon or image', 'js_composer'),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_sticker_cq",
                "heading" => __("Display the sticker with:", "vc_sticker_cq"),
                "param_name" => "backgroundtype",
                "value" => array("Solid background color" => "solid", "Gradient background color" => "gradient", "Image" => "image"),
                "description" => __("", "vc_sticker_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_sidebyside_cq",
                "heading" => __("Choose a built-in solid color:", "vc_sidebyside_cq"),
                "param_name" => "builtsolidcolor",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "or customized color below:" => "customized"),
                'std' => 'mediumgray',
                "dependency" => Array('element' => "backgroundtype", 'value' => array('solid')),
                "description" => __("", "vc_sidebyside_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => __("Or customized solid background color:", 'vc_sticker_cq'),
                "param_name" => "solidcolor",
                "value" => '#CCD1D9',
                "dependency" => Array('element' => "builtsolidcolor", 'value' => array('customized')),
                "description" => __("", 'vc_sticker_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => __("Main color for the gradient background:", 'vc_sticker_cq'),
                "param_name" => "gradientcolor",
                "value" => '#4A89DC',
                "dependency" => Array('element' => "backgroundtype", 'value' => array('gradient')),
                "description" => __("", 'vc_sticker_cq')
              ),
              array(
                "type" => "attach_image",
                "heading" => __("Background image:", "vc_sticker_cq"),
                "param_name" => "backgroundimage",
                "value" => "",
                "dependency" => Array('element' => "backgroundtype", 'value' => array('image')),
                "description" => __("Select image from media library.", "vc_sticker_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => __("Resize image to this width:", "vc_sticker_cq"),
                "param_name" => "imagewidth",
                "value" => "",
                "dependency" => Array('element' => "backgroundtype", 'value' => array('image')),
                "description" => __("Default we'll use the original image, you can specify a smaller width (like 240) here, then image will be resized to this width.", "vc_sticker_cq")
              ),
              array(
                'type' => 'dropdown',
                'heading' => __( 'Icon library', 'js_composer' ),
                'value' => array(
                  __( 'Font Awesome', 'js_composer' ) => 'fontawesome'
                ),
                'admin_label' => true,
                'param_name' => 'icon',
                'description' => __( 'Select icon library.', 'js_composer' ),
              ),
              array(
                'type' => 'iconpicker',
                'heading' => __( 'Icon for the sticker (optional)', 'js_composer' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => true, // default true, display an "EMPTY" icon?
                  'iconsPerPage' => 100, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'description' => __( 'Select icon from library. Default is blank.', 'js_composer' ),
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => __("Icon color:", 'vc_sticker_cq'),
                "param_name" => "fontcolor",
                "value" => '',
                "description" => __("Default is white, customize it with other color here.", 'vc_sticker_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => __("Size of the icon:", "vc_sticker_cq"),
                "param_name" => "fontsize",
                "value" => "",
                "description" => __("Default is 3em, you can specify other value here.", "vc_sticker_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => __( 'URL (Optional link for the type text)', 'vc_sticker_cq' ),
                'param_name' => 'textlink',
                'description' => __( '', 'vc_sticker_cq' )
              ),
              array(
                "type" => "textfield",
                "heading" => __("Size of the sticker:", "vc_sticker_cq"),
                "param_name" => "stickersize",
                "value" => "",
                "description" => __("Default is 120px. You can specify other value here.", "vc_sticker_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_sticker_cq",
                "heading" => __("Opacity of the shadow:", "vc_sticker_cq"),
                "param_name" => "shadowopacity",
                "value" => array("0", "0.2", "0.4", "0.6", "0.8", "1"),
                'std' => '0.8',
                "description" => __("", "vc_sticker_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => __("CSS margin of the whole element:", "vc_sticker_cq"),
                "param_name" => "elementmargin",
                "value" => "",
                "description" => __("Default is margin: 12px auto 0 auto, stand for margin top for 12px and align center. You can specify other value here.", "vc_sticker_cq")
              )

           )
        ));

          }else{
            vc_map(array(
            "name" => __("Sticker", 'vc_sticker_cq'),
            "base" => "cq_vc_sticker",
            "class" => "wpb_cq_vc_extension_sticker",
            "icon" => "cq_allinone_sticker",
            "category" => __('Sike Extensions', 'js_composer'),
            'description' => __('With icon or image', 'js_composer'),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_sticker_cq",
                "heading" => __("Display the sticker with:", "vc_sticker_cq"),
                "param_name" => "backgroundtype",
                "value" => array("Solid background color" => "solid", "Gradient background color" => "gradient", "Image" => "image"),
                "description" => __("", "vc_sticker_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_sidebyside_cq",
                "heading" => __("Choose a built-in solid color:", "vc_sidebyside_cq"),
                "param_name" => "builtsolidcolor",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray", "or customized color below:" => "customized"),
                'std' => 'mediumgray',
                "dependency" => Array('element' => "backgroundtype", 'value' => array('solid')),
                "description" => __("", "vc_sidebyside_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => __("Or customized solid background color:", 'vc_sticker_cq'),
                "param_name" => "solidcolor",
                "value" => '#CCD1D9',
                "dependency" => Array('element' => "builtsolidcolor", 'value' => array('customized')),
                "description" => __("", 'vc_sticker_cq')
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => __("Main color for the gradient background:", 'vc_sticker_cq'),
                "param_name" => "gradientcolor",
                "value" => '#4A89DC',
                "dependency" => Array('element' => "backgroundtype", 'value' => array('gradient')),
                "description" => __("", 'vc_sticker_cq')
              ),
              array(
                "type" => "attach_image",
                "heading" => __("Background image:", "vc_sticker_cq"),
                "param_name" => "backgroundimage",
                "value" => "",
                "dependency" => Array('element' => "backgroundtype", 'value' => array('image')),
                "description" => __("Select image from media library.", "vc_sticker_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => __("Resize image to this width:", "vc_sticker_cq"),
                "param_name" => "imagewidth",
                "value" => "",
                "dependency" => Array('element' => "backgroundtype", 'value' => array('image')),
                "description" => __("Default we'll use the original image, you can specify a smaller width (like 240) here, then image will be resized to this width.", "vc_sticker_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => __("Optional icon (Font Awesome) for the sticker:", "vc_sticker_cq"),
                "param_name" => "icon",
                "value" => "",
                "description" => __("Support Font Awesome icon, for example fa-twitter will insert a Twitter icon. See all the available Font Awesome icon", "vc_sticker_cq")
              ),
              array(
                "type" => "colorpicker",
                "holder" => "div",
                "class" => "",
                "heading" => __("Icon color:", 'vc_sticker_cq'),
                "param_name" => "fontcolor",
                "value" => '',
                "description" => __("Default is white, customize it with other color here.", 'vc_sticker_cq')
              ),
              array(
                "type" => "textfield",
                "heading" => __("Size of the icon:", "vc_sticker_cq"),
                "param_name" => "fontsize",
                "value" => "",
                "description" => __("Default is 3em, you can specify other value here.", "vc_sticker_cq")
              ),
              array(
                'type' => 'vc_link',
                'heading' => __( 'URL (Optional link for the type text)', 'vc_sticker_cq' ),
                'param_name' => 'textlink',
                'description' => __( '', 'vc_sticker_cq' )
              ),
              array(
                "type" => "textfield",
                "heading" => __("Size of the sticker:", "vc_sticker_cq"),
                "param_name" => "stickersize",
                "value" => "",
                "description" => __("Default is 120px. You can specify other value here.", "vc_sticker_cq")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "class" => "vc_sticker_cq",
                "heading" => __("Opacity of the shadow:", "vc_sticker_cq"),
                "param_name" => "shadowopacity",
                "value" => array("0", "0.2", "0.4", "0.6", "0.8", "1"),
                'std' => '0.8',
                "description" => __("", "vc_sticker_cq")
              ),
              array(
                "type" => "textfield",
                "heading" => __("CSS margin of the whole element:", "vc_sticker_cq"),
                "param_name" => "elementmargin",
                "value" => "",
                "description" => __("Default is margin: 12px auto 0 auto, stand for margin top for 12px and align center. You can specify other value here.", "vc_sticker_cq")
              )

           )
        ));

          }

          add_shortcode('cq_vc_sticker', array($this,'cq_vc_sticker_func'));


      }

      function cq_vc_sticker_func($atts, $content=null) {
          $icon_fontawesome = '';
          extract(shortcode_atts(array(
            "icon_fontawesome" => "",
            "builtsolidcolor" => "mediumgray",
            "solidcolor" => "#CCD1D9",
            "backgroundtype" => "solid",
            "gradientcolor" => "",
            "imagerepeat" => "no-repeat",
            "icon" => "",
            "fontcolor" => "",
            "fontsize" => "",
            "imagewidth" => "",
            "textlink" => "",
            "stickersize" => "",
            "shadowopacity" => "0.8",
            "elementmargin" => "",
            "backgroundimage" => ""
          ), $atts));

          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $output = '';

          wp_register_style( 'vc-extensions-sticker-style', plugins_url('css/style.css', __FILE__) );
          wp_enqueue_style( 'vc-extensions-sticker-style' );

          wp_register_script('sticker', plugins_url('js/sticker.min.js', __FILE__), array("jquery"));
          wp_enqueue_script('sticker');
          wp_register_script('vc-extensions-sticker-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "sticker"));
          wp_enqueue_script('vc-extensions-sticker-script');

          $textlink = vc_build_link($textlink);

          $color_style_arr = array("grapefruit" => array("#ED5565", "#DA4453"), "bittersweet" => array("#FC6E51", "#E9573F"), "sunflower" => array("#FFCE54", "#F6BB42"), "grass" => array("#A0D468", "#8CC152"), "mint" => array("#48CFAD", "#37BC9B"), "aqua" => array("#4FC1E9", "#3BAFDA"), "bluejeans" => array("#5D9CEC", "#4A89DC"), "lavender" => array("#AC92EC", "#967ADC"), "pinkrose" => array("#EC87C0", "#D770AD"), "lightgray" => array("#F5F7FA", "#E6E9ED"), "mediumgray" => array("#CCD1D9", "#AAB2BD"), "darkgray" => array("#656D78", "#434A54"), "customized" => array("$solidcolor", "$solidcolor") );

          $solidcolor_arr = $color_style_arr[$builtsolidcolor];
          $backgroundimage = wp_get_attachment_image_src($backgroundimage, 'full');
          $output = '';
          if($textlink["url"]!=="") $output .= '<a href="'.$textlink["url"].'" title="'.$textlink["title"].'" target="'.$textlink["target"].'" class="cq-sticker-link">';
          if($icon==""&&version_compare(WPB_VC_VERSION,  "4.4")>= 0){
            $icon = "fontawesome";
          }

          if(isset(${'icon_' . $icon})){
              $output .= '<div class="cq-sticker" data-backgroundtype="'.$backgroundtype.'" data-backgroundcolor="'.$solidcolor_arr[1].'" data-gradientcolor="'.$gradientcolor.'" data-image="'.$backgroundimage[0].'" data-icon="'.esc_attr(${'icon_' . $icon}).'" data-size="'.$stickersize.'" data-fontsize="'.$fontsize.'" data-fontcolor="'.$fontcolor.'" data-elementmargin="'.$elementmargin.'" data-shadowopacity="'.$shadowopacity.'">';
          }else{
              $output .= '<div class="cq-sticker" data-backgroundtype="'.$backgroundtype.'" data-backgroundcolor="'.$solidcolor_arr[1].'" data-gradientcolor="'.$gradientcolor.'" data-image="'.$backgroundimage[0].'" data-icon="'.$icon.'" data-size="'.$stickersize.'" data-fontsize="'.$fontsize.'" data-fontcolor="'.$fontcolor.'" data-elementmargin="'.$elementmargin.'" data-shadowopacity="'.$shadowopacity.'">';
          }
          $output .= '</div>';
          if($textlink["url"]!=="") $output .= '</a>';
          return $output;

        }

  }

}

?>
