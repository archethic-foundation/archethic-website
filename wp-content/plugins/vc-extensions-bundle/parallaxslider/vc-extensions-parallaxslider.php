<?php
if (!class_exists('VC_Extensions_ParallaxSlider')){
    class VC_Extensions_ParallaxSlider{
        private $item_height = "";
        private $text_color = "";
        private $caption_bg = "";
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Parallax Slider", 'cq_allinone_vc'),
            "base" => "cq_vc_parallaxslider",
            "class" => "cq_vc_parallaxslider",
            "icon" => "cq_vc_parallaxslider",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            "as_parent" => array('only' => 'cq_vc_parallaxslider_item'),
            "js_view" => 'VcColumnView',
            "show_settings_on_create" => true,
            'description' => esc_attr__('Slidehshow w/ loading animation', 'js_composer'),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "heading" => esc_attr__("Caption position:", "cq_allinone_vc"),
                "param_name" => "captionposition",
                "value" => array("top" => "top", "bottom" => "bottom", "none" => "none"),
                "std" => "bottom",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                 "type" => "dropdown",
                 "holder" => "",
                 "edit_field_class" => "vc_col-xs-6 vc_column",
                 "heading" => esc_attr__("Auto delay slideshow", "cq_allinone_vc"),
                 "param_name" => "autoslide",
                 "value" => array("no", "2", "3", "4", "5", "6", "7", "8"),
                 "std" => "no",
                 "description" => esc_attr__("In seconds, default is no, which is disabled.", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => esc_attr__("Arrow button position", "cq_allinone_vc"),
                "param_name" => "buttonposition",
                "value" => array("Left" => "left", "Right" => "right", "None (do not display the arrow buttons)" => "none"),
                "std" => "right",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => esc_attr__("Arrow button shape", "cq_allinone_vc"),
                "param_name" => "buttonshape",
                "dependency" => Array("element" => "buttonposition", "value" => array("left", "right")),
                "value" => array("Rounded" => "rounded", "Square" => "square", "Round" => "round"),
                "std" => "square",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_column vc_col-xs-6",
                "heading" => esc_attr__("Arrow color:", "cq_allinone_vc"),
                "param_name" => "arrowcolor",
                "value" => "",
                "dependency" => Array("element" => "buttonposition", "value" => array("left", "right")),
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_column vc_col-xs-6",
                "heading" => esc_attr__("Arrow hover color:", "cq_allinone_vc"),
                "param_name" => "arrowhovercolor",
                "value" => "",
                "dependency" => Array("element" => "buttonposition", "value" => array("left", "right")),
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_column vc_col-xs-6",
                "heading" => esc_attr__("Arrow button background color:", "cq_allinone_vc"),
                "param_name" => "arrowbg",
                "value" => "",
                "dependency" => Array('element' => "buttonposition", 'value' => array('left', 'right')),
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_column vc_col-xs-6",
                "heading" => esc_attr__("Arrow hover background color:", "cq_allinone_vc"),
                "param_name" => "arrowhoverbg",
                "value" => "",
                "dependency" => Array('element' => "buttonposition", 'value' => array('left', 'right')),
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => esc_attr__("Active dot color", "cq_allinone_vc"),
                "param_name" => "activestyle",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray"),
                "std" => "grass",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_column vc_col-xs-6",
                "heading" => esc_attr__("Caption text color:", 'cq_allinone_vc'),
                "param_name" => "textcolor",
                "value" => "",
                "description" => esc_attr__("Default is white.", 'cq_allinone_vc')
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_column vc_col-xs-6",
                "heading" => esc_attr__("Caption background color:", 'cq_allinone_vc'),
                "param_name" => "captionbg",
                "value" => "",
                "description" => esc_attr__("Default is gray with transparent.", 'cq_allinone_vc')
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => esc_attr__("Default dot border color", "cq_allinone_vc"),
                "param_name" => "borderstyle",
                "value" => array("Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray"),
                "std" => "mediumgray",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "checkbox",
                "heading" => esc_attr__("Auto height? ", "cq_allinone_vc" ),
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "param_name" => "autoheight",
                "std" => "yes",
                "description" => esc_attr__("Check this if you want the slide to be auto height.", "cq_allinone_vc" ),
                "value" => array( esc_attr__( "Yes", "cq_allinone_vc" ) => "yes" ),
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Extra class name", "cq_allinone_vc"),
                "edit_field_class" => "vc_col-xs-6 vc_column",
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
             "name" => esc_attr__("Slide Item","cq_allinone_vc"),
             "base" => "cq_vc_parallaxslider_item",
             "class" => "cq_vc_parallaxslider_item",
             "icon" => "cq_vc_parallaxslider_item",
             "category" => esc_attr__("Sike Extensions", "js_composer"),
             "description" => esc_attr__("Add image, text","cq_allinone_vc"),
             "as_child" => array("only" => "cq_vc_parallaxslider"),
             "show_settings_on_create" => true,
             "content_element" => true,
             "params" => array(
              array(
                  "type" => "attach_image",
                  "edit_field_class" => "vc_column vc_col-xs-6",
                  "heading" => esc_attr__("Image:", "cq_allinone_vc"),
                  "param_name" => "image",
                  "value" => "",
                  "description" => esc_attr__("Select from media library.", "cq_allinone_vc")
              ),
              array(
                "type" => "checkbox",
                "edit_field_class" => "vc_column vc_col-xs-6",
                "heading" => esc_attr__( "Resize the image?", "cq_allinone_vc" ),
                "param_name" => "isresize",
                "description" => esc_attr__( "We will use the original image by default, you can specify a width below if the original image is too large.", "cq_allinone_vc" ),
                "std" => "no",
                "value" => array( esc_attr__( "Yes", "cq_allinone_vc" ) => "yes" ),
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_column vc_col-xs-6",
                "heading" => esc_attr__("Resize image to this width.", "cq_allinone_vc"),
                "param_name" => "imagesize",
                "value" => "",
                "dependency" => Array("element" => "isresize", "value" => array("yes")),
                "description" => esc_attr__("Enter image width in pixels, for example: 400. The image then will be resized to 400. Leave empty to use original full image.", "cq_allinone_vc")
              ),
              array(
                "type" => "textarea_html",
                "heading" => esc_attr__("Content", "cq_allinone_vc"),
                "param_name" => "content",
                "value" => "",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "textfield",
                "edit_field_class" => "vc_column vc_col-xs-6",
                "heading" => esc_attr__("Tooltip for the dot navigation (optional)", "cq_allinone_vc"),
                "param_name" => "tooltip",
                "value" => "",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "vc_link",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "heading" => esc_attr__("URL (Optional link for the image)", "cq_allinone_vc"),
                "param_name" => "imagelink",
                "value" => "",
                "description" => esc_attr__("", "cq_allinone_vc")
              )


              ),
            )
        );

          add_shortcode('cq_vc_parallaxslider', array($this,'cq_vc_parallaxslider_func'));
          add_shortcode('cq_vc_parallaxslider_item', array($this,'cq_vc_parallaxslider_item_func'));

      }

      function cq_vc_parallaxslider_func($atts, $content=null) {
        $css_class = $css = $autoslide = $autoheight = $buttonshape = $dotsize = $activestyle = $borderstyle = $backgroundcolor = $captionposition = $buttonposition = $textcolor = $extraclass = '';
        extract(shortcode_atts(array(
          "buttonshape" => "sqaure",
          "dotsize" => "16",
          "autoslide" => "no",
          "autoheight" => "yes",
          "activestyle" => "grass",
          "borderstyle" => "mediumgray",
          "captionposition" => "bottom",
          "textcolor" => "",
          "arrowcolor" => "",
          "arrowhovercolor" => "",
          "arrowhoverbg" => "",
          "arrowbg" => "",
          "captionbg" => "",
          "backgroundcolor" => "",
          "buttonposition" => "right",
          "css" => "",
          "extraclass" => ""
        ),$atts));

        $this -> text_color = $textcolor;
        $this -> caption_bg = $captionbg;

        $output = "";
        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ''), 'cq_vc_parallaxslider', $atts);

        wp_register_style('tooltipster', plugins_url('../appmockup/css/tooltipster.css', __FILE__));
        wp_enqueue_style('tooltipster');

        wp_register_style('swiper', plugins_url('../cardslider/css/swiper.css', __FILE__));
        wp_enqueue_style('swiper');

        wp_register_script('tooltipster', plugins_url('../appmockup/js/jquery.tooltipster.min.js', __FILE__), array('jquery'));
        wp_enqueue_script('tooltipster');
        wp_register_script('swiper', plugins_url('../cardslider/js/swiper.min.js', __FILE__), array('jquery'));
        wp_enqueue_script('swiper');

        wp_register_style( 'vc-extensions-parallaxslider-style', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style( 'vc-extensions-parallaxslider-style' );


        wp_register_script('vc-extensions-parallaxslider-script', plugins_url('js/init.min.js', __FILE__), array("jquery", "tooltipster"));
        wp_enqueue_script('vc-extensions-parallaxslider-script');

        $output .= '<div class="cq-parallaxslider cq-parallaxslider-shape-'.$buttonshape.'  cq-parallaxslider-captionposition-'.$captionposition.' cq-parallaxslider-buttonposition-'.$buttonposition.' cq-parallaxslider-active-'.$activestyle.' cq-parallaxslider-border-'.$borderstyle.' cq-parallaxslider-dotsize-'.$dotsize.' '.$extraclass.' '.$css_class.'" data-autoslide="'.$autoslide.'" data-autoheight="'.$autoheight.'" style="background-color:'.$backgroundcolor.'" data-arrowhovercolor="'.$arrowhovercolor.'" data-arrowcolor="'.$arrowcolor.'" data-arrowbg="'.$arrowbg.'" data-arrowhoverbg="'.$arrowhoverbg.'">';
        $output .= '<div class="swiper-wrapper">';
        $output .= do_shortcode($content);
        $output .= '</div>';

        $output .= '<div class="cq-parallaxslider-nav"></div>';

        $output .= '<div class="cq-parallaxslider-arrows">';
        $output .= '<div class="swiper-button-prev cq-parallaxslider-button" style="color:'.$arrowcolor.';background-color:'.$arrowbg.'"></div>
                    <div class="swiper-button-next cq-parallaxslider-button" style="color:'.$arrowcolor.';background-color:'.$arrowbg.'"></div>';
        $output .= '</div>';

        $output .= '</div>';
        return $output;

      }


      function cq_vc_parallaxslider_item_func($atts, $content=null, $tag) {
          $output = $faceicon = $image = $imagesize = $imagelink = $videowidth = $isresize = $tooltip =  $backgroundcolor = $backgroundhovercolor = $itembgcolor =  $iconsize =  $css = $bgstyle =  $buttoncolor = $buttontext = $buttonshape = $buttonsize = "";
          $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypo = $icon_linecons = $icon_pixelicons = $icon_material = $icon_monosocial = "";
            extract(shortcode_atts(array(
              "faceicon" => "entypo",
              "image" => "",
              "imagesize" => "",
              "imagelink" => "",
              "isresize" => "no",
              "iscaption" => "",
              "tooltip" => "",
              "bgstyle" => "aqua",
              "backgroundcolor" => "",
              "backgroundhovercolor" => "",
              "itembgcolor" => "",
              "avataricon" => "entypo",
              "icon_fontawesome" => "fa fa-user",
              "icon_openiconic" => "vc-oi vc-oi-dial",
              "icon_typicons" => "typcn typcn-adjust-brightness",
              "icon_entypo" => "entypo-icon entypo-icon-user",
              "icon_linecons" => "vc_li vc_li-heart",
              "icon_material" => "vc-material vc-material-cake",
              "icon_pixelicons" => "",
              "icon_monosocial" => "",
              "iconsize" => "",
              "buttontext" => "",
              "buttoncolor" => "blue",
              "buttonsize" => "xs",
              "buttonshape" => "rounded",
              "buttonstyle" => "modern",
              "css" => ""
            ), $atts));

          vc_icon_element_fonts_enqueue($faceicon);
          $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

          $img = $thumbnail = "";

          vc_icon_element_fonts_enqueue($avataricon);

          $fullimage = wp_get_attachment_image_src($image, 'full');
          $thumbnail = $fullimage[0];
          if($isresize=="yes"&&$imagesize!=""){
              if(function_exists('wpb_resize')){
                  $img = wpb_resize($image, null, $imagesize, null);
                  $thumbnail = $img['url'];
                  if($thumbnail=="") $thumbnail = $fullimage[0];
              }
          }


          $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content
          $image_str = '';
          $text_str = '';

          $imagelink = vc_build_link($imagelink);
          $output = '';

          if($imagelink["url"]!=""){
              $image_str .= '<a href="'.$imagelink["url"].'" title="'.$imagelink["title"].'" target="'.$imagelink["target"].'" rel="'.$imagelink["rel"].'" class="cq-parallaxslider-imagelink">';
          }


          if(intval($this -> item_height) > 0){
            $image_str .= '<div class="cq-parallaxslider-imgcontainer" style="height:'.intval($this -> item_height).'px" title="'.$tooltip.'">';
          }else{
            $image_str .= '<div class="cq-parallaxslider-imgcontainer" title="'.$tooltip.'">';
          }


          $image_str .= '<div class="cq-parallaxslider-image" style="background-image:url('.$thumbnail.'); ">';

          $image_str .= '<img class="cq-parallaxslider-imageitem" src="'.$thumbnail.'">';

          $image_str .= '</div>';


          $image_str .= '</div>';
          if($imagelink["url"]!="") $image_str .= '</a>';


          $text_str .= '<div class="cq-parallaxslider-content">';
          if($content != ""){
              $text_str .= '<div class="cq-parallaxslider-text" style="color:'.$this -> text_color.';background-color:'.$this -> caption_bg.';">';
              $text_str .= do_shortcode($content);
              $text_str .= '</div>';
          }
          $text_str .= '</div>';

          $output .= '<div class="cq-parallaxslider-item swiper-slide">';

          $output .= $image_str . $text_str;
          $output .= '</div>';
          return $output;

        }

  }
}
//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) && !class_exists('WPBakeryShortCode_cq_vc_parallaxslider')) {
    class WPBakeryShortCode_cq_vc_parallaxslider extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) && !class_exists('WPBakeryShortCode_cq_vc_parallaxslider_item')) {
    class WPBakeryShortCode_cq_vc_parallaxslider_item extends WPBakeryShortCode {
    }
}

?>
