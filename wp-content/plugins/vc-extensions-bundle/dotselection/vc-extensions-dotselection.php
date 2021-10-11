<?php
if (!class_exists('VC_Extensions_DotSelection')){
    class VC_Extensions_DotSelection{
        private $image_position = "left";
        private $date_fontsize = "";
        private $item_height = "";
        function __construct() {
            vc_map(array(
            "name" => esc_attr__("Dot Selection", 'cq_allinone_vc'),
            "base" => "cq_vc_dotselection",
            "class" => "cq_vc_dotselection",
            "icon" => "cq_vc_dotselection",
            "category" => esc_attr__('Sike Extensions', 'js_composer'),
            "as_parent" => array('only' => 'cq_vc_dotselection_item'),
            "js_view" => 'VcColumnView',
            "show_settings_on_create" => true,
            'description' => esc_attr__('Color dot with slide', 'js_composer'),
            "params" => array(
              array(
                "type" => "dropdown",
                "holder" => "",
                "heading" => esc_attr__("Dot border type:", "cq_allinone_vc"),
                "param_name" => "bordertype",
                "value" => array("none" => "none", "solid" => "solid", "dotted" => "dotted", "dashed" => "dashed"),
                "std" => "dashed",
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
                 "heading" => esc_attr__("Transition style", "cq_allinone_vc"),
                 "param_name" => "transition",
                 "value" => array("Slide" => "slide", "Fade" => "fade", "Flip" => "flip", "Coverflow" => "coverflow", "Cube" => "cube"),
                 "std" => "slide",
                 "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => esc_attr__("Element shape", "cq_allinone_vc"),
                "param_name" => "shape",
                "value" => array('Rounded' => 'rounded', 'Square' => 'square', 'Round' => 'round'),
                'std' => 'rounded',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => esc_attr__("Dot shape", "cq_allinone_vc"),
                "param_name" => "dotshape",
                "value" => array('Rounded' => 'rounded', 'Square' => 'square', 'Round' => 'round'),
                'std' => 'round',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => esc_attr__("Dot size", "cq_allinone_vc"),
                "param_name" => "dotsize",
                "value" => array('16' => '16', '24' => '24', '32' => '32', '48' => '48'),
                'std' => '24',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "dropdown",
                "holder" => "",
                "edit_field_class" => "vc_col-xs-6 vc_column",
                "class" => "",
                "heading" => esc_attr__("Active dot color", "cq_allinone_vc"),
                "param_name" => "activestyle",
                "value" => array("None" => "none", "Grape Fruit" => "grapefruit", "Bitter Sweet" => "bittersweet", "Sunflower" => "sunflower", "Grass" => "grass", "Mint" => "mint", "Aqua" => "aqua", "Blue Jeans" => "bluejeans", "Lavender" => "lavender", "Pink Rose" => "pinkrose", "Light Gray" => "lightgray", "Medium Gray" => "mediumgray", "Dark Gray" => "darkgray"),
                'std' => 'none',
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                'type' => 'checkbox',
                'heading' => esc_attr__('Auto height? ', 'cq_allinone_vc' ),
                "edit_field_class" => "vc_col-xs-6 vc_column",
                'param_name' => 'autoheight',
                'std' => 'no',
                'description' => esc_attr__("Check this if you want the slide to be auto height.", 'cq_allinone_vc' ),
                'value' => array( esc_attr__( 'Yes', 'cq_allinone_vc' ) => 'yes' ),
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
             "base" => "cq_vc_dotselection_item",
             "class" => "cq_vc_dotselection_item",
             "icon" => "cq_vc_dotselection_item",
             "category" => esc_attr__('Sike Extensions', 'js_composer'),
             "description" => esc_attr__("Add image, text and button","cq_allinone_vc"),
             "as_child" => array('only' => 'cq_vc_dotselection'),
             "show_settings_on_create" => true,
             "content_element" => true,
             "params" => array(
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Tooltip for the dot (optional)", "cq_allinone_vc"),
                "param_name" => "tooltip",
                "value" => "",
                "description" => esc_attr__("", "cq_allinone_vc")
              ),
              array(
                "type" => "colorpicker",
                "edit_field_class" => "vc_column vc_col-xs-6",
                "heading" => esc_attr__("Dot color for current slide", 'cq_allinone_vc'),
                "param_name" => "dotcolor",
                "value" => "",
                "description" => esc_attr__("", 'cq_allinone_vc')
              ),
              array(
                  "type" => "attach_image",
                  "edit_field_class" => "vc_column vc_col-xs-6",
                  "heading" => esc_attr__("Slide Image:", "cq_allinone_vc"),
                  "param_name" => "image",
                  "value" => "",
                  "description" => esc_attr__("Select from media library.", "cq_allinone_vc")
              ),
              array(
                'type' => 'checkbox',
                'heading' => esc_attr__( 'Resize the image?', 'cq_allinone_vc' ),
                'param_name' => 'isresize',
                'description' => esc_attr__( 'We will use the original image by default, you can specify a width below if the original image is too large.', 'cq_allinone_vc' ),
                'std' => 'no',
                'value' => array( esc_attr__( 'Yes', 'cq_allinone_vc' ) => 'yes' ),
              ),
              array(
                "type" => "textfield",
                "heading" => esc_attr__("Resize image to this width.", "cq_allinone_vc"),
                "param_name" => "imagesize",
                "value" => "",
                "dependency" => Array('element' => "isresize", 'value' => array('yes')),
                "description" => esc_attr__('Enter image width in pixels, for example: 400. The image then will be resized to 400. Leave empty to use original full image.', "cq_allinone_vc")
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

          add_shortcode('cq_vc_dotselection', array($this,'cq_vc_dotselection_func'));
          add_shortcode('cq_vc_dotselection_item', array($this,'cq_vc_dotselection_item_func'));

      }

      function cq_vc_dotselection_func($atts, $content=null) {
        $css_class = $css = $autoslide = $autoheight = $shape = $dotshape = $dotsize = $transition = $activestyle = $backgroundcolor = $bordertype = $extraclass = '';
        extract(shortcode_atts(array(
          "bordertype" => "dashed",
          "shape" => "rounded",
          "dotshape" => "round",
          "dotsize" => "32",
          "autoslide" => "no",
          "autoheight" => "no",
          "transition" => "slide",
          "activestyle" => "none",
          "backgroundcolor" => "",
          "css" => "",
          "extraclass" => ""
        ),$atts));


        $output = "";
        $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ''), 'cq_vc_dotselection', $atts);

        wp_register_style('tooltipster', plugins_url('../appmockup/css/tooltipster.css', __FILE__));
        wp_enqueue_style('tooltipster');

        wp_register_style('swiper', plugins_url('../cardslider/css/swiper.css', __FILE__));
        wp_enqueue_style('swiper');

        wp_register_script('tooltipster', plugins_url('../appmockup/js/jquery.tooltipster.min.js', __FILE__), array('jquery'));
        wp_enqueue_script('tooltipster');
        wp_register_script('swiper', plugins_url('../cardslider/js/swiper.min.js', __FILE__), array('jquery'));
        wp_enqueue_script('swiper');

        wp_register_style( 'vc-extensions-dotselection-style', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style( 'vc-extensions-dotselection-style' );


        wp_register_script('vc-extensions-dotselection-script', plugins_url('js/init.js', __FILE__), array("jquery", "tooltipster"));
        wp_enqueue_script('vc-extensions-dotselection-script');

        $output .= '<div class="cq-dotselection cq-dotselection-shape-'.$shape.' cq-dotselection-active-'.$activestyle.' cq-dotselection-dotsize-'.$dotsize.' cq-dotselection-dotshape-'.$dotshape.' cq-dotselection-border-'.$bordertype.' '.$extraclass.' '.$css_class.'" data-autoslide="'.$autoslide.'" data-autoheight="'.$autoheight.'" data-transition="'.$transition.'" style="background-color:'.$backgroundcolor.'">';
        $output .= '<div class="swiper-wrapper">';
        $output .= do_shortcode($content);
        $output .= '</div>';
        $output .= '<div class="cq-dotselection-nav"></div>';
        $output .= '</div>';
        return $output;

      }


      function cq_vc_dotselection_item_func($atts, $content=null, $tag) {
          $output = $faceicon = $image = $imagesize = $imagelink = $videowidth = $isresize = $tooltip =  $backgroundcolor = $backgroundhovercolor = $itembgcolor = $iconcolor = $iconsize =  $css = $bgstyle =  $dotcolor = $buttoncolor = $buttontext = $buttonshape = $buttonsize = $buttonlink = $align = "";
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
              "dotcolor" => "",
              "buttontext" => "",
              "buttoncolor" => "blue",
              "buttonsize" => "xs",
              "buttonshape" => "rounded",
              "buttonstyle" => "modern",
              "buttonlink" => "",
              "align" => "center",
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

          if($bgstyle == "customized" && $backgroundcolor != ""){
          	$arrowstyle_str = "border-bottom:15px solid $backgroundcolor";
          }
          $itembgstyle_str = '';
          if($bgstyle == "customized" && $backgroundcolor != ""){
          	$itembgstyle_str = "background-color: $backgroundcolor";
          }

          $image_str = '';
          $text_str = '';

          $imagelink = vc_build_link($imagelink);
          $output = '';
          if(intval($this -> item_height) > 0){
            $image_str .= '<div class="cq-dotselection-imgcontainer" style="height:'.intval($this -> item_height).'px">';
          }else{
            $image_str .= '<div class="cq-dotselection-imgcontainer">';
          }

          if($imagelink["url"]!=""){
              $image_str .= '<a href="'.$imagelink["url"].'" title="'.$imagelink["title"].'" target="'.$imagelink["target"].'" rel="'.$imagelink["rel"].'" class="cq-dotselection-imagelink">';
          }
          if($thumbnail != "") $image_str .= '<img src="'.$thumbnail.'" class="cq-dotselection-img" title="'.$tooltip.'" alt="">';
          if($imagelink["url"]!="") $image_str .= '</a>';
          $image_str .= '</div>';

          $output .= '<div class="cq-dotselection-item swiper-slide" data-dotcolor="'.$dotcolor.'">';
          if($this -> image_position == "left"){
            $output .= $image_str . $text_str;
          } else{
            $output .= $text_str . $image_str;
          }
          $output .= '</div>';
          return $output;

        }

  }
}
//Extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) && !class_exists('WPBakeryShortCode_cq_vc_dotselection')) {
    class WPBakeryShortCode_cq_vc_dotselection extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) && !class_exists('WPBakeryShortCode_cq_vc_dotselection_item')) {
    class WPBakeryShortCode_cq_vc_dotselection_item extends WPBakeryShortCode {
    }
}

?>
